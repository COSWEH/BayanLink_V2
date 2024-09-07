<?php
include('../../includes/conn.inc.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location: ../superAdminPost.m.php');
    exit;
}

$civilian_brgy = $_SESSION['user_brgy'];

$query = "SELECT p.post_id, p.user_id, p.post_brgy, p.post_content, p.post_img, p.post_date, u.user_brgy, u.user_fname, u.user_mname, u.user_lname
          FROM tbl_posts AS p 
          INNER JOIN tbl_useracc AS u ON p.user_id = u.user_id
          WHERE p.post_brgy = '$civilian_brgy'
          ORDER BY p.post_date DESC";

$result = mysqli_query($con, $query);

if (!$result) {
    die('Error in query: ' . mysqli_error($con));
}

while ($data = mysqli_fetch_assoc($result)) {
    $postId = $data['post_id'];
    $brgy = $data['user_brgy'];
    $fullname = $data['user_fname'] . " " . $data['user_mname'] . " " . $data['user_lname'];
    $fullname = ucwords(strtolower($fullname));
    $content = $data['post_content'];
    $img = $data['post_img'];
    $getTime = $data['post_date'];

    $get_Time_And_Day = new DateTime($getTime);
?>

    <div class="card mb-3 shadow border border-2">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <img src="../img/brgyIcon.png" alt="Profile Picture" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px;">
                <?php echo "<h6>$brgy</h6>"; ?>
            </div>
            <p>
                <small>
                    <?php echo $get_Time_And_Day->format('h:i A D, M j, Y'); ?>
                </small>
            </p>
            <hr>
            <div class="mb-3">
                <p id="bpPost-text<?php echo $postId; ?>" class="fs-5">
                    <span id="bpPost-text<?php echo $postId; ?>-content">
                        <?php echo htmlspecialchars(substr($content, 0, 100)); ?>...
                    </span>
                    <span id="bpPost-text<?php echo $postId; ?>-more" style="display:none;">
                        <?php echo htmlspecialchars($content); ?>
                    </span>
                    <a href="#" id="bpPost-text<?php echo $postId; ?>-toggle" class="text-primary">See more...</a>
                </p>
            </div>
            <div class="row">
                <?php
                if (!empty($img)) {
                    $imgArray = json_decode($img, true);

                    if (is_array($imgArray)) {
                        // Get the count of images
                        $imgCount = count($imgArray);
                ?>
                        <!-- Ensure the image gallery is only output once -->
                        <div class="bpImage-gallery<?php echo $postId; ?>">
                            <div id="cAdminBrgyPost<?php echo $postId; ?>" class="row">
                                <?php foreach ($imgArray as $index => $imgName): ?>
                                    <?php
                                    // Determine the column size based on the number of images
                                    $colClass = '';
                                    if ($imgCount === 1) {
                                        $colClass = 'col-12'; // Full width on large screens
                                    } elseif ($imgCount === 2) {
                                        $colClass = 'col-6'; // Half width on large screens
                                    } elseif ($imgCount === 3) {
                                        $colClass = 'col-6 col-lg-4'; // One-third width on large screens
                                    } else {
                                        $colClass = 'col-6 col-lg-3'; // One-fourth width on large screens
                                    }
                                    ?>

                                    <div class="<?php echo $colClass; ?> p-2 bpImage-item<?php echo $postId; ?> <?php echo $index >= 4 ? 'd-none' : ''; ?>">
                                        <img src="../barangay/brgy_dbImages/<?php echo htmlspecialchars($imgName); ?>" class="img-fluid rounded shadow-sm">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php if ($imgCount > 4): ?>
                                <a href="#" id="bpImage-toggle<?php echo $postId; ?>" class="text-primary">See more...</a>
                            <?php endif; ?>
                        </div>
                <?php
                    } else {
                        echo "<div class='col-12 col-md-6 col-sm-3 p-2'>
                                <p class='text-danger'>Error loading images</p>
                              </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Modal post Structure -->
    <div class="modal fade" id="viewAdminPostModal<?php echo $postId; ?>" tabindex="-1" aria-labelledby="viewAdminPostModal<?php echo $postId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-postcard text-primary" style="font-size: 25px;"></i>
                    </div>
                    <h6 class="my-3 fw-semibold text-center">Barangay Post Details</h6>

                    <div class="card mb-3 shadow border border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="../img/brgyIcon.png" alt="Profile Picture" class="img-fluid rounded-circle me-2" style="width: 50px; height: 50px;">
                                <?php echo "<h6 class='fw-bold'>$brgy</h6>"; ?>
                            </div>
                            <p>
                                <small class="fw-bold">
                                    <?php echo $get_Time_And_Day->format('h:i A D, M j, Y'); ?>
                                </small>
                            </p>
                            <hr>
                            <div class="mb-3">
                                <p class="fs-5">
                                    <?php echo htmlspecialchars($content); ?>
                                </p>
                            </div>

                            <div class="row">
                                <?php
                                if (!empty($img)) {
                                    $imgArray = json_decode($img, true);

                                    if (is_array($imgArray)) {
                                        $imgCount = count($imgArray);
                                ?>
                                        <!-- Ensure the image gallery is only output once -->
                                        <div class="row">
                                            <?php foreach ($imgArray as $index => $imgName): ?>

                                                <div class="col-12 p-2">
                                                    <img src="../barangay/brgy_dbImages/<?php echo htmlspecialchars($imgName); ?>" class="img-fluid rounded shadow-sm">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>

                                <?php
                                    } else {
                                        echo "<div class='col-12 col-md-6 col-lg-3 p-2'>
                    <p class='text-danger'>Error loading images</p>
                  </div>";
                                    }
                                }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // image content
            $('#bpImage-toggle<?php echo $postId; ?>').off('click').on('click', function(e) {
                e.preventDefault();
                console.log('Image toggle clicked');

                var $hiddenImages = $('.bpImage-item<?php echo $postId; ?>.d-none'); // Hidden images
                var $toggleLink = $('#bpImage-toggle<?php echo $postId; ?>');

                if ($hiddenImages.length > 0) {
                    // Show all hidden images
                    $hiddenImages.removeClass('d-none');
                    $toggleLink.text('See less...');
                } else {
                    // Hide images beyond the first 4
                    $('.bpImage-item<?php echo $postId; ?>').slice(4).addClass('d-none');
                    $toggleLink.text('See more...');
                }
            });

            let triggerElement = document.getElementById('cAdminBrgyPost<?php echo $postId; ?>');

            // Get the modal element
            let modalElement = new bootstrap.Modal(document.getElementById('viewAdminPostModal<?php echo $postId; ?>'));

            // Add a click event listener to the trigger element
            triggerElement.addEventListener('click', function() {
                // Show the modal
                modalElement.show();
            });

            function updateMpTextContent() {
                let $content = $('#bpPost-text<?php echo $postId; ?>-content');
                let $moreText = $('#bpPost-text<?php echo $postId; ?>-more');
                let $toggleLink = $('#bpPost-text<?php echo $postId; ?>-toggle');
                let fullText = "<?php echo addslashes($content); ?>"; // PHP variable output

                let charLimit = $(window).width() > 992 ? 200 : 100; // 200 for large screens, 100 for small screens
                let truncatedText = fullText.length > charLimit ? fullText.substr(0, charLimit) + '...' : fullText;

                $content.text(truncatedText);
                $moreText.text(fullText);

                // Adjust font size based on screen width
                if ($(window).width() > 992) { // Large screen
                    $('#bpPost-text<?php echo $postId; ?>').removeClass('fs-6').addClass('fs-5');
                } else { // Small screen
                    $('#bpPost-text<?php echo $postId; ?>').removeClass('fs-5').addClass('fs-6');
                }

                // Show or hide the "See more" link based on text length
                if (fullText.length > charLimit) {
                    $toggleLink.show(); // Show "See more" if text exceeds limit
                    if ($moreText.is(':visible')) {
                        $content.hide();
                        $toggleLink.text('See less...');
                    } else {
                        $content.show();
                        $toggleLink.text('See more...');
                    }
                } else {
                    $toggleLink.hide(); // Hide "See more" if text is within limit
                    $content.show(); // Ensure content is always visible if short
                }
            }

            // Initial call to set up the text based on the current screen size
            updateMpTextContent();

            // Update text content on window resize
            $(window).resize(function() {
                updateMpTextContent();
            });
            // text content
            $('#bpPost-text<?php echo $postId; ?>-toggle').off('click').on('click', function(e) {
                e.preventDefault();
                console.log('Toggle link clicked');

                var $moreText = $('#bpPost-text<?php echo $postId; ?>-more');
                var $toggleLink = $('#bpPost-text<?php echo $postId; ?>-toggle');

                if ($moreText.is(':visible')) {
                    $('#bpPost-text<?php echo $postId; ?>-content').show();
                    $moreText.hide();
                    $toggleLink.text('See more...');
                } else {
                    $('#bpPost-text<?php echo $postId; ?>-content').hide();
                    $moreText.show();
                    $toggleLink.text('See less...');
                }
            });
        });
    </script>

<?php
}
?>