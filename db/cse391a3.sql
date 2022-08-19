-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2022 at 06:27 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+06:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cse391a3`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(6) UNSIGNED NOT NULL,
  `mechanic_id` int(6) NOT NULL,
  `car_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `mechanic_id`, `car_id`, `user_id`, `date`, `time`, `status`) VALUES
(14, 5, 12, 1, '2022-06-30', '20:55:00', 0),
(15, 10, 9, 2, '2022-07-01', '11:47:00', 0),
(16, 4, 14, 1, '2022-07-01', '02:47:00', 0),
(17, 4, 13, 1, '2022-07-01', '10:52:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(6) UNSIGNED NOT NULL,
  `car_license` varchar(50) NOT NULL,
  `car_registration` varchar(50) NOT NULL,
  `car_model` varchar(50) NOT NULL,
  `user_id` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `car_license`, `car_registration`, `car_model`, `user_id`) VALUES
(9, 'GA-11-3113', '3698569856', 'Toyota Axio X Hybrid 2016', 2),
(10, 'GA-11-1112', '5698523356', 'Toyota Axio X 2012', 3),
(12, 'GA-77-3183', 'A9UUNFEB2A2NDUUYH', 'Honda Grace LX 2018', 1),
(13, 'GA-59-6329', 'YMXR72EZ4AYWR9C50', 'Toyota Premio EX 2016', 1),
(14, 'GHA-11-9018', 'J3P8SJSN7AXTEWD3F', 'Mitsubishi Outlandar SUNROOF 2006', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mechanics`
--

CREATE TABLE `mechanics` (
  `mechanic_id` int(6) UNSIGNED NOT NULL,
  `mechanic_name` varchar(255) NOT NULL,
  `mechanic_age` int(10) NOT NULL,
  `mechanic_phone` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mechanics`
--

INSERT INTO `mechanics` (`mechanic_id`, `mechanic_name`, `mechanic_age`, `mechanic_phone`) VALUES
(2, 'Rahim', 30, '01700000000'),
(3, 'Selim', 35, '01800000000'),
(4, 'Sabbir', 24, '01900000000'),
(5, 'Sohel', 28, '01500000000'),
(10, 'Bodrul', 32, '01600000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` int(1) NOT NULL DEFAULT '0',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `address`, `phone`, `reg_date`) VALUES
(1, 'rhythm', '7b7a88659b9de5eb90449a083e1dc621', 'errhythm.me@gmail.com', 1, '17/C, Nabiha Mansion, Maricha Garden, East Razabazar, Farmgate', '01779092201', '2022-07-01 05:57:22'),
(2, 'shv', '85e074b6e6a348c07cd5a5dd3a28c7be', 'shv@shv.com', 0, '9740 SW BANK RD', '3093040892', '2022-07-01 04:43:18'),
(21, 'abc', '900150983cd24fb0d6963f7d28e17f72', 'abc@abc.abc', 0, NULL, NULL, '2022-07-01 05:40:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mechanics`
--
ALTER TABLE `mechanics`
  ADD PRIMARY KEY (`mechanic_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mechanics`
--
ALTER TABLE `mechanics`
  MODIFY `mechanic_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
