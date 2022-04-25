CREATE DATABASE `PostalService` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */

-- PostalService.Company_Vehicle definition

CREATE TABLE `Company_Vehicle` (
  `vehicle_id` int NOT NULL AUTO_INCREMENT,
  `vehicle_miles` int NOT NULL DEFAULT '0',
  `vehicle_cost` decimal(18,2) NOT NULL,
  `vehicle_type` varchar(25) NOT NULL,
  PRIMARY KEY (`vehicle_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Contact_Logs definition

CREATE TABLE `Contact_Logs` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(75) NOT NULL,
  `email` varchar(75) NOT NULL,
  `message` varchar(255) NOT NULL,
  `received` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Employee definition

CREATE TABLE `Employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `minit` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `home_address` varchar(255) NOT NULL,
  `home_city` varchar(50) NOT NULL,
  `home_state` char(2) NOT NULL,
  `home_zipcode` varchar(5) NOT NULL,
  `email` varchar(75) NOT NULL,
  `phone_number` char(10) NOT NULL,
  `ssn` char(9) NOT NULL,
  `manager_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `Strikes` int NOT NULL DEFAULT '0',
  `hourly_wage` decimal(18,2) NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `ssn` (`ssn`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone_number` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Employee definition

CREATE TABLE `Employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `minit` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `last_name` varchar(30) NOT NULL,
  `dob` date NOT NULL,
  `home_address` varchar(255) NOT NULL,
  `home_city` varchar(50) NOT NULL,
  `home_state` char(2) NOT NULL,
  `home_zipcode` varchar(5) NOT NULL,
  `email` varchar(75) NOT NULL,
  `phone_number` char(10) NOT NULL,
  `ssn` char(9) NOT NULL,
  `manager_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `Strikes` int NOT NULL DEFAULT '0',
  `hourly_wage` decimal(18,2) NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `ssn` (`ssn`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone_number` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Location definition

CREATE TABLE `Location` (
  `location_id` int NOT NULL AUTO_INCREMENT,
  `location_address` varchar(255) NOT NULL,
  `location_city` varchar(50) NOT NULL,
  `location_state` char(2) NOT NULL,
  `location_zipcode` varchar(5) NOT NULL,
  `location_dept` varchar(25) NOT NULL,
  PRIMARY KEY (`location_id`),
  UNIQUE KEY `location_address` (`location_address`),
  KEY `location_zipcode` (`location_zipcode`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Mail definition

CREATE TABLE `Mail` (
  `mail_id` int NOT NULL AUTO_INCREMENT,
  `mail_type` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `from_name` varchar(75) NOT NULL,
  `from_address` varchar(255) NOT NULL,
  `from_city` varchar(50) NOT NULL,
  `from_state` char(2) NOT NULL,
  `from_zipcode` varchar(5) NOT NULL,
  `to_name` varchar(75) NOT NULL,
  `to_address` varchar(255) NOT NULL,
  `to_city` varchar(50) NOT NULL,
  `to_state` char(2) NOT NULL,
  `to_zipcode` varchar(5) NOT NULL,
  `shipping_class` varchar(25) NOT NULL,
  `shipping_cost` decimal(18,2) NOT NULL,
  `label_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `delivered_on` datetime DEFAULT NULL,
  `tracking_number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`mail_id`),
  KEY `to_zipcode` (`to_zipcode`),
  KEY `from_zipcode` (`from_zipcode`),
  KEY `idx_trackingnum` (`tracking_number`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.MailOrders definition

CREATE TABLE `MailOrders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `trackingNumber` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `packageSize` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `packageWeight` int DEFAULT NULL,
  `billingAddress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `senders_email` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `idx_trackingnum` (`trackingNumber`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Manager definition

CREATE TABLE `Manager` (
  `manager_id` int NOT NULL AUTO_INCREMENT,
  `manager_lname` varchar(30) NOT NULL,
  `employee_id` int NOT NULL,
  PRIMARY KEY (`manager_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `Manager_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.Vehicle_Use definition

CREATE TABLE `Vehicle_Use` (
  `log_id` int NOT NULL AUTO_INCREMENT,
  `vehicle_id` int NOT NULL,
  `driven_by_employee_id` int NOT NULL,
  `date_departed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_returned` datetime DEFAULT NULL,
  `start_location_id` int NOT NULL,
  `end_location_id` int DEFAULT NULL,
  `miles_driven` int DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `vehicle_id` (`vehicle_id`),
  KEY `start_location_id` (`start_location_id`),
  KEY `end_location_id` (`end_location_id`),
  KEY `driven_by_employee_id` (`driven_by_employee_id`),
  CONSTRAINT `Vehicle_Use_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `Company_Vehicle` (`vehicle_id`),
  CONSTRAINT `Vehicle_Use_ibfk_2` FOREIGN KEY (`start_location_id`) REFERENCES `Location` (`location_id`),
  CONSTRAINT `Vehicle_Use_ibfk_3` FOREIGN KEY (`end_location_id`) REFERENCES `Location` (`location_id`),
  CONSTRAINT `Vehicle_Use_ibfk_4` FOREIGN KEY (`driven_by_employee_id`) REFERENCES `Employee` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- PostalService.WORKS_AT definition

CREATE TABLE `WORKS_AT` (
  `employee_id` int NOT NULL,
  `location_id` int NOT NULL,
  `employment_date` date NOT NULL DEFAULT (curdate()),
  UNIQUE KEY `employee_id` (`employee_id`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `WORKS_AT_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `Employee` (`employee_id`),
  CONSTRAINT `WORKS_AT_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `Location` (`location_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE DEFINER=`admin`@`%` TRIGGER `add_miles` AFTER UPDATE ON `Vehicle_Use` FOR EACH ROW UPDATE PostalService.Company_Vehicle 
	SET vehicle_miles = (PostalService.Company_Vehicle.vehicle_miles + NEW.miles_driven)
	WHERE NEW.vehicle_id = vehicle_id
    
CREATE DEFINER=`admin`@`%` TRIGGER `add_manager_id_to_employee` AFTER INSERT ON `Manager` FOR EACH ROW UPDATE PostalService.Employee 
	SET manager_id = NEW.manager_id
	WHERE NEW.employee_id = employee_id
    
CREATE DEFINER=`admin`@`%` TRIGGER `remove_manager_id_from_employee` AFTER DELETE ON `Manager` FOR EACH ROW UPDATE PostalService.Employee 
	SET manager_id = NULL
	WHERE employee_id = OLD.employee_id
    
CREATE DEFINER=`admin`@`%` TRIGGER `delete_vehicle_use_log` BEFORE DELETE ON `Company_Vehicle` FOR EACH ROW DELETE FROM PostalService.Vehicle_Use 
	WHERE vehicle_id = OLD.vehicle_id
    
CREATE DEFINER=`admin`@`%` TRIGGER `timestamp_delivery_on_delivered` AFTER UPDATE ON `MailOrders` FOR EACH ROW BEGIN
    IF (NEW.status = 'Delivered') THEN
        UPDATE Mail SET delivered_on = now() WHERE NEW.trackingNumber = tracking_number;
    END IF;
END
    
CREATE DEFINER=`admin`@`%` TRIGGER `Mail_Checker` BEFORE INSERT ON `Mail` FOR EACH ROW BEGIN
	IF ((SELECT COUNT(mail_id) FROM PostalService.Mail WHERE PostalService.Mail.to_address = NEW.to_address AND TIMESTAMPDIFF(HOUR, label_created , now()) < 24) > 3) THEN
		signal sqlstate '45000' SET MESSAGE_TEXT = "No more than 4 packages can be sent to this address in the last 24 hours";
	END IF;
END

CREATE DEFINER=`admin`@`%` TRIGGER `Employee_ShiftStrike_Adder` AFTER UPDATE ON `Employee_Shift` FOR EACH ROW BEGIN
	DECLARE identification int;
	SET identification = NEW.employee_id;
	UPDATE PostalService.Employee SET Strikes = (Strikes + 1) WHERE employee_id = identification AND (SELECT TIMESTAMPDIFF(MINUTE, PostalService.Employee_Shift.shift_start , PostalService.Employee_Shift.shift_end) FROM PostalService.Employee_Shift WHERE shift_id = NEW.shift_id) > 480;
	UPDATE PostalService.Employee SET hourly_wage = hourly_wage - .10 WHERE employee_id = identification AND Strikes % 3 = 0 AND Strikes != 0;
END

CREATE DEFINER=`admin`@`%` TRIGGER `Employee_Salary_Checker` BEFORE INSERT ON `Employee` FOR EACH ROW BEGIN
	DECLARE counter int;
	IF ((SELECT COUNT(*) FROM PostalService.Employee WHERE manager_id != '' AND hourly_wage < NEW.hourly_wage) > 0) THEN
		signal sqlstate '45000';
	END IF;
END

CREATE DATABASE `WebLogins` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */

-- WebLogins.users definition

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(75) NOT NULL,
  `name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `access_level` tinyint(1) NOT NULL,
  `security_question` varchar(255) NOT NULL,
  `security_answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE DEFINER=`admin`@`%` TRIGGER `set_user_id_if_signed_up` AFTER INSERT ON `users` FOR EACH ROW BEGIN
	IF ((SELECT COUNT(email) FROM PostalService.Employee WHERE email = NEW.email) = 1) THEN 
		UPDATE PostalService.Employee SET user_id = NEW.id WHERE email = NEW.email;
	END IF;
END
