
<script type="text/javascript">

  $(function(){
   
    $('#btn-close').click(function(){
      close_popup();
    }); 

      $('#form-ss-jurnal_umum').submit(function(){
          var data = new FormData();
          $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
          $('#notice').show();
          data.append('id_mst_inv_barang_habispakai_jenis', $('#id_mst_inv_barang_habispakai_jenis').val());
          data.append('batch', $('#batch').val());
          data.append('uraian', $('#uraian').val());
          data.append('jumlah', $('#jumlah').val());
          data.append('batch', $('#batch').val());
          data.append('tgl_distribusi', $('#tanggal_distribusi').val());
          data.append('jumlahdistribusi', $('#jumlahdistribusi').val());
          $.ajax({
              cache : false,
              contentType : false,
              processData : false,
              type : 'POST',
              url : '<?php echo base_url()."inventory/bhp_distribusi/".$action."_distribusi/" ?>',
              data : data,
              success : function(response){
                var res  = response.split("|");
                if(res[0]=="OK"){
                    $('#notice').hide();
                    $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                    $('#notice').show();
                    $("#jqxgrid_barang").jqxGrid('updatebounddata', 'cells');
                    close_popup();
                }
                else if(res[0]=="Error"){
                    $('#notice').hide();
                    $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
                    $('#notice').show();
                }
                else{
                    $('#popup_content').html(response);
                }
            }
          });

          return false;
      });
    });
</script>

<div style="padding:15px">
  <div id="notice" class="alert alert-success alert-dismissable" <?php if ($notice==""){ echo 'style="display:none"';} ?> >
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
    <i class="icon fa fa-check"></i>
    Information!
    </h4>
    <div id="notice-content">{notice}</div>
  </div>
	<div class="row">
    <?php echo form_open(current_url(), 'id="form-ss-jurnal_umum"') ?>
    <div class="box-body">
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>{title}</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h4>Transaksi akan disimpan di database</h4></div>
        </div>
      <div class="alert alert-success" role="alert">
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px">{transaksi_urut}</div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nomor Tranasksi</div>
          <div class="col-md-8">
            {nomor_transaksi}
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Uraian</div>
          <div class="col-md-8">
            {uraian}
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Debit</div>
          <div class="col-md-8">
            <font size="4">{jml_debit}</font><br>
            {id_akun_debit}
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kredit</div>
          <div class="col-md-8">
            <font size="4">{jml_kredit}</font><br>
            {id_akun_kredit}
          </div>
        </div>
      </div>
    </div>
        <div class="box-footer pull-right">
              <button type="button" id="btn-close" class="btn btn-warning">Batal</button>
              <button type="button" class="btn btn-success">Simpan Transaksi</button>
              <button type="button" class="btn btn-primary">Simpan Sebagai Draf</button>
            </div>
        </div>
    </div>
</form>
</div>
<div id="popup_masterbarang" style="display:none">
  <div id="popup_mastertitle">Data master Barang</div>
  <div id="popup_mastercontent">&nbsp;</div>
</div>