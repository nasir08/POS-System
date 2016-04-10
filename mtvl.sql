-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 07, 2015 at 09:59 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mtvl`
--
CREATE DATABASE IF NOT EXISTS `mtvl` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mtvl`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `uname` varchar(150) NOT NULL,
  `pword` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `phone` bigint(150) NOT NULL,
  `r_code` varchar(150) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `uname`, `pword`, `type`, `phone`, `r_code`, `status`) VALUES
(1, 'Ayofe Muktar', 'm.t', '5129c617dcc69d9cb546525176641dbfcde32582', 'admin', 8037158678, 'YXlvMQ==', 0),
(2, 'Ayofe Y.A', 'yemi', 'f771a4ff642f3803e15e11d549ce0a02e3ab2a24', 'admin', 8037158678, 'dXJ1d2Fu', 0),
(4, 'Abdul Kabir', 'kabir', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'sales point', 8052008452, 'MTIzNA==', 0),
(5, 'Abdul Akeem', 'sahabe', '09bc328680cd1c655a5774ac7561c96e7f93b42c', 'sales point', 8059015154, 'MTk4MA==', 0),
(6, 'Ayofe Nasir', 'nasir', '40bbbdfb2835536975686ec710abcaaf0362f9f0', 'manager', 8077424593, 'YWRlMTE4NQ==', 0),
(7, 'Mohammed Qasim ', 'qasim', 'd92bf834c6c9379bf236a17ab14372b560f86034', 'manager', 8067442298, 'QWxsYWh1IGwgSGFx', 0),
(8, 'retret', 'ererer', '2cb7c931bd279cdedbaf6f4cb98349ee0e1ed5b9', 'sales point', 56456465, 'SThZRTQz', 0),
(9, 'Ade', 'ade', '6fb0394b969258c4f33b92bbe8c601462bb5455b', 'sales point', 87678, 'YWRl', 0);

-- --------------------------------------------------------

--
-- Table structure for table `balance_bf`
--

CREATE TABLE IF NOT EXISTS `balance_bf` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `amount` double NOT NULL,
  `sales_point` bigint(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `balance_bf`
--

INSERT INTO `balance_bf` (`id`, `amount`, `sales_point`) VALUES
(1, 1646000, 1),
(6, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `sales_point` bigint(150) NOT NULL,
  `good_id` bigint(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `item_name`, `unit_price`, `quantity`, `amount`, `sales_point`, `good_id`) VALUES
(9, 'Oerlikon Electrode - G12', 2200, 2, 4400, 6, 20),
(10, '12mm Imported - Retails {Ton}', 149000, 2, 298000, 6, 31),
(11, 'Binding Wires - 10kg', 2500, 2, 5000, 6, 13),
(12, 'Saw Blade - Bundle', 1500, 2, 3000, 6, 16),
(13, '0.7mm Wholesales pcs', 2550, 4, 10200, 6, 152),
(14, '0.8mm Wholesales pcs', 3000, 4, 12000, 6, 155);

-- --------------------------------------------------------

--
-- Table structure for table `debtors`
--

CREATE TABLE IF NOT EXISTS `debtors` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `balance` double NOT NULL,
  `sales_point` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `debtors`
--

INSERT INTO `debtors` (`id`, `name`, `balance`, `sales_point`) VALUES
(1, 'Adewale Adesina', 900000, 6),
(2, 'Dangote', 3500000, 6),
(3, 'yrytrt', 5000, 1),
(4, 'yrytrt', 0, 1),
(5, 'yrytrt', 0, 1),
(6, 'yrytrt', 0, 1),
(7, 'yrytrt', 0, 1),
(8, 'yrytrt', 9000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `debt_history`
--

CREATE TABLE IF NOT EXISTS `debt_history` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(150) NOT NULL,
  `amount` double NOT NULL,
  `debtor` bigint(20) NOT NULL,
  `sales_point` bigint(20) NOT NULL,
  `receipt` varchar(150) NOT NULL,
  `date` date NOT NULL,
  `load_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `debt_history`
--

INSERT INTO `debt_history` (`id`, `type`, `amount`, `debtor`, `sales_point`, `receipt`, `date`, `load_count`) VALUES
(1, 'Debt', 1000000, 1, 6, '6454345', '2015-02-06', 1),
(2, 'Debt', 4000000, 2, 6, 'Transfer From Debtors Book', '2015-02-06', 1),
(4, 'Debt', 90000, 2, 6, '234243', '2015-02-06', 1),
(6, 'Debt', 90000, 2, 6, 'Transfer From Debtors Book', '2015-02-06', 1),
(7, 'Debt', 400000, 1, 6, '32342', '2015-02-06', 1),
(9, 'Payment', 180000, 2, 1, '', '2015-02-06', 1),
(10, 'Payment', 400000, 1, 1, '', '2015-02-06', 1),
(11, 'Payment', 1500000, 2, 1, '', '2015-02-06', 1),
(12, 'Payment', 200000, 1, 1, '', '2015-02-06', 2),
(13, 'Debt', 100000, 1, 1, '65656', '2015-02-06', 2),
(14, 'Debt', 200000, 2, 1, '34535', '2015-02-06', 1),
(15, 'Payment', 700000, 2, 1, '', '2015-02-06', 1),
(16, 'Debt', 1000000, 2, 1, '3445465', '2015-08-31', 1),
(17, 'Debt', 500000, 2, 1, 'Transfer From Debtors Book', '2015-08-31', 1),
(18, 'Debt', 5000, 3, 1, '', '2015-08-31', 1),
(19, 'Debt', 5000, 4, 1, '', '2015-08-31', 0),
(20, 'Debt', 5000, 5, 1, '', '2015-08-31', 0),
(21, 'Debt', 5000, 6, 1, '', '2015-08-31', 0),
(22, 'Debt', 5000, 7, 1, '', '2015-08-31', 0),
(23, 'Debt', 5000, 8, 1, '', '2015-08-31', 1),
(24, 'Debt', 4000, 8, 1, '', '2015-08-31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `purpose` text NOT NULL,
  `amount` double NOT NULL,
  `sales_point` bigint(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `date`, `purpose`, `amount`, `sales_point`) VALUES
(1, '2015-02-06', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 1000000, 6),
(4, '2015-02-06', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 90000, 6),
(5, '2015-02-06', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 400000, 6),
(6, '2015-02-06', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 100000, 1),
(7, '2015-02-06', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 200000, 1),
(8, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 1000000, 1),
(9, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 5000, 1),
(10, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 5000, 1),
(11, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 5000, 1),
(12, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 5000, 1),
(13, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 5000, 1),
(14, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 5000, 1),
(15, '2015-08-31', '[<em>System - Do Not Delete</em>] Deduction Of Customer Debt From Account', 4000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) NOT NULL,
  `family` varchar(150) NOT NULL,
  `amount_rem` varchar(150) NOT NULL,
  `delimeter` double NOT NULL,
  `unit_price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=317 ;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `item_name`, `family`, `amount_rem`, `delimeter`, `unit_price`) VALUES
(1, 'Binding Wires #100', 'no', '100', 1, 100),
(2, 'Binding Wires #200', 'no', '100', 1, 200),
(3, 'Binding Wires #300', 'no', '100', 1, 300),
(4, 'Binding Wires #400', 'no', '100', 1, 400),
(13, 'Binding Wires - 10kg', '10KG B/W', '305.5', 1, 2500),
(14, 'Binding Wires - 20kg', '20KG B/W', '412', 1, 5000),
(15, 'Binding Wires - 25kg HT', '25KG HT B/W', '82', 1, 6500),
(16, 'Saw Blade - Bundle', 'SAW BLADE', '6629', 10, 1500),
(17, 'Saw Blade - Pack', 'SAW BLADE', '6629', 100, 15000),
(18, 'Saw Blade - Pieces', 'SAW BLADE', '6629', 1, 150),
(19, 'Oerlikon Electrode - G10', 'Oerlikon Electrode - G10', '112', 1, 2200),
(20, 'Oerlikon Electrode - G12', 'Oerlikon Electrode - G12', '150', 1, 2200),
(21, '3/4 Flat Bar - Retails', '3/4 FLAT BAR', '12324', 1, 400),
(22, '3/4 Flat Bar - wholesales', '3/4 FLAT BAR', '12324', 1, 380),
(23, '8mm Imported - Wholesale {pcs}', '5/16 HT', '1420', 1, 810),
(24, '8mm Imported - Retails {pcs}', '5/16 HT', '1420', 1, 850),
(25, '8mm Imported - Wholesale {Ton}', '5/16 HT', '1420', 210, 170000),
(26, '8mm Imported - Retails {Ton}', '5/16 HT', '1420', 134, 109000),
(27, '10mm Imported - Wholesales {Pcs}', '3/8 HT', '8773', 1, 1240),
(28, '10mm Imported - Wholesales {Ton}', '3/8 HT', '8773', 133, 165000),
(29, '10mm Imported - Retails {Pcs}', '3/8 HT', '8773', 1, 1250),
(30, '10mm Imported - Retails {Ton}', '3/8 HT', '8773', 133, 165000),
(31, '12mm Imported - Retails {Ton}', '''/2 Imported', '10808', 84, 149000),
(32, '12mm Imported - Retails {Pcs}', '''/2 Imported', '10808', 1, 1800),
(33, '12mm Imported - Wholesales {Pcs}', '''/2 Imported', '10808', 1, 1775),
(34, '12mm Imported - Wholesales {Ton}', '''/2 Imported', '10808', 93, 165000),
(35, '16mm Imported - Wholesales {Ton}', '5/8 Imported', '2529', 52, 165000),
(36, '16mm Imported - Retails {Ton}', '5/8 Imported', '2529', 52, 165000),
(37, '16mm Imported - Wholesales {pcs}', '5/8 Imported', '2529', 1, 3173),
(38, '16mm Imported - Retails {pcs}', '5/8 Imported', '2529', 1, 3200),
(39, '20mm Imported - Retails {Ton}', '3/4 Imported', '433', 33, 168000),
(40, '20mm Imported - Retails {pcs}', '3/4 Imported', '433', 1, 5100),
(41, '20mm Imported - Wholesales {Ton}', '3/4 Imported', '433', 33, 168000),
(42, '20mm Imported - Wholesales {pcs}', '3/4 Imported', '433', 1, 5090),
(43, '25mm Imported - Retails {Ton}', '1'' Rod Imported', '69', 21, 168000),
(44, '25mm Imported - Retails {pcs}', '1'' Rod Imported', '69', 1, 8100),
(45, '25mm Imported - Wholesales {pcs}', '1'' Rod Imported', '69', 1, 8000),
(46, '25mm Imported - Wholesales {Ton}', '1'' Rod Imported', '69', 21, 168000),
(47, '32mm Imported Ton', '32mm HT', '170', 13, 185000),
(48, '32mm Imported Pcs', '32mm HT', '170', 1, 14230),
(49, '1/4 Rod Ton', '6mm', '15331', 580, 165000),
(50, '1/4 Rod - Wholesales {Pcs}', '6mm', '15331', 1, 284),
(51, '1/4 Rod - Retails {Pcs}', '6mm', '15331', 1, 300),
(52, '10mm Local - Retails {Pcs}', '3/8 Local', '4382', 1, 850),
(53, '10mm Local - Retails {Ton}', '3/8 Local', '4382', 134, 114000),
(54, '10mm Local - Wholesales {Pcs}', '3/8 Local', '4382', 1, 850),
(55, '10mm Local - Wholesales {Ton}', '3/8 Local', '4382', 135, 115000),
(56, '12mm Local - Retails {Pcs}', '''/2 Local', '3335', 1, 1150),
(57, '12mm Local - Retails {Ton}', '''/2 Local', '3335', 84, 96000),
(58, '12mm Local - Wholesales {Pcs}', '''/2 Local', '3335', 1, 1138),
(59, '12mm Local - Wholesales {Ton}', '''/2 Local', '3335', 94, 107000),
(60, '16mm Local - Retails {Ton}', '5/8 Local', '101', 52, 105000),
(61, '16mm Local - Retails {pcs}', '5/8 Local', '101', 1, 2050),
(62, '16mm Local - Wholesales {Ton}', '5/8 Local', '101', 53, 107000),
(63, '16mm Local - Wholesales {pcs}', '5/8 Local', '101', 1, 2019),
(64, '20mm TMT - Retails {Ton}', '3/4 Rod TMT', '21', 33, 140000),
(65, '20mm TMT - Retails {pcs}', '3/4 Rod TMT', '21', 1, 4300),
(66, '20mm TMT - Wholesales {pcs}', '3/4 Rod TMT', '21', 1, 4242),
(67, '20mm TMT - Wholesales {Ton}', '3/4 Rod TMT', '150', 33, 140000),
(68, '25mm TMT - Wholesales {Ton}', '1'' Rod TMT', '9', 21, 140000),
(69, '25mm TMT - Wholesales {pcs}', '1'' Rod TMT', '9', 1, 6667),
(70, '25mm TMT - Retails {pcs}', '1'' Rod TMT', '9', 1, 6700),
(71, '25mm TMT - Retails {Ton}', '1'' Rod TMT', '9', 21, 140000),
(72, '16mm TMT - Wholesales {Ton}', '5/8 TMT', '894', 52, 140000),
(73, '16mm TMT - Wholesales {pcs}', '5/8 TMT', '894', 1, 2692),
(74, '12mm TMT - Wholesales {Ton}', '''/2 TMT', '2685', 93, 140000),
(75, '12mm TMT - Retails {Ton}', '''/2 TMT', '2685', 84, 127000),
(76, '12mm TMT - Wholesales {pcs}', '''/2 TMT', '2685', 1, 1505),
(77, '12mm TMT - Retails {pcs}', '''/2 TMT', '2685', 1, 1550),
(78, '10mm TMT - Wholesales {Ton}', '3/8 TMT', '467', 133, 150000),
(79, '10mm TMT - Wholesales {pcs}', '3/8 TMT', '467', 1, 1128),
(80, '10mm TMT - Retails {pcs}', '3/8 TMT', '467', 1, 1130),
(81, '10mm TMT - Retails {Ton}', '3/8 TMT', '467', 133, 150000),
(82, '20mm Local - Wholesales {Ton}', '3/4 Local Rod', '1154', 34, 115000),
(83, '20mm Local - Wholesales {pcs}', '3/4 Local Rod', '1154', 1, 3385),
(84, '20mm Local - Retails {Ton}', '3/4 Local Rod', '1154', 33, 112000),
(85, '20mm Local - Retails {pcs}', '3/4 Local Rod', '1154', 1, 3400),
(86, '25mm Local - Retails {Ton}', '1'' Rod Local', '210', 21, 110000),
(87, '25mm Local - Retails {pcs}', '1'' Rod Local', '210', 1, 5250),
(88, '25mm Local - Wholesales {pcs}', '1'' Rod Local', '210', 1, 5228),
(89, '25mm Local Wholesales {Ton}', '1'' Rod Local', '210', 22, 115000),
(90, '3/4 Black Thick - Wholesales', '3/4 BTH', '110247', 1, 600),
(91, '3/4 Black Thick - Retails', '3/4 BTH', '10247', 1, 650),
(92, '3/4 White Thick- Retails', '3/4 WTH', '3905', 1, 450),
(93, '3/4 White Thick- Wholesales', '3/4 WTH', '3905', 1, 440),
(94, '1x1 Black thick - Wholesales', '1X1 BTH', '1194', 1, 850),
(95, '1x1 Black thick - Retails', '1X1 BTH', '1194', 1, 900),
(96, '1x1 Black thick 2 - Retails', '1X1 BTH 2', '5750', 1, 800),
(97, '1x1 Black thick 2 - Wholesales', '1X1 BTH 2', '5750', 1, 780),
(98, '1x1 White thick - Retails', '1X1 WTH', '471', 1, 550),
(99, '1x1 White thick - Wholesales', '1X1 WTH', '471', 1, 530),
(100, '1''/2 Bthick Thick - Retails', '1''/2 BTH', '2885', 1, 1350),
(101, '1''/2 Bthick Thick - Wholesales', '1''/2 BTH', '2885', 1, 1300),
(102, '1''/2 Bthick Thick 2 - Retails', '1''/2 BTH 2', '2400', 1, 1300),
(103, '1''/2 Bthick Thick 2 - Wholesales', '1''/2 BTH 2', '2400', 1, 1250),
(104, '1''/2 White Thick - Retails', '1''/2 WTH', '18', 1, 960),
(105, '1''/2 White Thick - Wholesales', '1''/2 WTH', '18', 1, 950),
(106, '1''/2 Bthick Thick Square - Hacco', '1''/2 BTH HACCO', '120', 1, 2600),
(107, '2x2 Black Thick - Wholesales', '2x2 BTH', '1334', 1, 1850),
(108, '2x2 Black Thick - Retails', '2x2 BTH', '1334', 1, 1950),
(109, '2x2 White Thick - Retails', '2x2 WTH', '750', 1, 1300),
(110, '2x2 White Thick - Wholesales', '2x2 WTH', '750', 1, 1270),
(111, '2x2 Black Thick 2 - Retails', '2x2 BTH 2', '546', 1, 1800),
(112, '2x2 Black Thick 2 - Wholesales', '2x2 BTH 2', '546', 1, 1700),
(113, '2x2 Black Thick - Hacco', '2X2 BTH HACCO', '58', 1, 3500),
(114, '3x1''/2 Black Thick 1.2mm - Wholesales', '3x1''/2 BTH', '2588', 1, 2350),
(115, '3x1''/2 Black Thick 1.2mm - Retails', '3x1''/2 BTH', '2588', 1, 2400),
(116, '3x1''/2 Black Thick 2 - Wholesales', '3x1''/2 BTH 2', '2533', 1, 2100),
(117, '3x1''/2 Black Thick 2 - Retails', '3x1''/2 BTH 2', '2533', 1, 2200),
(119, '3x1''/2 White Thick - Retails', '3x1''/2 WTH', '1121', 1, 1500),
(120, '3x1''/2 White Thick - Wholesales', '3x1''/2 WTH', '1121', 1, 1400),
(121, '3x1''/2 Black Thick Square - Hacco', '3x1''/2 Black Thick Square - Hacco', '50', 1, 4000),
(122, '2x1 White Thick - Retails', '2x1 WTH', '1534', 1, 960),
(123, '2x1 White Thick - Wholesales', '2x1 WTH', '1534', 1, 950),
(124, '10mm Square Rod - Wholesales', '3/8 Square Rod', '1251', 1, 800),
(125, '10mm Square Rod - Retails', '3/8 Square Rod', '1251', 1, 850),
(126, '16mm Square Rod', '5/8 Full Square Rod', '27', 1, 2100),
(127, '14mm Square Rod', '5/8 Unfull Square Rod', '2', 1, 1700),
(128, '12mm Square Rod - Retails', '''/2 Square Rod', '10947', 1, 1000),
(129, '12mm Square Rod - Wholesales', '''/2 Square Rod', '10947', 1, 950),
(130, '3x3 Black Thick', '3x3 Black Thick', '63', 1, 3300),
(131, '1', '1 ANGLE', '4490', 1, 850),
(132, '1'' Angle - Retails', '1 ANGLE', '2003', 1, 900),
(133, '1''/2 Angle 2.5 - Retails', 'BED ANGLE 2', '3520', 1, 1200),
(134, '1''/2 Angle 2.5 - Wholesales', 'BED ANGLE 1', '3813', 1, 1150),
(135, 'Fed Electrode Retails - G12', 'Fed Electrodes', '3022', 1, 1600),
(136, 'Fed Electrode Wholesales - G12', 'Fed Electrodes', '2522', 1, 1550),
(137, 'JoyLong Electrode Wholesales - G12', 'JOYLONG ELECTRODES', '14', 1, 1350),
(138, '1''/2 Angle 4mm - Wholesales', '1''/2 Angles 4mm', '2409', 1, 2100),
(139, '1''/2 Angle 4mm - Retails', '1''/2 Angles 4mm', '2409', 1, 2100),
(140, '2'' Angle 3mm - Retail', '2'' Angles 3mm', '246', 1, 2200),
(141, '2'' Angle 3mm - Wholesales', '2'' Angles 3mm', '246', 1, 2100),
(142, '2'' Angle 4mm - Retail', '2'' Angles 4mm', '156', 1, 3000),
(143, '2'' Angle 4mm - Wholesales', '2'' Angles 4mm', '156', 1, 2900),
(144, '2'' Angle 5mm - Retail', '2'' Angles 5mm', '668', 1, 3500),
(145, '2'' Angle 5mm - Wholesales', '2'' Angles 5mm', '668', 1, 3400),
(146, '2''/2 Angle Retails', '60x60', '987', 1, 4800),
(147, '2''/2 Angle Wholesales', '60x60', '987', 1, 4700),
(148, '3'' Angle - Retails', '70x70', '858', 1, 5400),
(149, '3'' Angle - Wholesales', '70x70', '858', 1, 5300),
(150, '3'' Full Angle - Retails', '75x75', '586', 1, 5800),
(151, '3'' Full Angle - Wholesales', '75x75', '586', 1, 5700),
(152, '0.7mm Wholesales pcs', '0.7mm', '998883', 1, 2550),
(153, '0.7mm - Retails pcs', '0.7mm', '998883', 1, 2600),
(154, '0.7mm Wholesales Ton', '0.7mm', '998883', 1, 150000),
(155, '0.8mm Wholesales pcs', '0.8mm', '999570', 1, 3000),
(156, '0.8mm Wholesales Ton', '0.8mm', '999570', 1, 150000),
(157, '0.8mm - Retails pcs', '0.8mm', '999570', 1, 3100),
(158, '0.9mm Wholesales pcs', '0.9mm', '999865', 1, 3300),
(159, '0.9mm - Retails pcs', '0.9mm', '999865', 1, 3400),
(160, '0.9mm Wholesales Ton', '0.9mm', '999865', 1, 150000),
(161, '0.6mm Wholesales pcs', '0.6mm', '0', 1, 2250),
(162, '0.6mm - Retails pcs', '0.6mm', '0', 1, 2300),
(163, '0.6mm Wholesales Ton', '0.6mm', '0', 1, 155000),
(164, '0.5mm Wholesales pcs', '0.5mm', '999456', 1, 1900),
(165, '0.5mm - Retails pcs', '0.5mm', '999456', 1, 2000),
(166, '0.5mm Wholesales Ton', '0.5mm', '999456', 1, 155000),
(167, '0.4mm Wholesales pcs', '0.4mm', '999802', 1, 1500),
(168, '0.4mm - Retails pcs', '0.4mm', '999802', 1, 1500),
(169, '1mm Plate', '1mm Black Plate', '899878', 1, 4700),
(170, '1.2mm Plate', '1.2mm Black Plate', '899881', 1, 5000),
(171, '1.5mm Plate - Retails', 'Gauge 16', '899851', 1, 5500),
(172, '1.5mm Plate - Wholesales', 'Gauge 16', '899851', 1, 5400),
(173, '3mm Plate', '3mm Black Plate', '899993', 1, 10500),
(174, '4mm Plate', '4mm Black Plate', '899999', 1, 12500),
(175, '5mm Plate', '5mm Black Plate', '899983', 1, 16000),
(176, '1.5mm Chq Plate - Retails', '1.5mm Chequered Plate', '9797', 1, 6500),
(177, '1.5mm Chq Plate - Wholesales', '1.5mm Chequered Plate', '9797', 1, 6500),
(178, '1.6mm Chq Plate - Retails', '1.6mm Chequered', '9677', 1, 7500),
(179, '2.5mm chequered', '2.5mm Chequered Plate', '94', 1, 10000),
(180, '3mm Chq Plate', '3mm Chequered Plate', '42', 1, 11500),
(181, '4mm Chq Plate', '4mm Chequered Plate', '9994', 1, 16000),
(182, 'Binding Wires #1000', 'no', '100', 1, 1000),
(183, 'Binding Wires #900', 'no', '100', 1, 900),
(184, 'Binding Wires #800', 'no', '100', 1, 800),
(185, 'Binding Wires #700', 'no', '100', 1, 700),
(186, 'Binding Wires #600', 'no', '100', 1, 600),
(187, 'Binding Wires #500', 'no', '100', 1, 500),
(188, '1'' Flat Bar 3mm- Wholesales', '1'' F/BAR 3MM', '17435', 1, 590),
(189, '1'' Flat Bar 3mm - Retails', '1'' F/BAR 3MM', '17435', 1, 600),
(190, '1'' Flat Bar 5mm', '1'' F/BAR 5MM', '17956', 1, 1100),
(191, '1''/2 Flat Bar - 3mm', '1''/2 FLAT BAR 3MM', '17825', 1, 1000),
(192, '1''/2 Flat Bar - 5mm', '1''/2 FLAT BAR 5MM', '18000', 1, 2200),
(193, '2'' Flat Bar - 4mm', '2'' FLAT BAR 4MM', '17952', 1, 1800),
(194, '1'' Galvanized - Retails', '1'' GALVANIZED', '966', 1, 1600),
(195, '1'' Galvanized - Wholesales', '1'' GALVANIZED', '966', 1, 1600),
(196, '3/4 Galvanized - Retails', '3/4 GALVANIZED', '100', 1, 1400),
(197, '3/4 Galvanized - Wholesales', '3/4 GALVANIZED', '100', 1, 1400),
(198, '1''/4 Galvanized - Retails', '1''/4 GALVANIZED', '978', 1, 2500),
(199, '1''/4 Galvanized - Wholesales', '1''/4 GALVANIZED', '978', 1, 2300),
(200, '1''/2 Galvanized - Wholesales', '1''/2 GALVANIZED', '2331', 1, 2650),
(201, '1''/2 Galvanized - Retails', '1''/2 GALVANIZED', '92', 1, 3000),
(202, '2'' Galvanized - Retails', '2'' GALVANIZED', '100', 1, 4000),
(203, '2'' Galvanized - Wholesales', '2'' GALVANIZED', '100', 1, 3650),
(204, '2''/2 Galvanized - Retails', '2''/2 GALVANIZED', '100', 1, 5600),
(205, '2''/2 Galvanized - Wholesales', '2''/2 GALVANIZED', '100', 1, 4800),
(206, '3'' Galvanized - Retails', '3'' GALVANIZED', '100', 1, 6800),
(207, '3'' Galvanized - Wholesales', '3'' GALVANIZED', '100', 1, 6000),
(208, '4'' Galvanized - Wholesales', '4'' GALVANIZED', '68', 1, 8500),
(209, '4'' Galvanized - Retails', '4'' GALVANIZED', '68', 1, 9000),
(210, '6'' Frame', '6'' FRAME', '56', 1, 2900),
(211, '9'' Frame', '9'' FRAME', '10', 1, 3600),
(214, '3/4 Round Pipe - Retails', '3/4 ROUND PIPE', '9589', 1, 850),
(215, '3/4 Round Pipe - Wholesales', '3/4 ROUND PIPE', '9589', 1, 800),
(216, '1'' Round Pipe - Retails', '1'' ROUND PIPE', '9648', 1, 1050),
(217, '1'' Round Pipe - Wholesales', '1'' ROUND PIPE', '9648', 1, 1000),
(218, '1''/4 Round Pipe', '1''/4 ROUND PIPE', '9842', 1, 1300),
(220, '1''/2 Galvanized - Retails', '1''/2 GALVANIZED', '9992', 1, 3000),
(221, '1''/2 Round Hacco', '1''/2 ROUND HACCO', '9926', 1, 2600),
(222, '2'' Round Pipe - Retails', '2'' ROUND PIPE', '9812', 1, 2000),
(223, '2'' Round Pipe - Wholesales', '2'' ROUND PIPE', '9812', 1, 1900),
(224, '2'' Round Pipe - Hacco', '2'' ROUND PIPE HACCO', '9939', 1, 3200),
(225, '2''/2 Round Pipe - Wholesales', '2''/2 ROUND PIPE', '9960', 1, 2450),
(226, '2''/2 Round Pipe - Retails', '2''/2 ROUND PIPE', '9960', 1, 2500),
(227, '2''/2 Round Pipe - Hacco', '2''/2 ROUND PIPE HACCO', '9947', 1, 4000),
(228, '3'' Round Pipe - Hacco', '3'' ROUND PIPE', '9987', 1, 5000),
(229, 'Stone Bridge G12- Retails', 'STONE BRIDGE G12', '36', 1, 1400),
(230, 'Stone Bridge G12- Wholesales', 'STONE BRIDGE G12', '36', 1, 1350),
(231, 'Stone Bridge G10- Wholesales', 'STONE BRIDGE G10', '17', 1, 1350),
(232, 'Stone Bridge G10- Retails', 'STONE BRIDGE G10', '17', 1, 1400),
(233, 'Stone Bridge Small G12- Retails', 'STONE BRIDGE G12 SMALL', '8115', 1, 700),
(234, 'Stone Bridge G12 Small - Wholesales', 'STONE BRIDGE G12 SMALL', '8115', 1, 675),
(235, '7x7 Square ''/4', '7*7 RING SQUARE ''/4', '3996', 12, 350),
(236, '7x7 Triangle ''/4', '7*7 RING TRIANGLE ''/4', '12084', 12, 320),
(237, '7x7 Square 5/16', '7*7 RING SQUARE 5/16', '16128', 12, 650),
(238, '7x7 Triangle 5/16', '7*7 RING TRIANGLE 5/16', '2104', 12, 650),
(239, '4x7 Triangle ''/4 - Retails', '4*7 RING TRIANGLE ''/4', '4956', 12, 250),
(240, '4x7 Square ''/4 - Retails', '4*7 RING SQUARE ''/4', '1224', 12, 300),
(241, '6x6 Square ''/4 - Retails', '6*6 RING SQUARE ''/4', '3636', 12, 320),
(242, '7x7 Square 8mm - Retails', '7*7 RING SQUARE 8mm', '19680', 12, 650),
(243, '7x7 Square 8mm - Wholesales', '7*7 RING SQUARE 8mm', '19680', 12, 600),
(244, '7x7 Square 10mm', '7*7 RING SQUARE 10MM', '16812', 12, 900),
(245, 'Cutting Disk Big', 'CUTTING BIG', '58', 1, 200),
(246, 'Cutting Disk Small', 'CUTTING SMALL', '129', 1, 150),
(247, '6x6 Triangle ''/4 - Retails', '6*6 RING TRIANGLE ''/4', '1740', 12, 300),
(248, '6x6 Triangle ''/4 - Wholesales', '6*6 RING TRIANGLE ''/4', '1740', 12, 230),
(250, '6x6 Square ''/4 - Wholesales', '6*6 RING SQUARE ''/4', '3636', 12, 250),
(251, '4x7 Square ''/4 - Wholesales', '4*7 RING SQUARE ''/4', '1224', 12, 250),
(252, '4x7 Triangle ''/4 - Wholesales', '4*7 RING TRIANGLE ''/4', '4956', 12, 220),
(253, '4x2 R J', '100 x 55 R J', '10', 1, 7500),
(254, '4''/2x2''/2 R J', '120 x 64 R J', '30', 1, 19000),
(257, '4x2 U-Channel Thick', '100 x 50 U - Channel THICK', '143', 1, 9000),
(258, '4x2 U-Channel Lite', '100 x 50 U - CHANNEL LITE', '120', 1, 6500),
(259, '3x1''/2 U - Channel', '80 x 40 U - CHANNEL', '500', 1, 7500),
(261, '6x3 R J', '160 x 84  R J IPE', '18', 1, 28000),
(264, 'Z - Pulin 1.2', 'Z - PULIN 1.2mm', '197', 1, 3200),
(265, 'Z - Pulin 2.5mm', 'Z - PULIN 2.5mm', '113', 1, 3800),
(267, '1''/2 Round pipe - Retails', '1''/2 ROUND', '118', 1, 1500),
(268, '5/16 Local - RETAIL Pcs', '8MM LOCAL', '14665', 1, 650),
(269, 'Fed Electrode Retails - G10', 'Fed Electrodes G10', '11976', 1, 1600),
(270, 'Fed Electrode WHOLESALES - G10', 'Fed Electrodes G10', '11976', 1, 1550),
(271, '4'' HACCO', '4'' HACCO', '11981', 1, 6000),
(272, '2x1 Black Thick - Retails', '2x1 BTH', '1464', 1, 1350),
(273, '2x1 Black Thick - Wholesales', '2x1 BTH', '1464', 1, 1300),
(277, 'TRANSPORTATION', 'no', '100000', 1, 0),
(279, '3/4 LITE - Retails', '3/4 WHITE LITE', '11808', 1, 350),
(280, '3/4 LITE - Wholesales', '3/4 WHITE LITE', '11808', 1, 330),
(282, '12mm Plain - Retails', '''/2 Plain Rod', '11978', 1, 1250),
(283, 'Loaders Fee', 'no', '100000', 1, 0),
(284, 'Transfer Account', 'no', '100', 1, 0),
(285, '1''/2 Round pipe - Wholesales', '1''/2 ROUND', '118', 1, 1450),
(286, '1.6mm Chequered - Wholesales', '1.6mm Chequered', '1337', 1, 7000),
(287, 'Old Balance payment', 'no', '100', 1, 0),
(288, '4x2 Pipe 1.2mm', '4x2 Pipe', '42', 1, 3500),
(289, '2mm Plate - Wholesales', 'Gauge 14', '518', 1, 6800),
(290, '2mm Plate - Retails', 'Gauge 14', '518', 1, 7000),
(291, '1'' Stainless', '1'' Stainless', '300', 1, 4500),
(292, '1''/4 Stainless', '1''/4 Stainless', '297', 1, 5500),
(293, '2'' Stainless', '2'' Stainless', '300', 1, 8000),
(294, '3/4 Stainless', '3/4 Stainless', '300', 1, 2800),
(296, '''/2'' Stainless', '''/2 Stainless', '300', 1, 1500),
(297, '5/16 Local - Wholesales Ton', '8MM LOCAL', '14665', 210, 135000),
(298, '5/16 LOCAL - RETAILS Ton', '8MM LOCAL', '14665', 134, 87000),
(299, '5/16 Local - Wholesales Pcs', '8MM LOCAL', '14665', 1, 643),
(300, '1''4 x 3/4 Pipe', '1''/4x3/4', '98', 1, 1350),
(301, 'Galvanized Sheet 0.5', 'Galv 0.5mm', '408', 1, 2400),
(302, 'Galvanized Sheet 0.6', 'Galv 0.6mm', '350', 1, 3100),
(303, 'Galvanized Sheet 0.7', 'Galv 0.7mm', '301', 1, 3550),
(304, 'Galvanized Sheet 0.8', 'Galv 0.8mm', '266', 1, 4100),
(305, 'Galvanized Sheet 0.9', 'Galv 0.9mm', '227', 1, 4500),
(306, 'Galvanized Sheet 1.2', 'Galv 1.2mm', '176', 1, 5900),
(307, 'Galvanized Sheet 1.4', 'Galv 1.4mm', '132', 1, 6900),
(308, '16mm TMT - Retails {pcs}', '5/8 TMT', '894', 1, 2700),
(309, '8 x 4 RJ', '200 X 100 IPE', '25', 1, 38000),
(310, '7 X 3''/2 RJ', '180 X 90 IPE', '25', 1, 35000),
(311, '6''/4 X 3''/4 RJ', '160 x 82 IPE', '66.5', 1, 28000),
(312, '5''/2 x 3 R J', '140 x 75 IPE', '30', 1, 24000),
(313, '5 x 2''/4 RJ', '120 x 64 IPE', '30', 1, 21000),
(314, '4 x 2''/4 R J', '100 x 55 IPE', '83', 1, 7500),
(315, '1'' Angle - Wholesales', '1 ANGLE', '2003', 1, 850),
(316, 'Brought Forward Debit Balance', 'no', '100', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reciept`
--

CREATE TABLE IF NOT EXISTS `reciept` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `amount` double NOT NULL,
  `amount_paid` double NOT NULL,
  `vat` double NOT NULL,
  `change` double NOT NULL,
  `r_change` double NOT NULL,
  `sales_point` bigint(150) NOT NULL,
  `date` date NOT NULL,
  `remark` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `balance` varchar(150) NOT NULL,
  `rev` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `reciept`
--

INSERT INTO `reciept` (`id`, `name`, `amount`, `amount_paid`, `vat`, `change`, `r_change`, `sales_point`, `date`, `remark`, `type`, `balance`, `rev`) VALUES
(1, 'Adewale Adesina', 1490000, 1490000, 74500, 0, 0, 6, '2015-02-06', 'Paid & Supplied', '', '', 0),
(3, 'Dangote', 180000, 180000, 9000, 0, 0, 1, '2015-02-06', '', '', '', 0),
(4, 'Adewale Adesina', 400000, 400000, 20000, 0, 0, 1, '2015-02-06', '', '', '', 0),
(5, 'Dangote', 1500000, 1500000, 75000, 0, 0, 1, '2015-02-06', '', '', '', 0),
(6, 'Adewale Adesina', 200000, 200000, 10000, 0, 0, 1, '2015-02-06', '', '', '', 0),
(7, 'Dangote', 700000, 700000, 35000, 0, 0, 1, '2015-02-06', '', '', '', 0),
(8, 'Balance Brought Forward', 2680000, 2680000, 0, 0, 0, 1, '2015-08-31', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reciept_goods`
--

CREATE TABLE IF NOT EXISTS `reciept_goods` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `vat` double NOT NULL,
  `date` date NOT NULL,
  `good_id` bigint(150) NOT NULL,
  `sales_point` bigint(150) NOT NULL,
  `reciept` bigint(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `reciept_goods`
--

INSERT INTO `reciept_goods` (`id`, `item_name`, `unit_price`, `quantity`, `amount`, `vat`, `date`, `good_id`, `sales_point`, `reciept`) VALUES
(1, '12mm Imported - Retails {Ton}', 149000, 10, 1490000, 74500, '2015-02-06', 31, 6, 1),
(3, 'Debt Payment', 180000, 1, 180000, 9000, '2015-02-06', 0, 1, 3),
(4, 'Debt Payment', 400000, 1, 400000, 20000, '2015-02-06', 0, 1, 4),
(5, 'Debt Payment', 1500000, 1, 1500000, 75000, '2015-02-06', 0, 1, 5),
(6, 'Debt Payment', 200000, 1, 200000, 10000, '2015-02-06', 0, 1, 6),
(7, 'Debt Payment', 700000, 1, 700000, 35000, '2015-02-06', 0, 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `waiting`
--

CREATE TABLE IF NOT EXISTS `waiting` (
  `id` bigint(150) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `amount` double NOT NULL,
  `sales_point` bigint(150) NOT NULL,
  `good_id` bigint(150) NOT NULL,
  `customer` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
