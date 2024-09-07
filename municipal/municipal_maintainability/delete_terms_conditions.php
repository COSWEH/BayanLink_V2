<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDeleteTM'])) {
    $deleteTM_id = $_POST['deleteTM_id'];

    $query = mysqli_query($con, "DELETE FROM `tbl_terms_conditions` WHERE `tm_id` = '$deleteTM_id'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Terms and Conditions deleted by user $user_name.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_tm_message'] = "Terms and Conditions has been successfully deleted.";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminDashboard.php');
    exit;
}
