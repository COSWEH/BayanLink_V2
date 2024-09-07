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
} else {
    while ($row = mysqli_fetch_assoc($checkUser)) {
        $brgy = $row['user_brgy'];
        $fname = $row['user_fname'];
        $mname = $row['user_mname'];
        $lname = $row['user_lname'];
        $gender = $row['user_gender'];
    }
}

// If user role is not super admin
if ($user_role != 2) {
    header('Location: ../unauthorized.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- local css -->
    <link rel="stylesheet" href="municipalMaterials/style.m.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- jquery ajax cdn -->
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
                        echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">';
                    } else {
                        echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle me-3" style="width: 50px; height: 50px;">';
                    }
                    ?>
                    <p class="mb-0">
                        <?php
                        $fullname = $fname . " " . $mname . " " . $lname;
                        echo ucwords(strtolower($fullname));
                        ?>
                    </p>
                </div>
            </div>

            <div class="mx-3">
                <h5 class="mb-3">Menu</h5>
                <ul class="navbar-nav flex-column mb-3">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="superAdminPost.m.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="superAdminProfiling.m.php">Profiling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active-post" aria-current="page" href="superAdminDashboard.php">Dashboard</a>
                    </li>
                </ul>
                <hr>
                <button type="button" class="btn w-100 rounded-5 mb-3" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-3">
        <div class="row g-3">
            <nav class="col-md-3 d-none d-md-block sidebar border rounded p-3 bg-body-tertiary d-flex flex-column">
                <div>
                    <button id="theme-toggle" class="btn btn-sm shadow mb-3 theme-toggle">
                        <i class="bi bi-moon-fill moon-icon" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill sun-icon" id="sun-icon" style="display:none;"></i>
                    </button>

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
                            $fullname = $fname . " " . $mname . " " . $lname;
                            echo ucwords(strtolower($fullname));
                            ?>
                        </h6>
                    </div>
                    <hr>
                    <h3 class="mb-3">Menu</h3>
                    <ul class="navbar-nav flex-column mb-3">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="superAdminPost.m.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="superAdminProfiling.m.php">Profiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active-post" aria-current="page" href="superAdminDashboard.php">Dashboard</a>
                        </li>
                    </ul>
                    <hr>
                </div>

                <button type="button" class="btn mt-3 w-100 rounded-5 mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- Main Content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Super admin account</h6>
                        <button class="btn btn-sm btn-primary shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addSuperAdminModal">Add account</button>
                    </div>
                    <div class="card-body">
                        <div id="showAllSuperAdmin" class="overflow-auto" style="height: 300px;">
                            <!-- Super admin accounts content -->
                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Terms and Conditions</h6>
                        <button class="btn btn-sm btn-primary shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addTMModal">Add</button>
                    </div>
                    <div class="card-body">
                        <div class="overflow-auto" style="height: 300px;">
                            <!-- terms and conditions content -->
                            <ul id="termsContainer" class="list-group" aria-live="polite" aria-atomic="true">

                            </ul>
                        </div>
                    </div>
                </div>

                <!-- home content-->
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Home</h6>
                        <button class="btn btn-sm btn-success shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#editHomeContent">Edit home</button>
                        <div class="row align-items-center mb-4">
                            <!-- Content Section -->
                            <div class="col-md-6 text-center text-md-start px-lg-5">
                                <!-- Title with Edit Button -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h1 id="homeTitle" class="display-6 mb-0">Loading...</h1>
                                </div>
                                <!-- Subtitle1 with Edit Button -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p id="homeSubtitle1" class="small mb-0">Loading...</p>
                                </div>
                                <!-- Subtitle2 with Edit Button -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <p id="homeSubtitle2" class="small mb-0">Loading...</p>
                                </div>
                            </div>
                            <!-- Image Section with Edit Button -->
                            <div class="col-md-6 px-lg-5 text-center">
                                <div class="position-relative">
                                    <img id="homeImg" src="" width="300" height="200" alt="Bayanlink Overview" class="img-fluid rounded shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- services -->
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Services</h6>
                        <button class="btn btn-sm btn-primary shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addServicesModal">Add servicess</button>
                    </div>
                    <div class="card-body">
                        <div id="services_container" class="row row-cols-2 row-cols-lg-3 g-2">
                        </div>
                    </div>
                </div>

                <!-- contact -->
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Contact</h6>
                        <button class="btn btn-sm btn-primary shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addContactModal">Add contact</button>
                    </div>
                    <div class="card-body" id="showAllContact">
                        <div id="contact_container" class="row">
                            <!-- Data will be dynamically inserted here -->
                        </div>
                    </div>
                </div>

                <!-- about us and mission -->
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>About us and our Mission</h6>
                        <button class="btn btn-sm btn-success shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#editAboutMissionModal">Edit content</button>
                    </div>
                    <div class="card-body">
                        <div class="overflow-auto" style="height: 300px;">
                            <h6>About us</h6>
                            <p>
                                <small id="about_us"></small>
                            </p>
                            <h6>Our mission</h6>
                            <p>
                                <small id="our_mission"></small>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- faqs -->
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>FAQs</h6>
                        <button class="btn btn-sm btn-primary shadow" aria-current="page" data-bs-toggle="modal" data-bs-target="#addFaqsModal">Add faqs</button>
                    </div>
                    <div class="card-body">
                        <div id="showAllFaqs" class="overflow-auto" style="height: 300px;">
                            <!-- FAQs content -->
                        </div>
                    </div>
                </div>

                <!-- logs -->
                <div class="card mb-3 shadow border border-2 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Logs</h6>
                    </div>
                    <div class="card-body">
                        <div id="showLogs" class="overflow-auto" style="height: 300px;">
                            <!-- Logs content -->
                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    </div>

    <!-- add super admin account modal -->
    <div class="modal fade" id="addSuperAdminModal" tabindex="-1" aria-labelledby="addSuperAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-person-plus text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Add Super Admin Account</h6>
                    <p class="text-muted">Please fill in the necessary information to create a new super admin account.</p>

                    <div class="container">
                        <form action="municipal_includes/addSuperAdminAcc.php" method="POST">

                            <!-- Group 1: Full Name -->
                            <div id="group1" class="form-step">
                                <h4 class="h4 mb-3">Personal Information</h4>
                                <div class="form-floating mb-3">
                                    <input type="text" name="fname" class="form-control" id="user_fname" placeholder="First Name" required pattern="^[a-zA-Z\s\-]+$">
                                    <label for="user_fname" class="form-label">First Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="mname" class="form-control" id="user_mname" placeholder="Middle Name" pattern="^[a-zA-Z\s\-]+$">
                                    <label for="user_mname" class="form-label">Middle Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="lname" class="form-control" id="user_lname" placeholder="Last Name" required pattern="^[a-zA-Z\s\-]+$">
                                    <label for="user_lname" class="form-label">Last Name</label>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn1">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Group 2: Sex and Address -->
                            <div id="group2" class="form-step d-none">
                                <h4 class="h4 mb-3">Personal Information</h4>
                                <div class="form-floating mb-3">
                                    <select id="user_gender" name="gender" class="form-select" required>
                                        <option value="" disabled selected>Select Male or Female</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="user_gender" class="form-label">Sex</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" name="user_purok" class="form-control" id="user_purok" placeholder="Purok" required>
                                    <label for="user_purok" class="form-label">Purok</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="contactNum" class="form-control" id="contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)">
                                    <label for="contactNum" class="form-label">Contact Number</label>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn2">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn2">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Group 3: Additional Information -->
                            <div id="group3" class="form-step d-none">
                                <h4 class="h4 mb-3">Additional Information</h4>
                                <div class="form-floating mb-3">
                                    <input id="dateOfBirth" class="form-control" type="date" name="dateOfBirth" placeholder="Date of Birth" required>
                                    <label for="dateOfBirth">Date of Birth</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input id="placeOfBirth" class="form-control" type="text" name="placeOfBirth" placeholder="Place of Birth" required>
                                    <label for="placeOfBirth">Place of Birth</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select id="civilStatus" name="civilStatus" class="form-select" required>
                                        <option value="" disabled selected>Choose Status</option>
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                        <option value="Widowed">Widowed</option>
                                        <option value="Divorced">Divorced</option>
                                    </select>
                                    <label for="civilStatus">Civil Status</label>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn3">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn4">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Group 4: Account Information -->
                            <div id="group4" class="form-step d-none">
                                <h4 class="h4 mb-3">Account Information</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required title="e.g., juandelacruz143@gmail.com">
                                            <label for="user_email" class="form-label">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="username" class="form-control" id="username" placeholder="Username" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$" title="At least three characters and more">
                                            <label for="username" class="form-label">Username</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="password" name="signupPassword" class="form-control mb-3" id="signupPassword" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                            <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="signupShowPasswordIcon"><i class="bi bi-eye-slash-fill"></i></span>
                                            <label for="signupPassword" class="form-label">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating mb-3 position-relative">
                                            <input type="password" name="confirmPassword" class="form-control mb-3" id="confirmPassword" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                            <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="confirmShowPasswordIcon"><i class="bi bi-eye-slash-fill"></i></span>
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn4">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-primary w-100" name="submit">
                                            Create Account <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- add tm modal -->
    <div class="modal fade" id="addTMModal" tabindex="-1" aria-labelledby="addTMModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-journal-plus text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal tm -->
                    <h4 class="my-3 fw-semibold" id="addTMModalLabel">Add Terms and Conditions</h4>
                    <p class="text-muted">add the terms and conditions below.</p>

                    <!--  var title = $('#addTM_title').val().trim();
                var description = $('#addTM_content').val().trim(); -->

                    <!-- services title form -->
                    <form action="municipal_maintainability/add_terms_conditions.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="addTM_title" class="form-control" id="addTM_title" value="" placeholder="Services Title">
                            <label for="addTM_title" class="form-label">Terms and Conditions Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="addTM_content" class="form-control" id="addTM_content" placeholder="Services Description" style="height: 250px"></textarea>
                            <label for="addTM_content" class="form-label">Terms and Condtions Description</label>
                        </div>

                        <div id="showAddTMError"></div>
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnAddTermsConditions" id="btnAddTermsConditions" class="btn btn-primary">Add terms and conditons</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update terms conditions modal -->
    <div class="modal fade" id="updateTMModal" tabindex="-1" aria-labelledby="updateTMModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-success" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal services -->
                    <h4 class="my-3 fw-semibold" id="updateTMModalLabel">Edit Terms and Conditions</h4>
                    <p class="text-muted">Update the Terms and Conditions below.</p>

                    <!-- services title form -->
                    <form action="municipal_maintainability/update_terms_conditions.php" method="POST">
                        <input type="hidden" id="updateTM_id" value="" name="updateTM_id">
                        <div class="form-floating mb-3">
                            <input type="text" name="updateTM_title" class="form-control" id="updateTM_title" value="" placeholder="Terms and Condtions Title">
                            <label for="updateTM_title" class="form-label">Terms and Condtions Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="updateTM_content" class="form-control" id="updateTM_content" placeholder="Terms and Condtions Content" style="height: 250px"> </textarea>
                            <label for="updateTM_content" class="form-label">Terms and Condtions Description</label>
                        </div>

                        <div id="showUpdateTMError"></div>
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnUpdateTermsConditions" id="btnUpdateTermsConditions" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete tm modal -->
    <div class="modal fade" id="deleteTMModal" tabindex="-1" aria-labelledby="deleteTMModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-danger-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-trash text-danger" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal tm confirmation -->
                    <h4 class="my-3 fw-semibold" id="deleteTMModalLabel">Delete Terms and Condtions</h4>
                    <p class="text-muted">Are you sure you want to delete the following terms and conditions?</p>

                    <!-- tm details -->
                    <div class="mb-3">
                        <p><strong>Title:</strong> <span id="deleteTM_title"></span></p>
                        <p><strong>Content:</strong> <span id="deleteTM_content"></span></p>

                    </div>

                    <!-- Hidden form for deletion -->
                    <form action="municipal_maintainability/delete_terms_conditions.php" method="POST">
                        <input type="hidden" id="deleteTM_id" name="deleteTM_id">

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnDeleteTM" id="btnDeleteTM" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update home content modal -->
    <div class="modal fade" id="editHomeContent" tabindex="-1" aria-labelledby="editHomeContentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Icon and Title -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-success" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <div class="text-center">
                        <h4 class="my-3 fw-semibold" id="editHomeContentLabel">Update Home Content</h4>
                        <p class="text-muted">Update home content below.</p>
                    </div>

                    <!-- Form for Updating Home Title -->
                    <form action="municipal_maintainability/update_home.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="home_content_id" name="home_content_id">

                        <div class="form-floating mb-3">
                            <input type="text" name="home_content_title" class="form-control" id="home_content_title" placeholder="Home title">
                            <label for="home_content_title" class="form-label">Home title</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="home_content_subtitle1" class="form-control" id="home_content_subtitle1" placeholder="Home subtitle 1" style="height: 100px"></textarea>
                            <label for="home_content_subtitle1" class="form-label">Home subtitle 1</label>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea name="home_content_subtitle2" class="form-control" id="home_content_subtitle2" placeholder="Home subtitle 2" style="height: 100px"></textarea>
                            <label for="home_content_subtitle2" class="form-label">Home subtitle 2</label>
                        </div>

                        <div class="mb-3">
                            <input type="file" name="home_content_img" class="form-control" id="home_content_img" accept=".jpg, .jpeg, .png">
                            <div class="badge text-bg-success text-wrap" style="width: 6rem;">
                                <small>Home image.</small>
                            </div>
                        </div>

                        <!-- Error Display Area -->
                        <div id="showHomeContentError"></div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnHomeContent" id="btnHomeContent" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- add services modal -->
    <div class="modal fade" id="addServicesModal" tabindex="-1" aria-labelledby="addServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-person-gear text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal services -->
                    <h4 class="my-3 fw-semibold" id="addServicesModalLabel">Add Services</h4>
                    <p class="text-muted">add the services below.</p>

                    <!-- services title form -->
                    <form action="municipal_maintainability/add_services.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="addServices_title" class="form-control" id="addServices_title" value="" placeholder="Services Title">
                            <label for="addServices_title" class="form-label">Services Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="addServices_desc" class="form-control" id="addServices_desc" placeholder="Services Description" style="height: 250px"></textarea>
                            <label for="addServices_desc" class="form-label">Services Description</label>
                        </div>

                        <div id="showAddServicesError"></div>
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnAddServices" id="btnAddServices" class="btn btn-primary">Add service</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update services modal -->
    <div class="modal fade" id="updateServicesModal" tabindex="-1" aria-labelledby="updateServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-success" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal services -->
                    <h4 class="my-3 fw-semibold" id="updateServicesModalLabel">Edit Services</h4>
                    <p class="text-muted">Update the services below.</p>

                    <!-- services title form -->
                    <form action="municipal_maintainability/update_services.php" method="POST">
                        <input type="hidden" id="updateServices_id" value="" name="updateServices_id">
                        <div class="form-floating mb-3">
                            <input type="text" name="updateServices_title" class="form-control" id="updateServices_title" value="" placeholder="Services Title">
                            <label for="updateServices_title" class="form-label">Services Title</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea type="text" name="updateServices_desc" class="form-control" id="updateServices_desc" placeholder="Services Description" style="height: 250px"> </textarea>
                            <label for="updateServices_desc" class="form-label">Services Description</label>
                        </div>

                        <div id="showUpdateServicesError"></div>
                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnUpdateServices" id="btnUpdateServices" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- delete service modal -->
    <div class="modal fade" id="deleteServicesModal" tabindex="-1" aria-labelledby="deleteServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and subTitle -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-danger-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-trash text-danger" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal delete confirmation -->
                    <h4 class="my-3 fw-semibold" id="deleteServicesModalLabel">Delete Service</h4>
                    <p class="text-muted">Are you sure you want to delete the following service?</p>

                    <!-- Service details -->
                    <div class="mb-3">
                        <p><strong>Title:</strong> <span id="deleteServices_title"></span></p>
                        <p><strong>Description:</strong> <span id="deleteServices_desc"></span></p>

                    </div>

                    <!-- Hidden form for deletion -->
                    <form action="municipal_maintainability/delete_services.php" method="POST">
                        <input type="hidden" id="deleteServices_id" name="deleteServices_id">

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnDeleteServices" id="btnDeleteServices" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Contact modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Icon and Title -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-person-vcard text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <div class="text-center">
                        <h4 class="my-3 fw-semibold" id="addContactModalLabel">Add Contact</h4>
                        <p class="text-muted">Add contact below.</p>
                    </div>

                    <div id="submitError" class="text-danger mt-2" style="display: none;">
                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>Please correct the errors before submitting.
                        </div>
                    </div>

                    <!-- Form for adding contact -->
                    <form id="addContactForm" action="municipal_maintainability/add_contact.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="contact_id" name="contact_id">

                        <div class="mb-3">
                            <label for="contact_number" class="form-label">Phone number :</label>
                            <div class="input-group">
                                <span class="input-group-text">+63</span>
                                <input type="number" name="contact_number" class="form-control" id="contact_number" placeholder="Phone number">
                            </div>
                            <div id="phone-alert" class="text-danger mt-2" style="display: none;">
                                <div class="alert alert-warning" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Please enter a valid Philippines phone number (e.g., 9123456789).
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="contct_email" class="form-label">Email address :</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" name="contct_email" class="form-control" id="contct_email" placeholder="Email address">
                            </div>
                            <div id="email-alert" class="text-danger mt-2" style="display: none;">
                                <div class="alert alert-warning" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Please enter a valid email address.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="contact_location" class="form-label">Location:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-geo-alt"></i>
                                </span>
                                <input type="text" name="contact_location" class="form-control" id="contact_location" placeholder="Location">
                            </div>
                            <ul id="autocomplete-results" class="list-group position-absolute w-100 mt-1 overflow-auto" style="max-height: 200px;"></ul>
                        </div>

                        <!-- No Input Error Message -->
                        <div id="no-input-error" class="text-danger mt-2" style="display: none;">
                            <div class="alert alert-warning" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>Please fill up at least one input field.
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnAddContact" id="btnAddContact" class="btn btn-primary">Add contact</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- delete contact modal -->
    <div class="modal fade" id="deleteContactModal" tabindex="-1" aria-labelledby="deleteContactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and Title -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-danger-subtle mx-auto" style="height: 60px; width: 60px;">
                        <i class="bi bi-trash text-danger" style="font-size: 30px;"></i>
                    </div>

                    <!-- Modal delete confirmation -->
                    <h4 class="my-3 fw-semibold" id="deleteContactModalLabel">Delete Contact</h4>
                    <p class="text-muted">Are you sure you want to delete the following contact?</p>

                    <!-- Contact details -->
                    <div class="mb-3">
                        <p><strong>Phone Number:</strong> <span id="deleteContact_number"></span></p>
                        <p><strong>Email:</strong> <span id="deleteContact_email"></span></p>
                        <p><strong>Location:</strong> <span id="deleteContact_location"></span></p>
                    </div>

                    <!-- Hidden form for deletion -->
                    <form action="municipal_maintainability/delete_contact.php" method="POST">
                        <input type="hidden" id="deleteContact_id" name="deleteContact_id">

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnDeleteContact" id="btnDeleteContact" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- update about mission modal -->
    <div class="modal fade" id="editAboutMissionModal" tabindex="-1" aria-labelledby="editAboutMissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and Title -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-pencil-square text-success" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title and Subtitle -->
                    <h4 class="my-3 fw-semibold" id="editAboutMissionModalLabel">Edit About and Mission</h4>
                    <p class="text-muted">Update the about and mission below.</p>

                    <!-- Form -->
                    <form id="updateAboutMissionForm" action="municipal_maintainability/update_about_mission.php" method="POST">
                        <input type="hidden" id="update_about_mission_id" name="update_about_mission_id">

                        <div class="form-floating mb-3">
                            <textarea name="update_about_us" class="form-control" id="update_about_us" placeholder="About Us" style="height: 150px"></textarea>
                            <label for="update_about_us" class="form-label">About Us</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="update_our_mission" class="form-control" id="update_our_mission" placeholder="Our Mission" style="height: 150px"></textarea>
                            <label for="update_our_mission" class="form-label">Our Mission</label>
                        </div>

                        <!-- Error Message Container -->
                        <div id="showUpdateAboutMissionError"></div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnUpdateAboutMission" id="btnUpdateAboutMission" class="btn btn-primary">Update</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- add faqs modal -->
    <div class="modal fade" id="addFaqsModal" tabindex="-1" aria-labelledby="addFaqsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Icon and Title -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-question-circle text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h4 class="my-3 fw-semibold" id="addFaqsModalLabel">Frequently Asked Questions</h4>
                    <p class="text-muted">Please fill out the form below to add a new FAQ.</p>

                    <!-- Form -->
                    <form action="municipal_maintainability/addFaqs.m.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="question" class="form-control" id="question" placeholder="Question" required>
                            <label for="question" class="form-label">Question</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea name="answer" class="form-control" id="answer" placeholder="Answers" style="height: 100px" required></textarea>
                            <label for="answer" class="form-label">Answers</label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" name="btnFaqs" class="btn btn-primary">Add</button>
                            <button type="button" class="btn border border-2" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
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

    <script>
        $(document).ready(function() {
            //load all logs from database
            $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                $("#showLogs").html(data);
            });

            $.post('municipal_includes/AllSuperAdmin.php', {}, function(data) {
                $("#showAllSuperAdmin").html(data);
            });

            $.post('municipal_maintainability/showAllFaqs.php', {}, function(data) {
                $("#showAllFaqs").html(data);
            });

            function updateLogs() {
                $.post('municipal_includes/showAllLogs.php', {}, function(data) {
                    $("#showLogs").html(data);
                    setTimeout(updateLogs, 10000);
                });
            }

            // Initial call to load messages
            updateLogs();

            function editTermsConditions(tm_id, tm_title, tm_content) {
                // Set the service ID, title, and description in the modal fields
                $('#updateTM_id').val(tm_id);
                $('#updateTM_content').val(tm_content);

                // Update the modal title or any other elements if necessary
                $('#updateTM_title').val(tm_title);

                // Show the modal
                $('#updateTMModal').modal('show');
            }

            function deleteTersConditions(tm_id, tm_title, tm_content) {
                // Set the service ID, title, and description in the modal fields
                $('#deleteTM_id').val(tm_id);
                $('#deleteTM_content').text(tm_content);

                // Update the modal title or any other elements if necessary
                $('#deleteTM_title').text(tm_title);

                // Show the modal
                $('#deleteTMModal').modal('show');
            }

            // fetch terms and conditions
            $.ajax({
                url: '../includes/show_terms_conditions.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {

                        $('#termsContainer').empty();

                        response.forEach(function(item) {

                            var termHtml = `
                                <li class="list-group-item" role="listitem">
                                    <p><strong>${item.count}. ${item.tm_title}</strong></p>
                                    <p>${item.tm_content}</p>
                                    <button class="btn btn-sm btn-success edit_tm" data-id="${item.tm_id}" data-title="${item.tm_title}" data-content="${item.tm_content}">Edit</button>
                                    <button class="btn btn-sm btn-danger delete_tm" data-id="${item.tm_id}" data-title="${item.tm_title}" data-content="${item.tm_content}">Delete</button>
                                </li>`;
                            $('#termsContainer').append(termHtml);
                        });

                        $('.edit_tm').on('click', function() {
                            let tm_id = $(this).data('id');
                            let tm_title = $(this).data('title');
                            let tm_content = $(this).data('content');

                            // Call the editTermsCondition function with the service details
                            editTermsConditions(tm_id, tm_title, tm_content);
                        });

                        $('.delete_tm').on('click', function() {
                            let tm_id = $(this).data('id');
                            let tm_title = $(this).data('title');
                            let tm_content = $(this).data('content');

                            // Call the deleteService function with the service details
                            deleteTersConditions(tm_id, tm_title, tm_content);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

            $('#addTMModal form').on('submit', function(event) {
                // Clear any previous error messages
                $('#showAddTMError').empty();

                var title = $('#addTM_title').val().trim();
                var contetn = $('#addTM_content').val().trim();

                if (title === '' || contetn === '') {
                    event.preventDefault(); // Prevent form submission

                    // Create the alert HTML
                    var alertHtml = `
            <div class="alert alert-warning" role="alert">
                Both the title and content must be filled out.
            </div>`;

                    // Insert the alert into the #showAddTMError div
                    $('#showAddTMError').html(alertHtml);

                    setTimeout(function() {
                        $('#showAddTMError').empty();
                    }, 3000);
                }
            });

            $('#updateTMModal form').on('submit', function(event) {
                // Clear any previous error messages
                $('#showUpdateTMError').empty();

                var title = $('#updateTM_title').val().trim();
                var content = $('#updateTM_content').val().trim();

                if (title === '' || content === '') {
                    event.preventDefault(); // Prevent form submission

                    // Create the alert HTML
                    var alertHtml = `
            <div class="alert alert-warning" role="alert">
                Both the title and content must be filled out.
            </div>`;

                    $('#showUpdateTMError').html(alertHtml);

                    setTimeout(function() {
                        $('#showUpdateTMError').empty();
                    }, 3000);
                }
            });

            // fetch home 
            $.ajax({
                url: '../includes/show_home.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $('#home_content_id').val(response.home_id);
                        $('#homeTitle').text(response.home_title);
                        $('#homeSubtitle1').text(response.home_subtitleOne);
                        $('#homeSubtitle2').text(response.home_subtitleTwo);
                        $('#homeImg').attr('src', '../index_dbImg/' + response.home_img);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

            document.getElementById("home_content_img").addEventListener("change", function(event) {
                const fileInput = event.target;
                const file = fileInput.files[0]; // Get the first (and only) file
                const maxSize = 8 * 1024 * 1024; // 8MB in bytes

                // Clear previous error messages
                const errorContainer = document.getElementById('showHomeContentError');
                errorContainer.innerHTML = '';

                if (file) {
                    // Check if the file size exceeds 8MB
                    if (file.size > maxSize) {
                        // Show an error message if the file is too large
                        errorContainer.innerHTML = `
                <div class="alert alert-danger text-center" role="alert">
                    Image is too large. Maximum size is 8MB.
                </div>`;
                        console.log("Skipped image (too large):", file.name);

                        // Clear the file input
                        fileInput.value = '';

                        // Clear the error message after 3 seconds
                        setTimeout(() => {
                            errorContainer.innerHTML = '';
                        }, 3000);
                    } else {
                        // Log the file's name and size
                        console.log("File Name:", file.name);
                        console.log("File Size:", file.size); // Size in bytes
                    }
                }
            });

            function editService(serviceId, serviceTitle, serviceDesc) {
                // Set the service ID, title, and description in the modal fields
                $('#updateServices_id').val(serviceId);
                $('#updateServices_desc').val(serviceDesc);

                // Update the modal title or any other elements if necessary
                $('#updateServices_title').val(serviceTitle);

                // Show the modal
                $('#updateServicesModal').modal('show');
            }

            function deleteService(serviceId, serviceTitle, serviceDesc) {
                // Set the service ID, title, and description in the modal fields
                $('#deleteServices_id').val(serviceId);
                $('#deleteServices_desc').text(serviceDesc);

                // Update the modal title or any other elements if necessary
                $('#deleteServices_title').text(serviceTitle);

                // Show the modal
                $('#deleteServicesModal').modal('show');
            }

            // fetch services
            $.ajax({
                url: '../includes/show_services.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $('#services_container').empty(); // Clear existing content

                        response.forEach(function(service) {
                            var serviceCard = `
                    <div class="col">
                    <div class="card border shadow rounded mb-3">
                        <div class="card-header p-3 fs-6 text-center d-flex justify-content-between align-items-center">
                            <span>${service.services_title}</span>
                        </div>
                        <div class="card-body p-3">
                            <p class="card-text small">${service.services_desc}</p>

                             <button class="btn btn-sm btn-success shadow me-2 edit-service" data-id="${service.services_id}" data-title="${service.services_title}" data-desc="${service.services_desc}">Edit</button>
                                <button class="btn btn-sm btn-danger shadow delete-service" data-id="${service.services_id}" data-title="${service.services_title}" data-desc="${service.services_desc}">Delete</button>
                        </div>
                    </div>
                </div>

                                `;
                            $('#services_container').append(serviceCard);
                        });

                        // Attach click event listener to all Edit buttons after they are added to the DOM
                        $('.edit-service').on('click', function() {
                            let serviceId = $(this).data('id');
                            let serviceTitle = $(this).data('title');
                            let serviceDesc = $(this).data('desc');

                            // Call the editService function with the service details
                            editService(serviceId, serviceTitle, serviceDesc);
                        });

                        $('.delete-service').on('click', function() {
                            let serviceId = $(this).data('id');
                            let serviceTitle = $(this).data('title');
                            let serviceDesc = $(this).data('desc');

                            // Call the deleteService function with the service details
                            deleteService(serviceId, serviceTitle, serviceDesc);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

            $('#addServicesModal form').on('submit', function(event) {
                // Clear any previous error messages
                $('#showAddServicesError').empty();

                var title = $('#addServices_title').val().trim();
                var description = $('#addServices_desc').val().trim();

                if (title === '' || description === '') {
                    event.preventDefault(); // Prevent form submission

                    // Create the alert HTML
                    var alertHtml = `
            <div class="alert alert-warning" role="alert">
                Both the title and description must be filled out.
            </div>`;

                    // Insert the alert into the #showAddServicesError div
                    $('#showAddServicesError').html(alertHtml);

                    setTimeout(function() {
                        $('#showAddServicesError').empty();
                    }, 3000);
                }
            });

            $('#updateServicesModal form').on('submit', function(event) {
                // Clear any previous error messages
                $('#showUpdateServicesError').empty();

                var title = $('#updateServices_title').val().trim();
                var description = $('#updateServices_desc').val().trim();

                if (title === '' || description === '') {
                    event.preventDefault(); // Prevent form submission

                    // Create the alert HTML
                    var alertHtml = `
            <div class="alert alert-warning" role="alert">
                Both the title and description must be filled out.
            </div>`;

                    // Insert the alert into the #showUpdateServicesError div
                    $('#showUpdateServicesError').html(alertHtml);

                    setTimeout(function() {
                        $('#showUpdateServicesError').empty();
                    }, 3000);
                }
            });

            // fetch contact
            $.ajax({
                url: 'municipal_maintainability/show_contact.php', // Replace with the path to your PHP script
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#contact_container').html('<p>' + response.error + '</p>');
                    } else {
                        let html = '';
                        response.forEach(contact => {
                            html += `
                        <div class="col-md-4 mb-3">
                            <div class="card shadow border border-2 rounded-3">
                                <div class="card-body">
                                    <h6>Phone Number</h6>
                                    <p><small>${contact.contact_number || 'N/A'}</small></p>
                                    <h6>Email</h6>
                                    <p><small>${contact.contact_email || 'N/A'}</small></p>
                                    <h6>Location</h6>
                                    <p><small>${contact.contact_location || 'N/A'}</small></p>
                                     <button class="btn btn-danger btn-sm shadow" data-id="${contact.contact_id}" data-number="${contact.contact_number}" data-email="${contact.contact_email}" data-location="${contact.contact_location}" data-bs-toggle="modal" data-bs-target="#deleteContactModal">Delete</button>
                                </div>
                            </div>
                        </div>`;
                        });
                        $('#contact_container').html(html);
                    }
                },
                error: function(xhr, status, error) {
                    $('#contact_container').html('<p>An error occurred while fetching contact data.</p>');
                    console.error('AJAX Error:', status, error);
                }
            });

            // handling invalid input for contact number
            document.getElementById('contact_number').addEventListener('input', function() {
                const phoneNumber = this.value;
                const phoneAlert = document.getElementById('phone-alert');

                // Regex to match Philippine phone numbers: 10 digits after the +63
                const phonePattern = /^[9]\d{9}$/;

                if (!phonePattern.test(phoneNumber)) {
                    phoneAlert.style.display = 'block';
                } else {
                    phoneAlert.style.display = 'none';
                    submitError.style.display = 'none';
                }
            });
            // handling invalid input for email address
            document.getElementById('contct_email').addEventListener('input', function() {
                const email = this.value;
                const emailAlert = document.getElementById('email-alert');

                // Simple regex to validate email addresses
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailPattern.test(email)) {
                    emailAlert.style.display = 'block';
                } else {
                    emailAlert.style.display = 'none';
                    submitError.style.display = 'none';
                }
            });
            // Handle form submission
            document.getElementById('addContactForm').addEventListener('submit', function(event) {
                const phoneNumber = document.getElementById('contact_number').value;
                const email = document.getElementById('contct_email').value;
                const phoneAlert = document.getElementById('phone-alert').style.display;
                const emailAlert = document.getElementById('email-alert').style.display;
                const submitError = document.getElementById('submitError');
                const noInputError = document.getElementById('no-input-error');

                // Check if there are any validation errors
                if (phoneAlert === 'block' || emailAlert === 'block') {
                    // Prevent form submission
                    event.preventDefault();
                    // Show the submit error message
                    submitError.style.display = 'block';
                    noInputError.style.display = 'none';
                } else if (!phoneNumber && !email) {
                    // Prevent form submission if no input fields are filled
                    event.preventDefault();
                    // Show the error message for no input
                    noInputError.style.display = 'block';
                    submitError.style.display = 'none';
                } else {
                    // Hide the error messages if everything is fine
                    submitError.style.display = 'none';
                    noInputError.style.display = 'none';
                }
            });

            $(document).on('show.bs.modal', '#deleteContactModal', function(event) {
                let button = $(event.relatedTarget); // Button that triggered the modal
                let id = button.data('id'); // Extract info from data-id attribute
                let number = button.data('number');
                let email = button.data('email');
                let location = button.data('location');

                console.log(id);

                // Update the modal with the contact details
                $('#deleteContactModalLabel').text('Delete Contact ID: ' + id);
                $('#deleteContact_number').text(number);
                $('#deleteContact_email').text(email);
                $('#deleteContact_location').text(location);
                $('#deleteContact_id').val(id);
            });

            // show all locations
            const input = document.getElementById('contact_location');
            const resultsContainer = document.getElementById('autocomplete-results');
            const locations = [
                'Brgy. Alua, San Isidro, Nueva Ecija',
                'Brgy. Calaba, San Isidro, Nueva Ecija',
                'Brgy. Malapit, San Isidro, Nueva Ecija',
                'Brgy. Mangga, San Isidro, Nueva Ecija',
                'Brgy. Poblacion, San Isidro, Nueva Ecija',
                'Brgy. Pulo, San Isidro, Nueva Ecija',
                'Brgy. San Roque, San Isidro, Nueva Ecija',
                'Brgy. Santo Cristo, San Isidro, Nueva Ecija',
                'Brgy. Tabon, San Isidro, Nueva Ecija'
            ];
            let debounceTimeout;

            input.addEventListener('keyup', () => {
                clearTimeout(debounceTimeout);

                const query = input.value.toLowerCase();
                if (query.length < 1) {
                    resultsContainer.innerHTML = '';
                    return;
                }

                debounceTimeout = setTimeout(() => {
                    const filteredLocations = locations.filter(location =>
                        location.toLowerCase().includes(query)
                    );
                    resultsContainer.innerHTML = filteredLocations.map(location => `
                    <li class="list-group-item list-group-item-action">
                        ${location}
                    </li>
                `).join('');
                }, 300); // Debounce delay
            });

            resultsContainer.addEventListener('click', (event) => {
                const suggestion = event.target.closest('.list-group-item');
                if (suggestion) {
                    input.value = suggestion.textContent.trim();
                    resultsContainer.innerHTML = '';
                }
            });

            // fetch about us and mission
            $.ajax({
                url: '../includes/show_about_mission.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        $('#about_us').text(response.about_us);
                        $('#our_mission').text(response.our_mission);

                        // fetch to the modal
                        $('#update_about_mission_id').val(response.about_mission_id);
                        $('#update_about_us').text(response.about_us);
                        $('#update_our_mission').text(response.our_mission);

                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

            // handling error for about mission modal
            document.getElementById('updateAboutMissionForm').addEventListener('submit', function(event) {
                const aboutUs = document.getElementById('update_about_us').value.trim();
                const ourMission = document.getElementById('update_our_mission').value.trim();
                const showError = document.getElementById('showUpdateAboutMissionError');

                // Clear any previous error messages
                showError.innerHTML = '';

                // Check if both fields are empty
                if (!aboutUs || !ourMission) {
                    event.preventDefault();
                    // Show error message
                    showError.innerHTML = `
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>Please fill out both the "About Us" and "Our Mission" fields.
            </div>`;

                    setTimeout(() => {
                        showError.innerHTML = '';
                    }, 3000);
                }
            });


            // get super admin info
            function navigateGroups(currentGroup, nextGroup) {
                $(currentGroup).addClass('d-none');
                $(nextGroup).removeClass('d-none');
            }

            $('#nextBtn1').click(function() {
                navigateGroups('#group1', '#group2');
            });

            $('#prevBtn2').click(function() {
                navigateGroups('#group2', '#group1');
            });

            $('#nextBtn2').click(function() {
                navigateGroups('#group2', '#group3');
            });

            $('#prevBtn3').click(function() {
                navigateGroups('#group3', '#group2');
            });

            $('#nextBtn4').click(function() {
                navigateGroups('#group3', '#group4');
            });

            $('#prevBtn4').click(function() {
                navigateGroups('#group4', '#group3');
            });

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
            togglePasswordVisibility("signupPassword", "signupShowPasswordIcon");
            togglePasswordVisibility("confirmPassword", "confirmShowPasswordIcon");
        });
    </script>

    <script src="municipalMaterials/script.m.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
function displaySuccessMessage($sessionKey, $title = "Success", $icon = "success")
{
    if (isset($_SESSION[$sessionKey])) {
        echo '<script>
                Swal.fire({
                    title: "' . $title . '",
                    text: "' . $_SESSION[$sessionKey] . '",
                    icon: "' . $icon . '",
                });
            </script>';
        unset($_SESSION[$sessionKey]);
    }
}

// super admin
displaySuccessMessage('addSuperAdmin_success_message');

//terms conditions
displaySuccessMessage('add_tm_message');
displaySuccessMessage('update_tm_message');
displaySuccessMessage('delete_tm_message');

//home
displaySuccessMessage('update_content_message');
displaySuccessMessage('no_fileds_update_message', 'Oops!', 'warning');
displaySuccessMessage('update_content_img_error', 'Invalid Image Size', 'error');

//services
displaySuccessMessage('add_services_message');
displaySuccessMessage('update_services_message');
displaySuccessMessage('delete_services_message');

//contact
displaySuccessMessage('add_contact_message');
displaySuccessMessage('delete_contact_message');

//about mission
displaySuccessMessage('update_aboutMission_message');

//faqs
displaySuccessMessage('faq_message');
displaySuccessMessage('delete_faq_message');
?>