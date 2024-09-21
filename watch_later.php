<?php

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

// Handle form submission to save a new link
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $url = $conn->real_escape_string($_POST['url']);
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $progress = (int)$_POST['progress'];

    $sql = "INSERT INTO watch_links (uid, title, url, deadline, progress) 
            VALUES ('$uid', '$title', '$url', '$deadline', '$progress')";

    if ($conn->query($sql) === TRUE) {
        $insert = true;
        header('Location: watch_later.php'); 
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all links for the logged-in user
$links = [];
if ($result = $conn->query("SELECT * FROM watch_links WHERE uid = '$uid' ORDER BY created_at DESC")) {
    while ($row = $result->fetch_assoc()) {
        $links[] = $row;
    }
    $result->free();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch Later Links</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .link-green {
        background-color: #c3e6cb;
    }

    .link-yellow {
        background-color: #ffeeba;
    }

    .link-red {
        background-color: #f5c6cb;
    }
    </style>
</head>

<body>

    <!-- Include navigation -->
    <?php require 'reuse/_nav.php'; ?>

    <header class="section__container header__container" id="home">
        <h1>Get Started with<br /> Our <span>Resources Management</span></h1>
        <p>Begin organizing your links and resources. Discover the most effective strategies to manage them efficiently
            and maximize their utility. Here Red for low progress, Yellow for increasing progress, and Green for near
            completion.</p>
    </header>

    <!-- Main section -->
    <section class="steps" id="about">
        <hr>
        <h2 class="section__header">Track and Save <span>Links and Resources</span></h2>
        <hr>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-10">

                    <!-- Form to save a new link -->
                    <form action="watch_later.php" method="POST" class="mt-3">
                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="Title" required>
                        </div>
                        <div class="form-group">
                            <input type="url" name="url" class="form-control" placeholder="URL" required>
                        </div>
                        <div class="form-group">
                            <input type="date" name="deadline" class="form-control" placeholder="Deadline" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="progress" class="form-control" placeholder="Progress (%)" min="0"
                                max="100">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Link</button>
                    </form>

                    <!-- Display list of saved links -->
                    <ul class="list-group mt-5">
                        <?php foreach ($links as $link): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center 
                            <?php 
                                if ($link['progress'] >= 80) {
                                    echo 'link-green';
                                } elseif ($link['progress'] >= 30 && $link['progress'] < 80) {
                                    echo 'link-yellow';
                                } else {
                                    echo 'link-red';
                                }
                            ?>">
                            <div>
                                <a href="<?php echo $link['url']; ?>" target="_blank">
                                    <?php echo htmlspecialchars($link['title']); ?>
                                </a>
                                <p>Deadline: <?php echo $link['deadline']; ?></p>
                                <p>Progress: <?php echo $link['progress']; ?>%</p>
                            </div>
                            <div>
                                <a href="update_link.php?id=<?php echo $link['id']; ?>" class="badge badge-primary"
                                    style='font-size: 1em; padding: 10px 20px;'>Update</a>
                                <a href="delete_link.php?id=<?php echo $link['id']; ?>" class="badge badge-danger"
                                    style='font-size: 1em; padding: 10px 20px;'>Delete</a>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>

                </div>
            </div>
        </div>

    </section>

    <!-- Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>