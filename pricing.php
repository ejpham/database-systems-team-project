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
                    <a href="pricing.php" class="nav-item nav-link active">Pricing</a>
                    <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
                </ul>
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                    <a href="index.php" class="navbar-brand"><span style="margin-right:7.3rem">Postal Office</style></a>
                <?php } else { ?>
                    <a href="index.php" class="navbar-brand"><span style="margin-right:7.8rem">Postal Office</style></a>
                <?php } ?>
                <ul class="nav navbar-nav ms-auto">
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account Options</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if ($_SESSION["is_employee"] >= "1") { ?>
                                    <a href="database-access.php" class="dropdown-item">Database Access</a>
                                <?php } ?>
                                <a href="my-account.php" class="dropdown-item">My Account</a>
                                <a href="sign-out.php" class="dropdown-item">Sign Out</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <a href="sign-in.php" class="nav-item nav-link">Sign In</a>
                        <a href="sign-up.php" class="nav-item nav-link">Sign Up</a>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Pricing</h6>
                <p><b>Mail</b></p>
                <ul style = "list-style-type:square">
                    <li>Fast: $3</li>
                    <li>Express: $6</li>
                </ul>
                <p><b>Packages Based on size</b></p>
                <ul style = "list-style-type:square">
                    <li>8 x 8 x 6: $6</li>
                    <li>8 x 8 x 8: $7</li>
                    <li>10 x 8 x 6: $8</li>
                    <li>12 x 6 x 6: $9</li>
                    <li>12 x 9 x 3: $10</li>
                    <li>12 x 9 x 4: $11</li>
                    <li>12 x 10 x 4: $12</li>
                    <li>12 x 12 x 3: $13</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
