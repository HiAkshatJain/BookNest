CREATE DATABASE BookStore;
USE BookStore;

CREATE TABLE Book(
    BookID varchar(50),
	BookTitle varchar(200),
    ISBN varchar(20),
    Price double(12,2),
    Author varchar(128),
    Type varchar(128),
    Image varchar(128),
    PRIMARY KEY (BookID)
);

CREATE TABLE Users(
    UserID int not null AUTO_INCREMENT,
    UserName varchar(128),
    Password varchar(16),
    PRIMARY KEY (UserID)
);

CREATE TABLE Customer (
	CustomerID int not null AUTO_INCREMENT,
    CustomerName varchar(128),
    CustomerPhone varchar(12),
    CustomerIC varchar(14),
    CustomerEmail varchar(200),
    CustomerAddress varchar(200),
    CustomerGender varchar(10),
    UserID int,
    PRIMARY KEY (CustomerID),
    CONSTRAINT FOREIGN KEY (UserID) REFERENCES Users(UserID) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE `Order`(
	OrderID int not null AUTO_INCREMENT,
    CustomerID int,
    BookID varchar(50),
    DatePurchase datetime,
    Quantity int,
    TotalPrice double(12,2),
    Status varchar(1),
    PRIMARY KEY (OrderID),
    CONSTRAINT FOREIGN KEY (BookID) REFERENCES Book(BookID) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Cart(
	CartID int not null AUTO_INCREMENT,
    CustomerID int,
    BookID varchar(50),
    Price double(12,2),
    Quantity int,
    TotalPrice double(12,2),
    PRIMARY KEY (CartID),
    CONSTRAINT FOREIGN KEY (BookID) REFERENCES Book(BookID) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID) ON DELETE SET NULL ON UPDATE CASCADE
);


INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-001','Star Wars','123-456-789-1',136,'George Lucas','Fiction','image/starwars.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-002', 'It Ends with Us', '987-654-321-2', 200, 'Colleen Hoover', 'Romance', 'image/romance.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-003', 'A House Without Windows', '543-210-987-3', 180, 'Nadia Hashimi', 'Fiction', 'image/fiction.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-004', 'Paradise Lost', '111-222-333-4', 150, 'John Milton', 'Classic', 'image/classic.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-005', 'The Diary of a Young Girl', '999-888-777-5', 120, 'Anne Frank', 'Biography', 'image/biography.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-006', 'Wings of Fire', '444-555-666-6', 160, 'Dr. APJ Abdul Kalam', 'Autobiography', 'image/autobiography.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-007', 'The Alchemist', '777-888-999-7', 220, 'Paulo Coelho', 'Philosophy', 'image/philosophy.jpg');

INSERT INTO `book`(`BookID`, `BookTitle`, `ISBN`, `Price`, `Author`, `Type`, `Image`) 
VALUES ('B-008', 'Sherlock Holmes', '333-444-555-8', 300, 'Arthur Conan Doyle', 'Mystery', 'image/mystery.jpg');
