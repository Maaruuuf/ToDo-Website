<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
  header("location:login.php");
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/firstpage.css" />
    <title>Welcome To ToTrick</title>
</head>

<body>
    <nav>
        <div class="nav__header">
            <div class="nav__logo">
                <a href="#" class="logo">To<span>Trick</span></a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#Feature">Features</a></li>
            <li><a href="#service">Solutions</a></li>
            <li><a href="#contact">Resources</a></li>
            <li><button class="btn"><a href="/project1/profile.php">User Profile</a></button></li>
        </ul>
    </nav>
    <header class="section__container header__container" id="home">
        <img src="assets/logo3.png" alt="header" />
        <img src="assets/logo1.png" alt="header" />
        <img src="assets/logo2.png" alt="header" />
        <img src="assets/logo4.png" alt="header" />
        <img src="assets/logo5.png" alt="header" />
        <img src="assets/logo6.png" alt="header" />
        <h2>
            <img src="assets/logo.png" alt="bag" />
            Best Todo Website
        </h2>
        <h1>Organize, Plan & <br /> Achieve Your <span> Goals</span></h1>
        <p>
            Start organizing your tasks today. Discover countless ways to manage your goals efficiently and transform
            your
            productivity.
        </p>
        <div class="header__btns">
            <a href="#Feature" class="btn">Get Started Now</a>
            <a href="#">
                <span><i class="ri-play-fill"></i></span>
                How It Works?
            </a>
        </div>
    </header>

    <section class="steps" id="about">
        <div class="section__container steps__container">
            <h2 class="section__header">
                Get Started with <span>Our Features</span>
            </h2>
            <p class="section__description">
                Use Our Website For Effortlessly Organize Your Tasks and Achieve Your Goals.
            </p>
            <div class="steps__grid">
                <div class="steps__card">
                    <span><i class="ri-user-fill"></i></span>
                    <h4>User Friendly Interface</h4>
                    <p>
                        Sign up in just a few clicks to unlock exclusive access to powerful tools for organizing tasks
                        and achieving
                        your goals. It's quick, easy, and completely free!
                    </p>
                </div>
                <div class="steps__card">
                    <span><i class="ri-search-fill"></i></span>
                    <h4>Manage Tasks</h4>
                    <p>
                        Dive into our task management system tailored to fit your needs and preferences. With our
                        advanced
                        organization tools, managing your tasks has never been easier..
                    </p>
                </div>
                <div class="steps__card">
                    <span><i class="ri-file-paper-fill"></i></span>
                    <h4>Track Your Finance</h4>
                    <p>
                        Enhance your financial oversight by linking your accounts and tracking your expenses. Let us
                        help you manage
                        your budget and make informed financial decisions.
                    </p>
                </div>
                <div class="steps__card">
                    <span><i class="ri-briefcase-fill"></i></span>
                    <h4>Manage Resources</h4>
                    <p>
                        Take control of your resources with our intuitive tools. Organize and allocate your assets
                        efficiently to
                        achieve your goals and maximize productivity.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section__container explore__container" id="Feature">
        <h2 class="section__header">
            <span>Task Management Options</span> Are Waiting For You To Explore
        </h2>
        <p class="section__description">
            Discover a World of Productivity and Endless Possibilities, and Find the Perfect Tools to Shape Your
            Success.
        </p>

        <div class="explore__grid">
            <a href="/project1/task.php" class="explore__card">
                <span><i class="ri-checkbox-circle-fill"></i></span>
                <h4>Task Management</h4>
                <p>Create, update and delete</p>
            </a>
            <a href="/project1/note.php" class="explore__card">
                <span><i class="ri-compass-discover-fill"></i></span>
                <h4>Track Your Things</h4>
                <p>Take short notes</p>
            </a>
            <a href="/project1/finance_budget.php" class="explore__card">
                <span><i class="ri-money-dollar-circle-fill"></i></span>
                <h4>Finance Management</h4>
                <p>Save your money</p>
            </a>
            <a href="/project1/project_budget.php" class="explore__card">
                <span><i class="ri-money-dollar-circle-fill"></i></span>
                <h4>Budget Management</h4>
                <p>Track your budget for projects</p>
            </a>
            <a href="/project1/books_to_read.php" class="explore__card">
                <span><i class="ri-book-fill"></i></span>
                <h4>Track Books</h4>
                <p>Track of your Reading List</p>
            </a>
            <a href="/project1/watch_later.php" class="explore__card">
                <span><i class="ri-time-fill"></i></span>
                <h4>Resource Management</h4>
                <p>Save and manage links</p>
            </a>
        </div>
        <div class="explore__btn">
        <a href="#Feature" class="btn">Save Time and Get More Done Now ! </a>
        </div>
    </section>

    <section class="section__container offer__container" id="service">
        <h2 class="section__header">What We <span>Offer</span></h2>
        <p class="section__description">
            Explore the Benefits and Services We Provide to Enhance Your Task Management and Achieve Your Goals
        </p>
        <div class="offer__grid">
            <div class="offer__card">
                <img src="assets/offer1.jpg" alt="offer" />
                <div class="offer__details">
                    <span>01</span>
                    <div>
                        <h4>Task Management Solutions</h4>
                        <p>
                            Efficiently manage your tasks and finances showcase your achievements.
                        </p>
                    </div>
                </div>
            </div>
            <div class="offer__card">
                <img src="assets/offer-2.jpg" alt="offer" />
                <div class="offer__details">
                    <span>02</span>
                    <div>
                        <h4>Organize & Track Progress</h4>
                        <p>Explore Customizable Categories for Organizing Links, Books, and Notes to Suit Your Needs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="offer__card">
                <img src="assets/offer-3.jpg" alt="offer" />
                <div class="offer__details">
                    <span>03</span>
                    <div>
                        <h4>Intuitive Interface</h4>
                        <p>User-friendly and easy interface with responsive design for making your day organize.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer" id="contact">
        <div class="section__container footer__container">
            <div class="footer__col">
                <div class="footer__logo">
                    <a href="#" class="logo">To<span>Trick</span></a>
                </div>
                <p>
                    Our platform is designed to help you efficiently manage your tasks and achieve your personal goals.
                </p>
            </div>
            <div class="footer__col">
                <h4>Quick Links</h4>
                <ul class="footer__links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#Feature">Features</a></li>
                    <li><a href="#service">Testimonials</a></li>
                    <li><a href="/project1/contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>Follow Us</h4>
                <ul class="footer__links">
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Youtube</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>Contact Us</h4>
                <ul class="footer__links">
                    <li>
                        <a href="#">
                            <span><i class="ri-phone-fill"></i></span> 01601819943
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span><i class="ri-map-pin-2-fill"></i></span>
                            Aust,Tejgaon,Dhaka,Bangladesh
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__bar">
            Copyright © 2024 Group-2(84,86,93). All rights reserved.
        </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="assets/main2.js"></script>
</body>

</html>