<?php
require_once __DIR__ . '/../model/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        global $conn;
        $this->userModel = new User($conn);

        // Chỉ admin mới vào được
        if(!isset($_SESSION['admin'])) {
            header("Location: ../admin/index.php?controller=admin&action=login");
            exit;
        }
    }

    // Danh sách người dùng
    public function list() {
        $users = $this->userModel->getAll();
        include __DIR__ . '/../view/user_list.php';
    }

    // Thêm người dùng
    public function add() {
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if(empty($username) || empty($password)) {
                $error = "Tên đăng nhập và mật khẩu không được để trống";
            }

            if(empty($error)) {
                $this->userModel->create($username, $password, $fullname, $email, $role);
                header("Location: index.php?controller=user&action=list");
                exit;
            }
        }

        include __DIR__ . '/../view/user_form.php';
    }

    // Sửa người dùng
    public function edit() {
        $error = '';
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getById($id);
        if(!$user) {
            $_SESSION['error'] = "Người dùng không tồn tại";
            header("Location: index.php?controller=user&action=list");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if(empty($username)) $error = "Tên đăng nhập không được để trống";

            if(empty($error)) {
                $this->userModel->update($id, $username, $password, $fullname, $email, $role);
                header("Location: index.php?controller=user&action=list");
                exit;
            }
        }

        include __DIR__ . '/../view/user_form.php';
    }

    // Xóa người dùng
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->userModel->delete($id);
        header("Location: index.php?controller=user&action=list");
        exit;
    }
}
?>