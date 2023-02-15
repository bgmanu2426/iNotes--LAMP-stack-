<?php
include '_dbconnect.php';

session_start();
$email = $_SESSION['email'];
$sql1 = "DROP TABLE `inotes`.`$email`";
$result1 = mysqli_query($connection, $sql1);

$sql2 = "DELETE FROM users WHERE `users`.`email` = '$email'";
$result2 = mysqli_query($connection, $sql2);

session_unset();
session_destroy();
header("location: ../signup.php");
?>