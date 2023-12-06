-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Oct 25, 2023 at 12:43 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_budget_tracker`
--
CREATE DATABASE IF NOT EXISTS `db_budget_tracker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_budget_tracker`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE `accounts` (
  `account_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_name` varchar(45) NOT NULL,
  `account_type` varchar(45) NOT NULL,
  `starting_amount` int(10) NOT NULL,
  `currency_type` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`account_id`, `user_id`, `account_name`, `account_type`, `starting_amount`, `currency_type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 'Human Incubator Inc (Salary)', 'Cash', 20000, 'PHP', '2023-10-25 18:35:31', '2023-10-25 18:35:31', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `category` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 'House Bills', '2023-10-25 18:38:55', '2023-10-25 18:38:55', NULL),
(6, 'Transportation', '2023-10-25 18:38:55', '2023-10-25 18:38:55', NULL),
(7, 'Food and Dine', '2023-10-25 18:39:16', '2023-10-25 18:39:16', NULL),
(8, 'School Expense', '2023-10-25 18:39:16', '2023-10-25 18:39:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `label`
--

DROP TABLE IF EXISTS `label`;
CREATE TABLE `label` (
  `label_id` int(10) NOT NULL,
  `label` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `label`
--

INSERT INTO `label` (`label_id`, `label`, `created_at`, `updated_at`, `deleted_at`) VALUES
(12, 'Food, Night Snacks and Others', '2023-10-25 18:40:32', '2023-10-25 18:40:32', NULL),
(13, 'Bus, jeep, and tricycles', '2023-10-25 18:40:32', '2023-10-25 18:40:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  `record_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `record_type` varchar(45) NOT NULL,
  `account_name` varchar(45) NOT NULL,
  `amount` int(8) NOT NULL,
  `currency_type` varchar(45) NOT NULL,
  `category` varchar(45) NOT NULL,
  `label` varchar(45) NOT NULL,
  `record_date` date NOT NULL,
  `record_time` time NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `email` varchar(45) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `first_name`, `middle_name`, `last_name`, `password`, `created_at`, `updated_at`) VALUES
(5, 'gadiego4616val@admin.fatima.edu.ph', 'Gerald', 'Almaden', 'Diego', '$2y$10$9uTXmSiIDnIRPKI.tDFD2eY0RPv0WqHAhsb5ydQ.69uhuGgnECoYu', '2023-10-19 16:40:55', '2023-10-19 16:40:55'),
(6, 'trimuru199@gmail.com', 'Gerald', 'Almaden', 'Diego', '$2y$10$HawlDAwp9eotpX2U7AwL2uKZrnboDJ3gaPqi/U8cZrn6RBT8No.by', '2023-10-20 06:03:19', '2023-10-20 06:03:19'),
(7, 'kimballmonroe8@gmail.com', 'Gerald', 'Almaden', 'Diego', '$2y$10$hTgLFGwGq4z2Fct6OQRFpOFZQMabm2qcG/XJiwZw9MTy.TehN4vii', '2023-10-20 10:02:26', '2023-10-20 10:02:26'),
(8, 'gerald.diego99@yahoo.com', 'Gerald', 'Almaden', 'Diego', '$2y$10$YCBbozxrFjmuEROc5SHcfuwWysG4lYyyBezksJdx8guAQ4dK4zFOK', '2023-10-20 20:20:55', '2023-10-20 20:20:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `account_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `label`
--
ALTER TABLE `label`
  ADD PRIMARY KEY (`label_id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `record_user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `label`
--
ALTER TABLE `label`
  MODIFY `label_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `record_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
