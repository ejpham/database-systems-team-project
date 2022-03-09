-- COSC 3380 - MonWed 5:30pm-7:00pm - Team 3 Checkpoint 2 Feedback

-- DROP SCHEMA db_PostalService;

CREATE SCHEMA db_PostalService;
-- [team-3-db].db_PostalService.Employee definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Employee;

CREATE TABLE [team-3-db].db_PostalService.Employee (
	id numeric(10,0) NOT NULL,
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
	typeofestablishment char(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	tracking_number char(40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	id numeric(18,0) NOT NULL,
	CONSTRAINT PK_Location PRIMARY KEY (id)
);
ALTER TABLE [team-3-db].db_PostalService.Location WITH NOCHECK ADD CONSTRAINT CK__Location__typeof__76969D2E CHECK ([typeofestablishment]='Warehouse' OR [typeofestablishment]='Post Office');


-- [team-3-db].db_PostalService.Mail definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Mail;

CREATE TABLE [team-3-db].db_PostalService.Mail (
	tracking_number char(40) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	mail_type char(6) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	shipping_class varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	shipping_status varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT PK_Mail PRIMARY KEY (tracking_number)
);


-- [team-3-db].db_PostalService.Recipient definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Recipient;

CREATE TABLE [team-3-db].db_PostalService.Recipient (
	to_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	from_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT PK_Recipient PRIMARY KEY (to_name,to_address,to_city,to_state,to_zipcode)
);


-- [team-3-db].db_PostalService.Sender definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.Sender;

CREATE TABLE [team-3-db].db_PostalService.Sender (
	from_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	from_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NOT NULL,
	to_name varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_address varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_city varchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_state char(2) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	to_zipcode char(5) COLLATE SQL_Latin1_General_CP1_CI_AS NULL,
	CONSTRAINT PK_Sender PRIMARY KEY (from_name,from_address,from_city,from_state,from_zipcode)
);


-- [team-3-db].db_PostalService.WORKS_AT definition

-- Drop table

-- DROP TABLE [team-3-db].db_PostalService.WORKS_AT;

CREATE TABLE [team-3-db].db_PostalService.WORKS_AT (
	employee_id numeric(10,0) NOT NULL,
	location_id numeric(18,0) NOT NULL,
	employment_date date NOT NULL
);


-- [team-3-db].db_PostalService.Location foreign keys

ALTER TABLE [team-3-db].db_PostalService.Location ADD CONSTRAINT FK_MailLocation FOREIGN KEY (tracking_number) REFERENCES [team-3-db].db_PostalService.Mail(tracking_number);


-- [team-3-db].db_PostalService.Mail foreign keys

ALTER TABLE [team-3-db].db_PostalService.Mail ADD CONSTRAINT FK_MailRecipient FOREIGN KEY (to_name,to_address,to_city,to_state,to_zipcode) REFERENCES [team-3-db].db_PostalService.Recipient(to_name,to_address,to_city,to_state,to_zipcode);
ALTER TABLE [team-3-db].db_PostalService.Mail ADD CONSTRAINT FK_MailSender FOREIGN KEY (from_name,from_address,from_city,from_state,from_zipcode) REFERENCES [team-3-db].db_PostalService.Sender(from_name,from_address,from_city,from_state,from_zipcode);


-- [team-3-db].db_PostalService.Recipient foreign keys

ALTER TABLE [team-3-db].db_PostalService.Recipient ADD CONSTRAINT FK_RecipientSender FOREIGN KEY (from_name,from_address,from_city,from_state,from_zipcode) REFERENCES [team-3-db].db_PostalService.Sender(from_name,from_address,from_city,from_state,from_zipcode);


-- [team-3-db].db_PostalService.Sender foreign keys

ALTER TABLE [team-3-db].db_PostalService.Sender ADD CONSTRAINT FK_SenderRecipient FOREIGN KEY (to_name,to_address,to_city,to_state,to_zipcode) REFERENCES [team-3-db].db_PostalService.Recipient(to_name,to_address,to_city,to_state,to_zipcode);


-- [team-3-db].db_PostalService.WORKS_AT foreign keys

ALTER TABLE [team-3-db].db_PostalService.WORKS_AT ADD CONSTRAINT FK_Employee FOREIGN KEY (employee_id) REFERENCES [team-3-db].db_PostalService.Employee(id);
ALTER TABLE [team-3-db].db_PostalService.WORKS_AT ADD CONSTRAINT FK_Location FOREIGN KEY (location_id) REFERENCES [team-3-db].db_PostalService.Location(id);
