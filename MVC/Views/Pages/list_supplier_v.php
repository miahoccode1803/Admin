<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhà cung cấp</title>
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
        <a href="http://localhost/webproject/supplier" style=" text-decoration:none;color:white;">
            <i class="fa fa-plus-square">Thêm nhà cung cấp</i>
        </a>
    </button>
    <form method="POST" action="http://localhost/webproject/list_supplier/search">
        <div class="sanpham">
            <table class="table-header" style="overflow:auto;">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Người liên hệ</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody class="table-content">
                    <?php 
                        if (isset($data['data']) && !empty($data['data'])) {
                            $i=0;
                            while ($row = mysqli_fetch_assoc($data['data'])) {
                        ?>
                    <tr>
                        <td><?php echo ++$i ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact_phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['contact_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td>
                            <a href="http://localhost/webproject/list_supplier/delete/<?php echo $row['name']?>"
                                style=" text-decoration:none;color:white;float:left;padding-right:0px;margin-left:38%;"><i
                                    class="fa fa-trash"></i></a><a
                                href="http://localhost/webproject/list_supplier/update/<?php echo $row['name']?>"
                                style=" text-decoration:none;color:white;float:left;padding-left:0px;padding-right:0px;"><i
                                    class="fa fa-wrench"></i></a>
                        </td>
                    </tr>
                    <?php        
                            }
                        } else {
                            echo "<tr><td colspan='6'>Không có nhà cung cấp nào.</td></tr>";
                        }
                        ?>

                </tbody>

                <div class="table-footer" style="position: fixed; bottom: 0; left: 170px; z-index: 1; width: 100%;">
                    <select name="kieuTimNCC">
                        <option value="name"
                            <?php echo (isset($_POST['kieuTimNCC']) && $_POST['kieuTimNCC'] == 'name') ? 'selected' : ''; ?>>
                            Tìm theo tên</option>
                        <option value="contact_name"
                            <?php echo (isset($_POST['kieuTimNCC']) && $_POST['kieuTimNCC'] == 'contact_name') ? 'selected' : ''; ?>>
                            Tìm theo người liên hệ</option>
                        <option value="address"
                            <?php echo (isset($_POST['kieuTimNCC']) && $_POST['kieuTimNCC'] == 'address') ? 'selected' : ''; ?>>
                            Tìm theo địa chỉ</option>
                        <option value="contact_email"
                            <?php echo (isset($_POST['kieuTimNCC']) && $_POST['kieuTimNCC'] == 'contact_email') ? 'selected' : ''; ?>>
                            Tìm theo email</option>
                        <option value="contact_phone"
                            <?php echo (isset($_POST['kieuTimNCC']) && $_POST['kieuTimNCC'] == 'contact_phone') ? 'selected' : ''; ?>>
                            Tìm theo số điện thoại</option>
                    </select>
                    <input type="text" placeholder="Tìm kiếm..." name="txtFind"
                        value="<?php echo isset($_POST['txtFind']) ? htmlspecialchars($_POST['txtFind']) : ''; ?>">
                    <button name="btnFind">
                        <i class="fa fa-search"></i>
                        Tìm kiếm
                    </button>

                </div>
            </table>
        </div>
        </div>
    </form>
    <?php if (!empty($data['message'])): ?>
    <script>
    alert('<?php echo $data['message']; ?>');
    </script>
    <?php endif; ?>S
</body>

</html>