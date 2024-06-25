<?php
class account_m extends connectDB {

    function account_del($username) {
        // Escaping user input for security
        $username = mysqli_real_escape_string($this->con, $username);

        // Start a transaction
        mysqli_begin_transaction($this->con);

        try {
            // Get the customer ID based on username
            $sql = "SELECT customer_id FROM customers WHERE username = '$username'";
            $result = mysqli_query($this->con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $customer_id = $row['customer_id'];

                // Delete order details for orders placed by the customer
                $sql = "DELETE od FROM orderdetails od 
                        JOIN orders o ON od.order_id = o.order_id 
                        WHERE o.customer_id = '$customer_id'";
                mysqli_query($this->con, $sql);

                // Delete orders placed by the customer
                $sql = "DELETE FROM orders WHERE customer_id = '$customer_id'";
                mysqli_query($this->con, $sql);

                // Delete the customer
                $sql = "DELETE FROM customers WHERE customer_id = '$customer_id'";
                mysqli_query($this->con, $sql);

                // Commit the transaction
                mysqli_commit($this->con);
                return true;
            } else {
                throw new mysqli_sql_exception("Customer not found: " . mysqli_error($this->con));
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of error
            mysqli_rollback($this->con);
            throw new mysqli_sql_exception("Error executing query: " . $e->getMessage());
        }
    }

    function account_find($username, $email, $name) {
        // Escaping user input for security
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
            throw new mysqli_sql_exception("Error executing query: " . mysqli_error($this->con));
        }
    }

    function toggle_active_status($username) {
        // Escaping user input for security
        $username = mysqli_real_escape_string($this->con, $username);

        // Fetch current status
        $sql = "SELECT `is_active` FROM customers WHERE `username` = '$username'";
        $result = mysqli_query($this->con, $sql);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $current_status = $row['is_active'];
            // Toggle status
            $new_status = $current_status ? 0 : 1;

            // Update status in database
            $sql = "UPDATE customers SET `is_active` = $new_status WHERE `username` = '$username'";
            if (mysqli_query($this->con, $sql)) {
                return $new_status;
            } else {
                throw new mysqli_sql_exception("Error updating status: " . mysqli_error($this->con));
            }
        } else {
            throw new mysqli_sql_exception("Error fetching current status: " . mysqli_error($this->con));
        }
    }


}
?>