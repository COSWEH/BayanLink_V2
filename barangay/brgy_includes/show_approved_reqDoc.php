<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../adminDocument.b.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT req_id, user_id, req_date, req_fname, req_mname, req_lname, req_contactNo, req_gender, req_brgy, req_purok, req_age, req_dateOfBirth, req_placeOfBirth, req_civilStatus, req_eSignature, req_typeOfDoc, req_valid_id, req_status
          FROM tbl_requests
          WHERE req_brgy = '$civilian_brgy' && req_status = 'Approved'
          ORDER BY req_date DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

$rowCount = mysqli_num_rows($result);
if ($rowCount == 0) {
    echo "<p>No document requests found.</p>";
} else {
?>
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
                while ($data = mysqli_fetch_assoc($result)) {
                    // Fetch data from tbl_requests
                    $reqId = $data['req_id'];
                    $userId = $data['user_id'];
                    $reqDate = $data['req_date'];
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
                    $get_Time_And_Day = new DateTime($reqDate);
                    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');


                    $_SESSION['getRequesterID'] = $userId;
                ?>
                    <tr>
                        <td><small><?php echo htmlspecialchars($docType); ?></small></td>
                        <td><small><?php echo htmlspecialchars($fname . " " . $mname . " " . $lname); ?></small></td>
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
                                <a href="#" data-bs-toggle="modal" data-bs-target="#esModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>">
                                    <img src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_eSignature); ?>" class="img-fluid rounded" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                </a>
                            <?php } else { ?>
                                <span>No E-Signature</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($req_valid_id)) { ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#vidModal<?php echo $status; ?>" data-image-src="../civilian/civilian_dbImg/<?php echo htmlspecialchars($req_valid_id); ?>">
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
                ?>
            </tbody>
        </table>
    </div>

    <!-- es Modal -->
    <div class="modal fade" id="esModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="esModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-warning-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                        <i class="bi bi-image text-warning" style="font-size: 25px;"></i>
                    </div>
                    <h5 class="modal-title mb-3">View Image</h5>
                    <img id="esModalImage<?php echo $status; ?>" class="img-fluid rounded-2" style="max-width: 100%; height: auto;">
                    <div class="d-grid gap-3 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- vid Modal -->
    <div class="modal fade" id="vidModal<?php echo $status; ?>" tabindex="-1" aria-labelledby="vidModal<?php echo $status; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-warning-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                        <i class="bi bi-image text-warning" style="font-size: 25px;"></i>
                    </div>
                    <h5 class="modal-title mb-3">View Video</h5>
                    <img id="vidModalImage<?php echo $status; ?>" class="img-fluid rounded-2" style="max-width: 100%; height: auto;">
                    <div class="d-grid gap-3 mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('#esModal<?php echo $status; ?>').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let imageSrc = button.data('image-src');
                let modalImage = $(this).find('#esModalImage<?php echo $status; ?>');
                modalImage.attr('src', imageSrc);
            });

            $('#vidModal<?php echo $status; ?>').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let imageSrc = button.data('image-src');
                let modalImage = $(this).find('#vidModalImage<?php echo $status; ?>');
                modalImage.attr('src', imageSrc);
            });


        });
    </script>
<?php
}
?>