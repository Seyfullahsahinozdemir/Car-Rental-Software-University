-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2022 at 11:04 PM
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
(31, 'test4', 'jeep', 350, 'jeep.png', 5, 'empty', 8);

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
  `statu` tinyint(1) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`messageID`, `customerUsername`, `comment`, `date`, `groupID`, `statu`, `receiver`) VALUES
(5, 'deneme', 'deneme 12 3 1 23 ', '2022-05-11 09:19:25', 539454528, 0, 'admin'),
(6, 'deneme', 'ccmamcsc', '2022-05-11 09:22:07', 1419460536, 0, 'admin'),
(7, 'admin', 'cavsbrbdrbdbf', '2022-05-11 12:06:48', 539454528, 0, 'deneme'),
(8, 'deneme', 'third message from deneme', '2022-05-12 11:08:32', 539454528, 0, 'admin'),
(9, 'deneme', '4. message from deneme', '2022-05-12 11:08:47', 539454528, 0, 'admin'),
(10, 'deneme', '2. message from deneme', '2022-05-12 11:09:21', 1419460536, 0, 'admin'),
(11, 'admin', '5. message from admin', '2022-05-12 11:34:10', 539454528, 1, 'deneme'),
(12, 'admin', '3. message from admin\r\n', '2022-05-12 11:34:27', 1419460536, 1, 'deneme'),
(13, 'deneme2', 'new admin message from deneme2', '2022-05-12 11:41:01', 1557531692, 0, 'admin'),
(14, 'admin', 'second message from admin to deneme2', '2022-05-12 11:42:14', 1557531692, 1, 'deneme2'),
(15, 'admin', 'Hi deneme2, Some of the reasons, we need to delete your reservation that start at 2022-07-11 and finish at 2022-07-13', '2022-05-25 16:20:47', 1040957264, 1, 'deneme2'),
(16, 'deneme2', 'thirdd message\r\n', '2022-05-25 17:59:13', 1557531692, 1, 'admin'),
(18, 'sahin', 'i have payment problem', '2022-05-26 20:21:37', 1858041465, 1, 'admin'),
(19, 'admin', 'sorry for that', '2022-05-26 20:22:57', 1858041465, 1, 'sahin'),
(20, 'sahin', 'aaa', '2022-05-26 20:23:31', 1858041465, 1, 'admin'),
(22, 'admin', 'Hi sahin, Some of the reasons, we need to delete your reservation that start at 2022-05-27 and finish at 2022-05-29', '2022-05-26 20:34:51', 2057614732, 1, 'sahin'),
(23, 'sahin', 'system has an error.', '2022-05-26 20:46:18', 1421091862, 1, 'admin'),
(24, 'admin', 'sorry for that', '2022-05-26 20:46:57', 1421091862, 1, 'sahin');

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
(220747319, 'Reservation', 'test4'),
(539454528, 'test', 'General'),
(559038879, 'Payment problem', 'Payment'),
(1040957264, 'Reservation', 'test1'),
(1419460536, 'tes2', 'System'),
(1421091862, 'tutut', 'System'),
(1557531692, 'testtststs', 'System'),
(1858041465, 'payment', 'Payment'),
(2057614732, 'Reservation', 'test4');

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `ID` int(11) NOT NULL,
  `carID` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `stars` int(11) NOT NULL,
  `comment` text NOT NULL,
  `start` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`ID`, `carID`, `username`, `stars`, `comment`, `start`) VALUES
(2, 28, 'deneme', 5, 'i love this <3', NULL),
(3, 27, 'deneme', 3, 'not bad car', NULL),
(4, 28, 'deneme2', 4, 'good \r\n', NULL),
(6, 28, 'sahin', 5, 'i really love this', '2022-01-10'),
(7, 28, 'sahin', 3, 'not bad', '2022-01-01'),
(8, 27, 'sahin', 4, 'ilike this car', '2022-05-25');

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
('test', 'deneme', '2022-05-02', '2022-05-11', 850),
('test1', 'deneme2', '2022-05-10', '2022-05-12', 420),
('test', 'sahin', '2022-05-25', '2022-05-28', 425),
('test1', 'sahin', '2022-01-01', '2022-01-03', 560),
('test1', 'sahin', '2022-01-10', '2022-01-12', 280);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `name` varchar(100) NOT NULL,
  `username` varchar(40) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `statu` tinyint(1) NOT NULL,
  `active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `username`, `email`, `password`, `statu`, `active`) VALUES
('sahin', 'admin', 'admin', '202cb962ac59075b964b07152d234b70', 0, 1),
('hakki', 'deneme', 'sahinn@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1),
('deneme2', 'deneme2', 'temp', '202cb962ac59075b964b07152d234b70', 1, 1),
('deneme3', 'deneme3', 'temp1', '698d51a19d8a121ce581499d7b701668', 1, 1),
('sahin', 'sahin', 'sahin@gmail.com', '8d5e957f297893487bd98fa830fa6413', 1, 1),
('sahin', 'tempp', 'temp@gmail.com', '202cb962ac59075b964b07152d234b70', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `message_group`
--
ALTER TABLE `message_group`
  ADD PRIMARY KEY (`groupID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

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
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
