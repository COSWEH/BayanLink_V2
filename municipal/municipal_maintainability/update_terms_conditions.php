<?php
include('../../includes/conn.inc.php');
session_start();


function capitalizeSentences($text)
{
    // Convert the entire text to lowercase
    $text = strtolower($text);

    // Capitalize the first letter of the first sentence
    $text = ucfirst($text);

    // Capitalize the first letter after every period followed by a space
    $text = preg_replace_callback('/(?<=[.])\s+(\w)/', function ($matches) {
        return ' ' . strtoupper($matches[1]);
    }, $text);

    return $text;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['btnUpdateTermsConditions'])) {
        $updateTM_id = $_POST['updateTM_id'];
        $updateTM_title = $_POST['updateTM_title'];
        $updateTM_content = $_POST['updateTM_content'];

        $updateTM_title = ucwords(strtolower($updateTM_title));
        $updateTM_content = capitalizeSentences($updateTM_content);

        $updateTM_title = mysqli_real_escape_string($con, $updateTM_title);
        $updateTM_content = mysqli_real_escape_string($con, $updateTM_content);

        if (empty($updateTM_title) && empty($updateTM_content)) {
            header('Location: ../superAdminDashboard.php');
            exit;
        }

        $tm_query = mysqli_query($con, "UPDATE `tbl_terms_conditions` SET `tm_title` = '$updateTM_title', `tm_content` = '$updateTM_content' WHERE `tm_id` = '$updateTM_id'");

        // add logs
        $userid = $_SESSION['user_id'];
        $user_name = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name updated the terms and conditions', CURRENT_TIMESTAMP,'$userid')");

        if ($tm_query) {
            $_SESSION['update_tm_message'] = "Terms and Conditions successfully updated";
            header('Location: ../superAdminDashboard.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
} else {
    header('Location: ../superAdminDashboard.php');
    exit;
}
