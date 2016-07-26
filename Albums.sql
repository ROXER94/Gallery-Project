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
-- Table structure for table `Albums`
--

CREATE TABLE IF NOT EXISTS `Albums` (
  `aID` int(11) NOT NULL,
  `AlbumName` varchar(32) NOT NULL,
  `AlbumDescription` varchar(255) NOT NULL,
  `date_created` date NOT NULL,
  `date_modified` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Albums`
--

INSERT INTO `Albums` (`aID`, `AlbumName`, `AlbumDescription`, `date_created`, `date_modified`) VALUES
(1, 'Cornell', 'An album depicting everything Cornell!', '2016-07-01', '2016-07-26'),
(2, 'Historical People', 'An album featuring prominent historical figures', '2016-07-02', '2016-07-26'),
(3, 'Superheroes!', 'An album containing fictional superheroes', '2016-07-02', '2016-07-26'),
(4, 'Cities', 'An album highlighting the landscape of cities', '2016-07-26', '2016-07-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Albums`
--
ALTER TABLE `Albums`
  ADD PRIMARY KEY (`aID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
