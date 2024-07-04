<?php
class supplier_m extends connectDB {

    function supplier_ins($name, $address, $phone, $email) {
        // Prepare SQL statements using Prepared Statements to prevent SQL Injection
        $sql = "INSERT INTO Suppliers (name, address, phone, email) 
                VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $address, $phone, $email);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function supplier_del($supplier_id) {
        // Use Prepared Statements to prevent SQL Injection
        $sql = "DELETE FROM Suppliers WHERE supplier_id = ?";
        $stmt = mysqli_prepare($this->
        con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $supplier_id);
        $result = mysqli_stmt_execute($stmt);

        return $result;
    }

    function supplier_find($name) {
        // Use Prepared Statements to prevent SQL Injection
        $sql = "SELECT * FROM Suppliers WHERE name LIKE CONCAT('%', ?, '%')";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        return $result;
    }

    function duplicateName($name) {
        $sql = "SELECT * FROM Suppliers WHERE name=?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $num_rows > 0;
    }
}
?>