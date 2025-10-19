<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/css/custom-theme.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include __DIR__ . '/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include __DIR__ . '/topbar.php'; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Danh sách đơn hàng</h1>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Người đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($orders)): ?>
                                        <?php foreach($orders as $o): ?>
                                        <pre><?php print_r($orders); ?></pre>
                                        <tr>
                                            <td><?= $o['id'] ?></td>
                                            <td><?= htmlspecialchars($o['fullname']) ?></td>
                                            <td><?= number_format($o['total_price'],0,',','.') ?>₫</td>
                                            <td><?= ucfirst($o['status']) ?></td>
                                            <td><?= $o['created_at'] ?></td>
                                            <td>
                                                <form method="POST"
                                                    action="index.php?controller=order&action=updateStatus&id=<?= $o['id'] ?>">
                                                    <select name="status" class="form-control form-control-sm mb-1">
                                                        <option value="pending"
                                                            <?= $o['status']=='pending'?'selected':'' ?>>Chờ xác nhận
                                                        </option>
                                                        <option value="confirmed"
                                                            <?= $o['status']=='confirmed'?'selected':'' ?>>Xác nhận đơn
                                                        </option>
                                                        <option value="shipping"
                                                            <?= $o['status']=='shipping'?'selected':'' ?>>Đang giao
                                                        </option>
                                                        <option value="delivered"
                                                            <?= $o['status']=='delivered'?'selected':'' ?>>Đã giao
                                                        </option>
                                                        <option value="success"
                                                            <?= $o['status']=='success'?'selected':'' ?>>Thành công
                                                        </option>
                                                    </select>
                                                    <button class="btn btn-primary btn-sm btn-block">Cập nhật</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>