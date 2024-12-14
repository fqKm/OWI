-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 05:03 PM
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
-- Database: `owi_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id` int(64) NOT NULL,
  `rt` int(8) NOT NULL,
  `rw` int(8) NOT NULL,
  `jalan` varchar(256) NOT NULL,
  `dusun` varchar(256) NOT NULL,
  `desa` varchar(256) NOT NULL,
  `kecamatan` varchar(256) NOT NULL,
  `kota` varchar(256) NOT NULL,
  `kode_pos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alamat`
--

INSERT INTO `alamat` (`id`, `rt`, `rw`, `jalan`, `dusun`, `desa`, `kecamatan`, `kota`, `kode_pos`) VALUES
(1, 1, 1, 'Jl Berokan', 'Dusun', 'Desa', '', 'Kota', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pakaian`
--

CREATE TABLE `pakaian` (
  `id` int(64) NOT NULL,
  `jenis` varchar(256) NOT NULL,
  `ukuran` enum('XS','S','M','L','XL','XXL') NOT NULL,
  `id_penawaran` int(32) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pakaian`
--

INSERT INTO `pakaian` (`id`, `jenis`, `ukuran`, `id_penawaran`, `jumlah`) VALUES
(1, 'tidur', 'M', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `penawaran_donasi`
--

CREATE TABLE `penawaran_donasi` (
  `id` int(32) NOT NULL,
  `judul` varchar(256) NOT NULL,
  `deskripsi` varchar(256) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL,
  `id_alamat` int(64) NOT NULL,
  `foto` varchar(256) DEFAULT NULL,
  `nik_pembuat` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penawaran_donasi`
--

INSERT INTO `penawaran_donasi` (`id`, `judul`, `deskripsi`, `dibuat_pada`, `id_alamat`, `foto`, `nik_pembuat`) VALUES
(1, 'satu', 'satu', '2024-12-14 11:05:13', 1, '../upload/penawaran/IMG_20240711_080003_1.jpg', 123);

-- --------------------------------------------------------

--
-- Table structure for table `permintaan_donasi`
--

CREATE TABLE `permintaan_donasi` (
  `id` int(32) NOT NULL,
  `judul` varchar(256) NOT NULL,
  `deskripsi` varchar(256) DEFAULT NULL,
  `dibuat_pada` datetime NOT NULL,
  `id_alamat` int(64) NOT NULL,
  `nik_pembuat` int(16) NOT NULL,
  `foto` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permintaan_donasi`
--

INSERT INTO `permintaan_donasi` (`id`, `judul`, `deskripsi`, `dibuat_pada`, `id_alamat`, `nik_pembuat`, `foto`) VALUES
(1, 'satu', 'satu', '2024-12-14 15:56:59', 1, 123, '../upload/penawaran/IMG_20240711_080003_1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nik` int(32) NOT NULL,
  `nama_depan` varchar(256) NOT NULL,
  `nama_belakang` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nomor_telepon` varchar(13) DEFAULT NULL,
  `id_alamat` int(64) DEFAULT NULL,
  `organisasi` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nik`, `nama_depan`, `nama_belakang`, `email`, `password`, `nomor_telepon`, `id_alamat`, `organisasi`) VALUES
(123, 'Faiq', 'Muna', 'faiqkhoirul04@gmail.com', '$2y$10$Qq5/5UTAB9/cV.viBeUJduHTvsVqWK6epqBYdsFLysj0zXBVbigGq', '087845352327', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_penawaran` (`id_penawaran`);

--
-- Indexes for table `penawaran_donasi`
--
ALTER TABLE `penawaran_donasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alamat` (`id_alamat`),
  ADD KEY `nik_pembuat` (`nik_pembuat`);

--
-- Indexes for table `permintaan_donasi`
--
ALTER TABLE `permintaan_donasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alamat` (`id_alamat`),
  ADD KEY `nik_pembuat` (`nik_pembuat`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `id_alamat` (`id_alamat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pakaian`
--
ALTER TABLE `pakaian`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penawaran_donasi`
--
ALTER TABLE `penawaran_donasi`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permintaan_donasi`
--
ALTER TABLE `permintaan_donasi`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD CONSTRAINT `pakaian_ibfk_1` FOREIGN KEY (`id_penawaran`) REFERENCES `penawaran_donasi` (`id`);

--
-- Constraints for table `penawaran_donasi`
--
ALTER TABLE `penawaran_donasi`
  ADD CONSTRAINT `penawaran_donasi_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id`),
  ADD CONSTRAINT `penawaran_donasi_ibfk_2` FOREIGN KEY (`nik_pembuat`) REFERENCES `user` (`nik`);

--
-- Constraints for table `permintaan_donasi`
--
ALTER TABLE `permintaan_donasi`
  ADD CONSTRAINT `permintaan_donasi_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id`),
  ADD CONSTRAINT `permintaan_donasi_ibfk_2` FOREIGN KEY (`nik_pembuat`) REFERENCES `user` (`nik`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
