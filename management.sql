-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2018 at 11:02 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `management`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` int(11) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `customer_id` varchar(9) NOT NULL,
  `customer_mail` varchar(254) NOT NULL,
  `branch_id` int(255) NOT NULL,
  `service_id` int(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(255) NOT NULL,
  `branch_mail` varchar(50) NOT NULL,
  `branch_name` varchar(30) NOT NULL,
  `branch_tel` varchar(11) NOT NULL,
  `branch_address` varchar(30) NOT NULL,
  `org_username` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_mail`, `branch_name`, `branch_tel`, `branch_address`, `org_username`) VALUES
(100, 'fidx-haifa@gmail.com', 'פידיקס חיפה', '0521234567', 'חיפה,רחוב א,17', 'fidx'),
(101, 'fidx-telaviv@gmail.com', 'פידיקס תל-אביב', '0521234568', 'תל-אביב,רחוב ב,15', 'fidx'),
(102, 'fidx-karmiel@gmail.com', 'פידיקס כרמיאל', '0521234569', 'חיפה,רחוב א,17', 'fidx');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `organization_name` varchar(20) NOT NULL,
  `organization_username` varchar(30) NOT NULL,
  `organization_email` varchar(70) NOT NULL,
  `organization_password` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`organization_name`, `organization_username`, `organization_email`, `organization_password`) VALUES
('בנק פידיקס', 'fidx', 'fidx@gmail.com', 'fidx123');

-- --------------------------------------------------------

--
-- Table structure for table `org_manager`
--

CREATE TABLE `org_manager` (
  `username` varchar(30) NOT NULL,
  `password` varchar(70) NOT NULL,
  `manager_mail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `org_manager`
--

INSERT INTO `org_manager` (`username`, `password`, `manager_mail`) VALUES
('fidx', 'fidx123456', 'fidx-manager@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `org_represent`
--

CREATE TABLE `org_represent` (
  `username` varchar(30) NOT NULL,
  `password` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `org_represent`
--

INSERT INTO `org_represent` (`username`, `password`) VALUES
('fidx', 'fidx123');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `service_id` int(255) NOT NULL,
  `service_name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `app_time_avg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`service_id`, `service_name`, `app_time_avg`) VALUES
(48, 'שירות כללי', 15),
(49, 'שירות לבעלי עסק', 25),
(50, 'שירות אישי', 20),
(51, 'שירות כללי', 15),
(52, 'שירות לבעלי עסק', 25),
(53, 'שירות אישי', 20),
(54, 'שירות כללי', 15),
(55, 'שירות לבעלי עסק', 25),
(56, 'שירות אישי', 20);

-- --------------------------------------------------------

--
-- Table structure for table `service_branch`
--

CREATE TABLE `service_branch` (
  `service_id` int(255) NOT NULL,
  `branch_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `service_branch`
--

INSERT INTO `service_branch` (`service_id`, `branch_id`) VALUES
(48, 100),
(49, 100),
(50, 100),
(51, 101),
(52, 101),
(53, 101),
(54, 102),
(55, 102),
(56, 102);

-- --------------------------------------------------------

--
-- Table structure for table `work_hours`
--

CREATE TABLE `work_hours` (
  `day` int(11) NOT NULL,
  `startA` time NOT NULL,
  `endA` time NOT NULL,
  `startB` time NOT NULL,
  `endB` time NOT NULL,
  `dayOFF` int(11) NOT NULL,
  `branch_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `work_hours`
--

INSERT INTO `work_hours` (`day`, `startA`, `endA`, `startB`, `endB`, `dayOFF`, `branch_id`) VALUES
(1, '10:00:00', '12:00:00', '12:30:00', '17:00:00', 1, 100),
(2, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 100),
(3, '10:00:00', '12:00:00', '12:30:00', '17:00:00', 1, 100),
(4, '14:00:00', '17:00:00', '17:30:00', '21:00:00', 1, 100),
(5, '08:00:00', '00:00:00', '00:00:00', '13:00:00', 1, 100),
(6, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 100),
(7, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 100),
(1, '08:00:00', '11:00:00', '11:30:00', '14:00:00', 1, 101),
(2, '09:00:00', '12:00:00', '12:30:00', '15:00:00', 1, 101),
(3, '14:00:00', '18:00:00', '18:30:00', '19:00:00', 1, 101),
(4, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 101),
(5, '10:00:00', '13:00:00', '13:30:00', '18:00:00', 1, 101),
(6, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 101),
(7, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 101),
(1, '10:00:00', '12:00:00', '12:30:00', '15:00:00', 1, 102),
(2, '10:00:00', '12:30:00', '13:00:00', '15:00:00', 1, 102),
(3, '08:00:00', '11:00:00', '11:30:00', '15:00:00', 1, 102),
(4, '14:00:00', '16:00:00', '16:30:00', '19:00:00', 1, 102),
(5, '12:00:00', '00:00:00', '00:00:00', '17:00:00', 1, 102),
(6, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 102),
(7, '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 102);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `username` (`username`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`),
  ADD UNIQUE KEY `branch_mail` (`branch_mail`),
  ADD KEY `org_username` (`org_username`) USING BTREE;

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`organization_username`);

--
-- Indexes for table `org_manager`
--
ALTER TABLE `org_manager`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `org_represent`
--
ALTER TABLE `org_represent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_branch`
--
ALTER TABLE `service_branch`
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `work_hours`
--
ALTER TABLE `work_hours`
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `service`
--
ALTER TABLE `service`
  MODIFY `service_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organization` (`organization_username`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`);

--
-- Constraints for table `branch`
--
ALTER TABLE `branch`
  ADD CONSTRAINT `branch_ibfk_1` FOREIGN KEY (`org_username`) REFERENCES `organization` (`organization_username`);

--
-- Constraints for table `org_manager`
--
ALTER TABLE `org_manager`
  ADD CONSTRAINT `org_manager_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organization` (`organization_username`);

--
-- Constraints for table `org_represent`
--
ALTER TABLE `org_represent`
  ADD CONSTRAINT `org_represent_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organization` (`organization_username`);

--
-- Constraints for table `service_branch`
--
ALTER TABLE `service_branch`
  ADD CONSTRAINT `service_branch_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`),
  ADD CONSTRAINT `service_branch_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `service` (`service_id`);

--
-- Constraints for table `work_hours`
--
ALTER TABLE `work_hours`
  ADD CONSTRAINT `work_hours_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
