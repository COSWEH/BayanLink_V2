<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

include('../../includes/conn.inc.php');
$config = include('../../config/config.php');
session_start();

if (isset($_POST['btnSignup']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $fromSanIsidro = ucwords(strtolower($_SESSION['fromSanIsidro']));
    $barangay = ucwords(strtolower($_SESSION['user_brgy']));
    $fname = ucwords(strtolower($_POST['fname']));
    $mname = ucwords(strtolower($_POST['mname']));
    $lname = ucwords(strtolower($_POST['lname']));
    $gender = $_POST['gender'];
    $purok = $_POST['user_purok'];
    $contactNum = $_POST['contactNum'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $placeOfBirth = ucwords(strtolower($_POST['placeOfBirth']));
    $civilStatus = $_POST['civilStatus'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['signupPassword'];
    $confirmPassword = $_POST['confirmPassword'];


    $_SESSION['admin_fname'] = $fname;
    $_SESSION['admin_mname'] = $mname;
    $_SESSION['admin_lname'] = $lname;
    $_SESSION['admin_gender'] = $gender;
    $_SESSION['admin_purok'] = $purok;
    $_SESSION['admin_contactNum'] = $contactNum;
    $_SESSION['dateOfBirth'] = $dateOfBirth;
    $_SESSION['placeOfBirth'] = $placeOfBirth;
    $_SESSION['civilStatus'] = $civilStatus;
    $_SESSION['admin_email'] = $email;
    $_SESSION['admin_username'] = $username;
    $_SESSION['admin_password'] = $password;


    function validateName($name)
    {
        $pattern = "/^[a-zA-Z\s\-]+$/";
        return preg_match($pattern, $name) === 1;
    }

    function validatePhoneNumber($phoneNumber)
    {
        $pattern = "/^(09\d{9}|639\d{9})$/";
        return preg_match($pattern, $phoneNumber) === 1;
    }

    function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function validateUsername($username)
    {
        $pattern = "/^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$/";
        return preg_match($pattern, $username) === 1;
    }

    function validatePassword($password)
    {
        // Check if the password meets the length requirement and the complexity pattern
        $lengthValid = strlen($password) >= 8;
        $patternValid = preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password);

        return $lengthValid && $patternValid;
    }


    $fname_result = validateName($fname);
    $mname_result = validateName($mname);
    $lname_result = validateName($lname);
    $contactNum_result = validatePhoneNumber($contactNum);
    $email_result = validateEmail($email);
    $username_result = validateUsername($username);
    $password_result = validatePassword($password);

    $errors = [];

    if (!$fname_result) {
        $errors[] = "First Name is invalid.";
    }
    if (!$mname_result) {
        $errors[] = "Middle Name is invalid.";
    }
    if (!$lname_result) {
        $errors[] = "Last Name is invalid.";
    }
    if (!$contactNum_result) {
        $errors[] = "Phone Number is invalid.";
    }
    if (!$email_result) {
        $errors[] = "Email is invalid.";
    }
    if (!$username_result) {
        $errors[] = "Username is invalid.";
    }
    if (!$password_result) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    if (empty($errors)) {

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //check if the username is already exist
            $checkUsername = mysqli_query($con, "SELECT * FROM tbl_useracc WHERE username = '$username' LIMIT 1");
            $countUsername = mysqli_num_rows($checkUsername);

            //check if the email address is already exist
            $checkEmail = mysqli_query($con, "SELECT * FROM tbl_useracc WHERE user_email = '$email' LIMIT 1");
            $countEmail = mysqli_num_rows($checkEmail);

            if ($countUsername == 1) {
                $_SESSION['addAdmin_error_message'] = "Username already exists!";
                header('location: ../adminDashboard.php');
            } elseif ($countEmail == 1) {
                $_SESSION['addAdmin_error_message'] = "Email address already exists!";
                header('location: ../adminDashboard.php');
            } elseif ($password != $confirmPassword) {
                $_SESSION['addAdmin_error_message'] = "Password did not match!";
                header('location: ../adminDashboard.php');
            } else {
                $verification_code = mt_rand(100000, 999999);

                $message = "
                    <h2 style='color: #2980b9;'>Your One-Time Password (OTP)</h2>
                    <p>Dear User,</p>
                    <p>Your OTP for completing your registration on BayanLink is:</p>
                    <h1 style='font-size: 24px; color: #e74c3c;'>$verification_code</h1>
                    <p>Please use this code to verify your account. If you did not request this code, please ignore this message.</p>
                    <br>
                    <p>With regards,</p>
                    <p><strong>The BayanLink Team</strong></p>
                    <p style='font-size: 12px; color: #7f8c8d;'>This is an automated message, please do not reply.</p>
                ";

                $mail = new PHPMailer(true);

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = $config['email'];
                $mail->Password = $config['password'];
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;

                $mail->setFrom($config['email'], 'BayanLink');

                $mail->addAddress($email);

                $mail->isHTML(true);

                $mail->Subject = "BayanLink OTP for Account Verification";
                $mail->Body = $message;

                $mail->send();

                $_SESSION['verification_code'] = $verification_code;
                echo '
            <form id="redirectForm" action="verify_account.php" method="POST">
                <input type="hidden" name="verification_code" value="' . htmlspecialchars($verification_code) . '">
                <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
            </form>
            <script>
                document.getElementById("redirectForm").submit();
            </script>
            ';
                exit;
            }
            exit;
        }
    } else {
        // Concatenate error messages into a single string
        $error_message = implode("<br>", $errors);
        $_SESSION['addAdmin_error_message'] = $error_message;
        header('location: ../adminPost.b.php');
        exit;
    }
} else {
    header('location: ../adminPost.b.php');
    exit;
}
