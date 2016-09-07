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
				'namametode'   			=> $act->namametode,
				'id_inventaris'   		=> $act->id_inventaris,
				'edit'	   => 1,
				'delete'   => 1,
				'view'   => 1
				
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function delete_data($id=0){
		$this->authentication->verify('keuangan','del');

		if($this->penyusutan_model->delete_data($id)){
			return true;
		}else{
			return false;
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
	function edit_penyusutan($id=0){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('id_inventaris', 'ID Inventaris', 'trim|required');
		$this->form_validation->set_rules('id_mst_akun','Akun','trim|required');
		$this->form_validation->set_rules('id_mst_akun_akumulasi','Akun Akumulasi','trim|required');
		$this->form_validation->set_rules('id_mst_metode_penyusutan','Metode Penyusutan','trim|required');

			
	    $data 							= $this->penyusutan_model->get_edit_row($id);
		$data['alert_form']		   	    = "";
	    $data['action']					= "edit";	
	    $data['akun_inventaris']		= $this->penyusutan_model->getallnilaiakun();
	    $data['akun_bebaninventaris']	= $this->penyusutan_model->getallnilaiakun();
	    $data['metode_penyusutan']		= $this->penyusutan_model->getallmetodepenyusustan();
	    $data['title_form']				= "Ubah Inventaris Penyusutan";	
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_edit_penyusutan",$data));
		}elseif($this->penyusutan_model->editpenyusutan()){
				die("OK");
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/penyusutan/edit_penyusutan");
		}
		die($this->parser->parse("keuangan/penyusutan/form_edit_penyusutan",$data));
	}	
	function json_edit($id=0){
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
	
		$rows_all = $this->penyusutan_model->get_dataedit();

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
		
		$rows = $this->penyusutan_model->get_dataedit($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();

			foreach($rows as $act) {
	 		$data[] = array(
				'nama_barang'   		=> $act->nama_barang,
				'id_mst_inv_barang'	   	=> $act->id_mst_inv_barang,
				'id_inventaris_barang'	=> $act->id_inventaris_barang,
				'register'    			=> $act->register,
				'id_cl_phc'   			=> $act->id_cl_phc,
				'harga'   				=> $act->harga,
				'namaakun'   			=> $act->namaakun,
				'kodeakun'   			=> $act->kodeakun,
				'id_inventaris'   		=> $act->id_inventaris,
				'namaakumulasi'   		=> $act->namaakumulasi,
				'kodeakumulasi'   		=> $act->kodeakumulasi,
				'namapenyusutan'   		=> $act->namapenyusutan,
				'id_mst_metode_penyusutan' => $act->id_mst_metode_penyusutan,
				'kodenamaakun'   		=> $act->kodeakun.' - '.$act->namaakun,
				'kodenamaakumulasi'   	=> $act->kodeakumulasi.' - '.$act->namaakumulasi,
				'nilai_ekonomis'   		=> $act->nilai_ekonomis,
				'nilai_sisa'   			=> $act->nilai_sisa,
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
	function edit($id=0){
		$this->authentication->verify('keuangan','show');
		$data['title_group']    = "Keuangan";
		$data['title_form']     = "Daftar Inventaris";	
		$data['content'] = $this->parser->parse("keuangan/penyusutan/edit",$data,true);						
		
		$this->template->show($data,"home");
	}
	function arrayakuninventaris($value='')
	{
		$data = $this->penyusutan_model->getallnilaiakun();
		echo json_encode($data);
	}
	function arraymetodepenyusutan($value='')
	{
		$this->db->where('aktif','1');
		$this->db->select('id_mst_metode_penyusutan,nama');
		$data = $this->db->get('mst_keu_metode_penyusutan')->result_array();
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

	    $this->form_validation->set_rules('id_transaksi', 'ID Transaksi', 'trim|required');

	    $data 							= $this->penyusutan_model->gettransaksi($id);
	    $data['getalldata']		   	    = $this->penyusutan_model->getdatajurnal($id);
	    $data['getakun']				= $this->penyusutan_model->getallnilaiakun();
		$data['alert_form']		   	    = "";
	    $data['action']					= "add";
	    $data['form_title']				= "Add Inventaris - Step 3";
	    
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_tambah_penyusutantahaptiga",$data));
		}elseif($this->penyusutan_model->simpandatatransaksi()){
				die("OK");
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
	function updatestatusakuninventaris(){
		$this->authentication->verify('keuangan','edit');
		$this->penyusutan_model->updatedata();
	}
	function updatestatusakunakumulasi(){
		$this->authentication->verify('keuangan','edit');
		$this->penyusutan_model->updatedataakumulasi();
	}
	function updatestatuspenyusutan(){
		$this->authentication->verify('keuangan','edit');
		$this->penyusutan_model->updatedatapenyusutan();
	}
	function updatenilaiekonomis(){
		$this->authentication->verify('keuangan','edit');
		$this->penyusutan_model->updatedatanilaiekonomis();
	}
	function updatenilaisisa(){
		$this->authentication->verify('keuangan','edit');
		$this->penyusutan_model->updatedatanilaisisa();
	}
	
}
