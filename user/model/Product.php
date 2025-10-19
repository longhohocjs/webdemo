<?php
class Product {
    private $conn;
    private $table = 'products';

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

    public function getAllWithRating() {
        $sql = "SELECT p.*, 
            IFNULL(AVG(c.rating),0) AS avg_rating,
            COUNT(c.id) AS total_comments
            FROM products p
            LEFT JOIN comments c ON c.product_id = p.id
            GROUP BY p.id
            ORDER BY p.created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Tìm kiếm
    public function search($keyword) {
        $sql = "SELECT * FROM {$this->table} 
            WHERE name LIKE :keyword OR description LIKE :keyword";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]); // dấu % để LIKE toàn cục
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm đang giảm giá
    public function getOnSale() {
        $stmt = $this->conn->query("SELECT * FROM products WHERE sale_price > 0 ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Lấy sản phẩm mới nhất
        public function getLatest($limit = 8) {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?");
            $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

}
?>