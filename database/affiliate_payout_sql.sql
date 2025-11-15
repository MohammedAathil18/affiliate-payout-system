CREATE DATABASE IF NOT EXISTS `affiliate_payout` 
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE `affiliate_payout`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Table structure for table `commissions`
--
CREATE TABLE `commissions` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `commission_amt` decimal(10,2) NOT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commissions`
--
INSERT INTO `commissions` (`id`, `sale_id`, `user_id`, `level`, `commission_amt`, `paid_at`) VALUES
(1, 1, 2, 1, 7.00, NULL),
(2, 1, 1, 2, 3.50, NULL),
(3, 2, 2, 1, 100.00, NULL),
(4, 2, 1, 2, 50.00, NULL),
(5, 3, 11, 1, 300.00, NULL),
(6, 4, 8, 1, 4000.00, NULL),
(7, 5, 26, 1, 5000.00, NULL),
(8, 5, 6, 2, 2500.00, NULL),
(9, 6, 28, 1, 5800.00, NULL),
(10, 6, 7, 2, 2900.00, NULL);

-- --------------------------------------------------------
-- Table structure for table `sales`
--
CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `sale_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--
INSERT INTO `sales` (`id`, `buyer_id`, `user_id`, `product`, `amount`, `sale_date`) VALUES
(1, 0, 3, 'Soap', 70.00, '2025-11-14 23:26:05'),
(2, 0, 3, 'Furniture', 1000.00, '2025-11-15 06:38:36'),
(3, 0, 35, 'Grinder', 3000.00, '2025-11-15 06:59:53'),
(4, 0, 29, 'mobile', 40000.00, '2025-11-15 07:09:27'),
(5, 0, 50, 'Table', 50000.00, '2025-11-15 09:36:02'),
(6, 0, 52, 'Laptop', 58000.00, '2025-11-15 09:36:55');

-- --------------------------------------------------------
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`id`, `name`, `parent_id`, `created_at`) VALUES
(1, 'Xavier Peterson', NULL, '2025-11-14 22:34:26'),
(2, 'Ina Rivers', 1, '2025-11-14 22:34:36'),
(3, 'Mercedes Campos', 2, '2025-11-14 22:54:38'),
(4, 'Alexa Collins', 3, '2025-11-15 06:36:59'),
(5, 'User_A1', NULL, '2025-11-15 06:56:46'),
(6, 'User_A2', NULL, '2025-11-15 06:56:46'),
(7, 'User_A3', NULL, '2025-11-15 06:56:46'),
(8, 'User_A4', NULL, '2025-11-15 06:56:46'),
(9, 'User_A5', NULL, '2025-11-15 06:56:46'),
(10, 'User_A6', NULL, '2025-11-15 06:56:46'),
(11, 'User_A7', NULL, '2025-11-15 06:56:46'),
(12, 'User_A8', NULL, '2025-11-15 06:56:46'),
(13, 'User_A9', NULL, '2025-11-15 06:56:46'),
(14, 'User_A10', NULL, '2025-11-15 06:56:46'),
(15, 'User_B1_1', 1, '2025-11-15 06:57:03'),
(16, 'User_B1_2', 1, '2025-11-15 06:57:03'),
(17, 'User_B2_1', 2, '2025-11-15 06:58:26'),
(18, 'User_B2_2', 2, '2025-11-15 06:58:26'),
(19, 'User_B3_1', 3, '2025-11-15 06:58:26'),
(20, 'User_B3_2', 3, '2025-11-15 06:58:26'),
(21, 'User_B4_1', 4, '2025-11-15 06:58:26'),
(22, 'User_B4_2', 4, '2025-11-15 06:58:26'),
(23, 'User_B5_1', 5, '2025-11-15 06:58:26'),
(24, 'User_B5_2', 5, '2025-11-15 06:58:26'),
(25, 'User_B6_1', 6, '2025-11-15 06:58:26'),
(26, 'User_B6_2', 6, '2025-11-15 06:58:26'),
(27, 'User_B7_1', 7, '2025-11-15 06:58:26'),
(28, 'User_B7_2', 7, '2025-11-15 06:58:26'),
(29, 'User_B8_1', 8, '2025-11-15 06:58:26'),
(30, 'User_B8_2', 8, '2025-11-15 06:58:27'),
(31, 'User_B9_1', 9, '2025-11-15 06:58:27'),
(32, 'User_B9_2', 9, '2025-11-15 06:58:27'),
(33, 'User_B10_1', 10, '2025-11-15 06:58:27'),
(34, 'User_B10_2', 10, '2025-11-15 06:58:27'),
(35, 'User_C1_1_1', 11, '2025-11-15 06:59:10'),
(36, 'User_C1_2_1', 12, '2025-11-15 06:59:10'),
(37, 'User_C2_1_1', 13, '2025-11-15 06:59:10'),
(38, 'User_C2_2_1', 14, '2025-11-15 06:59:10'),
(39, 'User_C3_1_1', 15, '2025-11-15 06:59:10'),
(40, 'User_C3_2_1', 16, '2025-11-15 06:59:10'),
(41, 'User_C4_1_1', 17, '2025-11-15 06:59:10'),
(42, 'User_C4_2_1', 18, '2025-11-15 06:59:10'),
(43, 'User_C5_1_1', 19, '2025-11-15 06:59:10'),
(44, 'User_C5_2_1', 20, '2025-11-15 06:59:10'),
(45, 'User_C6_1_1', 21, '2025-11-15 06:59:10'),
(46, 'User_C6_2_1', 22, '2025-11-15 06:59:10'),
(47, 'User_C7_1_1', 23, '2025-11-15 06:59:10'),
(48, 'User_C7_2_1', 24, '2025-11-15 06:59:10'),
(49, 'User_C8_1_1', 25, '2025-11-15 06:59:10'),
(50, 'User_C8_2_1', 26, '2025-11-15 06:59:10'),
(51, 'User_C9_1_1', 27, '2025-11-15 06:59:10'),
(52, 'User_C9_2_1', 28, '2025-11-15 06:59:10'),
(53, 'User_C10_1_1', 29, '2025-11-15 06:59:10'),
(54, 'User_C10_2_1', 30, '2025-11-15 06:59:10'),
(55, 'Renee Matthews', 48, '2025-11-15 07:09:01');

--
-- Indexes
--
ALTER TABLE `commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT
--
ALTER TABLE `commissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints
--
ALTER TABLE `commissions`
  ADD CONSTRAINT `commissions_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commissions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
