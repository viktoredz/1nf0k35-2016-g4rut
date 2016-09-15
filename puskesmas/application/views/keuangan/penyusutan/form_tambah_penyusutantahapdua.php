
<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-6">
      <h4>{form_title}</h4>
    </div>
    <div class="col-sm-6" style="text-align: right">
      <button type="button" name="btn_keuangan_add_stepdua" class="btn btn-warning""><i class='glyphicon glyphicon-arrow-right'></i> &nbsp; Selanjutnya</button>
      <!-- <button type="button" name="btn_keuangan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Batal</button> -->
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
            <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Menambahkan <?php echo count($datainventaris); ?> Inventaris
                </div>
                <div class="col-md-8" style="float:right">
                  <input type="checkbox" name="transaksitambah" id="transaksitambah"> Tambakan Sebagai Transaksi
                  </div>
                </div>
              </div>
              <?php $i=1; foreach ($datainventaris as $key) {
              ?>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                 <font size="3"><b><?php echo $i.'. ';?> <?php echo $key['nama_barang'] ?></b></font>
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
                 <select name='akun_inventaris' id='akun_inventaris<?php echo $i;?>' class="form-control">
                  <?php 
                   foreach ($nilaiakun_inventaris as $datainve) { 
                        $select = $datainve['id_mst_akun'] == $key['id_mst_akun'] ? 'selected' :'';
                    ?>
                      <option value="<?php echo $datainve['id_mst_akun']?>" <?php echo $select?>><?php echo $datainve['nama_akun'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Akun Beban penyusutan
                </div>
                <div class="col-md-8">
                  <select name='akun_bebanpenyusustan' id='akun_bebanpenyusustan<?php echo $i;?>' class="form-control">
                  <?php  foreach ($nilaiakun_bebanpenyusustan as $databeban) { 
                        $select = $databeban['id_mst_akun'] == $key['id_mst_akun_akumulasi'] ? 'selected' :'';
                    ?>
                      <option value="<?php echo $databeban['id_mst_akun']?>" <?php echo $select?>><?php echo $databeban['nama_akun'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Metode penyusutan
                </div>
                <div class="col-md-8">
                  <select name='metode_penyusustan' onchange="showekonomissia(<?php echo $i;?>)" id='metode_penyusustan<?php echo $i;?>' class="form-control">
                    <?php  foreach ($nilaimetode_penyusustan as $datametode) { 
                        $select = $datametode['id_mst_metode_penyusutan'] == $key['id_mst_metode_penyusutan'] ? 'selected' :'';
                    ?>
                      <option value="<?php echo $datametode['id_mst_metode_penyusutan']?>" <?php echo $select?>><?php echo $datametode['nama'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row" style="margin: 5px" id="datanilai_ekonomis<?php echo $i;?>">
                <div class="col-md-4" style="padding: 5px">
                 Nilai Ekonomis
                </div>
                <div class="col-md-4">
                  <input type="number" class="form-control" name="nilai_ekonomis" id="nilai_ekonomis<?php echo $i;?>" placeholder="Nilai Ekonomis" value="<?php 
                      if (isset($key['nilai_ekonomis']) && set_value('nilai_ekonomis')=='') {
                        echo $key['nilai_ekonomis'];
                      }else{
                        echo set_value('nilai_ekonomis');
                      }
                    ?>">
                </div>
                <div class="col-md-4" style="padding: 8px"> Tahun</div>
              </div>
              <div class="row" style="margin: 5px" id="datanilai_sisa<?php echo $i;?>">
                <div class="col-md-4" style="padding: 5px">
                 Nilai Sisa
                </div>
                <div class="col-md-8">
                  <input type="number" class="form-control" name="nilai_sisa" id="nilai_sisa<?php echo $i;?>" placeholder="Nilai Sisa" value="<?php 
                      if (isset($key['nilai_sisa']) && set_value('nilai_sisa')=='') {
                        echo $key['nilai_sisa'];
                      }else{
                        echo set_value('nilai_sisa');
                      }
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


  $(function () {
    
   $("[name='btn_keuangan_close']").click(function(){
        $("#popup_keuangan_penyusutan").jqxWindow('close');
        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
    });

    $("[name='btn_keuangan_add_stepdua']").click(function(){

        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();
        <?php $no=1; foreach ($datainventaris as $datain) { ?>
          data.append("id_inventaris<?php echo $no;?>",  "<?php echo $datain['id_inventaris']?>");
          data.append('id_inventaris_barang<?php echo $no;?>', "<?php echo $datain['id_inventaris_barang']?>");
          data.append('id_mst_akun<?php echo $no;?>',           $("#akun_inventaris<?php echo $no;?>").val());
          data.append('id_mst_akun_akumulasi<?php echo $no;?>', $("#akun_bebanpenyusustan<?php echo $no;?>").val());
          data.append('id_mst_metode_penyusutan<?php echo $no;?>', $("#metode_penyusustan<?php echo $no;?>").val());
          data.append('nilai_ekonomis<?php echo $no;?>', $("#nilai_ekonomis<?php echo $no;?>").val());
          data.append('nilai_sisa<?php echo $no;?>', $("#nilai_sisa<?php echo $no;?>").val());
          data.append('nama_barang<?php echo $no;?>', "<?php echo $datain['nama_barang']?>");
        <?php $no++;} ?>
          data.append('jumlahdata', "<?php echo count($datainventaris) ?>");
          if(document.getElementById('transaksitambah').checked) {
              data.append('transaksitambah', "1");
          } else {
              data.append('transaksitambah', "0");
          }
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/penyusutan/addstepdua"?>',
            data : data ,
            success : function(response){
              if(document.getElementById('transaksitambah').checked) {
                $("#popup_keuangan_penyusutan_content").html(response);
              }else{
                $("#popup_keuangan_penyusutan").jqxWindow('close');
                $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
              }
            }
         });

        return false;
    });
  });
  function showekonomissia(no){
    
    pilihmetode = $("#metode_penyusustan"+no).val();
    if (pilihmetode=='5') {
      $("#datanilai_ekonomis"+no).hide();
    }else{
      $("#datanilai_ekonomis"+no).show();
    }
    if (pilihmetode=='5' || pilihmetode=='6' || pilihmetode=='3') {
      $("#datanilai_sisa"+no).hide();
    }else{
      $("#datanilai_sisa"+no).show();
    }


  }
</script>
