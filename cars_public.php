<?php
include 'config/config.php';


// Initialize filter conditions
$brand = $_GET['brand'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';

$sql = "SELECT * FROM cars WHERE status = 'available'";

// Add filters
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


<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
      .footer {
      background-color: #343a40;
      color: #fff;
      padding: 40px 0;
    }
    .footer a {
      color: #ccc;
      text-decoration: none;
    }
    .footer a:hover {
      color: #fff;
    }
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease-in-out;
    }
    .fade-in.show {
      opacity: 1;
      transform: none;
    }
  </style>
  
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">CarRental</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link " href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-linkactive" href="cars_public.php">Browse Cars</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
        <li class="nav-item"><a class="nav-link" href="user/login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link" href="user/register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h2 class="text-center mb-4">Browse Our Cars</h2>

  <!-- Filters -->
  <form method="GET" class="row g-3 mb-5">
    <div class="col-md-4">
      <input type="text" name="brand" class="form-control" placeholder="Search by brand (e.g. Toyota)" value="<?= htmlspecialchars($brand) ?>">
    </div>
    <div class="col-md-3">
      <input type="number" name="min_price" class="form-control" placeholder="Min Price (€)" value="<?= htmlspecialchars($min_price) ?>">
    </div>
    <div class="col-md-3">
      <input type="number" name="max_price" class="form-control" placeholder="Max Price (€)" value="<?= htmlspecialchars($max_price) ?>">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </form>

  <!-- Car Grid -->
  <div class="row">
    <?php if (mysqli_num_rows($cars) > 0): ?>
      <?php while ($car = mysqli_fetch_assoc($cars)) { ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="uploads/<?= $car['image'] ?>" class="card-img-top" alt="<?= $car['name'] ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($car['name']) ?></h5>
              <p class="card-text">
                <strong>Brand:</strong> <?= htmlspecialchars($car['brand']) ?><br>
                <strong>Model:</strong> <?= htmlspecialchars($car['model']) ?><br>
                <strong>Price:</strong> <?= $car['price_per_day'] ?>€/day
              </p>
              <a href="user/login.php" class="btn btn-outline-primary mt-auto">Login to Book</a>
            </div>
          </div>
        </div>
      <?php } ?>
    <?php else: ?>
      <p class="text-center text-muted">No cars found matching your criteria.</p>
    <?php endif; ?>
  </div>
</div>

<footer class="footer">
  <div class="container text-center">
    <p>&copy; 2025 CarRental. All rights reserved.</p>
    <div class="mt-3">
      <a href="#" class="me-3"><i class="bi bi-facebook"></i></a>
      <a href="#" class="me-3"><i class="bi bi-twitter"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
    </div>
  </div>
</footer>
