<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnAddServices']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $addServices_title = $_POST['addServices_title'];
    $addServices_desc = $_POST['addServices_desc'];
    $addServices_title = ucwords(strtolower($addServices_title));
    $addServices_desc = ucwords(strtolower($addServices_desc));

    if (empty($addServices_title) || empty($addServices_desc)) {
        header('Location: ../superAdminDashboard.php');
        exit;
    }

    $addServices_title = mysqli_real_escape_string($con, $addServices_title);
    $addServices_desc = mysqli_real_escape_string($con, $addServices_desc);

    $query = mysqli_query($con, "INSERT INTO `tbl_services`(`services_id`, `services_title`, `services_desc`, `services_created_at`) VALUES ('', '$addServices_title', '$addServices_desc', CURRENT_TIMESTAMP)");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username added a service', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['add_services_message'] = "Service successfully added";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
