<?php
include '../config/config.php';       // 🔁 Inclure la connexion MySQL
include '../includes/user_header.php';     // Ensuite inclure le header



$uid = $_SESSION['user_id'];
$reservations = mysqli_query($conn,
  "SELECT b.*, c.name as car_name FROM bookings b JOIN cars c ON b.car_id = c.id WHERE b.user_id = $uid"
);
?>

<h2>Mes réservations</h2>
<table class="table table-striped mt-4">
  <thead class="table-dark">
    <tr>
      <th>Voiture</th><th>Du</th><th>Au</th><th>Total</th><th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($reservations)) { ?>
      <tr>
        <td><?= $row['car_name'] ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['end_date'] ?></td>
        <td><?= $row['total_price'] ?> €</td>
        <td><?= ucfirst($row['status']) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>

<?php include '../includes/user_footer.php'; ?>
