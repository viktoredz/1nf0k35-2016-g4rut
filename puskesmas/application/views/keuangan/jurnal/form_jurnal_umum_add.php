<script type="text/javascript">
  $("[name='create_jurnal_transaksi_debet']").show();
  $("[name='delete_jurnal_transaksi_debet']").show();
  $("[name='create_jurnal_transaksi_kredit']").show();
  $("[name='delete_jurnal_transaksi_kredit']").show();
</script>
<?php 
if($alert_form!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <div id="showmessgt"></div>
  <?php echo $alert_form;?>
</div>
<?php } ?>

<div class="box-body">
<div id="error_mssg">
  <button aria-hidden="true"  id="btncls" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <div id="mssgerr"></div>
</div>
</div>
<div id="popup_jurum_instansi" style="display:none">
  <div id="popup_title">Tambah Instansi</div>
  <div id="popup_content_jurum_instansi">&nbsp;</div>
</div>

<div class="box-body">
<form action="<?php echo base_url()?>keuangan/jurnal/$action" method="post" enctype="multipart/form-data">
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
              <select id="jenistransaksi" name="jenistransaksi"  class="form-control">
                <?php 
                if (isset($id_mst_keu_transaksi)) {
                  $id_mst_keu_transaksi = $id_mst_keu_transaksi;
                }else{
                  $id_mst_keu_transaksi = $id_mst_transaksi;
                }
                foreach ($filetransaksi as $datjentrans) { 
                  $select = $datjentrans->id_mst_transaksi==$id_mst_keu_transaksi ? 'selected' :'';
                ?>
                  <option value="<?php echo $datjentrans->id_mst_transaksi;?>" <?php echo $select;?>><?php echo $datjentrans->nama;?></option>
                <?php } ?>
              </select>
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kategori</div>
          <div class="col-md-9">
              <select id="kategori_transaksi" name="kategori_transaksi"  class="form-control">
                <?php foreach ($filterkategori_transaksi as $key) { 
                  $select = $key->id_mst_kategori_transaksi==$id_kategori_transaksi ? 'selected' :'';
                ?>
                  <option value="<?php echo $key->id_mst_kategori_transaksi;?>" <?php echo $select;?>><?php echo $key->nama;?></option>
                <?php } ?>
              </select>
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
            <div id='jurnaltrasaksidata_debet'>
              <?php foreach ($getdebit as $keydebet) { ?>
                <div id="jurnaltrasaksi_debet-<?php echo $keydebet->id_jurnal; ?>" name="jurnaltrasaksi_debet-<?php echo $keydebet->id_transaksi; ?>">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-1" style="padding:5px">
                        <?php if (count($getkredit) >='2') { ?>
                          <script type="text/javascript">
                            $("#create_jurnal_transaksi_debet<?php echo $keydebet->id_jurnal;?>").hide();
                            $("#delete_jurnal_transaksi_debet<?php echo $keydebet->id_jurnal;?>").hide();
                          </script>
                        <?php } ?>
                        <?php if (count($getdebit) =='1') { ?>
                          <script type="text/javascript">
                            $("#delete_jurnal_transaksi_debet<?php echo $keydebet->id_jurnal;?>").hide();
                          </script>
                        <?php } ?>
                        <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi_debet<?php echo $keydebet->id_jurnal;?>" name="create_jurnal_transaksi_debet" onclick='add_jurnaltransaksi("<?php echo $keydebet->id_transaksi;?>","<?php echo $keydebet->id_jurnal; ?>","debet")'></a>
                        <a class="glyphicon glyphicon-trash" id="delete_jurnal_transaksi_debet<?php echo $keydebet->id_jurnal;?>" name="delete_jurnal_transaksi_debet" onclick='delete_jurnaltransaksi("<?php echo $keydebet->id_transaksi;?>","<?php echo $keydebet->id_jurnal; ?>","debet")'></a>
                      </div>
                      <div class="col-md-5">
                          <select onchange='selectnamaakun("<?php echo $keydebet->id_jurnal;?>","debet")' id="id_mst_akun_debet<?php echo $keydebet->id_jurnal;?>" class="form-control" name="id_mst_akun_debet">
                            <?php foreach ($getdataakun as $dataakun) { 
                              $select = ($dataakun->kode == $keydebet->id_mst_akun ? "selected" :'');
                            ?>
                              <option value="<?php echo $dataakun->kode?>" <?php echo $select;?>><?php echo $dataakun->uraian?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-3">
                        <input  onchange='inputvalueakunas("<?php echo $keydebet->id_jurnal;?>","debet")' type="text" id="debit_debet<?php echo $keydebet->id_jurnal;?>" name="debit_debet" placeholder="Debit Akun"  class="form-control" value="<?php 
                            if(set_value('debit_debet')=="" && isset($keydebet->debet)){
                              echo $keydebet->debet;
                            }else{
                              echo  set_value('debit_debet');
                            }
                            ?>" />
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
            <div id='jurnaltrasaksidata_kredit'>
              <?php foreach ($getkredit as $keykredit) { ?>
                <div id="jurnaltrasaksi_kredit-<?php echo $keykredit->id_jurnal; ?>" name="jurnaltrasaksi_kredit-<?php echo $keykredit->id_transaksi; ?>">
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-1" style="padding:5px">
                        <?php if (count($getdebit) >='2' ) { ?>
                          <script type="text/javascript">
                            $("#create_jurnal_transaksi_kredit<?php echo $keykredit->id_jurnal;?>").hide();  
                            $("#delete_jurnal_transaksi_kredit<?php echo $keykredit->id_jurnal;?>").hide();
                          </script>
                        <?php } ?>
                        <?php if (count($getkredit) =='1') { ?>
                          <script type="text/javascript">
                            $("#delete_jurnal_transaksi_kredit<?php echo $keykredit->id_jurnal;?>").hide();
                          </script>
                        <?php } ?>  
                        <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi_kredit<?php echo $keykredit->id_jurnal;?>" name="create_jurnal_transaksi_kredit" onclick='add_jurnaltransaksi("<?php echo $keykredit->id_transaksi;?>","<?php echo $keykredit->id_jurnal; ?>","kredit")'></a>
                        <a class="glyphicon glyphicon-trash" id="delete_jurnal_transaksi_kredit<?php echo $keykredit->id_jurnal;?>" name="delete_jurnal_transaksi_kredit" onclick='delete_jurnaltransaksi("<?php echo $keykredit->id_transaksi;?>","<?php echo $keykredit->id_jurnal; ?>","kredit")'></a>
                      </div>
                      <div class="col-md-5">
                          <select onchange='selectnamaakun("<?php echo $keykredit->id_jurnal;?>","kredit")' id="id_mst_akun_kredit<?php echo $keykredit->id_jurnal;?>" class="form-control" name="id_mst_akun_kredit">
                            <?php foreach ($getdataakun as $dataakun) { 
                              $select = ($dataakun->kode == $keykredit->id_mst_akun ? "selected" :'');
                            ?>
                              <option value="<?php echo $dataakun->kode?>" <?php echo $select;?>><?php echo $dataakun->uraian?></option>
                            <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-3">
                        <input onchange='inputvalueakunas("<?php echo $keykredit->id_jurnal;?>","kredit")' type="text" id="debit_akun_kredit<?php echo $keykredit->id_jurnal;?>" name="debit_akun_kredit" placeholder="Debit Akun"  class="form-control" value="<?php 
                            if(set_value('debit_akun_kredit')=="" && isset($keykredit->kredit)){
                              echo $keykredit->kredit;
                            }else{
                              echo  set_value('debit_akun_kredit');
                            }
                            ?>" />
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
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
              <input type="hidden" id="id_instansi" name="id_instansi" placeholder="Instansi"  class="form-control" value="<?php 
              if(set_value('id_instansi')=="" && isset($id_instansi)){
                echo $id_instansi;
              }else{
                echo  set_value('id_instansi');
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
  $("#error_mssg").hide();
 
  $("#tgl_transaksi").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  $("#tgl_jatuhtempo").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
});
$("#btncls").click(function(){
  $("#error_mssg").hide();
});
$("#instansi").autocomplete({
  minLength: 0,
  source:"<?php echo base_url().'keuangan/jurnal/autocomplite_instansi' ?>",
  focus: function( event, ui ) {
    $("#instansi" ).val(ui.item.value);
    return false;
  },
  open: function(event, ui) {
                  $(".ui-autocomplete").css("position: absolute");
                  $(".ui-autocomplete").css("top: 0");
                  $(".ui-autocomplete").css("left: 0");
                  $(".ui-autocomplete").css("cursor: default");
                  $(".ui-autocomplete").css("z-index","999999");
                  $(".ui-autocomplete").css("font-weight : bold");
              },
  select: function( event, ui ) {
    $("#instansi").val( ui.item.value );
    $("#id_instansi").val(ui.item.key);
    return false;
  }
}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
  return $( "<li>" )
    .append( "<a><b><font size=2>" + item.label + "</font></b><br><font size=1>" + item.alamat + "</font></a>" )
    .appendTo( ul );
};
$("#tambahinstansi").click(function(){
  $("#popup_jurum_instansi #popup_content_jurum_instansi").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/add_instansi/'; ?>", function(data) {
    $("#popup_content_jurum_instansi").html(data);
  });
  $("#popup_jurum_instansi").jqxWindow({
    theme: theme, resizable: false,
    width: 450,
    height: 400,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurum_instansi").jqxWindow('open');
});

function add_jurnaltransaksi(id_transaksi,id_jurnal,tipe,$code){
      var data = new FormData();
      data.append('id_transaksi', id_transaksi);
      data.append('id_jurnal',    id_jurnal);

      $.ajax({
       cache : false,
       contentType : false,
       processData : false,
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/add_kredit_debit/" ?>'+tipe,
       data : data,
       success: function (response) {
        a = response.split("|");
          if(a[0]=="OK"){
            if (tipe=='kredit') {
                var form_kredit = '<div id="jurnaltrasaksi_kredit-'+a[2]+'" name="jurnaltrasaksi_kredit-'+a[1]+'">\
                  <div class="box-body">\
                    <div class="row">\
                      <div class="col-md-1" style="padding:5px">\
                        <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi_kredit'+a[2]+'" name="create_jurnal_transaksi_kredit" onclick="add_jurnaltransaksi(\''+a[1]+'\',\''+a[2]+'\',\'kredit\')"></a>\
                        <a class="glyphicon glyphicon-trash" id="delete_jurnal_transaksi_kredit'+a[2]+'" name="delete_jurnal_transaksi_kredit" onclick="delete_jurnaltransaksi(\''+a[1]+'\',\''+a[2]+'\',\'kredit\')"></a>\
                      </div>\
                      <div class="col-md-5">\
                          <select onchange="selectnamaakun(\''+a[2]+'\',\'kredit\')" id="id_mst_akun_kredit'+a[2]+'" class="form-control" name="id_mst_akun_kredit">\
                            <?php foreach ($getdataakun as $dataakun) { ?>\
                              <option value="<?php echo $dataakun->kode?>" <?php echo $select;?>><?php echo $dataakun->uraian?></option>\
                            <?php } ?>\
                          </select>\
                      </div>\
                      <div class="col-md-3">\
                      </div>\
                      <div class="col-md-3">\
                        <input type="text" onchange="inputvalueakunas(\''+a[2]+'\',\'kredit\')" id="debit_akun_kredit'+a[2]+'" name="debit_akun_kredit" placeholder="Debit Akun"  class="form-control" value="0" />\
                      </div>\
                    </div>\
                  </div>\
                </div>';

                $('#jurnaltrasaksidata_kredit').append(form_kredit);
                if (a[3] >=2 ) {
                  $("[name='create_jurnal_transaksi_kredit']").show();
                  $("[name='delete_jurnal_transaksi_kredit']").show();
                  $("[name='delete_jurnal_transaksi_debet']").hide();
                  $("[name='create_jurnal_transaksi_debet']").hide();
                }
            }else{
                var form_debit = '<div id="jurnaltrasaksi_debet-'+a[2]+'" name="jurnaltrasaksi_debet-'+a[1]+'">\
                  <div class="box-body">\
                    <div class="row">\
                      <div class="col-md-1" style="padding:5px">\
                        <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi_debet'+a[2]+'" name="create_jurnal_transaksi_debet" onclick="add_jurnaltransaksi(\''+a[1]+'\',\''+a[2]+'\',\'debet\')"></a>\
                        <a class="glyphicon glyphicon-trash" id="delete_jurnal_transaksi_debet'+a[2]+'" name="delete_jurnal_transaksi_debet" onclick="delete_jurnaltransaksi(\''+a[1]+'\',\''+a[2]+'\',\'debet\')"></a>\
                      </div>\
                      <div class="col-md-5">\
                          <select onchange="selectnamaakun(\''+a[2]+'\',\'debet\')" id="id_mst_akun_debet'+a[2]+'" class="form-control" name="id_mst_akun_debet">\
                            <?php foreach ($getdataakun as $dataakun) { ?>\
                              <option value="<?php echo $dataakun->kode?>" <?php echo $select;?>><?php echo $dataakun->uraian?></option>\
                            <?php } ?>\
                          </select>\
                      </div>\
                      <div class="col-md-3">\
                        <input onchange="inputvalueakunas(\''+a[2]+'\',\'debet\')" type="text" id="debit_debet'+a[2]+'" name="debit_debet" placeholder="Debit Akun"  class="form-control" value="0" />\
                      </div>\
                      <div class="col-md-3">\
                      </div>\
                    </div>\
                  </div>\
                </div>';

                $('#jurnaltrasaksidata_debet').append(form_debit);
                if (a[3] >=2 ) {
                  $("[name='create_jurnal_transaksi_debet']").show();
                  $("[name='delete_jurnal_transaksi_debet']").show();
                  $("[name='delete_jurnal_transaksi_kredit']").hide();
                  $("[name='create_jurnal_transaksi_kredit']").hide();
                }
            }
          }else{
              alert("Failed.");
          }
       }
    });
}
function delete_jurnaltransaksi(id_transaksi,id_jurnal,tipe) {
  if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/delete_kreditdebet/" ?>'+tipe,
       data : 'id_transaksi='+id_transaksi+'&id_jurnal='+id_jurnal,
       success: function (response) {
        res = response.split("|");
        if(res[0]=="OK"){
            if (tipe=='kredit') {
              $("#jurnaltrasaksi_kredit-"+id_jurnal).remove();
            }else{
              $("#jurnaltrasaksi_debet-"+id_jurnal).remove();
            }
            
            if (res[3] <=2 ) {
              $("[name='delete_jurnal_transaksi_debet']").hide();
              $("[name='delete_jurnal_transaksi_kredit']").hide();
              $("[name='create_jurnal_transaksi_kredit']").show();
              $("[name='create_jurnal_transaksi_debet']").show();
            }
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}
function selectnamaakun(id_jurnal,tipe){
  if (tipe=='kredit') {
    valuesdata = $("#id_mst_akun_kredit"+id_jurnal).val();
  }else{
    valuesdata = $("#id_mst_akun_debet"+id_jurnal).val();
  }
  $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/selectnamaakun/" ?>'+id_jurnal+'/'+tipe,
       data : 'valuesdata='+valuesdata,
       success: function (response) {
       }
  });
}

function inputvalueakunas(id_jurnal,tipe){
  if (tipe=='kredit') {
    values = parseInt($("#debit_akun_kredit"+id_jurnal).val(),10);
  }else{
    values = parseInt($("#debit_debet"+id_jurnal).val(),10);
  }
  $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/inputvalueakun/" ?>'+id_jurnal+'/'+tipe,
       data : 'valueinput='+values,
       success: function (response) {
       }
  });
}
$("#btn-simpan_jurum").click(function(){
  var data = new FormData();
  $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
  $('#notice').show();
  data.append('id_transaksi', "<?php echo $id;?>");
  data.append('tanggal', $('#tgl_transaksi').val());
  data.append('uraian', $('#uraian').val());
  data.append('keterangan', $('#keterangan').val());
  // data.append('lampiran', $('#lampiran').val());
  data.append('jenistransaksi', $('#jenistransaksi').val());
  data.append('bukti_kas', $('#bukti_kas').val());
  data.append('jatuh_tempo', $('#tgl_jatuhtempo').val());
  data.append('nomor_faktur', $('#nomor_faktur').val());
  data.append('id_mst_syarat_pembayaran', $('#syarat_pem').val());
  data.append('id_instansi', $('#id_instansi').val());
  data.append('id_kategori_transaksi', $('#kategori_transaksi').val());
  data.append('lampiran', $('input[type=file]')[0].files[0]); 

  $.ajax({
      cache : false,
      contentType : false,
      processData : false,
      type : 'POST',
      url : '<?php echo base_url()."keuangan/jurnal/{action}_junal_umum/$id" ?>',
      data : data,
      success : function(response){
        var res  = response.split("|");
        if(res[0]=="OK"){
          var obj = jQuery.parseJSON(res[1]);
          $("#error_mssg").addClass("alert alert-success alert-dismissable").show();
          $("#mssgerr").html('Data berhasil diubah');
        }
        else if(res[0]=="Error"){
           var obj = jQuery.parseJSON(res[1]);
            $("#error_mssg").addClass("alert alert-danger alert-dismissable").show();
            $("#mssgerr").html(obj.err_msg);
        }
        else{
            var obj = jQuery.parseJSON(res[1]);
            $("#error_mssg").addClass("alert alert-warning alert-dismissable").show();
            $("#mssgerr").html(obj.err_msg);
        }
    }
  });
  return false;
});
</script>
