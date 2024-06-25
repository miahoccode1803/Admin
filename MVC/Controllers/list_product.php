<?php
class list_product extends controller {
    private $lst_product;

    public function __construct() {
        $this->lst_product = $this->model('product_m');
    }

    public function Get_data() {
        $dulieu = $this->lst_product->product_find('', '');
        $this->view('Masterlayout', [
            'dulieu' => $dulieu,
            'page' => 'list_product_v'
        ]);
    }

    public function find() {
        if (isset($_POST['btnFind'])) {
            $searchType = $_POST['kieuTimSanPham'];
            $searchQuery = $_POST['txtFind'];
            $ma = '';
            $ten = '';
            if ($searchType == 'ma') {
                $ma = $searchQuery;
            } else if ($searchType == 'ten') {
                $ten = $searchQuery;
            }
            // Tìm kiếm sản phẩm dựa trên mã hoặc tên
            $dulieu = $this->lst_product->product_find($ma, $ten);
            $this->view('Masterlayout', [
                'dulieu' => $dulieu,
                'page' => 'list_product_v'
            ]);
        }
    }

    public function update_data() {
        $message = "";
        $imgPath = "";
    
        // Kiểm tra nếu có tệp ảnh được tải lên
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['product_image']['tmp_name'];
            $fileName = $_FILES['product_image']['name'];
            $uploadDir = 'img/products/'; // Thư mục lưu trữ ảnh trên server
            $dest_path = $uploadDir . $fileName;
    
            // Tạo thư mục nếu chưa tồn tại
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
    
            // Di chuyển tệp tải lên đến thư mục đích
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imgPath = $dest_path; // Đường dẫn lưu trữ ảnh
            } else {
                $message = "Tải lên hình ảnh thất bại.";
            }
        } else {
            $imgPath = $_POST['txtimg']; // Giữ nguyên đường dẫn ảnh cũ nếu không có tệp mới
        }
    
        if (isset($_POST['btnUpdate'])) {
            $product_id = $_POST['txtproduct_id'];
            $name = $_POST['txtname'];
            $company = $_POST['sltcompany'];
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
    
            $result = $this->lst_product->product_upd($product_id, $name, $company, $imgPath, $price, $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery);
    
            if ($result) {
                $message = "Cập nhật sản phẩm thành công.";
            } else {
                $message = "Cập nhật sản phẩm thất bại. Vui lòng thử lại.";
            }
        }
    
        // Hiển thị form cập nhật sản phẩm cùng với thông báo
        $this->view('Masterlayout', [
            'page' => 'product_upd_v',
            'product' => $this->lst_product->get_product_for_update_form($_POST['txtproduct_id']),
            'message' => $message
        ]);
    }
    
    
    
    function update($product_id){
       // Lấy thông tin sản phẩm cần cập nhật
       // Hiển thị form cập nhật sản phẩm cùng với thông báo
       $this->view('Masterlayout', [
           'page' => 'product_upd_v',
           'product' => $this->lst_product->get_product_for_update_form($product_id)
       ]);
    }
public function delete($product_id) {
    // Gọi hàm product_del để xóa sản phẩm
    $result = $this->lst_product->product_del($product_id);

    if ($result) {
        // Xóa thành công
        $message = "Xóa sản phẩm thành công.";
    } else {
        // Xóa thất bại
        $message = "Xóa sản phẩm thất bại. Vui lòng thử lại.";
    }
    
    $this->view('Masterlayout', [
        'page' => 'list_product_v',
        'dulieu' => $this->lst_product->product_find("",""),
        'message' => $message
    ]);
}
}
?>