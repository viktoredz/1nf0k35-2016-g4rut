<?php
class Dashboard extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('morganisasi_model');
		$this->load->model('admin_model');
        $this->load->model('inventory/inv_ruangan_model');
		$this->load->helper('html');
		$this->load->helper('captcha');
		$this->load->library('image_CRUD');
	}
	


	function index(){
		$this->authentication->verify('inventory','show');
		$data = array();
		$data['title_group'] 	= "Dashboard Inventory";
		$data['title_form'] 	= "Inventory";

		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$bln = (int) date('m');
		$thn = date('Y');
		$data['j_asset'] = $this->admin_model->get_inv_barang();
		$data['j_ruangan'] = $this->admin_model->get_inv_barang1();

		$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));
		$data['j_puskesmas'] = count($this->inv_ruangan_model->get_data_puskesmas());

		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		//$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));
		$kodepuskesmas = $this->session->userdata('puskesmas');
		//	if(substr($kodepuskesmas, -2)=="01"){
		//		$this->db->like('code','P'.substr($kodepuskesmas, 0,7));
		//	}else {
		$this->db->like('code','P'.$kodepuskesmas);
		//	}
		$datapuskesmas = $this->inv_ruangan_model->get_data_puskesmas();
		foreach ($datapuskesmas as $row) {
			$bar[$row->code]['puskesmas'] = $row->value;
		}

		
		$j_barang_baik = $this->admin_model->get_jum_aset();
		foreach ($j_barang_baik as $row) {
			$bar[$row->id_cl_phc]['j_barang_baik'] = $row->jml;
		}

		$j_barang_baik1 = $this->admin_model->get_nilai_aset();
		foreach ($j_barang_baik1 as $row) {
			$bar[$row->id_cl_phc]['j_barang_baik1'] = $row->nilai;
		}


		$j_barang_rr = $this->admin_model->get_jum_aset1();
		foreach ($j_barang_rr as $row) {
			$bar[$row->id_cl_phc]['j_barang_rr'] = $row->jml;
		}

		$j_barang_rr1 = $this->admin_model->get_nilai_aset1();
		foreach ($j_barang_rr1 as $row) {
			$bar[$row->id_cl_phc]['j_barang_rr1'] = $row->nilai;
		}


		$j_barang_rb = $this->admin_model->get_jum_aset2();
		foreach ($j_barang_rb as $row) {
			$bar[$row->id_cl_phc]['j_barang_rb'] = $row->jml;
		}

		$j_barang_rb1 = $this->admin_model->get_nilai_aset2();
		foreach ($j_barang_rb1 as $row) {
			$bar[$row->id_cl_phc]['j_barang_rb1'] = $row->nilai;
		}

		
		$nilai_aset = $this->admin_model->get_jum_nilai_aset();
		foreach ($nilai_aset as $row) {
			$bar[$row->id_cl_phc]['nilai_aset'] = $row->jml;
		}

		$nilai_aset1 = $this->admin_model->get_jum_nilai_aset2();
		foreach ($nilai_aset1 as $row) {
			$bar[$row->id_cl_phc]['nilai_aset1'] = $row->nilai;
		}
		$data['bar']	= $bar;
		$data['color']	= $color;
		$data['content']= $this->parser->parse("inventory/dashboard",$data,true);
		
		$this->template->show($data,'home');
	}


}
