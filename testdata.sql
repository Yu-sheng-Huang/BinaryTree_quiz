-- Adminer 4.8.1 MySQL 10.4.32-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `policyholders`;
CREATE TABLE `policyholders` (
  `PolicyholderID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) DEFAULT NULL,
  `JoinDate` datetime DEFAULT NULL,
  `ReferrerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`PolicyholderID`),
  KEY `ReferrerID` (`ReferrerID`),
  CONSTRAINT `policyholders_ibfk_1` FOREIGN KEY (`ReferrerID`) REFERENCES `policyholders` (`PolicyholderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `policyholders` (`PolicyholderID`, `Name`, `JoinDate`, `ReferrerID`) VALUES
(1,	'John',	'2024-01-01 00:00:00',	NULL),
(2,	'Alice',	'2024-01-02 00:00:00',	1),
(3,	'Bob',	'2024-01-03 00:00:00',	1),
(4,	'Carol',	'2024-01-04 00:00:00',	2),
(5,	'David',	'2024-01-05 00:00:00',	2),
(6,	'Eve',	'2024-01-06 00:00:00',	4),
(7,	'Frank',	'2024-01-07 00:00:00',	3),
(8,	'Grace',	'2024-01-08 00:00:00',	5),
(9,	'Harry',	'2024-01-09 00:00:00',	5),
(10,	'Ivy',	'2024-01-10 00:00:00',	6),
(11,	'Jack',	'2024-01-11 00:00:00',	7),
(12,	'Karen',	'2024-01-12 00:00:00',	8),
(13,	'Larry',	'2024-01-13 00:00:00',	9),
(14,	'Mary',	'2024-01-14 00:00:00',	10),
(15,	'Nancy',	'2024-01-15 00:00:00',	11),
(16,	'Olivia',	'2024-01-16 00:00:00',	1),
(17,	'Peter',	'2024-01-17 00:00:00',	1),
(18,	'Quinn',	'2024-01-18 00:00:00',	2),
(19,	'Rose',	'2024-01-19 00:00:00',	2),
(20,	'Sam',	'2024-01-20 00:00:00',	3),
(21,	'Tina',	'2024-01-21 00:00:00',	3),
(22,	'Ursula',	'2024-01-22 00:00:00',	4),
(23,	'Victor',	'2024-01-23 00:00:00',	4),
(24,	'Wendy',	'2024-01-24 00:00:00',	5),
(25,	'Xavier',	'2024-01-25 00:00:00',	5),
(26,	'Yvonne',	'2024-01-26 00:00:00',	6),
(27,	'Zack',	'2024-01-27 00:00:00',	6),
(28,	'Amy',	'2024-01-28 00:00:00',	7),
(29,	'Ben',	'2024-01-29 00:00:00',	7),
(30,	'Chris',	'2024-01-30 00:00:00',	8);

