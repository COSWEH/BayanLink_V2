   
<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../post.c.php');
    exit;
}
$getUserid = $_SESSION['user_id'];


$updateNotif = mysqli_query($con, "UPDATE `tbl_notification` SET `status` = 'read' WHERE `user_id` = '$getUserid' AND `status` = 'unread'");

if ($updateNotif) {
    echo "Success";
} else {
    echo "Error: " . mysqli_error($con);
}
