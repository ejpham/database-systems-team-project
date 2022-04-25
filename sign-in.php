<?php
session_start();
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
    header("location:index.php");
    exit;
}
require_once "db_conn_PostalService.php";
require_once "db_conn_WebLogins.php";
$email = $password = "";
$email_err = $password_err = $success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) $email_err = "Please enter your e-mail address.";
    else $email = trim($_POST['email']);
    if (empty(trim($_POST["password"]))) $password_err = "Please enter your password.";
    else $password = trim($_POST["password"]);
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT name, email, pass, access_level FROM WebLogins.users WHERE email = ?";
        if ($stmt = mysqli_prepare($conn_WebLogins, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $name, $email, $hashed_password, $access_level);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["logged_in"] = true;
                            $_SESSION["email"] = $email;
                            $_SESSION["name"] = $name;
                            $_SESSION["access_level"] = $access_level;
                            if ($access_level == 2 || $access_level == 3) {
                                if ($result = mysqli_query($conn_PostalService, "SELECT employee_id FROM PostalService.Employee WHERE email = '$email'")) {
                                    $row = mysqli_fetch_assoc($result);
                                    $_SESSION["employee_id"] = $row["employee_id"];
                                    if ($_SESSION["access_level"] == "2") $success = '<div class="alert alert-success" role="alert">Employee login successful.</div>';
                                    else $success = '<div class="alert alert-success" role="alert">Manager login successful.</div>';
                                }
                                else $error = '<div class="alert alert-danger" role="alert">Could not grab employee ID.</div>';
                            }
                            else $success = '<div class="alert alert-success" role="alert">Customer login successful.</div>';
                            header("refresh:1; url=index.php");
                        }
                        else $error = '<div class="alert alert-danger" role="alert">Invalid e-mail address or password.</div>';
                    }
                }
                else $error = '<div class="alert alert-danger" role="alert">Invalid e-mail address or password.</div>';
            }
            else $error = '<div class="alert alert-danger" role="alert">Oops! Something went wrong. Please try again later.</div>';
            mysqli_stmt_close($stmt);
        }
    }
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
                <a href="index.php" class="navbar-brand">Postal Office</a>
                <ul class="nav navbar-nav ms-auto">
                    <a href="sign-in.php" class="nav-item nav-link active">Sign In</a>
                    <a href="sign-up.php" class="nav-item nav-link">Sign Up</a>
                </ul>
            </div>
        </nav>
    </div>
    <!--Form for Sign In-->
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Sign In</h6>
                <p>Sign in below. Forgot your password? Click <a href="reset-password.php">here</a>.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        echo $success;
                        echo $error;
                    ?>
                    <div class="m-3">
                        <label class="form-label" for="inputEmail">E-mail Address</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" id="inputEmail" placeholder="E-mail Address">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="inputPassword">Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="inputPassword" placeholder="Password">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="m-3">
                        <input type="submit" name="submit" class="btn btn-outline-secondary" value="Sign In">
                    </div>
                </form>
                <p>Don't have an account? <a href="sign-up.php">Sign up</a> here.</p>
            </div>
        </div>
    </div>
</body>
</html>
