<?php
class product extends controller {
    private $lst_product;

    public function __construct() {
        $this->lst_product = $this->model('product_m');
    }

    public function Get_data() {
        $this->view('Masterlayout', [
            'page' => 'product_v'
        ]);
    }

    public function add() {
        $message = "";
        if (isset($_POST["btnAdd"])) {
            $imgPath = "";
            // Kiểm tra nếu có tệp ảnh được tải lên
            if (isset($_FILES['img'])) {
                // Tên của tệp ảnh
                $fileName = $_FILES['img']['name'];
                // Đường dẫn lưu tệp ảnh (tại thư mục img/products/)
                $imgPath = 'img/products/' . $fileName;
            }
            // Lấy dữ liệu từ form
                $product_id = $_POST['txtproduct_id'];
                $name = $_POST['txtname'];
                $company = $_POST['sltcompany'];
                $img = $imgPath;
                $price = $_POST['txtprice'];
                $screen = $_POST['txtscreen'];
                $os = $_POST['txtos'];
                $camera = $_POST['txtcamera'];
                $camera_front = $_POST['txtcamera_front'];
                $cpu = $_POST['txtcpu'];
                $ram = $_POST['txtram'];
                $rom = $_POST['txtrom'];
                $microUSB = $_POST['txtmicroUSB'];
                $battery = $_POST['txtbattery'];
    
            // Kiểm tra trùng lặp product_id
            if ($this->lst_product->duplicateID($product_id)) {
                // Thông báo lỗi nếu product_id đã tồn tại
                $message = "Mã sản phẩm đã tồn tại. Vui lòng nhập mã sản phẩm khác.";
            } else {
                // Gọi hàm product_ins để thêm sản phẩm
                $result = $this->lst_product->product_ins($product_id,$name,$company,$img, $price,$screen,$os,$camera,$camera_front,$cpu,$ram,$rom,$microUSB,$battery);
    
                if ($result) {
                    // Thêm thành công
                    $message = "Thêm sản phẩm thành công.";
                } else {
                    // Thêm thất bại
                    $message = "Thêm sản phẩm thất bại. Vui lòng thử lại.";
                }
            }
        }
        // Hiển thị form thêm sản phẩm cùng với thông báo
        $this->view('Masterlayout', [
            'page' => 'product_v',
            'message' => $message,
            'product_id'=> $product_id,
            'name'=> $name,
            'company'=> $company,
            'img'=> $img,
            'price'=> $price,
            'screen'=> $screen,
            'os'=> $os,
            'camera'=> $camera,
            'camera_front'=> $camera_front,
            'cpu'=> $cpu,
            'ram'=> $ram,
            'rom'=> $rom,
            'microUSB'=> $microUSB,
            'battery'=> $battery
        ]);
    }
    

  
}
?>