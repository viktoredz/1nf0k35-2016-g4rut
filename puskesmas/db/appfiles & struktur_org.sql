-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30 Mei 2016 pada 09.04
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
-- Struktur dari tabel `app_files`
--

CREATE TABLE IF NOT EXISTS `app_files` (
  `id` int(10) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'ina',
  `filename` varchar(100) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `id_theme` int(10) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `app_files`
--

INSERT INTO `app_files` (`id`, `lang`, `filename`, `module`, `id_theme`) VALUES
(1, 'ina', 'Home', 'morganisasi', 2),
(3, 'ina', 'Permohonan', 'permohonan', 2),
(2, 'en', 'Users', 'admin_user', 2),
(4, 'en', 'Pemeriksaan', 'pemeriksaan', 2),
(3, 'en', 'Permohonan', 'permohonan', 2),
(4, 'ina', 'Pemeriksaan', 'pemeriksaan', 2),
(5, 'en', 'Sertifikat', 'sertifikat', 2),
(5, 'ina', 'Sertifikat', 'sertifikat', 2),
(6, 'ina', 'Master Data', '#', 2),
(6, 'en', 'Master Data', '#', 2),
(2, 'ina', 'Users', 'admin_user', 2),
(1, 'en', 'Home', 'index.php', 2),
(31, 'ina', 'Admin', 'admin', 3),
(31, 'en', 'Admin', 'admin', 3),
(36, 'ina', 'Menu', 'admin_menu', 2),
(36, 'en', 'Menu', 'admin_menu', 2),
(37, 'ina', 'File', 'admin_file', 2),
(37, 'en', 'Files', 'admin_file', 2),
(38, 'ina', 'Hak Akses', 'admin_role', 2),
(38, 'en', 'Role', 'admin_role', 2),
(39, 'ina', 'Dashboard', '#', 2),
(39, 'en', 'Dashboard', '#', 2),
(40, 'ina', 'Profil', 'morganisasi/profile', 2),
(40, 'en', 'Profile', 'morganisasi/profile', 2),
(41, 'ina', 'Laporan', '#', 2),
(41, 'en', 'Report', '#', 2),
(42, 'ina', 'Daftar Produsen Benih', 'lap_penangkar', 2),
(42, 'en', 'List of Seed Producers', 'lap_penangkar', 2),
(43, 'ina', 'Rekapitulasi Sertifikasi', 'lap_rekap', 2),
(43, 'en', 'Recapitulation Certification', 'lap_rekap', 2),
(44, 'ina', 'Daftar Komoditi', 'lap_komoditi', 2),
(44, 'en', 'Commodity List', 'lap_komoditi', 2),
(45, 'ina', 'Charts', '#', 2),
(45, 'en', 'Charts', '#', 2),
(46, 'ina', 'Daerah Produsen Benih', 'chart_penangkar', 2),
(46, 'en', 'Regional Seed Producers', 'chart_penangkar', 2),
(47, 'ina', 'Rekapitulasi Sertifikat', 'chart_sert', 2),
(47, 'en', 'Recapitulation Certificate', 'chart_sert', 2),
(48, 'ina', 'Rekapitulasi Komoditi', 'chart_komd', 2),
(48, 'en', 'Commodity recapitulation', 'chart_komd', 2),
(49, 'ina', 'Admin Panel', '#', 2),
(49, 'en', 'Admin Panel', '#', 2),
(50, 'ina', 'Konfigurasi', 'admin_config', 2),
(50, 'en', 'Configuration', 'admin_config', 2),
(51, 'ina', 'Data Master', '#', 2),
(51, 'en', 'Master Data', '#', 2),
(52, 'ina', 'Puskesmas', 'mst/puskesmas', 2),
(52, 'en', 'Puskesmas', 'mst/puskesmas', 2),
(53, 'ina', 'Kepegawaian', '#', 2),
(53, 'en', 'officialdom', '#', 2),
(54, 'ina', 'Daftar Riwayat Hidup', 'kepegawaian/drh', 2),
(54, 'en', 'Daftar Riwayat Hidup', 'kepegawaian/drh', 2),
(55, 'ina', 'Keuangan', '#', 2),
(55, 'en', 'Finansial', '#', 2),
(56, 'ina', '#Target Penerimaan', 'keuangan/target_penerimaan', 2),
(56, 'en', '#Target Penerimaan', 'keuangan/target_penerimaan', 2),
(57, 'ina', 'Aset Tetap', '#', 2),
(57, 'en', 'Aset Tetap', '#', 2),
(58, 'ina', 'Pengadaan Barang', 'inventory/pengadaanbarang', 2),
(58, 'en', 'Pengadaan Barang', 'inventory/pengadaanbarang', 2),
(59, 'ina', 'SMS Gateway', '#', 2),
(59, 'en', 'SMS Gateway', '#', 2),
(60, 'ina', 'SMS Dashboard', 'sms/sms', 2),
(60, 'en', 'SMS Dashboard', 'sms/sms', 2),
(61, 'ina', 'SMS Diterima', 'sms/inbox', 2),
(61, 'en', 'SMS Diterima', 'sms/inbox', 2),
(62, 'ina', 'Buku Telepon', 'sms/pbk', 2),
(62, 'en', 'Phonebook', 'sms/pbk', 2),
(63, 'ina', 'SMS Grup', 'sms/group', 2),
(63, 'en', 'SMS Grup', 'sms/group', 2),
(64, 'ina', 'SMS Info', 'sms/autoreply', 2),
(64, 'en', 'SMS Info', 'sms/autoreply', 2),
(120, 'ina', 'Kepegawaian', 'kepegawaian', 2),
(66, 'ina', 'Daftar Urut Pegawai (D.U.P)', 'kepegawaian/lap_dup', 2),
(66, 'en', 'Daftar Urut Pegawai (D.U.P)', 'kepegawaian/lap_dup', 2),
(67, 'ina', 'Agama', 'mst/agama', 2),
(67, 'en', 'Religion', 'mst/agama', 2),
(68, 'ina', 'Desa / Kelurahan', 'mst/desa', 2),
(68, 'en', 'Village / Sub', 'mst/desa', 2),
(69, 'ina', 'Kota / Kabupaten', 'mst/kabupatenkota', 2),
(69, 'en', 'City / County', 'mst/kabupatenkota', 2),
(70, 'ina', 'Kecamatan', 'mst/kecamatan', 2),
(70, 'en', 'Districts', 'mst/kecamatan', 2),
(71, 'ina', 'Provinsi', 'mst/provinsi', 2),
(71, 'en', 'Province', 'mst/provinsi', 2),
(72, 'ina', 'Inv Barang', 'mst/invbarang', 2),
(72, 'en', 'Inventory', 'mst/invbarang', 2),
(74, 'ina', 'Kepegawaian', '#', 2),
(74, 'en', 'Employee Affair', '#', 2),
(75, 'ina', 'SMS Setting', 'sms/setting', 2),
(75, 'en', 'SMS Setting', 'sms/setting', 2),
(76, 'ina', 'Inventaris Ruangan', 'inventory/inv_ruangan', 2),
(76, 'en', 'Inventaris Ruangan', 'inventory/inv_ruangan', 2),
(77, 'ina', 'Permohonan Barang', 'inventory/permohonanbarang', 2),
(77, 'en', 'Permohonan Barang', 'inventory/permohonanbarang', 2),
(78, 'ina', 'inventory', 'inventory', 2),
(78, 'en', 'inventory', 'inventory', 2),
(79, 'ina', 'mst', 'mst', 2),
(79, 'en', 'mst', 'mst', 2),
(80, 'ina', 'Keu Tarif STS', 'mst/keuangan_sts', 2),
(80, 'en', 'Keu Tarif STS', 'mst/keuangan_sts', 2),
(81, 'ina', 'keuangan', 'keuangan', 2),
(81, 'en', 'keuangan', 'keuangan', 2),
(82, 'ina', 'sms', 'sms', 2),
(82, 'en', 'sms', 'sms', 2),
(83, 'ina', 'SMS Terkirim', 'sms/sentitems', 2),
(83, 'en', 'SMS Terkirim', 'sms/sentitems', 2),
(84, 'ina', 'Peg Status Nikah', 'mst/pegnikah', 2),
(84, 'en', 'Kep Status Nikah', 'mst/pegnikah', 2),
(85, 'ina', 'Inv Pilihan', 'mst/invpilihan', 2),
(85, 'en', 'Inv Pilihan', 'mst/invpilihan', 2),
(86, 'ina', 'Keu Kode Rekening', 'mst/keuangan_rekening', 2),
(86, 'en', 'Keu Kode Rekening', 'mst/keuangan_rekening', 2),
(87, 'ina', 'Peg Rumpun Pendidikan', 'mst/pegpendidikanrumpun', 2),
(87, 'en', 'Peg Rumpun Pendidikan', 'mst/pegpendidikanrumpun', 2),
(88, 'ina', 'Peg Tingkat Pendidikan', 'mst/pegpendidikantingkat', 2),
(88, 'en', 'Peg Tingkat Pendidikan', 'mst/pegpendidikantingkat', 2),
(89, 'ina', 'Peg Jurusan Pendidikan', 'mst/pegpendidikanjurusan', 2),
(89, 'en', 'Peg Jurusan Pendidikan', 'mst/pegpendidikanjurusan', 2),
(90, 'ina', 'Peg Kursus/Diklat', 'mst/kursusdiklat', 2),
(90, 'en', 'Peg Kursus/Diklat', 'mst/kursusdiklat', 2),
(91, 'ina', 'Peg Penghargaan', 'mst/pegpenghargaan', 2),
(91, 'en', 'Peg Penghargaan', 'mst/pegpenghargaan', 2),
(92, 'ina', 'Peg Golongan/Ruang', 'mst/peggolongan', 2),
(92, 'en', 'Peg Golongan/Ruang', 'mst/peggolongan', 2),
(93, 'ina', 'Peg Jabatan Fungsional', 'mst/pegfungsional', 2),
(93, 'en', 'Peg Jabatan Fungsional', 'mst/pegfungsional', 2),
(94, 'ina', 'Peg Jabatan Struktural', 'mst/pegstruktural', 2),
(94, 'en', 'Peg Jabatan Struktural', 'mst/pegstruktural', 2),
(95, 'ina', 'Peg Listing', 'mst/peglisting', 2),
(95, 'en', 'Peg Listing', 'mst/peglisting', 2),
(96, 'ina', 'PNS : Listing', 'kepegawaian/listing_pns', 2),
(96, 'en', 'PNS : Listing', 'kepegawaian/listing_pns', 2),
(97, 'ina', 'Absensi', 'kepegawaian/absensi', 2),
(97, 'en', 'Absensi', 'kepegawaian/absensi', 2),
(98, 'ina', 'Daftar Urut Kepangkatan (D.U.K)', 'kepegawaian/lap_duk', 2),
(98, 'en', 'Daftar Urut Kepangkatan (D.U.K)', 'kepegawaian/lap_duk', 2),
(99, 'ina', 'Rekap Tenaga Medis', 'kepegawaian/lap_tenagamedis', 2),
(99, 'en', 'Rekap Tenaga Medis', 'kepegawaian/lap_tenagamedis', 2),
(100, 'ina', 'Statistik Absensi', 'kepegawaian/lap_absensi', 2),
(100, 'en', 'Statistik Absensi', 'kepegawaian/lap_absensi', 2),
(101, 'ina', 'Kenaikan Pangkat', 'kepegawaian/lap_pangkat', 2),
(101, 'en', 'Kenaikan Pangkat', 'kepegawaian/lap_pangkat', 2),
(102, 'ina', 'Kenaikan Jabatan', 'kepegawaian/lap_jabatan', 2),
(102, 'en', 'Kenaikan Jabatan', 'kepegawaian/lap_jabatan', 2),
(103, 'ina', 'Non PNS : Listing TKD', 'kepegawaian/listing_nonpns', 2),
(103, 'en', 'Non PNS : Listing TKD', 'kepegawaian/listing_nonpns', 2),
(104, 'ina', 'Penilaian Angka Kredit (P.A.K)', 'kepegawaian/pak', 2),
(104, 'en', 'Penilaian Angka Kredit (P.A.K)', 'kepegawaian/pak', 2),
(105, 'ina', 'Penilaian Sasaran Kerja Pegawai', 'kepegawaian/skp', 2),
(105, 'en', 'Penilaian Sasaran Kerja Pegawai', 'kepegawaian/skp', 2),
(106, 'ina', 'Inventaris Barang', 'inventory/inv_barang', 2),
(106, 'en', 'Inventaris Barang', 'inventory/inv_barang', 2),
(107, 'ina', 'K I R', 'inventory/lap_kir', 2),
(107, 'en', 'K I R', 'inventory/lap_kir', 2),
(108, 'ina', 'K I B - A', 'inventory/lap_kiba', 2),
(108, 'en', 'K I B - A', 'inventory/lap_kiba', 2),
(109, 'ina', 'K I B - B', 'inventory/lap_kibb', 2),
(109, 'en', 'K I B - B', 'inventory/lap_kibb', 2),
(110, 'ina', 'K I B - C', 'inventory/lap_kibc', 2),
(110, 'en', 'K I B - C', 'inventory/lap_kibc', 2),
(111, 'ina', 'K I B - D', 'inventory/lap_kibd', 2),
(111, 'en', 'K I B - D', 'inventory/lap_kibd', 2),
(112, 'ina', 'K I B - E', 'inventory/lap_kibe', 2),
(112, 'en', 'K I B - E', 'inventory/lap_kibe', 2),
(113, 'ina', 'K I B - F', 'inventory/lap_kibf', 2),
(113, 'en', 'K I B - F', 'inventory/lap_kibf', 2),
(114, 'ina', 'Subsidi - BKU Subsidi', 'keuangan/subsidi_bku', 2),
(114, 'en', 'Subsidi - BKU Subsidi', 'keuangan/subsidi_bku', 2),
(115, 'ina', 'Surat Tanda Setoran', 'keuangan/sts/general', 2),
(115, 'en', 'Surat Tanda Setoran', 'keuangan/sts/general', 2),
(116, 'ina', 'Opini Publik', 'sms/opini', 2),
(116, 'en', 'Opini Publik', 'sms/opini', 2),
(118, 'ina', 'SMS Tipe', 'sms/tipe', 2),
(117, 'ina', 'SMS Masal', 'sms/bc', 2),
(117, 'en', 'SMS Masal', 'sms/bc', 2),
(118, 'en', 'SMS Tipe', 'sms/tipe', 2),
(119, 'ina', 'SMS Menu', 'sms/menu_sms', 2),
(119, 'en', 'SMS Menu', 'sms/menu_sms', 2),
(120, 'en', 'Kepegawaian', 'kepegawaian', 2),
(121, 'ina', '#BKU Penerimaan Pembantu', 'keuangan/bku_penerimaan', 2),
(121, 'en', '#BKU Penerimaan Pembantu', 'keuangan/bku_penerimaan', 2),
(122, 'ina', 'Distribusi Barang', 'inventory/distribusibarang', 2),
(122, 'en', 'Distribusi Barang', 'inventory/distribusibarang', 2),
(123, 'ina', 'L P L P O', 'inventory/lap_lplpo', 2),
(123, 'en', 'L P L P O', 'inventory/lap_lplpo', 2),
(124, 'ina', 'R K B U', 'inventory/lap_rkbu', 2),
(124, 'en', 'R K B U', 'inventory/lap_rkbu', 2),
(125, 'ina', 'Lap. Pengadaan Barang', 'inventory/lap_pengadaan', 2),
(125, 'en', 'Lap. Pengadaan Barang', 'inventory/lap_pengadaan', 2),
(126, 'ina', 'Bahan Habis Pakai', '#', 2),
(126, 'en', 'Bahan Habis Pakai', '#', 2),
(127, 'ina', 'Penerimaan', 'inventory/bhp_pengadaan', 2),
(127, 'en', 'Penerimaan', 'inventory/bhp_pengadaan', 2),
(129, 'ina', 'Bahan Habis Pakai', 'mst/invbaranghabispakai', 2),
(129, 'en', 'Bahan Habis Pakai', 'mst/invbaranghabispakai', 2),
(130, 'ina', 'Riwayat Pengadaan BHP', 'inventory/lap_bhp_pengadaan', 2),
(130, 'en', 'Riwayat Pengadaan BHP', 'inventory/lap_bhp_pengadaan', 2),
(131, 'ina', 'Stock BHP', 'inventory/lap_bhp_pengeluaran', 2),
(131, 'en', 'Stock BHP', 'inventory/lap_bhp_pengeluaran', 2),
(132, 'ina', 'Kartu Ketersediaan BHP', 'inventory/lap_bhp_ketersediaan', 2),
(132, 'en', 'Kartu Ketersediaan BHP', 'inventory/lap_bhp_ketersediaan', 2),
(133, 'ina', 'Buku Inventaris', 'inventory/lap_bukuinventaris', 2),
(133, 'en', 'Buku Inventaris', 'inventory/lap_bukuinventaris', 2),
(134, 'ina', 'Daftar Mutasi Barang', 'inventory/lap_mutasibarang', 2),
(134, 'en', 'Daftar Mutasi Barang', 'inventory/lap_mutasibarang', 2),
(135, 'ina', 'Stock Opname', 'inventory/bhp_opname', 2),
(135, 'en', 'Stock Opname', 'inventory/bhp_opname', 2),
(136, 'ina', 'Ketuk Pintu', '#', 2),
(136, 'en', 'Ketuk Pintu', '#', 2),
(137, 'ina', 'Data Keluarga', 'eform/data_kepala_keluarga', 2),
(137, 'en', 'Data Keluarga', 'eform/data_kepala_keluarga', 2),
(138, 'ina', 'eForm', 'eform', 2),
(138, 'en', 'eForm', 'eform', 2),
(139, 'ina', 'Penilaian DP3', 'kepegawaian/penilaiandppp', 2),
(139, 'en', 'Penilaian DP3', 'kepegawaian/penilaiandppp', 2),
(140, 'ina', 'D U K', 'kepegawaian/duk', 2),
(140, 'en', 'D U K', 'kepegawaian/duk', 2),
(141, 'ina', 'Laporan Hasil KPLDH', 'eform/laporan_kpldh', 2),
(141, 'en', 'Laporan Hasil KPLDH', 'eform/laporan_kpldh', 2),
(142, 'ina', 'Retur Barang', 'inventory/bhp_retur', 2),
(142, 'en', 'Retur Barang', 'inventory/bhp_retur', 2),
(161, 'ina', 'Struktur Organisasi', 'kepegawaian/struktur', 2),
(161, 'en', 'Struktur Organisasi', 'kepegawaian/struktur', 2),
(144, 'ina', 'Pemusnahan Sediaan', 'inventory/bhp_pemusnahan', 2),
(144, 'en', 'Pemusnahan Sediaan', 'inventory/bhp_pemusnahan', 2),
(145, 'ina', 'Distribusi', 'inventory/bhp_distribusi', 2),
(145, 'en', 'Distribusi', 'inventory/bhp_distribusi', 2),
(146, 'ina', 'Keu Akun', 'mst/keuangan_akun', 2),
(146, 'en', 'Keu Akun', 'mst/keuangan_akun', 2),
(147, 'ina', 'Dashboard', 'keuangan/dashboard', 2),
(147, 'en', 'Dashboard', 'keuangan/dashboard', 2),
(148, 'ina', 'Penyusutan Inventaris', 'keuangan/penyusutan', 2),
(148, 'en', 'Penyusutan Inventaris', 'keuangan/penyusutan', 2),
(149, 'ina', 'Jurnal', 'keuangan/jurnal', 2),
(149, 'en', 'Jurnal', 'keuangan/jurnal', 2),
(150, 'ina', 'Buku Besar', 'keuangan/bukubesar', 2),
(150, 'en', 'Buku Besar', 'keuangan/bukubesar', 2),
(151, 'ina', 'Neraca Lajur', 'keuangan/neracalajur', 2),
(151, 'en', 'Neraca Lajur', 'keuangan/neracalajur', 2),
(154, 'ina', 'Keu Instansi', 'mst/keuangan_instansi', 2),
(153, 'ina', 'Laporan Keuangan', 'keuangan/laporan', 2),
(153, 'en', 'Laporan Keuangan', 'keuangan/laporan', 2),
(154, 'en', 'Keu Instansi', 'mst/keuangan_instansi', 2),
(155, 'ina', 'Keu Laporan', 'mst/keuangan_laporan', 2),
(155, 'en', 'Keu Laporan', 'mst/keuangan_laporan', 2),
(156, 'ina', 'Keu Transaksi', 'mst/keuangan_transaksi', 2),
(156, 'en', 'Keu Transaksi', 'mst/keuangan_transaksi', 2),
(157, 'ina', 'Keu Inventaris', 'mst/keuangan_inventaris', 2),
(157, 'en', 'Keu Inventaris', 'mst/keuangan_inventaris', 2),
(158, 'ina', 'Keu Buku Besar', 'mst/keuangan_bukubesar', 2),
(158, 'en', 'Keu Buku Besar', 'mst/keuangan_bukubesar', 2),
(159, 'ina', 'Kondisi Barang', 'inventory/bhp_kondisi', 2),
(159, 'en', 'Kondisi Barang', 'inventory/bhp_kondisi', 2),
(160, 'ina', 'Permintaan', 'inventory/bhp_permintaan', 2),
(160, 'en', 'Permintaan', 'inventory/bhp_permintaan', 2),
(162, 'ina', 'Peg Organisasi', 'mst/pegorganisasi', 2),
(162, 'en', 'Peg Organisasi', 'mst/pegorganisasi', 2),
(163, 'ina', 'Stuktur Kepegawaian', 'kepegawaian/stuktur_kepegawaian', 2),
(163, 'en', 'Stuktur Kepegawaian', 'kepegawaian/stuktur_kepegawaian', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mst_peg_struktur_org`
--

CREATE TABLE IF NOT EXISTS `mst_peg_struktur_org` (
  `tar_id_struktur_org` int(11) NOT NULL,
  `tar_id_struktur_org_parent` int(11) DEFAULT '0',
  `tar_nama_posisi` varchar(100) NOT NULL,
  `tar_aktif` int(2) DEFAULT '1',
  `code_cl_phc` varchar(20) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `mst_peg_struktur_org`
--

INSERT INTO `mst_peg_struktur_org` (`tar_id_struktur_org`, `tar_id_struktur_org_parent`, `tar_nama_posisi`, `tar_aktif`, `code_cl_phc`) VALUES
(1, 0, 'Kepala Puskesmas', 1, 'P3205181203'),
(2, 1, 'Kepala Sub Bagian Tata Usaha', 1, 'P3205181203'),
(3, 2, 'Sistem Informasi Puskesmas', 1, 'P3205181203'),
(4, 2, 'Kepegawaian', 1, 'P3205181203'),
(5, 2, 'Rumah Tangga', 1, 'P3205181203'),
(6, 2, 'Keuangan', 1, 'P3205181203'),
(7, 1, 'Penanggung Jawab UKM Essensial dan Keperawatan Masyarakat', 1, 'P3205181203'),
(8, 1, 'Penanggung jawab UKM Pengembangan', 1, 'P3205181203'),
(9, 1, 'Penanggung Jawab UKP, Kefarmasian dan Laboratorium', 1, 'P3205181203'),
(10, 1, 'Penanggung Jawab Jaringan Pelayanan Puskesmas dan Jejaring Puskesmas Pelayanan Kesehatan', 1, 'P3205181203'),
(11, 7, 'Pelayanan Promosi Kesehatan Termasuk UKS', 1, 'P3205181203'),
(12, 7, 'Pelayanan Kesehatan Lingkungan', 1, 'P3205181203'),
(13, 7, 'Pelayanan KIA-KB yang bersifat UKM', 1, 'P3205181203'),
(14, 7, 'Pelayanan Gizi yang Bersifat UKM', 1, 'P3205181203'),
(15, 7, 'Pelayanan Pencegahan dan Pengendalian Penyakit', 1, 'P3205181203'),
(16, 7, 'Pelayanan Keperawatan Kesehatan Masyarakat', 1, 'P3205181203'),
(17, 8, 'Pelayanan Kesehatan Jiwa', 1, 'P3205181203'),
(18, 8, 'Pelayanan Kesehatan Gigi Masyarakat', 1, 'P3205181203'),
(19, 8, 'Pelayanan Kesehatan Tradisional Komplementer', 1, 'P3205181203'),
(20, 8, 'Pelayanan Kesehatan Indera', 1, 'P3205181203'),
(21, 8, 'Pelayanan Kesehatan Olahraga', 1, 'P3205181203'),
(22, 8, 'Pelayanan Kesehatan Lansia', 1, 'P3205181203'),
(23, 8, 'Pelayanan Kesehatan Kerja', 1, 'P3205181203'),
(24, 8, 'Pelayanan Kesehatan Lainnya', 1, 'P3205181203'),
(25, 9, 'Pelayanan Pemeriksaan Umum', 1, 'P3205181203'),
(26, 9, 'Pelayanan Kesehatan Gigi dan Mulut', 1, 'P3205181203'),
(27, 9, 'Pelayanan Kesehatan KIA - KB yang bersifat UKP', 1, 'P3205181203'),
(28, 9, 'Pelayanan Gawat Darurat', 1, 'P3205181203'),
(29, 9, 'Pelayananan Gizi yang Bersifat UKP', 1, 'P3205181203'),
(30, 9, 'Pelayanan Persalinan', 1, 'P3205181203'),
(31, 9, 'Pelayanan Rawat Inap', 1, 'P3205181203'),
(32, 9, 'Pelayanan Kefarmasian', 1, 'P3205181203'),
(33, 9, 'Pelayanan Laboratorium', 1, 'P3205181203'),
(34, 10, 'Puskesmas Pembantu', 1, 'P3205181203'),
(35, 10, 'Puskesmas Keliling', 1, 'P3205181203'),
(36, 10, 'Jejaring Fasilitas Pelayanan Kesehatan', 1, 'P3205181203'),
(37, 10, 'Bidan Desa', 1, 'P3205181203'),
(38, 1, 'Dokter Umum', 1, 'P3205181203'),
(39, 1, 'Dokter Gigi', 1, 'P3205181203'),
(40, 1, 'Apoteker', 1, 'P3205181203'),
(41, 1, 'Asisten Apoteker', 1, 'P3205181203'),
(42, 1, 'Bidan', 1, 'P3205181203'),
(43, 1, 'Perawat', 1, 'P3205181203'),
(44, 1, 'Sanitarian', 1, 'P3205181203'),
(45, 1, 'Promosi Kesehatan', 1, 'P3205181203'),
(46, 1, 'Nutrisionis', 1, 'P3205181203'),
(47, 1, 'Analis', 1, 'P3205181203'),
(48, 1, 'Epidemiologi', 1, 'P3205181203'),
(49, 1, 'Entomologi', 1, 'P3205181203'),
(50, 1, 'Perawat Gigi', 1, 'P3205181203');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_files`
--
ALTER TABLE `app_files`
  ADD PRIMARY KEY (`id`,`lang`);

--
-- Indexes for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  ADD PRIMARY KEY (`tar_id_struktur_org`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_files`
--
ALTER TABLE `app_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=164;
--
-- AUTO_INCREMENT for table `mst_peg_struktur_org`
--
ALTER TABLE `mst_peg_struktur_org`
  MODIFY `tar_id_struktur_org` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
