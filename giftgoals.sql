-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 28, 2016 at 05:45 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `giftgoals`
--
CREATE DATABASE IF NOT EXISTS `giftgoals` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `giftgoals`;

-- --------------------------------------------------------

--
-- Table structure for table `agelist`
--

DROP TABLE IF EXISTS `agelist`;
CREATE TABLE IF NOT EXISTS `agelist` (
  `ageID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`ageID`,`productID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `agelist`
--

INSERT INTO `agelist` (`ageID`, `productID`) VALUES
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `ages`
--

DROP TABLE IF EXISTS `ages`;
CREATE TABLE IF NOT EXISTS `ages` (
  `ageID` int(11) NOT NULL AUTO_INCREMENT,
  `ageText` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ages`
--

INSERT INTO `ages` (`ageID`, `ageText`) VALUES
(1, 'Teen');

-- --------------------------------------------------------

--
-- Table structure for table `brokenLinks`
--

DROP TABLE IF EXISTS `brokenLinks`;
CREATE TABLE IF NOT EXISTS `brokenLinks` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `productID` int(11) NOT NULL,
  `storeID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `catID` int(11) NOT NULL AUTO_INCREMENT,
  `catName` varchar(50) NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `catName`) VALUES
(1, 'Boys'),
(2, 'Girls'),
(3, 'Toys'),
(4, 'Star Wars'),
(5, 'Lego'),
(6, 'Jewelry');

-- --------------------------------------------------------

--
-- Table structure for table `categorylist`
--

DROP TABLE IF EXISTS `categorylist`;
CREATE TABLE IF NOT EXISTS `categorylist` (
  `categoryID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`categoryID`,`productID`),
  KEY `categoryID` (`categoryID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categorylist`
--

INSERT INTO `categorylist` (`categoryID`, `productID`) VALUES
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(5, 4),
(5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `genderlist`
--

DROP TABLE IF EXISTS `genderlist`;
CREATE TABLE IF NOT EXISTS `genderlist` (
  `genderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  PRIMARY KEY (`genderID`,`productID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `genderlist`
--

INSERT INTO `genderlist` (`genderID`, `productID`) VALUES
(2, 2),
(1, 3),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `genderID` int(11) NOT NULL AUTO_INCREMENT,
  `genderText` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`genderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`genderID`, `genderText`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(250) NOT NULL,
  `manufacturer` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `cost` int(11) NOT NULL,
  `imageURL` varchar(250) NOT NULL,
  `userID` int(11) NOT NULL,
  `pDateAdded` date NOT NULL,
  `numReports` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`productID`),
  KEY `productName` (`productName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productName`, `manufacturer`, `description`, `cost`, `imageURL`, `userID`, `pDateAdded`, `numReports`) VALUES
(1, 'Air Hogs Star Wars RC X-Wing Starfighter', '', 'Take on the Empire with a Star Wars remote control flying X-wing from Air Hogs. Equipped with ducted propellers and a 2.4GHz communication system for a flying range of 250 feet, the remote control X-wing Starfighter is a Death Star&#039;s worst enemy. Crash-resistant foam body construction protects the X-wing against damage from crash landings.', 2, 'http://multimedia.bbycastatic.ca/multimedia/products/500x500/103/10380/10380188.jpg', 1, '2016-03-01', 0),
(2, 'Air Hogs Star Wars RC Ultimate Millennium Falcon Quadcopter', '', 'Now you can make the Kessel Run in less than 12 parsecs with the Air Hogs Star Wars RC Ultimate Millennium Falcon. It&#039;s powered by 4 quad propellers concealed in the ducts of the ship. Its authentic lights and sounds bring the Millennium Falcon to life as you fly and 2.4GHz communication lets you control it up to 250 feet away.', 4, 'https://multimedia.bbycastatic.ca/multimedia/products/500x500/103/10380/10380190.jpg', 1, '2016-03-01', 0),
(3, 'Air Hogs Star Wars RC Millennium Falcon', '', 'Now you can make the Kessel Run in less than 12 parsecs with the Air Hogs Star Wars RC Millennium Falcon. It&#039;s powered with a single rotor Powercore drive train and the onboard gyro-stabilization provides stable and smooth control. It&#039;s constructed from impact-resistant foam so it can withstand rough landings.', 3, 'https://multimedia.bbycastatic.ca/multimedia/products/500x500/103/10380/10380189.jpg', 1, '2016-03-01', 5),
(4, 'LEGO Star Wars Millennium Falcon', '', 'LEGO Star Wars The Force Awakens Millennium Falcon Set\r\nAnother adventure commences in a galaxy far, far away with the LEGO Star Wars The Force Awakens Millennium Falcon Set. Join old friends, Han Solo and Chewbacca, as well as new friends from The Force Awakens movie, Rey and Finn, as they battle to protect the Millennium Falcon in another fight against the dark side. Lift the hull plates to check out all the new modifications Han and Chewy have been working on, including a holochess board and a more detailed hyperdrive. When the enemy attacks, Rey and Finn quickly grab supplies from the secret compartment below to load the blasters while Han and Chewy try to fix the fried hyperdrive. Firing quick rounds, Rey keeps the enemy at bay as long as she can, but with the enemy bearing down on them, she and Finn decide to leave the ship in the detachable cockpit. Han Solo and Chewbacca must choose to fight for their iconic starship or finally give in to the dark side with this exciting 1,330-piece LEGO set fit for any Star Wars fan.', 5, 'http://www.toysrus.com/graphics/tru_prod_images/LEGO-Star-Wars-Millennium-Falcon--pTRU1-20241710dt.jpg', 1, '2016-03-05', 0),
(5, 'LEGO Star Wars Kylo Ren''s Command Shuttle', '', 'LEGO Star Wars Episode VII Kylo Ren&#039;s Command Shuttle Set\r\nTake control of the First Order with the LEGO Star Wars Episode VII Kylo Ren&#039;s Command Shuttle Set. With opening front, rear and bottom storage bays, wing-mounted, spring-loaded shooters with detachable weapon racks and an extending wing function, there&#039;s no battle too big to confront. Help Kylo Ren and General Hux command the First Order officer, crew members and Stormtrooper through intense battle scenes recreated from The Force Awakens film. With two blaster pistols, a blaster and Kylo Ren&#039;s lightsaber, the First Order squad is ready for attack. This 1,005-piece set enables countless battles and reenactments of epic scenes from the Star Wars film.', 4, 'http://www.toysrus.com/graphics/media/trus/Aplusplus/2015/10_22_15/57582706/lego-star-wars-episode-vii-kylo-rens-command-shuttle-set-57582706-01.jpg', 1, '2016-03-05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reportproduct`
--

DROP TABLE IF EXISTS `reportproduct`;
CREATE TABLE IF NOT EXISTS `reportproduct` (
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `reportingtype` int(11) NOT NULL,
  `pReportDate` date NOT NULL,
  PRIMARY KEY (`userID`,`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reporttype`
--

DROP TABLE IF EXISTS `reporttype`;
CREATE TABLE IF NOT EXISTS `reporttype` (
  `reporttypeID` int(11) NOT NULL AUTO_INCREMENT,
  `reportype` varchar(50) NOT NULL,
  PRIMARY KEY (`reporttypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `reporttype`
--

INSERT INTO `reporttype` (`reporttypeID`, `reportype`) VALUES
(1, 'Inappropriate Language'),
(2, 'Inappropriate Product'),
(3, 'Inappropriate Image'),
(4, 'Spam');

-- --------------------------------------------------------

--
-- Table structure for table `reportuser`
--

DROP TABLE IF EXISTS `reportuser`;
CREATE TABLE IF NOT EXISTS `reportuser` (
  `reporteduserID` int(11) NOT NULL,
  `reportinguserID` int(11) NOT NULL,
  `reportingtype` int(11) NOT NULL,
  `uReportDate` date NOT NULL,
  PRIMARY KEY (`reporteduserID`,`reportinguserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportuser`
--

INSERT INTO `reportuser` (`reporteduserID`, `reportinguserID`, `reportingtype`, `uReportDate`) VALUES
(1, 1, 1, '2016-03-27'),
(1, 2, 1, '2016-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `reviewrating`
--

DROP TABLE IF EXISTS `reviewrating`;
CREATE TABLE IF NOT EXISTS `reviewrating` (
  `reviewID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `helpful` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reviewID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `reviewID` int(11) NOT NULL AUTO_INCREMENT,
  `productID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `reviewTxt` text NOT NULL,
  `reviewRating` int(11) NOT NULL,
  `rDateAdded` date NOT NULL,
  `ownProd` tinyint(4) NOT NULL DEFAULT '0',
  `numReports` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`reviewID`),
  KEY `productID` (`productID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewID`, `productID`, `userID`, `reviewTxt`, `reviewRating`, `rDateAdded`, `ownProd`, `numReports`) VALUES
(1, 1, 1, 'the x-wing starfighter is really cool.You can''t fly this inside. You will need a lot of space for this one. I recently bought this for my son for Christmas and he loves it. The only problem with this plane is that it has slow turns, other than that the x wing starfighter is awesome!', 4, '2016-03-01', 0, 0),
(2, 1, 2, 'My son got the X-wing starfighter for Christmas and he is having a blast! But the only problem is that the my son is having a tough time making it stay in the air and turning.', 3, '2016-03-01', 0, 0),
(6, 2, 1, 'great', 4, '2016-03-12', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `storelist`
--

DROP TABLE IF EXISTS `storelist`;
CREATE TABLE IF NOT EXISTS `storelist` (
  `productID` int(11) NOT NULL,
  `storeID` int(11) NOT NULL,
  `productURL` varchar(250) NOT NULL,
  PRIMARY KEY (`productID`,`storeID`),
  KEY `productID` (`productID`),
  KEY `storeID` (`storeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `storelist`
--

INSERT INTO `storelist` (`productID`, `storeID`, `productURL`) VALUES
(1, 1, 'http://www.bestbuy.ca/en-CA/product/air-hogs-air-hogs-star-wars-rc-x-wing-starfighter-1033352/10380188.aspx'),
(1, 2, 'http://www.toysrus.com/product/index.jsp?productId=57582136'),
(1, 4, 'http://www.walmart.com/ip/Air-Hogs-Star-Wars-Remote-Control-X-Wing-Starfighter/45017595'),
(2, 1, 'http://www.bestbuy.ca/en-CA/product/air-hogs-air-hogs-star-wars-rc-ultimate-millennium-falcon-quadcopter-1033350/10380190.aspx'),
(3, 1, 'http://www.bestbuy.ca/en-CA/product/air-hogs-air-hogs-star-wars-rc-millennium-falcon-1033351/10380189.aspx'),
(3, 2, 'http://www.toysrus.com/product/index.jsp?productId=57106506'),
(4, 2, 'http://www.toysrus.com/product/index.jsp?productId=54946986'),
(5, 2, 'http://www.toysrus.com/product/index.jsp?productId=57582706');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
CREATE TABLE IF NOT EXISTS `stores` (
  `storeID` int(11) NOT NULL AUTO_INCREMENT,
  `storeName` varchar(150) NOT NULL,
  `storeURL` varchar(250) NOT NULL,
  `thumbnail` varchar(250) NOT NULL,
  PRIMARY KEY (`storeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`storeID`, `storeName`, `storeURL`, `thumbnail`) VALUES
(1, 'Best Buy', 'http://www.bestbuy.ca/', 'http://images.bbycastatic.ca/sf/companyinfo/pressroom/assets/bby_download_logo.gif'),
(2, 'Toysrus', 'http://www.toysrus.com/', 'http://www.toysrusinc.com/assets/images/site/tru_sample-160x45.jpg'),
(4, 'Walmart', 'http://www.walmart.com/', 'http://cdn.corporate.walmart.com/resource/assets-bsp3/images/corp/walmart-logo.64968e7648c4bbc87f823a1eff1d6bc7.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `uDateAdded` date NOT NULL,
  `birth` year(4) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userName` (`userName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1007 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `userName`, `password`, `points`, `uDateAdded`, `birth`, `gender`, `role`, `image`) VALUES
(1, 'markcrookr@gmail.com', 'mcrook', 'fb9ca3a91288f20d8918b73f87f1b1254d9f52e3', 0, '2016-03-01', 1973, NULL, 1, ''),
(2, 'test1@email.com', 'test1', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-01', 2000, NULL, 0, ''),
(3, 'test2@email.com', 'test2', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-01', 2001, NULL, 0, ''),
(1000, 'test3@email.com', 'test3', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-05', 2006, NULL, 0, ''),
(1002, 'capncrook@yahoo.com', 'Crook', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-12', 1973, NULL, 0, ''),
(1005, 'test666@email.com', 'test666', 'test1234', 0, '2016-03-25', 1973, NULL, 0, ''),
(1006, 'test6@email.com', 'Crook', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-27', 1973, NULL, 0, '');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `userRegDate`;
DELIMITER //
CREATE TRIGGER `userRegDate` BEFORE INSERT ON `users`
 FOR EACH ROW SET NEW.uDateAdded = curdate()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `wDateAdded` date NOT NULL,
  PRIMARY KEY (`userID`,`productID`),
  KEY `userID` (`userID`),
  KEY `productID` (`productID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`userID`, `productID`, `notes`, `wDateAdded`) VALUES
(1, 1, 'Qty 2\nRed', '2016-03-01'),
(1, 2, '', '2016-03-12'),
(1, 3, '', '2016-03-12'),
(1, 4, '', '2016-03-11');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agelist`
--
ALTER TABLE `agelist`
  ADD CONSTRAINT `agelist_ibfk_1` FOREIGN KEY (`ageID`) REFERENCES `ages` (`ageID`),
  ADD CONSTRAINT `agelist_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `categorylist`
--
ALTER TABLE `categorylist`
  ADD CONSTRAINT `categorylist_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`catID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `categorylist_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `genderlist`
--
ALTER TABLE `genderlist`
  ADD CONSTRAINT `genderlist_ibfk_1` FOREIGN KEY (`genderID`) REFERENCES `genders` (`genderID`),
  ADD CONSTRAINT `genderlist_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `reviewrating`
--
ALTER TABLE `reviewrating`
  ADD CONSTRAINT `reviewrating_ibfk_1` FOREIGN KEY (`reviewID`) REFERENCES `reviews` (`reviewID`),
  ADD CONSTRAINT `reviewrating_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `storelist`
--
ALTER TABLE `storelist`
  ADD CONSTRAINT `storelist_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`),
  ADD CONSTRAINT `storelist_ibfk_2` FOREIGN KEY (`storeID`) REFERENCES `stores` (`storeID`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
