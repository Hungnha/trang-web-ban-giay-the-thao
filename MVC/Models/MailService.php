<?php
// Nhúng thư viện PHPMailer đã tải ở Bước 1
include_once './Lib/PHPMailer/Exception.php';
include_once './Lib/PHPMailer/PHPMailer.php';
include_once './Lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public static function send($toEmail, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // 1. Cấu hình Server (Dùng Gmail làm ví dụ)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;

            // --- THAY THÔNG TIN CỦA BẠN VÀO ĐÂY ---
            $mail->Username = 'frurt35@gmail.com'; // Email của bạn
            $mail->Password = 'oyaa ngyg egnh eizp'; // Mật khẩu ứng dụng (App Password)
            // ---------------------------------------

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Hoặc ENCRYPTION_STARTTLS
            $mail->Port = 465; // 465 nếu dùng SMTPS, 587 nếu dùng STARTTLS
            $mail->CharSet = 'UTF-8';

            // 2. Người gửi và người nhận
            $mail->setFrom('frurt35@gmail.com', 'Giày Hiện Đại Support');
            $mail->addAddress($toEmail);

            // 3. Nội dung email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            // Ghi log lỗi nếu cần: echo "Lỗi gửi mail: {$mail->ErrorInfo}";
            return false;
        }
    }
}
?>