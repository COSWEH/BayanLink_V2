<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDeleteFaq'])) {
    $getFaqID = $_POST['getFaqID'];


    $query = mysqli_query($con, "DELETE FROM `tbl_faqs` WHERE `faq_id` = '$getFaqID'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','FAQs deleted by user $user_name.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_faq_message'] = "FAQs has been successfully deleted.";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminDashboard.php');
    exit;
}
