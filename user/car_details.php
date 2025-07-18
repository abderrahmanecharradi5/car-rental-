<?php
include '../includes/user_header.php'; // Includes the header and session check
include '../config/config.php'; // Database connection

// Check if car ID is passed
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

// Decode the images and features
$images = explode(',', $car['images']);  // Assuming images are stored as comma-separated values
$features = explode(',', $car['features']);  // Assuming features are stored as comma-separated values
?>

<div class="container py-4">
  <h2>Details for <?= htmlspecialchars($car['name']) ?></h2>

  <!-- Car Image Gallery -->
  <div class="row">
    <div class="col-md-6">
      <div id="carCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <?php foreach ($images as $index => $image): ?>
            <div class="carousel-item <?= ($index == 0) ? 'active' : ''; ?>">
              <img src="../uploads/<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="<?= htmlspecialchars($car['name']) ?>">
            </div>
          <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
      </div>
    </div>

    <!-- Car Details -->
    <div class="col-md-6">
      <h4>About the Car</h4>
      <p><?= nl2br(htmlspecialchars($car['description'])) ?></p>
      <hr>

      <h5>Features</h5>
      <ul>
        <?php foreach ($features as $feature): ?>
          <li><?= htmlspecialchars($feature) ?></li>
        <?php endforeach; ?>
      </ul>

      <hr>

      <h5>Price per Day</h5>
      <p><?= htmlspecialchars($car['price_per_day']) ?> €</p>

      <hr>

      <!-- Booking Button (if available) -->
      <a href="book_car.php?id=<?= $car['id'] ?>" class="btn btn-primary">Book Now</a>
    </div>
  </div>
</div>

<?php include '../includes/user_footer.php'; ?>
