<?php
include'reuse/_dbconnect.php';
session_start();

$id = (int)$_GET['id'];

$sql = "DELETE FROM watch_links WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header('Location: watch_later.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
