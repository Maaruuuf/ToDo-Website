<?php
include 'reuse/_dbconnect.php';
session_start();

$id = $_GET['id'];
$book = null;

if ($result = $conn->query("SELECT * FROM books WHERE id = $id")) {
    $book = $result->fetch_assoc();
    $result->free();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];
    $progress = $_POST['progress'];

    $stmt = $conn->prepare("UPDATE books SET title = ?, author = ?, description = ?, deadline = ?, progress = ? WHERE id = ?");
    $stmt->bind_param('ssssii', $title, $author, $description, $deadline, $progress, $id);
    $stmt->execute();
    $stmt->close();

    header('Location: books_to_read.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Update Book</h3>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            </div>
            <div class="form-group">
                <input type="text" name="author" class="form-control" placeholder="Author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            </div>
            <div class="form-group">
                <textarea name="description" class="form-control" placeholder="Description" required><?php echo htmlspecialchars($book['description']); ?></textarea>
            </div>
            <div class="form-group">
                <input type="date" name="deadline" class="form-control" placeholder="Deadline" value="<?php echo htmlspecialchars($book['deadline']); ?>" required>
            </div>
            <div class="form-group">
                <input type="number" name="progress" class="form-control" placeholder="Progress (%)" min="0" max="100" value="<?php echo htmlspecialchars($book['progress']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>
</body>
</html>
