<?php
include '../config/config.php';
include '../includes/user_header.php'; // User header and session check

// Handle filters
$brand = $_GET['brand'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$sql = "SELECT * FROM cars WHERE status = 'available'";

if (!empty($brand)) {
    $brandEscaped = mysqli_real_escape_string($conn, $brand);
    $sql .= " AND brand LIKE '%$brandEscaped%'";
}
if (!empty($min_price)) {
    $sql .= " AND price_per_day >= " . (int)$min_price;
}
if (!empty($max_price)) {
    $sql .= " AND price_per_day <= " . (int)$max_price;
}

$cars = mysqli_query($conn, $sql);
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
  <h2>Browse Available Cars</h2>

  <!-- Search Filters -->
  <form method="GET" class="row g-3 mb-5">
    <div class="col-md-3">
      <input type="text" name="brand" class="form-control" placeholder="Search by brand" value="<?= htmlspecialchars($brand) ?>">
    </div>
    <div class="col-md-3">
      <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="<?= htmlspecialchars($min_price) ?>">
    </div>
    <div class="col-md-3">
      <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?= htmlspecialchars($max_price) ?>">
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <!-- Car Grid -->
  <div class="row">
    <?php while ($car = mysqli_fetch_assoc($cars)) { ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="../uploads/<?= $car['image'] ?>" class="card-img-top" alt="<?= $car['name'] ?>" style="height: 200px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title"><?= $car['name'] ?></h5>
            <p><strong>Brand:</strong> <?= $car['brand'] ?></p>
            <p><strong>Model:</strong> <?= $car['model'] ?></p>
            <p><strong>Price per Day:</strong> <?= $car['price_per_day'] ?> €</p>
            <a href="car_details.php?id=<?= $car['id'] ?>" class="btn btn-primary">View Details</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php include '../includes/user_footer.php'; ?>
