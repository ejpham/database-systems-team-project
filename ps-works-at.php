<?php
session_start();
require "db_conn_PostalService.php";
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location:sign-in.php");
    exit;
}
if ($_SESSION["access_level"] == "1") {
    header("location:index.php");
    exit;
}
$sql = "SELECT * FROM PostalService.WORKS_AT ORDER BY location_id ASC, employee_id ASC";
if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
    if (mysqli_stmt_execute($stmt)) mysqli_stmt_bind_result($stmt, $emp_id, $loc_id, $emp_date);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_stmt_close($stmt);
    if ($_POST["action"] == "add") {
        $emp_id = trim($_POST["emp_id"]);
        $loc_id = trim($_POST["loc_id"]);
        $run = "INSERT INTO PostalService.WORKS_AT (employee_id, location_id) VALUES (?, ?);";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "ii", $emp_id, $loc_id);
            if (mysqli_stmt_execute($stmt));
        }
    }
    else if ($_POST["action"] == "update") {
        $emp_id = trim($_POST["emp_id"]);
        $loc_id = trim($_POST["loc_id"]);
        $run = "UPDATE PostalService.WORKS_AT SET location_id = ?, employment_date = (curdate()) WHERE employee_id = ?";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "ii", $emp_id, $loc_id);
            if (mysqli_stmt_execute($stmt));
        }
    }
    else if ($_POST["action"] == "delete") {
        $emp_id = trim($_POST["emp_id"]);
        $run = "DELETE FROM PostalService.WORKS_AT WHERE employee_id = ?;";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $emp_id);
            if (mysqli_stmt_execute($stmt));
        }
    }
    header("refresh:0;");
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
        
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }
        
        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }
    </style>
    <link href="headers.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="m-4">
            <nav class="navbar navbar-expand-sm navbar-light rounded" style="background-color: #e3f2fd;">
                <div class="container-fluid">
                    <ul class="nav navbar-nav me-auto">
                        <span id="name" class="nav-item">Logged in as: <?php echo $_SESSION["name"] ?></span>
                        <span id="name" class="nav-item">, Employee ID: <?php echo $_SESSION["employee_id"] ?></span>
                        <span id="name" class="nav-item">, Access Level: <?php if ($_SESSION["access_level"] == "3") echo 'Manager'; else echo 'Employee'; ?></span>
                    </ul>
                    <span class="navbar-brand mx-auto">Postal Service</span>
                    <ul class="nav navbar-nav ms-auto">
                        <a href="sign-out.php" class="nav-item nav-link">Sign Out</a>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="m-4 row">
            <div class="col-auto">
                <div class="flex-column flex-shrink-0 p-3 rounded" style="width: 14rem; background-color: #e3f2fd;">
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
                        <?php if ($_SESSION["access_level"] == "3") { ?>
                            <li class="mb-1">
                                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#reports-collapse" aria-expanded="true">
                                    Reports
                                </button>
                                <div class="collapse show" id="reports-collapse">
                                    <ul class="btn-toggle-van list-unstyled fw-normal pb-1 small">
                                        <li><a href="rp-employee-hours-worked.php" class="nav-item nav-link rounded">Employee Hours</a></li>
                                        <li><a href="rp-number-of-employees.php" class="nav-item nav-link rounded">Number of Employees at Location</a></li>
                                        <li><a href="rp-packages-sent-out.php" class="nav-item nav-link rounded">Packages Sent Out</a></li>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col">
                <a href="ps-employees.php"><button class="btn btn-outline-primary">Back</button></a>
                <h6 class="display-6">Employee Works At</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped table-hover table-sm align-middle">
                        <thead>
                            <th scope="col">Emp. ID</th>
                            <th scope="col">Loc. ID</th>
                            <th scope="col">Employment Date</th>
                            <?php if ($_SESSION["access_level"] == "3") { ?><th scope="col"></th><?php } ?>
                        </thead>
                        <tbody>
                            <?php if ($_SESSION["access_level"] == "3") { ?>
                                <tr>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="action" value="add">
                                        <td><input type="number" name="emp_id" class="form-control" min="1" placeholder="Employee ID"></td>
                                        <td><input type="number" name="loc_id" class="form-control" min="1" placeholder="Location ID"></td>
                                        <td></td>
                                        <td>
                                            <input type="submit" class="btn btn-primary align-self-start" value="Add">
                                        </td>
                                    </form>
                                </tr>
                            <?php } ?>
                            <?php while (mysqli_stmt_fetch($stmt)) { ?>
                                <tr>
                                    <td><?php echo $emp_id; ?></td>
                                    <?php if ($_SESSION["access_level"] == "3") { ?>
                                        <td>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                                <div class="input-group">
                                                    <input type="number" name="loc_id" class="form-control" value="<?php echo $loc_id; ?>" min="1">
                                                    <input type="submit" class="btn btn-outline-primary" value="Update">
                                                </div>
                                            </form>
                                        </td>
                                    <?php } else { ?>
                                        <td><?php echo $loc_id; ?></td>
                                    <?php } ?>
                                    <td><?php echo $emp_date; ?></td>
                                    <?php if ($_SESSION["access_level"] == "3") { ?>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                        <td><input type="submit" class="btn btn-danger" value="Delete"></td>
                                    </form>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
