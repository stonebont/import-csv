-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 07, 2025 at 11:27 AM
-- Server version: 10.5.29-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stonebon_import`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bosda`
--

CREATE TABLE `tbl_bosda` (
  `id_bosda` int(7) NOT NULL,
  `npsn` varchar(8) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `jml_bosda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_bosda`
--

INSERT INTO `tbl_bosda` (`id_bosda`, `npsn`, `tahun`, `jml_bosda`) VALUES
(1, '12345678', '2024', 12300000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_bosda`
--
ALTER TABLE `tbl_bosda`
  ADD PRIMARY KEY (`id_bosda`),
  ADD UNIQUE KEY `npsn_varchar` (`npsn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_bosda`
--
ALTER TABLE `tbl_bosda`
  MODIFY `id_bosda` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
