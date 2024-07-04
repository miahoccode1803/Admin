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
        if (isset($_FILES['dataFile']) && $_FILES['dataFile']['error'] == 0 && isset($_POST['table'])) {
            $file = $_FILES['dataFile']['tmp_name'];
            $table = $_POST['table']; // Get the selected table name
            
            require './Public/Classes/PHPExcel.php';
            $objPHPExcel = PHPExcel_IOFactory::load($file);
    
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
    
            $data = [];
            for ($row = 2; $row <= $highestRow; $row++) { // Bỏ qua hàng tiêu đề
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                $data[] = $rowData[0];
            }
    
            // Thực hiện việc lưu dữ liệu vào cơ sở dữ liệu dựa trên tên bảng
            if ($this->saveToDatabase($table, $data)) {
                $message = 'Data imported successfully!';
            } else {
                $message = 'Failed to import data!';
            }
        } else {
            $message = 'File upload failed!';
        }
        header('Location: /import_export/Get_data?message=' . urlencode($message));
    }

    private function saveToDatabase($table, $data) {
        // Kết nối cơ sở dữ liệu
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "quanlydt";
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
            return false;
        }

        $success = true;

        // Lưu dữ liệu vào cơ sở dữ liệu (thực hiện các câu lệnh SQL ở đây dựa vào $table)

        // Example SQL insertion for customers table
        if ($table === 'customers') {
            foreach ($data as $row) {
                $name = $row[0]; // Assuming the structure of your data
                $email = $row[1];
                $username = $row[2];
                $password = $row[3];
                $is_active = $row[4];
                
                // Example SQL query
                $sql = "INSERT INTO customers (`name`, `email`, `username`, `password`, `is_active`) VALUES ('$name', '$email', '$username', '$password', '$is_active')";
                if (!$conn->query($sql)) {
                    $success = false;
                    break;
                }
            }
        }
        
        else if ($table === 'products') {
            foreach ($data as $row) {
                $product_id = $row[0]; // Assuming the structure of your data
                $name = $row[1];
                $company = $row[2];
                $img = $row[3];
                $price = $row[4];
                $screen = $row[5];
                $os = $row[6];
                $camera = $row[7];
                $camera_front = $row[8];
                $cpu = $row[9];
                $ram = $row[10];
                $rom = $row[11];
                $microUSB = $row[12];
                $battery = $row[13];
    
                // Example SQL query
                $sql = "INSERT INTO Products (product_id, `name`, company, img, price) 
                        VALUES ('$product_id', '$name', '$company', '$img', '$price')";
                if (!$conn->query($sql)) {
                    $success = false;
                    break;
                }
    
                // Insert into ProductDetails table
                $sql2 = "INSERT INTO ProductDetails (product_id, screen, os, camera, camera_front, cpu, ram, rom, microUSB, battery) 
                         VALUES ('$product_id', '$screen', '$os', '$camera', '$camera_front', '$cpu', '$ram', '$rom', '$microUSB', '$battery')";
                if (!$conn->query($sql2)) {
                    $success = false;
                    break;
                }
            }
        }
            else if ($table === 'orders') {
                foreach ($data as $row) {
                    $order_id = $row[0]; // Assuming the structure of your data
                    $customer_id = $row[1]; // Assuming customer_id
                    $order_date = $row[2];
                    $status = $row[3];
                    
                    // Example SQL query for orders table
                    $sql = "INSERT INTO orders (order_id, customer_id, order_date, status) 
                            VALUES ('$order_id', '$customer_id', '$order_date', '$status')";
                    if (!$conn->query($sql)) {
                        $success = false;
                        break;
                    }
                    
                    // Insert order details if available
                    if (isset($row[4])) {
                        $products = explode(',', $row[4]); // Assuming products are comma-separated
                        foreach ($products as $product) {
                            // Parse product details (e.g., product_name (quantity x price))
                            $pattern = '/^(.*?) \((.*?) x (.*?)\)$/';
                            preg_match($pattern, $product, $matches);
                            
                            if (count($matches) == 4) {
                                $product_name = trim($matches[1]);
                                $quantity = trim($matches[2]);
                                $price = trim($matches[3]);
                                
                                // Retrieve product_id from products table
                                $product_sql = "SELECT product_id FROM products WHERE name = '$product_name'";
                                $product_result = $conn->query($product_sql);
                                
                                if ($product_result->num_rows > 0) {
                                    $product_row = $product_result->fetch_assoc();
                                    $product_id = $product_row['product_id'];
                                    
                                    // Insert into orderdetails table
                                    $orderdetail_sql = "INSERT INTO orderdetails (order_id, product_id, quantity, price) 
                                                        VALUES ('$order_id', '$product_id', '$quantity', '$price')";
                                    if (!$conn->query($orderdetail_sql)) {
                                        $success = false;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
        }

        $conn->close();
        return $success;
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