<?php
session_start();

// 1️⃣ Kết nối DB
$host = 'localhost';
$db   = 'webbanhang';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Lỗi kết nối DB: " . $e->getMessage());
}

// 2️⃣ Tạo bảng users nếu chưa có
$conn->exec("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    email VARCHAR(100),
    role ENUM('admin','user') NOT NULL DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)
");

// 3️⃣ Tạo tài khoản admin
$admin_username = 'admin';
$admin_password_plain = 'admin123';
$admin_password_hash = password_hash($admin_password_plain, PASSWORD_BCRYPT);
$admin_email = 'admin@example.com';
$admin_fullname = 'Quản trị viên';
$admin_role = 'admin';

// Xóa nếu đã tồn tại
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->execute([$admin_username]);

// Thêm admin mới
$stmt = $conn->prepare("INSERT INTO users (username,password,fullname,email,role) VALUES (?,?,?,?,?)");
$stmt->execute([$admin_username, $admin_password_hash, $admin_fullname, $admin_email, $admin_role]);

echo "✅ Admin đã được tạo: username=admin, password=admin123\n";

// 4️⃣ Test login trực tiếp
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$admin_username]);
$user = $stmt->fetch();

if ($user && password_verify($admin_password_plain, $user['password']) && $user['role']=='admin') {
    echo "✅ Đăng nhập admin thành công!";
} else {
    echo "❌ Đăng nhập thất bại!";
}
?>