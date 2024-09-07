<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../adminDocument.b.php');
    exit;
}

$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];
$admin_brgy = $_SESSION['user_brgy'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

// If user does not exist, sign out
if ($countUser < 1) {
    header('Location: ../signout.php');
    exit;
}

// If user role is not brgy admin
if ($user_role != 1) {
    header('Location: ../unauthorized.php');
    exit;
}

$query = mysqli_query($con, "
    SELECT r.* 
    FROM tbl_requests r
    JOIN tbl_useracc u 
    ON r.user_id = u.user_id
    WHERE r.user_id = u.user_id
    AND u.user_brgy = '$admin_brgy' 
    AND r.req_status = 'Cancelled'
");

if ($query) {
    $countCancelled = mysqli_num_rows($query);

    // Display notification badge if there are unread notifications

    if ($countCancelled > 0) {
        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">';
        echo $countCancelled;
        echo '</span>';
    }
} else {
    // Handle query error (optional)
    echo 'Error fetching notifications: ' . mysqli_error($con);
}
