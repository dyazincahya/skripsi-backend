-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 13, 2020 at 11:32 AM
-- Server version: 5.7.31-log
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vuspictu_skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_presensi`
--

CREATE TABLE `data_presensi` (
  `dp_id` int(11) NOT NULL,
  `dp_mahasiswa` int(11) NOT NULL,
  `dp_dosen` int(11) NOT NULL,
  `dp_matakuliah` int(11) NOT NULL,
  `dp_ruangan` int(11) NOT NULL,
  `dp_status` enum('hadir','alpha') NOT NULL,
  `dp_presensi_date` date NOT NULL,
  `dp_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_presensi`
--

INSERT INTO `data_presensi` (`dp_id`, `dp_mahasiswa`, `dp_dosen`, `dp_matakuliah`, `dp_ruangan`, `dp_status`, `dp_presensi_date`, `dp_created`) VALUES
(1, 9, 1, 1, 1, 'hadir', '2020-08-10', '2020-08-10 00:32:01'),
(2, 3, 1, 1, 1, 'alpha', '2020-08-10', '2020-08-10 00:32:09'),
(3, 1, 1, 1, 1, 'alpha', '2020-08-10', '2020-08-10 00:32:14'),
(4, 5, 1, 1, 1, 'alpha', '2020-08-10', '2020-08-10 00:32:20'),
(5, 8, 1, 1, 1, 'hadir', '2020-08-10', '2020-08-10 00:32:31'),
(6, 9, 1, 1, 1, 'hadir', '2020-08-11', '2020-08-11 00:34:16'),
(7, 3, 1, 1, 1, 'hadir', '2020-08-11', '2020-08-11 00:34:19'),
(8, 1, 1, 1, 1, 'hadir', '2020-08-11', '2020-08-11 00:34:22'),
(9, 5, 1, 1, 1, 'hadir', '2020-08-11', '2020-08-11 00:34:26'),
(10, 8, 1, 1, 1, 'hadir', '2020-08-11', '2020-08-11 00:34:30'),
(11, 9, 1, 1, 1, 'hadir', '2020-08-22', '2020-08-23 00:36:32'),
(12, 5, 1, 1, 1, 'alpha', '2020-08-22', '2020-08-23 00:36:39'),
(13, 8, 1, 1, 1, 'hadir', '2020-08-22', '2020-08-23 00:36:46'),
(14, 9, 1, 3, 1, 'hadir', '2020-09-02', '2020-09-02 16:40:37'),
(15, 3, 1, 3, 1, 'alpha', '2020-09-02', '2020-09-02 16:40:40'),
(16, 1, 1, 3, 1, 'hadir', '2020-09-02', '2020-09-02 16:40:43'),
(17, 5, 1, 3, 1, 'hadir', '2020-09-02', '2020-09-02 16:40:46'),
(18, 9, 1, 7, 1, 'alpha', '2020-09-02', '2020-09-02 16:41:05'),
(19, 8, 1, 3, 1, 'alpha', '2020-09-02', '2020-09-02 20:26:16');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `f_id` int(11) NOT NULL,
  `f_strata` enum('D1','D2','D3','D4','S1','S2','S3') NOT NULL,
  `f_fakultas` varchar(10) NOT NULL,
  `f_fakultas_name` varchar(75) NOT NULL,
  `f_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`f_id`, `f_strata`, `f_fakultas`, `f_fakultas_name`, `f_created`) VALUES
(1, 'S1', 'FKOM', 'Fakultas Ilmu Komputer', '2020-07-21 07:28:28'),
(2, 'S1', 'FKIP', 'Fakultas Keguruan Dan Ilmu Pendidikan', '2020-07-21 07:28:28'),
(3, 'S1', 'FE', 'Fakultas Ekonomi', '2020-07-21 07:28:28'),
(4, 'S1', 'FHUTAN', 'Fakultas Kehutanan', '2020-07-21 07:28:28'),
(5, 'S1', 'FHUKUM', 'Fakultas Hukum', '2020-07-21 07:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kuliah`
--

CREATE TABLE `jadwal_kuliah` (
  `jk_id` int(11) NOT NULL,
  `jk_dosen` int(11) NOT NULL,
  `jk_ruangan` int(11) NOT NULL,
  `jk_matakuliah` int(11) NOT NULL,
  `jk_semester` smallint(6) NOT NULL DEFAULT '1',
  `jk_start_kuliah` time NOT NULL,
  `jk_end_kuliah` time NOT NULL,
  `jk_day` enum('SENIN','SELASA','RABU','KAMIS','JUMAT','SABTU','MINGGU') NOT NULL,
  `jk_active_from` date NOT NULL,
  `jk_active_until` date NOT NULL,
  `jk_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_kuliah`
--

INSERT INTO `jadwal_kuliah` (`jk_id`, `jk_dosen`, `jk_ruangan`, `jk_matakuliah`, `jk_semester`, `jk_start_kuliah`, `jk_end_kuliah`, `jk_day`, `jk_active_from`, `jk_active_until`, `jk_created`) VALUES
(1, 1, 1, 1, 1, '08:00:00', '10:00:00', 'SENIN', '2020-07-01', '2021-02-28', '2020-08-02 17:03:13'),
(2, 1, 1, 2, 1, '08:00:00', '10:00:00', 'SELASA', '2020-07-01', '2021-02-28', '2020-08-02 17:03:54'),
(3, 1, 1, 3, 1, '08:00:00', '10:00:00', 'RABU', '2020-07-01', '2021-02-28', '2020-08-22 23:58:00'),
(4, 1, 1, 4, 1, '08:00:00', '10:00:00', 'KAMIS', '2020-07-01', '2021-02-28', '2020-08-22 23:59:24'),
(5, 1, 1, 5, 1, '08:00:00', '10:00:00', 'JUMAT', '2020-07-01', '2021-02-28', '2020-08-22 23:58:00'),
(6, 1, 1, 6, 1, '08:00:00', '10:00:00', 'SABTU', '2020-07-01', '2021-02-28', '2020-08-22 23:59:24'),
(7, 1, 1, 7, 1, '10:00:00', '12:00:00', 'RABU', '2020-07-01', '2021-02-28', '2020-08-22 23:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `kampus`
--

CREATE TABLE `kampus` (
  `k_id` int(11) NOT NULL,
  `k_name` varchar(25) NOT NULL,
  `k_alamat` text NOT NULL,
  `k_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kampus`
--

INSERT INTO `kampus` (`k_id`, `k_name`, `k_alamat`, `k_created`) VALUES
(1, 'A', 'Jl. Cut Nyak Dhien No.36 A, Cijoho, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45513', '2020-07-21 07:08:19'),
(2, 'B', 'Jl. Pramuka No.67, Purwawinangun, Kec. Kuningan, Kabupaten Kuningan, Jawa Barat 45512', '2020-07-21 07:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `m_id` int(11) NOT NULL,
  `m_nim` varchar(25) NOT NULL,
  `m_strata` enum('D3','D4','S1','S2','S3') NOT NULL,
  `m_semester` enum('1','2','3','4','5','6','7','8','9','10','11','12','13','14') NOT NULL,
  `m_fullname` varchar(100) NOT NULL,
  `m_tgl_lahir` date NOT NULL,
  `m_jk` enum('LAKI-LAKI','PEREMPUAN') NOT NULL,
  `m_alamat` text NOT NULL,
  `m_email` varchar(100) NOT NULL,
  `m_nohp` varchar(15) NOT NULL,
  `m_ruangan` int(11) NOT NULL,
  `m_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`m_id`, `m_nim`, `m_strata`, `m_semester`, `m_fullname`, `m_tgl_lahir`, `m_jk`, `m_alamat`, `m_email`, `m_nohp`, `m_ruangan`, `m_created`) VALUES
(1, '201820201000', 'S1', '1', 'Arif Muarif Syafrudin', '1995-04-13', 'LAKI-LAKI', '<p>\n	Desa cibimbin, kecamatan cibimbin, kabupaten kuningan, jawa barat</p>\n', 'arifmuarifsyafrudin@gmail.com', '081234567890', 1, '2020-07-19 15:16:17'),
(2, '201820201001', 'S1', '1', 'Fajar Nugrah', '1995-04-13', 'LAKI-LAKI', '<p>\n	Desa cilimus, kecamatan linggarjati, kabupaten kuningan, jawa barat</p>\n', 'fajarnugrah@gmail.com', '081234567890', 1, '2020-07-19 15:16:17'),
(3, '201820201003', 'S1', '1', 'Adnan alfian', '1994-08-04', 'LAKI-LAKI', '<p>\n	bandung, jawa barat</p>\n', 'adnan@gmail.com', '08323332323', 1, '2020-08-08 21:56:10'),
(4, '201820201002', 'S1', '1', 'Setiabudi', '1994-08-04', 'LAKI-LAKI', '<p>\n	jakarta</p>\n', 'setiabudi@gmail.com', '087777323', 1, '2020-08-23 00:18:44'),
(5, '201820201004', 'S1', '1', 'Ayu Rahma', '1994-08-04', 'PEREMPUAN', '<p>\n	bandung, jawa barat</p>\n', 'ayu@gmail.com', '08323332323', 1, '2020-08-23 00:22:42'),
(6, '201820201005', 'S1', '1', 'Elsa Gustiani', '1994-08-04', 'PEREMPUAN', '<p>\n	bandung, jawa barat</p>\n', 'elsa@gmail.com', '08323332323', 1, '2020-08-23 00:23:13'),
(7, '201820201006', 'S1', '1', 'Yuni Ningsih', '1994-08-04', 'PEREMPUAN', '<p>\n	bandung, jawa barat</p>\n', 'yuni@gmail.com', '08323332323', 1, '2020-08-23 00:24:14'),
(8, '201820201007', 'S1', '1', 'Elisabet Nana', '1994-08-04', 'PEREMPUAN', '<p>\n	bandung, jawa barat</p>\n', 'nana@gmail.com', '08323332323', 1, '2020-08-23 00:25:00'),
(9, '201820201008', 'S1', '1', 'Adam Brian', '1994-08-04', 'LAKI-LAKI', '<p>\n	bandung, jawa barat</p>\n', 'adam@gmail.com', '08323332323', 1, '2020-08-23 00:25:30'),
(10, '201820201009', 'S1', '1', 'Rizky Isman', '1994-08-04', 'LAKI-LAKI', '<p>\n	bandung, jawa barat</p>\n', 'rizky@gmail.com', '08323332323', 1, '2020-08-23 00:25:59'),
(11, '201820201010', 'S1', '1', 'Rudi Deud', '1994-08-04', 'LAKI-LAKI', '<p>\n	bandung, jawa barat</p>\n', 'rudi@gmail.com', '08323332323', 1, '2020-08-23 00:26:24'),
(14, '20200811878', 'S1', '3', 'Cahya new', '2005-09-12', 'LAKI-LAKI', 'Jabar', 'cahya@yahoo.com', '0878888', 1, '2020-09-12 23:33:24');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliah`
--

CREATE TABLE `matakuliah` (
  `mk_id` int(11) NOT NULL,
  `mk_fakultas` int(11) NOT NULL,
  `mk_kategori` enum('KEJURUAN','UMUM') NOT NULL,
  `mk_tipe` enum('WAJIB','OPTIONAL') NOT NULL,
  `mk_semester` smallint(6) NOT NULL DEFAULT '1',
  `mk_name` varchar(100) NOT NULL,
  `mk_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matakuliah`
--

INSERT INTO `matakuliah` (`mk_id`, `mk_fakultas`, `mk_kategori`, `mk_tipe`, `mk_semester`, `mk_name`, `mk_created`) VALUES
(1, 1, 'KEJURUAN', 'WAJIB', 1, 'pengantar sistem informasi', '2020-07-19 22:05:54'),
(2, 1, 'KEJURUAN', 'WAJIB', 1, 'algoritma 1', '2020-07-19 22:05:54'),
(3, 1, 'KEJURUAN', 'WAJIB', 1, 'algoritma 2', '2020-07-19 22:05:54'),
(4, 1, 'KEJURUAN', 'WAJIB', 1, 'pemrograman web', '2020-07-19 22:05:54'),
(5, 1, 'KEJURUAN', 'WAJIB', 1, 'pemrograman desktop', '2020-07-19 22:05:54'),
(6, 1, 'UMUM', 'WAJIB', 1, 'Kalkulus 1', '2020-07-19 22:09:48'),
(7, 1, 'UMUM', 'WAJIB', 1, 'Kalkulus 2', '2020-07-19 22:09:48'),
(8, 1, 'UMUM', 'OPTIONAL', 1, 'Bahasa Indonesia', '2020-07-19 22:09:48'),
(9, 1, 'UMUM', 'OPTIONAL', 1, 'Pendidikan Agama', '2020-07-19 22:09:48'),
(10, 1, 'UMUM', 'OPTIONAL', 1, 'Fisika Dasar', '2020-07-19 22:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `r_id` int(11) NOT NULL,
  `r_kampus` int(11) NOT NULL,
  `r_name` varchar(11) NOT NULL,
  `r_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`r_id`, `r_kampus`, `r_name`, `r_created`) VALUES
(1, 1, '4.1.1', '2020-07-19 21:57:43'),
(3, 1, '4.1.3', '2020-07-19 21:57:43'),
(4, 1, '4.1.4', '2020-07-19 21:57:43'),
(5, 1, '4.1.5', '2020-07-19 21:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_role` enum('DOSEN','STAF') NOT NULL,
  `u_nik` varchar(15) NOT NULL,
  `u_fullname` varchar(100) NOT NULL,
  `u_tgl_lahir` date NOT NULL,
  `u_jk` enum('LAKI-LAKI','PEREMPUAN') NOT NULL,
  `u_alamat` text NOT NULL,
  `u_nohp` varchar(15) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_password` varchar(100) NOT NULL,
  `u_last_strata` varchar(5) NOT NULL,
  `u_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_role`, `u_nik`, `u_fullname`, `u_tgl_lahir`, `u_jk`, `u_alamat`, `u_nohp`, `u_email`, `u_password`, `u_last_strata`, `u_created`) VALUES
(1, 'DOSEN', '123456789000', 'Nunu Nugraha S.Kom M.Kom', '1990-02-05', '', '<p>\n	Kuningan, jawa barat, indonesia</p>\n', '08123456789', 'dosen@uniku.ac.id', '202cb962ac59075b964b07152d234b70', 'S2', '2020-08-02 03:36:35'),
(2, 'DOSEN', '123456789001', 'Maman Isaqa M.Ti', '1987-01-01', '', '<p>\n	Bandung, jawa barat, indonesia</p>\n', '0812243111', 'maman@uniku.ac.id', '202cb962ac59075b964b07152d234b70', 'S2', '2020-08-03 08:11:38'),
(3, 'STAF', '123388990', 'Staff', '2020-08-10', '', '<p>\n	jabar</p>\n', '08122433230', 'staff@uniku.ac.id', 'd41d8cd98f00b204e9800998ecf8427e', 'S1', '2020-08-10 20:57:46'),
(4, 'STAF', '123388990', 'cahya dyazin', '2020-08-10', '', '<p>\r\n	jabar</p>\r\n', '08122433230', 'dyazincahya@gmail.com', '202cb962ac59075b964b07152d234b70', 'S1', '2020-08-10 20:57:46'),
(6, 'DOSEN', '11111222', 'Fsdfds', '2020-09-06', 'PEREMPUAN', 'Sdfsdfds', '24423', 'vcxx@dgdf.ftgdf', '77e19b6553b29005f81f5634f2419bf6', 'S1', '2020-09-06 08:33:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_presensi`
--
ALTER TABLE `data_presensi`
  ADD PRIMARY KEY (`dp_id`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  ADD PRIMARY KEY (`jk_id`);

--
-- Indexes for table `kampus`
--
ALTER TABLE `kampus`
  ADD PRIMARY KEY (`k_id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`m_id`),
  ADD KEY `m_ruangan` (`m_ruangan`),
  ADD KEY `m_ruangan_2` (`m_ruangan`);

--
-- Indexes for table `matakuliah`
--
ALTER TABLE `matakuliah`
  ADD PRIMARY KEY (`mk_id`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_presensi`
--
ALTER TABLE `data_presensi`
  MODIFY `dp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jadwal_kuliah`
--
ALTER TABLE `jadwal_kuliah`
  MODIFY `jk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kampus`
--
ALTER TABLE `kampus`
  MODIFY `k_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `matakuliah`
--
ALTER TABLE `matakuliah`
  MODIFY `mk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
