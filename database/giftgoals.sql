-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 30, 2016 at 04:36 PM
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
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(6, 15),
(7, 15),
(6, 16),
(6, 24),
(7, 24),
(6, 40),
(4, 41),
(5, 41),
(6, 41),
(4, 49),
(5, 49),
(6, 49),
(6, 55),
(7, 55),
(4, 56),
(5, 56),
(6, 56),
(4, 57),
(5, 57),
(6, 57),
(6, 58),
(7, 58);

-- --------------------------------------------------------

--
-- Table structure for table `ages`
--

DROP TABLE IF EXISTS `ages`;
CREATE TABLE IF NOT EXISTS `ages` (
  `ageID` int(11) NOT NULL AUTO_INCREMENT,
  `ageText` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ages`
--

INSERT INTO `ages` (`ageID`, `ageText`) VALUES
(1, 'Baby'),
(2, 'Toddler'),
(3, 'Kids'),
(4, 'Teen'),
(5, 'Young Adult'),
(6, 'Adult'),
(7, 'Senior');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `catName`) VALUES
(1, 'Boys'),
(2, 'Girls'),
(3, 'Toys'),
(4, 'Star Wars'),
(5, 'Lego'),
(6, 'Jewelry'),
(7, 'Accessories'),
(8, 'Automotive'),
(9, 'Clothes'),
(10, 'House & Home'),
(11, 'Makeup'),
(12, 'Outdoor'),
(13, 'Stationary'),
(14, 'Tech'),
(15, 'Tools'),
(16, 'Video Games');

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
(1, 41),
(1, 56),
(1, 57),
(2, 41),
(2, 49),
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
(5, 5),
(8, 16),
(9, 49),
(9, 55),
(9, 56),
(9, 57),
(10, 15),
(10, 24),
(10, 40),
(10, 41),
(10, 58),
(12, 14),
(12, 52),
(12, 53),
(12, 57),
(12, 58),
(14, 41),
(15, 14),
(15, 55);

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
(3, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(1, 5),
(2, 5),
(3, 14),
(2, 15),
(1, 16),
(3, 24),
(1, 40),
(1, 41),
(2, 41),
(2, 49),
(1, 55),
(2, 55),
(1, 56),
(1, 57),
(1, 58),
(2, 58);

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
CREATE TABLE IF NOT EXISTS `genders` (
  `genderID` int(11) NOT NULL AUTO_INCREMENT,
  `genderText` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`genderID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`genderID`, `genderText`) VALUES
(1, 'Male'),
(2, 'Female'),
(3, 'Non Specific');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productName`, `manufacturer`, `description`, `cost`, `imageURL`, `userID`, `pDateAdded`, `numReports`) VALUES
(1, 'Air Hogs Star Wars RC X-Wing Starfighter', '', 'Take on the Empire with a Star Wars remote control flying X-wing from Air Hogs. Equipped with ducted propellers and a 2.4GHz communication system for a flying range of 250 feet, the remote control X-wing Starfighter is a Death Star&#039;s worst enemy. Crash-resistant foam body construction protects the X-wing against damage from crash landings.', 2, 'http://multimedia.bbycastatic.ca/multimedia/products/500x500/103/10380/10380188.jpg', 1, '2016-03-01', 0),
(2, 'Air Hogs Star Wars RC Ultimate Millennium Falcon Quadcopter', '', 'Now you can make the Kessel Run in less than 12 parsecs with the Air Hogs Star Wars RC Ultimate Millennium Falcon. It&#039;s powered by 4 quad propellers concealed in the ducts of the ship. Its authentic lights and sounds bring the Millennium Falcon to life as you fly and 2.4GHz communication lets you control it up to 250 feet away.', 4, 'https://multimedia.bbycastatic.ca/multimedia/products/500x500/103/10380/10380190.jpg', 1, '2016-03-01', 0),
(3, 'Air Hogs Star Wars RC Millennium Falcon TEST', '', 'Now you can make the Kessel Run in less than 12 parsecs with the Air Hogs Star Wars RC Millennium Falcon. It''s powered with a single rotor Powercore drive train and the onboard gyro-stabilization provides stable and smooth control. It''s constructed from impact-resistant foam so it can withstand rough landings.', 3, 'https://multimedia.bbycastatic.ca/multimedia/products/500x500/103/10380/10380189.jpg', 1, '2016-03-01', 0),
(4, 'LEGO Star Wars Millennium Falcon', '', 'LEGO Star Wars The Force Awakens Millennium Falcon Set\r\nAnother adventure commences in a galaxy far, far away with the LEGO Star Wars The Force Awakens Millennium Falcon Set. Join old friends, Han Solo and Chewbacca, as well as new friends from The Force Awakens movie, Rey and Finn, as they battle to protect the Millennium Falcon in another fight against the dark side. Lift the hull plates to check out all the new modifications Han and Chewy have been working on, including a holochess board and a more detailed hyperdrive. When the enemy attacks, Rey and Finn quickly grab supplies from the secret compartment below to load the blasters while Han and Chewy try to fix the fried hyperdrive. Firing quick rounds, Rey keeps the enemy at bay as long as she can, but with the enemy bearing down on them, she and Finn decide to leave the ship in the detachable cockpit. Han Solo and Chewbacca must choose to fight for their iconic starship or finally give in to the dark side with this exciting 1,330-piece LEGO set fit for any Star Wars fan.', 5, 'http://www.toysrus.com/graphics/tru_prod_images/LEGO-Star-Wars-Millennium-Falcon--pTRU1-20241710dt.jpg', 1, '2016-03-05', 0),
(5, 'LEGO Star Wars Kylo Ren''s Command Shuttle', '', 'LEGO Star Wars Episode VII Kylo Ren&#039;s Command Shuttle Set\r\nTake control of the First Order with the LEGO Star Wars Episode VII Kylo Ren&#039;s Command Shuttle Set. With opening front, rear and bottom storage bays, wing-mounted, spring-loaded shooters with detachable weapon racks and an extending wing function, there&#039;s no battle too big to confront. Help Kylo Ren and General Hux command the First Order officer, crew members and Stormtrooper through intense battle scenes recreated from The Force Awakens film. With two blaster pistols, a blaster and Kylo Ren&#039;s lightsaber, the First Order squad is ready for attack. This 1,005-piece set enables countless battles and reenactments of epic scenes from the Star Wars film.', 4, 'http://www.toysrus.com/graphics/media/trus/Aplusplus/2015/10_22_15/57582706/lego-star-wars-episode-vii-kylo-rens-command-shuttle-set-57582706-01.jpg', 1, '2016-03-05', 0),
(14, 'Husqvarna Chainsaw Chaps', 'Husqvarna', 'Chainsaw Safety Chaps are extremely light weight apron chaps with five layers of warp knit Kevmalimo chainsaw protection on the front and sides\r\nHas a 36 to 38&quot; overall length from the waist to ankle\r\nMade with a 400 Denier shell\r\nMeets BNQ/CUL class B certification\r\nIncludes a tool pocket\r\nMachine washable and available in navy blue only', 0, 'http://www.treestuff.com/store/images/products/large/1121.jpg', 1031, '2016-04-13', 0),
(15, 'Meyer Lemon Tree', 'Mother Nature', 'A simple gift for your special mom on Mother\\''s Day! The ever popular Meyer Lemon in a bright red pot is the perfect paring for that perfect mom. The well-known Bearss Lime in a bright pink pot will bring a smile to the mom in your life.\r\nBoth are easy to grow and can remain in their decorative pots for the season and then transplanted into a 12 inch pot inch pots in the fall.', 0, './thumbnails/A_gift_idea_for__56b540956938f_192x142[1].jpg', 1031, '2016-04-13', 0),
(16, 'F-150 Running Boards', 'Lund', 'Supercrew, black, curved bar.', 0, './thumbnails/lund-5-inch-oval-nerf-bars[1].jpg', 1031, '2016-04-13', 0),
(24, 'Keurig K200', 'Keurig', 'A small - 4 cup Keurig machine', 0, './thumbnails/keurig.jpg', 1033, '2016-04-16', 0),
(40, 'Stihl gas powered grass trimmer FS 38', 'Stihl', 'The FS 38 is a lightweight gas powered grass trimmer for homeowner use.', 0, './images/stihl.jpg', 1033, '2016-04-17', 0),
(41, 'Bose Soundlink Colour Bluetooth Speaker', 'Bose', 'The Bose SoundLink Color Bluetooth Speaker delivers incredible sound in a small, compact speaker design. This powerful speaker is portable and wireless, so you can bring your favourite music wherever you go thanks to Bluetooth connectivity. The rechargeable battery lasts up to 8 hours on a single charge so the party never has to stop.', 0, './images/bose.jpg', 1033, '2016-04-17', 0),
(49, 'Wunder Under Pant III *Full-On Luxtreme', 'Lululemon', 'These no-fuss, versatile pants were designed to fit like a second skin&mdash;they\\''re perfect for yoga or the gym.', 0, './images/lulu.jpg', 1034, '2016-04-18', 0),
(52, 'Pocket Chain Saw', '', 'Although compact, lightweight and portable, this surprisingly rugged tool can efficiently cut through a 3&quot; diameter tree branch in 60 seconds using a simple seesaw technique. Its size and flexibility make it particularly adaptable for sawing at odd angles or in tight, awkward spaces &ndash; root removal in trenches, clearing brush from fences and trimming in corners, for example.\r\n\r\nThe chain saw is 38&quot; long with a 20-1/2&quot; long blade and ergonomic handles. The 92 bi-directional 1/2&quot; high teeth are hardened high-strength steel with a rust-resistant coating. They rarely require sharpening, but if they do, use a fine-toothed flat file. The chain saw coils into a compact size that fits into an included 3-3/4&quot; x 1-3/4&quot; x 4-1/2&quot; carrying case with a sewn belt loop.\r\n\r\nThe tool and case together weigh 7-1/2 oz. Instructions included.', 0, './images/09A0380i.jpg', 1020, '2016-04-19', 0),
(53, 'Belt Axe', '', 'Both functional and attractive, the \\&quot;bearded\\&quot; design of this axe lets you grip the handle directly behind the cutting edge to make shavings for a quick fire, to rough out a carving, or even to skin dinner.\r\n\r\nThe head is cast from 440C stainless steel, with a 4-1/2\\&quot; blade ground and polished to a beautiful edge. It doubles beautifully as both axe and knife. The laminated birch handle is curved for easy gripping and good balance.\r\n\r\nComes in a grain leather sheath with double-snap closure and a swivelling belt loop. Weighs less than 2 lb. The ultimate outdoor accessory.\r\n\r\nMade in USA.', 0, './images/45k1655s4[1].jpg', 1020, '2016-04-19', 0),
(55, 'Nothing Runs Like a Deere Pewter Buckle', 'John Deere', '\\&quot;Nothing Runs Like a Deere\\&quot; Fine Pewter Buckle', 0, './images/lp14141[1].jpg', 1036, '2016-04-24', 0),
(56, 'Chicken Butt T-Shirt', '6DollarShirts', 'Why did the chicken cross the road? Because people keep making this joke!\r\n\r\n&bull; Professionally printed silkscreen.\r\n&bull; 100% cotton tee (heathers poly-cotton).\r\n&bull; Ships within 2 business days.\r\n&bull; Designed and printed in the USA.', 0, './images/Chicken_Butt_t_shirt_kellygreen[1].jpg', 1036, '2016-04-24', 0),
(57, 'Patagonia Men\\''s Stretch Wavefarer Board Short', 'Patagonia', 'The Patagonia Men\\''s Stretch Wavefarer Board Short is stretchy for maximized movement and mobility. So you can move around as much as you physically can and not have a wardrobe malfunction. The inseam is designed to prevent chafing and the material is water-repellant. The Stretch Wavefarer also has 40 UPF sun protection shielding your buns and thighs from the sun\\''s rays. It has a key loop to keep your keys where you put them. Just don\\''t lock them in your car.', 0, './images/10206366x1120310_zm[1].jpg', 1036, '2016-04-24', 0),
(58, 'Yeti Tundra 125 Cooler', 'Yeti', 'The YETI Tundra 125 Cooler is a large cooler for hauling drinks, food and plenty of ice. Family camping for a few weeks, vacations that start off with a mega car trip, or just hunting and fishing for days on end. The Permafrost&trade; insulation surrounds the necessary ice to keep it mighty cold, so the sustenance you tuck inside stays fresh and cold. Doublehaul&trade; handles make it easy to move from truck bed to chillin\\'' near the fire, but you should totally make your friend help you carry this mighty beast. When you\\''re not fishing a cold drink out from the inside, keep the lid closed and use it as a seat to tie your boots or just kick back and rest.', 0, './images/10276680x1010868_zm[1].jpg', 1036, '2016-04-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reportproduct`
--

DROP TABLE IF EXISTS `reportproduct`;
CREATE TABLE IF NOT EXISTS `reportproduct` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `pReportDate` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `reportreview`
--

DROP TABLE IF EXISTS `reportreview`;
CREATE TABLE IF NOT EXISTS `reportreview` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reportedReviewID` int(11) NOT NULL,
  `reportinguserID` int(11) NOT NULL,
  `rReportDate` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

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

--
-- Dumping data for table `reviewrating`
--

INSERT INTO `reviewrating` (`reviewID`, `userID`, `helpful`) VALUES
(1, 1020, 1),
(1, 1028, 1),
(2, 1020, 1),
(2, 1023, 1),
(9, 1020, 1),
(11, 1021, 1),
(14, 1021, 1),
(14, 1031, 1),
(17, 1027, 1),
(17, 1033, 1),
(21, 1036, 1),
(22, 1034, 1),
(22, 1036, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`reviewID`, `productID`, `userID`, `reviewTxt`, `reviewRating`, `rDateAdded`, `ownProd`, `numReports`) VALUES
(1, 1, 1, 'the x-wing starfighter is really cool.You can''t fly this inside. You will need a lot of space for this one. I recently bought this for my son for Christmas and he loves it. The only problem with this plane is that it has slow turns, other than that the x wing starfighter is awesome!', 4, '2016-03-01', 0, 0),
(2, 1, 2, 'My son got the X-wing starfighter for Christmas and he is having a blast! But the only problem is that the my son is having a tough time making it stay in the air and turning.', 3, '2016-03-01', 0, 0),
(9, 1, 1020, 'OK ', 3, '2016-04-05', 0, 0),
(11, 2, 1020, 'We love its durability, it has a decent run time and tons of fun. Really great drone for our first. Great product.', 5, '2016-04-10', 1, 0),
(12, 3, 1020, '10/10 would play with', 4, '2016-04-12', 1, 0),
(13, 2, 1021, '10/10 would play with', 4, '2016-04-12', 1, 0),
(14, 14, 1031, 'I need these!', 5, '2016-04-13', 0, 0),
(15, 15, 1031, 'So far so good. No lemons yet, but it\\''s pretty new and it hasn\\''t died, so... success!', 5, '2016-04-13', 1, 0),
(16, 40, 1033, 'This thing is awesome. Starts every time and is nicely balanced. It\\''s a bit heavy because it\\''s gas, but compared to my old electric one, it\\''s so much fun to use. Very powerful and no cord to deal with. Love it!', 5, '2016-04-17', 1, 0),
(17, 41, 1033, 'This has been great for our family. Easily connects all our phones and sounds awesome. The bass is much better than you think it\\''s going to be. You won\\''t regret buying this.', 5, '2016-04-17', 1, 0),
(18, 49, 1034, 'These are my absolute favorite pants!!', 5, '2016-04-18', 1, 0),
(19, 15, 1021, 'I started up my own lemon shop because of this tree. It makes lemons like there\\''s no tomorrow!', 5, '2016-04-18', 1, 0),
(20, 41, 1027, 'I had a chance to test this speaker in Best Buy. And you know what? I think I\\''m going to to buy it as a gift for my nephew.', 5, '2016-04-18', 0, 0),
(21, 52, 1020, 'Great little tool around the house and in the garden but also for camping.', 5, '2016-04-19', 1, 0),
(22, 53, 1020, 'Very expensive (now even more than when I got mine) but it is a great little hatchet.', 4, '2016-04-19', 1, 0),
(24, 41, 1039, 'big sound from little speaker', 4, '2016-04-20', 0, 0),
(25, 41, 1040, 'Love the colour choices!', 4, '2016-04-20', 0, 0);

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
(1, 11, 'https://www.amazon.ca/Air-Hogs-Star-X-Wing-Starfighter/dp/B018VNNGCG/ref=sr_1_1?ie=UTF8&amp;qid=1460677083&amp;sr=8-1&amp;keywords=Air+Hogs+Star+Wars+RC+X-Wing+Starfighter'),
(2, 1, 'http://www.bestbuy.ca/en-CA/product/air-hogs-air-hogs-star-wars-rc-ultimate-millennium-falcon-quadcopter-1033350/10380190.aspx'),
(3, 1, 'http://www.bestbuy.ca/en-CA/product/air-hogs-air-hogs-star-wars-rc-millennium-falcon-1033351/10380189.aspx'),
(3, 2, 'http://www.toysrus.com/product/index.jsp?productId=57106506'),
(4, 2, 'http://www.toysrus.com/product/index.jsp?productId=54946986'),
(5, 2, 'http://www.toysrus.com/product/index.jsp?productId=57582706'),
(14, 7, 'http://www.canadiantire.ca/en/pdp/husqvarna-chainsaw-safety-chaps-0545662p.html'),
(15, 8, 'https://www.fourwindsgrowers.com/store/other-edibles.html?page=shop.product_details&amp;flypage=flypage.tpl&amp;category_id=26&amp;product_id=377'),
(16, 9, 'https://www.realtruck.com/lund-5-oval-nerf-bars/R183635P2014Y212MA.html'),
(24, 4, 'http://www.walmart.ca/en/ip/keurig-20-brewing-system-k200-black/6000191647258?cmpid=PPC_Google_Google-Shopping_PLA_EN_6000191647258_100182107432668_1939&amp;amp;gclid=CLb4jMGAjswCFdBZhgodKZ8Grg'),
(40, 32, 'http://en.stihl.ca/STIHL-Products/Grass-trimmers-brushcutters-and-clearing-saws/Grass-trimmers/2661-210/FS-38.aspx'),
(41, 1, 'http://www.bestbuy.ca/en-CA/product/bose-bose-soundlink-color-bluetooth-speaker-blue-soundlink-bt-spk-blu/10323542.aspx'),
(49, 33, 'http://shop.lululemon.com/products/clothes-accessories/pants-yoga/Wunder-Under-Pant-III-Fullux?cc=0001&skuId=3657241&catId=pants-yoga'),
(52, 34, 'http://www.leevalley.com/en/wood/page.aspx?p=72075&cat=1,41131'),
(53, 34, 'http://www.leevalley.com/en/garden/page.aspx?p=44448&cat=2,44728,44448'),
(55, 36, 'http://www.anrdoezrs.net/links/8057000/type/dlg/http://www.rungreen.com/nothing-runs-like-a-deere-pewter-buckle.html'),
(56, 37, 'http://www.tkqlhce.com/click-8056999-12131274-1452033069000'),
(57, 38, 'http://www.anrdoezrs.net/click-8056999-10386385-1412735576000?url=http%3A%2F%2Fwww.moosejaw.com%2Fmoosejaw%2Fshop%2Fproduct_Patagonia-Men-s-Stretch-Wavefarer-Board-Short_10206366____&cjsku=2850022'),
(58, 38, 'http://www.anrdoezrs.net/click-8056999-10386385-1412735576000?url=http%3A%2F%2Fwww.moosejaw.com%2Fmoosejaw%2Fshop%2Fproduct_YETI-Tundra-125-Cooler_10276680____&cjsku=2480354');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`storeID`, `storeName`, `storeURL`, `thumbnail`) VALUES
(1, 'Best Buy', 'http://www.bestbuy.ca/', 'http://images.bbycastatic.ca/sf/companyinfo/pressroom/assets/bby_download_logo.gif'),
(2, 'Toysrus', 'http://www.toysrus.com/', 'http://www.toysrusinc.com/assets/images/site/tru_sample-160x45.jpg'),
(4, 'Walmart', 'http://www.walmart.com/', 'http://cdn.corporate.walmart.com/resource/assets-bsp3/images/corp/walmart-logo.64968e7648c4bbc87f823a1eff1d6bc7.png'),
(7, 'Canadian Tire', 'http://www.canadiantire.ca', 'http://canadiantire.scene7.com/is/image/CanadianTire/logotype?wid=297&hei=166'),
(8, 'Fourwindsgrowers.com', 'www.fourwindsgrowers.com', 'img/seller.png'),
(9, 'Realtruck.com', 'www.realtruck.com', 'img/seller.png'),
(11, 'Amazon.ca', 'http://www.amazon.ca', 'https://images-na.ssl-images-amazon.com/images/G/15/gno/images/general/navAmazonLogoFooter._CB169459397_.gif'),
(32, 'Stihl', '', 'img/seller.png'),
(33, 'Lululemon', 'http://shop.lululemon.com/', 'http://images.lululemon.com/is/image/lululemon/ui-logo?$pngstandard$'),
(34, 'Lee Valley Tools', 'http://www.leevalley.com', './images/leevalley.png'),
(35, 'Mark Store', 'http://www.campcrook.com', 'http://www.campcrook.com/images/sunset1.jpg'),
(36, 'John Deere', 'http://www.anrdoezrs.net/links/8057000/type/dlg/http://www.rungreen.com/', 'http://www.deere.com/en_US/media/corporate_images/citizenship/john_deere_inspire/green_yellow_vert_logo.jpg'),
(37, '6DollarShirts', 'http://www.tkqlhce.com/click-8056999-12131274-1452033069000', 'http://6dollar.threadpitinc.netdna-cdn.com/skin1/images/6dollarshirts_logo_reg.gif'),
(38, 'Moosejaw', 'http://www.jdoqocy.com/click-8056999-10386385-1412735576000?url=http%3A%2F%2Fwww.moosejaw.com', 'http://cdn-us-ec.yottaa.net/53c6d66786305e30e100018d/www.moosejaw.com/v~12.f8/wcsstore/AuroraStorefrontAssetStore/Attachment/MJmainLogo.jpg?yocs=21_25_&yoloc=us');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `uDateAdded` date NOT NULL,
  `birth` year(4) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '0',
  `image` varchar(250) NOT NULL,
  PRIMARY KEY (`userID`),
  KEY `userName` (`userName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1048 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `email`, `userName`, `password`, `points`, `uDateAdded`, `birth`, `gender`, `role`, `image`) VALUES
(1, 'markcrookr@gmail.com', 'mcrook', 'fb9ca3a91288f20d8918b73f87f1b1254d9f52e3', 103, '2016-03-01', 1973, NULL, 1, ''),
(2, 'test1@email.com', 't1', '593dbb55ce1157538e83bd3dcad2781037564290', 6, '2016-03-01', 2000, NULL, 0, ''),
(3, 'test2@email.com', 'test2', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-01', 2001, NULL, 0, ''),
(1000, 'test3@email.com', 'test3', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-05', 2006, NULL, 0, ''),
(1002, 'capncrook@yahoo.com', 'Crook', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-12', 1973, NULL, 0, ''),
(1005, 'test666@email.com', 'test666', 'test1234', 0, '2016-03-25', 1973, NULL, 0, ''),
(1006, 'test6@email.com', 'Crook', '593dbb55ce1157538e83bd3dcad2781037564290', 0, '2016-03-27', 1973, NULL, 0, ''),
(1007, 'a@a.a', 'some Name', 'aaa123', 0, '2016-03-29', 2016, NULL, 0, 'http://placehold.it/150x150'),
(1008, 'a@a.a', 'some Name', 'aaa', 0, '2016-03-29', 2016, NULL, 0, 'http://placehold.it/150x150'),
(1009, 'z@z.z', 'zzz', 'zzz', 0, '2016-03-29', 0000, NULL, 0, 'http://placehold.it/150x150'),
(1010, 'b@b.c', 'bbb', 'bbb', 0, '2016-03-29', 0000, NULL, 0, 'http://placehold.it/150x150'),
(1012, 'chikashikaari@gmail.com', 'Taras Kubrak', 'randomPassword', 0, '2016-03-29', 0000, 'male', 0, '//graph.facebook.com/772353682868641/picture?height=150&width=150'),
(1013, 'test7@email.com', 'mcrook666', 'Test1234%', 0, '2016-03-29', 1973, NULL, 0, 'http://placehold.it/150x150'),
(1014, 'hassan.m94@hotmail.com', 'Hassan', 'abcd1234', 0, '2016-03-30', 1994, NULL, 0, 'http://placehold.it/150x150'),
(1015, 'a', 'Taras Kubrak', 'randomPassword', 0, '2016-03-30', 1901, 'male', 0, '//graph.facebook.com/772353682868641/picture?height=150&width=150'),
(1017, 'test8@email.com', 'test8', 'Test1234%', 0, '2016-03-30', 1955, NULL, 0, 'http://placehold.it/150x150'),
(1020, '1034619299918271', 'Mark Crook', 'randomPassword', 38, '2016-03-30', 1901, 'male', 1, '//graph.facebook.com/1034619299918271/picture?height=150&width=150'),
(1021, '10156669288425543', 'Hassan Mohammad', 'randomPassword', 1340, '2016-04-01', 1901, 'male', 1, '//graph.facebook.com/10156669288425543/picture?height=150&width=150'),
(1023, 'testuser@giftgoals.ca', 'testuser', 'password1', 1500, '2016-04-06', 1994, 'male', 0, ''),
(1025, '10154011260155126', 'Sheila Galbraith', 'randomPassword', 0, '2016-04-10', 1901, 'female', 0, '//graph.facebook.com/10154011260155126/picture?height=150&width=150'),
(1026, 'bla@bla.com', 'bla', '$2a$09$jLSvGh1mFkVIoQXzn5gYsuNz8636RMyvmNfvOnQ8/qMZVA6qVzYry', 0, '2016-04-12', 1998, NULL, 0, 'img/user.png'),
(1027, '772353682868641', 'Taras Kubrak', '$2a$09$fuBGORr9y2NCPT14iJ78eesEk/9t0a/MGE2xz9UElu7g.0XHi5rki', 3, '2016-04-12', 1901, 'male', 1, '//graph.facebook.com/772353682868641/picture?height=150&width=150'),
(1028, 'test@a.com', 'test', '$2a$09$jLSvGh1mFkVIoQXzn5gYsu9YI.sPFTEquOiTSgQJsS5HcEfUrXpEW', 0, '2016-04-12', 1998, NULL, 0, 'img/user.png'),
(1029, '10209550698509540', 'Brandon Tran', '$2a$09$I9TLV0YmZqGrOzJho2vj6OkIBIUydUDWV.9yyXg8VlNrVITJw6GDC', 0, '2016-04-12', 1901, 'male', 0, '//graph.facebook.com/10209550698509540/picture?height=150&width=150'),
(1030, 'tacos@tacobell.com', 'ILoveTacos', '$2a$09$jLSvGh1mFkVIoQXzn5gYsuAWn6ba2HG5tGWRmiU7YBHUyDZ4Nhwsa', 0, '2016-04-12', 1994, NULL, 0, 'img/user.png'),
(1031, '10153965849875225', 'Craig Donnelly', '$2a$09$UwmMpoE9HtdxzrLiTa53jO2ike6fOvHCicGCSU8DNk4zrSd0qGfNO', 7, '2016-04-12', 1901, 'male', 1, '//graph.facebook.com/10153965849875225/picture?height=150&width=150'),
(1033, 'craigger@craigger.com', 'craigger', '$2a$09$jLSvGh1mFkVIoQXzn5gYsu.dfrV/LN7isnsXHYiTC39PwqiYnOeeu', 7, '2016-04-16', 1969, NULL, 0, 'img/user.png'),
(1034, 'iamcallie@hotmail.com', 'CalDonz', '$2a$09$jLSvGh1mFkVIoQXzn5gYsu.dfrV/LN7isnsXHYiTC39PwqiYnOeeu', 3, '2016-04-17', 1999, NULL, 0, 'img/user.png'),
(1035, 'ac@ac.ca', 'ac', '$2a$09$jLSvGh1mFkVIoQXzn5gYsub4k7znzqk7Z1HC31I6bbyOyvPuiX2Zi', 1, '2016-04-18', 1995, NULL, 0, 'img/user.png'),
(1036, '10153982032015225', 'Craig Donnelly', '$2a$09$QHxNvMSqfXOsA5pLW2K1PuUJAtIPCbGw.IFWLE1KxJkBRZxlC6ski', 4, '2016-04-20', 1901, 'male', 1, '//graph.facebook.com/10153982032015225/picture?height=150&width=150'),
(1037, '810811852356157', 'Taras Kubrak', '$2a$09$uIgek2UOvj3GzBQMn6hCPeCG0uCQiEF.sm/uGmJmwBDnzYRH5pq8W', 0, '2016-04-20', 1901, 'male', 0, '//graph.facebook.com/810811852356157/picture?height=150&width=150'),
(1038, '10154035082965126', 'Sheila Galbraith', '$2a$09$n1fAJ3cwzPExtMVDopvdOO/WI/XLnXzKAhn1rFBm6Q7Y5CF2MVq8W', 0, '2016-04-20', 1901, 'female', 0, '//graph.facebook.com/10154035082965126/picture?height=150&width=150'),
(1039, '1047606565286211', 'Mark Crook', '$2a$09$Vgujf6kPbXoZMQzU542ICOHTdTuw6Iva73eA5sYirem7mEHTXWXGa', 1, '2016-04-20', 1901, 'male', 1, '//graph.facebook.com/1047606565286211/picture?height=150&width=150'),
(1040, '10154141794573781', 'Megan Lavin Donovan', '$2a$09$ElbnIFmjc41HfepRSBdCTO559v.fdgR7YOeQI3lS9WKRXoXYQW/CC', 1, '2016-04-20', 1901, 'female', 0, '//graph.facebook.com/10154141794573781/picture?height=150&width=150'),
(1041, '10153962545040590', 'Carolina Arboleda', '$2a$09$k7BxCi3zsV8dY5oJmH1Qc.ad0RjacMCLWIadRBB40VcnXON6.HyG6', 0, '2016-04-20', 1901, 'female', 0, '//graph.facebook.com/10153962545040590/picture?height=150&width=150'),
(1042, '10156755641030543', 'Hassan Mohammad', '$2a$09$DvGYUdM87rl3ZmK2FaXt6..ijRONLC.YB9OuiKDlD3wiRrhifBcOe', 0, '2016-04-20', 1901, 'male', 0, '//graph.facebook.com/10156755641030543/picture?height=150&width=150'),
(1043, '1093240664066319', 'Casey Donnelly', '$2a$09$qH0BwUXb9dNf3oW7nrYaMuhf66fukN24DC9zwlF92sdKbgevnFEPC', 0, '2016-04-20', 1901, 'female', 0, '//graph.facebook.com/1093240664066319/picture?height=150&width=150'),
(1044, '1073617269361491', 'Callie Donnelly', '$2a$09$HSyQnqU2G8Pibw7feAmgaOIFYfqOoEMo9z6Y8S0vXdXNhQ1eCvC1O', 0, '2016-04-20', 1901, 'female', 0, '//graph.facebook.com/1073617269361491/picture?height=150&width=150'),
(1045, '10153379939386541', 'Ashraful Ahamed', '$2a$09$AiLb712OVnWwmQUhSp3zFeD0JGrJ1olL9MYjvcaCk1YEPA5smvRWm', 0, '2016-04-20', 1901, 'male', 0, '//graph.facebook.com/10153379939386541/picture?height=150&width=150'),
(1046, '1761706884116044', 'à¦à¦• à¦†à¦¤à§à¦®à¦¸à¦®à¦°à§à¦ªà¦£à¦•à¦¾à¦°à§€', '$2a$09$eEyfB85mOFdQ4zZ96SPGqeJrCY.FY9nrZSSxiBLbAQhS1JHCAoMra', 0, '2016-04-20', 1901, 'male', 0, '//graph.facebook.com/1761706884116044/picture?height=150&width=150'),
(1047, '10154169625666350', 'Mandi Faulkner Donnelly', '$2a$09$Ju10mZjbkPOepDMBhGQ2yOS4Tza2kQbCRaP9vY5r4EWKUUSIWlnJ2', 0, '2016-04-21', 1901, 'female', 0, '//graph.facebook.com/10154169625666350/picture?height=150&width=150');

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
(1, 4, '', '2016-03-11'),
(1012, 3, '', '2016-03-29'),
(1013, 1, 'Qty 2 so can have dogfight', '2016-03-29'),
(1021, 2, '', '2016-04-06'),
(1023, 2, '', '2016-04-09'),
(1027, 24, 'Interesting ', '2016-04-19'),
(1027, 52, '', '2016-04-19'),
(1031, 2, '', '2016-04-19'),
(1031, 14, '', '2016-04-13'),
(1031, 16, '', '2016-04-13'),
(1040, 41, '', '2016-04-20');

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
