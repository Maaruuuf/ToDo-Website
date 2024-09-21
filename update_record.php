<?php
include'reuse/_dbconnect.php';
session_start();
if (isset($_POST['update_record'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $record = $conn->query("SELECT * FROM financial_records WHERE id = $id")->fetch_assoc();
    $overviewResult = $conn->query("SELECT * FROM financial_overview ORDER BY created_at DESC LIMIT 1");
    if ($overviewResult->num_rows > 0) {
        $overview = $overviewResult->fetch_assoc();
    } else {
        $overview = ['current_balance' => 0.00, 'monthly_income' => 0.00, 'monthly_expenses' => 0.00];
    }

    // Revert the previous amount
    if ($record['type'] == 'cost') {
        $overview['current_balance'] += $record['amount'];
        $overview['monthly_expenses'] -= $record['amount'];
    } else {
        $overview['current_balance'] -= $record['amount'];
        $overview['monthly_income'] -= $record['amount'];
    }

    // Apply the new amount
    if ($type == 'cost') {
        $overview['current_balance'] -= $amount;
        $overview['monthly_expenses'] += $amount;
    } else {
        $overview['current_balance'] += $amount;
        $overview['monthly_income'] += $amount;
    }

    $conn->query("UPDATE financial_overview SET current_balance = {$overview['current_balance']}, monthly_income = {$overview['monthly_income']}, monthly_expenses = {$overview['monthly_expenses']} WHERE id = {$overview['id']}");

    $sql = "UPDATE financial_records SET type = '$type', amount = '$amount', description = '$description', date = '$date' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('Location: finance_budget.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id = $_GET['id'];
$record = $conn->query("SELECT * FROM financial_records WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Financial Record</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Update Financial Record</h1>
        <form action="/project1/update_record.php" method="POST" class="mt-3">
            <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="cost" <?php if ($record['type'] == 'cost') echo 'selected'; ?>>Cost</option>
                    <option value="saving" <?php if ($record['type'] == 'saving') echo 'selected'; ?>>Saving</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?php echo $record['amount']; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $record['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo $record['date']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update_record">Update Record</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
