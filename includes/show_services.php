<?php
include('conn.inc.php');

$services_query = "SELECT * FROM `tbl_services` ORDER BY `services_created_at` DESC";
$services_result = mysqli_query($con, $services_query);

$response = array();

if (mysqli_num_rows($services_result) > 0) {
    while ($row = mysqli_fetch_assoc($services_result)) {
        $service_data = array(
            'services_id' => $row['services_id'],
            'services_title' => $row['services_title'],
            'services_desc' => $row['services_desc']
        );
        $response[] = $service_data;
    }
} else {
    $response['error'] = "No data found";
}

echo json_encode($response);
