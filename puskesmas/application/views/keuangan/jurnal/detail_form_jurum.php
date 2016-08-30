
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
$("#btn_hapus_detail_jurum").click(function(){
  var r = confirm("Apakah anda yakin akan menghapus data?");
    if (r == true) {
        $.get("<?php echo base_url().'keuangan/jurnal/hapusdetailjurum/'.$id?>",function(data){
          close_popup();
        });
    } else {
    }
});
$("#ubahdetailjurum").click(function(){
   $.get("<?php echo base_url().'keuangan/jurnal/edit_junal_umum/'.$id; ?>", function(data) {
    $("#content1").html(data);
      $("#popup_jurnal").jqxWindow('close');
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
          <div class="col-md-9"><h3>{title}</h3></div>
          <div class="col-md-3" style="float:right;padding: 15px">
            <select class="form-control" id="draf">
                <option value="<?php echo $status?>"><?php echo ucfirst($status);?></option>
              <?php foreach ($datadraft as $key => $value) { ?>
                <option value="<?php echo $key ?>"> <?php echo $value ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo substr($id_transaksi, -10);?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Uraian</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($uraian) && $uraian!='' ? $uraian :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Keterangan</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($keterangan) && $keterangan!='' ? $keterangan :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Tanggal Transaksi</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($tanggal) && $tanggal!='' ? date('d-m-Y',strtotime($tanggal)) :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kategori Transaksi</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($kategori_transaksi) && $kategori_transaksi!='' ? $kategori_transaksi :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-6" style="padding: 5px"><b>Debit</b></div>
          <div class="col-md-6" style="padding: 6px">
          </div>
        </div>
        <?php foreach ($datajurnaldebit as $key) { ?>
        <div class="row" style="margin: 5px">
          <div class="col-md-1" style="padding: 5px"></div>
          <div class="col-md-6" style="padding: 5px"><font color='blue'><?php echo $key->id_mst_akun.' - '.$key->uraian;?></font></div>
          <div class="col-md-3" style="padding: 6px">
            <div style="float:right">
               <?php echo number_format($key->debet,2);?>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
        <?php } ?>
        <div class="row" style="margin: 5px">
          <div class="col-md-6" style="padding: 5px"><b>Kredit</b></div>
          <div class="col-md-6" style="padding: 6px">
          </div>
        </div>
        <?php foreach ($datajurnal as $key) { ?>
        
        <div class="row" style="margin: 5px">
        <div class="col-md-1"></div>
          <div class="col-md-6" style="padding: 5px"><font color='blue'><?php echo $key->id_mst_akun.' - '.$key->uraian;?></font></div>
          <div class="col-md-3" style="padding: 6px">
            <div style="float:right" >
              <?php echo number_format($key->kredit,2);?>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
        <?php } ?>
        <div class="row" style="margin: 5px" >
          <div class="col-md-4" style="padding: 5px">Lampiran</div>
          <div class="col-md-8" style="padding: 6px">
            <a><?php echo (isset($lampiran) && $lampiran!='' ? $lampiran :'-');?></a>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Syarat</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($syarat) && $syarat!='' ? $syarat :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Jatuh Tempo</div>
          <div class="col-md-8" style="padding: 6px">
          <?php echo (isset($jatuh_tempo) && $jatuh_tempo!='' ? $jatuh_tempo :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">No Faktur</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($nomor_faktur) && $nomor_faktur!='' ? $nomor_faktur :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Instansi</div>
          <div class="col-md-8" style="padding: 6px">
            <a href=""><?php echo (isset($instansi) && $instansi!='' ? $instansi :'-');?></a>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Data untuk Cetak</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kode Kegiatan</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($kode_kegiatan) && $kode_kegiatan!='' ? $kode_kegiatan :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Sub Kegiatan</div>
          <div class="col-md-8" style="padding: 6px">
            <?php echo (isset($sub_kegaitan) && $sub_kegaitan!='' ? $sub_kegaitan :'-');?>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px">-dst-</div>
        </div>
        <div class="row" style="margin: 5px; float:right">
          <div class="col-md-12" style="padding: 6px"><b><i>diubah 3 kali</i></b> <a>lihat versi lama</a></div>
        </div>
    </div>
        <div class="box-footer">
            <div style="float:left">
              <button type="button" class="btn btn-danger" id="btn_hapus_detail_jurum"><i class="glyphicon glyphicon-trash"></i> Hapus Transaksi</button>
            </div>
            <div style="float:right">
              <button type="button" class="btn btn-primary" id="ubahdetailjurum"><i class="glyphicon glyphicon-edit"></i> Ubah</button>
              <button type="button" id="btn-close" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Tutup</button>
            </div>
        </div>
    </div>
</form>
</div>
<div id="popup_masterbarang" style="display:none">
  <div id="popup_mastertitle">Data master Barang</div>
  <div id="popup_mastercontent">&nbsp;</div>
</div>