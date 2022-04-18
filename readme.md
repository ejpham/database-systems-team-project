Logins for Website:
    manager@uh.edu 123456 (access level {is_employee} =3)
    employee@uh.edu 123456 (access level {is_employee} =2)
    customer@uh.edu 123456 (access level {is_employee} =1)
    
    
The sections in this readme file consist of the .php file and the description of its corresponding page. 

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
        ()
    Pricing:
    
        pricing.php
        ()
    Contact Us:
        
        contact-us.php
        ()
    Sign In:
        
        sign-in.php
        ()
        
    Reset Password:
    
        reset-password.php
        ()
    Sign Up:
    
        sign-up.php
        ()

Database Access (Employee & Manager Only):
    
    database-access.php
    (This page, as well as every subsequent page here, can only be accessed by anybody that is an employee or a manager.
    Additionally, they would have to be logged into their account to access this page.)

    Postal Service:

        Mail:
        
            ps-mail.php
            ps-mail-orders.php
            ()
        Employees:
            
            ps-employees.php
            ps-employee-shift.php
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
