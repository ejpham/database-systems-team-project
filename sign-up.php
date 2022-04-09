<?php
session_start();
// check if already logged in, if so, redirect to index
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:index.php");
    exit;
}
// run script to connect to WebLogins schema in database
require_once "db_conn_WebLogins.php";
// declare variables
$email = $name = $password = $confirm_password = "";
$email_err = $name_err = $password_err = $confirm_password_err = $success = $error = "";
// if "post" was called from submit button in form below
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate email from textbox
    if (empty(trim($_POST["email"]))) $email_err = "Please enter a valid e-mail address.";
    else if (strlen(trim($_POST["email"])) > 75) $email_err = "E-mail address can be no longer than 75 characters.";
    else $email = trim($_POST["email"]);
    // validate name from textbox
    if (empty(trim($_POST["name"]))) $name_err = "Please enter a name.";
    else if (strlen(trim($_POST["name"])) > 75) $name_err = "Name can be no longer than 75 characters.";
    else $name = trim($_POST["name"]);
    // validate password from textbox
    if (empty(trim($_POST["password"]))) $password_err = "Please enter a password.";
    else if (strlen(trim($_POST["password"])) < 6) $password_err = "Password must have at least 6 characters.";
    else if (strlen(trim($_POST["password"])) > 16) $password_err = "Password can be no longer than 16 characters.";
    else $password = trim($_POST["password"]);
    // validate confirm password from textbox
    if (empty(trim($_POST["confirm_password"]))) $confirm_password_err = "Please confirm password.";
    else {
        $confirm_password = trim($_POST["confirm_password"]);
        // make sure password === confirm password
        if (empty($password_err) && ($password != $confirm_password)) $confirm_password_err = "Password did not match.";
    }
    
    // variable containing query to search database for given email from textbox
    $check_db_email = "SELECT * FROM WebLogins.users WHERE email='$email'";
    // run and store query result into variable
    $result = mysqli_query($conn_WebLogins, $check_db_email);
    // boolean (i think...not sure but it works) variable from result
    $email_exists = mysqli_fetch_assoc($result);
    // if true
    if ($email_exists) $email_err = "E-mail address is already taken.";
    
    // if all error strings are empty meaning all info is valid
    if (empty($email_err) && empty($name_err) && empty($password_err) && empty($confirm_password_err)) {
        // variable containing query to insert info into database
        $sql = "INSERT INTO WebLogins.users (email, name, pass) VALUES (?, ?, ?)";
        // prepare query statement
        if ($stmt = mysqli_prepare($conn_WebLogins, $sql)) {
            // bind parameters into query statement
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_name, $param_pass);
            $param_email = $email;
            $param_name = $name;
            // encrypt password
            $param_pass = password_hash($password, PASSWORD_BCRYPT);
            // if query executed successfully
            if (mysqli_stmt_execute($stmt)) {
                $success = '<div class="alert alert-success" role="alert">Your account has been created.</div>';
                // wait 2 seconds then redirect to sign-in page
                header('refresh:1; url=sign-in.php');
            }
            else $error = '<div class="alert alert-danger" role="alert">Oops, something went wrong. Please try again later.</div>';
        }
        else $error = '<div class="alert alert-danger" role="alert">Please make sure your information is valid.</div>';
    }
    // close the connection
    mysqli_close($conn_WebLogins);
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
</head>
<body>
    <!--Navigation-->
    <div class="m-4">
        <nav class="navbar navbar-expand-sm navbar-light" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <ul class="nav navbar-nav me-auto">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="mail.php" class="nav-item nav-link">Mail</a>
                    <a href="pricing.php" class="nav-item nav-link">Pricing</a>
                    <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
                </ul>
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                    <a href="index.php" class="navbar-brand"><span style="margin-right:7.3rem">Postal Office</style></a>
                <?php } else { ?>
                    <a href="index.php" class="navbar-brand"><span style="margin-right:7.8rem">Postal Office</style></a>
                <?php } ?>
                <ul class="nav navbar-nav ms-auto">
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account Options</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="my-account.php" class="dropdown-item">My Account</a>
                                <?php if ($_SESSION["is_employee"] === "1") { ?>
                                    <a href="database-access.php" class="dropdown-item">Database Access</a>
                                <?php } ?>
                                <a href="sign-out.php" class="dropdown-item">Sign Out</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <a href="sign-in.php" class="nav-item nav-link">Sign In</a>
                        <a href="sign-up.php" class="nav-item nav-link active">Sign Up</a>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
    <!--Form for Sign Up-->
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Sign Up</h6>
                <p>Fill out the form below to create an account.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        echo $sucess;
                        echo $error;
                    ?>
                    <div class="m-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" id="inputName" placeholder="Full Name">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="inputEmail">E-mail Address</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" id="inputEmail" placeholder="E-mail Address">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="inputPassword">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" id="inputPassword" placeholder="Password">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="m-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" id="inputPassword" placeholder="Confirm Password">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="m-3">
                        <input type="submit" name="submit" class="btn btn-outline-secondary" value="Submit">
                    </div>
                </form>
                <p>Already registered? <a href="sign-in.php">Sign in</a> here.</p>
            </div>
        </div>
    </div>
</body>
</html>
