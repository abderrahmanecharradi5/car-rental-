<?php
include '../config/config.php'; // Include database connection
include '../includes/admin_header.php'; // Admin header and session check

// Get total number of cars
$total_cars = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars"))['total'];

// Get count of available and rented cars
$available_cars = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars WHERE status = 'available'"))['total'];
$rented_cars = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM cars WHERE status = 'rented'"))['total'];

// Get total revenue (assuming you have a bookings table and price per day for cars)
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_price) AS total FROM bookings"))['total'];

// Get revenue by month for the chart
$monthly_revenue = mysqli_query($conn, "SELECT MONTH(start_date) AS month, SUM(total_price) AS revenue FROM bookings GROUP BY MONTH(start_date) ORDER BY MONTH(start_date)");

$months = [];
$revenues = [];
while ($row = mysqli_fetch_assoc($monthly_revenue)) {
    $months[] = date('F', mktime(0, 0, 0, $row['month'], 10)); // Convert month number to month name
    $revenues[] = $row['revenue'];
}

// Fetch recent bookings (last 5 bookings)
$recent_bookings = mysqli_query($conn, "SELECT b.*, c.name AS car_name FROM bookings b JOIN cars c ON b.car_id = c.id ORDER BY b.start_date DESC LIMIT 5");
?>


  <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Rental - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Custom Styles */
    :root {
      --primary: #1e40af;
      --secondary: #3b82f6;
      --accent: #10b981;
      --text: #1f2937;
      --bg-light: #f9fafb;
      --card-bg: #ffffff;
    }

    body {
      background-color: var(--bg-light);
      color: var(--text);
      font-family: 'Inter', sans-serif;
    }

    .container {
      max-width: 1200px;
    }

    h2, h3 {
      font-weight: 700;
      color: var(--primary);
    }

    /* Card Styling */
    .card {
      border: none;
      border-radius: 12px;
      background-color: var(--card-bg);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text);
      margin-bottom: 1rem;
    }

    .card-body {
      padding: 1.5rem;
    }

    .display-4 {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--secondary);
    }

    /* Card Icons */
    .card-icon {
      font-size: 2rem;
      margin-bottom: 0.5rem;
      color: var(--accent);
    }

    /* Table Styling */
    .table {
      background-color: var(--card-bg);
      border-radius: 8px;
      overflow: hidden;
    }

    .table-dark {
      background-color: var(--primary);
      --bs-table-bg: var(--primary);
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
      --bs-table-accent-bg: rgba(0, 0, 0, 0.03);
    }

    /* Chart Container */
    .chart-container {
      background-color: var(--card-bg);
      padding: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .display-4 {
        font-size: 2rem;
      }

      .card-body {
        padding: 1rem;
      }
    }
  </style>
</head>

<div class="container py-4">
  <h2>Admin Dashboard</h2>

  <!-- Stats Cards -->
  <div class="row mt-4">
    <!-- Total Cars -->
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Total Cars</h5>
          <p class="display-4"><?= $total_cars ?></p>
        </div>
      </div>
    </div>
    
    <!-- Available Cars -->
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Available Cars</h5>
          <p class="display-4"><?= $available_cars ?></p>
        </div>
      </div>
    </div>

    <!-- Rented Cars -->
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Rented Cars</h5>
          <p class="display-4"><?= $rented_cars ?></p>
        </div>
      </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body text-center">
          <h5 class="card-title">Total Revenue</h5>
          <p class="display-4"><?= number_format($total_revenue, 2) ?> €</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Monthly Revenue Chart -->
  <h3 class="mt-5">Monthly Revenue</h3>
  <canvas id="monthlyRevenueChart" width="400" height="200"></canvas>
  
  <script>
    const ctx = document.getElementById('monthlyRevenueChart').getContext('2d');
    const monthlyRevenueChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode($months) ?>, // Months as labels
        datasets: [{
          label: 'Revenue (€)',
          data: <?= json_encode($revenues) ?>, // Revenue data
          borderColor: 'rgba(75, 192, 192, 1)',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

  <!-- Recent Bookings -->
  <h3 class="mt-5">Recent Bookings</h3>
  <table class="table table-striped mt-3">
    <thead class="table-dark">
      <tr>
        <th>Car</th>
        <th>User</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Total Price</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($booking = mysqli_fetch_assoc($recent_bookings)) { ?>
        <tr>
          <td><?= $booking['car_name'] ?></td>
          <td><?= $booking['user_id'] ?></td>
          <td><?= $booking['start_date'] ?></td>
          <td><?= $booking['end_date'] ?></td>
          <td><?= $booking['total_price'] ?> €</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
