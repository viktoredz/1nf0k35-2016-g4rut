

--
-- Table structure for table `mst_peg_berhenti`
--

CREATE TABLE IF NOT EXISTS `mst_peg_berhenti` (
  `id_berhenti` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(150) DEFAULT NULL,
  `jenis` enum('hormat','tidakhormat') DEFAULT NULL,
  PRIMARY KEY (`id_berhenti`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mst_peg_berhenti`
--

INSERT INTO `mst_peg_berhenti` (`id_berhenti`, `kategori`, `jenis`) VALUES
(1, 'Meninggal Dunia', 'hormat'),
(2, 'Atas Permintaan sendiri', 'hormat'),
(3, 'Mencapai Batas Usia Pensiun', 'hormat'),
(4, 'Adanya Penyederhanaan Organisasi', 'hormat'),
(5, 'Tidak Cakap Jasmani Dan Rohani ', 'hormat'),
(6, 'Melanggar sumpah/janji ', 'tidakhormat'),
(7, 'Melakukan penyelewengan ', 'tidakhormat'),
(8, 'Dihukum penjara atau kurungan ', 'tidakhormat');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai_berhenti`
--

CREATE TABLE IF NOT EXISTS `pegawai_berhenti` (
  `id_pegawai` varchar(12) NOT NULL,
  `id_berhenti` int(11) NOT NULL,
  `tmt` date NOT NULL,
  `sk_tgl` date DEFAULT NULL,
  `sk_nomor` varchar(50) DEFAULT NULL,
  `sk_pejabat` varchar(100) DEFAULT NULL,
  `berhenti_tipe` enum('hormat','tidakhormat') DEFAULT NULL,
  `code_cl_phc` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

