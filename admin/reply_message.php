<?php
include '../includes/admin_header.php';
include '../config/config.php';

// Get message ID from URL
if (!isset($_GET['id'])) {
  echo "No message selected.";
  exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM contact_messages WHERE id = $id";
$result = mysqli_query($conn, $query);
$message = mysqli_fetch_assoc($result);

if (!$message) {
  echo "Message not found.";
  exit;
}

// Handle the reply form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $reply_subject = mysqli_real_escape_string($conn, $_POST['subject']);
  $reply_message = mysqli_real_escape_string($conn, $_POST['message']);
  $user_email = $message['email']; // Get user email from the original message

  // Send the email reply
  $to = $user_email;
  $subject = "Re: " . $message['subject'] . " - Admin Reply";
  $body = "Dear " . $message['name'] . ",\n\n" . $reply_message;
  $headers = "From: admin@yourdomain.com";

  if (mail($to, $subject, $body, $headers)) {
    // After sending the email, update the admin message status
    mysqli_query($conn, "UPDATE messages SET status='replied' WHERE id = $id");

    $_SESSION['msg'] = "Reply sent successfully!";
    header("Location: messages.php");
    exit;
  } else {
    $_SESSION['msg'] = "Error sending reply. Please try again.";
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
  <h2>Reply to Message</h2>

  <form method="POST">
    <div class="mb-3">
      <label for="subject" class="form-label">Subject</label>
      <input type="text" name="subject" class="form-control" value="Re: <?= htmlspecialchars($message['subject']) ?>" required>
    </div>
    <div class="mb-3">
      <label for="message" class="form-label">Reply Message</label>
      <textarea name="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Send Reply</button>
    <a href="messages.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

<?php include '../includes/admin_footer.php'; ?>
