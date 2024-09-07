<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnReqDocument']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['getUserid'];
    $req_fname = ucwords(strtolower($_POST['fName']));
    $req_mname = ucwords(strtolower($_POST['mName']));
    $req_lname = ucwords(strtolower($_POST['lName']));
    $req_contactNo = $_POST['contNumber'];
    $req_gender = ucwords(strtolower($_POST['user_gender']));
    $req_brgy = ucwords(strtolower($_POST['user_brgy']));
    $req_purok = $_POST['purok'];
    $req_age = $_POST['age'];
    $req_dateOfBirth = $_POST['dateOfBirth'];
    $req_placeOfBirth = ucwords(strtolower($_POST['placeOfBirth']));
    $req_civilStatus = ucwords(strtolower($_POST['civilStatus']));
    $req_typeOfDoc = $_POST['docType'];
    $req_status = "Pending";

    $username = $_SESSION['username'];

    $req_fname = mysqli_real_escape_string($con, $req_fname);
    $mname = mysqli_real_escape_string($con, $mname);
    $req_lname = mysqli_real_escape_string($con, $req_lname);
    $req_placeOfBirth = mysqli_real_escape_string($con, $req_placeOfBirth);

    if (
        empty($user_id) || empty($req_fname) || empty($req_lname) || empty($req_contactNo) || empty($req_gender) ||
        empty($req_brgy) || empty($req_purok) || empty($req_age) || empty($req_dateOfBirth) || empty($req_placeOfBirth) ||
        empty($req_civilStatus) || empty($req_typeOfDoc)
    ) {
        header('location: ../document.c.php');
        exit;
    }

    // File size limit (e.g., 8MB)
    $maxFileSize = 8 * 1024 * 1024; // 8MB in bytes

    // Handle the file upload
    if (isset($_FILES['userValidID']) && isset($_FILES['eSignature'])) {
        // Handling eSignature file
        $eSignatureFile = $_FILES['eSignature'];
        if ($eSignatureFile['error'] !== UPLOAD_ERR_OK) {
            die('Error: E-Signature file upload error.');
        }

        if ($eSignatureFile['size'] > $maxFileSize) {
            die('Error: E-Signature file size exceeds the limit of 8MB.');
        }

        $eSignatureName = $eSignatureFile['name'];
        $eSignatureTmpName = $eSignatureFile['tmp_name'];

        $eSignatureExtension = strtolower(pathinfo($eSignatureName, PATHINFO_EXTENSION));
        $eSignatureBaseName = pathinfo($eSignatureName, PATHINFO_FILENAME);
        $newESignatureName = $eSignatureBaseName . '-[BayanLink-' . uniqid() . '].' . $eSignatureExtension;

        // Handling userValidID file
        $validIDFile = $_FILES['userValidID'];
        if (
            $validIDFile['error'] !== UPLOAD_ERR_OK
        ) {
            die('Error: Valid ID file upload error.');
        }

        // Check file size
        if ($validIDFile['size'] > $maxFileSize) {
            die('Error: Valid ID file size exceeds the limit of 8MB.');
        }

        $validIDName = $validIDFile['name'];
        $validIDTmpName = $validIDFile['tmp_name'];

        $validIDExtension = strtolower(pathinfo($validIDName, PATHINFO_EXTENSION));
        $validIDBaseName = pathinfo($validIDName, PATHINFO_FILENAME);
        $newValidIDName = $validIDBaseName . '-[BayanLink-' . uniqid() . '].' . $validIDExtension;

        $eSignaturePath = '../civilian_dbImg/' . $newESignatureName;
        $validIDPath = '../civilian_dbImg/' . $newValidIDName;

        // Check directory existence and create if necessary
        if (!is_dir('../civilian_dbImg')) {
            mkdir(
                '../civilian_dbImg',
                0755,
                true
            );
        }

        // Move uploaded files
        if (!move_uploaded_file($eSignatureTmpName, $eSignaturePath)) {
            die('Error: Failed to move E-Signature file.');
        }
        if (!move_uploaded_file($validIDTmpName, $validIDPath)) {
            die('Error: Failed to move Valid ID file.');
        }

        echo 'Files uploaded successfully.';
    } else {
        die('Error: No files uploaded or there was an upload error.');
    }

    $checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$user_id' LIMIT 1");
    $countUser = mysqli_num_rows($checkUser);

    if ($countUser > 0) {

        // $query = mysqli_query($con, "INSERT INTO `tbl_requests`(`req_id`, `user_id`, `req_date`, `req_fname`, `req_mname`, `req_lname`, `req_contactNo`, `req_brgy`, `req_typeOfDoc`, `req_valid_id`, `req_password`, `req_status`) VALUES ('', '$user_id', CURRENT_TIMESTAMP, '$req_fname', '$req_lname', '$req_contactNo', '$req_brgy', '$req_typeOfDoc', '$newValidIDName', '$req_password', '$req_status')");

        $query = mysqli_query($con, "INSERT INTO `tbl_requests` (`req_id`, `user_id`, `req_date`, `req_fname`, `req_mname`, `req_lname`, `req_contactNo`, `req_gender`, `req_brgy`, `req_purok`, `req_age`, `req_dateOfBirth`, `req_placeOfBirth`, `req_civilStatus`, `req_eSignature`, `req_typeOfDoc`, `req_valid_id`, `req_status`) VALUES ('', '$user_id', CURRENT_TIMESTAMP, '$req_fname', '$req_mname', '$req_lname', '$req_contactNo', '$req_gender', '$req_brgy', '$req_purok', '$req_age', '$req_dateOfBirth', '$req_placeOfBirth', '$req_civilStatus', '$newESignatureName', '$req_typeOfDoc', '$newValidIDName', '$req_status')");

        // add logs
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username requested a $req_typeOfDoc', CURRENT_TIMESTAMP,'$user_id')");

        if ($query) {
            $_SESSION['reqDoc_message'] = "Document submitted";
            header('location: ../document.c.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
} else {
    header('location: ../document.c.php');
    exit;
}
