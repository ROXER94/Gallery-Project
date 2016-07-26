-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 26, 2016 at 05:30 PM
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
-- Table structure for table `Relationships`
--

CREATE TABLE IF NOT EXISTS `Relationships` (
  `pID` int(11) NOT NULL,
  `aID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Relationships`
--

INSERT INTO `Relationships` (`pID`, `aID`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 2),
(7, 2),
(8, 2),
(8, 1),
(9, 2),
(10, 2),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 4),
(17, 4),
(18, 4),
(19, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
