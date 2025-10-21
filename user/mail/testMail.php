<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require __DIR__.'/PHPMailer/src/Exception.php';
require __DIR__.'/PHPMailer/src/PHPMailer.php';
require __DIR__.'/PHPMailer/src/SMTP.php';

session_start();

// -------- Giả lập dữ liệu user & giỏ hàng --------
$_SESSION['user'] = [
    'fullname' => 'Nguyen Van Test',
    'email' => 'nguyenlongho02022004@gmail.com',
    'address' => '123 Đường ABC, Quận 1, TP.HCM'
];

$_SESSION['giohang'] = [
    [
        'name' => 'Sản phẩm 1',
        'price' => 150000,
        'sale_price' => 120000,
        'quantity' => 2,
        'image' => 'https://via.placeholder.com/50'
    ],
    [
        'name' => 'Sản phẩm 2',
        'price' => 250000,
        'sale_price' => 0,
        'quantity' => 1,
        'image' => 'https://via.placeholder.com/50'
    ]
];

$_SESSION['order'] = [
    'id' => 'DH123456',
    'date' => date('d/m/Y'),
    'shipping_method' => 'Giao hàng nhanh',
    'status' => 'Đang xử lý',
    'delivery_date' => date('d/m/Y', strtotime('+3 days'))
];

// -------- Gửi mail --------
$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // bật debug để thấy log
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nguyenlongho224@gmail.com'; // Gmail gửi đi
    $mail->Password   = 'ppjifaswlbaivojb'; // App Password 16 ký tự
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('nguyenlongho224@gmail.com', 'Shop Demo');
    $mail->addAddress($_SESSION['user']['email'], $_SESSION['user']['fullname']);

    $mail->isHTML(true);
    $mail->Subject = 'Test Hóa đơn #' . $_SESSION['order']['id'];

    $orderLink = 'http://localhost/webbanhangdemo/user/index.php?controller=order&action=detail&id=' . $_SESSION['order']['id'];

    $body = '<h3>Xin chào '.$_SESSION['user']['fullname'].'</h3>';
    $body .= '<p>Mã đơn hàng: '.$_SESSION['order']['id'].' | Ngày: '.$_SESSION['order']['date'].'</p>';
    $body .= '<table border="1" cellpadding="5"><tr><th>STT</th><th>Tên SP</th><th>Hình</th><th>Giá</th><th>SL</th><th>Thành tiền</th></tr>';

    $tong = 0;
    foreach($_SESSION['giohang'] as $i => $item){
        $price = ($item['sale_price'] > 0) ? $item['sale_price'] : $item['price'];
        $thanhtien = $price * $item['quantity'];
        $tong += $thanhtien;
        $body .= '<tr>
            <td>'.($i+1).'</td>
            <td>'.$item['name'].'</td>
            <td><img src="'.$item['image'].'" width="50"></td>
            <td>'.number_format($price).' đ</td>
            <td>'.$item['quantity'].'</td>
            <td>'.number_format($thanhtien).' đ</td>
        </tr>';
    }

    $body .= '<tr><td colspan="5"><strong>Tổng tiền</strong></td><td><strong>'.number_format($tong).' đ</strong></td></tr>';
    $body .= '</table>';
    $body .= '<p><a href="'.$orderLink.'">Xem chi tiết đơn hàng</a></p>';

    $mail->Body = $body;
    $mail->AltBody = 'Đơn hàng của bạn đã được tạo. Xem chi tiết tại: '.$orderLink;

    $mail->send();
    echo "Email test đã gửi thành công!";
} catch (Exception $e) {
    echo "Gửi mail thất bại: {$mail->ErrorInfo}";
}