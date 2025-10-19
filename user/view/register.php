<!-- <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="text" name="fullname" placeholder="Fullname"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required><br>
    <button type="submit">Đăng ký</button>
    <?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form> -->

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="assets/img/filip-baotic-g2AaE9ONQyQ-unsplash.jpg" alt="Login image" class="w-100 vh-100"
                        style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-6 text-black">

                    <div class="px-5 ms-xl-4">
                        <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                        <span class="h1 fw-bold mb-0">Logo</span>
                    </div>

                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                        <form method="POST" style="width: 23rem;">

                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" name="username" placeholder="Username" required id="form2Example18"
                                    class="form-control form-control-lg" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" name="fullname" placeholder="Fullname" id="form2Example18"
                                    class="form-control form-control-lg" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" name="email" placeholder="Email" id="form2Example18"
                                    class="form-control form-control-lg" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" name="password" placeholder="Mật khẩu" required
                                    id=" form2Example28" class="form-control form-control-lg" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required
                                    id=" form2Example28" class="form-control form-control-lg" />
                            </div>

                            <div class="pt-1 mb-4">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block"
                                    type="submit">Đăng ký</button>
                            </div>
                            <p>Bạn đã có tài khoản? <a href="#!" class="link-info">Đăng nhập tại đây</a></p>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>