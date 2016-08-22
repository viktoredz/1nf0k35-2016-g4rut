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
		$this->load->model('kepegawaian/kepegawaian_model');
	}
	


	function index(){
		$this->authentication->verify('inventory','show');
		$data = array();
		$data['title_group'] 	= "Dashboard Inventory";
		$data['title_form'] 	= "Inventory";

		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$bln = (int) date('m');
		$thn = date('Y');
		$data['j_pegawai'] = $this->kepegawaian_model->get_datapegawai();
		$data['j_pegawaipns'] = $this->kepegawaian_model->get_datapegawaipns();
		$data['j_pegawainonpns'] = $this->kepegawaian_model->get_datapegawainonpns();

		$this->db->like('code','p'.substr($this->session->userdata('puskesmas'),0,7));
		$data['j_puskesmas'] = count($this->inv_ruangan_model->get_data_puskesmas());

		$bar = array();
		$color = array('#f56954','#00a65a','#f39c12','#00c0ef','#8d16c5','#d2d6de','#3c8dbc','#69d856','#eb75e4');

		
		$kodepuskesmas = $this->session->userdata('puskesmas');
		$this->db->like('code','P'.$kodepuskesmas);
		$datapuskesmas = $this->inv_ruangan_model->get_data_puskesmas();
		foreach ($datapuskesmas as $row) {
			$bar[$row->code]['puskesmas'] = $row->value;
		}

		
		$data['jmlpendidikanlulus'] =$this->kepegawaian_model->get_jum_pendidikanpegawai();

		$data['jenisklamin'] = $this->kepegawaian_model->get_jum_jenisklmin_pegawai();
		
		$data['bar']	= $bar;
		$data['color']	= $color;
		$data['content']= $this->parser->parse("kepegawaian/dashboard",$data,true);
		// print_r($data);
		// die();
		$this->template->show($data,'home');
	}


}
