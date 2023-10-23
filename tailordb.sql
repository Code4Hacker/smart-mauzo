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

CREATE TABLE WORKERS (
    workerID INT PRIMARY KEY AUTO_INCREMENT,
    workerName VARCHAR(255) UNIQUE
);

CREATE TABLE DEALS (
    dealID INT PRIMARY KEY AUTO_INCREMENT,
    dealTitle VARCHAR(30),
    dealDescription TEXT,
    dealRequirements TINYTEXT,
    registeredBy INT,
    customerId VARCHAR(30),
    dealStatus VARCHAR(30) DEFAULT 'PENDING',
    tracking VARCHAR(30) DEFAULT 'WAITING',
    deleted VARCHAR(6) DEFAULT 'false',
    registedDate DATE DEFAULT CURRENT_TIMESTAMP(),
    mini_employee VARCHAR(255),
    dateOut DATE,
    FOREIGN KEY (mini_employee) REFERENCES WORKERS (workerName) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE CONTENTS (
    cID INT PRIMARY KEY AUTO_INCREMENT,
    dealPicture VARCHAR(50),
    price INT,
    measurements TEXT,
    categories VARCHAR(40),
    quantity INT,
    deleted VARCHAR(6) DEFAULT 'false',
    deal INT,
    FOREIGN KEY (deal) REFERENCES DEALS (dealID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE STOCKS (
    stockID INT PRIMARY KEY AUTO_INCREMENT,
    stockTitle VARCHAR(60),
    stockDes TEXT,
    stockCost INT,
    registeredBy INT,
    stockImage VARCHAR(40),
    quantity INT,
    dateIn DATE DEFAULT CURRENT_TIMESTAMP(),
    FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE
    DEALS
ADD
    FOREIGN KEY (registeredBy) REFERENCES EMPLOYEES (employeeID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE
    DEALS
ADD
    FOREIGN KEY (customerId) REFERENCES CUSTOMERS (customerUnique) ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO
    ADMINS (
        adminID,
        adminFirst,
        adminLast,
        adminEmail,
        adminContact,
        adminProfile,
        adminPasscode
    )
VALUES
    (
        NULL,
        'Gemini',
        'Child',
        'geminichild@gmail.com',
        '+255628272363',
        '/admin/admin__.jpg',
        'admin123'
    ),
    (
        NULL,
        'Admin2',
        'MymiddleName',
        'geminichild2@gmail.com',
        '+255628272363',
        '/admin/admin__.jpg',
        'admin123'
    );

INSERT INTO
    EMPLOYEES (
        employeeID,
        employeeFirst,
        employeeLast,
        employeeEmail,
        employeeAddress,
        employeeContact,
        employeeProfile,
        employeePasscode
    )
VALUES
    (
        NULL,
        'Adam',
        'Smith',
        'employe1@gmail.com',
        'Mbezi Luis',
        '+255628272363',
        '/employee/employee__.jpg',
        'employee1'
    ),
(
        NULL,
        'Ryna',
        'Walker',
        'employe2@gmail.com',
        'Goba',
        '+255628272363',
        '/employee/employee__.jpg',
        'employee2'
    );

INSERT INTO
    CUSTOMERS (
        customerID,
        customerFirst,
        customerLast,
        customerEmail,
        customerAddress,
        customerContact,
        customerProfile,
        customerUnique,
        registeredBy
    )
VALUES
    (
        NULL,
        'Customer1',
        'Wayne',
        'customer1@gmail.com',
        'Arusha Mjini',
        '+255628272363',
        '/profiles/1099665442.jpg',
        '001/10/2023',
        1
    ),
(
        NULL,
        'Customer2',
        'Regun',
        'customer2@gmail.com',
        'Dodoma Mjini',
        '+255628272363',
        '/profiles/PRF587022459.jpg',
        '002/9/2023',
        2
    ),
(
        NULL,
        'Customer3',
        'Rahim',
        'customer3@gmail.com',
        'Dodoma Mjini',
        '+255628272363',
        '/profiles/PRF587022459.jpg',
        '003/11/2023',
        1
    );
INSERT INTO 
    WORKERS (
        workerName
    )
VALUES (
    'Ramadhani Juma'
),(
    'Hendry Adam'
),(
    'Hatibu Juma'
),(
    'Jackson Juma'
);
INSERT INTO
    DEALS (
        dealID,
        dealTitle,
        dealDescription,
        dealRequirements,
        registeredBy,
        customerId,
        mini_employee
    )
VALUES
    (
        NULL,
        'Deal Number 1',
        ' Simple Descripiton one',
        'Requirement for one - 5090\nOne to two - 3200 \nthree to four - 5000',
        2,
        '001/10/2023',
        'Ramadhani Juma'
    ),
(
        NULL,
        'Deal Number 2',
        ' Simple Descripiton two',
        'Requirement for one - 3400 \nTwd to two - 900\nthree to four - 74500',
        1,
        '001/10/2023',
        'Hendry Adam'
    ),
(
        NULL,
        'Deal Number 3',
        ' ase Descripiton one',
        'Requirement for one - 2000 \nOne to two - 4900 \nthree to four - 3400',
        1,
        '002/9/2023',
        'Hatibu Juma'
    ),
(
        NULL,
        'Deal Number 4',
        ' Simple Descripiton one',
        'Requirement for one\nOne to two\nthree to four',
        2,
        '003/11/2023',
        'Jackson Juma'
    );

INSERT INTO
    CONTENTS (cID, price, measurements, categories, quantity, deal)
VALUES
    (
        NULL,
        24000,
        ' Sit - 20mm, L - 43cm, W - 12cm',
        'Men Jacket',
        2,
        2
    ),
(
        NULL,
        4000,
        ' Sit - 20mm, L - 43cm, W - 12cm',
        'Women Jacket',
        11,
        1
    ),
(
        NULL,
        34000,
        't - 20mm, L - 43cm, W - 12cm',
        'Men Trouser',
        1,
        2
    ),
(
        NULL,
        5400,
        ' Sit - 20mm, L - 43cm, W - 12cm',
        'Women Jacket',
        22,
        3
    );

INSERT INTO
    STOCKS (
        stockTitle,
        stockDes,
        stockCost,
        registeredBy,
        stockImage,
        quantity
    )
VALUES
    (
        'WOUNDS PACKAGES',
        'New Package from Mr. gamary delivery from user somebody at friday this week',
        240000,
        2,
        '/stocks/two.jpg',
        14
    ),
(
        '2 WOUNDS PACKAGES',
        'Second New Package from Mr. gamary delivery from user somebody at friday this week',
        40000,
        1,
        '/stocks/one.jpg',
        14
    );