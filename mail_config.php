<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOTPEmail($email, $otp) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kunalsharmakunu09@gmail.com'; // Your Gmail
        $mail->Password   = 'asvf rlsx stgt jvzw'; // From Step 4.2
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('no-reply@farmtechhub.com', 'FarmTech Hub');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your FarmTech Hub Verification Code';
        $mail->Body    = "
            <h2>FarmTech Hub Verification</h2>
            <p>Your OTP for registration is: <strong>$otp</strong></p>
            <p>This code is valid for 10 minutes.</p>
        ";
        $mail->AltBody = "Your OTP is: $otp (valid for 10 minutes)";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>