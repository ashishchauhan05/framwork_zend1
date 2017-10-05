-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2017 at 08:30 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `framwork_zend1`
--

CREATE DATABASE IF NOT EXISTS `framwork_zend1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `framwork_zend1`;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address` varchar(50),
  `landmark` varchar(300) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `zipcode` varchar(300) DEFAULT NULL,
  `state` varchar(300) DEFAULT NULL,
  `reset_token` varchar(500) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` datetime(6) DEFAULT NULL,
  `updated_at` datetime(6) DEFAULT NULL,
  `deleted_at` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`name`, `email`, `password`, `phone`, `gender`, `address`, `landmark`, `city`, `zipcode`, `state`, `reset_token`,`status`, `created_at`, `updated_at`) VALUES ('Super Admin', 'super@admin.com', '123456', '1234567890', 'm', NULL, NULL, NULL, NULL, NULL, NULL,1, '2017-10-01 10:22:11', '2017-10-01 10:22:11');