-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 23 Agu 2016 pada 11.57
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
-- Struktur dari tabel `mst_keu_akun`
--

CREATE TABLE IF NOT EXISTS `mst_keu_akun` (
  `id_mst_akun` int(11) NOT NULL,
  `id_mst_akun_parent` int(11) DEFAULT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `uraian` varchar(255) DEFAULT NULL,
  `saldo_normal` enum('debet','kredit') DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT NULL,
  `bisa_transaksi` tinyint(1) DEFAULT NULL,
  `saldo_awal` double DEFAULT NULL,
  `urutan` smallint(6) DEFAULT NULL,
  `keterangan` text,
  `bisa_diedit` tinyint(1) DEFAULT NULL,
  `tanggal_dibuat` datetime DEFAULT NULL,
  `buku_besar_umum` tinyint(1) DEFAULT NULL,
  `mendukung_anggaran` tinyint(1) DEFAULT NULL,
  `mendukung_target` tinyint(1) DEFAULT NULL,
  `mendukung_transaksi` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=260 DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `mst_keu_akun`
--

INSERT INTO `mst_keu_akun` (`id_mst_akun`, `id_mst_akun_parent`, `kode`, `uraian`, `saldo_normal`, `aktif`, `bisa_transaksi`, `saldo_awal`, `urutan`, `keterangan`, `bisa_diedit`, `tanggal_dibuat`, `buku_besar_umum`, `mendukung_anggaran`, `mendukung_target`, `mendukung_transaksi`) VALUES
(1, NULL, NULL, 'Harta', 'debet', 1, 0, 0, 7, NULL, 0, '2016-04-08 00:00:00', 1, 0, 0, 1),
(2, NULL, NULL, 'Hutang', 'kredit', 1, 0, 0, 11, NULL, 0, '2016-04-08 00:00:00', 1, 0, 0, NULL),
(3, NULL, NULL, 'Modal', 'kredit', 1, 0, 0, 5, NULL, 0, '2016-04-08 00:00:00', 1, 0, 0, NULL),
(4, NULL, NULL, 'Pendapatan', 'kredit', 1, 0, 0, 4, NULL, 0, '2016-04-08 00:00:00', 1, 0, 0, NULL),
(5, NULL, NULL, 'Beban', 'debet', 1, 0, 0, 3, NULL, 0, '2016-04-08 00:00:00', 1, 1, 1, 1),
(6, 1, '11000', 'Kas dan Setara Kas', 'debet', 1, 0, 0, 0, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, NULL),
(7, 6, '11100', 'Kas', 'debet', 1, 0, 0, 0, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, NULL),
(8, 7, '11110', 'Kas Bendahara Penerimaan', 'debet', 1, 0, 0, 0, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, NULL),
(9, 7, '11120', 'Kas Bendahara Pengeluaran', 'debet', 1, 0, 0, 0, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, NULL),
(58, 6, '11200', 'Bank', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:33:17', 1, NULL, NULL, 0),
(59, 58, '11210', 'Rekening Bank BLUD', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:34:45', 1, NULL, NULL, 0),
(13, 1, '21000', 'Aset Tetap', 'debet', 1, 0, 0, 3, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, 1),
(14, 13, '21100', 'Harga Perolehan', 'debet', 1, 0, 0, 3, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, 1),
(15, 14, '21110', 'Tanah', 'debet', 1, 0, 0, 3, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, NULL),
(16, 3, '21200', 'Akumulasi Penyusutan', 'kredit', 1, 0, 0, 1, NULL, 1, '2016-04-12 00:00:00', 1, 0, 0, NULL),
(17, 5, '62710', 'Beban Penyusutan', 'debet', 0, 1, 0, 1, NULL, 1, '2016-04-12 00:00:00', 1, 1, 1, 1),
(18, 4, '51000', 'Pendapatan Jasa Layanan', 'kredit', 1, 0, 100000, 1, NULL, 1, '2016-04-12 00:00:00', 1, 0, 1, 0),
(19, 18, '51100', 'Pendapatan Pasien Umum', 'kredit', 1, 1, 0, 1, NULL, 1, '2016-04-12 00:00:00', 1, 1, 1, 0),
(20, 1, '16000', 'Persediaan', 'debet', 1, 1, 0, 2, NULL, 1, '2016-04-04 00:00:00', 1, 0, 0, NULL),
(21, 4, '55000', 'Pendapatan Rutin', 'kredit', 1, 1, 0, 1, NULL, 1, '2016-04-05 00:00:00', 1, 0, 1, NULL),
(60, 58, '11220', 'Rekening Bank JKN', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:35:51', 1, NULL, NULL, 0),
(61, 1, '12000', 'Investasi Jaka Pendek', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:39:19', 1, NULL, NULL, 0),
(62, 61, '12100', 'Deposito s/d 3 Bulan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:39:55', 1, NULL, NULL, 0),
(63, 1, '13000', 'Piutang Panjar', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:40:27', 1, NULL, NULL, 0),
(64, 1, '14000', 'Piutang Pelayanan (Bersih)', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:41:33', 1, NULL, NULL, 0),
(65, 64, '14100', 'Piutang Pelayanan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:44:26', 1, NULL, NULL, 0),
(66, 65, '14110', 'Piutang Jaminan Perusahaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:45:29', 1, NULL, NULL, 0),
(67, 66, '14110.01', 'Piutang PT. A', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:46:06', 1, NULL, NULL, 0),
(68, 65, '14120', 'Piutang Pasien BPJS', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:47:03', 1, NULL, NULL, 0),
(69, 68, '14120.01', 'Klaim Persalinan & Rawat Inap BPJS', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:48:06', 1, NULL, NULL, 0),
(70, 68, '14120.02', 'Klaim Ambulance BPJS', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:49:01', 1, NULL, NULL, 0),
(71, 68, '14120.03', 'Klaim BPJS Lainnya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:49:38', 1, NULL, NULL, 0),
(72, 65, '14130', 'Piutang Pasien Akses Mandiri/Sukarela (In Health)', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:50:56', 1, NULL, NULL, 0),
(73, 65, '14140', 'Piutang Jamkesda', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:51:41', 1, NULL, NULL, 0),
(74, 65, '14150', 'Piutang Pasien Umum', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:53:47', 1, NULL, NULL, 0),
(75, 64, '14200', 'Cadangan Kerugian Piutang', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:55:23', 1, NULL, NULL, 0),
(76, 75, '14210', 'Kurang Lancar (lebih dari 1 tahun sd 2 tahun)', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:56:11', 1, NULL, NULL, 0),
(77, 75, '14220', 'Kurang Lancar (lebih dari 2 tahun sd 3 tahun)', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:56:49', 1, NULL, NULL, 0),
(78, 75, '14230', 'Tidak Lancar (lebih dari 3 tahun sd 5 tahun)', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:57:29', 1, NULL, NULL, 0),
(79, 75, '14240', 'Macet (lebih dari 5 tahun)', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 11:58:09', 1, NULL, NULL, 0),
(80, 1, '15000', 'Piutang Lain-lain', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:06:00', 1, NULL, NULL, 0),
(81, 80, '15100', 'Piutang Sewa', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:08:50', 1, NULL, NULL, 0),
(82, 81, '15110', 'Piutang Sewa ATM', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:09:22', 1, NULL, NULL, 0),
(83, 81, '15120', 'Piutang Sewa Lahan Parkir', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:09:50', 1, NULL, NULL, 0),
(84, 20, '16100', 'Persediaan Persediaan Bahan Farmasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:10:45', 1, NULL, NULL, 0),
(85, 84, '16110', 'Persediaan Obat-obat Farmasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:11:21', 1, NULL, NULL, 0),
(86, 84, '16120', 'Persediaan Bahan Medis Habis Pakai', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:12:32', 1, NULL, NULL, 0),
(87, 84, '16130', 'Persediaan Alat Kesehatan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:13:23', 1, NULL, NULL, 0),
(88, 84, '16140', 'Persediaan Radiologi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:15:02', 1, NULL, NULL, 0),
(89, 84, '16150', 'Persediaan Radioterapi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:17:19', 1, NULL, NULL, 0),
(90, 84, '16160', 'Persediaan Laboratorium', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:18:22', 1, NULL, NULL, 0),
(91, 20, '16200', 'Persediaan Alat-alat', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:19:23', 1, NULL, NULL, 0),
(92, 91, '16210', 'Persediaan ATK', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:20:08', 1, NULL, NULL, 0),
(93, 91, '16220', 'Persediaan Alat Kebersihan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:20:40', 1, NULL, NULL, 0),
(94, 91, '16230', 'Persediaan Alat Cetak', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:21:26', 1, NULL, NULL, 0),
(95, 91, '16240', 'Persediaan Alat Listrik', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:22:04', 1, NULL, NULL, 0),
(96, 91, '16250', 'Persediaan Alat Bangunan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:22:38', 1, NULL, NULL, 0),
(97, 20, '16300', 'Persediaan Barang Gizi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:23:34', 1, NULL, NULL, 0),
(98, 1, '17000', 'Beban Dibayar Dimuka', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:24:15', 1, NULL, NULL, 0),
(99, 98, '17100', 'Asuransi Dibayar Dimuka', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:25:15', 1, NULL, NULL, 0),
(100, 99, '17110', 'Asuransi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:25:38', 1, NULL, NULL, 0),
(101, 14, '21120', 'Peralatan dan Mesin', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:27:15', 1, NULL, NULL, 0),
(102, 101, '21121', 'Alat Berat', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:27:48', 1, NULL, NULL, 0),
(103, 101, '21122', 'Alat Angkutan Darat Bermotor', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:28:46', 1, NULL, NULL, 0),
(104, 101, '21123', 'Alat Bengkel', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:29:15', 1, NULL, NULL, 0),
(105, 101, '21124', 'Alat Kantor & RT', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:29:47', 1, NULL, NULL, 0),
(106, 101, '21125', 'Perlengkapan Kantor', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:30:15', 1, NULL, NULL, 0),
(107, 101, '21126', 'Komputer', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:30:42', 1, NULL, NULL, 0),
(108, 101, '21127', 'Alat Studio', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:32:49', 1, NULL, NULL, 0),
(109, 101, '21128', 'Alat Kedokteran', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:33:28', 1, NULL, NULL, 0),
(110, 101, '21129', 'Alat Laboratorium', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:34:03', 1, NULL, NULL, 0),
(111, 14, '21130', 'Gedung dan Bangunan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:35:04', 1, NULL, NULL, 0),
(112, 14, '21140', 'Jalan, Irigasi dan Jaringan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:35:33', 1, NULL, NULL, 0),
(113, 14, '21150', 'Aset Tetap Lainnya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:36:36', 1, NULL, NULL, 0),
(114, 113, '21151', 'Koleksi Buku/Perpustakaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:37:40', 1, NULL, NULL, 0),
(115, 113, '21152', 'Barang Bercorak Kesenian, Kebudayaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:38:43', 1, NULL, NULL, 0),
(116, 14, '21160', 'Konstruksi Dalam Pengerjaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:39:31', 1, NULL, NULL, 0),
(117, 1, '22000', 'Aset lain-lain', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:40:52', 1, NULL, NULL, 0),
(118, 117, '22100', 'Aset Tetap Rusak Berat', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:41:33', 1, NULL, NULL, 0),
(119, 117, '22200', 'Persediaan Kadaluarsa', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:42:02', 1, NULL, NULL, 0),
(120, 16, '21210', 'Akm. Peny. Peralatan dan Mesin', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:43:00', 1, NULL, NULL, 0),
(121, 16, '21220', 'Akm. Peny. Gedung dan Bangunan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:44:21', 1, NULL, NULL, 0),
(122, 16, '21230', 'Akm. Peny. Jalan, Irigasi dan Jaringan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:44:54', 1, NULL, NULL, 0),
(123, 16, '21240', 'Akm. Peny. Aset Tetap Lainny', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:45:27', 1, NULL, NULL, 0),
(124, 2, '31000', 'Hutang Usaha', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:46:50', 1, NULL, NULL, 0),
(125, 124, '31100', 'Hutang Usaha - Obat dan BMHP', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:47:24', 1, NULL, NULL, 0),
(126, 124, '31200', 'Hutang Usaha - Bahan Makanan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:47:43', 1, NULL, NULL, 0),
(127, 124, '31300', 'Hutang Usaha - Perlengkapan Pasien', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:48:10', 1, NULL, NULL, 0),
(128, 124, '31400', 'Hutang Usaha - Bahan Pembersih', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:48:49', 1, NULL, NULL, 0),
(129, 124, '31500', 'Hutang Usaha - Barang Cetakan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:49:09', 1, NULL, NULL, 0),
(130, 124, '31600', 'Hutang Usaha - Barang ATK', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:49:33', 1, NULL, NULL, 0),
(131, 124, '31700', 'Hutang Usaha - Perlengkapan Rumah Tangga', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:50:00', 1, NULL, NULL, 0),
(132, 124, '31800', 'Hutang Usaha - Pengadaan Aset Tetap', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:50:28', 1, NULL, NULL, 0),
(133, 124, '31900', 'Hutang Usaha - Pengadaan Jasa', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:50:54', 1, NULL, NULL, 0),
(134, 133, '31910', 'Hutang Usaha - Bahan Bakar Dapur', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:51:28', 1, NULL, NULL, 0),
(135, 2, '32000', 'Biaya Yang Masih Harus Dibayar (Biaya YMH)', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:52:11', 1, NULL, NULL, 0),
(136, 135, '32100', 'Biaya YMH - Jasa Pelayanan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:53:45', 1, NULL, NULL, 0),
(137, 135, '32200', 'Biaya YMH - Pemeliharaan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:54:11', 1, NULL, NULL, 0),
(138, 135, '32300', 'Biaya YMH - Administrasi Kantor', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:54:29', 1, NULL, NULL, 0),
(139, 135, '32400', 'Biaya YMH - Barang dan Jasa', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:54:59', 1, NULL, NULL, 0),
(140, 135, '32500', 'Biaya YMH - Biaya Operasional Lainnya', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:55:21', 1, NULL, NULL, 0),
(141, 2, '33000', 'Hutang Utang Pajak', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:56:05', 1, NULL, NULL, 0),
(142, 141, '33100', 'Hutang PPN', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:56:36', 1, NULL, NULL, 0),
(143, 141, '33200', 'Hutang PPh ps 21', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:56:57', 1, NULL, NULL, 0),
(144, 141, '33300', 'Hutang PPh ps 22', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:57:30', 1, NULL, NULL, 0),
(145, 2, '34000', 'Pendapatan Diterima Dimuka', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:57:53', 1, NULL, NULL, 0),
(146, 145, '34100', 'Uang Muka Pasien', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 13:58:18', 1, NULL, NULL, 0),
(147, 3, '41000', 'Ekuilitas Awal', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:04:57', 1, NULL, NULL, 0),
(148, 147, '41100', 'Koreksi Ekuitas Awal', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:09:41', 1, NULL, NULL, 0),
(149, 3, '42000', 'Ekuitas Hibah', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:10:14', 1, NULL, NULL, 0),
(150, 3, '43000', 'Surplus (Defisit)', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:10:48', 1, NULL, NULL, 0),
(151, 150, '43100', 'Surplus (Defisit) Tahun Lalu', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:11:19', 1, NULL, NULL, 0),
(152, 150, '43200', 'Surplus (Defisit) Tahun Berjalan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:12:12', 1, NULL, NULL, 0),
(153, 18, '51200', 'Pendapatan BPJS', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:14:30', 1, NULL, NULL, 0),
(154, 153, '51210', 'Pendapatan BPJS-Kapitasi', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:15:03', 1, NULL, NULL, 0),
(155, 153, '51220', 'Pendapatan BPJS-Rawat Inap dan Persalinan', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:15:30', 1, NULL, NULL, 0),
(156, 153, '51230', 'Pendapatan BPJS-Ambulance BPJS', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:16:21', 1, NULL, NULL, 0),
(157, 153, '51240', 'Pendapatan BPJS-Klaim Lainnya', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:16:59', 1, NULL, NULL, 0),
(158, 18, '51300', 'Pendapatan Asuransi Lain', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:17:51', 1, NULL, NULL, 0),
(159, 18, '51400', 'Pendapatan Jamkesda', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:18:18', 1, NULL, NULL, 0),
(160, 4, '52000', 'Pendapatan APBN', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:18:40', 1, NULL, NULL, 0),
(161, 4, '53000', 'Pendapatan APBD', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:19:05', 1, NULL, NULL, 0),
(162, 161, '53100', 'Operasional', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:19:36', 1, NULL, NULL, 0),
(163, 161, '53200', 'Investasi', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:20:21', 1, NULL, NULL, 0),
(164, 4, '54000', 'Pendapatan Lainnya', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:21:25', 1, NULL, NULL, 0),
(165, 164, '54100', 'Pelayanan Parkir', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:21:48', 1, NULL, NULL, 0),
(166, 164, '54200', 'Denda', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:22:07', 1, NULL, NULL, 0),
(167, 164, '54300', 'Jasa Giro', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:22:26', 1, NULL, NULL, 0),
(168, 5, '61000', 'Biaya Pelayanan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:31:27', 1, NULL, NULL, 0),
(169, 168, '61100', 'Biaya Pegawai', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:33:21', 1, NULL, NULL, 0),
(170, 169, '61110', 'Gaji dan Tunjangan  Non PNS', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:33:52', 1, NULL, NULL, 0),
(171, 169, '61120', 'Lembur', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:34:21', 1, NULL, NULL, 0),
(172, 169, '61130', 'Honorarium Pelayanan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:35:05', 1, NULL, NULL, 0),
(173, 169, '61140', 'Dinas Malam', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:35:28', 1, NULL, NULL, 0),
(174, 169, '61150', 'Piket Idul Fitri', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:35:48', 1, NULL, NULL, 0),
(175, 168, '61200', 'Biaya Bahan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:36:37', 1, NULL, NULL, 0),
(176, 175, '61210', 'Biaya Obat-obatan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:37:04', 1, NULL, NULL, 0),
(177, 175, '61220', 'Biaya Alkes', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:37:31', 1, NULL, NULL, 0),
(178, 175, '61230', 'Biaya Bahan dan Alat Laboratorium', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:38:16', 1, NULL, NULL, 0),
(179, 175, '61240', 'Biaya Bahan dan Alat Radiologi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:38:43', 1, NULL, NULL, 0),
(180, 175, '61250', 'Biaya Bahan Makan Pasien', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:39:11', 1, NULL, NULL, 0),
(181, 175, '61260', 'Biaya Bahan Bakar Dapur Pasien', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:40:05', 1, NULL, NULL, 0),
(182, 175, '61279', 'BHP Ruangan & Oksigen', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:41:00', 1, NULL, NULL, 0),
(183, 168, '61300', 'Biaya Jasa Pelayanan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:41:42', 1, NULL, NULL, 0),
(184, 183, '61310', 'Biaya Jasa Pelayanan Pegawai', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:42:07', 1, NULL, NULL, 0),
(185, 183, '61320', 'Biaya Jasa Pelayanan Medis Akrual', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:42:26', 1, NULL, NULL, 0),
(186, 183, '61330', 'Biaya Jasa Pelayanan Hari Raya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:42:52', 1, NULL, NULL, 0),
(187, 183, '61340', 'Biaya Jasa Insentif', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:43:27', 1, NULL, NULL, 0),
(188, 183, '61350', 'Biaya Jasa Pembinaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:44:01', 1, NULL, NULL, 0),
(189, 168, '61400', 'Biaya Pemeliharaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:44:33', 1, NULL, NULL, 0),
(190, 189, '61410', 'Pemeliharaan Alat Kedokteran', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:45:06', 1, NULL, NULL, 0),
(191, 189, '61420', 'Pemeliharaan Alat Transportasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:45:30', 1, NULL, NULL, 0),
(192, 189, '61430', 'Pemeliharaan Perlengkapan Kantor', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:46:02', 1, NULL, NULL, 0),
(193, 168, '61500', 'Biaya Barang dan Jasa', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:46:59', 1, NULL, NULL, 0),
(194, 193, '61510', 'Biaya Linen', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:47:27', 1, NULL, NULL, 0),
(195, 193, '61520', 'Biaya Cetakan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:47:46', 1, NULL, NULL, 0),
(196, 193, '61530', 'Biaya Makanan dan Minuman Pelayanan Lainnya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:48:14', 1, NULL, NULL, 0),
(197, 168, '61600', 'Biaya Pelayanan Lain-lain', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:48:43', 1, NULL, NULL, 0),
(198, 197, '61610', 'Biaya Pasien Jamkesmas,PKMS,Jamkesda dll', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:49:17', 1, NULL, NULL, 0),
(199, 197, '61620', 'Biaya Pemulasaran', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:50:01', 1, NULL, NULL, 0),
(200, 197, '61630', 'Biaya Pasien TB', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:50:16', 1, NULL, NULL, 0),
(201, 197, '61640', 'Biaya Perjalanan Dinas Pelayanan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:50:47', 1, NULL, NULL, 0),
(202, 5, '62000', 'Biaya Umum & Administrasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:51:28', 1, NULL, NULL, 0),
(203, 202, '62100', 'Biaya Pegawai', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:52:52', 1, NULL, NULL, 0),
(204, 203, '62110', 'Biaya Gaji dan Tunjangan PNS', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:53:52', 1, NULL, NULL, 0),
(205, 203, '62120', 'Biaya Lembur', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:54:28', 1, NULL, NULL, 0),
(206, 203, '62130', 'Biaya Honorarium Panitia', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:55:19', 1, NULL, NULL, 0),
(207, 202, '62200', 'Biaya Administrasi Kantor', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:55:48', 1, NULL, NULL, 0),
(208, 207, '62210', 'Biaya Benda Pos dan Pengiriman', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:56:18', 1, NULL, NULL, 0),
(209, 207, '62220', 'Biaya ATK', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:56:37', 1, NULL, NULL, 0),
(210, 207, '62230', 'Biaya Cetakan & Pengadaan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:56:57', 1, NULL, NULL, 0),
(211, 207, '62240', 'Biaya Pakaian Dinas/Kerja', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:57:37', 1, NULL, NULL, 0),
(212, 207, '62250', 'Biaya Makan Minum Tamu', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:57:59', 1, NULL, NULL, 0),
(213, 207, '62260', 'Biaya Jasa Langganan Listrik/Air/Telp/Internet', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:58:47', 1, NULL, NULL, 0),
(214, 207, '62270', 'Biaya Langganan Media/Surat Kabar/Majalah', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 14:59:14', 1, NULL, NULL, 0),
(215, 202, '62300', 'Biaya Pemeliharaan Adm dan UM', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:00:16', 1, NULL, NULL, 0),
(216, 215, '62310', 'Biaya Pemeliharaan Gedung & Banguan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:00:56', 1, NULL, NULL, 0),
(217, 215, '62320', 'Biaya Pemeliharaan Instalasi/Jaringan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:01:28', 1, NULL, NULL, 0),
(218, 215, '62330', 'Biaya Pemeliharaan Alat Transportasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:02:03', 1, NULL, NULL, 0),
(219, 215, '62340', 'Biaya Pemeliharaan Sarpras Lainnya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:02:34', 1, NULL, NULL, 0),
(220, 215, '62350', 'Biaya Pemeliharaan Alat Kantor dan RT', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:03:02', 1, NULL, NULL, 0),
(221, 202, '62400', 'Biaya Barang dan Jasa', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:03:37', 1, NULL, NULL, 0),
(222, 221, '62410', 'Biaya Bahan dan Alat Sanitasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:04:13', 1, NULL, NULL, 0),
(223, 221, '62420', 'Biaya Bahan Pembersih dan Alat Kebersihan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:04:46', 1, NULL, NULL, 0),
(224, 221, '62430', 'Biaya Bahan Bakar', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:05:16', 1, NULL, NULL, 0),
(225, 221, '62440', 'Biaya Bahan Gas', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:06:00', 1, NULL, NULL, 0),
(226, 221, '62450', 'Biaya Dapur/Pantry', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:06:29', 1, NULL, NULL, 0),
(227, 221, '62460', 'Biaya Pengisian Tabung Pemadam Kebakaran', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:07:05', 1, NULL, NULL, 0),
(228, 221, '62470', 'Biaya Jasa Konsultan dan pihak Ketiga Lainnya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:07:56', 1, NULL, NULL, 0),
(229, 221, '62480', 'Biaya Makanan dan Minuman Kantor', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:08:29', 1, NULL, NULL, 0),
(230, 221, '62490', 'Biaya Pengembangan SIM dan TI', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:08:57', 1, NULL, NULL, 0),
(240, 202, '62500', 'Biaya Promosi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:36:16', 1, NULL, NULL, 0),
(241, 240, '62510', 'Biaya Pemasaran dan Publikasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:36:56', 1, NULL, NULL, 0),
(242, 240, '62520', 'Biaya Komunikasi dan Mediamasa', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:37:28', 1, NULL, NULL, 0),
(243, 202, '62600', 'Biaya Umum dan Administrasi Lainnya', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:38:12', 1, NULL, NULL, 0),
(244, 243, '62610', 'Biaya Premi Asuransi dan Kesehatan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:38:40', 1, NULL, NULL, 0),
(245, 243, '62620', 'Biaya Kerugian Piutang', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:38:59', 1, NULL, NULL, 0),
(246, 243, '62630', 'Biaya Kerugian Penghapusan Aset Tetap dan Piutang', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:39:31', 1, NULL, NULL, 0),
(247, 243, '62640', 'Biaya Aset Extracomtable', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:40:11', 1, NULL, NULL, 0),
(248, 243, '62650', 'Biaya Perijinan, Legalisasi dan Akreditasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:41:14', 1, NULL, NULL, 0),
(249, 243, '62660', 'Biaya Keamanan dan Ketertiban/Sosial', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:41:45', 1, NULL, NULL, 0),
(250, 202, '62700', 'Biaya Penyusutan dan Amortisasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:42:12', 1, NULL, NULL, 0),
(251, 250, '62710', 'Biaya Penyusutan', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:42:33', 1, NULL, NULL, 0),
(252, 250, '62720', 'Biaya Amortisasi', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:42:52', 1, NULL, NULL, 0),
(253, 4, '63000', 'Pendapatan (Biaya) Non Operasional', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:43:41', 1, NULL, NULL, 0),
(254, 253, '63100', 'Pendapatan Non Operasional', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:44:09', 1, NULL, NULL, 0),
(255, 254, '63110', 'Pendapatan Bunga Bank', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:45:13', 1, NULL, NULL, 0),
(256, 254, '63120', 'Pendapatan Penj. Aset Tetap', 'kredit', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:45:42', 1, NULL, NULL, 0),
(257, 5, '63200', 'Biaya Non Operasional', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:46:53', 1, NULL, NULL, 0),
(258, 257, '63210', 'Beban Bunga', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:47:11', 1, NULL, NULL, 0),
(259, 257, '63220', 'Beban Administrasi Bank', 'debet', 1, NULL, 0, NULL, NULL, 1, '2016-08-23 15:47:34', 1, NULL, NULL, 0);

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
(4, 0, 0, 'debit', NULL, NULL, NULL, NULL, NULL),
(5, 0, 0, 'kredit', NULL, NULL, NULL, NULL, NULL),
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
-- Indexes for table `mst_keu_akun`
--
ALTER TABLE `mst_keu_akun`
  ADD PRIMARY KEY (`id_mst_akun`),
  ADD KEY `fk_mst_keu_akun_mst_keu_akun1_idx` (`id_mst_akun_parent`);

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
-- AUTO_INCREMENT for table `mst_keu_akun`
--
ALTER TABLE `mst_keu_akun`
  MODIFY `id_mst_akun` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=260;
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
