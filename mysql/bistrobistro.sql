DROP DATABASE IF EXISTS bistrobistro;
 
CREATE DATABASE bistrobistro;
  
CREATE USER 'bb'@'localhost'
  IDENTIFIED BY '';

GRANT ALL
  ON bistrobistro.*
  TO 'bb'@'localhost';
  
USE bistrobistro;
  
CREATE TABLE requests (
request_id INT(11) PRIMARY KEY AUTO_INCREMENT,
time_requested TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
JSON_request JSON NOT NULL,
contacted TINYINT
);
 
ALTER TABLE requests AUTO_INCREMENT=100000;
  
CREATE TABLE guests (
f_name VARCHAR(50) NOT NULL,
l_name VARCHAR(100) NOT NULL,
phone CHAR(10) NOT NULL,
email VARCHAR(255) PRIMARY KEY,
notes VARCHAR(1000)
);

CREATE TABLE allergies (
allergy VARCHAR(255) PRIMARY KEY
);

CREATE TABLE occasions (
occasion VARCHAR(255) PRIMARY KEY
);

CREATE TABLE tables (
table_num CHAR(2) PRIMARY KEY,
capacity VARCHAR(2)
);
  
CREATE TABLE managers (
username VARCHAR(50) PRIMARY KEY,
password VARCHAR(100) NOT NULL,
name VARCHAR(255) NOT NULL
);
  
CREATE TABLE reservations (
res_id INT(11) PRIMARY KEY AUTO_INCREMENT,
date DATE NOT NULL,
time VARCHAR(4) NOT NULL,
party CHAR(2) NOT NULL,
notes VARCHAR(1000),
email VARCHAR(255),
request_id INT(11),
occasion VARCHAR(255),
allergy VARCHAR(255),
table_num CHAR(2),
FOREIGN KEY (email) REFERENCES guests(email),
FOREIGN KEY (request_id) REFERENCES requests(request_id),
FOREIGN KEY (occasion) REFERENCES occasions(occasion),
FOREIGN KEY (allergy) REFERENCES allergies(allergy),
FOREIGN KEY (table_num) REFERENCES tables(table_num)
);

ALTER TABLE reservations AUTO_INCREMENT=100000;