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
    <title>Barangay Post</title>
    <!-- local css -->
    <link rel="stylesheet" href="brgyMaterials/style.b.css">
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
                    if ($gender == "Male") {
                        echo '<img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 50px; height: 50px;">';
                    } else {
                        echo '<img src="../img/female-user.png" alt="Profile Picture" class="img-fluid rounded-circle mb-2" style="width: 50px; height: 50px;">';
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
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active-post" aria-current="page" href="adminPost.b.php">Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="adminDocument.b.php">Document</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="adminProfiling.b.php">Profiling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="adminDashboard.php">Dashboard</a>
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
                        if ($gender == "Male") {
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
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active-post" aria-current="page" href="adminPost.b.php">Post</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="adminDocument.b.php">Document</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="adminProfiling.b.php">Profiling</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="adminDashboard.php">Dashboard</a>
                        </li>

                        <hr>
                    </ul>
                </div>
                <button type="button" class="btn mt-3 w-100 rounded-5 mt-auto" data-bs-toggle="modal" data-bs-target="#signoutModal"><i class="bi bi-box-arrow-left"></i> Sign out </button>
            </nav>
            <!-- main content -->
            <main class="col-12 col-md-9 content border rounded p-3">
                <!-- create post -->
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
                        <button type="button" class="btn btn-lg ms-3 rounded-5 w-100 bg-light-subtle" data-bs-toggle="modal" data-bs-target="#postModal">
                            <i class="bi bi-images me-2"></i>
                            Create post
                        </button>
                    </div>
                    <hr>
                </div>
                <!-- show all barangay post -->
                <div id="brgyPost" class="p-2 bg-dark-subtle rounded">

                </div>
            </main>
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

    <!-- create post modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center border border-0">
                    <div class="w-100 text-center">
                        <h4 class="modal-title" id="postModalLabel">
                            Create post
                        </h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="container p-5 modal-body">
                    <!-- Post Content Form -->
                    <form id="createPostForm" action="brgy_includes/createPost.b.php" method="POST" enctype="multipart/form-data">
                        <div class="d-flex align-items-center mb-3">
                            <img src="../img/male-user.png" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 75px; height: 75px;">
                            <div>
                                <h6 class="mb-0">
                                    <?php
                                    echo $fullname;
                                    ?>
                                </h6>
                                <h6 class="text-muted mb-0">
                                    <?php
                                    echo "<small>From: Brgy. </small>" . $brgy;
                                    ?>
                                </h6>
                            </div>
                        </div>
                        <div class="mb-3">
                            <textarea name="baTextContent" class="form-control" id="postContent" rows="3" required placeholder="What's on your mind?"></textarea>
                        </div>
                        <div class="mb-3">
                            <div for="bgAddPhotos" class="rounded border bg-light-subtle text-center p-3 d-flex flex-column align-items-center justify-content-center" style="height: 150px; cursor: pointer;">
                                <i class="bi bi-images mb-2"></i>
                                <p class="m-0 ">Add Photos</p>
                                <!-- change to file -->
                                <input type="file" name="bgAddPhotos[]" id="bgAddPhotos" class="opacity-0 position-absolute" accept=".jpg, jpeg, .png" multiple>
                            </div>
                            <hr>
                            <!-- Show selected photos with equal layout -->
                            <div id="selectedPhotosForCreate" class="row g-2">
                                <!-- Selected photos will be added here -->
                            </div>
                        </div>
                        <div id="crtPstImgSizeError"></div>
                        <button type="submit" name="baBtnCreatePost" class="btn btn-primary w-100">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        //load all brgy post from database
        $(document).ready(function() {
            $.post('brgy_includes/show_brgyPost.b.php', {}, function(data) {
                $("#brgyPost").html(data);
            });

            function updateBrgyPost() {
                $.post('brgy_includes/show_brgyPost.b.php', {}, function(data) {
                    $("#brgyPost").html(data);

                });
            }
            // Initial call to load messages
            updateBrgyPost();

            // show selected photos to the create post modal
            let selectedFiles = [];
            document.getElementById("bgAddPhotos").addEventListener("change", function(event) {
                const files = event.target.files;
                const photoContainer = document.getElementById("selectedPhotosForCreate");
                const maxSize = 8 * 1024 * 1024; // 8MB in bytes

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];

                    // Check if the file size exceeds 8MB
                    if (file.size > maxSize) {
                        $('#crtPstImgSizeError').html('<div class="alert alert-danger text-center" role="alert">Image is too large</div>');
                        console.log("Skipped image (too large):", file.name);

                        setTimeout(() => {
                            $('#crtPstImgSizeError').html('');
                        }, 3000);

                        continue;
                    }

                    selectedFiles.push(file);

                    console.log("Added image:", file.name);

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Create a new container for the image and remove button
                        const photoWrapper = document.createElement("div");
                        photoWrapper.classList.add("col-12", "col-md-4", "position-relative");

                        const imgElement = document.createElement("img");
                        imgElement.src = e.target.result;
                        imgElement.classList.add("img-fluid", "rounded", "shadow-sm");

                        // Create a remove button
                        const removeButton = document.createElement("button");
                        removeButton.classList.add(
                            "btn",
                            "bg-dark-subtle",
                            "position-absolute",
                            "top-0",
                            "end-0",
                            "m-2"
                        );
                        removeButton.innerHTML = '<i class="bi bi-x"></i>';
                        // Append image and button to the wrapper
                        photoWrapper.appendChild(imgElement);
                        photoWrapper.appendChild(removeButton);
                        // Append the wrapper to the container
                        photoContainer.appendChild(photoWrapper);
                        // Add event listener to the remove button
                        removeButton.addEventListener("click", function() {
                            photoContainer.removeChild(photoWrapper);
                            selectedFiles = selectedFiles.filter(f => f !== file);
                            console.log("Removed image:", file.name); // Log when image is removed
                        });
                    };

                    reader.readAsDataURL(file);
                }
            });

            document.getElementById("createPostForm").addEventListener("submit", function(event) {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                document.getElementById("bgAddPhotos").files = dataTransfer.files;

                console.log("Submitting form with images:", selectedFiles.map(f => f.name)); // Log images before submission
            });
        });
    </script>

    <script src="brgyMaterials/script.b.js"></script>
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
    'success_message' => ['type' => 'success', 'title' => 'Success'],
    'post_message' => ['type' => 'success', 'title' => 'Success'],
    'delete_message' => ['type' => 'success', 'title' => 'Success'],
    'addAdmin_error_message' => ['type' => 'error', 'title' => 'Error'],
    'addAdmin_success_message' => ['type' => 'success', 'title' => 'Done'],
];

foreach ($alerts as $sessionKey => $alertConfig) {
    if (isset($_SESSION[$sessionKey])) {
        displayAlert($alertConfig['type'], $_SESSION[$sessionKey], $alertConfig['title']);
        unset($_SESSION[$sessionKey]);
    }
}
?>

</html>