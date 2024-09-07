<?php
include('../../includes/conn.inc.php');

$contact_query = "SELECT * FROM `tbl_contact`";
$contact_result = mysqli_query($con, $contact_query);

$response = array();

if (mysqli_num_rows($contact_result) > 0) {
    while ($row = mysqli_fetch_assoc($contact_result)) {
        $contact_data = array(
            'contact_id' => $row['contact_id'],
            'contact_number' => $row['contact_number'],
            'contact_email' => $row['contact_email'],
            'contact_location' => $row['contact_location']
        );
        $response[] = $contact_data;
    }
} else {
    $response['error'] = "No data found";
}

header('Content-Type: application/json');
echo json_encode($response);
