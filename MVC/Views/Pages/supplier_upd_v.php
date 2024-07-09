<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập Nhật Nhà Cung Cấp</title>
    <link rel="stylesheet" href="http://localhost/webproject/Public/Css/admin/style.css">
</head>

<body>
    <form method="POST" action="http://localhost/webproject/list_supplier/update_data">
        <div id="khungCapNhatNhaCungCap" style="width:max-content;margin:auto">
            <div class="overlayTable table-outline table-content table-header">
                <a href="http://localhost/webproject/list_supplier"><span class="close">&times;</span></a>
                <table>
                    <tr>
                        <th colspan="2">Cập Nhật Nhà Cung Cấp</th>
                    </tr>
                    <tr>
                        <td>Tên nhà cung cấp:</td>
                        <td><input type="text" name="txtname"
                                value="<?php echo isset($data['name']) ? htmlspecialchars($data['name']) : ''; ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Tên liên hệ:</td>
                        <td><input type="text" name="txtcontact_name"
                                value="<?php echo isset($data['contact_name']) ? htmlspecialchars($data['contact_name']) : ''; ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Số điện thoại:</td>
                        <td><input type="text" name="txtphone"
                                value="<?php echo isset($data['contact_phone']) ? htmlspecialchars($data['contact_phone']) : ''; ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="txtemail"
                                value="<?php echo isset($data['contact_email']) ? htmlspecialchars($data['contact_email']) : ''; ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ:</td>
                        <td><input type="text" name="txtaddress"
                                value="<?php echo isset($data['address']) ? htmlspecialchars($data['address']) : ''; ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" class="buttonPro green" value="Cập Nhật" name="btnUpdate" />
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php if (!empty($data['message'])): ?>
        <script>
        alert('<?php echo $data['message']; ?>');
        </script>
        <?php endif; ?>
    </form>
</body>

</html>