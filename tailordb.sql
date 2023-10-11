DROP DATABASE TAILOR;

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
    deleted VARCHAR(6) DEFAULT 'false',
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
    deleted VARCHAR(6) DEFAULT 'false',
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
    deleted VARCHAR(6) DEFAULT 'false',
    FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE DEALS (
    dealID INT PRIMARY KEY AUTO_INCREMENT,
    dealTitle VARCHAR(30),
    dealDescription TEXT,
    dealRequirements TINYTEXT,
    dealPicture VARCHAR(50),
    registeredBy INT,
    customerId VARCHAR(30),
    price VARCHAR(100),
    measurements TEXT,
    categories VARCHAR(40),
    dealStatus VARCHAR(30) DEFAULT 'PENDING',
    tracking VARCHAR(30) DEFAULT 'IN PRODUCTION',
    quantity INT,
    deleted VARCHAR(6) DEFAULT 'false',
    registedDate DATE DEFAULT CURRENT_TIMESTAMP(),
    dateOut DATE
);

ALTER TABLE DEALS ADD FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE DEALS ADD FOREIGN KEY (customerId) REFERENCES CUSTOMERS (customerUnique) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO ADMINS (adminID, adminFirst, adminLast, adminEmail, adminContact, adminProfile, adminPasscode) VALUES (NULL, 'Gemini','Child','geminichild@gmail.com','+255628272363','/admin/admin__.jpg','admin123'), (NULL, 'Admin2','MymiddleName','geminichild2@gmail.com','+255628272363','/admin/admin__.jpg','admin123');

INSERT INTO EMPLOYEES (employeeID, employeeFirst, employeeLast, employeeEmail, employeeAddress, employeeContact, employeeProfile, employeePasscode) VALUES (NULL, 'Adam','Smith','employe1@gmail.com','Mbezi Luis','+255628272363','/employee/employee__.jpg','employee1'),(NULL, 'Ryna','Walker','employe2@gmail.com','Goba','+255628272363','/employee/employee__.jpg','employee2');

INSERT INTO CUSTOMERS (customerID, customerFirst, customerLast, customerEmail, customerAddress, customerContact, customerProfile, customerUnique, registeredBy) VALUES (NULL, 'Customer 1','Wayne','customer1@gmail.com','Arusha Mjini','+255628272363','/profiles/profile.jpg','CM2334CM',1),(NULL, 'Customer 2','Doe','customer2@gmail.com','Dodoma Mjini','+255628272363','/profiles/profile.jpg','CM23343M',2);

INSERT INTO DEALS (dealID, dealTitle, dealDescription, dealRequirements, dealPicture, registeredBy, customerId, price, measurements, categories, quantity) VALUES (NULL, 'Deal 2','Rendering code is browser- and platform-independent which provides increased compatibility and portability. If it renders once, it will render anytime.
The size of the JavaScript library is fixed and doesn\'t depend on the features used. And it\'s actually really tiny ','demo shooes 3 inches','/deals/employee__.jpg',2,'CM23343M','203900', 'L - 50ft, W - 30cm, HPS - 34inch', 'Men Trouser', 10),(NULL, 'Deal 1','For some charts, data has to be uploaded to Google servers for the chart to be rendered. If you deal with sensitive data, please check the Google APIs Terms of Service. Also, make sure to always check the Data Policy sections in the docs. In this tutorial','32ft cloth pt','/deals/employee__.jpg',1,'CM2334CM',548900, 'L - 54ft, W - 34cm, HPS - 34inch', 'Men Trouser', 3),(NULL, 'Deal 3','For some charts, data has to be uploaded to Google servers for the chart to be rendered. If you deal with sensitive data, please check the Google APIs Terms of Service. Also, make sure to always check the Data Policy sections in the docs. In this tutorial','32ft cloth pt','/deals/employee__.jpg',1,'CM2334CM',548900, 'L - 26ft, W - 37cm, HPS - 34inch','Women Skirt/Trouser', 6);