
-- --------------------------------------------------------

--
-- Struktur dari tabel `keu_jurnal`
--

CREATE TABLE IF NOT EXISTS `keu_jurnal` (
  `id_jurnal` varchar(16) NOT NULL,
  `id_transaksi` varchar(50) NOT NULL,
  `id_mst_akun` int(11) NOT NULL,
  `debet` double DEFAULT NULL,
  `kredit` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keu_sts`
--

CREATE TABLE IF NOT EXISTS `keu_sts` (
  `id_sts` varchar(16) NOT NULL,
  `tgl` date DEFAULT NULL,
  `code_cl_phc` char(11) NOT NULL,
  `nomor` varchar(45) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `status` enum('disetor','draft') DEFAULT NULL,
  `ttd_pimpinan_nip` varchar(45) DEFAULT NULL,
  `ttd_pimpinan_nama` varchar(55) DEFAULT NULL,
  `ttd_penerima_nip` varchar(45) DEFAULT NULL,
  `ttd_penerima_nama` varchar(55) DEFAULT NULL,
  `ttd_penyetor_nip` varchar(45) DEFAULT NULL,
  `ttd_penyetor_nama` varchar(55) DEFAULT NULL,
  `catatan` text,
  `id_transaksi_pendapatan` varchar(50) DEFAULT NULL,
  `id_transaksi_setor` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keu_transaksi`
--

CREATE TABLE IF NOT EXISTS `keu_transaksi` (
  `id_transaksi` varchar(50) NOT NULL,
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
-- Indexes for table `keu_sts`
--
ALTER TABLE `keu_sts`
  ADD PRIMARY KEY (`id_sts`),
  ADD KEY `fk_keu_sts_cl_phc1_idx` (`code_cl_phc`),
  ADD KEY `fk_keu_sts_keu_transaksi1_idx` (`id_transaksi_pendapatan`),
  ADD KEY `fk_keu_sts_keu_transaksi2_idx` (`id_transaksi_setor`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
