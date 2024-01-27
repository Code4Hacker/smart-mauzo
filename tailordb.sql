DROP DATABASE ONLINE;

CREATE DATABASE ONLINE;

USE ONLINE;

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
CREATE TABLE PRODUCT (
    productId int AUTO_INCREMENT PRIMARY KEY,
    productName VARCHAR(255) UNIQUE,
    sellingPrice int DEFAULT 0,
    buyingPrice int,
    quantity int DEFAULT 1,
    deleted VARCHAR(2) DEFAULT 'FL',
    registedDate DATE DEFAULT CURRENT_TIMESTAMP()
);
CREATE TABLE WORKERS (
    workerID INT PRIMARY KEY AUTO_INCREMENT,
    workerName VARCHAR(255) UNIQUE
);
CREATE TABLE SOLD (
    cID INT PRIMARY KEY AUTO_INCREMENT,
    customerId VARCHAR(30),
    quantity int,
    price int,
    productN VARCHAR(255),
    registedDate DATE DEFAULT CURRENT_TIMESTAMP()
);
ALTER TABLE SOLD 
    ADD 
    FOREIGN KEY (customerId) REFERENCES CUSTOMERS (customerUnique) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE SOLD 
    ADD 
    FOREIGN KEY (productN) REFERENCES PRODUCT (productName) ON DELETE CASCADE ON UPDATE CASCADE;


-- CREATE TABLE STOCKS (
--     stockID INT PRIMARY KEY AUTO_INCREMENT,
--     stockTitle VARCHAR(60),
--     stockDes TEXT,
--     stockCost INT,
--     registeredBy INT,
--     stockImage VARCHAR(40),
--     quantity INT,
--     deleted VARCHAR(6) DEFAULT 'false',
--     category VARCHAR(50),
--     dateIn DATE DEFAULT CURRENT_TIMESTAMP(),
--     FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE
-- );
