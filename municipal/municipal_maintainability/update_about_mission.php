<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnUpdateAboutMission']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_about_mission_id = $_POST['update_about_mission_id'];
    $update_about_us = mysqli_real_escape_string($con, $_POST['update_about_us']);
    $update_our_mission = mysqli_real_escape_string($con, $_POST['update_our_mission']);

    if (empty($update_about_mission_id) || empty($update_about_us) || empty($update_our_mission)) {
        header('Location: ../superAdminPost.m.php');
        exit;
    }

    $query = mysqli_query($con, "UPDATE `tbl_about_mission` SET `about_us` = '$update_about_us', `our_mission` = '$update_our_mission' WHERE `about_mission_id` = '$update_about_mission_id'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name updated a About Us and Our Mission', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['update_aboutMission_message'] = "About us and our mission successfully updated";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
