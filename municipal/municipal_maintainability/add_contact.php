<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnAddContact']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact_number = "+63" . $_POST['contact_number'];
    $contct_email = $_POST['contct_email'];
    $contact_location = $_POST['contact_location'];

    if ($contact_number == "+63") {
        $contact_number = '';
    }
    // if (empty($contact_number) || empty($contct_email) || empty($contact_location)) {
    //     header('Location: ../superAdminDashboard.php');
    //     exit;
    // }

    $contact_number = mysqli_real_escape_string($con, $contact_number);
    $contct_email = mysqli_real_escape_string($con, $contct_email);
    $contact_location = mysqli_real_escape_string($con, $contact_location);

    $query = mysqli_query($con, "INSERT INTO `tbl_contact`(`contact_id`, `contact_number`, `contact_email`, `contact_location`) VALUES ('', '$contact_number', '$contct_email', '$contact_location')");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username added a contact', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['add_contact_message'] = "Contact successfully added";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
