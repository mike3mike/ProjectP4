DROP TABLE IF EXISTS `user_task`;
DROP TABLE IF EXISTS `invoice`;
DROP TABLE IF EXISTS `task`;
DROP TABLE IF EXISTS `client`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `address`;

CREATE TABLE `address`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `street_name` VARCHAR(50) NOT NULL,
    `house_number` INT NOT NULL,
    `postal_code` VARCHAR(50) NOT NULL,
    `city` VARCHAR(50) NOT NULL
);

CREATE TABLE `user`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(50) NOT NULL,
    `email_address` VARCHAR(50) NOT NULL,
    `password` VARCHAR(50) NOT NULL,
    `phone_number` INT NOT NULL,
    `role` SET('coordinator','opdrachtgever','lid') NOT NULL,
    `is_approved` BOOLEAN DEFAULT false
);

CREATE TABLE `client`(
    `user_id` INT NOT NULL PRIMARY KEY,
    `company_name` VARCHAR(50) NOT NULL,
    `contact_person_name` VARCHAR(50) NOT NULL,
    `contact_person_phone_number` INT NOT NULL,
    `invoice_email_address` VARCHAR(50) NOT NULL,
    `invoice_address_id` INT NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    FOREIGN KEY (`invoice_address_id`) REFERENCES `address` (`id`)
);

CREATE TABLE `task`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `begin_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `date` DATE NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `instructor_name` VARCHAR(50) NOT NULL,
    `task_number` INT NOT NULL,
    `play_address_id` INT NOT NULL,
    `makeup_address_id` INT,
    `status` ENUM('lopend','inBehandeling','afgerond') NOT NULL DEFAULT 'lopend',
    `client_id` INT NOT NULL,
    FOREIGN KEY (`client_id`) REFERENCES `client` (`user_id`),
    FOREIGN KEY (`makeup_address_id`) REFERENCES `address` (`id`),
    FOREIGN KEY (`play_address_id`) REFERENCES `address` (`id`)
);

CREATE TABLE `invoice`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `signature` VARCHAR(50) NOT NULL,
    `specifics` VARCHAR(255) NOT NULL,
    `address_id` INT NOT NULL,
    `task_id` INT NOT NULL,
    FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
    FOREIGN KEY (`address_id`) REFERENCES `address` (`id`)
);

CREATE TABLE `user_task`(
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `status` ENUM('geaccepteerd','geweigerd','misschien'),
    `admit` BOOLEAN,
    `task_id` INT NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    FOREIGN KEY (`task_id`) REFERENCES `task` (`id`)
);

INSERT INTO `address` (`street_name`, `house_number`, `postal_code`, `city`) VALUES 
('Hoofdstraat', 123, '1234 AB', 'Amsterdam'),
('Zijstraat', 456, '5678 CD', 'Rotterdam');

INSERT INTO `user` (`full_name`, `email_address`, `password`, `phone_number`, `role`) VALUES 
('Piet Pietersen', 'piet.pietersen@email.com', 'password456', 612345678, 'opdrachtgever'),
('Marie Marijnsen', 'marie.marijnsen@email.com', 'password012', 612345679, 'coordinator'),
('Jan Janssen', 'jan.janssen@email.com', 'password123', 612345680, 'lid');

INSERT INTO `client` (`user_id`, `company_name`, `contact_person_name`, `contact_person_phone_number`, `invoice_email_address`, `invoice_address_id`) VALUES 
(1, 'TestCo', 'Mike Lijten', 698765432, 'mikelijten@invoice.com', 1),
(2, 'VoorbeeldBV', 'John Doe', 698765433, 'johndoe@invoice.com', 2);

INSERT INTO `task` (`begin_time`, `end_time`, `date`, `description`, `instructor_name`, `task_number`, `play_address_id`, `makeup_address_id`, `status`, `client_id`) VALUES 
('09:30:00', '10:30:00', '2023-05-31', 'Test taak', 'koen van steen, mohammed samadov', 123456, 1, NULL, 'inBehandeling', 1),
('10:45:00', '11:45:00', '2023-06-01', 'Voorbeeld taak', 'koen van steen, mohammed samadov', 123457, 2, NULL, 'inBehandeling', 2);

INSERT INTO `invoice` (`signature`, `specifics`, `address_id`, `task_id`) VALUES 
('Ondertekening 1', 'Bijzonderheden 1', 1, 1),
('Ondertekening 2', 'Bijzonderheden 2', 2, 2);

INSERT INTO `user_task` (`user_id`, `status`, `admit`, `task_id`) VALUES 
(3, 'geaccepteerd', true, 1),
(3, 'geaccepteerd', true, 2);

-- Host:  mysql.exe -h db-mysql-ams3-46626-do-user-8155278-0.b.db.ondigitalocean.com --port 25060 -u P14-Lotus-1
--   -p
-- password: AVNS_PfKiCGBUJtLi80amBmW
