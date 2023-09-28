CREATE DATABASE TAILOR;

USE TAILOR;

CREATE TABLE ADMINS (
    adminID INT PRIMARY KEY AUTO_INCREMENT,
    adminFirst VARCHAR(30),
    adminLast VARCHAR(30),
    adminEmail VARCHAR(50),
    adminContact VARCHAR(13),
    adminProfile VARCHAR(50),
    adminPasscode VARCHAR(30),
    registedDate DATE DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE EMPLOYEES (
    employeeID INT PRIMARY KEY AUTO_INCREMENT,
    employeeFirst VARCHAR(30),
    employeeLast VARCHAR(30),
    employeeEmail VARCHAR(50),
    employeeAddress TINYTEXT,
    employeeContact VARCHAR(13),
    employeeProfile VARCHAR(50),
    employeePasscode VARCHAR(30),
    registedDate DATE DEFAULT CURRENT_TIMESTAMP()
);

CREATE TABLE CUSTOMERS (
    customerID INT PRIMARY KEY AUTO_INCREMENT,
    customerFirst VARCHAR(30),
    customerLast VARCHAR(30),
    customerEmail VARCHAR(50),
    customerAddress TINYTEXT,
    customerContact VARCHAR(13),
    customerProfile VARCHAR(50),
    customerUnique VARCHAR(30) UNIQUE,
    registeredBy INT,
    registedDate DATE DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DEALS (
    dealID INT PRIMARY KEY AUTO_INCREMENT,
    dealTitle VARCHAR(30),
    dealDescription TEXT,
    dealSummary TEXT,
    dealPicture VARCHAR(50),
    registeredBy INT,
    customerId VARCHAR(30),
    registedDate DATE DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (customerId) REFERENCES CUSTOMERS (customerUnique) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO ADMINS (adminID, adminFirst, adminLast, adminEmail, adminContact, adminProfile, adminPasscode) VALUES (NULL, 'Gemini','Child','geminichild@gmail.com','+255628272363','/admin/admin__.jpg','admin123'), (NULL, 'Admin2','MymiddleName','geminichild2@gmail.com','+255628272363','/admin/admin__.jpg','admin123');

INSERT INTO EMPLOYEES (employeeID, employeeFirst, employeeLast, employeeEmail, employeeAddress, employeeContact, employeeProfile, employeePasscode) VALUES (NULL, 'Adam','Smith','employe1@gmail.com','Mbezi Luis','+255628272363','/employee/employee__.jpg','employee1'),(NULL, 'Ryna','Walker','employe2@gmail.com','Goba','+255628272363','/employee/employee__.jpg','employee2');

INSERT INTO CUSTOMERS (customerID, customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerProfile, customerUnique, registeredBy) VALUES (NULL, 'Customer 1','Wayne','customer1@gmail.com','Arusha Mjini','+255628272363','/customers/employee__.jpg','CM2334CM',1),(NULL, 'Customer 2','Doe','customer2@gmail.com','Dodoma Mjini','+255628272363','/customers/employee__.jpg','CM23343M',2);

INSERT INTO DEALS (dealID, dealTitle, dealDescription, dealSummary, dealPicture, registeredBy, customerId) VALUES (NULL, 'Deal 2','Five Feets of pant, Jackects 3m width, row cutting Jackets','3m pants, 1pc cloth','/deals/employee__.jpg',1,'CM2334CM'),(NULL, 'Deal 1','Four Feets of pant, Jackects 3m width, row cutting Jackets','3m pants, 1pc cloth','/deals/employee__.jpg',1,'CM2334CM');