<?php
include '../config/config.php';
include '../includes/admin_header.php'; // Make sure it includes session protection and Bootstrap

$search = $_GET['search'] ?? '';

// Handle delete
if (isset($_GET['delete'])) {
  $delete_id = intval($_GET['delete']);
  mysqli_query($conn, "DELETE FROM users WHERE id = $delete_id AND role = 'user'");
  header("Location: manage_users.php");
  exit;
}

// Search logic
$search_query = "WHERE role = 'user'";
if (!empty($search)) {
  $search = mysqli_real_escape_string($conn, $search);
  $search_query .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

// Join with bookings to count
$query = "
  SELECT users.*, COUNT(bookings.id) AS booking_count
  FROM users
  LEFT JOIN bookings ON users.id = bookings.user_id
  $search_query
  GROUP BY users.id
";
$users = mysqli_query($conn, $query);
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
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Users</h2>
    <form method="GET" class="d-flex">
      <input type="text" name="search" class="form-control me-2" placeholder="Search name or email" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
      <button type="submit" class="btn btn-outline-primary">Search</button>
    </form>
  </div>

  <table class="table table-bordered table-hover">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Registered</th>
      <th>Bookings</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($user = mysqli_fetch_assoc($users)) { ?>
      <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['created_at'] ?></td>
        <td><span class="badge bg-info"><?= $user['booking_count'] ?></span></td>
        <td>
          <a href="?delete=<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </tbody>
</table>


<?php include '../includes/admin_footer.php'; ?>
