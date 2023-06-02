DROP TABLE IF EXISTS `user_task`;
DROP TABLE IF EXISTS `invoice`;
DROP TABLE IF EXISTS `task`;
DROP TABLE IF EXISTS `client`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `address`;

CREATE TABLE `address`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `streetName` VARCHAR(50) NOT NULL,
    `houseNumber` INT NOT NULL,
    `postalCode` VARCHAR(50) NOT NULL,
    `city` VARCHAR(50) NOT NULL
);

CREATE TABLE `user`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fullName` VARCHAR(50) NOT NULL,
    `emailAddress` VARCHAR(50) NOT NULL,
    `password` VARCHAR(50) NOT NULL,
    `phoneNumber` INT NOT NULL,
    `role` set('coordinator','opdrachtgever','lid') NOT NULL
);

CREATE TABLE `client`(
    `userId` INT NOT NULL PRIMARY KEY,
    `companyName` VARCHAR(50) NOT NULL,
    `contactPersonName` VARCHAR(50) NOT NULL,
    `contactPersonPhoneNumber` INT NOT NULL,
    `invoiceEmailAddress` VARCHAR(50) NOT NULL,
    `addressId` INT NOT NULL,
    FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
    FOREIGN KEY (`addressId`) REFERENCES `address` (`id`)
);

CREATE TABLE `task`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `beginTime` TIME NOT NULL,
    `endTime` TIME NOT NULL,
    `date` DATE NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `instructorName` VARCHAR(50) NOT NULL,
    `taskNumber` INT NOT NULL,
    `playAddressId` INT NOT NULL,
	`makeupAddressId` INT,
    `status` ENUM('lopend','inBehandeling','afgerond') NOT NULL DEFAULT 'lopend',
    `clientId` INT NOT NULL,
    FOREIGN KEY (`clientId`) REFERENCES `client` (`userId`),
    FOREIGN KEY (`makeupAddressId`) REFERENCES `address` (`id`),
    FOREIGN KEY (`playAddressId`) REFERENCES `address` (`id`)
);

CREATE TABLE `invoice`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `signature` VARCHAR(50) NOT NULL,
    `specifics` VARCHAR(255) NOT NULL,
	`addressId` INT NOT NULL,
    `taskId` INT NOT NULL,
    FOREIGN KEY (`taskId`) REFERENCES `task` (`id`),
    FOREIGN KEY (`addressId`) REFERENCES `address` (`id`)
);

CREATE TABLE `user_task`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `userId` INT NOT NULL,
    `status` ENUM('geaccepteerd','geweigerd','misschien'),
    `admit` BOOLEAN,
    `taskId` INT NOT NULL,
    FOREIGN KEY (`userId`) REFERENCES `user` (`id`),
    FOREIGN KEY (`taskId`) REFERENCES `task` (`id`)
);
INSERT INTO `address` (`streetName`, `houseNumber`, `postalCode`, `city`) VALUES 
('Hoofdstraat', 123, '1234 AB', 'Amsterdam'),
('Zijstraat', 456, '5678 CD', 'Rotterdam');

INSERT INTO `user` (`fullName`, `emailAddress`, `password`, `phoneNumber`, `role`) VALUES 
('Piet Pietersen', 'piet.pietersen@email.com', 'password456', 612345678, 'opdrachtgever'),
('Marie Marijnsen', 'marie.marijnsen@email.com', 'password012', 612345679, 'coordinator'),
('Jan Janssen', 'jan.janssen@email.com', 'password123', 612345680, 'lid');

INSERT INTO `client` (`userId`, `companyName`, `contactPersonName`, `contactPersonPhoneNumber`, `invoiceEmailAddress`, `addressId`) VALUES 
(1, 'TestCo', 'Mike Lijten', 698765432, 'mikelijten@invoice.com', 1),
(2, 'VoorbeeldBV', 'John Doe', 698765433, 'johndoe@invoice.com', 2);

INSERT INTO `task` (`beginTime`, `endTime`, `date`, `description`, `instructorName`, `taskNumber`, `playAddressId`, `makeupAddressId`, `status`, `clientId`) VALUES 
('09:30:00', '10:30:00', '2023-05-31', 'Test taak', 'koen van steen, mohammed samadov', 123456, 1, NULL, 'inBehandeling', 1),
('10:45:00', '11:45:00', '2023-06-01', 'Voorbeeld taak', 'koen van steen, mohammed samadov', 123457, 2, NULL, 'inBehandeling', 2);

INSERT INTO `invoice` (`signature`, `specifics`, `addressId`, `taskId`) VALUES 
('Ondertekening 1', 'Bijzonderheden 1', 1, 1),
('Ondertekening 2', 'Bijzonderheden 2', 2, 2);

INSERT INTO `user_task` (`userId`, `status`, `admit`, `taskId`) VALUES 
(3, 'geaccepteerd', true, 1),
(3, 'geaccepteerd', true, 2);

-- Host:  mysql.exe -h db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com --port 25060 -u P14-Lotus-1
--   -p
-- password: AVNS_PfKiCGBUJtLi80amBmW
