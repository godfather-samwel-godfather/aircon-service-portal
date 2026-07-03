-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2026 at 03:23 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aircon_service_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `air_conditioners`
--

CREATE TABLE `air_conditioners` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `serial_number` varchar(100) DEFAULT NULL,
  `ac_type` varchar(50) DEFAULT NULL,
  `cooling_capacity` varchar(50) DEFAULT NULL,
  `installation_date` date DEFAULT NULL,
  `installation_address` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `air_conditioners`
--

INSERT INTO `air_conditioners` (`id`, `customer_id`, `nickname`, `brand`, `model`, `serial_number`, `ac_type`, `cooling_capacity`, `installation_date`, `installation_address`, `notes`, `created_at`) VALUES
(1, 1, 'Living Room AC', 'LG', 'LG-S12', 'LG-AC-2026-0001', 'Split', '12000 BTU', '2025-03-15', 'Mbezi Beach, Dar es Salaam', 'Works but not cooling well', '2026-07-02 10:19:27'),
(2, 2, 'living Room AC', 'LG', 'Artcool Inverter V', 'SN-9988776655', 'Split Unit', '12000 BTU', '2024-05-02', 'Mbezi Beach , Dar es salaam', 'haitoi barid vizuri inatoa kelele kubwa wakati wa usiku', '2026-07-02 10:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `technician_id` int(10) UNSIGNED DEFAULT NULL,
  `air_conditioner_id` int(10) UNSIGNED NOT NULL,
  `preferred_date` date DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `problem_description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `emergency` tinyint(1) DEFAULT 0,
  `status` enum('pending_payment','paid','pending_technician','approved','rejected','in_progress','completed','cancelled') DEFAULT 'pending_payment',
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_id`, `technician_id`, `air_conditioner_id`, `preferred_date`, `preferred_time`, `problem_description`, `image`, `emergency`, `status`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-07-03', '10:00:00', 'AC is running but not cooling properly. Possible gas leak.', NULL, 0, 'paid', NULL, '2026-07-02 10:19:27', '2026-07-02 10:19:27'),
(2, 2, 1, 2, '2026-07-02', '15:36:00', 'inahitaji service ya dharura hali ya hewa ni joto sana', NULL, 1, 'completed', NULL, '2026-07-02 10:37:52', '2026-07-02 15:45:48');

-- --------------------------------------------------------

--
-- Table structure for table `booking_services`
--

CREATE TABLE `booking_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `service_category_id` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking_services`
--

INSERT INTO `booking_services` (`id`, `booking_id`, `service_category_id`, `price`) VALUES
(1, 1, 2, '80000.00'),
(2, 1, 4, '70000.00'),
(4, 2, 2, '80000.00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT 'General Inquiry',
  `message` text DEFAULT NULL,
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('new','read','replied') DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `reply`, `replied_at`, `admin_id`, `status`, `created_at`, `user_id`) VALUES
(1, 'godfather godfather', 'godfathersamwel1997@gmail.com', '0683296637', 'AC Installation', 'hi', 'hi nikusaidie nini', '2026-07-02 18:57:40', 1, 'replied', '2026-07-02 18:16:21', NULL),
(2, 'godfather godfather', 'godfathersamwel1997@gmail.com', '0683296637', 'AC Repair', 'ineed service', 'ok wait', '2026-07-02 19:11:31', 1, 'replied', '2026-07-02 19:10:46', NULL),
(3, 'godfather godfather', 'godfathersamwel1997@gmail.com', '0683296637', 'Emergency Repair', 'ican get fast service to my aircon', 'yes you can get welcome to register first and select any service and any technician for you concern', '2026-07-03 11:07:00', 1, 'replied', '2026-07-03 11:05:33', NULL),
(4, 'godfather godfather', 'godfathersamwel1997@gmail.com', '0683296637', 'Emergency Repair', 'hi', 'hello welcome aircon service meet with our certified technician and our servicess', '2026-07-03 11:31:05', 1, 'replied', '2026-07-03 11:29:45', NULL),
(5, 'godfather godfather', 'godfathersamwel1997@gmail.com', '0683296637', 'General Inquiry', 'help me service', 'welcome', '2026-07-03 11:44:04', 1, 'replied', '2026-07-03 11:43:33', NULL),
(6, 'Jackline', 'jackline@gmail.com', '0617571265', 'AC Repair', 'i need faster and good work', 'ok', '2026-07-03 12:57:17', 1, 'replied', '2026-07-03 12:56:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `region` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `region`, `district`, `street_address`, `profile_photo`, `created_at`) VALUES
(1, 2, 'Dar es Salaam', 'Kinondoni', 'Mbezi Beach', NULL, '2026-07-02 10:19:27'),
(2, 4, 'dar es salaam', 'kinondoni', 'mbweni', 'assets/uploads/profiles/profile_1782988063_4888.jpg', '2026-07-02 10:27:43'),
(3, 7, 'dar es salaam', 'kigambon', 'darajan', 'assets/uploads/profiles/profile_1783083013_2374.jpg', '2026-07-03 12:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `fault_reports`
--

CREATE TABLE `fault_reports` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `air_conditioner_id` int(10) UNSIGNED NOT NULL,
  `fault_category` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `urgency_level` enum('low','medium','high','emergency') DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_reference` varchar(100) DEFAULT NULL,
  `status` enum('pending','paid','failed') DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `payment_method`, `transaction_reference`, `status`, `paid_at`, `created_at`) VALUES
(1, 1, '150000.00', 'manual', 'TXN-1-1782987567', 'paid', '2026-07-02 13:19:27', '2026-07-02 10:19:27'),
(2, 2, '80000.00', 'manual', 'TXN-2-1782988688', 'paid', '2026-07-02 13:38:08', '2026-07-02 10:37:52');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `technician_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `image`, `description`, `price`, `status`, `created_at`) VALUES
(1, 'AC Installation', NULL, 'Professional split/window AC installation service.', '120000.00', 'active', '2026-07-02 10:19:27'),
(2, 'AC Repair', NULL, 'Troubleshooting and repair for cooling/system faults.', '80000.00', 'active', '2026-07-02 10:19:27'),
(3, 'AC Maintenance', NULL, 'Routine checkup, cleaning, and performance tuning.', '60000.00', 'active', '2026-07-02 10:19:27'),
(4, 'Gas Refill', NULL, 'Refrigerant refill and leak inspection service.', '70000.00', 'active', '2026-07-02 10:19:27');

-- --------------------------------------------------------

--
-- Table structure for table `service_history`
--

CREATE TABLE `service_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `technician_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `service_date` date DEFAULT NULL,
  `work_done` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_history`
--

INSERT INTO `service_history` (`id`, `booking_id`, `technician_id`, `customer_id`, `service_date`, `work_done`, `remarks`, `created_at`) VALUES
(1, 2, 1, 2, '2026-07-02', 'work nice now', 'gas to fill ac', '2026-07-02 15:45:48');

-- --------------------------------------------------------

--
-- Table structure for table `service_results`
--

CREATE TABLE `service_results` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `technician_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `before_image` varchar(255) DEFAULT NULL,
  `after_image` varchar(255) DEFAULT NULL,
  `work_report` text DEFAULT NULL,
  `parts_used` text DEFAULT NULL,
  `signature_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_results`
--

INSERT INTO `service_results` (`id`, `booking_id`, `technician_id`, `customer_id`, `before_image`, `after_image`, `work_report`, `parts_used`, `signature_image`, `created_at`) VALUES
(1, 2, 1, 2, 'assets/uploads/service_results/before_1783007148_93ac4ea411b8.jpg', 'assets/uploads/service_results/after_1783007148_2e2e26873191.jpg', 'work nice now', 'gas to fill ac', 'assets/uploads/service_results/signature_1783007148_45c2e56b38db.jpg', '2026-07-02 15:45:48');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `years_experience` int(11) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `national_id` varchar(100) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `certificate_file` varchar(255) DEFAULT NULL,
  `service_radius` varchar(100) DEFAULT NULL,
  `verification_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`id`, `user_id`, `company_name`, `years_experience`, `license_number`, `national_id`, `specialization`, `certificate_file`, `service_radius`, `verification_status`, `created_at`) VALUES
(1, 3, 'CoolBreeze HVAC', 6, 'TCH-2026-001-TZ', '19900101-12345-00001-11', 'Installation, Repair, Maintenance', NULL, 'Dar es Salaam', 'approved', '2026-07-02 10:19:27'),
(2, 5, 'smart Air company', 6, 'TCH-2026-000-TZ', '19970727-14126-00003-27', 'AC installation and maintanance', 'assets/uploads/certificates/certificate_1782989479_5271.jpg', 'AC  repair  and installation', 'approved', '2026-07-02 10:51:19'),
(3, 6, 'smart Air company', 10, 'MD-2026-TZ', '20031215357190000120', 'AC installation and maintanance', 'assets/uploads/certificates/certificate_1783082226_7308.jpg', 'AC  repair  and installation', 'approved', '2026-07-03 12:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer','technician') NOT NULL,
  `status` enum('active','inactive','pending','blocked') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'System Admin', 'admin@aircon.com', '0700000000', '$2y$10$lEH.fh/J8yKrJmmGHUJTRObTy5d2k3xJnq2u.s8Zr9KLfcLQO7Z/y', 'admin', 'active', '2026-07-02 10:19:27', '2026-07-02 11:00:40'),
(2, 'Test Customer', 'customer@aircon.com', '0711111111', '$2y$10$inkGfAZTmTPhG8IV0.HQY.1ZyeWjOT6U3Wv9jR.v6VhrXwCs3u.dm', 'customer', 'active', '2026-07-02 10:19:27', '2026-07-02 11:00:40'),
(3, 'Test Technician', 'tech@aircon.com', '0722222222', '$2y$10$bFFxJ1nlcQ.63Op7wJZ8u.m/H2wFT5OZGcUkT.bJgWRBNiToej2tW', 'technician', 'active', '2026-07-02 10:19:27', '2026-07-03 12:53:53'),
(4, 'godfather godfather', 'godfather@gmail.com', '0683296637', '$2y$10$JTGl6yfesoPfYj88d2PCUOrndZ7DHdi9ECMwSgAjwL0ZOfKMWvDs2', 'customer', 'active', '2026-07-02 10:27:43', '2026-07-02 10:27:43'),
(5, 'joan samwel godfather', 'joansamwel2005@gmail.com', '0657835580', '$2y$10$aRP.FCGM3eU1EWqcPtyH7eCKsJdsEHuTlnJT9Y0pUNDjE9Z1EEtCa', 'technician', 'active', '2026-07-02 10:51:19', '2026-07-02 11:06:21'),
(6, 'Naman reginald', 'naamangelard@gmail.com', '0658810635', '$2y$10$gWZwTPBhgjT1t5/kb5u1pulecL/B/qICh9opATqFMI15lMMcj7h/S', 'technician', 'active', '2026-07-03 12:37:06', '2026-07-03 12:38:20'),
(7, 'Jackline Anthony', 'jackline@gmail.com', '061757571265', '$2y$10$HVP4kSQg.UZuzi2Wgt5s3OYD2YoFApd9gZRYmgQ3..If0Ok7yq4vG', 'customer', 'active', '2026-07-03 12:50:13', '2026-07-03 12:50:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `air_conditioners`
--
ALTER TABLE `air_conditioners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_air_conditioners_customer` (`customer_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bookings_customer` (`customer_id`),
  ADD KEY `idx_bookings_technician` (`technician_id`),
  ADD KEY `idx_bookings_air_conditioner` (`air_conditioner_id`);

--
-- Indexes for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_booking_service_once` (`booking_id`,`service_category_id`),
  ADD KEY `idx_booking_services_booking` (`booking_id`),
  ADD KEY `idx_booking_services_service` (`service_category_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_contact_messages_email` (`email`),
  ADD KEY `idx_contact_messages_status` (`status`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_customers_user_id` (`user_id`);

--
-- Indexes for table `fault_reports`
--
ALTER TABLE `fault_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fault_reports_customer` (`customer_id`),
  ADD KEY `idx_fault_reports_air_conditioner` (`air_conditioner_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notifications_user` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_payments_booking` (`booking_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reviews_booking` (`booking_id`),
  ADD KEY `idx_reviews_customer` (`customer_id`),
  ADD KEY `idx_reviews_technician` (`technician_id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_history`
--
ALTER TABLE `service_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_service_history_booking` (`booking_id`),
  ADD KEY `idx_service_history_technician` (`technician_id`),
  ADD KEY `idx_service_history_customer` (`customer_id`);

--
-- Indexes for table `service_results`
--
ALTER TABLE `service_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `technician_id` (`technician_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_technicians_user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `air_conditioners`
--
ALTER TABLE `air_conditioners`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `booking_services`
--
ALTER TABLE `booking_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fault_reports`
--
ALTER TABLE `fault_reports`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_history`
--
ALTER TABLE `service_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_results`
--
ALTER TABLE `service_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `air_conditioners`
--
ALTER TABLE `air_conditioners`
  ADD CONSTRAINT `fk_air_conditioners_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_bookings_air_conditioner` FOREIGN KEY (`air_conditioner_id`) REFERENCES `air_conditioners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bookings_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bookings_technician` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `booking_services`
--
ALTER TABLE `booking_services`
  ADD CONSTRAINT `fk_booking_services_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_booking_services_service` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `fk_customers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fault_reports`
--
ALTER TABLE `fault_reports`
  ADD CONSTRAINT `fk_fault_reports_air_conditioner` FOREIGN KEY (`air_conditioner_id`) REFERENCES `air_conditioners` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_fault_reports_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `fk_reviews_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_reviews_technician` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_history`
--
ALTER TABLE `service_history`
  ADD CONSTRAINT `fk_service_history_booking` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service_history_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_service_history_technician` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_results`
--
ALTER TABLE `service_results`
  ADD CONSTRAINT `service_results_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_results_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `technicians` (`id`),
  ADD CONSTRAINT `service_results_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `technicians`
--
ALTER TABLE `technicians`
  ADD CONSTRAINT `fk_technicians_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
