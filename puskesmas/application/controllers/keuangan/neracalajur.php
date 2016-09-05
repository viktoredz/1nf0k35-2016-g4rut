<?php
class Neracalajur extends CI_Controller {

 public function __construct(){
		parent::__construct();
		$this->load->model('keuangan/jurnal_model');
	}

	function index(){
		$this->authentication->verify('keuangan','edit');
		$data['title_group']   = "Keuangan";
		$data['title_form']    = "Neraca Lajur";

		$data['content']       = $this->parser->parse("keuangan/neracalajur/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	
}

