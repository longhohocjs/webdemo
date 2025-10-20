<?php
require_once __DIR__ . '/../../config/database.php';

class RevenueController {
    private $conn;

    public function __construct(){
        global $conn;
        $this->conn = $conn;
    }

    public function index(){
        // Doanh thu tuần: 7 ngày gần nhất
        $stmt = $this->conn->prepare("
            SELECT DAYOFWEEK(created_at) as day, SUM(total_price) as total
            FROM orders 
            WHERE status IN ('delivered', 'success')
            AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
            GROUP BY DAYOFWEEK(created_at)
            ORDER BY DAYOFWEEK(created_at)
        ");
        $stmt->execute();
        $weekRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Doanh thu tháng: ngày trong tháng hiện tại
        $stmt = $this->conn->prepare("
            SELECT DAY(created_at) as day, SUM(total_price) as total
            FROM orders 
            WHERE status IN ('delivered', 'success')
            AND MONTH(created_at)=MONTH(NOW()) 
            AND YEAR(created_at)=YEAR(NOW())
            GROUP BY DAY(created_at)
            ORDER BY DAY(created_at)
        ");
        $stmt->execute();
        $monthRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Doanh thu năm: tháng trong năm hiện tại
        $stmt = $this->conn->prepare("
            SELECT MONTH(created_at) as month, SUM(total_price) as total
            FROM orders 
            WHERE status IN ('delivered', 'success') 
            AND YEAR(created_at)=YEAR(NOW())
            GROUP BY MONTH(created_at)
            ORDER BY MONTH(created_at)
        ");
        $stmt->execute();
        $yearRevenue = $stmt->fetchAll(PDO::FETCH_ASSOC);

       include __DIR__ . '/../view/revenue.php';

    }
}