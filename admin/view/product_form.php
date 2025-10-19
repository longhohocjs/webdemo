<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= isset($product) ? 'Sửa' : 'Thêm' ?> sản phẩm</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="assets/css/custom-theme.css" rel="stylesheet">

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>
        <!-- End Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include __DIR__ . '/topbar.php'; ?>
                <!-- End Topbar -->

                <!-- Begin Page Content -->
                <?php if(!isset($product)) $product = []; ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800"><?= isset($product['id']) ? 'Sửa' : 'Thêm' ?> sản phẩm</h1>

                    <?php if(!empty($error)) echo "<p class='text-danger'>$error</p>"; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Tên sản phẩm</label>
                                    <input type="text" name="name" class="form-control"
                                        value="<?= $product['name'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Giá</label>
                                    <input type="number" name="price" class="form-control"
                                        value="<?= $product['price'] ?? '' ?>" step="0.01" required>
                                </div>
                                <div class="form-group">
                                    <label>Số lượng</label>
                                    <input type="number" name="quantity" class="form-control"
                                        value="<?= $product['quantity'] ?? '' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Mô tả</label>
                                    <textarea name="description"
                                        class="form-control"><?= $product['description'] ?? '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Giảm giá (₫)</label>
                                    <input type="number" name="discount"
                                        value="<?= isset($product['discount']) ? $product['discount'] : 0 ?>"
                                        class="form-control" min="0">
                                </div>
                                <div class="form-group">
                                    <label>Ảnh sản phẩm</label>
                                    <input type="file" name="image" class="form-control">
                                    <?php if(!empty($product['image'])): ?>
                                    <img src="../assets/images/products/<?= $product['image'] ?>" width="100"
                                        class="mt-2">
                                    <?php endif; ?>
                                </div>
                                <button
                                    class="btn btn-primary"><?= isset($product['id']) ? 'Cập nhật' : 'Thêm' ?></button>
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
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sb-admin-2.min.js"></script>
</body>

</html>