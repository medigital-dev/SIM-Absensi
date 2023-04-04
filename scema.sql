-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 04, 2023 at 08:43 PM
-- Server version: 10.3.38-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twthiyjh_sim`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis` varchar(16) NOT NULL,
  `kode_absen` varchar(4) NOT NULL,
  `keterangan` varchar(64) DEFAULT NULL,
  `id_peg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `nama` varchar(64) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `email` varchar(64) NOT NULL,
  `website` varchar(64) NOT NULL,
  `logo` varchar(16) NOT NULL,
  `id_ka` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_pegawai`
--

CREATE TABLE `data_pegawai` (
  `id` int(11) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(128) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `jk` varchar(32) NOT NULL,
  `tempat_lahir` varchar(32) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `nama_dusun` varchar(32) NOT NULL,
  `rt` int(11) NOT NULL,
  `rw` int(11) NOT NULL,
  `nama_desa` varchar(32) NOT NULL,
  `nama_kecamatan` varchar(32) NOT NULL,
  `nama_kabupaten` varchar(32) NOT NULL,
  `nama_provinsi` varchar(64) NOT NULL,
  `no_telp` varchar(24) NOT NULL,
  `jabatan` varchar(16) NOT NULL,
  `foto` varchar(64) NOT NULL,
  `level_user` varchar(32) NOT NULL,
  `aktif_peg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_pegawai`
--

INSERT INTO `data_pegawai` (`id`, `email`, `password`, `first_name`, `last_name`, `jk`, `tempat_lahir`, `tanggal_lahir`, `latitude`, `longitude`, `nama_dusun`, `rt`, `rw`, `nama_desa`, `nama_kecamatan`, `nama_kabupaten`, `nama_provinsi`, `no_telp`, `jabatan`, `foto`, `level_user`, `aktif_peg`) VALUES
(2, 'mesaidlg@gmail.com', '$2y$10$Olzc.eUqFGXGCG2p8Ve0aegMkVzDjweE58T/Y6o6soH/3tHctYTwO', 'Muhammad', 'Said', 'Laki-laki', 'Gunungkidul', '1990-04-22', NULL, NULL, 'Madusari', 4, 2, 'Wonosari', 'Wonosari', 'Gunungkidul', 'DI Yogyakarta', '087839301572', 'Pegawai', 'MUHAMMAD_SAID_LATIF_GHOFARI_PAS_FOTO.JPG', 'admin', 1),
(16, 'afrel_nisa@gmail.com', '$2y$10$r.lpVALobmmY6HYwCoC50unEMknr5m/Qi7lnrhPTlllh482aZccxi', 'Afreilya Nisa', 'Nur Rochmah', 'Perempuan', 'Wonogiri', '1991-04-24', NULL, NULL, 'Madusari', 4, 2, 'Wonosari', 'Wonosari', 'Gunungkidul', 'DI Yogyakarta', '08787887655', 'Pegawai', 'WIN_20210709_11_45_40_Pro.jpg', 'Pegawai', 0),
(17, 'keano@gmail.com', '$2y$10$D91d8xdj1702f86XXibhy.qBGLnK9evknYkOuxaWdweHcx8K7J6f2', 'Keano Rafisqy', 'Izwar Alghaisan', 'Laki-laki', 'Sleman', '2019-04-03', NULL, NULL, 'Madusari', 4, 2, 'Wonosari', 'Wonosari', 'Gunungkidul', 'DI Yogyakarta', '0975678965', 'Pegawai', 'WhatsApp_Image_2021-07-21_at_3_53_04_PM1.jpeg', 'Kepala', 0),
(18, 'slamet@gmail.com', '$2y$10$DWfKIyuH8N3k0trWbZZHY.JfpizB3g4cSG42X38yp5y6zeJXJuhNO', 'Slamet', 'Prabowo', 'Laki-laki', 'Gunungkidul', '1965-07-27', NULL, NULL, 'Kemorosari II', 4, 2, 'Piyaman', 'Wonosari', 'Gunungkidul', 'DI Yogyakarta', '09956789678', 'Kepala', 'default.jpg', 'Kepala', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hari_aktif`
--

CREATE TABLE `hari_aktif` (
  `id` int(11) NOT NULL,
  `nama` varchar(16) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hari_aktif`
--

INSERT INTO `hari_aktif` (`id`, `nama`, `is_active`) VALUES
(1, 'Senin', 1),
(2, 'Selasa', 1),
(3, 'Rabu', 1),
(4, 'Kamis', 1),
(5, 'Jumat', 1),
(6, 'Sabtu', 1),
(7, 'Minggu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hari_libur`
--

CREATE TABLE `hari_libur` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_libur` varchar(32) NOT NULL,
  `keterangan` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jam_kerja`
--

CREATE TABLE `jam_kerja` (
  `id` int(11) NOT NULL,
  `jam_masuk` time NOT NULL,
  `jam_pulang` time NOT NULL,
  `jumlah_jam` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jam_kerja`
--

INSERT INTO `jam_kerja` (`id`, `jam_masuk`, `jam_pulang`, `jumlah_jam`) VALUES
(1, '08:00:00', '16:00:00', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `presensi`
--

CREATE TABLE `presensi` (
  `id` int(11) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `id_peg` int(11) NOT NULL,
  `ip_addr` varchar(16) NOT NULL,
  `browser` varchar(16) NOT NULL,
  `device_type` varchar(16) NOT NULL,
  `os` varchar(16) NOT NULL,
  `device_name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `presensi`
--

INSERT INTO `presensi` (`id`, `latitude`, `longitude`, `tanggal`, `waktu`, `id_peg`, `ip_addr`, `browser`, `device_type`, `os`, `device_name`) VALUES
(1, 0, 0, '2021-07-28', '17:07:56', 2, '182.2.70.62', 'Mobile Browser', 'Mobile', 'Android', ' Redmi 7A'),
(2, 0, 0, '2021-07-28', '21:40:55', 2, '112.215.244.163', 'Mobile Browser', 'Mobile', 'Android', ' Redmi 7A'),
(3, 0, 0, '2021-07-29', '12:32:14', 2, '140.213.171.90', 'Mobile Browser', 'Mobile', 'Android', ' Redmi 7A');

-- --------------------------------------------------------

--
-- Table structure for table `tahun`
--

CREATE TABLE `tahun` (
  `id` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tahun`
--

INSERT INTO `tahun` (`id`, `tahun`, `is_active`) VALUES
(1, 2021, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_request_activation`
--

CREATE TABLE `user_request_activation` (
  `id` int(11) NOT NULL,
  `id_peg` int(11) NOT NULL,
  `date` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_request_activation`
--

INSERT INTO `user_request_activation` (`id`, `id_peg`, `date`) VALUES
(1, 2, '2021-07-28 10:13:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hari_aktif`
--
ALTER TABLE `hari_aktif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hari_libur`
--
ALTER TABLE `hari_libur`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jam_kerja`
--
ALTER TABLE `jam_kerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tahun`
--
ALTER TABLE `tahun`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_request_activation`
--
ALTER TABLE `user_request_activation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_pegawai`
--
ALTER TABLE `data_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hari_libur`
--
ALTER TABLE `hari_libur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tahun`
--
ALTER TABLE `tahun`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_request_activation`
--
ALTER TABLE `user_request_activation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
