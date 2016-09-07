<?php if(validation_errors()!=""){ ?>
<div class="alert alert-danger alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-6">
       <h4>{title_form}</h4> 
    </div>
    <div class="col-sm-6" style="text-align: right">
      <button type="button" name="btn_keuangan_edit_penyusutan" id="btn_keuangan_add_editpenysutan" class="btn btn-warning"><i class='glyphicon glyphicon-floppy-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_keuangan_penyusutan_close" id="btn_keuangan_penyusutan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Close</button>
    </div>
  </div>

<div class="row" style="margin: 5px">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="row" style="margin: 5px">
        <div class="col-md-12" style="padding: 5px">
         <font size="3"><b><?php 
          if (isset($nama_barang)) {
            echo $nama_barang;
          }
          ?></b></font>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         ID Inventaris
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($id_inventaris)) {
          	echo $id_inventaris;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Akun Inventaris
        </div>
        <div class="col-md-8">
          <select class="form-control" id="akun_inventaris" name="akun_inventaris">
            <?php foreach ($akun_inventaris as $keyinv) { 
              $select = $keyinv['id_mst_akun']==$id_mst_akun ? 'selected' : '';
            ?>
              <option value="<?php echo $keyinv['id_mst_akun']; ?>" <?php echo $select; ?>><?php echo $keyinv['nama_akun'];?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Akun Beban Penyusutan
        </div>
        <div class="col-md-8">
          <select class="form-control" id="akun_beban" name="akun_beban">
            <?php foreach ($akun_bebaninventaris as $keyak) { 
              $select = $keyak['id_mst_akun']==$id_mst_akun_akumulasi ? 'selected' : '';
            ?>
              <option value="<?php echo $keyak['id_mst_akun']; ?>" <?php echo $select; ?>><?php echo $keyak['nama_akun'];?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Metode Penyusutan
        </div>
        <div class="col-md-8">
          <select class="form-control" id="metode" name="metode">
            <?php foreach ($metode_penyusutan as $keymetod) { 
              $select = $keymetod['id_mst_metode_penyusutan']==$id_mst_metode_penyusutan ? 'selected' : '';
            ?>
              <option value="<?php echo $keymetod['id_mst_metode_penyusutan']; ?>" <?php echo $select; ?>><?php echo $keymetod['nama'];?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="row" style="margin: 5px" id="nilai_ekonomisdata">
        <div class="col-md-4" style="padding: 5px">
         Nilai Ekonomis
        </div>
        <div class="col-md-4">
          <input type="number" class="form-control" id="nilai_ekonomis" name="nilai_ekonomis" value="<?php
          if (isset($nilai_ekonomis) && set_value('nilai_ekonomis')=='') {
            echo $nilai_ekonomis;
          }else{
            echo set_value('nilai_ekonomis');
          }
          ?>"> 
        </div>
        <div class="col-md-4" style="padding:8px">Tahun</div>
      </div>
      <div class="row" style="margin: 5px" id="nilai_sisadata">
        <div class="col-md-4" style="padding: 5px">
         Nilai Sisa
        </div>
        <div class="col-md-8">
          <input type="number" class="form-control" id="nilai_sisa" name="nilai_sisa" value="<?php
          if (isset($nilai_sisa) && set_value('nilai_sisa')=='') {
            echo $nilai_sisa;
          }else{
            echo set_value('nilai_sisa');
          }
          ?>"> 
        </div>
      </div>

      <br>
    </div>

  </div>
</div>
</form>

<script>

$("#metode").change(function(){
  if ($(this).val()!='5') {
    $("#nilai_ekonomisdata").show();
  }else{
    $("#nilai_ekonomisdata").hide();
  }
  if ($(this).val()=='5' || $(this).val()=='6' || $(this).val()=='3') {
    $("#nilai_sisadata").hide();
  }else{
    $("#nilai_sisadata").show();
  }
});
  $(function () { 
    <?php if ($id_mst_metode_penyusutan=='5') { ?>
      $("#nilai_ekonomisdata").hide();
    <?php } ?>
    <?php if ($id_mst_metode_penyusutan=='5' || $id_mst_metode_penyusutan=='6' || $id_mst_metode_penyusutan=='3') { ?>
      $("#nilai_sisadata").hide();
    <?php } ?>
  	$("#btn_keuangan_penyusutan_close").click(function(){
  		closepopup();
  	});
  	function closepopup(){
            $("#popup_keuangan_penyusutan").jqxWindow('close');
        }
    $("#btn_keuangan_add_editpenysutan").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('id_inventaris',          "<?php echo $id_inventaris ?>");
        data.append('id_mst_akun',             $("#akun_inventaris").val());
        data.append('id_mst_akun_akumulasi',   $("#akun_beban").val());
        data.append('id_mst_metode_penyusutan',$("#metode").val());
        data.append('nilai_ekonomis',          $("#nilai_ekonomis").val());
        data.append('nilai_sisa',              $("#nilai_sisa").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/penyusutan/edit_penyusutan"?>',
            data : data ,
            success : function(response){
              if(response=="OK"){
                alert("Data penysutan berhasil disimpan.");
                $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                closepopup();
              }else{
                alert('data failed');
              }
            }
         });

        return false;
    });
  });

function edit(id){
    document.location.href="<?php echo base_url().'keuangan/penyusutan/edit';?>/" + id ;
}
</script>
