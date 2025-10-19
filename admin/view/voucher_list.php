<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách voucher</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/css/custom-theme.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>
        <!-- End Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php include __DIR__ . '/topbar.php'; ?>
                <!-- End Topbar -->

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Danh sách voucher</h1>

                    <a href="index.php?controller=voucher&action=add" class="btn btn-success mb-3">Thêm voucher</a>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Mã</th>
                                            <th>Giảm giá</th>
                                            <th>Loại</th>
                                            <th>Ngày bắt đầu</th>
                                            <th>Ngày kết thúc</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($vouchers)): ?>
                                        <?php foreach($vouchers as $v): ?>
                                        <tr>
                                            <td><?= $v['id'] ?></td>
                                            <td><?= htmlspecialchars($v['code']) ?></td>
                                            <td><?= number_format($v['discount'],0,',','.') ?><?= $v['type']=='percent'?'%':'₫' ?>
                                            </td>
                                            <td><?= ucfirst($v['type']) ?></td>
                                            <td><?= $v['start_date'] ?></td>
                                            <td><?= $v['end_date'] ?></td>
                                            <td><?= $v['status'] ? '<span class="text-success">Active</span>' : '<span class="text-danger">Inactive</span>' ?>
                                            </td>
                                            <td>
                                                <a href="index.php?controller=voucher&action=edit&id=<?= $v['id'] ?>"
                                                    class="btn btn-primary btn-sm">Sửa</a>
                                                <a href="index.php?controller=voucher&action=delete&id=<?= $v['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa voucher này?')">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Chưa có voucher nào</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End Main Content -->
        </div>
        <!-- End Content Wrapper -->
    </div>
    <!-- End Wrapper -->

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>