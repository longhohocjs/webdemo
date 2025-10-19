<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>
    <!-- Reset CSS -->
    <link rel="stylesheet" href="assets/css/reset.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <!-- Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/custom-theme.css">

</head>

<body>

    <!-- Header -->
    <header class="header d-flex align-items-center">
        <div class="header__logo"><a href="/webbanhangdemo/user/index.php">MyShop</a></div>
        <form class="header__search" method="GET" action="index.php">
            <input class="header__search--keyword" type="text" name="keyword" placeholder="Nhập sản phẩm cần tìm..."
                value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">

            <button class="header__search--icon" type="submit"><i class="fa-solid fa-magnifying-glass "></i></button>
        </form>
        <a href="index.php?controller=order&action=history" class="header__history-order"><i
                class="fa-solid fa-clock-rotate-left"></i>Lịch sử đơn hàng</a>
        <?php if(isset($order)): ?>
        <a href="index.php?controller=order&action=detail&id=<?= $order['id'] ?>" class="header__detail-order">
            Xem chi tiết
        </a>
        <?php endif; ?>

        <div class="header__user">

            <div class="header__user--action">
                <?php if(isset($_SESSION['user'])): ?>
                <span>Xin chào,
                    <?= htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']) ?></span>
                <a href="index.php?controller=user&action=logout" class="btn header__btn--logout">Đăng xuất</a>
                <button onclick="window.location='index.php?controller=cart&action=view'" class="header__cart"><i
                        class="fa-solid fa-cart-shopping"></i></button>
                <?php else: ?>
                <a href="index.php?controller=user&action=login" class="btn header__btn--login ">Đăng nhập</a>
                <a href="index.php?controller=user&action=register" class="btn header__btn--register">Đăng ký</a>
                <button onclick="window.location='index.php?controller=cart&action=view'" class="header__cart"><i
                        class="fa-solid fa-cart-shopping"></i></button>
                <?php endif; ?>
            </div>

        </div>

    </header>



    <main class="main container">
        <div class="order-detail">
            <h2>Chi tiết đơn hàng #<?= htmlspecialchars($order_id) ?></h2>

            <table>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php 
    $total = 0; 
    foreach($orderItems as $item):
        $price = isset($item['sale_price']) && $item['sale_price'] > 0 
                ? $item['sale_price'] 
                : $item['price'];
        $subtotal = $price * $item['quantity'];
        $total += $subtotal;
    ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><img src="../admin/assets/images/products/<?= $item['image'] ?>" alt=""></td>
                    <td><?= number_format($price,0,',','.') ?>₫</td>
                    <td><?= $item['quantity'] ?></td>
                    <td><strong><?= number_format($subtotal,0,',','.') ?>₫</strong></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <div class="order-total">
                Tổng tiền: <span style="color:#ee4d2d;"><?= number_format($total,0,',','.') ?>₫</span>
            </div>

            <div class="order-status">
                <strong>Trạng thái:</strong> <?= ucfirst($orderStatus ?? 'Đang xử lý') ?>
            </div>

            <a href="index.php?controller=order&action=history" class="back-btn">
                ← Quay lại lịch sử đơn hàng
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__logo">MyShop</div>
        <p>&copy; 2025 MyShop. All rights reserved.</p>
    </footer>



</body>

</html>