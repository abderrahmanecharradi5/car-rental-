<?php
include '../config/config.php';       // Doit être tout en haut pour charger la connexion MySQL
include '../includes/header.php';     // Ensuite le header commun

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit();
}

$car_id = $_GET['id'];

if (isset($_POST['book'])) {
    $start = $_POST['start'];
    $end = $_POST['end'];
    $car = mysqli_fetch_assoc(mysqli_query($conn, "SELECT price_per_day FROM cars WHERE id=$car_id"));
    $days = (strtotime($end) - strtotime($start)) / (60 * 60 * 24);
    $price = $car['price_per_day'] * $days;

    mysqli_query($conn, "INSERT INTO bookings (user_id, car_id, start_date, end_date, total_price)
        VALUES ({$_SESSION['user_id']}, $car_id, '$start', '$end', $price)");

    mysqli_query($conn, "UPDATE cars SET status='rented' WHERE id=$car_id");

    $success = "Réservation confirmée pour $days jours.";
}
?>

<h2>Réserver</h2>
<?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
<form method="POST">
  <div class="mb-3">
    <label class="form-label">Date de début</label>
    <input type="date" name="start" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Date de fin</label>
    <input type="date" name="end" class="form-control" required>
  </div>
  <button type="submit" name="book" class="btn btn-success">Confirmer</button>
  <a href="cars.php" class="btn btn-secondary">Annuler</a>
</form>

<?php include '../includes/footer.php'; ?>
