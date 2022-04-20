<?php
session_start();
require_once "db_conn_WebLogins.php";
require_once "db_conn_PostalService.php";
$name = $email = $message = "";
$name_err = $email_err = $message_err = $success = $error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
        if (empty(trim($_POST["name"]))) $name_err = "Please enter a name.";
        else if (strlen(trim($_POST["name"])) > 75) $name_err = "Name can be no longer than 75 characters.";
        else $name = trim($_POST["name"]);
        if (empty(trim($_POST["email"]))) $email_err = "Please enter a valid e-mail address.";
        else if (strlen(trim($_POST["email"])) > 75) $email_err = "E-mail address can be no longer than 75 characters.";
        else $email = trim($_POST["email"]);
    }
    else {
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
    }
    if (empty(trim($_POST["message"]))) $message_err = "Please enter a message.";
    else $message = trim($_POST["message"]);
    if (empty($email_err) && empty($name_err) && empty($message_err)) {
        $sql = "INSERT INTO PostalService.Contact_Logs (full_name, email, message) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_message);
            $param_name = $name;
            $param_email = $email;
            $param_message = $message;
            if (mysqli_stmt_execute($stmt)) $success = '<div class="alert alert-success" role="alert">Your message has been sent.</div>';
            else $error = '<div class="alert alert-danger" role="alert">Your message could not be sent.</div>';
        }
    }
    mysqli_close($conn_WebLogins);
    mysqli_close($conn_PostalService);
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
                    <a href="contact-us.php" class="nav-item nav-link active">Contact Us</a>
                </ul>
                <a href="index.php" class="navbar-brand">Postal Office</a>
                <ul class="nav navbar-nav ms-auto">
                    <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) { ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Account Options</a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if ($_SESSION["access_level"] > "1") { ?>
                                    <a href="database-access.php" class="dropdown-item">Database Access</a>
                                <?php } ?>
                                <a href="my-account.php" class="dropdown-item">My Account</a>
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
    <!--Form for Email-->
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Contact Us</h6>
                <p>Fill out the form below to contact us.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        echo $success;
                        echo $error;
                    ?>
                    <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) { ?>
                        <div class="m-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control-plaintext" value="<?php echo $_SESSION["name"]; ?>" id="inputName" disabled>
                        </div>
                        <div class="m-3">
                            <label class="form-label" for="inputEmail">E-mail Address</label>
                            <input type="email" name="email" class="form-control-plaintext" value="<?php echo $_SESSION["email"]; ?>" id="inputEmail" disabled>
                        </div>
                    <?php } else { ?>
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
                    <?php } ?>
                    <div class="m-3">
                        <label class="form-label" for="inputMessage">Message</label>
                        <textarea class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $message; ?>" name="message" id="inputMessage" rows="5" maxlength="255" style="resize:none" placeholder="Enter a message"></textarea>
                        <span class="invalid-feedback"><?php echo $message_err; ?></span>
                        <div id="count">
                            <span id="current_count">0</span>
                            <span id="maximum_count">/ 255</span>
                        </div>
                    </div>
                    <div class="m-3">
                        <input type="submit" name="submit" class="btn btn-outline-secondary" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('textarea').keyup(function() {
            var characterCount = $(this).val().length,
            current_count = $('#current_count'),
            maximum_count = $('#maximum_count'),
            count = $('#count');
            current_count.text(characterCount);
        });
    </script>
</body>
</html>
