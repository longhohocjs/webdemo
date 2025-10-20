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
    <link rel="stylesheet" href="assets/css/custom-theme.css?v=<?= time() ?>">

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
        <div class="container checkout-container">
            <h2>Thanh toán</h2>

            <!-- Giỏ hàng -->
            <table class="table checkout-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td>
                            <img src="../admin/assets/images/products/<?= htmlspecialchars($item['image'] ?? 'default.png') ?>"
                                alt="">
                        </td>
                        <td><?= number_format($item['price']) ?>₫</td>
                        <td>
                        <td><?= $item['quantity'] ?></td>
                        <td class="item-total"><?= number_format($item['price'] * $item['quantity']) ?>₫</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Địa chỉ giao hàng -->
            <div class="mt-4">
                <h5>Địa chỉ giao hàng</h5>
                <input type="text" class="form-control mb-2" placeholder="Họ tên người nhận"
                    value="<?= $_SESSION['user']['name'] ?? '' ?>">
                <input type="text" class="form-control mb-2" placeholder="Số điện thoại">
                <input type="text" class="form-control" placeholder="Địa chỉ">
            </div>

            <!-- Phương thức thanh toán -->
            <div class="mt-4">
                <h5>Phương thức thanh toán</h5>
                <select class="form-select" id="payment-method">
                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                    <option value="vnpay">VNPay</option>
                    <option value="momo">Momo</option>
                </select>
            </div>

            <!-- Tổng tiền & nút đặt hàng -->
            <div class="summary mt-4">
                <h5>Thông tin đơn hàng</h5>
                <p>Tạm tính: <span id="subtotal"><?= number_format($total) ?>₫</span></p>
                <p>Phí vận chuyển: <span id="shipping"><?= number_format($shippingFee) ?>₫</span></p>
                <p>Giảm giá: <span id="discount"><?= number_format($discount) ?>₫</span></p>
                <p class="total">Tổng cộng: <span id="finalTotal"><?= number_format($total) ?>₫</span></p>
                <button id="placeOrder" class="btn btn-primary w-100">Đặt hàng</button>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer__logo">MyShop</div>
        <p>&copy; 2025 MyShop. All rights reserved.</p>
    </footer>
</body>

</html>