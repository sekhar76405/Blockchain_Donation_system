-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2022 at 08:24 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Create a database with any name(here: login) and after that update the same in config.php
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_camp`
--

CREATE TABLE `active_camp` (
  `c_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `total_amt` int(100) NOT NULL,
  `raised_amt` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `active_camp`
--

INSERT INTO `active_camp` (`c_id`, `u_id`, `title`, `description`, `start_time`, `end_time`, `total_amt`, `raised_amt`) VALUES
(46, 26, 'Captain Tomâ€™s Walk for the NHS', 'Without a doubt one of the most inspiring and acclaimed fundraising campaigns of recent years. While the circumstances were unprecedented, not to mention unfortunate, Captain Tomâ€™s efforts came to represent a nationwide message of coming together in times of crisis, capturing the hearts and minds of the UK.', '2022-05-16 02:01:00', '2022-05-29 02:01:00', 15000, 5600),
(47, 25, 'Wings for life - World Run', 'Setting physical challenges is a tried and tested way of fundraising. While there will always be space for charity marathons and boat races, more unconventional sports events can attract more attention. Wings For Life, a charity that funds research into spinal cord injury, has shaken up the classic charity run with a new format. Instead of aiming to run a certain distance, participants have to get as far as possible within 30 minutes â€“ a chaser car sets off after half an hour and as soon as it passes you, your race is up. This inevitably ups the pace of the run and makes for good viewing â€“ the token man in rhino suit has to get a wiggle on.', '2022-05-16 02:04:00', '2022-05-20 02:05:00', 50000, 720),
(48, 29, 'Movember', 'You mightâ€™ve noticed more gents sporting facial hair in the run-up to Christmas over the past few years. Some pull it off, others donâ€™t. Regardless, a furry upper lip isnâ€™t just a passing fad but the result of an effective fundraising campaign run by Movember. The fundraising concept is simple â€“ encourage guys (and girls) to grow out their tash for the month of November and collect donations for the pleasure. All money goes towards tackling male health issues such as prostate cancer.', '2022-05-16 04:33:00', '2022-05-23 04:33:00', 560000, 15850),
(53, 27, 'Need of study', 'annfoinfw', '2022-08-04 23:45:00', '2022-08-08 23:45:00', 1200, 0);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `u_id` int(100) NOT NULL,
  `c_id` int(100) NOT NULL,
  `amt` int(100) NOT NULL,
  `time` datetime NOT NULL,
  `transaction_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`u_id`, `c_id`, `amt`, `time`, `transaction_hash`) VALUES
(27, 48, 500, '2022-05-16 04:50:26', '0x32242c8a6fba3eef84f2cc3002e74126edb409065117574cf9fac7b98679034b'),
(27, 47, 100, '2022-05-16 04:52:45', '0xa5c8a53faf63df261192cd07f005895dd6940493fc1dec500dd530cbd860caa1'),
(31, 46, 100, '2022-05-16 05:10:47', '0xdd563702902108cd258076acb580385aa187cb7b5518ec68ca15618423500008'),
(31, 48, 250, '2022-05-16 05:12:31', '0xfcbeb95494923a4eab011efbde9453f18a4f0bb0dd695cf70c8d8a04acec2a2f'),
(31, 47, 620, '2022-05-16 05:13:16', '0xa2d93dbf855dd42d5a1822d1babb71cf3c0bcf5beed03620f743edad44244473'),
(31, 50, 1000, '2022-05-16 05:15:37', '0x4f6785338897c87dd370a90a96f00e871b713289ee9c407ce2ff0b908b967cdf'),
(26, 48, 100, '2022-05-16 05:18:25', '0xa9f7798e113d00471aebcef05d180b656fd67ec0c36942b333f9e23f4a9ab8cf'),
(26, 50, 360, '2022-05-16 05:18:51', '0x0d82e8f42ed262d7a03f680250a122b5bde27d7e4755f3700ffd564db0562400'),
(29, 50, 5000, '2022-05-16 10:45:16', '0x1226a4eb4370ab6b53fc02e7cfaa3281672da4ea938e1d79401e3607bddef190'),
(30, 46, 5500, '2022-05-16 10:49:26', '0xa2685f6e2623763411c2fb6265a809984dd083e99a081423995d2623b6e5b86a'),
(30, 50, 1000, '2022-05-16 10:50:18', '0x7c35af55084af08de0269f5a59eea5c225efe26e99afce9d23af367d00ef5dfb'),
(30, 48, 15000, '2022-05-16 10:51:12', '0x7fc83d85b746ad15ad498092b5a3cd44db5dbb00aabf046d6992e612d32eb4d6'),
(25, 51, 5000, '2022-06-11 20:12:59', '0xc0f9c3c9b25ee9296865b8d029105dec55ada0be69691b09f2ba58fe106f3e37');

-- --------------------------------------------------------

--
-- Table structure for table `prev_camp`
--

CREATE TABLE `prev_camp` (
  `c_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `title` varchar(500) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `total_amt` int(100) NOT NULL,
  `raised_amt` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prev_camp`
--

INSERT INTO `prev_camp` (`c_id`, `u_id`, `title`, `description`, `start_time`, `end_time`, `total_amt`, `raised_amt`) VALUES
(0, 27, 'Help Piper See Again', 'Our furry, four-legged friends sometimes get sick and need to undergo expensive surgery. Other times, someone might need to cover the costs associated with adopting a service animal or pet. And sometimes, you just want to help out your worthy, local animal shelter. Whatever the case is, you can use crowdfunding to pay for the expenses that come with caring for an animal in need. The organizer of this crowdfunding campaign posted four updates that let Piperâ€™s supporters know how she was recuperating. Posting updates helps to connect your donors to your campaign and keeps them in the loop.', '2022-05-16 05:13:00', '2022-05-16 05:14:01', 100000, 0),
(0, 27, 'Help Piper See Again', 'Our furry, four-legged friends sometimes get sick and need to undergo expensive surgery. Other times, someone might need to cover the costs associated with adopting a service animal or pet. And sometimes, you just want to help out your worthy, local animal shelter. Whatever the case is, you can use crowdfunding to pay for the expenses that come with caring for an animal in need. The organizer of this crowdfunding campaign posted four updates that let Piperâ€™s supporters know how she was recuperating. Posting updates helps to connect your donors to your campaign and keeps them in the loop.', '2022-05-16 05:14:00', '2022-06-11 20:11:18', 160000, 7360),
(0, 32, '', '', '0000-00-00 00:00:00', '2022-08-04 12:36:16', 0, 0),
(0, 27, 'Need for Study', 'I Really need money for my B, Tech Education.', '2022-06-11 20:11:00', '2022-08-04 23:45:27', 100000, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `phonenumber` int(10) NOT NULL,
  `metamaskID` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `email`, `password`, `firstname`, `lastname`, `phonenumber`, `metamaskID`) VALUES
(25, 'somasekhar@gmail.com', '$2y$10$v2AI5uOAyEojd4FgTi3gQuvH8PFDnfwJKCQj3Y2z1uaZxZ.XoW3xu', 'Somasekhar', 'Mukkamala', 2147483647, '0x43ad213fdf08c81deda2ed0dd8d3b6975d11df9a'),
(26, 'aryanmukerji@gmail.com', '$2y$10$bHAz2G7KqHKxaOm5wUoaH..B7MmX5QnBzSNmEmvIw8xS8jvap3.cq', 'Aryan', 'Mukerji', 2147483647, '0x2296233aeb39be748ca1904fe5f482076b2cae03'),
(27, 'hardik@gmail.com', '$2y$10$/x0PpMXQesaAwMgoGItd8eHHW7xcHgVmsKu3doJWdjdBdL7JCHrM.', 'Hardik', 'Garg', 2147483647, '0x508fef491f90d96f23d7ad385785f54017166cf4'),
(29, 'nandit@gmail.com', '$2y$10$gKC/9ysNyKbXKFugLsDxDOo8H8tNbFfcS72fGGua4wzhk7dxO7t9u', 'Nandit', 'Srivastava', 2147483647, '0x196635b91a59f5754348d1896d8d70c1e8b66c58'),
(30, 'sheshu@gmail.com', '$2y$10$1UwFSn7Bhn/KOZ2ikS0lB.jgRZWdw1YWLkit/pD4hAx1jUJFfmEMG', 'Sheshu', 'Kumar', 2147483647, '0x8c6a23fa58f1abbc7ffc8eaf4b93a37ba574155b'),
(31, 'asingh@gmail.com', '$2y$10$/t9h7MXED9/nKGljBI5CyuYVupum234PniWkfALmlgNpTQmGWXz8K', 'Anmol', 'Singh', 2147483647, '0xca53006ed191333c9cc203017b80ed882c2cbb19'),
(32, 'test@email.com', '$2y$10$/u.rTBEFC2orwZziz/DlKO4Uu3wl31z16sxNlZSG7yahO6nxLzpzG', 'test', 'name', 2147483647, '0x43ad213fdf08c81deda2ed0dd8d3b6975d11df9a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_camp`
--
ALTER TABLE `active_camp`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `active_camp`
--
ALTER TABLE `active_camp`
  MODIFY `c_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
