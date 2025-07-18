<?php
include '../config/config.php'; // Database connection

if (!isset($_GET['id'])) {
  echo "No car selected.";
  exit;
}

$car_id = intval($_GET['id']);

// Fetch car details from the database
$query = "SELECT * FROM cars WHERE id = $car_id AND status = 'available'";
$result = mysqli_query($conn, $query);
$car = mysqli_fetch_assoc($result);

if (!$car) {
  echo "Car not found or unavailable.";
  exit;
}

// Handle form submission to update car details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $brand = mysqli_real_escape_string($conn, $_POST['brand']);
  $model = mysqli_real_escape_string($conn, $_POST['model']);
  $price_per_day = mysqli_real_escape_string($conn, $_POST['price_per_day']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $features = mysqli_real_escape_string($conn, implode(',', $_POST['features']));  // Serialize features
  $images = mysqli_real_escape_string($conn, implode(',', $_FILES['images']['name']));  // Handle multiple image uploads

  // Move images to the upload folder
  $image_paths = [];
  foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $image_name = $_FILES['images']['name'][$key];
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image_name);
    if (move_uploaded_file($tmp_name, $target_file)) {
      $image_paths[] = $image_name;
    }
  }

  $update_query = "UPDATE cars SET name='$name', brand='$brand', model='$model', price_per_day='$price_per_day', description='$description', features='$features', images='" . implode(',', $image_paths) . "' WHERE id = $car_id";
  
  if (mysqli_query($conn, $update_query)) {
    $_SESSION['msg'] = "Car details updated successfully!";
    header("Location: cars.php"); // Redirect to car listing page
    exit();
  } else {
    $_SESSION['msg'] = "Error updating car details.";
  }
}
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
  <h2>Edit Car Details</h2>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="name" class="form-label">Car Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($car['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="brand" class="form-label">Brand</label>
      <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($car['brand']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="model" class="form-label">Model</label>
      <input type="text" name="model" class="form-control" value="<?= htmlspecialchars($car['model']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="price_per_day" class="form-label">Price per Day (€)</label>
      <input type="number" name="price_per_day" class="form-control" value="<?= htmlspecialchars($car['price_per_day']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Car Description</label>
      <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($car['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label for="features" class="form-label">Car Features</label>
      <input type="text" name="features[]" class="form-control" value="<?= htmlspecialchars($car['features']) ?>" placeholder="Feature 1, Feature 2" required>
    </div>
    <div class="mb-3">
      <label for="images" class="form-label">Car Images</label>
      <input type="file" name="images[]" class="form-control" multiple>
    </div>
    <button type="submit" class="btn btn-success">Update Car</button>
    <a href="cars.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>


