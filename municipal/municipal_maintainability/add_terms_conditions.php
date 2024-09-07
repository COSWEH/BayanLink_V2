<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnAddTermsConditions']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $addTM_title = $_POST['addTM_title'];
    $addTM_content = $_POST['addTM_content'];

    $addTM_title = ucwords(strtolower($addTM_title));
    $addTM_content = ucwords(strtolower($addTM_content));

    if (empty($addTM_title) || empty($addTM_content)) {
        header('Location: ../superAdminDashboard.php');
        exit;
    }

    $addTM_title = mysqli_real_escape_string($con, $addTM_title);
    $addTM_content = mysqli_real_escape_string($con, $addTM_content);

    $query = mysqli_query($con, "INSERT INTO `tbl_terms_conditions`(`tm_id`, `tm_title`, `tm_content`) VALUES ('', '$addTM_title', '$addTM_content')");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username added a terms and conditions', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['add_tm_message'] = "Terms and Conditions successfully added";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
