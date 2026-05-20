-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2026 at 02:39 AM
-- Server version: 11.8.5-MariaDB-log
-- PHP Version: 8.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet_store_db`
--
DROP DATABASE IF EXISTS `pet_store_db`;
CREATE DATABASE IF NOT EXISTS `pet_store_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `pet_store_db`;
-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `email` text NOT NULL,
  `hashed_pass` tinytext NOT NULL,
  `salt` char(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `fname`, `lname`, `email`, `hashed_pass`, `salt`) VALUES
(1, 'Alice', 'Smith', 'alice@petstore.com', 'hash1', 'salt123456789012345678'),
(2, 'Bob', 'Jones', 'bob@petstore.com', 'hash2', 'salt223456789012345678'),
(3, 'Charlie', 'Brown', 'charlie@petstore.com', 'hash3', 'salt323456789012345678'),
(4, 'Diana', 'Prince', 'diana@petstore.com', 'hash4', 'salt423456789012345678'),
(5, 'Edward', 'Norton', 'edward@petstore.com', 'hash5', 'salt523456789012345678'),
(6, 'Fiona', 'Gallagher', 'fiona@petstore.com', 'hash6', 'salt623456789012345678'),
(7, 'George', 'Miller', 'george@petstore.com', 'hash7', 'salt723456789012345678'),
(8, 'Hannah', 'Abbott', 'hannah@petstore.com', 'hash8', 'salt823456789012345678'),
(9, 'Ian', 'Wright', 'ian@petstore.com', 'hash9', 'salt923456789012345678'),
(10, 'Jane', 'Doe', 'jane@petstore.com', 'hash10', 'salt023456789012345678');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `service_type` enum('nail clipping','fur styling','clean up') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `customer_id`, `pet_id`, `service_type`) VALUES
(1, 1, 1, 'nail clipping'),
(2, 2, 2, 'fur styling'),
(3, 3, 3, 'clean up'),
(4, 4, 4, 'nail clipping'),
(5, 5, 5, 'fur styling'),
(6, 6, 6, 'clean up'),
(7, 7, 7, 'nail clipping'),
(8, 8, 8, 'fur styling'),
(9, 9, 9, 'clean up'),
(10, 10, 10, 'nail clipping');

-- --------------------------------------------------------

--
-- Table structure for table `cart_listings`
--

CREATE TABLE `cart_listings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_listings`
--

INSERT INTO `cart_listings` (`id`, `customer_id`, `product_id`, `product_amount`) VALUES
(1, 1, 1, 2),
(2, 2, 3, 1),
(3, 3, 10, 5),
(4, 4, 7, 1),
(5, 5, 5, 1),
(6, 6, 6, 3),
(7, 7, 4, 1),
(8, 8, 8, 2),
(9, 9, 9, 4),
(10, 10, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'toys', 'Enrichment for your pets.', '2026-04-02 12:44:33'),
(3, 'clothes', 'Collars, harnesses, raincoats, boots, and other articles for your pet to wear.', '2026-04-02 13:18:11'),
(4, 'food', 'Wet foods, dry foods, treats, frozen foods, live food', '2026-04-02 13:18:11'),
(5, 'tools', '', '2026-04-02 13:26:22'),
(6, 'health products', 'Products to help your pet remain hale and hearty.', '2026-04-02 13:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `email` text NOT NULL,
  `hashed_pass` varchar(72) NOT NULL,
  `salt` char(22) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fname`, `lname`, `email`, `hashed_pass`, `salt`) VALUES
(1, 'John', 'Doe', 'john@gmail.com', 'custhash1', 'csalt12345678901234567'),
(2, 'Mary', 'Jane', 'mary@yahoo.com', 'custhash2', 'csalt22345678901234567'),
(3, 'Peter', 'Parker', 'spidey@dailybugle.com', 'custhash3', 'csalt32345678901234567'),
(4, 'Bruce', 'Wayne', 'bruce@wayneent.com', 'custhash4', 'csalt42345678901234567'),
(5, 'Clark', 'Kent', 'clark@dailyplanet.com', 'custhash5', 'csalt52345678901234567'),
(6, 'Lois', 'Lane', 'lois@dailyplanet.com', 'custhash6', 'csalt62345678901234567'),
(7, 'Tony', 'Stark', 'tony@stark.com', 'custhash7', 'csalt72345678901234567'),
(8, 'Steve', 'Rogers', 'steve@shield.gov', 'custhash8', 'csalt82345678901234567'),
(9, 'Natasha', 'Romanoff', 'nat@widow.com', 'custhash9', 'csalt92345678901234567'),
(10, 'Wanda', 'Maximoff', 'wanda@avengers.org', 'custhash10', 'csalt02345678901234567');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `retrieval_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `date`, `retrieval_date`) VALUES
(1, 1, '2026-03-20', '2026-03-22'),
(2, 2, '2026-03-21', '2026-03-23'),
(3, 3, '2026-03-22', '2026-03-24'),
(4, 4, '2026-03-23', '2026-03-25'),
(5, 5, '2026-03-24', '2026-03-26'),
(6, 6, '2026-03-25', '2026-03-27'),
(7, 7, '2026-03-26', '2026-03-28'),
(8, 8, '2026-03-27', '2026-03-29'),
(9, 9, '2026-03-27', '2026-03-30'),
(10, 10, '2026-03-27', '2026-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `order_listings`
--

CREATE TABLE `order_listings` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_listings`
--

INSERT INTO `order_listings` (`id`, `order_id`, `product_id`, `product_amount`) VALUES
(1, 1, 3, 2),
(2, 2, 1, 1),
(3, 3, 8, 1),
(4, 4, 10, 3),
(5, 5, 2, 1),
(6, 6, 4, 2),
(7, 7, 6, 5),
(8, 8, 5, 1),
(9, 9, 9, 2),
(10, 10, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` enum('dog','cat','bird','other') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`id`, `name`, `customer_id`, `type`) VALUES
(1, 'Buddy', 1, 'dog'),
(2, 'Misty', 2, 'cat'),
(3, 'Goldie', 3, 'other'),
(4, 'Tweety', 4, 'bird'),
(5, 'Rex', 5, 'dog'),
(6, 'Luna', 6, 'cat'),
(7, 'Pip', 7, 'bird'),
(8, 'Max', 8, 'dog'),
(9, 'Bella', 9, 'cat'),
(10, 'Shadow', 10, 'dog');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `thumbnail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `stock_quantity`, `category_id`, `brand`, `price`, `thumbnail`) VALUES
(1, 'Chew Toy', 'It\'s like chewing gum, but for your pet and it doesn\'t stick to floors.', 50, 1, 'PetJoy', 9.99, 'chew_toy1.jpg'),
(2, 'Auto Feeder', 'Releases nutrition without you being there. Great for absentee owners.', 10, 5, 'TechPet', 89.99, 'autofeeder1.jpg'),
(3, 'Kibble 5kg', 'Dry food for your dog. It\'s like cereal made of meat not approved for human consumption.', 100, 4, 'NutriBite', 25.50, 'kibble1.jpg'),
(4, 'Grooming Brush', 'The easiest way to get your own felt.', 30, 5, 'ShinyCoat', 12.00, 'pet_brush1.jpg'),
(5, 'Dog Raincoat', 'My code is DRY and your pet will be too.', 15, 3, 'PawsGear', 19.99, 'dog_raincoat1.jpg'),
(6, 'Catnip', 'Merry making mint munchable.', 200, 1, 'HappyCat', 5.00, 'catnip1.jpg'),
(7, 'Bird Cage', 'You can put a bird in a cage sometimes without it being a metaphor.', 5, 1, 'SkyHome', 45.00, 'bird_cage1.jpg'),
(8, 'Flea Collar', 'Not a collar for fleas or a collar that attracts fleas.', 40, 6, 'SafePet', 14.50, 'flea_collar1.jpg'),
(9, 'Squeaky Ball', 'Kinda grim when you think about how it\'s meant to simulate a little animal\'s deathrattle.', 60, 1, 'PetJoy', 4.99, 'squeaky_ball1.jpg'),
(10, 'Fish Flakes', 'It\'s a shame fish will never be able to try dry foods.', 80, 4, 'AquaLife', 7.25, 'fish_feed1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `file_path` text NOT NULL,
  `is_primary` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trusted_devices`
--

CREATE TABLE `trusted_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `device_name` varchar(100) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `two_factor_auth`
--

CREATE TABLE `two_factor_auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `secret` varchar(255) NOT NULL,
  `enabled` tinyint(1) DEFAULT 0,
  `enabled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `two_factor_auth`
--

INSERT INTO `two_factor_auth` (`id`, `user_id`, `secret`, `enabled`, `enabled_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'NCZDWGQSYA2BALYVDVZBNQQRI7KZRCJM', 0, '2026-05-20 00:55:29', '2026-05-20 00:55:29', '2026-05-20 01:50:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password_hash`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Ehsan', 'Hussain', 'AdminE', 'ehsanhussain899@gmail.com', '$2y$12$ZTBJiX3/UUsASOU0wfn1Buy7rWdj2BGrIHrbKez8AZBVRlNGNXxmq', 'customer', '2026-05-19 19:35:02', '2026-05-19 19:35:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pet_id` (`pet_id`),
  ADD KEY `fk_appointments_customer_id` (`customer_id`);

--
-- Indexes for table `cart_listings`
--
ALTER TABLE `cart_listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_listings_products_id` (`product_id`),
  ADD KEY `fk_cart_listings_customer_id` (`customer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_customer_id` (`customer_id`);

--
-- Indexes for table `order_listings`
--
ALTER TABLE `order_listings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_id` (`product_id`),
  ADD KEY `fk_order_id` (`order_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PRODUCT_IMAGES_PRODUCT_ID` (`product_id`);

--
-- Indexes for table `trusted_devices`
--
ALTER TABLE `trusted_devices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `device_token` (`device_token`),
  ADD KEY `idx_device_token` (`device_token`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `two_factor_auth`
--
ALTER TABLE `two_factor_auth`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart_listings`
--
ALTER TABLE `cart_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_listings`
--
ALTER TABLE `order_listings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trusted_devices`
--
ALTER TABLE `trusted_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `two_factor_auth`
--
ALTER TABLE `two_factor_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appointments_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `cart_listings`
--
ALTER TABLE `cart_listings`
  ADD CONSTRAINT `fk_cart_listings_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `fk_cart_listings_products_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_listings`
--
ALTER TABLE `order_listings`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `FK_PRODUCT_IMAGES_PRODUCT_ID` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `trusted_devices`
--
ALTER TABLE `trusted_devices`
  ADD CONSTRAINT `trusted_devices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `two_factor_auth`
--
ALTER TABLE `two_factor_auth`
  ADD CONSTRAINT `two_factor_auth_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
