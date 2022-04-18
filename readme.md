Logins for Website:
    manager@uh.edu 123456 (access level {is_employee} =3)
    employee@uh.edu 123456 (access level {is_employee} =2)
    customer@uh.edu 123456 (access level {is_employee} =1)
    
    
The sections in this readme file consist of the .php file and the description of its corresponding page on the web application. 

Customer Page (Everyone):

    Home:
    
        index.php
        (This is the main page of our web application. It provides links to the Mail-sending page, Pricing list, and
        Contact-Us page. While NOT signed in, on the top right section there are Sign In and Sign Up buttons)
    Mail:
    
        mail.php
        (Clicking on the Mail button on the main page sends you to the Mail page, where you can send mail. You are asked 
        to first put in your full name, email address, your own address, and then input the recipient's full name and 
        address. Once filled out, you can choose between sending a Letter or a Package. Picking Letter, you can choose
        between Regular or Premium letter speed [how quick the letter will be sent to the recipient], and you'll be given
        the total price [only depending on the letter speed] and asked to put in your payment information. Picking 
        Package, you can choose between Regular or Premium package speed as well as the dimensions of the package you 
        are sending. Additionally, a slidebar is shown to pick the weight of that package. The total price of the package
        [depending on the package speed, dimensions, and weight] is shown and you are then asked for your payment info.)
        
        tracking.php
        (In the Mail page towards the top, if you already have a mail order created, you can click the link to keep 
        track of that order. When you click the link, you are asked to provide the tracking number of your mail order. 
        If you input a valid Tracking Number, you can receive the status of your mail order; the statuses are: Label
        Created, Processing, In Transit, Out for Delivery, and Delivered. On the other hand, if you enter this page and
        you have not sent a mail order, there is a link that will send you back to the Mail page to send an order out.)
    Pricing:
    
        pricing.php
        (The Pricing page shows a list of the different pricings of the package selections from the Mail page. This is only 
        relevant for packages because the prices for letters consist of only the type of delivery speed for those letters,
        so the prices can be easily displayed on the Mail page.)
    Contact Us:
        
        contact-us.php
        (If you want to send a message to the establishment, you can click the Contact Us button to do so. When NOT signed
        in, you are asked to put your Full Name and E-mail Address before you can send a message. Otherwise, if you are
        signed into your account, your registered name and email are shown. The maximum number of characters in your
        message is 255.)
    Sign In:
        
        sign-in.php
        (If you already have an account, you can click the Sign In button on the Home page; once you have, input your
        registered E-mail Address and Password. If you put in the correct credentials, you are signed into your account.
        If not, en error message will appear mentioning "Invalid e-mail address or password".)
    Reset Password:
    
        reset-password.php
        (You can click this link on the Sign In page if you have forgotten your password. You are then prompted to fill
        out a form in order to reset your password. Inputting your E-mail Address is first. Then, you are given a dropbox
        to pick a security question to answer [the chosen security question is picked during the sign-up of your account,
        and the question you chose and answered during sign-up will be recorded  //in the database// and used in the case
        of a forgotten password]. After, you can input a new password to replace your old one, and the process is finished
        once you click the Reset Password button.)
    Sign Up:
    
        sign-up.php
        (If you do not have an account for this Post Office, you can create one by clicking on the Sign Up button on the 
        Main page at the top OR on the Sign In page at the bottom. The account creation process starts with you being
        for your Full Name and the E-mail Address you'll use for this account. Then, you are asked to input a Password 
        and confirm that Password. You are given a dropbox to choose a security question [which will be used to help reset
        your Password] and answer for that question. Once all of this has been completed, you can click the Sign Up button
        and your account will now have been created.)

Database Access (Employee & Manager Only):
    
    database-access.php
    (This page, as well as every subsequent page here, can only be accessed by anybody that is an employee or a manager.
    Additionally, they would have to be logged into their account to access this page.)

    Postal Service:

        Mail:
        
            ps-mail.php
            (This page lists out details of the Mail orders made to this Postal Office. These details include the Mail ID 
            [the order of the Mail requests made], the Mail type, the Sender's info [Name, Address, City, State, and 
            Zipcode], the Receiver's info [Name, Address, City, State, and Zipcode], the Shipping Class, the Shipping Cost,
            the date of the Mail's Label's creation, Delivered-on date, and the Mail's Tracking Number.)
            
            ps-mail-orders.php
            (By clicking on the Mail-Orders button on the bottom of the Mail page, employees are able to view the details of all the Mail 
            orders made through this web application. These details include the Order ID of that mail, that Mail's Tracking Number, 
            the Status of that Mail Order [Label Created, Processing, In Transit, Out for Delivery, Delivered][the employee can 
            update the Status of the Order by picking any of the corresponding names], the Size of the Package [if it is a letter 
            order, no sizes are displayed], the Weight of the Package [if letter order, no weight amount is displayed], the
            Billing Address of the Sender, and the Sender's E-mail.)
        Employees:
            
            ps-employees.php
            ()
            ps-employee-shift.php
            ()
            ps-works-at.php
            ()
        Managers:

            ps-managers.php
            ()
            is_employee {
                1 = customer
                2 = employee
                3 = manager
            }

        Locations:
            
            ps-locations.php
            ()
            location_dept {
                1 = postal office
                2 = warehouse
                3 = corporate
            }
        Vehicles:
            
            ps-vehicles.php
            ()
            ps-vechicle-use.php
            ()
        Contact Logs:
            
            ps-contact-logs.php
            ()
    Web Logins:

        Users:
            
            wl-users.php
            ()
    Reports:

        Employee Hours:

            rp-employee-hours-worked.php
            ()
        Number of Employeess at Location:
        
            rp-number-of-employees.php
            ()
        Total Miles Driven by Vehicle:
        
            rp-miles-driven-by-vehicle.php
            ()
