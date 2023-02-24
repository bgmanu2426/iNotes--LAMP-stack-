<?php
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Connecting to the databse
  require 'partials/_dbconnect.php';

  //Variables to store and match the details from login form
  $email = $_POST["input_email"];
  $password = $_POST["input_password"];

  //Check the email and password entered by user is correct or not
  $sql = "SELECT * FROM `users` WHERE email='$email'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);
  $fetch = mysqli_fetch_assoc($result);
  if (($num == 1) && password_verify($password, $fetch['password'])) {
    $login = true;
    //Start the session
    session_start();
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $fetch['name'];
    header("location: index.php");
  } else {
    $showError = true;
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
if ($login) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Welcome!</strong> ' . $fetch['name'] . ' you have been successfully logged in to iSecure 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
} elseif ($showError) {
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Invalid Credentials
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>

<!-- Login form -->
<div class="container col-md-6 my-5">
  <h3 class="text-center m-4">Login up to iNotes</h3>
  <form action="login.php" method="post">
    <div class="form-floating mb-3">
      <input type="email" class="form-control my-4" id="floatingInput" name="input_email" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control my-4" id="floatingPassword" name="input_password" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <button type="submit" id='sub' class="btn btn-primary bg-gradient my-3">Login</button>
  </form>
  <p> <br><em><strong>Don't have an accout? <a href="signup.php">Click here to Signup --></a></strong></em></p>
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
    // const addClassActive = document.getElementsByTagName('a')[3];
    // addClassActive.classList.add('active');

    // To fix the re-submission error on reloading the webpage
    if (window.history.replaceState) {
      window.history.replaceState(null, null, window.location.href);
    }

    document.getElementById('sub').onclick = function() {
      window.location = `/login.php`;
    }
  </script>
</body>

</html>