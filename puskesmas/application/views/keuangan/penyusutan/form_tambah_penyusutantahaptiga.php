<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-6">
      <h4>{form_title}</h4>
    </div>
    <div class="col-sm-6" style="text-align: right">
      <button type="button" name="btn_keuangan_add_steptiga" class="btn btn-warning" onclick="addsteptiga(3)"><i class='glyphicon glyphicon-floppy-save'></i> &nbsp; Simpan</button>
      <!-- <button type="button" name="btn_keuangan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Batal</button> -->
    </div>
  </div>

  <div class="row" style="margin: 5px">
    <div class="col-md-12">
        <div class="box box-primary">
          <!-- <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              Buat Transaksi Inventaris
            </div>
            <div class="col-md-2" style="padding: 5px">
              Pemisah 
            </div>
            <div class="col-md-6">
              <select name="pemisah" id="pemisah" class='form-control'>
                <option value="1">Per Barang</option>
              </select>
            </div>
          </div> -->
          <div class="row" style="margin: 5px">
            <div class="col-md-12" style="padding: 5px">
             <font size="3"><b>#Transaksi</b></font>
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-12" style="padding: 5px">
             <font size="3"><b>Informasi Dasar</b></font>
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              Nomor Transaksi
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control" name="auto" placeholder="(Auto)" disabled="">
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              Tanggal Transaksi
            </div>
            <div class="col-md-8">
              <div name="transaksi_tgl" id="transaksi_tgl" value="<?php
               if(set_value('transaksi_tgl')=="" && isset($tanggal)==''){
                  echo $tanggal;
                }else{
                  echo  set_value('transaksi_tgl');
                }
              ?>" ></div>
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              Uraian
            </div>
            <div class="col-md-8">
              <input type="text" class="form-control" name="uraian" id="uraian" placeholder="uraian" value="<?php 
                if(set_value('uraian')=="" && isset($uraian)){
                  echo $uraian;
                }else{
                  echo  set_value('uraian');
                }
                ?>">
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-12" style="padding: 5px">
             <font size="3"><b>Jurnal Transaksi</b></font>
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              <b>Nama Akun</b>
            </div>
            <div class="col-md-4">
             <b> Debit</b>
            </div>
            <div class="col-md-4">
              <b>Kredit</b>
            </div>
          </div>
          <?php foreach ($getalldata as $datajurnal) { ?>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              <?php echo $datajurnal->kode.' - '.$datajurnal->namaakun;?>
            </div>
            <div class="col-md-4">
              <div class='pull-right'>
              <?php echo number_format($datajurnal->debet,2);?>
              </div>
            </div>
            <div class="col-md-4">
              
            </div>
          </div>
          <?php } ?>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              <select id="jurnaltransaksi" name="jurnaltransaksi" class="form-control">
                <?php foreach ($getakun as $keyakun): 
                $select = $keyakun['id_mst_akun']==$idakunkredittotal ?'selected' : '';
                ?>
                  <option value="<?php echo $keyakun['id_mst_akun'] ?>" <?php echo $select; ?>><?php echo $keyakun['nama_akun'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <div class="pull-right">
                <?php echo number_format($kredittot,2); ?>
              </div>
            </div>
          </div>
          <div class="row" style="margin: 5px">
            <div class="col-md-4" style="padding: 5px">
              <b>Total</b>
            </div>
            <div class="col-md-4">
              <div class="pull-right">
              <b><?php echo number_format($jumlahtotal,2); ?></b>
              </div>
            </div>
            <div class="col-md-4">
              <div class="pull-right">
              <b><?php echo number_format($jumlahtotal,2); ?></b>
              </div>
            </div>
          </div>

          <br>
      </div>
    </div>
  </div>
</form>

<script>
  $(function () { 

    $("[name='transaksi_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});

    
   $("[name='btn_keuangan_close']").click(function(){
        $("#popup_keuangan_penyusutan").jqxWindow('close');
        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
    });

    $("[name='btn_keuangan_add_steptiga']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('akunkredit',           $("[name='jurnaltransaksi']").val());
        data.append('id_transaksi',         "<?php echo $id_transaksi; ?>");
        data.append('tanggal',              $("#transaksi_tgl").val());
        data.append('uraian',               $("#uraian").val());
        data.append('jumlahtotal',          "<?php echo $jumlahtotal; ?>");
        data.append('id_jurnalkredit',      "<?php echo $id_jurnalkredit; ?>");
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/penyusutan/addsteptiga"   ?>',
            data : data ,
            success : function(response){
              if(response=="OK"){
                alert("Data berhasil disimpan.");
                $("#popup_keuangan_penyusutan").jqxWindow('close');
                $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
              }else{
                alert('Failed');
              }
            }
         });

        return false;
    });
  });


function addsteptiga(id) {
  $("#popup_keuangan_penyusutan").jqxWindow('close');
  // $("#popup_keuangan_penyusutan").jqxWindow('close');
  // $.get("<?php echo base_url().'keuangan/penyusutan/addsteptiga' ?>/", function(data) {
  //   $("#popup_keuangan_penyusutan_content").html(data);
  // });
}
</script>
