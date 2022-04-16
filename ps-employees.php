<?php
session_start();
require "db_conn_PostalService.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location:sign-in.php");
    exit;
}
if ($_SESSION["is_employee"] == "1") {
    header("location:index.php");
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
    <link href="sidebars.css" rel="stylesheet">
    <script src="sidebars.js"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <link href="headers.css" rel="stylesheet">
</head>
<body>
    <div class="m-4">
        <nav class="navbar navbar-expand-sm navbar-light rounded" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <ul class="nav navbar-nav me-auto">
                    <span id="name" class="nav-item">Logged in as: <?php echo $_SESSION["name"] ?></span>
                </ul>
                <span class="navbar-brand mx-auto">Postal Service Employees</span>
                <ul class="nav navbar-nav ms-auto">
                    <a href="sign-out.php" class="nav-item nav-link">Sign Out</a>
                </ul>
            </div>
        </nav>
    </div>
    <div class="m-4">
        <div class="flex-shrink-0 p-3 rounded" style="width: 14rem; background-color: #e3f2fd;">
            <a href="database-access.php" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
                <span class="fs-5 fw-semibold">Databases</span>
            </a>
            <ul class="list-unstyled ps-0">
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#postal-service-collapse" aria-expanded="true">
                        Postal Service
                    </button>
                    <div class="collapse show" id="postal-service-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="ps-mail.php" class="nav-item nav-link rounded">Mail</a></li>
                            <li><a href="ps-employees.php" class="nav-item nav-link rounded">Employees</a></li>
                            <li><a href="ps-managers.php" class="nav-item nav-link rounded">Managers</a></li>
                            <li><a href="ps-locations.php" class="nav-item nav-link rounded">Locations</a></li>
                            <li><a href="ps-vehicles.php" class="nav-item nav-link rounded">Vehicles</a></li>
                            <li><a href="ps-contact-logs.php" class="nav-item nav-link rounded">Contact Logs</a></li>
                        </ul>
                    </div>
                </li>
                <li class="mb-1">
                    <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#web-logins-collapse" aria-expanded="true">
                        Web Logins
                    </button>
                    <div class="collapse show" id="web-logins-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="wl-users.php" class="nav-item nav-link rounded">Users</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <main>
    </main>
</body>
</html>
