<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/css/custom-theme.css" rel="stylesheet">

    <style>
    .preview-img {
        width: 80px;
        height: auto;
        object-fit: cover;
        border-radius: 4px;
    }
    </style>
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
                    <h1 class="h3 mb-4 text-gray-800">Danh sách sản phẩm</h1>

                    <a href="index.php?controller=product&action=add" class="btn btn-success mb-3">Thêm sản phẩm</a>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Ảnh</th>
                                            <th>Tên</th>
                                            <th>Giá</th>
                                            <th>Giảm giá</th>
                                            <th>Số lượng</th>
                                            <th>Mô tả</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($products)): ?>
                                        <?php foreach($products as $p): ?>
                                        <tr>
                                            <td><?= $p['id'] ?></td>
                                            <td>
                                                <?php if(!empty($p['image'])): ?>
                                                <img src="../assets/images/products/<?= $p['image'] ?>"
                                                    class="preview-img">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $p['name'] ?></td>
                                            <td><?= number_format($p['price'],0,',','.') ?>₫</td>
                                            <td><?= number_format($p['sale_price'],0,',','.') ?>₫</td>
                                            <td><?= $p['quantity'] ?></td>
                                            <td><?= $p['description'] ?></td>
                                            <td>
                                                <a href="index.php?controller=product&action=edit&id=<?= $p['id'] ?>"
                                                    class="btn btn-primary btn-sm">Sửa</a>
                                                <a href="index.php?controller=product&action=delete&id=<?= $p['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Chưa có sản phẩm nào</td>
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

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>