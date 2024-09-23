<?php
include('../includes/conn.inc.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    header('Location: ../signout.php');
    exit;
}

// echo ".";
$getUserid = $_SESSION['user_id'];
$user_role = $_SESSION['role_id'];

// Validate the user against the database
$checkUser = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `user_id` = '$getUserid' LIMIT 1");
$countUser = mysqli_num_rows($checkUser);

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- local css -->
    <link rel="stylesheet" href="civilianMaterials/style.c.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- JQUERY CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top d-lg-none d-md-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../img/BayanLinkLogoBlack.png" alt="Logo" width="46" height="40" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="mx-3 mb-3">
                <div class="d-flex align-items-center mt-2">
                    <?php
                    $getGender = $_SESSION['user_gender'];
                    if ($getGender == "Male") {
                        echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 50px; height: 50px;">';
                    } else {
                        echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 50px; height: 50px;">';
                    }
                    ?>
                    <p class="mb-0">
                        <?php
                        $fullname = $_SESSION['user_fname'] . " " . $_SESSION['user_mname'] . " " . $_SESSION['user_lname'];
                        echo ucwords($fullname);
                        ?>
                    </p>
                </div>
            </div>

            <div class="mx-3">
                <h5 class="mb-3">Menu</h5>
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="post.c.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active-post" aria-current="page" href="profile.c.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="document.c.php">Request Document</a>
                    </li>
                </ul>
                <hr>
                <button type="button" class="btn w-100 rounded-5 mb-3" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-3">
        <div class="row g-3">
            <!-- left -->
            <nav class="col-md-3 d-none d-md-block sidebar border rounded p-3 bg-body-tertiary d-flex flex-column">
                <div class="d-flex justify-content-between mb-3 ">
                    <button id="theme-toggle" class="btn shadow">
                        <i class="bi bi-moon-fill" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
                    </button>
                    <div class="dropdown ">
                        <button class="btn shadow position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="notificationButton">
                            <i class="bi bi-bell-fill"></i>
                            <div id="count-notification">
                            </div>
                        </button>
                        <div class="dropdown-menu">
                            <div class="card border border-0" style="width: 300px;">
                                <!-- Notification Header -->
                                <div class="card-header">
                                    <h6 class="mb-0">
                                        Notifications
                                    </h6>
                                </div>
                                <div id="notification-content" class="p-3" style="height: 200px; overflow-y: auto;">
                                    <!-- Your notification content here -->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-center">
                    <?php
                    $getGender = $_SESSION['user_gender'];
                    if ($getGender == "Male") {
                        echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">';
                    } else {
                        echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">';
                    }
                    ?>
                    <h6 class="mb-3">
                        <?php
                        $fullname = $_SESSION['user_fname'] . " " . $_SESSION['user_mname'] . " " . $_SESSION['user_lname'];
                        echo ucwords($fullname);
                        ?>
                    </h6>
                </div>
                <hr>
                <h3 class="mb-3">Menu</h3>
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="post.c.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active-profile" aria-current="page" href="profile.c.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="document.c.php">Request Document</a>
                    </li>
                    <hr>
                </ul>

                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <!-- info -->
                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="card-body">
                        <h3 class="card-title mb-3 ">Personal Information</h3>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>From San Isidro:</strong></p>
                                <p class="text-muted" id="fromSanIsidro"><?php echo $_SESSION['fromSanIsidro']; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Barangay:</strong></p>
                                <p class="text-muted" id="barangay"><?php echo $_SESSION['user_brgy']; ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Full Name:</strong></p>
                                <p class="text-muted" id="fullname">
                                    <?php
                                    $fullname = $_SESSION['user_fname'] . ' ' . $_SESSION['user_mname'] . ' ' . $_SESSION['user_lname'];
                                    echo ucwords($fullname);
                                    ?>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Sex:</strong></p>
                                <p class="text-muted" id="gender">
                                    <?php
                                    $gender = $_SESSION['user_gender'];
                                    echo ucwords($gender);
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <p class="mb-2"><strong>Address:</strong></p>
                                <p class="text-muted" id="address"><?php echo "Purok " . $_SESSION['user_purok'] . " Brgy. " . $_SESSION['user_brgy'] . ', ' . $_SESSION['user_city']; ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Contact Number:</strong></p>
                                <p class="text-muted" id="contactNum"><?php echo $_SESSION['user_contactNum']; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Date of Birth:</strong></p>
                                <p class="text-muted" id="dateOfBirth"><?php echo $_SESSION['dateOfBirth']; ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Place of Birth:</strong></p>
                                <p class="text-muted" id="placeOfBirth"><?php echo $_SESSION['placeOfBirth']; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Civil Status:</strong></p>
                                <p class="text-muted" id="civilStatus"><?php echo $_SESSION['civilStatus']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="card-body">
                        <h3 class="card-title mb-4 ">Account Information</h3>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Email:</strong></p>
                                <p class="text-muted" id="email"><?php echo $_SESSION['user_email']; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-2"><strong>Username:</strong></p>
                                <p class="text-muted" id="username"><?php echo $_SESSION['username']; ?></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <p class="mb-2"><strong>Password:</strong></p>
                                <p class="text-muted">********</p>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-outline-primary my-2" type="button" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                Change Password
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">Update Information</button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- change password modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-warning-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-lock text-warning" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Change Password</h6>
                    <p class="text-muted">Please enter your current password and the new password you wish to set.</p>


                    <div class="container">
                        <!-- Password Change Form -->
                        <form action="civilian_includes/change_password.c.php" method="POST">
                            <div style="position: relative;">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters"><span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="currentShowPasswordIcon"><i class=" bi bi-eye-slash-fill"></i></span>
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                </div>
                            </div>

                            <div style="position: relative;">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters"><span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="newShowPasswordIcon"><i class=" bi bi-eye-slash-fill"></i></span>
                                    <label for="newPassword" class="form-label">New Password</label>
                                </div>
                            </div>

                            <div style="position: relative;">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters"><span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="confirmShowPasswordIcon"><i class=" bi bi-eye-slash-fill"></i></span>
                                    <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                                </div>
                            </div>

                            <button type="submit" name="btnChangePass" class="btn btn-primary w-100">Change Password</button>
                        </form>
                    </div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Update Information Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Update Information</h6>
                    <p class="text-muted">Update your personal information as needed.</p>

                    <div class="container">
                        <form action="civilian_includes/update_information.c.php" method="POST">
                            <h4 class="h4 ">Personal Information</h4>
                            <!-- Dropdown for San Isidro -->
                            <div class="form-floating mb-3">
                                <?php
                                $selectedValue = isset($_SESSION['fromSanIsidro']) ? $_SESSION['fromSanIsidro'] : '';
                                ?>
                                <select id="fromSanIsidroYN" name="fromSanIsidro" class="form-select" required>
                                    <option value="" disabled <?php echo $selectedValue === '' ? 'selected' : ''; ?>>Select Yes or No</option>
                                    <option value="Yes" <?php echo $selectedValue === 'Yes' ? 'selected' : ''; ?>>Yes</option>
                                    <option value="No" <?php echo $selectedValue === 'No' ? 'selected' : ''; ?>>No</option>
                                </select>
                                <label for="fromSanIsidroYN" class="form-label">Are you from San Isidro?</label>
                            </div>

                            <!-- Barangay -->
                            <div class="form-floating mb-3">
                                <?php
                                $selectedBarangay = isset($_SESSION['user_brgy']) ? $_SESSION['user_brgy'] : '';
                                ?>
                                <select name="barangay" id="user_brgy" class="form-select" required>
                                    <option value="" disabled selected>Select Barangay</option>
                                    <option value="Alua">Alua</option>
                                    <option value="Calaba">Calaba</option>
                                    <option value="Malapit">Malapit</option>
                                    <option value="Mangga">Mangga</option>
                                    <option value="Poblacion">Poblacion</option>
                                    <option value="Pulo">Pulo</option>
                                    <option value="San Roque">San Roque</option>
                                    <option value="Sto. Cristo">Sto. Cristo</option>
                                    <option value="Tabon">Tabon</option>
                                </select>
                                <label for="user_brgy" class="form-label">Which Barangay are you from?</label>
                            </div>
                            <hr>

                            <!-- Full Name -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-floating mb-2">
                                        <input type="text" name="fname" class="form-control" id="user_fname" placeholder="First Name" required pattern="^[a-zA-Z\s\-]+$" value="<?php echo $_SESSION['user_fname']; ?>">
                                        <label for="user_fname" class="form-label">First Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-2">
                                        <input type="text" name="mname" class="form-control" id="user_mname" placeholder="Middle Name" pattern="^[a-zA-Z\s\-]+$" value="<?php echo $_SESSION['user_mname']; ?>">
                                        <label for="user_mname" class="form-label">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-2">
                                        <input type="text" name="lname" class="form-control" id="user_lname" placeholder="Last Name" pattern="^[a-zA-Z\s\-]+$" required value="<?php echo $_SESSION['user_lname']; ?>">
                                        <label for="user_lname" class="form-label">Last Name</label>
                                    </div>
                                </div>
                            </div>

                            <!-- gender -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select name="gender" id="user_gender" class="form-select" required>
                                            <option value="" disabled>Select Male or Female</option>
                                            <?php
                                            if (isset($_SESSION['user_gender'])) {
                                                $getGender = $_SESSION['user_gender'];
                                                echo '<option value="Male"' . ($getGender == "Male" ? ' selected' : '') . '>Male</option>';
                                                echo '<option value="Female"' . ($getGender == "Female" ? ' selected' : '') . '>Female</option>';
                                            } else {
                                                echo '<option value="Male">Male</option>';
                                                echo '<option value="Female">Female</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="user_gender" class="form-label">Sex</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="user_purok" class="form-control" id="user_purok" placeholder="Purok" value="<?php echo $_SESSION['user_purok']; ?>" required>
                                        <label for="user_purok" class="form-label">Purok</label>
                                    </div>
                                </div>

                            </div>
                            <div>
                                <div class="form-floating mb-3">
                                    <input type="tel" name="contactNum" class="form-control" id="user_contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)" value="<?php echo $_SESSION['user_contactNum']; ?>">
                                    <label for="user_contactNum" class="form-label">Contact Number</label>
                                </div>
                            </div>

                            <div>
                                <div class="form-floating mb-3">
                                    <input id="dateOfBirth" class="form-control" type="date" name="dateOfBirth" placeholder="Date of Birth" required
                                        value="<?php echo isset($_SESSION['dateOfBirth']) ? htmlspecialchars($_SESSION['dateOfBirth']) : ''; ?>">
                                    <label for="dateOfBirth">Date of Birth</label>
                                </div>
                            </div>

                            <div>
                                <div class="form-floating mb-3">
                                    <input id="placeOfBirth" class="form-control" type="text" name="placeOfBirth" placeholder="Place of Birth" required
                                        value="<?php echo isset($_SESSION['placeOfBirth']) ? htmlspecialchars($_SESSION['placeOfBirth']) : ''; ?>">
                                    <label for="placeOfBirth">Place of Birth</label>
                                </div>
                            </div>

                            <div>
                                <div class="form-floating mb-3">
                                    <select id="civilStatus" name="civilStatus" class="form-select" required>
                                        <option value="" disabled <?php echo !isset($_SESSION['civilStatus']) ? 'selected' : ''; ?>>Choose Status</option>
                                        <option value="Single" <?php echo isset($_SESSION['civilStatus']) && $_SESSION['civilStatus'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                                        <option value="Married" <?php echo isset($_SESSION['civilStatus']) && $_SESSION['civilStatus'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                                        <option value="Widowed" <?php echo isset($_SESSION['civilStatus']) && $_SESSION['civilStatus'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                        <option value="Divorced" <?php echo isset($_SESSION['civilStatus']) && $_SESSION['civilStatus'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                    </select>
                                    <label for="civilStatus">Civil Status</label>
                                </div>
                            </div>

                            <h4 class="h4 ">Account Information</h4>
                            <!-- Email and Username -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="e.g., juandelacruz143@gmail.com" value="<?php echo $_SESSION['user_email']; ?>">
                                        <label for="user_email" class="form-label">Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="username" class="form-control" id="username" placeholder="Username" required required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more" value="<?php echo $_SESSION['username']; ?>">
                                        <input type="hidden" name="password" value="<?php echo $_SESSION['password']; ?>">
                                        <label for="username" class="form-label">Username</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="btnUpdate" class="btn btn-primary w-100">Update</button>
                        </form>
                    </div>
                </div>

                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- signout modal -->
    <div class="modal fade" id="signoutModal" tabindex="-1" aria-labelledby="signoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-warning-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-box-arrow-left text-warning" style="font-size: 25px;"></i>
                    </div>

                    <h6 class="my-3 fw-semibold">Are you sure you want to sign out?</h6>
                    <p class="text-muted">Please confirm if you wish to end your session.</p>
                    <form action="../signout.php" method="POST">
                        <div class="d-grid gap-3 mx-4">
                            <button type="submit" name="btnSignout" class="btn btn-primary">
                                Sign out
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

    <script src="civilianMaterials/script.c.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // update status to read
        document.getElementById("notificationButton").addEventListener("click", function() {
            // Get the notification count element
            var notificationCountElement = document.querySelector("#count-notification .badge");

            // Check if the notification count is not empty
            if (notificationCountElement && notificationCountElement.innerText.trim() !== "") {
                // AJAX request to update notifications status to "read"
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "civilian_includes/update_notifications.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log("All notifications updated to read");
                        // Clear the notification count badge
                        document.getElementById("count-notification").innerHTML = '';
                    }
                };
                xhr.send();
            } else {
                console.log("No unread notifications to update.");
            }
        });

        $(document).ready(function() {
            $.post('civilian_includes/show_notification.php', {}, function(data) {
                $("#notification-content").html(data);
            });

            $.post('civilian_includes/show_notification_count.php', {}, function(data) {
                $("#count-notification").html(data);
            });

            function updateNotification() {
                $.post('civilian_includes/show_notification.php', {}, function(data) {
                    $("#notification-content").html(data);
                    setTimeout(updateNotification, 500);
                });
            }

            function showNotificationCount() {
                $.post('civilian_includes/show_notification_count.php', {}, function(data) {
                    $("#count-notification").html(data);
                    setTimeout(showNotificationCount, 500);
                });
            }

            updateNotification();
            showNotificationCount()


            const barangayOptions = [
                "Alua", "Calaba", "Malapit", "Mangga", "Poblacion",
                "Pulo", "San Roque", "Sto. Cristo", "Tabon"
            ];

            const $barangaySelect = $('#user_brgy');
            const $fromSanIsidroSelect = $('#fromSanIsidroYN');

            // Function to update the barangay select options
            function updateBarangayOptions() {
                const selectedValue = $fromSanIsidroSelect.val();
                $barangaySelect.empty(); // Clear existing options

                if (selectedValue === "Yes") {
                    $barangaySelect.append('<option value="" disabled selected>Select Barangay</option>');
                    barangayOptions.forEach(option => {
                        $barangaySelect.append(`<option value="${option}">${option}</option>`);
                    });
                } else if (selectedValue === "No") {
                    $barangaySelect.append('<option value="N/A" selected>N/A</option>');
                }
            }

            // Update options when selection changes
            $fromSanIsidroSelect.change(function() {
                updateBarangayOptions();
            });

            // Initial load
            updateBarangayOptions();


            // Function to toggle password visibility
            function togglePasswordVisibility(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const showPasswordIcon = document.getElementById(iconId);

                showPasswordIcon.addEventListener("click", function() {
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        showPasswordIcon.innerHTML = '<i class="bi bi-eye-fill"></i>';
                    } else {
                        passwordInput.type = "password";
                        showPasswordIcon.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
                    }
                });
            }

            // Initialize the toggle for each password field
            togglePasswordVisibility("currentPassword", "currentShowPasswordIcon");
            togglePasswordVisibility("newPassword", "newShowPasswordIcon");
            togglePasswordVisibility("confirmNewPassword", "confirmShowPasswordIcon");

        });
    </script>
</body>

<?php
if (isset($_SESSION['password_message'])) {
    echo '<script>
            Swal.fire({
                title: "' . $_SESSION['password_message_code'] . '",
                text: "' . $_SESSION['password_message'] . '",
                icon: "' . strtolower($_SESSION['password_message_code']) . '",
            });
        </script>';
    unset($_SESSION['password_message']);
}

if (isset($_SESSION['update_message'])) {
    echo '<script>
            Swal.fire({
                title: "' . $_SESSION['update_message_code'] . '",
                text: "' . $_SESSION['update_message'] . '",
                icon: "' . strtolower($_SESSION['update_message_code']) . '",
            });
        </script>';
    unset($_SESSION['update_message']);
}
?>

</html>