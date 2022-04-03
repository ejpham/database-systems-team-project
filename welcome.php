<?php
// Initialize the session
session_start();

require db_conn_PostalService.php;

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location:sign-in.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Post Office</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class = "container">
            <!--Navigation-->
            <nav class="navbar">
                <div class="brand-name">
                    <h5>Post Office</h5>
                    <h6>Home</h6>
                </div>
                <div class="nav-items">
                    <ul class="navbar-nav">
                        <li class="nav-link"><a href="welcome.php">Home</a></li>
                        <li class="nav-link"><a href="mail.php">Mail</a></li>
                        <li class="nav-link"><a href="pricing.php">Pricing</a></li>
                        <li class="nav-link"><a href="contact-us.php">Contact Us</a></li>
                        <a href="sign-out.php"><button class="yellow-button">Sign Out</button></a>
                    </ul>
                </div>
            </nav>
        </div>
    </body>
</html>
