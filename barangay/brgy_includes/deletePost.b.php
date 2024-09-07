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
            $filePath = '../brgy_dbImages/' . $imgFile;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

    $query = mysqli_query($con, "DELETE FROM `tbl_posts` WHERE `post_id` = '$post_id'");

    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username deleted a post', CURRENT_TIMESTAMP,'$user_id')");

    if ($query) {
        $_SESSION['delete_message'] = "Post successfully deleted";
        header('Location: ../adminPost.b.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../adminPost.b.php');
    exit;
}
