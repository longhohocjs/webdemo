<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($voucher) ? 'Sửa' : 'Thêm' ?> voucher</title>
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
                    <h1 class="h3 mb-4 text-gray-800"><?= isset($voucher) ? 'Sửa' : 'Thêm' ?> voucher</h1>

                    <?php if(!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label>Mã voucher</label>
                                    <input type="text" name="code" class="form-control"
                                        value="<?= $voucher['code'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Giảm giá</label>
                                    <input type="number" name="discount" class="form-control"
                                        value="<?= $voucher['discount'] ?? '' ?>" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label>Loại</label>
                                    <select name="type" class="form-control">
                                        <option value="percent"
                                            <?= isset($voucher) && $voucher['type']=='percent' ? 'selected' : '' ?>>Phần
                                            trăm (%)</option>
                                        <option value="amount"
                                            <?= isset($voucher) && $voucher['type']=='amount' ? 'selected' : '' ?>>Số
                                            tiền</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Ngày bắt đầu</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="<?= $voucher['start_date'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Ngày kết thúc</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="<?= $voucher['end_date'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Trạng thái</label>
                                    <select name="status" class="form-control">
                                        <option value="1"
                                            <?= isset($voucher) && $voucher['status']==1 ? 'selected' : '' ?>>Active
                                        </option>
                                        <option value="0"
                                            <?= isset($voucher) && $voucher['status']==0 ? 'selected' : '' ?>>Inactive
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary"><?= isset($voucher) ? 'Cập nhật' : 'Thêm' ?></button>
                                <a href="index.php?controller=voucher&action=list" class="btn btn-secondary">Hủy</a>
                            </form>
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

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>