-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Agu 2016 pada 04.11
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
-- Struktur dari tabel `mst_keu_transaksi`
--

CREATE TABLE IF NOT EXISTS `mst_keu_transaksi` (
  `id_mst_transaksi` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `untuk_jurnal` enum('semua','jurnal_umum','jurnal_penyesuaian','jurnal_penutup') DEFAULT NULL,
  `deskripsi` text,
  `jumlah_transaksi` int(11) DEFAULT NULL,
  `bisa_diubah` tinyint(1) DEFAULT NULL,
  `id_mst_kategori_transaksi` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `mst_keu_transaksi`
--

INSERT INTO `mst_keu_transaksi` (`id_mst_transaksi`, `nama`, `untuk_jurnal`, `deskripsi`, `jumlah_transaksi`, `bisa_diubah`, `id_mst_kategori_transaksi`) VALUES
(9, 'Pendapatan Pasien Umum', 'jurnal_umum', '', 0, 0, 1),
(10, 'Pendapatan BPJS-Rawat Inap dan Persalina', 'jurnal_umum', '', 0, 0, 1),
(11, 'Pendapatan BPJS Kapitasi', 'jurnal_umum', '', 0, 0, 1),
(12, 'Jasa Giro', 'jurnal_umum', '', 0, 0, 1),
(13, 'Transfer Bendahara penerimaan ke bank', 'jurnal_umum', '', 0, 0, 1),
(14, 'Pendapatan BPJS-Rawat Inap dan Persalinan', 'jurnal_umum', '', 0, 0, 1),
(15, 'Jasa Giro', 'jurnal_umum', '', 0, 0, 1),
(16, 'Pendapatan Pasien Umum Kredit', 'jurnal_umum', '', 0, 0, 1),
(17, 'Klaim Persalinan & Rawat Inap BPJS', 'jurnal_umum', '', 0, 0, 1),
(18, 'Denda', 'jurnal_umum', '', 0, 0, 1),
(19, 'Pembelian Persediaan', 'jurnal_umum', '', 0, 0, 2),
(20, 'Pembelian Persediaan', 'jurnal_umum', '', 0, 0, 2),
(21, 'Biaya', 'jurnal_umum', '', 0, 0, 2),
(22, 'Biaya', 'jurnal_umum', '', 0, 0, 2),
(23, 'Transfer dari bank ke bendahara pengeluaran', 'jurnal_umum', '', 0, 0, 2),
(24, 'Transfer dari bank ke bendahara pengeluaran', 'jurnal_umum', '', 0, 0, 2),
(25, 'Biaya yang harus dibayar (non operasional, 32600)', 'jurnal_umum', '', 0, 0, 2),
(26, 'Biaya Jasa pelayanan', 'jurnal_umum', '', 0, 0, 2),
(27, 'Setor Pajak PPH ps 21', 'jurnal_umum', '', 0, 0, 2),
(28, 'Pembelian Perlengkapan', 'jurnal_umum', '', 0, 0, 2),
(29, 'Setor Pajak PPN', 'jurnal_umum', '', 0, 0, 2),
(30, 'Setor Pajak PPH ps 22', 'jurnal_umum', '', 0, 0, 2),
(31, 'Pelunasan Hutang Dagang', 'jurnal_umum', '', 0, 0, 2),
(32, 'Biaya Bahan bahan', 'jurnal_penyesuaian', '', 0, 0, 3),
(33, 'Biaya jasa langganan', 'jurnal_penyesuaian', '', 0, 0, 3),
(34, 'Biaya penyusutan', 'jurnal_penyesuaian', '', 0, 0, 3),
(35, 'Biaya Asuransi', 'jurnal_penyesuaian', '', 0, 0, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_keu_transaksi_item`
--

CREATE TABLE IF NOT EXISTS `mst_keu_transaksi_item` (
  `id_mst_transaksi_item` int(11) NOT NULL,
  `id_mst_akun` int(11) NOT NULL,
  `id_mst_transaksi` int(11) NOT NULL,
  `type` enum('debit','kredit') DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `auto_fill` tinyint(1) DEFAULT NULL,
  `id_mst_transaksi_item_from` int(11) DEFAULT NULL,
  `value` tinyint(4) DEFAULT NULL,
  `urutan` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `mst_keu_transaksi_item`
--

INSERT INTO `mst_keu_transaksi_item` (`id_mst_transaksi_item`, `id_mst_akun`, `id_mst_transaksi`, `type`, `group`, `auto_fill`, `id_mst_transaksi_item_from`, `value`, `urutan`) VALUES
(44, 154, 11, 'kredit', 1, NULL, NULL, NULL, 1),
(43, 60, 11, 'debit', 1, NULL, NULL, NULL, 1),
(42, 155, 10, 'kredit', 1, NULL, NULL, NULL, 1),
(41, 69, 10, 'debit', 1, NULL, NULL, NULL, 1),
(40, 19, 9, 'kredit', 1, NULL, NULL, NULL, 1),
(39, 8, 9, 'debit', 1, NULL, NULL, NULL, 1),
(49, 69, 14, 'debit', 1, NULL, NULL, NULL, 1),
(48, 8, 13, 'kredit', 1, NULL, NULL, NULL, 1),
(47, 59, 13, 'debit', 1, NULL, NULL, NULL, 1),
(46, 167, 12, 'kredit', 1, NULL, NULL, NULL, 1),
(45, 60, 12, 'debit', 1, NULL, NULL, NULL, 1),
(50, 155, 14, 'kredit', 1, NULL, NULL, NULL, 1),
(51, 59, 15, 'debit', 1, NULL, NULL, NULL, 1),
(52, 167, 15, 'kredit', 1, NULL, NULL, NULL, 1),
(53, 74, 16, 'debit', 1, NULL, NULL, NULL, 1),
(54, 19, 16, 'kredit', 1, NULL, NULL, NULL, 1),
(55, 60, 17, 'debit', 1, NULL, NULL, NULL, 1),
(56, 69, 17, 'kredit', 1, NULL, NULL, NULL, 1),
(57, 60, 18, 'debit', 1, NULL, NULL, NULL, 1),
(58, 60, 18, 'kredit', 1, NULL, NULL, NULL, 1),
(59, 20, 19, 'debit', 1, NULL, NULL, NULL, 1),
(60, 124, 19, 'kredit', 1, NULL, NULL, NULL, 1),
(61, 20, 20, 'debit', 1, NULL, NULL, NULL, 1),
(62, 9, 20, 'kredit', 1, NULL, NULL, NULL, 1),
(63, 5, 21, 'debit', 1, NULL, NULL, NULL, 1),
(64, 9, 21, 'kredit', 1, NULL, NULL, NULL, 1),
(65, 5, 22, 'debit', 1, NULL, NULL, NULL, 1),
(66, 124, 22, 'kredit', 1, NULL, NULL, NULL, 1),
(67, 9, 23, 'debit', 1, NULL, NULL, NULL, 1),
(68, 59, 23, 'kredit', 1, NULL, NULL, NULL, 1),
(69, 9, 24, 'debit', 1, NULL, NULL, NULL, 1),
(70, 60, 24, 'kredit', 1, NULL, NULL, NULL, 1),
(71, 135, 25, 'debit', 1, NULL, NULL, NULL, 1),
(72, 60, 25, 'kredit', 1, NULL, NULL, NULL, 1),
(73, 183, 26, 'debit', 1, NULL, NULL, NULL, 1),
(74, 9, 26, 'kredit', 1, NULL, NULL, NULL, 1),
(75, 143, 26, 'kredit', 1, NULL, 0, NULL, 2),
(76, 143, 27, 'debit', 1, NULL, NULL, NULL, 1),
(77, 9, 27, 'kredit', 1, NULL, NULL, NULL, 1),
(78, 119, 28, 'debit', 1, NULL, NULL, NULL, 1),
(79, 9, 28, 'kredit', 1, NULL, NULL, NULL, 1),
(80, 142, 28, 'kredit', 1, NULL, 0, NULL, 3),
(81, 144, 28, 'kredit', 1, NULL, 0, NULL, 4),
(82, 142, 29, 'debit', 1, NULL, NULL, NULL, 1),
(83, 9, 29, 'kredit', 1, NULL, NULL, NULL, 1),
(84, 144, 30, 'debit', 1, NULL, NULL, NULL, 1),
(85, 9, 30, 'kredit', 1, NULL, NULL, NULL, 1),
(86, 124, 31, 'debit', 1, NULL, NULL, NULL, 1),
(87, 7, 31, 'kredit', 1, NULL, NULL, NULL, 1),
(88, 5, 32, 'debit', 1, NULL, NULL, NULL, 1),
(89, 20, 32, 'kredit', 1, NULL, NULL, NULL, 1),
(90, 213, 33, 'debit', 1, NULL, NULL, NULL, 1),
(91, 135, 33, 'kredit', 1, NULL, NULL, NULL, 1),
(92, 251, 34, 'debit', 1, NULL, NULL, NULL, 1),
(93, 16, 34, 'kredit', 1, NULL, NULL, NULL, 1),
(94, 244, 35, 'debit', 1, NULL, NULL, NULL, 1),
(95, 99, 35, 'kredit', 1, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_keu_transaksi`
--
ALTER TABLE `mst_keu_transaksi`
  ADD PRIMARY KEY (`id_mst_transaksi`),
  ADD KEY `fk_mst_keu_transaksi_mst_keu_kategori_transaksi1_idx` (`id_mst_kategori_transaksi`);

--
-- Indexes for table `mst_keu_transaksi_item`
--
ALTER TABLE `mst_keu_transaksi_item`
  ADD PRIMARY KEY (`id_mst_transaksi_item`),
  ADD KEY `fk_mst_keu_transaksi_item_mst_keu_akun1_idx` (`id_mst_akun`),
  ADD KEY `fk_mst_keu_transaksi_item_mst_keu_transaksi_item1_idx` (`id_mst_transaksi_item_from`),
  ADD KEY `fk_mst_keu_transaksi_item_mst_keu_transaksi1_idx` (`id_mst_transaksi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_keu_transaksi`
--
ALTER TABLE `mst_keu_transaksi`
  MODIFY `id_mst_transaksi` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `mst_keu_transaksi_item`
--
ALTER TABLE `mst_keu_transaksi_item`
  MODIFY `id_mst_transaksi_item` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=96;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
