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
    public function checkout($user_id, $order_id, $voucher = null){
        // Lấy giỏ hàng user
        $cartItems = $this->getCart($user_id);
        if(empty($cartItems)) return false;

        //  Kiểm tra số lượng tồn kho trước khi tạo đơn hàng
        foreach($cartItems as $item){
            $stmt = $this->conn->prepare("SELECT quantity FROM products WHERE id = ?");
            $stmt->execute([$item['product_id']]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$product || $product['quantity'] < $item['quantity']){
                // Nếu sản phẩm không đủ hàng → báo lỗi và dừng lại
                echo "<script>alert('Sản phẩm {$item['name']} không đủ số lượng trong kho!'); 
                     window.location='index.php?controller=cart&action=view';</script>";
                exit;
            }
        }

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

        try {
            // 🔄 Bắt đầu transaction để đảm bảo tính toàn vẹn
            $this->conn->beginTransaction();

            // Tạo đơn hàng
            $stmt = $this->conn->prepare("
                INSERT INTO orders (user_id, total_price, status, created_at, updated_at)
                VALUES (?, ?, 'pending', NOW(), NOW())
            ");
            $stmt->execute([$user_id, $total]);
            $order_id = $this->conn->lastInsertId();

            // Thêm sản phẩm vào order_items và trừ kho
            $stmtInsert = $this->conn->prepare("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES (?, ?, ?, ?)
            ");
            $stmtUpdateQty = $this->conn->prepare("
               UPDATE products SET quantity = quantity - ? WHERE id = ?
            ");

            foreach($cartItems as $item){
                $price = $item['sale_price'] ?? $item['price'];
                $stmtInsert->execute([$order_id, $item['product_id'], $item['quantity'], $price]);
                $stmtUpdateQty->execute([$item['quantity'], $item['product_id']]);
            }

            // Xóa giỏ hàng
            $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE user_id=?");
            $stmt->execute([$user_id]);

            // Cập nhật trạng thái đơn
            $stmt = $this->conn->prepare("UPDATE orders SET status='confirmed', updated_at=NOW() WHERE id=?");
            $stmt->execute([$order_id]);

            //  Commit transaction
            $this->conn->commit();

            return $order_id;

        } catch (Exception $e) {
            //  Nếu có lỗi → rollback
            $this->conn->rollBack();
            echo "<script>alert('Đặt hàng thất bại: {$e->getMessage()}'); history.back();</script>";
            return false;
        }
    }

}
?>