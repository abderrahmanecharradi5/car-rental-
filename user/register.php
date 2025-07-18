<?php
session_start();
include '../config/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password

  // Check if the email is already registered
  $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
  if (mysqli_num_rows($check_email) > 0) {
    $error = "Email is already taken!";
  } else {
    // Insert the new user into the database
    mysqli_query($conn, "INSERT INTO users (name, email, password, role) 
                         VALUES ('$name', '$email', '$password_hash', 'user')");
    $success = "Registration successful! You can now log in.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>User Registration</h4>
          </div>
          <div class="card-body">
            <?php if ($error): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php elseif ($success): ?>
              <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <form method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="mt-3 text-center">
              <a href="login.php">Already have an account? Log in</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
