<?php
class Bukubesar_model extends CI_Model {

    var $tabel    = 'mst_keu_bukubesar';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    

    function get_data($start=0,$limit=999999,$options=array())
    {
		$this->db->order_by('id_mst_bukubesar','asc');
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

 	function get_data_row($id){
		$data = array();
		$options = array('id_mst_bukubesar' => $id);
		$query = $this->db->get_where($this->tabel,$options);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	public function getSelectedData($table,$data)
    {
        return $this->db->get_where($table, array('kode'=>$data));
    }
   
	function getallnilaiakun($idparent=0,$i=0)
    {	
    	
	    $category_data = array();
	    if ($idparent==0) {
	    	$this->db->where("id_mst_akun_parent IS NULL", null, false);
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
     function pilihan_enums($table , $field){
     $row = $this->db->query("SHOW COLUMNS FROM ".$table." LIKE '$field'")->row()->Type;  
     $regex = "/'(.*?)'/";
            preg_match_all( $regex , $row, $enum_array );
            $enum_fields = $enum_array[1];
            foreach ($enum_fields as $key=>$value)
            {
                $enums[$value] = $value; 
            }
            return $enums;
    }
    function getalldatakaun(){
    	return $this->db->get('mst_keu_bukubesar')->result();
    }
}