<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['value'])) {
    header('location: ../adminPost.b.php');
    exit;
}

$postId = $_POST['value'];

$query = "SELECT post_img FROM tbl_posts WHERE post_id = '$postId'";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

$data = mysqli_fetch_assoc($result);
$post_img = $data['post_img'];

if (!empty($post_img)) {
    $imgArray = json_decode($post_img, true);
    if (is_array($imgArray)) {
        echo json_encode($imgArray);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
