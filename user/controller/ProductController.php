<?php
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Comment.php';
require_once __DIR__ . '/../model/Order.php';
require_once __DIR__ . '/../../config/database.php';

class ProductController {
    private $productModel;
    private $commentModel;
    private $orderModel;

    public function __construct() {
        global $conn;
        $this->productModel = new Product($conn);
        $this->commentModel = new Comment($conn);
        $this->orderModel   = new Order($conn);
    }

    // Hiển thị chi tiết sản phẩm
    public function detail() {
        $id = intval($_GET['id'] ?? 0);
        $product = $this->productModel->getById($id);

        if (!$product) {
            echo "Sản phẩm không tồn tại!";
            return;
        }

        // Lấy bình luận
        $comments = $this->commentModel->getByProduct($id);

        // Tính trung bình sao
        $avgRating = 0;
        $countRating = count($comments);
        if ($countRating > 0) {
            $sum = array_sum(array_column($comments, 'rating'));
            $avgRating = round($sum / $countRating, 1);
        }

        // Kiểm tra người dùng đã mua chưa
        $canComment = false;
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $canComment = $this->orderModel->hasUserPurchasedProduct($userId, $id);
        }

        include __DIR__ . '/../view/product_detail.php';
    }
}
?>