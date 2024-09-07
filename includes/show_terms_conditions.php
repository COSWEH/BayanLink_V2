<?php
include('conn.inc.php');

$tm_query = "SELECT * FROM `tbl_terms_conditions` ORDER BY tm_id ASC";
$tm_result = mysqli_query($con, $tm_query);

$response = array();
$count = 1;

if (mysqli_num_rows($tm_result) > 0) {
    while ($row = mysqli_fetch_assoc($tm_result)) {
        $response[] = array(
            'count' => $count++,  // Increment count for each term
            'tm_id' => $row['tm_id'],
            'tm_title' => $row['tm_title'],
            'tm_content' => $row['tm_content']
        );
    }
} else {
    $response['error'] = "No data found";
}

echo json_encode($response);
