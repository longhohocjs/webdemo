<?php
require_once __DIR__ . '/../model/Order.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        global $conn;
        $this->orderModel = new Order($conn);

        if(!isset($_SESSION['admin'])) {
            header("Location: index.php?controller=admin&action=login");
            exit;
        }
    }

    public function list() {
        $orders = $this->orderModel->getAll();
        include __DIR__ . '/../view/order_list.php';
    }

    

    public function updateStatus() {
        $id = $_GET['id'] ?? 0;
        $status = $_POST['status'] ?? '';

        $allowed = ['pending','confirmed','shipping','delivered','success'];
        if(in_array($status, $allowed)) {
            $this->orderModel->updateStatus($id, $status);
        }

        header("Location: index.php?controller=order&action=list");
        exit;
    }

    
}