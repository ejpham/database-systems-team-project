<?php
session_start();
require_once "db_conn_PostalService.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["trackingNum"]))) $tracking_err = "Please enter a tracking number.";
    else $tracking = trim($_POST["trackingNum"]);
    if (empty($tracking_err)) {
        $sql = "SELECT status FROM PostalService.MailOrders WHERE trackingNumber = $tracking";
        $resultingStatus = $conn_PostalService->query($sql);
        if ($resultingStatus->num_rows > 0) {
            $row = $resultingStatus->fetch_assoc();
            $stat = $row["status"];
        }
        if (!empty($row)) {
            $success = '<div class="alert alert-success" role="alert">Mail Status: '.$stat.'</div>';
        }
        else $error = '<div class="alert alert-danger" role="alert">Could not find your package based on this tracking number.</div>';
    }
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
                    <a href="mail.php" class="nav-item nav-link active">Mail</a>
                    <a href="pricing.php" class="nav-item nav-link">Pricing</a>
                    <a href="contact-us.php" class="nav-item nav-link">Contact Us</a>
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
    <!-- End Navigation -->
    <!--Form for Tracking-->
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Track Mail</h6>
                <p>Fill out the form below to track mail or <a href="mail.php">send your mail</a> here.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        echo $success;
                        echo $error;
                    ?>
                    <div class="m-3">
                        <label class="form-label">Tracking Number</label>
                        <input type="text" name="trackingNum" class="form-control <?php echo (!empty($tracking_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tracking; ?>" id="inputTracking" maxlength = "10" placeholder="Tracking #">
                        <span class="invalid-feedback"><?php echo $tracking_err; ?></span>
                    </div>
                    <div class="m-3">
                        <input type="submit" name="submit" class="btn btn-outline-secondary" value="Track">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
