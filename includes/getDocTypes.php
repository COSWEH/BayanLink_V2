<?php
include('conn.inc.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../civilian/document.c.php');
    exit;
}

// Query to select all document types from tbl_typeDoc
$sql = "SELECT `docType` FROM `tbl_typedoc`";
$result = mysqli_query($con, $sql);

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    // Start building the options
    $options = '<option value="" disabled selected>Select Document</option>';

    // Fetch each row and create an option element
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= '<option value="' . htmlspecialchars($row['docType'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row['docType'], ENT_QUOTES, 'UTF-8') . '</option>';
    }
} else {
    $options = '<option value="" disabled>No Document found</option>';
}

echo $options; // Return the options
