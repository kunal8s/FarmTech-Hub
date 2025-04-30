<?php
require 'mail_config.php';

if (sendOTPEmail('test@example.com', '123456')) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email";
}
?>