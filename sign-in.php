<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:welcome.php");
    exit;
}

require_once "db_conn_WebLogins.php";

$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your e-mail address.";
    }
    else {
        $email = trim($_POST["email"]);
    }
    if (empty(trim($_POST["password"])) || strlen(trim($_POST["password"])) < 6 || strlen(trim($_POST["password"])) > 16) {
        $password_err = "Please enter your password.";
    }
    else {
        $password = trim($_POST["password"]);
    }
    
    if (empty($email_err) && empty($password_err)) {
        $sql = "SELECT id, email, pass FROM WebLogins.users WHERE email = ?";
        if ($stmt = mysqli_prepare($conn_WebLogins, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            header("location:welcome.php");
                        }
                        else {
                            $login_err = "Invalid e-mail address or password.";
                        }
                    }
                }
            }
            else {
                echo "Oops! Something went wrong. Please try again later.";
            }
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
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class = "container">
            <!--Navigation-->
            <nav class="navbar">
                <div class="brand-name">
                    <h5>Post Office</h5>
                    <h6>Sign In</h6>
                </div>
                <div class="nav-items">
                    <ul class="navbar-nav">
                        <li class="nav-link"><a href="index.php">Home</a></li>
                        <li class="nav-link"><a href="mail.php">Mail</a></li>
                        <li class="nav-link"><a href="pricing.php">Pricing</a></li>
                        <li class="nav-link"><a href="contact-us.php">Contact Us</a></li>
                        <a href="sign-in.php"><button class="yellow-button">Sign In</button></a>
                        <a href="sign-up.php"><button class="yellow-button">Sign Up</button></a>
                    </ul>
                </div>
            </nav>
                <!--Form for Sign In-->
                <div class="brand-name">
                <p>Sign in below.</p>
                <?php if (!empty($login_err)) { echo '<div class="alert alert-danger">' . $login_err . '</div>'; } ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label>E-mail Address</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="yellow-button" value="Sign In">
                    </div>
                    <p>Don't have an account? <a href="sign-up.php">Sign up</a> now.</p>
                </form>
            </div>
        </div>
    </body>
</html>
