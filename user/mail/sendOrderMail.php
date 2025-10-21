<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/src/Exception.php';
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nguyenlongho224@gmail.com';
    $mail->Password   = 'ppjifaswlbaivojb';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('nguyenlongho224@gmail.com', 'Shop Demo');
    $mail->addAddress($_SESSION['user']['email'], $_SESSION['user']['fullname']);

    $mail->isHTML(true);
    $mail->Subject = 'Hóa đơn đặt hàng';

    $orderLink = 'https://yourdomain.com/order-detail.php?id=' . $_SESSION['order']['id'];

    // Màu trạng thái
    $statusColor = '#FFA500';
    switch($_SESSION['order']['status']){
        case 'Đang xử lý': $statusColor = '#FFA500'; break;
        case 'Đã giao': $statusColor = '#4CAF50'; break;
        case 'Hủy': $statusColor = '#FF0000'; break;
    }

    $body = '<div style="font-family: Arial, sans-serif; color: #333; max-width:650px; margin:auto; padding:20px; border:1px solid #ddd; border-radius:10px;">
        <h2 style="color:#4CAF50; text-align:center;">Hóa đơn đặt hàng</h2>
        <h3>Thông tin đơn hàng</h3>
        <p>
            <strong>Mã đơn hàng:</strong> '.$_SESSION['order']['id'].'<br>
            <strong>Ngày đặt:</strong> '.$_SESSION['order']['date'].'<br>
            <a href="'.$orderLink.'" style="display:inline-block; margin-top:10px; padding:10px 15px; background-color:#4CAF50; color:#fff; text-decoration:none; border-radius:5px;">Xem chi tiết đơn hàng</a>
        </p>
        <h3>Thông tin khách hàng</h3>
        <p>
            <strong>Họ tên:</strong> '.$_SESSION['user']['fullname'].'<br>
            <strong>Email:</strong> '.$_SESSION['user']['email'].'<br>
        </p>
        <h3>Thông tin vận chuyển</h3>
        <p>
            <strong>Phương thức vận chuyển:</strong> '.$_SESSION['order']['shipping_method'].'<br>
            <strong>Trạng thái đơn hàng:</strong> <span style="color:'.$statusColor.'; font-weight:bold;">'.$_SESSION['order']['status'].'</span><br>
            <strong>Dự kiến giao hàng:</strong> '.$_SESSION['order']['delivery_date'].'<br>
        </p>
        <h3>Chi tiết đơn hàng</h3>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color:#f2f2f2; text-align:left;">
                    <th style="padding:8px; border:1px solid #ddd;">STT</th>
                    <th style="padding:8px; border:1px solid #ddd;">Tên sản phẩm</th>
                    <th style="padding:8px; border:1px solid #ddd;">Hình</th>
                    <th style="padding:8px; border:1px solid #ddd;">Đơn giá</th>
                    <th style="padding:8px; border:1px solid #ddd;">Số lượng</th>
                    <th style="padding:8px; border:1px solid #ddd;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>';

    $tong = 0;
    foreach($mailCartItems as $i => $item){
        $price = ($item['sale_price'] ?? 0) > 0 ? $item['sale_price'] : $item['price'];
        $thanhtien = $price * $item['quantity'];
        $tong += $thanhtien;

        $body .= '<tr>
            <td style="padding:8px; border:1px solid #ddd;">'.($i+1).'</td>
            <td style="padding:8px; border:1px solid #ddd;">'.$item['name'].'</td>
            <td style="padding:8px; border:1px solid #ddd;">
                <img src="'.$item['image'].'" width="50" height="50" style="object-fit:cover;">
            </td>
            <td style="padding:8px; border:1px solid #ddd;">'.number_format($price).' đ</td>
            <td style="padding:8px; border:1px solid #ddd;">'.$item['quantity'].'</td>
            <td style="padding:8px; border:1px solid #ddd;">'.number_format($thanhtien).' đ</td>
        </tr>';
    }

    $body .= '<tr>
        <td colspan="5" style="padding:8px; border:1px solid #ddd; text-align:right;"><strong>Tổng tiền</strong></td>
        <td style="padding:8px; border:1px solid #ddd;"><strong>'.number_format($tong).' đ</strong></td>
    </tr>
    </tbody></table>
    <p style="text-align:center; margin-top:20px;">Cảm ơn bạn đã mua hàng tại Shop Demo! Chúng tôi sẽ liên hệ để xác nhận đơn hàng và giao hàng sớm nhất.</p>
    </div>';

    $mail->Body = $body;
    $mail->AltBody = 'Đơn hàng của bạn đã được tạo. Xem chi tiết tại: '.$orderLink;

    $mail->send();
    echo "Đã gửi hóa đơn thành công!";

} catch (Exception $e) {
    error_log("Gửi hóa đơn thất bại: " . $mail->ErrorInfo);
}
