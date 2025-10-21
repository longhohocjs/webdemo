<?php
class Order {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Lấy tất cả đơn hàng của user
    public function getOrdersByUser($user_id){
        $sql = "SELECT * FROM orders WHERE user_id=:user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id'=>$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết sản phẩm của một đơn hàng
    public function getItems($order_id){
        $sql = "SELECT oi.*, p.name, p.image, p.sale_price, p.price 
                FROM order_items oi
                JOIN products p ON p.id=oi.product_id
                WHERE oi.order_id=:order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['order_id'=>$order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        public function hasUserPurchasedProduct($user_id, $product_id) {
        $sql = "SELECT COUNT(*) FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE o.user_id = :user_id 
            AND oi.product_id = :product_id
            AND o.status IN ('completed', 'delivered')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
        return $stmt->fetchColumn() > 0;
    }

    public function createOrder($user_id, $total_price, $status = 'pending') {
        $stmt = $this->conn->prepare("
            INSERT INTO orders (user_id, total_price, status, created_at, updated_at)
            VALUES (:user_id, :total_price, :status, NOW(), NOW())
        ");
        $stmt->execute([
            'user_id' => $user_id,
            'total_price' => $total_price,
            'status' => $status
        ]);
        return $this->conn->lastInsertId();
}


    
}
?>