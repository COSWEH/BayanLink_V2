<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body class="bg-dark">
    <div class="container">

        <form action="test.php" method="POST">
            <input type="text" class="form-control" name="pass" required>
            <hr>
            <button class="btn btn-primary" name="btnHash">hash</button>
            <hr>
        </form>


        <h6 class="text-light">
            <?php
            if (isset($_POST['btnHash'])) {
                $pass = $_POST['pass'];

                echo $pass = password_hash($pass, PASSWORD_DEFAULT);
            }

            ?>
        </h6>
    </div>


</html>