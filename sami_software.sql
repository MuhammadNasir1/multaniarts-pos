-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 08:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sami_software`
--

-- --------------------------------------------------------

--
-- Table structure for table `attlog`
--

CREATE TABLE `attlog` (
  `empolyeeID` varchar(50) NOT NULL,
  `authdatetime` text NOT NULL,
  `authdate` text NOT NULL,
  `authtime` text NOT NULL,
  `direction` text NOT NULL,
  `devicename` text NOT NULL,
  `devicesn` text NOT NULL,
  `personname` text NOT NULL,
  `carno` text NOT NULL,
  `adddatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attlog`
--

INSERT INTO `attlog` (`empolyeeID`, `authdatetime`, `authdate`, `authtime`, `direction`, `devicename`, `devicesn`, `personname`, `carno`, `adddatetime`) VALUES
('4', '2022-12-04T18:05:11', '2022-12-04', '18:05:11', 'IN', 'attendace', 'DS-K1A8503MF-B20191120V010203ENE12098421', 'Noman', '', '2022-12-04 16:21:16'),
('4', '2022-12-04T19:16:23', '2022-12-04', '19:16:23', 'IN', 'attendace', 'DS-K1A8503MF-B20191120V010203ENE12098421', 'Noman', '', '2022-12-04 16:21:16'),
('4', '2022-12-04T19:16:25', '2022-12-04', '19:16:25', 'IN', 'attendace', 'DS-K1A8503MF-B20191120V010203ENE12098421', 'Noman', '', '2022-12-04 16:21:16'),
('5', '2022-12-04T19:54:07', '2022-12-04', '19:54:07', 'IN', 'attendace', 'DS-K1A8503MF-B20191120V010203ENE12098421', 'Demo', '', '2022-12-04 16:21:16'),
('5', '2022-12-14T14:27:38', '2022-12-14', '14:27:38', 'IN', 'attendace', 'DS-K1A8503MF-B20191120V010203ENE12098421', 'Demo', '', '2022-12-14 09:27:41');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_active` int(11) NOT NULL DEFAULT 0,
  `brand_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_active`, `brand_status`) VALUES
(1, 'poly bags', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `brokers`
--

CREATE TABLE `brokers` (
  `broker_id` int(255) NOT NULL,
  `broker_name` text NOT NULL,
  `broker_phone` text NOT NULL,
  `broker_email` text NOT NULL,
  `broker_address` text NOT NULL,
  `broker_status` int(11) NOT NULL,
  `adddatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget`
--

CREATE TABLE `budget` (
  `budget_id` int(11) NOT NULL,
  `budget_name` text NOT NULL,
  `budget_amount` double NOT NULL,
  `budget_type` varchar(300) NOT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `voucher_type` int(11) DEFAULT NULL,
  `budget_date` date NOT NULL,
  `budget_add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `budget`
--

INSERT INTO `budget` (`budget_id`, `budget_name`, `budget_amount`, `budget_type`, `voucher_id`, `voucher_type`, `budget_date`, `budget_add_date`) VALUES
(1, 'expense added to shop', 5000, 'expense', 8, 1, '2021-06-20', '2021-06-20 13:35:45'),
(2, 'expense added to shop', 2000, 'expense', 9, 1, '2021-06-20', '2021-06-20 13:39:56'),
(3, 'expense added to shop', 1000, 'expense', 6815, 1, '2023-09-25', '2023-09-25 17:17:47');

-- --------------------------------------------------------

--
-- Table structure for table `budget_category`
--

CREATE TABLE `budget_category` (
  `budget_category_id` int(11) NOT NULL,
  `budget_category_name` text NOT NULL,
  `budget_category_type` varchar(400) NOT NULL,
  `budget_category_add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `category_price` varchar(100) NOT NULL DEFAULT '1',
  `category_purchase` varchar(100) NOT NULL,
  `categories_active` int(11) NOT NULL DEFAULT 0,
  `categories_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `category_price`, `category_purchase`, `categories_active`, `categories_status`) VALUES
(1, 'pvc rolls', '1', '', 0, 1),
(2, 'pvc bags', '1', '', 0, 1),
(3, 'hanger', '1', '', 0, 1),
(4, 'imp', '8.75', '', 0, 1),
(5, 'super cler', '9.35', '', 0, 1),
(6, 'sada ns', '8.75', '', 0, 1);

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
  `customer_id` int(11) DEFAULT NULL,
  `check_location` text DEFAULT NULL,
  `check_status` int(11) NOT NULL DEFAULT 0,
  `check_amount` varchar(100) DEFAULT NULL,
  `check_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checks`
--

INSERT INTO `checks` (`check_id`, `check_no`, `check_bank_name`, `check_expiry_date`, `check_type`, `voucher_id`, `customer_id`, `check_location`, `check_status`, `check_amount`, `check_timestamp`) VALUES
(5, 'dd no-72551', '', '', '', 189, NULL, NULL, 0, NULL, '2021-09-20 07:45:24'),
(6, 'c-81946794', '', '', '', 190, NULL, NULL, 0, NULL, '2021-09-20 08:17:54'),
(7, 'no-10371835', 'bank al habib limited', '', '', 193, NULL, NULL, 0, NULL, '2021-09-20 12:00:52'),
(8, 'dd no 08172559', '', '', '', 194, NULL, NULL, 0, NULL, '2021-09-20 12:57:43'),
(9, '', '', '', '', 195, NULL, NULL, 0, NULL, '2021-09-20 13:11:40'),
(10, '', '', '', '', 196, NULL, NULL, 0, NULL, '2021-09-21 04:35:23'),
(11, 'dd no-24576120', '', '', '', 197, NULL, NULL, 0, NULL, '2021-09-21 06:09:39'),
(12, '', '', '', '', 198, NULL, NULL, 0, NULL, '2021-09-21 07:02:01'),
(13, '', '', '', '', 199, NULL, NULL, 0, NULL, '2021-09-21 07:56:21'),
(14, 'dd ', '', '', '', 203, NULL, NULL, 0, NULL, '2021-09-22 11:28:58'),
(15, 'dd no-25350518', 'hbl', '2021-09-23', 'cross pay order', 206, NULL, NULL, 0, NULL, '2021-09-23 06:23:37'),
(16, 'c86591574', '', '2021-09-23', '', 208, NULL, NULL, 0, NULL, '2021-09-23 08:40:04'),
(17, 'dd no-06352921', 'meezan bank ', '2021-09-23', 'cross pay order', 209, NULL, NULL, 0, NULL, '2021-09-23 09:23:58'),
(18, 'c-68468455', 'mezzan bank', '2021-09-25', 'check cross', 215, NULL, NULL, 0, NULL, '2021-09-24 11:15:08'),
(19, '06352930', 'meezan bank ', '2021-09-24', 'cross pay order', 218, NULL, NULL, 0, NULL, '2021-09-24 12:22:16'),
(20, 'dd no 00738', 'habib metro bank', '', '', 220, NULL, NULL, 0, NULL, '2021-09-24 12:45:21'),
(21, 'no-83589262', 'meezan bank', '2021-10-10', 'check', 224, NULL, NULL, 0, NULL, '2021-09-25 08:12:32'),
(22, 'c-72659914', 'meezan bank ', '2021-09-25', '', 225, NULL, NULL, 0, NULL, '2021-09-25 12:17:16'),
(23, '10371834', 'bank al habib limited', '2021-03-10', 'check', 230, NULL, NULL, 0, NULL, '2021-09-27 06:55:06'),
(24, '86591577', 'meezan bank ', '2021-09-27', 'check', 231, NULL, NULL, 0, NULL, '2021-09-27 12:09:24'),
(25, '89357367', 'meezan bank ', '2021-10-18', 'check cross', 234, NULL, NULL, 0, NULL, '2021-09-28 10:12:27'),
(26, '14906246', 'habib metropolitan bank ltd', '2021-09-28', 'cross pay order', 235, NULL, NULL, 0, NULL, '2021-09-28 11:49:20'),
(27, '24788450', 'habib bank ', '2021-09-29', 'cross pay order', 237, NULL, NULL, 0, NULL, '2021-09-29 09:23:17'),
(28, '89357370', 'meezan bank ', '2021-10-20', 'check', 239, NULL, NULL, 0, NULL, '2021-09-29 11:09:49'),
(29, '02851032', 'silkbank', '2021-09-30', 'cross pay order', 243, NULL, NULL, 0, NULL, '2021-09-30 06:38:17'),
(30, '04868382', 'the bank of punjab', '2021-09-29', 'cross pay order', 245, NULL, NULL, 0, NULL, '2021-09-30 10:23:19'),
(31, '10376528', 'bank al habib limited', '2021-10-01', 'check cross', 246, NULL, NULL, 0, NULL, '2021-09-30 11:34:45'),
(32, '24576130', 'bank al habib limited', '2021-10-01', 'cross pay order', 249, NULL, NULL, 0, NULL, '2021-10-01 10:38:14'),
(33, '04868383', 'the bank of punjab', '2021-09-29', 'cross pay order', 250, NULL, NULL, 0, NULL, '2021-10-01 11:04:41'),
(34, '25350538', 'hbl', '2021-10-02', 'cross pay order', 256, NULL, NULL, 0, NULL, '2021-10-02 06:58:45'),
(36, '7573667', 'meezan bank', '2021-11-17', 'payorder', 0, 2, 'bank locker', 0, '500000', '2021-11-16 22:19:04'),
(37, '123', 'meezan ', '2023-09-25', 'cash ', 6812, NULL, NULL, 0, NULL, '2023-09-25 10:44:47');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` text NOT NULL,
  `address` text DEFAULT NULL,
  `company_phone` varchar(100) NOT NULL,
  `personal_phone` varchar(100) NOT NULL,
  `email` text DEFAULT NULL,
  `stock_manage` int(11) NOT NULL,
  `sale_interface` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `address`, `company_phone`, `personal_phone`, `email`, `stock_manage`, `sale_interface`) VALUES
(5, 'Chairmain traders', '532939393650ab2ce6da16.jpg', 'Faisalabad Punjab Pakistan', '123456789,312456789', '0412551909', 'testemail@info.com', 1, 'gui');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(2000) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_phone` varchar(13) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_status` int(255) NOT NULL,
  `customer_type` varchar(250) DEFAULT NULL,
  `customer_limit` varchar(100) NOT NULL DEFAULT '0',
  `customer_add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_status`, `customer_type`, `customer_limit`, `customer_add_date`) VALUES
(1, 'ats lahore', '', '03218453897', 'ats synthetics pvt ltd 3rd floor ats height 7th durand road lahore', 1, 'supplier', '0', '2021-06-05 07:05:17'),
(2, 'ali raza', '', '9876543', '', 1, 'customer', '500000', '2021-06-05 10:27:33'),
(3, 'meezan bank (bakarmandi)', '', '03227711909', '', 1, 'bank', '0', '2021-06-07 04:45:08'),
(4, 'shop', '', '1', '', 1, 'expense', '0', '2021-06-10 09:58:22'),
(5, 'mulatani', '', '000', '', 1, 'customer', '0', '2023-09-21 08:38:26'),
(6, 'Cash in hand', '', '03227711909', '', 1, 'bank', '0', '2021-06-07 04:45:08'),
(7, 'debit test', '', '0', '', 1, 'customer', '0', '2023-09-25 11:57:12'),
(8, 'credit test', '', '0', '', 1, 'supplier', '0', '2023-09-25 12:00:21'),
(9, 'faaiz', '', '0', '', 1, 'customer', '0', '2023-09-25 17:08:11');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `expense_name` varchar(100) DEFAULT NULL,
  `expense_status` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_name`, `expense_status`, `timestamp`) VALUES
(1, 'salary', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hold_product`
--

CREATE TABLE `hold_product` (
  `hold_product_id` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `hold_qty` int(11) NOT NULL,
  `customer_name` varchar(250) NOT NULL,
  `added_by` int(11) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT 0,
  `add_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `hold_product`
--

INSERT INTO `hold_product` (`hold_product_id`, `product_id`, `hold_qty`, `customer_name`, `added_by`, `is_deleted`, `add_datetime`) VALUES
(1, 101, 10, '2', 1, 0, '2021-12-12 20:12:09'),
(2, 101, 10, '4', 1, 0, '2021-12-12 20:12:09');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `page` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `nav_edit` int(11) NOT NULL DEFAULT 0,
  `nav_delete` int(11) NOT NULL DEFAULT 0,
  `nav_add` int(11) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `page`, `parent_id`, `icon`, `sort_order`, `nav_edit`, `nav_delete`, `nav_add`, `timestamp`) VALUES
(97, 'accounts', '#', 0, 'fa fa-edit', 4, 1, 1, 1, '2021-06-02 14:12:59'),
(98, 'customers', 'customers.php?type=customer', 97, 'fa fa-edit', 4, 1, 1, 1, '2021-04-13 11:03:33'),
(99, 'banks', 'customers.php?type=bank', 97, 'fa fa-edit', 2, 1, 1, 1, '2021-04-13 11:03:33'),
(100, 'users', 'users.php', 97, 'fa fa-edit', 3, 1, 1, 1, '2021-04-13 11:03:33'),
(101, 'vouchers', '#', 0, 'fa fa-clipboard-list', 3, 0, 0, 0, '2021-06-02 14:12:59'),
(104, 'order', '#', 0, 'fas fa-cart-plus', 1, 0, 0, 0, '2021-06-02 14:12:59'),
(105, 'Cash Sale', 'cash_sale.php', 104, 'fas fa-cart-plus', 9, 1, 0, 1, '2021-04-13 11:03:33'),
(106, 'view orders', 'view_orders.php', 104, 'fa fa-edit', 10, 0, 0, 0, '2021-04-13 11:03:33'),
(107, 'others', '#', 0, 'fa fa-edit', 7, 0, 0, 0, '2021-06-02 14:12:55'),
(108, 'Add Products', 'product.php?act=add#', 107, 'fa fa-edit', 12, 1, 0, 1, '2021-04-13 11:03:34'),
(109, 'view products', 'product.php?act=list', 107, 'fa fa-edit', 13, 1, 1, 1, '2021-04-13 11:03:34'),
(110, 'brands', 'brands.php#', 107, 'fa fa-edit', 14, 1, 1, 1, '2021-04-13 11:03:34'),
(111, '15 days sale', 'credit_sale.php?credit_type=15days', 104, 'fa fa-edit', 15, 1, 1, 1, '2021-06-05 10:37:18'),
(112, 'purchase', '#', 0, 'fa fa-edit', 2, 0, 0, 0, '2021-06-02 14:12:59'),
(113, 'Cash Purchase', 'cash_purchase.php', 112, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-13 13:33:37'),
(114, 'credit purchase', 'credit_purchase.php', 112, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-13 13:34:31'),
(115, 'Reports', '#', 0, 'fa fa-edit', 5, 0, 0, 0, '2021-06-02 14:12:59'),
(116, 'bank ledger', 'reports.php?type=bank', 115, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-14 12:03:11'),
(117, 'supplier ledger', 'reports.php?type=supplier', 115, 'fa fa-edit', NULL, 1, 0, 0, '2021-04-14 12:03:52'),
(118, 'customer ledger', 'reports.php?type=customer ', 115, 'fa-edit', NULL, 0, 0, 0, '2021-04-14 12:04:27'),
(119, 'view purchases', 'view_purchases.php', 112, 'add_to_queue', NULL, 1, 1, 1, '2021-04-15 12:17:07'),
(120, 'categories', 'categories.php#', 107, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-17 10:59:24'),
(121, 'supplier', 'customers.php?type=supplier', 97, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-17 11:36:01'),
(122, 'expense ', 'customers.php?type=expense', 97, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-17 11:41:42'),
(123, 'product purchase report', 'product_purchase_report.php', 115, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-20 09:07:34'),
(125, 'product sale report', 'product_sale_report.php', 115, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-21 10:48:47'),
(127, 'expense report', 'expence_report.php', 115, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-21 11:11:51'),
(128, 'income report', 'income_report.php', 115, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-21 11:12:23'),
(129, 'profit and loss', 'profit_loss.php', 115, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-21 11:12:38'),
(130, 'profit summary', 'profit_summary.php', 115, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-21 11:12:58'),
(131, 'trail balance', 'trail_balance.php#', 115, 'fa fa-edit', 6, 0, 0, 0, '2021-06-02 14:19:37'),
(132, '30 days sale', 'credit_sale.php?credit_type=30days', 104, 'add_to_queue', NULL, 1, 0, 1, '2021-06-02 14:10:27'),
(133, 'expense type', 'expense_type.php', 107, 'local_shipping', NULL, 0, 0, 0, '2021-06-10 10:03:43'),
(134, 'analytics', 'analytics.php', 115, '', NULL, 0, 0, 0, '2021-06-10 11:08:00'),
(135, 'sale report', 'sale_report', 115, 'shopping_cart', NULL, 0, 0, 0, '2021-06-15 07:56:59'),
(136, 'general voucher', 'voucher.php?act=general_voucher', 101, 'add_to_queue', NULL, 1, 0, 1, '2021-06-20 13:20:15'),
(137, 'expense voucher', 'voucher.php?act=expense_voucher', 101, 'local_shipping', NULL, 1, 0, 1, '2021-06-20 13:30:18'),
(138, 'single voucher', 'voucher.php?act=single_voucher', 101, 'shopping_cart', NULL, 1, 1, 1, '2021-06-20 13:30:47'),
(139, 'voucher lists', 'voucher.php?act=lists', 101, 'shopping_cart', NULL, 1, 1, 1, '2021-06-20 13:31:37'),
(140, 'backup & restore', 'backup.php', 107, 'shopping_cart', NULL, 1, 0, 1, '2021-06-26 07:56:24'),
(141, 'combine sale', 'combine_bill.php', 104, '', NULL, 0, 0, 0, '2023-09-25 13:47:17'),
(142, 'quotation', 'quotation.php', 104, 'add_to_queue', NULL, 0, 0, 0, '2024-04-15 07:38:20'),
(143, 'quotation list', 'quotation_list.php', 104, 'shopping_cart', NULL, 0, 0, 0, '2024-04-15 07:39:41'),
(145, 'production', 'production.php', 101, 'add_to_queue', NULL, 0, 0, 0, '2024-04-18 10:40:08'),
(146, 'add production', 'addproduction.php', 101, 'add_to_queue', NULL, 0, 0, 0, '2024-05-01 12:44:33');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
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
  `print_status` int(10) NOT NULL DEFAULT 0,
  `address` varchar(500) NOT NULL,
  `charges` varchar(200) NOT NULL,
  `note` varchar(1000) NOT NULL,
  `pending_order` varchar(1000) NOT NULL,
  `tracking` varchar(200) NOT NULL,
  `customer_profit` varchar(255) NOT NULL,
  `transaction_id` int(11) NOT NULL DEFAULT 0,
  `broker_id` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `delaytime` text DEFAULT NULL,
  `freight` text DEFAULT NULL,
  `order_narration` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `credit_sale_type` varchar(20) NOT NULL DEFAULT 'none',
  `vehicle_no` varchar(100) DEFAULT NULL,
  `voucher_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `transaction_paid_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `cod`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `customer_account`, `payment_account`, `order_status`, `print_status`, `address`, `charges`, `note`, `pending_order`, `tracking`, `customer_profit`, `transaction_id`, `broker_id`, `type`, `delaytime`, `freight`, `order_narration`, `timestamp`, `credit_sale_type`, `vehicle_no`, `voucher_no`) VALUES
(1, 1, '2021-06-10', 'sami', '101010', '', '', '59890', '0', '', '59890', '59890', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, '2021-06-10 10:47:34', 'none', 'le-395', NULL),
(2, 2, '2021-06-10', 'ali raza', '9876543', '', '', '78280', '0', '', '78280', '78280', '0', 'credit_sale', 1, 2, 3, '0', 0, '', '', '', '', '', '', 3, NULL, NULL, NULL, NULL, '1010', '2021-06-21 08:57:13', '15days', 'le-395', NULL),
(3, 7, '2021-06-12', 'ali raza', '9876543', '', '', '4920', '10', '', '4428', '528', '3900', 'credit_sale', 0, 2, 3, '0', 0, '', '', '', '', '', '', 8, NULL, NULL, NULL, '100', 'dfg', '2021-06-12 09:16:24', '15days', 'le-395', NULL),
(4, 9, '2021-06-12', 'sami', '101010', '', '', '137640', '0', '', '137640', '138140', '-500', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '500', NULL, '2021-06-12 09:32:29', 'none', 'le-395', NULL),
(5, 10, '2021-06-11', 'ali raza', '9876543', '', '', '4920', '0', '', '4920', '0', '4920', 'credit_sale', 0, 2, 0, '0', 0, '', '', '', '', '', '', 11, NULL, NULL, NULL, '', '', '2021-06-26 12:33:23', '15days', 'le-395', NULL),
(6, 12, '2021-06-13', 'ali raza', '9876543', '', '', '16500', '0', '', '16500', '73150', '-56650', 'credit_sale', 1, 2, 0, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', '321', '2021-06-13 08:39:28', 'none', 'le-395', NULL),
(7, 13, '2021-06-13', 'sami', '101010', '', '', '5000', '0', '', '5000', '5500', '-500', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '500', NULL, '2021-06-13 09:07:49', 'none', 'le-395', NULL),
(8, 0, '2021-06-13', 'ali raza', '9876543', '', '', '5470', '0', '', '5470', '5470', '0', 'credit_sale', 1, 2, 0, '0', 0, '', '', '', '', '', '', 14, NULL, NULL, NULL, '', '', '2021-06-21 08:57:36', '15days', 'le-395', NULL),
(9, 15, '2021-06-13', 'ali raza', '9876543', '', '', '5350', '0', '', '5350', '5350', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-13 09:45:46', 'none', 'le-395', NULL),
(10, 17, '2021-06-14', 'ali raza', '9876543', '', '', '10350', '20', '', '8280', '8280', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '1000', NULL, '2021-06-14 07:05:44', 'none', 'le-395', NULL),
(11, 0, '2021-06-14', 'ali raza', '9876543', '', '', '5050', '0', '', '5050', '5050', '0', 'credit_sale', 1, 2, 3, '0', 0, '', '', '', '', '', '', 20, NULL, NULL, NULL, '', '', '2021-06-21 08:57:05', '15days', 'le-395', NULL),
(12, 0, '2021-06-14', 'ali raza', '9876543', '', '', '5050', '0', '', '5050', '5050', '0', 'credit_sale', 1, 2, 3, '0', 0, '', '', '', '', '', '', 21, NULL, NULL, NULL, '', '', '2021-06-21 08:12:15', '15days', 'le-395', NULL),
(18, 42, '2021-06-26', 'ali raza', '9876543', '', '', '4900', '0', '', '4900', '4900', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-26 07:45:30', 'none', 'le-395', NULL),
(19, 43, '2021-06-26', 'sami', '101010', '', '', '4900', '0', '', '4900', '4900', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-26 08:08:22', 'none', 'le-395', NULL),
(20, 44, '2021-06-26', '', '', '', '', '9800', '0', '', '9800', '9800', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-26 08:52:49', 'none', '', NULL),
(21, 45, '2021-06-26', 'sami', '101010', '', '', '5150', '0', '', '5150', '5150', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-26 08:56:50', 'none', 'le-395', NULL),
(22, 46, '2021-06-26', 'ali raza', '9876543', '', '', '4900', '0', '', '4900', '4900', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-26 09:22:25', 'none', 'le-395', NULL),
(23, 55, '2021-06-26', 'ali raza', '9876543', '', '', '4900', '0', '', '4900', '4900', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-06-26 11:45:39', 'none', 'le-395', NULL),
(24, 56, '2021-07-29', 'sami', '101010', '', '', '24502.5', '0', '', '24502.5', '24502.5', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2021-07-29 08:20:31', 'none', 'le-395', NULL),
(25, 58, '2021-07-31', 'sami', '101010', '', '', '4900', '0', '', '5900', '5900', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '1000', NULL, '2021-07-31 12:07:30', 'none', 'le-395', NULL),
(26, 0, '2021-10-08', 'ali raza', '9876543', '', '', '52500', '0', '', '52500', '0', '52500', 'credit_sale', 0, 2, 3, '0', 0, '', '', '', '', '', '', 66, NULL, NULL, NULL, '', '12', '2021-10-08 12:38:11', '30days', '12', NULL),
(27, 0, '2021-12-11', 'ali raza', '9876543', '', '', '5470', '0', '', '5470', '0', '5470', 'credit_sale', 0, 2, 3, '1', 0, '', '', '', '', '', '', 67, NULL, NULL, NULL, '', 'test', '2021-12-11 10:37:55', '15days', 'abcd', NULL),
(28, 0, '2021-12-11', 'ali raza', '9876543', '', '', '5450', '0', '', '5450', '0', '5450', 'credit_sale', 0, 2, 3, '1', 0, '', '', '', '', '', '', 68, NULL, NULL, NULL, '', '', '2021-12-11 11:00:45', '5days', 'le-395', NULL),
(29, 0, '2022-03-01', 'ali raza', '9876543', '', '', '5050', '0', '', '5050', '0', '5050', 'credit_sale', 0, 2, 3, '1', 0, '', '', '', '', '', '', 69, NULL, NULL, NULL, '', '', '2022-03-01 09:38:10', '15days', 'le-395', NULL),
(30, 70, '2022-03-01', 'ali raza', '9876543', '', '', '5350', '0', '', '5350', '5350', '0', 'cash_in_hand', 1, NULL, 3, '0', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2022-03-01 09:40:18', 'none', 'le-395', NULL),
(31, 0, '2023-09-20', 'ali raza', '9876543', '', '', '5526', '0', '', '5526', ' 0', '5526', 'credit_sale', 0, 2, 3, '1', 0, '', '', '', '', '', '', 72, NULL, NULL, NULL, '', '123', '2023-09-20 09:27:20', '30days', 'le-395', '75731'),
(32, 76, '2023-09-25', 'ali raza', '9876543', '', '', '5000', '0', '', '5000', '5000', '0', 'cash_in_hand', 1, NULL, 3, '1', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2023-09-25 11:55:57', 'none', 'le-395', NULL),
(33, 0, '2023-09-25', 'debit test', '0', '', '', '5170', '0', '', '5170', '0', '5170', 'credit_sale', 0, 7, 6, '1', 0, '', '', '', '', '', '', 77, NULL, NULL, NULL, '', '123', '2023-09-25 11:58:31', '15days', '123', '123'),
(34, 79, '2023-09-25', 'debit test', '0', '', '', '5380', '0', '', '5380', '380', '5000', 'credit_sale', 0, 7, 6, '1', 0, '', '', '', '', '', '', 78, NULL, NULL, NULL, '', '123', '2023-09-25 11:59:11', '15days', '123', '123'),
(35, 85, '2023-09-25', 'ali raza', '9876543', '', '', '5150', '0', '', '5150', '5150', '0', 'cash_in_hand', 1, NULL, 6, '1', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2023-09-25 17:07:11', 'none', 'abcd', NULL),
(36, 0, '2023-09-25', 'faaiz', '0', '', '', '5100', '0', '', '5100', '0', '5100', 'credit_sale', 0, 9, 3, '1', 1, '', '', '', '', '', '', 86, NULL, NULL, NULL, '', '12', '2023-09-30 18:02:06', '30days', 'le-395', '1234'),
(37, 88, '2023-09-25', 'faaiz', '0', '', '', '5100', '0', '', '5100', '2100', '3000', 'credit_sale', 0, 9, 6, '1', 1, '', '', '', '', '', '', 87, NULL, NULL, NULL, '', '', '2023-09-30 18:02:06', '30days', 'le-395', '145'),
(38, 95, '2023-09-26', 'ali raza', '9876543', '', '', '5450', '0', '', '5450', '450', '5000', 'cash_in_hand', 0, NULL, 3, '1', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2023-09-25 23:52:10', 'none', 'le-395', NULL),
(39, 96, '2023-09-27', 'sami', '101010', '', '', '107920', '0', '', '107920', '247920', '-140000', 'cash_in_hand', 1, NULL, 3, '1', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2023-09-27 08:15:38', 'none', '123', NULL),
(40, 0, '2023-10-03', 'ali raza', '9876543', '', '', '5000', '0', '', '5000', '0', '5000', 'cash_in_hand', 0, NULL, 6, '1', 0, '', '', '', '', '', '', 0, NULL, NULL, NULL, '', NULL, '2023-10-18 09:24:30', 'none', '', '1234'),
(41, 0, '2024-01-23', 'faaiz', '0', '', '', '5170', '0', '', '5170', '0', '5170', 'credit_sale', 0, 9, 3, '1', 0, '', '', '', '', '', '', 97, NULL, NULL, NULL, '', 'test12213231', '2024-01-23 17:00:04', '15days', 'abcd', '12');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `quantity` double NOT NULL,
  `rate` double NOT NULL,
  `total` double NOT NULL,
  `order_item_status` int(11) NOT NULL DEFAULT 0,
  `discount` varchar(255) DEFAULT NULL,
  `gauge` text DEFAULT NULL,
  `width` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `rate`, `total`, `order_item_status`, `discount`, `gauge`, `width`) VALUES
(1, 2, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(2, 2, 21, 10, 5444, 54440, 1, NULL, NULL, NULL),
(3, 2, 19, 1, 5280, 5280, 1, NULL, NULL, NULL),
(4, 2, 99, 10, 7300, 73000, 1, NULL, NULL, NULL),
(5, 2, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(6, 1, 21, 10, 5444, 54440, 1, NULL, NULL, NULL),
(7, 2, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(8, 1, 21, 10, 5444, 54440, 1, NULL, NULL, NULL),
(9, 2, 19, 1, 5280, 5280, 1, NULL, NULL, NULL),
(10, 2, 99, 10, 7300, 73000, 1, NULL, NULL, NULL),
(11, 2, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(12, 2, 21, 10, 5444, 54440, 1, NULL, NULL, NULL),
(13, 3, 1, 1, 4920, 4920, 1, NULL, NULL, NULL),
(14, 4, 80, 5, 5898, 29490, 1, NULL, NULL, NULL),
(15, 4, 4, 21, 5150, 108150, 1, NULL, NULL, NULL),
(16, 5, 1, 1, 4920, 4920, 1, NULL, NULL, NULL),
(17, 6, 6, 1, 5900, 5900, 1, NULL, NULL, NULL),
(18, 6, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(19, 6, 4, 1, 5150, 5150, 1, NULL, NULL, NULL),
(20, 7, 2, 1, 5000, 5000, 1, NULL, NULL, NULL),
(21, 8, 3, 1, 5470, 5470, 1, NULL, NULL, NULL),
(22, 9, 5, 1, 5350, 5350, 1, NULL, NULL, NULL),
(23, 10, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(24, 10, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(25, 11, 2, 1, 5050, 5050, 1, NULL, NULL, NULL),
(26, 12, 2, 1, 5050, 5050, 1, NULL, NULL, NULL),
(27, 13, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(28, 14, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(29, 15, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(30, 16, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(31, 17, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(32, 18, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(33, 19, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(34, 20, 1, 2, 4900, 9800, 1, NULL, NULL, NULL),
(35, 21, 4, 1, 5150, 5150, 1, NULL, NULL, NULL),
(39, 22, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(40, 23, 1, 1, 4900, 4900, 1, NULL, NULL, NULL),
(41, 24, 1, 5, 4900.5, 24502.5, 1, NULL, NULL, NULL),
(42, 25, 1, 5, 4900, 4900, 1, NULL, NULL, NULL),
(43, 26, 4, 10, 5250, 52500, 1, NULL, NULL, NULL),
(44, 27, 3, 1, 5470, 5470, 1, NULL, NULL, NULL),
(45, 28, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(46, 29, 62, 1, 5050, 5050, 1, NULL, NULL, NULL),
(47, 30, 5, 1, 5350, 5350, 1, NULL, NULL, NULL),
(49, 31, 3, 1, 5526, 5526, 1, NULL, NULL, NULL),
(50, 32, 2, 1, 5000, 5000, 1, NULL, NULL, NULL),
(51, 33, 4, 1, 5170, 5170, 1, NULL, NULL, NULL),
(52, 34, 5, 1, 5380, 5380, 1, NULL, NULL, NULL),
(53, 35, 4, 1, 5150, 5150, 1, NULL, NULL, NULL),
(54, 36, 2, 1, 5100, 5100, 1, NULL, NULL, NULL),
(55, 37, 2, 1, 5100, 5100, 1, NULL, NULL, NULL),
(56, 38, 3, 1, 5450, 5450, 1, NULL, NULL, NULL),
(57, 39, 101, 5, 7000, 35000, 1, NULL, NULL, NULL),
(58, 39, 92, 10, 7292, 72920, 1, NULL, NULL, NULL),
(59, 40, 2, 1, 5000, 5000, 1, NULL, NULL, NULL),
(60, 41, 4, 1, 5170, 5170, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `privileges_id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `nav_url` text NOT NULL,
  `addby` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nav_add` int(11) NOT NULL DEFAULT 0,
  `nav_edit` int(11) NOT NULL DEFAULT 0,
  `nav_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`privileges_id`, `user_id`, `nav_id`, `nav_url`, `addby`, `date_time`, `nav_add`, `nav_edit`, `nav_delete`) VALUES
(332, 1, 98, 'customers.php?type=customer', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(333, 1, 99, 'customers.php?type=bank', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(334, 1, 100, 'users.php', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(335, 1, 102, 'voucher.php?act=add', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 0),
(336, 1, 103, 'voucher.php?act=list', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(337, 1, 105, 'cash_sale.php', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 0),
(338, 1, 106, 'view_orders.php', 'Added By: admin', '2021-04-15 12:26:49', 0, 0, 0),
(339, 1, 108, 'product.php?act=add#', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 0),
(340, 1, 109, 'product.php?act=list', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(341, 1, 110, 'brands.php#', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(342, 1, 111, 'credit_sale.php', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 0),
(343, 1, 113, 'cash_purchase.php', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(344, 1, 114, 'credit_purchase.php', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(345, 1, 116, 'reports.php?type=bank', 'Added By: admin', '2021-04-15 12:26:49', 1, 0, 1),
(346, 1, 117, 'reports.php?type=supplier', 'Added By: admin', '2021-04-15 12:26:49', 0, 0, 0),
(347, 1, 118, 'reports.php?type=customer ', 'Added By: admin', '2021-04-15 12:26:49', 0, 0, 0),
(348, 1, 119, 'view_purchases.php', 'Added By: admin', '2021-04-15 12:26:49', 0, 0, 0),
(349, 1, 0, '', 'Added By: admin', '2021-04-15 12:26:49', 0, 0, 0),
(386, 2, 98, 'customers.php?type=customer', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(387, 2, 99, 'customers.php?type=bank', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(388, 2, 100, 'users.php', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(389, 2, 102, 'voucher.php?act=add', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 0),
(390, 2, 103, 'voucher.php?act=list', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(391, 2, 105, 'cash_sale.php', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 0),
(392, 2, 106, 'view_orders.php', 'Added By: admin', '2021-06-04 12:43:16', 0, 0, 0),
(393, 2, 108, 'product.php?act=add#', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 0),
(394, 2, 109, 'product.php?act=list', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(395, 2, 110, 'brands.php#', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(396, 2, 111, 'credit_sale.php?credit_type=30days', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(397, 2, 113, 'cash_purchase.php', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 1),
(398, 2, 114, 'credit_purchase.php', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 0),
(399, 2, 116, 'reports.php?type=bank', 'Added By: admin', '2021-06-04 12:43:16', 0, 0, 0),
(400, 2, 117, 'reports.php?type=supplier', 'Added By: admin', '2021-06-04 12:43:16', 0, 0, 1),
(401, 2, 118, 'reports.php?type=customer ', 'Added By: admin', '2021-06-04 12:43:16', 1, 0, 0),
(402, 2, 119, 'view_purchases.php', 'Added By: admin', '2021-06-04 12:43:16', 0, 0, 0),
(403, 2, 0, 'categories.php#', 'Added By: admin', '2021-06-04 12:43:16', 0, 0, 0),
(410, 6, 98, 'customers.php?type=customer', 'Added By: admin', '2021-06-20 14:22:42', 1, 1, 1),
(411, 6, 99, 'customers.php?type=bank', 'Added By: admin', '2021-06-20 14:22:42', 1, 1, 1),
(412, 6, 100, 'users.php', 'Added By: admin', '2021-06-20 14:22:42', 1, 1, 1),
(413, 6, 105, 'cash_sale.php', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 0),
(414, 6, 106, 'view_orders.php', 'Added By: admin', '2021-06-20 14:22:43', 0, 0, 0),
(415, 6, 108, 'product.php?act=add#', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 0),
(416, 6, 109, 'product.php?act=list', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(417, 6, 110, 'brands.php#', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(418, 6, 111, 'credit_sale.php?credit_type=15days', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(419, 6, 113, 'cash_purchase.php', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(420, 6, 114, 'credit_purchase.php', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(421, 6, 116, 'reports.php?type=bank', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(422, 6, 117, 'reports.php?type=supplier', 'Added By: admin', '2021-06-20 14:22:43', 0, 1, 0),
(423, 6, 118, 'reports.php?type=customer ', 'Added By: admin', '2021-06-20 14:22:43', 0, 0, 0),
(424, 6, 119, 'view_purchases.php', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(425, 6, 120, 'categories.php#', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(426, 6, 121, 'customers.php?type=supplier', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(427, 6, 122, 'customers.php?type=expense', 'Added By: admin', '2021-06-20 14:22:43', 1, 1, 1),
(428, 6, 123, 'product_purchase_report.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(429, 6, 125, 'product_sale_report.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(430, 6, 127, 'expence_report.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(431, 6, 128, 'income_report.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(432, 6, 129, 'profit_loss.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(433, 6, 130, 'profit_summary.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(434, 6, 131, 'trail_balance.php#', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(435, 6, 132, 'credit_sale.php?credit_type=30days', 'Added By: admin', '2021-06-20 14:22:44', 1, 1, 0),
(436, 6, 133, 'expense_type.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(437, 6, 134, 'analytics.php', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(438, 6, 135, 'sale_report', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0),
(439, 6, 136, 'voucher.php?act=general_voucher', 'Added By: admin', '2021-06-20 14:22:44', 1, 1, 0),
(440, 6, 137, 'voucher.php?act=expense_voucher', 'Added By: admin', '2021-06-20 14:22:44', 1, 1, 0),
(441, 6, 138, 'voucher.php?act=single_voucher', 'Added By: admin', '2021-06-20 14:22:44', 1, 1, 1),
(442, 6, 139, 'voucher.php?act=lists', 'Added By: admin', '2021-06-20 14:22:44', 1, 1, 1),
(443, 6, 0, '', 'Added By: admin', '2021-06-20 14:22:44', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(200) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(250) DEFAULT NULL,
  `product_image` text NOT NULL,
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity_instock` double NOT NULL,
  `hold_product` int(100) DEFAULT NULL,
  `purchased` double NOT NULL,
  `current_rate` double NOT NULL,
  `f_days` text DEFAULT NULL,
  `t_days` text DEFAULT NULL,
  `purchase_rate` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `availability` int(11) DEFAULT 0,
  `alert_at` double DEFAULT 5,
  `weight` varchar(200) NOT NULL,
  `actual_rate` varchar(250) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_mm` varchar(100) NOT NULL DEFAULT '0',
  `product_inch` varchar(100) DEFAULT '0',
  `product_meter` varchar(100) NOT NULL DEFAULT '0',
  `adddatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_code`, `product_image`, `brand_id`, `category_id`, `quantity_instock`, `hold_product`, `purchased`, `current_rate`, `f_days`, `t_days`, `purchase_rate`, `status`, `availability`, `alert_at`, `weight`, `actual_rate`, `product_description`, `product_mm`, `product_inch`, `product_meter`, `adddatetime`) VALUES
(1, 'b2 10x50x24', 'b2105024', '', 1, 1, 63, NULL, 0, 4900, '4920', '4970', 4800, 0, 1, 5, '', NULL, 'b2 10x50x24', '0', '0', '0', '2021-12-11 12:45:59'),
(2, 'b2 10x54x24', 'b2105424', '', 1, 1, 111, NULL, 0, 5000, '5050', '5100', 4960, 1, 1, 5, '', NULL, 'b2 10x54x24', '0', '0', '0', '2024-01-23 17:00:32'),
(3, 'b2 10x60x26', 'b2106026', '', 1, 1, 47, NULL, 0, 5450, '5470', '5526', 0, 1, 1, 5, '', NULL, 'b2 10x60x26', '0', '0', '0', '2024-01-23 17:28:41'),
(4, 'b2 12x50x24', 'b2125024', '', 1, 1, 7, NULL, 0, 5150, '5170', '5250', 0, 1, 1, 5, '', NULL, 'b2 12x50x24', '0', '0', '0', '2024-01-23 17:01:03'),
(5, 'b2 12x54x24', 'b2125424', '', 1, 1, 50, NULL, 0, 5350, '5380', '5440', 0, 1, 1, 5, '', NULL, 'b2 12x54x24', '0', '0', '0', '2023-09-25 11:59:11'),
(6, 'b2 12x60x24', 'b2126024', '', 1, 1, 0, NULL, 0, 5900, '5930', '5990', 0, 1, 1, 5, '', NULL, '\r\nb2 12x60x24', '0', '0', '0', '2021-06-13 08:39:27'),
(7, 'b2 14x50x24', 'b2145024', '', 1, 1, 0, NULL, 0, 5575, '5600', '5650', 0, 1, 1, 5, '', NULL, 'b2 14x50x24', '0', '0', '0', '0000-00-00 00:00:00'),
(8, 'b2 14x54x24', 'b2145424', '', 1, 1, 0, NULL, 0, 5800, '5820', '5870', 0, 1, 1, 5, '', NULL, 'b2 14x54x24', '0', '0', '0', '0000-00-00 00:00:00'),
(9, 'b2 14x60x24', 'b2146024', '', 1, 1, 0, NULL, 0, 6350, '6370', '6500', 0, 1, 1, 5, '', NULL, 'b2 14x60x24', '0', '0', '0', '0000-00-00 00:00:00'),
(10, 'album  10x54x24', 'a105424', '', 1, 1, 0, NULL, 0, 7750, '7770', '7800', 0, 1, 1, 5, '', NULL, 'album  10x54x24', '0', '0', '0', '0000-00-00 00:00:00'),
(11, 'album  12x54x24', 'a125424', '', 1, 1, 0, NULL, 0, 8450, '8500', '8550', 0, 1, 1, 5, '', NULL, 'album  12x54x24', '0', '0', '0', '0000-00-00 00:00:00'),
(12, 'album  14x54x24', 'a145424', '', 1, 1, -1, NULL, 0, 9150, '9170', '9225', 0, 1, 1, 5, '', NULL, 'album  14x54x24', '0', '0', '0', '2021-06-10 09:46:55'),
(13, 'album  18x54x28 ', 'a185424', '', 1, 1, 0, NULL, 0, 18700, '12750', '12800', 0, 1, 1, 5, '', NULL, 'album  18x54x28 ', '0', '0', '0', '0000-00-00 00:00:00'),
(14, 'album  24x54x28 ', 'a245428', '', 1, 1, 0, NULL, 0, 7500, '7550', '7600', 0, 1, 1, 5, '', NULL, 'album  18x54x28 ', '0', '0', '0', '0000-00-00 00:00:00'),
(15, 'black paten 11x54x24', 'bp115424', '', 1, 1, 0, NULL, 0, 5150, '5170', '5230', 0, 1, 1, 5, '', NULL, 'black paten 11x54x24', '0', '0', '0', '0000-00-00 00:00:00'),
(16, 'black paten 13x48x28', 'bp134828', '', 1, 1, -1, NULL, 0, 4850, '4920', '4930', 0, 1, 1, 5, '', NULL, 'black paten 13x48x28', '0', '0', '0', '2021-06-10 09:46:56'),
(17, 'nargas 16x60x28', 'n166028', '', 1, 1, 0, NULL, 0, 5400, '5450', '5520', 0, 1, 1, 5, '', NULL, 'nargas 16x60x28', '0', '0', '0', '0000-00-00 00:00:00'),
(18, 'imp 6x52x28', 'imp65228', '', 1, 4, 0, NULL, 0, 5056, '5084', '5113', 5056, 1, 1, 5, '', NULL, 'imp 6x52x28', '6', '52', '100', '2021-06-07 10:16:41'),
(19, 'imp 6x54x24 ', 'imp65424', '', 1, 4, -1, NULL, 0, 5250, '5280', '5310', 5250, 1, 1, 5, '', NULL, 'imp 6x54x24 ', '6', '54', '100', '2021-06-10 10:49:22'),
(20, 'imp 6x52x24 ', 'imp65224', '', 1, 4, 0, NULL, 0, 5056, '5084', '5113', 5056, 1, 1, 5, '', NULL, 'imp 6x52x24 ', '6', '52', '100', '2021-06-07 10:16:41'),
(21, 'imp 7x48x24 ', 'imp74824', '', 1, 4, -10, NULL, 0, 5444, '5476', '5507', 5444, 1, 1, 5, '', NULL, 'imp 7x48x24 ', '7', '48', '100', '2021-06-10 10:47:34'),
(22, 'imp 7x52x24 ', 'imp75224', '', 1, 4, 0, NULL, 0, 5898, '5932', '5966', 5898, 1, 1, 5, '', NULL, 'imp 7x52x24 ', '7', '52', '100', '2021-06-07 10:16:41'),
(23, 'imp 7x54x24 ', 'imp75424', '', 1, 4, 0, NULL, 0, 6125, '6160', '6195', 6125, 1, 1, 5, '', NULL, 'imp 7x54x24 ', '7', '54', '100', '2021-06-07 10:16:41'),
(24, 'imp 8x50x24', 'imp85024', '', 1, 4, 0, NULL, 0, 6481, '6519', '6556', 6481, 1, 1, 5, '', NULL, 'imp 8x50x24', '8', '50', '100', '2021-06-07 10:16:41'),
(25, 'imp 8x52x24 ', 'imp85224', '', 1, 4, 0, NULL, 0, 6741, '6779', '6818', 6741, 1, 1, 5, '', NULL, 'imp 8x52x24 ', '8', '52', '100', '2021-06-07 10:16:41'),
(26, 'imp 8x56x24 ', 'imp85624', '', 1, 4, 0, NULL, 0, 7259, '7301', '7342', 7259, 1, 1, 5, '', NULL, 'imp 8x56x24 ', '8', '56', '100', '2021-06-07 10:16:41'),
(27, 'imp 9x48x26 ', 'imp94826', '', 1, 4, 0, NULL, 0, 7000, '7040', '7080', 7000, 1, 1, 5, '', NULL, 'imp 9x48x26 ', '9', '48', '100', '2021-06-07 10:16:41'),
(28, 'imp 9x50x26', 'imp95026', '', 1, 4, 0, NULL, 0, 7292, '7333', '7375', 7292, 1, 1, 5, '', NULL, 'imp 9x50x26', '9', '50', '100', '2021-06-07 10:16:41'),
(29, 'imp 9x52x26 ', 'imp95226', '', 1, 4, 0, NULL, 0, 7583, '7627', '7670', 7583, 1, 1, 5, '', NULL, 'imp 9x52x26 ', '9', '52', '100', '2021-06-07 10:16:41'),
(30, 'imp 9x56x24 ', 'imp95624', '', 1, 4, 0, NULL, 0, 8167, '8213', '8260', 8167, 1, 1, 5, '', NULL, 'imp 9x56x24 ', '9', '56', '100', '2021-06-07 10:16:41'),
(31, 'imp 9x54x24 ', 'imp95424', '', 1, 4, 0, NULL, 0, 7875, '7920', '7965', 7875, 1, 1, 5, '', NULL, 'imp 9x54x24 ', '9', '54', '100', '2021-06-07 10:16:41'),
(32, 'imp 9x60x24 ', 'imp96024', '', 1, 4, 0, NULL, 0, 8750, '8800', '8850', 0, 1, 1, 5, '', NULL, 'imp 9x54x24 ', '9', '60', '100', '2021-06-05 11:01:07'),
(33, 'imp 8x60x24 ', 'imp86024', '', 1, 4, 0, NULL, 0, 7778, '7822', '7867', 0, 1, 1, 5, '', NULL, 'imp 9x54x24 ', '8', '60', '100', '2021-06-05 11:01:44'),
(34, 'imp 10x48x26 ', 'imp104826', '', 1, 4, 0, NULL, 0, 7778, '7822', '7867', 0, 1, 1, 5, '', NULL, 'imp 10x48x26 ', '10', '48', '100', '2021-06-05 11:02:39'),
(35, 'imp10x50x26 ', 'imp105026', '', 1, 4, 0, NULL, 0, 8102, '8148', '8194', 0, 1, 1, 5, '', NULL, 'imp 10x50x26 ', '10', '50', '100', '2021-06-07 06:17:10'),
(36, 'imp 10x52x26 ', 'imp105226', '', 1, 4, 0, NULL, 0, 8426, '8474', '8522', 0, 1, 1, 5, '', NULL, 'imp 10x52x26 ', '10', '52', '100', '2021-06-05 11:07:48'),
(37, 'imp 10x54x26 ', 'imp105426', '', 1, 4, 0, NULL, 0, 8750, '8800', '8850', 0, 1, 1, 5, '', NULL, 'imp 10x54x26 ', '10', '54', '100', '2021-06-05 11:08:39'),
(38, 'imp 11x48x26 ', 'imp114826', '', 1, 4, 0, NULL, 0, 4278, '4302', '4327', 4278, 1, 1, 5, '', NULL, 'imp 11x48x26 ', '11', '48', '50', '2021-06-07 11:02:38'),
(39, 'imp 11x50x28 ', 'imp115028', '', 1, 4, 0, NULL, 0, 4456, '4481', '4507', 4405, 1, 1, 5, '', NULL, 'imp 11x50x28 ', '11', '50', '50', '2021-06-07 11:04:51'),
(40, 'imp 11x50x26 ', 'imp115026', '', 1, 4, 0, NULL, 0, 4456, '4481', '4507', 4456, 1, 1, 5, '', NULL, 'imp 11x50x26 ', '11', '50', '50', '2021-06-07 11:04:51'),
(41, 'imp 11x52x26', 'imp115226', '', 1, 4, 0, NULL, 0, 4634, '4661', '4687', 4634, 1, 1, 5, '', NULL, 'imp 11x52x26', '11', '52', '50', '2021-06-07 10:56:55'),
(42, 'imp 11x60x26 ', 'imp116026', '', 1, 4, 0, NULL, 0, 5347, '5378', '5408', 5347, 1, 1, 5, '', NULL, 'imp 11x60x26 ', '11', '60', '50', '2021-06-07 10:56:55'),
(43, 'imp 12x48x26 ', 'imp124826', '', 1, 4, 0, NULL, 0, 4667, '4693', '4720', 4667, 1, 1, 5, '', NULL, 'imp 12x48x26 ', '12', '48', '50', '2021-06-07 10:56:55'),
(44, 'imp 12x50x28 ', 'imp125028', '', 1, 4, 0, NULL, 0, 4861, '4889', '4917', 0, 1, 1, 5, '', NULL, 'imp 12x50x28 ', '12', '50', '50', '2021-06-05 11:15:54'),
(45, 'imp 12x52x26 ', 'imp125226', '', 1, 4, 0, NULL, 0, 5056, '5084', '5113', 5056, 1, 1, 5, '', NULL, 'imp 12x52x26 ', '12', '52', '50', '2021-06-07 10:56:55'),
(46, 'imp 12x56x30 ', 'imp125630', '', 1, 4, 0, NULL, 0, 5444, '5476', '5507', 5444, 1, 1, 5, '', NULL, 'imp 12x56x30 ', '12', '56', '50', '2021-06-07 10:56:55'),
(47, 'imp 13x48x28 ', 'imp134828', '', 1, 4, 0, NULL, 0, 5056, '5084', '5113', 5056, 1, 1, 5, '', NULL, 'imp 13x48x28 ', '13', '48', '50', '2021-06-07 10:56:55'),
(48, 'imp 13x52x28 ', 'imp135228', '', 1, 4, 0, NULL, 0, 5477, '5508', '5539', 5477, 1, 1, 5, '', NULL, 'imp 13x52x28 ', '13', '52', '50', '2021-06-07 10:56:55'),
(49, 'imp 13x54x28 ', 'imp135428', '', 1, 4, 0, NULL, 0, 5688, '5720', '5753', 5688, 1, 1, 5, '', NULL, 'imp 13x54x28 ', '13', '54', '50', '2021-06-07 10:56:55'),
(50, 'imp 13x60x26 ', 'imp136026', '', 1, 4, 0, NULL, 0, 6319, '6356', '6392', 6319, 1, 1, 5, '', NULL, 'imp 13x60x26 ', '13', '60', '50', '2021-06-07 10:56:55'),
(51, 'imp 14x52x28 ', 'imp145228', '', 1, 4, 0, NULL, 0, 5898, '5932', '5966', 5898, 1, 1, 5, '', NULL, 'imp 14x52x28 ', '14', '52', '50', '2021-06-07 10:56:55'),
(52, 'imp 15x54x32 ', 'imp155432', '', 1, 4, 0, NULL, 0, 6563, '6600', '6638', 6563, 1, 1, 5, '', NULL, 'imp 15x54x32 ', '15', '54', '50', '2021-06-07 10:56:55'),
(53, 'imp 14x50x26 ', 'imp145026', '', 1, 4, 0, NULL, 0, 5671, '5704', '5736', 5671, 1, 1, 5, '', NULL, 'imp 14x50x26 ', '14', '50', '50', '2021-06-07 10:56:55'),
(54, 'imp 14x48x24 ', 'imp144824', '', 1, 4, 0, NULL, 0, 5444, '5476', '5507', 5444, 1, 1, 5, '', NULL, 'imp 14x48x24 ', '14', '48', '50', '2021-06-07 10:56:55'),
(55, 'imp 12x54x24 ', 'imp125424', '', 1, 4, 0, NULL, 0, 5250, '5280', '5310', 5250, 1, 1, 5, '', NULL, 'imp 12x54x24 ', '12', '54', '50', '2021-06-07 10:56:55'),
(56, 'imp 11x54x24 ', 'imp115424', '', 1, 4, 0, NULL, 0, 4813, '4840', '4868', 4813, 1, 1, 5, '', NULL, 'imp 11x54x24 ', '11', '54', '50', '2021-06-07 10:56:55'),
(57, 'imp 11x58x24 ', 'imp115824', '', 1, 4, 0, NULL, 0, 5169, '5199', '5228', 5169, 1, 1, 5, '', NULL, 'imp 11x58x24 ', '11', '58', '50', '2021-06-07 10:56:55'),
(58, 'imp 12x58x24 ', 'imp125824', '', 1, 4, 0, NULL, 0, 5639, '5671', '5703', 5639, 1, 1, 5, '', NULL, 'imp 12x58x24 ', '12', '58', '50', '2021-06-07 10:56:55'),
(59, 'imp 11x56x26 ', 'imp115626', '', 1, 4, 0, NULL, 0, 4991, '5019', '5048', 4991, 1, 1, 5, '', NULL, 'imp 11x56x26 ', '11', '56', '50', '2021-06-07 10:56:55'),
(60, 'super clear 8x54x28 ', 'sc85428', '', 1, 5, 0, NULL, 0, 7480, '7520', '7560', 0, 1, 1, 5, '', NULL, 'super clear 8x54x28 ', '8', '54', '100', '2021-06-05 11:40:36'),
(61, 'super clear 9x54x26 ', 'sc95426', '', 1, 5, 0, NULL, 0, 8415, '8460', '8505', 0, 1, 1, 5, '', NULL, 'super clear 9x54x26 ', '9', '54', '100', '2021-06-05 11:41:57'),
(62, 'super clear 9x60x26 ', 'sc96026', '', 1, 5, -1, NULL, 0, 9350, '9400', '9450', 0, 1, 1, 5, '', NULL, 'super clear 9x60x26 ', '9', '60', '100', '2022-03-01 09:38:09'),
(63, 'super clear 10x60x26 ', 'sc106026', '', 1, 5, 0, NULL, 0, 10389, '10444', '10500', 0, 1, 1, 5, '', NULL, 'super clear 10x60x26 ', '10', '60', '100', '2021-06-05 11:44:25'),
(64, 'super clear 11x54x26 ', 'sc115426', '', 1, 5, 0, NULL, 0, 10285, '10340', '10395', 0, 1, 1, 5, '', NULL, 'super clear 11x54x26 ', '11', '54', '100', '2021-06-05 11:45:15'),
(65, 'super clear 11x58x26 ', 'sc115826', '', 1, 5, -1, NULL, 0, 11047, '11106', '11165', 0, 1, 1, 5, '', NULL, 'super clear 26x58x26 ', '11', '58', '100', '2021-06-10 09:46:56'),
(66, 'super clear 11x60x26 ', 'sc116026', '', 1, 5, 0, NULL, 0, 11428, '11489', '11550', 0, 1, 1, 5, '', NULL, 'super clear 11x60x26 ', '11', '60', '100', '2021-06-05 11:47:31'),
(67, 'super clear 12x54x26 ', 'sc125426', '', 1, 5, 0, NULL, 0, 11220, '11280', '11340', 0, 1, 1, 5, '', NULL, 'super clear 12x54x26 ', '12', '54', '100', '2021-06-05 11:48:34'),
(68, 'super clear 12x60x26 ', 'sc126026', '', 1, 5, 0, NULL, 0, 12467, '12533', '12600', 0, 1, 1, 5, '', NULL, 'super clear 12x60x26 ', '12', '60', '100', '2021-06-05 11:49:30'),
(69, 'super clear 13x54x28 ', 'sc135428', '', 1, 5, 0, NULL, 0, 12155, '12220', '12285', 0, 1, 1, 5, '', NULL, 'super clear 13x54x28 ', '13', '54', '100', '2021-06-05 11:50:26'),
(70, 'super clear 13x60x28 ', 'sc136028', '', 1, 5, 0, NULL, 0, 13506, '13578', '13650', 0, 1, 1, 5, '', NULL, 'super clear 13x60x28 ', '13', '60', '100', '2021-06-05 11:51:38'),
(71, 'super clear 14x52x30 ', 'sc145230', '', 1, 5, 0, NULL, 0, 12605, '12673', '12740', 0, 1, 1, 5, '', NULL, 'super clear 14x52x30 ', '14', '52', '100', '2021-06-05 11:52:56'),
(72, 'super clear 14x60x26 ', 'sc146026', '', 1, 5, 0, NULL, 0, 14544, '14622', '14700', 0, 1, 1, 5, '', NULL, 'super clear 14x60x26 ', '14', '60', '100', '2021-06-05 11:54:21'),
(73, 'super clear 15x60x26 ', 'sc156026', '', 1, 5, 0, NULL, 0, 15583, '15667', '15750', 0, 1, 1, 5, '', NULL, 'super clear 15x60x26 ', '15', '60', '100', '2021-06-05 11:55:11'),
(74, 'super clear 16x60x26 ', 'sc166026', '', 1, 5, 0, NULL, 0, 16622, '16711', '16800', 0, 1, 1, 5, '', NULL, 'super clear 16x60x26 ', '16', '60', '100', '2021-06-05 11:56:33'),
(75, 'super clear 8x60x26 ', 'sc86026', '', 1, 5, 0, NULL, 0, 8311, '8356', '8400', 0, 1, 1, 5, '', NULL, 'super clear 8x60x26 ', '8', '60', '100', '2021-06-05 11:57:29'),
(76, 'ns 6x48x24', 'ns64824', '', 1, 6, 0, NULL, 0, 4667, '4693', '4720', 0, 1, 1, 5, '', NULL, 'ns 6x48x24', '6', '48', '100', '2021-06-05 12:03:41'),
(77, 'ns 6x52x22', 'ns65222', '', 1, 6, 0, NULL, 0, 5056, '5084', '5113', 0, 1, 1, 5, '', NULL, 'ns 6x52x22', '6', '52', '100', '2021-06-05 12:46:36'),
(78, 'ns 6x54x24', 'ns65424', '', 1, 6, 0, NULL, 0, 5250, '5280', '5310', 0, 1, 1, 5, '', NULL, 'ns 6x54x24', '6', '54', '100', '2021-06-05 12:47:34'),
(79, 'ns 7x48x24', 'ns74824', '', 1, 6, 0, NULL, 0, 5444, '5476', '5507', 0, 1, 1, 5, '', NULL, 'ns 7x48x24', '7', '48', '100', '2021-06-05 12:48:26'),
(80, 'ns 7x52x24', 'ns75224', '', 1, 6, -5, NULL, 0, 5898, '5932', '5966', 0, 1, 1, 5, '', NULL, 'ns 7x52x24', '7', '52', '100', '2021-06-12 09:32:28'),
(81, 'ns 7x60x24', 'ns76024', '', 1, 6, 0, NULL, 0, 6806, '6844', '6883', 0, 1, 1, 5, '', NULL, 'ns 7x60x24', '7', '60', '100', '2021-06-05 12:51:17'),
(82, 'ns 7x54x24', 'ns75424', '', 1, 6, 0, NULL, 0, 6125, '6160', '6195', 0, 1, 1, 5, '', NULL, 'ns 7x54x24', '7', '54', '100', '2021-06-05 12:52:16'),
(83, 'ns 8x50x24', 'ns85024', '', 1, 6, -1, NULL, 0, 6481, '6519', '6556', 0, 1, 1, 5, '', NULL, 'ns 8x50x24', '8', '50', '100', '2021-06-10 10:42:03'),
(84, 'ns 8x52x24', 'ns85224', '', 1, 6, 0, NULL, 0, 6741, '6779', '6818', 0, 1, 1, 5, '', NULL, 'ns 8x52x24', '8', '52', '100', '2021-06-05 12:53:58'),
(85, 'ns 8x54x24', 'ns85424', '', 1, 6, 0, NULL, 0, 7000, '7040', '7080', 0, 1, 1, 5, '', NULL, 'ns 8x54x24', '8', '54', '100', '2021-06-05 12:54:41'),
(86, 'ns 8x60x24', 'ns86024', '', 1, 6, 0, NULL, 0, 7778, '7822', '7867', 0, 1, 1, 5, '', NULL, 'ns 8x60x24', '8', '60', '100', '2021-06-05 12:55:26'),
(87, 'ns 9x54x26', 'ns95426', '', 1, 6, 0, NULL, 0, 7875, '7920', '7965', 0, 1, 1, 5, '', NULL, 'ns 9x54x26', '9', '54', '100', '2021-06-05 12:56:12'),
(88, 'ns 9x48x26', 'ns94826', '', 1, 6, 0, NULL, 0, 7000, '7040', '7080', 0, 1, 1, 5, '', NULL, 'ns 9x48x26', '9', '48', '100', '2021-06-05 12:57:12'),
(89, 'ns 10x50x30', 'ns105030', '', 1, 6, 0, NULL, 0, 8102, '8148', '8194', 0, 1, 1, 5, '', NULL, 'ns 10x50x30', '10', '50', '100', '2021-06-05 12:59:31'),
(90, 'ns 9x60x24', 'ns96024', '', 1, 6, 0, NULL, 0, 8750, '8800', '8850', 0, 1, 1, 5, '', NULL, 'ns 9x60x24', '9', '60', '100', '2021-06-05 13:00:31'),
(91, 'ns 10x54x26', 'ns105426', '', 1, 6, 0, NULL, 0, 8750, '8800', '8850', 0, 1, 1, 5, '', NULL, 'ns 10x54x26', '10', '54', '100', '2021-06-05 13:01:34'),
(92, 'ns 9x50x26', 'ns95026', '', 1, 6, -10, NULL, 0, 7292, '7333', '7375', 0, 1, 1, 5, '', NULL, 'ns 9x50x26', '9', '50', '100', '2023-09-27 08:15:38'),
(93, 'ns 11x48x26', 'ns114826', '', 1, 6, 0, NULL, 0, 4278, '4302', '4327', 0, 1, 1, 5, '', NULL, 'ns 11x48x26', '11', '48', '50', '2021-06-05 13:03:26'),
(94, 'ns 11x52x26', 'ns115226', '', 1, 6, 0, NULL, 0, 4634, '4661', '4687', 0, 1, 1, 5, '', NULL, 'ns 11x52x26', '11', '52', '50', '2021-06-05 13:04:28'),
(95, 'ns 11x58x26', 'ns115826', '', 1, 6, 0, NULL, 0, 5169, '5199', '5228', 0, 1, 1, 5, '', NULL, 'ns 11x58x26', '11', '58', '50', '2021-06-10 10:34:47'),
(96, 'ns 12x50x26', 'ns125026', '', 1, 6, -10, NULL, 0, 4861, '4889', '4917', 0, 1, 1, 5, '', NULL, 'ns 12x50x26', '12', '50', '50', '2021-06-10 09:46:56'),
(97, 'ns 13x50x26', 'ns135026', '', 1, 6, 0, NULL, 0, 5266, '5296', '5326', 0, 1, 1, 5, '', NULL, 'ns 13x50x26', '13', '50', '50', '2021-06-05 13:06:57'),
(98, 'ns 8x48x24', 'ns84824', '', 1, 6, 0, NULL, 0, 6222, '6258', '6293', 0, 1, 1, 5, '', NULL, 'ns 8x48x24', '8', '48', '100', '2021-06-05 13:08:01'),
(99, 'ns 8x56x24', 'ns85624', '', 1, 6, -10, NULL, 0, 7259, '7301', '7342', 0, 1, 1, 5, '', NULL, 'ns 8x56x24', '8', '56', '100', '2021-06-10 10:49:22'),
(100, 'ns 8x48x30', 'ns84830', '', 1, 6, 0, NULL, 0, 6222, '6258', '6293', 0, 1, 1, 5, '', NULL, 'ns 8x48x30', '8', '48', '100', '2021-06-05 13:10:33'),
(101, 'ns 8x54x30', 'ns85430', '', 1, 6, -5, NULL, 0, 7000, '7040', '7080', 0, 1, 1, 5, '', NULL, 'ns 8x54x30', '8', '54', '100', '2023-09-27 08:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `production_id` int(11) NOT NULL,
  `production_date` text NOT NULL,
  `production_name` text NOT NULL,
  `customer` text NOT NULL,
  `customer_address` text NOT NULL,
  `production_lat_no` text NOT NULL,
  `production_cost` text NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`production_id`, `production_date`, `production_name`, `customer`, `customer_address`, `production_lat_no`, `production_cost`, `added_time`) VALUES
(1, '2024-05-03', 'new production', 'noman', 'house no 185 h-block gulistan colony faisalabad', '55725745472', '100000', '2024-05-03 06:31:42'),
(2, '2024-05-03', 'clothing', 'usama arshad', 'chichawatni', '12640094772', '500000', '2024-05-03 06:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchase_date` date NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_contact` varchar(255) NOT NULL,
  `sub_total` varchar(255) NOT NULL,
  `vat` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `grand_total` varchar(255) NOT NULL,
  `paid` varchar(255) NOT NULL,
  `due` varchar(255) NOT NULL,
  `payment_type` varchar(30) DEFAULT NULL,
  `payment_account` int(11) DEFAULT NULL,
  `customer_account` int(11) DEFAULT NULL,
  `payment_status` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `transaction_paid_id` int(11) NOT NULL,
  `purchase_narration` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `purchase_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `paid`, `due`, `payment_type`, `payment_account`, `customer_account`, `payment_status`, `transaction_id`, `transaction_paid_id`, `purchase_narration`, `timestamp`) VALUES
(6, '2021-06-07', 'ats lahore', '03218453897', '', '', '0', '0', '0', '0', '0', 'cash_in_hand', 3, 1, 1, 0, 15, 'imp', '2021-06-07 06:25:11'),
(7, '2021-06-07', 'ats lahore', '03218453897', '', '', '4900', '0', '4900', '110760', '-105860', 'cash_in_hand', 3, 1, 1, 0, 16, 'imp', '2021-06-07 06:28:34'),
(8, '2021-06-10', 'ats lahore', '03218453897', '', '', '9920', '0', '9920', '9920', '0', 'cash_purchase', 3, 1, 1, 0, 4, '10', '2021-06-10 10:50:41'),
(9, '2021-06-10', 'ats lahore', '03218453897', '', '', '4960', '0', '4960', '960', '4000', 'credit_purchase', 3, 1, 1, 5, 6, '00', '2021-06-10 10:58:35'),
(10, '2021-06-14', 'ats lahore', '03218453897', '', '', '6800', '0', '6800', '6800', '0', 'cash_purchase', 3, 1, 1, 0, 16, 'not', '2021-06-14 07:04:30'),
(11, '2021-06-14', 'ats lahore', '03218453897', '', '', '4960', '0', '4960', '0', '4960', 'credit_purchase', 0, 1, 1, 18, 0, 'not paid yet', '2021-06-14 07:12:05'),
(12, '2021-06-14', 'ats lahore', '03218453897', '', '', '4800', '0', '4800', '4800', '0', 'cash_purchase', 3, 1, 1, 0, 19, '7890-', '2021-06-14 07:15:09'),
(13, '2021-06-26', 'ats lahore', '03218453897', '', '', '240000', '0', '240000', '240000', '0', 'cash_purchase', 3, 1, 1, 0, 47, 'a', '2021-06-26 09:55:13'),
(14, '2021-06-26', 'ats lahore', '03218453897', '', '', '48000', '0', '48000', '48000', '0', 'cash_purchase', 3, 1, 1, 0, 48, 'hj', '2021-06-26 10:00:29'),
(15, '2021-06-26', 'ats lahore', '03218453897', '', '', '496000', '0', '496000', '496000', '0', 'cash_purchase', 3, 1, 1, 0, 49, '', '2021-06-26 10:01:58'),
(16, '2021-06-26', 'ats lahore', '03218453897', '', '', '14950', '0', '14950', '14950', '0', 'cash_purchase', 3, 1, 1, 0, 50, 'a', '2021-06-26 10:03:32'),
(17, '2021-06-26', 'ats lahore', '03218453897', '', '', '200', '0', '200', '200', '0', 'cash_purchase', 3, 1, 1, 0, 51, 'sdf', '2021-06-26 10:04:24'),
(18, '2021-06-26', 'ats lahore', '03218453897', '', '', '50000', '0', '50000', '50000', '0', 'cash_purchase', 3, 1, 1, 0, 52, 'a', '2021-06-26 10:25:15'),
(19, '2021-06-26', 'ats lahore', '03218453897', '', '', '48000', '0', '48000', '48000', '0', 'cash_purchase', 3, 1, 1, 0, 53, '', '2021-06-26 10:40:16'),
(20, '2021-06-26', 'ats lahore', '03218453897', '', '', '900', '0', '900', '900', '0', 'cash_purchase', 3, 1, 1, 0, 54, '', '2021-06-26 10:41:29'),
(22, '2023-09-25', 'credit test', '0', '', '', '4960', '0', '4960', '4960', '0', 'cash_purchase', 6, 8, 1, 0, 81, '', '2023-09-25 12:02:42'),
(23, '2023-09-25', 'credit test', '0', '', '', '4960', '0', '4960', '0', '4960', 'credit_purchase', 6, 8, 1, 82, 0, '', '2023-09-25 12:03:28'),
(24, '2023-09-25', 'credit test', '0', '', '', '4960', '0', '4960', '4960', '0', 'cash_purchase', 6, 8, 1, 0, 91, '', '2023-09-25 17:15:29'),
(25, '2023-09-25', 'credit test', '0', '', '', '4960', '0', '4960', '0', '4960', 'credit_purchase', 6, 8, 1, 92, 0, '', '2023-09-25 17:16:21'),
(26, '2024-01-23', 'ats lahore', '03218453897', '', '', '4960', '0', '4960', '4960', '0', 'cash_purchase', 3, 1, 1, 0, 98, '12343235', '2024-01-23 17:00:32'),
(27, '2024-01-23', 'ats lahore', '03218453897', '', '', '50', '0', '50', '0', '50', 'credit_purchase', 3, 1, 1, 99, 0, '12345', '2024-01-23 17:01:03'),
(28, '2024-01-23', 'credit test', '0', '', '', '299', '0', '299', '299', '0', 'cash_purchase', 3, 8, 1, 0, 100, '', '2024-01-23 17:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_item`
--

CREATE TABLE `purchase_item` (
  `purchase_item_id` int(255) NOT NULL,
  `purchase_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `purchase_item_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`purchase_item_id`, `purchase_id`, `product_id`, `quantity`, `rate`, `total`, `purchase_item_status`) VALUES
(3, 1, 18, '10', '4998', '49980', 1),
(4, 2, 18, '5', '4998', '24990', 1),
(5, 3, 18, '10', '5056', '50560', 1),
(6, 4, 18, '0', '4998', '0', 1),
(7, 5, 19, '0', '5190', '0', 1),
(235, 6, 18, '0', '5056', '0', 1),
(236, 6, 19, '0', '5250', '0', 1),
(237, 6, 20, '0', '5056', '0', 1),
(238, 6, 21, '0', '5444', '0', 1),
(239, 6, 22, '0', '5898', '0', 1),
(240, 6, 23, '0', '6125', '0', 1),
(241, 6, 24, '0', '6481', '0', 1),
(242, 6, 25, '0', '6741', '0', 1),
(243, 6, 26, '0', '7259', '0', 1),
(244, 6, 27, '0', '7000', '0', 1),
(245, 6, 28, '0', '7292', '0', 1),
(246, 6, 29, '0', '7583', '0', 1),
(247, 6, 30, '0', '8167', '0', 1),
(248, 6, 1, '0', '4900', '0', 1),
(249, 6, 31, '0', '7875', '0', 1),
(356, 7, 38, '0', '4278', '0', 1),
(357, 7, 39, '0', '4405', '0', 1),
(358, 7, 40, '0', '4456', '0', 1),
(359, 7, 41, '0', '4634', '0', 1),
(360, 7, 42, '0', '5347', '0', 1),
(361, 7, 43, '0', '4667', '0', 1),
(362, 7, 45, '0', '5056', '0', 1),
(363, 7, 46, '0', '5444', '0', 1),
(364, 7, 47, '0', '5056', '0', 1),
(365, 7, 48, '0', '5477', '0', 1),
(366, 7, 49, '0', '5688', '0', 1),
(367, 7, 50, '0', '6319', '0', 1),
(368, 7, 51, '0', '5898', '0', 1),
(369, 7, 52, '0', '6563', '0', 1),
(370, 7, 53, '0', '5671', '0', 1),
(371, 7, 54, '0', '5444', '0', 1),
(372, 7, 55, '0', '5250', '0', 1),
(373, 7, 56, '0', '4813', '0', 1),
(374, 7, 57, '0', '5169', '0', 1),
(375, 7, 58, '0', '5639', '0', 1),
(376, 7, 59, '0', '4991', '0', 1),
(377, 7, 1, '1', '4900', '4900', 1),
(382, 8, 1, '1', '4900', '4900', 1),
(383, 8, 2, '1', '4960', '9860', 1),
(384, 8, 2, '2', '4960', '9920', 1),
(385, 9, 2, '1', '4960', '4960', 1),
(386, 10, 1, '1', '4800', '4800', 1),
(387, 10, 3, '1', '2000', '2000', 1),
(388, 11, 2, '1', '4960', '4960', 1),
(389, 12, 1, '1', '4800', '4800', 1),
(390, 13, 1, '50', '4800', '240000', 1),
(391, 14, 1, '10', '4800', '48000', 1),
(392, 15, 2, '100', '4960', '496000', 1),
(393, 16, 3, '50', '299', '14950', 1),
(394, 17, 5, '1', '200', '200', 1),
(395, 18, 5, '50', '1000', '50000', 1),
(396, 19, 1, '10', '4800', '48000', 1),
(397, 20, 5, '1', '900', '900', 1),
(398, 21, 2, '1', '4960', '4960', 1),
(399, 22, 2, '1', '4960', '4960', 1),
(400, 23, 2, '1', '4960', '4960', 1),
(401, 24, 2, '1', '4960', '4960', 1),
(402, 25, 2, '1', '4960', '4960', 1),
(403, 26, 2, '1', '4960', '4960', 1),
(404, 27, 4, '1', '50', '50', 1),
(405, 28, 3, '1', '299', '299', 1);

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `quotation_id` int(11) NOT NULL,
  `quotation_number` text NOT NULL,
  `cust_name` text NOT NULL,
  `cust_email` text NOT NULL,
  `cust_phone` text NOT NULL,
  `cust_address` text NOT NULL,
  `cust_date` text NOT NULL,
  `cust_due_date` text NOT NULL,
  `currency` text NOT NULL,
  `taxrate` text NOT NULL,
  `sub_total` text NOT NULL,
  `grandtotal` text NOT NULL,
  `user_id` text NOT NULL,
  `quotation_status` text NOT NULL,
  `note` text NOT NULL,
  `description` text NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `quotation_prod_id` int(11) NOT NULL,
  `quotation_id` text NOT NULL,
  `product_name` text NOT NULL,
  `product_quantity` text NOT NULL,
  `product_rate` text NOT NULL,
  `kg_quantity` text NOT NULL,
  `sub_total` text NOT NULL,
  `added_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `debit` varchar(100) NOT NULL,
  `credit` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `transaction_remarks` text NOT NULL,
  `transaction_add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `transaction_date` text DEFAULT NULL,
  `transaction_type` text DEFAULT NULL,
  `transaction_from` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `debit`, `credit`, `balance`, `customer_id`, `transaction_remarks`, `transaction_add_date`, `transaction_date`, `transaction_type`, `transaction_from`) VALUES
(1, '0', '59890', '', 3, 'cash_sale by order id#1', '2021-06-10 10:47:34', '2021-06-10', 'cash_in_hand', 'invoice'),
(3, '0', '78280', '', 2, 'credit_sale by order id#2', '2021-10-08 11:59:28', '2021-06-10', 'credit_sale', 'invoice'),
(4, '9920', '0', '', 3, 'purchased by purchased id#8', '2021-06-10 10:50:41', '2021-06-10', 'cash_purchase', 'purchase'),
(5, '4000', '0', '', 1, 'purchased on  purchased id#9', '2021-06-10 10:58:35', '2021-06-10', 'credit_purchase', 'purchase'),
(6, '960', '0', '', 3, 'purchased by purchased id#9', '2021-06-10 10:58:35', '2021-06-10', 'credit_purchase', 'purchase'),
(7, '0', '528', '', 3, 'credit_sale by order id#3', '2021-06-12 09:16:24', '2021-06-12', 'credit_sale', 'invoice'),
(8, '0', '3900', '', 2, 'credit_sale by order id#3', '2021-06-12 09:16:24', '2021-06-12', 'credit_sale', 'invoice'),
(9, '0', '138140', '', 3, 'cash_sale by order id#4', '2021-06-12 09:32:28', '2021-06-12', 'cash_in_hand', 'invoice'),
(10, '0', '0', '', 0, 'credit_sale by order id#5', '2021-06-13 07:51:26', '2021-06-13', 'credit_sale', 'invoice'),
(11, '0', '4920', '', 2, 'credit_sale by order id#5', '2021-06-13 07:51:26', '2021-06-13', 'credit_sale', 'invoice'),
(12, '0', '73150', '', 0, 'credit_sale by order id#6', '2021-06-13 08:39:28', '2021-06-13', 'credit_sale', 'invoice'),
(13, '0', '5500', '', 3, 'cash_sale by order id#7', '2021-06-13 09:07:48', '2021-06-13', 'cash_in_hand', 'invoice'),
(14, '0', '5470', '', 2, 'credit_sale by order id#8', '2021-06-13 09:11:57', '2021-06-13', 'credit_sale', 'invoice'),
(15, '0', '5350', '', 3, 'cash_sale by order id#9', '2021-06-13 09:45:46', '2021-06-13', 'cash_in_hand', 'invoice'),
(16, '6800', '0', '', 3, 'purchased by purchased id#10', '2021-06-14 07:04:30', '2021-06-14', 'cash_purchase', 'purchase'),
(17, '0', '8280', '', 3, 'cash_sale by order id#10', '2021-06-14 07:05:44', '2021-06-14', 'cash_in_hand', 'invoice'),
(18, '4960', '0', '', 1, 'purchased on  purchased id#11', '2021-06-14 07:12:05', '2021-06-14', 'credit_purchase', 'purchase'),
(19, '4800', '0', '', 3, 'purchased by purchased id#12', '2021-06-14 07:15:09', '2021-06-14', 'cash_purchase', 'purchase'),
(20, '0', '5050', '', 2, 'credit_sale by order id#11', '2021-06-14 07:19:40', '2021-06-14', 'credit_sale', 'invoice'),
(21, '0', '5050', '', 2, 'credit_sale by order id#12', '2021-06-14 12:14:27', '2021-06-14', 'credit_sale', 'invoice'),
(22, '0', '4900', '', 3, 'cash_sale by order id#13', '2021-06-14 12:16:31', '2021-06-14', 'cash_in_hand', 'invoice'),
(23, '50000', '0', '', 3, '', '2021-06-20 10:30:04', '2021-06-20', 'general_voucher', 'voucher'),
(24, '0', '50000', '', 1, '', '2021-06-20 10:30:05', '2021-06-20', 'general_voucher', 'voucher'),
(25, '80000', '0', '', 2, 'check no #123456789', '2021-10-08 11:49:23', '2021-06-20', 'general_voucher', 'voucher'),
(26, '0', '50000', '', 3, 'check no #123456789', '2021-06-20 10:32:42', '2021-06-20', 'general_voucher', 'voucher'),
(27, '5000', '0', '', 3, 'meeezan debit ali raza credit', '2021-06-20 11:15:02', '2021-06-20', 'general_voucher', 'voucher'),
(28, '0', '5000', '', 2, 'meeezan debit ali raza credit', '2021-06-20 11:15:02', '2021-06-20', 'general_voucher', 'voucher'),
(29, '10', '0', '', 3, '', '2021-06-20 11:30:31', '2021-06-20', 'general_voucher', 'voucher'),
(30, '0', '10', '', 3, '', '2021-06-20 11:30:31', '2021-06-20', 'general_voucher', 'voucher'),
(31, '4', '0', '', 3, '2000', '2021-06-20 11:32:40', '2021-06-20', 'general_voucher', 'voucher'),
(32, '0', '4', '', 4, '2000', '2021-06-20 11:32:40', '2021-06-20', 'general_voucher', 'voucher'),
(33, '5000', '0', '', 3, 'paid salary', '2021-06-20 13:35:45', '2021-06-20', '1', 'voucher'),
(34, '0', '5000', '', 4, 'paid salary', '2021-06-20 13:35:45', '2021-06-20', '1', 'voucher'),
(35, '2000', '0', '', 3, 'salary to ali', '2021-06-20 13:39:56', '2021-06-20', '1', 'voucher'),
(36, '0', '2000', '', 4, 'salary to ali', '2021-06-20 13:39:56', '2021-06-20', '1', 'voucher'),
(37, '2000', '0', '', 3, 'pta ni aweee', '2021-06-20 13:40:39', '2021-06-20', 'single_voucher', 'voucher'),
(38, '0', '4900', '', 3, 'cash_sale by order id#14', '2021-06-23 12:27:05', '2021-06-23', 'cash_in_hand', 'invoice'),
(39, '0', '4900', '', 3, 'cash_sale by order id#15', '2021-06-23 12:27:06', '2021-06-23', 'cash_in_hand', 'invoice'),
(40, '0', '4900', '', 3, 'cash_sale by order id#16', '2021-06-23 12:27:07', '2021-06-23', 'cash_in_hand', 'invoice'),
(41, '0', '4900', '', 3, 'cash_sale by order id#17', '2021-06-23 12:27:07', '2021-06-23', 'cash_in_hand', 'invoice'),
(42, '0', '4900', '', 3, 'cash_sale by order id#18', '2021-06-26 07:45:29', '2021-06-26', 'cash_in_hand', 'invoice'),
(43, '0', '4900', '', 3, 'cash_sale by order id#19', '2021-06-26 08:08:22', '2021-06-26', 'cash_in_hand', 'invoice'),
(44, '0', '9800', '', 3, 'cash_sale by order id#20', '2021-06-26 08:52:49', '2021-06-26', 'cash_in_hand', 'invoice'),
(45, '0', '5150', '', 3, 'cash_sale by order id#21', '2021-06-26 08:56:50', '2021-06-26', 'cash_in_hand', 'invoice'),
(46, '0', '4900', '', 3, 'cash_sale by order id#22', '2021-06-26 09:22:25', '2021-06-26', 'cash_in_hand', 'invoice'),
(47, '240000', '0', '', 3, 'purchased by purchased id#13', '2021-06-26 09:55:13', '2021-06-26', 'cash_purchase', 'purchase'),
(48, '48000', '0', '', 3, 'purchased by purchased id#14', '2021-06-26 10:00:29', '2021-06-26', 'cash_purchase', 'purchase'),
(49, '496000', '0', '', 3, 'purchased by purchased id#15', '2021-06-26 10:01:58', '2021-06-26', 'cash_purchase', 'purchase'),
(50, '14950', '0', '', 3, 'purchased by purchased id#16', '2021-06-26 10:03:33', '2021-06-26', 'cash_purchase', 'purchase'),
(51, '200', '0', '', 3, 'purchased by purchased id#17', '2021-06-26 10:04:25', '2021-06-26', 'cash_purchase', 'purchase'),
(52, '50000', '0', '', 3, 'purchased by purchased id#18', '2021-06-26 10:25:15', '2021-06-26', 'cash_purchase', 'purchase'),
(53, '48000', '0', '', 3, 'purchased by purchased id#19', '2021-06-26 10:40:17', '2021-06-26', 'cash_purchase', 'purchase'),
(54, '900', '0', '', 3, 'purchased by purchased id#20', '2021-06-26 10:41:30', '2021-06-26', 'cash_purchase', 'purchase'),
(55, '0', '4900', '', 3, 'cash_sale by order id#23', '2021-06-26 11:45:39', '2021-06-26', 'cash_in_hand', 'invoice'),
(56, '0', '24502.5', '', 3, 'cash_sale by order id#24', '2021-07-29 08:20:30', '2021-07-29', 'cash_in_hand', 'invoice'),
(57, '9000', '0', '', 1, 'slary to su[[;', '2021-07-29 10:55:10', '2021-07-29', 'single_voucher', 'voucher'),
(58, '0', '5900', '', 3, 'cash_sale by order id#25', '2021-07-31 12:07:30', '2021-07-31', 'cash_in_hand', 'invoice'),
(59, '32000', '0', '', 1, 'jazz cash tranfer', '2021-08-01 09:32:07', '2021-08-01', 'single_voucher', 'voucher'),
(60, '1000', '0', '', 1, 'jkl;\'', '2021-08-02 09:35:25', '2021-08-02', 'single_voucher', 'voucher'),
(62, '', '0', '', 1, 'jazz cash tranfer', '2021-08-02 09:41:34', '2021-08-02', 'single_voucher', 'voucher'),
(63, '5000', '0', '', 1, 'bc', '2021-08-02 09:42:26', '2021-08-02', 'single_voucher', 'voucher'),
(64, '3000', '0', '', 2, '', '2021-10-08 12:24:53', '2021-10-08', 'general_voucher', 'voucher'),
(65, '0', '3000', '', 3, '', '2021-10-08 12:24:53', '2021-10-08', 'general_voucher', 'voucher'),
(66, '0', '52500', '', 2, 'credit_sale by order id#26', '2021-10-08 12:38:11', '2021-10-08', 'credit_sale', 'invoice'),
(67, '0', '5470', '', 2, 'credit_sale by order id#27', '2021-12-11 10:37:55', '2021-12-11', 'credit_sale', 'invoice'),
(68, '0', '5450', '', 2, 'credit_sale by order id#28', '2021-12-11 11:00:45', '2021-12-11', 'credit_sale', 'invoice'),
(69, '0', '5050', '', 2, 'credit_sale by order id#29', '2022-03-01 09:38:10', '2022-03-01', 'credit_sale', 'invoice'),
(70, '0', '5350', '', 3, 'cash_sale by order id#30', '2022-03-01 09:40:18', '2022-03-01', 'cash_in_hand', 'invoice'),
(72, '0', '5526', '', 2, 'credit_sale by order id#31', '2023-09-20 09:27:20', '2023-09-20', 'credit_sale', 'invoice'),
(73, '0', '50000', '', 5, 'opening balance ', '2023-09-21 08:39:03', '2023-09-21', 'single_voucher', 'voucher'),
(74, '15000', '0', '', 5, 'cash in hand', '2023-09-25 10:44:47', '2023-09-25', 'payment_clearance ', 'voucher'),
(75, '0', '15000', '', 1, 'cash in hand', '2023-09-25 10:44:47', '2023-09-25', 'payment_clearance ', 'voucher'),
(76, '5000', '0', '', 3, 'cash_sale by order id#32', '2023-09-25 11:55:57', '2023-09-25', 'cash_in_hand', 'invoice'),
(77, '5170', '0', '', 7, 'credit_sale by order id#33', '2023-09-25 11:58:31', '2023-09-25', 'credit_sale', 'invoice'),
(78, '5000', '0', '', 7, 'credit_sale by order id#34', '2023-09-25 11:59:11', '2023-09-25', 'credit_sale', 'invoice'),
(79, '0', '380', '', 6, 'credit_sale by order id#34', '2023-09-25 11:59:11', '2023-09-25', 'credit_sale', 'invoice'),
(81, '4960', '0', '', 6, 'purchased by purchased id#22', '2023-09-25 12:02:42', '2023-09-25', 'cash_purchase', 'purchase'),
(82, '0', '4960', '', 8, 'purchased on  purchased id#23', '2023-09-25 12:03:28', '2023-09-25', 'credit_purchase', 'purchase'),
(83, '960', '0', '', 8, 'abcd 123', '2023-09-25 12:31:11', '2023-09-25', 'general_voucher', 'voucher'),
(84, '0', '960', '', 6, 'abcd 123', '2023-09-25 12:31:11', '2023-09-25', 'general_voucher', 'voucher'),
(85, '5150', '0', '', 6, 'cash_sale by order id#35', '2023-09-25 17:07:11', '2023-09-25', 'cash_in_hand', 'invoice'),
(86, '5100', '0', '', 9, 'credit_sale by order id#36', '2023-09-25 17:08:57', '2023-09-25', 'credit_sale', 'invoice'),
(87, '3000', '0', '', 9, 'credit_sale by order id#37', '2023-09-25 17:09:45', '2023-09-25', 'credit_sale', 'invoice'),
(88, '0', '2100', '', 6, 'credit_sale by order id#37', '2023-09-25 17:09:45', '2023-09-25', 'credit_sale', 'invoice'),
(89, '1100', '0', '', 6, 'cash in hand', '2023-09-25 17:14:15', '2023-09-25', 'general_voucher', 'voucher'),
(90, '0', '1100', '', 9, 'cash in hand', '2023-09-25 17:14:15', '2023-09-25', 'general_voucher', 'voucher'),
(91, '4960', '0', '', 6, 'purchased by purchased id#24', '2023-09-25 17:15:30', '2023-09-25', 'cash_purchase', 'purchase'),
(92, '0', '4960', '', 8, 'purchased on  purchased id#25', '2023-09-25 17:16:21', '2023-09-25', 'credit_purchase', 'purchase'),
(93, '1000', '0', '', 6, '12345 exp', '2023-09-25 17:17:47', '2023-09-25', '1', 'voucher'),
(94, '0', '1000', '', 4, '12345 exp', '2023-09-25 17:17:47', '2023-09-25', '1', 'voucher'),
(95, '450', '0', '', 3, 'cash_sale by order id#38', '2023-09-25 23:52:09', '2023-09-26', 'cash_in_hand', 'invoice'),
(96, '247920', '0', '', 3, 'cash_sale by order id#39', '2023-09-27 08:15:38', '2023-09-27', 'cash_in_hand', 'invoice'),
(97, '5170', '0', '', 9, 'credit_sale by order id#41', '2024-01-23 17:00:04', '2024-01-23', 'credit_sale', 'invoice'),
(98, '4960', '0', '', 3, 'purchased by purchased id#26', '2024-01-23 17:00:32', '2024-01-23', 'cash_purchase', 'purchase'),
(99, '0', '50', '', 1, 'purchased on  purchased id#27', '2024-01-23 17:01:03', '2024-01-23', 'credit_purchase', 'purchase'),
(100, '299', '0', '', 3, 'purchased by purchased id#28', '2024-01-23 17:28:41', '2024-01-23', 'cash_purchase', 'purchase'),
(101, '500', '0', '', 3, '123', '2024-01-23 17:29:14', '2024-01-23', 'general_voucher', 'voucher'),
(102, '0', '500', '', 9, '123', '2024-01-23 17:29:14', '2024-01-23', 'general_voucher', 'voucher');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` text NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `user_role` text NOT NULL,
  `status` text NOT NULL,
  `cash_account` int(10) DEFAULT NULL,
  `adddatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `password`, `address`, `phone`, `user_role`, `status`, `cash_account`, `adddatetime`) VALUES
(1, 'admin', 'admin', 'adminn@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'asergh', '2345y', 'admin', '1', NULL, '2021-06-21 11:16:04'),
(2, 'sami', '', 'sami@gmail.com', 'd54d1702ad0f8326224b817c796763c9', 'main bazar sadhar faisalabad', '12345', 'subadmin', '1', 6, '2023-09-25 10:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `voucher_id` int(11) NOT NULL,
  `customer_id1` varchar(250) DEFAULT NULL,
  `customer_id2` varchar(250) DEFAULT NULL,
  `addby_user_id` int(11) DEFAULT NULL,
  `editby_user_id` int(11) DEFAULT NULL,
  `voucher_amount` varchar(250) NOT NULL,
  `transaction_id1` varchar(250) DEFAULT NULL,
  `transaction_id2` varchar(250) DEFAULT NULL,
  `voucher_hint` text DEFAULT NULL,
  `voucher_date` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `voucher_type` varchar(100) DEFAULT NULL,
  `voucher_group` varchar(100) DEFAULT NULL,
  `td_check_no` text DEFAULT NULL,
  `voucher_bank_name` varchar(255) DEFAULT NULL,
  `td_check_date` varchar(100) DEFAULT NULL,
  `check_type` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`voucher_id`, `customer_id1`, `customer_id2`, `addby_user_id`, `editby_user_id`, `voucher_amount`, `transaction_id1`, `transaction_id2`, `voucher_hint`, `voucher_date`, `timestamp`, `voucher_type`, `voucher_group`, `td_check_no`, `voucher_bank_name`, `td_check_date`, `check_type`) VALUES
(5, '1', NULL, 1, 1, '50000000', '923', NULL, 'cash in hand', '2021-07-12', '2021-07-12 23:13:48', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(6, '1', NULL, 1, 1, '30000000', '1142', NULL, 'cash in hand ', '2021-07-28', '2021-07-28 16:29:42', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(9, '17', NULL, 1, NULL, '1632315', '1657', NULL, 'maintain  account', '2021-08-20', '2021-08-20 19:45:52', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(10, '17', NULL, 1, NULL, '1280199', '1658', NULL, 'opening balance ', '2021-08-20', '2021-08-20 19:47:35', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(12, '17', NULL, 1, NULL, '231012', '1731', NULL, 'maintain  account', '2021-08-23', '2021-08-24 05:12:00', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(13, '5', NULL, 1, NULL, '935977', '1732', NULL, 'maintain  account', '2021-08-23', '2021-08-24 05:14:49', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(14, '8', NULL, 1, NULL, '838711', '1733', NULL, 'maintain  account', '2021-08-23', '2021-08-24 05:17:54', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(15, '7', NULL, 1, NULL, '1064068', '1734', NULL, 'maintain  account', '2021-08-23', '2021-08-24 05:19:24', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(16, '19', NULL, 1, NULL, '1331987', '1735', NULL, 'maintain  account', '2021-08-23', '2021-08-24 05:20:44', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(17, '28', NULL, 1, NULL, '1243728', '1736', NULL, 'maintain  account', '2021-08-23', '2021-08-24 05:25:53', NULL, 'single_voucher', NULL, NULL, NULL, NULL),
(6812, '5', '1', 1, NULL, '15000', '74', '75', 'cash in hand', '2023-09-25', '2023-09-25 10:44:47', 'payment_clearance ', 'general_voucher', '123', 'meezan ', '2023-09-25', 'cash '),
(6813, '8', '6', 1, NULL, '960', '83', '84', 'abcd 123', '2023-09-25', '2023-09-25 12:31:11', 'general_voucher', 'general_voucher', '', '', '', ''),
(6814, '6', '9', 1, NULL, '1100', '89', '90', 'cash in hand', '2023-09-25', '2023-09-25 17:14:15', 'general_voucher', 'general_voucher', '', '', '', ''),
(6815, '6', '4', 1, NULL, '1000', '93', '94', '12345 exp', '2023-09-25', '2023-09-25 17:17:47', '1', 'expense_voucher', NULL, NULL, NULL, NULL),
(6816, '3', '9', 1, NULL, '500', '101', '102', '123', '2024-01-23', '2024-01-23 17:29:14', 'general_voucher', 'general_voucher', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `brokers`
--
ALTER TABLE `brokers`
  ADD PRIMARY KEY (`broker_id`);

--
-- Indexes for table `budget`
--
ALTER TABLE `budget`
  ADD PRIMARY KEY (`budget_id`);

--
-- Indexes for table `budget_category`
--
ALTER TABLE `budget_category`
  ADD PRIMARY KEY (`budget_category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categories_id`);

--
-- Indexes for table `checks`
--
ALTER TABLE `checks`
  ADD PRIMARY KEY (`check_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `hold_product`
--
ALTER TABLE `hold_product`
  ADD PRIMARY KEY (`hold_product_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`privileges_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`production_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_item`
--
ALTER TABLE `purchase_item`
  ADD PRIMARY KEY (`purchase_item_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`quotation_id`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`quotation_prod_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brokers`
--
ALTER TABLE `brokers`
  MODIFY `broker_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `budget_category`
--
ALTER TABLE `budget_category`
  MODIFY `budget_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `checks`
--
ALTER TABLE `checks`
  MODIFY `check_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hold_product`
--
ALTER TABLE `hold_product`
  MODIFY `hold_product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `privileges_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=444;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `production_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `purchase_item_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `quotation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `quotation_prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6817;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
