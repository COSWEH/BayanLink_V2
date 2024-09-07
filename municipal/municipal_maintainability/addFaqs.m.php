<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnFaqs']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (empty($question) || empty($answer)) {
        header('Location: ../superAdminDashboard.php');
        exit;
    }

    $question = mysqli_real_escape_string($con, $question);
    $answer = mysqli_real_escape_string($con, $answer);

    $query = mysqli_query($con, "INSERT INTO `tbl_faqs`(`faq_id`, `faq_question`, `faq_answer`, `faq_created_at`) VALUES ('', '$question', '$answer', CURRENT_TIMESTAMP)");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username added a FAQs', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['faq_message'] = "FAQs successfully addedd";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
