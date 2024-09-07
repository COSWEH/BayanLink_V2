<?php
include('conn.inc.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../index.php');
    exit;
}
// Fetch the latest 5 FAQs for initial display
$sql = "SELECT * FROM tbl_faqs ORDER BY faq_created_at DESC LIMIT 5";
$initial_result = mysqli_query($con, $sql);

// Fetch all FAQs to be able to load more on demand
$sql_all = "SELECT * FROM tbl_faqs ORDER BY faq_created_at DESC";
$all_result = mysqli_query($con, $sql_all);

// Fetch total number of FAQs
$total_faqs = $all_result->num_rows;
?>

<div id="faqCarousel" class="carousel slide">
    <div class="carousel-inner">
        <!-- Initial Slide with First 5 FAQs -->
        <div class="carousel-item active">
            <div class="accordion shadow" id="accordion1">
                <?php if ($initial_result->num_rows > 0) {
                    while ($row = $initial_result->fetch_assoc()) { ?>
                        <div class="accordion-item border border-0">
                            <h2 class="accordion-header" id="heading<?php echo $row['faq_id']; ?>">
                                <button class="accordion-button bg-light-subtle border border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['faq_id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $row['faq_id']; ?>">
                                    <?php echo htmlspecialchars($row['faq_question']); ?>
                                </button>
                            </h2>
                            <div id="collapse<?php echo $row['faq_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $row['faq_id']; ?>" data-bs-parent="#accordion1">
                                <div class="accordion-body">
                                    <p><?php echo htmlspecialchars($row['faq_answer']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } // End of while loop
                } else { ?>
                    <p>No FAQs available.</p>
                <?php } ?>
            </div>
        </div>

        <!-- Placeholder for additional slides -->
        <?php
        // Calculate number of additional slides needed
        $num_additional_slides = ceil(($total_faqs - 5) / 5);
        for ($i = 1; $i <= $num_additional_slides; $i++) { ?>
            <div class="carousel-item">
                <div class="accordion shadow" id="accordion<?php echo $i + 1; ?>">
                    <?php
                    // Fetch the next 5 FAQs for this slide
                    $offset = 5 + ($i - 1) * 5;
                    $sql_next = "SELECT * FROM tbl_faqs ORDER BY faq_created_at DESC LIMIT 5 OFFSET $offset";
                    $next_result = mysqli_query($con, $sql_next);
                    if ($next_result->num_rows > 0) {
                        while ($row = $next_result->fetch_assoc()) { ?>
                            <div class="accordion-item border border-0">
                                <h2 class="accordion-header" id="heading<?php echo $row['faq_id']; ?>">
                                    <button class="accordion-button bg-light-subtle border border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $row['faq_id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $row['faq_id']; ?>">
                                        <?php echo htmlspecialchars($row['faq_question']); ?>
                                    </button>
                                </h2>
                                <div id="collapse<?php echo $row['faq_id']; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $row['faq_id']; ?>" data-bs-parent="#accordion<?php echo $i + 1; ?>">
                                    <div class="accordion-body bg-light-subtle">
                                        <p><?php echo htmlspecialchars($row['faq_answer']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } // End of while loop
                    } else { ?>
                        <p>No FAQs available.</p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Carousel controls placed below the carousel -->
    <div class="d-flex justify-content-between mt-2">
        <button class="carousel-control-prev btn" type="button" data-bs-target="#faqCarousel" data-bs-slide="prev">
            <span><i class="bi bi-arrow-left text-dark-emphasis" style="font-size: 2.5rem;"></i></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next btn" type="button" data-bs-target="#faqCarousel" data-bs-slide="next">
            <span> <i class="bi bi-arrow-right text-dark-emphasis" style="font-size: 2.5rem;"></i></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>