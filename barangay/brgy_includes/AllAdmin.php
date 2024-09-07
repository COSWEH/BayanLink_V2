<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../adminProfiling.b.php');
    exit;
}

$adminBrgy = $_SESSION['user_brgy'];

$getUserQuery = "SELECT * FROM `tbl_useracc` WHERE `user_brgy` = '$adminBrgy' AND `role_id` = 1";
$result = mysqli_query($con, $getUserQuery);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}
?>

<div class="table-responsive ">
    <table class="table table-responsive table-bordered border border-3 table-hover text-center text-capitalized">
        <thead class="table-active text-uppercase text-white">
            <tr>
                <th style="width: 11.11%;"><small>Full Name</small></th>
                <th style="width: 11.11%;"><small>Sex</small></th>
                <th style="width: 11.11%;"><small>Barangay</small></th>
                <th style="width: 11.11%;"><small>Purok</small></th>
                <th style="width: 11.11%;"><small>Age</small></th>
                <th style="width: 11.11%;"><small>Date of Birth</small></th>
                <th style="width: 11.11%;"><small>Place of Birth</small></th>
                <th style="width: 11.11%;"><small>Civil Status</small></th>
                <th style="width: 11.11%;"><small>Action</small></th>
            </tr>

        </thead>
        <tbody>
            <?php
            while ($data = mysqli_fetch_assoc($result)) {
                $adminID = $data['user_id'];
                $fname = $data['user_fname'];
                $mname = $data['user_mname'];
                $lname = $data['user_lname'];
                $fullname = $fname . ' ' . $mname . ' ' . $lname;

                $fullname = strtolower($fullname);
                $fullname = ucwords($fullname);

                $sex = $data['user_gender'];
                $brgy = $data['user_brgy'];
                $purok = $data['user_purok'];
                $age = $data['user_age'];
                $dateOfBirth = $data['dateOfBirth'];
                $placeOfBirth = $data['placeOfBirth'];
                $civilStatus = $data['civilStatus'];
            ?>
                <tr>
                    <td><small><?php echo htmlspecialchars($fullname); ?></small></td>
                    <td><small><?php echo htmlspecialchars($sex); ?></small></td>
                    <td><small><?php echo htmlspecialchars($brgy); ?></small></td>
                    <td><small><?php echo htmlspecialchars($purok); ?></small></td>
                    <td><small><?php echo htmlspecialchars($age); ?></small></td>
                    <td><small><?php echo htmlspecialchars($dateOfBirth); ?></small></td>
                    <td><small><?php echo htmlspecialchars($placeOfBirth); ?></small></td>
                    <td><small><?php echo htmlspecialchars($civilStatus); ?></small></td>
                    <td><button type="button" class="btn btn-sm btn-danger aDelete" data-post-id="<?php echo $adminID; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete <i class=" bi bi-trash ms-2"></i></button></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Delete Admin Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center align-items-center rounded-circle bg-danger-subtle mx-auto" style="height: 50px; width: 50px;">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 25px;"></i>
                </div>

                <h6 class="my-3 fw-semibold">Are you sure?</h6>
                <p class="text-muted">This action cannot be undone. Please confirm your decision.</p>
                <form action="brgy_includes/deleteAdmin.php" method="POST">
                    <input type="hidden" id="getAdminID" name="getAdminID">
                    <div class="d-grid gap-3 mx-4">
                        <button type="submit" name="btnDeleteAcc" class="btn btn-danger">
                            Delete account
                        </button>
                        <button type="button" class="btn border border-2" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.aDelete', function() {
            let sa_id = $(this).data('post-id');
            console.log(sa_id);
            $('#getAdminID').val(sa_id);
        });
    });
</script>