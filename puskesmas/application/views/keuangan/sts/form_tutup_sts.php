<?php if(validation_errors()!=""){ ?>
<div class="alert alert-danger alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-8">
 
    </div>
    <div class="col-sm-12" style="text-align: right">
      <button type="button" name="btn_keuangan_add_sts_tutup" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan & Tutup STS</button>
      <button type="button" name="btn_keuangan_close_tutup" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Batal</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">

              <div class="row">
                <div class="col-md-12">
                  Penutupan STS, klik simpan dan tutup untuk menutup STS. STS yang sudah ditutup tidak bisa dirubah lagi.
                  <br><br>
                  Transaksi Berikut akan disimpan dijurnal umum
                  <br><br>
                </div>
              </div>
            <div class="backgroundhitam" role="alert"> <br>
              <div class="row" style="margin: 5px;  display: none;">
                <div class="col-md-3" style="padding: 5px">
                 Nomor Transaksi
                </div>
                <div class="col-md-9">
                  
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Tanggal 
                </div>
                <div class="col-md-9">
                  <?php echo date('d-m-Y',strtotime($tgl));?>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Uraian
                </div>
                <div class="col-md-9">
                  <input type="text" name="uraiantutup" id="uraiantutup" value="<?php echo "Penerimaan Puskesmas Tanggal ".date('d-m-Y',strtotime($tgl)); ?>" class="form-control">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Debit
                </div>
                <div class="col-md-9">
                  <font size="3"><b>{totaldebit}</b></font><br>
                  {id_akun_debit_uraian}
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  Kredit
                </div>
              </div>
              <?php $jmldata=0; foreach ($allkredit as $key) { $jmldata++; ?>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                </div>
                <div class="col-md-9">
                  <font size="3"><b><?php echo $key->totalkredit;?></b></font><br>
                  <?php echo $key->id_akun_kredit_uraian;?>
                </div>
              </div>
              <?php } ?><br>
            </div>
            <div class="row" style="margin: 5px">
              <div class="col-md-12" style="padding: 5px">
                <div class="pull-right">
                <input type="checkbox" name="setoranbank" id="setoranbank"> Sertakan Transaksi Setoran Bank
                </div>
              </div>
            </div>
            <div class="backgroundhitam" role="alert" id="transaksisetorbank"><br>
              <div class="row" style="margin: 5px;  display: none;">
                <div class="col-md-3" style="padding: 5px">
                 Nomor Transaksi
                </div>
                <div class="col-md-9">
                  
                </div>
              </div>

              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Tanggal 
                </div>
                <div class="col-md-9">
                  <?php echo date('d-m-Y',strtotime($tgl));?>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Uraian
                </div>
                <div class="col-md-9">
                  <input type="text" name="uraiantutupsetor" id="uraiantutupsetor" value="<?php  echo "Setoran Puskesmas Tanggal ".date('d-m-Y',strtotime($tgl)); ?>" class="form-control">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Debit
                </div>
                <div class="col-md-9">
                  <font size="3"><b>{totaldebit}</b></font><br>
                  {akun_kredit}
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-3" style="padding: 5px">
                  Kredit
                </div>
                <div class="col-md-9">
                  <font size="3"><b>{totaldebit}</b></font><br>
                  {id_akun_debit_uraian}
                </div>
              </div><br>
            </div>
            <input type="hidden" name="id_sts" id="id_sts" value="<?php 
            if(set_value('id_sts')=="" && isset($id_sts)){
                echo $id_sts;
              }else{
                echo  set_value('id_sts');
              }
            ?>">
            <input type="hidden" name="kodeclphc" id="kodeclphc" value="<?php 
            if(set_value('kodeclphc')=="" && isset($kodeclphc)){
                echo $kodeclphc;
              }else{
                echo  set_value('kodeclphc');
              }
            ?>">
            <input type="hidden" name="isicheckbox" id="isicheckbox">
              <br>
            </div>
          </div>
  </div>
</form>

<script>


  $(function () { 
    $("#transaksisetorbank").hide();
    $("#isicheckbox").val('no');
    $("#setoranbank").click(function(){
      if ($(this).is(':checked')) {
          $("#transaksisetorbank").show();
          $("#isicheckbox").val('yes');
      }else{
        $("#transaksisetorbank").hide();
        $("#isicheckbox").val('no');
      }
    });
    $("[name='btn_keuangan_close_tutup']").click(function(){
      $("#popup_keuangan_sts_tutup").jqxWindow('close');
    });
    $("[name='btn_keuangan_add_sts_tutup']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('id_sts',               $("[name='id_sts']").val());
        data.append('kodeclphc',            $("[name='kodeclphc']").val());
        data.append('uraiantutup',          $("[name='uraiantutup']").val());
        data.append('uraiantutupsetor',     $("[name='uraiantutupsetor']").val());
        data.append('isicheckbox',          $("[name='isicheckbox']").val());
        data.append('totaldebitkredit',     "<?php echo $totaldebit;?>");
        data.append('tanggal',              "<?php echo $tgl;?>");
        data.append('id_akun_debit',        "<?php echo $id_akun_debit;?>");
        data.append('akun_kredit',          "<?php echo $akun_kredit;?>");
        data.append('jmldata',              "<?php echo $jmldata;?>");
        data.append('id_akun_kredit',       "<?php echo $id_akun_kredit;?>");
        <?php $i=1; foreach ($allkredit as $key) { ?>
        data.append("id_akun_kredit_uraian<?php echo $i;?>",    "<?php echo $key->id_mst_akun;?>");
        data.append("totalkredit<?php echo $i;?>",              "<?php echo $key->totalkredit;?>");
        <?php $i++;} ?>
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/sts/add_tutup_buku"   ?>',
            data : data ,
            success : function(response){
              a = response.split(" | ");
              if(a[0]=="OK"){
                alert("Data Berhasil disimpan");
                $("#popup_keuangan_sts_tutup").jqxWindow('close');
                location.reload();
              }else{
                $('#popup_keuangan_sts__tutup_content').html(response);
              }
            }
         });

        return false;
    });
  });

</script>
<style type="text/css">
  .backgroundhitam{
    background-color: #DCDCDC;
  }
</style>
