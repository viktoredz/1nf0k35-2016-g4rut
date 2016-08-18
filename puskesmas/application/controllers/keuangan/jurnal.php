<?php
class Jurnal extends CI_Controller {

 public function __construct(){
		parent::__construct();
		$this->load->model('keuangan/jurnal_model');
	}

	function index(){
		$this->authentication->verify('keuangan','edit');
		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Jurnal";
		$data['content']       = $this->parser->parse("keuangan/jurnal/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function tab($pageIndex){
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Umum";
				$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
				$data['filekategori'] =array('all'=>"Semua Kategori","penerimaankas" => 'Penerimaan Kas',"Pembelian" => 'pembelian',"Biaya" => 'biaya',"penjualan" => 'Penjualan',"pembukuan"=>'Pembukuan');
				$data['filetransaksi'] =array('all'=>"Semua Transaksi","transaksidisimpan" => 'Transaksi Disimpan',"transaksidraf" => 'Transaksi Draf');
				$data['tambahtransaksi'] =array('pendapatanumum'=>"Pendapatan Umum","pendapatanbpjs" => 'Pendapatan BPJS Kapasitas',"pembelian" => 'Pembelian Persediaan');
				$data['tambahtransaksiotomatis'] =array('transaksiotomatis'=>"Transaksi Otomatis");
				die($this->parser->parse("keuangan/jurnal/jurnal_umum",$data));

				break;
			case 2:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Penyesuaian";
				
				// die($this->parser->parse("keuangan/jurnal/jurnal_penyesuaian",$data));
				 die($this->parser->parse("keuangan/jurnal/form_penyusutan_inventaris",$data));

				break;
			case 3:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Penutup";
				
				die($this->parser->parse("keuangan/jurnal/jurnal_penutup",$data));

				break;
			default:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Umum";
				$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
				die($this->parser->parse("keuangan/jurnal/kategori_transaksi",$data));
				break;
		}
	}
	

	function json_jurnal_umum(){
		$this->authentication->verify('keuangan','show');

		$data = array(
						'0'=>array('id_jurnal' => '2','edit'=>'1','tanggal'=>'11-Maret-2016','transaksi'=>'Penerimaan Pendapatan Puskesmas - 110316-1','status'=>'Disimpan','child' => array(
											'0' => array('id_jurnal' => '3','transaksi'=>'Kas Bendahara','kodeakun'=>'111110','debet'=>'47850000'),
											'1'=>array('id_jurnal' => '4','transaksi'=>'Pendapatan Pasien Umum','kodeakun' =>'511110','kredit'=>'47850000')
											)
							),
						'1' => array('id_jurnal'=>'5','edit'=>'1','tanggal'=>'15-Maret-2016','transaksi'=>'Penerimaan Jasa Giro - 110316-2','status'=>'Draf','child'=>array(
											'0'=>array('id_jurnal' => '6','transaksi'=>'Rekening Bank JKN','kodeakun'=>'11220','debet'=>'1055693'),
											'1'=>array('id_jurnal' => '7','transaksi'=>'Jasa Giro','kodeakun'=>'54300','kredit'=>'1055693')
										)
							)
				);
		// $data = $this->jurnal_model->get_data_jurnal_umum($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		

		echo json_encode($data);
	}

	function json_jurnal_penyesuaian(){
		$this->authentication->verify('keuangan','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('keuangan_keu_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('keuangan_keu_kategori_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->jurnal_model->get_data_transaksi();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('keuangan_keu_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('keuangan_keu_kategori_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->jurnal_model->get_data_transaksi($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_keuangan_transaksi'			=> $act->id_keuangan_transaksi,
				'untuk_jurnal'				=> ucwords(str_replace("_"," ","$act->untuk_jurnal")),
				'nama'					    => $act->nama,
				'kategori'					=> $act->kategori,
				'id_keuangan_kategori_transaksi'	=> $act->id_keuangan_kategori_transaksi,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function json_jurnal_penutup(){
		$this->authentication->verify('keuangan','show');

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('keuangan_keu_otomasi_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('keuangan_keu_otomasi_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->jurnal_model->get_data_transaksi_otomatis();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl_diklat') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}
				elseif($field == 'nama') {
					$this->db->like('keuangan_keu_otomasi_transaksi.'.$field,$value);
				}
				elseif($field == 'kategori') {
					$this->db->like('keuangan_keu_kategori_transaksi.nama',$value);
				}else{
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->jurnal_model->get_data_transaksi_otomatis($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_keuangan_otomasi_transaksi'	=> $act->id_keuangan_otomasi_transaksi,
				'untuk_jurnal'				=> ucwords(str_replace("_"," ","$act->untuk_jurnal")),
				'nama'					    => $act->nama,
				'kategori'					=> $act->kategori,
				'id_keuangan_kategori_transaksi'	=> $act->id_keuangan_kategori_transaksi,
				'edit'						=> 1,
				'delete'					=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

function detail_jurnal_umum($id=0){
	$this->authentication->verify('keuangan','show');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','keterangan'=>'Biaya rutin untuk pengamanan kantor', 'tgl_transaksi' => '1 Desember 2016','kategori_transaksi' =>'Biaya','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000','lampiran' =>'Download File','syarat' =>'n/EOM','jth_tempo'=>'1 Januari 2016','no_faktur'=>'13121414','instansi'=>'CV. Medika','kode_kegiatan'=>'2093001','sub_kegaitan'=>'01');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "detail";
		$data['title']			= "Detail Transaksi";
		$data['datadraft']		= array('cetak' => 'Cetak','kuitansi'=>'Kuitansi');

		die($this->parser->parse('keuangan/jurnal/detail_form_jurum', $data));
	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}

function transaksi_otomatis_jurum($id=0){
	$this->authentication->verify('keuangan','show');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "detail";
		$data['title']			= "Konfirmasi Transaksi Otomatis";
		
		die($this->parser->parse('keuangan/jurnal/form_otomatis_jurum', $data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}	
function pilih_tipe_transaksijurum($id=0){
	$this->authentication->verify('keuangan','show');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "detail";
		$data['title']			= "Pilih Tipe Transaksi";
		
		// die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		die($this->parser->parse('keuangan/jurnal/form_riwayat_perubahan_jurum',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function pilihversi($id='0'){
	if ($id==1) {
		$data[] 					= array('tanggal_perubahan'=>'17 Agustus 2016');
		echo json_encode($data);
	}else{
		$data[] 					= array('tanggal_perubahan'=>'17 Agustus 2016','alasan_perubahan'=>'kebutuhan','dirubaholeh'=>'aku','nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','keterangan'=>'Biaya rutin untuk pengamanan kantor', 'tgl_transaksi' => '1 Desember 2016','kategori_transaksi' =>'Biaya','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000','lampiran' =>'Download File','syarat' =>'n/EOM','jth_tempo'=>'1 Januari 2016','no_faktur'=>'13121414','instansi'=>'CV. Medika','kode_kegiatan'=>'2093001','sub_kegaitan'=>'01');
		echo json_encode($data);
	}
}
function edit_junal_umum($id='0'){
	$this->authentication->verify('keuangan','edit');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "edit";
		$data['title']			= "Jurnal Umum";
		$data['sub_title']		= "Transaksi Baru";
		
		// die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		die($this->parser->parse('keuangan/jurnal/form_jurnal_umum',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}

function penyusutan_inventaris($id='0'){
	$this->authentication->verify('keuangan','edit');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "edit";
		$data['title']			= "Jurnal Umum";
		$data['sub_title']		= "Transaksi Baru";
		
		// die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		die($this->parser->parse('keuangan/jurnal/form_penyusutan_inventaris',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function add_penyusutan_inventaris($id=0){
	$this->authentication->verify('keuangan','add');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "edit";
		$data['title']			= "Tambah Penyusustan Inventaris";
		
		// die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		die($this->parser->parse('keuangan/jurnal/add_penyusutan',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function json_penyusutan(){
		$this->authentication->verify('keuangan','show');


		// if($_POST) {
		// 	$fil = $this->input->post('filterscount');
		// 	$ord = $this->input->post('sortdatafield');

		// 	for($i=0;$i<$fil;$i++) {
		// 		$field = $this->input->post('filterdatafield'.$i);
		// 		$value = $this->input->post('filtervalue'.$i);

		// 		if($field == 'tgl_pengadaan') {
		// 			$value = date("Y-m-d",strtotime($value));
		// 			$this->db->where($field,$value);
		// 		}
		// 		elseif($field == 'kode') {
		// 			$this->db->like('inv_inventaris_barang.id_mst_inv_barang',$value);
		// 		}
		// 		elseif($field != 'year') {
		// 			$this->db->like($field,$value);
		// 		}
		// 	}

		// 	if(!empty($ord)) {
		// 		$this->db->order_by($ord, $this->input->post('sortorder'));
		// 	}
		// }
		
		// $rows_all = $this->jurnal_model->get_data();


		// if($_POST) {
		// 	$fil = $this->input->post('filterscount');
		// 	$ord = $this->input->post('sortdatafield');

		// 	for($i=0;$i<$fil;$i++) {
		// 		$field = $this->input->post('filterdatafield'.$i);
		// 		$value = $this->input->post('filtervalue'.$i);

		// 		if($field == 'tgl_pengadaan') {
		// 			$value = date("Y-m-d",strtotime($value));
		// 			$this->db->where($field,$value);
		// 		}
		// 		elseif($field == 'kode') {
		// 			$this->db->like('inv_inventaris_barang.id_mst_inv_barang',$value);
		// 		}
		// 		elseif($field != 'year') {
		// 			$this->db->like($field,$value);
		// 		}
		// 	}

		// 	if(!empty($ord)) {
		// 		$this->db->order_by($ord, $this->input->post('sortorder'));
		// 	}
		// }
		
		// $rows = $this->jurnal_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		// $data = array();
		// foreach($rows as $act) {
		// 	$data[] = array(
		// 		'kode' 				=> substr(chunk_split($act->id_mst_inv_barang, 2, '.'), 0,14),
		// 		'kode_barang' 		=> $act->id_mst_inv_barang,
		// 		'register' 			=> $act->register,
		// 		'nama_barang' 		=> $act->nama_barang,
		// 		'harga' 			=> $act->harga,
		// 		'kondisi'			=> $act->pilihan_keadaan_barang." - ".$act->val,		
		// 		'id_barang'			=> $act->id_inventaris_barang,				
		// 		'nama' 				=> preg_replace('/[^A-Za-z0-9\-]/', '_', $act->nama_barang)
		// 	);
		// }

		$data[] = array('id_inventaris'=>'1','nm_iventaris' => 'Mobil','id_inventaris'=>'2','nm_iventaris' => 'Komputer','id_inventaris'=>'3','nm_iventaris' => 'Meja');
		
		$size = sizeof($data);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
}

