Logins for Website:
    manager@uh.edu 123456 (access level {is_employee} =3)
    employee@uh.edu 123456 (access level {is_employee} =2)
    customer@uh.edu 123456 (access level {is_employee} =1)
    
    
This readme file is separated into 

Customer Page (Everyone):

    Home:
        index.php
    Mail:
        mail.php
    Pricing:
        pricing.php
    Contact Us:
    
    Sign In:
    
    Reset Password:
    
    Sign Up:

Database Access (Employee & Manager Only):

    Postal Service:

        Mail:

        Employees:
            
            employees.php
            employee-shift.php
            works-at.php
        Managers:

            is_employee {
                1 = customer
                2 = employee
                3 = manager
            }

        Locations:

            location_dept {
                1 = postal office
                2 = warehouse
                3 = corporate
            }

        Vehicles:
        
        Contact Logs:

    Web Logins:

        Users:

    Reports:

        Employee Hours:

            rp-employee-hours-worked.php

        Number of Employeess at Location:
        
            rp-number-of-employees.php

        Total Miles Driven by Vehicle:
        
            rp-miles-driven-by-vehicle.php
