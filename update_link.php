<?php
include 'reuse/_dbconnect.php';
session_start();

$id = $_GET['id'];
$link = null;

if ($result = $conn->query("SELECT * FROM watch_links WHERE id = $id")) {
    $link = $result->fetch_assoc();
    $result->free();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $url = $_POST['url'];
    $deadline = $_POST['deadline'];
    $progress = $_POST['progress'];

    $stmt = $conn->prepare("UPDATE watch_links SET title = ?, url = ?, deadline = ?, progress = ? WHERE id = ?");
    $stmt->bind_param('sssii', $title, $url, $deadline, $progress, $id);
    $stmt->execute();
    $stmt->close();

    header('Location: watch_later.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Link</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Update Link</h3>
        <form action="" method="POST">
            <div class="form-group">
                <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo htmlspecialchars($link['title']); ?>" required>
            </div>
            <div class="form-group">
                <input type="url" name="url" class="form-control" placeholder="URL" value="<?php echo htmlspecialchars($link['url']); ?>" required>
            </div>
            <div class="form-group">
                <input type="date" name="deadline" class="form-control" placeholder="Deadline" value="<?php echo htmlspecialchars($link['deadline']); ?>" required>
            </div>
            <div class="form-group">
                <input type="number" name="progress" class="form-control" placeholder="Progress (%)" min="0" max="100" value="<?php echo htmlspecialchars($link['progress']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Link</button>
        </form>
    </div>
</body>
</html>
