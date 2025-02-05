<?php
include 'reuse/_dbconnect.php';
session_start();

if (!isset($_SESSION['uid'])) {
    echo "User ID is not set. Please log in.";
    exit;
}

$uid = $_SESSION['uid']; 


if (isset($_GET['fetch_tasks_and_books'])) {
    $events = [];

    
    $queryTasks = "SELECT title, start_date, deadline_date FROM tasks WHERE uid = ?";
    $stmtTasks = $conn->prepare($queryTasks);
    $stmtTasks->bind_param('i', $uid);
    $stmtTasks->execute();
    $resultTasks = $stmtTasks->get_result();

    while ($row = $resultTasks->fetch_assoc()) {
       
        $events[] = [
            'title' => $row['title'] . " (Task Start)",
            'start' => $row['start_date'],
            'color' => '#FEA303', 
        ];
        $events[] = [
            'title' => $row['title'] . " (Task Deadline)", 
            'start' => $row['deadline_date'],
            'color' => '#914955', 
        ];
    }

   
    $queryBooks = "SELECT title, deadline FROM books WHERE uid = ?";
    $stmtBooks = $conn->prepare($queryBooks);
    $stmtBooks->bind_param('i', $uid);
    $stmtBooks->execute();
    $resultBooks = $stmtBooks->get_result();

    while ($row = $resultBooks->fetch_assoc()) {
        
        $events[] = [
            'title' => $row['title'] . " (Book Deadline)", 
            'start' => $row['deadline'],
            'color' => '#1C3F60', 
        ];
    }

     
     $queryResources = "SELECT title, deadline FROM watch_links WHERE uid = ?";
     $stmtResources = $conn->prepare($queryResources);
     $stmtResources->bind_param('i', $uid);
     $stmtResources->execute();
     $resultResources = $stmtResources->get_result();
 
     while ($row = $resultResources->fetch_assoc()) {
         
         $events[] = [
             'title' => $row['title'] . " (Resource Deadline)", 
             'start' => $row['deadline'],
             'color' => '#3D550C', 
         ];
     }

    // Output all events as JSON
    header('Content-Type: application/json');
    echo json_encode($events);
    exit;
}

if (isset($_GET['logout'])) {
    unset($uid);
    session_destroy();
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <!-- Optional: jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>User Profile</title>

    <style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }

    .section__header span {
        color: #1B2A37;
    }

    .leaderboard .card {
        border: none;
        border-radius: 15px;
        background: linear-gradient(135deg, #e3f2fd, #385E72);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .leaderboard .card:hover {
        transform: scale(1.03);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    .leaderboard .list-group-item {
        background-color: #e3f2fd;
        border: none;
        font-size: 1.1rem;
        padding: 15px 20px;
        border-bottom: 1px solid #bbdefb;
        transition: background-color 0.3s, transform 0.2s;
    }

    .leaderboard .list-group-item:hover {
        background-color: #bbdefb;
        transform: translateX(5px);
    }

    .leaderboard .list-group-item strong {
        font-weight: bold;
        color: #914955;
    }

    .leaderboard h2 {
        font-size: 2rem;
        font-weight: bold;
        color: #1B2A37;
    }

    .btn-primary {
        background-color: #42a5f5;
        border-color: #42a5f5;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #5B89AE;
    }

    #calendar-container {
        max-width: 900px;
        margin: 50px auto;
        padding: 10px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    #calendar {
        margin: 20px;
    }
    </style>
</head>

<body>

    <?php require 'reuse/_nav.php'; ?>

    <section class="steps" id="about">
        <h2 class="section__header text-center my-4">
        Profile <span>Insights</span>
        </h2>
        <div class="container d-flex justify-content-center">
            <div class="card" style="width: 24rem;">
                <div class="card-body">
                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE sid = '$uid'") or die('query failed');
                    if (mysqli_num_rows($select) > 0) {
                        $fetch = mysqli_fetch_assoc($select);
                    }
                    ?>
                    <h5 class="card-title"><?php echo 'Username: ' . $fetch['username']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo 'Email: ' . $fetch['email']; ?></h6>
                    <a href="update_profile.php" class="btn btn-primary">Update profile</a>
                    <a href="/project1/logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </section>

    <section class="leaderboard my-5">
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            
                            $task_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `tasks` WHERE uid = '$uid'"))['count'];
                            $note_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `notes` WHERE uid = '$uid'"))['count'];
                            $book_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `books` WHERE uid = '$uid'"))['count'];
                            $resource_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `watch_links` WHERE uid = '$uid'"))['count'];

                            
                            $tasks_finished = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `tasks` WHERE uid = '$uid' AND deadline_date < NOW()"))['count'];
                            $tasks_active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM `tasks` WHERE uid = '$uid' AND deadline_date >= NOW()"))['count'];
                            ?>

                            <ul class="list-group">
                                <li class="list-group-item">Tasks Added: <strong><?php echo $task_count; ?></strong>
                                </li>
                                <li class="list-group-item">Notes Added: <strong><?php echo $note_count; ?></strong>
                                </li>
                                <li class="list-group-item">Books Added: <strong><?php echo $book_count; ?></strong>
                                </li>
                                <li class="list-group-item">Resources Added:
                                    <strong><?php echo $resource_count; ?></strong>
                                </li>
                                <li class="list-group-item">Tasks with Finished Deadlines:
                                    <strong><?php echo $tasks_finished; ?></strong>
                                </li>
                                <li class="list-group-item">Tasks Still Active:
                                    <strong><?php echo $tasks_active; ?></strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="calendar">
        
        <div id="calendar-container">
            <div id="calendar"></div>
        </div>
    </section>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '?fetch_tasks_and_books=true', 
            eventClick: function(info) {
                
                alert('Event: ' + info.event.title + '\nDate: ' + info.event.start.toISOString()
                    .slice(0, 10));
            }
        });

        calendar.render();
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>