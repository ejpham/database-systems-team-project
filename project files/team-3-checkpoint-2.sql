-- DROP SCHEMA db_PostalService;

CREATE SCHEMA db_PostalService;
-- [team-3-db].db_PostalService.Company_Vehicles definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Company_Vehicles;

CREATE TABLE [team-3-db].db_PostalService.Company_Vehicles (
	Vehicle_ID numeric(10,0) NOT NULL,
	Vehicle_Monthly_Insurance decimal(10,2) NULL,
	Date_Acquired date NOT NULL,
	Insurance_Acquired date NULL,
	vehicle_cost decimal(10,2) NOT NULL,
	CONSTRAINT PK_Vehicle_ID_Constraint PRIMARY KEY (Vehicle_ID)
);


-- [team-3-db].db_PostalService.Employee definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Employee;

CREATE TABLE [team-3-db].db_PostalService.Employee (
	id numeric(18,0) NOT NULL,
	ssn char(9) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	home_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	home_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	home_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	home_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	email_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	dateofbirth date NULL,
	phone_number char(10) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT PK_Employee PRIMARY KEY (id)
);


-- [team-3-db].db_PostalService.Location definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Location;

CREATE TABLE [team-3-db].db_PostalService.Location (
	state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	num_of_employees int NOT NULL,
	id numeric(18,0) NOT NULL,
	address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	location_type varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_Location PRIMARY KEY (id)
);


-- [team-3-db].db_PostalService.Recipient definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Recipient;

CREATE TABLE [team-3-db].db_PostalService.Recipient (
	name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_Recipient PRIMARY KEY (name,address,city,state,zipcode)
);


-- [team-3-db].db_PostalService.Sender definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Sender;

CREATE TABLE [team-3-db].db_PostalService.Sender (
	name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	CONSTRAINT PK_Sender PRIMARY KEY (name,address,city,state,zipcode)
);


-- [team-3-db].db_PostalService.Employee_Salary definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Employee_Salary;

CREATE TABLE [team-3-db].db_PostalService.Employee_Salary (
	yearly_salary decimal(10,2) NULL,
	Yearly_Taxes_Witheld decimal(10,2) NULL,
	last_payment_date date NULL,
	last_payment_check decimal(10,2) NULL,
	employee_id numeric(18,0) NOT NULL,
	Last_Payment_Taxes decimal(10,2) NULL,
	Hours_Worked_Last_Paystub decimal(5,2) NULL,
	CONSTRAINT FK_Employee_ID FOREIGN KEY (employee_id) REFERENCES [team-3-db].db_PostalService.Employee(id)
);


-- [team-3-db].db_PostalService.Mail_Carrier definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Mail_Carrier;

CREATE TABLE [team-3-db].db_PostalService.Mail_Carrier (
	carrier_id numeric(18,0) NOT NULL,
	employee_id numeric(18,0) NOT NULL,
	shift_start datetime NOT NULL,
	shift_end datetime NULL,
	CONSTRAINT PK_Carrier PRIMARY KEY (carrier_id),
	CONSTRAINT FK_carrieremployee FOREIGN KEY (employee_id) REFERENCES [team-3-db].db_PostalService.Employee(id)
);


-- [team-3-db].db_PostalService.Manager definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Manager;

CREATE TABLE [team-3-db].db_PostalService.Manager (
	manager_id numeric(18,0) NOT NULL,
	employee_id numeric(18,0) NOT NULL,
	location_id numeric(18,0) NOT NULL,
	CONSTRAINT PK_Manager_ID PRIMARY KEY (manager_id),
	CONSTRAINT FK_Managers_Employee_ID FOREIGN KEY (employee_id) REFERENCES [team-3-db].db_PostalService.Employee(id),
	CONSTRAINT FK_Manages_Location_ID FOREIGN KEY (location_id) REFERENCES [team-3-db].db_PostalService.Location(id)
);


-- [team-3-db].db_PostalService.Vehicle_Uses definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Vehicle_Uses;

CREATE TABLE [team-3-db].db_PostalService.Vehicle_Uses (
	Vehicle_ID numeric(10,0) NOT NULL,
	Date_Taken_out datetime NOT NULL,
	Date_Returned datetime NULL,
	mail_carrier_id numeric(18,0) NOT NULL,
	Start_Location_id numeric(18,0) NOT NULL,
	End_Location_id numeric(18,0) NULL,
	CONSTRAINT FK_Location_id FOREIGN KEY (Start_Location_id) REFERENCES [team-3-db].db_PostalService.Location(id),
	CONSTRAINT FK_Location_id_End FOREIGN KEY (End_Location_id) REFERENCES [team-3-db].db_PostalService.Location(id),
	CONSTRAINT FK_carrieridvehicleuse FOREIGN KEY (mail_carrier_id) REFERENCES [team-3-db].db_PostalService.Mail_Carrier(carrier_id),
	CONSTRAINT Vehicle_ID_Constraint FOREIGN KEY (Vehicle_ID) REFERENCES [team-3-db].db_PostalService.Company_Vehicles(Vehicle_ID)
);


-- [team-3-db].db_PostalService.WORKS_AT definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.WORKS_AT;

CREATE TABLE [team-3-db].db_PostalService.WORKS_AT (
	employee_id numeric(18,0) NOT NULL,
	location_id numeric(18,0) NOT NULL,
	employment_date date NOT NULL,
	CONSTRAINT FK_Employee_ID_Worksat FOREIGN KEY (employee_id) REFERENCES [team-3-db].db_PostalService.Employee(id),
	CONSTRAINT FK_Location FOREIGN KEY (location_id) REFERENCES [team-3-db].db_PostalService.Location(id)
);


-- [team-3-db].db_PostalService.Zipcodes definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Zipcodes;

CREATE TABLE [team-3-db].db_PostalService.Zipcodes (
	zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	assigned_location_id numeric(18,0) NOT NULL,
	CONSTRAINT PK_Zipcodes PRIMARY KEY (zipcode),
	CONSTRAINT FK_Zipcode_Under_Location FOREIGN KEY (assigned_location_id) REFERENCES [team-3-db].db_PostalService.Location(id)
);


-- [team-3-db].db_PostalService.Mail definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Mail;

CREATE TABLE [team-3-db].db_PostalService.Mail (
	tracking_number char(40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	mail_type char(6) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	shipping_class varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	shipping_cost decimal(10,2) NOT NULL,
	label_created datetime NULL,
	delivered_on datetime NULL,
	CONSTRAINT PK_Mail PRIMARY KEY (tracking_number),
	CONSTRAINT FK_MAIL_TO FOREIGN KEY (to_name,to_address,to_city,to_state,to_zipcode) REFERENCES [team-3-db].db_PostalService.Recipient(name,address,city,state,zipcode),
	CONSTRAINT FK_SEND_FROM FOREIGN KEY (from_name,from_address,from_city,from_state,from_zipcode) REFERENCES [team-3-db].db_PostalService.Sender(name,address,city,state,zipcode),
	CONSTRAINT FK_fromZipcode_assignedLoc FOREIGN KEY (from_zipcode) REFERENCES [team-3-db].db_PostalService.Zipcodes(zipcode),
	CONSTRAINT FK_toZipcode_assignedLoc FOREIGN KEY (to_zipcode) REFERENCES [team-3-db].db_PostalService.Zipcodes(zipcode)
);
