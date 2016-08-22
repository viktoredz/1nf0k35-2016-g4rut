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
      <button type="button" name="btn_keuangan_edit_penyusutan" id="btn_keuangan_edit_penyusutan" onclick="edit(1)" class="btn btn-warning"><i class='glyphicon glyphicon-triangle-right'></i> &nbsp; Selanjutnya</button>
      <button type="button" name="btn_keuangan_penyusutan_close" id="btn_keuangan_penyusutan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Close</button>
    </div>
  </div>

<div class="row" style="margin: 5px">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="row" style="margin: 5px">
        <div class="col-md-12" style="padding: 5px">
         <font size="3"><b><?php 
          if (isset($nama_inventaris)) {
            echo $nama_inventaris;
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
            <?php foreach ($akun_inventaris as $key => $value) { ?>
              <option value="<?php echo $key; ?>"><?php echo $value;?></option>
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
            <?php foreach ($akun_bebaninventaris as $key => $value) { ?>
              <option value="<?php echo $key; ?>"><?php echo $value;?></option>
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
            <?php foreach ($metode_penyusutan as $key => $value) { ?>
              <option value="<?php echo $key; ?>"><?php echo $value;?></option>
            <?php }?>
          </select>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Nilai Ekonomis
        </div>
        <div class="col-md-7">
          <input type="number" class="form-control" id="nilai_ekonomis" name="nilai_ekonomis" value="<?php
          if (isset($nilai_ekonomis) && set_value('nilai_ekonomis')) {
            echo $nilai_ekonomis;
          }else{
            echo set_value('nilai_ekonomis');
          }
          ?>"> 
        </div>
        <div class="col-md-1" style="padding:5px">Tahun</div>
      </div>
      

      <br>
    </div>

  </div>
</div>
</form>

<script>


  $(function () { 
  	$("#btn_keuangan_penyusutan_close").click(function(){
  		closepopup();
  	});
  	function closepopup(){
            $("#popup_keuangan_penyusutan").jqxWindow('close');
        }
    $("[name='btn_keuangan_add_sts']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('id_sts',          $("[name='sts_id']").val());
        data.append('nomor',           $("[name='sts_nomor']").val());
        data.append('tgl',             $("[name='sts_tgl']").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/sts/add_sts"   ?>',
            data : data ,
            success : function(response){
              a = response.split(" | ");
              if(a[0]=="OK"){
                alert("Data STS berhasil disimpan.");
                $("#jqxgreeddetail").jqxGrid('updatebounddata', 'cells');
                window.location.href="<?php echo base_url().'keuangan/sts/detail';?>/" + a[1];
              }else{
                $('#popup_keuangan_sts_content').html(response);
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
