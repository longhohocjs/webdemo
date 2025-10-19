<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title><?= isset($user) ? 'Sửa' : 'Thêm' ?> người dùng</title>
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
                    <h1 class="h3 mb-4 text-gray-800"><?= isset($user) ? 'Sửa' : 'Thêm' ?> người dùng</h1>
                    <?php if(!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label>Tên đăng nhập</label>
                                    <input type="text" name="username" class="form-control"
                                        value="<?= $user['username'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Mật khẩu <?= isset($user) ? '(để trống nếu không đổi)' : '' ?></label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Họ tên</label>
                                    <input type="text" name="fullname" class="form-control"
                                        value="<?= $user['fullname'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?= $user['email'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control">
                                        <option value="user"
                                            <?= isset($user['role']) && $user['role']=='user' ? 'selected' : '' ?>>User
                                        </option>
                                        <option value="admin"
                                            <?= isset($user['role']) && $user['role']=='admin' ? 'selected' : '' ?>>
                                            Admin</option>
                                    </select>
                                </div>
                                <button class="btn btn-primary"><?= isset($user) ? 'Cập nhật' : 'Thêm' ?></button>
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

    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="..