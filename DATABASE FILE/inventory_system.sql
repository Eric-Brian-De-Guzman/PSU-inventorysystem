-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 01:52 PM
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
(18, 'eric'),
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

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(1, 'jerich.png', 'image/png');

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
(3, 'LAMB, SHANK', 'KGM', '40318843', '3899', 100.00, 200.00, 1, 0, '2023-11-09 17:13:56'),
(4, 'LAMB, LOIN, FULL (REMOVE THE CHINE BONE)', 'KGM', '40319983', '4988', 100.00, 200.00, 1, 0, '2023-11-09 17:14:37'),
(5, 'FROZEN LAMB CHOP CUTS, 1.2 CM THICK', 'KGM', '40276908', '4998', 100.00, 200.00, 1, 0, '2023-11-09 17:15:13'),
(6, 'LEG, LAMB, BONE-IN, FROZEN, 22KG/CT', 'KGM', '40295077', '5000', 100.00, 200.00, 1, 0, '2023-11-09 17:15:47'),
(7, 'BUMBU SEREH', 'KGM', '40277042', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:26:07'),
(8, 'DRY SAMBAL LADO MUDO, 6 X 2KG/CT', 'CT', '40328878', '4999', 100.00, 200.00, 2, 0, '2023-11-09 17:26:39'),
(9, 'DRY, BUMBU OPOR LQ170203B, 6X2KG/CTN', 'CT', '40276297', '4999', 100.00, 200.00, 2, 0, '2023-11-09 17:27:09'),
(10, 'DRY, BUMBU TALIWANG LQ170202B, 6X2KG/CTN', 'CT', '40276822', '4981', 100.00, 200.00, 2, 0, '2023-11-09 17:27:33'),
(11, 'DRY, BUMBU TUTURUGA LQ170205B, 6X2KG/CTN', 'CT', '40323243', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:28:14'),
(12, 'DRY, BUMBU WOKU LQ170204B, 6X2KG/CTN', 'CT', '40308944', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:28:57'),
(13, 'DRY, BUMBU BETUTU LQ170201B, 6X2KG/CTN', 'CT', '40299391', '5000', 100.00, 200.00, 2, 0, '2023-11-09 17:29:23'),
(14, 'DRY BUMBU RICA RICA, 6 X 2 KG/CT', 'CT', '40316275', '4999', 100.00, 200.00, 2, 0, '2023-11-09 17:44:31'),
(15, 'DRY BUMBU RENDANG, 6 X 2 KG/CT', 'CT', '40314418', '5000', 100.00, 200.00, 2, 0, '2023-11-09 18:01:00'),
(16, 'DRY BUMBU GULAI MERAH, 6 X 2KG/CT', 'CT', '40308942', '5000', 100.00, 200.00, 2, 0, '2023-11-09 18:06:03'),
(17, 'FROZEN, BUMBU SOUP, 10KG/CTN', 'CT', '40293621', '5000', 1.00, 2.00, 2, 0, '2023-11-09 18:12:05'),
(18, 'BUMBU ASAM PADE', 'KGM', '40322857', '5000', 1.00, 2.00, 2, 0, '2023-11-09 18:14:28'),
(19, 'SHALLOTS, FROZEN, WHOLE, PEELED, 2KG X', 'CT', '40325800', '-1', 1.00, 2.00, 2, 0, '2023-11-09 18:38:28'),
(20, 'DRY BUMBU RUJAK, 6 X 2 KG/CT', 'CT', '40320490', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:53:12'),
(21, 'DRY BUMBU RAWON, 6 X 2 KG/CT', 'CT', '40319986', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:53:47'),
(22, 'DRY BUMBU KARE, 6 X 2 KG/CT', 'CT', '40312503', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:54:37'),
(23, 'DRY BUMBU SOTO AYAM, 6 X 2 KG/CT', 'CT', '40320616', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:54:58'),
(24, 'DRY BUMBU KALIO, 6 X 2KG/CT', 'CT', '40312099', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:56:16'),
(25, 'DRY SAMBAL CANGKUANG TERI, 6 X 2KG/CT', 'CT', '40331928', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:56:35'),
(26, 'BUMBU PECEL, 1 KG X 5/CTN', 'CT', '40321949', '10', 1.00, 2.00, 2, 0, '2023-11-09 18:58:58'),
(27, 'lamb', 'KGM', '123r212erewq', '152', 12.00, 100.00, 1, 0, '2023-11-13 01:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `vendor_id` int(11) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `remarks` varchar(55) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `category_id`, `vendor_id`, `qty`, `price`, `remarks`, `date`) VALUES
(13, 10, 1, 1, 1, 0.00, 'hello', '2023-11-01'),
(14, 9, 1, 3, 1, 200.00, '10', '2023-11-14'),
(27, 10, 2, 4, 1, 1200.00, 'w', '2023-11-20'),
(28, 4, 1, 1, 12, 1500.00, '50%', '2023-11-20'),
(29, 8, 2, 4, 1, 200.00, '50%', '2023-11-20'),
(30, 3, 1, 3, 1, 1200.00, '50%', '2023-11-20'),
(31, 5, 1, 3, 1, 1200.00, 'aaa', '2023-11-20'),
(32, 19, 2, 3, 11, 12.00, '50%', '2023-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `date`) VALUES
(1, 13, 15, '2023-11-13'),
(7, 12, 2023, '0000-00-00'),
(11, 12, 2023, '0000-00-00'),
(12, 12, 2023, '0000-00-00'),
(18, 12, 2023, '0000-00-00'),
(19, 12, 2023, '0000-00-00'),
(23, 2, 12, '2023-11-13'),
(24, 2, 12, '2023-11-13');

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
(1, 'Harry Denn', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2023-11-20 12:09:00'),
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

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) UNSIGNED NOT NULL,
  `vendor_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `vendor_name`) VALUES
(4, 'Calibo'),
(3, 'Emma'),
(1, 'Eric');

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
  ADD KEY `product_id` (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`) USING BTREE,
  ADD KEY `categorie_id` (`category_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`) USING BTREE;

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_name` (`vendor_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `products` (`categorie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
