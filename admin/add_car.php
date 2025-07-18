<?php
include '../config/config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Form submission logic
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $brand = mysqli_real_escape_string($conn, $_POST['brand']);
  $model = mysqli_real_escape_string($conn, $_POST['model']);
  $price = mysqli_real_escape_string($conn, $_POST['price']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $features = mysqli_real_escape_string($conn, implode(',', $_POST['features'])); // Store features as a comma-separated list

  // Handle image uploads (multiple images)
  $images = [];
  foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
    $image_name = $_FILES['images']['name'][$key];
    $tmp = $_FILES['images']['tmp_name'][$key];
    move_uploaded_file($tmp, "../uploads/$image_name");
    $images[] = $image_name; // Add image name to the array
  }

  // Store multiple images as a comma-separated list
  $images = implode(',', $images);

  // Insert the car into the database
  $query = "INSERT INTO cars (name, brand, model, price_per_day, status, description, features, images)
            VALUES ('$name', '$brand', '$model', '$price', '$status', '$description', '$features', '$images')";
  
  if (mysqli_query($conn, $query)) {
    $_SESSION['msg'] = "Car added successfully!";
    header("Location: manage_cars.php"); // Redirect to the manage cars page
    exit;
  } else {
    $_SESSION['msg'] = "Error adding car.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental - Add New Car</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
  <h2>Add New Car</h2>

  <!-- Success or Error Message -->
  <?php if (isset($_SESSION['msg'])): ?>
    <div class="alert alert-info"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="name" class="form-label">Car Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="brand" class="form-label">Brand</label>
      <input type="text" name="brand" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="model" class="form-label">Model</label>
      <input type="text" name="model" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Price per Day (€)</label>
      <input type="number" name="price" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="status" class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="available">Available</option>
        <option value="rented">Rented</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Car Description</label>
      <textarea name="description" class="form-control" rows="5" required></textarea>
    </div>

    <div class="mb-3">
      <label for="features" class="form-label">Car Features</label>
      <input type="text" name="features[]" class="form-control" placeholder="Feature 1, Feature 2" required>
    </div>

    <div class="mb-3">
      <label for="images" class="form-label">Car Images</label>
      <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
    </div>

    <button type="submit" class="btn btn-success">Add Car</button>
    <a href="manage_cars.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

<!-- Preview uploaded images -->
<script>
  const imageInput = document.querySelector('input[name="images[]"]');
  const imagePreview = document.createElement('div');

  imageInput.addEventListener('change', function(e) {
    imagePreview.innerHTML = ''; // Clear previous previews
    const files = e.target.files;
    Array.from(files).forEach(file => {
      const reader = new FileReader();
      reader.onload = function(event) {
        const img = document.createElement('img');
        img.src = event.target.result;
        img.style.width = '100px';
        img.style.margin = '5px';
        imagePreview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  });

  document.querySelector('form').appendChild(imagePreview); // Attach preview div to form
</script>

</body>
</html>
