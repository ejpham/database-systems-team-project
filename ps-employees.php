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
$sql = "SELECT * FROM PostalService.Employee";
if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
    if (mysqli_stmt_execute($stmt)) mysqli_stmt_bind_result($stmt, $emp_id, $fname, $minit, $lname, $dob, $addr, $city, $state, $zip, $email, $pnum, $ssn, $m_id, $u_id, $strikes, $wage);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_stmt_close($stmt);
    if ($_POST["action"] == "add") {
        if (!empty(trim($_POST["fname"]))) $fname = trim($_POST["fname"]);
        $minit = trim($_POST["minit"]);
        if (!empty(trim($_POST["lname"]))) $lname = trim($_POST["lname"]);
        if (!empty(trim($_POST["dob"]))) $dob = trim($_POST["dob"]);
        if (!empty(trim($_POST["address"]))) $addr = trim($_POST["address"]);
        if (!empty(trim($_POST["city"]))) $city = trim($_POST["city"]);
        if (!empty(trim($_POST["state"]))) $state = trim($_POST["state"]);
        if (!empty(trim($_POST["zip"]))) $zip = trim($_POST["zip"]);
        if (!empty(trim($_POST["email"]))) $email = trim($_POST["email"]);
        if (!empty(trim($_POST["phone_num"])) && strlen(trim($_POST["phone_num"])) == 10) $pnum = trim($_POST["phone_num"]);
        if (!empty(trim($_POST["ssn"])) && strlen(trim($_POST["ssn"])) == 9) $ssn = trim($_POST["ssn"]);
        if (!empty(trim($_POST["wage"]))) $wage = trim($_POST["wage"]);
        if (!empty($fname) && !empty($lname) && !empty($dob) && !empty($addr) && !empty($city) && !empty($state) && !empty($zip) && !empty($email) && !empty($pnum) && !empty($ssn) && !empty($wage)){
            $run = "INSERT INTO PostalService.Employee (first_name, minit, last_name, dob, home_address, home_city, home_state, home_zipcode, email, phone_number, ssn, hourly_wage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
                mysqli_stmt_bind_param($stmt, "sssssssssssd", $fname, $minit, $lname, $dob, $addr, $city, $state, $zip, $email, $pnum, $ssn, $wage);
                try {
                    if (mysqli_stmt_execute($stmt));
                }
                catch (mysqli_sql_exception $e) {
                    
                }
            }
        }
    }
    else if ($_POST["action"] == "edit") {
        $emp_id = trim($_POST["emp_id"]);
        if (!empty(trim($_POST["fname"]))) $fname = trim($_POST["fname"]);
        $minit = trim($_POST["minit"]);
        if (!empty(trim($_POST["lname"]))) $lname = trim($_POST["lname"]);
        if (!empty(trim($_POST["dob"]))) $dob = trim($_POST["dob"]);
        if (!empty(trim($_POST["address"]))) $addr = trim($_POST["address"]);
        if (!empty(trim($_POST["city"]))) $city = trim($_POST["city"]);
        if (!empty(trim($_POST["state"]))) $state = trim($_POST["state"]);
        if (!empty(trim($_POST["zip"]))) $zip = trim($_POST["zip"]);
        if (!empty(trim($_POST["email"]))) $email = trim($_POST["email"]);
        if (!empty(trim($_POST["phone_num"])) && strlen(trim($_POST["phone_num"])) == 10) $pnum = trim($_POST["phone_num"]);
        if (!empty(trim($_POST["ssn"])) && strlen(trim($_POST["ssn"])) == 9) $ssn = trim($_POST["ssn"]);
        if (!empty(trim($_POST["wage"]))) $wage = trim($_POST["wage"]);
        if (!empty($fname) && !empty($lname) && !empty($dob) && !empty($addr) && !empty($city) && !empty($state) && !empty($zip) && !empty($email) && !empty($pnum) && !empty($ssn) && !empty($wage)){
            $run = "UPDATE PostalService.Employee SET first_name = ?, minit = ?, last_name = ?, dob = ?, home_address = ?, home_city = ?, home_state = ?, home_zipcode = ?, email = ?, phone_number = ?, ssn = ?, hourly_wage = ? WHERE employee_id = ?";
            if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
                mysqli_stmt_bind_param($stmt, "sssssssssssdi", $fname, $minit, $lname, $dob, $addr, $city, $state, $zip, $email, $pnum, $ssn, $wage, $emp_id);
                try {
                    if (mysqli_stmt_execute($stmt));
                }
                catch (mysqli_sql_exception $e) {
                    
                }
            }
        }
    }
    else if ($_POST["action"] == "delete") {
        $emp_id = trim($_POST["emp_id"]);
        $run = "DELETE FROM PostalService.Employee WHERE employee_id = ?";
        if ($stmt = mysqli_prepare($conn_PostalService, $run)) {
            mysqli_stmt_bind_param($stmt, "i", $emp_id);
            try {
                if (mysqli_stmt_execute($stmt));
            }
            catch (mysqli_sql_exception $e) {
                
            }
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
                <a href="ps-employee-shift.php"><button class="btn btn-outline-primary">Employee Shift</button></a>
                <a href="ps-works-at.php"><button class="btn btn-outline-primary">Employee Works At</button></a>
                <h6 class="display-6">Employees</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-primary table-striped table-hover table-sm align-middle">
                        <thead>
                            <?php if ($_SESSION["access_level"] == "3") { ?>
                                <th scope="col">Emp. ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">M.I.</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Home Address</th>
                                <th scope="col">City</th>
                                <th scope="col">State</th>
                                <th scope="col">Zip Code</th>
                                <th scope="col">E-mail Address</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">SSN</th>
                                <th scope="col">Man. ID</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Strikes</th>
                                <th scope="col">Hourly Wage</th>
                                <th scope="col"></th>
                            <?php } else { ?>
                                <th scope="col">Emp. ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">M.I.</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Date of Birth</th>
                                <th scope="col">Home Address</th>
                                <th scope="col">City</th>
                                <th scope="col">State</th>
                                <th scope="col">Zip Code</th>
                                <th scope="col">E-mail Address</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">SSN</th>
                                <th scope="col">Man. ID</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Strikes</th>
                                <th scope="col">Hourly Wage</th>
                            <?php } ?>
                        </thead>
                        <tbody>
                            <?php if ($_SESSION["access_level"] == "3") { ?>
                                <tr>
                                    <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="action" value="add">
                                        <td></td>
                                        <td><input class="form-control" type="text" name="fname" maxlength="30" placeholder="First Name"></td>
                                        <td><input class="form-control" type="text" name="minit" maxlength="1" oninput="this.value = this.value.toUpperCase();" placeholder="M.I."></td>
                                        <td><input class="form-control" type="text" name="lname" maxlength="30" placeholder="Last Name"></td>
                                        <td><input class="form-control" type="date" name="dob"></td>
                                        <td><input class="form-control" type="text" name="address" maxlength="255" placeholder="Address"></td>
                                        <td><input class="form-control" type="text" name="city" maxlength="50" placeholder="City"></td>
                                        <td>
                                            <select class="form-select" type="text" name="state">
                                                <option value="">State</option>
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
                                        <td><input class="form-control" type="text" name="zip" maxlength="5" placeholder="Zip Code"></td>
                                        <td><input class="form-control" type="email" name="email" maxlength="75" placeholder="E-mail Address"></td>
                                        <td><input class="form-control" type="text" name="phone_num" maxlength="10" placeholder="1234567890"></td>
                                        <td><input class="form-control" type="text" name="ssn" maxlength="9" placeholder="123456789"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><input class="form-control" type="currency" name="wage" min="0" placeholder="0.00"></td>
                                        <td><input type="submit" name="submit" class="btn btn-primary" value="Add"></td>
                                    </form>
                                </tr>
                            <?php }
                            while (mysqli_stmt_fetch($stmt)) { ?>
                            <tr>
                                <?php if ($_SESSION["access_level"] == "3") { ?>
                                    <td><?php echo $emp_id; ?></td>
                                    <td><?php echo $fname; ?></td>
                                    <td><?php echo $minit; ?></td>
                                    <td><?php echo $lname; ?></td>
                                    <td><?php echo $dob; ?></td>
                                    <td><?php echo $addr; ?></td>
                                    <td><?php echo $city; ?></td>
                                    <td><?php echo $state; ?></td>
                                    <td><?php echo $zip; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $pnum; ?></td>
                                    <td><?php echo $ssn; ?></td>
                                    <td><?php echo $m_id; ?></td>
                                    <td><?php echo $u_id; ?></td>
                                    <td><?php echo $strikes; ?></td>
                                    <td><?php echo $wage; ?></td>
                                    <td>
                                        <?php 
                                        echo '<button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal'.$emp_id.'">Edit</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal'.$emp_id.'" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel'.$emp_id.'" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel'.$emp_id.'">Edit Employee</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                                        <input type="hidden" name="action" value="edit">
                                                        <input type="hidden" name="emp_id" value="'.$emp_id.'">
                                                        <div class="modal-body">
                                                            <div class="m-3">
                                                                <label class="form-label">First Name</label>
                                                                <input class="form-control" type="text" name="fname" maxlength="30" value="'.$fname.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">M. Init.</label>
                                                                <input class="form-control" type="text" name="minit" maxlength="1" value="'.$minit.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Last Name</label>
                                                                <input class="form-control" type="text" name="lname" maxlength="30" value="'.$lname.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Date of Birth</label>
                                                                <input class="form-control" type="date" name="dob" value="'.$dob.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Home Address</label>
                                                                <input class="form-control" type="text" name="address" maxlength="255" value="'.$addr.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">City</label>
                                                                <input class="form-control" type="text" name="city" maxlength="50" value="'.$city.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">State</label>
                                                                <input class="form-control" type="text" name="state" maxlength="2" value="'.$state.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Zip Code</label>
                                                                <input class="form-control" type="text" name="zip" maxlength="5" value="'.$zip.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">E-mail Address</label>
                                                                <input class="form-control" type="text" name="email" maxlength="75" value="'.$email.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Phone Number</label>
                                                                <input class="form-control" type="text" name="phone_num" maxlength="10" value="'.$pnum.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Social Security Number</label>
                                                                <input class="form-control" type="text" name="ssn" maxlength="9" value="'.$ssn.'">
                                                            </div>
                                                            <div class="m-3">
                                                                <label class="form-label">Hourly Wage</label>
                                                                <input class="form-control" type="currency" name="wage" min="0" value="'.$wage.'">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <input type="submit" class="btn btn-primary" value="Save changes"></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>';
                                        ?>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                            <input type="submit" class="btn btn-danger" value="Delete">
                                        </form>
                                    </td>
                                <?php } else { ?>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $emp_id; ?></td>
                                    <td><?php echo $fname; ?></td>
                                    <td><?php echo $minit; ?></td>
                                    <td><?php echo $lname; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $dob; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $addr; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $city; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $state; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $zip; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $pnum; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $ssn; ?></td>
                                    <td><?php echo $m_id; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $u_id; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $strikes; ?></td>
                                    <td><?php if ($_SESSION["employee_id"] == $emp_id) echo $wage; ?></td>
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
