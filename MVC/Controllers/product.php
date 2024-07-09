<?php
class product extends controller {
    private $lst_product;

    public function __construct() {
        $this->lst_product = $this->model('product_m');
    }

    public function Get_data() {
        $companies = $this->lst_product->getUniqueCompanies(); // Lấy danh sách các công ty
    
        $this->view('Masterlayout', [
            'page' => 'product_v',
            'companies' => $companies // Truyền dữ liệu công ty vào view
        ]);
    }

    public function add() {
        $message = "";
        $product_id = $name = $company = $img = $price = $screen = $os = $camera = $camera_front = $cpu = $ram = $rom = $microUSB = $battery = $quantity = "";
        $companies = $this->lst_product->getUniqueCompanies(); // Fetch list of companies

        if (isset($_POST["btnAdd"])) {
            $imgPath = "";
            // Check if an image file is uploaded
            if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
                $fileName = basename($_FILES['img']['name']);

            }
            // Get form data
            $product_id = $_POST['txtproduct_id'];
            $name = $_POST['txtname'];
            $company = $_POST['sltcompany'];
            $img =  $fileName;
            $price = $_POST['txtprice'];
            $quantity = $_POST['txtquantity'];
            $screen = $_POST['txtscreen'];
            $os = $_POST['txtos'];
            $camera = $_POST['txtcamera'];
            $camera_front = $_POST['txtcamera_front'];
            $cpu = $_POST['txtcpu'];
            $ram = $_POST['txtram'];
            $rom = $_POST['txtrom'];
            $microUSB = $_POST['txtmicroUSB'];
            $battery = $_POST['txtbattery'];

            // Check for duplicate product_id
            if ($this->lst_product->duplicateID($product_id)) {
                $message = "Mã sản phẩm đã tồn tại. Vui lòng nhập mã sản phẩm khác.";
            } else {
                // Call product_ins method to add product
                $result = $this->lst_product->product_ins($product_id, $name, $company, $img, $price, $quantity, $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery);

                if ($result) {
                    $message = "Thêm sản phẩm thành công.";
                } else {
                    $message = "Thêm sản phẩm thất bại. Vui lòng thử lại.";
                }
            }
        }

        // Display the add product form with message and company list
        $this->view('Masterlayout', [
            'page' => 'product_v',
            'message' => $message,
            'product_id'=> $product_id,
            'name'=> $name,
            'company'=> $company,
            'img'=>  $fileName,
            'price'=> $price,
            'quantity'=> $quantity,
            'screen'=> $screen,
            'os'=> $os,
            'camera'=> $camera,
            'camera_front'=> $camera_front,
            'cpu'=> $cpu,
            'ram'=> $ram,
            'rom'=> $rom,
            'microUSB'=> $microUSB,
            'battery'=> $battery,
            'companies' => $companies // Pass companies data to the view
        ]);
    }
}
?>