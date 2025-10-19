<?php
class Voucher {
    private $conn;
    private $table = 'vouchers';

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * Lấy voucher theo mã
     * @param string $code
     * @return array|false
     */
    public function getByCode($code){
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} 
            WHERE code = ? AND status = 1 AND start_date <= CURDATE() AND end_date >= CURDATE() LIMIT 1");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kiểm tra voucher có hợp lệ hay không
     * @param string $code
     * @return bool
     */
    public function isValid($code){
        return (bool)$this->getByCode($code);
    }

    /**
     * Tính số tiền giảm giá dựa theo voucher
     * @param array $voucher
     * @param float $total
     * @return float
     */
     public function calculateDiscount($voucher, $total){
        if($voucher['type'] === 'percent'){
            return $total * $voucher['discount'] / 100;
        } else { // amount
            return $voucher['discount'];
        }
    }
}
?>