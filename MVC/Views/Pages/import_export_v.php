<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import/Export Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        crossorigin="anonymous">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-container {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .form-container h2 {
        margin-top: 0;
        color: #333;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #555;
    }

    .form-group {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <form id="mainForm" method="post" enctype="multipart/form-data">
        <div class="container">
            <div class="form-container">
                <h2>Nhập dữ liệu</h2>
                <div class="form-group">
                    <input type="file" id="dataFile" name="dataFile" accept=".xlsx" required>
                    <select name="table" id="table" required>
                        <option value="">Chọn bảng</option>
                        <option value="customers">Khách Hàng</option>
                        <option value="products">Sản Phẩm</option>
                        <option value="orders">Đơn hàng</option>
                        <option value="suppliers">Nhà cung cấp</option>
                    </select>
                    <button type="submit" class="btn" onclick="submitForm(event)"><i class="fa fa-upload"></i> Import
                        Data</button>
                </div>
            </div>

            <div class="form-container">
                <h2>Xuất file</h2>
                <h4>Chọn bảng để xuất file</h4>
                <div class="form-group">
                    <a href="http://localhost/Admin/import_export/exportData/customers" class="btn"><i
                            class="fa fa-download"></i> Khách Hàng</a>
                </div>
                <div class="form-group">
                    <a href="http://localhost/Admin/import_export/exportData/products" class="btn"><i
                            class="fa fa-download"></i> Sản Phẩm</a>
                </div>
                <div class="form-group">
                    <a href="http://localhost/Admin/import_export/exportData/orders" class="btn"><i
                            class="fa fa-download"></i> Đơn hàng</a>
                </div>
                <div class="form-group">
                    <a href="http://localhost/Admin/import_export/exportData/suppliers" class="btn"><i
                            class="fa fa-download"></i> Nhà cung cấp</a>
                </div>
            </div>
        </div>
    </form>
    <?php if (!empty($data['message'])): ?>
    <script>
    alert('<?php echo $data['message']; ?>');
    </script>
    <?php endif; ?>
    <script>
    function submitForm(event) {
        event.preventDefault();
        const form = document.getElementById('mainForm');
        const table = document.getElementById('table').value;
        if (table) {
            form.action = `http://localhost/Admin/import_export/importData/${table}`;
            form.submit();
        } else {
            alert('Please select a table to import.');
        }
    }
    </script>
</body>

</html>