<?php
require_once __DIR__ . '/../model/Review.php';

class ReviewController {
    private $reviewModel;

    public function __construct(){
        global $conn;
        $this->reviewModel = new Review($conn);

        // Kiểm tra admin
        if(!isset($_SESSION['admin'])) {
            header("Location: index.php?controller=admin&action=login");
            exit;
        }
    }

    // Danh sách đánh giá
    public function list(){
        $reviews = $this->reviewModel->getAll();
        include __DIR__ . '/../view/review_list.php';
    }

    // Xóa đánh giá
    public function delete(){
        $id = $_GET['id'] ?? 0;
        $this->reviewModel->delete($id);
        header("Location: index.php?controller=review&action=list");
        exit;
    }
}
?>