<?php
$showAlertSuccess = false;
$showError = false;
$exists = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Connect to the databse
    require 'partials/_dbconnect.php';

    //Variables to store the input details from signup form
    $email = $_POST["input_email"];
    $name = $_POST["input_name"];
    $number = $_POST["input_number"];
    $password = $_POST["input_password"];
    $c_password = $_POST["input_cpassword"];

    //Store the new users data to users table in th databse
    $existsSql = "SELECT * FROM `users` WHERE email = '$email'";
    $existsResult = mysqli_query($connection, $existsSql);
    $numExistRow = mysqli_num_rows($existsResult);
    if ($numExistRow > 0) {
        $exists = true;
    } else {
        if (($password == $c_password)) {
            //Creating table to store the data of users with table name as their emailid
            $tb_name = $email;
            $createSql = "CREATE TABLE `$tb_name` (`slno` INT(12) NOT NULL AUTO_INCREMENT , `title` VARCHAR(50) NOT NULL , `description` TEXT NOT NULL , `timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`slno`)) ENGINE = InnoDB";
            $result = mysqli_query($connection, $createSql);
            //Creating to store users login data in users table
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users`(`email`, `name`, `mo_number`, `password`, `dt`) VALUES ('$email','$name','$number','$hash',current_timestamp())";
            $result = mysqli_query($connection, $sql);
            if ($result) {
                $showAlertSuccess = true;
            }
        } else {
            $showError = true;
        }
    }
}
?>

<!-- HTML -->
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iNotes</title>
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<!-- Navbar included -->
<?php include 'partials/_navbar.php'; ?>

<!-- Alerts -->
<?php
if ($showAlertSuccess) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> Your account is created, you can now login using your credentials
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
} elseif ($showError) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Your passwords didn\'t match
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
} elseif ($exists) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> E-mail already exists login or try with diffrent e-mail
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<!-- Signup form -->
<div class="container col-md-6">
    <h3 class="text-center m-4">Sign up to iNotes</h3>
    <form action="signup.php" method="post">
        <div class="form-text"><em>All the below fields marked with <em style="color: red;">*</em> are mandotry to
                fill</em></div>
        <div class="mb-3 my-3">
            <label for="input_email" class="form-label">E-mail <strong style="color: red;">*</strong></label>
            <input type="email" class="form-control" id="input_email" name="input_email" required placeholder="Enter your e-mail id">
        </div>
        <div class="mb-3 my-3">
            <label for="input_name" class="form-label">Name <strong style="color: red;">*</strong></label>
            <input type="text" class="form-control" id="input_name" name="input_name" placeholder="Enter your full name" required>
        </div>
        <div class="mb-3 my-3">
            <label for="input_number" class="form-label">Mobile Number</label>
            <input type="number" maxlength="10" class="form-control" id="input_number" name="input_number" placeholder="Enter your mobile number">
        </div>
        <div class="mb-3">
            <label for="input_password" class="form-label">Password <strong style="color: red;">*</strong></label>
            <input type="password" class="form-control" id="input_password" name="input_password" placeholder="Enter your password" required>
        </div>
        <div class="mb-3">
            <label for="input_cpassword" class="form-label">Confirm Password <strong style="color: red;">*</strong></label>
            <input type="text" class="form-control" id="input_cpassword" name="input_cpassword" placeholder="Confirm your your password" required>
        </div>
        <button type="reset" class="btn btn-danger">&nbspReset&nbsp</button>
        <button type="submit" class="btn btn-success mx-4">Signup</button>
    </form>
    <hr>
</div>

<body>
    <?php
    include 'partials/_footer.php';
    ?>
    <!-- Javascript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>
        // // To add active class to the navbar
        // const addClassActive = document.getElementsByTagName('a')[2];
        // addClassActive.classList.add('active');

        // To fix the re-submission error on reloading the webpage
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>