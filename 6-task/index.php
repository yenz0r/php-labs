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

    <?php 
        require('connect_db.php');

        if (isset($_POST['user_name'], $_POST['user_pass'])) {
            $userName = $_POST['user_name'];
            $userPass = $_POST['user_pass'];

            $query = "insert into users_info (login, pass, active) values ('$userName', '$userPass', 0);";
            $result = mysqli_query($connection, $query);
            
            if ($result) {
                $successMessage = "Регистрация прошла успешно";
            } else {
                $errorMessage = "Повторите попытку";
            }
        }
    ?>

    <div class="container">
        <form class="form-signin" method="post">
            <h2>Registration</h2>
    <?php if (isset($successMessage)) {?><div class="alert alert-success" role="alert"> <?php echo $successMessage; ?> </div> <?php } ?>
    <?php if (isset($errorMessage)) {?><div class="alert alert-danger" role="alert"> <?php echo $errorMessage; ?> </div> <?php } ?>
            <input type="text" name="user_name" class="form-control" placeholder="Username" required>
            <input type="password" name="user_pass" class="form-control" placeholder="Password" required><br/>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
            <a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
        </form>
    </div>
</body>
</html>
