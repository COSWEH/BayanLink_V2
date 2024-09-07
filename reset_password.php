<?php
include('includes/conn.inc.php');
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $token_hash = hash("sha256", $token);

    $_SESSION['getHashedToken'] = $token;

    $checkToken = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `reset_token_hash` = '$token_hash'");
    $countToken = mysqli_num_rows($checkToken);

    // If user does not exist, sign out
    if ($countToken < 1) {
        header('Location: signout.php');
        exit;
    }

    while ($row = mysqli_fetch_assoc($checkToken)) {
        $userid = $row['user_id'];
        $expiration = strtotime($row['reset_token_expires_at']);
    }

    if ($expiration <= time()) {
        die('Token has expired');
    }
} else {
    header('Location: signout.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    <div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-10 col-lg-8">
                <div class="card p-0 shadow">
                    <div class="row no-gutters">
                        <!-- Left side: Shield icon and text -->
                        <div class="col d-none d-md-flex flex-column align-items-center justify-content-center text-center left-side bg-info p-5">
                            <i class="bi bi-shield-lock-fill text-light" style="font-size: 8rem;"></i>
                            <p class="text-light mt-3">Create a new password to secure your account. Make sure it's strong and unique for better protection.</p>
                        </div>
                        <!-- Right side: Form -->
                        <div class="col p-5">
                            <form action="includes/process-password-reset.php" method="POST">
                                <h4 class="mb-3 fw-bold">Enter New Password</h4>
                                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required pattern=".{8,}">
                                    <label for="new_password" class="form-label">New Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required pattern=".{8,}">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col mb-2">
                                        <button type="submit" name="btnResetPassword" class="btn btn-info text-light w-100 fw-bold mb-2">Reset Password</button>
                                        <a href="index.php" class="btn btn-secondary w-100 fw-bold">Back to Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<?php
if (isset($_SESSION['reset_pass_message'])) {
?>
    <script>
        Swal.fire({
            title: "Error",
            text: "<?php echo $_SESSION['reset_pass_message']; ?>",
            icon: "error",
        });
    </script>
<?php
    unset($_SESSION['reset_pass_message']);
}
?>

</html>