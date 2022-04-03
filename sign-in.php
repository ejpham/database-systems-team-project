<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location:index.php");
    exit;
}

require_once "db_conn_WebLogins.php";

$email = $password = "";
$email_err = $password_err = $login_err = $success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["email"]))) $email_err = "Please enter your e-mail address.";
    else $email = trim($_POST['email']);
    
    if (empty(trim($_POST["password"]))) $password_err = "Please enter your password.";
    else $password = trim($_POST["password"]);
    
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
                            $success = "Login successful.";
                            header("location:index.php");
                        }
                        else $login_err = "Invalid e-mail address or password.";
                    }
                }
                else $login_err = "Invalid e-mail address or password.";
            }
            else $login_err = "Oops! Something went wrong. Please try again later.";
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <!--Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
            <div class="container-fluid">
                <a href="#" class="navbar-brand">Postal Office</a>
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="mail.php" class="nav-item nav-link">Mail</a>
                <a href="pricing.php" class="nav-item nav-link">Pricing</a>
                <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
                <a href="sign-in.php" class="nav-item nav-link active"><button type="button" class="btn btn-outline-primary">Sign In</button></a>
                <button type="button" class="btn btn-outline-primary"><a href="sign-up.php" class="nav-item nav-link">Sign Up</a></button>
            </div>
        </nav>
        <!--Form for Sign In-->
        <div class="container-fluid">
            <div class="row">
                <div class="m-4">
                    <p>Sign in below.</p>
                    <?php if (!empty($login_err)) echo '<div class="alert alert-danger">' . $login_err . '</div>'; ?>
                    <?php
                    if (!empty($success)) echo '<div class="alert alert-success">' . $success . '</div>';
                    else if (!empty($error)) echo '<div class="alert alert-danger">' . $login_err . '</div>';
                    ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="m-3">
                            <label class="form-label" for="inputEmail">E-mail Address</label>
                            <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" >
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
