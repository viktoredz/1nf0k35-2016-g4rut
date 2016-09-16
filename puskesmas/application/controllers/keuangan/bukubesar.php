<?php
class Bukubesar extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('keuangan/bukubesar_model');
	}

	function index(){
		$this->authentication->verify('keuangan','edit');
		$data['title_group'] 	= "Keuangan";
		$data['title_form'] 	= "Bukubesar";
		$data['databukubesar'] 	= $this->bukubesar_model->getalldatakaun();
		$data['dataallakun'] 	= $this->bukubesar_model->getallnilaiakun();
		
		$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
		$data['content'] = $this->parser->parse("keuangan/bukubesar/show",$data,true);

		$this->template->show($data,"home");
	}
	function pilihgrid($judul=0){
		$judul = $this->input->post("judul");
		$bulan = $this->input->post("bulan");
		$tahun = $this->input->post("tahun");
		$id_judul = $this->input->post("id_judul");
		$pilihdata = explode("_#", $id_judul);
		if ($pilihdata[0]=='tambahan') {
			if($pilihdata[1]=="1"){
				$this->griddatatambahan($bulan,$tahun,$id_judul);
			}else if($pilihdata[1]=="2"){
				$this->datausia($kecamatan,$kelurahan,$rw);
			}else{
				return $judul;
			}
		}else if ($pilihdata[0]=='akun') {
			if($pilihdata[1]=="1"){
				$this->d($bulan,$tahun,$id_judul);
			}else if($pilihdata[1]=="2"){
				$this->datausia($kecamatan,$kelurahan,$rw);
			}else{
				return $judul;
			}
		}else{
			return $judul;
		}
	}
	function griddatatambahan($bulan=0,$tahun=0,$id_judul=0){
		echo 'hai';
	}

	
}
