-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2024 at 04:22 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `complite`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `accountID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountType` enum('Student','Instructor','Admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`accountID`),
  UNIQUE KEY `accounts_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accountID`, `username`, `password`, `accountType`, `status`, `dateTime`) VALUES
(1, '@dmin01', '$2y$10$7EIEfQcZuGWmPOD4V/D/m.PAloF4JXGiNzAbrGofm8VzSaUyW3cz6', 'Admin', 'Active', '2024-12-09 03:14:35'),
(2, 'john@doe', '$2y$10$uCiSs/K68St3F/YcJndMSeyzHxjItWgieDc3fZzlsiqRDcXg.U25y', 'Student', 'Active', '2024-12-09 03:14:35'),
(3, 'bobby@brown', '$2y$10$AZP9mrQMEMZM9nRM/0mNG.g0PLNhRCuS57K2gu9Yw8ltnIJzG5wJS', 'Instructor', 'Active', '2024-12-09 03:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
CREATE TABLE IF NOT EXISTS `actions` (
  `actionID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_ID` bigint UNSIGNED NOT NULL,
  `actionMessage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`actionID`),
  KEY `actions_account_id_foreign` (`account_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

DROP TABLE IF EXISTS `activity`;
CREATE TABLE IF NOT EXISTS `activity` (
  `activityID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `activityQuestions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activityChoices` json NOT NULL,
  `activityKey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activityPicture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`activityID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityID`, `activityQuestions`, `activityChoices`, `activityKey`, `activityPicture`) VALUES
(1, 'What is a computer?', '[\"A Food\", \"A Animal\", \"An Object\", \"A Machine\"]', 'A Machine', 'Robot.png');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_ID` bigint UNSIGNED NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middleName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthDate` date NOT NULL,
  `profilePhoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`adminID`),
  KEY `admin_account_id_foreign` (`account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `account_ID`, `firstName`, `lastName`, `middleName`, `email`, `sex`, `birthDate`, `profilePhoto`) VALUES
(1, 1, 'Eric', 'Lopez', 'Gomez', 'eric_lopez@sample.com', 'Male', '2000-01-01', '');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `section_ID` bigint UNSIGNED NOT NULL,
  `lesson_ID` bigint UNSIGNED NOT NULL,
  `activity_ID` bigint UNSIGNED NOT NULL,
  KEY `content_section_id_foreign` (`section_ID`),
  KEY `content_lesson_id_foreign` (`lesson_ID`),
  KEY `content_activity_id_foreign` (`activity_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`section_ID`, `lesson_ID`, `activity_ID`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `enroll_section`
--

DROP TABLE IF EXISTS `enroll_section`;
CREATE TABLE IF NOT EXISTS `enroll_section` (
  `enrollID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_ID` bigint UNSIGNED NOT NULL,
  `student_ID` bigint UNSIGNED NOT NULL,
  `lessonStatus` enum('Not Started','In Progress','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Started',
  `activityStatus` enum('Not Started','In Progress','Completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Not Started',
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`enrollID`),
  KEY `enroll_section_section_id_foreign` (`section_ID`),
  KEY `enroll_section_student_id_foreign` (`student_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enroll_section`
--

INSERT INTO `enroll_section` (`enrollID`, `section_ID`, `student_ID`, `lessonStatus`, `activityStatus`, `dateTime`) VALUES
(1, 1, 1, 'Not Started', 'Not Started', '2024-12-09 03:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_profile`
--

DROP TABLE IF EXISTS `instructor_profile`;
CREATE TABLE IF NOT EXISTS `instructor_profile` (
  `instructorID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_ID` bigint UNSIGNED NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middleName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthDate` date NOT NULL,
  `profilePhoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`instructorID`),
  KEY `instructor_profile_account_id_foreign` (`account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instructor_profile`
--

INSERT INTO `instructor_profile` (`instructorID`, `account_ID`, `firstName`, `lastName`, `middleName`, `email`, `sex`, `birthDate`, `profilePhoto`) VALUES
(1, 3, 'Bobby', 'Brown', 'Green', 'bobby_brown@sample.com', 'Male', '1986-05-05', '');

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

DROP TABLE IF EXISTS `lesson`;
CREATE TABLE IF NOT EXISTS `lesson` (
  `lessonID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lessonPicture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lessonContent` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lessonID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`lessonID`, `lessonPicture`, `lessonContent`) VALUES
(1, NULL, 'What Makes Up a Computer?'),
(2, NULL, 'A computer consists of two main components: hardware and software. Hardware refers to the physical parts of a computer that you can see and touch, while software includes the programs and applications that make the hardware useful. In this lesson, we will focus on the hardware components of a computer.'),
(3, NULL, 'Key Hardware Components and Their Functions'),
(4, NULL, 'Input Devices:'),
(5, NULL, 'Input devices enable you to interact with the computer by sending information or commands to it. These devices allow you to provide instructions, type data, or make selections, helping the computer understand what you want it to do.'),
(6, NULL, 'Keyboard: Used to type letters, numbers, and commands.'),
(7, NULL, 'Mouse: Used to move the cursor and click on items on the screen.'),
(8, NULL, 'Touchpad (on laptops): A flat surface that acts as a mouse replacement.'),
(9, 'images/InputDevices.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(193, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(194, '2024_12_06_215212_create_accounts_table', 1),
(195, '2024_12_06_220342_create_student_profile_table', 1),
(196, '2024_12_06_224622_create_instructor_profile_table', 1),
(197, '2024_12_06_224903_create_admin_table', 1),
(198, '2024_12_06_225136_create_reports_table', 1),
(199, '2024_12_06_225655_create_actions_table', 1),
(200, '2024_12_07_221708_create_lesson_table', 1),
(201, '2024_12_07_222023_create_activity_table', 1),
(202, '2024_12_07_222217_create_section_table', 1),
(203, '2024_12_07_222711_create_content_table', 1),
(204, '2024_12_07_223121_create_enroll_section_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `reportID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_ID` bigint UNSIGNED NOT NULL,
  `reportMessage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reportID`),
  KEY `reports_account_id_foreign` (`account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`reportID`, `account_ID`, `reportMessage`, `dateTime`) VALUES
(1, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2024-12-09 03:14:35'),
(2, 3, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '2024-12-09 03:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
CREATE TABLE IF NOT EXISTS `section` (
  `sectionID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instructor_ID` bigint UNSIGNED NOT NULL,
  `courseName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courseDescription` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `activityName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sectionName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sectionCode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actDueDate` timestamp NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`sectionID`),
  UNIQUE KEY `section_sectioncode_unique` (`sectionCode`),
  KEY `section_instructor_id_foreign` (`instructor_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`sectionID`, `instructor_ID`, `courseName`, `courseDescription`, `activityName`, `sectionName`, `sectionCode`, `actDueDate`, `dateTime`) VALUES
(1, 1, 'Parts of the Computer', 'By the end of this lesson, students will be able to identify the basic parts of a computer, understand their functions, and differentiate between hardware and software.', 'Practice', 'IT3-1', 'sample', '2024-12-23 14:30:00', '2024-12-09 03:14:35');

-- --------------------------------------------------------

--
-- Table structure for table `student_profile`
--

DROP TABLE IF EXISTS `student_profile`;
CREATE TABLE IF NOT EXISTS `student_profile` (
  `studentID` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_ID` bigint UNSIGNED NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middleName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sex` enum('Male','Female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthDate` date NOT NULL,
  `profilePhoto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points` int NOT NULL,
  `grades` double(8,2) NOT NULL,
  PRIMARY KEY (`studentID`),
  KEY `student_profile_account_id_foreign` (`account_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_profile`
--

INSERT INTO `student_profile` (`studentID`, `account_ID`, `firstName`, `lastName`, `middleName`, `email`, `sex`, `birthDate`, `profilePhoto`, `points`, `grades`) VALUES
(1, 2, 'John', 'Doe', 'Gi', 'john_doe@sample.com', 'Male', '2003-12-05', '', 100, 80.00);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_account_id_foreign` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`accountID`) ON DELETE CASCADE;

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_account_id_foreign` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`accountID`) ON DELETE CASCADE;

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_activity_id_foreign` FOREIGN KEY (`activity_ID`) REFERENCES `activity` (`activityID`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_lesson_id_foreign` FOREIGN KEY (`lesson_ID`) REFERENCES `lesson` (`lessonID`) ON DELETE CASCADE,
  ADD CONSTRAINT `content_section_id_foreign` FOREIGN KEY (`section_ID`) REFERENCES `section` (`sectionID`) ON DELETE CASCADE;

--
-- Constraints for table `enroll_section`
--
ALTER TABLE `enroll_section`
  ADD CONSTRAINT `enroll_section_section_id_foreign` FOREIGN KEY (`section_ID`) REFERENCES `section` (`sectionID`) ON DELETE CASCADE,
  ADD CONSTRAINT `enroll_section_student_id_foreign` FOREIGN KEY (`student_ID`) REFERENCES `student_profile` (`studentID`) ON DELETE CASCADE;

--
-- Constraints for table `instructor_profile`
--
ALTER TABLE `instructor_profile`
  ADD CONSTRAINT `instructor_profile_account_id_foreign` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`accountID`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_account_id_foreign` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`accountID`) ON DELETE CASCADE;

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `section_instructor_id_foreign` FOREIGN KEY (`instructor_ID`) REFERENCES `instructor_profile` (`instructorID`) ON DELETE CASCADE;

--
-- Constraints for table `student_profile`
--
ALTER TABLE `student_profile`
  ADD CONSTRAINT `student_profile_account_id_foreign` FOREIGN KEY (`account_ID`) REFERENCES `accounts` (`accountID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
