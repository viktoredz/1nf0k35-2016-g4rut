<?php
class Penyusutan_model extends CI_Model {

    var $tb    = 'keu_sts';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
    }
    
    function get_data($start=0,$limit=999999,$options=array()){
    	$this->db->join('mst_keu_metode_penyusutan','keu_inventaris.id_inventaris_barang=mst_keu_metode_penyusutan.id_mst_metode_penyusutan','left');
    	$this->db->join('get_all_inventaris2','get_all_inventaris2.id_inventaris_barang=keu_inventaris.id_inventaris_barang','right');
        return $this->db->get('keu_inventaris',$limit,$start)->result();
    }
    function get_data_inventaris($start=0,$limit=999999,$options=array()){
    	$this->db->select("get_all_inventaris2.*,IF((SELECT `id_inventaris` FROM `keu_inventaris` WHERE id_inventaris_barang=get_all_inventaris2.`id_inventaris_barang`) IS NULL,'','ditambahkan') AS status",false);
        return $this->db->get('get_all_inventaris2',$limit,$start)->result();
    }
    function get_data_puskesmas(){
    	return $this->db->get('cl_phc')->result();
    }
    function addstepsatu(){
    	$tgl 		= explode('_tu_', $id);
    	$datainv    = explode('_tr_', $tgl[1]);
    	for ($i=0; $i <=count($datainv)-1 ; $i++) { 
    		$datasave = array(
    		'id_inventaris'			=> $this->idinventaris(),
    		'id_inventaris_barang'	=> $datainv[$i],
    		'id_mst_akun'			=> '9',
    		'id_mst_akun_akumulasi'		=> '9',
    		'akumulasi_beban'			=> '9',
    		'nilai_ekonomis'			=> '0',
    		'nilai_sisa'				=> '0',
    		'id_mst_metode_penyusutan'	=> '1',
    		);
    		$this->db->insert('keu_inventaris',$datasave);
    	}
    	return $this->input->post('dataceklis');
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
    	$tgl 		= explode('_tu_', $id);
    	$datainv    = explode('_tr_', $tgl[1]);
    	$this->db->select("keu_inventaris.*,get_all_inventaris2.nama_barang");
    	$this->db->where_in('id_inventaris_barang',$datainv);
    	$this->db->join('keu_inventaris','keu_inventaris.id_inventaris_barang = get_all_inventaris2.id_inventaris_barang','left');
    	return $this->db->get('get_all_inventaris2')->result_array();
    }
}
