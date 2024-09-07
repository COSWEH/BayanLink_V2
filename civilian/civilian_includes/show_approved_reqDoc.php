<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../document.c.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$civilian_brgy = $_SESSION['user_brgy'];

$query = "
    SELECT 
        r.req_id, 
        r.user_id, 
        r.req_date, 
        r.req_typeOfDoc, 
        r.req_status,
        u.user_brgy, 
        u.user_fname, 
        u.user_mname, 
        u.user_lname, 
        u.user_gender, 
        u.user_contactNum, 
        u.dateOfBirth, 
        u.user_age, 
        u.placeOfBirth, 
        u.civilStatus, 
        u.user_city, 
        u.user_purok
    FROM 
        tbl_requests r
    JOIN 
        tbl_useracc u
    ON 
        r.user_id = u.user_id
    WHERE 
        r.user_id = '$user_id' 
    AND 
        u.user_brgy = '$civilian_brgy' 
    AND 
        r.req_status = 'Approved'
    ORDER BY 
        r.req_date DESC
";



$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

$rowCount = mysqli_num_rows($result);

if ($rowCount == 0) {
    echo "<p>No document requests found.</p>";
}

while ($data = mysqli_fetch_assoc($result)) {
    // Fetch data from tbl_requests
    $reqId = $data['req_id'];
    $userId = $data['user_id'];
    $reqDate = $data['req_date'];
    $fname = $data['user_fname'];
    $mname = $data['user_mname'];
    $lname = $data['user_lname'];
    $contactNo = $data['user_contactNum'];
    $gender = $data['user_gender'];
    $brgy = $data['user_brgy'];
    $purok = $data['user_purok'];
    $age = $data['user_age'];
    $dateOfBirth = $data['dateOfBirth'];
    $placeOfBirth = $data['placeOfBirth'];
    $civilStatus = $data['civilStatus'];
    $docType = $data['req_typeOfDoc'];
    $status = $data['req_status'];

    $get_Time_And_Day = new DateTime($reqDate);
    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');

    $getDocTemplateQuery = "SELECT doc_template FROM tbl_typedoc WHERE docType = '$docType'";
    $getDtResult = mysqli_query($con, $getDocTemplateQuery);

    if (
        mysqli_num_rows($getDtResult) > 0
    ) {
        $row = mysqli_fetch_assoc($getDtResult);

        $getDocumentTemplate = $row['doc_template'];
        $pdfFileUrl = '../includes/doc_template/' . $getDocumentTemplate;
    }
?>

    <!-- List of Document Requests -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-4 mb-2">
        <div class="card shadow border border-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center text-center ">
                    <h5 class="card-title mb-0 mx-auto"><?php echo $docType; ?></h5>

                    <button type="button" class="btn btn-sm shadow position-relative btnPreview<?php echo $reqId; ?>" data-doc-type="<?php echo $docType; ?>" data-bs-toggle="modal" data-bs-target="#docTypePreviewModal<?php echo $reqId; ?>">
                        <i class="bi bi-file-earmark-text-fill fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill">
                            <i class="bi bi-eye-fill fs-4 text-secondary"></i>
                        </span>
                    </button>
                </div>
                <hr>
                <div class="d-flex flex-column mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-person-fill me-2">
                                <span class="ms-2">Name:</span>
                            </i>
                            <small>
                                <?php echo $fname . " " . $mname . " " . $lname; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-phone-fill me-2">
                                <span class="ms-2">Contact No:</span>
                            </i>
                            <small>
                                <?php echo $contactNo; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-gender-ambiguous me-2">
                                <span class="ms-2">Gender:</span>
                            </i>
                            <small>
                                <?php echo $gender; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-house-door-fill me-2">
                                <span class="ms-2">Barangay:</span>
                            </i>
                            <small>
                                <?php echo $brgy; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-calendar-fill me-2">
                                <span class="ms-2">Date of Birth:</span>
                            </i>
                            <small>
                                <?php echo $dateOfBirth; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-geo-alt-fill me-2">
                                <span class="ms-2">Purok:</span>
                            </i>
                            <small>
                                <?php echo $purok; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-geo-alt-fill me-2">
                                <span class="ms-2">Place of Birth:</span>
                            </i>
                            <small>
                                <?php echo $placeOfBirth; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-person-hearts me-2">
                                <span class="ms-2">Civil Status:</span>
                            </i>
                            <small>
                                <?php echo $civilStatus; ?>
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <h6>
                            <i class="bi bi-calendar3 me-2">
                                <span class="ms-2">Age:</span>
                            </i>
                            <small>
                                <?php echo $age; ?> years old
                            </small>
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <?php
                        if ($status == "Approved") {
                            $percentage = 100;
                        } elseif ($status == "Processing") {
                            $percentage = 50;
                        } else {
                            $percentage = 0;
                        }
                        ?>
                        <div class="container">
                            <div class="progress" role="progressbar" aria-label="Progress bar" style="width: 100%;" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" style="width: <?php echo $percentage; ?>%"></div>
                            </div>

                            <div class="d-flex justify-content-between mt-2">
                                <div class="text-center position-relative">
                                    <?php
                                    if ($percentage >= 0) {
                                        echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                        echo '<div><small class="text-success">Pending</small></div>';
                                    } else {
                                        echo '<i class="bi bi-check-circle"></i>';
                                        echo '<div><small>Pending</small></div>';
                                    }
                                    ?>
                                </div>
                                <div class="text-center position-relative">
                                    <?php
                                    if ($percentage >= 50) {
                                        echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                        echo '<div><small class="text-success">Processing</small></div>';
                                    } else {
                                        echo '<i class="bi bi-check-circle"></i>';
                                        echo '<div><small>Processing</small></div>';
                                    }
                                    ?>
                                </div>
                                <div class="text-center position-relative">
                                    <?php
                                    if ($percentage >= 100) {
                                        echo '<i class="bi bi-check-circle-fill text-success"></i>';
                                        echo '<div><small class="text-success">Approved</small></div>';
                                    } else {
                                        echo '<i class="bi bi-check-circle"></i>';
                                        echo '<div><small>Approved</small></div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- doc type preview modal -->
    <div class="modal fade" id="docTypePreviewModal<?php echo $reqId; ?>" tabindex="-1" aria-labelledby="docTypePreviewModal<?php echo $reqId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                        <i class="bi bi-eye-fill text-primary" style="font-size: 25px;"></i>
                    </div>

                    <h5 class="fw-semibold">Document Preview</h5>
                    <p class="text-muted mb-4">This is just a template preview. The actual document will be available at the designated pickup location.</p>

                    <!-- Container for PDF.js -->
                    <div id="pdf-container<?php echo $reqId; ?>" class="row"></div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js"></script>

    <script>
        document.querySelectorAll('.btnPreview<?php echo $reqId; ?>').forEach(button => {
            button.addEventListener('click', function() {
                const reqId = "<?php echo $reqId; ?>";
                const pdfUrl = "<?php echo $pdfFileUrl; ?>";
                const container = document.getElementById(`pdf-container${reqId}`);

                console.log(pdfUrl);

                // Clear the container in case it has content from previous renders
                container.innerHTML = '';

                // Loading the PDF
                pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                    // Loop through each page and render it
                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        pdf.getPage(pageNum).then(page => {
                            const scale = 1.5; // Adjust scale as needed
                            const viewport = page.getViewport({
                                scale: scale
                            });

                            // Create a canvas element for each page
                            const canvas = document.createElement('canvas');
                            canvas.width = viewport.width;
                            canvas.height = viewport.height;
                            container.appendChild(canvas);

                            const context = canvas.getContext('2d');

                            // Render the page into the canvas context
                            const renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };
                            page.render(renderContext);
                        }).catch(error => {
                            console.error("Error rendering page:", error);
                        });
                    }
                }).catch(error => {
                    console.error('Error loading PDF:', error);
                });
            });
        });
    </script>

<?php
}
?>

<script>
    $(document).ready(function() {
        $(document).on('click', '.btnCancelRequest', function() {
            let p_id = $(this).data('post-id'); // Retrieve post ID from update button
            $('#getReqID').val(p_id);

            console.log(p_id);

        });
    });
</script>