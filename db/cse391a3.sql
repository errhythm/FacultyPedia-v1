-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 24, 2022 at 06:43 PM
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
(4, 26, 25, 'CSE391', '2022-08-22', '12:12:00', 'Rfgsdfgfdgfdg', 'pending', '2022-08-21 20:12:42', '2022-08-21 20:12:42', 26, 26),
(5, 28, 27, 'CSE391', '2022-08-24', '12:30:00', 'Need help', 'approved', '2022-08-23 09:34:32', '2022-08-23 09:34:32', 28, 28);

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
(18, 'CSE438', 'Very Great Faculty', 5, '27', '28', '2022-08-23 03:11:40', 0, 'approved'),
(19, 'CSE222', 'Very Nice.', 4.5, '30', '28', '2022-08-23 03:12:36', 0, 'approved'),
(20, 'MAT110', 'Welcoming as usual.', 4.5, '31', '28', '2022-08-23 03:13:06', 0, 'approved'),
(21, 'BUS201', 'Clears the topic really well.', 5, '32', '28', '2022-08-23 03:14:00', 0, 'approved'),
(22, 'BUS201', 'Polite.', 4, '32', '33', '2022-08-23 03:14:39', 0, 'approved'),
(23, 'CSE222', 'Great', 4.5, '30', '33', '2022-08-23 03:14:51', 0, 'approved'),
(24, 'CSE438', 'Awesome guy!', 5, '27', '33', '2022-08-23 03:15:06', 0, 'approved'),
(25, 'CSE110', 'Great faculty!', 4, '27', '33', '2022-08-23 03:15:45', 1, 'approved'),
(26, 'CSE111', 'Great', 4.5, '27', '28', '2022-08-23 03:33:25', 0, 'approved'),
(27, 'CSE1210', 'dfasdf', 5, '27', '28', '2022-08-23 03:34:05', 1, 'rejected');

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
(27, 'TRZ', 'bfb030d858c745b0a72340de2ae7f1ad', 'trz@bracu.ac.bd', 'faculty', 'Computer Science & Engineering', '2022-08-23 03:03:51', NULL),
(28, '20101298', '7b7a88659b9de5eb90449a083e1dc621', 'ehsanur.rahman.rhythm@g.bracu.ac.bd', 'student', 'Computer Science & Engineering', '2022-08-23 03:07:04', 'Ehsanur Rahman'),
(29, '20141003', 'ab02e29e0ede868f6d1bf5074e1a47b2', 'rajvir.ahmed.shuvo@g.bracu.ac.bd', 'student', 'Computer Science', '2022-08-23 03:07:26', 'Rajvir Ahmed'),
(30, 'MOB', '41f02b07e8e203d3260facb55b2f4b1b', 'mob@bracu.ac.bd', 'faculty', 'Mathematics & Natural Science', '2022-08-23 03:07:42', NULL),
(31, 'PHR', 'b266e47eb657161825cded6cc0dd5730', 'phr@bracu.ac.bd', 'faculty', 'Computer Science & Engineering', '2022-08-23 03:07:59', NULL),
(32, 'DBS', '85afaab5f3b6a638269e33d12da2fedf', 'dbs@bracu.ac.bd', 'faculty', 'Bracu Business School', '2022-08-23 03:08:13', NULL),
(33, '20101129', 'ea37cf12bc41ad89c8bba341a5a66065', 'shafakat@g.bracu.ac.bd', 'student', 'Computer Science & Engineering', '2022-08-23 03:08:32', NULL),
(34, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@bracu.ac.bd', 'admin', NULL, '2022-08-23 03:16:26', NULL),
(35, 'NZN', '86080b0f3c8464151ec0d8b0bbffd0f6', 'nzn@bracu.ac.bd', 'faculty', NULL, '2022-08-23 03:32:16', NULL);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
