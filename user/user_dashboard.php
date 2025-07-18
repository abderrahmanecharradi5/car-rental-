<?php
include '../config/config.php';
include '../includes/user_header.php';



if (!isset($_SESSION['user_id'])) {
  header("Location: login.php"); // Redirect to login page if not logged in
  exit();
}


// Fetch user information
$user_id = $_SESSION['user_id'];
$user_info = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'"));

// Fetch recent bookings
$recent_bookings = mysqli_query($conn, "SELECT b.*, c.name AS car_name FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = '$user_id' ORDER BY b.start_date DESC LIMIT 5");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<div class="container py-4">
  <h2>Welcome, <?= $user_info['name'] ?></h2>

  <!-- User Profile -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title">Profile</h5>
      <p><strong>Email:</strong> <?= $user_info['email'] ?></p>

    </div>
  </div>

  <!-- Recent Bookings -->
  <h3 class="mb-3">Recent Bookings</h3>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr>
        <th>Car</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($booking = mysqli_fetch_assoc($recent_bookings)) { ?>
        <tr>
          <td><?= $booking['car_name'] ?></td>
          <td><?= $booking['start_date'] ?></td>
          <td><?= $booking['end_date'] ?></td>
          <td>
            <span class="badge <?= $booking['status'] == 'confirmed' ? 'bg-success' : 'bg-warning' ?>">
              <?= ucfirst($booking['status']) ?>
            </span>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include '../includes/user_footer.php'; ?>
