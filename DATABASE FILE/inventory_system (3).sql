-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2023 at 04:53 PM
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
(7, 'BEEF'),
(6, 'CHEMICAL'),
(5, 'CHICKEN'),
(9, 'DAIRY'),
(2, 'DRY SPICES'),
(11, 'FISH'),
(14, 'FRESH VEGETABLES'),
(12, 'FROZEN VEGET'),
(10, 'GROCERIES'),
(1, 'LAMB'),
(13, 'LOCAL FRUIT &amp; VEGES'),
(15, 'PORK'),
(8, 'PRECOOKED'),
(3, 'RICE'),
(4, 'SAUSAGES');

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
  `stock_code` varchar(55) DEFAULT NULL,
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
(1, 'LAMB RACK, FROZEN', 'KGM', '40317938', '-4756', 10.00, 10.00, 1, 0, '2023-12-01 17:09:19'),
(2, 'LAMB, SHANK', 'KGM', '40318843', '0', 10.00, 10.00, 1, 0, '2023-12-01 17:10:48'),
(3, 'LAMB, LOIN, FULL (REMOVE THE CHINE BONE)', 'KGM', '40319983', '0', 10.00, 10.00, 1, 0, '2023-12-01 17:11:14'),
(4, 'FROZEN LAMB CHOP CUTS, 1.2 CM THICK', 'KGM', '40276908', '-15496', 10.00, 10.00, 1, 0, '2023-12-01 17:11:38'),
(5, 'LEG, LAMB, BONE-IN, FROZEN, 22KG/CT', 'KGM', '40295077', '-4550', 10.00, 10.00, 1, 0, '2023-12-01 17:45:26'),
(6, 'BUMBU PECEL, 1 KG X 5/CTN', 'CT', '40321949', '-699', 10.00, 10.00, 2, 0, '2023-12-02 21:04:17'),
(7, 'DRY SAMBAL CANGKUANG TERI, 6 X 2KG/CT', 'CT', '40331928', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:04:39'),
(8, 'DRY BUMBU KALIO, 6 X 2KG/CT', 'CT', '40312099', '-233', 10.00, 10.00, 2, 0, '2023-12-02 21:05:00'),
(9, 'DRY BUMBU SOTO AYAM, 6 X 2 KG/CT', 'CT', '40320616', '-315', 10.00, 10.00, 2, 0, '2023-12-02 21:05:19'),
(10, 'DRY BUMBU KARE, 6 X 2 KG/CT', 'CT', '40312503', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:05:54'),
(11, 'DRY BUMBU RAWON, 6 X 2 KG/CT', 'CT', '40319986', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:06:13'),
(12, 'DRY BUMBU RUJAK, 6 X 2 KG/CT', 'CT', '40320490', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:06:31'),
(13, 'SHALLOTS, FROZEN, WHOLE, PEELED, 2KG X', 'CT', '40325800', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:06:48'),
(14, 'BUMBU ASAM PADE', 'CT', '40322857', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:07:07'),
(15, 'FROZEN, BUMBU SOUP, 10KG/CTN', 'CT', '40293621', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:07:22'),
(16, 'DRY BUMBU GULAI MERAH, 6 X 2KG/CT', 'CT', '40308942', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:07:40'),
(17, 'DRY BUMBU RENDANG, 6 X 2 KG/CT', 'CT', '40314418', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:07:58'),
(18, 'DRY BUMBU RICA RICA, 6 X 2 KG/CT', 'CT', '40316275', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:08:18'),
(19, 'BUMBU SEREH', 'CT', '40277042', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:08:33'),
(20, 'DRY SAMBAL LADO MUDO, 6 X 2KG/CT', 'CT', '40328878', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:08:56'),
(21, 'DRY, BUMBU OPOR LQ170203B, 6X2KG/CTN', 'CT', '40276297', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:09:12'),
(22, 'DRY, BUMBU TALIWANG LQ170202B, 6X2KG/CTN', 'CT', '40276822', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:09:31'),
(23, 'DRY, BUMBU TUTURUGA LQ170205B, 6X2KG/CTN', 'CT', '40323243', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:09:48'),
(24, 'DRY, BUMBU WOKU LQ170204B, 6X2KG/CTN', 'CT', '40308944', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:10:03'),
(25, 'DRY, BUMBU BETUTU LQ170201B, 6X2KG/CTN', 'CT', '40299391', '0', 10.00, 10.00, 2, 0, '2023-12-02 21:10:20');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `stock_code` varchar(55) DEFAULT NULL,
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

INSERT INTO `sales` (`id`, `product_id`, `stock_code`, `category_id`, `vendor_id`, `qty`, `price`, `remarks`, `date`) VALUES
(1, 1, '40317938', 1, 1, 708, 245000.00, '', '2023-09-01'),
(2, 4, '40276908', 1, 1, 1821, 220000.00, '', '2023-09-01'),
(3, 1, '40317938', 1, 1, 1528, 245000.00, '', '2023-01-05'),
(4, 2, '40318843', 1, 1, 0, 227027.00, '', '2023-01-01'),
(5, 4, '40276908', 1, 1, 3649, 220000.00, '', '2023-01-01'),
(6, 5, '40295077', 1, 1, 2035, 163000.00, '', '2023-01-01'),
(8, 1, '40317938', 1, 1, 1591, 245000.00, '', '2023-06-01'),
(9, 4, '40276908', 1, 1, 893, 220000.00, '', '2023-06-01'),
(10, 4, '40276908', 1, 2, 892, 219500.00, '', '2023-06-01'),
(11, 5, '40295077', 1, 1, 2515, 163000.00, '', '2023-06-01'),
(12, 4, '40276908', 1, 2, 1820, 219500.00, '', '2023-09-01'),
(13, 1, '40317938', 1, 1, 1392, 245000.00, '', '2023-12-01'),
(14, 4, '40276908', 1, 1, 1386, 220000.00, '', '2023-12-01'),
(15, 4, '40276908', 1, 2, 1386, 219500.00, '', '2023-12-01'),
(16, 6, '40321949', 2, 4, 204, 239.00, '', '2023-09-01'),
(17, 6, '40321949', 2, 5, 87, 249299.00, '', '2023-09-02'),
(18, 8, '40312099', 2, 5, 233, 605980.00, '', '2023-09-02'),
(19, 9, '40320616', 2, 3, 221, 588000.00, '', '2023-09-02'),
(20, 9, '40320616', 2, 5, 94, 587890.00, '', '2023-09-02'),
(21, 6, '40321949', 2, 4, 285, 239000.00, '', '2023-12-02'),
(22, 6, '40321949', 2, 5, 123, 242299.00, '', '2023-12-02');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `stock_code` varchar(55) DEFAULT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `stock_onhand` int(11) NOT NULL,
  `submitted_usage` int(11) NOT NULL,
  `req_qty` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(1, 'Harry Denn', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'no_image.png', 1, '2023-12-02 22:17:22'),
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
(4, 'PUFD'),
(3, 'PUFI'),
(5, 'TRIBOGA/SARIMA'),
(1, 'vendor A'),
(2, 'Vendor B');

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
  ADD KEY `media_id` (`media_id`),
  ADD KEY `stock_code` (`stock_code`) USING BTREE;

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `vendor_id` (`vendor_id`) USING BTREE,
  ADD KEY `categorie_id` (`category_id`),
  ADD KEY `stock_code` (`stock_code`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`) USING BTREE,
  ADD KEY `category_id` (`category_id`),
  ADD KEY `stock_code` (`stock_code`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `sales_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `products` (`categorie_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sales_ibfk_4` FOREIGN KEY (`stock_code`) REFERENCES `products` (`stock_code`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `products` (`categorie_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stocks_ibfk_3` FOREIGN KEY (`stock_code`) REFERENCES `products` (`stock_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
