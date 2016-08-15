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
        return $category_data;
    }
}