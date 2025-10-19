<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Danh sách người dùng</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Danh sách người dùng</h1>
                    <a href="index.php?controller=user&action=add" class="btn btn-success mb-3">Thêm người dùng</a>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên đăng nhập</th>
                                            <th>Họ tên</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($users)): ?>
                                        <?php foreach($users as $u): ?>
                                        <tr>
                                            <td><?= $u['id'] ?></td>
                                            <td><?= $u['username'] ?></td>
                                            <td><?= $u['fullname'] ?></td>
                                            <td><?= $u['email'] ?></td>
                                            <td><?= $u['role'] ?></td>
                                            <td>
                                                <a href="index.php?controller=user&action=edit&id=<?= $u['id'] ?>"
                                                    class="btn btn-primary btn-sm">Sửa</a>
                                                <a href="index.php?controller=user&action=delete&id=<?= $u['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Xóa người dùng này?')">Xóa</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Chưa có người dùng nào</td>
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