<?php
// Database connection and session handling
include 'reuse/_dbconnect.php';
session_start();
if (!isset($_SESSION['uid'])) {
    echo "User ID is not set. Please log in.";
    exit;
}

$uid = $_SESSION['uid'];
$insert = false;
$update = false;
$delete = false;

// Handle book submission (Insert new book)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $progress = (int)$_POST['progress'];

    $sql = "INSERT INTO books (uid, title, author, description, deadline, progress) 
            VALUES ('$uid', '$title', '$author', '$description', '$deadline', '$progress')";

    if ($conn->query($sql) === TRUE) {
        $insert = true;
        header('Location: books_to_read.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all books for the logged-in user
$books = [];
if ($result = $conn->query("SELECT * FROM books WHERE uid = '$uid' ORDER BY created_at DESC ")) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    $result->free();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books to Read</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .book-green {
        background-color: #c3e6cb;
        color: #155724;
    }

    .book-yellow {
        background-color: #ffeeba;
    }

    .book-red {
        background-color: #f5c6cb;
        color: #721c24;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php require 'reuse/_nav.php'; ?>

    <!-- Header Section -->
    <header class="section__container header__container" id="home">
        <h1>Get Started with<br /> Our <span>Reading Tracker</span></h1>
        <p>Discover the best ways to manage your reading list efficiently and keep
            track of the books you read to enhance your knowledge and productivity.
        </p>
        <p>
            Monitor your reading progress with
            our color-coded system: Red indicates very low progress, Yellow shows progress is increasing, and Green
            means you're close to finishing!
        </p>

    </header>

    <!-- Main Content -->
    <section class="steps" id="about">
        <hr>
        <h2 class="section__header">Track your <span>Reading Progress</span></h2>
        <hr>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-10">
                    <!-- Book Submission Form -->
                    <form action="books_to_read.php" method="POST" class="mt-3">
                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="author" class="form-control" placeholder="Author" required>
                        </div>
                        <div class="form-group">
                            <textarea name="description" class="form-control" placeholder="Description"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="date" name="deadline" class="form-control" placeholder="Deadline" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="progress" class="form-control" placeholder="Progress (%)" min="0"
                                max="100">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Book</button>
                    </form>

                    <!-- Book List -->
                    <ul class="list-group mt-5">
                        <?php foreach ($books as $book): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center 
                            <?php 
                                if ($book['progress'] >= 80) {
                                    echo 'book-green';
                                } elseif ($book['progress'] >= 30 && $book['progress'] < 80) {
                                    echo 'book-yellow';
                                } else {
                                    echo 'book-red';
                                }
                            ?>">
                            <div>
                                <h5><?php echo htmlspecialchars($book['title']); ?></h5>
                                <p><?php echo htmlspecialchars($book['author']); ?></p>
                                <p><?php echo htmlspecialchars($book['description']); ?></p>
                                <p>Deadline: <?php echo $book['deadline']; ?></p>
                                <p>Progress: <?php echo $book['progress']; ?>%</p>
                            </div>
                            <div>
                                <a href="update_book.php?id=<?php echo $book['id']; ?>" class="badge badge-primary"
                                    style='font-size: 1em; padding: 10px 20px;'>Update</a>
                                <a href="delete_book.php?id=<?php echo $book['id']; ?>" class="badge badge-danger"
                                    style='font-size: 1em; padding: 10px 20px;'>Delete</a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>