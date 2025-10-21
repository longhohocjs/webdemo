<?php
// Mock dữ liệu đơn vị vận chuyển
$donViVanChuyen = [
    ['id' => 1, 'ten' => 'Giao Hàng Nhanh', 'phi' => 30000, 'thoigian' => '1-2 ngày'],
    ['id' => 2, 'ten' => 'Giao Hàng Tiết Kiệm', 'phi' => 20000, 'thoigian' => '2-4 ngày'],
    ['id' => 3, 'ten' => 'Viettel Post', 'phi' => 25000, 'thoigian' => '2-3 ngày']
];
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán</title>
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
        <div class="header__logo"><a href="/webbanhangdemo/user/index.php">WeoShop</a></div>
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
    <!-- cart -->
    <main class="main container">
        <div class="cart shopee-cart">
            <h1>Thanh toán</h1>
            <?php if(!empty($cartItems)): ?>
            <form id="cart-form" method="POST" action="index.php?controller=cart&action=update" class="cart-form">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
            $total = 0;
            foreach($cartItems as $item): 
              $price = isset($item['sale_price']) && $item['sale_price'] > 0 
                ? $item['sale_price'] 
                : $item['price'];

              $quantity = $item['quantity'] ?? 1;
              $subtotal = $price * $quantity;
              $total += $subtotal;
          ?>
                        <tr>
                            <td class="product-info">
                                <img src="../admin/assets/images/products/<?= htmlspecialchars($item['image'] ?? 'default.png') ?>"
                                    alt="">
                                <div class="product-name"><?= htmlspecialchars($item['name'] ?? '') ?></div>
                            </td>
                            <td><?= number_format($price,0,',','.') ?>₫</td>
                            <td>
                                <input type="number" name="quantity[<?= $item['product_id'] ?? 0 ?>]"
                                    value="<?= $quantity ?>" min="1" class="qty-input">
                            </td>
                            <td><a href="index.php?controller=cart&action=remove&id=<?= $item['product_id'] ?? 0 ?>"
                                    class="btn-delete">Xóa</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-voucher">
                    <label for="voucher-input">Mã giảm giá:</label>
                    <input type="text" id="voucher-input" placeholder="Nhập mã voucher"
                        value="<?= htmlspecialchars($appliedVoucher ?? '') ?>">
                    <button type="button" id="apply-voucher-btn" class="btn btn-apply">Áp dụng</button>
                </div>
            </form>
            <div class="cart-shipping mt-3">
                <label for="shipping-select"><strong>Chọn đơn vị vận chuyển:</strong></label>
                <select id="shipping-select" class="form-select">
                    <?php foreach($donViVanChuyen as $dv): ?>
                    <option value="<?= $dv['id'] ?>" data-phi="<?= $dv['phi'] ?>">
                        <?= $dv['ten'] ?> - <?= number_format($dv['phi']) ?>₫ (<?= $dv['thoigian'] ?>)
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="cart-shipping-fee mt-2">
                Phí vận chuyển: <span id="shipping-fee">0</span>₫
            </div>
            <div class="cart-grand-total mt-2">
                Tổng thanh toán: <span id="grand-total"><?= number_format($total) ?></span>₫
            </div>


            <!-- Thanh tổng tiền cố định -->
            <div class="cart-footer">
                <div class="cart-total">
                    Tổng tiền: <span class="total-amount"
                        id="total-amount"><?= number_format($total ?? 0,0,',','.') ?></span>₫

                </div>
                <div class="cart-buttons">
                    <button type="submit" form="cart-form" class="btn btn-update">Cập nhật</button>
                    <button type="button" onclick="window.location='index.php?controller=cart&action=placeOrder'"
                        class="btn btn-checkout">Thanh toán</button>

                </div>
            </div>

            <?php else: ?>
            <p class="cart-empty">Giỏ hàng trống.</p>
            <?php endif; ?>
        </div>
    </main>
    <!-- Footer -->
    <footer class="footer">
        <div class="footer__logo">WeoShop</div>
        <p>&copy; 2025 WeoShop. All rights reserved.</p>
    </footer>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
    document.getElementById('apply-voucher-btn').addEventListener('click', function() {
        const code = document.getElementById('voucher-input').value.trim();

        if (!code) {
            alert('Vui lòng nhập mã voucher');
            return;
        }

        fetch(`index.php?controller=cart&action=applyVoucher`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `voucher=${encodeURIComponent(code)}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('total-amount').textContent = data.total.toLocaleString();
                    alert('Voucher áp dụng thành công!');
                } else {
                    alert('Voucher không hợp lệ hoặc hết hạn.');
                }
            })
            .catch(err => console.error(err));
    });
    document.querySelector('.btn-update').addEventListener('click', function(e) {
        e.preventDefault();

        const form = document.getElementById('cart-form');
        const formData = new FormData(form);

        fetch('index.php?controller=cart&action=update', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    //  Cập nhật tổng tiền hiển thị
                    document.getElementById('total-amount').textContent = data.total_formatted;

                    //  Hiển thị thông báo nhẹ
                    showToast("Thanh toán đã được cập nhật!");
                }
            })
            .catch(err => console.error('Lỗi cập nhật giỏ hàng:', err));
    });

    function showToast(msg) {
        const toast = document.createElement('div');
        toast.textContent = msg;
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = '#28a745';
        toast.style.color = '#fff';
        toast.style.padding = '10px 15px';
        toast.style.borderRadius = '6px';
        toast.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
        toast.style.zIndex = 1000;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    }

    const shippingSelect = document.getElementById('shipping-select');
    const shippingFeeEl = document.getElementById('shipping-fee');
    const grandTotalEl = document.getElementById('grand-total');
    const totalAmountEl = document.getElementById('total-amount'); // Tổng tiền giỏ hàng hiển thị
    const cartTotal = <?= $total ?>;

    // Hàm cập nhật phí vận chuyển và tổng tiền
    function capNhatVanChuyen() {
        const phi = parseInt(shippingSelect.options[shippingSelect.selectedIndex].dataset.phi);

        // Cập nhật phí vận chuyển
        shippingFeeEl.textContent = phi.toLocaleString();

        // Tổng thanh toán = tiền giỏ hàng + phí vận chuyển
        const grandTotal = cartTotal + phi;
        grandTotalEl.textContent = grandTotal.toLocaleString();

        // Đồng bộ luôn tổng tiền giỏ hàng ở phần cart-footer
        totalAmountEl.textContent = grandTotal.toLocaleString();
    }

    // Khi chọn đơn vị vận chuyển
    shippingSelect.addEventListener('change', capNhatVanChuyen);

    // Khởi tạo lần đầu
    capNhatVanChuyen();
    </script>
</body>

</html>