<?php
require_once __DIR__.'/../model/Order.php';
require_once __DIR__.'/../model/Comment.php';
require_once __DIR__.'/../../config/database.php';

class OrderController {
    private $orderModel;
    private $commentModel;

    public function __construct(){
        global $conn;
        $this->orderModel = new Order($conn);
        $this->commentModel = new Comment($conn);

        // Kiểm tra user đã đăng nhập
        if(!isset($_SESSION['user'])){
            header("Location: index.php?controller=user&action=login");
            exit;
        }
    }
    

    // Lịch sử mua hàng
    public function history(){
        $user_id = $_SESSION['user']['id'];
        $orders = $this->orderModel->getOrdersByUser($user_id);
        $user_id = $_SESSION['user']['id'];
        $orders = $this->orderModel->getOrdersByUser($user_id);

        $ordersWithItems = []; // khởi tạo mảng
        foreach($orders as $order){
            $ordersWithItems[] = [
                'order' => $order,
                'items' => $this->orderModel->getItems($order['id'])
            ];
        }

        include __DIR__.'/../view/order_history.php';
    }

    // Chi tiết đơn hàng
    public function detail(){
        $order_id = $_GET['id'] ?? 0;
        $order_id = intval($order_id);

        $orderItems = $this->orderModel->getItems($order_id);

        if(empty($orderItems)){
            $_SESSION['error'] = "Đơn hàng không tồn tại!";
            header("Location: index.php?controller=order&action=history");
            exit;
        }

        // Lấy trạng thái đơn hàng từ bảng orders
        $orders = $this->orderModel->getOrdersByUser($_SESSION['user']['id']);
        $orderStatus = '';
        foreach($orders as $o){
            if($o['id'] == $order_id){
                $orderStatus = $o['status'];
                break;
            }
        }

        // ✅ Lấy thông tin chi tiết đơn hàng (trạng thái, ngày tạo)
        global $conn;
        $stmt = $conn->prepare("SELECT status, created_at FROM orders WHERE id = :id");
        $stmt->execute(['id' => $order_id]);
        $orderInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $orderStatus = $orderInfo['status'] ?? 'pending';
        $orderDate = $orderInfo['created_at'] ?? null;

        include __DIR__ . '/../view/order_detail.php';
    }

    // Thêm bình luận & đánh giá
    public function comment(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $user_id = $_SESSION['user']['id'];
            $product_id = intval($_POST['product_id'] ?? 0);
            $content = trim($_POST['content'] ?? '');
            $rating = intval($_POST['rating'] ?? 0);

            if($product_id > 0 && $rating >=1 && $rating <=5 && !empty($content)){
                $this->commentModel->addComment($user_id, $product_id, $content, $rating);
            }

            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
  
?>