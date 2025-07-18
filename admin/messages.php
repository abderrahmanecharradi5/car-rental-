<?php
include '../includes/admin_header.php';
include '../config/config.php';

// Fetch messages
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
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


<div class="container mt-5">
    <h2 class="mb-4">Contact Messages</h2>

    <table class="table table-bordered table-striped">
<thead class="table-dark">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Sent At</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
<?php
if (mysqli_num_rows($result) > 0):
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)):
?>
<tr>
    <td><?= $count++ ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['subject']) ?></td>
    <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
    <td><?= $row['created_at'] ?></td>
    <td>
        <a href="delete_message.php?id=<?= $row['id'] ?>" 
           onclick="return confirm('Are you sure you want to delete this message?')" 
           class="btn btn-sm btn-danger">
           Delete
        </a>
        <a href="reply_message.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Reply</a>
    </td>
</tr>
<?php endwhile; else: ?>
<tr><td colspan="7" class="text-center">No messages found</td></tr>
<?php endif; ?>
</tbody>


    </table>
</div>

<?php include '../includes/admin_footer.php'; ?>
