<?php
session_start();
require "db_conn_WebLogins.php";
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location:sign-in.php");
    exit;
}
if ($_SESSION["is_employee"] == "1") {
    header("location:index.php");
    exit;
}
$sql = "SELECT id, email, name, is_employee FROM WebLogins.users ORDER BY id ASC";
if ($stmt = mysqli_prepare($conn_WebLogins, $sql)) {
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $email, $name, $is_employee);
}
$input_id = $input_access_level = "";
$input_id_err = $input_access_level_err = $success = $error = "";
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (empty(trim($_POST["input_id"])) || trim($_POST["input_id"]) < 1) $input_id_err = '<div class="alert alert-danger" role="alert">Please enter a valid User ID.</div>';
//     else $input_id = $_POST["input_id"];
//     if (empty(trim($_POST["input_access_level"])) || trim($_POST["input_access_level"]) < 0 || trim($_POST["input_access_level"]) > 3) $input_access_level_err = '<div class="alert alert-danger" role="alert">Please enter a valid access level.</div>';
//     else $input_access_level = $_POST["input_access_level"];
//     if (empty($input_id_err) && empty($input_access_level_err)) {
//         mysqli_stmt_close($stmt);
//         mysqli_query($conn_WebLogins, "UPDATE WebLogins.users SET is_employee = '".$input_access_level."' WHERE id = '".$input_id."'");
//         header("refresh:0;");
//     }
// }
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
                    <span class="navbar-brand mx-auto">Postal Service Mail</span>
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
                <h6 class="display-6">Users</h6>
                <table class="table table-bordered table-primary table-hover">
                <thead>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail Address</th>
                    <th scope="col">Access Level</th>
                </thead>
                <tbody>
                    <?php while (mysqli_stmt_fetch($stmt)) { ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $is_employee; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="m-4 row justify-content-center">
            <div class="col-5">
                <h6 class="display-6">Adjust Access Level</h6>
                <ul class="list">
                    <li>1 = Customer</li>
                    <li>2 = Employee</li>
                    <li>3 = Manager</li>
                </ul>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                    echo $input_id_err;
                    echo $input_access_level_err;
                    ?>
                    <div class="m-3 input-group">
                        <input type="number" name="input_id" class="form-control" value="<?php echo $input_id; ?>" id="inputID" placeholder="User ID" min="1">
                        <input type="number" name="input_access_level" class="form-control" value="<?php echo $input_access_level; ?>" id="inputAccessLevel" placeholder="New Access Level" min="1" max="3">
                        <input type="submit" name="submit" class="btn btn-primary" value="Query">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
