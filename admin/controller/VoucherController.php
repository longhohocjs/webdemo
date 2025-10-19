<?php
require_once __DIR__ . '/../model/Voucher.php';

class VoucherController {
    private $voucherModel;

    public function __construct() {
        global $conn;
        $this->voucherModel = new Voucher($conn);

        if(!isset($_SESSION['admin'])) {
            header("Location: index.php?controller=admin&action=login");
            exit;
        }
    }

    public function list() {
        $vouchers = $this->voucherModel->getAll();
        include __DIR__ . '/../view/voucher_list.php';
    }

    public function add() {
        $error = '';
        if($_SERVER['REQUEST_METHOD']==='POST') {
            $code = $_POST['code'] ?? '';
            $discount = $_POST['discount'] ?? 0;
            $type = $_POST['type'] ?? 'percent';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $status = $_POST['status'] ?? 1;

            if(empty($code)) $error = "Mã voucher không được để trống";
            if(empty($discount)) $error = "Giảm giá không được để trống";

            if(empty($error)) {
                $this->voucherModel->create($code, $discount, $type, $start_date, $end_date, $status);
                header("Location: index.php?controller=voucher&action=list");
                exit;
            }
        }
        include __DIR__ . '/../view/voucher_form.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $voucher = $this->voucherModel->getById($id);
        if(!$voucher) {
            $_SESSION['error'] = "Voucher không tồn tại";
            header("Location: index.php?controller=voucher&action=list");
            exit;
        }

        $error = '';
        if($_SERVER['REQUEST_METHOD']==='POST') {
            $code = $_POST['code'] ?? '';
            $discount = $_POST['discount'] ?? 0;
            $type = $_POST['type'] ?? 'percent';
            $start_date = $_POST['start_date'] ?? '';
            $end_date = $_POST['end_date'] ?? '';
            $status = $_POST['status'] ?? 1;

            if(empty($code)) $error = "Mã voucher không được để trống";
            if(empty($discount)) $error = "Giảm giá không được để trống";

            if(empty($error)) {
                $this->voucherModel->update($id, $code, $discount, $type, $start_date, $end_date, $status);
                header("Location: index.php?controller=voucher&action=list");
                exit;
            }
        }

        include __DIR__ . '/../view/voucher_form.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $this->voucherModel->delete($id);
        header("Location: index.php?controller=voucher&action=list");
        exit;
    }
}
?>