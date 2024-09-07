    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <?php
    include('../../includes/conn.inc.php');
    session_start();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('location: ../post.c.php');
        exit;
    }

    $getUserid = $_SESSION['user_id'];
    $user_role = $_SESSION['role_id'];

    // Validate the user against the database
    $checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
    $countUser = mysqli_num_rows($checkUser);

    $getReqID = "SELECT r.req_id, r.user_id, u.user_brgy
            FROM tbl_requests AS r 
            INNER JOIN tbl_useracc AS u ON r.user_id = u.user_id
            WHERE r.user_id = '$getUserid'";

    // If user does not exist, sign out
    if ($countUser < 1) {
        header('Location: ../signout.php');
        exit;
    }

    // If user role is not civilian
    if ($user_role != 0) {
        header('Location: ../unauthorized.php');
        exit;
    }

    // Execute the query to get req_id
    $reqIDResult = mysqli_query($con, $getReqID);

    // Check if the query was successful and fetch the result
    if ($reqIDResult && mysqli_num_rows($reqIDResult) > 0) {
        $getReqIDdata = mysqli_fetch_assoc($reqIDResult);
        // $req_id = $getReqIDdata['user_id'];
        $admin_brgy = $getReqIDdata['user_brgy'];

        // Only proceed if req_id is not null
        if ($getUserid) {
            // Query to get notifications for the given req_id
            $ntfQuery = "SELECT * FROM `tbl_notification` WHERE `user_id` = '$getUserid' ORDER BY `notify_date` DESC";
            $result = mysqli_query($con, $ntfQuery);

            // Check if the query was successful
            if ($result) {
                // Check if there are any notifications
                if (mysqli_num_rows($result) > 0) {
                    while ($data = mysqli_fetch_assoc($result)) {
                        $notify_id = $data['notify_id'];
                        $description = $data['description'];
                        $status = $data['status'];
                        $getTime = $data['notify_date'];

                        $get_Time_And_Day = new DateTime($getTime);
    ?>
                        <div class="card-body p-2 bg-body-secondary rounded">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <div>
                                        Admin of <?php echo htmlspecialchars($admin_brgy); ?>
                                    </div>
                                    <div class="mt-1">
                                        <small>
                                            <?php echo htmlspecialchars($description); ?> your Document
                                        </small>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-muted"><?php echo $get_Time_And_Day->format('h:i A D, M j, Y'); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
    <?php
                    }
                } else {
                    // Handle the case where no notifications are found
                    echo '<div class="card-body p-2 bg-body-secondary rounded">';
                    echo '<small>No notifications found.</small>';
                    echo '</div>';
                }
            } else {
                // Handle query error (optional)
                die('Error in query: ' . mysqli_error($con));
            }
        } else {
            // Handle the case where req_id is null
            echo '<div class="card-body p-2 bg-body-secondary rounded">';
            echo '<small>No notifications available.</small>';
            echo '</div>';
        }
    }
    ?>