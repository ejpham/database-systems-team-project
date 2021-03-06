<?php
session_start();
require_once "db_conn_WebLogins.php";
require_once "db_conn_PostalService.php";
$weight = $price = 0;
$packSizeSelected = $packSpeedSelected = $lettSpeedSelected = "0:0";
$name = $email = $mail_type = $address = $fromaddress = $state = $fromstate = $city = $fromcity = $cvv = $expDate = $cardnum = $recName = $lettSpeed = $packSize = $packSpeed = $toZip = $fromZip = $tracking = "";
$name_err = $email_err = $mail_type_err = $state_err = $fromstate_err = $success = $error = $address_err = $fromaddress_err = $city_err = $fromcity_err = $cvv_err = $expDate_err = $cardnum_err = $recName_err = $lettSpeed_err = $packSize_err = $packSpeed_err = $weight_err = $toZip_err= $fromZip_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        $name = $_SESSION["name"];
        $email = $_SESSION["email"];
    }
    else {
        if (empty(trim($_POST["name"]))) $name_err = "Please enter a name.";
        else if (strlen(trim($_POST["name"])) > 75) $name_err = "Name can be no longer than 75 characters.";
        else $name = trim($_POST["name"]);
        if (empty(trim($_POST["email"]))) $email_err = "Please enter a valid e-mail address.";
        else if (strlen(trim($_POST["email"])) > 75) $email_err = "E-mail address can be no longer than 75 characters.";
        else $email = trim($_POST["email"]);
    }
    if (trim($_POST["mailtype"]) == "Select Mail Type") $mail_error = "Please select mail type.";
    else $mail_type = trim($_POST["mailtype"]);
    if (empty(trim($_POST["Address"]))) $address_err = "Please enter a valid address.";
    else if (strlen(trim($_POST["Address"])) > 75) $address_err = "Address can be no longer than 75 characters.";
    else $address = trim($_POST["Address"]);
    if (empty(trim($_POST["fromAddress"]))) $fromaddress_err = "Please enter a valid address.";
    else if (strlen(trim($_POST["fromAddress"])) > 75) $fromaddress_err = "Address can be no longer than 75 characters.";
    else $fromaddress = trim($_POST["fromAddress"]);
    if (empty(trim($_POST["state"]))) $state_err = "Please make a state selection.";
    else $state = trim($_POST["state"]);
    if (empty(trim($_POST["fromstate"]))) $fromstate_err = "Please make a state selection.";
    else $fromstate = trim($_POST["fromstate"]);
    if (empty(trim($_POST["city"]))) $city_err = "Please enter a valid city.";
    else if (strlen(trim($_POST["city"])) > 50) $city_err = "City can be no longer than 50 characters.";
    else $city = trim($_POST["city"]);
    if (empty(trim($_POST["fromcity"]))) $fromcity_err = "Please enter a valid city.";
    else if (strlen(trim($_POST["fromcity"])) > 50) $fromcity_err = "City can be no longer than 50 characters.";
    else $fromcity = trim($_POST["fromcity"]);
    if (empty(trim($_POST["tozipCode"]))) $toZip_err = "Please enter a zip code.";
    else if (strlen(trim($_POST["tozipCode"])) != 5) $toZip_err = "zip code must be 5 characters.";
    else $toZip = trim($_POST["tozipCode"]);
    if (empty(trim($_POST["fromzipCode"]))) $fromZip_err = "Please enter a zip code.";
    else if (strlen(trim($_POST["fromzipCode"])) != 5) $fromZip_err = "zip code must be 5 characters.";
    else $fromZip = trim($_POST["fromzipCode"]);
    if (empty(trim($_POST["receiveName"]))) $recName_err = "Please enter a name.";
    else if (strlen(trim($_POST["receiveName"])) > 75) $recName_err = "Name can be no longer than 75 characters.";
    else $recName = trim($_POST["receiveName"]);
    if (empty(trim($_POST["mailtype"]))) $mail_type_err = "Please make a mail type selection.";
    else $mail_type = trim($_POST["mailtype"]);
    $parts = trim($_POST['letterSpeed']);
    $lettSpeedSelected = $parts;
    $arr = explode(":", $parts);
    if ($arr[1] == 0) $lettSpeed_err = "Please make a letter speed selection.";
    else $lettSpeed = $arr[0];
    $parts = trim($_POST['packageSpeed']);
    $packSpeedSelected = $parts;
    $arr = explode(":", $parts);
    if ($arr[1] == 0) $packSpeed_err = "Please make a package speed selection.";
    else $packSpeed = $arr[0];
    $parts = trim($_POST['packageSize']);
    $packSizeSelected = $parts;
    $arr = explode(":", $parts);
    if ($arr[1] == 0) $packSize_err = "Please make a size selection.";
    else $packSize = $arr[0];
    if (trim($_POST["weightSelector"]) == 0) $weight_err = "Please make a weight selection.";
    else $weight = trim($_POST["weightSelector"]);
    if (empty(trim($_POST["cardNumbers"]))) $cardnum_err = "Please enter a valid Card Number.";
    else if (strlen(trim($_POST["cardNumbers"])) != 16) $cardnum_err = "Please enter a valid Card Number.";
    else $cardnum = trim($_POST["cardNumbers"]);
    if (empty(trim($_POST["expDate"]))) $expDate_err = "Please enter a valid Expiration Date.";
    else if (strlen(trim($_POST["expDate"])) != 5) $expDate_err = "Please enter a valid Expiration Date.";
    else{
        if (intval(substr($_POST["expDate"], 0, 2)) > 12) $expDate_err = "Please enter a valid month";
        else if (intval(substr($_POST["expDate"], 3, 2)) < 22) $expDate_err = "Please enter a valid year";
        else $expDate = trim($_POST["expDate"]);
    }
    if (empty(trim($_POST["cvv"]))) $cvv_err = "Please enter a CVV";
    else if (strlen(trim($_POST["cvv"])) > 4 || strlen(trim($_POST["cvv"])) < 3) $cvv_err = "Please enter a valid CVV";
    else $cvv = trim($_POST["cvv"]);
    $price = trim($_POST["finalPrice"]);
    if (empty($cardnum_err) && empty($expDate_err) && empty($cvv_err) && empty($email_err) && empty($name_err) && empty($message_err) && $price != 0 && empty($fromaddress_err) && empty($fromcity_err) && empty($fromstate_err) && empty($fromZip_err) && empty($toZip_err) && empty($address_err) && empty($city_err) && empty($state_err) && empty($mail_type_err) && empty($recName_err) && (empty($packSpeed_err) || empty($lettSpeed_err))) {
        $sql = "INSERT INTO PostalService.Mail (mail_type, to_name, from_name, to_address, from_address, to_city, from_city, to_state, from_state, to_zipcode, from_zipcode, shipping_class, shipping_cost, tracking_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sql2 = "INSERT INTO PostalService.MailOrders (trackingNumber, status, packageSize, packageWeight, billingAddress, senders_email) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn_PostalService, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssssssssssds", $param_mail_type, $param_to_name, $param_from_name, $param_to_address, $param_from_address, $param_to_city, $param_from_city, $param_to_state, $param_from_state, $param_to_zipcode, $param_from_zipcode, $param_shipping_class, $param_shipping_cost, $param_tracking);
            $tracking = strval(rand(0,9999999999));
            $param_mail_type = $mail_type;
            $param_to_name = $recName;
            $param_from_name = $name;
            $param_to_address = $address;
            $param_from_address = $fromaddress;
            $param_to_city = $city;
            $param_from_city = $fromcity;
            $param_to_state = $state;
            $param_from_state = $fromstate;
            $param_to_zipcode = $toZip;
            $param_from_zipcode = $fromZip;
            if ($mail_type == "Letter") $param_shipping_class = $lettSpeed;
            else $param_shipping_class = $packSpeed;
            $param_shipping_cost = $price;
            $param_tracking = $tracking;
            try{
            if (mysqli_stmt_execute($stmt)) $success = '<div class="alert alert-success" role="alert">Your order has been processed successfully.</div>';
            else $error = '<div class="alert alert-danger" role="alert">Your order could not be accommodated.</div>';
            }
            catch(mysqli_sql_exception $e){
                $error = '<div class="alert alert-danger" role="alert">Four packages have been sent to this address in the past 24 hours, no more will be taken.</div>';
            }
        }
        if (empty($error)) {
            if ($stmt2 = mysqli_prepare($conn_PostalService, $sql2)) {
                mysqli_stmt_bind_param($stmt2, "sssiss", $param_tracking, $param_status, $param_packageSize, $param_packageWeight, $param_billingAdd, $param_sendersEmail);
                $param_status = "Label Created";
                $param_packageSize = $packSize;
                if ($weight > 0) $param_packageWeight = $weight;
                else $param_packageWeight = NULL;
                $param_billingAdd = $fromaddress;
                $param_sendersEmail = $email;
                if (mysqli_stmt_execute($stmt2)) $success = '<div class="alert alert-success" role="alert">Your order has been processed successfully.</div>';
                else $error = '<div class="alert alert-danger" role="alert">Your order could not be accommodated.</div>';
            }
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
    <link href="styles.css" rel="stylesheet">
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
    <!-- NAVIGATION END -->
    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Send Mail</h6>
                <p>Fill out the form below to send mail or <a href="tracking.php">track your mail</a> here.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        echo $success;
                        echo $error;
                        if (!empty($success)) { ?>
                            <div class = "m-3"><p>Tracking Number: <?php echo $tracking; ?></p></div>
                        <?php } ?>
                        <div class="m-3">
                            <label class="form-label">Sender's Full Name</label>
                            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) { ?>
                                <input type="text" name="name" class="form-control-plaintext" value="<?php echo $_SESSION["name"]; ?>" id="inputName" readonly>
                            <?php } else { ?>
                                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" id="inputName" placeholder="Full Name">
                                <span class="invalid-feedback"><?php echo $name_err; ?></span>
                            <?php } ?>
                        </div>
                        <div class="m-3">
                            <label class="form-label" for="inputEmail">E-mail Address</label>
                            <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) { ?>
                                <input type="email" name="email" class="form-control-plaintext" value="<?php echo $_SESSION["email"]; ?>" id="inputEmail" readonly>
                            <?php } else { ?>
                                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" id="inputEmail" placeholder="E-mail Address">
                                <span class="invalid-feedback"><?php echo $email_err; ?></span>
                            <?php } ?>
                        </div>
                        <div class="m-3">
                            <label class="form-label">From Address</label>
                            <input type="text" name="fromAddress" class="form-control <?php echo (!empty($fromaddress_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fromaddress; ?>" id="inputFromAddress" placeholder="Address">
                            <span class="invalid-feedback"><?php echo $fromaddress_err; ?></span>
                            <div class="input-group">
                                <input type="text" name="fromcity" class="form-control <?php echo (!empty($fromcity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fromcity; ?>" id="inputfromCity" placeholder="City">
                                <span class="invalid-feedback"><?php echo $fromcity_err; ?></span>
                                <input type="text" name="fromzipCode" class="form-control <?php echo (!empty($fromZip_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $fromZip; ?>" id="inputfromZip" placeholder="Zip Code" maxlength = "5">
                                <span class="invalid-feedback"><?php echo $fromZip_err; ?></span>
                                <select class="form-select" type="text" id="fromstateSelector" name="fromstate">
                                    <option value="">State</option>
                                    <option value="AL">AL</option>
                                    <option value="AK">AK</option>
                                    <option value="AR">AR</option>	
                                    <option value="AZ">AZ</option>
                                    <option value="CA">CA</option>
                                    <option value="CO">CO</option>
                                    <option value="CT">CT</option>
                                    <option value="DC">DC</option>
                                    <option value="DE">DE</option>
                                    <option value="FL">FL</option>
                                    <option value="GA">GA</option>
                                    <option value="HI">HI</option>
                                    <option value="IA">IA</option>
                                    <option value="ID">ID</option>
                                    <option value="IL">IL</option>
                                    <option value="IN">IN</option>
                                    <option value="KS">KS</option>
                                    <option value="KY">KY</option>
                                    <option value="LA">LA</option>
                                    <option value="MA">MA</option>
                                    <option value="MD">MD</option>
                                    <option value="ME">ME</option>
                                    <option value="MI">MI</option>
                                    <option value="MN">MN</option>
                                    <option value="MO">MO</option>	
                                    <option value="MS">MS</option>
                                    <option value="MT">MT</option>
                                    <option value="NC">NC</option>	
                                    <option value="NE">NE</option>
                                    <option value="NH">NH</option>
                                    <option value="NJ">NJ</option>
                                    <option value="NM">NM</option>			
                                    <option value="NV">NV</option>
                                    <option value="NY">NY</option>
                                    <option value="ND">ND</option>
                                    <option value="OH">OH</option>
                                    <option value="OK">OK</option>
                                    <option value="OR">OR</option>
                                    <option value="PA">PA</option>
                                    <option value="RI">RI</option>
                                    <option value="SC">SC</option>
                                    <option value="SD">SD</option>
                                    <option value="TN">TN</option>
                                    <option value="TX">TX</option>
                                    <option value="UT">UT</option>
                                    <option value="VT">VT</option>
                                    <option value="VA">VA</option>
                                    <option value="WA">WA</option>
                                    <option value="WI">WI</option>	
                                    <option value="WV">WV</option>
                                    <option value="WY">WY</option>
                                </select>
                                <span class="invalid-feedback d-block"><?php echo $fromstate_err; ?></span>
                                <script type="text/javascript">
                                    document.getElementById('fromstateSelector').value = "<?php echo $fromstate; ?>";
                                </script>
                            </div>
                        </div>
                        <div class="m-3">
                            <label class="form-label">Recipient's Full Name</label>
                            <input type="text" name="receiveName" class="form-control <?php echo (!empty($recName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recName; ?>" id="inputRecName" placeholder="Full Name">
                            <span class="invalid-feedback"><?php echo $recName_err; ?></span>
                        </div>
                        <div class="m-3">
                            <label class="form-label">To Address</label>
                            <input type="text" name="Address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>" id="inputAddress" placeholder="Address">
                            <span class="invalid-feedback"><?php echo $address_err; ?></span>
                            <div class="input-group mb-3">
                                <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>" id="inputCity" placeholder="City">
                                <span class="invalid-feedback"><?php echo $city_err; ?></span>
                                <input type="text" name="tozipCode" class="form-control <?php echo (!empty($toZip_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $toZip; ?>" id="inputtoZip" placeholder="Zip Code" maxlength = "5">
                                <span class="invalid-feedback"><?php echo $toZip_err; ?></span>
                                <select class="form-select" type="text" id="stateSelector" name="state">
                                    <option value="">State</option>
                                    <option value="AL">AL</option>
                                    <option value="AK">AK</option>
                                    <option value="AR">AR</option>	
                                    <option value="AZ">AZ</option>
                                    <option value="CA">CA</option>
                                    <option value="CO">CO</option>
                                    <option value="CT">CT</option>
                                    <option value="DC">DC</option>
                                    <option value="DE">DE</option>
                                    <option value="FL">FL</option>
                                    <option value="GA">GA</option>
                                    <option value="HI">HI</option>
                                    <option value="IA">IA</option>
                                    <option value="ID">ID</option>
                                    <option value="IL">IL</option>
                                    <option value="IN">IN</option>
                                    <option value="KS">KS</option>
                                    <option value="KY">KY</option>
                                    <option value="LA">LA</option>
                                    <option value="MA">MA</option>
                                    <option value="MD">MD</option>
                                    <option value="ME">ME</option>
                                    <option value="MI">MI</option>
                                    <option value="MN">MN</option>
                                    <option value="MO">MO</option>	
                                    <option value="MS">MS</option>
                                    <option value="MT">MT</option>
                                    <option value="NC">NC</option>	
                                    <option value="NE">NE</option>
                                    <option value="NH">NH</option>
                                    <option value="NJ">NJ</option>
                                    <option value="NM">NM</option>			
                                    <option value="NV">NV</option>
                                    <option value="NY">NY</option>
                                    <option value="ND">ND</option>
                                    <option value="OH">OH</option>
                                    <option value="OK">OK</option>
                                    <option value="OR">OR</option>
                                    <option value="PA">PA</option>
                                    <option value="RI">RI</option>
                                    <option value="SC">SC</option>
                                    <option value="SD">SD</option>
                                    <option value="TN">TN</option>
                                    <option value="TX">TX</option>
                                    <option value="UT">UT</option>
                                    <option value="VT">VT</option>
                                    <option value="VA">VA</option>
                                    <option value="WA">WA</option>
                                    <option value="WI">WI</option>	
                                    <option value="WV">WV</option>
                                    <option value="WY">WY</option>
                                </select>
                                <span class="invalid-feedback d-block"><?php echo $state_err; ?></span>
                                <script type="text/javascript">
                                    document.getElementById('stateSelector').value = "<?php echo $state; ?>";
                                </script>
                            </div>
                        </div>
                        <div class="m-3">
                            <select class="form-select" type = "text" name = "mailtype" id = "mailSelector" onchange = "MailCheck(this);">
                                <option value = "">Select Mail Type</option>
                                <option value="Letter">Letter</option>
                                <option value="Package">Package</option>
                            </select>

                            <script type="text/javascript">
                                document.getElementById('mailSelector').value = "<?php echo $mail_type; ?>";
                            </script>

                            <span class="invalid-feedback d-block"><?php echo $mail_type_err; ?></span>
                        </div>
                        <div class="m-3" id="ifLetter" style="display: none;">
                            <select class="form-select" type = "text" name = "letterSpeed" id = "letterSelector" onChange="updatePriceLetter();">
                                <option value = "0:0">Select Letter Speed</option>
                                <option value="Express:6">Premium</option>
                                <option value="Fast:3">Regular</option>
                            </select>
                            <script type="text/javascript">
                                document.getElementById('letterSelector').value = "<?php echo $lettSpeedSelected; ?>";
                            </script>
                            <span class="invalid-feedback d-block"><?php echo $lettSpeed_err; ?></span>
                        </div>
                        <div class="m-3" id="ifPackage" style="display: none;">
                            <select class="form-select" type = "text" name = "packageSpeed" id = "packageSelector" onChange="updatePricePackage();">
                                <option value = "0:0">Select Package Speed</option>
                                <option value="Express:6">Premium</option>
                                <option value="Fast:3">Regular</option>
                            </select>
                            <script type="text/javascript">
                                document.getElementById('packageSelector').value = "<?php echo $packSpeedSelected; ?>";
                            </script>
                            <span class="invalid-feedback d-block"><?php echo $packSpeed_err; ?></span>
                        </div>
                        <div class="m-3" id="packageSizeSelector" style="display: none;">
                            <select class="form-select" type="text" name="packageSize" id="sizeSelector" onChange="updatePricePackage();">
                                <option value = "0:0">Select Package Size</option>
                                <option value="8 x 8 x 6:6">8 x 8 x 6</option>
                                <option value="8 x 8 x 8:7">8 x 8 x 8</option>
                                <option value="10 x 8 x 6:8">10 x 8 x 6</option>
                                <option value="12 x 6 x 6:9">12 x 6 x 6</option>
                                <option value="12 x 9 x 3:10">12 x 9 x 3</option>
                                <option value="12 x 9 x 4:11">12 x 9 x 4</option>
                                <option value="12 x 10 x 4:12">12 x 10 x 4</option>
                                <option value="12 x 12 x 3:13">12 x 12 x 3</option>
                            </select>
                            <script type="text/javascript">
                                document.getElementById('sizeSelector').value = "<?php echo $packSizeSelected; ?>";
                            </script>
                            <span class="invalid-feedback d-block"><?php echo $packSize_err; ?></span>
                        </div>
                        <div class="m-3" id="packageWeight" style="display: none;">
                            <label for="weight" class="form-label">Slide for weight (lb): <span id = "changeRange1Value"> 0 </span> </label>
                            <input type="range" class="form-range" id="weight" name = "weightSelector" min="0" max="100" step="1" value="<?php echo $weight; ?>" onchange="updatePricePackage();">
                            <span class="invalid-feedback d-block"><?php echo $weight_err; ?></span>
                        </div>
                        <div class="m-3" id="priceShow">
                            <label class="form-label">Price:</label>
                            <input type="number" class="form-control-plaintext" id="priceChanging" name="finalPrice" value="<?php echo $price; ?>" style="background-color:#FFFFFF;" readonly>
                        </div>
                        <div class="m-3" id = "cardInfo" style="display:block;">
                            <label class="form-label">Card Information</label>
                            <input type="text" name="cardNumbers" class="form-control <?php echo (!empty($cardnum_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cardnum; ?>" id="cardnum" placeholder="0000000000000000" maxlength="16">
                            <span class="invalid-feedback"><?php echo $cardnum_err; ?></span>
                            <span class="input-group-text"></span>
                            <input type="text" name="expDate" class="form-control <?php echo (!empty($expDate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $expDate; ?>" maxlength="5" id="inputexpDate" placeholder="Expiration Date: MM/YY">
                            <span class="invalid-feedback"><?php echo $expDate_err; ?></span>
                            <span class="input-group-text"></span>
                            <input type="text" name="cvv" class="form-control <?php echo (!empty($ccv_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cvv; ?>" id="inputCCV" placeholder="CVV: 000">
                            <span class="invalid-feedback"><?php echo $cvv_err; ?></span>
                        </div>
                        <div class="m-3">
                            <input type="submit" name="submit" class="btn btn-outline-secondary" value="Send">
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('input').mousemove(function() {
            var customRange1_VAL = document.getElementById("weight").value;
            changeRange1Value = $('#changeRange1Value');
            changeRange1Value.text(customRange1_VAL);
        });
        function MailCheck(that) {
            if(that.value == "Letter"){
                document.getElementById("ifLetter").style.display = "block";
                document.getElementById("ifPackage").style.display = "none";
                document.getElementById("packageSizeSelector").style.display = "none";
                document.getElementById("packageWeight").style.display = "none";
                console.log("HERE");
                updatePriceLetter();
            }
            else if (that.value == "Package") {
                document.getElementById("ifPackage").style.display = "block";
                document.getElementById("packageSizeSelector").style.display = "block";
                document.getElementById("packageWeight").style.display = "block";
                document.getElementById("ifLetter").style.display = "none";
                updatePricePackage();
            }
            else {
                document.getElementById("ifLetter").style.display = "none";
                document.getElementById("ifPackage").style.display = "none";
                document.getElementById("packageSizeSelector").style.display = "none";
                document.getElementById("packageWeight").style.display = "none";
                hideCardInfo();
                clearPrice();
            }
        }
        function showCardInfo() {
            document.getElementById("cardInfo").style.display = "block";
        }

        function hideCardInfo() {
            document.getElementById("cardInfo").style.display = "none";
        }
        window.onload = MailCheck(document.getElementById("mailSelector"));
        function updatePricePackage(){
            let adding = 0;
            const array = document.getElementById("sizeSelector").value.split(":");
            adding = adding + parseInt(array[1]);
            const array2 = document.getElementById("packageSelector").value.split(":");
            adding = adding + parseInt(array2[1]);
            adding = adding + (parseInt(document.getElementById("changeRange1Value").textContent) / 10);
            if(parseInt(array[1]) > 0 && parseInt(array2[1]) > 0 && parseInt(document.getElementById("changeRange1Value").textContent) > 0) {
                showCardInfo();
            }
            else {
                hideCardInfo();
            }
            document.getElementById("priceChanging").value = adding;
        }
        function updatePriceLetter() {
            let adding = 0;
            const array = document.getElementById("letterSelector").value.split(":");
            adding = adding + parseInt(array[1]);
            if (adding > 0) {
                showCardInfo();
            }
            else {
                hideCardInfo();
            }
            document.getElementById("priceChanging").value = adding;
        }
        function clearPrice() {
            priceChanging = $('#priceChanging');
            priceChanging.text(0);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
