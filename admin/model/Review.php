<?php
class Review {
    private $conn;
    private $table = 'comments';

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Lấy tất cả đánh giá kèm thông tin sản phẩm và người dùng
    public function getAll() {
        $sql = "SELECT c.*, u.username, p.name AS product_name
                FROM {$this->table} c
                JOIN users u ON u.id = c.user_id
                JOIN products p ON p.id = c.product_id
                ORDER BY c.created_at DESC";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xóa đánh giá
    public function delete($id){
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>