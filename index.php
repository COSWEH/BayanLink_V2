<?php
include('includes/conn.inc.php');
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/BayanLinkLogoBlack.png" type="image/svg+xml" />
    <title>BayanLink</title>
    <!-- local css -->
    <link rel="stylesheet" href="indexMaterials/style.im.css">
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container">
            <a class="navbar-brand  fs-4" href="#home">
                <img src="img/BayanLinkLogoBlack.png" alt="Logo" width="46" height="40" class="d-inline-block align-text-top"> <small class="fw-bold">BayanLink</small></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#about">About</a>
                    </li>
                </ul>

                <div class="ms-auto">
                    <button type="button" class="btn btn-outline-success " data-bs-toggle="modal" data-bs-target="#registerModal">
                        Sign up
                    </button>

                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#loginModal">
                        Sign in
                    </button>

                    <button id="theme-toggle" class="btn btn-sm shadow">
                        <i class="bi bi-moon-fill" id="moon-icon"></i>
                        <i class="bi bi-brightness-high-fill" id="sun-icon" style="display:none;"></i>
                    </button>

                </div>
            </div>
        </div>
    </nav>

    <!-- Sign in Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-primary-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-box-arrow-in-right text-primary" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Sign In</h6>
                    <p class="text-muted">Please enter your account credentials to sign in.</p>

                    <div class="container">
                        <form action="signin.code.php" method="POST">
                            <h4 class="h4 mb-3">Account Information</h4>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="email" placeholder="Email address" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>" required>
                                <label for="email" class="form-label">Email address</label>
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input type="password" name="signinPassword" class="form-control" id="signinPassword" placeholder="Password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required pattern=".{8,}">
                                <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="showPasswordIcon">
                                    <i class="bi bi-eye-slash-fill"></i>
                                </span>
                                <label for="signinPassword" class="form-label">Password</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col d-flex align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" name="rememberMe" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                </div>
                                <div class="col text-end">
                                    <small>
                                        <a class="link-offset-2" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a>
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" name="btnSignin" class="btn btn-primary w-100">
                                        Sign in <i class="bi bi-box-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>

                <!-- Modal Footer -->
                <div class="modal-footer border-0">
                    <div class="text-center w-100">
                        <p class="text-muted">Don't have an account? <a class="link-offset-2" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Sign up here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title" id="forgotPasswordLabel">Forgot Password</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#loginModal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body text-center">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-warning-subtle mx-auto mb-3" style="height: 50px; width: 50px;">
                        <i class="bi bi-lock-fill text-warning" style="font-size: 25px;"></i>
                    </div>

                    <!-- Instruction Text -->
                    <p class="text-muted mb-4">
                        <small>Enter your email address to reset your password. A reset link will be sent to your email.</small>
                    </p>

                    <div class="container">
                        <form method="POST" action="includes/forgot-password.php">
                            <div class="form-floating mb-3">
                                <input type="email" name="fpEmail" class="form-control" id="fpEmail" required placeholder="name@example.com">
                                <label for="fpEmail">Email address</label>
                            </div>

                            <button type="submit" name="btnForgotPassword" class="btn btn-primary w-100">
                                Submit <i class="bi bi-arrow-right-circle"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-success-subtle mx-auto" style="height: 50px; width: 50px;">
                        <i class="bi bi-person-plus text-success" style="font-size: 25px;"></i>
                    </div>

                    <!-- Modal Title -->
                    <h6 class="my-3 fw-semibold">Sign Up</h6>
                    <p class="text-muted">Please fill out the form below to create your account.</p>

                    <div class="container">
                        <form action="signup.code.php" method="POST">
                            <!-- progress bar -->
                            <div id="signupProgressBar" class="progress mb-3" role="progressbar" aria-label="Default striped example" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped" style="width: 10%"></div>
                            </div>

                            <!-- Step 1: Personal Information -->
                            <div id="group1" class="form-step">
                                <h4 class="h4 mb-3">Personal Information</h4>
                                <div class="form-floating mb-3">
                                    <select id="fromSanIsidro" name="fromSanIsidro" class="form-select" required>
                                        <option value="" disabled selected>Select Yes or No</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <label for="fromSanIsidro" class="form-label">Are you from San Isidro?</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="user_city" id="user_city" class="form-select" required>
                                        <!-- Options go here -->
                                    </select>
                                    <label for="user_city" class="form-label">Municipality</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="barangay" id="user_brgy" class="form-select" required>
                                        <!-- Options go here -->
                                    </select>
                                    <label for="user_brgy" class="form-label">Which Barangay are you from?</label>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn1">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Name Details -->
                            <div id="group2" class="form-step d-none">
                                <h4 class="h4 mb-3">Name Details</h4>
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
                                    <div class="col-12 col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn1">
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

                            <!-- Step 3: Address and Contact -->
                            <div id="group3" class="form-step d-none">
                                <h4 class="h4 mb-3">Address and Contact</h4>
                                <div class="form-floating mb-3">
                                    <select id="user_sex" name="sex" class="form-select" required>
                                        <option value="" disabled selected>Select Male or Female</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="user_sex" class="form-label">Sex</label>
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
                                    <input type="number" name="contactNum" class="form-control" id="contactNum" placeholder="Contact Number" required pattern="^(09\d{9}|639\d{9})$" title="(e.g., 09123456789 or 639123456789)">
                                    <label for="contactNum" class="form-label">Contact Number</label>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn2">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-primary w-100" id="nextBtn3">
                                            Next <i class="bi bi-arrow-right-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Birth Details -->
                            <div id="group4" class="form-step d-none">
                                <h4 class="h4 mb-3">Birth Details</h4>
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

                            <!-- Step 5: Account Information -->
                            <div id="group5" class="form-step d-none">
                                <h4 class="h4 mb-3">Account Information</h4>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="user_email" placeholder="Email Address" required title="e.g., juandelacruz143@gmail.com">
                                    <label for="user_email" class="form-label">Email Address</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="username" class="form-control" id="username" placeholder="Username" required pattern="^[a-zA-Z]{2}[a-zA-Z0-9.@_\\-\\s]+$">
                                    <label for="username" class="form-label">Username</label>
                                </div>

                                <div style="position: relative;">
                                    <div class="form-floating mb-3">
                                        <input type="password" name="signup_password" class="form-control" id="signup_password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="At least one number, one uppercase letter, one lowercase letter, and at least 8 or more characters">
                                        <span class="icon position-absolute top-50 end-0 translate-middle-y p-3" id="password-toggle">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </span>
                                        <label for="signup_password" class="form-label">Password</label>
                                    </div>
                                </div>



                                <div class="form-check mb-3 d-flex align-items-center">
                                    <input class="form-check-input me-2" type="checkbox" id="agreeTerms">
                                    <label class="form-check-label text-muted" for="agreeTerms">
                                        I agree to the <a href="#" class="link-offset-2" data-bs-toggle="modal" data-bs-target="#termsConditionModal">terms and conditions</a>
                                    </label>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6 mb-2">
                                        <button type="button" class="btn btn-secondary w-100" id="prevBtn4">
                                            <i class="bi bi-arrow-left-square"></i> Previous
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="submit" class="btn btn-primary w-100" id="registerBtn" disabled>
                                            Register <i class="bi bi-check-square"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Close Button -->
                <button type="button" class="btn-close position-absolute top-0 end-0 p-3" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-footer border-0">
                    <div class="text-center w-100">
                        <p class="text-muted">Already have an account? <a class="link-offset-2" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Log in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsConditionModal" tabindex="-1" aria-labelledby="termsConditionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title" id="termsConditionModalLabel">Terms and Conditions</h4>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-toggle="modal" data-bs-target="#registerModal"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <!-- Modal Icon -->
                    <div class="d-flex justify-content-center align-items-center rounded-circle bg-light mx-auto mb-4 shadow" style="height: 60px; width: 60px;">
                        <i class="bi bi-file-earmark-text-fill text-primary" style="font-size: 30px;"></i>
                    </div>

                    <!-- Terms and Conditions Text -->
                    <div class="text-center mb-4">
                        <h5 class="fw-bold">Welcome to BayanLink</h5>
                        <p class="text-muted">Please read these Terms and Conditions carefully before using our platform.</p>
                    </div>

                    <div class="container text-start">
                        <div id="termsContainer">
                            <!-- Terms and conditions will be dynamically added here -->
                        </div>


                        <ul class="list-unstyled">
                            <li id="tm_contact_number">
                                <i class="bi bi-telephone-fill"></i>
                                Loading...
                            </li>
                            <li id="tm_contact_email">
                                <i class="bi bi-envelope-fill"></i>
                                Loading...
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Home Section -->
    <section id="home" class="container my-5">
        <div class="row align-items-center">
            <!-- Content Section -->
            <div class="col-md-6 text-center text-md-start mb-5 px-lg-5">
                <!-- title -->
                <h1 id="home-title" class="display-3  mb-5">Loading...</h1>
                <!-- subtitle 1 -->
                <p id="home-subtitle1" class="lead mb-5">Loading...</p>
                <!-- subtitle 2 -->
                <p id="home-subtitle2" class="mb-5">Loading...</p>
                <button type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#registerModal">
                    Get started
                </button>

            </div>
            <!-- Image Section -->
            <div class="col-md-6 px-lg-5">
                <!-- img -->
                <img id="home-img" src="" width="600" height="400" alt="Bayanlink Overview" class="img-fluid rounded shadow-sm">
            </div>
        </div>
        <hr>
    </section>

    <!-- Services Section -->
    <section id="services" class="container my-5">
        <h1 class="text-center mb-4">Our Services</h1>
        <div id="services_container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        </div>
        <hr>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container my-5">
        <h1 class="text-center mb-4">Get in Touch with Us!</h1>
        <p class="text-center mb-4">If you have any inquiries and want to get in touch with us, we'll be happy to help you!</p>
        <div class="row g-4">
            <div class="col-md-4">
                <div>
                    <h5 class="mb-1">Contact Phone Number</h5>
                    <p id="contact_number"><i class="bi bi-telephone-fill"></i> Loading...</p>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h5 class="mb-1">Our Email Address</h5>
                    <p id="contact_email"><i class="bi bi-envelope-fill"></i> Loading...</p>
                </div>
            </div>
            <div class="col-md-4">
                <div>
                    <h5 class="mb-1">Our Location</h5>
                    <p id="contact_location"><i class="bi bi-geo-alt-fill"></i> Loading...</p>
                </div>
            </div>
        </div>
        <hr>
    </section>

    <!-- About Section -->
    <section id="about" class="container my-5">
        <div class="row mb-4">
            <div class="col">
                <h1 class="text-center mb-3">About Us</h1>
                <p id="about_us" class="lead text-center">

                </p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col">
                <h1 class="text-center mb-3">Our Mission</h1>
                <p id="our_mission" class="lead text-center">

                </p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <h1 class="text-center mb-3">Our Amazing Team</h1>
                <div class="row g-4">
                    <div class="col-md-3 text-center">
                        <img src="img/p1.png" alt="Yvez Santiago" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Yvez Santiago</h6>
                        <p class="text-muted">Front-end Developer</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/p2.png" alt="Kevin Palma" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Kevin Palma</h6>
                        <p class="text-muted">UI/UX Designer</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/p3.png" alt="Vincent Bernardino" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Vincent Bernardino</h6>
                        <p class="text-muted">Operations Manager</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img src="img/p4.png" alt="Paolo Ramos" class="img-fluid rounded-circle mb-2" style="width: 100px; height: 100px;">
                        <h6>Paolo Ramos</h6>
                        <p class="text-muted">Back-end Developer</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center mb-3">Frequently Asked Questions</h1>
                <p class="text-center">Find answers to common questions below:</p>

                <div id="faqs">

                </div>

            </div>
        </div>

    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-5">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6 mb-2 mb-md-0">
                    <h5>About Us</h5>
                    <p id="footer_about_us"><i class="bi bi-telephone-fill"></i> Loading...</p>
                </div>
                <div class="col-md-6 mb-2 mb-md-0">
                    <h5>Contact Us</h5>
                    <p>
                        <small id="footer_contact_number">
                            <i class="bi bi-telephone-fill"></i>
                            Loading...
                        </small>
                    </p>
                    <p>
                        <small id="footer_contact_email">
                            <i class="bi bi-envelope-fill"></i>
                            Loading...
                        </small>
                    </p>
                </div>
            </div>
            <div class="pt-3">
                <p class="mb-0">&copy; <span id="current-year"></span> BayanLink. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="indexMaterials/script.im.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {

            document.getElementById('agreeTerms').addEventListener('change', function() {
                const registerBtn = document.getElementById('registerBtn');
                registerBtn.disabled = !this.checked;
            });

            function showFaqs() {
                $.post("includes/show_faqs.php", {}, function(data) {
                    $("#faqs").html(data);
                });

                setTimeout(showFaqs, 30000);
            }

            // fetch terms conditions
            function fetchTermsConditions() {
                $.ajax({
                    url: 'includes/show_terms_conditions.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            // Clear the existing content
                            $('#termsContainer').empty();

                            // Loop through the response and append each term
                            response.forEach(function(item) {
                                // Create a new section for each term and append it
                                var termHtml = `
                        <div class="term-section">
                            <p><strong>${item.count}. ${item.tm_title}</strong></p>
                            <p>${item.tm_content}</p>
                        </div>
                    `;
                                $('#termsContainer').append(termHtml);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }


            // fetch home
            function fetchHomeContent() {
                $.ajax({
                    url: 'includes/show_home.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            $('#home-title').text(response.home_title);
                            $('#home-subtitle1').text(response.home_subtitleOne);
                            $('#home-subtitle2').text(response.home_subtitleTwo);
                            $('#home-img').attr('src', 'index_dbImg/' + response.home_img);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            // fetch services
            function fetchServicesContent() {
                $.ajax({
                    url: 'includes/show_services.php',
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
                            <div class="card card-custom border shadow rounded">
                                <div class="card-header p-3 fs-5 text-center">${service.services_title}</div>
                                <div class="card-body p-3">
                                    <p class="card-text">${service.services_desc}</p>
                                </div>
                            </div>
                        </div>
                    `;
                                $('#services_container').append(serviceCard);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            // fetch contact
            function fetchContactContent() {
                $.ajax({
                    url: 'includes/show_contact.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            // Handle phone numbers
                            if (response.contact_number && response.contact_number.length > 0) {
                                const phoneNumbers = response.contact_number.map(number => `<i class="bi bi-telephone-fill"></i> ${number}`).join('<br>');
                                $('#contact_number').html(phoneNumbers);
                                $('#footer_contact_number').html(phoneNumbers);
                                $('#tm_contact_number').html(phoneNumbers);
                            } else {
                                $('#contact_number').html('No phone numbers available');
                                $('#footer_contact_number').html('No phone numbers available');
                                $('#tm_contact_number').html('No phone numbers available');
                            }

                            // Handle emails
                            if (response.contact_email && response.contact_email.length > 0) {
                                const emails = response.contact_email.map(email => `<i class="bi bi-envelope-fill"></i> ${email}`).join('<br>');
                                $('#contact_email').html(emails);
                                $('#footer_contact_email').html(emails);
                                $('#tm_contact_email').html(emails);
                            } else {
                                $('#contact_email').html('No email addresses available');
                                $('#footer_contact_email').html('No email addresses available');
                                $('#tm_contact_email').html('No email addresses available');
                            }

                            // Location
                            if (response.contact_location && response.contact_location.length > 0) {
                                const locations = response.contact_location.map(location => `<i class="bi bi-geo-alt-fill"></i> ${location}`).join('<br>');
                                $('#contact_location').html(locations);
                            } else {
                                $('#contact_location').html('Location information not available');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            // fetch about us and mission
            function fetchAboutMissionContent() {
                $.ajax({
                    url: 'includes/show_about_mission.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {

                            $('#footer_about_us').text(response.about_us);
                            $('#our_mission').text(response.our_mission);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                    }
                });
            }

            fetchTermsConditions()
            fetchHomeContent();
            fetchServicesContent();
            fetchContactContent()
            fetchAboutMissionContent();

            setInterval(fetchTermsConditions, 1000);
            setInterval(fetchHomeContent, 1000);
            setInterval(fetchServicesContent, 1000);
            setInterval(fetchContactContent, 1000);
            setInterval(fetchAboutMissionContent, 1000);
            showFaqs();

            // JavaScript to handle the steps in the multi-steps form
            const formSteps = document.querySelectorAll('.form-step');
            const progressBar = document.querySelector('.progress-bar');
            const totalSteps = formSteps.length;
            let currentStep = 0;

            function showStep(step) {
                formSteps.forEach((stepElement, index) => {
                    stepElement.classList.toggle('d-none', index !== step);
                });
                updateProgressBar(step);
            }

            function updateProgressBar(step) {
                const totalSteps = formSteps.length;
                const progressPercentage = (step / (totalSteps - 1)) * 100;
                progressBar.style.width = `${progressPercentage}%`;
            }


            function nextStep() {
                if (currentStep < formSteps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            }

            function prevStep() {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            }

            document.getElementById('nextBtn1').addEventListener('click', nextStep);
            document.getElementById('nextBtn2').addEventListener('click', nextStep);
            document.getElementById('nextBtn3').addEventListener('click', nextStep);
            document.getElementById('nextBtn4').addEventListener('click', nextStep);

            document.getElementById('prevBtn1').addEventListener('click', prevStep);
            document.getElementById('prevBtn2').addEventListener('click', prevStep);
            document.getElementById('prevBtn3').addEventListener('click', prevStep);
            document.getElementById('prevBtn4').addEventListener('click', prevStep);
            showStep(currentStep);


            const municipalityOptions = [
                "Aliaga", "Cabanatuan City", "Cabiao", "Carranglan", "Cuyapo",
                "Gabaldon", "Gapan City", "General Tinio", "General Mariano Alvarez",
                "Guimba", "Jaen", "Llanera", "Licab", "Laur",
                "Nampicuan", "Pantabangan", "Peñaranda", "Quezon", "Rizal",
                "San Antonio", "San Jose City", "San Leonardo", "San Luis",
                "San Manuel", "San Nicolas", "San Rafael", "Santa Rosa", "Santo Domingo",
                "Santo Niño", "Santo Tomas", "Talavera", "Talugtug", "Zaragoza"
            ];

            const barangayOptions = [
                "Alua", "Calaba", "Malapit", "Mangga", "Poblacion",
                "Pulo", "San Roque", "Sto. Cristo", "Tabon"
            ];

            const $fromSanIsidroSelect = $('#fromSanIsidro');
            const $user_city = $('#user_city');
            const $barangaySelect = $('#user_brgy');

            // Function to update the barangay select options
            function updateBarangayOptions() {
                const selectedValue = $fromSanIsidroSelect.val();
                $barangaySelect.empty(); // Clear existing options
                $user_city.empty();

                if (selectedValue === "Yes") {
                    $barangaySelect.append('<option value="" disabled selected>Select Barangay</option>');
                    barangayOptions.forEach(option => {
                        $barangaySelect.append(`<option value="${option}">${option}</option>`);
                    });
                    $user_city.append('<option value="" disabled selected>Select Municipality</option>');
                    $user_city.append('<option value="San Isidro">San Isidro</option>');
                } else if (selectedValue === "No") {
                    $barangaySelect.append('<option value="N/A" selected>N/A</option>');
                    $user_city.append('<option value="" disabled selected>Select Municipality</option>');
                    municipalityOptions.forEach(option => {
                        $user_city.append(`<option value="${option}">${option}</option>`);
                    });
                }
            }

            // Update options when selection changes
            $fromSanIsidroSelect.change(function() {
                updateBarangayOptions();
            });

            // Initial load
            updateBarangayOptions();

            // for place of birth
            document.getElementById('user_city').addEventListener('change', function() {
                var selectedCity = this.value;
                document.getElementById('placeOfBirth').value = selectedCity + ', Nueva Ecija';
            });

            // Function to handle the navigation between groups
            function navigateGroups(currentGroup, nextGroup, show) {
                $(currentGroup).addClass('d-none');
                $(nextGroup).removeClass('d-none');
            }

            // Event listeners for navigation buttons
            $('#nextBtn1').click(function() {
                navigateGroups('#group1', '#group2');
            });

            $('#prevBtn1').click(function() {
                navigateGroups('#group2', '#group1');
            });

            $('#nextBtn2').click(function() {
                navigateGroups('#group2', '#group3');
            });

            $('#prevBtn2').click(function() {
                navigateGroups('#group3', '#group2');
            });

            $('#nextBtn3').click(function() {
                navigateGroups('#group3', '#group4');
            });

            $('#prevBtn3').click(function() {
                navigateGroups('#group4', '#group3');
            });

            $('#nextBtn4').click(function() {
                navigateGroups('#group4', '#group5');
            });

            $('#prevBtn4').click(function() {
                navigateGroups('#group5', '#group4');
            });

            // Function to toggle password visibility
            function togglePasswordVisibility(inputId, iconId) {
                const passwordInput = document.getElementById(inputId);
                const showPasswordIcon = document.getElementById(iconId);

                // Check if elements exist
                if (passwordInput && showPasswordIcon) {
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
            }


            // Initialize the toggle for each password field
            togglePasswordVisibility("signinPassword", "showPasswordIcon");
            togglePasswordVisibility("signup_password", "password-toggle");

        });
    </script>

</body>

</html>

<?php

// Function to display a SweetAlert notification
function displayAlert($sessionKey, $title, $icon)
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

// Display notifications
displayAlert('signin_error_message', 'Sign In Error', 'warning');
displayAlert('signup_error_message', 'Sign Up Error', 'error');
displayAlert('signup_success_message', 'Sign Up Successful', 'success');
displayAlert('fpMessage', 'Password Reset Successful', 'success');
displayAlert('errorFPMessage', 'Password Reset Error', 'warning');
displayAlert('passUpdatedMessage', 'Password Updated Successfully', 'success');

?>