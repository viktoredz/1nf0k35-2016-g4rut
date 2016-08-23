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
      <button type="button" name="btn_keuangan_add_sts" class="btn btn-warning" onclick="addsteptiga(3)"><i class='glyphicon glyphicon-floppy-save'></i> &nbsp; Simpan</button>
      <button type="button" name="btn_keuangan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Batal</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
            <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Buat Transaksi Inventaris
                </div>
                <div class="col-md-8">
                  Pemisah 
                  <select name="pemisah" id="pemisah" class='form-control'>
                    <option value="1">Per Barang</option>
                  </select>
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                 <font size="3"><b>#Transaks 1</b></font>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                 <font size="3"><b>Informasi Dasar</b></font>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Transaksi
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="auto" placeholder="(Auto)">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Tanggal Transaksi
                </div>
                <div class="col-md-8">
                  <div name="transaksi_tgl"></div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Uraian
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="uraian" placeholder="uraian"  value="Pembelian Pengadaan 12223 - Angkutan Darat dan Komputer">
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                 <font size="3"><b>Jurnal Transaksi</b></font>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Nama Akun
                </div>
                <div class="col-md-4">
                  Debit
                </div>
                <div class="col-md-4">
                  Kredit
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  21122 - Angkutan Darat
                </div>
                <div class="col-md-4">
                  800.000.000
                </div>
                <div class="col-md-4">
                  
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  21126 - Komputer
                </div>
                <div class="col-md-4">
                  40.000.000
                </div>
                <div class="col-md-4">
                  
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  <select id="jurnaltransaksi" name="jurnaltransaksi" class="form-control">
                    <option value="1">Kas Bendahara Pengeluaran</option>
                  </select>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    840.000.000
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  <b>Total</b>
                </div>
                <div class="col-md-4">
                  <b>840.000.000</b>
                </div>
                <div class="col-md-4">
                  <b>840.000.000</b>
                </div>
              </div>

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
    tabIndex = 1;
    kodeSTS();

    $("[name='transaksi_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});

    
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
                $("#jqxgridPilih").jqxGrid('updatebounddata', 'cells');
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
  $("#popup_keuangan_penyusutan").jqxWindow('close');
  // $("#popup_keuangan_penyusutan").jqxWindow('close');
  // $.get("<?php echo base_url().'keuangan/penyusutan/addsteptiga' ?>/", function(data) {
  //   $("#popup_keuangan_penyusutan_content").html(data);
  // });
}
</script>
