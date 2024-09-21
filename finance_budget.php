<?php
include 'reuse/_dbconnect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/firstpage.css" />
    <title>Finance Management</title>
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
        <h1>Get Started with<br /> Our <span>Finance Management</span></h1>
        <p>
            Begin organizing your finances. Discover the most effective strategies to manage your money efficiently and
            maximize your savings.
        </p>
    </header>

    <section class="steps" id="finance">
        <div class="container">
            <!-- Display Financial Overview -->
            <hr>
            <h2 class="section__header">
                Financial <span>Analysis</span>
            </h2>
            <hr>

            <?php
            $result = $conn->query("SELECT * FROM financial_overview ORDER BY created_at DESC LIMIT 1");
            if ($result->num_rows > 0) {
                $overview = $result->fetch_assoc();
            } else {
                $overview = ['current_balance' => 0.00, 'monthly_income' => 0.00, 'monthly_expenses' => 0.00];
            }
            ?>

            <div class="card mt-5">
                <div class="card-body">
                    <h5 class="card-title">Current Balance:
                        BDT <?php echo number_format($overview['current_balance'], 2); ?>
                    </h5>
                    <p class="card-text">Income:
                        BDT <?php echo number_format($overview['monthly_income'], 2); ?>
                    </p>
                    <p class="card-text">Expenses:
                        BDT <?php echo number_format($overview['monthly_expenses'], 2); ?>
                    </p>
                </div>
                <a href="/project1/finance_budget.php" class="btn">Refresh To See New Current Balance! </a>
            </div>


            <div class="card mt-5">
                <hr>
                <!-- Financial Records Form -->
                <h2 class="section__header"> Track Financial <span>Expenses and Savings</span> </h2>
                <hr>
            </div>

            <form action="/project1/finance_budget.php" method="POST" class="mt-3">
                <div class="form-group">
                    <label for="type">Type:</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="cost">Cost</option>
                        <option value="saving">Income</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit_record">Save Record</button>
            </form>

            <hr>

            <!-- Display Financial Records -->
            <h3 class="section__header">
                Financial <span>Reports</span>
            </h3>
            <hr>
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_POST['submit_record'])) {
                        $type = $_POST['type'];
                        $amount = $_POST['amount'];
                        $description = $_POST['description'];
                        $date = $_POST['date'];

                        $sql = "INSERT INTO financial_records (type, amount, description, date) VALUES ('$type', '$amount', '$description', '$date')";
                        if ($conn->query($sql) === TRUE) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Your record has been added successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';

                            // Update financial overview after record insertion
                            $result = $conn->query("SELECT * FROM financial_overview ORDER BY created_at DESC LIMIT 1");
                            if ($result->num_rows > 0) {
                                $overview = $result->fetch_assoc();
                                
                            } else {
                                $overview = ['current_balance' => 0.00, 'monthly_income' => 0.00, 'monthly_expenses' => 0.00];
                            }

                            if ($type == 'cost') {
                                $overview['current_balance'] -= $amount;
                                $overview['monthly_expenses'] += $amount;
                            } else {
                                $overview['current_balance'] += $amount;
                                $overview['monthly_income'] += $amount;
                            }

                            $conn->query("UPDATE financial_overview SET current_balance = {$overview['current_balance']}, monthly_income = {$overview['monthly_income']}, monthly_expenses = {$overview['monthly_expenses']} WHERE id = {$overview['id']}");

                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }

                    if (isset($_GET['delete_record'])) {
                        $id = $_GET['delete_record'];
                        $record = $conn->query("SELECT * FROM financial_records WHERE id = $id")->fetch_assoc();

                        if ($record['type'] == 'cost') {
                            $overview['current_balance'] += $record['amount'];
                            $overview['monthly_expenses'] -= $record['amount'];
                        } else {
                            $overview['current_balance'] -= $record['amount'];
                            $overview['monthly_income'] -= $record['amount'];
                        }

                        $conn->query("UPDATE financial_overview SET current_balance = {$overview['current_balance']}, monthly_income = {$overview['monthly_income']}, monthly_expenses = {$overview['monthly_expenses']} WHERE id = {$overview['id']}");

                        if ($conn->query("DELETE FROM financial_records WHERE id = $id")) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> Your record has been deleted successfully!
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                        }

                    }

                    $result = $conn->query("SELECT * FROM financial_records");
                    while ($row = $result->fetch_assoc()) {
                        $row_class = $row['type'] == 'cost' ? 'budget-red' : 'budget-green';
                                echo "<tr class='{$row_class}'>
                               <td>{$row['type']}</td>
                               <td>{$row['amount']}</td>
                               <td>{$row['description']}</td>
                               <td>{$row['date']}</td>
                                <td>
                                      <a href='update_record.php?id={$row['id']}' class='btn btn-info'>Update</a>
                                      <a href='finance_budget.php?delete_record={$row['id']}' class='btn btn-danger'>Delete</a>
                               </td>
                                </tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>