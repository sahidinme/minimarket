-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 06:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(30) DEFAULT NULL,
  `satuan` varchar(20) DEFAULT NULL,
  `harga_satuan` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `satuan`, `harga_satuan`) VALUES
(1, 'kopi abc', '1 pack', 1000),
(2, 'kopi luak', '1 pack', 1500);

-- --------------------------------------------------------

--
-- Table structure for table `detailpenjualan`
--

CREATE TABLE `detailpenjualan` (
  `id_detailpenjualan` int(11) NOT NULL,
  `id_penjualan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `kuantitas` int(11) DEFAULT NULL,
  `harga_satuan` bigint(20) DEFAULT NULL,
  `sub_total` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailpenjualan`
--

INSERT INTO `detailpenjualan` (`id_detailpenjualan`, `id_penjualan`, `id_barang`, `kuantitas`, `harga_satuan`, `sub_total`) VALUES
(3, 4, 1, 5, 1000, 5000),
(4, 5, 2, 3, 1500, 4500),
(5, 6, 2, 2, 1500, 3000),
(6, 7, 2, 5, 1500, 7500),
(7, 8, 1, 10, 1000, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `nama_kasir` varchar(30) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_tlp` bigint(20) DEFAULT NULL,
  `no_ktp` bigint(20) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kasir`
--

INSERT INTO `kasir` (`id_kasir`, `nama_kasir`, `alamat`, `no_tlp`, `no_ktp`, `username`, `password`) VALUES
(1, 'kasir1', 'alamat kasir 1', 12345678, 987654321, 'kasir1', '$2y$10$9nWmA/BL4f/XtJ5aoXvC0uq6OWh5FXf4PMD9GK4u9MwFW8QG6HjWS'),
(4, 'kasir 3 ', 'alamat kasir 3', 1234511111, 5432111111, 'kasir3', '$2y$10$1XlC3YuYZRm4NLl48mJwVO.Dw4.i.GiMm4B.TPIwvYlzZAGpZFAEO');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` bigint(10) DEFAULT NULL,
  `id_shift` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `waktu_transaksi`, `total`, `id_shift`) VALUES
(4, '2024-07-08 06:23:49', 5000, 1),
(5, '2024-07-08 06:23:49', 4500, 1),
(6, '2024-07-08 07:22:40', 3000, 1),
(7, '2024-07-08 07:32:16', 7500, 1),
(8, '2024-07-08 07:43:25', 10000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL,
  `id_kasir` int(11) DEFAULT NULL,
  `saldo_awal` bigint(20) DEFAULT NULL,
  `jumlah_penjualan` bigint(20) DEFAULT NULL,
  `saldo_akhir` bigint(20) DEFAULT NULL,
  `waktu_buka` datetime NOT NULL DEFAULT current_timestamp(),
  `waktu_tutup` datetime DEFAULT NULL,
  `status` enum('aktif','tidak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id_shift`, `id_kasir`, `saldo_awal`, `jumlah_penjualan`, `saldo_akhir`, `waktu_buka`, `waktu_tutup`, `status`) VALUES
(1, 1, 10000, 150000, 150000, '2024-07-08 11:40:06', '2024-07-08 23:44:30', 'aktif'),
(3, 4, 10000, NULL, NULL, '2024-07-08 08:42:35', NULL, NULL),
(4, 4, 50000, NULL, NULL, '2024-07-08 08:43:07', NULL, NULL),
(5, 1, 60000, NULL, NULL, '2024-07-08 09:09:18', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD PRIMARY KEY (`id_detailpenjualan`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id_kasir`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_shift` (`id_shift`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id_shift`),
  ADD KEY `id_kasir` (`id_kasir`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  MODIFY `id_detailpenjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id_shift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD CONSTRAINT `detailpenjualan_ibfk_1` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`),
  ADD CONSTRAINT `detailpenjualan_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_shift`) REFERENCES `shift` (`id_shift`);

--
-- Constraints for table `shift`
--
ALTER TABLE `shift`
  ADD CONSTRAINT `shift_ibfk_1` FOREIGN KEY (`id_kasir`) REFERENCES `kasir` (`id_kasir`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
