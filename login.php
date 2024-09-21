<?php
$login = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    include'reuse/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];
   
    

    if (!empty($username) && !empty($password)) {
       
            $sql = "Select * from users where username = '$username' AND password = '$password' ";
            $result = mysqli_query($conn, $sql);
            $num = mysqli_num_rows($result);
            if($num == 1 ){
                $login = true;
                session_start();
                while($row = mysqli_fetch_assoc($result)){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['uid'] = $row['sid'];
                    $_SESSION['user_id'] = $row['sid'];

                    

                }
                header("location: firstpage.php");
                
            }else{
                $showError = true;
            }      
        
    } else {
        $showError = true; 
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
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/form.css" />


    <title>Login in ToTrick</title>
</head>

<body>

    <?php
    if($login){
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong> You are logged in!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div> ' ; 
    }
    if($showError){
        echo ' <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Sir!</strong> Invalid Credentials!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div> ' ; 
    }
    ?>



    <div class="container">
        <div class="container__left">
            <div class="content">
                <div class="header">
                    <a href="/project1/landingpage.php" class="register">Go to ToTrick</a>
                </div>
                <div class="form__content">
                    <h3 class="form__title">Login to ToTrick</h3>
                    <p class="form__subtitle">
                        Welcome! Please fill your username and password to Log in to your
                        account.
                    </p>
                    <form action="/project1/login.php" method="post">
                        <div class="input-box">
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                                required>
                        </div>
                        <div class="input-box">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password" required>
                        </div>
                        <button class="submit__btn" type="submit">Login Now</button>
                        <p>Create an account? <a href="/project1/signup.php">Signup Here</a></p>

                    </form>
                    <span class="bottom__line"></span>
                    <p class="footer__title">You can also login with:</p>
                    <div class="social__icons">
                        <i class="ri-facebook-box-fill"></i>
                        <i class="ri-google-fill"></i>
                        <i class="ri-twitter-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container__right">
            <div class="image">
                <h3>Start your journey</h3>
                <p>
                    Start organize your life with our website! Login into your account
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