<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
    <link rel="stylesheet" href="http://localhost/meMe/Public/css/admin/style.css">
    <link rel="stylesheet" href="http://localhost/meMe/Public/css/admin/progress.css">
</head>

<body>
    <form method="POST" action="http://localhost/meMe/supplier/add">
        <div id="khungThemNhaCungCap" style="width:max-content;margin:auto">
            <div class="overlayTable table-outline table-content table-header">
                <a href="http://localhost/meMe/list_supplier"><span class="close">&times;</span></a>
                <table>
                    <tr>
                        <th colspan="2">Thêm Nhà Cung Cấp</th>
                    </tr>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type="text" name="txtname" required></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><input type="text" name="txtaddress" required></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td><input type="text" name="txtphone" required></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="txtemail" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="table-footer">
                            <button name="btnAdd">THÊM</button>
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