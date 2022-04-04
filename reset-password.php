<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:index.php");
    exit;
}
 
require_once "db_conn_WebLogins.php";
 
$email = $new_password = $confirm_password = "";
$email_err = $new_password_err = $confirm_password_err = $success = $error = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) $email_err = "Please enter your e-mail address.";
    else $email = trim($_POST['email']);
    
    if (empty(trim($_POST["new_password"]))) $new_password_err = "Please enter the new password.";     
    else if (strlen(trim($_POST["new_password"])) < 6) $new_password_err = "Password must have at least 6 characters.";
    else if (strlen(trim($_POST["new_password"])) > 16) $new_password_err = "Password can be no longer than 16 characters.";
    else $new_password = trim($_POST["new_password"]);
    
    if (empty(trim($_POST["confirm_password"]))) $confirm_password_err = "Please confirm the password.";
    else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) $confirm_password_err = "Password did not match.";
    }
    
    $check_db_email = "SELECT * FROM WebLogins.users WHERE email='$email'";
    $result = mysqli_query($conn_WebLogins, $check_db_email);
    $email_exists = mysqli_fetch_assoc($result);
    
    if (!$email_exists) $email_err = "Invalid e-mail address";
    
    if (empty($email_err) && empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE WebLogins.users SET pass = ? WHERE email = ?";
        
        if ($stmt = mysqli_prepare($conn_WebLogins, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_email);
            $param_password = password_hash($new_password, PASSWORD_BCRYPT);
            $param_email = $email;
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                session_destroy();
                $success = "Successfully changed password.";
                header("refresh:1; url=sign-in.php");
                exit();
            }
            else $error = "Oops! Something went wrong. Please try again later.";
            
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
    <link href="styles.css" rel="stylesheet">
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
                                <a href="database-access.php" class="dropdown-item">Database Access</a>
                                <a href="sign-out.php" class="dropdown-item">Sign Out</a>
                            </div>
                        </li>
                    <?php } else { ?>
                        <a href="sign-in.php" class="nav-item nav-link">Sign In</a>
                        <a href="sign-up.php" class="nav-item nav-link">Sign Up</a>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>
    <!--Form for Reset Password-->
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Reset Password</h6>
                <p>Please fill out this form to reset your password.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-success"><?php echo $success; ?></div>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <div class="m-3">
                        <label class="form-label" for="inputEmail">E-mail Address</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" id="inputEmail" placeholder="E-mail Address">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="inputNewPassword">New Password</label>
                        <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>" id="inputNewPassword" placeholder="New Password">
                        <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                    </div>
                    <div class="m-3">
                        <label class="form-label" for="inputConfirmPassword">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" id="inputConfirmPassword" placeholder="Confirm New Password">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="m-3">
                        <input type="submit" name="submit" class="btn btn-outline-secondary" value="Reset Password">
                    </div>
                </form>
                <p>Change your mind? <a href="sign-in.php">Sign in</a> here.</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
