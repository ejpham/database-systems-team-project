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
} else {}

$from_date_err = $to_date_err = $err = "";
$sql1 = $sql2 = "";
$totalPrice = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["from_date"])) && !empty(trim($_POST["to_date"]))) $from_date_err = '<div class="alert alert-danger" role="alert">Please enter a from date.</div>';
    else if (!empty(trim($_POST["from_date"])) && empty(trim($_POST["to_date"]))) $to_date_err = '<div class="alert alert-danger" role="alert">Please enter a to date.</div>';
    else if (!empty(trim($_POST["from_date"])) && !empty(trim($_POST["to_date"]))) {
        $from_date = trim($_POST["from_date"]);
        $to_date = trim($_POST["to_date"]);
        $sql = "SELECT mail_type, from_address, to_address, delivered_on, shipping_cost FROM PostalService.Mail WHERE DATE(?) <= DATE(label_created) AND DATE(?) >= DATE(label_created)";
    }
    else $err = '<div class="alert alert-danger" role="alert">Please enter a from and to date.</div>';
    if (empty($from_date_err) && empty($to_date_err) && empty($err)) {
        if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $from_date, $to_date);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $mail_type, $from_address, $to_address, $delivered_on, $shipping_cost);
            $showtable = '
            <table class="table table-bordered table-primary table-hover align-middle">
                <thead>
                    <th scope="col">Mail Type</th>
                    <th scope="col">From Address</th>
                    <th scope="col">To Address</th>
                    <th scope="col">Delivered On</th>
                </thead>
                <tbody>';
            while (mysqli_stmt_fetch($stmt)) {
                $totalPrice = $totalPrice + $shipping_cost;
                $showtable .= '<tr><td>';
                $showtable .= $mail_type;
                $showtable .= '</td><td>';
                $showtable .= $from_address;
                $showtable .= '</td><td>';
                $showtable .= $to_address;
                $showtable .= '</td><td>';
                $showtable .= $delivered_on;
                $showtable .= '</td></tr>';
            }
            $showtable .= '</tbody></table>';
            mysqli_stmt_close($stmt);
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
                    </ul>
                </div>
            </div>
            <div class="col">
                <h6 class="display-6">Packages Sent Out</h6>
                <?php
                    echo $from_date_err;
                    echo $to_date_err;
                    echo $err;
                ?>
                <div class="m-3 d-print-none">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="input-group">
                        <a href=""><button type="button" class="btn btn-outline-secondary">Refresh</button></a>
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
                    echo "Total Revenue From This Period: " . $totalPrice;
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
