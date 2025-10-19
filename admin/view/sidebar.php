<?php
if(!isset($_SESSION['admin'])) {
    header("Location: index.php?controller=admin&action=login");
    exit;
}
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Brand / Logo -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="index.php?controller=admin&action=dashboard">
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=admin&action=dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Quản lý sản phẩm -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=product&action=list">
            <i class="fas fa-box"></i>
            <span>Quản lý sản phẩm</span>
        </a>
    </li>

    <!-- Quản lý người dùng (tùy chọn) -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=user&action=list">
            <i class="fas fa-users"></i>
            <span>Quản lý người dùng</span>
        </a>
    </li>

    <!-- Quản lý đơn hàng -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=order&action=list">
            <i class="fas fa-shopping-cart"></i>
            <span>Quản lý đơn hàng</span>
        </a>
    </li>

    <!-- Menu quản lý đánh giá -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=review&action=list">
            <i class="fas fa-star"></i>
            <span>Quản lý đánh giá</span>
        </a>
    </li>

    <!-- Menu quản lý voucher -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=voucher&action=list">
            <i class="fas fa-ticket-alt"></i>
            <span>Quản lý voucher</span>
        </a>
    </li>

    <!-- Menu quản lý Doanh thu-->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=revenue&action=index">
            <i class="fas fa-dollar-sign"></i>
            <span>Doanh thu</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="index.php?controller=admin&action=logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Đăng xuất</span>
        </a>
    </li>

</ul>