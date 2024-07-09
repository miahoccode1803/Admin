<?php
class import_export extends controller {
    public function __construct() {
    }

    public function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'import_export_v'
        ]);
    }

    
    public function importData() {
        require './Public/Classes/PHPExcel.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['dataFile']['tmp_name']) && !empty($_FILES['dataFile']['tmp_name'])) {
                $file = $_FILES['dataFile']['tmp_name'];
                $table = $_POST['table'];

                $objPHPExcel = PHPExcel_IOFactory::load($file);
                $sheet = $objPHPExcel->getActiveSheet();
                $data = $sheet->toArray(null, true, true, true);

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "quanlydt";
                
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                // Giả sử hàng đầu tiên chứa tên cột
                $columns = array_shift($data);
                $columnsString = implode(", ", $columns);

                foreach ($data as $row) {
                    $values = array_map(function($value) use ($conn) {
                        return "'" . $conn->real_escape_string($value) . "'";
                    }, $row);
                    $valuesString = implode(", ", $values);

                    if ($table === 'customers') {
                        $sql = "INSERT INTO customers ($columnsString) VALUES ($valuesString)";
                    } elseif ($table === 'products') {
                        $sql = "INSERT INTO products ($columnsString) VALUES ($valuesString)";
                    } elseif ($table === 'orders') {
                        $sql = "INSERT INTO orders ($columnsString) VALUES ($valuesString)";
                    } elseif ($table === 'suppliers') {
                        $sql = "INSERT INTO suppliers ($columnsString) VALUES ($valuesString)";
                    }

                    if (!$conn->query($sql)) {
                        echo "Lỗi: " . $sql . "<br>" . $conn->error;
                    }
                }

                $conn->close();
                echo "Dữ liệu đã được import thành công!";
            } else {
                echo "Chưa chọn tệp!";
            }
        } else {
            echo "Invalid request method.";
        }
    }
    

    public function exportData($table) {
        require './Public/Classes/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $objPHPExcel->getActiveSheet();
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "quanlydt";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $title = '';
        $mergeRange = '';
        $data = [];

        if ($table === 'customers') {
            $title = 'Bảng Khách Hàng';
            $mergeRange = 'A1:E1'; // Merge từ cột A đến cột E
            $sql = "SELECT `name`, `email`, `username`, `password`, `is_active` FROM customers";
            $result = $conn->query($sql);
            $data[] = ['Name', 'Email', 'Username', 'Password', 'Is_active'];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [$row['name'], $row['email'], $row['username'], $row['password'], $row['is_active']];
                }
            }
        } elseif ($table === 'products') {
            $title = 'Bảng Sản Phẩm';
            $mergeRange = 'A1:N1'; // Merge từ cột A đến cột N
            $sql = "SELECT p.product_id, p.name, p.company, p.img, p.price, pd.screen, pd.os, pd.camera, pd.camera_front, pd.cpu, pd.ram, pd.rom, pd.microUSB, pd.battery
                    FROM Products p
                    LEFT JOIN ProductDetails pd ON p.product_id = pd.product_id";
            $result = $conn->query($sql);
            $data[] = ['ID', 'Product Name', 'Company', 'IMG', 'Price', 'Screen', 'OS', 'Camera', 'Camera_front', 'CPU', 'RAM', 'ROM', 'microUSB', 'Battery'];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [$row['product_id'], $row['name'], $row['company'], $row['img'], $row['price'], $row['screen'], $row['os'], $row['camera'], $row['camera_front'], $row['cpu'], $row['ram'], $row['rom'], $row['microUSB'], $row['battery']];
                }
            }
        } elseif ($table === 'orders') {
            $title = 'Bảng Đơn Hàng';
            $mergeRange = 'A1:F1'; // Merge từ cột A đến cột F
            $sql = "
                SELECT o.order_id, c.name as customer_name, o.order_date, o.status,
                       GROUP_CONCAT(CONCAT(p.name, ' (', od.quantity, ' x ', od.price, ')') SEPARATOR ', ') as products,
                       SUM(od.quantity * od.price) as total
                FROM orders o
                JOIN customers c ON o.customer_id = c.customer_id
                LEFT JOIN orderdetails od ON o.order_id = od.order_id
                LEFT JOIN products p ON od.product_id = p.product_id
                GROUP BY o.order_id
            ";
            $result = $conn->query($sql);
            $data[] = ['Order ID', 'Customer', 'Date', 'Status', 'Products', 'Total'];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [$row['order_id'], $row['customer_name'], $row['order_date'], $row['status'], $row['products'], $row['total']];
                }
            }
        } elseif ($table === 'suppliers') {
            $title = 'Bảng Nhà Cung Cấp';
            $mergeRange = 'A1:E1'; // Merge từ cột A đến cột E
            $sql = "SELECT `name`, `contact_name`, `contact_email`, `address`, `contact_phone` FROM suppliers";
            $result = $conn->query($sql);
            $data[] = ['Name', 'Contact Name', 'Contact Email', 'Address', 'Contact Phone'];

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = [$row['name'], $row['contact_name'], $row['contact_email'], $row['address'], $row['contact_phone']];
                }
            }
        }

        // Thêm tiêu đề bảng
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells($mergeRange);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        // Đưa dữ liệu vào bảng bắt đầu từ dòng thứ 3
        $sheet->fromArray($data, null, 'A3');

        // Định dạng tiêu đề với màu xanh lá cây
        $headerStyleArray = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
                'name' => 'Verdana',
            ],
            'fill' => [
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => ['rgb' => '00FF00']  // Màu xanh lá cây
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A3:' . $sheet->getHighestColumn() . '3')->applyFromArray($headerStyleArray);

        // Định dạng dữ liệu
        $dataStyleArray = [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('A4:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray($dataStyleArray);

        // Căn chỉnh văn bản và điều chỉnh kích thước cột tự động
        foreach (range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getStyle($col . '4:' . $col . $sheet->getHighestRow())->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $table . '.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}

?>