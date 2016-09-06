<?php
class Penyusutan extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');

		$this->load->model('keuangan/penyusutan_model');
	}

	
	function index(){
		$this->authentication->verify('keuangan','show');
		$this->db->where('code','P'.$this->session->userdata('puskesmas'));
		$data['data_puskesmas']	= $this->penyusutan_model->get_data_puskesmas();

		$data['title_group']    = "Keuangan";
		$data['title_form']     = "Daftar Inventaris";	
		$this->session->set_userdata('filter_nomo_kontrak','');
	    $this->session->set_userdata('filter_pengadaanbulan','');
	    $this->session->set_userdata('filter_pengadaantahun','');


		$data['content'] = $this->parser->parse("keuangan/penyusutan/show",$data,true);						
		
		$this->template->show($data,"home");
	}

	

	function json($id=0){
		$this->authentication->verify('keuangan','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl' ) {
					$value = date("Y-m-d",strtotime($value));

					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
	
		if($this->session->userdata('filter_puskesmas')!=''){
			if($this->session->userdata('filter_puskesmas')=="all"){

			}else{
				$this->db->where("id_cl_phc",$this->session->userdata('filter_puskesmas'));
			}
		}else{
				$this->db->where("id_cl_phc",'P'.$this->session->userdata('puskesmas'));
		}
	
		$rows_all = $this->penyusutan_model->get_data();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl' ) {
					$value = date("Y-m-d",strtotime($value));

					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		
		if($this->session->userdata('filter_puskesmas')!=''){
			if($this->session->userdata('filter_puskesmas')=="all"){

			}else{
				$this->db->where("id_cl_phc",$this->session->userdata('filter_puskesmas'));
			}
		}else{
				$this->db->where("id_cl_phc",'P'.$this->session->userdata('puskesmas'));
		}
		
		$rows = $this->penyusutan_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

			foreach($rows as $act) {
	 		$data[] = array(
				'nama_barang'   		=> $act->nama_barang,
				'id_mst_inv_barang'	   	=> $act->id_mst_inv_barang,
				'id_inventaris_barang'	=> $act->id_inventaris_barang,
				'register'    			=> $act->register,
				'id_cl_phc'   			=> $act->id_cl_phc,
				'harga'   				=> $act->harga,
				'edit'	   => 1,
				'delete'   => 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function delete_sts($id=0){
		$this->authentication->verify('keuangan','del');

		if($this->penyusutan_model->delete_sts($id)){
			$this->session->set_flashdata('alert', 'Delete data ('.$id.')');
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
		}
	}

	

	function detail_penyusutan($id=''){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('id_sts', 'ID STS', 'trim|required');
		$this->form_validation->set_rules('nomor','Nomor','trim|required|callback_sts_nomor');
		$this->form_validation->set_rules('tgl','Tanggal','trim|required|callback_sts_tgl');

		$data['id_sts']	   			    = $id;
		$data['alert_form']		   	    = "";
	    $data['action']					= "detail";	

	    $data 							= array('id_inventaris' => '1','nama_inventaris' => 'Mobil Tesla - Model S','nilai_awal' => '800000000','nilai_akhir' => '500000000','metode_penyusutan' => 'Jumlah Angka Tahun','akun_inventaris'=>'21122 - Alat Angkutan Darat Bermotor','biaya_penyusutan' =>'62710 - Biaya Penyusutan','nilai_ekonomis' =>'5 Tahun','nilai_sisa' =>'0','mulai_pakai'=>'12 Desember 2015');
	    $data['title_form']				= "Detail Inventaris Penyusutan";	
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_detail_penyusutan",$data));
		}elseif($this->cek_tgl_sts($this->input->post('tgl'))){
				$id=$this->penyusutan_model->add_sts();
				die("OK | $id");
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/penyusutan/detail_penyusutan");
		}
		die($this->parser->parse("keuangan/penyusutan/form_detail_penyusutan",$data));
	}	

	function json_detail($id=0){
		$this->authentication->verify('keuangan','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl' ) {
					$value = date("Y-m-d",strtotime($value));

					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
	
		if($this->session->userdata('filter_puskesmas')!=''){
			if($this->session->userdata('filter_puskesmas')=="all"){

			}else{
				$this->db->where("id_cl_phc",$this->session->userdata('filter_puskesmas'));
			}
		}else{
				$this->db->where("id_cl_phc",'P'.$this->session->userdata('puskesmas'));
		}
		if($this->session->userdata('filter_pengadaantahun')!=''){
			$this->db->where("YEAR(tgl_pengadaan)",$this->session->userdata('filter_pengadaantahun'));
		}
		if($this->session->userdata('filter_pengadaanbulan')!=''){
			$this->db->where("MONTH(tgl_pengadaan)",$this->session->userdata('filter_pengadaanbulan'));
		}
		if($this->session->userdata('filter_nomo_kontrak')!=''){
			$this->db->like("nomor_kontrak",$this->session->userdata('filter_nomo_kontrak'));
		}
	


		$rows_all = $this->penyusutan_model->get_data_inventaris();

		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tgl' ) {
					$value = date("Y-m-d",strtotime($value));

					$this->db->where($field,$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		
		if($this->session->userdata('filter_puskesmas')!=''){
			if($this->session->userdata('filter_puskesmas')=="all"){

			}else{
				$this->db->where("id_cl_phc",$this->session->userdata('filter_puskesmas'));
			}
		}else{
				$this->db->where("id_cl_phc",'P'.$this->session->userdata('puskesmas'));
		}
		if($this->session->userdata('filter_pengadaantahun')!=''){
			$this->db->where("YEAR(tgl_pengadaan)",$this->session->userdata('filter_pengadaantahun'));
		}
		if($this->session->userdata('filter_pengadaanbulan')!=''){
			$this->db->where("MONTH(tgl_pengadaan)",$this->session->userdata('filter_pengadaanbulan'));
		}
		if($this->session->userdata('filter_nomo_kontrak')!=''){
			$this->db->like("nomor_kontrak",$this->session->userdata('filter_nomo_kontrak'));
		}
		$rows = $this->penyusutan_model->get_data_inventaris($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

			foreach($rows as $act) {
	 		$data[] = array(
				'nama_barang'   		=> $act->nama_barang,
				'id_mst_inv_barang'	   	=> $act->id_mst_inv_barang,
				'id_inventaris_barang'	=> $act->id_inventaris_barang,
				'register'    			=> $act->register,
				'id_cl_phc'   			=> $act->id_cl_phc,
				'harga'   				=> $act->harga,
				'status'   				=> $act->status,
				'nomor_kontrak'   		=> $act->nomor_kontrak,
				'edit'	   => 1,
				'delete'   => 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function edit_penyusutan($id=''){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('id_sts', 'ID STS', 'trim|required');
		$this->form_validation->set_rules('nomor','Nomor','trim|required|callback_sts_nomor');
		$this->form_validation->set_rules('tgl','Tanggal','trim|required|callback_sts_tgl');

		$data['id_sts']	   			    = $id;
		$data['alert_form']		   	    = "";
	    $data['action']					= "edit";		
	    $data 							= array('id_inventaris' => '121211213','nilai_ekonomis'=>10,'nama_inventaris'=>'Mobil Tesla - Model S');
	    $data['akun_inventaris']		= array('212121' => '212121 - Alat Angkutan Darat','313131'=>'313131 - Alat Angkutan Udara');
	    $data['akun_bebaninventaris']	= array('612123' => 'Biaya Penyusutan','6123213' => 'Biaya Tambahan');
	    $data['metode_penyusutan']		= array('1' => 'Metode Garis Lurus','2' => 'Tanpa Penyusutan','3' => 'Saldo Menurun','4' => 'Metode Unit Produksi','5' => 'Tanpa Penyusutan');
	    $data['title_form']				= "Ubah Inventaris Penyusutan";	
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_edit_penyusutan",$data));
		}elseif($this->cek_tgl_sts($this->input->post('tgl'))){
				$id=$this->penyusutan_model->add_sts();
				die("OK | $id");
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/penyusutan/edit_penyusutan");
		}
		die($this->parser->parse("keuangan/penyusutan/form_edit_penyusutan",$data));
	}	
	function json_edit($id=0){
		$this->authentication->verify('keuangan','show');


		// if($_POST) {
		// 	$fil = $this->input->post('filterscount');
		// 	$ord = $this->input->post('sortdatafield');

		// 	for($i=0;$i<$fil;$i++) {
		// 		$field = $this->input->post('filterdatafield'.$i);
		// 		$value = $this->input->post('filtervalue'.$i);

		// 		if($field == 'tgl' ) {
		// 			$value = date("Y-m-d",strtotime($value));

		// 			$this->db->where($field,$value);
		// 		}elseif($field != 'year') {
		// 			$this->db->like($field,$value);
		// 		}
		// 	}

		// 	if(!empty($ord)) {
		// 		$this->db->order_by($ord, $this->input->post('sortorder'));
		// 	}
		// }
	
		// if($this->session->userdata('filter_bulan')!=''){
		// 	if($this->session->userdata('filter_bulan')=="all"){

		// 	}else{
		// 		$this->db->where("MONTH(tgl)",$this->session->userdata('filter_bulan'));
		// 	}
		// }else{
		// 		$this->db->where("MONTH(tgl)",date("m"));
		// }
		// if($this->session->userdata('filter_tahun')!=''){
		// 	if($this->session->userdata('filter_tahun')=="all"){

		// 	}else{
		// 		$this->db->where("YEAR(tgl)",$this->session->userdata('filter_tahun'));
		// 	}
		// }else{
		// 	$this->db->where("YEAR(tgl)",date("Y"));
		// }
	
		// $rows_all = $this->penyusutan_model->get_data();

		// if($_POST) {
		// 	$fil = $this->input->post('filterscount');
		// 	$ord = $this->input->post('sortdatafield');

		// 	for($i=0;$i<$fil;$i++) {
		// 		$field = $this->input->post('filterdatafield'.$i);
		// 		$value = $this->input->post('filtervalue'.$i);

		// 		if($field == 'tgl' ) {
		// 			$value = date("Y-m-d",strtotime($value));

		// 			$this->db->where($field,$value);
		// 		}elseif($field != 'year') {
		// 			$this->db->like($field,$value);
		// 		}
		// 	}

		// 	if(!empty($ord)) {
		// 		$this->db->order_by($ord, $this->input->post('sortorder'));
		// 	}
		// }
		
		// if($this->session->userdata('filter_bulan')!=''){
		// 	if($this->session->userdata('filter_bulan')=="all"){

		// 	}else{
		// 		$this->db->where("MONTH(tgl)",$this->session->userdata('filter_bulan'));
		// 	}
		// }else{
		// 	$this->db->where("MONTH(tgl)",date("m"));
		// }
		// if($this->session->userdata('filter_tahun')!=''){
		// 	if($this->session->userdata('filter_tahun')=="all"){

		// 	}else{
		// 		$this->db->where("YEAR(tgl)",$this->session->userdata('filter_tahun'));
		// 	}
		// }else{
		// 	$this->db->where("YEAR(tgl)",date("Y"));
		// }
		
		// $rows = $this->penyusutan_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		// $data = array();

		// 	foreach($rows as $act) {
	 // 		$data[] = array(
		// 		'id_sts'   => $act->id_sts,
		// 		'tgl'	   => date("d-m-Y",strtotime($act->tgl)),
		// 		'ttd_penerima_nama'	=> $act->ttd_penerima_nama,
		// 		'nomor'	   => $act->nomor,
		// 		'total'    => $act->total,
		// 		'status'   => ucwords($act->status),
		// 		'edit'	   => 1,
		// 		'delete'   => 1
		// 	);
		// }

		$data = array(
			'0' => array('id_inventaris' => '1','nama_inventaris' => 'Mobil Tesla - Model S','akun_inventaris' => '2121212 - Alat','akun_beban' => '62710 - Biaya Penyusutan','metode' => 'Jumlah Angka Tahun','nilai_ekonomis'=> 5,'nilai_sisa'   => '200000000'),
			'1' => array('id_inventaris' => '2','nama_inventaris' => 'Komputer Mac Pro','akun_inventaris' => '211216 - Komputer','akun_beban' => '62710 - Biaya Penyusutan','metode' => 'Saldo Menurun','nilai_ekonomis'=> 5,'nilai_sisa'   => ''),
			'2' => array('id_inventaris' => '3','nama_inventaris' => 'Bangunan Gedung A','akun_inventaris' => '2121212 - Alat','akun_beban' => '62710 - Biaya Penyusutan','metode' => 'Faris Lurus','nilai_ekonomis'=> 5,'nilai_sisa'   => '0'),
			'3' => array('id_inventaris' => '4','nama_inventaris' => 'Tanah - Tanah Jalan X','akun_inventaris' => '2121212 - Alat','akun_beban' => '62710 - Biaya Penyusutan','metode' => 'Tanpa Penyusutan','nilai_ekonomis'=> '','nilai_sisa'   => ''),
			'4' => array('id_inventaris' => '5','nama_inventaris' => 'Alat Kesehatan _ MRI','akun_inventaris' => '2121212 - Alat','akun_beban' => '62710 - Biaya Penyusutan','metode' => 'Manual','nilai_ekonomis'=> 5,'nilai_sisa'   => '0'),
			);
		$size = sizeof($data);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function edit($id=0){
		$this->authentication->verify('keuangan','show');
		$data['title_group']    = "Keuangan";
		$data['title_form']     = "Daftar Inventaris";	
		$data['content'] = $this->parser->parse("keuangan/penyusutan/edit",$data,true);						
		
		$this->template->show($data,"home");
	}
	function arrayakuninventaris($value='')
	{
		$data = array(
			'0' => array('value'=>'212121','label' => '212121 - Alat'), 
			'1' => array('value'=>'21126','label' =>'21126 - komputer')
		);
		echo json_encode($data);
	}
	function arrayakunbeban($value='')
	{
		$data = array(
			'0' => array('value'=>'62710','label' => '62710 - Biaya Penyusutan'), 
			'1' => array('value'=>'62720','label' => '62720 - Biaya Tambahan')
		);
		echo json_encode($data);
	}
	function arraymetodepenyusutan($value='')
	{
		$data = array(
			'0' => array('value'=>'1','label' => 'Jumlah Angka Tahun'), 
			'1' => array('value'=>'2','label' => 'Saldo Menurun'),
			'2' => array('value'=>'3','label' => 'Garis Lurus'),
			'3' => array('value'=>'4','label' => 'Tanpa Penyusutan'),
			'4' => array('value'=>'5','label' => 'Manual'),
			'5' => array('value'=>'5','label' => 'Metode Unit Produksi'),
		);
		echo json_encode($data);
	}
	function add_inventaris(){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('dataceklis', 'Data Inventaris Barang', 'trim|required');

		$data['id_sts']	   			    = "";
		$data['alert_form']		   	    = "";
	    $data['action']					= "add";
	    $data['form_title']				= "Add Inventaris - Step 1";
	    $data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
	    $this->session->set_userdata('filter_nomo_kontrak','');
	    $this->session->set_userdata('filter_pengadaanbulan','');
	    $this->session->set_userdata('filter_pengadaantahun','');

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_tambah_penyusutantahapsatu",$data));
		}elseif($id = $this->penyusutan_model->addstepsatu()){
				$this->addstepdua($id);
		}else{
			$this->addstepdua($id);
		}
		
	}
	function addstepdua($id=0){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('jumlahdata', 'Data Inventaris Barang', 'trim|required');
	    

		$data['datainventaris']	   		= $this->penyusutan_model->getalldatainv($id);
		$data['alert_form']		   	    = "";
	    $data['action']					= "add";
	    $data['form_title']				= "Add Inventaris - Step 2";
	    $data['nilaiakun_inventaris']	= $this->penyusutan_model->getallnilaiakun();
	    $data['nilaiakun_bebanpenyusustan']	= $this->penyusutan_model->getallnilaiakun();
	    $data['nilaimetode_penyusustan']= $this->penyusutan_model->getallmetodepenyusustan();
	    
	    
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_tambah_penyusutantahapdua",$data));
		}elseif($id = $this->penyusutan_model->addstepdua()){
				if ($this->input->post('transaksitambah')=='1') {
					$this->addsteptiga($id);
				}else{
					die("OK | $id");
				}
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/penyusutan/addstepdua");
		}
		die($this->parser->parse("keuangan/penyusutan/form_tambah_penyusutantahapdua",$data));
	}
	function addsteptiga($id=0){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('id_sts', 'ID STS', 'trim|required');

		$data['id_sts']	   			    = "";
		$data['alert_form']		   	    = "";
	    $data['action']					= "add";
	    $data['form_title']				= "Add Inventaris - Step 3";
	    $data['dataedit']				= array(
	    										'0' => array('id_inventaris' => '21212121','judul' =>'Mobil Tesla - Model S','akun_inventaris'=>'211266','nilai_ekonomis'=>'2','akun_bebanpenyusustan'=>'62710','metode_penyusustan'=>'0'),
	    										'1' => array('id_inventaris' => '32323232','judul' =>'Komputer - Mac Pro','akun_inventaris'=>'21122','nilai_ekonomis'=>'10','akun_bebanpenyusustan'=>'62711','metode_penyusustan'=>'1'),
	    									);
	    $data['nilaiakun_inventaris']	= array('0' =>array('key' => '21122', 'value'=>'21122 - Alat Angkutan'),
	    										'1' =>array('key' => '211266', 'value'=>'211266 - Alat Komputer'));
	    $data['nilaiakun_bebanpenyusustan']	= array('0' =>array('key' => '62710','value'=>'62710 - Biaya Penyusustan'),
	    										 	'1' =>array('key' => '62711','value'=>'62711 - Biaya Tambahan'));
	    $data['nilaimetode_penyusustan']	= array('0' =>array('key' => '1','value'=>'Saldo Menurun'),
	    										 	'1' =>array('key' => '2','value'=>'Metode Garis Lurus'),
	    										 	'2' =>array('key' => '3','value'=>'Tanpa Penyusutan'));
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_tambah_penyusutantahaptiga",$data));
		}elseif($this->cek_tgl_sts($this->input->post('tgl'))){
				$id=$this->penyusutan_model->add_sts();
				die("OK | $id");
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/penyusutan/addsteptiga");
		}
		die($this->parser->parse("keuangan/penyusutan/form_tambah_penyusutantahaptiga",$data));
	}


	function filterpengadaanbulan(){
		if($_POST) {
			if($this->input->post('bulan') != '') {
				$this->session->set_userdata('filter_pengadaanbulan',$this->input->post('bulan'));
			}
		}
	}
	function filterpengadaantahun(){
		if($_POST) {
			if($this->input->post('tahun') != '') {
				$this->session->set_userdata('filter_pengadaantahun',$this->input->post('tahun'));
			}
		}
	}
	function filternomo_kontrak(){
		if($_POST) {
			$this->session->set_userdata('filter_nomo_kontrak',$this->input->post('nomor'));
		}
	}
}
