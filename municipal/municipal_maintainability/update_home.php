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

if (isset($_POST['btnHomeContent']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $home_content_id = $_POST['home_content_id'];
    $home_content_title = $_POST['home_content_title'];
    $home_content_subtitle1 = $_POST['home_content_subtitle1'];
    $home_content_subtitle2 = $_POST['home_content_subtitle2'];

    $home_content_subtitle1 = capitalizeSentences($home_content_subtitle1);
    $home_content_subtitle2 = capitalizeSentences($home_content_subtitle2);

    $home_content_title = mysqli_real_escape_string($con, $_POST['home_content_title']);
    $home_content_subtitle1 = mysqli_real_escape_string($con, $_POST['home_content_subtitle1']);
    $home_content_subtitle2 = mysqli_real_escape_string($con, $_POST['home_content_subtitle2']);

    $upload_dir = '../../index_dbImg/';
    $home_content_img = $_FILES['home_content_img'];

    // Initialize the SQL query parts
    $set_parts = [];
    $update_img = false;

    if ($home_content_img['size'] > 8 * 1024 * 1024) { // 8MB
        $_SESSION['update_content_img_error'] = "Image size should not exceed 8MB.";
        header('Location: ../superAdminDashboard.php');
        exit;
    }

    // Fetch the current image path from the database
    $result = mysqli_query($con, "SELECT `home_img` FROM `tbl_home` WHERE `home_id` = '$home_content_id'");
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $current_img_path = $upload_dir . $row['home_img'];
    } else {
        die('Error: Unable to fetch current image path from database.');
    }

    // Check if new image is uploaded and move it
    if ($home_content_img['size'] > 0) {
        $temp_name = $home_content_img['tmp_name'];
        $original_name = $home_content_img['name'];
        $upload_file = $upload_dir . basename($original_name);

        if (move_uploaded_file($temp_name, $upload_file)) {
            $home_img_path = basename($original_name);
            $update_img = true;

            // Delete the old image if it exists
            if (file_exists($current_img_path) && $row['home_img'] !== basename($original_name)) {
                unlink($current_img_path);
            }
        } else {
            die('Error: Unable to move uploaded file.');
        }
    }

    // Prepare the SQL update query dynamically
    if (!empty($home_content_title)) {
        $set_parts[] = "`home_title` = '$home_content_title'";
    }
    if (!empty($home_content_subtitle1)) {
        $set_parts[] = "`home_subtitleOne` = '$home_content_subtitle1'";
    }
    if (!empty($home_content_subtitle2)) {
        $set_parts[] = "`home_subtitleTwo` = '$home_content_subtitle2'";
    }
    if ($update_img) {
        $set_parts[] = "`home_img` = '$home_img_path'";
    }

    if (empty($set_parts)) {
        $_SESSION['no_fileds_update_message'] = "No fields to update.";
        header('Location: ../superAdminDashboard.php');
        exit;
    }

    $set_clause = implode(', ', $set_parts);
    $home_content_query = mysqli_query($con, "UPDATE `tbl_home` SET $set_clause WHERE `home_id` = '$home_content_id'");

    // Add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name changed the home content', CURRENT_TIMESTAMP,'$userid')");

    // Check if the query was successful
    if ($home_content_query) {
        $_SESSION['update_content_message'] = "Home content successfully updated";
        header('Location: ../superAdminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('Location: ../superAdminDashboard.php');
    exit;
}
