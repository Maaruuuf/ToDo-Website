<?php
include'reuse/_dbconnect.php';
session_start();

$id = (int)$_GET['id'];

$sql = "DELETE FROM books WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header('Location: books_to_read.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
