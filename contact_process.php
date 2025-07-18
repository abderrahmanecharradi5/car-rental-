<?php
session_start();
include 'config/config.php'; // adjust path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "Invalid email address.";
        header("Location: contact.php");
        exit();
    }

    $query = "INSERT INTO contact_messages (name, email, subject, message, created_at) 
              VALUES ('$name', '$email', '$subject', '$message', NOW())";

    if (mysqli_query($conn, $query)) {
        $_SESSION['msg'] = "Message sent successfully!";
    } else {
        $_SESSION['msg'] = "Something went wrong. Please try again.";
    }

    header("Location: contact.php");
    exit();
} else {
    header("Location: contact.php");
    exit();
}
