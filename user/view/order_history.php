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
        <h2 class="order-history-title">Lịch sử mua hàng</h2>

        <div class="order-history">
            <?php foreach($ordersWithItems as $o): ?>
            <?php $order = $o['order']; $items = $o['items']; ?>
            <div class="order-card">
                <div class="order-header">
                    <span class="order-id">Đơn hàng #<?= $order['id'] ?></span>
                    <span class="order-status <?= $order['status'] ?>"><?= ucfirst($order['status']) ?></span>
                    <span class="order-date"><?= $order['created_at'] ?></span>
                </div>

                <?php foreach($items as $item): ?>
                <?php 
                $price = $item['sale_price'] > 0 ? $item['sale_price'] : $item['price']; 
                $comments = $this->commentModel->getByProduct($item['product_id']);
                ?>
                <div class="order-item">
                    <img src="../admin/assets/images/products/<?= $item['image'] ?>" alt="<?= $item['name'] ?>"
                        class="order-img">
                    <div class="order-info">
                        <h4><?= htmlspecialchars($item['name']) ?></h4>
                        <p class="order-qty">Số lượng: <?= $item['quantity'] ?></p>
                        <p class="order-price"><?= number_format($price,0,',','.') ?>₫</p>

                        <!-- Nếu đã có đánh giá -->
                        <?php if(!empty($comments)): ?>
                        <div class="user-review">
                            <strong>Đánh giá của bạn:</strong><br>
                            <?php foreach($comments as $c): ?>
                            <div class="review-block">
                                <div class="review-stars">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                    <span class="star <?= $i <= $c['rating'] ? 'filled' : '' ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <div class="review-content">
                                    <?= htmlspecialchars($c['content']) ?>
                                </div>
                                <div class="review-meta">
                                    - <?= htmlspecialchars($c['fullname']) ?>, <?= $c['created_at'] ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php elseif($order['status'] === 'delivered'): ?>
                        <!-- Nếu chưa đánh giá -->

                        <?php endif; ?>


                    </div>

                    <div class="order-actions">
                        <a href="index.php?controller=product&action=detail&id=<?= $item['product_id'] ?>"
                            class="btn-detail">Xem sản phẩm</a>
                        <!-- Chỉ hiển thị nút đánh giá khi trang trạng thái đơn hàng đã giao và thành công-->
                        <?php if($order['status'] === 'delivered' || $order['status'] === 'Success'): ?>
                        <button class="btn-rate" onclick="openRatingModal(<?= $item['product_id'] ?>)">Đánh giá</button>
                        <?php endif; ?>
                        <a href="index.php?controller=order&action=detail&id=<?= $order['id'] ?>"
                            class="detail-order__btn">
                            Xem chi tiết đơn hàng
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

        </div>

        <!-- Modal đánh giá -->
        <div id="ratingModal" class="rating-modal">
            <div class="modal-content">
                <span class="close" onclick="closeRatingModal()">&times;</span>
                <h3>Đánh giá sản phẩm</h3>
                <form method="POST" action="index.php?controller=order&action=comment">
                    <input type="hidden" name="product_id" id="product_id">
                    <textarea name="content" placeholder="Chia sẻ cảm nhận của bạn..." required></textarea>

                    <div class="stars">
                        <?php for($i=5;$i>=1;$i--): ?>
                        <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>" required>
                        <label for="star<?= $i ?>">★</label>
                        <?php endfor; ?>
                    </div>

                    <button type="submit" class="btn-submit">Gửi đánh giá</button>
                </form>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__logo">MyShop</div>
        <p>&copy; 2025 MyShop. All rights reserved.</p>
    </footer>

    <script>
    function openRatingModal(productId) {
        const modal = document.getElementById('ratingModal');
        modal.style.display = 'block';
        document.getElementById('product_id').value = productId;
        document.body.style.overflow = 'hidden';
    }

    function closeRatingModal() {
        const modal = document.getElementById('ratingModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('ratingModal');
        if (event.target == modal) closeRatingModal();
    }
    </script>
</body>

</html>