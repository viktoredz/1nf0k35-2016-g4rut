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
		$this->session->set_userdata('filter_kategori','');
		$this->session->set_userdata('filter_bulan','');
		$this->session->set_userdata('filter_tahun','');
		$this->session->set_userdata('filter_transaksi','');

		$data['content']       = $this->parser->parse("keuangan/jurnal/show",$data,true);		
		
		$this->template->show($data,"home");
	}

	function tab($pageIndex){
		$this->session->set_userdata('filter_kategori','');
		$this->session->set_userdata('filter_bulan','');
		$this->session->set_userdata('filter_tahun','');
		$this->session->set_userdata('filter_transaksi','');
		$this->session->set_userdata('filter_puskesmas','');
		$data = array();

		switch ($pageIndex) {
			case 1:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Umum";
				$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
				$data['filekategori'] = $this->jurnal_model->getallkategori();
				$data['filetransaksi'] =$this->jurnal_model->pilihan_enums('keu_transaksi','status');
				$data['tambahtransaksi'] =array('pendapatanumum'=>"Pendapatan Umum","pendapatanbpjs" => 'Pendapatan BPJS Kapasitas',"pembelian" => 'Pembelian Persediaan');
				$data['tambahtransaksiotomatis'] =array('transaksiotomatis'=>"Transaksi Otomatis");
				$this->db->where('code','P'.$this->session->userdata('puskesmas'));
				$data['datapuskes'] 	= $this->jurnal_model->getallpuskesmas();

				die($this->parser->parse("keuangan/jurnal/jurnal_umum",$data));

				break;
			case 2:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Penyesuaian";
				
				// die($this->parser->parse("keuangan/jurnal/jurnal_penyesuaian",$data));
				 die($this->parser->parse("keuangan/jurnal/form_penyusutan_inventaris",$data));

				break;
			case 3:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Penutup";
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Umum";
				$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
				$data['filekategori'] =$this->jurnal_model->getallkategori();//array('all'=>"Semua Kategori","penerimaankas" => 'Penerimaan Kas',"Pembelian" => 'pembelian',"Biaya" => 'biaya',"penjualan" => 'Penjualan',"pembukuan"=>'Pembukuan');
				$data['filetransaksi'] =$this->jurnal_model->pilihan_enums('keu_transaksi','status');//array('all'=>"Semua Transaksi","transaksidisimpan" => 'Transaksi Disimpan',"transaksidraf" => 'Transaksi Draf');
				$data['tambahtransaksi'] =array('pendapatanumum'=>"Pendapatan Umum","pendapatanbpjs" => 'Pendapatan BPJS Kapasitas',"pembelian" => 'Pembelian Persediaan');
				$data['tambahtransaksiotomatis'] =array('transaksiotomatis'=>"Transaksi Otomatis");
				
				$this->db->where('code','P'.$this->session->userdata('puskesmas'));
				$data['datapuskespe'] 	= $this->jurnal_model->getallpuskesmas();
				die($this->parser->parse("keuangan/jurnal/jurnal_penutup",$data));

				break;
			default:
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Jurnal Penutup";
				$data['title_group']   = "Keuangan";
				$data['title_form']    = "Transaksi di hapus";
				$data['bulan'] =array(1=>"Januari","Februari","Maret","April","Mei","Juni","July","Agustus","September","Oktober","November","Desember");
				$data['filekategori'] =$this->jurnal_model->getallkategori();
				$data['filetransaksi'] =$this->jurnal_model->pilihan_enums('keu_transaksi','status');
				$data['tambahtransaksi'] =array('pendapatanumum'=>"Pendapatan Umum","pendapatanbpjs" => 'Pendapatan BPJS Kapasitas',"pembelian" => 'Pembelian Persediaan');
				$data['tambahtransaksiotomatis'] =array('transaksiotomatis'=>"Transaksi Otomatis");
				$this->db->where('code','P'.$this->session->userdata('puskesmas'));
				$data['datapuskeshapus'] 	= $this->jurnal_model->getallpuskesmas();
				die($this->parser->parse("keuangan/jurnal/transaksi_hapus",$data));

				break;
		}
	}
	function autocomplite_instansi($obat=0){
		$search = explode("&",$this->input->server('QUERY_STRING'));
		$search = str_replace("term=","",$search[0]);
		$search = str_replace("+"," ",$search);

		$this->db->where("nama like '%".$search."%'");
		$this->db->limit(10,0);
		$query= $this->db->get("mst_inv_pbf")->result();
		foreach ($query as $q) {
			$inst[] = array(
				'key' 		=> $q->code, 
				'value' 	=> $q->nama.' - '.$q->kategori,
				'alamat' 	=> $q->alamat,
			);
		}
		echo json_encode($inst);
	}
	function json_jurnal_umum($type='jurnal_umum'){
		$this->authentication->verify('keuangan','show');
		if ($this->session->userdata('filter_kategori')!='') {
			if ($this->session->userdata('filter_kategori')=='all') {
			}else{
				$this->db->where('id_kategori_transaksi',$this->session->userdata('filter_kategori'));
			}
		}
		if ($this->session->userdata('filter_tahun')!='') {
			$this->db->where('YEAR(tanggal)',$this->session->userdata('filter_tahun'));
		}else{
			$this->db->where('YEAR(tanggal)',date("Y"));
		}
		if ($this->session->userdata('filter_bulan')!='') {
			$this->db->where('MONTH(tanggal)',$this->session->userdata('filter_bulan'));
		}else{
			$this->db->where('MONTH(tanggal)',date("m"));
		}
		if ($this->session->userdata('filter_transaksi')!='') {
			if ($this->session->userdata('filter_transaksi')=='all') {
			}else{
				$this->db->where('status',$this->session->userdata('filter_transaksi'));
			}
		}
		if ($this->session->userdata('filter_puskesmas')!='') {
			$this->db->where('keu_transaksi.code_cl_phc',$this->session->userdata('filter_puskesmas'));
		}else{
			$this->db->where('keu_transaksi.code_cl_phc','P'.$this->session->userdata('puskesmas'));
		}
		$data = $this->jurnal_model->get_datajurnalumum($type);

		echo json_encode($data);
	}
	function json_jurnal_hapus($type='jurnal_umum'){
		$this->authentication->verify('keuangan','show');
		
		if ($this->session->userdata('filter_tahun')!='') {
			$this->db->where('YEAR(tanggal)',$this->session->userdata('filter_tahun'));
		}else{
			$this->db->where('YEAR(tanggal)',date("Y"));
		}
		if ($this->session->userdata('filter_bulan')!='') {
			$this->db->where('MONTH(tanggal)',$this->session->userdata('filter_bulan'));
		}else{
			$this->db->where('MONTH(tanggal)',date("m"));
		}
		$data = $this->jurnal_model->get_datajurnalumum($type,'dihapus');
		
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

	
	function detail_jurnal_umum($id=0){
	$this->authentication->verify('keuangan','show');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= $this->jurnal_model->get_detail_row($id);///array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','keterangan'=>'Biaya rutin untuk pengamanan kantor', 'tgl_transaksi' => '1 Desember 2016','kategori_transaksi' =>'Biaya','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000','lampiran' =>'Download File','syarat' =>'n/EOM','jth_tempo'=>'1 Januari 2016','no_faktur'=>'13121414','instansi'=>'CV. Medika','kode_kegiatan'=>'2093001','sub_kegaitan'=>'01');
		$data['datajurnal']		= $this->jurnal_model->get_detail_jurnal($id);
		$data['datajurnaldebit']		= $this->jurnal_model->get_detail_jurnaldebit($id);
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "detail";
		$data['title']			= "Detail Transaksi";
		$data['datadraft']		= array('cetak' => 'Cetak','kuitansi'=>'Kuitansi');

		die($this->parser->parse('keuangan/jurnal/detail_form_jurum', $data));
	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}

function transaksi_otomatis_jurum($id=0){
	$this->authentication->verify('keuangan','show');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "detail";
		$data['title']			= "Konfirmasi Transaksi Otomatis";
		
		die($this->parser->parse('keuangan/jurnal/form_otomatis_jurum', $data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}	
function pilih_tipe_transaksijurum($id=0){
	$this->authentication->verify('keuangan','show');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "detail";
		$data['title']			= "Pilih Tipe Transaksi";
		
		die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		// die($this->parser->parse('keuangan/jurnal/form_riwayat_perubahan_jurum',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function pilihversi($id='0'){
	if ($id==1) {
		$data[] 					= array('tanggal_perubahan'=>'17 Agustus 2016');
		echo json_encode($data);
	}else{
		$data[] 					= array('tanggal_perubahan'=>'17 Agustus 2016','alasan_perubahan'=>'kebutuhan','dirubaholeh'=>'aku','nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','keterangan'=>'Biaya rutin untuk pengamanan kantor', 'tgl_transaksi' => '1 Desember 2016','kategori_transaksi' =>'Biaya','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000','lampiran' =>'Download File','syarat' =>'n/EOM','jth_tempo'=>'1 Januari 2016','no_faktur'=>'13121414','instansi'=>'CV. Medika','kode_kegiatan'=>'2093001','sub_kegaitan'=>'01');
		echo json_encode($data);
	}
}
function add_junal_umum($id='0'){
	$this->authentication->verify('keuangan','edit');
	$id = $this->jurnal_model->addjurnal($id);
    $this->edit_junal_umum($id);
}
function idtrasaksi(){
		$kodpus = 'P'.$this->session->userdata('puskesmas');
        $q = $this->db->query("select MAX(RIGHT(id_transaksi,4)) as kd_max from keu_transaksi");
        $nourut="";
        if($q->num_rows()>0)
        {
            foreach($q->result() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $nourut = sprintf("%04s", $tmp);
            }
        }
        else
        {
            $nourut = "0001";
        }
        return $kodpus.date("Y").date('m').$nourut;
    }
function edit_junal_umum($id='0',$tipesimpan='disimpan'){
	$this->authentication->verify('keuangan','edit');

    $this->form_validation->set_rules('uraian', 'Uraian', 'trim');
    $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim');
    $this->form_validation->set_rules('jenistransaksi', 'jenistransaksi', 'trim');
    $this->form_validation->set_rules('bukti_kas', 'Bukti Kas', 'trim');
    $this->form_validation->set_rules('nomor_faktur', 'Nomor Faktur', 'trim');
    $this->form_validation->set_rules('id_mst_syarat_pembayaran', 'Syarat Pembayaran', 'trim');
    $this->form_validation->set_rules('id_instansi', 'Instansi', 'trim');
    $this->form_validation->set_rules('id_kategori_transaksi', 'Kategori Transaksi', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= $this->jurnal_model->get_detail_row($id);
		$data['alert_form']		= validation_errors();
		$data['id']				= $id;
		$data['action']			= "edit";
		$data['title']			= "Jurnal Umum";
		$data['tipesimpan']		= $tipesimpan;
		$data['sub_title']		= "Ubah Transaksi";
		$this->db->where('id_mst_kategori_transaksi','1');
		$data['filetransaksi'] 	= $this->jurnal_model->pilihan_jenis();
		$data['filterkategori_transaksi'] =$this->jurnal_model->filterkategori_transaksi();
		$data['getdebit']		= $this->jurnal_model->getdebit($id);
		$data['getkredit']		= $this->jurnal_model->getkredit($id);
		$data['getsyarat']		= $this->jurnal_model->getsyarat();
		$data['getdataakun']	= $this->jurnal_model->getdataakun();
		// if (!empty($data['alert_form'])) {
		// 	$datas['err_msg'] = validation_errors();
		// 	die('Err|'.json_encode($datas));
		// };
		die($this->parser->parse('keuangan/jurnal/form_jurnal_umum',$data));

	}else{

		$config['upload_path']          = './public/files/datafile/';
        // $config['max_size']             = 100;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;
        $config['allowed_types'] 		= 'avi|png|jpeg|pdf|jpg|xlx|xlxs|doc|docx';
        $config['file_name']      		= 'file-'.trim(str_replace(" ","",date('dmYHis')));

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // if ( ! $this->upload->do_upload('lampiran'))
        // {
        //         $error = array('err_msg' => $this->upload->display_errors());
        //         die('Error|'.json_encode($error));
        // }
        // else
        // {
        	$this->upload->do_upload('lampiran');
        	$this->upload->data();
        	$this->db->where('id_transaksi',$this->input->post('id_transaksi'));
        	$t=explode("-", $this->input->post('tanggal'));
        	$tgl = $t[2].'-'.$t[1].'-'.$t[0];
        	$ttempo=explode("-", $this->input->post('jatuh_tempo'));
        	$tgltempo = $ttempo[2].'-'.$ttempo[1].'-'.$ttempo[0];
        	if ($tipesimpan=='draft') {
        		$statussimpan = 'draft';
        	}else{
        		$statussimpan = 'disimpan';
        	}
			$values = array(
				'tanggal'			=> $tgl,
				'uraian'			=> $this->input->post('uraian'),
				'keterangan' 		=> $this->input->post('keterangan'),
				'bukti_kas' 		=> $this->input->post('bukti_kas'),
				'status' 			=> $statussimpan,
				'lampiran' 			=> $config['file_name'],
				'jatuh_tempo' 		=> $tgltempo,
				'nomor_faktur' 		=> $this->input->post('nomor_faktur'),
				'id_mst_syarat_pembayaran' 	=> $this->input->post('id_mst_syarat_pembayaran'),
				'id_instansi' 			=> $this->input->post('id_instansi'),
			);
			$simpan=$this->db->update('keu_transaksi', $values);
			if($simpan==true){
				$data['err_msg'] ='Data Tersimpan';
				die("OK|".json_encode($data));
			}else{
				$data['err_msg'] ="Proses data gagal";
				 die("Error|".json_encode($data));
			}
		// }
		
	}
}


function penyusutan_inventaris($id='0'){
	$this->authentication->verify('keuangan','edit');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data 					= array('nomor_transaksi' =>'0112153','uraian'=>'Dibayar belaja Pengamanan Kantor','transaksi_urut'=>'Transaksi 1','id_akun_debit'=>'3010 - Belanja Rutin','jml_debit'=>'41300000','id_akun_kredit'=>'1010 - Hutang Dagang','jml_kredit'=>'41300000');
		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "edit";
		$data['title']			= "Jurnal Umum";
		$data['sub_title']		= "Transaksi Baru";
		
		// die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		die($this->parser->parse('keuangan/jurnal/form_penyusutan_inventaris',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function add_instansi(){
	$this->authentication->verify('keuangan','add');

    $this->form_validation->set_rules('nama', 'Nama Instansi', 'trim|required');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
    $this->form_validation->set_rules('alamat', 'Alamat', 'trim');
    $this->form_validation->set_rules('telepon', 'Telepon', 'trim');

	if($this->form_validation->run()== FALSE){

		$data['notice']			= validation_errors();
		$data['action']			= "add";
		$data['title_form']		= "Tambah Instansi";
		$data['datakateg']		= $this->jurnal_model->pilihan_enums('mst_inv_pbf','kategori');
		die($this->parser->parse('keuangan/jurnal/form_instansi',$data));

	}else{
		
		$values = array(
			'nama'						=> $this->input->post('nama'),
			// 'deskripsi'					=> $this->input->post('deskripsi'),
			'alamat' 					=> $this->input->post('alamat'),
			'tlp' 						=> $this->input->post('telepon'),
			'kategori' 					=> $this->input->post('deskripsi'),
			'aktif' 					=> '1',
		);
		$simpan=$this->db->insert('mst_inv_pbf', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function json_penyusutan(){
		$this->authentication->verify('keuangan','show');


		$data[] = array('id_inventaris'=>'1','nm_iventaris' => 'Mobil','id_inventaris'=>'2','nm_iventaris' => 'Komputer','id_inventaris'=>'3','nm_iventaris' => 'Meja');
		
		$size = sizeof($data);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
	}
function tutupbuku($id=0){
	$this->authentication->verify('keuangan','add');

    $this->form_validation->set_rules('jumlahdistribusi', 'Jumlah Distribusi', 'trim|required');
    $this->form_validation->set_rules('uraian', 'Nama Barang', 'trim');
    $this->form_validation->set_rules('jumlah', 'Jumlah', 'trim');

	if($this->form_validation->run()== FALSE){

		$data['notice']			= validation_errors();
		$data['id']				= $id;
		$data['action']			= "edit";
		$data['title']			= "Tutup Buku";
		
		// die($this->parser->parse('keuangan/jurnal/form_tipe_transaksi_jurum',$data));
		die($this->parser->parse('keuangan/jurnal/form_tutupbuku',$data));

	}else{
		
		$values = array(
			'id_inv_inventaris_habispakai_distribusi'=>$id_distribusi,
			'id_mst_inv_barang_habispakai'=> $kode,
			'batch' => $batch,
			'jml' => $this->input->post('jumlahdistribusi'),
		);
		$simpan=$this->db->insert('inv_inventaris_habispakai_distribusi_item', $values);
		if($simpan==true){
			die("OK|Data Tersimpan");
		}else{
			 die("Error|Proses data gagal");
		}
		
	}
}
function filterkategori(){
	if($_POST) {
		if($this->input->post('kategori') != '') {
			$this->session->set_userdata('filter_kategori',$this->input->post('kategori'));
		}
	}
}
function filtertahun(){
	if($_POST) {
		if($this->input->post('tahundata') != '') {
			$this->session->set_userdata('filter_tahun',$this->input->post('tahundata'));
		}
	}
}
function filterbulan(){
	if($_POST) {
		if($this->input->post('bulandata') != '') {
			$this->session->set_userdata('filter_bulan',$this->input->post('bulandata'));
		}
	}
}
function filterpuskesmas(){
	if($_POST) {
		if($this->input->post('puskes') != '') {
			$this->session->set_userdata('filter_puskesmas',$this->input->post('puskes'));
		}
	}
}
function filtertransaksi(){
	if($_POST) {
		if($this->input->post('transaksi') != '') {
			$this->session->set_userdata('filter_transaksi',$this->input->post('transaksi'));
		}
	}
}
function hapusdetailjurum($id='0'){
	$this->authentication->verify('keuangan','edit');
	$this->db->set('status','dihapus');
	$this->db->where('id_transaksi',$id);
	if ($this->db->update('keu_transaksi')) {
		return 1;
	}else{
		return mysql_error();
	}
}
function add_kredit_debit($tipe='kredit'){
	$this->authentication->verify('keuangan','add');
	echo $this->jurnal_model->add_kredit_debit($tipe);
	die();
}
function delete_kreditdebet($tipe='kredit'){
	// $this->authentication->verify('keuangan','delete');
	echo $this->jurnal_model->delete_kreditdebet($tipe);
	die();
}
function selectnamaakun($id_jurnal='0',$tipe='kredit'){
	$this->authentication->verify('keuangan','add');
	echo $this->jurnal_model->selectnamaakun($id_jurnal,$tipe);
	die();
}
function inputvalueakun($id_jurnal='0',$tipe='kredit'){
	// $this->authentication->verify('keuangan','add');
	$this->jurnal_model->inputvalueakun($id_jurnal,$tipe);
	die();
}
function json_transaksi(){
	$this->authentication->verify('keuangan','show');


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'namakategori') {
					$this->db->like('mst_keu_kategori_transaksi.nama',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$rows_all = $this->jurnal_model->get_data_tipetransaksi();


		if($_POST) {
			$fil = $this->input->post('filterscount');
			$ord = $this->input->post('sortdatafield');

			for($i=0;$i<$fil;$i++) {
				$field = $this->input->post('filterdatafield'.$i);
				$value = $this->input->post('filtervalue'.$i);

				if($field == 'tanggal_permohonan') {
					$value = date("Y-m-d",strtotime($value));
					$this->db->where($field,$value);
				}elseif($field == 'namakategori') {
					$this->db->like('mst_keu_kategori_transaksi.nama',$value);
				}elseif($field != 'year') {
					$this->db->like($field,$value);
				}
			}

			if(!empty($ord)) {
				$this->db->order_by($ord, $this->input->post('sortorder'));
			}
		}
		$rows = $this->jurnal_model->get_data_tipetransaksi($this->input->post('recordstartindex'), $this->input->post('pagesize'));
		$data = array();
		$no=1;
		foreach($rows as $act) {
			$data[] = array(
				'id_mst_transaksi' 			=> $act->id_mst_transaksi,
				'nama' 						=> $act->nama,
				'namakategori' 				=> $act->namakategori,
				'untuk_jurnal'				=> $act->untuk_jurnal,
				'deskripsi'					=> $act->deskripsi,
				'detail'					=> 1,
			);
		}


		
		$size = sizeof($rows_all);
		$json = array(
			'TotalRows' => (int) $size,
			'Rows' => $data
		);

		echo json_encode(array($json));
}
function cekstatus($id=0){
	$this->db->where('id_transaksi',$id);
	$query = $this->db->get('keu_transaksi');
	if ($query->num_rows() > 0) {
		$data = $query->row_array();
		return $data['status'];
	}else{
		return 'disimpan';
	}
}
function delete_junal_umum($id=0){
	$tipedel = $this->cekstatus($id);
	if ($tipedel=='draft') {
		$this->dodelselamanya($id);
	}else{
		$this->db->set('status','dihapus');
		$this->db->where('id_transaksi',$id);
		$this->db->update('keu_transaksi');
		$this->tab('1');
	}	
}
function dodelselamanya($id=0){
	$this->db->where('id_transaksi',$id);
	$this->db->delete('xkeu_jurnal');
	
	$this->db->where('id_transaksi',$id);
	$this->db->delete('xkeu_transaksi');
}
function gettotaldebetkredit($id='0'){
	$this->db->select('sum(kredit) as totalkredit,sum(debet) as totaldebit');
	$this->db->where('id_transaksi',$id);
	$query = $this->db->get('keu_jurnal')->result_array();
	echo json_encode($query);
}
}

