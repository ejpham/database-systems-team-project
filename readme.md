Logins for Website:
    manager@uh.edu 123456 (access level {is_employee} =3)
    employee@uh.edu 123456 (access level {is_employee} =2)
    customer@uh.edu 123456 (access level {is_employee} =1)
    
    
The sections in this readme file consist of the .php file and the description of its corresponding page. 

Customer Page (Everyone):

    Home:
    
        index.php
    Mail:
    
        mail.php
    Pricing:
    
        pricing.php
    Contact Us:
        
        contact-us.php
    
    Sign In:
        
        sign-in.php
        Takes you 
        
    Reset Password:
    
        reset-password.php
    
    Sign Up:
    
        sign-up.php
        

Database Access (Employee & Manager Only):
    
    database-access.php
    (This page, as well as every subsequent page here, can only be accessed by anybody that is an employee or a manager.
    Additionally, they would have to be logged into their account to access this page)

    Postal Service:

        Mail:
        
            ps-mail.php
            ps-mail-orders.php
        Employees:
            
            ps-employees.php
            ps-employee-shift.php
            ps-works-at.php
        Managers:

            ps-managers.php
            
            is_employee {
                1 = customer
                2 = employee
                3 = manager
            }

        Locations:
            
            ps-locations.php
            
            location_dept {
                1 = postal office
                2 = warehouse
                3 = corporate
            }
        Vehicles:
            
            ps-vehicles.php
            ps-vechicle-use.php
            
        Contact Logs:
            
            ps-contact-logs.php
    Web Logins:

        Users:
            
            wl-users.php

    Reports:

        Employee Hours:

            rp-employee-hours-worked.php

        Number of Employeess at Location:
        
            rp-number-of-employees.php

        Total Miles Driven by Vehicle:
        
            rp-miles-driven-by-vehicle.php
