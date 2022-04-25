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
if ($stmt_select_location = mysqli_prepare($conn_PostalService, "SELECT location_id, location_city, location_state, location_zipcode, location_dept FROM PostalService.Location")) {
    if (mysqli_stmt_execute($stmt_select_location)) {
        mysqli_stmt_store_result($stmt_select_location);
        mysqli_stmt_bind_result($stmt_select_location, $loc_id, $loc_city, $loc_state, $loc_zip, $loc_dept);
        $results = array();
        while (mysqli_stmt_fetch($stmt_select_location)) {
            $row = array($loc_id, $loc_city, $loc_state, $loc_zip, $loc_dept);
            array_push($results, $row);
        }
        mysqli_stmt_close($stmt_select_location);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["location"]))) $loc_id_err = '<div class="alert alert-danger" role="alert">Please select a location.</div>';
    else $loc_id = trim($_POST["location"]);
    $sql1 = "SELECT COUNT(*) FROM PostalService.WORKS_AT WHERE location_id = ?";
    $sql2 = "SELECT PostalService.Employee.employee_id, first_name, last_name, manager_id, PostalService.WORKS_AT.employment_date FROM PostalService.Employee, PostalService.WORKS_AT WHERE PostalService.WORKS_AT.employee_id = PostalService.Employee.employee_id AND PostalService.WORKS_AT.location_id = ?";
    if (empty($loc_id_err)) {
        if ($stmt1 = mysqli_prepare($conn_PostalService, $sql1)) {
            mysqli_stmt_bind_param($stmt1, "i", $loc_id);
            if (mysqli_stmt_execute($stmt1)) {
                mysqli_stmt_bind_result($stmt1, $total);
                mysqli_stmt_fetch($stmt1);
                for ($i = 0; $i < sizeof($results); $i++) {
                    if ($results[$i][0] == $loc_id) {
                        $loc_city = $results[$i][1];
                        $loc_state = $results[$i][2];
                        $loc_zip = $results[$i][3];
                        $loc_dept = $results[$i][4];
                    }
                }
                $showtotal = '<p>Total Employees at '.$loc_dept.' (ID: '.$loc_id.') in '.$loc_city.', '.$loc_state.' '.$loc_zip.': '.$total.'</p>';
                mysqli_stmt_close($stmt1);
            }
        }
        if ($stmt2 = mysqli_prepare($conn_PostalService, $sql2)) {
            mysqli_stmt_bind_param($stmt2, "i", $loc_id);
            if (mysqli_stmt_execute($stmt2)) {
                mysqli_stmt_bind_result($stmt2, $emp_id, $fname, $lname, $man_id, $emp_date);
                $showtable = '
                <div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped table-sm align-middle caption-top">
                        <caption>'.$showtotal.'</caption>
                        <thead>
                            <th scope="col">Employee ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Manager ID</th>
                            <th scope="col">Employment Date</th>
                        </thead>
                        <tbody>';
                while (mysqli_stmt_fetch($stmt2)) {
                    $showtable .= '<tr><td>';
                    $showtable .= $emp_id;
                    $showtable .= '</td><td>';
                    $showtable .= $fname;
                    $showtable .= '</td><td>';
                    $showtable .= $lname;
                    $showtable .= '</td><td>';
                    $showtable .= $man_id;
                    $showtable .= '</td><td>';
                    $showtable .= $emp_date;
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
                <h6 class="display-6">Total Employees at Location</h6>
                <?php echo $loc_id_err; ?>
                <div class="m-3 d-print-none">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="input-group">
                            <a href=""><button type="button" class="btn btn-outline-secondary">Refresh</button></a>
                            <span class="input-group-text">Location</span>
                            <select class="form-select" name="location">
                                <option selected disabled>Locations</option>
                                <?php for ($i = 0; $i < sizeof($results); $i++) { ?>
                                    <option value="<?php echo $results[$i][0]; ?>"><?php echo $results[$i][4].': '.$results[$i][1].', '.$results[$i][2].' '.$results[$i][3]; ?></option>
                                <?php } ?>
                            </select>
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
</body>
</html>
