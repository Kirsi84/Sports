-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23.03.2020 klo 18:13
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

--
-- Vedos taulusta `club`
--

INSERT INTO `club` (`id`, `name`, `description`, `updated`, `updatedBy`) VALUES
(1, 'Vesijuoksijat', 'teat', '2020-03-17 15:15:58', 'testuser'),
(2, 'Moskovan dynamo', 'test2', '2020-03-17 15:16:31', 'testuser'),
(3, 'Maratoonarit', 'huippukuntoiset', '2020-03-23 15:06:33', 'teppo1');

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

--
-- Vedos taulusta `member`
--

INSERT INTO `member` (`id`, `firstname`, `lastname`, `description`, `club_id`, `updated`, `updatedBy`) VALUES
(14, 'teppo', 'terävä', 'jees', 2, '2020-03-17 15:32:06', 'testUser');

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
-- Vedos taulusta `user`
--

INSERT INTO `user` (`username`, `passwd`, `email`) VALUES
('teppo', 'aebb9a8980056e270638464e72671087fee763e4', 'testi.testi@puppu.fi'),
('teppo1', '088da3f5201f97c4455b16619c35da383fc5f87a', 'testi.testi@puppu.fi'),
('teppo2', 'f868f52bee1a51b44d4f2210afaf4c0402fca5e5', 'testi.testi@puppu.fi'),
('teppo3', 'bcbceffda08f6fe5dc1dd3c1bfff5bbd53bd066a', 'testi.tete@tititesti.fi');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
