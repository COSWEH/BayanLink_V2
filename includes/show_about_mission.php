<?php
include('conn.inc.php');

$about_mission_query = "SELECT * FROM `tbl_about_mission`";
$about_mission_result = mysqli_query($con, $about_mission_query);

$response = array();

if (mysqli_num_rows($about_mission_result) > 0) {
    $row = mysqli_fetch_assoc($about_mission_result);
    $response['about_mission_id'] = $row['about_mission_id'];
    $response['about_us'] = $row['about_us'];
    $response['our_mission'] = $row['our_mission'];
} else {
    $response['error'] = "No data found";
}

echo json_encode($response);
