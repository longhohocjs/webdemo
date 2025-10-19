<?php
class Comment {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Thêm bình luận và đánh giá
    public function addComment($user_id, $product_id, $content, $rating){
        $sql = "INSERT INTO comments (user_id, product_id, content, rating) 
                VALUES (:user_id, :product_id, :content, :rating)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id'=>$user_id,
            'product_id'=>$product_id,
            'content'=>$content,
            'rating'=>$rating
        ]);

        // Cập nhật trung bình đánh giá và tổng bình luận
        $sqlUpdate = "UPDATE products p
                      SET p.avg_rating = (SELECT AVG(c.rating) FROM comments c WHERE c.product_id = p.id),
                          p.total_comments = (SELECT COUNT(*) FROM comments c WHERE c.product_id = p.id)
                      WHERE p.id = :product_id";
        $stmtUpdate = $this->conn->prepare($sqlUpdate);
        $stmtUpdate->execute(['product_id'=>$product_id]);
    }

    // Lấy bình luận theo sản phẩm
    public function getByProduct($product_id){
        $sql = "SELECT c.*, u.fullname 
                FROM comments c
                JOIN users u ON u.id=c.user_id
                WHERE c.product_id=:product_id
                ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['product_id'=>$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tính đánh giá trung bình
    public function getAverageRating($product_id){
        $stmt = $this->conn->prepare("SELECT AVG(rating) as avg_rating FROM comments WHERE product_id=?");
        $stmt->execute([$product_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['avg_rating'] ?? 0;
    }

    public function getStatsByProduct($product_id) {
    $stmt = $this->conn->prepare("
        SELECT 
            COUNT(*) AS total_comments,
            ROUND(AVG(rating), 1) AS avg_rating
        FROM comments
        WHERE product_id = ?
    ");
    $stmt->execute([$product_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>