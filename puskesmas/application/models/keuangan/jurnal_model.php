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
    function get_datajurnalumum($type){
        $puskes = 'P'.$this->session->userdata('puskesmas');
        $this->db->where('code_cl_phc',$puskes);
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
}