<?php
class account_m extends connectDB {

    function account_del($username) {
        // Thoát đầu vào của người dùng để bảo mật
        $username = mysqli_real_escape_string($this->con, $username);

        // Bắt đầu một giao dịch
        mysqli_begin_transaction($this->con);

        try {
            // Lấy ID khách hàng dựa trên tên người dùng
            $sql = "SELECT customer_id FROM customers WHERE username = '$username'";
            $result = mysqli_query($this->con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $customer_id = $row['customer_id'];

                // Xóa chi tiết đơn hàng của các đơn hàng do khách hàng đặt
                $sql = "DELETE od FROM orderdetails od 
                        JOIN orders o ON od.order_id = o.order_id 
                        WHERE o.customer_id = '$customer_id'";
                mysqli_query($this->con, $sql);

                // Xóa các đơn hàng do khách hàng đặt
                $sql = "DELETE FROM orders WHERE customer_id = '$customer_id'";
                mysqli_query($this->con, $sql);

                // Xóa khách hàng
                $sql = "DELETE FROM customers WHERE customer_id = '$customer_id'";
                mysqli_query($this->con, $sql);

                // Cam kết giao dịch
                mysqli_commit($this->con);
                return true;
            } else {
                throw new mysqli_sql_exception("Không tìm thấy khách hàng: " . mysqli_error($this->con));
            }
        } catch (Exception $e) {
            // Hoàn tác giao dịch trong trường hợp lỗi
            mysqli_rollback($this->con);
            throw new mysqli_sql_exception("Lỗi khi thực thi truy vấn: " . $e->getMessage());
        }
    }

    function account_find($username, $email, $name) {
        // Thoát đầu vào của người dùng để bảo mật
        $username = mysqli_real_escape_string($this->con, $username);
        $email = mysqli_real_escape_string($this->con, $email);
        $name = mysqli_real_escape_string($this->con, $name);

        $sql = "SELECT `name`, `email`, `username`, `password`, `is_active`
                FROM customers
                WHERE `username` LIKE '%$username%'
                AND `name` LIKE '%$name%'
                AND `email` LIKE '%$email%'";

        $result = mysqli_query($this->con, $sql);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            throw new mysqli_sql_exception("Lỗi khi thực thi truy vấn: " . mysqli_error($this->con));
        }
    }

    function toggle_active_status($username) {
        // Thoát đầu vào của người dùng để bảo mật
        $username = mysqli_real_escape_string($this->con, $username);

        // Lấy trạng thái hiện tại
        $sql = "SELECT `is_active` FROM customers WHERE `username` = '$username'";
        $result = mysqli_query($this->con, $sql);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $current_status = $row['is_active'];
            // Chuyển đổi trạng thái
            $new_status = $current_status ? 0 : 1;

            // Cập nhật trạng thái trong cơ sở dữ liệu
            $sql = "UPDATE customers SET `is_active` = $new_status WHERE `username` = '$username'";
            if (mysqli_query($this->con, $sql)) {
                return $new_status;
            } else {
                throw new mysqli_sql_exception("Lỗi khi cập nhật trạng thái: " . mysqli_error($this->con));
            }
        } else {
            throw new mysqli_sql_exception("Lỗi khi lấy trạng thái hiện tại: " . mysqli_error($this->con));
        }
    }

}
?>