-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2025 at 06:30 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emergency`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `emergency_id` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `distance` varchar(50) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `emergency_id`, `address`, `latitude`, `longitude`, `distance`, `remark`, `created_at`, `user_id`) VALUES
(1, '0100', 'Unknown Address', 6.5243793, 3.3792057, NULL, 'Emergency Triggered', '2025-07-27 14:06:10', NULL),
(2, '0101', 'Unknown Address', 6.5243793, 3.3792057, NULL, 'Emergency Triggered', '2025-07-27 14:07:01', NULL),
(3, '0102', 'Unknown Address', 6.5243793, 3.3792057, NULL, 'Emergency Triggered', '2025-07-27 14:07:33', NULL),
(13, '0103', 'Tizeti HQ Test Address, Eletu Odibo Street, Shomolu, Lagos State, 102216, Nigeria', 6.5243793, 3.3792057, NULL, 'Unresolved', '2025-07-27 14:51:18', NULL),
(14, '0104', 'Tizeti HQ Test Address, Eletu Odibo Street, Shomolu, Lagos State, 102216, Nigeria', 6.5243793, 3.3792057, NULL, 'Unresolved', '2025-07-27 14:51:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical`
--

CREATE TABLE `medical` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical`
--

INSERT INTO `medical` (`id`, `username`, `email`, `password`, `phone_number`, `gender`, `profile_picture`, `first_name`, `last_name`) VALUES
(6, 'john', 'johnadedamola3@gmail.com', '$2y$10$dbh22SJLWQhonqYiusuU3ePBGgLdLQY45Hizwa54x7x6J236LK/o6', '901332145', 'Male', 'profile_6876418eaffb0.jpg', 'Adedamola', 'Oyewale'),
(7, 'beetayo', 'beetayotoyosi@gmail.com', '$2y$10$vP8qmTRa55wrb6c9Pyqd/uLzGS8IJxGcxJmM64mxJYvmTBVkQ3pri', '9039916193', 'Female', 'profile_6876482310ecc.jpg', NULL, NULL),
(8, 'Elmutawakil', 'mutawakiltaiwo1@gmail.com', '$2y$10$1Bicte468tcd/xmRE/7i6e8.AbfQGQ4YUbh7Q5.h53Nsj1HDkRmUe', '8114455158', 'Male', NULL, NULL, NULL),
(9, 'Mercy', 'mercy@gmail.com', '$2y$10$rU8yCgeWpsYn3ZQ.pIcqXuiSfT/4.qxsc24DchRvPMOLKxjflk67y', '7030321549', 'Female', 'profile_687575a0b9f93.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medical`
--
ALTER TABLE `medical`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `medical`
--
ALTER TABLE `medical`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
