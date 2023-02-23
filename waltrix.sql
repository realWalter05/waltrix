-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2023 at 04:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `waltrix`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(120) COLLATE utf8_czech_ci NOT NULL,
  `password` text COLLATE utf8_czech_ci NOT NULL,
  `cookie_token` text COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `cookie_token`) VALUES
(1, 'Walter', 'zikavaclav05@gmail.com', '$2y$10$.symIASas0ioR5S.58mHnOPwthXZUhsf5n78hFrqt8DFj/qQsWr/C', '$2y$10$SxDrl3x3jfkC9NPZkRxb8eJqwsa4mQJun7Ji1ooL97etxLzmuhLjK'),
(6, 'ZackCZ_', 'zdenek30@post.cz', '$2y$10$k0QR8HuKKxKt3q6/oFIY.ehptswEbcYawC18fQ37zuUfr.F4wmiEW', NULL),
(7, 'S1vyX', 'simonvanecek@seznam.cz', '$2y$10$xucK5Z29zHwOOkL7OaD1IOkDPceV2fSsa9kY/C5E/3Yju/cQlWYPe', '$2y$10$w.1Dq1TZVIHWmasUvvuupup4RMlFlv3yuVb/GvLaCmLt7q40EiHz2'),
(8, 'Joe Who', 'mamajoe@gmail.com', '$2y$10$HiXjt1xrjvHWZ0vf28LTkelFO19W.rQd.FXd0dOp2Na9JkpEsaWRu', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `watched_movies`
--

CREATE TABLE `watched_movies` (
  `id` int(11) NOT NULL,
  `tmdb_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `watched_movies`
--

INSERT INTO `watched_movies` (`id`, `tmdb_id`, `user_id`) VALUES
(9, 74465, 1);

-- --------------------------------------------------------

--
-- Table structure for table `watched_series`
--

CREATE TABLE `watched_series` (
  `id` int(11) NOT NULL,
  `tmdb_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `episode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `watched_series`
--

INSERT INTO `watched_series` (`id`, `tmdb_id`, `user_id`, `season`, `episode`) VALUES
(24, 94997, 1, 1, 1),
(25, 94997, 1, 1, 2),
(26, 94997, 1, 1, 3),
(27, 1434, 1, 1, 1),
(28, 1434, 1, 1, 2),
(29, 1434, 1, 1, 3),
(30, 1434, 1, 1, 4),
(31, 1434, 1, 1, 5),
(32, 1434, 1, 1, 6),
(33, 1434, 1, 1, 7),
(34, 1434, 1, 2, 1),
(35, 1434, 1, 2, 3),
(36, 1434, 1, 2, 4),
(37, 1434, 1, 2, 5),
(38, 37680, 1, 5, 15),
(39, 37680, 1, 5, 16),
(40, 1434, 1, 2, 6),
(41, 94997, 1, 1, 4),
(42, 37680, 1, 6, 1),
(43, 37680, 1, 6, 2),
(44, 37680, 1, 6, 3),
(45, 37680, 1, 6, 4),
(46, 2288, 1, 1, 1),
(47, 2288, 1, 1, 2),
(48, 1434, 1, 2, 7),
(49, 94997, 7, 1, 1),
(50, 37680, 1, 6, 5),
(51, 2288, 1, 1, 3),
(52, 94997, 1, 1, 5),
(53, 76479, 7, 1, 1),
(54, 37680, 1, 6, 9),
(55, 76479, 7, 1, 2),
(56, 76479, 7, 1, 3),
(57, 76479, 7, 1, 4),
(58, 76479, 7, 1, 5),
(59, 76479, 7, 1, 6),
(60, 76479, 7, 1, 7),
(61, 76479, 7, 1, 8),
(62, 94997, 1, 1, 6),
(63, 37680, 1, 6, 6),
(64, 37680, 1, 6, 7),
(65, 37680, 1, 6, 8),
(66, 37680, 1, 6, 10),
(67, 37680, 1, 6, 11),
(68, 76479, 7, 2, 1),
(69, 2710, 1, 13, 8),
(70, 1434, 1, 2, 8),
(71, 1434, 1, 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `watching_movies`
--

CREATE TABLE `watching_movies` (
  `id` int(11) NOT NULL,
  `tmdb_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `watched` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `watching_movies`
--

INSERT INTO `watching_movies` (`id`, `tmdb_id`, `user_id`, `watched`) VALUES
(5, 157336, 1, 0),
(6, 616037, 7, 0),
(7, 810693, 7, 4),
(8, 610150, 7, 0),
(9, 19995, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `watching_series`
--

CREATE TABLE `watching_series` (
  `id` int(11) NOT NULL,
  `tmdb_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `season` int(11) NOT NULL,
  `episode` int(11) NOT NULL,
  `watched` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Dumping data for table `watching_series`
--

INSERT INTO `watching_series` (`id`, `tmdb_id`, `user_id`, `season`, `episode`, `watched`) VALUES
(47, 94997, 1, 1, 3, 0),
(48, 1422, 1, 8, 1, 9),
(56, 94997, 1, 1, 4, 65),
(57, 62286, 1, 1, 1, 0),
(71, 76479, 7, 1, 1, 55),
(74, 76479, 7, 1, 2, 70),
(82, 37680, 1, 6, 12, 20),
(84, 94997, 1, 1, 6, 3),
(87, 76479, 7, 2, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `watched_movies`
--
ALTER TABLE `watched_movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watched_series`
--
ALTER TABLE `watched_series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watching_movies`
--
ALTER TABLE `watching_movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `watching_series`
--
ALTER TABLE `watching_series`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `watched_movies`
--
ALTER TABLE `watched_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `watched_series`
--
ALTER TABLE `watched_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `watching_movies`
--
ALTER TABLE `watching_movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `watching_series`
--
ALTER TABLE `watching_series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
