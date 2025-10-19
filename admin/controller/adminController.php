<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../model/Admin.php';

class AdminController {

    public function login() {
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);
        include __DIR__ . '/../view/login.php';
    }

    public function checkLogin() {
        global $conn;
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $adminModel = new Admin($conn);
        $admin = $adminModel->login($username, $password);

        if ($admin) {
            $_SESSION['admin'] = $admin;
            header("Location: index.php?controller=admin&action=dashboard");
            exit;
        } else {
            $_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu!";
            header("Location: index.php?controller=admin&action=login");
            exit;
        }
    }

    

    public function dashboard() {
        global $conn;
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?controller=admin&action=login");
            exit;
        }
        // Tổng số người dùng
        $result = $conn->query("SELECT COUNT(*) as total FROM users");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $tong_nguoidung = $row['total'];

        // Tổng số sản phẩm
        $result = $conn->query("SELECT COUNT(*) as total FROM products");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $tong_sanpham = $row['total'];

        //Tổng số đơn hàng
        $result = $conn->query("SELECT COUNT(*) as total FROM orders");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $tong_donhang = $row['total'];
        
        $result = $conn->query("SELECT COUNT(*) as total FROM comments");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $tong_danhgia = $row['total'];

        include __DIR__ . '/../view/dashboard.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=admin&action=login");
        exit;
    }
}
?>