-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 02 Sep 2016 pada 10.57
-- Versi Server: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epus_prog_3205`
--

DELIMITER $$
--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `bulan`() RETURNS varchar(4) CHARSET latin1
RETURN @bulan$$

CREATE DEFINER=`root`@`localhost` FUNCTION `func`() RETURNS date
RETURN @var$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tahun`() RETURNS varchar(4) CHARSET latin1
RETURN @tahun$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tglkondisi`() RETURNS date
RETURN @tglkondisi$$

CREATE DEFINER=`root`@`localhost` FUNCTION `tglrusak`() RETURNS date
RETURN @tglrusak$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keu_jurnal`
--

CREATE TABLE IF NOT EXISTS `keu_jurnal` (
  `id_jurnal` varchar(30) NOT NULL,
  `id_transaksi` varchar(30) NOT NULL,
  `id_mst_akun` int(11) NOT NULL,
  `debet` double DEFAULT NULL,
  `kredit` double DEFAULT NULL,
  `status` enum('kredit','debet') DEFAULT NULL,
  `id_keu_transaksi_inventaris` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keu_transaksi`
--

CREATE TABLE IF NOT EXISTS `keu_transaksi` (
  `id_transaksi` varchar(30) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `lampiran` varchar(255) DEFAULT NULL,
  `tipe_jurnal` enum('jurnal_umum','jurnal_penyesuaian','jurnal_penutup') DEFAULT NULL,
  `status` enum('ditutup','disimpan','draft','dihapus') DEFAULT NULL,
  `bukti_kas` varchar(255) DEFAULT NULL,
  `jatuh_tempo` datetime DEFAULT NULL,
  `nomor_faktur` varchar(45) DEFAULT NULL,
  `id_mst_syarat_pembayaran` int(11) DEFAULT NULL,
  `id_instansi` int(11) DEFAULT NULL,
  `id_kategori_transaksi` int(11) NOT NULL,
  `code_cl_phc` char(11) NOT NULL,
  `id_mst_keu_transaksi` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keu_transaksi_inventaris`
--

CREATE TABLE IF NOT EXISTS `keu_transaksi_inventaris` (
  `id_transaksi_inventaris` int(11) NOT NULL,
  `id_inventaris` varchar(30) NOT NULL,
  `id_transaksi` varchar(30) NOT NULL,
  `periode_penyusutan_awal` date DEFAULT NULL,
  `periode_penyusutan_akhir` date DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `pemakaian_period` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keu_jurnal`
--
ALTER TABLE `keu_jurnal`
  ADD PRIMARY KEY (`id_jurnal`),
  ADD KEY `fk_keu_jurnal_keu_transaksi1_idx` (`id_transaksi`),
  ADD KEY `fk_keu_jurnal_mst_keu_akun1_idx` (`id_mst_akun`);

--
-- Indexes for table `keu_transaksi`
--
ALTER TABLE `keu_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_keu_transaksi_mst_keu_syarat_pembayaran1_idx` (`id_mst_syarat_pembayaran`),
  ADD KEY `fk_keu_transaksi_mst_keu_instansi1_idx` (`id_instansi`),
  ADD KEY `fk_keu_transaksi_mst_keu_kategori_transaksi1_idx` (`id_kategori_transaksi`),
  ADD KEY `fk_keu_transaksi_cl_phc1_idx` (`code_cl_phc`),
  ADD KEY `fk_keu_transaksi_mst_keu_transaksi1_idx` (`id_mst_keu_transaksi`);

--
-- Indexes for table `keu_transaksi_inventaris`
--
ALTER TABLE `keu_transaksi_inventaris`
  ADD PRIMARY KEY (`id_transaksi_inventaris`),
  ADD KEY `fk_keu_transaksi_inventaris_keu_inventaris1_idx` (`id_inventaris`),
  ADD KEY `fk_keu_transaksi_inventaris_keu_transaksi1_idx` (`id_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keu_transaksi_inventaris`
--
ALTER TABLE `keu_transaksi_inventaris`
  MODIFY `id_transaksi_inventaris` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
