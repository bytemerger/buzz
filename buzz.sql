-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2018 at 11:55 PM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buzz`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `sendFriend` varchar(55) NOT NULL,
  `acceptFriend` varchar(55) NOT NULL,
  `accepted` int(11) NOT NULL,
  `seen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`sendFriend`, `acceptFriend`, `accepted`, `seen`) VALUES
('chuk', 'adg', 1, 0),
('chuk', 'key1', 1, 0),
('chuke', 'key1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `loginSelector` varchar(500) NOT NULL,
  `loginToken` varchar(255) NOT NULL,
  `loginUserName` varchar(50) NOT NULL,
  `loginExpires` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `sender` varchar(55) NOT NULL,
  `acceptor` varchar(55) NOT NULL,
  `text` mediumtext NOT NULL,
  `time` datetime NOT NULL,
  `seen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`sender`, `acceptor`, `text`, `time`, `seen`) VALUES
('key1', 'chuk', 'how are you', '2018-11-13 23:34:01', 0),
('chuk', 'key1', 'i am fine', '2018-11-13 23:34:39', 1),
('chuk', 'key1', 'please review this', '2018-11-13 23:34:53', 1),
('chuk', 'key1', 'About WAAVI\n\nWAAVI is a Spanish web development and product consulting agency, working with Startups and other online businesses since 2013. Need to get work done in Laravel or PHP? Contact us through waavi.com.\nIntroduction\n\nWAAVI Sanitizer provides an easy way to format user input, both through the provided filters or through custom ones that can easily be added to the sanitizer library.\n\nAlthough not limited to Laravel 5 users, there are some extensions provided for this framework, like a way to easily Sanitize user input through a custom FormRequest and easier extensibility.', '2018-11-13 23:35:18', 1),
('key1', 'chuk', 'nice work', '2018-11-13 23:36:04', 0),
('key1', 'chuk', 'when was it done', '2018-11-13 23:36:14', 0),
('key1', 'chuk', 'ok', '2018-11-14 14:08:34', 0),
('key1', 'chuk', 'i think it is working', '2018-11-14 14:30:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `firstName`, `lastName`, `email`) VALUES
('chuke', '$2y$10$qPmCfuBwmDEf8vB.juaUsOtFc8rvtQzmqqPzEu9jtq7OAE4bS65hS', 'chukwi', 'mba', 'chuke@gmail.com'),
('adg', '$2y$10$r7PG4VvT9iyQe/84d14wNOL3hwZwkVV6FTUnb8vsJKHZIgRyt5E96', 'adb', 'adg', 'adbg@gmail.com'),
('key1', '$2y$10$6VymFJrWm8YwwNdY6idT7etXmCfwUeX46jAbjfz5Pd.BtWbX8/lHC', 'sdf', 'adb', 'fr@gmail.com'),
('hiwn', '$2y$10$wRuvit6Ng5/ocQgJNsylJuE2sAwHa4p8cY0h85fZlVvB2fc3HTAJy', 'lag', 'chiwn', 'lag@yahoo.com'),
('chuk', '$2y$10$qEijODJSBnvMHtIBdcb2Le1akyFnERZwW.qWTnfFdkohgQx4cLYuO', 'vic', 'abaga', 'aba@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
