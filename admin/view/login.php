<?php
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập Admin</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/css/custom-theme.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Đăng nhập Quản trị</h1>
                            <?php if(!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>
                        </div>
                        <form action="index.php?controller=admin&action=checkLogin" method="POST">
                            <div class="form-group mb-3">
                                <input type="text" class="form-control form-control-user" name="username"
                                    placeholder="Tên đăng nhập" required>
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" class="form-control form-control-user" name="password"
                                    placeholder="Mật khẩu" required>
                            </div>
                            <button class="btn btn-primary btn-user btn-block">Đăng nhập</button>
                        </form>
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