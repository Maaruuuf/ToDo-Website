<?php

include 'reuse/_dbconnect.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

 
    mysqli_query($conn, "UPDATE `users` SET username = '$update_name', email = '$update_email' WHERE sid = '$user_id'") or die('query failed');

    
    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, ($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if ($update_pass != $old_pass) {
            $message[] = 'Old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'Confirm password not matched!';
        } else {
            mysqli_query($conn, "UPDATE `users` SET password = '$confirm_pass' WHERE sid = '$user_id'") or die('query failed');
            $message[] = 'Password Updated successfully!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <?php require 'reuse/_nav.php'; ?>


    <section class="steps" id="about">

        <h2 class="section__header text-center my-4">
            Update <span>Profile and Change Password❓</span>
        </h2>

        <div class="container mt-5">
            <?php
        $select = mysqli_query($conn, "SELECT * FROM `users` WHERE sid = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        }
    ?>

            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <?php
                    if (isset($message)) {
                        foreach ($message as $message) {
                            echo '<div class="alert alert-warning" role="alert">'.$message.'</div>';
                        }
                    }
                ?>
                        <div class="mb-3">
                            <label for="update_name" class="form-label">User Name</label>
                            <input type="text" name="update_name" value="<?php echo $fetch['username']; ?>"
                                class="form-control" id="update_name">
                        </div>
                        <div class="mb-3">
                            <label for="update_email" class="form-label">Email Address</label>
                            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>"
                                class="form-control" id="update_email">
                        </div>
                        <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                        <div class="mb-3">
                            <label for="update_pass" class="form-label">Old Password</label>
                            <input type="password" name="update_pass" placeholder="Enter previous password"
                                class="form-control" id="update_pass">
                        </div>
                        <div class="mb-3">
                            <label for="new_pass" class="form-label">New Password</label>
                            <input type="password" name="new_pass" placeholder="Enter new password" class="form-control"
                                id="new_pass">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_pass" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_pass" placeholder="Confirm new password"
                                class="form-control" id="confirm_pass">
                        </div>
                        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
                        <a href="/project1/profile.php" class="btn btn-secondary">Go Back</a>
                    </form>
                </div>
            </div>
        </div>

    </section>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>