<?php
class Home extends controller {
    private $productModel;

    public function __construct() {
        $this->productModel = $this->model('product_m');
    }

    public function Get_data() {
        // Lấy dữ liệu doanh thu và số lượng bán ra theo hãng từ model
        $data = $this->productModel->get_sales_and_revenue_by_company();
        
        // Kiểm tra giá trị của $data (tùy chọn)
        error_log(print_r($data, true));

        // Trả về dữ liệu và trang 'home_v' cho view 'Masterlayout'
        $this->view('Masterlayout', [
            'data' => $data,
            'page' => 'home_v'
        ]);
    }
}
?>