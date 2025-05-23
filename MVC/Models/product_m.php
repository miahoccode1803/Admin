<?php
class product_m extends connectDB {

    function product_ins($product_id, $name, $company, $img, $price, $quantity, $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery) {
        // Prepare SQL statements using Prepared Statements to prevent SQL Injection
        $sql1 = "INSERT INTO Products (product_id, `name`, company, img, price, quantity) 
                 VALUES (?, ?, ?, ?, ?, ?)";
        $stmt1 = mysqli_prepare($this->con, $sql1);
        mysqli_stmt_bind_param($stmt1, "ssssss", $product_id, $name, $company, $img, $price, $quantity);
        $result1 = mysqli_stmt_execute($stmt1);

        if ($result1) {
            // Insert into ProductDetails table
            $sql2 = "INSERT INTO ProductDetails (product_id, screen, os, camera, camera_front, cpu, ram, rom, microUSB, battery) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($this->con, $sql2);
            mysqli_stmt_bind_param($stmt2, "ssssssssss", $product_id, $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery);
            $result2 = mysqli_stmt_execute($stmt2);

            return $result2;
        } else {
            return false;
        }
    }

    function duplicateID($masp) {
        $sql = "SELECT * FROM products WHERE product_id=?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $masp);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $num_rows = mysqli_stmt_num_rows($stmt);
        mysqli_stmt_close($stmt);
        return $num_rows > 0;
    }

    function product_del($product_id) {
        // Use Prepared Statements to prevent SQL Injection
        $sql1 = "DELETE FROM ProductDetails WHERE product_id = ?";
        $stmt1 = mysqli_prepare($this->con, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $product_id);
        $result1 = mysqli_stmt_execute($stmt1);

        if ($result1) {
            $sql2 = "DELETE FROM Products WHERE product_id = ?";
            $stmt2 = mysqli_prepare($this->con, $sql2);
            mysqli_stmt_bind_param($stmt2, "s", $product_id);
            $result2 = mysqli_stmt_execute($stmt2);

            return $result2;
        } else {
            return false;
        }
    }

    function product_find($masp, $name) {
        // Use Prepared Statements to prevent SQL Injection
        $sql = "SELECT * FROM Products
                WHERE product_id LIKE CONCAT('%', ?, '%')
                AND `name` LIKE CONCAT('%', ?, '%')";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $masp, $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return $result;
    }

    function product_upd($product_id, $name, $company, $img, $price, $quantity, $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery) {
        // Use Prepared Statements to prevent SQL Injection
        $sql1 = "UPDATE Products 
                 SET `name` = ?, company = ?, img = ?, price = ?, quantity = ? 
                 WHERE product_id = ?";
        $stmt1 = mysqli_prepare($this->con, $sql1);
        mysqli_stmt_bind_param($stmt1, "ssssss", $name, $company, $img, $price, $quantity, $product_id);
        $result1 = mysqli_stmt_execute($stmt1);
    
        if ($result1) {
            $sql2 = "UPDATE ProductDetails 
                     SET screen = ?, os = ?, camera = ?, camera_front = ?, 
                         cpu = ?, ram = ?, rom = ?, microUSB = ?, battery = ? 
                     WHERE product_id = ?";
            $stmt2 = mysqli_prepare($this->con, $sql2);
            mysqli_stmt_bind_param($stmt2, "ssssssssss", $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery, $product_id);
            $result2 = mysqli_stmt_execute($stmt2);
    
            return $result2;
        } else {
            return false;
        }
    }

    function get_product_for_update_form($product_id) {
        // Use Prepared Statements to prevent SQL Injection
        $sql = "SELECT p.product_id, p.name, p.company, p.img, p.price, p.quantity, pd.screen, pd.os, pd.camera, pd.camera_front, pd.cpu, pd.ram, pd.rom, pd.microUSB, pd.battery
                FROM Products p
                LEFT JOIN ProductDetails pd ON p.product_id = pd.product_id
                WHERE p.product_id = ?";
    
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $product_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $product_id, $name, $company, $img, $price, $quantity, $screen, $os, $camera, $camera_front, $cpu, $ram, $rom, $microUSB, $battery);
    
        if (mysqli_stmt_fetch($stmt)) {
            $data = [
                'product_id' => $product_id,
                'name' => $name,
                'company' => $company,
                'img' => $img,
                'price' => $price,
                'quantity' => $quantity,
                'screen' => $screen,
                'os' => $os,
                'camera' => $camera,
                'camera_front' => $camera_front,
                'cpu' => $cpu,
                'ram' => $ram,
                'rom' => $rom,
                'microUSB' => $microUSB,
                'battery' => $battery
            ];
            return $data;
        } else {
            return false;
        }
    }

    function get_sales_and_revenue_by_company() {
        // Query to get sales and revenue by company
        $sql = "SELECT p.company, 
                       SUM(od.quantity) as total_sales, 
                       SUM(p.price * od.quantity) as total_revenue 
                FROM Products p
                JOIN OrderDetails od ON p.product_id = od.product_id
                GROUP BY p.company";
        $result = mysqli_query($this->con, $sql);

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Format total_sales and total_revenue as numbers
            $row['total_sales'] = intval($row['total_sales']);
            $row['total_revenue'] = floatval($row['total_revenue']);
            $data[] = $row;
        }

        return $data;
    }


    function getUniqueCompanies() {
        $sql = "SELECT `name` FROM Suppliers";
        $result = mysqli_query($this->con, $sql);
    
        // Check if query was successful
        if (!$result) {
            die('Query error: ' . mysqli_error($this->con));
        }
    
        $companies = array();
    
        // Fetch associative array
        while ($row = mysqli_fetch_assoc($result)) {
            $companies[] = $row['name']; // Add each company name to the array
        }
    
        // Free result set
        mysqli_free_result($result);
    
        return $companies;
    }
}
?>