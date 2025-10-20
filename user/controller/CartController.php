<?php
require_once __DIR__ . '/../model/Cart.php';
require_once __DIR__ . '/../model/Product.php';
require_once __DIR__ . '/../model/Voucher.php';
require_once __DIR__ . '/../../config/database.php';

class CartController {
    private $cartModel;
    private $productModel;
    private $voucherModel;
    private $orderModel;
    private $conn;

    public function __construct(){
        global $conn;
        $this->conn = $conn;
        $this->cartModel = new Cart($conn);
        $this->productModel = new Product($conn);
        $this->voucherModel = new Voucher($conn);
    }

    // AJAX thêm sản phẩm vào giỏ
    public function add(){
        $id = intval($_GET['id'] ?? 0);
        $product = $this->productModel->getById($id);
        if(!$product){
            echo json_encode(['success'=>false,'message'=>'Sản phẩm không tồn tại']);
            return;
        }

        $price = ($product['sale_price'] > 0) ? $product['sale_price'] : $product['price'];


        if(isset($_SESSION['user'])){
            $user_id = $_SESSION['user']['id'];
            $this->cartModel->addItem($user_id, $id, 1, $price);
            $cartItems = $this->cartModel->getCart($user_id);
        } else {
            if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
                if(isset($_SESSION['cart'][$id])){
                    $_SESSION['cart'][$id]['quantity'] +=1;
            } else {
                $_SESSION['cart'][$id] = [
                    'quantity'=>1,
                    'price'=>$price,
                    'name'=>$product['name'],
                    'sale_price'=>$product['sale_price'] ?? null,
                    'image'=>$product['image'] ?? null
                ];
            }
            $cartItems = [];
            foreach($_SESSION['cart'] as $pid=>$item){
                $cartItems[] = [
                    'product_id'=>$pid,
                    'quantity'=>$item['quantity'],
                    'price'=>$item['price'],
                    'name'=>$item['name'],
                    'sale_price'=>$item['sale_price'] ?? null,
                    'image'=>$item['image'] ?? null
                ];
            }
        }
        echo json_encode(['success'=>true,'cart'=>$cartItems]);
    }

    // Xem giỏ hàng
    public function view(){
        if(isset($_SESSION['user'])){
            $user_id = $_SESSION['user']['id'];
            $cartItems = $this->cartModel->getCart($user_id);
        } else {
            $cartItems = [];
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $pid=>$item){
                    $cartItems[] = [
                        'product_id'=>$pid,
                        'quantity'=>$item['quantity'],
                        'price'=>$item['price'],
                        'name'=>$item['name'],
                        'sale_price'=>$item['sale_price'] ?? null,
                        'image'=>$item['image'] ?? null
                    ];
                }
            }
        }
        include __DIR__ . '/../view/cart.php';
    }

    // Cập nhật số lượng & áp dụng voucher (AJAX version)
    public function update() {
        $quantities = $_POST['quantity'] ?? [];
        $voucherCode = $_POST['voucher'] ?? null;

        $appliedVoucher = null;
        if ($voucherCode) {
            $v = $this->voucherModel->getByCode($voucherCode);
            if ($v && $v['status'] == 1 && $v['start_date'] <= date('Y-m-d') && $v['end_date'] >= date('Y-m-d')) {
                $appliedVoucher = $v;
            }
        }

        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user']['id'];
            foreach ($quantities as $product_id => $qty) {
                $product = $this->productModel->getById($product_id);
                $price = ($product['sale_price'] > 0) ? $product['sale_price'] : $product['price'];
                $this->cartModel->updateItem($user_id, $product_id, intval($qty), $price);
            }
            $cartItems = $this->cartModel->getCart($user_id);
        } else {
            foreach ($quantities as $product_id => $qty) {
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] = intval($qty);
                }
            }
            $cartItems = $_SESSION['cart'] ?? [];
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        }

        // Áp dụng voucher nếu có
        if ($appliedVoucher) {
            $discount = 0;
            if ($appliedVoucher['type'] === 'percent') {
                $discount = $total * ($appliedVoucher['discount'] / 100);
            } else {
                $discount = $appliedVoucher['discount'];
            }   
            $total -= $discount;
        }

        // Lưu voucher vào session
        $_SESSION['voucher'] = $appliedVoucher ?: null;


        //  Trả JSON để JS cập nhật giao diện
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'total' => $total,
            'total_formatted' => number_format($total, 0, ',', '.') . '₫'
        ]);
        exit;
    }   


    // Xóa sản phẩm khỏi giỏ
    public function remove(){
        $id = intval($_GET['id'] ?? 0);
        if(isset($_SESSION['user'])){
            $user_id = $_SESSION['user']['id'];
            $this->cartModel->removeItem($user_id, $id);
        } else {
            unset($_SESSION['cart'][$id]);
        }
        header("Location: index.php?controller=cart&action=view");
        exit;
    }

    

    public function applyVoucher() {
        header('Content-Type: application/json'); // bắt buộc trả JSON

        if(!isset($_POST['voucher']) || empty($_POST['voucher'])){
            echo json_encode(['success'=>false]);
            return;
        }

        if(!isset($_SESSION['user'])){
            echo json_encode(['success'=>false, 'message'=>'Cần đăng nhập']);
            return;
        }

        $user_id = $_SESSION['user']['id'];
        $code = $_POST['voucher'];

        // Lấy giỏ hàng
        $cartItems = $this->cartModel->getCart($user_id);
        $total = 0;
        foreach($cartItems as $item){
            $price = $item['sale_price'] ?? $item['price'];
            $total += $price * $item['quantity'];
        }

        // Lấy voucher
        require_once __DIR__ . '/../model/Voucher.php';
        $voucherModel = new Voucher($this->conn);
        $voucher = $voucherModel->getByCode($code);

        if($voucher){
            $discount = $voucherModel->calculateDiscount($voucher, $total);
            $totalAfterDiscount = max(0, $total - $discount); // tránh âm
            echo json_encode(['success'=>true, 'total'=>$totalAfterDiscount]);
        } else {
            echo json_encode(['success'=>false]);
        }
    }

    // Thanh toán
    public function checkout(){
        if(!isset($_SESSION['user'])){
                header("Location: index.php?controller=user&action=login");
                exit;
            }
            $user_id = $_SESSION['user']['id'];
            $cart_items = $_SESSION['cart'] ?? [];
            $voucher = $_SESSION['voucher'] ?? null;

              // Tính tổng tiền
            $total = 0;
            foreach ($cart_items as $item) {
                $price = ($item['sale_price'] > 0) ? $item['sale_price'] : $item['price'];
                $total += $price * $item['quantity'];
            }
            
            
            // Tạo đơn hàng trong bảng orders
            require_once __DIR__ . '/../model/Order.php';
            $this->orderModel = new Order($this->conn);
            $order_id = $this->cartModel->checkout($user_id, null, $voucher);
            if($order_id){
                // Xóa giỏ hàng session
                unset($_SESSION['cart']);
                unset($_SESSION['voucher']);
                header("Location: index.php?controller=order&action=history");
                exit;
            } else {
                echo "Thanh toán thất bại!";
        }
    }

}
?>