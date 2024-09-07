<?php
include('conn.inc.php');

$contact_query = "SELECT * FROM `tbl_contact`";
$contact_result = mysqli_query($con, $contact_query);

$response = array();

$contact_numbers = array();
$contact_emails = array();
$contact_locations = array();

while ($row = mysqli_fetch_assoc($contact_result)) {
    if (!empty($row['contact_number'])) {
        $contact_numbers[] = $row['contact_number'];
    }
    if (!empty($row['contact_email'])) {
        $contact_emails[] = $row['contact_email'];
    }
    if (!empty($row['contact_location'])) {
        $contact_locations[] = $row['contact_location']; // Assuming location is the same for all rows
    }
}

if (!empty($contact_numbers)) {
    $response['contact_number'] = $contact_numbers;
}
if (!empty($contact_emails)) {
    $response['contact_email'] = $contact_emails;
}
if (!empty($contact_locations)) {
    $response['contact_location'] = $contact_locations; // Or you can remove this line if you don't want to send location if it is NULL
}

// if (empty($response)) {
//     $response['error'] = "No data found";
// }

header('Content-Type: application/json');
echo json_encode($response);
