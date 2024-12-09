-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 09:22 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `d_transaksi`
--

CREATE TABLE `d_transaksi` (
  `id_dtransaksi` int(11) NOT NULL,
  `id_transaksi` varchar(10) NOT NULL,
  `id_item` varchar(10) NOT NULL,
  `jumlah` varchar(10) NOT NULL,
  `total` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d_transaksi`
--

INSERT INTO `d_transaksi` (`id_dtransaksi`, `id_transaksi`, `id_item`, `jumlah`, `total`) VALUES
(1, 'TRN001', 'ITM001', '1', '5000'),
(2, 'TRN001', 'ITM010', '1', '20000'),
(4, 'TRN001', 'ITM004', '2', '16000'),
(5, 'TRN001', 'ITM005', '1', '6000'),
(6, 'TRN002', 'ITM001', '2', '10000'),
(7, 'TRN002', 'ITM008', '1', '4000');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` varchar(10) NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `harga` varchar(20) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id_item`, `nama_item`, `harga`, `ket`) VALUES
('ITM001', 'Pakaian', '5000', 'Harga Perkilo'),
('ITM002', 'Selimut Besar', '10000', 'Harga Satuan'),
('ITM003', 'Selimut Kecil', '6000', 'Harga Satuan'),
('ITM004', 'Sprei Besar', '8000', 'Harga Satuan'),
('ITM005', 'Sprei Kecil', '6000', 'Harga Satuan'),
('ITM006', 'Sprei Rumbai', '10000', 'Harga Satuan'),
('ITM007', 'Handuk Besar', '5000', 'Harga Satuan'),
('ITM008', 'Handuk Kecil', '4000', 'Harga Satuan'),
('ITM009', 'Bad Cover Jumbo', '25000', 'Harga Satuan'),
('ITM010', 'Bad Cover Besar', '20000', 'Harga Satuan'),
('ITM011', 'Bad Cover Kecil', '15000', 'Harga Satuan');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` varchar(10) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `ket` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `ket`) VALUES
('LYN001', 'Kilat', 'Layanan cuci pakaian yang selesai dalam waktu -+ 24 jam	'),
('LYN002', 'Reguler', 'Layanan cuci pakaian yang selesai dalam waktu -+ 2 hari	');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `icon` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama`, `url`, `icon`) VALUES
(1, 'Transaksi', 'index.php', 'transaksi.png'),
(2, 'Item', 'item.php', 'item.png'),
(3, 'Layanan', 'layanan.php', 'layanan.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(10) NOT NULL,
  `nama_kons` varchar(50) NOT NULL,
  `hp` varchar(20) NOT NULL,
  `terima_tgl` date NOT NULL,
  `selesai_tgl` date NOT NULL,
  `id_layanan` varchar(10) NOT NULL,
  `total_harga` varchar(20) NOT NULL,
  `pembayaran` varchar(20) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nama_kons`, `hp`, `terima_tgl`, `selesai_tgl`, `id_layanan`, `total_harga`, `pembayaran`, `status`) VALUES
('TRN001', 'Lintang', '081331599321', '2023-07-01', '2023-07-02', 'LYN002', '47000', 'Cash', 1),
('TRN002', 'Yogi', '085231804178', '2023-07-03', '2023-07-05', 'LYN002', '14000', 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `foto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `nama`, `foto`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@example.com', 'Admin', 'default.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `d_transaksi`
--
ALTER TABLE `d_transaksi`
  ADD PRIMARY KEY (`id_dtransaksi`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `d_transaksi`
--
ALTER TABLE `d_transaksi`
  MODIFY `id_dtransaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
