<?php
class Voucher {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM vouchers ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM vouchers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($code, $discount, $type, $start_date, $end_date, $status=1) {
        $stmt = $this->conn->prepare("INSERT INTO vouchers (code, discount, type, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$code, $discount, $type, $start_date, $end_date, $status]);
    }

    public function update($id, $code, $discount, $type, $start_date, $end_date, $status) {
        $stmt = $this->conn->prepare("UPDATE vouchers SET code=?, discount=?, type=?, start_date=?, end_date=?, status=? WHERE id=?");
        return $stmt->execute([$code, $discount, $type, $start_date, $end_date, $status, $id]);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM vouchers WHERE id=?");
        return $stmt->execute([$id]);
    }
}
?>