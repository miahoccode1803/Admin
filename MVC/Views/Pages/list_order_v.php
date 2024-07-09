<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="http://localhost/Admin/Public/Css/admin/style.css">
    <link rel="stylesheet" href="http://localhost/Admin/Public/Css/admin/progress.css">
    <style>
    .x:hover {
        color: red;
    }
    </style>
</head>

<body>

    <!-- Form tìm kiếm đơn hàng -->
    <form id="orderSearchForm" action="http://localhost/Admin/list_order/find" method="POST">
        <div class="donhang">
            <table class="table-header">
                <thead>
                    <tr>
                        <th title="Sắp xếp" style="width: 5%">Stt <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 10%">Mã đơn hàng <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 15%">Tên khách hàng <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 15%">Ngày đặt hàng <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 10%">Trạng thái <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 25%">Sản phẩm <i class="fa fa-sort"></i></th>
                        <th title="Sắp xếp" style="width: 10%">Tổng tiền <i class="fa fa-sort"></i></th>
                        <th style="width: 10%">Hành động</th> <!-- Thêm cột hành động -->
                    </tr>
                </thead>
                <tbody class="table-content">
                    <?php
                    if (isset($data['dulieu']) && !empty($data['dulieu'])) {
                        $i = 0;
                        foreach ($data['dulieu'] as $row) {
                    ?>
                    <tr>
                        <td><?php echo ++$i ?></td>
                        <td><?php echo $row['order_id'] ?></td>
                        <td><?php echo $row['customer_name'] ?></td>
                        <td><?php echo $row['order_date'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td><?php echo $row['products'] ?></td>
                        <td><?php echo $row['total'] ?></td>
                        <td>
                            <!-- Dấu tích để thay đổi trạng thái đơn hàng -->
                            <a href="http://localhost/Admin/list_order/change_status/<?php echo $row['order_id'] ?>"
                                style=" text-decoration:none;color:white;float:left;padding-left:30px;padding-right:0px;"><i
                                    class="fa fa-check"></i></a>
                            <!-- Dấu X để xóa đơn hàng -->
                            <a href="http://localhost/Admin/list_order/cancel_order/<?php echo $row['order_id'] ?>"
                                style=" text-decoration:none;color:white;float:left;padding-left:0px;padding-right:0px;"
                                class="x"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <div class="timTheoNgay">
                Từ ngày: <input type="date" id="fromDate" name="fromDate"
                    value="<?php echo isset($_POST['fromDate']) ? $_POST['fromDate'] : '' ?>">
                Đến ngày: <input type="date" id="toDate" name="toDate"
                    value="<?php echo isset($_POST['toDate']) ? $_POST['toDate'] : '' ?>">
                <button type="button" onclick="locDonHangTheoKhoangNgay()"><i class="fa fa-search"></i> Tìm</button>
            </div>

            <select name="kieuTimDonHang">
                <option value="order_id"
                    <?php echo isset($_POST['kieuTimDonHang']) && $_POST['kieuTimDonHang'] == 'order_id' ? 'selected' : '' ?>>
                    Tìm theo mã đơn</option>
                <option value="customer_name"
                    <?php echo isset($_POST['kieuTimDonHang']) && $_POST['kieuTimDonHang'] == 'customer_name' ? 'selected' : '' ?>>
                    Tìm theo tên khách hàng</option>
                <option value="status"
                    <?php echo isset($_POST['kieuTimDonHang']) && $_POST['kieuTimDonHang'] == 'status' ? 'selected' : '' ?>>
                    Tìm theo trạng thái</option>
            </select>
            <input type="text" placeholder="Tìm kiếm..." name="txtSearch"
                value="<?php echo isset($_POST['txtSearch']) ? $_POST['txtSearch'] : '' ?>">
            <button type="submit"><i class="fa fa-search"></i> Tìm kiếm</button>
        </div>
    </form>

    <script>
    function locDonHangTheoKhoangNgay() {
        document.getElementById('orderSearchForm').submit();
    }

    function timKiemDonHang(input) {
        document.getElementById('orderSearchForm').submit();
    }
    </script>
</body>

</html>