<?php
include('../../includes/conn.inc.php');
session_start();

if (isset($_POST['btnAddDocument']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $documentType = ucwords(strtolower($_POST['documentType']));
    $documentTemplate = $_FILES['documentTemplate'];

    if (empty($documentType)) {
        $_SESSION['add_doc_message'] = "Document Type is required";
        header('Location: ../adminDashboard.php');
        exit;
    }

    // Validate and handle file upload
    $allowedExtensions = ['pdf'];
    $fileExtension = strtolower(pathinfo($documentTemplate['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        $_SESSION['add_doc_message'] = "Only PDF files are allowed";
        header('Location: ../adminDashboard.php');
        exit;
    }

    // Check for upload errors
    if ($documentTemplate['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['add_doc_message'] = "Error uploading file";
        header('Location: ../adminDashboard.php');
        exit;
    }

    $uploadDir = '../../includes/doc_template/';
    $fileName = basename($documentTemplate['name']); // Get the file name
    $uploadFile = $uploadDir . $fileName;

    if (!move_uploaded_file($documentTemplate['tmp_name'], $uploadFile)) {
        $_SESSION['add_doc_message'] = "Failed to upload file";
        header('Location: ../adminDashboard.php');
        exit;
    }

    $documentType = mysqli_real_escape_string($con, $documentType);
    $fileName = mysqli_real_escape_string($con, $fileName);

    $query = mysqli_query($con, "INSERT INTO `tbl_typedoc`(`id`, `docType`, `doc_template`) VALUES ('', '$documentType', '$fileName')");

    // add logs
    $userid = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username added a document', CURRENT_TIMESTAMP,'$userid')");

    if ($query) {
        $_SESSION['add_doc_message'] = "Document successfully addedd";
        header('Location: ../adminDashboard.php');
        exit;
    } else {
        die('Error: ' . mysqli_error($con));
    }
}
