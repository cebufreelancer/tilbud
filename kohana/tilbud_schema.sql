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
  `addresses` text,
  `image` varchar(255) default NULL,
  `image2` varchar(255) default NULL,
  `image3` varchar(255) default NULL,
  `image4` varchar(255) default NULL,
  `image5` varchar(255) default NULL,
  `facebook_image` varchar(255) default NULL,
  `regular_price` decimal(10,2) default '0.00',
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
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL auto_increment,
  `page_code` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_code`, `content`, `created_at`, `updated_at`) VALUES
(1, 'about', 'about us content', '2011-04-26 00:00:00', '2011-04-26 00:00:00'),
(2, 'contact', 'contact us content', '2011-04-26 00:00:00', '2011-04-26 00:00:00'),
(3, 'faq', 'faq content', '2011-04-26 16:17:28', '2011-04-26 16:17:32'),
(4, 'terms', 'terms and conditions', '2011-04-26 16:17:28', '2011-04-26 16:17:32'),
(5, 'how', 'how tilbud', '2011-04-26 16:17:28', '2011-04-26 16:17:32'),
(6, 'suggest', 'suggest  tilbud', '2011-04-26 16:17:28', '2011-04-26 16:17:32'),
(7, 'getyourbusiness', 'get your business on tilbudiyen', '2011-04-26 16:17:28', '2011-04-26 16:17:32'),
(8, 'why', 'why tilbudibyen', '2011-04-26 16:17:28', '2011-04-26 16:17:32');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `organizations`
--

ALTER TABLE `products`
  ADD CONSTRAINT FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`ID`) ON DELETE CASCADE;
	
ALTER TABLE `deals`
	ADD CONSTRAINT FOREIGN KEY (`city_id`) REFERENCES `cities` (`ID`) ON DELETE CASCADE;
	
ALTER TABLE `users` 
	ADD `firstname` VARCHAR( 100 ) DEFAULT '',
	ADD `lastname` VARCHAR( 100 ) DEFAULT '',
	ADD `mobile` VARCHAR( 20 ) NULL;
	
ALTER TABLE `billings`
  ADD CONSTRAINT FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
	
ALTER TABLE `vendors`
	ADD `notes` TEXT NULL;
	
CREATE ALGORITHM=UNDEFINED DEFINER=`tilbud`@`localhost` SQL SECURITY DEFINER VIEW `v_orders` AS select distinct `orders`.`ID` AS `ID`,`orders`.`user_id` AS `user_id`,`orders`.`deal_id` AS `deal_id`,`orders`.`refno` AS `refno`,`orders`.`quantity` AS `quantity`,`orders`.`payment_type` AS `payment_type`,`orders`.`total_count` AS `total_count`,`orders`.`status` AS `status`,`orders`.`date_paid` AS `date_paid`,`orders`.`date_created` AS `date_created`,`deals`.`city_id` AS `city_id`,`deals`.`group_id` AS `group_id`,`deals`.`title` AS `title`,`deals`.`description` AS `description`,`deals`.`contents` AS `contents`,`deals`.`contents_title` AS `contents_title`,`deals`.`whatyouget` AS `whatyouget`,`deals`.`information` AS `information`,`deals`.`reference_no` AS `reference_no`,`deals`.`addresses` AS `addresses`,`deals`.`image` AS `image`,`deals`.`regular_price` AS `regular_price`,`deals`.`discount` AS `discount`,`deals`.`end_date` AS `end_date`,`deals`.`start_date` AS `start_date`,`users`.`email` AS `email`,`users`.`username` AS `username`,`users`.`firstname` AS `firstname`,`users`.`lastname` AS `lastname`,`users`.`mobile` AS `mobile`,`users`.`address` AS `address`,concat(`users`.`firstname`,' ',`users`.`lastname`) AS `fullname` from ((`orders` join `deals`) join `users`) where ((`orders`.`deal_id` = `deals`.`ID`) and (`orders`.`user_id` = `users`.`id`));

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url_code` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `name`, `url_code`) VALUES
(1, 'Example Category', 'example-category');

--
-- Table structure for table `category_relationships`
--

CREATE TABLE IF NOT EXISTS `category_relationships` (
  `category_id` int(11) NOT NULL,
  `deal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `deals`
	MODIFY `regular_price` decimal(10,2) DEFAULT '0.00' ,
	MODIFY `discount` decimal(10,2) DEFAULT '0.00';	

--
-- MAY 4 2011 Updates
-- 

ALTER TABLE  `deals` ADD  `group_id` INT NOT NULL AFTER  `product_id`;
ALTER TABLE  `deals` ADD  `reference_no` VARCHAR( 50 ) NULL AFTER  `group_id`;
ALTER TABLE  `deals` ADD  `youtube_url` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `end_date`;
ALTER TABLE  `deals` ADD  `expiry_date` DATETIME NULL DEFAULT NULL AFTER  `end_date`;
ALTER TABLE  `deals` ADD  `min_sold` INT NOT NULL DEFAULT  '0' AFTER  `max_buy`;
ALTER TABLE  `deals` ADD  `max_sold` INT NOT NULL DEFAULT  '0' AFTER  `min_sold`;

ALTER TABLE  `cities` ADD  `order` INT NOT NULL DEFAULT  '0';

--
-- MAY 6 2011 Updates
--
CREATE TABLE IF NOT EXISTS `subscribers` (
  `email` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  UNIQUE KEY `email` (`email`,`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- May 8 2011 Updates
--
ALTER TABLE  `deals` ADD  `addresses` TEXT NOT NULL AFTER  `information`;
ALTER TABLE  `users` ADD  `group_id` int(11) NOT NULL DEFAULT 1 AFTER `id`;

--
-- May 13 2011 Updates
--
ALTER TABLE  `billings` ADD  `cardtype` VARCHAR( 50 ) NOT NULL DEFAULT  'mastercard' AFTER  `cardname`;

--
-- May 19 2011 Updates
--
ALTER TABLE `users` 
	ADD `address` VARCHAR( 255 ) NULL,
	MODIFY `firstname` VARCHAR( 100 ) DEFAULT '',
	MODIFY `lastname` VARCHAR( 100 ) DEFAULT '';

--
-- May 20 2011 Updates
--
ALTER TABLE `orders` ADD `refno` VARCHAR( 50 ) NOT NULL AFTER `deal_id` ;

--
-- May 22 2011 Updates
--

--
-- Table structure for table `mail_templates`
--

CREATE TABLE IF NOT EXISTS `mail_templates` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `subject` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

INSERT INTO `mail_templates` (`ID`, `name`, `text`, `subject`) VALUES
(1, 'Order Template', '<p>K&aelig;re $CUSTOMERNAME,</p>\n<p>&nbsp;</p>\n<p><strong>$DEAL</strong>&nbsp;er nu aktiveret.</p>\n<p>&nbsp;</p>\n<p>I den vedh&aelig;ftet pdf fil finder du dit v&aelig;rdibevis med dit referencenummer.</p>\n<p>Har du angivet dit mobilnummer har du ogs&aring; modtaget referencenummeret p&aring; SMS.</p>\n<p>Medbring dit referencenummer i butikken n&aring;r du &oslash;nsker at g&oslash;re brug af dit k&oslash;b.</p>\n<p>Husk at v&aelig;re opm&aelig;rksom p&aring; v&aelig;rdibevisets udl&oslash;bsdato. Den st&aring;r p&aring; det vedh&aelig;ftede v&aelig;rdibevis.</p>\n<p>&nbsp;</p>\n<p>Referencenummeret kan indl&oslash;ses fra i dag af.</p>\n<p>God forn&oslash;jelse!</p>\n<table style="font-size: 12px; margin-top: 25px; width: 100%;">\n<tbody>\n<tr>\n<td style="font-size: 12px; vertical-align: top;" width="50%"><strong>K&oslash;ber</strong><br /> $CUSTOMERNAME <br />$CUSTOMEREMAIL <br /><br /><strong>S&aelig;lger</strong><br /> TilbudiByen.dk<br /> N&oslash;rregade 7B<br /> 1165 K&oslash;benhavn K<br /> CVR nummer: 33583400</td>\n<td style="font-size: 12px; vertical-align: top;" width="50%"><strong>FAKTURA</strong><br /> Bestillingsnummer: $ORDERNUMBER<br /> Fakturanummer: $ORDERNUMBER<br /> Dato: $DATETODAY<br /><br /> Betaling: <strong>$PAYMENTTYPE</strong><br /> Betalingstatus: <strong>$ORDERSTATUS</strong></td>\n</tr>\n</tbody>\n</table>\n<p>&nbsp;</p>\n<table style="font-size: 12px; border-collapse: collapse; margin: 25px 0px;">\n<thead style="font-weight: bold;">\n<tr style="border-bottom: 2px solid #000;">\n<td style="padding: 15px 3px;" width="60%">Beskrivelse</td>\n<td style="border-bottom: 2px solid #000;" width="10%">Antal</td>\n<td style="border-bottom: 2px solid #000;" width="15%">Pris</td>\n<td style="border-bottom: 2px solid #000;" width="15%">Total</td>\n</tr>\n</thead>\n<tbody>\n<tr style="border-bottom: 1px solid #000;">\n<td style="padding: 10px 5px;">$DEAL</td>\n<td>$QUANTITY</td>\n<td>$REGULARPRICE DKK</td>\n<td>$TOTALAMOUNT DKK</td>\n</tr>\n<tr style="border-bottom: 1px solid #000;">\n<td style="padding: 10px 5px;">Betalingskortgebyr<br /> $PAYMENTTYPE, $CARDNUMBER</td>\n<td>1</td>\n<td>$CARDINTEREST DKK</td>\n<td>$CARDINTEREST DKK</td>\n</tr>\n<tr style="border-bottom: 1px solid #000; font-weight: bold;">\n<td style="padding: 10px 5px;" colspan="3">Total</td>\n<td>$TOTALAMOUNT DKK</td>\n</tr>\n<tr style="border-bottom: 1px solid #000;">\n<td style="padding: 10px 5px;" colspan="3">Heraf moms (25,00%)</td>\n<td>10.00 DKK</td>\n</tr>\n</tbody>\n</table>\n<p>Husk at oplyse dit bestillingsnummer hvis du skulle f&aring; brug for at henvende dig til Tilbudibyen kundeservice i forbindelse med dit k&oslash;b.</p>\n<p>&nbsp;</p>\n<p>Med venlig hilsen<br />The Tilbudibyen Team<br /><br /><a href="http://www.tilbudibyen.com">http://www.tilbudibyen.com</a></p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>$LOGO</p>\n<p>Tilbud DK ApS, Vesterbrogade 20, 3. sal, 1620 K&oslash;benhavn K<br />CVR nummer: 32780709</p>\n<p>&nbsp;</p>\n<p><em>Du kan ikke svare direkte p&aring; denne e-mail. Benyt venligst kontakt-siden p&aring; tilbudibyen.com</em>&nbsp;</p>', '$DEAL TilbudiByen.dk (Ordrenummer $ORDER_ID)'),
(2, 'Deal Template', '<div style="color: #000000;">\r\n<p style="text-align: center; font-size: 11px;">Jeg &oslash;nsker at se denne e-mail i min browser - $EMAILFORMATURL.</p>\r\n<p style="text-align: center; font-size: 11px;">Du modtager denne e-mail fordi du er tilmeldt nyhedsbrevet hos TilbudiByen.dk.Hvis du ikke &oslash;nsker at modtage Dagens Tilbud i Byen p&aring; e-mail l&aelig;ngere kan du altid afmelde dig ved at klike her.</p>\r\n\r\n<div style="border: 15px solid #40a2d5; background: #FFFFFF; width: 670px; padding: 15px; margin: auto;">\r\n  <div style="background: #000000; padding: 15px 10px; url($BGHEADER) bottom left repeat-x;">\r\n     $LOGO<span style="float: right; font-style: italic; color: #e9e9e9; font-size: 17px; padding-top: 15px;">De bedste tilbud og oplevelser i din by!</span>\r\n  </div>\r\n\r\n  <div style="background: #40a2d5; color: #FFF;">\r\n    <h1 style="font-size: 22px; padding: 10px;"><span style="color: #000;">$DEALTITLE</span> $DEAL</h1>\r\n  </div>\r\n\r\n  <div style="width: 200px; float: left;">\r\n\r\n    <div style="font-size: 60px; font-weight: bold; text-align: center; color: #40a2d5; $DEALCLASS"><span style="color: #000;">$DEALPRICE</span>,-</div>\r\n    <div>$DEALURL</div>\r\n\r\n    <div style="font-size: 18px; font-weight: bold; padding: 5px 20px 5px 0px;">Værdi:<span style="float: right;">$DEALREGPRICE,-</span></div>\r\n    <div style="font-size: 18px; font-weight: bold; padding: 5px 20px 5px 0px;">Rabat:<span style="float: right;">$DEALDISCOUNT %</span></div>\r\n    <div style="font-size: 18px; font-weight: bold; padding: 5px 20px 5px 0px;">Du sparer:	<span style="float: right;">$DEALSAVINGS,-</span></div>\r\n    <div style="clear: both;"></div>\r\n\r\n    <h3 style="color: #40a2d5;">Information</h3>\r\n    <div style="font-size: 14px;">$DEALINFO</div>\r\n\r\n    <h3 style="color: #40a2d5;">Hvor ligger det</h3>\r\n    <div style="font-size: 14px;">$LOCATION</div>\r\n  </div>\r\n\r\n  <div style="width: 430px; float: left; padding-left: 25px; font: 18px/22px Arial, Helvetica, sans-serif;">\r\n    <h2 style="color: #666666; font-size: 22px;">Se dagens tilbud på video - klik her.</h2>\r\n    $DEALIMAGE <br/>\r\n    $DEALCONTENTS\r\n  </div>\r\n\r\n  <div style="clear: both;"></div>\r\n\r\n  <div style="text-align: right; margin-top: 25px;">$FACEBOOK</div>\r\n</div>\r\n\r\n<p style="text-align: center; font-size: 11px;">Nyhedsbrevet udsendes af Tilbudibyen.dk ApS - N&oslash;rregade 7B - 1165 K&oslash;benhavn K</p>\r\n</div>', '$DEAL');