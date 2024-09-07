<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

include('conn.inc.php');
$config = include('../config/config.php');
session_start();

if (isset($_POST['btnForgotPassword']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fpEmail = isset($_POST['fpEmail']) ? trim($_POST['fpEmail']) : '';
    $fpEmail = htmlspecialchars($fpEmail);

    if (empty($fpEmail)) {
        $_SESSION['errorFPMessage'] = "Please enter your email address.";
        header('location: ../index.php');
        exit;
    }

    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $query = mysqli_query($con, "UPDATE `tbl_useracc` SET `reset_token_hash` = '$token_hash', `reset_token_expires_at` = '$expiry' WHERE `user_email` = '$fpEmail'");

    if ($query) {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($config['email'], 'BayanLink');

        $mail->addAddress($fpEmail);

        $mail->isHTML(true);

        $mail->Subject = "BayanLink Password Reset";
        $mail->Body = <<<END
        
        Click <a href="localhost/blcapstone/reset_password.php?token=$token">here</a> to reset your password.
        
        END;

        $mail->send();

        $_SESSION['fpMessage'] = "We have sent a password reset link to $fpEmail.";
    } else {
        // say message anyway
        $_SESSION['fpMessage'] = "We have sent a password reset link to $fpEmail.";
    }
    header('location: ../index.php');
    exit;
}
