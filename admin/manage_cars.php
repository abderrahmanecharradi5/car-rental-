<?php
include '../config/config.php'; // Include database connection
include '../includes/admin_header.php'; // Admin navbar and session check

// Fetch all cars from the database
$cars = mysqli_query($conn, "SELECT * FROM cars");

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
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manage Cars</h2>
    <a href="add_car.php" class="btn btn-success">+ Add New Car</a>
  </div>

  <!-- Car Table -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Brand</th>
        <th>Model</th>
        <th>Price</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($car = mysqli_fetch_assoc($cars)) { ?>
        <tr>
          <td><img src="../uploads/<?= $car['image'] ?>" width="80" height="50" style="object-fit: cover;"></td>
          <td><?= $car['name'] ?></td>
          <td><?= $car['brand'] ?></td>
          <td><?= $car['model'] ?></td>
          <td><?= $car['price_per_day'] ?> €</td>
          <td>
            <span class="badge <?= $car['status'] == 'available' ? 'bg-success' : 'bg-secondary' ?>">
              <?= ucfirst($car['status']) ?>
            </span>
          </td>
          <td>
            <a href="edit_car.php?id=<?= $car['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="delete_car.php?id=<?= $car['id'] ?>" onclick="return confirm('Are you sure you want to delete this car?')" class="btn btn-sm btn-danger">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
