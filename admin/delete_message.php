<?php
include '../config/config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM contact_messages WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: messages.php?deleted=1");
        exit;
    } else {
        echo "Error deleting message: " . mysqli_error($conn);
    }
} else {
    header("Location: messages.php");
    exit;
}
