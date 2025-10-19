<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý đánh giá</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Danh sách đánh giá</h1>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Sản phẩm</th>
                                            <th>Người dùng</th>
                                            <th>Đánh giá</th>
                                            <th>Bình luận</th>
                                            <th>Ngày tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($reviews)): ?>
                                        <?php foreach($reviews as $r): ?>
                                        <tr>
                                            <td><?= $r['id'] ?></td>
                                            <td><?= $r['product_name'] ?></td>
                                            <td><?= $r['username'] ?></td>
                                            <td><?= $r['rating'] ?>/5</td>
                                            <td><?= $r['content'] ?></td>
                                            <td><?= $r['created_at'] ?></td>
                                            <td>
                                                <a href="index.php?controller=review&action=delete&id=<?= $r['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa đánh giá này?')">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center">Chưa có đánh giá nào</td>
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

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>

</html>