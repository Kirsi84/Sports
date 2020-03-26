-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26.03.2020 klo 07:07
-- Palvelimen versio: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sports`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `club`
--

CREATE TABLE `club` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL,
  `description` varchar(100) CHARACTER SET utf32 COLLATE utf32_swedish_ci DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedBy` varchar(50) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Rakenne taululle `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL,
  `description` varchar(100) CHARACTER SET utf32 COLLATE utf32_swedish_ci DEFAULT NULL,
  `club_id` int(11) NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updatedBy` varchar(50) CHARACTER SET utf32 COLLATE utf32_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Rakenne taululle `user`
--

CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `passwd` char(40) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `club`
--
ALTER TABLE `club`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `club_id_ind` (`club_id`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `club`
--
ALTER TABLE `club`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `club_id_ind` FOREIGN KEY (`club_id`) REFERENCES `club` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
