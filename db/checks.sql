-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2021 at 02:38 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polybags`
--

-- --------------------------------------------------------

--
-- Table structure for table `checks`
--

CREATE TABLE `checks` (
  `check_id` int(11) NOT NULL,
  `check_no` varchar(250) DEFAULT NULL,
  `check_bank_name` varchar(250) DEFAULT NULL,
  `check_expiry_date` varchar(100) DEFAULT NULL,
  `check_type` varchar(100) DEFAULT NULL,
  `voucher_id` int(11) NOT NULL,
  `check_status` int(11) NOT NULL DEFAULT 0,
  `check_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `checks`
--

INSERT INTO `checks` (`check_id`, `check_no`, `check_bank_name`, `check_expiry_date`, `check_type`, `voucher_id`, `check_status`, `check_timestamp`) VALUES
(2, '202002asa', 'bank al  habbib', '2021-09-18', 'cross check', 25, 1, '2021-09-18 08:25:07'),
(3, '202002asa', 'bank al  habbib', '2021-09-18', 'cross check', 26, 1, '2021-09-18 10:04:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checks`
--
ALTER TABLE `checks`
  ADD PRIMARY KEY (`check_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checks`
--
ALTER TABLE `checks`
  MODIFY `check_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
