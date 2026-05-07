CREATE DATABASE real_estate_portal_db;
USE real_estate_portal_db ;

CREATE TABLE users (
  userID INT NOT NULL AUTO_INCREMENT UNIQUE,
  userName VARCHAR(50) NOT NULL,
  contactInfo VARCHAR(200) NULL,
  passwordHash VARCHAR(255) NOT NULL,
  userType ENUM('agent', 'buyer', 'renter') NOT NULL,
  PRIMARY KEY (userID));

CREATE TABLE properties (
  propertyID INT NOT NULL UNIQUE AUTO_INCREMENT,
  title VARCHAR(100) NOT NULL,
  propertyType VARCHAR(50) NOT NULL,
  address VARCHAR(200) NOT NULL,
  city VARCHAR(100) NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  status ENUM('available', 'sold', 'rented') NOT NULL DEFAULT 'available',
  agentID INT NOT NULL,
  PRIMARY KEY (propertyID),
  FOREIGN KEY (agentID) REFERENCES users(userID));

CREATE TABLE inquiries (
  inquiryID INT NOT NULL UNIQUE AUTO_INCREMENT,
  userID INT NOT NULL,
  propertyID INT NOT NULL,
  message VARCHAR(255) NOT NULL,
  inquiryDate DATETIME NOT NULL,
  PRIMARY KEY (inquiryID),
  FOREIGN KEY (userID) REFERENCES users (userID),
  FOREIGN KEY (propertyID) REFERENCES properties (propertyID));

CREATE TABLE transactions (
  transactionID INT NOT NULL UNIQUE AUTO_INCREMENT,
  propertyID INT NOT NULL,
  userID INT NOT NULL,
  transactionType ENUM('sale', 'rental') NOT NULL,
  transactionDate DATETIME NOT NULL,
  amount DECIMAL(12,2) NOT NULL,
  PRIMARY KEY (transactionID),
  FOREIGN KEY (userID) REFERENCES users(userID),
  FOREIGN KEY (propertyID) REFERENCES properties(propertyID));

CREATE TABLE favorites (
  favoriteID INT NOT NULL UNIQUE AUTO_INCREMENT,
  userID INT NOT NULL,
  propertyID INT NOT NULL,
  savedDate DATETIME NOT NULL,
  PRIMARY KEY (favoriteID),
  FOREIGN KEY (userID) REFERENCES users(userID),
  FOREIGN KEY (propertyID) REFERENCES properties(propertyID));
  
  /*INSERTS to populate the data of the tables*/
  
INSERT INTO users (userName, contactInfo, passwordHash, userType)
VALUES 
("Zoro", "zoro@grandline.com", "", "agent"),
("Bartolomeo", "Barto@strawhats.org", "", "buyer"),
("Cavendish", "Cavendish@grandlinerealty.com", "", "renter");

INSERT INTO properties (title, propertyType, address, city, price, status, agentID)
VALUES 
("Baratie", "Boat", "Sambas Region", "East Blue", "50000.0", "available", "1"),
("Water 7", "Apt", "Paradise", "Grand Line", "150000.0", "rented", "1"),
("Shogun Castle", "Palace", "New World", "Wano", "250000.0", "sold", "3");

INSERT INTO inquiries (userID, propertyID, message, inquiryDate)
VALUES 
("2", "1", "Are there any Marine bases nearby?", "2026-05-02 12:22:00"),
("1", "3", "How often does the water train come?", "2026-05-04 18:34:00"),
("2", "2", "Can I eat inside the Throne Room?", "2026-04-21 09:10:00");

INSERT INTO transactions (propertyID, userID, transactionType, transactionDate, amount)
VALUES 
("3", "1", "sale", "2026-04-27 09:45:00", "50000"),
("1", "2", "rented", "2026-05-01 10:20:00", "150000"),
("2", "2", "rented", "2026-05-03 15:00:00", "150000");

INSERT INTO favorites (userID, propertyID, savedDate)
VALUES 
("2","3","2026-03-31 14:56:00"),
("3","1","2026-05-02 07:35:00"),
("1","2","2026-05-02 10:30:00");

/*Creating the view for buyers*/
CREATE VIEW propertylistingview AS
    SELECT 
        properties.title AS title,
        properties.propertyType AS propertyType,
        properties.city AS city,
        properties.price AS price,
        properties.status AS status
    FROM
        (properties
        JOIN users ON ((properties.agentID = users.userID)));