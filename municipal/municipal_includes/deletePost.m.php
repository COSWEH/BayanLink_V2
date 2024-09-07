<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['baBtnDeletePost'])) {
    $post_id =  $_POST['getPostIdToDelete'];
    $img = $_SESSION['getImg'];
    $imgArray = json_decode($img, true);

    // check if success to decode
    if ($imgArray) {
        foreach ($imgArray as $imgFile) {
            $filePath = '../municipal_dbImages/' . $imgFile;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    $query = mysqli_query($con, "DELETE FROM `tbl_posts` WHERE `post_id` = '$post_id'");

    // add logs
    $userid = $_SESSION['user_id'];
    $user_name = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $user_name deleted a posts', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['delete_message'] = "Post successfully deleted";
        header('Location: ../superAdminPost.m.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../superAdminPost.m.php');
    exit;
}
