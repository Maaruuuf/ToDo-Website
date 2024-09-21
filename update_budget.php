<?php
include'reuse/_dbconnect.php';
session_start();

if (isset($_POST['update_budget'])) {
    $id = $_POST['id'];
    $project_name = $_POST['project_name'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $spent = $_POST['spent'];
    $deadline = $_POST['deadline'];

    $sql = "UPDATE project_budgets SET project_name = '$project_name', description = '$description', budget = '$budget', spent = '$spent', deadline = '$deadline' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: project_budget.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id = $_GET['id'];
$budget = $conn->query("SELECT * FROM project_budgets WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Project Budget</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Update Project Budget</h1>
        <form action="update_budget.php" method="POST" class="mt-3">
            <input type="hidden" name="id" value="<?php echo $budget['id']; ?>">
            <div class="form-group">
                <label for="project_name">Project Name:</label>
                <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo $budget['project_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $budget['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="budget">Budget:</label>
                <input type="number" step="0.01" class="form-control" id="budget" name="budget" value="<?php echo $budget['budget']; ?>" required>
            </div>
            <div class="form-group">
                <label for="spent">Spent:</label>
                <input type="number" step="0.01" class="form-control" id="spent" name="spent" value="<?php echo $budget['spent']; ?>" required>
            </div>
            <div class="form-group">
                <label for="deadline">Deadline:</label>
                <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $budget['deadline']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_budget">Update Budget</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
