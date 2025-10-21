<?php
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
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
                <div class="col-sm-6 text-black"
                    style="margin: 90px; height: 500px; width:500px; border: 1px solid #d5d5d5ff; border-radius: 13px; box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">

                    <div class="px-5 ms-xl-4" style="margin-top: 30px;">
                        <span class="h1 fw-bold mb-0">WeoShop</span>
                    </div>

                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                        <form action="index.php?controller=admin&action=checkLogin" method="POST" style="width: 23rem;">

                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; ">Đănh nhập admin
                            </h3>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="text" name="username" placeholder="Username" required id="form2Example18"
                                    class="form-control form-control-lg" />
                                <?php if(!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>

                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" name="password" placeholder="Mật khẩu" required
                                    id=" form2Example28" class="form-control form-control-lg" />
                            </div>

                            <div class="pt-1 mb-4">
                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block"
                                    type="submit">Login</button>
                            </div>

                        </form>

                    </div>

                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="https://static.vecteezy.com/system/resources/previews/010/161/589/original/user-security-3d-illustration-png.png"
                        alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

<!-- <form method="POST">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <button type="submit">Đăng nhập</button>
    <?php if(!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
</form> -->