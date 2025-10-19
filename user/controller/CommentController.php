<?php
require_once __DIR__ . '/../model/Comment.php';
require_once __DIR__ . '/../../config/database.php';

class CommentController {
    private $commentModel;

    public function __construct(){
        global $conn;
        $this->commentModel = new Comment($conn);

        if(!isset($_SESSION['user'])){
            header("Location: index.php?controller=user&action=login");
            exit;
        }
    }

    // Thêm bình luận AJAX
    public function add(){
        $user_id = $_SESSION['user']['id'];
        $product_id = $_POST['product_id'] ?? 0;
        $order_id = $_POST['order_id'] ?? 0;
        $rating = $_POST['rating'] ?? 0;
        $comment = $_POST['comment'] ?? '';

        if(!$this->commentModel->canComment($user_id, $product_id)){
            echo json_encode(['success'=>false,'message'=>'Bạn chưa mua sản phẩm này']);
            return;
        }

        $success = $this->commentModel->add($user_id, $product_id, $order_id, $rating, $comment);
        echo json_encode(['success'=>$success]);
    }
}
?>