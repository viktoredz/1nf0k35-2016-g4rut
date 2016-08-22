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
		$data['data_puskesmas']	= $this->penyusutan_model->get_data_puskesmas();
		$data['title_group']    = "Keuangan";
		$data['title_form']     = "Penyusutan Inventaris";	
		// $data['nama_puskes'] 	= "";
		$this->session->set_userdata('filter_bulan','');
		$this->session->set_userdata('filter_tahun','');
		$data['bulan']			= array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

		$data['content'] = $this->parser->parse("keuangan/penyusutan/show",$data,true);						
		
		$this->template->show($data,"home");
	}

	

	function json($id=0){
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
			'0' => array('id_inventaris' => '1','nama_inventaris' => 'Mobil Tesla - Model S','nilai_awal' => '800000000','nilai_akhir' => '500000000','metode' => 'Jumlah Angka Tahun','edit'	   => 1,'delete'   => 1,'view'   => 1),
			'1' => array('id_inventaris' => '2','nama_inventaris' => 'Komputer Mac Pro','nilai_awal' => '40000000','nilai_akhir' => '30000000','metode' => 'Saldo Menurun','edit'	   => 1,'delete'   => 1,'view'   => 1),
			'2' => array('id_inventaris' => '3','nama_inventaris' => 'Bangunan Gedung A','nilai_awal' => '40000000','nilai_akhir' => '30000000','metode' => 'Metode Garis Lurus','edit'	   => 1,'delete'   => 1,'view'   => 1),
			'3' => array('id_inventaris' => '4','nama_inventaris' => 'Tanah - Tanah Jalan X','nilai_awal' => '40000000','nilai_akhir' => '40000000','metode' => 'Tanpa Penyusutan','edit'	   => 1,'delete'   => 1,'view'   => 1),
			'4' => array('id_inventaris' => '5','nama_inventaris' => 'Alat Kesehatan _ MRI','nilai_awal' => '800000000','nilai_akhir' => '500000000','metode' => 'Metode Unit Produksi','edit'	   => 1,'delete'   => 1,'view'   => 1),
			);
		$size = sizeof($data);
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

	function add_sts(){
		$this->authentication->verify('keuangan','add');

	    $this->form_validation->set_rules('id_sts', 'ID STS', 'trim|required');
		$this->form_validation->set_rules('nomor','Nomor','trim|required|callback_sts_nomor');
		$this->form_validation->set_rules('tgl','Tanggal','trim|required|callback_sts_tgl');

		$data['id_sts']	   			    = "";
		$data['alert_form']		   	    = "";
	    $data['action']					= "add";

		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("keuangan/penyusutan/form_tambah_sts",$data));
		}elseif($this->cek_tgl_sts($this->input->post('tgl'))){
				$id=$this->penyusutan_model->add_sts();
				die("OK | $id");
		}else{
			$this->session->set_flashdata('alert_form', 'Tanggal harus lebih dari tanggal terakhir input dan tidak lebih dari tanggal hari ini.');
			redirect(base_url()."keuangan/penyusutan/add_sts");
		}
		die($this->parser->parse("keuangan/penyusutan/form_tambah_sts",$data));
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
			redirect(base_url()."keuangan/penyusutan/add_sts");
		}
		die($this->parser->parse("keuangan/penyusutan/form_detail_penyusutan",$data));
	}	

	function json_detail($id=0){
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
			'0' => array('id_inventaris' => '1','tanggal' => '2016-01-31','debit' => '75000000','kredit' => '0','nilai_inventaris' => '725000000','view'=> 1),
			'1' => array('id_inventaris' => '2','tanggal' => '2016-02-31','debit' => '75000000','kredit' => '0','nilai_inventaris' => '650000000','view'   => 1),
			'2' => array('id_inventaris' => '3','tanggal' => '2016-03-31','debit' => '75000000','kredit' => '0','nilai_inventaris' => '575000000','view'   => 1),
			'3' => array('id_inventaris' => '4','tanggal' => '2016-05-31','debit' => '75000000','kredit' => '0','nilai_inventaris' => '500000000','view'   => 1),
			);
		$size = sizeof($data);
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
			redirect(base_url()."keuangan/penyusutan/form_edit_penyusutan");
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
}
