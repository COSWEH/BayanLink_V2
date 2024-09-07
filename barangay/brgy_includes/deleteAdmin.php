<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDeleteAcc'])) {
    $getAdminID = $_POST['getAdminID'];


    $query = mysqli_query($con, "DELETE FROM `tbl_useracc` WHERE `user_id` = '$getAdminID'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Admin account deleted by user $user_name.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_message'] = "Admin account has been successfully deleted.";
        header('Location: ../adminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../adminDashboard.php');
    exit;
}
