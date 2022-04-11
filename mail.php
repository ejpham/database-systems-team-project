<?php
session_start();
require_once "db_conn_WebLogins.php";
require_once "db_conn_PostalService.php";
$name = $email = $mail_type = $address = $state = $city = $cardnum = $ccv = $expDate = $cardnum = $recName = $lettSpeed = $packSize = $packSpeed = "";
$name_err = $email_err = $mail_type_err = $state_err = $success = $error = $address_err = $city_err = $ccv_err = $expDate_err = $cardnum_err = $recName_err = $lettSpeed_err = $packSize_err = $packSpeed_err = "";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $email = $_SESSION["email"];
    $grab_name_sql = "SELECT name FROM WebLogins.users WHERE email='$email'";
    $result = mysqli_query($conn_WebLogins, $grab_name_sql);
    $name = mysqli_fetch_assoc($result)["name"];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
        if (empty(trim($_POST["name"]))) $name_err = "Please enter a name.";
        else if (strlen(trim($_POST["name"])) > 75) $name_err = "Name can be no longer than 75 characters.";
        else $name = trim($_POST["name"]);

        if (empty(trim($_POST["email"]))) $email_err = "Please enter a valid e-mail address.";
        else if (strlen(trim($_POST["email"])) > 75) $email_err = "E-mail address can be no longer than 75 characters.";
        else $email = trim($_POST["email"]);

        if (trim($_POST["mailtype"]) == "Select Mail Type") $mail_error = "Please select mail type.";
        else $mail_type = trim($_POST["mailtype"]);

        if (empty(trim($_POST["Address"]))) $address_err = "Please enter a valid Address.";
        else if (strlen(trim($_POST["Address"])) > 75) $address_err = "Address can be no longer than 75 characters.";
        else $address = trim($_POST["Address"]);

        if (empty(trim($_POST["state"]))) $state_err = "Please make a state selection.";
        else $state = trim($_POST["state"]);

        if (empty(trim($_POST["City"]))) $city_err = "Please enter a valid City.";
        else if (strlen(trim($_POST["City"])) > 75) $city_err = "City can be no longer than 75 characters.";
        else $city = trim($_POST["City"]);

        if (empty(trim($_POST["receiveName"]))) $recName_err = "Please enter a Name.";
        else if (strlen(trim($_POST["receiveName"])) > 75) $recName_err = "Name can be no longer than 75 characters.";
        else $recName = trim($_POST["receiveName"]);

        if (trim($_POST["mailtype"]) == "Select Mail Type") $mail_type_err = "Please make a Mail Type selection.";
        else $mail_type = trim($_POST["mailtype"]);

        if (trim($_POST["packageSpeed"]) == "Select Package Speed") $packSpeed_err = "Please make a Package Speed selection.";
        else $packSpeed = trim($_POST["packageSpeed"]);

        if (trim($_POST["packageSize"]) == "Select Package Size") $packSize_err = "Please make a size selection.";
        else $packSize = trim($_POST["packageSize"]);
    }
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
    <!-- NAVIGATION END -->

    <div class="container-fluid col-sm-6">
        <div class="row">
            <div class="m-4">
                <h6 class="display-6">Sending Mail</h6>
                <p>Fill out the form below to send mail.</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        echo $success;
                        echo $error;
                        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                        <div class="m-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control-plaintext <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>" id="inputName" value="<?php echo $name ?>" disabled>
                            <span class="invalid-feedback"><?php echo $name_err; ?></span>
                        </div>
                        <div class="m-3">
                            <label class="form-label" for="inputEmail">E-mail Address</label>
                            <input type="email" name="email" class="form-control-plaintext <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" id="inputEmail" value="<?php echo $email ?>" disabled>
                            <span class="invalid-feedback"><?php echo $email_err; ?></span>
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
                        <label class="form-label">Receiver's Full Name</label>
                        <input type="text" name="receiveName" class="form-control <?php echo (!empty($recName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recName; ?>" id="inputRecName" placeholder="Receiver's Full Name">
                        <span class="invalid-feedback"><?php echo $recName_err; ?></span>
                    </div>

                    <div class="m-3">
                        <label class="form-label">To Address</label>
                        <input type="text" name="Address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>" id="inputAddress" placeholder="To Address">
                        <span class="invalid-feedback"><?php echo $address_err; ?></span>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-select" aria-label="Default select example" type = "text" id = "stateSelector" name = "state" value="<?php echo $state; ?>">
                            <option value = "">State</option>
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

                        <input type="text" name="City" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>" id="inputCity" placeholder="city">
                        <span class="invalid-feedback"><?php echo $city_err; ?></span>
                    </div>

                    <br />

                    <div class="m-3">
                        <select class="form-select" aria-label="Default select example" type = "text" name = "mailtype" id = "mailSelector" onchange = "MailCheck(this);">
                            <option value = "Select Mail Type">Select Mail Type</option>
                            <option value="Letter">Letter</option>
                            <option value="Package">Package</option>
                        </select>
                        <span class="invalid-feedback d-block"><?php echo $mail_type_err; ?></span>
                    </div>

                    <div class="m-3" id = "ifLetter" style="display: none;">
                        <select class="form-select" aria-label="Default select example" type = "text" name = "letterSpeed" id = "letterSelector">
                            <option value = "Select Letter Speed">Select Letter Speed</option>
                            <option value="Express">Express</option>
                            <option value="Fast">Fast</option>
                        </select>
                        <span class="invalid-feedback d-block"><?php echo $lettSpeed_err; ?></span>
                    </div>

                    <div class="m-3" id = "ifPackage" style="display: none;">
                        <select class="form-select" aria-label="Default select example" type = "text" name = "packageSpeed" id = "packageSelector">
                            <option value = "Select Package Speed">Select Package Speed</option>
                            <option value="Express">Premium</option>
                            <option value="Fast">Regular</option>
                        </select>
                        <span class="invalid-feedback d-block"><?php echo $packSpeed_err; ?></span>
                    </div>

                    <div class="m-3" id = "packageSize" style="display: none;">
                        <select class="form-select" aria-label="Default select example" type = "text" name = "packageSize" id = "sizeSelector">
                            <option value = "Select Package Size">Select Package Size</option>
                            <option value="1">8 x 8 x 6</option>
                            <option value="2">8 x 8 x 8</option>
                            <option value="3">10 x 8 x 6</option>
                            <option value="4">12 x 6 x 6</option>
                            <option value="5">12 x 9 x 3</option>
                            <option value="6">12 x 9 x 4</option>
                            <option value="7">12 x 10 x 4</option>
                            <option value="8">12 x 12 x 3</option>
                        </select>
                        <span class="invalid-feedback d-block"><?php echo $packSize_err; ?></span>
                    </div>

                    <div class="m-3" id = "packageWeight" style="display: none;">
                        <label for="weight" class="form-label">Slide for weight: <span id="changeRange1Value">0</span></label>
                        <input type="range" class="form-range" id="weight" min="0" max="100" step="1" value="0">
                    </div>

                    <br />

                    <div class="m-3" id = "cardInfo" style="display: block;">
                        <label class="form-label">Card Information</label>
                        <input type="text" name="cardNumbers" class="form-control <?php echo (!empty($cardnum_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cardnum; ?>" id="cardnum" placeholder="0000 0000 0000 0000">
                        <span class="invalid-feedback"><?php echo $cardnum_err; ?></span>

                        <span class="input-group-text"></span>
                        <input type="text" name="expDate" class="form-control <?php echo (!empty($expDate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $expDate; ?>" id="inputexpDate" placeholder="Expiration Date">
                        <span class="invalid-feedback"><?php echo $expDate_err; ?></span>

                        <span class="input-group-text"></span>
                        <input type="text" name="ccv" class="form-control <?php echo (!empty($ccv_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ccv; ?>" id="inputCCV" placeholder="CCV">
                        <span class="invalid-feedback"><?php echo $ccv_err; ?></span>
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
    </script>

    <script type = "text/javascript">
        function MailCheck(that) {
            if(that.value == "Letter"){
                document.getElementById("ifLetter").style.display = "block";
                document.getElementById("ifPackage").style.display = "none";
                document.getElementById("packageSize").style.display = "none";
                document.getElementById("packageWeight").style.display = "none";
            }
            else if (that.value == "Package") {
                document.getElementById("ifPackage").style.display = "block";
                document.getElementById("packageSize").style.display = "block";
                document.getElementById("packageWeight").style.display = "block";
                document.getElementById("ifLetter").style.display = "none";
            }
            else {
                document.getElementById("ifLetter").style.display = "none";
                document.getElementById("ifPackage").style.display = "none";
                document.getElementById("packageSize").style.display = "none";
                document.getElementById("packageWeight").style.display = "none";
            }
        }
    </script>

    <script>
      document.getElementById('stateSelector').onchange = function() {
        localStorage.setItem('selectedtem', document.getElementById('stateSelector').value);
      };

      if (localStorage.getItem('selectedtem')) {
        document.getElementById('stateSelector').options[localStorage.getItem('selectedtem')].selected = true;
      }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
