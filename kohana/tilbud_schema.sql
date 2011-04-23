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
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `regular_price` decimal(10,0) DEFAULT '0',
  `discount` decimal(10,0) DEFAULT '0',
  `discount_type` varchar(50) DEFAULT 'percent',
  `min_buy` int(11) NOT NULL DEFAULT '1',
  `max_buy` int(11) NOT NULL DEFAULT '0',
  `vouchers` int(11) NOT NULL DEFAULT '0',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `deals`
--

INSERT INTO `deals` (`ID`, `city_id`, `product_id`, `title`, `description`, `image`, `regular_price`, `discount`, `discount_type`, `min_buy`, `max_buy`, `vouchers`, `start_date`, `end_date`, `date_create`, `last_update`) VALUES
(1, 1, 1, 'Super Peel Sale', 'super peel sale', NULL, '5000', '50', 'percent', 1, 5, 25, '2011-05-09 00:57:51', '2011-05-14 00:58:05', '2011-04-24 00:58:14', NULL);

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
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `vendor_id`, `title`, `description`, `price`, `image`) VALUES
(1, 1, 'Super Peel', 'super peel', '5000', NULL);

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
-- Constraints for dumped tables
--

--
-- Constraints for table `organizations`
--

ALTER TABLE `products`
  ADD CONSTRAINT FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`ID`);
	
ALTER TABLE `deals`
	ADD CONSTRAINT FOREIGN KEY (`city_id`) REFERENCES `cities` (`ID`);
	
ALTER TABLE `deals`
	ADD CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `products` (`ID`);