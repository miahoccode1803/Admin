<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Products</title>
    <link rel="stylesheet" href="http://localhost/webproject/Public/Css/admin/style.css">
    <link rel="stylesheet" href="http://localhost/webproject/Public/Css/admin/progress.css">
</head>

<style>
.add {
    padding: 5px 10px;
    border: 3px solid transparent;
    background-color: black;
}

.add:hover {
    background-color: green;
}

.add a {
    font-family: Arial, Helvetica, sans-serif;
}
</style>

<body>
    <button class="add">
        <a href="http://localhost/webproject/product" style=" text-decoration:none;color:white;">
            <i class="fa fa-plus-square">Thêm sản phẩm</i>
        </a>
    </button>
    <form method="post" action="http://localhost/webproject/list_product/find">
        <div class="sanpham">
            <table class="table-header" style="overflow:auto;">
                <thead>
                    <tr>
                        <th title="Sắp xếp" style="width:fit-content">Stt <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width:fit-content">Mã <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width:fit-content">Tên <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width:fit-content">Giá <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width:fit-content">Hãng sản xuất <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width:fit-content">Số lượng <i class="fa fa-sort"></i></th>
                        <th style="width: 15%">Hành động</th>
                    </tr>
                </thead>
                <tbody class="table-content">
                    <?php
                    if(isset($data['dulieu']) && !empty($data['dulieu'])) {
                        $i = 0;
                        foreach($data['dulieu'] as $row) {
                            ?>
                    <tr>
                        <td><?php echo ++$i ?></td>
                        <td><?php echo $row['product_id'] ?></td>
                        <td class="hideImg"><img class="hinhDaiDien"
                                src="<?php echo "http://localhost/webproject/Public/Picture/products/".$row['img'] ?>"
                                alt="Ảnh đại diện"><a href="#"><?php echo $row['name'] ?></a></td>
                        <td><?php echo $row['price'] ?></td>
                        <td><?php echo $row['company'] ?></td>
                        <td><?php echo $row['quantity'] ?></td>
                        <td>
                            <a href="http://localhost/webproject/list_product/delete/<?php echo $row['product_id']?>"
                                style=" text-decoration:none;color:white;float:left;padding-right:0px;margin-left:38%;"><i
                                    class="fa fa-trash"></i></a><a
                                href="http://localhost/webproject/list_product/update/<?php echo $row['product_id']?>"
                                style=" text-decoration:none;color:white;float:left;padding-left:0px;padding-right:0px;"><i
                                    class="fa fa-wrench"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="table-content">
        </div>

        <div class="table-footer" style="position: fixed; bottom: 0; left: 170px;z-index: 1;width:100%">
            <select name="kieuTimSanPham">
                <option value="ma"
                    <?php echo (isset($_POST['kieuTimSanPham']) && $_POST['kieuTimSanPham'] == 'ma') ? 'selected' : ''; ?>>
                    Tìm theo mã</option>
                <option value="ten"
                    <?php echo (isset($_POST['kieuTimSanPham']) && $_POST['kieuTimSanPham'] == 'ten') ? 'selected' : ''; ?>>
                    Tìm theo tên</option>
            </select>
            <input type="text" placeholder="Tìm kiếm..." name="txtFind"
                value="<?php echo isset($_POST['txtFind']) ? $_POST['txtFind'] : ''; ?>">
            <button name="btnFind">
                <i class="fa fa-search"></i>
                Tìm kiếm
            </button>
        </div>
    </form>
    <?php if (!empty($data['message'])): ?>
    <script>
    alert('<?php echo $data['message']; ?>');
    </script>
    <?php endif; ?>
</body>

</html>