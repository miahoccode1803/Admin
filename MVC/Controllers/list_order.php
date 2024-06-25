<?php
class list_order extends controller {
    private $lst_order;

    public function __construct() {
        $this->lst_order = $this->model('order_m');
    }

    public function Get_data() {
        $orders = $this->lst_order->order_find('', '', '', '', '');
        
        $this->view('Masterlayout', [
            'page' => 'list_order_v',
            'dulieu' => $orders
        ]);
    }

    public function find() {
        $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
        $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';
        $query = isset($_POST['txtSearch']) ? $_POST['txtSearch'] : '';
        $searchType = isset($_POST['kieuTimDonHang']) ? $_POST['kieuTimDonHang'] : '';
        
        // Initialize variables
        $order_id = '';
        $customer_name = '';
        $status = '';

        // Assign values based on search type
        switch ($searchType) {
            case 'order_id':
                $order_id = $query;
                break;
            case 'customer_name':
                $customer_name = $query;
                break;
            case 'status':
                $status = $query;
                break;
        }

        // Call order_find method with correct parameters
        $result = $this->lst_order->order_find($fromDate, $toDate, $order_id, $customer_name, $status);

        // Load view with results
        $this->view('Masterlayout', [
            'dulieu' => $result,
            'page' => 'list_order_v'
        ]);
    }

    public function change_status($order_id) {
        // Lấy trạng thái hiện tại của đơn hàng
        $current_status = $this->lst_order->get_order_status($order_id);

        if ($current_status == 'Cancelled') {
            // Hiển thị alert thông báo lỗi bằng JavaScript
            echo '<script>alert("Đơn hàng đã bị hủy không thể duyệt."); window.location.href = "http://localhost/meMe/list_order/find";</script>';
            exit;
        }
            if ($current_status == 'Shipped') {
                // Hiển thị alert thông báo lỗi bằng JavaScript
                echo '<script>alert("Đơn hàng đã được duyệt rồi."); window.location.href = "http://localhost/meMe/list_order/find";</script>';
                exit;
            }
        else {
            // Cập nhật trạng thái đơn hàng thành "Shipped"
            $result = $this->lst_order->update_order_status($order_id, 'Shipped');

            if ($result) {
                // Hiển thị alert thông báo thành công bằng JavaScript
                echo '<script>alert("Đã duyệt đơn hàng thành công!"); window.location.href = "http://localhost/meMe/list_order/find";</script>';
                exit;
            } else {
                // Xử lý tình huống lỗi (nếu cập nhật thất bại)
                echo '<script>alert("Cập nhật trạng thái đơn hàng thất bại."); window.location.href = "http://localhost/meMe/list_order/find";</script>';
                exit;
            }
        }
    }

    public function cancel_order($order_id) {
        // Lấy trạng thái hiện tại của đơn hàng
        $current_status = $this->lst_order->get_order_status($order_id);

        if ($current_status == 'Shipped') {
            // Hiển thị alert thông báo lỗi bằng JavaScript
            echo '<script>alert("Đơn hàng đã được giao không thể hủy."); window.location.href = "http://localhost/meMe/list_order/find";</script>';
            exit;
        }
        else if($current_status == 'Cancelled'){
            echo '<script>alert("Đơn hàng đã được hủy."); window.location.href = "http://localhost/meMe/list_order/find";</script>';
            exit;
        
        } else {
            // Cập nhật trạng thái đơn hàng thành "Cancelled"
            $result = $this->lst_order->cancel_order($order_id);

            if ($result) {
                // Hiển thị alert thông báo thành công bằng JavaScript
                echo '<script>alert("Đã hủy đơn hàng thành công!"); window.location.href = "http://localhost/meMe/list_order/find";</script>';
                exit;
            } else {
                // Xử lý tình huống lỗi (nếu cập nhật thất bại)
                echo '<script>alert("Hủy đơn hàng thất bại."); window.location.href = "http://localhost/meMe/list_order/find";</script>';
                exit;
            }
        }
    }
}
?>