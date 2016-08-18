
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
          <div class="col-md-4" style="padding: 5px"><h3>{title}</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px">
          <b>Konfirmasi tutup buku periode 1 Agustus -31 Agustus 2016</b><br>
          Sebelum tutup buku, Pastikan Semua periode ini dan transaski untuk tutup buku sudah di masukan. Jurnal yang sudah ditutup tidak bisa dirubah lagi. <br>
          <b>Yakin akan menutup buku periode ini ?</b>
          </div>
        </div>
        
    </div>
        <div class="box-footer">
            <div style="float:right">
              <button type="button" id="btn-close" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
              <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-book"></i> Tutup Buku</button>
            </div>
        </div>
    </div>
</form>
</div>
<div id="popup_masterbarang" style="display:none">
  <div id="popup_mastertitle">Data master Barang</div>
  <div id="popup_mastercontent">&nbsp;</div>
</div>