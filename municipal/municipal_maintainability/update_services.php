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
    if (isset($_POST['btnUpdateServices'])) {
        $services_id = $_POST['updateServices_id'];
        $services_title = $_POST['updateServices_title'];
        $services_desc = $_POST['updateServices_desc'];

        $services_title = ucwords(strtolower($services_title));
        $services_desc = capitalizeSentences($services_desc);

        $services_title = mysqli_real_escape_string($con, $services_title);
        $services_desc = mysqli_real_escape_string($con, $services_desc);

        if (empty($services_title) && empty($services_desc)) {
            header('Location: ../superAdminDashboard.php');
            exit;
        }

        $services_query = mysqli_query($con, "UPDATE `tbl_services` SET `services_title` = '$services_title', `services_desc` = '$services_desc' WHERE `services_id` = '$services_id'");

        // add logs
        $userid = $_SESSION['user_id'];
        $user_name = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name changed the second home subtitle', CURRENT_TIMESTAMP,'$userid')");

        if ($services_query) {
            $_SESSION['update_services_message'] = "Service successfully updated";
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
