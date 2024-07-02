--this is irrelevant, I used it to remind myself of the structure of the table, they are not even up to date

CREATE TABLE `User` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `realname` VARCHAR(255) DEFAULT 'USER',
  `isadmin` BIT DEFAULT 0,
  `gamesplayed` INT DEFAULT 0,
  `bestscore` INT DEFAULT 0,
  `avgscore` DECIMAL(10, 2) DEFAULT 0.00,
  `profilephoto` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE `Country` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `flagphoto` VARCHAR(255) DEFAULT NULL
);

CREATE TABLE `Location` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) DEFAULT NULL,
  `difficulty` INT NOT NULL CHECK (`difficulty` BETWEEN 1 AND 100),
  `photo` VARCHAR(255) NOT NULL,
  `countryid` INT,
  ADD CONSTRAINT `licenta_ibfk_1` FOREIGN KEY (`countryid`) REFERENCES `Country`(`id`)
);




INSERT INTO `User`(`username`, `password`, `realname`, `isadmin`)
VALUES ('iliedr19', 'parolailiedr19', 'Ilie Daniel Rus', 1),
       ('arthur123', 'parolaarthur123', 'King Arthur', 1),
       ('user1', 'parolauser1', 'User One Uno', 0),
       ('user2', 'parolauser2', 'User Two Dos', 0),
       ('user3', 'parolauser3', 'User Three Tres', 0),
       ('user4', 'parolauser4', 'User Four Quatros', 0),
       ('user5', 'parolauser5', 'User Five Cinco', 0),
       ('user6', 'parolauser6', 'User Six Seis', 0);


--every country for Country
--nothing for Location from phpmyadmin