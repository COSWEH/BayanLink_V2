
 <?php
    include('conn.inc.php');
    session_start();

    if (isset($_POST['btnResetPassword']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $token = $_POST['token'];
        $token_hash = hash("sha256", $token);

        $password = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if (strlen($password) < 8) {
            $_SESSION['reset_pass_message'] = "Password must be at least 8 characters";
            $redirect_url = '../reset_password.php?token=' . urlencode($token);
            header('Location: ' . $redirect_url);
            exit;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['reset_pass_message'] = "Passwords must match";
            $redirect_url = '../reset_password.php?token=' . urlencode($token);
            header('Location: ' . $redirect_url);
            exit;
        }

        $checkToken = mysqli_query($con, "SELECT * FROM `tbl_useracc` WHERE `reset_token_hash` = '$token_hash'");
        $countToken = mysqli_num_rows($checkToken);

        //If token does not exist, sign out
        if ($countToken < 1) {
            header('Location: ../signout.php');
            exit;
        }

        while ($row = mysqli_fetch_assoc($checkToken)) {
            $userid = $row['user_id'];
            $expiration = strtotime($row['reset_token_expires_at']);
        }

        if ($expiration <= time()) {
            $_SESSION['reset_pass_message'] = "Token is expired";
            $redirect_url = '../reset_password.php?token=' . urlencode($token);
            header('Location: ' . $redirect_url);
            exit;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = mysqli_query($con, "UPDATE `tbl_useracc` SET `password` = '$password_hash',
            `reset_token_hash` = NULL,
            `reset_token_expires_at` = NULL
             WHERE `user_id` = '$userid'");

        if ($query) {
            $_SESSION['passUpdatedMessage'] = "Password updated. You can now login.";
            header('Location: ../index.php');
            exit;
        }
    }
