<?php
class supplier_m extends connectDB {

    function supplier_ins($name, $contact_name, $phone, $email, $address) {
        // Prepare SQL statements using Prepared Statements to prevent SQL Injection
        $sql = "INSERT INTO Suppliers (`name`, `contact_name`, `contact_phone`, `contact_email`, `address`) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->con, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($this->con)));
        }
        mysqli_stmt_bind_param($stmt, "sssss", $name, $contact_name, $phone, $email, $address);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    function supplier_del($name) {
        // Use Prepared Statements to prevent SQL Injection
        $sql = "DELETE FROM Suppliers WHERE `name` = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($this->con)));
        }
        mysqli_stmt_bind_param($stmt, "s", $name); // Use "s" for string parameter
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    function supplier_find($criteria, $keyword) {
        // Use Prepared Statements to prevent SQL Injection
        $sql = "SELECT * FROM Suppliers WHERE `$criteria` LIKE ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($this->con)));
        }
        $keyword = "%$keyword%";
        mysqli_stmt_bind_param($stmt, "s", $keyword);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    function get_supplier_by_id($name) {
        // Retrieve supplier details by ID
        $sql = "SELECT * FROM Suppliers WHERE `name` = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($this->con)));
        }
        mysqli_stmt_bind_param($stmt, "s", $name); // Assuming supplier_id is a string
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $supplier = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $supplier;
    }

    function supplier_upd($name, $contact_name, $phone, $email, $address) {
        // Prepare SQL statements using Prepared Statements to prevent SQL Injection
        $sql = "UPDATE Suppliers SET `contact_name` = ?, `contact_phone` = ?, `contact_email` = ?, `address` = ? WHERE `name` = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($this->con)));
        }
        mysqli_stmt_bind_param($stmt, "sssss", $contact_name, $phone, $email, $address, $name);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    function duplicateName($name) {
        // Check if a supplier name already exists
        $sql = "SELECT * FROM Suppliers WHERE `name`=?";
        $stmt = mysqli_prepare($this->con, $sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars(mysqli_error($this->con)));
        }
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $num_rows > 0;
    }
}
?>