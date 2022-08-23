-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 23, 2022 at 07:26 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


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
  `id` int(11) UNSIGNED NOT NULL,
  `st_id` int(11) UNSIGNED NOT NULL,
  `f_id` int(11) UNSIGNED NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL,
  `updated_by` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `st_id`, `f_id`, `course_name`, `date`, `time`, `message`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 26, 23, 'ASDA', '2022-08-11', '23:05:00', 'ADA', 'pending', '2022-08-21 20:05:38', '2022-08-21 20:05:38', 26, 26),
(3, 26, 23, 'CSE391', '2022-08-11', '21:08:00', 'asdasd', 'approved', '2022-08-21 20:08:50', '2022-08-21 20:08:50', 26, 26),
(4, 26, 25, 'CSE391', '2022-08-22', '12:12:00', 'Rfgsdfgfdgfdg', 'pending', '2022-08-21 20:12:42', '2022-08-21 20:12:42', 26, 26);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `course` varchar(255) NOT NULL,
  `review` varchar(255) NOT NULL,
  `stars` float NOT NULL,
  `faculty` varchar(11) NOT NULL,
  `student` varchar(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `anonymous` tinyint(1) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `course`, `review`, `stars`, `faculty`, `student`, `date`, `anonymous`, `status`) VALUES
(1, 'CSE391', 'Rhythm', 4, '25', '26', '2022-08-19 11:58:14', 0, 'approved'),
(7, 'CSE420', 'dasdasd', 5, '25', '26', '2022-08-19 11:58:14', 1, 'pending'),
(8, 'CSE221', 'AS', 3, '25', '23', '2022-08-19 12:25:57', 0, 'approved'),
(9, 'CSE360', 'Nice, really nice. ', 5, '25', '23', '2022-08-19 12:53:31', 0, 'approved'),
(10, 'CSE251', 'asdasddfsdgfdsgdfhgdfdfgdfgdf', 4.5, '25', '26', '2022-08-19 14:47:10', 1, 'pending'),
(11, 'CSE331', 'sadaSdasd', 2.5, '25', '26', '2022-08-19 14:48:39', 1, 'pending'),
(13, 'CSE391', 'asdasd', 4.5, '23', '26', '2022-08-19 16:27:43', 0, 'approved'),
(14, 'CSE301', 'SAdasdasd', 1.5, '25', '26', '2022-08-21 15:05:39', 1, 'approved'),
(15, 'CSE438', 'Very Bad faculty. ', 0.5, '25', '21', '2022-08-21 15:28:16', 1, 'approved'),
(16, 'CSE391', 'Shit', 0.5, '25', '21', '2022-08-21 18:02:41', 1, 'rejected'),
(17, 'CSE392', 'Shitsdsd', 3, '25', '21', '2022-08-21 18:03:22', 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `department` varchar(255) DEFAULT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `full_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `department`, `reg_date`, `full_name`) VALUES
(1, 'rhythm', '7b7a88659b9de5eb90449a083e1dc621', 'errhythm.me@gmail.com', 'admin', '17/C, Nabiha Mansion, Maricha Garden, East Razabazar, Farmgate', '2022-08-22 17:33:45', 'Ehsanur Rahman Rhyth'),
(2, 'shv', '85e074b6e6a348c07cd5a5dd3a28c7be', 'shv@shv.com', 'student', '9740 SW BANK RD', '2022-08-18 13:08:07', 'Rajvir'),
(21, 'abc', '900150983cd24fb0d6963f7d28e17f72', 'abc@abc.abc', 'student', '', '2022-08-18 13:08:09', 'ABC'),
(23, '20101298', '7b7a88659b9de5eb90449a083e1dc621', 'ehsanur.rahman.rhythm@g.bracu.ac.bd', 'faculty', 'Computer Science & Engineering', '2022-08-21 12:06:01', 'Ehsanur Rahman Rhythm'),
(25, '20141003', 'ab02e29e0ede868f6d1bf5074e1a47b2', 'shv@ph.com', 'faculty', 'Computer Science', '2022-08-18 14:03:23', NULL),
(26, '20101129', 'ea37cf12bc41ad89c8bba341a5a66065', 'arnob@arnob.com', 'student', 'Computer Science & eNgiNeeRiNg', '2022-08-21 12:54:47', 'Shafakat Arnob');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
