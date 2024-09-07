<?php
include('../../includes/conn.inc.php');
session_start();

if (empty($_SESSION['user_id'])) {
    header('location: ../superAdminPost.m.php');
    exit;
}

$query = "SELECT * FROM `tbl_logs` ORDER BY `log_date` DESC";
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
                    <th style="width: 25%;"><small>LOG ID</small></th>
                    <th style="width: 25%;"><small>LOG DESCRIPTION</small></th>
                    <th style="width: 25%;"><small>LOG DATE</small></th>
                    <th style="width: 25%;"><small>USER ID</small></th>
                </tr>

            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_assoc($result)) {
                    // Fetch data from tbl_requests
                    $log_id = $data['log_id'];
                    $log_desc = $data['log_desc'];
                    $log_date = $data['log_date'];
                    $user_id = $data['user_id'];
                    $get_Time_And_Day = new DateTime($log_date);
                    $formattedDate = $get_Time_And_Day->format('Y-m-d H:i:s');
                ?>
                    <tr>
                        <td><small><?php echo htmlspecialchars($log_id); ?></small></td>
                        <td><small><?php echo htmlspecialchars($log_desc); ?></small></td>
                        <td><small><?php echo htmlspecialchars($formattedDate); ?></small></td>
                        <td><small><?php echo htmlspecialchars($user_id); ?></small></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>


<?php
}
?>