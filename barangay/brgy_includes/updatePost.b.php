<?php
include('../../includes/conn.inc.php');
session_start();

//bgUpdatePhotos
if (isset($_POST['baBtnEditPost']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['getPostIdToUpdate'];
    $userid = $_SESSION['user_id'];
    $post_brgy = $_SESSION['getAdminBrgy'];
    $content = $_POST['baTextContent'];

    $username = $_SESSION['username'];

    $dbImgArray = [];
    $selectedImgArray = [];
    $maxSize = 8 * 1024 * 1024; // 8MB in bytes

    if (isset($_POST['bgDbPhotos'])) {
        $jsonString = $_POST['bgDbPhotos'];
        $dbImgArray = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            echo 'Decoded DB JSON: ';
            print_r($dbImgArray);
        }
    } else {
        echo 'bgDbPhotos is not set.';
    }

    if (!empty($_FILES['bgUpdatePhotos']['name'][0])) {
        $imgCount = count($_FILES['bgUpdatePhotos']['name']);

        for ($i = 0; $i < $imgCount; $i++) {
            $imgName = $_FILES['bgUpdatePhotos']['name'][$i];
            $tmpName = $_FILES['bgUpdatePhotos']['tmp_name'][$i];
            $imgSize = $_FILES['bgUpdatePhotos']['size'][$i];

            // Check if the image size exceeds the maximum allowed size
            if ($imgSize > $maxSize) {
                die('Error: Each image must be 8MB or smaller.');
            }

            $imgExtension = explode('.', $imgName);
            $imgExtension = strtolower(end($imgExtension));

            $imgBaseName = pathinfo($imgName, PATHINFO_FILENAME);
            $newImgName = $imgBaseName . '-[BayanLink-' . uniqid() . '].' . $imgExtension;

            // move to the local folder
            move_uploaded_file($tmpName, '../brgy_dbImages/' . $newImgName);
            $selectedImgArray[] = $newImgName;
        }
    } else {
        $selectedImgArray = [];
    }

    if (!is_array($dbImgArray)) {
        $dbImgArray = [];
    }

    if (!is_array($selectedImgArray)) {
        $selectedImgArray = [];
    }

    $combinedImgArray = array_merge($dbImgArray, $selectedImgArray);

    echo '<br><br>Combined Images Array: ';
    print_r($combinedImgArray);

    $combinedImgArrayJson = json_encode($combinedImgArray);

    echo '<br><br>Combined Images Array: ';
    print_r($combinedImgArray);

    $combinedImgArrayJson = json_encode($combinedImgArray);
    $content = strip_tags($content); // Remove HTML tags
    $content = mysqli_real_escape_string($con, $content); // Escape special characters for SQL

    $query = mysqli_query($con, "UPDATE `tbl_posts` SET 
    `user_id` = '$userid', 
    `post_brgy` = '$post_brgy', 
    `post_content` = '$content', 
    `post_img` = '$combinedImgArrayJson', 
    `post_date` = CURRENT_TIMESTAMP 
    WHERE `post_id` = '$post_id'");

    // add logs
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username updated a post', CURRENT_TIMESTAMP,'$userid')");

    // Check for success
    if ($query) {
        $_SESSION['post_message'] = "Post successfully updated";
        header('Location: ../adminPost.b.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
} else {
    header('location: ../adminPost.b.php');
    exit;
}
