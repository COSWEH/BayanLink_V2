<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['value'])) {
    $_SESSION['getPostId'] = $_POST['value'];

    $getPostId = $_SESSION['getPostId'];

    $selectContent = "SELECT post_content FROM tbl_posts where post_id = '$getPostId'";
    $query = mysqli_query($con, $selectContent);
    $contentData = mysqli_fetch_assoc($query);

    echo $post_content = $contentData['post_content'];
} else {
    header('location: ../adminPost.b.php');
    exit;
}
