<?php
class Kepegawaian_model extends CI_Model {

    var $tabel    = '';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    function get_datapegawai()
    {
    	$puskes = 'P'.$this->session->userdata('puskesmas');
    	$this->db->where('code_cl_phc',$puskes);
    	$this->db->select("COUNT(*) as total",false);
    	$query = $this->db->get('pegawai');
    	return $query->result();
    }
    function get_datapegawaipns(){
    	$puskes = 'P'.$this->session->userdata('puskesmas');
    	$this->db->where('code_cl_phc',$puskes);
    	$this->db->select("count(*) as pns");
    	$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, status, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat","pangkat.id_pegawai = pegawai.id_pegawai and status='PNS'");
        $query = $this->db->get('pegawai');
    	return $query->result();
    }
    function get_datapegawainonpns(){
    	$puskes = 'P'.$this->session->userdata('puskesmas');
    	$this->db->where('code_cl_phc',$puskes);
    	$this->db->select("count(*) as nonpns");
    	$this->db->join("(SELECT  id_pegawai, nip_nit, tmt,id_mst_peg_golruang, masa_krj_bln, masa_krj_thn, status, CONCAT(tmt, id_pegawai) AS pangkatterakhir FROM
        pegawai_pangkat WHERE CONCAT(tmt, id_pegawai) IN (SELECT  CONCAT(MAX(tmt), id_pegawai) FROM pegawai_pangkat GROUP BY id_pegawai)) pangkat","pangkat.id_pegawai = pegawai.id_pegawai and status!='PNS'");
        $query = $this->db->get('pegawai');
    	return $query->result();	
    }
    function get_jum_jenisklmin_pegawai(){
    	$puskes = 'P'.$this->session->userdata('puskesmas');
    	$this->db->where('code_cl_phc',$puskes);
    	$this->db->select("COUNT(*) as jmlklmin,jenis_kelamin as kelamin,code_cl_phc as id_cl_phc");
    	$this->db->group_by('jenis_kelamin');
    	$query = $this->db->get('pegawai');
    	return $query->result();
    }
    function get_jum_pendidikanpegawai(){
    	$puskes = 'P'.$this->session->userdata('puskesmas');
    	$this->db->where('code_cl_phc',$puskes);
    	$this->db->select("mst_peg_tingkatpendidikan.deskripsi,COUNT(*) AS total");
    	$this->db->join("(SELECT  id_pegawai,id_mst_peg_jurusan,sekolah_nama, CONCAT(ijazah_tgl, id_pegawai) AS lulusterakhir FROM
        pegawai_pendidikan WHERE CONCAT(ijazah_tgl, id_pegawai) IN 
        (SELECT  CONCAT(MAX(ijazah_tgl), id_pegawai) FROM pegawai_pendidikan GROUP BY id_pegawai)) pendidikan","pendidikan.id_pegawai = pegawai.id_pegawai",'LEFT');
        $this->db->join("mst_peg_jurusan","id_jurusan = pendidikan.id_mst_peg_jurusan",'LEFT');
        $this->db->join("mst_peg_tingkatpendidikan","id_tingkat = mst_peg_jurusan.id_mst_peg_tingkatpendidikan",'LEFT');
        $this->db->group_by("mst_peg_tingkatpendidikan.id_tingkat");
        $query = $this->db->get('pegawai');
    	return $query->result();	
    }
}