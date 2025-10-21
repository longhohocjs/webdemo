<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
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

    <main class="main container">
        <div class="product-detail-container">
            <div class="product-main">
                <div class="product-image">
                    <img src="../admin/assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>">
                </div>

                <div class="product-info">
                    <h2><?= htmlspecialchars($product['name']) ?></h2>

                    <div class="price">
                        <?php if (!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
                        <span class="sale"><?= number_format($product['sale_price'], 0, ',', '.') ?>₫</span>
                        <span class="original"><?= number_format($product['price'], 0, ',', '.') ?>₫</span>
                        <?php else: ?>
                        <span class="sale"><?= number_format($product['price'], 0, ',', '.') ?>₫</span>
                        <?php endif; ?>
                    </div>

                    <p class="description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    <div class="product-comments">
                        <h3>Đánh giá sản phẩm</h3>
                        <?php if ($countRating > 0): ?>
                        <?php foreach ($comments as $c): ?>
                        <div class="comment">
                            <strong><?= htmlspecialchars($c['fullname']) ?></strong>
                            <span class="rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class="fa<?= $i <= $c['rating'] ? 's' : 'r' ?> fa-star"></i>
                                <?php endfor; ?>
                            </span>
                            <p><?= htmlspecialchars($c['content']) ?></p>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                        <?php endif; ?>
                    </div>
                    <button class="btn-add" onclick="addToCart(<?= $product['id'] ?>)">Thêm vào giỏ hàng</button>
                </div>
            </div>


        </div>
        </div>

        <script>
        function addToCart(productId) {
            fetch(`index.php?controller=cart&action=add&id=${productId}`)
                .then(response => response.text())
                .then(data => {
                    // ✅ Hiển thị thông báo
                    showToast("Đã thêm sản phẩm vào giỏ hàng!");

                    // (Tùy chọn) cập nhật số lượng giỏ hàng hiển thị trên header
                    const cartCount = document.querySelector("#cart-count");
                    if (cartCount) {
                        const current = parseInt(cartCount.textContent) || 0;
                        cartCount.textContent = current + 1;
                    }
                })
                .catch(error => {
                    console.error("Lỗi thêm giỏ hàng:", error);
                });
        }

        // Hàm hiển thị thông báo gọn gàng
        function showToast(message) {
            let toast = document.createElement("div");
            toast.textContent = message;
            toast.style.position = "fixed";
            toast.style.bottom = "20px";
            toast.style.right = "20px";
            toast.style.background = "#28a745";
            toast.style.color = "#fff";
            toast.style.padding = "10px 15px";
            toast.style.borderRadius = "5px";
            toast.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
            toast.style.zIndex = "9999";
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2000);
        }
        </script>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__logo">WeoShop</div>
        <p>&copy; 2025 WeoShop. All rights reserved.</p>
    </footer>

    <script>
    function addToCart(productId) {
        fetch(`index.php?controller=cart&action=add&id=${productId}`, {
                method: 'POST'
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Đã thêm vào giỏ hàng');
                } else {
                    alert('Thêm giỏ hàng thất bại');
                }
            });
    }
    </script>
</body>

</html>