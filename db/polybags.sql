-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2021 at 12:57 PM
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
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_active` int(11) NOT NULL DEFAULT 0,
  `brand_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`, `brand_active`, `brand_status`) VALUES
(6, 'dell', 0, 1),
(7, 'brighto', 0, 1),
(8, 'brandname', 0, 1),
(9, 'cheetah', 0, 1),
(10, 'vivo', 0, 1),
(11, 'realme', 0, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brokers`
--

INSERT INTO `brokers` (`broker_id`, `broker_name`, `broker_phone`, `broker_email`, `broker_address`, `broker_status`, `adddatetime`) VALUES
(1, 'sami        ', '03457573667', 'imsami67@gmail.com', 'Faisalabad Pakistan', 1, '2020-02-10 00:04:57');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `budget_category`
--

CREATE TABLE `budget_category` (
  `budget_category_id` int(11) NOT NULL,
  `budget_category_name` text NOT NULL,
  `budget_category_type` varchar(400) NOT NULL,
  `budget_category_add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `budget_category`
--

INSERT INTO `budget_category` (`budget_category_id`, `budget_category_name`, `budget_category_type`, `budget_category_add_date`) VALUES
(1, 'shop', 'expense', '2020-02-10 00:43:16'),
(2, 'food', 'expense', '2020-03-12 11:12:11'),
(4, 'salary', 'expense', '2021-03-31 12:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL,
  `categories_name` varchar(255) NOT NULL,
  `category_price` varchar(20) NOT NULL,
  `categories_active` int(11) NOT NULL DEFAULT 0,
  `categories_status` int(11) NOT NULL DEFAULT 0,
  `category_purchase` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categories_id`, `categories_name`, `category_price`, `categories_active`, `categories_status`, `category_purchase`) VALUES
(4, 'category', '0', 0, 1, 0),
(5, 'laptops', '0', 0, 1, 0),
(6, 'clothes', '0', 0, 1, 0),
(7, 'mobiles', '200', 0, 1, 180),
(8, 'cometics', '200', 0, 1, 0),
(9, 'categorynew', '0', 0, 1, 0),
(10, 'home ', '0', 0, 1, 0),
(12, 'pear', '2000', 0, 1, 0),
(13, 'aspire', '200', 0, 1, 0),
(14, 'pvc rolls', '9', 0, 1, 0),
(15, 'rings', '100', 0, 1, 80),
(16, 'jeans', '200', 0, 1, 100);

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
  `sale_interface` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `logo`, `address`, `company_phone`, `personal_phone`, `email`, `stock_manage`, `sale_interface`) VALUES
(5, 'Accounting Sofware', '1688481632607e983574a36.gif', 'Faisalabad Punjab Pakistan', '0301-1010101', '0321-1010101', 'testemail@info.com', 1, 'keyboard');

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
  `customer_add_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_status`, `customer_type`, `customer_add_date`) VALUES
(14, 'shehroz shabbir', 'shehroz@gmail.com', '03021312301', 'lahore', 1, 'supplier', '2021-04-17 11:37:49'),
(15, 'mezan bank ltd', '', '0321123123142', 'faisalabad pakistan ', 1, 'bank', '2021-04-17 11:39:20'),
(16, 'sufyan', 'sufi@gmail.com', '0301000000012', 'pakistan', 1, 'customer', '2021-04-17 11:41:05'),
(17, 'samii', '', '345612', 'sitara lal center factory area', 1, 'supplier', '2021-04-17 11:41:44'),
(18, 'hammad ali', 'seretr@gmail.com', '2412401204', 'lahore', 1, 'expense', '2021-04-20 09:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `expense_name` varchar(100) DEFAULT NULL,
  `expense_status` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `expense_name`, `expense_status`, `timestamp`) VALUES
(1, 'Salaries', 1, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `page`, `parent_id`, `icon`, `sort_order`, `nav_edit`, `nav_delete`, `nav_add`, `timestamp`) VALUES
(97, 'accounts', '#', 0, 'fa fa-edit', 4, 1, 1, 1, '2021-04-21 10:34:23'),
(98, 'customers', 'customers.php?type=customer', 97, 'fa fa-edit', 4, 1, 1, 1, '2021-04-13 11:03:33'),
(99, 'banks', 'customers.php?type=bank', 97, 'fa fa-edit', 2, 1, 1, 1, '2021-04-13 11:03:33'),
(100, 'users', 'users.php', 97, 'fa fa-edit', 3, 1, 1, 1, '2021-04-13 11:03:33'),
(101, 'vouchers', '#', 0, 'fa fa-clipboard-list', 3, 0, 0, 0, '2021-04-21 10:34:28'),
(102, 'add voucher', 'voucher.php?act=add', 101, 'fas fa-clipboard-list', 6, 1, 0, 1, '2021-04-13 11:03:33'),
(103, 'view vouchers', 'voucher.php?act=list', 101, 'fas fa-clipboard-list', 7, 1, 1, 1, '2021-04-13 11:03:33'),
(104, 'order', '#', 0, 'fas fa-cart-plus', 1, 0, 0, 0, '2021-04-21 10:34:25'),
(105, 'Cash Sale', 'cash_sale.php', 104, 'fas fa-cart-plus', 9, 1, 0, 1, '2021-04-13 11:03:33'),
(106, 'view orders', 'view_orders.php', 104, 'fa fa-edit', 10, 0, 0, 0, '2021-04-13 11:03:33'),
(107, 'others', '#', 0, 'fa fa-edit', 5, 0, 0, 0, '2021-04-21 10:34:23'),
(108, 'Add Products', 'product.php?act=add#', 107, 'fa fa-edit', 12, 1, 0, 1, '2021-04-13 11:03:34'),
(109, 'view products', 'product.php?act=list', 107, 'fa fa-edit', 13, 1, 1, 1, '2021-04-13 11:03:34'),
(110, 'brands', 'brands.php#', 107, 'fa fa-edit', 14, 1, 1, 1, '2021-04-13 11:03:34'),
(111, 'credit sale', 'credit_sale.php', 104, 'fa fa-edit', 15, 1, 0, 1, '2021-04-13 11:03:34'),
(112, 'purchase', '#', 0, 'fa fa-edit', 2, 0, 0, 0, '2021-04-21 10:34:28'),
(113, 'Cash Purchase', 'cash_purchase.php', 112, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-13 13:33:37'),
(114, 'credit purchase', 'credit_purchase.php', 112, 'fa fa-edit', NULL, 1, 1, 1, '2021-04-13 13:34:31'),
(115, 'Reports', '#', 0, 'fa fa-edit', 6, 0, 0, 0, '2021-04-21 11:11:08'),
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
(131, 'trail balance', 'trail_balance.php', 0, 'fa fa-edit', NULL, 0, 0, 0, '2021-04-25 10:20:04');

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
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `transaction_paid_id`, `order_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `cod`, `grand_total`, `paid`, `due`, `payment_type`, `payment_status`, `customer_account`, `payment_account`, `order_status`, `address`, `charges`, `note`, `pending_order`, `tracking`, `customer_profit`, `transaction_id`, `broker_id`, `type`, `delaytime`, `freight`, `order_narration`, `timestamp`) VALUES
(94, 124, '2021-04-24', 'hassan ali', '03001121232131', '', '', '120000', '0', '', '120000', '120000', '0', 'cash_in_hand', 1, NULL, 15, '0', '', '', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, '2021-04-24 09:38:58'),
(95, 125, '2021-04-24', 'sufyan', '0301000000012', '', '', '136000', '10', '', '122400', '112400', '10000', 'credit_sale', 0, 16, 15, '0', '', '', '', '', '', '', 126, NULL, NULL, NULL, NULL, 'mi t10 pro ', '2021-04-24 09:39:59');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `rate`, `total`, `order_item_status`, `discount`, `gauge`, `width`) VALUES
(70, 94, 19, 1, 120000, 120000, 1, NULL, NULL, NULL),
(71, 95, 20, 2, 68000, 136000, 1, NULL, NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(368, 2, 98, 'customers.php?type=customer', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(369, 2, 99, 'customers.php?type=bank', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(370, 2, 100, 'users.php', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(371, 2, 102, 'voucher.php?act=add', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 0),
(372, 2, 103, 'voucher.php?act=list', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(373, 2, 105, 'cash_sale.php', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 0),
(374, 2, 106, 'view_orders.php', 'Added By: admin', '2021-04-15 12:38:01', 0, 0, 0),
(375, 2, 108, 'product.php?act=add#', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 0),
(376, 2, 109, 'product.php?act=list', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(377, 2, 110, 'brands.php#', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(378, 2, 111, 'credit_sale.php', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 0),
(379, 2, 113, 'cash_purchase.php', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(380, 2, 114, 'credit_purchase.php', 'Added By: admin', '2021-04-15 12:38:01', 1, 0, 1),
(381, 2, 116, 'reports.php?type=bank', 'Added By: admin', '2021-04-15 12:38:02', 1, 0, 1),
(382, 2, 117, 'reports.php?type=supplier', 'Added By: admin', '2021-04-15 12:38:02', 0, 0, 0),
(383, 2, 118, 'reports.php?type=customer ', 'Added By: admin', '2021-04-15 12:38:02', 0, 0, 0),
(384, 2, 119, 'view_purchases.php', 'Added By: admin', '2021-04-15 12:38:02', 1, 0, 1),
(385, 2, 0, '', 'Added By: admin', '2021-04-15 12:38:02', 0, 0, 0);

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
  `purchased` double NOT NULL,
  `current_rate` double NOT NULL,
  `f_days` text DEFAULT NULL,
  `t_days` text DEFAULT NULL,
  `product_mm` double NOT NULL,
  `product_inch` double NOT NULL,
  `product_meter` double NOT NULL,
  `purchase_rate` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `availability` int(11) DEFAULT 0,
  `alert_at` double DEFAULT 5,
  `weight` varchar(200) NOT NULL,
  `actual_rate` varchar(250) DEFAULT NULL,
  `product_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_code`, `product_image`, `brand_id`, `category_id`, `quantity_instock`, `purchased`, `current_rate`, `f_days`, `t_days`, `product_mm`, `product_inch`, `product_meter`, `purchase_rate`, `status`, `availability`, `alert_at`, `weight`, `actual_rate`, `product_description`) VALUES
(19, 'iphone xi max', '11max', '', 11, 7, 26, 0, 463, '463', '463', 5, 5, 5, 417, 1, 1, 5, '', NULL, 'iphone 11 max pro'),
(20, 'mi t10 pro', 'mit10', '', 11, 7, 28, 0, 3704, '3705', '3706', 10, 10, 10, 3333, 1, 1, 5, '', NULL, '8/256 gb'),
(21, 'alpha fuel xt', '234', '', 10, 13, 10, 0, 74, '74', '74', 10, 2, 1, 0, 1, 1, 5, '', NULL, 'qwert'),
(22, '12', '12', '', 6, 14, 0, 0, 8000, '8044', '8089', 8, 2, 5, 0, 1, 1, 5, '', NULL, '');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `purchase_date`, `client_name`, `client_contact`, `sub_total`, `vat`, `total_amount`, `discount`, `grand_total`, `paid`, `due`, `payment_type`, `payment_account`, `customer_account`, `payment_status`, `transaction_id`, `transaction_paid_id`, `purchase_narration`, `timestamp`) VALUES
(27, '2021-04-24', 'shehroz shabbir', '03021312301', '', '', '2400000', '0', '2400000', '2400000', '0', 'cash_in_hand', 15, 14, 1, 0, 121, '', '2021-04-24 09:27:22'),
(28, '2021-04-24', 'samii', '345612', '', '', '1360000', '0', '1360000', '1260000', '100000', 'credit_sale', 15, 17, 1, 122, 123, '', '2021-04-24 09:29:21'),
(29, '2021-06-08', 'shehroz shabbir', '03021312301', '', '', '660700', '0', '660700', '660700', '0', 'cash_in_hand', 15, 14, 1, 0, 129, '', '2021-06-08 07:48:48'),
(30, '2021-06-08', 'samii', '345612', '', '', '38000', '0', '38000', '38000', '0', 'cash_in_hand', 15, 17, 1, 0, 130, '', '2021-06-08 10:42:55');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_item`
--

INSERT INTO `purchase_item` (`purchase_item_id`, `purchase_id`, `product_id`, `quantity`, `rate`, `total`, `purchase_item_status`) VALUES
(35, 27, 19, '20', '120000', '2400000', 1),
(36, 28, 20, '20', '68000', '1360000', 1),
(37, 29, 19, '6', '110000', '660000', 1),
(38, 29, 21, '10', '70', '660700', 1),
(39, 30, 19, '1', '500', '500', 1),
(40, 30, 20, '10', '3750', '38000', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `debit`, `credit`, `balance`, `customer_id`, `transaction_remarks`, `transaction_add_date`, `transaction_date`, `transaction_type`, `transaction_from`) VALUES
(121, '2400000', '0', '', 15, 'purchased by purchased id#27', '2021-04-24 09:32:21', '2021-04-24', 'cash_in_hand', 'purchase'),
(122, '100000', '0', '', 17, 'purchased on  purchased id#28', '2021-04-24 09:29:22', '2021-04-24', 'credit_sale', 'purchase'),
(123, '1260000', '0', '', 15, 'purchased by purchased id#28', '2021-04-24 09:29:22', '2021-04-24', 'credit_sale', 'purchase'),
(124, '120000', '0', '', 15, 'cash_sale by order id#94', '2021-04-24 09:38:58', '2021-04-24', 'cash_in_hand', 'invoice'),
(125, '0', '112400', '', 15, 'credit_sale by order id#95', '2021-04-24 09:39:59', '2021-04-24', 'credit_sale', 'invoice'),
(126, '0', '10000', '', 16, 'credit_sale by order id#95', '2021-04-24 09:39:59', '2021-04-24', 'credit_sale', 'invoice'),
(129, '660700', '0', '', 15, 'purchased by purchased id#29', '2021-06-08 07:48:48', '2021-06-08', 'cash_in_hand', 'purchase'),
(130, '38000', '0', '', 15, 'purchased by purchased id#30', '2021-06-08 10:42:56', '2021-06-08', 'cash_in_hand', 'purchase');

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
  `adddatetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `fullname`, `email`, `password`, `address`, `phone`, `user_role`, `status`, `adddatetime`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '2345', '12345', 'admin', '0', '2021-04-10 08:40:34'),
(2, 'sami', 'sami biro', 'sami@gmail.com', 'd54d1702ad0f8326224b817c796763c9', 'main bazar sadhar faisalabad', '12345', 'subadmin', '1', '2021-04-09 08:28:27'),
(3, 'test', 'test user', 'test@email.com', '11223344', 'main bazar sadhar faisalabad', '12345', 'manager', '0', '2021-04-15 08:25:30'),
(4, 'mursad', 'murshad users', 'mursad@gmail.com', 'd54d1702ad0f8326224b817c796763c9', 'acd', '11223344', 'manager', '0', '2021-04-15 08:25:36');

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
  `voucher_group` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `brokers`
--
ALTER TABLE `brokers`
  MODIFY `broker_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budget`
--
ALTER TABLE `budget`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `budget_category`
--
ALTER TABLE `budget_category`
  MODIFY `budget_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `privileges_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=386;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `purchase_item`
--
ALTER TABLE `purchase_item`
  MODIFY `purchase_item_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
