<?php
include('conn.inc.php');

$home_query = "SELECT * FROM `tbl_home`";
$home_result = mysqli_query($con, $home_query);

$response = array();

if (mysqli_num_rows($home_result) > 0) {
    $row = mysqli_fetch_assoc($home_result);
    $response['home_id'] = $row['home_id'];
    $response['home_title'] = $row['home_title'];
    $response['home_subtitleOne'] = $row['home_subtitleOne'];
    $response['home_subtitleTwo'] = $row['home_subtitleTwo'];
    $response['home_img'] = $row['home_img'];
} else {
    $response['error'] = "No data found";
}

echo json_encode($response);
