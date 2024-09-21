<?php

include 'reuse/_dbconnect.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}

if (isset($_GET['logout'])) {
   unset($user_id);
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
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>User Profile</title>

</head>

<body>

    <?php require 'reuse/_nav.php'; ?>

    <section class="steps" id="about">
        
        <h2 class="section__header text-center my-4">
            User <span>Profile</span>
        </h2>
        <div class="container d-flex justify-content-center">
            <div class="card" style="width: 24rem;">
                <div class="card-body">
                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM `users` WHERE sid = '$user_id'") or die('query failed');
                    if (mysqli_num_rows($select) > 0) {
                        $fetch = mysqli_fetch_assoc($select);
                    }
                    ?>
                    <h5 class="card-title"><?php echo 'User Name: ' . $fetch['username']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo 'Email: ' . $fetch['email']; ?></h6>
                    <a href="update_profile.php" class="btn btn-primary">Update profile</a>
                    <a href="/project1/logout.php" class="btn btn-danger">Logout</a>
                    
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
