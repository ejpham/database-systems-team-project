<?php
require_once "db_conn.php";
require_once "session.php";
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
//     $name = trim($_POST['name']);
//     $email = trim($_POST['emai']);
//     $password = trim($_POST['password']);
//     $confirm_password = trim($_POST["confirm_password"]);
//     $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
//     if ($query = $conn->prepare("SELECT * FROM WebLogins.users WHERE email = ?")) {
//         $error = '';
//         $query->bind_param('s', $email);
//         $query->execute();
//         $query->store_result();
//         if ($query->num_rows > 0) {
//             $error .= '<p class="error">Password must have at least 6 characters.</p>';
//         }
//         if (empty($confirm_password)) {
//             $error .= '<p class="error">Please confirm passwords.</p>';
//         }
//         else if (empty($error) && ($password != $confirm_password)) {
//             $error .= '<p class="error">Passwords did not match.</p>';
//         }
//         if (empty($error)) {
//             $insertQuery = $conn->prepare("INSERT INTO WebLogins.users (name, email, password) VALUES (?, ?, ?);");
//             $insertQuery->bind_param("sss", $name, $email, $password_hash);
//             $result = $insertQuery->execute();
//             if ($result) {
//                 $error .= '<p class="success">Your registration was successful!</p>';
//             }
//             else {
//                 $error .= '<p class="error">Something went wrong.</p>';
//             }
//         }
//         $query->close();
//         $insertQuery->close();
//         sqlsrv_close($conn);
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
                <form action="" method="post">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="yellow-button" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
