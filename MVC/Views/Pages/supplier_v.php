<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhà Cung Cấp</title>
    <link rel="stylesheet" href="http://localhost/webproject/Public/css/admin/style.css">
    <link rel="stylesheet" href="http://localhost/webproject/Public/css/admin/progress.css">
</head>

<body>
    <form method="POST" action="http://localhost/webproject/list_supplier/add">
        <div id="khungThemNhaCungCap" style="width:max-content;margin:auto">
            <div class="overlayTable table-outline table-content table-header">
                <a href="http://localhost/webproject/list_supplier"><span class="close">&times;</span></a>
                <table>
                    <tr>
                        <th colspan="2">Thêm Nhà Cung Cấp</th>
                    </tr>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td>Tên liên hệ:</td>
                        <td><input type="text" name="contact_name" required></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><input type="text" name="address" required></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td><input type="text" name="phone" required></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-footer">
                            <button type="submit" name="btnAdd">THÊM</button>
                        </td>
                    </tr>
                </table>
                <?php if (!empty($data['message'])): ?>
                <script>
                alert('<?php echo $data['message']; ?>');
                </script>
                <?php endif; ?>
            </div>
        </div>
    </form>
</body>

</html>