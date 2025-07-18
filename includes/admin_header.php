<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("Location: login.php");
  exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="manage_cars.php">Manage Cars</a></li>
      <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
      <a class="nav-link" href="messages.php"><i class="bi bi-envelope"></i> Messages</a>
      <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
