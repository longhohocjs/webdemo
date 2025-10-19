<?php
class User {
    private $conn;
    private $table = 'users'; // hoặc tên bảng của bạn

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Tạo user mới (đăng ký)
    public function create($username, $password, $fullname = null, $email = null, $role = 'user'){
        $sql = "INSERT INTO {$this->table} (username, password, fullname, email, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $username, 
            password_hash($password, PASSWORD_DEFAULT), 
            $fullname, 
            $email, 
            $role
        ]);
    }

    // Lấy user theo username
    public function getByUsername($username){
        $sql = "SELECT * FROM {$this->table} WHERE username=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Kiểm tra đăng nhập
    public function verifyLogin($username, $password){
        $user = $this->getByUsername($username);
        if($user && password_verify($password, $user['password'])){
            return $user;
        }
        return false;
    }
}