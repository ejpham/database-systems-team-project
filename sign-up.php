<?php
require_once "db_conn_WebLogins.php";

// Define variables and initialize with empty values
$email = $name = $password = $confirm_password = "";
$email_err = $name_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter a valid e-mail address.";
    }
    else if (strlen(trim($_POST["email"])) > 75) {
        $email_err = "E-mail address can be no longer than 75 characters.";
    }
    else {
        $email = trim($_POST["email"]);
    }
    
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    }
    else if (strlen(trim($_POST["name"])) > 75) {
        $name_err = "Name can be no longer than 75 characters.";
    }
    else {
        $name = trim($_POST["name"]);
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    }
    else if (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    }
    else if (strlen(trim($_POST["password"])) > 16) {
        $password_err = "Password can be no longer than 16 characters.";
    }
    else {
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    }
    else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    $check_db_email = "SELECT * FROM WebLogins.users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn_WebLogins, $check_db_email);
    $email_exists = mysqli_fetch_assoc($result);
    
    // Check if e-mail address exists in database
    if ($email_exists) {
        $email_err = "E-mail address is already taken.";
    }
    
    // Check input errors before inserting in database
    if (empty($email_err) && empty($name_err) && empty($password_err) && empty($confirm_password_err)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $query = "INSERT INTO WebLogins.users (email, name, pass) VALUES ('$email', '$name', '$hashed_password')";
        mysqli_query($conn_WebLogins, $query);
        echo "Registration successful!";
        header('location:sign-in.php');
    }
    
    // Close connection
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-begin">
            <div class="container-fluid py-3 my-3">
                <a href="#" class="navbar-brand">Post Office</a>
                <div class="nav-items">
                    <div class="navbar-nav">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="mail.php" class="nav-item nav-link">Mail</a>
                        <a href="pricing.php" class="nav-item nav-link">Pricing</a>
                        <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
                    </div>
                    <div class="navbar-nav ms-auto">
                        <a href="sign-in.php" class="nav-item nav-link"><button type="button" class="btn btn-light">Sign In</button></a>
                        <a href="sign-up.php" class="nav-item nav-link active"><button type="button" class="btn btn-light">Sign Up</button></a>
                    </div>
                </div>
            </div>
        </nav>
            <!--Form for Sign Up-->
            <div class="brand-name">
                <p>Fill out the form below to create an account.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                        <span class="invalid-feedback"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>E-mail Address</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-light" value="Submit">
                    </div>
                    <p>Already registered? <a href="sign-in.php" class="nav-item nav-link">Sign in</a> now.</p>
                </form>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
