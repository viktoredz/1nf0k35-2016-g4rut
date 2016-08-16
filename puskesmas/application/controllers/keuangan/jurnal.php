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
				die($this->parser->parse("keuangan/jurnal/jurnal_umum",$data));

				break;
			case 2:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Penyesuaian";
				$data['kategori']	   = $this->jurnal_model->get_data_kategori_transaksi();
				$this->session->set_userdata('filter_kategori','');
				
				die($this->parser->parse("keuangan/jurnal/jurnal_penyesuaian",$data));

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

	function filter_kategori(){
		if($_POST) {
			if($this->input->post('kategori') != '') {
				$this->session->set_userdata('filter_kategori',$this->input->post('kategori'));
			}
		}
	}

	


}

