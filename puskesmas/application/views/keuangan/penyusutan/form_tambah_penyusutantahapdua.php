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
      <h4>{form_title}</h4>
    </div>
    <div class="col-sm-6" style="text-align: right">
      <button type="button" name="btn_keuangan_add_sts" class="btn btn-warning" onclick="addsteptiga(3)"><i class='glyphicon glyphicon-arrow-right'></i> &nbsp; Selanjutnya</button>
      <button type="button" name="btn_keuangan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Batal</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
            <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Menambahkan 2 Inventaris
                </div>
                <div class="col-md-8" style="float:right">
                  <input type="checkbox" name="transaksitambah" checked=""> Tambakan Sebagai Transaksi
                  </div>
                </div>
              </div>
              <?php $i=1; foreach ($dataedit as $key) {
              ?>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                 <font size="3"><b><?php echo $i;?> <?php echo $key['judul'] ?></b></font>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 ID Inventaris
                </div>
                <div class="col-md-8">
                  <?php echo $key['id_inventaris'] ?>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Akun Inventaris
                </div>
                <div class="col-md-8">
                 <select name='akun_inventaris' id='akun_inventaris' class="form-control">
                  <?php 
                   foreach ($nilaiakun_inventaris as $datainve) { 
                        $select = $datainve['key'] == $key['akun_inventaris'] ? 'selected' :'';
                    ?>
                      <option value="<?php echo $datainve['key']?>" <?php echo $select?>><?php echo $datainve['value'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Akun Beban penyusutan
                </div>
                <div class="col-md-8">
                  <select name='akun_bebanpenyusustan' id='akun_bebanpenyusustan' class="form-control">
                  <?php  foreach ($nilaiakun_bebanpenyusustan as $databeban) { 
                        $select = $databeban['key'] == $key['akun_bebanpenyusustan'] ? 'selected' :'';
                    ?>
                      <option value="<?php echo $databeban['key']?>" <?php echo $select?>><?php echo $databeban['value'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Metode penyusutan
                </div>
                <div class="col-md-8">
                  <select name='metode_penyusustan' id='metode_penyusustan' class="form-control">
                    <?php  foreach ($nilaimetode_penyusustan as $datametode) { 
                        $select = $datametode['key'] == $key['metode_penyusustan'] ? 'selected' :'';
                    ?>
                      <option value="<?php echo $datametode['key']?>" <?php echo $select?>><?php echo $datametode['value'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Nilai Ekonomis
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="nilai_ekonomis" id="nilai_ekonomis" placeholder="Nilai Ekonomis" value="<?php echo $key['nilai_ekonomis'];
                      // if (isset($key['nilai_ekonomis']) && set_value('nilai_ekonomis')) {
                      //   echo $key['nilai_ekonomis'];
                      // }else{
                      //   echo set_value('nilai_ekonomis');
                      // }
                    ?>">
                </div>
              </div>
              <?php $i++; }?>
              <br>
            </div>
          </div>
  </div>
</form>

<script>

 function kodeSTS(){
      $.ajax({
      url: "<?php echo base_url().'keuangan/sts/kodeSts';?>",
      dataType: "json",
      success:function(data){ 
        $.each(data,function(index,elemet){
          var sts = elemet.kodests.split(".")
          $("#id_sts").val(sts[0]);
        });
      }
      });
      return false;
  }

  $(function () {
    
   $("[name='btn_keuangan_close']").click(function(){
        $("#popup_keuangan_penyusutan").jqxWindow('close');
    });

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
                $("#popup_keuangan_penyusutan").jqxWindow('close');
                alert("Data STS berhasil disimpan.");
                window.location.href="<?php echo base_url().'keuangan/sts/detail';?>/" + a[1];
              }else{
                $('#popup_keuangan_sts_content').html(response);
              }
            }
         });

        return false;
    });
  });

function addsteptiga(id) {
  $.get("<?php echo base_url().'keuangan/penyusutan/addsteptiga' ?>/", function(data) {
    $("#popup_keuangan_penyusutan_content").html(data);
  });
}
</script>
