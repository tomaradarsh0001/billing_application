-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 08:19 PM
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
-- Database: `billing_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'configuration.view', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(2, 'configuration.create', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(3, 'configuration.edit', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(4, 'configuration.delete', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(5, 'users.view', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(6, 'users.create', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(7, 'users.edit', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(8, 'users.delete', 'web', '2024-12-20 01:57:26', '2024-12-20 01:57:26'),
(9, 'permissions.view', 'web', '2024-12-20 05:28:46', '2024-12-20 05:28:46'),
(10, 'permissions.create', 'web', '2024-12-20 05:30:55', '2024-12-20 05:30:55'),
(11, 'permissions.delete', 'web', '2024-12-20 05:31:07', '2024-12-20 05:31:07'),
(12, 'permissions.edit', 'web', '2024-12-20 05:31:13', '2024-12-20 05:31:13'),
(14, 'test', 'web', '2024-12-22 12:23:57', '2024-12-22 12:23:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
