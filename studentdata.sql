-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 06:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(9) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `approval` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `username`, `password`, `approval`) VALUES
(9, 'ali', 'ali', 'ali', '94419b99b12c11133a4dfeccc3e17885974beb48f7827c48239aabfbcad238d8', 1),
(10, 'Guru Besar', 'gurubesar@gmail.com', 'gurubesar', '93470ca675127c49538b82bd6e90f42d419af020fb83f047c44142e1f2bf26ae', 1),
(11, 'admin', 'admin@gmail.com', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1),
(13, 'Halina', 'halina@gmail.com', 'halina16', '502f1a7c3604ac9758ed6fe5a5228e51657e728b17d01657657897b7b5727acb', 0),
(14, 'sulha', 'sulha2003@gmail.com', 'sulha1603', 'd100416879ca177991ead613f3102e3f6629037a9e037755fe6e44ed6ea86ff1', 0),
(15, 'sulha', 'sulha2003@gmail.com', 'sulha1603', 'd100416879ca177991ead613f3102e3f6629037a9e037755fe6e44ed6ea86ff1', 1),
(16, 'umar', 'umar123@gmail.com', 'wanumar', 'e263ee0e35e0d631905ecbac89049c71c73a51075bd023c0b4667e0cd4d8a48f', 0),
(17, 'umar', 'umar123@gmail.com', 'wanumar', 'e263ee0e35e0d631905ecbac89049c71c73a51075bd023c0b4667e0cd4d8a48f', 1),
(18, 'WAN MUAZ', 'muaz123@gmail.com', 'muaz123', '979fe412dc6b2fa5b854a2bf2e438b943306b5440c877b9af0f8c749a82c44db', 0),
(19, 'WAN MUAZ', 'muaz123@gmail.com', 'muaz123', '979fe412dc6b2fa5b854a2bf2e438b943306b5440c877b9af0f8c749a82c44db', 0),
(20, 'fatimah', 'tokma123@gmail.com', 'tokma', 'a72f14fcd78f350dd529f0cf55315b81a935ddb5cf7066903bb2c7e15aead933', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icnum` varchar(100) NOT NULL,
  `birth` date NOT NULL,
  `Address` varchar(100) NOT NULL,
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `icnum`, `birth`, `Address`, `login_id`) VALUES
(13, 'Lina joy', '30130341', '2005-01-02', 'No.3 jalan indah 45, taman indah permai, 68100 kuala lumpur', 11),
(18, 'umar', '1212120301347', '2012-12-12', 'No.8 jalan cempaka 5, taman cempaka lestari, 68100 kuala lumpur', 20),
(19, 'umar', '1212120301347', '2012-12-12', 'No.8 jalan cempaka 5, taman cempaka lestari, 68100 kuala lumpur', 20),
(20, 'aminah hasan la', '070715083426', '2007-07-15', 'No.89 jalan permai 45/12, taman indah permai, 68100 kuala lumpur', 11),
(21, 'ALI MAMAT', '732214123312', '2007-06-15', 'No.3 jalan indah 40, taman indah permai, 68100 kuala lumpur', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_products_1` (`login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_products_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

ALTER TABLE login ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL;
ALTER TABLE login ADD COLUMN token_expiry DATETIME DEFAULT NULL;

ALTER TABLE login
ADD COLUMN otp VARCHAR(6) DEFAULT NULL, 
ADD COLUMN otp_expiry DATETIME DEFAULT NULL;

ALTER TABLE login 
ADD COLUMN reset_otp VARCHAR(10) DEFAULT NULL;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
