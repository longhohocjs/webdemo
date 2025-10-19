<?php
class Order {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT orders.*, users.fullname FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getRevenueByWeek() {
        $stmt = $this->conn->query("
                SELECT DAYOFWEEK(created_at) as day, SUM(total_price) as total
                FROM orders
                WHERE status = 'success' AND YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)
                GROUP BY day
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRevenueByMonth() {
        $stmt = $this->conn->query("
                SELECT DAY(created_at) as day, SUM(total_price) as total
                FROM orders
                WHERE status = 'success' AND MONTH(created_at) = MONTH(CURDATE())
                GROUP BY day
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRevenueByYear() {
        $stmt = $this->conn->query("
                SELECT MONTH(created_at) as month, SUM(total_price) as total
                FROM orders
                WHERE status = 'success' AND YEAR(created_at) = YEAR(CURDATE())
                GROUP BY month
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}