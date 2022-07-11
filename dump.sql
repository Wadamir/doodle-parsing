-- phpMyAdmin SQL Dump

-- version 4.9.5deb2

-- https://www.phpmyadmin.net/

--

-- Host: localhost:3306

-- Generation Time: Dec 23, 2020 at 12:20 PM

-- Server version: 10.3.25-MariaDB-0ubuntu0.20.04.1

-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */

;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */

;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */

;

/*!40101 SET NAMES utf8mb4 */

;

--

-- Database: `jove`

--

-- --------------------------------------------------------

--

-- Table structure for table `availability`

--

CREATE TABLE `availability` (
    `id` bigint(20) NOT NULL,
    `property_id` bigint(20) NOT NULL,
    `bedroom_cnt` varchar(32) DEFAULT NULL,
    `bathroom_cnt` varchar(32) DEFAULT NULL,
    `listing_price` varchar(32) DEFAULT NULL,
    `home_size_sq_ft` varchar(32) DEFAULT NULL,
    `lease_length` varchar(32) DEFAULT NULL,
    `status` varchar(32) DEFAULT NULL,
    `image_urls` text DEFAULT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4;

-- --------------------------------------------------------

--

-- Table structure for table `properties`

--

CREATE TABLE `properties` (
    `id` bigint(20) NOT NULL,
    `address` varchar(256) DEFAULT NULL,
    `type` varchar(32) DEFAULT NULL,
    `lease_length` varchar(256) DEFAULT NULL,
    `latitude` varchar(64) DEFAULT NULL,
    `longitude` varchar(64) DEFAULT NULL,
    `contact_type` varchar(64) DEFAULT NULL,
    `contact_person` varchar(256) DEFAULT NULL,
    `contact_company` varchar(256) DEFAULT NULL,
    `contact_phone` varchar(32) DEFAULT NULL,
    `contact_email` varchar(128) DEFAULT NULL,
    `building_units` varchar(64) DEFAULT NULL,
    `addr_line_1` varchar(128) DEFAULT NULL,
    `addr_line_2` varchar(128) DEFAULT NULL,
    `city` varchar(64) DEFAULT NULL,
    `state_cd` char(2) DEFAULT NULL,
    `zip5_cd` varchar(32) DEFAULT NULL,
    `image_urls` text DEFAULT NULL,
    `listing_comments` text DEFAULT NULL,
    `virtual_tour_urls` text DEFAULT NULL,
    `pet_policy` text DEFAULT NULL,
    `outdoor_space` varchar(128) DEFAULT NULL,
    `on_premise_services` text DEFAULT NULL,
    `walk_score` varchar(128) DEFAULT NULL,
    `transit_score` varchar(128) DEFAULT NULL,
    `nearby_colleges` text DEFAULT NULL,
    `nearby_rail` text DEFAULT NULL,
    `nearby_transit` text DEFAULT NULL,
    `nearby_shopping` text DEFAULT NULL,
    `nearby_parks` text DEFAULT NULL,
    `nearby_airports` text DEFAULT NULL,
    `neighborhood_comments` text DEFAULT NULL,
    `listing_last_updated` varchar(32) DEFAULT NULL,
    `utilities_included` varchar(256) DEFAULT NULL,
    `building_security` varchar(128) DEFAULT NULL,
    `living_space` varchar(128) DEFAULT NULL,
    `on_premise_features` text DEFAULT NULL,
    `student_features` varchar(256) DEFAULT NULL,
    `kitchen` varchar(256) DEFAULT NULL,
    `parking` text DEFAULT NULL,
    `property_info` text DEFAULT NULL,
    `building_features` text DEFAULT NULL,
    `subdivision` varchar(32) DEFAULT NULL,
    `building_desc` text DEFAULT NULL,
    `building_name` varchar(128) NOT NULL,
    `builiding_office_hours` text DEFAULT NULL,
    `link` varchar(255) NOT NULL,
    `expences` text DEFAULT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
    `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4;

--

-- Indexes for dumped tables

--

--

-- Indexes for table `availability`

--

ALTER TABLE `availability` ADD PRIMARY KEY (`id`);

--

-- Indexes for table `properties`

--

ALTER TABLE `properties` ADD PRIMARY KEY (`id`);

--

-- AUTO_INCREMENT for dumped tables

--

--

-- AUTO_INCREMENT for table `availability`

--

ALTER TABLE
    `availability`
MODIFY
    `id` bigint(20) NOT NULL AUTO_INCREMENT;

--

-- AUTO_INCREMENT for table `properties`

--

ALTER TABLE
    `properties`
MODIFY
    `id` bigint(20) NOT NULL AUTO_INCREMENT;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */

;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */

;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */

;