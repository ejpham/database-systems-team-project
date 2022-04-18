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
$sql = "SELECT * FROM PostalService.MailOrders ORDER BY order_id DESC";
if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $order_id, $tracking_number, $status, $package_size, $package_weight, $billing, $email);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_stmt_close($stmt);
    $order_id = trim($_POST["order_id"]);
    $status = trim($_POST["status"]);
    $run = "UPDATE PostalService.MailOrders SET status = ? WHERE order_id = ?;";
    if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
        mysqli_stmt_execute($stmt);
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
                        <li class="mb-1">
                            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#reports-collapse" aria-expanded="true">
                                Reports
                            </button>
                            <div class="collapse show" id="reports-collapse">
                                <ul class="btn-toggle-van list-unstyled fw-normal pb-1 small">
                                    <li><a href="rp-employee-hours-worked.php" class="nav-item nav-link rounded">Employee Hours</a></li>
                                    <li><a href="rp-number-of-employees.php" class="nav-item nav-link rounded">Number of Employees at Location</a></li>
                                    <li><a href="rp-miles-driven-by-vehicle.php" class="nav-item nav-link rounded">Packages Sent Out</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col">
                <h6 class="display-6">Mail Orders</h6>
                <table class="table table-bordered table-primary table-hover align-middle">
                    <thead>
                        <th scope="col">Order ID</th>
                        <th scope="col">Tracking Number</th>
                        <th scope="col">Status</th>
                        <th scope="col">Package Size</th>
                        <th scope="col">Package Weight</th>
                        <th scope="col">Billing Address</th>
                        <th scope="col">Sender's E-mail</th>
                    </thead>
                    <tbody>
                        <?php while (mysqli_stmt_fetch($stmt)) { ?>
                        <tr>
                            <td><?php echo $order_id; ?></td>
                            <td><?php echo $tracking_number; ?></td>
                            <td>
                                <?php if ($status == "Delivered") { echo $status; } else { ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                    <div class="input-group">
                                        <select type="text" class="form-select" name="status" value="<?php echo $status; ?>">
                                            <?php if ($status == "Label Created") { ?>
                                                <option value="Label Created" selected disabled>Label Created</option>
                                                <option value="Processing">Processing</option>
                                                <option value="In Transit">In Transit</option>
                                                <option value="Out for Delivery">Out for Delivery</option>
                                                <option value="Delivered">Delivered</option>
                                            <?php } else if ($status == "Processing") { ?>
                                                <option value="Label Created" disabled>Label Created</option>
                                                <option value="Processing" selected disabled>Processing</option>
                                                <option value="In Transit">In Transit</option>
                                                <option value="Out for Delivery">Out for Delivery</option>
                                                <option value="Delivered">Delivered</option>
                                            <?php } else if ($status == "In Transit") { ?>
                                                <option value="Label Created" disabled>Label Created</option>
                                                <option value="Processing">Processing</option>
                                                <option value="In Transit" selected disabled>In Transit</option>
                                                <option value="Out for Delivery">Out for Delivery</option>
                                                <option value="Delivered">Delivered</option>
                                            <?php } else if ($status == "Out for Delivery") { ?>
                                                <option value="Label Created" disabled>Label Created</option>
                                                <option value="Processing">Processing</option>
                                                <option value="In Transit">In Transit</option>
                                                <option value="Out for Delivery" selected disabled>Out for Delivery</option>
                                                <option value="Delivered">Delivered</option>
                                            <?php } ?>
                                        </select>
                                        <input type="submit" class="btn btn-outline-primary" value="Update">
                                    </div>
                                </form>
                                <?php } ?>
                            </td>
                            <td><?php echo $package_size; ?></td>
                            <td><?php echo $package_weight; ?></td>
                            <td><?php echo $billing; ?></td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="m-4 row justify-content-center">
            <div class="col-auto">
                <a href="ps-mail.php"><button class="btn btn-outline-primary">Back</button></a>
            </div>
        </div>
        <div class="m-4 row justify-content-start">
            <div class="col-auto">
                <label>Status:</label>
                <ul>
                    <li>Label Created</li>
                    <li>Processing</li>
                    <li>In Transit</li>
                    <li>Out for Delivery</li>
                    <li>Delivered</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
