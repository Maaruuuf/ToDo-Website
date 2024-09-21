<?php
$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    include'reuse/_dbconnect.php';
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    //checking duplicate username
      $existsql = "SELECT * FROM users WHERE username = '$username'";
      $result = mysqli_query($conn,$existsql);
         $numExistRows = mysqli_num_rows($result);
            if($numExistRows > 0)
            {
                $showError = "Username already exists";
            }else{

                if (!empty($email) && !empty($username) && !empty($password) && !empty($cpassword)) {
       
                    if ($password == $cpassword) {
                        
                        $sql = "INSERT INTO `users` (`email`, `username`, `password`, `date`) 
                                VALUES ('$email', '$username', '$password', current_timestamp())";
            
                        $result = mysqli_query($conn, $sql);
            
                        if ($result) {
                            $showAlert = true; 
                        }else{
                            $showError = "Password do not match"; 
                        } 
                    } else {
                        $showError = "Password do not match"; 
                    }
                } else {
                    $showError = "Please ensure all fields are filled out correctly before submitting the form"; 
                }
                
            }
    
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>




    <title>SignUp to ToTrick</title>
</head>

<body>

    <?php 
    if($showAlert){
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is now created and you can login now. Go to login page!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div> ' ; 
    }
    if($showError){
        echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '.$showError.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div> ' ; 
    }
    ?>

    <div class="container">
        <div class="container__left">
            <div class="content">
                <div class="header">
                    <a href="/project1/login.php" class="register">Login to ToTrick</a>
                </div>
                <div class="form__content">
                    <h3 class="form__title">Register in ToTrick</h3>
                    <p class="form__subtitle">
                        Welcome! Please fill all your details to sign in to your account.
                    </p>
                    <form action="/project1/signup.php" method="post">

                        <div class="input-box">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                required>
                        </div>
                        <div class="input-box">
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Username">

                        </div>
                        <div class="input-box">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                        </div>
                        <div class="input-box">
                            <input type="password" class="form-control" id="cpassword" name="cpassword"
                                placeholder="Confirm Password">

                        </div>
                        <button class="submit__btn" type="submit">Signup</button>
                        <p>Already have an account? <a href="/project1/login.php">Login Here</a></p>

                    </form>
                    <span class="bottom__line"></span>
                </div>
            </div>
        </div>
        <div class="container__right">
            <div class="image">
                <h3>Start your journey</h3>
                <p>
                    Start organize your life with our website! Create an account!
                </p>
            </div>
        </div>
    </div>




    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>