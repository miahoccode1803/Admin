<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>

    <link rel="stylesheet" href="http://localhost/webproject/Public/Css/admin/style.css">
    <link rel="stylesheet" href="http://localhost/webproject/Public/Css/admin/progress.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Load font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        crossorigin="anonymous">

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
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

</head>

<body>
    <form action="http://localhost/webproject/list_account/find" method="POST">
        <div class="khachhang">
            <table class="table-header">
                <thead>
                    <tr>
                        <th title="Sắp xếp" style="width: 5%">Stt <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 15%">Họ tên <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 20%">Email <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 20%">Tài khoản <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 10%">Mật khẩu <i class="fa fa-sort"></i></th>
                        <th style="width: 10%">Hành động</th>
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
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['password'] ?></td>
                        <td>
                            <a href="javascript:void(0);"
                                onclick="confirmToggleStatus('<?php echo $row['username']?>', <?php echo $row['is_active'] ?>)"
                                style="text-decoration:none;color:white;float:left;padding-right:0px;margin-left:38%;">
                                <?php if ($row['is_active'] == 1): ?>
                                <i class="fas fa-toggle-on"></i>
                                <?php else: ?>
                                <i class="fas fa-toggle-off"></i>
                                <?php endif; ?>
                            </a>
                            <a href="http://localhost/webproject/list_account/delete/<?php echo $row['username'] ?>"
                                onclick=" confirmDelete('<?php echo $row['username']?>')"
                                style="text-decoration:none;color:white;float:left;padding-left:0px;padding-right:0px;"><i
                                    class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="table-footer">
                <select name="kieuTimKhachHang">
                    <option value="ten"
                        <?php echo (isset($_POST['kieuTimKhachHang']) && $_POST['kieuTimKhachHang'] == 'ten') ? 'selected' : ''; ?>>
                        Tìm theo họ tên</option>
                    <option value="email"
                        <?php echo (isset($_POST['kieuTimKhachHang']) && $_POST['kieuTimKhachHang'] == 'email') ? 'selected' : ''; ?>>
                        Tìm theo email</option>
                    <option value="taikhoan"
                        <?php echo (isset($_POST['kieuTimKhachHang']) && $_POST['kieuTimKhachHang'] == 'taikhoan') ? 'selected' : ''; ?>>
                        Tìm theo tài khoản</option>
                </select>
                <input type="text" name="txtSearch" placeholder="Tìm kiếm..."
                    value="<?php echo isset($_POST['txtSearch']) ? $_POST['txtSearch'] : ''; ?>">
                <button type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
            </div>
        </div>
    </form>

    <script>
    function confirmToggleStatus(username, currentStatus) {
        var confirmation = confirm("Bạn có chắc chắn muốn " + (currentStatus ? "tắt" : "bật") + " tài khoản này?");
        if (confirmation) {
            window.location.href = "http://localhost/webproject/list_account/toggleStatus/" + username;
        }
    }

    function confirmDelete(username) {
        if (confirm("Bạn có chắc chắn muốn xóa tài khoản này và tất cả đơn hàng liên quan tới tài khoản này không?")) {
            window.location.href = "http://localhost/webproject/list_account/delete/" + username;
        }
    }
    </script>
</body>

</html>