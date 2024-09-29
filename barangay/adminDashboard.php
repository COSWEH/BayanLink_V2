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

// If user role is not brgy admin
if ($user_role != 1) {
    header('Location: ../unauthorized.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiling</title>
    <link rel="stylesheet" href="brgyMaterials/style.b.css">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <a class="nav-link " aria-current="page" href="adminPost.b.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="adminDocument.b.php">Document</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="adminProfiling.b.php">Profiling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active-post" aria-current="page" href="adminDashboard.php">Dashboard</a>
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
                <div>
                    <button id="theme-toggle" class="btn btn-sm shadow mb-3">
                        <i class="bi bi-moon-fill" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
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
                            $fullname = $_SESSION['user_fname'] . " " . $_SESSION['user_mname'] . " " . $_SESSION['user_lname'];
                            echo ucwords($fullname);
                            ?>
                        </h6>
                    </div>
                    <hr>
                    <h3 class="mb-3">Menu</h3>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="adminPost.b.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="adminDocument.b.php">Document</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " aria-current="page" href="adminProfiling.b.php">Profiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active-document" aria-current="page" href="adminDashboard.php">Dashboard</a>
                        </li>
                        <hr>
                    </ul>
                </div>
                <button type="button" class="btn mt-3 w-100 rounded-5  mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>

            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Admin account</h6>
                        <button class="btn btn-sm btn-success" aria-current="page" data-bs-toggle="modal" data-bs-target="#addAdmin">Add account</button>
                    </div>
                    <div class="card-body">

                        <div id="showAllAdmin" class="overflow-auto" style="height: 300px;">

                        </div>
                    </div>
                </div>

                <div class="card mb-3 shadow border-0 rounded-3">
                    <div class="ms-3 mt-3">
                        <h6>Types of documents</h6>
                        <button class="btn btn-sm btn-success" aria-current="page" data-bs-toggle="modal" data-bs-target="#addDocumentModal">Add document</button>
                    </div>
                    <div class="card-body">

                        <div id="showAllDocuments" class="overflow-auto" style="height: 300px;">

                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- add admin account modal -->
    <div class="modal fade" id="addAdmin" tabindex="-1" aria-labelledby="addAdminLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-person-plus text-success" style="font-size: 25px;"></i>
                    </div>
                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Add Admin Account</h6>
                    <p class="text-muted">Please fill in the necessary information to create a new admin account.</p>

                    <div class="container">
                        <form action="brgy_includes/addAdminAcc.php" method="POST">

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
                                    <select name="user_purok" class="form-control" id="user_purok" required>
                                        <option value="" disabled selected>Select Purok</option>
                                        <option value="Purok 1">Purok 1</option>
                                        <option value="Purok 2">Purok 2</option>
                                        <option value="Purok 3">Purok 3</option>
                                        <option value="Purok 4">Purok 4</option>
                                        <option value="Purok 5">Purok 5</option>
                                        <option value="Purok 6">Purok 6</option>
                                        <option value="Purok 7">Purok 7</option>
                                        <option value="Purok 8">Purok 8</option>
                                        <option value="Purok 9">Purok 9</option>
                                    </select>
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
                                            <input type="password" name="confirmPassword" class="form-control mb-3" id="confirmPassword" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must match the password entered above">
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
                                        <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                            <i class="bi bi-check-square"></i> Submit
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

    <!-- add doc modal -->
    <div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-file-earmark-text text-success" style="font-size: 25px;"></i>
                    </div>

                    <h6 class="my-3 fw-semibold">Add Document</h6>
                    <p class="text-muted">Fill out the form below to add a new document.</p>

                    <div class="container">
                        <form action="brgy_includes/addDocument.php" method="POST" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="documentType" name="documentType" placeholder="Document Type" required>
                                <label for="documentType">Document Type</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="file" class="form-control" id="documentTemplate" name="documentTemplate" placeholder="Document Template" accept=".pdf" required>
                                <label for="documentType">Document Template</label>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="btnAddDocument" class="btn btn-primary">
                                    Add Document
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
        var selectedCity = "<?php echo $_SESSION['user_city']; ?>";
        document.getElementById('placeOfBirth').value = selectedCity + ', Nueva Ecija';

        $(document).ready(function() {

            $.post('brgy_includes/AllAdmin.php', {}, function(data) {
                $("#showAllAdmin").html(data);
            });

            $.post('brgy_includes/showAllDocuments.php', {}, function(data) {
                $("#showAllDocuments").html(data);
            });

            // get admin info
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
    <script src="brgyMaterials/script.b.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
// Function to display SweetAlert messages
function displayAlert($type, $message, $title)
{
    echo '<script>
            Swal.fire({
                title: "' . $title . '",
                text: "' . $message . '",
                icon: "' . $type . '",
            });
        </script>';
}

// Define session messages and their configurations
$alerts = [
    'delete_message' => ['type' => 'success', 'title' => 'Success'],
    'addAdmin_success_message' => ['type' => 'success', 'title' => 'Success'],
    'delete_docType_message' => ['type' => 'success', 'title' => 'Success'],
    'add_doc_message' => ['type' => 'success', 'title' => 'Success']
];

// Iterate over each session key and display the alert if set
foreach ($alerts as $sessionKey => $alertConfig) {
    if (isset($_SESSION[$sessionKey])) {
        displayAlert($alertConfig['type'], $_SESSION[$sessionKey], $alertConfig['title']);
        unset($_SESSION[$sessionKey]);
    }
}
?>