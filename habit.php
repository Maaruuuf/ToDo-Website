<?php
include 'reuse/_dbconnect.php';
session_start();


if (!isset($_SESSION['uid'])) {
    echo "User ID is not set. Please log in.";
    exit;
}


$uid = (int)$_SESSION['uid']; 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $exercise = $conn->real_escape_string($_POST['exercise']);
    $reading = $conn->real_escape_string($_POST['reading']);
    $coding = $conn->real_escape_string($_POST['coding']);
    $sleeping = $conn->real_escape_string($_POST['sleeping']);
    $praying = $conn->real_escape_string($_POST['praying']);
    $social_media = $conn->real_escape_string($_POST['social_media']);
    $breaks = $conn->real_escape_string($_POST['breaks']);
    $drinking_water = $conn->real_escape_string($_POST['drinking_water']);

   
    $sql = "INSERT INTO habits (uid, exercise, reading, coding, sleeping, praying, social_media, breaks, drinking_water) 
            VALUES ('$uid', '$exercise', '$reading', '$coding', '$sleeping', '$praying', '$social_media', '$breaks', '$drinking_water')";

    if ($conn->query($sql) === TRUE) {
        
        header('Location: habit.php?insert=success');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete']; 
    $deleteSql = "DELETE FROM habits WHERE id = $id AND uid = $uid";
    if ($conn->query($deleteSql) === TRUE) {
        header('Location: habit.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


$selectedData = null;
if (isset($_GET['view'])) {
    $id = (int)$_GET['view']; 
    $viewSql = "SELECT * FROM habits WHERE id = $id AND uid = $uid";
    $result = $conn->query($viewSql);
    if ($result->num_rows > 0) {
        $selectedData = $result->fetch_assoc();
    } else {
        echo "No data found for the selected view.";
    }
}


$sql = "SELECT * FROM habits WHERE uid = $uid ORDER BY id ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Habit Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="assets/habit.css" />
</head>

<body>
    <?php require 'reuse/_nav.php'; ?>
    <header class="section__container header__container" id="home">
        <img src="assets/logo3.png" alt="header" />
        <img src="assets/logo1.png" alt="header" />
        <img src="assets/logo2.png" alt="header" />
        <img src="assets/logo4.png" alt="header" />
        <img src="assets/logo5.png" alt="header" />
        <img src="assets/logo6.png" alt="header" />
        <h1><span>Habit Tracker</span></h1>
        <p>Track your habits and visualize your progress!</p>
    </header>

    <div class="container my-2">
        <!-- Input Form -->
        <section class="form-section">
            <h2>Track Your Habit Data!</h2>
            <form id="habitForm" action="habit.php" method="POST">
                <div class="form-group">
                    <label for="coding">Coding (hours)</label>
                    <input type="number" id="coding" name="coding" min="0" max="24"
                        placeholder="Enter hours for coding">
                </div>
                <div class="form-group">
                    <label for="sleeping">Sleeping (hours)</label>
                    <input type="number" id="sleeping" name="sleeping" min="0" max="24"
                        placeholder="Enter hours for sleeping">
                </div>
                <div class="form-group">
                    <label for="exercise">Exercise (hours)</label>
                    <input type="number" id="exercise" name="exercise" min="0" max="24"
                        placeholder="Enter hours for exercise">
                </div>
                <div class="form-group">
                    <label for="reading">Reading (hours)</label>
                    <input type="number" id="reading" name="reading" min="0" max="24"
                        placeholder="Enter hours for reading">
                </div>

                <div class="form-group">
                    <label for="praying">Praying (Number of Times)</label>
                    <input type="number" id="praying" name="praying" min="0" max="5"
                        placeholder="Enter Number of times for praying">
                </div>
                <div class="form-group">
                    <label for="social_media">Social media usage (hours)</label>
                    <input type="number" id="social_media" name="social_media" min="0" max="24"
                        placeholder="Enter hours for Social media usage">
                </div>
                <div class="form-group">
                    <label for="breaks">Breaks (hours)</label>
                    <input type="number" id="breaks" name="breaks" min="0" max="24"
                        placeholder="Enter hours for breaks">
                </div>
                <div class="form-group">
                    <label for="drinking_water">Drinking Water (Number of Glass)</label>
                    <input type="number" id="drinking_water" name="drinking_water" min="0" max="15"
                        placeholder="Enter Number of Glasses">
                </div>

                <button type="submit">Update Charts</button>
            </form>
        </section>
    </div>

    <div class="container my-4">
        <!-- Charts Section -->
        <section class="charts-section" id="charts">
            <h2>Habit Visualization ╰┈➤</h2>
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </section>
    </div>

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Coding</th>
                    <th>Sleeping</th>
                    <th>Exercise</th>
                    <th>Reading</th>
                    <th>Praying</th>
                    <th>Social</th>
                    <th>Breaks</th>
                    <th>Water Intake</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>
                <?php $id = 0; ?>
                <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()):  ?>
                <?php $id = $id+1;?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $row['coding']; ?></td>
                    <td><?php echo $row['sleeping']; ?></td>
                    <td><?php echo $row['exercise']; ?></td>
                    <td><?php echo $row['reading']; ?></td>
                    <td><?php echo $row['praying']; ?></td>
                    <td><?php echo $row['social_media']; ?></td>
                    <td><?php echo $row['breaks']; ?></td>
                    <td><?php echo $row['drinking_water']; ?></td>
                    <td>
                        <a href="habit.php?delete=<?php echo $row['id']; ?>">Delete</a> |
                        <a href="habit.php?view=<?php echo $row['id']; ?>">View</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No data available</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <hr>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    const barCtx = document.getElementById('barChart').getContext('2d');

    
    let exerciseHours = 0;
    let readingHours = 0;
    let codingHours = 0;
    let sleepingHours = 0;
    let socialMediaUsageHours = 0;
    let breaksHours = 0;
    let prayingTimes = 0;
    let drinkingWaterTimes = 0;

    
    <?php if ($selectedData): ?>
    exerciseHours = <?php echo $selectedData['exercise']; ?>;
    readingHours = <?php echo $selectedData['reading']; ?>;
    codingHours = <?php echo $selectedData['coding']; ?>;
    sleepingHours = <?php echo $selectedData['sleeping']; ?>;
    socialMediaUsageHours = <?php echo $selectedData['social_media']; ?>;
    breaksHours = <?php echo $selectedData['breaks']; ?>;
    prayingTimes = <?php echo $selectedData['praying']; ?>;
    drinkingWaterTimes = <?php echo $selectedData['drinking_water']; ?>;
    <?php endif; ?>

    
    new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Coding', 'Sleeping', 'Social Media', 'Breaks'],
            datasets: [{
                label: 'Hours Spent',
                data: [codingHours, sleepingHours, socialMediaUsageHours, breaksHours],
                backgroundColor: ['#2F2440', '#9C2D41','#C8DF52','#AAD6A0'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 16
                        }
                    }
                },
            }
        }
    });

    
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Exercise in Hours', 'Reading in Hours', 'Number of Praying Times', 'Drinking Water per Glass'],
            datasets: [{
                data: [exerciseHours, readingHours, prayingTimes, drinkingWaterTimes],
                backgroundColor: ['#1B2A37', '#533440','#ADC4D7', '#000000'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Hours',
                        font: {
                            size: 16
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    </script>
</body>

</html>