<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../superAdminDashboard.php');
    exit;
}

$getFaqs = "SELECT * FROM `tbl_faqs` ORDER BY `faq_created_at` DESC";
$result = mysqli_query($con, $getFaqs);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}
?>

<div class="table-responsive ">
    <table class="table table-responsive table-bordered border border-3 table-hover text-center text-capitalized">
        <thead class="table-active text-uppercase text-white">
            <tr>
                <th style="width: 15%;"><small>Faq ID</small></th>
                <th style="width: 25%;"><small>Faq Question</small></th>
                <th style="width: 35%;"><small>Faq Answer</small></th>
                <th style="width: 15%;"><small>Faq Created At</small></th>
                <th style="width: 10%;"><small>Action</small></th>
            </tr>

        </thead>
        <tbody>
            <?php
            while ($data = mysqli_fetch_assoc($result)) {
                $faq_id = $data['faq_id'];
                $faq_question = $data['faq_question'];
                $faq_answer = $data['faq_answer'];
                $faq_created_at = $data['faq_created_at'];
                $get_Time_And_Day = new DateTime($faq_created_at);
                $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');
            ?>
                <tr>
                    <td><small><?php echo htmlspecialchars($faq_id); ?></small></td>
                    <td><small><?php echo htmlspecialchars($faq_question); ?></small></td>
                    <td><small><?php echo htmlspecialchars($faq_answer); ?></small></td>
                    <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                    <td><button type="button" class="btn btn-sm btn-danger faqsDelete" data-post-id="<?php echo $faq_id; ?>" data-bs-toggle="modal" data-bs-target="#deleteFaqsModal">Delete <i class=" bi bi-trash ms-2"></i></button></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Delete faqs Modal -->
<div class="modal fade" id="deleteFaqsModal" tabindex="-1" aria-labelledby="deleteFaqsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="d-flex justify-content-center align-items-center rounded-circle bg-danger-subtle mx-auto" style="height: 50px; width: 50px;">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 25px;"></i>
                </div>

                <h6 class="my-3 fw-semibold">Are you sure?</h6>
                <p class="text-muted">This action cannot be undone. Please confirm your decision.</p>
                <form action="municipal_maintainability/deleteFaqs.php" method="POST">
                    <input type="hidden" id="getFaqID" name="getFaqID">
                    <div class="d-grid gap-3 mx-4">
                        <button type="submit" name="btnDeleteFaq" class="btn btn-danger">
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
        $(document).on('click', '.faqsDelete', function() {
            let faq_id = $(this).data('post-id');
            console.log(faq_id);
            $('#getFaqID').val(faq_id);
        });
    });
</script>