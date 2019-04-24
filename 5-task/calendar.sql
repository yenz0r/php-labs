-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 24, 2019 at 08:29 PM
-- Server version: 5.7.25
-- PHP Version: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calendar`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminStatistic`
--

CREATE TABLE `adminStatistic` (
  `id` int(11) NOT NULL,
  `admin` varchar(30) NOT NULL,
  `command` varchar(50) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminStatistic`
--

INSERT INTO `adminStatistic` (`id`, `admin`, `command`, `time`) VALUES
(6, 'admin', 'delete from adminStatistic;', '2019-04-24 20:27:44');

-- --------------------------------------------------------

--
-- Table structure for table `articlesInfo`
--

CREATE TABLE `articlesInfo` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `article_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articlesInfo`
--

INSERT INTO `articlesInfo` (`id`, `name`, `article_text`) VALUES
(1, 'weather', 'Weather is the state of the atmosphere, describing for example the degree to which it is hot or cold, wet or dry, calm or stormy, clear or cloudy. Most weather phenomena occur in the lowest level of the atmosphere, the troposphere, just below the stratosphere.'),
(2, 'nature', 'Nature, in the broadest sense, is the natural, physical, or material world or universe. Nature can refer to the phenomena of the physical world, and also to life in general.');

-- --------------------------------------------------------

--
-- Table structure for table `asking`
--

CREATE TABLE `asking` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `answer` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `asking`
--

INSERT INTO `asking` (`id`, `name`, `answer`) VALUES
(1, 'egor', 'yes'),
(2, 'egor', 'yes'),
(3, 'pasha', 'soso'),
(4, 'lesha', 'no'),
(5, 'misha', 'yes'),
(6, 'misha', 'yes'),
(7, 'artem', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `dataForShablon`
--

CREATE TABLE `dataForShablon` (
  `prop` text,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dataForShablon`
--

INSERT INTO `dataForShablon` (`prop`, `value`) VALUES
('position', 'Minsk'),
('title', 'Shablon for lab'),
('author', 'Egor Bichkouski');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `date` date DEFAULT NULL,
  `info` text,
  `img_url` text,
  `dayType` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`date`, `info`, `img_url`, `dayType`) VALUES
('2019-04-02', 'asfsaf', './src/green.jpg', 'free'),
('2019-04-12', 'asdfsaf', './src/red.jpg', 'task');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminStatistic`
--
ALTER TABLE `adminStatistic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articlesInfo`
--
ALTER TABLE `articlesInfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asking`
--
ALTER TABLE `asking`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminStatistic`
--
ALTER TABLE `adminStatistic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `articlesInfo`
--
ALTER TABLE `articlesInfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asking`
--
ALTER TABLE `asking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
