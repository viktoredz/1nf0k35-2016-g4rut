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
		if($this->session->userdata('level')=="sms"){
			redirect(base_url()."sms/sms");
		}
		$this->authentication->verify('morganisasi','show');
		$data = array();
		$data['title_group'] 	= "Dashboard";
		$data['title_form'] 	= "Home";

		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$bln = (int) date('m');
		$thn = date('Y');
		$data['j_asset'] = $this->admin_model->get_inv_barang();

		$data['j_ruangan'] = $this->admin_model->get_inv_barang1();

		$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));
		$data['j_puskesmas'] = count($this->inv_ruangan_model->get_data_puskesmas());

		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4','#000066');

		$kodepuskesmas = $this->session->userdata('puskesmas');

		$data['kecamatan'] = $this->admin_model->get_data_kecamatan();

		foreach ($data['kecamatan'] as $row) {
			$bar[$row['code']]['puskesmas'] = $row['nama'];
			$bar[$row['code']]['j_barang_baik'] = $this->admin_model->get_jum_aset($row['code']);
			$bar[$row['code']]['j_barang_baik1'] = $this->admin_model->get_nilai_aset($row['code']);
			$bar[$row['code']]['j_barang_rr'] = $this->admin_model->get_jum_aset1($row['code']);
			$bar[$row['code']]['j_barang_rr1'] = $this->admin_model->get_nilai_aset1($row['code']);
			$bar[$row['code']]['j_barang_rb'] = $this->admin_model->get_jum_aset2($row['code']);
			$bar[$row['code']]['j_barang_rb1'] = $this->admin_model->get_nilai_aset2($row['code']);
			$bar[$row['code']]['nilai_aset'] = $this->admin_model->get_jum_nilai_aset($row['code']);
			$bar[$row['code']]['nilai_aset1'] = $this->admin_model->get_jum_nilai_aset2($row['code']);
		}
		
		$data['bar']	= $bar;
		$data['color']	= $color;
		$data['content']= $this->parser->parse("inventory/dashboard",$data,true);
		
		$this->template->show($data,'home');
	}
}

