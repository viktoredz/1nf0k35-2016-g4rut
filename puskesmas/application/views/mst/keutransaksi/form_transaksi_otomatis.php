<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
      </div>

        <div class="box-footer">
          <button type="button" id="btn-kembali" class="btn btn-primary pull-right"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
          <button type="button" disabled="" name="btn_kategori_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button type="button" name="btn-reset" value="Reset" onclick='clearForm(this.form)' class="btn btn-success" ><i class='fa fa-refresh'></i> &nbsp; Reset</button>

       </div>
        <div class="box-body">

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">
            Nama Transaksi
          </div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="transaksi_nama" placeholder="Pembayaran Biaya Jasa Pelayanan" value="<?php 
              if(set_value('nama')=="" && isset($nama)){
                echo $nama;
              }else{
                echo  set_value('nama');
              }
              ?>">
          </div>
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Deskripsi</div>
          <div class="col-md-8">
          <textarea class="form-control" name="transaksi_deskripsi" placeholder="Deskripsi Dari Kategori"><?php 
              if(set_value('deskripsi')=="" && isset($deskripsi)){
                echo $deskripsi;
              }else{
                echo  set_value('deskripsi');
              }
              ?></textarea>
          </div>  
        </div>

        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">
            Untuk Jurnal
          </div>
          <div class="col-md-8">
              <select name="transaksi_jurnal" type="text" class="form-control">
              <?php 
                if(set_value('transaksi_jurnal')=="" && isset($untuk_jurnal)){
                  $transaksi_jurnal = $untuk_jurnal;
                }else{
                  $transaksi_jurnal = set_value('transaksi_jurnal');
                }
              ?>
              <option value="Semua" <?php if($transaksi_jurnal=="semua") echo "selected" ?>>Semua</option>
              <option value="Jurnal Umum" <?php if($transaksi_jurnal=="jurnal_umum") echo "selected" ?>>Jurnal Umum</option>
              <option value="Jurnal Penyesuaian" <?php if($transaksi_jurnal=="jurnal_penyesuaian") echo "selected" ?>>Jurnal Penyesuaian</option>
              <option value="Jurnal Penutup" <?php if($transaksi_jurnal=="jurnal_penutup") echo "selected" ?>>Jurnal Penutup</option>
              </select>
          </div>
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
          Kategori
        </div>
        <div class="col-md-8">
          <select  name="transaksi_kategori" type="text" class="form-control">
            <?php foreach($kategori as $k) : ?>
                <?php
                  if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
                    $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
                  }else{
                    $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
                  }
                  $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
                ?>
                <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div> 

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
          Favorit
        </div>
        <div class="col-md-8">
         <input type="checkbox" name="ortu_status_pns" value="1" <?php 
            if(set_value('status_pns')=="" && isset($status_pns)){
              $status_pns = $status_pns;
            }else{
              $status_pns = set_value('status_pns');
            }
            if($status_pns == 1) echo "checked";
            ?>>
        </div>
      </div> 


        <label>Pengaturan Transaksi</label>

<!--         <div class="row" style="margin: 5px">
           <div class="col-md-12">
              <?php $i=1; foreach($template as $t) : ?>
              <input type="checkbox" name="kategori_trans_template" id="kategori_trans_template<?php echo $i;?>" value="<?php echo $t->id_mst_setting_transaksi_template;?>" 
              <?php 
                if(set_value('nilai')=="" && isset($nilai)){
                   $nilai = $nilai;
                }else{
                   $nilai = set_value('nilai');
                }
                if($nilai == 1) echo "checked";
              ?>> 
                <?php echo $t->setting_judul ?>
                </br>
                <?php echo $t->seting_deskripsi ?>
                </br></br>
              <?php $i++; endforeach ?> 
                </div>
              </div>    -->

              <div class="row" style="margin: 5px">
                <div class="col-md-12">
                  <?php $i=1; foreach($template as $t) : ?>
                    <input type="checkbox" name="transaksi_otomatis_template" id="template<?php echo $i;?>" value="<?php echo $i;?>">
                    <?php echo $t->setting_judul ?>
                    </br>
                    <?php echo $t->seting_deskripsi ?>
                    </br></br>
                  <?php $i++; endforeach ?> 
                </div>
              </div>

        </div>
      </div>
    </div>
  </div>
</form>
</section>

<script type="text/javascript">

    $("#btn-kembali").click(function(){
      $.get('<?php echo base_url()?>mst/keuangan_transaksi/transaksi_otomatis_kembali', function (data) {
        $('#content3').html(data);
      });
    });

    $("[name='transaksi_otomatis_template']").click(function(){
      var data = new FormData();
      alert($("[name='transaksi_otomatis_template']:checked").val());

        data.append('template',     $("[name='transaksi_otomatis_template']:checked").val());
        data.append('kategori',     "<?php echo $id;?>");
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_otomatis_template_update/"?>'+$(this).val(),
            data : data,
            success : function(response){
              // a = response.split("|");
              if(response=="OK"){
              // if (a[1]=='1') {
                    $("#transaksi_otomatis_template").prop("checked", true);
                }else{
                    $("#transaksi_otomatis_template").prop("checked", false);
                // };
              // }else{
                // alert("Mendukung transaksi belum berhasil di aktifkan.");

              }
              //ceklist();
            }
        });
        return false;
    });

  function clearForm(form_transaksi_otomatis) {
   
    var elements = form_transaksi_otomatis.elements;
    form_transaksi_otomatis.reset();

    for(i=0; i<elements.length; i++) {
     
      field_type = elements[i].type.toLowerCase();
 
      switch(field_type) {
     
        case "text":
        case "password":
        case "textarea":
        case "hidden":  
         
          elements[i].value = "";
          break;
           
        case "radio":
        case "checkbox":
          if (elements[i].checked) {
                elements[i].checked = false;
          }
          break;

        case "select-one":
        case "select-multi":
                    elements[i].selectedIndex = -1;
          break;

        default:
          break;
      }
    }
}

</script>

