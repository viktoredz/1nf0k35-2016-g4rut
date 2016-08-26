
<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<div id="popup_jurum_instansi" style="display:none">
  <div id="popup_title">Tambah Instansi</div>
  <div id="popup_content_jurum_instansi">&nbsp;</div>
</div>
<div class="box-body">
<form action="<?php echo base_url()?>keuangan/jurnal/$action" method="post">
  <div class="box box-primary">
    <div class="box-body">
      <div class="row pull-right">
        <div class="box-body">
          <button type="reset" id="btn-reset_jurum" class="btn btn-success"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
          <button type="button" id="btn-simpan_jurum" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Simpan</button>
          <button type="button" id="btn-draf_jurum" class="btn btn-info"><i class="glyphicon glyphicon-floppy-save"></i> Simpan Sebagai Draf</button>
          <button type="button" id="btn-delete_jurum" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
          <button type="button" id="btn-close_jurum" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
        </div>
      </div>
        <div class="box-body">
          <h3>{sub_title}</h3>
          <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jenis Transaksi</div>
          <div class="col-md-9">
            <input type="text" id="status" name="status" placeholder="Jenis Transaksi"  class="form-control" value="<?php 
              if(set_value('status')=="" && isset($status)){
                echo $status;
              }else{
                echo  set_value('status');
              }
              ?>" />
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kategori</div>
          <div class="col-md-9">
            <input type="text" id="kategori_transaksi" name="kategori_transaksi" placeholder="Kategori"  class="form-control" value="<?php 
              if(set_value('kategori_transaksi')=="" && isset($kategori_transaksi)){
                echo $kategori_transaksi;
              }else{
                echo  set_value('kategori_transaksi');
              }
              ?>" />
          </div>
        </div>
        <!--<div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Alasan Perubahan</div>
          <div class="col-md-9">
            <textarea id="alasan_perubahan" name="alasan_perubahan" class="form-control"><?php 
             /* if(set_value('alasan_perubahan')=="" && isset($alasan_perubahan)){
                echo $alasan_perubahan;
              }else{
                echo  set_value('nomor_balasan_perubahanukti_kas');
              }*/
              ?></textarea> 
          </div>
        </div>-->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Dasar</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-9">
            <input type="text" id="id_transaksi" name="id_transaksi" placeholder="Nomor Transaksi"  class="form-control" value="<?php 
              if(set_value('id_transaksi')=="" && isset($id_transaksi)){
                echo substr($id_transaksi, -10);
              }else{
                echo  set_value('id_transaksi');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Uraian</div>
          <div class="col-md-9">
            <input type="text" id="uraian" name="uraian" placeholder="Uraian"  class="form-control" value="<?php 
              if(set_value('uraian')=="" && isset($uraian)){
                echo $uraian;
              }else{
                echo  set_value('uraian');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Tanggal Transaksi</div>
          <div class="col-md-9">
            <div type="text" id="tgl_transaksi" name="tgl_transaksi" value="<?php 
            if(set_value('tgl_transaksi')=="" && isset($tanggal)){
                echo $tanggal;
              }else{
                echo  set_value('tgl_transaksi');
              }
            ?>"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Jurnal Transaksi</h3></div>
        </div>
        <!--
        ini create
        -->
        <div id="jurnal_transaksi" class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-5">
                  <div class="box-header">
                    <h3 class="box-title">Nama Akun</h3>
                  </div>
                </div>
                <div class="col-md-3">
                  Debit
                </div>
                <div class="col-md-3">
                  Kredit
                </div>
              </div>
            </div>
            <div id='jurnaltrasaksidata'>
            <?php $i=1; foreach($getdebitkredit as $jt) { 
            ?>
            <div id="jurnaltrasaksi-<?php echo $jt->id_transaksi.$jt->id_jurnal; ?>" name="jurnaltrasaksi-<?php echo $jt->id_transaksi.$jt->id_jurnal; ?>">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-1" style="padding:5px">
                    <?php if ($jt->kredit!='0') { ?>
                    <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi" name="create_jurnal_transaksi" onclick='add_jurnaltransaksi("<?php echo $jt->id_transaksi;?>","<?php echo $jt->id_jurnal; ?>")'></a>
                    <?php } ?>
                    <?php if ($jt->kredit!='0') { ?>
                    <a class="glyphicon glyphicon-trash" id="delete_jurnal_transaksi" name="delete_jurnal_transaksi" onclick='delete_jurnaltransaksi("<?php echo $jt->id_transaksi;?>","<?php echo $jt->id_jurnal; ?>")'></a>
                    <?php } ?>
                  </div>
                  <div class="col-md-5">
                      <select id="id_mst_akun" class="form-control" name="id_mst_akun">
                        <?php foreach ($getdataakun as $dataakun) { 
                          $select = ($dataakun->kode == $jt->id_mst_akun ? "selected" :'');
                        ?>
                          <option value="<?php echo $dataakun->kode?>" <?php echo $select;?>><?php echo $dataakun->uraian?></option>
                        <?php } ?>
                      </select>
                  </div>
                  <div class="col-md-3">
                    <?php if ($jt->debet !='0') { ?>
                    <input type="text" id="debit" name="debit" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit')=="" && isset($jt->debet)){
                          echo $jt->debet;
                        }else{
                          echo  set_value('debit');
                        }
                        ?>" />
                    <?php } ?>
                  </div>
                  <div class="col-md-3">
                    <?php if ($jt->kredit !='0') { ?>
                    <input type="text" id="debit_akun" name="debit_akun" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit_akun')=="" && isset($jt->kredit)){
                          echo $jt->kredit;
                        }else{
                          echo  set_value('debit_akun');
                        }
                        ?>" />
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php $i++; } ?>
            </div>
          </div>
        </div>
        <!--End create -->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Tambahan</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Syarat Pembayaran</div>
          <div class="col-md-9">
            <select type="text" id="syarat_pem" name="syarat_pem" class="form-control">
              <?php foreach ($getsyarat as $key) { ?>
                <option value="<?php echo $key->id_mst_syarat_pembayaran; ?>" ><?php echo $key->nama.' - '.$key->deskripsi; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jatuh Tempo</div>
          <div class="col-md-9">
            <!-- <div type="text" id="tgl_transaksi" name="tgl_transaksi" placeholder="Tanggal Transaksi" /></div> -->
            <div id='tgl_jatuhtempo' name="tgl_jatuhtempo" value="<?php
                if(set_value('tgl_jatuhtempo')=="" && isset($jatuh_tempo)){
                  $tgl_tempo = strtotime($jatuh_tempo);
                }else{
                  $tgl_tempo = strtotime(set_value('tgl_jatuhtempo'));
                }
                if($tgl_tempo=="") $tgl_tempo = time();
                echo date("Y-m-d",$tgl_tempo);
              ?>" >
              </div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Faktur</div>
          <div class="col-md-9">
            <input type="text" id="nomor_faktur" name="nomor_faktur" placeholder="Nomor Faktur"  class="form-control" value="<?php 
              if(set_value('nomor_faktur')=="" && isset($nomor_faktur)){
                echo $nomor_faktur;
              }else{
                echo  set_value('nomor_faktur');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Bukti Kas</div>
          <div class="col-md-9">
            <input type="text" id="bukti_kas" name="bukti_kas" placeholder="Nomor Bukti Kas"  class="form-control" value="<?php 
              if(set_value('bukti_kas')=="" && isset($bukti_kas)){
                echo $bukti_kas;
              }else{
                echo  set_value('bukti_kas');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Instansi</div>
          <div class="col-md-7">
            <input type="text" id="instansi" name="instansi" placeholder="Instansi"  class="form-control" value="<?php 
              if(set_value('instansi')=="" && isset($instansi)){
                echo $instansi;
              }else{
                echo  set_value('instansi');
              }
              ?>" />
          </div>
          <div class="col-md-1"><button id="tambahinstansi" type="button" class="btn btn-default btn-success">Tambahkan</button></div>
        </div>
         <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Lampiran</div>
          <div class="col-md-9">
            <input type="file" id="lampiran" name="lampiran" value="Upload" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Keterangan</div>
          <div class="col-md-9">
            <textarea id="keterangan" name="keterangan" class="form-control"><?php 
              if(set_value('keterangan')=="" && isset($keterangan)){
                echo $keterangan;
              }else{
                echo  set_value('keterangan');
              }
              ?></textarea> 
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Data Pendukung</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kode Kegiatan</div>
          <div class="col-md-9">
            <input type="text" id="kode_kegiatan" name="kode_kegiatan" placeholder="Kode Kegiatan"  class="form-control" value="<?php 
              if(set_value('kode_kegiatan')=="" && isset($kode_kegiatan)){
                echo $kode_kegiatan;
              }else{
                echo  set_value('kode_kegiatan');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Sub Kegiatan</div>
          <div class="col-md-9">
            <input type="text" id="subkegiatan" name="subkegiatan" placeholder="Sub Kegiatan"  class="form-control" value="<?php 
              if(set_value('subkegiatan')=="" && isset($subkegiatan)){
                echo $subkegiatan;
              }else{
                echo  set_value('subkegiatan');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jenis Belaja</div>
          <div class="col-md-9">
            <input type="text" id="jns_belanja" name="jns_belanja" placeholder="Jenis Belanja"  class="form-control" value="<?php 
              if(set_value('jns_belanja')=="" && isset($jns_belanja)){
                echo $jns_belanja;
              }else{
                echo  set_value('jns_belanja');
              }
              ?>" />
          </div>
        </div>

      </div>
    </div>
  </div>
</form>        
</div>
<script type="text/javascript">
$(function(){
  $('#btn-close_jurum').click(function(){
      window.location.href="<?php echo base_url()?>keuangan/jurnal";
  });

 
  $("#tgl_transaksi").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  $("#tgl_jatuhtempo").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
});
$("#instansi").jqxInput(
    {
    width: '100%',
    height: '30px',
    minLength: 2,
    source: function (query, response) {
      var dataAdapter = new $.jqx.dataAdapter
      (
        {
          datatype: "json",
            datafields: [
            { name: 'nama_instansi', type: 'string'}
          ],
          url: '<?php echo base_url().'keuangan/jurnal/autocomplite_instansi'; ?>'
        },
        {
          autoBind: true,
          formatData: function (data) {
            data.query = query;
            return data;
          },
          loadComplete: function (data) {
            if (data.length > 0) {
              response($.map(data, function (item) {
                return item.nama_instansi;
              }));
            }
          }
        });
    }
});
$("#tambahinstansi").click(function(){
  $("#popup_jurum_instansi #popup_content_jurum_instansi").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/add_instansi/'; ?>", function(data) {
    $("#popup_content_jurum_instansi").html(data);
  });
  $("#popup_jurum_instansi").jqxWindow({
    theme: theme, resizable: false,
    width: 450,
    height: 500,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurum_instansi").jqxWindow('open');
});

function add_jurnaltransaksi(id_transaksi,id_jurnal){
      var data = new FormData();
      data.append('id_transaksi', id_transaksi);
      data.append('id_jurnal',    id_jurnal);

      $.ajax({
       cache : false,
       contentType : false,
       processData : false,
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/add_kredit/" ?>',
       data : data,
       success: function (response) {
        a = response.split("|");
          if(a[0]=="OK"){
        var form_debit = '<div id="jurnaltrasaksi-'+a[1]+a[2]+'" name="jurnaltrasaksi-'+a[1]+a[2]+'">\
              <div class="box-body">\
                <div class="row">\
                  <div class="col-md-1" style="padding:5px">\
                    <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi" name="create_jurnal_transaksi" onclick="add_jurnaltransaksi(\''+a[1]+'\',\''+a[2]+'\')"></a>\
                    <a class="glyphicon glyphicon-trash" id="delete_jurnal_transaksi" name="delete_jurnal_transaksi" onclick="delete_jurnaltransaksi(\''+a[1]+'\',\''+a[2]+'\')"></a>\
                  </div>\
                  <div class="col-md-5">\
                      <select id="id_mst_akun" class="form-control" name="id_mst_akun">\
                        <?php foreach ($getdataakun as $dataakun) { ?>\
                          <option value="<?php echo $dataakun->kode?>" <?php echo $select;?>><?php echo $dataakun->uraian?></option>\
                        <?php } ?>\
                      </select>\
                  </div>\
                  <div class="col-md-3">\
                  </div>\
                  <div class="col-md-3">\
                    <input type="text" id="debit_akun" name="debit_akun" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit_akun')=="" && isset($jt->kredit)){
                          echo $jt->kredit;
                        }else{
                          echo  set_value('debit_akun');
                        }
                        ?>" />\
                  </div>\
                </div>\
              </div>\
            </div>';

            $('#jurnaltrasaksidata').append(form_debit);
        }else{
            alert("Failed.");
        }
       }
    });
}
function delete_jurnaltransaksi(id_transaksi,id_jurnal) {
  if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/deletekredit" ?>',
       data : 'id_transaksi='+id_transaksi+'&id_jurnal='+id_jurnal,
       success: function (response) {
        res = response.split("|");
        if(res[0]=="OK"){
            $("#jurnaltrasaksi-"+id_transaksi+id_jurnal).remove();
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}
</script>
