<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../config/db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); // Use 'email' instead of 'username'

    // Check if admin exists
    $check_sql = "SELECT id, email FROM admins WHERE email = :email";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $check_stmt->execute();

    if ($check_stmt->rowCount() == 0) {
        $_SESSION['error'] = "Admin account not found.";
        header("Location: admin_reset_pass.php");
        exit();
    }

    $admin = $check_stmt->fetch(PDO::FETCH_ASSOC);

    // Generate 6-digit OTP
    $otp = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
    $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

    // Save OTP in database
    $update_sql = "UPDATE admins SET reset_token = :otp, reset_expiry = :expiry WHERE email = :email";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindValue(':otp', $otp, PDO::PARAM_STR);
    $update_stmt->bindValue(':expiry', $expiry, PDO::PARAM_STR);
    $update_stmt->bindValue(':email', $email, PDO::PARAM_STR);

    if (!$update_stmt->execute()) {
        $_SESSION['error'] = "Database error. Please try again.";
        header("Location: admin_forgot_pass.php");
        exit();
    }

    // Send OTP email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ezmarket1604@gmail.com';
        $mail->Password = 'lviw pfoy yqup zbso';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ezmarket1604@gmail.com', 'EZ Mart Admin');
        $mail->addAddress($admin['email']);
        $mail->isHTML(true);
        $mail->Subject = "Your EZ Mart Admin Password Reset OTP";

        $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #2563eb;'>EZ Mart Admin Password Reset</h2>
                <p>Your One-Time Password (OTP) is:</p>
                
                <div style='background: #f3f4f6; padding: 15px; text-align: center; 
                            margin: 20px 0; border-radius: 5px;'>
                    <h1 style='margin: 0; color: #2563eb; letter-spacing: 3px;'>$otp</h1>
                </div>
                
                <p>This OTP is valid for 15 minutes. If you didn't request this, please ignore this email.</p>
            </div>
        ";

        $mail->AltBody = "EZ Mart Admin Password Reset\n\nYour OTP is: $otp\n\nValid for 15 minutes.";

        $mail->send();
        $_SESSION['success'] = "OTP sent successfully to your registered email.";
        $_SESSION['otp_email'] = $email; // Store email for verification
        header("Location: admin_reset_pass.php");
        exit();
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        $_SESSION['error'] = "Failed to send OTP. Please try again.";
        header("Location: admin_reset_pass.php");
        exit();
    }
} else {
    header("Location: admin_reset_pass.php");
    exit();
}
