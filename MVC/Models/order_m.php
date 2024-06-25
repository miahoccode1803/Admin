<?php
class order_m extends connectDB {
    function order_find($fromDate, $toDate, $order_id, $customer_name, $status) {
        // Prepare SQL query
        $sql = "SELECT o.order_id, c.name as customer_name, o.order_date, o.status,
                       GROUP_CONCAT(CONCAT(p.name, ' (', od.quantity, ' x ', od.price, ')') SEPARATOR ', ') as products,
                       SUM(od.quantity * od.price) as total
                FROM orders o
                JOIN customers c ON o.customer_id = c.customer_id
                LEFT JOIN orderdetails od ON o.order_id = od.order_id
                LEFT JOIN products p ON od.product_id = p.product_id
                WHERE (o.order_id LIKE CONCAT('%', ?, '%') OR ? = '')
                AND (c.name LIKE CONCAT('%', ?, '%') OR ? = '')
                AND (o.order_date >= CONVERT(?, DATETIME) OR ? = '')
                AND (o.order_date <= CONVERT(?, DATETIME) OR ? = '')
                AND (o.status LIKE CONCAT('%', ?, '%') OR ? = '')
                GROUP BY o.order_id";

        // Prepare statement
        $stmt = mysqli_prepare($this->con, $sql);
        
        // Check for SQL errors
        if ($stmt === false) {
            die('MySQL prepare error: ' . mysqli_error($this->con));
        }
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssssssss", 
            $order_id, $order_id, 
            $customer_name, $customer_name, 
            $fromDate, $fromDate, 
            $toDate, $toDate, 
            $status, $status
        );

        // Execute statement
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows into associative array
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Close statement
        mysqli_stmt_close($stmt);

        // Return result
        return $orders;
    }

    function update_order_status($order_id, $new_status) {
        // Prepare SQL query
        $sql = "UPDATE orders SET status = ? WHERE order_id = ?";

        // Prepare statement
        $stmt = mysqli_prepare($this->con, $sql);

        // Check for SQL errors
        if ($stmt === false) {
            die('MySQL prepare error: ' . mysqli_error($this->con));
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", $new_status, $order_id);

        // Execute statement
        $result = mysqli_stmt_execute($stmt);

        // Close statement
        mysqli_stmt_close($stmt);

        // Return result
        return $result;
    }

    function cancel_order($order_id) {
        // Call update_order_status to change status to 'Cancelled'
        return $this->update_order_status($order_id, 'Cancelled');
    }

    function get_order_status($order_id) {
        // Prepare SQL query
        $sql = "SELECT status FROM orders WHERE order_id = ?";

        // Prepare statement
        $stmt = mysqli_prepare($this->con, $sql);

        // Check for SQL errors
        if ($stmt === false) {
            die('MySQL prepare error: ' . mysqli_error($this->con));
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "s", $order_id);

        // Execute statement
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the row
        $status = mysqli_fetch_assoc($result)['status'];

        // Close statement
        mysqli_stmt_close($stmt);

        // Return status
        return $status;
    }
}
?>