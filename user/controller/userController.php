<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../../config/database.php';

class UserController {
    private $userModel;
    private $productModel;

    public function __construct(){
        global $conn;
        $this->userModel = new User($conn);
        $this->productModel = new Product($conn);
    }

    // Đăng ký
    public function register(){
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email    = $_POST['email'] ?? '';

            if($password !== $confirm){
                $error = "Mật khẩu không khớp";
            } elseif($this->userModel->getByUsername($username)){
                $error = "Username đã tồn tại";
            } else {
                $this->userModel->create($username, $password, $fullname, $email);
                $_SESSION['user'] = $this->userModel->getByUsername($username);
                header("Location: index.php");
                exit;
            }
        }
        include __DIR__ . '/../view/register.php';
    }

    // Đăng nhập
    public function login(){
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->verifyLogin($username, $password);
            if($user){
                $_SESSION['user'] = $user;
                header("Location: index.php");
                exit;
            } else {
                $error = "Username hoặc mật khẩu không đúng";
            }
        }
        include __DIR__ . '/../view/login.php';
    }

    

    // Đăng xuất
    public function logout(){
        session_destroy();
        header("Location: index.php");
        exit;
    }

    // Trang home, có thể hiển thị tất cả sản phẩm hoặc tìm kiếm
    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        if($keyword) {
            $products = $this->productModel->search($keyword);
        } else {
            $products = $this->productModel->getAll();
        }
        $saleProducts = $this->productModel->getOnSale();
        $latestProducts = $this->productModel->getLatest(12);
        include __DIR__ . '/../view/home.php';
    }
}