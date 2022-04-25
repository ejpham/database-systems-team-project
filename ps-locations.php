<?php
session_start();
require "db_conn_PostalService.php";
$newAdd = $newCity = $newState = $newZip = $newDept = "";
$success = $error = "";
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("location:sign-in.php");
    exit;
}
if ($_SESSION["access_level"] == "1") {
    header("location:index.php");
    exit;
}

$sql = "SELECT location_id, location_address, location_city, location_state, location_zipcode, location_dept FROM PostalService.Location ORDER BY location_id ASC";
if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
    try {
        if (mysqli_stmt_execute($stmt)) mysqli_stmt_bind_result($stmt, $location_id, $location_address, $location_city, $location_state, $location_zipcode, $location_dept);
    }
    catch (mysqli_sql_exception $e) {}
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    mysqli_stmt_close($stmt);
    if ($_POST["action"] == "add") {
        if(!empty(trim($_POST["Address"])))
            $location_address = trim($_POST["Address"]);
        if(!empty(trim($_POST["City"])))
            $location_city = trim($_POST["City"]);
        if(trim($_POST["Address"]) != "State")
            $location_state = trim($_POST["State"]);
        if(!empty(trim($_POST["Zip"])))
            $location_zipcode = trim($_POST["Zip"]);
        if(!empty(trim($_POST["Department"])))
            $location_dept = trim($_POST["Department"]);
        if(!empty($location_address) && !empty($location_city) && !empty($location_state) && !empty($location_zipcode) && !empty($location_dept)){
            $run = "INSERT INTO PostalService.Location (location_address, location_city, location_state, location_zipcode, location_dept) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
                mysqli_stmt_bind_param($stmt, "sssss", $location_address, $location_city, $location_state, $location_zipcode, $location_dept);
                try {
                    if (mysqli_stmt_execute($stmt));
                }
                catch (mysqli_sql_exception $e) {}
            }
        }
    }
    else if ($_POST["action"] == "delete") {
        $location_id = $_POST["location_id"];
        $run = "DELETE FROM PostalService.Location WHERE location_id = ?";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $location_id);
            try {
                mysqli_stmt_execute($stmt);
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
                    <span class="navbar-brand mx-auto">Postal Service Locations</span>
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
                <h6 class="display-6">Locations</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped table-hover table-sm align-middle">
                        <thead>
                            <th scope="col">Loc. ID</th>
                            <th scope="col">Address</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <th scope="col">Zip Code</th>
                            <th scope="col">Department</th>
                            <?php if ($_SESSION["access_level"] == "3") { ?>
                            <th></th>
                            <?php } ?>
                        </thead>
                        <tbody>
                            <?php if ($_SESSION["access_level"] == "3") { ?>
                                <tr>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="action" value="add">
                                        <td></td>
                                        <td><input type="text" name="Address" class="form-control" placeholder="Address"></td>
                                        <td><input type="text" name="City" class="form-control" placeholder="City"></td>
                                        <td>
                                        <select class="form-select" type = "text" name = "State">
                                                <option value = "">State</option>
                                                <option value="AL">AL</option>
                                                <option value="AK">AK</option>
                                                <option value="AR">AR</option>	
                                                <option value="AZ">AZ</option>
                                                <option value="CA">CA</option>
                                                <option value="CO">CO</option>
                                                <option value="CT">CT</option>
                                                <option value="DC">DC</option>
                                                <option value="DE">DE</option>
                                                <option value="FL">FL</option>
                                                <option value="GA">GA</option>
                                                <option value="HI">HI</option>
                                                <option value="IA">IA</option>
                                                <option value="ID">ID</option>
                                                <option value="IL">IL</option>
                                                <option value="IN">IN</option>
                                                <option value="KS">KS</option>
                                                <option value="KY">KY</option>
                                                <option value="LA">LA</option>
                                                <option value="MA">MA</option>
                                                <option value="MD">MD</option>
                                                <option value="ME">ME</option>
                                                <option value="MI">MI</option>
                                                <option value="MN">MN</option>
                                                <option value="MO">MO</option>	
                                                <option value="MS">MS</option>
                                                <option value="MT">MT</option>
                                                <option value="NC">NC</option>	
                                                <option value="NE">NE</option>
                                                <option value="NH">NH</option>
                                                <option value="NJ">NJ</option>
                                                <option value="NM">NM</option>			
                                                <option value="NV">NV</option>
                                                <option value="NY">NY</option>
                                                <option value="ND">ND</option>
                                                <option value="OH">OH</option>
                                                <option value="OK">OK</option>
                                                <option value="OR">OR</option>
                                                <option value="PA">PA</option>
                                                <option value="RI">RI</option>
                                                <option value="SC">SC</option>
                                                <option value="SD">SD</option>
                                                <option value="TN">TN</option>
                                                <option value="TX">TX</option>
                                                <option value="UT">UT</option>
                                                <option value="VT">VT</option>
                                                <option value="VA">VA</option>
                                                <option value="WA">WA</option>
                                                <option value="WI">WI</option>	
                                                <option value="WV">WV</option>
                                                <option value="WY">WY</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="Zip" class="form-control" placeholder="Zip code" maxlength = "5"></td>
                                        <td><input type="text" name="Department" class="form-control" placeholder="Department"></td>
                                        <td><input type="submit" class="btn btn-primary" value="Add"></td>
                                    </form>
                                </tr>
                            <?php } ?>
                            <?php while (mysqli_stmt_fetch($stmt)) { ?>
                            <tr>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
                                    <td><?php echo $location_id; ?></td>
                                    <td><?php echo $location_address; ?></td>
                                    <td><?php echo $location_city; ?></td>
                                    <td><?php echo $location_state; ?></td>
                                    <td><?php echo $location_zipcode; ?></td>
                                    <td><?php echo $location_dept; ?></td>
                                    <?php if ($_SESSION["access_level"] == "3") { ?>
                                    <td><input type="submit" class="btn btn-danger" value="Delete"></td>
                                    <?php } ?>
                                </form>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <main>
        </main>
    </div>
</body>
</html>
