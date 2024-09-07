<?php
include('includes/conn.inc.php');
session_start();

if (isset($_POST['btnSignin']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $password = $_POST['signinPassword'];
    $password_pattern = "/.{8,}/";
    $password_result = preg_match($password_pattern, $password);
    $rememberMe = isset($_POST['rememberMe']);

    if ($password_result == 1) {
        // Valid
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Valid email address
            $checkEmail = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_email` = '$email' LIMIT 1");
            $countEmail = mysqli_num_rows($checkEmail);

            if ($countEmail > 0) {
                // Get user info from database
                $row = mysqli_fetch_assoc($checkEmail);
                $dbPassword = $row['password'];

                // Password verification
                if (password_verify($password, $dbPassword)) {
                    // set koki
                    if ($rememberMe) {
                        // Set cookies with a 7-day expiration
                        setcookie('email', $email, time() + (7 * 24 * 60 * 60), "/");
                        setcookie('password', $password, time() + (7 * 24 * 60 * 60), "/");
                    } else {
                        // Clear cookies if "Remember Me" is not checked
                        setcookie('email', '', time() - 3600, "/");
                        setcookie('password', '', time() - 3600, "/");
                    }

                    // Correct password input
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['fromSanIsidro'] = $row['fromSanIsidro'];
                    $_SESSION['user_city'] = $row['user_city'];
                    $_SESSION['user_brgy'] = $row['user_brgy'];
                    $_SESSION['user_fname'] = $row['user_fname'];
                    $_SESSION['user_mname'] = $row['user_mname'];
                    $_SESSION['user_lname'] = $row['user_lname'];
                    $_SESSION['user_gender'] = $row['user_gender'];
                    $_SESSION['user_purok'] = $row['user_purok'];
                    $_SESSION['user_contactNum'] = $row['user_contactNum'];
                    $_SESSION['dateOfBirth'] = $row['dateOfBirth'];
                    $_SESSION['user_age'] = $row['user_age'];
                    $_SESSION['placeOfBirth'] = $row['placeOfBirth'];
                    $_SESSION['civilStatus'] = $row['civilStatus'];
                    $_SESSION['user_email'] = $row['user_email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['role_id'] = $row['role_id'];

                    if ($_SESSION['role_id'] == 2) {
                        header('Location: municipal/superAdminPost.m.php');
                        $_SESSION['success_message'] = "Successfully login!";
                    } elseif ($_SESSION['role_id'] == 1) {
                        header('Location: barangay/adminPost.b.php');
                        $_SESSION['success_message'] = "Successfully login!";
                    } else {
                        header('Location: civilian/post.c.php');
                        $_SESSION['success_message'] = "Successfully login!";
                    }
                    exit;
                } else {
                    $_SESSION['signin_error_message'] = "Invalid password!";
                    header('Location: index.php');
                    exit;
                }
            } else {
                $_SESSION['signin_error_message'] = "Invalid email address!";
                header('Location: index.php');
                exit;
            }
        } else {
            $_SESSION['signin_error_message'] = "Invalid email format!";
            header('Location: index.php');
            exit;
        }
    } else {
        $_SESSION['signin_error_message'] = "Invalid input!";
        header('Location: index.php');
        exit;
    }
} else {
    header('location: index.php');
    exit;
}
