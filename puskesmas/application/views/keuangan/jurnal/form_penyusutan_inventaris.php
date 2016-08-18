
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
<div class="box-body">
<form action="<?php echo base_url()?>keuangan/jurnal/$action" method="post">
  <div class="box box-primary">
    <div class="box-body">
      <div class="row pull-right">
        <div class="box-body">
          <button type="reset" id="btn-reset_penyusutan_jurum" class="btn btn-success"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
          <button type="button" id="btn-simpan_penyusutan_jurum" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Simpan Perubahan</button>
          <button type="button" id="btn-delete_penyusutan_jurum" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
          <button type="button" id="btn-close_penyusutan_jurum" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
        </div>
      </div>
        <div class="box-body">
          <h3>{title_form}</h3>
          <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jenis Transaksi</div>
          <div class="col-md-9">
            <input type="text" id="jenis_transaksi" name="jenis_transaksi" placeholder="Jenis Transaksi"  class="form-control" value="<?php 
              if(set_value('jenis_transaksi')=="" && isset($jenis_transaksi)){
                echo $jenis_transaksi;
              }else{
                echo  set_value('jenis_transaksi');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kategori</div>
          <div class="col-md-9">
            <input type="text" id="kategori" name="kategori" placeholder="Kategori"  class="form-control" value="<?php 
              if(set_value('kategori')=="" && isset($kategori)){
                echo $jenis_transaksi;
              }else{
                echo  set_value('kategori');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Alasan Perubahan</div>
          <div class="col-md-9">
            <textarea id="alasan_perubahan" name="alasan_perubahan" class="form-control"><?php 
              if(set_value('alasan_perubahan')=="" && isset($alasan_perubahan)){
                echo $alasan_perubahan;
              }else{
                echo  set_value('nomor_balasan_perubahanukti_kas');
              }
              ?></textarea> 
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Dasar</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-9">
            <input type="text" id="nomor_transaksi" name="nomor_transaksi" placeholder="Nomor Transaksi"  class="form-control" value="<?php 
              if(set_value('nomor_transaksi')=="" && isset($nomor_transaksi)){
                echo $nomor_transaksi;
              }else{
                echo  set_value('nomor_transaksi');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Tanggal Transaksi</div>
          <div class="col-md-9">
            <!-- <div type="text" id="tgl_transaksi" name="tgl_transaksi" /></div> -->
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Daftar Transaksi</h3></div>
        </div>
        <!--
        ini create
        -->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><button type="button" id="add_inventaris" onclick="add_datainventaris()" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Inventaris</button></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div id='jqxExpander'>
              <div><i class="glyphicon glyphicon-trash"></i> Early History of the Internet</div>
              <div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">Transaksi Penyusutan</div>
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
                    <div class="col-md-6" style="padding: 5px">Uraian</div>
                    <div class="col-md-3">
                      Debit
                    </div>
                    <div class="col-md-3">
                      Kredit
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Alat</div>
                    <div class="col-md-3">
                      <input type="text" id="jml_debit" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('jml_debit')=="" && isset($jml_debit)){
                          echo $jml_debit;
                        }else{
                          echo  set_value('jml_debit');
                        }
                        ?>" />
                    </div>
                    <div class="col-md-3">
                      <input type="text" id="jml_kredit" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('jml_kredit')=="" && isset($jml_kredit)){
                          echo $jml_kredit;
                        }else{
                          echo  set_value('jml_kredit');
                        }
                        ?>" />
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Keadaan Kendaraan</div>
                    <div class="col-md-3">
                      <input type="text" id="jml_debit" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('jml_debit')=="" && isset($jml_debit)){
                          echo $jml_debit;
                        }else{
                          echo  set_value('jml_debit');
                        }
                        ?>" />
                    </div>
                    <div class="col-md-3">
                      <input type="text" id="jml_kredit" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('jml_kredit')=="" && isset($jml_kredit)){
                          echo $jml_kredit;
                        }else{
                          echo  set_value('jml_kredit');
                        }
                        ?>" />
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Total</div>
                    <div class="col-md-3">
                      <input type="text" id="jml_debit" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('jml_debit')=="" && isset($jml_debit)){
                          echo $jml_debit;
                        }else{
                          echo  set_value('jml_debit');
                        }
                        ?>" />
                    </div>
                    <div class="col-md-3">
                      <input type="text" id="jml_kredit" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('jml_kredit')=="" && isset($jml_kredit)){
                          echo $jml_kredit;
                        }else{
                          echo  set_value('jml_kredit');
                        }
                        ?>" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--End create -->
        
      </div>
    </div>
  </div>
</form>        
</div>
<div id="popup_inventaris" style="display:none">
  <div id="popup_title_inventaris">Data Inventaris</div>
  <div id="popup_content_inventaris">&nbsp;</div>
</div>
<script type="text/javascript">
$(function(){
  $('#btn-close_penyusutan_jurum').click(function(){
      window.location.href="<?php echo base_url()?>keuangan/jurnal";
  });
  $("#jqxExpander").jqxExpander({ width: '100%',theme: 'summer'});
  // $("#tgl_transaksi").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
});
function add_datainventaris(){
  var id=0;
  $("#popup_inventaris #popup_content_inventaris").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/add_penyusutan_inventaris/'; ?>"+id, function(data) {
    $("#popup_content_inventaris").html(data);
  });
  $("#popup_inventaris").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_inventaris").jqxWindow('open');
}
</script>
