-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2022 at 10:00 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `model` varchar(30) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `numberSeat` int(11) NOT NULL,
  `state` varchar(15) NOT NULL,
  `day` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`ID`, `name`, `model`, `price`, `image`, `numberSeat`, `state`, `day`) VALUES
(27, 'test', 'sedan', 85, 'sedan.png', 4, 'empty', 15),
(28, 'test1', 'sport', 140, 'sport-car.png', 2, 'empty', 5),
(30, 'test2', 'sedan', 170, 'sedan.png', 4, 'empty', 4),
(31, 'test4', 'jeep', 240, 'jeep.png', 5, 'empty', 8);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `messageID` int(11) NOT NULL,
  `customerUsername` varchar(40) NOT NULL,
  `comment` text NOT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `groupID` int(11) DEFAULT NULL,
  `statu` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `customerUsername`, `comment`, `date`, `groupID`, `statu`) VALUES
(5, 'deneme', 'deneme 12 3 1 23 ', '2022-05-11 12:19:25', 539454528, 0),
(6, 'deneme', 'ccmamcsc', '2022-05-11 12:22:07', 1419460536, 0),
(7, 'admin', 'cavsbrbdrbdbf', '2022-05-11 15:06:48', 539454528, 0),
(8, 'deneme', 'third message from deneme', '2022-05-12 14:08:32', 539454528, 0),
(9, 'deneme', '4. message from deneme', '2022-05-12 14:08:47', 539454528, 0),
(10, 'deneme', '2. message from deneme', '2022-05-12 14:09:21', 1419460536, 0),
(11, 'admin', '5. message from admin', '2022-05-12 14:34:10', 539454528, 0),
(12, 'admin', '3. message from admin\r\n', '2022-05-12 14:34:27', 1419460536, 0),
(13, 'deneme2', 'new admin message from deneme2', '2022-05-12 14:41:01', 1557531692, 0),
(14, 'admin', 'second message from admin to deneme2', '2022-05-12 14:42:14', 1557531692, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_group`
--

CREATE TABLE `message_group` (
  `groupID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `subtopic` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_group`
--

INSERT INTO `message_group` (`groupID`, `title`, `subtopic`) VALUES
(539454528, 'test', 'General'),
(1419460536, 'tes2', 'System'),
(1557531692, 'testtststs', 'System');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `ID` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`ID`, `carID`, `username`, `stars`, `comment`) VALUES
(2, 28, 'deneme', 5, 'i love this <3'),
(3, 27, 'deneme', 3, 'not bad car'),
(4, 28, 'deneme2', 4, 'good \r\n');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `carname` varchar(30) NOT NULL,
  `username` varchar(40) NOT NULL,
  `start` date NOT NULL,
  `finish` date NOT NULL,
  `totalPrice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`carname`, `username`, `start`, `finish`, `totalPrice`) VALUES
('test4', 'deneme', '2022-06-02', '2022-06-03', 480),
('test', 'deneme', '2022-05-02', '2022-05-11', 850),
('test1', 'deneme2', '2022-07-11', '2022-07-13', 420),
('test1', 'deneme2', '2022-05-10', '2022-05-12', 420);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(100) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `statu` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `username`, `email`, `password`, `statu`) VALUES
('sahin', 'admin', 'admin', '202cb962ac59075b964b07152d234b70', 0),
('hakki', 'deneme', 'sahinn@gmail.com', '202cb962ac59075b964b07152d234b70', 1),
('deneme2', 'deneme2', 'temp', '202cb962ac59075b964b07152d234b70', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `groupID` (`groupID`);

--
-- Indexes for table `message_group`
--
ALTER TABLE `message_group`
  ADD PRIMARY KEY (`groupID`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `carID` (`carID`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD KEY `carname` (`carname`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`groupID`) REFERENCES `message_group` (`groupID`);

--
-- Constraints for table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`carID`) REFERENCES `cars` (`ID`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`carname`) REFERENCES `cars` (`name`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
