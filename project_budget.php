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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Project Budget Management</title>
    <style>
    .budget-green {
        background-color: #c3e6cb;
    }

    .budget-red {
        background-color: #f5c6cb;
    }
    </style>
</head>

<body>
    <?php require 'reuse/_nav.php'; ?>

    <header class="section__container header__container" id="home">
        <h1>Get Started with<br /> Our <span>Budget Management</span></h1>
        <p>
            Start planning and tracking your project budgets. Discover the best ways to manage and allocate resources
            efficiently to ensure your project's success. Monitor your expenses easily with our color-coded system: Red
            indicates you’ve exceeded your budget, while Green shows you're spending below your budget.
        </p>
    </header>

    <section class="steps" id="about">
        <div class="container">
            <hr>
            <h2 class="section__header">
                Plan and Track <span>Your Project Budgets</span>
            </h2>
            <hr>

            <form action="/project1/project_budget.php" method="POST" class="mt-3">
                <div class="form-group">
                    <label for="project_name">Project Name:</label>
                    <input type="text" class="form-control" id="project_name" name="project_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="budget">Budget:</label>
                    <input type="number" step="0.01" class="form-control" id="budget" name="budget" required>
                </div>
                <div class="form-group">
                    <label for="spent">Spent:</label>
                    <input type="number" step="0.01" class="form-control" id="spent" name="spent" required>
                </div>
                <div class="form-group">
                    <label for="deadline">Deadline:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit_budget">Save Budget</button>
            </form>

            <!-- Display Project Budgets -->
            <hr>
            <h3 class="section__header">
                Project <span>Budgets</span>
            </h3>
            <hr>

            <table class="table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Budget</th>
                        <th>Spent</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Handle form submission and insert the budget into the database
                    if (isset($_POST['submit_budget'])) {
                        $project_name = $_POST['project_name'];
                        $description = $_POST['description'];
                        $budget = $_POST['budget'];
                        $spent = $_POST['spent'];
                        $deadline = $_POST['deadline'];

                        // Check if UID exists in the users table before inserting into project_budgets
                        $check_uid_sql = "SELECT sid FROM users WHERE sid = '$uid'";
                        $check_uid_result = mysqli_query($conn, $check_uid_sql);

                        if (mysqli_num_rows($check_uid_result) > 0) {
                            // UID exists, proceed with insertion
                            $sql = "INSERT INTO project_budgets (uid, project_name, description, budget, spent, deadline) 
                                    VALUES ('$uid', '$project_name', '$description', '$budget', '$spent', '$deadline')";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                          <strong>Success!</strong> Your record has been added successfully!
                                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                      </div>';
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">
                                    User ID does not exist in the users table. Please check your user information.
                                  </div>';
                        }
                    }

                    // Handle budget deletion
                    if (isset($_GET['delete_budget'])) {
                        $id = $_GET['delete_budget'];
                        if ($conn->query("DELETE FROM project_budgets WHERE id = $id")) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      <strong>Success!</strong> Your record has been deleted successfully!
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                        }
                    }

                    // Fetch and display all budgets for the current user
                    $result = $conn->query("SELECT * FROM project_budgets WHERE uid = '$uid'");
                    while ($row = $result->fetch_assoc()) {
                        $class = $row['spent'] <= $row['budget'] ? 'budget-green' : 'budget-red';
                        echo "<tr class='{$class}'>
                                <td>{$row['project_name']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['budget']}</td>
                                <td>{$row['spent']}</td>
                                <td>{$row['deadline']}</td>
                                <td>
                                    <a href='update_budget.php?id={$row['id']}' class='badge badge-primary mx-1' style='font-size: 1em; padding: 11px 17px;' >Update</a>
                                    <a href='project_budget.php?delete_budget={$row['id']}' class='badge badge-danger' style='font-size: 1em; padding: 11px 17px;' >Delete</a>
                                </td>
                              </tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>