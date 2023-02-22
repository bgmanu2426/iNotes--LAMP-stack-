<?php
$server = "localhost";
$username = "root";
$password = "Manu@7795";
$database = "inotes";

$connection = mysqli_connect($server,$username,$password,$database);
if (!$connection) {
    die("Error" . mysqli_connect_error());
}
?>