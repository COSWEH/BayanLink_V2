<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../post.c.php');
    exit;
}

$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

// If user does not exist, sign out
if ($countUser < 1) {
    header('Location: ../signout.php');
    exit;
}

// If user role is not civilian
if ($user_role != 0) {
    header('Location: ../unauthorized.php');
    exit;
}



// Query to check notifications
$checkNotif = mysqli_query($con, "SELECT * FROM `tbl_notification` WHERE `user_id` = '$getUserid' AND `status` = 'unread'");

// Check if the query was successful
if ($checkNotif) {
    $countNotif = mysqli_num_rows($checkNotif);

    // Display notification badge if there are unread notifications
    if ($countNotif > 0) {
        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">';
        echo $countNotif;
        echo '</span>';
    }
} else {
    // Handle query error (optional)
    echo 'Error fetching notifications: ' . mysqli_error($con);
}
