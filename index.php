<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Post Office</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <!--Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">Postal Office</a>
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="mail.php" class="nav-item nav-link">Mail</a>
                <a href="pricing.php" class="nav-item nav-link">Pricing</a>
                <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account</a>
                    <div class="dropdown-menu">
                        <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                            <a href="my-account.php" class="dropdown-item">My Account</a>
                            <a href="database-access.php" class="dropdown-item">Database Access</a>
                            <a href="sign-out.php" class="dropdown-item">Sign Out</a>
                        <?php } else { ?>
                            <a href="sign-in.php" class="dropdown-item">Sign In</a>
                            <a href="sign-up.php" class="dropdown-item">Sign Up</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
        <br/>
        <div class="container-fluid text-center">
            <h1 class="display-1"><b>Team 3 Postal Service</b></h1>
            <h6 class="display-6"><small class="text-muted">COSC 3380 Database Project</small></h6>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
