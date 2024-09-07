<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../adminProfiling.b.php');
    exit;
}

$getDocType = "SELECT * FROM `tbl_typedoc`";
$result = mysqli_query($con, $getDocType);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}
?>

<div class="table-responsive ">
    <table class="table table-responsive table-bordered border border-3 table-hover text-center text-capitalized">
        <thead class="table-active text-uppercase text-white">
            <tr>
                <th style="width: 33.33%;"><small>Document ID</small></th>
                <th style="width: 33.33%;"><small>Document Type</small></th>
                <th style="width: 33.33%;"><small>Action</small></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($data = mysqli_fetch_assoc($result)) {
                $id = $data['id'];
                $docType = $data['docType'];
            ?>
                <tr>
                    <td><small><?php echo htmlspecialchars($id); ?></small></td>
                    <td><small><?php echo htmlspecialchars($docType); ?></small></td>
                    <td><button type="button" class="btn btn-sm btn-danger aDelete" data-doc-id="<?php echo $id; ?>" data-bs-toggle="modal" data-bs-target="#docTypeModal">Delete <i class="bi bi-trash ms-2"></i></button></td>
                </tr>

            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Delete Document Modal -->
<div class="modal fade" id="docTypeModal" tabindex="-1" aria-labelledby="docTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center align-items-center rounded-circle bg-danger-subtle mx-auto" style="height: 50px; width: 50px;">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 25px;"></i>
                </div>

                <h6 class="my-3 fw-semibold">Are you sure?</h6>
                <p class="text-muted">This action cannot be undone. Please confirm your decision.</p>
                <form action="brgy_includes/deleteDocTpe.php" method="POST">
                    <input type="hidden" id="getDocTypeID" name="getDocTypeID">
                    <div class="d-grid gap-3 mx-4">
                        <button type="submit" name="btnDeleteDocType" class="btn btn-danger">
                            Delete document
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
            let sa_id = $(this).data('doc-id');
            console.log(sa_id);
            $('#getDocTypeID').val(sa_id);
        });
    });
</script>