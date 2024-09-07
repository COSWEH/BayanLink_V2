<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnChangePass']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Fetch stored password hash from the database
    $userId = $_SESSION['user_id'];
    $result = mysqli_query($con, "SELECT password FROM tbl_useracc WHERE user_id = '$userId'");
    $row = mysqli_fetch_assoc($result);
    $storedHash = $row['password'];

    $username = $_SESSION['username'];

    // Verify the current password
    if (password_verify($currentPassword, $storedHash)) {
        if ($newPassword === $confirmNewPassword) {
            // Hash the new password
            $newHash = password_hash($newPassword, PASSWORD_DEFAULT);  // Hashes the new password

            // Update the password in the database
            mysqli_query($con, "UPDATE tbl_useracc SET password = '$newHash' WHERE user_id = '$userId'");

            // add logs
            mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username changed his/her password', CURRENT_TIMESTAMP,'$userId')");

            $_SESSION['password_message'] = "Password updated successfully!";
            $_SESSION['password_message_code'] = "Success";
            header('location: ../profile.c.php');
        } else {
            $_SESSION['password_message'] = "New passwords do not match!";
            $_SESSION['password_message_code'] = "Error";
            header('location: ../profile.c.php');
        }
        exit;
    } else {
        $_SESSION['password_message'] = "Current password is incorrect!";
        $_SESSION['password_message_code'] = "Error";
        header('location: ../profile.c.php');
        exit;
    }
} else {
    header('location: ../post.c.php');
    exit;
}
