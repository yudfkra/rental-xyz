-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2018 at 04:21 AM
-- Server version: 10.3.11-MariaDB-log
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rental_xyz`
--

-- --------------------------------------------------------

--
-- Table structure for table `jenis_mobil`
--

CREATE TABLE `jenis_mobil` (
  `id` int(11) NOT NULL,
  `kode` varchar(5) NOT NULL,
  `jenis` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_mobil`
--

INSERT INTO `jenis_mobil` (`id`, `kode`, `jenis`) VALUES
(1, 'AVP', 'AVP'),
(2, 'SDN', 'Sedan');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `no_polisi` varchar(20) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tahun` varchar(4) NOT NULL,
  `harga` double NOT NULL,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tanggal_update` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `mobil_id` int(11) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `alamat` text NOT NULL,
  `total_harga` double NOT NULL,
  `denda` double NOT NULL DEFAULT 0,
  `tanggal_batas_kembali` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `tanggal_input` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `email`, `password`) VALUES
(1, 'Yuda', 'yuda@yahoo.co.id', '$2y$10$QHqGM1I/b/bq2R.R9pfPSulnljHH31Bgui/0pODWYxY5LByjrqm5G'),
(2, 'Wahyudin', 'wahyudin@yahoo.co.id', '$2y$10$gTVXQKsBDuZOKn/8zFwjQ.YzdxUKS0bb.hHa48Q3WhJvKBd3nmvD2'),
(3, 'Wanto', 'wanto@yahoo.co.id', '$2y$10$1IGgwn8dIYUeG6cqhXthk.OLyDpfLyzaKWEPdo/GyWgCYSC7cPoGW'),
(4, 'Diyas', 'diyas@yahoo.co.id', '$2y$10$oIAWEDZo8X13SL1gwL9ssutMq8jjOnow/pHvoyXyvqUM4KAXfSxhq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jenis_mobil`
--
ALTER TABLE `jenis_mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_mobil`
--
ALTER TABLE `jenis_mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
