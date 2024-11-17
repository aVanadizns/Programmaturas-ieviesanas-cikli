-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2022 at 08:30 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sagatave3`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategorijas`
--

CREATE TABLE `kategorijas` (
  `id` int(11) UNSIGNED NOT NULL,
  `nosaukums` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategorijas`
--

INSERT INTO `kategorijas` (`id`, `nosaukums`) VALUES
(1, 'Elektronika'),
(2, 'Mēbeles'),
(5, 'Sporta preces');

-- --------------------------------------------------------

--
-- Table structure for table `lapas`
--

CREATE TABLE `lapas` (
  `id` int(11) UNSIGNED NOT NULL,
  `nosaukums` varchar(100) NOT NULL,
  `taka` varchar(120) NOT NULL,
  `saturs` text DEFAULT NULL,
  `laiks` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lapas`
--

INSERT INTO `lapas` (`id`, `nosaukums`, `taka`, `saturs`, `laiks`) VALUES
(1, 'SÄkums', 'sakums', 'Esiet sveicin?ti SAGATAV?!', '2022-08-24 16:09:53'),
(3, 'Kontakti', 'Kontakti', 't.20626252dfd', '2022-07-20 18:31:32');

-- --------------------------------------------------------

--
-- Table structure for table `lietotaji`
--

CREATE TABLE `lietotaji` (
  `id` int(11) UNSIGNED NOT NULL,
  `e_pasts` varchar(150) NOT NULL,
  `parole` varchar(255) NOT NULL,
  `segvards` varchar(50) DEFAULT NULL,
  `loma` varchar(10) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `apraksts` text DEFAULT NULL,
  `registracijas_laiks` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lietotaji`
--

INSERT INTO `lietotaji` (`id`, `e_pasts`, `parole`, `segvards`, `loma`, `foto`, `apraksts`, `registracijas_laiks`) VALUES
(1, 'admin@webkursi.lv', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 'Ansis2', 'admin', 'adrese', 'apraksts', '2022-07-27 18:23:59'),
(3, 'admin2@webkursi.lv', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 'ggggg', 'admin', 'ggggg', 'ggggggggggggggggggggggg', '2022-07-27 18:37:26'),
(4, 'tests', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 'tests', 'user', '...', '...', '2022-08-03 16:23:22'),
(5, 'tests1@3arodskola.lv', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 'dfdsf', 'user', 'sdf', 'sdfsdf', '2022-08-03 16:23:59'),
(7, 'armands@gmail.com', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 'Armands', 'user', '...', '...', '2022-08-03 17:00:03'),
(8, 'armands2@gmail.com', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', '545', 'user', '45', '45', '2022-08-03 17:00:50'),
(9, 'zane@gmail.com', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 'Zane', 'user', '...', '...', '2022-08-03 17:04:19'),
(10, 't2', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 't2', 'user', 't2', 't2', '2022-08-10 15:58:20'),
(11, 't3', '$2y$10$W.QW3vQEYcI/qLXCniPIr.h3ybQfokiTnMxEGivUiRcY1mMue54Um', 't3', 'user', 't3', 't3', '2022-08-10 16:02:12'),
(12, 't55', '$2y$10$a6dcH.PAejUndFAdK7nxlOT7HqWAdXEqhGZZTrgxVkyD6meyvCXby', 't5', 'user', 't5', 't5', '2022-08-10 16:07:02'),
(13, 't8', '123', 't8', 'user', 't8', 't8', '2022-08-10 16:39:30'),
(14, 't999', '$2y$10$aqSRxi3UzX8fMnKi3br3NuDLLULw7crG84shoqsH6NbY5KPgaCbeu', 't9', 'user', 't9', 't9', '2022-08-10 16:44:50'),
(15, '', '$2y$10$.TVKoApIzjmkwKrN/y7I7.ez0KPwZ5GEVHoKAAk10a9SIGZNFRtTe', '', '', '', 'mmmmmmmmmmmmmm', '2022-08-17 16:04:46'),
(16, '', '$2y$10$5sR9e8L9vN8md8SnA6hkie7oMBK8W9IIrtG2eIaBzoPVgy5ZSFxs.', '', '', '', 'mmmmmmmmmmmmmm', '2022-08-17 16:06:22'),
(17, '', '$2y$10$nlznk99efg8dFj9f8PVekupV7AHaonC9fE3l8e7eySQTCx3FmJ.Y2', '', '', '', 'mmmmmmmmmmmmmm', '2022-08-17 16:06:28');

-- --------------------------------------------------------

--
-- Table structure for table `pasutijuma_preces`
--

CREATE TABLE `pasutijuma_preces` (
  `id` int(11) UNSIGNED NOT NULL,
  `pasutijuma_id` int(11) NOT NULL,
  `preces_id` int(11) NOT NULL,
  `daudzums` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasutijuma_preces`
--

INSERT INTO `pasutijuma_preces` (`id`, `pasutijuma_id`, `preces_id`, `daudzums`) VALUES
(1, 1, 15, 5),
(2, 1, 17, 3),
(3, 2, 18, 1),
(4, 2, 19, 1),
(5, 2, 21, 2),
(6, 3, 16, 1),
(7, 3, 17, 1),
(8, 3, 18, 1),
(9, 4, 17, 2),
(10, 4, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pasutijumi`
--

CREATE TABLE `pasutijumi` (
  `id` int(11) UNSIGNED NOT NULL,
  `lietotaja_id` int(11) NOT NULL,
  `laiks` timestamp NOT NULL DEFAULT current_timestamp(),
  `statuss` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pasutijumi`
--

INSERT INTO `pasutijumi` (`id`, `lietotaja_id`, `laiks`, `statuss`) VALUES
(1, 1, '2022-09-07 17:42:27', 'pasÅ«tÄ«jums saÅ†emts'),
(2, 1, '2022-09-07 17:51:21', 'pasÅ«tÄ«jums saÅ†emts'),
(3, 1, '2022-09-07 18:31:01', 'pasÅ«tÄ«jums saÅ†emts'),
(4, 1, '2022-09-14 17:43:54', 'pasÅ«tÄ«jums saÅ†emts');

-- --------------------------------------------------------

--
-- Table structure for table `preces`
--

CREATE TABLE `preces` (
  `id` int(11) UNSIGNED NOT NULL,
  `nosaukums` varchar(255) NOT NULL,
  `cena` decimal(6,2) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `apraksts` text DEFAULT NULL,
  `kategorijas_id` int(11) NOT NULL,
  `noliktava` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `preces`
--

INSERT INTO `preces` (`id`, `nosaukums`, `cena`, `foto`, `apraksts`, `kategorijas_id`, `noliktava`) VALUES
(15, 'Gludeklis Philips 6 bbb gggg', '55.00', 'uploads/gludeklis.png', 'Apraksts....', 1, 5),
(16, 'Skapis divdurvju', '300.00', 'uploads/skapis.jpg', '....', 2, 2),
(17, 'Ledusskapis', '600.00', 'uploads/ledusskapis.jpg', '....', 1, 3),
(18, 'Telefons Samsung S20', '500.00', 'uploads/telefons-samsung-galaxy-a33-5g-128gb.png', '....', 1, 7),
(19, 'DÄ«vÄns1', '300.00', 'uploads/divans.jpg', '...', 2, 1),
(20, 'DÄ«vÄns2', '240.00', 'uploads/divans2.jpg', '...', 2, 3),
(21, 'Drons2', '600.00', 'uploads/drons.jpg', '...', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategorijas`
--
ALTER TABLE `kategorijas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lapas`
--
ALTER TABLE `lapas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lietotaji`
--
ALTER TABLE `lietotaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasutijuma_preces`
--
ALTER TABLE `pasutijuma_preces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pasutijumi`
--
ALTER TABLE `pasutijumi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `preces`
--
ALTER TABLE `preces`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorijas`
--
ALTER TABLE `kategorijas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lapas`
--
ALTER TABLE `lapas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lietotaji`
--
ALTER TABLE `lietotaji`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pasutijuma_preces`
--
ALTER TABLE `pasutijuma_preces`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pasutijumi`
--
ALTER TABLE `pasutijumi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `preces`
--
ALTER TABLE `preces`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
