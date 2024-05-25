-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2021 at 08:52 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_paid_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_contact` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `cod` varchar(200) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `payment_type` varchar(30) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `customer_account` int(11) DEFAULT NULL,
  `payment_account` int(11) DEFAULT NULL,
  `order_status` varchar(20) NOT NULL DEFAULT '0',
  `address` varchar(500) NOT NULL,
  `charges` varchar(200) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `pending_order` varchar(1000) NOT NULL,
  `tracking` varchar(200) NOT NULL,
  `customer_profit` varchar(255) NOT NULL,
  `transaction_id` int(11) NOT NULL DEFAULT '0',
  `broker_id` int(11) DEFAULT NULL,
  `type` text,
  `delaytime` text,
  `freight` text,
  `order_narration` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `credit_sale_type` varchar(20) NOT NULL DEFAULT 'none',
  `vehicle_no` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `transaction_paid_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `cod`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `customer_account`, `payment_account`, `order_status`, `address`, `charges`, `note`, `pending_order`, `tracking`, `customer_profit`, `transaction_id`, `broker_id`, `type`, `delaytime`, `freight`, `order_narration`, `timestamp`, `credit_sale_type`, `vehicle_no`) VALUES
(1, 24, '2021-06-09', 'at poly bag', '01', '', '', '18796', '0', '', '18796', '9398', '9398', 'cash_in_hand', 1, NULL, 3, '0', '', '', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, '2021-06-10 04:01:27', 'none', NULL),
(2, 25, '2021-06-10', 'mussa package', '123456789', '', '', '195116', '0', '', '195116', '0', '195116', 'credit_sale', 0, 4, 3, '0', '', '', '', '', '', '', 26, NULL, NULL, NULL, NULL, 'pvc rool', '2021-06-10 06:13:52', '15days', 'LE_395'),
(3, 27, '2021-06-10', 'master abbas', '03076290112', '', '', '16200', '0', '', '16200', '11050', '5150', 'cash_in_hand', 1, NULL, 3, '0', '', '', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, '2021-06-10 04:37:18', 'none', NULL),
(4, 28, '2021-06-10', 'sohail', '03007624509', '', '', '7259', '0', '', '7259', '7259', '0', 'cash_in_hand', 1, NULL, 3, '0', '', '', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, '2021-06-10 04:58:31', 'none', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
