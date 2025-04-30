<?php
require_once 'db.php';
require_once 'mail_config.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'error' => 'Invalid email']);
        exit;
    }
    
    // Check cooldown period (3 minutes)
    if (isset($_SESSION['last_otp_time'])) {
        $elapsed = time() - $_SESSION['last_otp_time'];
        $cooldown = 180; // 3 minutes in seconds
        
        if ($elapsed < $cooldown) {
            $_SESSION['otp_cooldown'] = $cooldown - $elapsed;
            echo json_encode(['success' => false, 'error' => 'Please wait before requesting another OTP']);
            exit;
        }
    }
    
    // Regenerate and send OTP
    $otp = rand(100000, 999999);
    $_SESSION['signup_otp'] = $otp;
    $_SESSION['signup_otp_time'] = time();
    $_SESSION['last_otp_time'] = time();
    unset($_SESSION['otp_cooldown']);
    
    $subject = "Your FarmTech Hub Verification Code";
    $message = "Your new OTP for FarmTech Hub registration is: $otp\n\nThis code is valid for 10 minutes.";
    $headers = "From: no-reply@farmtechhub.com";
    
    if (mail($email, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to send email']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>