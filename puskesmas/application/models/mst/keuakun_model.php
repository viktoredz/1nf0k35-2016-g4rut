<?php
class Keuakun_model extends CI_Model {

    var $tabel    = '';
	var $lang	  = '';
    var $tb       = 'mst_keu_akun';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }

    function insert_entry(){
        $akun_urutan        = $this->input->post('akun_urutan');
        $akun_urutan_induk  = $this->input->post('akun_urutan_induk');
        $this->db->where('id_mst_akun',$akun_urutan_induk);
        $dt = $this->db->get($this->tb)->row();
        if($akun_urutan == "sebelum"){
            $data['urutan']  = $dt->urutan;
        }else{
            $data['urutan']  = $dt->urutan+1;
        }

        $data['uraian']         = $this->input->post('uraian');
        $data['saldo_normal']   = $this->input->post('saldo_normal');

        $data['aktif']              = 1;
        $data['saldo_awal']         = 0;
        $data['bisa_transaksi']     = 0;
        $data['bisa_diedit']        = 0;
        $data['buku_besar_umum']    = 1;
        $data['mendukung_target']   = 0;
        $data['mendukung_anggaran'] = 0;
        $data['mendukung_transaksi']= 0;
        $data['tanggal_dibuat']     = date('Y-m-d H:i:s');
	
		if($this->db->insert($this->tb, $data)){
            $id = mysql_insert_id();
            $this->db->query("UPDATE mst_keu_akun SET urutan=urutan+1 WHERE isnull(`id_mst_akun_parent`) AND urutan >= ".$data['urutan']." AND `id_mst_akun`<>".$id);

            return 1;
		}else{
			return mysql_error();
		}
    }

    function mendukung_transaksi_update($id){
        $data['mendukung_transaksi']      = $this->input->post('mendukung_transaksi');
       
        $this->db->where('id_mst_akun',$id);

        if($this->db->update($this->tb, $data)){
            $this->db->where('id_mst_akun',$id);
            $this->db->select('mendukung_transaksi');
            $variable = $this->db->get('mst_keu_akun');
            foreach ($variable->result() as $key) {
                if ($key->mendukung_transaksi=='1') {
                    return '1';
                }else{
                    return '2';    
                }
            }
        }else{
            return mysql_error();
        }
    }

    function mendukung_anggaran_update($id){
        $data['mendukung_anggaran']       = $this->input->post('mendukung_anggaran');
       
        $this->db->where('id_mst_akun',$id);

        if($this->db->update($this->tb, $data)){
            $this->db->where('id_mst_akun',$id);
            $this->db->select('mendukung_anggaran');
            $variable = $this->db->get('mst_keu_akun');
            foreach ($variable->result() as $key) {
                if($key->mendukung_anggaran=='1'){
                    return '1';
                }else{
                    return '2';
                }
            }
        }else{
            return mysql_error();
        }
    }

    function mendukung_target_update($id){
        $data['mendukung_target']         = $this->input->post('mendukung_target');
       
        $this->db->where('id_mst_akun',$id);

        if($this->db->update($this->tb, $data)){
            $this->db->where('id_mst_akun',$id);
            $this->db->select('mendukung_target');
            $variable = $this->db->get('mst_keu_akun');
            foreach ($variable->result() as $key ) {
               if ($key->mendukung_target=='1') {
                   return '1';
               }else{
                   return '2';
               }
            }
        }else{
            return mysql_error();
        }
    }

    function akun_delete($id = 0){
        $this->db->where('id_mst_akun_parent', $id);
        $child = $this->db->get($this->tb)->row();
        if(empty($child->id_mst_akun)){
            $this->db->where('id_mst_akun', $id);
            return $this->db->delete($this->tb);
        }else{
            return false;
        }

    }
    function akun_anggran_add(){

        $data = array(
           'jumlah'                 => $this->input->post('jumlah'),
           'tipe'                   => $this->input->post('tipe') ,
           'periode'                => $this->input->post('periode'),
           'id_mst_akun'            => $this->input->post('id_mst_akun'),
           'code_cl_phc'            => $this->input->post('code_cl_phc'),
        );
        $datawhere = array(
            'id_akun_anggaran'      => str_replace(" ", '', $this->input->post('id_akun_anggaran')),
            );
        $query = $this->db->get_where('keu_akun_anggaran',$datawhere);
        if ($query->num_rows>0) {
            if ($this->db->update('keu_akun_anggaran',$data,$datawhere)) {
                // $this->insertparent($data['id_mst_akun'],$data['tipe']);
                return 1;
            }else{
                return mysql_error();
            }
        }else{
            $dataid = array(
            'id_akun_anggaran'      => $this->idanggaran(),
            );
            $datainsert = array_merge($dataid,$data);
            if ($this->db->insert('keu_akun_anggaran',$datainsert)) {
                $this->updateparent();
                return 1;
            }else{
                return mysql_error();
            }
        }
    }
    function insertparent($kode='',$tipe=''){
        // $this->db->where('id_mst_akun',$kode);
        // $query = $this->db->get('mst_keu_akun');
        // if ($query->num_rows() > 0) {
        //     $parent = $query->row_array();
        //     $this->db->where('id_mst_akun_parent',$parent['id_mst_akun']);
        //     $this->db->joint('keu_akun_anggaran','keu_akun_anggaran.id_mst_akun = mst_keu_akun.id_mst_akun','left')
        //     $this->select("sum(keu_akun_anggaran.jumlah) as totalparent");
        //     $queryparent = $this->db->get('mst_keu_akun');

        //     $whereparent = array('id_mst_akun' => $kode);
        //     $cekidakun = $this->db->get_where('keu_akun_anggaran',$whereparent);
        //     if ($cekidakun->num_rows() > 0) 
        //         $idanggaran = $cekidakun->row_array():
        //         $queryparentdata = $queryparent->row_array();

        //         $this->db->where('id_akun_anggaran',$queryparentdata['id_akun_anggaran']);{
        //         $parentedit = array('jumlah', $queryparentdata['totalparent']);
        //         $this->update('keu_akun_anggaran',$parentedit);
        //     }
        // }
    }
    function updateparent($kode=''){
        $this->db->where('id_mst_akun',$kode);
        $query = $this->db->get('mst_keu_akun');
        if ($query->num_rows() > 0) {
            $parent = $query->row_array();
            $this->db->where('id_mst_akun_parent',$parent['id_mst_akun']);
            $this->select("sum(jumlah) as totalparent");
            $queryparent = $this->db->get('mst_keu_akun');
            if ($queryparent->num_rows() > 0) 
                $queryparentdata = $queryparent->row_array();
                $this->db->where('id_mst_akun',$kode);{
                $parentedit = array('jumlah', $queryparentdata['totalparent']);
                $this->update('mst_keu_akun',$parentedit);
            }
        }
    }
    function idanggaran()
    {
       $idpus = $this->session->userdata('puskesmas');
        $q = $this->db->query("select MAX(RIGHT(id_akun_anggaran,6)) as kd_max from keu_akun_anggaran where id_akun_anggaran like "."'".$idpus."%'"."");
        $nourut="";
        if($q->num_rows()>0)
        {
            foreach($q->result() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $nourut = sprintf("%06s", $tmp);
            }
        }
        else
        {
            $nourut = "000001";
        }
        return $this->session->userdata('puskesmas').$nourut;
    }
    function akun_add(){
        $data = array(
           'id_mst_akun_parent'     => $this->input->post('id_mst_akun_parent'),
           'kode'                   => $this->input->post('kode') ,
           'saldo_normal'           => $this->input->post('saldo_normal'),
           'saldo_awal'             => $this->input->post('saldo_awal'),
           'uraian'                 => $this->input->post('uraian'),
           'aktif'                  => 1,
           'bisa_diedit'            => 1,
           'buku_besar_umum'        => 1,
           'mendukung_transaksi'    => $this->input->post('mendukung_transaksi')
        );

         if($this->db->set('tanggal_dibuat', 'NOW()', FALSE)){
           ($this->db->insert($this->tb, $data));
            return 1;
        }else{
            return mysql_error();
        }
    }

    function akun_update(){
        $data = array(
           'id_mst_akun_parent'  => $this->input->post('id_mst_akun_parent'),
           'kode'                => $this->input->post('kode') ,
           'saldo_normal'        => $this->input->post('saldo_normal') ,
           'saldo_awal'          => $this->input->post('saldo_awal'),
           'uraian'              => $this->input->post('uraian'),
           'mendukung_transaksi' => $this->input->post('mendukung_transaksi')
        );
        $this->db->where('id_mst_akun', $this->input->post('id_mst_akun'));
        return $this->db->update($this->tb, $data);             
    }

 	function get_data($start=0,$limit=999999,$options=array())
    {
		$this->db->order_by('id_mst_akun','asc');
        $query = $this->db->get('mst_keu_akun',$limit,$start);
        return $query->result();
    }

    function get_data_akun(){     
        $this->db->where('aktif',1);
        $this->db->order_by('urutan','asc');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();  
    }

    function get_data_akun_anggaran($pilih,$tahun,$puskesmas){     
        $this->db->where('aktif',1);
        $this->db->order_by('urutan','asc');
        $this->db->select('mst_keu_akun.*,keu_akun_anggaran.id_akun_anggaran,keu_akun_anggaran.jumlah,keu_akun_anggaran.tipe,keu_akun_anggaran.periode,keu_akun_anggaran.code_cl_phc');
        $this->db->join('keu_akun_anggaran',"keu_akun_anggaran.id_mst_akun = mst_keu_akun.id_mst_akun and keu_akun_anggaran.tipe="."'".$pilih."'"."and  periode="."'".$tahun."'"."and  code_cl_phc="."'".$puskesmas."'"."",'left');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();  
    }
    
    function get_data_akun_target($pilih,$tahun,$puskesmas){     
        $this->db->where('aktif',1);
        $this->db->order_by('urutan','asc');
        $this->db->select("mst_keu_akun.id_mst_akun as id_mst_akun_target,mst_keu_akun.id_mst_akun_parent as id_mst_akun_parent_target,mst_keu_akun.kode as kode_target,mst_keu_akun.uraian as uraian_target,mst_keu_akun.saldo_normal as saldo_normal_target,mst_keu_akun.saldo_awal as saldo_awal_target,keu_akun_anggaran.id_akun_anggaran as id_akun_anggaran_target,keu_akun_anggaran.jumlah as jumlah_target,keu_akun_anggaran.tipe as tipe_target,keu_akun_anggaran.periode as periode_target,keu_akun_anggaran.code_cl_phc as code_cl_phc_target,ifnull((SELECT max(a.id_mst_akun_parent) FROM mst_keu_akun a where a.id_mst_akun_parent=mst_keu_akun.id_mst_akun),'anak') as statusdata",false);
        $this->db->join('keu_akun_anggaran',"keu_akun_anggaran.id_mst_akun = mst_keu_akun.id_mst_akun and keu_akun_anggaran.tipe="."'".$pilih."'"."and  periode="."'".$tahun."'"."and  code_cl_phc="."'".$puskesmas."'"."",'left');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();  
    }

    function get_data_akun_non_aktif(){     
        $this->db->where('aktif','0');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result_array();  
    }

    function get_parent_akun(){     
        $this->db->where('id_mst_akun_parent IS NULL');
        $this->db->order_by('uraian','asc');
        $query = $this->db->get('mst_keu_akun');     
        return $query->result();  
    }

   function get_data_akun_detail($id){
        $data = array();
        $this->db->where("id_mst_akun",$id);
        $query = $this->db->get('mst_keu_akun');
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }

    function get_data_akun_non_aktif_detail($id){
        $data = array();
        $this->db->where("id_mst_akun",$id);
        $this->db->where('aktif',0);
        $query = $this->db->get('mst_keu_akun');
        if($query->num_rows()>0){
            $data = $query->row_array();
        }

        $query->free_result();
        return $data;
    }
    function get_datapuskesmas(){
        return $this->db->get('cl_phc')->result();
    }
}

