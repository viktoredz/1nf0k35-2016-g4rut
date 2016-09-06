<?php
class Penyusutan_model extends CI_Model {

    var $tb    = 'keu_sts';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
    }
    
    function get_data($start=0,$limit=999999,$options=array()){
    	$this->db->join('mst_keu_metode_penyusutan','keu_inventaris.id_inventaris_barang=mst_keu_metode_penyusutan.id_mst_metode_penyusutan','left');
    	$this->db->join('get_all_inventaris2','get_all_inventaris2.id_inventaris_barang=keu_inventaris.id_inventaris_barang','left');
        return $this->db->get('keu_inventaris',$limit,$start)->result();
    }
    function get_data_inventaris($start=0,$limit=999999,$options=array()){
    	$this->db->select("get_all_inventaris2.*,IF((SELECT `id_inventaris` FROM `keu_inventaris` WHERE id_inventaris_barang=get_all_inventaris2.`id_inventaris_barang` limit 1) IS NULL,'','ditambahkan') AS status,inv_pengadaan.nomor_kontrak,inv_pengadaan.tgl_pengadaan", false);
    	$this->db->join('inv_pengadaan','inv_pengadaan.id_pengadaan = get_all_inventaris2.id_pengadaan','left');
        return $this->db->get('get_all_inventaris2',$limit,$start)->result();
    }
    function get_data_puskesmas(){
    	return $this->db->get('cl_phc')->result();
    }
    function addstepsatu(){
    	$datainv    = explode('_tr_', $this->input->post('dataceklis'));
    	$id_invbaru = '';
    	for ($i=0; $i <=count($datainv)-2 ; $i++) { 
    		$data = $id_invbaru;
    		$datasave = array(
    		'id_inventaris'			=> $this->idinventaris(),
    		'id_inventaris_barang'	=> $datainv[$i],
    		'id_mst_akun'			=> '9',
    		'id_mst_akun_akumulasi'		=> '9',
    		'akumulasi_beban'			=> '0',
    		'nilai_ekonomis'			=> '0',
    		'nilai_sisa'				=> '0',
    		'id_mst_metode_penyusutan'	=> '1',
    		);
    		$this->db->insert('keu_inventaris',$datasave);
    		$id_invbaru = $datasave['id_inventaris'].'_tr_'.$data;
    	}
    	return $id_invbaru;
    }
    function addstepdua(){
    	$jmldata    = $this->input->post('jumlahdata');
    	$id_invbaru = '';
    	$uraian ='';
    	for ($i=1; $i <=$jmldata ; $i++) { 
    		$data = $id_invbaru;
    		$datauraian = $uraian;
    		$datawhere=array(
    			'id_inventaris'			=> $this->input->post("id_inventaris$i"),
    			);
    		$datasave = array(
    		'id_mst_akun'				=> $this->input->post("id_mst_akun$i"),
    		'id_mst_akun_akumulasi'		=> $this->input->post("id_mst_akun_akumulasi$i"),
    		'nilai_ekonomis'			=> $this->input->post("nilai_ekonomis$i"),
    		'id_mst_metode_penyusutan'	=> $this->input->post("id_mst_metode_penyusutan$i"),
    		);
    		$this->db->update('keu_inventaris',$datasave,$datawhere);

    		$datatransaksi = array(
    			'id_transaksi'				=> $this->id_transaksi(),
    			'tanggal'					=> $this->input->post("id_mst_akun$i"),
    			'uraian'					=> $this->input->post("uraian"),
    			'status'					=> $this->input->post("uraian$i"),
    			'tipe_jurnal'					=> $this->input->post("uraian$i"),
    			'code_cl_phc'					=> $this->input->post("uraian$i"),
    			);
    		$this->db->insert('keu_transaksi',$datatransaksi);
    		$id_invbaru = $datawhere['id_inventaris'].'_tr_'.$data;
    		$uraian = $this->input->post("nama_barang$i").' & '.$datauraian;
    	}
    	$kodpus='P'.$this->session->userdata('puskesmas');
    	$datatransaksi = array(
    			'id_transaksi'				=> $this->id_transaksi(),
    			'tanggal'					=> date("Y-m-d"),
    			'uraian'					=> $uraian,
    			'status'					=> 'disimpan',
    			'tipe_jurnal'				=> 'jurnal_umum',
    			'code_cl_phc'				=> $kodpus,
    			);
    	$this->db->insert('keu_transaksi',$datatransaksi);
    	return $id_invbaru;
    }
     function idinventaris($id='0'){
        $q = $this->db->query("select RIGHT(MAX(id_inventaris),4) as kd_max from keu_inventaris");
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
        $kodpus=$this->session->userdata('puskesmas');
        return $kodpus.date("Y").date('m').$nourut;
    }
    function getalldatainv($id=0){
    	$datainv    = explode('_tr_', $id);
    	$this->db->select("keu_inventaris.*,get_all_inventaris2.nama_barang,mst_keu_akun.uraian as namaakun,akunakumulasi.uraian as namakunakumulasi,mst_keu_metode_penyusutan.nama as namapenyusutan");
    	$this->db->where_in('keu_inventaris.id_inventaris',$datainv);
    	$this->db->join('get_all_inventaris2','keu_inventaris.id_inventaris_barang = get_all_inventaris2.id_inventaris_barang','left');
    	$this->db->join('mst_keu_metode_penyusutan','mst_keu_metode_penyusutan.id_mst_metode_penyusutan = keu_inventaris.id_mst_metode_penyusutan','left');
    	$this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun = keu_inventaris.id_mst_akun','left');
    	$this->db->join('mst_keu_akun akunakumulasi','akunakumulasi.id_mst_akun = keu_inventaris.id_mst_akun_akumulasi','left');
    	return $this->db->get('keu_inventaris')->result_array();
    }
    
    function getallnilaiakun($idparent=0,$i=0)
    {	
    	
	    $category_data = array();
	    if ($idparent==0) {
	    	$this->db->where("id_mst_akun_parent IS NOT NULL", null, false);
	    }else{
	    	$this->db->where("id_mst_akun_parent",(int)$idparent);
	    }
	    $this->db->order_by('urutan');
	    $category_query = $this->db->get("mst_keu_akun");
	    $pisah='-';
	    
	    $i++;

	    foreach ($category_query->result() as $category) {
	    	if ($i=='1') {
		    	$pisah='';
		    }else if ($i=='2') {
		    	$pisah='--';
		    }else if ($i=='3') {
		    	$pisah='----';
		    }else if ($i=='4') {
		    	$pisah='------';
		    }else if ($i=='5') {
		    	$pisah='--------';
		    }else if ($i=='6') {
		    	$pisah='----------';
		    }else if ($i=='7') {
		    	$pisah='------------';
		    }else{
		    	$pisah='----------------';
		    }

	        $category_data[] = array(
	            'id_mst_akun' 					=> $category->id_mst_akun,
	            'id_mst_akun_parent' 			=> $category->id_mst_akun_parent,
	            'nama_akun' 					=> $idparent!=0 ? $pisah.' '.$category->kode.' '.$category->uraian : $category->kode.' '.$category->uraian,
	        );

		$children = $this->getallnilaiakun($category->id_mst_akun,$i);

	        if ($children) {
	            $category_data = array_merge( $category_data,$children);
	        }
	    	
	    }
	    
	    
	    return $category_data;
    }
    function getallmetodepenyusustan(){
    	return $this->db->get('mst_keu_metode_penyusutan')->result_array();
    }
}
