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
$sql = "SELECT * FROM PostalService.Employee";
if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $emp_id, $fname, $minit, $lname, $dob, $addr, $city, $zip, $email, $pnum, $ssn, $m_id);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_stmt_close($stmt);
    if ($_POST["action"] == "add") {
        $fname = trim($_POST["fname"]);
        $minit = trim($_POST["minit"]);
        $lname = trim($_POST["lname"]);
        $dob = trim($_POST["dob"]);
        $addr = trim($_POST["address"]);
        $city = trim($_POST["city"]);
        $zip = trim($_POST["zip"]);
        $email = trim($_POST["email"]);
        $pnum = trim($_POST["phone_num"]);
        $ssn = trim($_POST["ssn"]);
        $run = "INSERT INTO PostalService.Employee (first_name, minit, last_name, dob, home_address, home_city, home_zipcode, email, phone_number, ssn) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "ssssssssss", $fname, $minit, $lname, $dob, $addr, $city, $zip, $email, $pnum, $ssn);
            mysqli_stmt_execute($stmt);
        }
    }
    else if ($_POST["action"] == "delete") {
        $emp_id = trim($_POST["emp_id"]);
        $run = "DELETE FROM PostalService.Employee WHERE employee_id = ?";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $emp_id);
            mysqli_stmt_execute($stmt);
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
                    </ul>
                </div>
            </div>
            <div class="col">
                <h6 class="display-6">Employees</h6>
                <table class="table table-bordered table-primary table-hover">
                    <thead>
                        <th scope="col">Employee ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Middle Init.</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Date of Birth</th>
                        <th scope="col">Home Address</th>
                        <th scope="col">City</th>
                        <th scope="col">Zip Code</th>
                        <th scope="col">E-mail Address</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">SSN</th>
                        <th scope="col">Manager ID</th>
                        <?php if ($_SESSION["is_employee"] == "3") { ?><th scope="col"></th><?php } ?>
                    </thead>
                    <tbody>
                        <?php if ($_SESSION["is_employee"] == "3") { ?>
                            <tr>
                                <form method="post" action="">
                                    <input type="hidden" name="action" value="add">
                                    <td></td>
                                    <td><input class="form-control" type="text" name="fname" maxlength="30"></td>
                                    <td><input class="form-control" type="text" name="minit" maxlength="1" oninput="this.value = this.value.toUpperCase();"></td>
                                    <td><input class="form-control" type="text" name="lname" maxlength="30"></td>
                                    <td><input class="form-control" type="date" name="dob"></td>
                                    <td><input class="form-control" type="text" name="address" maxlength="255"></td>
                                    <td><input class="form-control" type="text" name="city" maxlength="50"></td>
                                    <td><input class="form-control" type="text" name="zip" maxlength="5"></td>
                                    <td><input class="form-control" type="email" name="email" maxlength="75"></td>
                                    <td><input class="form-control" type="text" name="phone_num" maxlength="10"></td>
                                    <td><input class="form-control" type="text" name="ssn" maxlength="9"></td>
                                    <td></td>
                                    <td><input type="submit" name="submit" class="btn btn-primary" value="Add"></td>
                                </form>
                            </tr>
                        <?php } else {} ?>
                        <?php while (mysqli_stmt_fetch($stmt)) { ?>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $emp_id; } ?></td>
                                <td><?php echo $fname; ?></td>
                                <td><?php echo $minit; ?></td>
                                <td><?php echo $lname; ?></td>
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $dob; } ?></td>
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $addr; } ?></td>
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $city; } ?></td>
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $zip; } ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $pnum; } ?></td>
                                <td><?php if ($_SESSION["is_employee"] == "3") { echo $ssn; } ?></td>
                                <td><?php echo $m_id; ?></td>
                                <?php if ($_SESSION["is_employee"] == "3") { ?><td><input type="submit" class="btn btn-outline-danger" value="Delete"></td><?php } ?>
                            </form>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
