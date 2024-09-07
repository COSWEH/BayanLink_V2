<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../adminDocument.b.php');
    exit;
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // SQL query to search for users by first name or last name
    $sql = "SELECT * FROM tbl_requests WHERE req_fname LIKE '%$query%' OR req_mname LIKE '%$query%' OR req_lname LIKE '%$query%'";
    $result = mysqli_query($con, $sql);

?>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-responsive table-bordered border border-3 table-hover text-center text-capitalized">
                <thead class="table-active text-uppercase text-white">
                    <tr>
                        <th style="width: 7.14%;"><small>Document Type</small></th>
                        <th style="width: 7.14%;"><small>Requester</small></th>
                        <th style="width: 7.14%;"><small>Purok</small></th>
                        <th style="width: 7.14%;"><small>Age</small></th>
                        <th style="width: 7.14%;"><small>Date of Birth</small></th>
                        <th style="width: 7.14%;"><small>Place of Birth</small></th>
                        <th style="width: 7.14%;"><small>Gender</small></th>
                        <th style="width: 7.14%;"><small>Civil Status</small></th>
                        <th style="width: 7.14%;"><small>Contact Number</small></th>
                        <th style="width: 7.14%;"><small>Barangay</small></th>
                        <th style="width: 7.14%;"><small>Date Requested</small></th>
                        <th style="width: 7.14%;"><small>e-Signature</small></th>
                        <th style="width: 7.14%;"><small>Valid ID</small></th>
                        <th style="width: 7.14%;"><small>Status</small></th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($data = mysqli_fetch_assoc($result)) {
                            $reqId = $data['req_id'];
                            $fname = $data['req_fname'];
                            $mname = $data['req_mname'];
                            $lname = $data['req_lname'];
                            $contactNo = $data['req_contactNo'];
                            $gender = $data['req_gender'];
                            $brgy = $data['req_brgy'];
                            $purok = $data['req_purok'];
                            $age = $data['req_age'];
                            $dateOfBirth = $data['req_dateOfBirth'];
                            $req_placeOfBirth = $data['req_placeOfBirth'];
                            $req_civilStatus = $data['req_civilStatus'];
                            $req_eSignature = $data['req_eSignature'];
                            $docType = $data['req_typeOfDoc'];
                            $status = $data['req_status'];
                            $req_valid_id = $data['req_valid_id'];
                            $formattedDate = (new DateTime($data['req_date']))->format('Y-m-d H:i:s');
                    ?>
                            <tr>
                                <td><small><?php echo htmlspecialchars($docType); ?></small></td>
                                <td><small><?php echo htmlspecialchars("$fname $mname $lname"); ?></small></td>
                                <td><small><?php echo htmlspecialchars($purok); ?></small></td>
                                <td><small><?php echo htmlspecialchars($age); ?></small></td>
                                <td><small><?php echo htmlspecialchars($dateOfBirth); ?></small></td>
                                <td><small><?php echo htmlspecialchars($req_placeOfBirth); ?></small></td>
                                <td><small><?php echo htmlspecialchars($gender); ?></small></td>
                                <td><small><?php echo htmlspecialchars($req_civilStatus); ?></small></td>
                                <td><small><?php echo htmlspecialchars($contactNo); ?></small></td>
                                <td><small><?php echo htmlspecialchars($brgy); ?></small></td>
                                <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                                <td>
                                    <?php if (!empty($req_eSignature)) { ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No E-Signature</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if (!empty($req_valid_id)) { ?>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>">
                                            <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </a>
                                    <?php } else { ?>
                                        <span>No Valid ID</span>
                                    <?php } ?>
                                </td>
                                <td><small><?php echo htmlspecialchars($status); ?></small></td>
                            </tr>
                <?php
                        }
                    } else {
                        echo '<tr><td colspan="15">No matching records found.</td></tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>