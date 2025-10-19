<?php
class Cart {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    // Lấy giỏ hàng của user từ DB
    public function getCart($user_id){
    $stmt = $this->conn->prepare("
        SELECT 
            ci.product_id,
            ci.quantity,
            COALESCE(ci.price, 
                     NULLIF(p.sale_price, 0), 
                     p.price) AS price,
            p.name,
            p.sale_price,
            p.image
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.user_id = ?
    ");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Thêm sản phẩm vào giỏ hàng
    public function addItem($user_id, $product_id, $quantity, $price){
        if ($price <= 0) {
            $stmt = $this->conn->prepare("SELECT price, sale_price FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $p = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($p) {
                $price = ($p['sale_price'] > 0) ? $p['sale_price'] : $p['price'];
            }
        }
        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $stmt = $this->conn->prepare("SELECT id, quantity FROM cart_items WHERE user_id=? AND product_id=?");
        $stmt->execute([$user_id, $product_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if($item){
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity=quantity+?, price=? WHERE id=?");
            $stmt->execute([$quantity, $price, $item['id']]);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO cart_items (user_id, product_id, quantity, price, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$user_id, $product_id, $quantity, $price]);
        }
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function updateItem($user_id, $product_id, $quantity, $price){
        if($quantity <= 0){
            $this->removeItem($user_id, $product_id);
        } else {
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity=?, price=? WHERE user_id=? AND product_id=?");
            $stmt->execute([$quantity, $price, $user_id, $product_id]);
        }
    }

    // Xóa sản phẩm khỏi giỏ
    public function removeItem($user_id, $product_id){
        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE user_id=? AND product_id=?");
        $stmt->execute([$user_id, $product_id]);
    }

    // Thanh toán
public function checkout($user_id, $voucher = null){
    // Lấy giỏ hàng user
    $cartItems = $this->getCart($user_id);
    if(empty($cartItems)) return false;

    // Tính tổng
    $total = 0;
    foreach($cartItems as $item){
        $price = $item['sale_price'] ?? $item['price'];
        $total += $price * $item['quantity'];
    }

    // Áp dụng voucher nếu có
    $discountAmount = 0;
    if($voucher){
        if($voucher['type'] == 'percent'){
            $discountAmount = $total * $voucher['discount']/100;
        } else {
            $discountAmount = $voucher['discount'];
        }
        $total -= $discountAmount;
        if($total < 0) $total = 0;
    }

    // Tạo đơn hàng với status pending
    $stmt = $this->conn->prepare("INSERT INTO orders (user_id, total_price, status, created_at, updated_at) VALUES (?, ?, 'pending', NOW(), NOW())");
    $stmt->execute([$user_id, $total]);
    $order_id = $this->conn->lastInsertId();

    // Chèn order_items
    $stmtInsert = $this->conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach($cartItems as $item){
        $price = $item['sale_price'] ?? $item['price'];
        $stmtInsert->execute([$order_id, $item['product_id'], $item['quantity'], $price]);
    }

    // Xóa giỏ hàng user
    $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE user_id=?");
    $stmt->execute([$user_id]);

    // Cập nhật trạng thái confirmed để hiển thị doanh thu
    $stmt = $this->conn->prepare("UPDATE orders SET status='confirmed', updated_at=NOW() WHERE id=?");
    $stmt->execute([$order_id]);

    return $order_id;
}
}
?>