<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnDelete']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $faq_id = $_POST['faqid'];

    if (empty($faq_id)) {
        header('Location: ../superAdminPost.m.php');
        exit;
    }

    $query = mysqli_query($con, "DELETE FROM `tbl_faqs` WHERE `faq_id` = '$faq_id'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name deleted a FAQs', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_faq_message'] = "FAQ successfully deleted";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
