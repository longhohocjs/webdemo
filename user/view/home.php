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
        <!-- Slidebar brand Swiper -->
        <div class="swiper brand-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img
                        src="https://www.stratfordcross.co.uk/globalassets/uk/stratford-cross/eat-drink-shop-play/logos/amenity_logos_apple.jpg?width=300&height=400&upscale=false&mode=max&quality=80"
                        alt="Apple"></div>
                <div class="swiper-slide"><img
                        src="https://tse3.mm.bing.net/th/id/OIP.miOzKusrECh171mYa76z0wHaHa?cb=12ucfimg=1&rs=1&pid=ImgDetMain&o=7&rm=3"
                        alt="Samsung">
                </div>
                <div class="swiper-slide"><img
                        src="data:image/webp;base64,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"
                        alt="Huawei"></div>
                <div class="swiper-slide"><img
                        src="https://thvnext.bing.com/th/id/OIP.WDCA7Kb0fB7hseUfrYsJqgHaEK?w=264&h=150&c=6&o=7&cb=12&dpr=1.1&pid=1.7&rm=3&ucfimg=1"
                        alt="Xiaomi"></div>
                <div class="swiper-slide"><img
                        src="https://tse4.mm.bing.net/th/id/OIP.D0RG3gmr4ZWsvCJnmr6CPwHaEK?cb=12&pid=ImgDet&ucfimg=1&w=206&h=116&c=7&dpr=1.1&o=7&rm=3"
                        alt="Oppo"></div>
                <div class="swiper-slide"><img
                        src="https://i0.wp.com/hirumobile.lk/wp-content/uploads/2021/01/Vivo-Logo.jpg" alt="Vivo"></div>
            </div>
        </div>
        <!-- Slidebar banner Swiper -->
        <div class="slide-bard">
            <div class="slide-media">
                <img src="assets/img/silivan-munguarakarama-Hing5iQTUnM-unsplash.jpg" alt=""
                    class="slide-bard__img--bottom">
                <img src="assets/img/anh-nhat-uCqMa_s-JDg-unsplash.jpg" alt="" class="slide-bard__img--top">
            </div>
            <div class="swiper banner-swiper">
                <div class="swiper-wrapper slide__right">
                    <div class="swiper-slide">
                        <img src="assets/img/pexels-quibler7-25839643.jpg" alt="Apple">
                    </div>
                    <div class="swiper-slide">
                        <img src="assets/img/pexels-peter-parker-172082580-30614624.jpg" alt="Samsung">
                    </div>
                    <div class="swiper-slide">
                        <img src="assets/img/pexels-readymade-4032364.jpg" alt="Huawei">
                    </div>
                </div>
            </div>

        </div>

        <!-- Sản phẩm sale -->
        <div class="product-sale">
            <?php if(!empty($saleProducts)): ?>
            <div class="section-title">Sản phẩm giảm giá</div>
            <div class="product-list">
                <?php foreach($saleProducts as $p): ?>
                <div class="product-item">
                    <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>">
                        <img src="../admin/assets/images/products/<?= $p['image'] ?>"
                            alt="<?= htmlspecialchars($p['name']) ?>">
                    </a>
                    <div class="product-item__title"><?= htmlspecialchars($p['name']) ?></div>
                    <div class="product-item__price">
                        <del><?= number_format($p['price'],0,',','.') ?>₫</del>
                        <strong><?= number_format($p['sale_price'],0,',','.') ?>₫</strong>
                    </div>
                    <div class="product-rating">
                        <?php if ($p['avg_rating'] > 0): ?>
                        <span class="stars">⭐ <?= $p['avg_rating'] ?></span>
                        <span class="reviews">(<?= $p['total_comments'] ?> đánh giá)</span>
                        <?php else: ?>
                        <span class="no-rating text-muted">Chưa có đánh giá</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-item__buttons">
                        <button class="btn btn-sm btn-success" onclick="addToCart(<?= $p['id'] ?>)">Thêm vào
                            giỏ</button>
                        <button class="btn btn-sm btn-primary" onclick="buyNow(<?= $p['id'] ?>)">Mua ngay</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sản phẩm mới nhất -->
        <div class="product-new">
            <?php if(!empty($latestProducts)): ?>
            <div class="section-title">Sản phẩm mới nhất</div>
            <div class="product-list">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php foreach($latestProducts as $p): ?>
                        <div class="swiper-slide">
                            <div class="product-item">
                                <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>">
                                    <img src="../admin/assets/images/products/<?= $p['image'] ?>"
                                        alt="<?= htmlspecialchars($p['name']) ?>">
                                </a>
                                <div class="product-item__info">
                                    <div class="product-item__title"><?= htmlspecialchars($p['name']) ?></div>
                                    <div class="product-item__price">
                                        <?= number_format($p['price'],0,',','.') ?>₫
                                    </div>
                                    <div class="product-rating">
                                        <?php if ($p['avg_rating'] > 0): ?>
                                        <span class="stars">⭐ <?= $p['avg_rating'] ?></span>
                                        <span class="reviews">(<?= $p['total_comments'] ?> đánh giá)</span>
                                        <?php else: ?>
                                        <span class="no-rating text-muted">Chưa có đánh giá</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-item__buttons">
                                        <button class="btn  btn-success" onclick="addToCart(<?= $p['id'] ?>)">Thêm vào
                                            giỏ</button>
                                        <button class="btn  btn-primary" onclick="buyNow(<?= $p['id'] ?>)">Mua
                                            ngay</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Tất cả sản phẩm -->
        <div class="product-all">
            <div class="section-title">Tất cả sản phẩm</div>
            <div class="product-list">
                <?php foreach($products as $p): ?>
                <div class="product-item">
                    <a href="index.php?controller=product&action=detail&id=<?= $p['id'] ?>">
                        <img src="../admin/assets/images/products/<?= $p['image'] ?>"
                            alt="<?= htmlspecialchars($p['name']) ?>">
                    </a>
                    <div class="product-item__title"><?= htmlspecialchars($p['name']) ?></div>
                    <div class="product-item__price">
                        <?= number_format($p['price'],0,',','.') ?>₫
                    </div>
                    <div class="product-rating">
                        <?php if ($p['avg_rating'] > 0): ?>
                        <span class="stars">⭐ <?= $p['avg_rating'] ?></span>
                        <span class="reviews">(<?= $p['total_comments'] ?> đánh giá)</span>
                        <?php else: ?>
                        <span class="no-rating text-muted">Chưa có đánh giá</span>
                        <?php endif; ?>
                    </div>
                    <div class="product-item__buttons">
                        <button class="btn btn-sm btn-success" onclick="addToCart(<?= $p['id'] ?>)">Thêm vào
                            giỏ</button>
                        <button class="btn btn-sm btn-primary" onclick="buyNow(<?= $p['id'] ?>)">Mua ngay</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Slide nhà vận chuyển -->
        <div class="swiper shipping-swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img
                        src="https://viettelpost.com.vn/wp-content/uploads/2022/03/Group-5934.png" alt="Viettel"></div>
                <div class="swiper-slide"><img
                        src="ahttps://theme.hstatic.net/200000472237/1001083717/14/logo.png?v=880" alt="GHN"></div>
                <div class="swiper-slide"><img src="https://ghtk.vn/assets/logo.svg" alt="GHTK"></div>
                <div class="swiper-slide"><img src="https://jtexpress.vn/themes/jtexpress/assets/images/logo.png"
                        alt="J&T"></div>
                <div class="swiper-slide"><img
                        src="https://chuyenphat.buudien.vn/wp-content/uploads/2024/06/483838000031439637.png"
                        alt="VNPost"></div>
                <div class="swiper-slide"><img src="https://www.fedex.com/content/dam/fedex-com/logos/logo.png"
                        alt="FedEx"></div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer__logo">MyShop</div>
        <p>&copy; 2025 MyShop. All rights reserved.</p>
    </footer>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        slidesPerGroup: 4,
        loop: true,
        loopFillGroupWithBlank: true,
        speed: 12000,
        autoplay: {
            delay: 0,
            disableOnInteraction: false,
        },
        allowTouchMove: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            1200: {
                slidesPerView: 4
            },
            992: {
                slidesPerView: 3
            },
            768: {
                slidesPerView: 2
            },
            576: {
                slidesPerView: 1
            }
        }
    });

    // --- Khi hover: làm chậm lại ---
    const swiperEl = document.querySelector(".mySwiper");
    swiperEl.addEventListener("mouseenter", () => {
        swiper.params.speed = 20000; // chạy chậm hơn (tăng thời gian trượt)
        swiper.autoplay.stop();
        swiper.autoplay.start(); // restart để áp dụng tốc độ mới
    });

    // Initialize Swiper
    const brandSwiper = new Swiper('.brand-swiper', {
        slidesPerView: 4, // số slide hiển thị
        spaceBetween: 20, // khoảng cách giữa slide
        loop: true, // lặp vô hạn
        loopedSlides: 12, // số slide clone để lặp mượt
        speed: 5000, // thời gian chuyển slide (ms), tăng để mượt hơn
        autoplay: {
            delay: 0, // thời gian giữa các slide
            disableOnInteraction: false,
            reverseDirection: true,
            pauseOnMouseEnter: false, // tạm dừng khi hover
        },
        // Thêm hiệu ứng mượt hơn nếu muốn
        effect: 'slide', // mặc định là 'slide'
        freeMode: true, // cho chuyển động tự nhiên hơn
        freeModeMomentum: true
    });

    const bannerSwiper = new Swiper('.banner-swiper', {
        slidesPerView: 1,
        loop: true,
        effect: 'fade', // 🔥 Hiệu ứng mờ dần
        fadeEffect: {
            crossFade: true, // làm ảnh cũ mờ đi song song với ảnh mới xuất hiện
        },
        speed: 1000, // thời gian chuyển giữa ảnh
        autoplay: {
            delay: 2500, // thời gian mỗi ảnh hiển thị
            disableOnInteraction: false,
        },
    });

    // Khi hover vào banner thì chạy chậm lại
    const bannerEl = document.querySelector('.banner-swiper');

    bannerEl.addEventListener('mouseenter', () => {
        bannerSwiper.params.autoplay.delay = 5000; // chậm lại khi hover
        bannerSwiper.autoplay.start();
    });

    bannerEl.addEventListener('mouseleave', () => {
        bannerSwiper.params.autoplay.delay = 2500; // trở lại bình thường
        bannerSwiper.autoplay.start();
    });



    const shippingSwiper = new Swiper('.shipping-swiper', {
        slidesPerView: 4, // số slide hiển thị
        spaceBetween: 20, // khoảng cách giữa slide
        loop: true, // lặp vô hạn
        loopedSlides: 12, // số slide clone để lặp mượt
        speed: 5000, // thời gian chuyển slide (ms), tăng để mượt hơn
        autoplay: {
            delay: 0, // thời gian giữa các slide
            disableOnInteraction: false,
            reverseDirection: true,
            pauseOnMouseEnter: false, // tạm dừng khi hover
        },
        // Thêm hiệu ứng mượt hơn nếu muốn
        effect: 'slide', // mặc định là 'slide'
        freeMode: true, // cho chuyển động tự nhiên hơn
        freeModeMomentum: true
    });

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

    function buyNow(productId) {
        fetch(`index.php?controller=cart&action=add&id=${productId}`, {
                method: 'POST'
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location = 'index.php?controller=cart&action=view';
                } else {
                    alert('Thêm giỏ hàng thất bại');
                }
            });
    }
    </script>

</body>

</html>