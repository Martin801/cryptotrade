-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2018 at 05:09 AM
-- Server version: 5.6.38
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webfinst_whtstreet`
--

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_applicationusers`
--

CREATE TABLE IF NOT EXISTS `bitcoin_applicationusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `bitcoin_applicationusers`
--

INSERT INTO `bitcoin_applicationusers` (`id`, `name`, `email`, `phone`, `address`, `password`, `status`) VALUES
(1, 'TEST', 'user1@gmail.com', '789456', 'UK', '$2y$10$.JsO0qhpHXpLIWSQFWGTFu/pYAcqd/bXtmGO3.o908goJhiooypUq', 1),
(2, 'test1', 'test1@gmail.com', '789456', 'UK', '$2y$10$w.G5IpBDSoVkLYBQbFt3O.Uxku0OuLwTeibj1o3LNJ4hDuYybbIri', 1),
(3, 'Martine', 'martine@gmail.com', '98322407444', 'Austrelia', '$2y$10$BzW/V3jWRBsOgqGdNTZGpOJBwKceoeAlX5g1xoDYYKLZ5s6sYjmhy', 1),
(4, 'wwww', 'admin@test22.com', '2343243243243', 'sdfsdfds', '$2y$10$AgYwLuH2it6Iu/Jb/qmPJ.hlGztdudf.NckDUNG.SwQoEhkwOmnoa', 1),
(10, 'Test User', 'aquatechbiswa@gmail.com', '123456', 'test user address', '$2y$10$RCMhGS.GyPIYemQHKU1GT.hPJHVbjMxiZ5XKhiPkMYKtsII4YqcH.', 1),
(11, 'Joydeep', 'user2@gmail.com', '9163331565', 'TEST', '$2y$10$vbZu.L7If9wyQASM/CeTQ.fIP1WhrxIfP8axLIrhFEnrssZmWFIUW', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_bots`
--

CREATE TABLE IF NOT EXISTS `bitcoin_bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `exchange_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `currency_to_spend_earn` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `qty_limit` varchar(255) NOT NULL,
  `amount_limit` varchar(255) NOT NULL,
  `qty_stop_loss_one` varchar(255) NOT NULL,
  `amount_stop_loss_one` varchar(255) NOT NULL,
  `qty_stop_loss_two` varchar(255) NOT NULL,
  `amount_stop_loss_two` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `bitcoin_bots`
--

INSERT INTO `bitcoin_bots` (`id`, `name`, `parent_id`, `user_id`, `exchange_id`, `type`, `currency`, `currency_to_spend_earn`, `qty`, `amount`, `qty_limit`, `amount_limit`, `qty_stop_loss_one`, `amount_stop_loss_one`, `qty_stop_loss_two`, `amount_stop_loss_two`, `status`, `created_date`) VALUES
(1, 'BOT-1521540580', 0, 1, 4, 'Buy', 'BTC', 'DOGE', '0.00100000', '', '', '', '', '', '', '', 'Success', '2018-03-20'),
(2, 'BOT-1521541976', 0, 1, 4, 'Buy', 'BTC', 'DOGE', '0.00100000', '', '', '', '', '', '', '', 'Success', '2018-03-20'),
(4, 'BOT-1521542186', 2, 1, 4, 'Sell', 'DOGE', 'BTC', '0.00100000', '1', '0.00100000', '5', '0.00100000', '1', '0.00100000', '5', 'Success', '2018-03-20'),
(5, 'BOT-1521542208', 1, 1, 4, 'Sell', 'DOGE', 'BTC', '0.00100000', '1', '0.00100000', '5', '0.00100000', '1', '0.00100000', '5', 'Success', '2018-03-20'),
(6, 'BOT-1521551349', 0, 1, 3, 'Buy', 'BTC', 'LTC', '0.02128517', '', '', '', '', '', '', '', 'Success', '2018-03-20'),
(8, 'BOT-1521889142', 0, 1, 4, 'Buy', 'BTC', 'DOGE', '0.001', '', '', '', '', '', '', '', 'Success', '2018-03-24'),
(9, 'BOT-1521889294', 6, 1, 3, 'Sell', 'LTC', 'BTC', '0.02128517', '1', '0.02128517', '5', '0.02128517', '1', '0.02128517', '5', 'Pending', '2018-03-24'),
(10, 'BOT-1522182298', 0, 1, 4, 'Buy', 'BTC', 'QTUM', '0.002', '', '', '', '', '', '', '', 'Pending', '2018-03-27'),
(11, 'BOT-1522182298', 10, 1, 4, 'Sell', 'QTUM', 'BTC', '0.001', '2', '0.001', '3', '0.001', '5', '0.001', '10', 'Pending', '2018-03-27'),
(12, 'BOT-1522215253', 0, 1, 4, 'Buy', 'BTC', 'DOGE', '0.001', '', '', '', '', '', '', '', 'Success', '2018-03-28'),
(13, 'BOT-1522215253', 12, 1, 4, 'Sell', 'DOGE', 'BTC', '0.001', '1', '0.001', '1', '0.001', '1', '0.001', '1', 'Success', '2018-03-28');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_bots_lsl`
--

CREATE TABLE IF NOT EXISTS `bitcoin_bots_lsl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bot_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL,
  `qty` varchar(255) NOT NULL,
  `persentage` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_exchange`
--

CREATE TABLE IF NOT EXISTS `bitcoin_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bitcoin_exchange`
--

INSERT INTO `bitcoin_exchange` (`id`, `name`, `status`, `created_date`, `edited_date`) VALUES
(1, 'Cryptopia', 1, '2017-12-21 18:57:37', '2017-12-21 18:57:37'),
(2, 'Binance', 1, '2017-12-21 18:57:19', '2017-12-21 18:57:19'),
(3, 'Yobit', 1, '2017-12-21 18:57:28', '2017-12-21 18:57:28'),
(4, 'Bittrex', 1, '2017-12-21 18:51:35', '2017-12-21 18:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_membership`
--

CREATE TABLE IF NOT EXISTS `bitcoin_membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `details` longtext NOT NULL,
  `duration` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `edited_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` varchar(255) NOT NULL,
  `lavel_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `bitcoin_membership`
--

INSERT INTO `bitcoin_membership` (`id`, `name`, `details`, `duration`, `status`, `created_date`, `edited_date`, `price`, `lavel_id`) VALUES
(1, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 1, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '1', '1'),
(2, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 2, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '100', '1'),
(3, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 1, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '20', '2'),
(4, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 2, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '200', '2'),
(5, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 1, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '35', '3'),
(6, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 2, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '350', '3'),
(7, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 1, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '60', '4'),
(8, '1 Exchange Monthly subscriptions', '1 Exchange Monthly subscriptions', 2, 1, '2018-01-25 05:06:43', '2018-01-25 05:06:43', '600', '4'),
(9, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '20', '1'),
(10, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '200', '1'),
(11, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '40', '2'),
(12, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '400', '2'),
(13, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '70', '3'),
(14, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '700', '3'),
(15, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '120', '4'),
(16, '2 Exchanges Monthly subscriptions', '2 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:15:49', '2018-01-25 05:15:49', '1200', '4'),
(17, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '35', '1'),
(18, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '350', '1'),
(19, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '70', '2'),
(20, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '700', '2'),
(21, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '120', '3'),
(22, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '1200', '3'),
(23, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '200', '4'),
(24, '4 Exchanges Monthly subscriptions', '4 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:21:32', '2018-01-25 05:21:32', '2000', '4'),
(25, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '30', '1'),
(26, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '300', '1'),
(27, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '60', '2'),
(28, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '600', '2'),
(29, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '105', '3'),
(30, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '1050', '3'),
(31, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 1, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '180', '4'),
(32, '3 Exchanges Monthly subscriptions', '3 Exchanges Monthly subscriptions', 2, 1, '2018-01-25 05:26:16', '2018-01-25 05:26:16', '1800', '4');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_membership_duration`
--

CREATE TABLE IF NOT EXISTS `bitcoin_membership_duration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duration` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=enable/2=disable',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bitcoin_membership_duration`
--

INSERT INTO `bitcoin_membership_duration` (`id`, `duration`, `status`) VALUES
(1, 'Monthly', '1'),
(2, 'Yearly', '1');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_membership_exchange_rel`
--

CREATE TABLE IF NOT EXISTS `bitcoin_membership_exchange_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `exchange_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `bitcoin_membership_exchange_rel`
--

INSERT INTO `bitcoin_membership_exchange_rel` (`id`, `membership_id`, `exchange_id`) VALUES
(9, 3, 1),
(10, 6, 4),
(11, 5, 3),
(24, 4, 2),
(25, 4, 3),
(26, 1, 1),
(27, 1, 2),
(28, 1, 3),
(29, 1, 4),
(30, 9, 1),
(31, 9, 2),
(32, 9, 3),
(33, 9, 4),
(34, 17, 1),
(35, 17, 2),
(36, 17, 3),
(37, 17, 4),
(38, 25, 1),
(39, 25, 2),
(40, 25, 3),
(41, 25, 4);

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_membership_lavel`
--

CREATE TABLE IF NOT EXISTS `bitcoin_membership_lavel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('1','2') NOT NULL COMMENT '1=enable/2=disable',
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bitcoin_membership_lavel`
--

INSERT INTO `bitcoin_membership_lavel` (`id`, `name`, `description`, `status`, `created_at`) VALUES
(1, 'The Beginner', 'The Beginner level access grants the ability to place 1 trade at a time', '1', '2018-01-25'),
(2, 'The 3-Pack', 'The 3-Pack level access grants the ability to place 3 trades at a time', '1', '2018-01-25'),
(3, 'The Lucky 7', 'The Lucky 7 level access grants the ability to place 7 trades at a time', '1', '2018-01-25'),
(4, 'The Legacy Builder', 'The Legacy Builder', '1', '2018-01-25');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_membership_type`
--

CREATE TABLE IF NOT EXISTS `bitcoin_membership_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memebertype` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_migrations`
--

CREATE TABLE IF NOT EXISTS `bitcoin_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bitcoin_migrations`
--

INSERT INTO `bitcoin_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_password_resets`
--

CREATE TABLE IF NOT EXISTS `bitcoin_password_resets` (
  `email` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_robot_tradess`
--

CREATE TABLE IF NOT EXISTS `bitcoin_robot_tradess` (
  `robot_id` int(11) NOT NULL AUTO_INCREMENT,
  `bot_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `exchange_id` int(11) NOT NULL,
  `market` varchar(255) NOT NULL,
  `type_of_trade` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `result` text,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`robot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `bitcoin_robot_tradess`
--

INSERT INTO `bitcoin_robot_tradess` (`robot_id`, `bot_id`, `user_id`, `exchange_id`, `market`, `type_of_trade`, `volume`, `price`, `result`, `datetime`) VALUES
(1, 1, 1, 4, 'BTC-DOGE', 'Buy', '0.00100000', '0.00000041', '{"success":true,"message":"","result":{"uuid":"999b74bc-46a5-4b8c-a6cb-e0e42ba9d5da"}}', '2018-03-20 10:07:01'),
(2, 2, 1, 4, 'BTC-DOGE', 'Buy', '0.00100000', '0.00000041', '{"success":true,"message":"","result":{"uuid":"1b90df9a-de0a-4c6d-bbd2-e4d1f9f97e88"}}', '2018-03-20 10:33:02'),
(3, 4, 1, 4, 'BTC-DOGE', 'Sell', '0.00100000', '0.0000004', '{"success":true,"message":"","result":{"uuid":"fa9ca4fe-e02d-48ea-97f3-f25f9747f1e1"}}', '2018-03-20 10:44:21'),
(4, 4, 1, 4, 'BTC-DOGE', 'Sell', '0.00100000', '0.0000004', '{"success":true,"message":"","result":{"uuid":"f6c1fd5d-3185-4fd0-8c51-659711b886e4"}}', '2018-03-20 10:44:21'),
(5, 5, 1, 4, 'BTC-DOGE', 'Sell', '0.00100000', '0.0000004', '{"success":false,"message":"INSUFFICIENT_FUNDS","result":null}', '2018-03-20 10:44:21'),
(6, 5, 1, 4, 'BTC-DOGE', 'Sell', '0.00100000', '0.0000004', '{"success":false,"message":"INSUFFICIENT_FUNDS","result":null}', '2018-03-20 10:44:22'),
(8, 6, 1, 3, 'LTC_BTC', 'Buy', '0.02128517', '0.01888', '{"success":1,"return":{"received":0,"remains":0.02128517,"order_id":100001567905247,"funds":{"btc":0.01919568,"ltc":0.02128517,"sigt":0,"yob2x":0,"bcd":0,"liza":0,"ubtc":0,"bth":0,"sbtc":0,"lbtc":0,"god":0,"bcp":0,"bum":0,"btcs":0,"btdoll":0.02},"funds_incl_orders":{"btc":0.01959834,"ltc":0.02128517,"sigt":0,"yob2x":0,"bcd":0,"liza":0,"ubtc":0,"bth":0,"sbtc":0,"lbtc":0,"god":0,"bcp":0,"bum":0,"btcs":0,"btdoll":0.02},"server_time":1521552304}}', '2018-03-20 13:25:04'),
(10, 8, 1, 4, 'BTC-DOGE', 'Buy', '0.001', '0.00000041', '{"success":true,"message":"","result":{"uuid":"05b6f251-9d0f-45d7-9170-b26d5b3c5107"}}', '2018-03-24 11:00:03'),
(11, 12, 1, 4, 'BTC-DOGE', 'Buy', '0.001', '0.0000004', '{"success":true,"message":"","result":{"uuid":"9a817e62-41c7-4efa-a0dc-d4d1379bb9e6"}}', '2018-03-28 05:34:32'),
(12, 13, 1, 4, 'BTC-DOGE', 'Sell', '0.001', '0.00000039', '{"success":true,"message":"","result":{"uuid":"5161668b-f767-46bc-be01-a36e8522ef39"}}', '2018-03-28 05:34:33'),
(13, 13, 1, 4, 'BTC-DOGE', 'Sell', '0.001', '0.00000039', '{"success":true,"message":"","result":{"uuid":"2e18f456-368b-4e50-90f5-f4d911b47a1d"}}', '2018-03-28 05:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_users`
--

CREATE TABLE IF NOT EXISTS `bitcoin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bitcoin_users`
--

INSERT INTO `bitcoin_users` (`id`, `name`, `email`, `profile_img`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@test.com', '1521711143.jpg', '$2y$10$uLCW5g4Dj39BcoJw.GoAyOe2BUJUxUe6VfMbmZuRFAVYf/eNzafz2', '6o64bJ9Xe9fzXaqRfsMeGxO4PhwmJBiFTazpm6fprCJhzjjzcEBto6pQQQbD', '2017-12-15 04:31:05', '2017-12-15 04:31:05');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_user_membership`
--

CREATE TABLE IF NOT EXISTS `bitcoin_user_membership` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `exchange_id` int(11) NOT NULL,
  `api_key` varchar(255) DEFAULT ' ',
  `api_secret` varchar(255) DEFAULT ' ',
  `buy_currency` varchar(255) NOT NULL,
  `buy_qty` double(17,17) NOT NULL,
  `buy_amount` double(17,17) NOT NULL,
  `sell_currency` varchar(255) NOT NULL,
  `sell_qty` double(17,17) NOT NULL,
  `sell_amount` double(17,17) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `bitcoin_user_membership`
--

INSERT INTO `bitcoin_user_membership` (`id`, `user_id`, `membership_id`, `exchange_id`, `api_key`, `api_secret`, `buy_currency`, `buy_qty`, `buy_amount`, `sell_currency`, `sell_qty`, `sell_amount`, `created_date`, `expiry_date`) VALUES
(1, 1, 4, 4, 'f62ead84f1b843fc800b25a427945327', '2b18f0598ec04d549d669f47e0671746', 'BTC', 0.00661370129898090, 0.08206998000000000, 'ETH', 0.00661370129898090, 0.08206998000000000, '2017-12-27 10:58:59', '2018-12-22'),
(2, 1, 4, 3, 'EEDD809A6BB412584D362854BF137628', 'a3d806572ebca0be4688df8590be958e', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2017-12-27 10:58:59', '2018-12-22'),
(3, 1, 4, 1, 'fae6f6d91eb948e99c5cfb184b8bc277', 'eZLfbl3auOI/iirSf8wkwk3VcbITr3s1JEqjY+fchpw=', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2017-12-27 08:39:51', '2018-12-22'),
(4, 1, 4, 2, 'RKPtIzwOfePQtKxwyk018fvLgTGX3IgwWvj9kYjNGE8XOiiYksShIJWsQPyH2WYR', 'A8X6HzvdTEFz5ns5AZ8DIi68b3nxPvGlmpaUXzvKkHUK0yWKo1gkGmnHagJU8hTu', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2017-12-27 08:39:51', '2018-12-22'),
(9, 10, 1, 1, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-01-31 01:45:54', '2018-02-01'),
(10, 10, 1, 2, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-01-31 01:45:54', '2018-02-01'),
(11, 10, 1, 3, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-01-31 01:45:54', '2018-02-01'),
(12, 10, 1, 4, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-01-31 01:45:54', '2018-02-01'),
(13, 11, 17, 1, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-02-22 14:44:00', '2018-02-23'),
(14, 11, 17, 2, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-02-22 14:44:00', '2018-02-23'),
(15, 11, 17, 3, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-02-22 14:44:00', '2018-02-23'),
(16, 11, 17, 4, ' ', ' ', '', 0.00000000000000000, 0.00000000000000000, '', 0.00000000000000000, 0.00000000000000000, '2018-02-22 14:44:00', '2018-02-23');

-- --------------------------------------------------------

--
-- Table structure for table `bitcoin_user_payment`
--

CREATE TABLE IF NOT EXISTS `bitcoin_user_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `membership_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `price` varchar(255) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `transaction_status` varchar(255) NOT NULL,
  `exchange_data` longtext NOT NULL,
  `payment_date` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `bitcoin_user_payment`
--

INSERT INTO `bitcoin_user_payment` (`id`, `user_id`, `membership_id`, `duration`, `price`, `transaction_id`, `transaction_status`, `exchange_data`, `payment_date`) VALUES
(1, 1, 4, 2, '2', 'PAY-2NN61249K05893947LJBS62I', 'approved', '[{"id":13,"name":"Binance Membership","details":"Binance Exchange","duration":2,"status":1,"created_date":"2017-12-22 12:13:01","edited_date":"2017-12-22 12:13:01","price":"2","membership_id":4,"exchange_id":1},{"id":14,"name":"Binance Membership","details":"Binance Exchange","duration":2,"status":1,"created_date":"2017-12-22 12:13:01","edited_date":"2017-12-22 12:13:01","price":"2","membership_id":4,"exchange_id":3}]', '2018-01-31 06:45:54'),
(2, 2, 6, 2, '4', 'PAY-8NK710726U381912JLJB2E3Q', 'approved', '[{"id":10,"name":"Poloniex Membership","details":"Poloniex Exchange","duration":2,"status":1,"created_date":"2017-12-22 12:13:50","edited_date":"2017-12-22 12:13:50","price":"4","membership_id":6,"exchange_id":4}]', '2018-01-31 06:45:54'),
(4, 10, 1, 1, '1', 'PAY-2ES373146J144912FLJYWMCQ', 'approved', '[{"id":26,"name":"1 Exchange Monthly subscriptions","details":"1 Exchange Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:06:43","edited_date":"2018-01-25 05:06:43","price":"1","lavel_id":"1","membership_id":1,"exchange_id":1},{"id":27,"name":"1 Exchange Monthly subscriptions","details":"1 Exchange Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:06:43","edited_date":"2018-01-25 05:06:43","price":"1","lavel_id":"1","membership_id":1,"exchange_id":2},{"id":28,"name":"1 Exchange Monthly subscriptions","details":"1 Exchange Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:06:43","edited_date":"2018-01-25 05:06:43","price":"1","lavel_id":"1","membership_id":1,"exchange_id":3},{"id":29,"name":"1 Exchange Monthly subscriptions","details":"1 Exchange Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:06:43","edited_date":"2018-01-25 05:06:43","price":"1","lavel_id":"1","membership_id":1,"exchange_id":4}]', '2018-01-31 06:45:54'),
(5, 11, 17, 1, '35', 'PAY-8UH11264GS7864314LKHITKQ', 'approved', '[{"id":34,"name":"4 Exchanges Monthly subscriptions","details":"4 Exchanges Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:21:32","edited_date":"2018-01-25 05:21:32","price":"35","lavel_id":"1","membership_id":17,"exchange_id":1},{"id":35,"name":"4 Exchanges Monthly subscriptions","details":"4 Exchanges Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:21:32","edited_date":"2018-01-25 05:21:32","price":"35","lavel_id":"1","membership_id":17,"exchange_id":2},{"id":36,"name":"4 Exchanges Monthly subscriptions","details":"4 Exchanges Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:21:32","edited_date":"2018-01-25 05:21:32","price":"35","lavel_id":"1","membership_id":17,"exchange_id":3},{"id":37,"name":"4 Exchanges Monthly subscriptions","details":"4 Exchanges Monthly subscriptions","duration":1,"status":1,"created_date":"2018-01-25 05:21:32","edited_date":"2018-01-25 05:21:32","price":"35","lavel_id":"1","membership_id":17,"exchange_id":4}]', '2018-02-22 09:14:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
