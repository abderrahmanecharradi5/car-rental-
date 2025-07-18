<?php
include '../config/config.php';

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  mysqli_query($conn, "DELETE FROM cars WHERE id = $id");
}

header("Location: manage_cars.php");
exit;
