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
if ($stmt = mysqli_prepare($conn_PostalService, "SELECT * FROM PostalService.Employee_Shift")) {
    try {
        if (mysqli_stmt_execute($stmt)) mysqli_stmt_bind_result($stmt, $shift_id, $emp_id, $shift_start, $shift_end);
        $shifts = array();
        while (mysqli_stmt_fetch($stmt)) {
            $row = array($shift_id, $emp_id, $shift_start, $shift_end);
            array_push($shifts, $row);
        }
        mysqli_stmt_close($stmt);
    }
    catch (mysqli_sql_exception $e) {}
}
if ($stmt_select_employee = mysqli_prepare($conn_PostalService, "SELECT employee_id, first_name, last_name FROM PostalService.Employee")) {
    try {
        if (mysqli_stmt_execute($stmt_select_employee)) {
            mysqli_stmt_store_result($stmt_select_employee);
            mysqli_stmt_bind_result($stmt_select_employee, $emp_id, $fname, $lname);
            $results = array();
            while (mysqli_stmt_fetch($stmt_select_employee)) {
                $row = array($emp_id, $fname, $lname);
                array_push($results, $row);
            }
            mysqli_stmt_close($stmt_select_employee);
        }
    }
    catch (mysqli_sql_exception $e) {}
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_stmt_close($stmt);
    if ($_POST["action"] == "add") {
        $emp_id = trim($_POST["emp_id"]);
        $run = "INSERT INTO PostalService.Employee_Shift (employee_id) VALUES (?);";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $emp_id);
            try {
                if (mysqli_stmt_execute($stmt));
            }
            catch (mysqli_sql_exception $e) {}
        }
    }
    else if ($_POST["action"] == "update") {
        $shift_id = trim($_POST["shift_id"]);
        $run = "UPDATE PostalService.Employee_Shift SET shift_end = now() WHERE shift_id = ?";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $shift_id);
            try {
                if (mysqli_stmt_execute($stmt));
            }
            catch (mysqli_sql_exception $e) {}
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
                <h6 class="display-6">Employee Shift</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped table-hover table-sm align-middle">
                        <thead>
                            <th scope="col">Shift ID</th>
                            <th scope="col">Emp. ID</th>
                            <th scope="col">Shift Start</th>
                            <th scope="col">Shift End</th>
                            <th scope="col"></th>
                        </thead>
                        <tbody>
                            <tr>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="action" value="add">
                                    <td></td>
                                    <td>
                                        <?php if ($_SESSION["access_level"] == "3") { ?>
                                            <select class="form-select" name="employee">
                                                <option selected disabled>Employees</option>
                                                <?php for ($i = 0; $i < sizeof($results); $i++) { ?>
                                                    <option value="<?php echo $results[$i][0]; ?>"><?php echo $results[$i][1].' '.$results[$i][2].' (ID: '.$results[$i][0].')'; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <input type="number" name="emp_id" class="form-control-plaintext" min="1" value="<?php echo $_SESSION["employee_id"]; ?>" readonly>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="submit" class="btn btn-success align-self-start" value="Clock In">
                                    </td>
                                </form>
                            </tr>
                            <?php for ($i = 0; $i < sizeof($shifts); $i++) { ?>
                                <tr>
                                    <?php if ($_SESSION["access_level"] == "2") { // employee
                                        if ($_SESSION["employee_id"] == $shifts[$i][1]) { // only show shifts for that employee
                                            if ($shift_end == "") { // shift not over ?>
                                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                    <input type="hidden" name="action" value="update">
                                                    <input type="hidden" name="shift_id" value="<?php echo $shift_id; ?>">
                                                    <td><?php echo $shifts[$i][0]; ?></td>
                                                    <td><?php echo $shifts[$i][1]; ?></td>
                                                    <td><?php echo $shifts[$i][2]; ?></td>
                                                    <td><?php echo $shifts[$i][3]; ?></td>
                                                    <td><input class="btn btn-warning align-self-start" type="submit" value="Clock Out"></td>
                                                </form>
                                            <?php }
                                            else { // old shifts ?>
                                                <td><?php echo $shifts[$i][0]; ?></td>
                                                <td><?php echo $shifts[$i][1]; ?></td>
                                                <td><?php echo $shifts[$i][2]; ?></td>
                                                <td><?php echo $shifts[$i][3]; ?></td>
                                                <td></td>
                                            <?php }
                                        }
                                    } else { // manager
                                        if ($shift_end == "") { // shift not over ?>
                                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="shift_id" value="<?php echo $shift_id; ?>">
                                                <td><?php echo $shifts[$i][0]; ?></td>
                                                <td><?php echo $shifts[$i][1]; ?></td>
                                                <td><?php echo $shifts[$i][2]; ?></td>
                                                <td><?php echo $shifts[$i][3]; ?></td>
                                                <td><input class="btn btn-warning align-self-start" type="submit" value="Clock Out"></td>
                                            </form>
                                        <?php }
                                        else { // old shifts ?>
                                            <td><?php echo $shifts[$i][0]; ?></td>
                                            <td><?php for ($j = 0; $j < sizeof($results); $j++) {
                                                if ($shifts[$i][1] == $results[$j][0]) echo $results[$j][1].' '.$results[$j][2];
                                            }
                                            ?></td>
                                            <td><?php echo $shifts[$i][2]; ?></td>
                                            <td><?php echo $shifts[$i][3]; ?></td>
                                            <td></td>
                                        <?php }
                                    } ?>
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
