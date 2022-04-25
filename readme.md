Logins for Website:
    manager@uh.edu  123456 (access_level = 3)
    employee@uh.edu 123456 (access_level = 2)
    customer@uh.edu 123456 (access_level = 1)
    
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
            (The Employees page by clicking on the Employees button on the left side of the page displays the information of all employees registered. 
            Employees are only able to see information like First Name, Middle Inital, and Last Name of other employees as well as E-mail Addresses 
            and Manager IDs of manager employees. Managers of this Postal Office, however, are able to see more of every Employee's registered information,
            and this information include the Employee ID, their First Name, Middle Initial, and Last Name, their Date of Birth, Home Address, City, Zipcode,
            E-mail Address, Phone Number, SSN, and Manager ID if they have one. Only Managers are able to add new Employees to the roster, and those
            new Employees will be given a new Employee ID number once added.)
            
            ps-employee-shift.php
            (You can view the Employee Shift page, whether an Employee or Manager, and be shown the details of the past shifts worked by employees 
            of the establishment. These details are the Shift ID numbers, Employee ID numbers, Year-Month-Day and timestamp of the Start of Shifts 
            and End of Shifts. When an employee wants to Clock In for their shift, all is asked from them is to enter their Employee ID number
            and click the Clock In button to start their shift. And once they are finished for the day, they can click the Clock Out button on 
            the buttom left of the page and the time of their shift is recorded in the system.)
            
            ps-works-at.php
            (The Employee Works At page can be accessed from the main Employees page. You are then presented a table that displays the 
            Employee IDs, Location ID [of where that employee with the corresponding Employee ID works at], and their Employement Date. 
            Normal employees do NOT have the ability to change their own Location ID; only Managers have the power to change the 
            Location IDs of every Employee working at the establishment. Managers are also the only ones who can add a New Employee 
            to this table by inserting that Employee's ID number and the Location ID of where they will be working at.)
        Managers:

            ps-managers.php
            (The Managers page is used to display the employees that are assigned the Manager role in the Postal Office. 
            You are only able to access this page if you are either an Employee or a Manager: access_level 
            {1 = customer, 2 = employee, 3 = manager}. Accounts for this Postal Service are assigned an access_level number.
            Employees are only able to view the Managers table that displays the Manager ID, Last Name of that Manager,
            and that Manager's Employee ID. Managers, however, are able to view the table as well as add a new employee
            as a manager and delete a manager from the table.)

        Locations:
            
            ps-locations.php
            (The Locations page shows a table of the registered locations that the Postal Service utilizes. 
            As an Employee, only the Location ID, Address, City, State, Zipcode, and Department type of that location are visible. 
            However as a Manager, in addition to the Location information being available, those of Manager status are able to add 
            a new registered location to the table as well as remove any locations from the table.)
        Vehicles:
            
            ps-vehicles.php
            (By accessing the Vehicles page, you are presented with a table that displays the Vehicle ID, total Vehicle 
            Miles [that the Vehicle has driven during its time registered in the Postal Office], Vehicle Cost, 
            and Vehicle Type of a registered Vehicle. When logged on as an Employee, you are only able to view 
            the table information. On the other hand, when logged on as a Manager, you are able to view the table 
            information as well as add a new vehicle to register or delete a vehicle from the 
            table [this happens when a vehicle is sold/needed to get rid of].)
            
            ps-vechicle-use.php
            (You can view the Vehicle Use page by clicking on the Vehicle Use button on the bottom of the Vehicles page. 
            This page is to keep track of the times a registered Vehicle is used during an Employee Shift. 
            Both Employees and Managers are able to check the table for the Vehicle's Log ID, Vehicle ID number, 
            the Employee ID of the Employee that drove that Vehicle, the Date Departed and Returned, the Start Location ID, 
            the End Location ID, and the Miles Driven. Employees and Managers are also both able to clock in a 
            "shift" when using a Vehicle by inputting the Vehicle ID and Start Location ID. Once their shift is finished, 
            the Vehicle needs to be clocked out along with the End Location ID and the Miles Driven for that shift; 
            the Miles Driven amount is then added to the total Vehicle Miles on the Vehicles Page.)
        Contact Logs:
            
            ps-contact-logs.php
            (The Contact Logs page is used to display all of the messages sent from the Customers on the 
            Contact Us page. This table includes information such as the Log ID of the message, the 
            Customer's Full Name, E-mail Address, the Message they sent, and the Date Received of that Message. 
            Both Employees and Managers are able to view this page.)
    Web Logins:

        Users:
            
            wl-users.php
            (By accessing the Users Page under the Web Logins section, you are able to view the information of 
            registered Users that have accounts for this Postal Service. The information includes the User ID number,
            the User's Name, E-mail Address, the Date Created for their account, and the User's Access Level. When logged 
            in as an Employee, you are only allowed to view the information of Users with an Access Level of 1; Employees 
            are not allowed to view information of other Employees or Managers and can only delete Users with an Access Level 
            of 1 [a Customer] from the table [which deletes that account from the Postal Service]. By being logged in 
            as a Manager, you have access to every registered User's information on the table and are allowed to delete 
            any User from the table. In addition to this, Managers are the only ones able to change the Access Levels 
            of Users, which is used to register new Employees once they have created an account, giving those Employees 
            access to the Database Access page.)
    Reports:
        [Only Managers are able to view the Reports section of the Database Access page.]
        
        Employee Hours:

            rp-employee-hours-worked.php
            ()
        Number of Employeess at Location:
        
            rp-number-of-employees.php
            ()
        Total Miles Driven by Vehicle:
        
            rp-miles-driven-by-vehicle.php
            ()
