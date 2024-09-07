<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDeleteContact'])) {
    $deleteContact_id = $_POST['deleteContact_id'];

    $query = mysqli_query($con, "DELETE FROM `tbl_contact` WHERE `contact_id` = '$deleteContact_id'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Contact deleted by user $user_name.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_contact_message'] = "Contact has been successfully deleted.";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminDashboard.php');
    exit;
}
