-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2016 at 05:37 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `info230_SP16_rdo26sp16`
--

-- --------------------------------------------------------

--
-- Table structure for table `Photos`
--

CREATE TABLE IF NOT EXISTS `Photos` (
  `pID` int(11) NOT NULL,
  `PhotoName` varchar(32) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `date_taken` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Photos`
--

INSERT INTO `Photos` (`pID`, `PhotoName`, `caption`, `image_url`, `date_taken`) VALUES
(1, 'Overlooking Cornell', 'Aerial view of the Cornell campus and Cayuga Lake', 'Images/OverlookingCornell.jpg', '2016-05-29'),
(2, 'Overlooking Ho Plaza', 'View of Ho Plaza with the famous McGraw Tower', 'Images/OverlookingHoPlaza.jpg', '2015-09-17'),
(3, 'Cornell University Entrance Sign', 'A popular location for Cornell visitors!', 'Images/CUEntranceSign.jpg', '2013-07-08'),
(4, 'Overlooking the Arts Quad', 'With Ezra Cornell!', 'Images/CUArtsQuad.jpg', '2016-06-02'),
(5, 'Ho Plaza in the wintertime', 'Students make their way to class regardless of the weather', 'Images/HoPlazaWinter.jpg', '2016-01-31'),
(6, 'George Washington', 'First President of the U.S.', 'Images/GeorgeWashington.jpg', '1789-02-04'),
(7, 'Albert Einstein', 'Voted "Person of the Century" by Time Magazine in 2000', 'Images/AlbertEinstein', '1999-12-31'),
(8, 'Ezra Cornell', 'Co-founder of Cornell University!', 'Images/EzraCornell.jpg', '1865-04-27'),
(9, 'Neil deGrasse Tyson', 'Director of the Hayden Planetarium', 'Images/NeilDeGrasseTyson.jpg', '2016-03-14'),
(10, 'Will Smith', 'The Fresh Prince of Bel-Air', 'Images/WillSmith.jpg', '2014-08-09'),
(11, 'Superman', 'Alter ego: Clark Kent', 'Images/Superman.png', '1938-04-18'),
(12, 'Spiderman', 'Alter ego: Peter Parker', 'Images/Spiderman.png', '1962-08-01'),
(13, 'Wonder Woman', 'Alto ego: Diana Prince', 'Images/Wonderwoman.png', '1941-12-01'),
(14, 'Batman', 'Alto ego: Bruce Wayne', 'Images/Batman.png', '1939-05-01'),
(15, 'Ironman', 'Alto ego: Tony Stark', 'Images/Ironman.png', '1963-03-01'),
(16, 'New York City', 'Overlooking Manhatten', 'Images/NYC.jpg', '2012-10-03'),
(17, 'London', 'Overlooking The River Thames and Big Ben', 'Images/London.jpg', '2015-09-29'),
(18, 'Paris', 'Overlooking The Eiffel Tower', 'Images/Paris.jpg', '2015-04-08'),
(19, 'Sydney', 'Overlooking The Sydney Opera House', 'Images/Sydney.jpg', '2013-11-13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Photos`
--
ALTER TABLE `Photos`
  ADD PRIMARY KEY (`pID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
