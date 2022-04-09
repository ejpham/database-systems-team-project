<?php
session_start();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <!--Navigation-->
    <div class="m-4">
        <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <ul class="nav navbar-nav me-auto">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="mail.php" class="nav-item nav-link">Mail</a>
                    <a href="pricing.php" class="nav-item nav-link">Pricing</a>
                    <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
                </ul>
                <a href="index.php" class="navbar-brand"><span style="margin-right:7.3rem">Postal Office</style></a>
                <ul class="nav navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account Options</a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="my-account.php" class="dropdown-item">My Account</a>
                            <?php if ($_SESSION["is_employee"] === true) { ?>
                                <a href="database-access.php" class="dropdown-item">Database Access</a>
                            <?php } ?>
                            <a href="sign-out.php" class="dropdown-item">Sign Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <br/>
    <div class="container-fluid text-center">
        <h6 class="display-6"><small class="text-muted">This content is currently unavailable.</small></h6>
    </div>
</body>
</html>
