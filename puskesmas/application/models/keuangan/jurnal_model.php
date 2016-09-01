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
        $this->db->select("keu_jurnal.*,mst_keu_akun.uraian,mst_keu_akun.kode");
        $this->db->join('mst_keu_akun','keu_jurnal.id_mst_akun=mst_keu_akun.id_mst_akun');
        $this->db->order_by("debet",'desc');
        $query = $this->db->get("keu_jurnal");
        $data=array();
        foreach ($query->result() as $key) {
            $data[]= array(
                        'id_jurnal'     => $key->id_jurnal,
                        'id_transaksi'  => $key->id_transaksi,
                        'id_mst_akun'   => $key->id_mst_akun,
                        'kodeakun'      => $key->kode,
                        'debet'         => $key->debet,
                        'kredit'        => $key->kredit,
                        'uraian'        => ($key->status!= 'kredit' ? ' &nbsp '.$key->uraian : $key->uraian),
                    );
            
        }
        return $data;
    }
    function getallkategori(){
        return $this->db->get('mst_keu_kategori_transaksi')->result_array();
    }
    function filterkategori_transaksi(){
        return $this->db->get('mst_keu_kategori_transaksi')->result();
    }
    function get_datajurnalumum($type,$status='0'){
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
            $data[$i]['status']         =  ucwords($key->status);
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
        $this->db->select("keu_transaksi.*,mst_keu_kategori_transaksi.nama as kategori_transaksi,mst_keu_syarat_pembayaran.deskripsi as syarat,mst_inv_pbf.nama as instansi ",false);
        $this->db->where('id_transaksi',$id);
        $this->db->join('mst_keu_kategori_transaksi','mst_keu_kategori_transaksi.id_mst_kategori_transaksi=keu_transaksi.id_kategori_transaksi');
        $this->db->join('mst_keu_syarat_pembayaran','mst_keu_syarat_pembayaran.id_mst_syarat_pembayaran=keu_transaksi.id_mst_syarat_pembayaran','left');
        //$this->db->join('mst_keu_instansi','mst_keu_instansi.id_mst_instansi=keu_transaksi.id_instansi','left');
        $this->db->join('mst_inv_pbf','mst_inv_pbf.code=keu_transaksi.id_instansi','left');
        $query =$this->db->get('keu_transaksi');
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        // $data = $query->free_result();
        return $data;
    }
    function get_detail_row_add($id=0){
        $this->db->select("mst_keu_transaksi.*",false);
        $this->db->where('id_mst_transaksi',$id);
        $query =$this->db->get('mst_keu_transaksi');
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
        }
        return $data;
    }
    
    function get_detail_jurnal($id){
        $this->db->select("keu_jurnal.*,mst_keu_akun.uraian");
        $this->db->where('id_transaksi',$id);
        $this->db->where("status",'kredit');
        $this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun=keu_jurnal.id_mst_akun');
        $query =$this->db->get('keu_jurnal');
        return $query->result();
    }
    function get_detail_jurnaldebit($id){
        $this->db->select("keu_jurnal.*,mst_keu_akun.uraian");
        $this->db->where('id_transaksi',$id);
        $this->db->where("status",'debet');
        $this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun=keu_jurnal.id_mst_akun');
        $query =$this->db->get('keu_jurnal');
        return $query->result();
    }
    function getsyarat(){
        $query = $this->db->get('mst_keu_syarat_pembayaran');
        return $query->result();
    }
    function getdebit($id=0){
        $this->db->select("keu_jurnal.*");
        $this->db->where('id_transaksi',$id);
        $this->db->where('status','debet');
        $this->db->order_by('debet','desc');
        $this->db->order_by('id_jurnal','asc');
        $query =$this->db->get('keu_jurnal');
        return $query->result();
    }
    function getkredit($id=0){
        $this->db->select("keu_jurnal.*");
        $this->db->where('id_transaksi',$id);
        $this->db->where('status','kredit');
        $this->db->order_by('kredit','desc');
        $this->db->order_by('id_jurnal','asc');
        $query =$this->db->get('keu_jurnal');
        return $query->result();
    }
    function getdataakun(){
        $this->db->where('mst_keu_akun.kode !=""');
        $query =$this->db->get('mst_keu_akun');
        return $query->result();   
    }
    function add_kredit_debit($tipe){
        $data = array(
            'kredit'          => '0',
            'id_jurnal'       => $this->idjurnal(),
            'id_transaksi'    => $this->input->post('id_transaksi'),
            'debet'           => '0',
            'id_mst_akun'     => '6',
            'status'          => $tipe,
            );
        if ($this->db->insert('keu_jurnal',$data)) {
            $this->db->where('id_transaksi',$this->input->post('id_transaksi'));
            $jmldata=$this->db->get('keu_jurnal')->num_rows();
            return "OK|$data[id_transaksi]|$data[id_jurnal]|$jmldata";
        }else{
            return mysql_error();
        }
    }
     function idjurnal($id='0'){
        $q = $this->db->query("select RIGHT(MAX(id_jurnal),4) as kd_max from keu_jurnal");
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
        $kodpus='P'.$this->session->userdata('puskesmas');
        return $kodpus.date("Y").date('m').$nourut;
    }
    function delete_kreditdebet($tipe){
        $data = array(
            'id_jurnal'       => $this->input->post('id_jurnal'),
            'id_transaksi'    => $this->input->post('id_transaksi'),
            );
        if ($this->db->delete('keu_jurnal',$data)) {
            $this->db->where('id_transaksi',$this->input->post('id_transaksi'));
            $jmldata=$this->db->get('keu_jurnal')->num_rows();
            return "OK|$data[id_transaksi]|$data[id_jurnal]|$jmldata";
        }else{
            return mysql_error();
        }
    }
    function selectnamaakun($id_jurnal,$tipe){
        $this->db->where('id_jurnal',$id_jurnal);
        $this->db->set('id_mst_akun',$this->input->post('valuesdata'));
        return $this->db->update('keu_jurnal');
    }
    function inputvalueakun($id_jurnal,$tipe){
        $this->db->where('id_jurnal',$id_jurnal);
        if ($tipe=='kredit') {
            $this->db->set('kredit',$this->input->post('valueinput'));
        }else{
            $this->db->set('debet',$this->input->post('valueinput'));
        }
        return $this->db->update('keu_jurnal');
    }
    function pilihan_jenis(){
        return $this->db->get('mst_keu_transaksi')->result();
    }
    function get_data_tipetransaksi($tipe,$start=0,$limit=999999,$options=array()){
        $this->db->where('untuk_jurnal',$tipe);
        $this->db->select("mst_keu_transaksi.*,mst_keu_kategori_transaksi.nama as namakategori");
        $this->db->join('mst_keu_kategori_transaksi','mst_keu_kategori_transaksi.id_mst_kategori_transaksi = mst_keu_transaksi.id_mst_kategori_transaksi','left');
        $query =$this->db->get('mst_keu_transaksi',$limit,$start);
        return $query->result();
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
    function mst_keu_tran($id){
        $this->db->where('id_mst_transaksi',$id);
        return $this->db->get('mst_keu_transaksi')->row_array();
    }
    function mst_keujurnal($id){
        $this->db->where('id_mst_transaksi',$id);
        return $this->db->get('mst_keu_transaksi_item')->result_array();
    }
    function addjurnal($id){
        $kodpus = 'P'.$this->session->userdata('puskesmas');
        $dat = $this->mst_keu_tran($id);
        $datakeu_transaksipen=array(
                        'id_transaksi'=>$this->idtrasaksi(),
                        'tanggal'=> date('Y-m-d'),
                        'code_cl_phc'=>$kodpus,
                        'tipe_jurnal'=>$dat['untuk_jurnal'],
                        'status'=>'draft',
                        'id_kategori_transaksi'=>$dat['id_mst_kategori_transaksi'],
                        'id_mst_keu_transaksi'=> $dat['id_mst_transaksi'],
                        );
        $this->db->insert('keu_transaksi',$datakeu_transaksipen);
        $datajurnal = $this->mst_keujurnal($id);
        foreach ($datajurnal as $key) {

            if ($key['type']=='kredit') {
                $datakredit=array(
                        'id_jurnal'=>$this->idjurnal(),
                        'id_transaksi'=> $datakeu_transaksipen['id_transaksi'],
                        'id_mst_akun'=>$key['id_mst_akun'],
                        'debet'=>'0',
                        'kredit'=>$key['value'],
                        'status'=> 'kredit',
                        );
                $this->db->insert('keu_jurnal',$datakredit);
            }else{
                $datadebet=array(
                        'id_jurnal'=>$this->idjurnal(),
                        'id_transaksi'=> $datakeu_transaksipen['id_transaksi'],
                        'id_mst_akun'=>$key['id_mst_akun'],
                        'debet'=>$key['value'],
                        'kredit'=>'0',
                        'status'=> 'debet',
                        );
                $this->db->insert('keu_jurnal',$datadebet);
            }
        }
        return $datakeu_transaksipen['id_transaksi'];
    }
    function getallpuskesmas(){
        return $this->db->get('cl_phc')->result();
    }
    function get_data_inventaris($id=0,$start=0,$limit=999999,$options=array()){
        $this->db->not_like('id_mst_inv_barang','06','after');
        $this->db->not_like('id_mst_inv_barang','05','after');
        $this->db->where_not_in('id_inventaris_barang',"select id_inventaris from keu_transaksi_inventaris where id_transaksi=".'"'.$id.'"'."");
        return $this->db->get('get_all_inventaris2',$limit,$start)->result();
    }
    function namabarang($id){
        $this->db->where('id_inventaris_barang',$id);
        $data = $this->db->get('get_all_inventaris2')->row_array();
        return $data;
    }
    function addInventaris($idtransaksi){
        $db = explode('_tr_',$this->input->post('data_barang'));
        $tempid='';
        $dataid='';
        for($i=0; $i<(count($db))-1; $i++){
           $tempid = $dataid;
           $getdat = $this->namabarang($db[$i]);
            $valuesdata = array(
                'id_inventaris'=>$db[$i],
                'id_transaksi' => $idtransaksi,
                'uraian' => $getdat['nama_barang'],
                'periode_penyusutan_awal' => date('Y-m-d'),
                'periode_penyusutan_akhir' => date('Y-m-d'), 
                'pemakaian_period' => '0'
            );
            $this->db->insert('keu_transaksi_inventaris',$valuesdata);
            $id = $this->db->insert_id();
            $dataid = $id.'####'.$tempid;
            $datakredit=array(
                        'id_jurnal'=>$this->idjurnal(),
                        'id_transaksi'=> $idtransaksi,
                        'id_mst_akun'=>'0',
                        'debet'=>'0',
                        'kredit'=>$getdat['harga'],
                        'status'=> 'kredit',
                        'id_keu_transaksi_inventaris'=> $id,
                        );
                $this->db->insert('keu_jurnal',$datakredit);
            $datadebet=array(
                        'id_jurnal'=>$this->idjurnal(),
                        'id_transaksi'=> $idtransaksi,
                        'id_mst_akun'=>'0',
                        'debet'=>$getdat['harga'],
                        'kredit'=>'0',
                        'status'=> 'debet',
                        'id_keu_transaksi_inventaris'=> $id,
                        );
                $this->db->insert('keu_jurnal',$datadebet);
        }
        return $dataid;
    }
    function get_allinventaris($id){
        $this->db->where('id_transaksi',$id);
        $this->db->select('keu_transaksi_inventaris.*,inv_inventaris_barang.nama_barang,(select sum(debet) from keu_jurnal where id_keu_transaksi_inventaris = keu_transaksi_inventaris.id_transaksi_inventaris) as totaldebet,(select sum(kredit) from keu_jurnal where id_keu_transaksi_inventaris = keu_transaksi_inventaris.id_transaksi_inventaris) as totalkredit');
        $this->db->join('inv_inventaris_barang','inv_inventaris_barang.id_inventaris_barang=keu_transaksi_inventaris.id_inventaris','left');
        $query = $this->db->get('keu_transaksi_inventaris');
        $data=array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $key) {
                $data[$key['id_transaksi_inventaris']]['id_transaksi_inventaris']    = $key['id_transaksi_inventaris'];
                $data[$key['id_transaksi_inventaris']]['id_inventaris']              = $key['id_inventaris'];
                $data[$key['id_transaksi_inventaris']]['id_transaksi']               = $key['id_transaksi'];
                $data[$key['id_transaksi_inventaris']]['periode_penyusutan_awal']    = $key['periode_penyusutan_awal'];
                $data[$key['id_transaksi_inventaris']]['periode_penyusutan_akhir']   = $key['periode_penyusutan_akhir'];
                $data[$key['id_transaksi_inventaris']]['uraian']                     = $key['uraian'];
                $data[$key['id_transaksi_inventaris']]['nama_barang']                = $key['nama_barang'];
                $data[$key['id_transaksi_inventaris']]['pemakaian_period']           = $key['pemakaian_period'];
                $data[$key['id_transaksi_inventaris']]['totalkredit']                = $key['totalkredit'];
                $data[$key['id_transaksi_inventaris']]['totaldebet']                 = $key['totaldebet'];
                $data[$key['id_transaksi_inventaris']]['childern']                   = $this->getjurnal($key['id_transaksi_inventaris']);
            }
        }
        
        return $data;
    }
   function getjurnal($id=0){
        $this->db->order_by('kredit','desc');
        $this->db->where('id_keu_transaksi_inventaris',$id);
        $query = $this->db->get('keu_jurnal');
        $data=array();
        if ($query->num_rows()>0) {
            foreach ($query->result_array() as $key) {
                $data[$key['id_jurnal']]['id_jurnal']       = $key['id_jurnal'];
                $data[$key['id_jurnal']]['id_transaksi']    = $key['id_transaksi'];
                $data[$key['id_jurnal']]['id_mst_akun']     = $key['id_mst_akun'];
                $data[$key['id_jurnal']]['debet']           = $key['debet'];
                $data[$key['id_jurnal']]['kredit']          = $key['kredit'];
                $data[$key['id_jurnal']]['status']          = $key['status'];
                $data[$key['id_jurnal']]['id_keu_transaksi_inventaris']    = $key['id_keu_transaksi_inventaris'];
            }
        }
        return $data;

   }
}