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
		$this->session->set_userdata('filter_databulan','');
		$this->session->set_userdata('filter_datatahun','');

		$data['databukubesar'] 	= $this->bukubesar_model->getalldatakaun();
		$data['dataallakun'] 	= $this->bukubesar_model->getallnilaiakun();
		
		$data['content'] = $this->parser->parse("keuangan/bukubesar/show",$data,true);
		$this->template->show($data,"home");
	}
	function pilihgrid($judul=0){
		$this->session->set_userdata('filter_databulan','');
		$this->session->set_userdata('filter_datatahun','');
		$judul = $this->input->post("judul");
		$bulan = $this->input->post("bulan");
		$tahun = $this->input->post("tahun");
		$id_judul = $this->input->post("id_judul");
		$pilihdata = explode("__", $id_judul);
		if ($pilihdata[0]=='tambahan') {
			$this->griddatatambahan($bulan,$tahun,$id_judul);
		}else if ($pilihdata[0]=='akun') {
			$this->griddataumum($bulan,$tahun,$id_judul);
		}else{
			return $judul;
		}
	}
	function griddatatambahan($bulan=0,$tahun=0,$id_judul=0){
		$this->authentication->verify('keuangan','edit');
		$data['bulan']		= $bulan;
		$data['tahun']		= $tahun;
		$data['id_judul']	= $id_judul;
		$this->db->where('code','P'.$this->session->userdata('puskesmas'));
		$data['datapuskesmas']	= $this->db->get('cl_phc')->result();
		$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
		$tampil				= explode("__", $id_judul);
		$pilihtampil		= $this->bukubesar_model->getpisah($tampil[1]);
		if ($pilihtampil['pisahkan_berdasar']=='akun') {
			$data['datagridakun']	= $this->bukubesar_model->getdatawhere($id_judul);
			die($this->parser->parse("keuangan/bukubesar/show_datatambahakun",$data));
		}else{
			$data['datagridtambah']	= $this->bukubesar_model->datagridinstansi('instansi');
			die($this->parser->parse("keuangan/bukubesar/show_datatambah",$data));
		}
	}
	function griddataumum($bulan=0,$tahun=0,$id_judul=0){
		$this->authentication->verify('keuangan','edit');
		$data['bulan']		= $bulan;
		$data['tahun']		= $tahun;
		$data['id_judul']	= $id_judul;
		$this->db->where('code','P'.$this->session->userdata('puskesmas'));
		$data['datapuskesmas']	= $this->db->get('cl_phc')->result();
		$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
		die($this->parser->parse("keuangan/bukubesar/show_dataumum",$data));
	}
	function json_umum($id=0){
		$this->authentication->verify('inventory','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'keterangan') {
					$this->db->like('keu_transaksi.uraian',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('filter_puskesmas')!='') {
			$this->db->where('keu_transaksi.code_cl_phc',$this->session->userdata('filter_puskesmas'));
		}else{
			$this->db->where('keu_transaksi.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}


		$rows_all = $this->bukubesar_model->get_data($id);


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'keterangan') {
					$this->db->like('keu_transaksi.uraian',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('filter_puskesmas')!='') {
			$this->db->where('keu_transaksi.code_cl_phc',$this->session->userdata('filter_puskesmas'));
		}else{
			$this->db->where('keu_transaksi.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		if ($this->session->userdata('filter_datatahun')!='') {
			$this->db->where('YEAR(keu_transaksi.tanggal)',$this->session->userdata('filter_datatahun'));
		}else{
			$this->db->where('YEAR(keu_transaksi.tanggal)',date("Y"));
		}
		if ($this->session->userdata('filter_databulan')!='') {
			$this->db->where('MONTH(keu_transaksi.tanggal)',$this->session->userdata('filter_databulan'));
		}else{
			$this->db->where('MONTH(keu_transaksi.tanggal)',date("n"));
		}
		$rows = $this->bukubesar_model->get_data($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=$this->input->post('recordstartindex')+1;
		$tempsaldo=0;
		foreach($rows as $act) {
			$totalsaldo = $tempsaldo;
			$data[] = array(
				'no'					=> $no++,
				'code_cl_phc' 			=> $act->code_cl_phc,
				'id_jurnal' 			=> $act->id_jurnal,
				'id_keu_transaksi_inventaris'	=> $act->id_keu_transaksi_inventaris,
				'id_transaksi'			=> $act->id_transaksi,
				'uraian'				=> $act->uraian,
				'tanggal'				=> $act->tanggal,
				'kode'					=> $act->kode,
				'keterangan'			=> $act->uraian,
				'status'				=> $act->status,
				'debet'					=> $act->debet,
				'kredit'				=> $act->kredit,
				'saldo'					=> ($act->status=="kredit" ? $totalsaldo - $act->kredit : $totalsaldo + $act->debet),
				'edit'					=> '1',
			);
			$tempsaldo = ($act->status=="kredit" ? $totalsaldo - $act->kredit : $totalsaldo + $act->debet);
		}
		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
	function get_bulanfilter(){
		if($_POST) {
			if($this->input->post('bulan') != '') {
				$this->session->set_userdata('filter_databulan',$this->input->post('bulan'));
			}
		}
	}
	function get_tahunfilter(){
		if($_POST) {
			if($this->input->post('tahun') != '') {
				$this->session->set_userdata('filter_datatahun',$this->input->post('tahun'));
			}
		}
	}
	function json_tambah($id_judul=0,$id=''){
		$this->authentication->verify('inventory','show');

		$datawhere = $this->bukubesar_model->getdatawhere($id_judul);
		$x=0;
		foreach ($datawhere as $keywhere) {
			if ($x==0) {
				$keydatawhere = "keu_jurnal.id_mst_akun="."'".$keywhere['id_mst_akun']."'"."";
			}else{
				$keydatawhere = $keydatawhere.' '."or keu_jurnal.id_mst_akun="."'".$keywhere['id_mst_akun']."'"."";
			}
			$x++;
		}
		if (count($datawhere) > 0) {
			$this->db->where("($keydatawhere)");
		}
		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'keterangan') {
					$this->db->like('keu_transaksi.uraian',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('filter_puskesmas')!='') {
			$this->db->where('keu_transaksi.code_cl_phc',$this->session->userdata('filter_puskesmas'));
		}else{
			$this->db->where('keu_transaksi.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		if ($this->session->userdata('filter_datatahun')!='') {
			$this->db->where('YEAR(keu_transaksi.tanggal)',$this->session->userdata('filter_datatahun'));
		}else{
			$this->db->where('YEAR(keu_transaksi.tanggal)',date("Y"));
		}
		if ($this->session->userdata('filter_databulan')!='') {
			$this->db->where('MONTH(keu_transaksi.tanggal)',$this->session->userdata('filter_databulan'));
		}else{
			$this->db->where('MONTH(keu_transaksi.tanggal)',date("n"));
		}
		
		$rows_all = $this->bukubesar_model->get_datatambah($id);

		$datawhere = $this->bukubesar_model->getdatawhere($id_judul);
		$x=0;
		foreach ($datawhere as $keywhere) {
			if ($x==0) {
				$keydatawhere = "keu_jurnal.id_mst_akun="."'".$keywhere['id_mst_akun']."'"."";
			}else{
				$keydatawhere = $keydatawhere.' '."or keu_jurnal.id_mst_akun="."'".$keywhere['id_mst_akun']."'"."";
			}
			$x++;
		}
		if (count($datawhere) > 0) {
			$this->db->where("($keydatawhere)");
		}
		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'keterangan') {
					$this->db->like('keu_transaksi.uraian',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		if ($this->session->userdata('filter_puskesmas')!='') {
			$this->db->where('keu_transaksi.code_cl_phc',$this->session->userdata('filter_puskesmas'));
		}else{
			$this->db->where('keu_transaksi.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		if ($this->session->userdata('filter_datatahun')!='') {
			$this->db->where('YEAR(keu_transaksi.tanggal)',$this->session->userdata('filter_datatahun'));
		}else{
			$this->db->where('YEAR(keu_transaksi.tanggal)',date("Y"));
		}
		if ($this->session->userdata('filter_databulan')!='') {
			$this->db->where('MONTH(keu_transaksi.tanggal)',$this->session->userdata('filter_databulan'));
		}else{
			$this->db->where('MONTH(keu_transaksi.tanggal)',date("n"));
		}
		$rows = $this->bukubesar_model->get_datatambah($id,$this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=$this->input->post('recordstartindex')+1;
		$tempsaldo=77000;
		foreach($rows as $act) {
		$totalsaldo = $tempsaldo;
			$data[] = array(
				'no'					=> $no++,
				'code_cl_phc' 			=> $act->code_cl_phc,
				'id_jurnal' 			=> $act->id_jurnal,
				'id_keu_transaksi_inventaris'	=> $act->id_keu_transaksi_inventaris,
				'id_transaksi'			=> $act->id_transaksi,
				'uraian'				=> $act->uraian,
				'tanggal'				=> $act->tanggal,
				'kode'					=> $act->kode,
				'keterangan'			=> $act->uraian,
				'status'				=> $act->status,
				'debet'					=> $act->debet,
				'kredit'				=> $act->kredit,
				'saldo'					=> ($act->status=="kredit" ? $totalsaldo - $act->kredit : $totalsaldo + $act->debet),
				'edit'					=> '1',
			);
			$tempsaldo = ($act->status=="kredit" ? $totalsaldo - $act->kredit : $totalsaldo + $act->debet);
		}
		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
}
