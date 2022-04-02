<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Post Office</title>
        <link rel="stylesheet" href="Style.css">
    </head>
    <body>
        <div class = "container">
            <!-- Navigation-->
            <nav class="navbar">
                <div class="brand-name">
                    <h5>Post Office</h5>
                    <h6>Sign Up</h6>
                </div>
                <div class="nav-items">
                    <ul class="navbar-nav">
                        <!--<li class="nav-link">Mail</li>-->
                        <!-- D-Ten: I'm trying to make the class items become links-->
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
                <p>Fill out the form to create an account.</p>
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
