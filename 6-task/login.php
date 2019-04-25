<?php 
        session_start();
        require('connect_db.php');

        if (isset($_POST['user_name'], $_POST['user_pass'])) {
            $userName = $_POST['user_name'];
            $userPass = $_POST['user_pass'];

            $query = "select * from users_info where login='$userName' and pass='$userPass';";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            $count = mysqli_num_rows($result);

            if ($count == 1) {
                $_SESSION['login'] = $userName; 
            } else {
                $errorMessage = "Error";
            }
        }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <form class="form-signin" method="post">
            <h2>Login</h2>
    <?php if (isset($successMessage)) {?><div class="alert alert-success" role="alert"> <?php echo $successMessage; ?> </div> <?php } ?>
    <?php if (isset($errorMessage)) {?><div class="alert alert-danger" role="alert"> <?php echo $errorMessage; ?> </div> <?php } ?>
            <input type="text" name="user_name" class="form-control" placeholder="Username" required>
            <input type="password" name="user_pass" class="form-control" placeholder="Password" required><br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <a class="btn btn-lg btn-primary btn-block" href="index.php">registration</a>
        </form>
    <?php
        if (isset($_SESSION['login'])) {
            $userName = $_SESSION['login'];
            echo "<hr/><div class='form-signin'><h2>Hello, " . $userName . "!</h2>";
            echo "<a href='logout.php' class='btn btn-lg btn-primary btn-block'>Logout</a></div>";
        }
    ?>
    </div>
</body>
</html>
