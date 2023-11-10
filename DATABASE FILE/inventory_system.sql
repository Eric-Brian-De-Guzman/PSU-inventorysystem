-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2023 at 03:43 AM
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
-- Database: `inventory_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(7, 'Beef'),
(6, 'Chemical'),
(5, 'Chicken'),
(16, 'Coffee'),
(17, 'Croisant'),
(8, 'Dairy'),
(2, 'Dry Spices'),
(12, 'Fish'),
(14, 'Fresh Vegetables'),
(11, 'Frozen Veget ( Loc &amp; SBY)'),
(10, 'Groceries'),
(1, 'Lamb'),
(13, 'Local Fruits &amp; Veges'),
(15, 'Pork'),
(9, 'Precooked'),
(3, 'Rice'),
(4, 'Sausages');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `UOI` varchar(10) DEFAULT NULL,
  `stock_code` text DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT NULL,
  `sale_price` decimal(25,2) NOT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `media_id` int(11) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `UOI`, `stock_code`, `quantity`, `buy_price`, `sale_price`, `categorie_id`, `media_id`, `date`) VALUES
(1, 'LAMB RACK, FROZEN', 'KGM', '40317938', '9', 12.00, 10.00, 1, 0, '2023-11-09 10:48:11'),
(2, 'LAMB RACK, FROZEN', 'KGM', '40317938', '5000', 100.00, 200.00, 1, 0, '2023-11-09 17:12:51'),
(3, 'LAMB, SHANK', 'KGM', '40318843', '3900', 100.00, 200.00, 1, 0, '2023-11-09 17:13:56'),
(4, 'LAMB, LOIN, FULL (REMOVE THE CHINE BONE)', 'KGM', '40319983', '5000', 100.00, 200.00, 1, 0, '2023-11-09 17:14:37'),
(5, 'FROZEN LAMB CHOP CUTS, 1.2 CM THICK', 'KGM', '40276908', '4999', 100.00, 200.00, 1, 0, '2023-11-09 17:15:13'),
(6, 'LEG, LAMB, BONE-IN, FROZEN, 22KG/CT', 'KGM', '40295077', '5000', 100.00, 200.00, 1, 0, '2023-11-09 17:15:47'),
(7, 'BUMBU SEREH', 'KGM', '40277042', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:26:07'),
(8, 'DRY SAMBAL LADO MUDO, 6 X 2KG/CT', 'CT', '40328878', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:26:39'),
(9, 'DRY, BUMBU OPOR LQ170203B, 6X2KG/CTN', 'CT', '40276297', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:27:09'),
(10, 'DRY, BUMBU TALIWANG LQ170202B, 6X2KG/CTN', 'CT', '40276822', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:27:33'),
(11, 'DRY, BUMBU TUTURUGA LQ170205B, 6X2KG/CTN', 'CT', '40323243', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:28:14'),
(12, 'DRY, BUMBU WOKU LQ170204B, 6X2KG/CTN', 'CT', '40308944', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:28:57'),
(13, 'DRY, BUMBU BETUTU LQ170201B, 6X2KG/CTN', 'CT', '40299391', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:29:23'),
(14, 'DRY BUMBU RICA RICA, 6 X 2 KG/CT', 'CT', '40316275', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:44:31'),
(15, 'DRY BUMBU RENDANG, 6 X 2 KG/CT', 'CT', '40314418', '5000', 100.00, 200.00, 2, 0, '2023-11-09 18:01:00'),
(16, 'DRY BUMBU GULAI MERAH, 6 X 2KG/CT', 'CT', '40308942', '5000', 100.00, 200.00, 2, 0, '2023-11-09 18:06:03'),
(17, 'FROZEN, BUMBU SOUP, 10KG/CTN', 'CT', '40293621', '5000', 1.00, 2.00, 2, 0, '2023-11-09 18:12:05'),
(18, 'BUMBU ASAM PADE', 'KGM', '40322857', '5000', 1.00, 2.00, 2, 0, '2023-11-09 18:14:28'),
(19, 'SHALLOTS, FROZEN, WHOLE, PEELED, 2KG X', 'CT', '40325800', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:38:28'),
(20, 'DRY BUMBU RUJAK, 6 X 2 KG/CT', 'CT', '40320490', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:53:12'),
(21, 'DRY BUMBU RAWON, 6 X 2 KG/CT', 'CT', '40319986', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:53:47'),
(22, 'DRY BUMBU KARE, 6 X 2 KG/CT', 'CT', '40312503', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:54:37'),
(23, 'DRY BUMBU SOTO AYAM, 6 X 2 KG/CT', 'CT', '40320616', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:54:58'),
(24, 'DRY BUMBU KALIO, 6 X 2KG/CT', 'CT', '40312099', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:56:16'),
(25, 'DRY SAMBAL CANGKUANG TERI, 6 X 2KG/CT', 'CT', '40331928', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:56:35'),
(26, 'BUMBU PECEL, 1 KG X 5/CTN', 'CT', '40321949', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `qty`, `price`, `date`) VALUES
(1, 1, 1, 10.00, '2023-11-09'),
(2, 5, 1, 200.00, '2023-11-09'),
(3, 3, 1100, 220000.00, '2023-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Harry Denn', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2023-11-10 09:52:02'),
(2, 'John Walker', 'special', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.png', 1, '2023-11-08 05:25:21'),
(3, 'Christopher', 'user', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.png', 1, '2021-04-04 19:54:46'),
(4, 'Natie Williams', 'natie', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, NULL),
(5, 'Kevin', 'kevin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 3, 'no_image.png', 1, '2021-04-04 19:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'special', 2, 1),
(3, 'User', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`id`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
