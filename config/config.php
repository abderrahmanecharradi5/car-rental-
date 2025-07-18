<?php
$host = "localhost";
$user = "root";
$password = ""; // set your DB password
$dbname = "car_rental";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
