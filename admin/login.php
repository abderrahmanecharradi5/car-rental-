<?php
session_start();
include '../config/config.php'; // Include the database connection

if (isset($_SESSION['admin_id'])) {
  header("Location: manage_cars.php");
  exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Fetch admin data from database
  $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND role = 'admin'");
  $admin = mysqli_fetch_assoc($query);

  // Check if the admin exists and if the password is correct
  if ($admin && password_verify($password, $admin['password'])) {
    $_SESSION['admin_id'] = $admin['id']; // Store the admin session
    header("Location: manage_cars.php"); // Redirect to the admin dashboard
    exit();
  } else {
    $error = "Invalid email or password!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Admin Login</h4>
          </div>
          <div class="card-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
