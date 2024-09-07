<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnDeleteDocType'])) {
    $getDocTypeID = $_POST['getDocTypeID'];


    $query = mysqli_query($con, "DELETE FROM `tbl_typedoc` WHERE `id` = '$getDocTypeID'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','Document deleted by user $user_name.', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_docType_message'] = "Document has been successfully deleted.";
        header('Location: ../adminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../adminDashboard.php');
    exit;
}
