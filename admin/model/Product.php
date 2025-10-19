<?php
class Product {
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy tất cả sản phẩm
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo id
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm
    public function create($name, $price, $quantity, $description, $image, $sale_price = 0) {
        $stmt = $this->conn->prepare("INSERT INTO products (name, price, quantity, description, image, sale_price) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $price, $quantity, $description, $image, $sale_price]);
    }

    // Sửa sản phẩm
    public function update($id, $name, $price, $quantity, $description, $image = null, $sale_price = 0) {
        if($image) {
            $stmt = $this->conn->prepare("UPDATE products SET name=?, price=?, quantity=?, description=?, image=?, sale_price=? WHERE id=?");
            return $stmt->execute([$name, $price, $quantity, $description, $image, $sale_price, $id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE products SET name=?, price=?, quantity=?, description=?, sale_price=? WHERE id=?");
            return $stmt->execute([$name, $price, $quantity, $description, $id, $sale_price]);
        }
    }

    // Xóa sản phẩm
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>