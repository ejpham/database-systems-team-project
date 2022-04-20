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
if ($_SESSION["access_level"] == "2") {
    header("location:database-access.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["emp_id"]))) $emp_id_err = '<div class="alert alert-danger" role="alert">Please enter an employee ID.</div>';
    else $emp_id = trim($_POST["emp_id"]);
    if (empty(trim($_POST["from_date"])) && !empty(trim($_POST["to_date"]))) $from_date_err = '<div class="alert alert-danger" role="alert">Please enter a from date.</div>';
    else if (!empty(trim($_POST["from_date"])) && empty(trim($_POST["to_date"]))) $to_date_err = '<div class="alert alert-danger" role="alert">Please enter a to date.</div>';
    else if (!empty(trim($_POST["from_date"])) && !empty(trim($_POST["to_date"]))) {
        $from_date = trim($_POST["from_date"]);
        $to_date = trim($_POST["to_date"]);
        $sql1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(shift_end , shift_start)))) FROM PostalService.Employee_Shift WHERE employee_id = ? AND DATE(?) <= DATE(shift_start) AND DATE(?) >= DATE(shift_end)";
        $sql2 = "SELECT * FROM PostalService.Employee_Shift WHERE employee_id = ? AND DATE(?) <= DATE(shift_start) AND DATE(?) >= DATE(shift_end)";
    }
    else {
        $sql1 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(shift_end , shift_start)))) FROM PostalService.Employee_Shift WHERE employee_id = ?;";
        $sql2 = "SELECT * FROM PostalService.Employee_Shift WHERE employee_id = ?";
    }
    if (empty($emp_id_err) && empty($from_date_err) && empty($to_date_err)) {
        if ($stmt1 = mysqli_prepare($conn_PostalService, $sql1)) {
            if (!empty($from_date) && !empty($to_date)) mysqli_stmt_bind_param($stmt1, "iss", $emp_id, $from_date, $to_date);
            else mysqli_stmt_bind_param($stmt1, "i", $emp_id);
            if (mysqli_stmt_execute($stmt1)) {
                mysqli_stmt_bind_result($stmt1, $total);
                mysqli_stmt_fetch($stmt1);
                $showtotal = '<p>Total Hours Worked: '.$total.'</p>';
                mysqli_stmt_close($stmt1);
            }
        }
        if ($stmt2 = mysqli_prepare($conn_PostalService, $sql2)) {
            if (!empty($from_date) && !empty($to_date)) mysqli_stmt_bind_param($stmt2, "iss", $emp_id, $from_date, $to_date);
            else mysqli_stmt_bind_param($stmt2, "i", $emp_id);
            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_bind_result($stmt2, $shift_id, $new_emp_id, $shift_start, $shift_end);
                $showtable = '
                <div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped table-sm align-middle caption-top">
                        <caption>'.$showtotal.'</caption>
                        <thead>
                            <th scope="col">Shift ID</th>
                            <th scope="col">Employee ID</th>
                            <th scope="col">Shift Start</th>
                            <th scope="col">Shift End</th>
                        </thead>
                        <tbody>';
                while (mysqli_stmt_fetch($stmt2)) {
                    $showtable .= '<tr><td>';
                    $showtable .= $shift_id;
                    $showtable .= '</td><td>';
                    $showtable .= $new_emp_id;
                    $showtable .= '</td><td>';
                    $showtable .= $shift_start;
                    $showtable .= '</td><td>';
                    $showtable .= $shift_end;
                    $showtable .= '</td></tr>';
                }
                $showtable .= '</tbody></table></div>';
                mysqli_stmt_close($stmt2);
            }
        }
    }
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
        <div class="m-4 d-print-none">
            <nav class="navbar navbar-expand-sm navbar-light rounded" style="background-color: #e3f2fd;">
                <div class="container-fluid">
                    <ul class="nav navbar-nav me-auto">
                        <span id="name" class="nav-item">Logged in as: <?php echo $_SESSION["name"] ?></span>
                        <span id="name" class="nav-item">, Employee ID: <?php echo $_SESSION["employee_id"] ?></span>
                        <span id="name" class="nav-item">, Access Level: <?php if ($_SESSION["access_level"] == "3") echo 'Manager'; else echo 'Employee'; ?></span>
                    </ul>
                    <span class="navbar-brand mx-auto">Reports</span>
                    <ul class="nav navbar-nav ms-auto">
                        <a href="sign-out.php" class="nav-item nav-link">Sign Out</a>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="m-4 row">
            <div class="col-auto d-print-none">
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
                <h6 class="display-6">Total Employee Hours Worked</h6>
                <?php
                    echo $emp_id_err;
                    echo $from_date_err;
                    echo $to_date_err;
                    echo $err;
                ?>
                <div class="m-3 d-print-none">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="input-group">
                            <a href=""><button type="button" class="btn btn-outline-secondary">Refresh</button></a>
                            <span class="input-group-text">Employee ID</span>
                            <input type="number" name="emp_id" class="form-control" value="<?php echo $emp_id; ?>" min="1" placeholder="Employee ID">
                            <span class="input-group-text">From Date</span>
                            <input type="date" name="from_date" class="form-control" value="<?php echo $from_date; ?>" id="datePickerID1">
                            <span class="input-group-text">To Date</span>
                            <input type="date" name="to_date" class="form-control" value="<?php echo $to_date; ?>" id="datePickerID2">
                            <input type="submit" class="btn btn-outline-primary" value="Generate">
                        </div>
                    </form>
                </div>
                <?php
                    echo $showtable;
                ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        datePickerID1.max = new Date().toLocaleDateString('en-ca');
        datePickerID2.max = new Date().toLocaleDateString('en-ca');
    </script>
</body>
</html>
