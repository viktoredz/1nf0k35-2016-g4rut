<?php
class Penyusutan_model extends CI_Model {

    var $tb    = 'keu_sts';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
    }
    
    function get_data($start=0,$limit=999999,$options=array()){
        $this->db->select("mst_keu_metode_penyusutan.nama as namametode,get_all_inventaris2.id_mst_inv_barang,get_all_inventaris2.register,get_all_inventaris2.id_cl_phc,keu_inventaris.*,get_all_inventaris2.nama_barang,get_all_inventaris2.harga,((get_all_inventaris2.harga) - IFNULL((select sum(debet) from keu_jurnal join keu_transaksi_inventaris on keu_transaksi_inventaris.id_transaksi_inventaris=keu_jurnal.id_keu_transaksi_inventaris where keu_transaksi_inventaris.id_inventaris=keu_inventaris.id_inventaris_barang),0)) as nilai_sekarang",false);
    	$this->db->join('mst_keu_metode_penyusutan','keu_inventaris.id_mst_metode_penyusutan=mst_keu_metode_penyusutan.id_mst_metode_penyusutan','left');
    	$this->db->join('get_all_inventaris2','get_all_inventaris2.id_inventaris_barang=keu_inventaris.id_inventaris_barang','left');
        return $this->db->get('keu_inventaris',$limit,$start)->result();
    }
    function get_dataedit($start=0,$limit=999999,$options=array()){
    	$this->db->select("get_all_inventaris2.id_mst_inv_barang,get_all_inventaris2.register,get_all_inventaris2.id_cl_phc,keu_inventaris.*,get_all_inventaris2.nama_barang,get_all_inventaris2.harga,mst_keu_akun.kode as kodeakun,mst_keu_akun.uraian as namaakun,akunakumulasi.kode as kodeakumulasi,akunakumulasi.uraian as namaakumulasi,mst_keu_metode_penyusutan.nama as namapenyusutan ");
    	$this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun = keu_inventaris.id_mst_akun','left');
    	$this->db->join('mst_keu_akun akunakumulasi','akunakumulasi.id_mst_akun = keu_inventaris.id_mst_akun_akumulasi','left');
    	$this->db->join('mst_keu_metode_penyusutan','keu_inventaris.id_mst_metode_penyusutan=mst_keu_metode_penyusutan.id_mst_metode_penyusutan','left');
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
    function addstepsatu(){
    	$datainv    = explode('_tr_', $this->input->post('dataceklis'));
    	$id_invbaru = '';
    	for ($i=0; $i <=count($datainv)-2 ; $i++) { 
    		$data = $id_invbaru;
            $akumulasidata= $this->getakumlasi($datainv[$i]);
            $hargabarang = $this->getharga($datainv[$i]);
    		$datasave = array(
    		'id_inventaris'			=> $this->idinventaris(),
    		'id_inventaris_barang'	=> $datainv[$i],
    		'id_mst_akun'			=> '124',
    		'id_mst_akun_akumulasi'		=> '251',
    		'akumulasi_beban'			=> $akumulasidata,
    		'nilai_ekonomis'			=> '0',
    		'nilai_sisa'				=> $hargabarang-$akumulasidata,
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
            $dataakumulasi = $this->input->post("id_mst_akun_akumulasi$i");
            if ($dataakumulasi=='5') {
                $this->db->set('nilai_ekonomis','0');
            }else{
                $this->db->set('nilai_ekonomis',$this->input->post("nilai_ekonomis$i"));
            }
            if ($dataakumulasi=='5' || $dataakumulasi=='6' || $dataakumulasi=='3') {
                $this->db->set('nilai_sisa','0');
            }else{
                $this->db->set('nilai_sisa',$this->input->post("nilai_sisa$i"));
            }
            $this->db->where('id_inventaris',$this->input->post("id_inventaris$i"));
            $this->db->set('id_mst_akun',$this->input->post("id_mst_akun$i"));
            $this->db->set('id_mst_akun_akumulasi',$this->input->post("id_mst_akun_akumulasi$i"));
            $this->db->set('id_mst_metode_penyusutan',$this->input->post("id_mst_metode_penyusutan$i"));

    		$this->db->update('keu_inventaris');
    		$id_invbaru = $this->input->post("id_inventaris$i").'_tr_'.$data;
    		$uraian = $this->input->post("nama_barang$i").' & '.$datauraian;
    	}
    	$kodpus='P'.$this->session->userdata('puskesmas');
    	$datatransaksi = array(
    			'id_transaksi'				=> $this->idtransaksi(),
    			'tanggal'					=> date("Y-m-d"),
    			'uraian'					=> $uraian,
    			'status'					=> 'disimpan',
    			'tipe_jurnal'				=> 'jurnal_umum',
    			'code_cl_phc'				=> $kodpus,
    			);
    	$this->db->insert('keu_transaksi',$datatransaksi);
    	for ($x=1; $x <=$jmldata ; $x++) { 
            $harga = $this->getharga($this->input->post("id_inventaris_barang$x"));
            $pilihmetod = $this->input->post("id_mst_akun_akumulasi$i");
            if ($pilihmetod=='5' || $pilihmetod=='6' || $pilihmetod=='3') {
                $hargadaftar = $harga;
            }else{
                $hargadaftar = $this->input->post("nilai_sisa$x");
            }
    		$datatransaksi = array(
    			'id_jurnal'				=> $this->idjurnal(),
    			'id_transaksi'			=> $datatransaksi['id_transaksi'],
    			'id_mst_akun'			=> $this->input->post("id_mst_akun$x"),
    			'debet'					=> $hargadaftar,
    			'kredit'				=> '0',
    			'status'				=> 'debet',
    			);
    		$this->db->insert('keu_jurnal',$datatransaksi);
    	}
        $datakredittransaksi = array(
                'id_jurnal'             => $this->idjurnal(),
                'id_transaksi'          => $datatransaksi['id_transaksi'],
                'id_mst_akun'           => '9',
                'debet'                 => '0',
                'kredit'                => $this->jumlahtotal($datatransaksi['id_transaksi']),
                'status'                => 'kredit',
                );
        $this->db->insert('keu_jurnal',$datakredittransaksi);
    	return $datatransaksi['id_transaksi'];
    }
    function jumlahtotal($id=0){
        $this->db->select("sum(debet) as total");
        $this->db->where("id_transaksi",$id);
        $query = $this->db->get("keu_jurnal")->row_array();
        return $query['total'];
    }
    function simpandatatransaksi(){
        $datawhere = array(
            'id_transaksi' => $this->input->post('id_transaksi'),
            );
        $tgl = explode('-', $this->input->post('tanggal'));
        $data=array(
            'tanggal' => $tgl[2].'-'.$tgl[1].'-'.$tgl[0],
            'uraian' => $this->input->post('uraian'),
            );
        $this->db->update('keu_transaksi',$data,$datawhere);
        $wherejurnal = array('id_jurnal'             => $this->input->post('id_jurnalkredit'));
        $datajurnal=array(
            'id_transaksi'          => $this->input->post('id_transaksi'),
            'id_mst_akun'           => $this->input->post("akunkredit"),
            'debet'                 => '0',
            'kredit'                => $this->input->post("jumlahtotal"),
            'status'                => 'kredit',
            );
         return  $this->db->update('keu_jurnal',$datajurnal,$wherejurnal);
    }
    function idtransaksi(){
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
    function getharga($id=0){
    	$this->db->where('id_inventaris_barang',$id);
    	$query = $this->db->get('get_all_inventaris2')->row_array();
    	return $query['harga'];
    }
     function idinventaris($id='0'){
        $kodpus=$this->session->userdata('puskesmas');
        $kodedata =$kodpus.date("Y").date('m');
        $q = $this->db->query("select RIGHT(MAX(id_inventaris),4) as kd_max from keu_inventaris  where id_inventaris like "."'".$kodedata."%'"."");
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
    function getallmetodepenyusustan(){
    	return $this->db->get('mst_keu_metode_penyusutan')->result_array();
    }
    function getdatajurnal($id){
    	$this->db->select("keu_jurnal.*,mst_keu_akun.kode,mst_keu_akun.uraian as namaakun");
    	$this->db->where('id_transaksi',$id);
        $this->db->where('status','debet');
    	$this->db->join('mst_keu_akun','keu_jurnal.id_mst_akun=mst_keu_akun.id_mst_akun','left');
    	return $this->db->get('keu_jurnal')->result();
    }
    function gettransaksi($id){
    	$this->db->where('id_transaksi',$id);
    	$this->db->select("keu_transaksi.*,keu_transaksi.uraian as namauraian,(select sum(debet) from keu_jurnal where id_transaksi=keu_transaksi.id_transaksi) as jumlahtotal,(select kredit from keu_jurnal where id_transaksi=keu_transaksi.id_transaksi AND keu_jurnal.status='kredit') as kredittot,(select id_mst_akun from keu_jurnal where id_transaksi=keu_transaksi.id_transaksi AND keu_jurnal.status='kredit') as idakunkredittotal,(select id_jurnal from keu_jurnal where id_transaksi=keu_transaksi.id_transaksi AND keu_jurnal.status='kredit') as id_jurnalkredit",false);
    	return $this->db->get('keu_transaksi')->row_array();	
    }
    
    function updatedata(){
        $idakun =$this->input->post('idakun');
        $id_inventaris =$this->input->post('idinventaris');
        
        $this->db->set('id_mst_akun',$idakun);
        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->update('keu_inventaris');
    }
    function updatedataakumulasi(){
        $idakun =$this->input->post('idakunakumulasi');
        $id_inventaris =$this->input->post('idinventarisdata');
        $this->db->set('id_mst_akun_akumulasi',$idakun);
        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->update('keu_inventaris');
    }
    function updatedatapenyusutan(){
        $idakun =$this->input->post('idakunpenyusutan');
        $id_inventaris =$this->input->post('idinventarispenyusutan');
        $this->db->set('id_mst_metode_penyusutan',$idakun);
        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->update('keu_inventaris');
    }
    function updatedatanilaiekonomis(){
        $nilaiekonomis =$this->input->post('nilaiekonomis');
        $id_inventaris =$this->input->post('id_inventaris');
        $this->db->set('nilai_ekonomis',$nilaiekonomis);
        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->update('keu_inventaris');
    }
    function updatedatanilaisisa(){
        $nilaisisa =$this->input->post('nilaisisa');
        $id_inventaris =$this->input->post('id_inventaris');
        $this->db->set('nilai_sisa',$nilaisisa);
        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->update('keu_inventaris');
    }
    function delete_data($id_inventaris){
        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->delete('keu_inventaris');
    }

    function get_edit_row($id){
        $this->db->select("get_all_inventaris2.id_mst_inv_barang,get_all_inventaris2.tanggal_pembelian,get_all_inventaris2.register,get_all_inventaris2.id_cl_phc,keu_inventaris.*,get_all_inventaris2.nama_barang,get_all_inventaris2.harga,mst_keu_akun.kode as kodeakun,mst_keu_akun.uraian as namaakun,akunakumulasi.kode as kodeakumulasi,akunakumulasi.uraian as namaakumulasi,mst_keu_metode_penyusutan.nama as namapenyusutan,(IFNULL((select sum(debet) from keu_jurnal join keu_transaksi_inventaris ab on ab.id_transaksi_inventaris=keu_jurnal.id_keu_transaksi_inventaris where ab.id_inventaris=keu_inventaris.id_inventaris_barang),0)) as totaldebetkredit");
        $this->db->join('mst_keu_metode_penyusutan','mst_keu_metode_penyusutan.id_mst_metode_penyusutan = keu_inventaris.id_mst_metode_penyusutan','left');
        $this->db->join('mst_keu_akun','mst_keu_akun.id_mst_akun = keu_inventaris.id_mst_akun','left');
        $this->db->join('mst_keu_akun akunakumulasi','akunakumulasi.id_mst_akun = keu_inventaris.id_mst_akun_akumulasi','left');
        $this->db->join('get_all_inventaris2','get_all_inventaris2.id_inventaris_barang=keu_inventaris.id_inventaris_barang','left');
        $this->db->where('id_inventaris',$id);
        return $this->db->get('keu_inventaris')->row_array();
    }
    function editpenyusutan(){
        $id_inventaris = $this->input->post('id_inventaris');
        $id_mst_akun = $this->input->post('id_mst_akun');
        $id_mst_akun_akumulasi = $this->input->post('id_mst_akun_akumulasi');
        $id_mst_metode_penyusutan = $this->input->post('id_mst_metode_penyusutan');
        $nilai_ekonomis = $this->input->post('nilai_ekonomis');
        $nilai_sisa = $this->input->post('nilai_sisa');

        $this->db->where('id_inventaris',$id_inventaris);
        $this->db->set('id_mst_akun',$id_mst_akun);
        $this->db->set('id_mst_akun_akumulasi',$id_mst_akun_akumulasi);
        $this->db->set('id_mst_metode_penyusutan',$id_mst_metode_penyusutan);
        if ($id_mst_metode_penyusutan!='5') {
            $this->db->set('nilai_ekonomis',$nilai_ekonomis);
        }else{
            $this->db->set('nilai_ekonomis','0');
        }
        if ($id_mst_metode_penyusutan=='5' ||$id_mst_metode_penyusutan=='6'|| $id_mst_metode_penyusutan=='3') {
            $this->db->set('nilai_sisa','0');
        }else{
            $this->db->set('nilai_sisa',$nilai_sisa);
        }
        return $this->db->update('keu_inventaris');
    }
    function get_dataallinv($id,$start=0,$limit=999999,$options=array()){
        $this->db->select("keu_transaksi_inventaris.*,keu_transaksi.tanggal,keu_transaksi.id_kategori_transaksi,keu_transaksi.code_cl_phc,keu_transaksi.id_mst_keu_transaksi,(select debet from keu_jurnal where id_keu_transaksi_inventaris=keu_transaksi_inventaris.id_transaksi_inventaris and status='debet')as debet,(select kredit from keu_jurnal where id_keu_transaksi_inventaris=keu_transaksi_inventaris.id_transaksi_inventaris and status='kredit')as kredit",false);
        $this->db->where("keu_transaksi_inventaris.id_inventaris",$id);
        $this->db->where("keu_transaksi.tipe_jurnal",'jurnal_penyesuaian');
        $this->db->join("keu_transaksi_inventaris","keu_transaksi_inventaris.id_transaksi=keu_transaksi.id_transaksi",'left');
        return $this->db->get('keu_transaksi',$limit,$start)->result();
    }
}