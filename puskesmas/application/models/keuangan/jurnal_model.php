<?php
class Jurnal_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->lang   = $this->config->item('language');
    }
    function getchild($idparent=0)
    {   
        $this->db->where('id_mst_transaksi',$idparent);
        $query = $this->db->get('mst_keu_transaksi_item');
        foreach ($query->result() as $key) {
            $data[] = array(
                'id_mst_transaksi_item' => $key->id_mst_transaksi_item,
                'id_mst_akun'           => $key->id_mst_akun,
                'id_mst_transaksi'      => $key->id_mst_transaksi,
                'group'                 => $key->group,
                'type'                  => $key->type,
                'auto_fill'             => $key->auto_fill,
                'id_mst_transaksi_item_from'=> $key->id_mst_transaksi_item_from,
                'value'                 => $key->value,
                'urutan'                => $key->urutan,
                'opsional'              => $key->opsional,
            );
        }
        return $data;
    }
    function get_data_jurnal_umum($start=0,$limit=999999,$options=array()){
        $category_data = array();
        $category_query = $this->db->get("mst_keu_transaksi");

        foreach ($category_query->result() as $category) {
            $category_data[] = array(
                'id_mst_transaksi'      => $category->id_mst_transaksi,
                'nama'                  => $category->nama,
                'untuk_jurnal'          => $category->untuk_jurnal,
                'deskripsi'             => $category->deskripsi,
                'jumlah_transaksi'      => $category->jumlah_transaksi,
                'bisa_diubah'           => $category->bisa_diubah,
                'id_mst_kategori_transaksi' => $category->id_mst_kategori_transaksi,
                'child'                 => $this->getchild($category->id_mst_transaksi)
            );
        }
        print_r($category_data);
    }

    function getchildumum($parent=0){
        $this->db->where("keu_jurnal.id_transaksi",$parent);
        $this->db->select("keu_jurnal.*,mst_keu_akun.uraian");
        $this->db->join('mst_keu_akun','keu_jurnal.id_mst_akun=mst_keu_akun.kode');
        $this->db->order_by("debet",'desc');
        $query = $this->db->get("keu_jurnal");
        $data=array();
        foreach ($query->result() as $key) {
            $data[]= array(
                        'id_jurnal'     => $key->id_jurnal,
                        'id_transaksi'  => $key->id_transaksi,
                        'id_mst_akun'   => $key->id_mst_akun,
                        'debet'         => $key->debet,
                        'kredit'        => $key->kredit,
                        'uraian'        => ($key->kredit!= '0' ? ' &nbsp '.$key->uraian : $key->uraian),
                    );
            
        }
        return $data;
    }
    function getallkategori(){
        return $this->db->get('mst_keu_kategori_transaksi')->result_array();
    }
    function get_datajurnalumum($type,$status='0'){
        $puskes = 'P'.$this->session->userdata('puskesmas');
        $this->db->where('code_cl_phc',$puskes);
        if ($status!='0') {
            $this->db->where('status', 'dihapus');
        }else{
            $this->db->where('status !=', 'dihapus');
        }
        $this->db->select("*");
        $this->db->where("tipe_jurnal",$type);
        $query = $this->db->get("keu_transaksi");
        $i=0;
        $data=array();
        foreach ($query->result() as $key) {
            $data[$i]['id_jurnalis']    =  $i;
            $data[$i]['id_transaksi']   =  $key->id_transaksi;
            $data[$i]['tanggal']        =  date("d-m-Y",strtotime($key->tanggal));
            $data[$i]['uraian']         =  $key->uraian;
            $data[$i]['tipe_jurnal']    =  $key->tipe_jurnal;
            $data[$i]['status']         =  $key->status;
            $data[$i]['id_kategori_transaksi']  =  $key->id_kategori_transaksi;
            $data[$i]['code_cl_phc']    =  $key->code_cl_phc;
            $data[$i]['debet']          =  '';
            $data[$i]['kredit']         =  '';
            $data[$i]['edit']           =  '1';
            $data[$i]['child']         = $this->getchildumum($key->id_transaksi);
        $i++;
        }
        return $data;
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
    function get_detail_row($id=0){
        $this->db->select("keu_transaksi.*,mst_keu_kategori_transaksi.nama as kategori_transaksi,(select debet from keu_jurnal where debet!=0 and id_transaksi=keu_transaksi.id_transaksi) as jml_debit,(select concat(keu_jurnal.id_mst_akun,' - ',mst_keu_akun.uraian) from keu_jurnal join mst_keu_akun on keu_jurnal.id_mst_akun=mst_keu_akun.kode where debet!=0 and id_transaksi=keu_transaksi.id_transaksi) as id_akun_debit,mst_keu_syarat_pembayaran.deskripsi as syarat,mst_keu_instansi.nama as instansi ",false);
        $this->db->where('id_transaksi',$id);
        $this->db->join('mst_keu_kategori_transaksi','mst_keu_kategori_transaksi.id_mst_kategori_transaksi=keu_transaksi.id_kategori_transaksi');
        $this->db->join('mst_keu_syarat_pembayaran','mst_keu_syarat_pembayaran.id_mst_syarat_pembayaran=keu_transaksi.id_mst_syarat_pembayaran','left');
        $this->db->join('mst_keu_instansi','mst_keu_instansi.id_mst_instansi=keu_transaksi.id_instansi','left');
        $query =$this->db->get('keu_transaksi');
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        // $data = $query->free_result();
        return $data;
    }
    function get_detail_jurnal($id){
        $this->db->select("keu_jurnal.*,mst_keu_akun.uraian");
        $this->db->where('id_transaksi',$id);
        $this->db->where("kredit !=",'0');
        $this->db->join('mst_keu_akun','mst_keu_akun.kode=keu_jurnal.id_mst_akun');
        $query =$this->db->get('keu_jurnal');
        return $query->result();
    }
    function getsyarat(){
        $query = $this->db->get('mst_keu_syarat_pembayaran');
        return $query->result();
    }
    function getdebitkredit($id=0){
        $this->db->select("keu_jurnal.*");
        $this->db->where('id_transaksi',$id);
        $query =$this->db->get('keu_jurnal');
        return $query->result();
    }
    function getdataakun(){
        $query =$this->db->get('mst_keu_akun');
        return $query->result();   
    }
    function add_kredit(){
        $data = array(
            'kredit'          => '0',
            'id_jurnal'       => $this->idjurnal($this->input->post('id_transaksi')),
            'id_transaksi'    => $this->input->post('id_transaksi'),
            'debet'           => '0',
            );
        if ($this->db->insert('keu_jurnal',$data)) {
            return "OK|$data[id_transaksi]|$data[id_jurnal]";
        }else{
            return mysql_error();
        }
    }
     function idjurnal($id='0'){
        $q = $this->db->query("select RIGHT(MAX(id_jurnal),2) as kd_max from keu_jurnal where id_transaksi="."'".$id."'"."");
        $nourut="";
        if($q->num_rows()>0)
        {
            foreach($q->result() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $nourut = sprintf("%02s", $tmp);
            }
        }
        else
        {
            $nourut = "01";
        }
        return $id.$nourut;
    }
    function delete_kredit(){
        $data = array(
            'id_jurnal'       => $this->input->post('id_jurnal'),
            'id_transaksi'    => $this->input->post('id_transaksi'),
            );
        if ($this->db->delete('keu_jurnal',$data)) {
            return "OK|$data[id_transaksi]|$data[id_jurnal]";
        }else{
            return mysql_error();
        }
    }
}