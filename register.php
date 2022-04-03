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
