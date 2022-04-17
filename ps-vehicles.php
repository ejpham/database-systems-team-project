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
$sql = "SELECT * FROM PostalService.Company_Vehicle";
if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $veh_id, $miles, $cost, $type);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_stmt_close($stmt);
    if ($_POST["action"] == "add") {
        $miles = trim($_POST["miles"]);
        $cost = trim($_POST["cost"]);
        $type = trim($_POST["type"]);
        $run = "INSERT INTO PostalService.Company_Vehicle (vehicle_miles, vehicle_cost, vehicle_type) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "ids", $miles, $cost, $type);
            mysqli_stmt_execute($stmt);
        }
    }
    else if ($_POST["action"] == "delete") {
        $veh_id = $_POST["veh_id"];
        $run = "DELETE FROM PostalService.Company_Vehicle WHERE vehicle_id = ?";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $veh_id);
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
                <h6 class="display-6">Vehicles</h6>
                <table class="table table-bordered table-primary table-hover">
                    <thead>
                        <th scope="col">Vehicle ID</th>
                        <th scope="col">Vehicle Miles</th>
                        <th scope="col">Vehicle Cost</th>
                        <th scope="col">Vehicle Type</th>
                        <th scope="col"></th>
                    </thead>
                    <tbody>
                        <tr>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="action" value="add">
                                <td></td>
                                <td><input type="number" name="miles" class="form-control" min="0" placeholder="Vehicle Mileage"></td>
                                <td><input type="currency" name="cost" class="form-control" placeholder="Vehicle Cost"></td>
                                <td><input type="text" name="type" class="form-control" placeholder="Vehicle Type"></td>
                                <td><input type="submit" class="btn btn-primary" value="Add"></td>
                            </form>
                        </tr>
                        <?php while (mysqli_stmt_fetch($stmt)) { ?>
                            <tr>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="veh_id" value="<?php echo $veh_id; ?>">
                                    <td><?php echo $veh_id; ?></td>
                                    <td><?php echo $miles; ?></td>
                                    <td><?php echo $cost; ?></td>
                                    <td><?php echo $type; ?></td>
                                    <td><input type="submit" class="btn btn-outline-danger" value="Delete"></td>
                                </form>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="m-4 row justify-content-center">
            <div class="col-auto">
                <a href="ps-vehicle-use.php"><button class="btn btn-outline-primary">Vehicle Use</button></a>
            </div>
        </div>
    </div>
</body>
</html>
