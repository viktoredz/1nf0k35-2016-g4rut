-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 07 Sep 2016 pada 11.06
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
-- Struktur dari tabel `keu_inventaris`
--

CREATE TABLE IF NOT EXISTS `keu_inventaris` (
  `id_inventaris` varchar(30) NOT NULL,
  `id_inventaris_barang` varchar(30) NOT NULL,
  `id_mst_akun` int(11) NOT NULL,
  `id_mst_akun_akumulasi` int(11) NOT NULL,
  `akumulasi_beban` double DEFAULT NULL,
  `nilai_ekonomis` double DEFAULT NULL,
  `nilai_sisa` double DEFAULT NULL,
  `id_mst_metode_penyusutan` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `keu_inventaris`
--

INSERT INTO `keu_inventaris` (`id_inventaris`, `id_inventaris_barang`, `id_mst_akun`, `id_mst_akun_akumulasi`, `akumulasi_beban`, `nilai_ekonomis`, `nilai_sisa`, `id_mst_metode_penyusutan`) VALUES
('32051812032016090001', '12100307041603405170301120003', 124, 251, NULL, 32, 54, 2),
('32051812032016090002', '12100307041603401000000000001', 124, 251, 100000000, 12, 0, 3),
('32051812032016090003', '12100307041603405170301120004', 124, 251, NULL, 0, 0, 5),
('32051812032016090004', '12100307041603402060201030001', 124, 251, 1000000, 20, 23, 4),
('32051812032016090005', '12100307041603405170301120005', 124, 251, NULL, 12, 0, 3),
('32051812032016090006', '12100307041603402060201030002', 124, 251, 1000000, 0, 0, 5),
('32051812032016090007', '12100307041603406000000000001', 124, 251, NULL, 12, 345, 2),
('32051812032016090008', '12100307041603405170301120002', 124, 251, NULL, 0, 0, 5),
('32051812032016090009', '12100307041603405170301120006', 124, 251, NULL, 0, 0, 2),
('32051812032016090010', '12100307041603405170301120010', 124, 251, NULL, 23, 23, 1),
('32051812032016090011', '12100307041603405170301120001', 124, 251, NULL, 345, 0, 3),
('32051812032016090012', '12100307041603402060201030003', 124, 251, 1000000, 0, 0, 1),
('32051812032016090013', '12100307041603405170301120007', 124, 251, NULL, 0, 0, 1),
('32051812032016090014', '12100307041603402060201030004', 124, 251, 1000000, 0, 0, 1),
('32051812032016090015', '12100307041603405170301120008', 124, 251, NULL, 0, 0, 1),
('32051812032016090016', '12100307041603403110101010001', 124, 251, 90000000, 0, 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_keu_metode_penyusutan`
--

CREATE TABLE IF NOT EXISTS `mst_keu_metode_penyusutan` (
  `id_mst_metode_penyusutan` int(11) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `penjelasan` varchar(45) DEFAULT NULL,
  `aktif` varchar(45) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `mst_keu_metode_penyusutan`
--

INSERT INTO `mst_keu_metode_penyusutan` (`id_mst_metode_penyusutan`, `nama`, `penjelasan`, `aktif`) VALUES
(1, 'Metode Garis Lurus', 'Penjelasan Metode Garis Lurus', '1'),
(2, 'Metode Unit Produksi', 'Penjelasan Metode Unit Produksi', '1'),
(3, 'Metode Saldo menurun', 'Penjelasan Saldo Menurun Lurus', '1'),
(4, 'Metode Jumlah Angka Tahun', 'Penjelasan Jumlah Angka Tahun', '1'),
(5, 'Metode Tanpa Penyusutan', 'Penjelasan Metode Tanpa Penyusutan', '1'),
(6, 'Metode Manual', 'Penjelasan Metode Manual', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keu_inventaris`
--
ALTER TABLE `keu_inventaris`
  ADD PRIMARY KEY (`id_inventaris`),
  ADD KEY `fk_keu_inventaris_mst_keu_akun1_idx` (`id_mst_akun`),
  ADD KEY `fk_keu_inventaris_mst_keu_akun2_idx` (`id_mst_akun_akumulasi`),
  ADD KEY `fk_keu_inventaris_mst_keu_metode_penyusutan1_idx` (`id_mst_metode_penyusutan`),
  ADD KEY `fk_keu_inventaris_inventaris_barang1_idx` (`id_inventaris_barang`);

--
-- Indexes for table `mst_keu_metode_penyusutan`
--
ALTER TABLE `mst_keu_metode_penyusutan`
  ADD PRIMARY KEY (`id_mst_metode_penyusutan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_keu_metode_penyusutan`
--
ALTER TABLE `mst_keu_metode_penyusutan`
  MODIFY `id_mst_metode_penyusutan` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
