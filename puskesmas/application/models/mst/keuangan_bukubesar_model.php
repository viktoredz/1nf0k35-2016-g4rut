<?php
class Keuangan_bukubesar_model extends CI_Model {

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
   function insert_entry()
    {
    	$datapisah = $this->input->post('aktif');
		if (isset($datapisah) && $datapisah=='1') {
			$data['aktif']	= '1';
		}
		$data['judul']				= $this->input->post('judul');
		$data['deskripsi']			= $this->input->post('deskripsi');
		$data['pisahkan_berdasar']	= $this->input->post('pisahkan_berdasar');

		
		if($this->db->insert($this->tabel, $data)){
			return $this->db->insert_id();
		}else{
			return mysql_error();
		}
    }

    function update_entry($kode)
    {
		$datapisah = $this->input->post('aktif');
		if (isset($datapisah) && $datapisah=='1') {
			$data['aktif']	= '1';
		}
		$data['judul']				= $this->input->post('judul');
		$data['deskripsi']			= $this->input->post('deskripsi');
		$data['pisahkan_berdasar']	= $this->input->post('pisahkan_berdasar');

		if($this->db->update($this->tabel, $data, array("id_mst_bukubesar"=>$kode))){
			return true;
		}else{
			return mysql_error();
		}
    }

	function delete_entry($kode)
	{
		$this->db->where('id_mst_bukubesar',$kode);

		return $this->db->delete($this->tabel);
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
    function get_dataakunall($id=0){
    	$data=array();
    	$this->db->select("mst_keu_akun.*,mst_keu_bukubesar_akun.id_mst_buku_besar");
    	$this->db->where('id_mst_buku_besar',$id);
    	$this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun=mst_keu_bukubesar_akun.id_mst_akun');
    	$data= $this->db->get('mst_keu_bukubesar_akun')->result_array();
    	return $data;
    }
    function getdatanama($id=0){
    	$this->db->where('id_mst_akun',$id);
    	$data = $this->db->get('mst_keu_akun')->row_array();
    	return $data['uraian'];
    }
    function insertdatakaun(){
    	$data['id_mst_buku_besar'] 	= $this->input->post('id_mst_buku_besar');
    	$data['id_mst_akun']		= $this->input->post('id_mst_akun');
    	$query = $this->db->get_where('mst_keu_bukubesar_akun',$data);
    	if ($query->num_rows() > 0) {
    		return 'duplicate';
    	}else{
    		if ($this->db->insert('mst_keu_bukubesar_akun',$data)) {
    			return "OK|".$data['id_mst_buku_besar'].'|'.$data['id_mst_akun'].'|'.$this->getdatanama($data['id_mst_akun']);
	    	}else{
	    		return "error|".$data['id_mst_buku_besar'].'|'.$data['id_mst_akun'].'|'.$this->getdatanama($data['id_mst_akun']);
	    	}
    	}
    }
    function deletedatakaun(){
    	$this->db->where('id_mst_buku_besar',$this->input->post('id_buku'));
    	$this->db->where('id_mst_akun',$this->input->post('id_akun'));
    	if ($this->db->delete('mst_keu_bukubesar_akun')) {
			return "OK|";
    	}else{
    		return "error|";
    	}
    }
    function updateaktip(){
    	$this->db->where('id_mst_bukubesar',$this->input->post('id'));
    	$data = $this->db->get('mst_keu_bukubesar')->row_array();
    	if ($data['aktif']=='1') {
    		$dataup['aktif'] = '0';
    	}else{
    		$dataup['aktif'] = '1';
    	}
    	$this->db->where('id_mst_bukubesar',$this->input->post('id'));
    	$this->db->update('mst_keu_bukubesar',$dataup);
    }
}