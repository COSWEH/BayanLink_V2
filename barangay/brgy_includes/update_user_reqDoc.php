<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../phpmailer/src/Exception.php';
require '../../phpmailer/src/PHPMailer.php';
require '../../phpmailer/src/SMTP.php';

include('../../includes/conn.inc.php');
$config = include('../../config/config.php');
session_start();

$admin_brgy = $_SESSION['user_brgy'];
$get_Time_And_Day = new DateTime();
$formattedDate = $get_Time_And_Day->format('h:i A D, M j, Y');
$getStatus = $_SESSION['getStatus'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ifProcessOrApprove = $_POST['ifProcessOrApprove'];

    if ($ifProcessOrApprove == "Process") {
        $process_req_id = $_POST['getProcessReqDocId'];
        $process_status = "Processing";

        $getRequesterID = mysqli_query($con, "SELECT `user_id` FROM `tbl_requests` WHERE `req_id` = $process_req_id");
        $getResult = mysqli_fetch_assoc($getRequesterID);
        $civilianID = $getResult['user_id'];

        $getCivilianEmail = mysqli_query($con, "SELECT `user_email` FROM `tbl_useracc` WHERE `user_id` = $civilianID");
        $getCivilianResult = mysqli_fetch_assoc($getCivilianEmail);
        $civilianEmail = $getCivilianResult['user_email'];


        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$process_status' WHERE `req_id` = '$process_req_id'");

        $notify_query = mysqli_query($con, "INSERT INTO `tbl_notification`(`notify_id`, `user_id`, `description`, `status`, `notify_date`) VALUES ('', '$civilianID', 'Processed', 'unread', CURRENT_TIMESTAMP)");

        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username proccessed a document', CURRENT_TIMESTAMP,'$user_id')");

        $message = "
            <h2 style='color: #2c3e50;'>Document Request Processed</h2>
            <p>Dear Citizen,</p>
            <p>We are pleased to inform you that your document request is now being processed by <strong>Brgy. $admin_brgy</strong>.</p>
            <p><strong>Processing Date:</strong> $formattedDate</p>
            <p>Thank you for using BayanLink for your document needs. You will receive further instructions if necessary.</p>
            <br>
            <p>Best regards,</p>
            <p><strong>The BayanLink Team</strong></p>
            <p style='font-size: 12px; color: #7f8c8d;'>This is an automated message, please do not reply.</p>
        ";

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($config['email'], 'BayanLink');

        $mail->addAddress($civilianEmail);

        $mail->isHTML(true);

        $mail->Subject = "Document Request Processed by $admin_brgy Barangay Administration";
        $mail->Body = $message;

        $mail->send();

        if ($query) {
            $_SESSION['processing_message'] = "Success!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif ($ifProcessOrApprove == "Approve") {
        //echo "approve";
        echo $approve_req_id = $_POST['getApproveReqDocId'];
        $approve_status = "Approved";

        $getRequesterID = mysqli_query($con, "SELECT `user_id` FROM `tbl_requests` WHERE `req_id` = $approve_req_id");
        $getResult = mysqli_fetch_assoc($getRequesterID);
        $civilianID = $getResult['user_id'];


        $getCivilianEmail = mysqli_query($con, "SELECT `user_email` FROM `tbl_useracc` WHERE `user_id` = $civilianID");
        $getCivilianResult = mysqli_fetch_assoc($getCivilianEmail);
        $civilianEmail = $getCivilianResult['user_email'];

        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$approve_status' WHERE `req_id` = '$approve_req_id'");

        $notify_query = mysqli_query($con, "INSERT INTO `tbl_notification`(`notify_id`, `user_id`, `description`, `status`, `notify_date`) VALUES ('', '$civilianID', 'Approved', 'unread', CURRENT_TIMESTAMP)");

        // add logs
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username approved a document', CURRENT_TIMESTAMP,'$user_id')");

        $message = "
            <h2 style='color: #2c3e50;'>Document Request Approved</h2>
            <p>Dear Citizen,</p>
            <p>We are pleased to inform you that your document request has been approved by <strong>$admin_brgy Barangay Administration</strong>.</p>
            <p><strong>Approval Date:</strong> $formattedDate</p>
            <p>Thank you for choosing BayanLink. Your approved document is now ready for the next steps.</p>
            <br>
            <p>Best regards,</p>
            <p><strong>The BayanLink Team</strong></p>
            <p style='font-size: 12px; color: #7f8c8d;'>This is an automated message, please do not reply.</p>
        ";

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($config['email'], 'BayanLink');

        $mail->addAddress($civilianEmail);

        $mail->isHTML(true);

        $mail->Subject = "Document Request Approved by $admin_brgy Barangay Administration";
        $mail->Body = $message;

        $mail->send();

        if ($query) {
            $_SESSION['approved_message'] = "Approved!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    } elseif ($ifProcessOrApprove == "Cancel") {
        $cancel_req_id = $_POST['getCancelReqDocId'];
        $cancel_status = "Cancelled";

        $cancellationReason = implode(", ", $_POST['options-base']);

        $getRequesterID = mysqli_query($con, "SELECT `user_id` FROM `tbl_requests` WHERE `req_id` = $cancel_req_id");
        $getResult = mysqli_fetch_assoc($getRequesterID);
        $civilianID = $getResult['user_id'];

        $getCivilianEmail = mysqli_query($con, "SELECT `user_email` FROM `tbl_useracc` WHERE `user_id` = $civilianID");
        $getCivilianResult = mysqli_fetch_assoc($getCivilianEmail);
        $civilianEmail = $getCivilianResult['user_email'];

        $query = mysqli_query($con, "UPDATE `tbl_requests` SET `req_status` = '$cancel_status', `req_reasons` = '$cancellationReason' WHERE `req_id` = '$cancel_req_id'");

        $notify_query = mysqli_query($con, "INSERT INTO `tbl_notification`(`notify_id`, `user_id`, `description`, `status`, `notify_date`) VALUES ('', '$civilianID', 'Cancelled', 'unread', CURRENT_TIMESTAMP)");

        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        mysqli_query($con, "INSERT INTO `tbl_logs`(`log_id`, `log_desc`, `log_date`, `user_id`) VALUES ('','User $username cancelled a document', CURRENT_TIMESTAMP,'$user_id')");

        $cancellationReason = trim($cancellationReason);
        $cancellationReason = rtrim($cancellationReason, ', ');

        $reasonList = ''; // Initialize the variable to store the HTML list

        if (!empty($cancellationReason)) {
            // Convert the comma-separated string into an array and clean up
            $cancellationReasonArray = array_map('trim', explode(", ", $cancellationReason));
            $cancellationReasonArray = array_filter($cancellationReasonArray);

            // Create the HTML list of reasons
            $reasonList = "<hr>
                   <h6>Cancellation Reasons:</h6>
                   <ul>";
            foreach ($cancellationReasonArray as $reason) {
                // Escape each reason for safe HTML output
                $escapedReason = htmlspecialchars($reason, ENT_QUOTES, 'UTF-8');
                $reasonList .= "<li><small>$escapedReason</small></li>";
            }
            $reasonList .= '</ul>';
        }

        // Create the message with cancellation reasons included
        $message = "
            <h2 style='color: #c0392b;'>Document Request Cancelled</h2>
            <p>Dear Citizen,</p>
            <p>We regret to inform you that your document request has been cancelled by <strong>$admin_brgy Barangay Administration</strong>.</p>
            <p><strong>Cancellation Date:</strong> $formattedDate</p>
            $reasonList
            <p>If you have any questions or need further assistance, please feel free to contact your barangay office.</p>
            <br>
            <p>With regards,</p>
            <p><strong>The BayanLink Team</strong></p>
            <p style='font-size: 12px; color: #7f8c8d;'>This is an automated message, please do not reply.</p>
        ";

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $config['email'];
        $mail->Password = $config['password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($config['email'], 'BayanLink');

        $mail->addAddress($civilianEmail);

        $mail->isHTML(true);

        $mail->Subject = "Document Request Cancelled by $admin_brgy Barangay Administration";
        $mail->Body = $message;

        $mail->send();

        if ($query) {
            $_SESSION['cancelled_message'] = "Cancelled!";
            header('Location: ../adminDocument.b.php');
            exit;
        } else {
            die('Error: ' . mysqli_error($con));
        }
    }
} else {
    header('location: ../adminDocument.b.php');
    exit;
}
