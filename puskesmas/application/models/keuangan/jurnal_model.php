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

    function getchildumum($parent=0,$type){
        $this->db->where("keu_jurnal.id_transaksi",$parent);
        $this->db->select("keu_jurnal.*,mst_keu_akun.uraian,mst_keu_akun.kode");
        $this->db->join('mst_keu_akun','keu_jurnal.id_mst_akun=mst_keu_akun.id_mst_akun');
        if ($type=='jurnal_umum') {
            $this->db->order_by("debet",'desc');
        }else{
            // $this->db->order_by("kredit",'desc');
        }
        
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
    function get_datajurnalumum($type='jurnal_umum',$status='0'){
        if ($status!='0') {
            $this->db->where('status','dihapus');
        }else{
            $this->db->where('status !=','dihapus');
        }
        $this->db->select("*");
        if ($type!='semuajurnal') {
            if ($type=='jurnal_penutup') {
                # code...
            }else{
                $this->db->where("tipe_jurnal",$type);
            }
        }
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
            $data[$i]['child']         = $this->getchildumum($key->id_transaksi,$type);
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
        $this->db->join('mst_keu_kategori_transaksi','mst_keu_kategori_transaksi.id_mst_kategori_transaksi=keu_transaksi.id_kategori_transaksi','left');
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
        // $this->db->where('mst_keu_akun.kode !=""');
        $query =$this->db->get('mst_keu_akun');
        return $query->result();   
    }
    function masterakun($id,$tipe='debit'){
        $this->db->where('id_mst_transaksi',$id);
        $this->db->where('type',$tipe);
        $query = $this->db->get('mst_keu_transaksi_item')->row_array();
        return $query['id_mst_akun'];
    }
    function getdataakunselect($id){
        $query =$this->db->get('mst_keu_akun');
        $data['datapilihaakunkredit']      = $this->masterakun($id,'kredit');
        $data['datapilihaakundebit']      = $this->masterakun($id,'debit');
        $i=0;
        foreach ($query->result_array() as $key) {
            $data[$i]['id_mst_akun'] = $key['id_mst_akun'];
            $data[$i]['uraian']      = $key['uraian'];
            $i++;
        }
        
        return $data;
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
        $kodpus=$this->session->userdata('puskesmas');
        $kodedata = $kodpus.date("Y").date('m');
        $q = $this->db->query("select RIGHT(MAX(id_jurnal),4) as kd_max from keu_jurnal where id_jurnal like "."'".$kodedata."%'"."");
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
        $kodpus = $this->session->userdata('puskesmas');
        $kodedata =$kodpus.date("Y").date('m');
        $q = $this->db->query("select MAX(RIGHT(id_transaksi,4)) as kd_max from keu_transaksi where id_transaksi like "."'".$kodedata."%'"."");
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
    function addjurnal($id,$tipetransaksi){
        $kodpus = $this->session->userdata('puskesmas');
        $dat = $this->mst_keu_tran($id);
        $datakeu_transaksipen=array(
                        'id_transaksi'=>$this->idtrasaksi(),
                        'tanggal'=> date('Y-m-d'),
                        'code_cl_phc'=>'P'.$kodpus,
                        'tipe_jurnal'=>$dat['untuk_jurnal'],
                        'status'=>'draft',
                        'id_kategori_transaksi'=>$dat['id_mst_kategori_transaksi'],
                        'id_mst_keu_transaksi'=> $dat['id_mst_transaksi'],
                        );
        $this->db->insert('keu_transaksi',$datakeu_transaksipen);
        if ($tipetransaksi=='jurnal_penyesuaian') {
            $this->db->where('id_transaksi',$datakeu_transaksipen['id_transaksi']);
            $this->db->set('uraian',$dat['nama']);
            $this->db->update('keu_transaksi');
        }else{
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
        }
        return $datakeu_transaksipen['id_transaksi'];
    }
    function getallpuskesmas(){
        return $this->db->get('cl_phc')->result();
    }
    function get_data_inventaris($id=0,$start=0,$limit=999999,$options=array()){
        $this->db->not_like('id_mst_inv_barang','06','after');
        $this->db->not_like('id_mst_inv_barang','05','after');
        $this->db->where('`id_inventaris_barang` NOT IN (SELECT `id_inventaris` FROM `keu_transaksi_inventaris` where `id_transaksi`='.'"'.$id.'")'.'', NULL, FALSE);
        return $this->db->get('get_all_inventaris2',$limit,$start)->result();
    }
    function namabarang($id){
        $this->db->where('id_inventaris_barang',$id);
        $data = $this->db->get('get_all_inventaris2')->row_array();
        return $data;
    }
    function hargapenyusutan($id=0){
        $this->db->where('id_inventaris_barang',$id);
        $query = $this->db->get('keu_inventaris');
        if ($query->num_rows() > 0) {
            $harga = $query->row_array();
            $data  = ((isset($harga['nilai_sisa']) || $harga['nilai_sisa']!='') ? $harga['nilai_sisa'] : '0');
        }else{
            $this->db->where('id_inventaris_barang',$id);
            $harga = $this->db->get('get_all_inventaris2')->row_array();    
            $data = ((isset($harga['harga']) || $harga['harga']!='') ? $harga['harga'] : '0');
        }
        
        return $data;   
    }
    function getdatakaunpenyusutan($id=0,$tipe='debit'){
        $this->db->where('id_mst_transaksi',$id);
        $this->db->where('type',$tipe);
        $query = $this->db->get('mst_keu_transaksi_item')->row_array();
        return $query['id_mst_akun'];
    }
    function addInventaris($idtransaksi,$idjenis){
        $db = explode('_tr_',$this->input->post('data_barang'));
        $tempid='';
        $dataid='';
        for($i=0; $i<(count($db))-1; $i++){
           $tempid = $dataid;
           $getdat = $this->namabarang($db[$i]);
           $getharga = $this->hargapenyusutan($db[$i]);
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
                        'id_mst_akun'=>$this->getdatakaunpenyusutan($idjenis,'kredit'),
                        'debet'=>'0',
                        'kredit'=>$getharga,
                        'status'=> 'kredit',
                        'id_keu_transaksi_inventaris'=> $id,
                        );
                $this->db->insert('keu_jurnal',$datakredit);
            $datadebet=array(
                        'id_jurnal'=>$this->idjurnal(),
                        'id_transaksi'=> $idtransaksi,
                        'id_mst_akun'=>$this->getdatakaunpenyusutan($idjenis,'debit'),
                        'debet'=>$getharga,
                        'kredit'=>'0',
                        'status'=> 'debet',
                        'id_keu_transaksi_inventaris'=> $id,
                        );
                $this->db->insert('keu_jurnal',$datadebet);
            $this->updatenilaisisa($db[$i]);
        }
        return $this->getdatajson($dataid);
    }
    function updatenilaisisa($id=0){
        $this->db->where('id_inventaris_barang',$id);
        $this->db->set('nilai_sisa','0');
        $this->db->update('keu_inventaris');

        $this->db->where('id_inventaris_barang',$id);
        $databarang = $this->db->get('get_all_inventaris2')->row_array();

        $this->db->where('id_inventaris_barang',$id);
        $dataakumulasi = $this->db->get('keu_inventaris')->row_array();

        $data = ($this->getakumlasi($id)!=0 ? $this->getakumlasi($id) : $databarang['harga']) - (isset($dataakumulasi['nilai_sisa']) ? $dataakumulasi['nilai_sisa'] : 0);
        $this->db->where('id_inventaris_barang',$id);
        $this->db->set('akumulasi_beban',$data);
        $this->db->update('keu_inventaris');
    }
    function getdatajson($data){
        $getdata = explode("####", $data);
       return $this->get_alldatainventaris($getdata);
    }
    function get_alldatainventaris($id=0){
        $this->db->where_in('id_transaksi_inventaris',$id);
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
   function delete_penyusutan_trans(){
        $this->db->where('id_keu_transaksi_inventaris',$this->input->post('id_transaksi_inv'));
        $this->db->delete('keu_jurnal');

        $this->db->where('id_transaksi_inventaris',$this->input->post('id_transaksi_inv'));
        return $this->db->delete('keu_transaksi_inventaris');

   }
   function ubahdatadetail(){
        $variabel = $this->input->post('dataubah');
        $id_transaksi = $this->input->post('id_transaksi');
        $id_transaksi_inventaris = $this->input->post('idinv');
        $values = $this->input->post('values');
        $table = $this->input->post('table');
        if ($variabel=="periode_penyusutan_awal" || $variabel=="periode_penyusutan_akhir") {
            $pisah = explode('-', $values);
            $values = $pisah[2].'-'.$pisah[1].'-'.$pisah[0];
        }
        $this->db->set($variabel, $values);
        $this->db->where('id_transaksi',$id_transaksi);
        $this->db->where('id_transaksi_inventaris',$id_transaksi_inventaris);
        return $this->db->update($table);
   }
   function getakumlasi($id){
        $this->db->select("sum(kredit) as totalkredit");
        $this->db->where('keu_transaksi_inventaris.id_inventaris',$id);
        $this->db->where('keu_transaksi.tanggal <=',date("Y-m-d"));
        $this->db->where('keu_transaksi.tipe_jurnal','jurnal_penyesuaian');
        $this->db->join('keu_transaksi_inventaris','keu_transaksi_inventaris.id_transaksi=keu_transaksi.id_transaksi','left');
        $this->db->join('keu_jurnal','keu_jurnal.id_keu_transaksi_inventaris=keu_transaksi_inventaris.id_transaksi_inventaris','left');
        $query = $this->db->get('keu_transaksi')->row_array();
        return $query['totalkredit'];
    }
   function ubahnilai_sisa($idinvbarang,$idinv,$variabel,$value,$datatambah){
        $this->db->where('id_inventaris_barang',$idinvbarang);
        $akumulasi=$this->db->get('get_all_inventaris2')->row_array();
        $this->db->where("id_inventaris_barang",$idinvbarang);
        $keu_inv = $this->db->get('keu_inventaris');

        if ($keu_inv->num_rows() > 0) {
            $data = $keu_inv->row_array();

            $harga = (($data['nilai_sisa'] + $datatambah)-$value);
            $hargaakumulasi  = $akumulasi['harga'] - $harga;
            $this->db->set('akumulasi_beban',$hargaakumulasi);
            $this->db->set('nilai_sisa',$harga);
            $this->db->where('id_inventaris_barang',$idinvbarang);
            $this->db->update('keu_inventaris');
        }
   }
   
   function ubahdatadetailtransaksi(){
        $variabel = $this->input->post('dataubah');
        $id_transaksi = $this->input->post('id_transaksi');
        $idjurnal = $this->input->post('idjurnal');
        $values = $this->input->post('values');
        $table = $this->input->post('table');
        $idinv = $this->input->post('idinv');


        if ($variabel=='kredit' || $variabel=='debet') {
            $datatambah = $this->input->post('datatambah');
            $this->db->where('id_transaksi_inventaris',$idinv);
            $this->db->where('id_transaksi',$id_transaksi);
            $dataquery = $this->db->get('keu_transaksi_inventaris')->row_array();
            $this->updatedebitkredit($id_transaksi,$idinv,$variabel,$values);


            $this->ubahnilai_sisa($dataquery['id_inventaris'],$idinv,$variabel,$values,$datatambah);

            
        }
        $this->db->set($variabel, $values);
        $this->db->where('id_transaksi',$id_transaksi);
        $this->db->where('id_jurnal',$idjurnal);
        return $this->db->update($table);
   }
   function updatedebitkredit($id_transaksi=0,$idinv=0,$variabel=0,$values=0){
        $this->db->where('id_transaksi',$id_transaksi);
        $this->db->where('id_keu_transaksi_inventaris',$idinv);
        $query = $this->db->get('keu_jurnal');
        foreach ($query->result() as $key) {
            if ($key->status=='kredit') {
                $this->db->set('kredit',$values);
            }else{
                $this->db->set('debet',$values);
            }
            $this->db->where('id_jurnal',$key->id_jurnal);
            $this->db->update('keu_jurnal');
        }
        return true;
   }
   function gettotaldetail(){
        $variabel = $this->input->post('dataubah');
        $id_transaksi = $this->input->post('id_transaksi');
        $idjurnal = $this->input->post('idjurnal');
        $values = $this->input->post('values');
        $table = $this->input->post('table');
        $this->db->select("sum($variabel) as totaldata,$table.*");
        $this->db->where('id_transaksi',$id_transaksi);
        $this->db->where('id_jurnal',$idjurnal);
        $query = $this->db->get($table)->row_array();
        return 'OK | '.$query['totaldata'].' | '.$query['id_keu_transaksi_inventaris'];
   }
   function updatekembaliuang($id){
        $this->db->where('id_transaksi',$id);
        $this->db->select("keu_transaksi_inventaris.*,(select sum(debet) from  keu_jurnal where id_keu_transaksi_inventaris=keu_transaksi_inventaris.id_transaksi_inventaris) as totaldebet");
        $query = $this->db->get('keu_transaksi_inventaris');
        foreach ($query->result_array() as $key){
            $this->db->select("keu_inventaris.*");
            $this->db->where('id_inventaris_barang',$key['id_inventaris']);
            $dataquery = $this->db->get('keu_inventaris')->row_array();

            $this->db->set('nilai_sisa',isset($dataquery['nilai_sisa']) ? $dataquery['nilai_sisa'] : '0'  + $key['totaldebet']);
            $this->db->where('id_inventaris_barang',$key['id_inventaris']);
            $this->db->update('keu_inventaris');
        }
   }
   function updatesisanilai(){
            $this->db->select("keu_transaksi_inventaris.*,(select sum(debet) from  keu_jurnal where id_keu_transaksi_inventaris=keu_transaksi_inventaris.id_transaksi_inventaris) as totaldebet");
            $this->db->where('id_transaksi_inventaris',$this->input->post('id_transaksi_inv'));
            $dataquery = $this->db->get('keu_transaksi_inventaris')->row_array();

            $this->db->where('id_inventaris_barang',$dataquery['id_inventaris']);
            $query = $this->db->get('keu_inventaris')->row_array();

            $this->db->set('nilai_sisa',$query['nilai_sisa'] + $dataquery['totaldebet']);
            $this->db->where('id_inventaris_barang',$dataquery['id_inventaris']);
            $this->db->update('keu_inventaris');
   }
   function settingconfig(){
        $kodpus=$this->session->userdata('puskesmas');
        $kodedata = $kodpus.date("Y").date('m');
        $id=$kodpus.date("Y").date('m');
        $this->db->like('id_periode',$id,'after');
        $query = $this->db->get('keu_periode');
        if ($query->num_rows < 1) {
            for ($i=0; $i <=11 ; $i++) { 
                $tmp = ((int)$i)+1;
                $nourut = sprintf("%02s", $tmp);
                $data = array(
                    'id_periode'        => $kodedata.date("Y").$nourut,
                    'start'             => date("Y").'-'.$nourut.'-01',
                    'end'               => date("Y").'-'.$nourut.'-'.$this->lastdate((int)$i+1, date("Y")),
                    'status'            => (((int)$i+1 < (int)date("m")) ? 'ditutup' : (((int)$i+1 > (int)date("m")) ? 'belum_berjalan':'berjalan')),
                    'code_cl_phc'       => 'P'.$this->session->userdata('puskesmas'),
                    );
                $this->db->insert('keu_periode',$data);
            }
        }
   }
   function lastdate($bulan, $tahun){
      $tanggal =  date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date($bulan).'/01/'.date($tahun).' 00:00:00'))));
      $tgl = explode("-", $tanggal);
      return $tgl[2];
    }
    function getdataberjalan(){
        $this->db->where('status','berjalan');
        $query = $this->db->get('keu_periode');
        if ($query->num_rows() > 0) {
            $dat = $query->row_array();
            $data = $dat['start'];
        }else{
            $data = '0000-00-00';
        }

        return $data;
    }
    function updatesisanilaidata($id=0){
            $this->db->select("keu_transaksi_inventaris.*,(select sum(debet) from  keu_jurnal where id_keu_transaksi_inventaris=keu_transaksi_inventaris.id_transaksi_inventaris) as totaldebet");
            $this->db->where('id_transaksi_inventaris',$id);
            $dataquery = $this->db->get('keu_transaksi_inventaris')->row_array();

            $this->db->where('id_inventaris_barang',$dataquery['id_inventaris']);
            $query = $this->db->get('keu_inventaris')->row_array();

            $this->db->set('nilai_sisa',$query['nilai_sisa'] + $dataquery['totaldebet']);
            $this->db->where('id_inventaris_barang',$dataquery['id_inventaris']);
            $this->db->update('keu_inventaris');
   }
    function jurnaltutupbuku(){

        $bulan = sprintf("%02s", $this->input->post('bulan'));
        $this->db->where('MONTH(tanggal)',$bulan);
        $this->db->where("YEAR(tanggal)",$this->input->post('tahun'));
        $query = $this->db->get('keu_transaksi')->result_array();
        foreach ($query as $key) {
            if ($key['status']=='disimpan' || $key['status']=='ditutup') {
                $this->db->where('id_transaksi',$key['id_transaksi']);
                $this->db->set('status','ditutup');
                $this->db->update('keu_transaksi');
            }else{
                $this->db->where('id_transaksi',$key['id_transaksi']);
                $dat = $this->db->get('keu_transaksi_inventaris')->row_array();
                $this->updatesisanilaidata($dat['id_inventaris']);

                $this->db->where('id_transaksi',$key['id_transaksi']);
                $this->db->delete('keu_transaksi_inventaris');

                $this->db->where('id_transaksi',$key['id_transaksi']);
                $this->db->delete('keu_jurnal');

                $this->db->where('id_transaksi',$key['id_transaksi']);
                $this->db->delete('keu_transaksi');
            }
        }
        $this->db->set('user_penutup',$this->session->userdata('username'));
        $this->db->set('status','ditutup');
        $this->db->where('MONTH(start)',$bulan);
        $this->db->where("YEAR(start)",$this->input->post('tahun'));
        $this->db->update('keu_periode');

        $bulanbaru = sprintf("%02s", $this->input->post('bulan')+1);
        if ($bulanbaru !='13') {
            $this->db->set('status','berjalan');
            $this->db->where('MONTH(start)',$bulanbaru);
            $this->db->where("YEAR(start)",$this->input->post('tahun'));
            $this->db->update('keu_periode');
        }
        $this->getdataberjalan();
    }
}