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
    mysqli_close($conn);
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
                    <h6>Sign Up</h6>
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
            <!--Form for Sign Up-->
            <div class="brand-name">
                <p>Fill out the form below to create an account.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
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
                        <input type="submit" name="submit" class="yellow-button" value="Submit">
                    </div>
                    <p>Already registered? <a href="sign-in.php">Sign in</a> now.</p>
                </form>
            </div>
        </div>
    </body>
</html>
