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
    <title>Document</title>
    <link rel="stylesheet" href="civilianMaterials/style.c.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jquery ajax cdn -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
                        <a class="nav-link " aria-current="page" href="profile.c.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active-post" aria-current="page" href="document.c.php">Request Document</a>
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
                <div class="d-flex justify-content-between mb-3">
                    <button id="theme-toggle" class="btn shadow">
                        <i class="bi bi-moon-fill" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
                    </button>
                    <div class="dropdown">
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
                        <a class="nav-link " aria-current="page" href="profile.c.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  active-document" aria-current="page" href="document.c.php">Request Document</a>
                    </li>
                    <hr>
                </ul>

                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="card mb-3 shadow p-3">
                    <div class="d-flex align-items-center">
                        <!-- Profile Image -->
                        <?php
                        $getGender = $_SESSION['user_gender'];
                        if ($getGender == "Male") {
                            echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 75px; height: 75px;">';
                        } else {
                            echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 75px; height: 75px;">';
                        }
                        ?>
                        <button type="button" class="btn btn-lg ms-3  rounded-5 w-100 bg-light-subtle" data-bs-toggle="modal" data-bs-target="#reqDocModal">
                            <i class="bi bi-file-earmark-text-fill me-2"></i>
                            Request document
                        </button>
                    </div>
                </div>

                <div class="card mb-3 shadow bg-body-secondary border-0 rounded-3">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-exclamation-circle mx-3" style="font-size: 2rem;"></i>
                        <p class="mb-0 fw-medium">
                            <small class="text-muted">
                                Please note that documents containing sensitive information or those requiring the physical presence of a resident cannot be processed through this system.
                            </small>
                        </p>
                    </div>
                </div>

                <nav>
                    <div class="nav nav-underline position-relative" id="nav-tab" role="tablist">
                        <button class="nav-link active flex-fill  position-relative" id="nav-pending-tab" data-bs-toggle="tab" data-bs-target="#nav-pending" type="button" role="tab" aria-controls="nav-pending" aria-selected="true">
                            Pending
                            <div id="count-pending"></div>
                        </button>
                        <button class="nav-link flex-fill  position-relative" id="nav-processing-tab" data-bs-toggle="tab" data-bs-target="#nav-processing" type="button" role="tab" aria-controls="nav-processing" aria-selected="false">
                            Processing
                            <div id="count-processing"></div>
                        </button>
                        <button class="nav-link flex-fill  position-relative" id="nav-approved-tab" data-bs-toggle="tab" data-bs-target="#nav-approved" type="button" role="tab" aria-controls="nav-approved" aria-selected="false">
                            Approved
                            <div id="count-approved"></div>
                        </button>
                        <button class="nav-link flex-fill  position-relative" id="nav-cancelled-tab" data-bs-toggle="tab" data-bs-target="#nav-cancelled" type="button" role="tab" aria-controls="nav-cancelled" aria-selected="false">
                            Cancelled
                            <div id="count-cancelled"></div>
                        </button>
                    </div>
                </nav>

                <div class="tab-content mt-2 p-1" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab" tabindex="0">
                        <!-- show all pending document requests -->
                        <div id="show_pending_reqDoc" class="row">
                            <!-- Content for pending requests -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-processing" role="tabpanel" aria-labelledby="nav-processing-tab" tabindex="0">
                        <!-- show all processing document requests -->
                        <div id="show_processing_reqDoc" class="row">
                            <!-- Content for processing requests -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab" tabindex="0">
                        <!-- show all approved document requests -->
                        <div id="show_approved_reqDoc" class="row">
                            <!-- Content for approved requests -->
                        </div>
                    </div>

                    <div class="tab-pane fade" id="nav-cancelled" role="tabpanel" aria-labelledby="nav-cancelled-tab" tabindex="0">
                        <!-- show all cancelled document requests -->
                        <div id="show_cancelled_reqDoc" class="row">
                            <!-- Content for cancelled requests -->
                        </div>
                    </div>
                </div>


            </main>
        </div>
    </div>

    <!-- Request Document Modal -->
    <div class="modal fade" id="reqDocModal" tabindex="-1" aria-labelledby="reqDocModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-info-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-file-earmark-text text-info" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Request a Document</h6>
                    <p class="text-muted">Please fill in the necessary information to request a document.</p>

                    <div class="container">
                        <!-- Request Document Form -->
                        <form id="requestDocumentForm" action="civilian_includes/create_reqDoc.php" method="POST" enctype="multipart/form-data">
                            <!-- Step 1: Request For and Document Type -->
                            <div id="step1" class="form-step">
                                <div class="form-floating mb-3">
                                    <select id="documentType" name="docType" class="form-select" required>
                                        <!-- show all document type from database -->
                                    </select>
                                    <label for="documentType">Document Type</label>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary  w-100" id="nextBtn1">Next
                                            <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: First, Middle, and Last Name -->
                            <div id="step2" class="form-step d-none">
                                <h4 class="h4  mb-3">Full Name</h4>
                                <input type="hidden" name="getUserid" value="<?php echo $getUserid; ?>">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input id="firstName" class="form-control" type="text" name="fName" placeholder="First Name" value="<?php echo $_SESSION['user_fname']; ?>" required>
                                            <label for="firstName">First Name</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input id="middleName" class="form-control" type="text" name="mName" placeholder="Middle Name" value="<?php echo $_SESSION['user_mname']; ?>" required>
                                            <label for="middleName">Middle Name</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input id="lastName" class="form-control" type="text" name="lName" placeholder="Last Name" value="<?php echo $_SESSION['user_lname']; ?>" required>
                                            <label for="lastName">Last Name</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary  w-100" id="prevBtn1">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary  w-100" id="nextBtn2">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Contact No, Gender, and Barangay -->
                            <div id="step3" class="form-step d-none">
                                <h4 class="h4  mb-3">Contact Information</h4>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input id="contactNumber" class="form-control" type="text" name="contNumber" placeholder="Contact Number" value="<?php echo $_SESSION['user_contactNum']; ?>" required>
                                            <label for="contactNumber">Contact Number</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select id="user_gender" name="user_gender" class="form-select" required>
                                                <option value="" disabled selected>Select Male or Female</option>
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
                                        <?php $user_brgy = $_SESSION['user_brgy']; ?>
                                        <div class="form-floating mb-3">
                                            <select name="user_brgy" id="user_brgy" class="form-select" required>
                                                <option value="" disabled <?php echo $user_brgy === 'N/a' ? 'selected' : ''; ?>>Select Barangay</option>
                                                <option value="Alua" <?php echo $user_brgy === 'Alua' ? 'selected' : ''; ?>>Alua</option>
                                                <option value="Calaba" <?php echo $user_brgy === 'Calaba' ? 'selected' : ''; ?>>Calaba</option>
                                                <option value="Malapit" <?php echo $user_brgy === 'Malapit' ? 'selected' : ''; ?>>Malapit</option>
                                                <option value="Mangga" <?php echo $user_brgy === 'Mangga' ? 'selected' : ''; ?>>Mangga</option>
                                                <option value="Poblacion" <?php echo $user_brgy === 'Poblacion' ? 'selected' : ''; ?>>Poblacion</option>
                                                <option value="Pulo" <?php echo $user_brgy === 'Pulo' ? 'selected' : ''; ?>>Pulo</option>
                                                <option value="San Roque" <?php echo $user_brgy === 'San Roque' ? 'selected' : ''; ?>>San Roque</option>
                                                <option value="Sto. Cristo" <?php echo $user_brgy === 'Sto. Cristo' ? 'selected' : ''; ?>>Sto. Cristo</option>
                                                <option value="Tabon" <?php echo $user_brgy === 'Tabon' ? 'selected' : ''; ?>>Tabon</option>
                                            </select>
                                            <label for="user_brgy" class="form-label">Which Barangay are you from?</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary  w-100" id="prevBtn2">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary  w-100" id="nextBtn3">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Purok, Age, and Date of Birth -->
                            <div id="step4" class="form-step d-none">
                                <h4 class="h4  mb-3">Additional Information</h4>
                                <div class="row">
                                    <div class="col">
                                        <?php $user_purok = $_SESSION['user_purok']; ?>
                                        <div class="form-floating mb-3">
                                            <select id="user_purok" class="form-control" name="purok" required>
                                                <option value="" disabled>Select Purok</option>
                                                <option value="Purok 1" <?php if ($user_purok == "Purok 1") echo "selected"; ?>>Purok 1</option>
                                                <option value="Purok 2" <?php if ($user_purok == "Purok 2") echo "selected"; ?>>Purok 2</option>
                                                <option value="Purok 3" <?php if ($user_purok == "Purok 3") echo "selected"; ?>>Purok 3</option>
                                                <option value="Purok 4" <?php if ($user_purok == "Purok 4") echo "selected"; ?>>Purok 4</option>
                                                <option value="Purok 5" <?php if ($user_purok == "Purok 5") echo "selected"; ?>>Purok 5</option>
                                                <option value="Purok 6" <?php if ($user_purok == "Purok 6") echo "selected"; ?>>Purok 6</option>
                                                <option value="Purok 7" <?php if ($user_purok == "Purok 7") echo "selected"; ?>>Purok 7</option>
                                                <option value="Purok 8" <?php if ($user_purok == "Purok 8") echo "selected"; ?>>Purok 8</option>
                                                <option value="Purok 9" <?php if ($user_purok == "Purok 9") echo "selected"; ?>>Purok 9</option>
                                            </select>
                                            <label for="user_purok">Purok</label>
                                        </div>


                                        <?php $dateOfBirth = $_SESSION['dateOfBirth']; ?>
                                        <div class="form-floating mb-3">
                                            <input id="dateOfBirth" class="form-control" type="date" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>" placeholder="Date of Birth" required>
                                            <label for="dateOfBirth">Date of Birth</label>
                                        </div>
                                        <?php $dob = new DateTime($dateOfBirth);
                                        $now = new DateTime();
                                        $interval = $now->diff($dob);
                                        $age = $interval->y; ?>
                                        <div class="form-floating mb-3">
                                            <input id="user_age" class="form-control" type="number" name="age" placeholder="Age" value="<?php echo $age; ?>" required>
                                            <label for="user_age">Age</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary  w-100" id="prevBtn3">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary  w-100" id="nextBtn4">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 5: Place of Birth, Civil Status, and e-Signature -->
                            <div id="step5" class="form-step d-none">
                                <h4 class="h4  mb-3">Additional Information</h4>
                                <div class="row">
                                    <div class="col">
                                        <?php $placeOfBirth = $_SESSION['placeOfBirth']; ?>
                                        <div class="form-floating mb-3">
                                            <input id="placeOfBirth" class="form-control" type="text" name="placeOfBirth" placeholder="Place of Birth" value="<?php echo $placeOfBirth; ?>" required>
                                            <label for="placeOfBirth">Place of Birth</label>
                                        </div>
                                        <?php
                                        $civilStatus = isset($_SESSION['civilStatus']) ? $_SESSION['civilStatus'] : '';
                                        ?>
                                        <div class="form-floating mb-3">
                                            <select id="civilStatus" name="civilStatus" class="form-select" required>
                                                <option value="" disabled <?php echo empty($civilStatus) ? 'selected' : ''; ?>>Choose Status</option>
                                                <option value="Single" <?php echo $civilStatus === 'Single' ? 'selected' : ''; ?>>Single</option>
                                                <option value="Married" <?php echo $civilStatus === 'Married' ? 'selected' : ''; ?>>Married</option>
                                                <option value="Widowed" <?php echo $civilStatus === 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                                                <option value="Divorced" <?php echo $civilStatus === 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                                            </select>
                                            <label for="civilStatus">Civil Status</label>
                                        </div>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary  w-100" id="prevBtn4">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary  w-100" id="nextBtn5">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 6: Valid ID, Password -->
                            <div id="step6" class="form-step d-none">
                                <h4 class="h4  mb-3">Final Information</h4>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-floating mb-3">
                                            <input id="eSignature" class="form-control" type="file" name="eSignature" accept=".jpg, jpeg, .png" required>
                                            <label for="eSignature" class="form-label">E-Signature</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="userValidID" class="form-control" type="file" name="userValidID" accept=".jpg, jpeg, .png" required>
                                            <label for="userValidID" class="form-label">Valid ID</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="esImgSizeError"></div>
                                <div id="viImgSizeError"></div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary  w-100" id="prevBtn5">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" name="btnReqDocument" id="btnReqDocument" class="btn btn-success  w-100">
                                            Submit <i class="bi bi-check-square"></i>
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

        document.getElementById('dateOfBirth').addEventListener('input', function() {
            const dob = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDifference = today.getMonth() - dob.getMonth();

            // Adjust if the birthday hasn't occurred yet this year
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            // Update the age input field
            document.getElementById('user_age').value = age;
        });

        // es img
        document.getElementById("eSignature").addEventListener("change", function(event) {
            const fileInput = event.target;
            const files = fileInput.files;
            const maxSize = 8 * 1024 * 1024; // 8MB in bytes
            const validFiles = [];

            // Loop through each file in the FileList
            for (let i = 0; i < files.length; i++) {
                const file = files[i]; // Get the individual file
                // Check if the file size exceeds 8MB
                if (file.size > maxSize) {
                    $('#esImgSizeError').html('<div class="alert alert-danger text-center" role="alert">Image is too large</div>');
                    console.log("Skipped image (too large):", file.name);

                    // Clear the error message after 3 seconds
                    setTimeout(() => {
                        $('#esImgSizeError').html('');
                    }, 3000);

                    // Skip this file
                    continue;
                }

                // Log the file's name and size
                console.log("File Name:", file.name);
                console.log("File Size:", file.size); // Size in bytes

                // Add valid files to the array
                validFiles.push(file);
            }

            // Clear the input field and reassign valid files
            if (validFiles.length === 0) {
                fileInput.value = ''; // Clear the file input if no valid files
            } else {
                // Create a new DataTransfer object to assign the valid files
                const dataTransfer = new DataTransfer();
                validFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files; // Update the file input with valid files
            }
        });

        // uv img
        document.getElementById("userValidID").addEventListener("change", function(event) {
            const fileInput = event.target;
            const files = fileInput.files;
            const maxSize = 8 * 1024 * 1024; // 8MB in bytes
            const validFiles = [];

            // Loop through each file in the FileList
            for (let i = 0; i < files.length; i++) {
                const file = files[i]; // Get the individual file
                // Check if the file size exceeds 8MB
                if (file.size > maxSize) {
                    $('#viImgSizeError').html('<div class="alert alert-danger text-center" role="alert">Image is too large</div>');
                    console.log("Skipped image (too large):", file.name);

                    // Clear the error message after 3 seconds
                    setTimeout(() => {
                        $('#viImgSizeError').html('');
                    }, 3000);

                    // Skip this file
                    continue;
                }

                // Log the file's name and size
                console.log("File Name:", file.name);
                console.log("File Size:", file.size); // Size in bytes

                // Add valid files to the array
                validFiles.push(file);
            }

            // Clear the input field and reassign valid files
            if (validFiles.length === 0) {
                fileInput.value = ''; // Clear the file input if no valid files
            } else {
                // Create a new DataTransfer object to assign the valid files
                const dataTransfer = new DataTransfer();
                validFiles.forEach(file => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files; // Update the file input with valid files
            }
        });


        $(document).ready(function() {

            function updateCount(endpoint, selector) {
                $.post(endpoint, {}, function(data) {
                    $(selector).html(data);
                    setTimeout(function() {
                        updateCount(endpoint, selector);
                    }, 30000);
                });
            }

            updateCount('civilian_includes/get_pending_count.php', '#count-pending');
            updateCount('civilian_includes/get_processing_count.php', '#count-processing');
            updateCount('civilian_includes/get_approved_count.php', '#count-approved');
            updateCount('civilian_includes/get_cancelled_count.php', '#count-cancelled');


            $.ajax({
                url: '../includes/getDocTypes.php',
                type: 'POST',
                dataType: 'html',
                success: function(data) {
                    $("#documentType").html(data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                }
            });


            $.post('civilian_includes/show_notification.php', {}, function(data) {
                $("#notification-content").html(data);
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

            $.post('civilian_includes/show_notification_count.php', {}, function(data) {
                $("#count-notification").html(data);
            });

            $('#nav-pending-tab').on('click', function() {
                loadRequestDocs('pending');
            });
            $('#nav-processing-tab').on('click', function() {
                loadRequestDocs('processing');
            });
            $('#nav-approved-tab').on('click', function() {
                loadRequestDocs('approved');
            });
            $('#nav-cancelled-tab').on('click', function() {
                loadRequestDocs('cancelled');
            });

            function loadRequestDocs(status) {
                $.post(`civilian_includes/show_${status}_reqDoc.php`, {}, function(data) {
                    $(`#show_${status}_reqDoc`).html(data);
                });
            }

            function updateReqDocs() {
                const statuses = ['pending', 'processing', 'approved', 'cancelled'];

                statuses.forEach(status => {
                    loadRequestDocs(status);
                });

                setTimeout(updateReqDocs, 30000);
            }

            // Initial load for req docu
            updateReqDocs();

            // Get the buttons and steps
            const steps = [
                document.getElementById('step1'),
                document.getElementById('step2'),
                document.getElementById('step3'),
                document.getElementById('step4'),
                document.getElementById('step5'),
                document.getElementById('step6')
            ];

            const nextButtons = [
                document.getElementById('nextBtn1'),
                document.getElementById('nextBtn2'),
                document.getElementById('nextBtn3'),
                document.getElementById('nextBtn4'),
                document.getElementById('nextBtn5')
            ];

            const prevButtons = [
                document.getElementById('prevBtn1'),
                document.getElementById('prevBtn2'),
                document.getElementById('prevBtn3'),
                document.getElementById('prevBtn4'),
                document.getElementById('prevBtn5')
            ];

            // Function to show a specific step
            function showStep(stepIndex) {
                steps.forEach(step => step.classList.add('d-none'));
                steps[stepIndex].classList.remove('d-none');
            }

            // Function to add event listeners to navigation buttons
            function addNavigationListeners(nextBtns, prevBtns) {
                nextBtns.forEach((btn, index) => {
                    if (btn) {
                        btn.addEventListener('click', function() {
                            showStep(index + 1);
                        });
                    }
                });

                prevBtns.forEach((btn, index) => {
                    if (btn) {
                        btn.addEventListener('click', function() {
                            showStep(index);
                        });
                    }
                });
            }

            // Initialize with the first step
            showStep(0);

            // Add event listeners to navigation buttons
            addNavigationListeners(nextButtons, prevButtons);


        });
    </script>
    <script src="civilianMaterials/script.c.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
// Function to display SweetAlert messages
function displayAlert($type, $message, $title = "Success")
{
    echo '<script>
            Swal.fire({
                title: "' . $title . '",
                text: "' . $message . '",
                icon: "' . $type . '",
            });
        </script>';
}

// Success and error messages handling
$alerts = [
    'reqDoc_message' => ['type' => 'success', 'title' => 'Success'],
    'reqDoc_invalid_password' => ['type' => 'error', 'title' => 'Error'],
    'cancelReq_message' => ['type' => 'success', 'title' => 'Success'],
];

foreach ($alerts as $sessionKey => $alertConfig) {
    if (isset($_SESSION[$sessionKey])) {
        displayAlert($alertConfig['type'], $_SESSION[$sessionKey], $alertConfig['title']);
        unset($_SESSION[$sessionKey]);
    }
}
?>

</html>