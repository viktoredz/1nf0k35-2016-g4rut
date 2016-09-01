
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
            <select disabled="disabled" id="jenistransaksipenyesuaian" name="jenistransaksipenyesuaian"  class="form-control">
                <?php foreach ($filetransaksi as $datjentrans) { 
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
            <select disabled="disabled"  id="kategori_transaksipenyesuaian" name="kategori_transaksipenyesuaian"  class="form-control">
                <?php foreach ($filterkategori_transaksi as $key) { 
                  $select = $key->id_mst_kategori_transaksi==$id_kategori_transaksi ? 'selected' :'';
                ?>
                  <option value="<?php echo $key->id_mst_kategori_transaksi;?>" <?php echo $select;?>><?php echo $key->nama;?></option>
                <?php } ?>
              </select>
          </div>
        </div>
        <!-- <div class="row" style="margin: 5px">
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
        </div> -->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Dasar</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-9">
            <input type="text" disabled="disabled" id="id_transaksipenyesuaian" name="id_transaksipenyesuaian" placeholder="Nomor Transaksi"  class="form-control" value="<?php 
              if(set_value('id_transaksipenyesuaian')=="" && isset($id_transaksi)){
                echo substr($id_transaksi, -10);
              }else{
                echo  set_value('id_transaksipenyesuaian');
              }
              ?>" />
          </div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3">Tanggal Transaksi</div>
          <div class="col-md-9">
            <div type="text" id="tgl_transaksipenyesuaian" name="tgl_transaksipenyesuaian"></div>
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
        </div><br>
        <div class="row" style="margin: 5px">
          <div class="col-md-12">
<!--show hide-->
      <?php foreach($getallinventaris as $keyinv) { ?>
            <div id="createtransaksiinventaris<?php echo $keyinv['id_transaksi_inventaris'];?>" name="createtransaksiinventaris">
              <div class="row" style="border-bottom:solid #3333ff;"> 
                 <div class="col-md-1" style="padding:5px"><i class="glyphicon glyphicon-trash"></i></div>
                 <div class="col-md-10"><font size="4"><b><?php echo $keyinv['nama_barang'] ?></b></font></div>
                 <div class="col-md-1">
                      <b><i  id="showdown<?php echo $keyinv['id_transaksi_inventaris'];?>" name="showdown" class="glyphicon glyphicon-chevron-down" onclick='showdowndata("<?php echo $keyinv['id_transaksi_inventaris'];?>")'></i></b>
                    <b><i id="showup<?php echo $keyinv['id_transaksi_inventaris'];?>" name="showup" class="glyphicon glyphicon-chevron-up" onclick='showupdata("<?php echo $keyinv['id_transaksi_inventaris'];?>")'></i></b>
                 </div>

              </div>
              <div id="showhide<?php echo $keyinv['id_transaksi_inventaris'];?>" name="showhide">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      Transaksi Penyusutan
                    </div>
                    <div class="col-md-2">
                      <div id="tgl_periode_penyusutan_awal<?php echo $keyinv['id_transaksi_inventaris'];?>" name="tgl_periode_penyusutan_awal"></div>&nbsp;&nbsp;
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-6">
                      <div id="tgl_periode_penyusutan_akhir<?php echo $keyinv['id_transaksi_inventaris'];?>" name="tgl_periode_penyusutan_akhir"></div>
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-3" style="padding: 5px">Uraian</div>
                    <div class="col-md-9">
                      <input type="text" id="uraian<?php echo $keyinv['id_transaksi_inventaris'];?>" name="uraian" placeholder="Uraian"  class="form-control" value="<?php 
                        if(set_value('uraian')=="" && isset($keyinv['uraian'])){
                          echo $keyinv['uraian'];
                        }else{
                          echo  set_value('uraian');
                        }
                        ?>" />
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Alat</div>
                    <div class="col-md-3">
                      Debit
                    </div>
                    <div class="col-md-3">
                      Kredit
                    </div>
                  </div>
              <div clas='box-body'>
              <?php foreach ($keyinv['childern'] as $keydetail) { ?>
                  <div class="row" id="detailinventaris<?php echo $keydetail['id_jurnal'];?>" name="detailinventaris">
                    <?php if ($keydetail['status']=='kredit') { ?>
                    <div class="col-md-6" style="padding: 5px">
                    <?php }else{?>
                      <div class="col-md-1" style="padding: 5px"> </div>
                      <div class="col-md-5" style="padding: 5px"> 
                    <?php } ?>
                      <select id="id_mst_akun<?php echo $keydetail['id_jurnal'];?>" name="id_mst_akun" class="form-control">
                        <?php foreach ($getdataakun as $dataakun) { 
                          $select = $dataakun->id_mst_akun == $keydetail['id_mst_akun'] ? 'selected' : '';
                        ?>
                          <option value="<?php echo $dataakun->id_mst_akun?>" <?php echo $select;?>><?php echo  $dataakun->uraian?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="col-md-3" >
                      <?php if ($keydetail['status']=='debet') { ?>
                      <input type="text" id="jml_debit<?php echo $keydetail['id_jurnal'];?>" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('jml_debit')=="" && isset($keydetail['debet'])){
                          echo $keydetail['debet'];
                        }else{
                          echo  set_value('jml_debit');
                        }
                        ?>" />
                      <?php }?>
                    </div>
                    <div class="col-md-3">
                      <?php if ($keydetail['status']=='kredit') { ?>
                      <input type="text" id="jml_kredit<?php echo $keydetail['id_jurnal'];?>" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('jml_kredit')=="" && isset($keydetail['kredit'])){
                          echo $keydetail['kredit'];
                        }else{
                          echo  set_value('jml_kredit');
                        }
                        ?>" />
                      <?php }?>
                    </div>
                  </div>
              <?php } ?>
              </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Total</div>
                    <div class="col-md-3">
                      <input type="text" id="jml_debit" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('jml_debit')=="" && isset($keyinv['totaldebet'])){
                          echo $keyinv['totaldebet'];
                        }else{
                          echo  set_value('jml_debit');
                        }
                        ?>" />
                    </div>
                    <div class="col-md-3">
                      <input type="text" id="jml_kredit" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('jml_kredit')=="" && isset($keyinv['totalkredit'])){
                          echo $keyinv['totalkredit'];
                        }else{
                          echo  set_value('jml_kredit');
                        }
                        ?>" />
                    </div>
                  </div>


                </div>
              </div>
            </div>
        <?php } ?>     
<!--show hide-->
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
  <?php if (count($getallinventaris) > 0) { ?>
    $("[name='tgl_periode_penyusutan_awal']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("[name='tgl_periode_penyusutan_akhir']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  <?php }?>
  $('#btn-close_penyusutan_jurum').click(function(){
      window.location.href="<?php echo base_url()?>keuangan/jurnal";
  });
  
  $("#tgl_transaksipenyesuaian").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  $("[name='showhide']").hide();
  $("[name='showdown']").hide();
  $("[name='showup']").show();
});

function showdowndata(id){
  $("#showdown"+id).hide();
  $("#showup"+id).show();
  $("#showhide"+id).hide("slow");
}
function showupdata(id){
  $("#showup"+id).hide();
  $("#showdown"+id).show();
  $("#showhide"+id).show("slow");
}
function add_datainventaris(){
  var id=0;
  $("#popup_inventaris #popup_content_inventaris").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/add_penyusutan_inventaris/'.$id; ?>", function(data) {
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
function addinventaris(data){
  alert(data);
}
</script>
