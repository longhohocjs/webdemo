<?php
class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy tất cả người dùng
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy user theo ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm người dùng
    public function create($username, $password, $fullname, $email, $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, fullname, email, role) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $hash, $fullname, $email, $role]);
    }

    // Sửa người dùng
    public function update($id, $username, $password, $fullname, $email, $role) {
        if($password) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE users SET username=?, password=?, fullname=?, email=?, role=? WHERE id=?");
            return $stmt->execute([$username, $hash, $fullname, $email, $role, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET username=?, fullname=?, email=?, role=? WHERE id=?");
            return $stmt->execute([$username, $fullname, $email, $role, $id]);
        }
    }

    // Xóa người dùng
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>