<?php
include '_dbconnect.php';

session_start();
$email = $_SESSION['email'];
$sql = "TRUNCATE TABLE `inotes`.`$email`";
$result = mysqli_query($connection,$sql);
header("location: ../home.php");
?>