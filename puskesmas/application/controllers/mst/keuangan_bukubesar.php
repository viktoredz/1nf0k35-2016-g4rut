<?php
class Keuangan_bukubesar extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('mst/keuangan_bukubesar_model');
	}
	
	function json(){
		$this->authentication->verify('mst','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				$this->db->like($field,$value);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows_all = $this->keuangan_bukubesar_model->get_data();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				$this->db->like($field,$value);
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}

		$rows = $this->keuangan_bukubesar_model->get_data($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_bukubesar'	=> $act->id_mst_bukubesar,
				'judul'				=> $act->judul,
				'deskripsi'			=> $act->deskripsi,
				'pisahkan_berdasar'	=> $act->pisahkan_berdasar,
				'aktif'				=> $act->aktif,
				'view'				=> 1,
				'edit'				=> 1,
				'delete'			=> 1
			);
		}

		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}

	function index(){
		$this->authentication->verify('mst','edit');
		$data['title_group'] = "Master";
		$data['title_form'] = "Master Data - keuangan_bukubesar";

		$data['content'] = $this->parser->parse("mst/keuangan_bukubesar/show",$data,true);

		$this->template->show($data,"home");
	}


	function add(){

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('pisahkan_berdasar', 'Pisahkan Berdasarkan', 'trim|required');
        $this->form_validation->set_rules('aktif', 'aktif', 'trim');

		if($this->form_validation->run()== FALSE){
			$data['title_group'] 	= "Master";
			$data['title_form']		="Tambah Buku Besar";
			$data['action']			="add";
			$data['kode']			="";
			$data['datanilaiakun']	=$this->keuangan_bukubesar_model->getallnilaiakun();
			$data['datapisah']		=$this->keuangan_bukubesar_model->pilihan_enums('mst_keu_bukubesar','pisahkan_berdasar');
		
			die($this->parser->parse("mst/keuangan_bukubesar/form",$data,true));
		}elseif($id= $this->keuangan_bukubesar_model->insert_entry()){
			$this->edit($id);
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
		}
			die($this->parser->parse("mst/keuangan_bukubesar/form",$data,true));
	}

	function edit($kode=0)
	{
		$this->authentication->verify('mst','add');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('pisahkan_berdasar', 'Pisahkan Berdasarkan', 'trim|required');
        $this->form_validation->set_rules('aktif', 'aktif', 'trim');

        $data = $this->keuangan_bukubesar_model->get_data_row($kode); 

		$data['title_group'] = "Master";
		$data['title_form']="Ubah Buku Besar";
		$data['action']="edit";
		$data['kode']=$kode;
		$data['dataallakun']= $this->keuangan_bukubesar_model->get_dataakunall($kode); 

	
		$data['datanilaiakun']	=$this->keuangan_bukubesar_model->getallnilaiakun();
		$data['datapisah']		=$this->keuangan_bukubesar_model->pilihan_enums('mst_keu_bukubesar','pisahkan_berdasar');
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keuangan_bukubesar/form",$data,true));
		}elseif($this->keuangan_bukubesar_model->update_entry($kode)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
		}
		die($this->parser->parse("mst/keuangan_bukubesar/form",$data,true));
	}
	function view($kode=0)
	{
		$this->authentication->verify('mst','add');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
        $this->form_validation->set_rules('pisahkan_berdasar', 'Pisahkan Berdasarkan', 'trim|required');
        $this->form_validation->set_rules('aktif', 'aktif', 'trim');

        $data = $this->keuangan_bukubesar_model->get_data_row($kode); 

		$data['title_group'] = "Master";
		$data['title_form']="Ubah Buku Besar";
		$data['action']="view";
		$data['kode']=$kode;
		$data['dataallakun']= $this->keuangan_bukubesar_model->get_dataakunall($kode); 

	
		$data['datanilaiakun']	=$this->keuangan_bukubesar_model->getallnilaiakun();
		$data['datapisah']		=$this->keuangan_bukubesar_model->pilihan_enums('mst_keu_bukubesar','pisahkan_berdasar');
		if($this->form_validation->run()== FALSE){
			die($this->parser->parse("mst/keuangan_bukubesar/form",$data,true));
		}elseif($this->keuangan_bukubesar_model->update_entry($kode)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
		}
		die($this->parser->parse("mst/keuangan_bukubesar/form",$data,true));
	}

	function dodel($kode=0){
		$this->authentication->verify('mst','del');

		if($this->keuangan_bukubesar_model->delete_entry($kode)){
			$this->session->set_flashdata('alert', 'Delete data ('.$kode.')');
			redirect(base_url()."mst/keuangan_bukubesar");
		}else{
			$this->session->set_flashdata('alert', 'Delete data error');
			redirect(base_url()."mst/keuangan_bukubesar");
		}
	}
	function add_akundata($id=0){
		$this->authentication->verify('mst','add');

		echo $this->keuangan_bukubesar_model->insertdatakaun();
	}
	function delete_dataakun(){
		$this->authentication->verify('mst','add');
		echo $this->keuangan_bukubesar_model->deletedatakaun();	
	}
	function updatedata(){
		$this->authentication->verify('mst','edit');
		echo $this->keuangan_bukubesar_model->updateaktip();	
	}
}
