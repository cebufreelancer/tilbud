-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2011 at 04:59 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `tilbud_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Copenhagen'),
(2, 'Aarhus'),
(3, 'Aalborg'),
(4, 'Kentucky');

-- --------------------------------------------------------

--
-- Table structure for table `deals`
--

CREATE TABLE IF NOT EXISTS `deals` (
  `ID` int(11) NOT NULL auto_increment,
  `city_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) default NULL,
  `description` text,
  `contents` text,
  `contents_title` varchar(255) NOT NULL,
  `whatyouget` text,
  `information` text,
  `image` varchar(255) default NULL,
  `regular_price` decimal(10,0) default '0',
  `discount` decimal(10,0) default '0',
  `discount_type` varchar(50) default 'percent',
  `min_buy` int(11) NOT NULL default '1',
  `max_buy` int(11) NOT NULL default '0',
  `vouchers` int(11) NOT NULL default '0',
  `total_sold` int(11) NOT NULL default '0',
  `start_date` datetime default NULL,
  `end_date` datetime default NULL,
  `is_featured` tinyint(1) NOT NULL default '0',
  `status` varchar(150) NOT NULL default 'draft',
  `date_create` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `last_update` datetime default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`ID`, `city_id`, `product_id`, `title`, `description`, `contents`, `contents_title`, `whatyouget`, `information`, `image`, `regular_price`, `discount`, `discount_type`, `min_buy`, `max_buy`, `vouchers`, `total_sold`, `start_date`, `end_date`, `is_featured`, `status`, `date_create`, `last_update`) VALUES
(1, 1, 1, 'Super Peel Sale', 'Halv pris p&aring; en stor sushi-menu til 2 personer hos Sushi.com p&aring; Sankt Ann&aelig; Plads. Del det med en du holder af - for der er mere end nok til 2.', 'I en k&aelig;lder p&aring; Sankt Ann&aelig; Plads ligger en skjult sushi-perle. S&aring; snart du tr&aelig;der ind hos Sushi.com, kan den hyggelige atmosf&aelig;re m&aelig;rkes, og betjeningen er s&oslash;d og &aring;ben.\r\n\r\nHos Sushi.com kan du f&aring; en anderledes sushi-oplevelse midt i byen. Det er de perfekte rammer om en hyggelig aften med &eacute;n, du holder af. Restauranten laver sushi efter alle kunstens regler og originale japanske opskrifter.\r\n\r\nIndehaveren Yadi har over fem &aring;rs erfaring som sushi-kok, og han er derfor rustet til at servicere sushi-glade k&oslash;benhavnere p&aring; allerbedste vis.\r\n\r\nDer bliver naturligvis kr&aelig;set for detaljerne med friske og sunde r&aring;varer. Med dagens tilbud f&aring;r du sushi til to personer best&aring;ende af:\r\n\r\n38 stk. sushi: \r\n- Nigiri: 2 stk. laks, 2 stk. tun, 2 stk. laks med peber, 2 stk. reje \r\n- Hoso maki: 4 stk. agurk, 4 stk. spicy reje \r\n- Insideout maki: 4 stk. hawaian, 4 stk. green laks \r\n- Futo maki: 6 stk. california \r\n- Rispapir maki: 4 stk. crispy rejer, 4 stk. laks \r\nVed hvert bord i restauranten finder du en knap, og n&aring;r du trykker p&aring; den, kommer der straks en tjener - for hos Sushi.com er betjeningen vigtig. Du beh&oslash;ver derfor aldrig at sidde og vifte forg&aelig;ves efter &oslash;jenkontakt. Du kan spise sushi-menuen i den hyggelige restaurant eller tage den med hjem.', 'Nyd en skr&aelig;ddersyet sushi couple menu', 'Max. 1 v&aelig;rdibevis pr. person.\r\nMax. 1500 v&aelig;rdibeviser til salg.\r\nBestilling af maden skal ske senest 2 timer f&oslash;r afhentning p&aring; tlf.: 3333 8088.\r\nKan tidligst afhentes fra kl 14. &AElig;ndringer i menu kan ikke foretages.\r\nV&aelig;rdibeviset kan indl&oslash;ses fra 18. februar 2011 til 30. april 2011', '&Aring;bningstider & hjemmeside:\r\nMandag-torsdag: 11-21\r\nFredag-l&oslash;rdag: 11-22\r\nS&oslash;ndag: 12-21\r\nwww.sushicom.dkapril 2011', 'sample-image.jpg', 500, 50, 'percent', 20, 100, 25, 0, '2011-05-09 00:57:51', '2011-05-14 00:58:05', 1, 'draft', '2011-04-24 00:58:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `payment_type` varchar(100) NOT NULL DEFAULT 'paypal',
  `total_count` decimal(10,0) NOT NULL DEFAULT '0',
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `date_paid` datetime NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text,
  `price` decimal(10,0) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `vendor_id`, `title`, `description`, `price`, `image`, `date_created`) VALUES
(1, 1, 'Super Peel', 'super peel', '5000', NULL, '2011-04-24 00:56:00'),
(2, 1, 'Facial wash', 'facial wash', '850', NULL, '2011-04-24 22:20:36'),
(3, 1, 'Face Lift', 'face lift', '3000', NULL, '2011-04-24 22:20:36'),
(4, 1, 'Breast Implant', 'breast implant', '25000', NULL, '2011-04-24 22:21:53'),
(5, 1, 'Nose Job', 'nose job', '0', NULL, '2011-04-24 22:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE IF NOT EXISTS `vendors` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `office_hours` text,
  `status` varchar(50) NOT NULL DEFAULT 'draft',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`ID`, `name`, `description`, `address`, `phone`, `url`, `email`, `office_hours`, `status`, `date_created`) VALUES
(1, 'Belo Medical', 'Belo Medical', 'Ayala Center', '111-111111', 'http://belo.com', 'belo@belo.com', 'Monday-Tuesday: 10-12AM', 'draft', '2011-04-24 00:56:00');


-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_code` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pages`
--

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billings` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cardname` varchar(50) DEFAULT NULL,
  `cardnumber` varchar(16) DEFAULT NULL,
  `cardcode` int(4) DEFAULT NULL,
  `expiry_year` int(11) DEFAULT NULL,
  `expiry_month` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zipcode` int(5) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `billing`
--

--
-- Constraints for dumped tables
--

--
-- Constraints for table `organizations`
--

ALTER TABLE `products`
  ADD CONSTRAINT FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`ID`) ON DELETE CASCADE;
	
ALTER TABLE `deals`
	ADD CONSTRAINT FOREIGN KEY (`city_id`) REFERENCES `cities` (`ID`) ON DELETE CASCADE,
	ADD CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`) ON DELETE CASCADE;
	
ALTER TABLE `users` 
	ADD `firstname` VARCHAR( 100 ) NULL ,
	ADD `lastname` VARCHAR( 100 ) NULL ,
	ADD `mobile` VARCHAR( 20 ) NULL;
	
ALTER TABLE `billings`
  ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;