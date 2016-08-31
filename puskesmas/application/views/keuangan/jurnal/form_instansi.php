<script type="text/javascript">
  $(function(){
   
    $('#btn-close-instansi').click(function(){
      $("#popup_jurum_instansi").jqxWindow('close');
    }); 

      $('#form-ss-jurnal_umum-instansi').submit(function(){
          var data = new FormData();
          $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
          $('#notice').show();
          data.append('nama', $('#nama_instansi').val());
          data.append('alamat', $('#alamat_instansi').val());
          data.append('deskripsi', $('#deskripsi_instansi').val());
          data.append('telepon', $('#telepon_instansi').val());
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."keuangan/jurnal/add_instansi/"?>',
              data : data,
              success : function(response){
                var res  = response.split("|");
                if(res[0]=="OK"){
                    $('#notice').hide();
                    $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                    $('#notice').show();
                    $("#popup_jurum_instansi").jqxWindow('close');
                }
                else if(res[0]=="Error"){
                    $('#notice').hide();
                    $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                    $('#notice').show();
                }
                else{
                    $('#popup_content_jurum_instansi').html(response);
                }
            }
          });

          return false;
      });
    });
</script>

<div style="padding:5px">
  <div id="notice" class="alert alert-success alert-dismissable" <?php if ($notice==""){ echo 'style="display:none"';} ?> >
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
    <i class="icon fa fa-check"></i>
    Information!
    </h4>
    <div id="notice-content">{notice}</div>
  </div>
    <?php echo form_open(current_url(), 'id="form-ss-jurnal_umum-instansi"') ?>
    <div class="box-body">
        <div class="row" >
          <div class="col-md-12"><h4>{title_form}</h4></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nama</div>
          <div class="col-md-8">
            <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" value="<?php 
                if(set_value('nama_instansi')=="" && isset($nama)){
                  echo $nama;
                }else{
                  echo  set_value('nama_instansi');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Telepon</div>
          <div class="col-md-8">
            <input type="text" name="telepon_instansi" id="telepon_instansi" class="form-control" value="<?php 
                if(set_value('telepon_instansi')=="" && isset($telepon)){
                  echo $telepon;
                }else{
                  echo  set_value('telepon_instansi');
                }
                ?>">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Alamat</div>
          <div class="col-md-8">
            <textarea class="form-control" id="alamat_instansi" name="alamat_instansi"><?php 
                if(set_value('alamat_instansi')=="" && isset($alamat)){
                  echo $alamat;
                }else{
                  echo  set_value('alamat_instansi');
                }
                ?></textarea>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kategori</div>
          <div class="col-md-8">
            <select id="deskripsi_instansi" name="deskripsi_instansi" class="form-control">
            <?php foreach ($datakateg as $datkat => $valkat) { ?>
              <option value="<?php echo $datkat; ?>"><?php echo ucwords($valkat); ?></option>
            <?php } ?>
            </select>
          </div>
        </div>        
    </div>
        <div class="box-footer pull-right">
              <button type="button" id="btn-close-instansi" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
              <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-saved"></i> Simpan</button>
            </div>
        </div>
</form>
</div>
<div id="popup_masterbarang" style="display:none">
  <div id="popup_mastertitle">Data master Barang</div>
  <div id="popup_mastercontent">&nbsp;</div>
</div>