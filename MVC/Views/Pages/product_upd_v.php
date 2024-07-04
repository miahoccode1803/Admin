<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="http://localhost/meMe/Public/css/admin/style.css">
    <link rel="stylesheet" href="http://localhost/meMe/Public/css/admin/progress.css">
</head>

<body>
    <form method="POST" action="http://localhost/meMe/list_product/update_data" enctype="multipart/form-data">
        <div id="khungSuaSanPham" style="width:max-content;margin:auto">
            <div class="overlayTable table-outline table-content table-header">
                <a href="http://localhost/meMe/list_product"><span class="close">&times;</span></a>
                <table>
                    <tr>
                        <th colspan="2">Cập nhật thông tin Sản Phẩm</th>
                    </tr>
                    <?php 
                    if (isset($data['product']) && !empty($data['product'])) {
                        $row = $data['product'];
                    ?>
                    <tr>
                        <td>Mã sản phẩm:</td>
                        <td><input type="text" id="maspThem" name="txtproduct_id"
                                value="<?php echo htmlspecialchars($row['product_id']); ?>" required readonly></td>
                    </tr>
                    <tr>
                        <td>Tên sản phẩm:</td>
                        <td><input type="text" name="txtname" value="<?php echo htmlspecialchars($row['name']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Hãng:</td>
                        <td>
                            <select name="sltcompany">
                                <?php
                                $company = ["Apple", "Samsung", "Oppo", "Nokia", "Huawei", "Xiaomi", "Realme", "Vivo", "Philips", "Mobell", "Mobiistar", "Itel", "Coolpad", "HTC", "Motorola"];
                                foreach ($company as $c) {
                                    $selected = ($c === $row['company']) ? 'selected' : '';
                                    echo "<option value='$c' $selected>$c</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Hình:</td>
                        <td>
                            <img class="hinhDaiDien" id="anhDaiDienSanPhamThem" name="product_img"
                                src="<?php echo "http://localhost/meMe/Public/img/products/".$row['img']; ?>"
                                alt="Product Image">
                            <input type="file" name="product_image" accept="image/*" onchange="previewImage(this);">
                        </td>
                    </tr>
                    <tr>
                        <td>Giá tiền:</td>
                        <td><input type="text" name="txtprice" value="<?php echo htmlspecialchars($row['price']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Số lượng:</td>
                        <td><input type="number" name="txtquantity"
                                value="<?php echo htmlspecialchars($row['quantity']); ?>" required></td>
                    </tr>
                    <tr>
                        <th colspan="2">Thông số kĩ thuật</th>
                    </tr>
                    <tr>
                        <td>Màn hình:</td>
                        <td><input type="text" name="txtscreen" value="<?php echo htmlspecialchars($row['screen']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Hệ điều hành:</td>
                        <td><input type="text" name="txtos" value="<?php echo htmlspecialchars($row['os']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Camera sau:</td>
                        <td><input type="text" name="txtcamera" value="<?php echo htmlspecialchars($row['camera']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Camera trước:</td>
                        <td><input type="text" name="txtcamera_front"
                                value="<?php echo htmlspecialchars($row['camera_front']); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td>CPU:</td>
                        <td><input type="text" name="txtcpu" value="<?php echo htmlspecialchars($row['cpu']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>RAM:</td>
                        <td><input type="text" name="txtram" value="<?php echo htmlspecialchars($row['ram']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Bộ nhớ trong:</td>
                        <td><input type="text" name="txtrom" value="<?php echo htmlspecialchars($row['rom']); ?>"
                                required></td>
                    </tr>
                    <tr>
                        <td>Thẻ nhớ:</td>
                        <td><input type="text" name="txtmicroUSB"
                                value="<?php echo htmlspecialchars($row['microUSB']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Dung lượng Pin:</td>
                        <td><input type="text" name="txtbattery"
                                value="<?php echo htmlspecialchars($row['battery']); ?>" required></td>
                    </tr>
                    <?php        
                    } else {
                        echo "<tr><td colspan='2'>Product not found.</td></tr>";
                    }
                    ?>
                    <tr>
                        <td colspan="2" class="table-footer">
                            <button type="submit" class="btn btn-primary" name="btnUpdate">CẬP NHẬT</button>
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
    <script>
    function previewImage(input) {
        var preview = document.getElementById('anhDaiDienSanPhamThem');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
    </script>
</body>

</html>