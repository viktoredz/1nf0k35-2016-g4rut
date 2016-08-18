
<script type="text/javascript">

  $(function(){
    detail_versi(1);
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

function hapus(){
  $("#tanggal_perubahan").html('');
  $("#alasan_perubahan").html('');
  $("#dirubaholeh").html('');
  $("#nomor_transaksi").html('');
  $("#uraian").html('');
  $("#keterangan").html('');
  $("#tgl_transaksi").html('');
  $("#kategori_transaksi").html('');
  $("#id_debit_akun").html('');
  $("#jml_debit").html('');
  $("#id_akun_kredit").html('');
  $("#jml_kredit").html('');
  $("#lampiran").html('');
  $("#syarat").html('');
  $("#jth_tempo").html('');
  $("#no_faktur").html('');
  $("#instansi").html('');
}
function detail_versi(id)
{
  hapus();
  $.ajax({
  url: "<?php echo base_url().'keuangan/jurnal/pilihversi/' ?>"+id,
  dataType: "json",
  success:function(data)
  { 
    $.each(data,function(index,elemet){
      $("#tanggal_perubahan").html(elemet.tanggal_perubahan);
      $("#alasan_perubahan").html(elemet.alasan_perubahan);
      $("#dirubaholeh").html(elemet.dirubaholeh);
      $("#nomor_transaksi").html(elemet.nomor_transaksi);
      $("#uraian").html(elemet.uraian);
      $("#keterangan").html(elemet.keterangan);
      $("#tgl_transaksi").html(elemet.tgl_transaksi);
      $("#kategori_transaksi").html(elemet.kategori_transaksi);
      $("#id_debit_akun").html(elemet.id_debit_akun);
      $("#jml_debit").html(elemet.jml_debit);
      $("#id_akun_kredit").html(elemet.id_akun_kredit);
      $("#jml_kredit").html(elemet.jml_kredit);
      $("#lampiran").html(elemet.lampiran);
      $("#syarat").html(elemet.syarat);
      $("#jth_tempo").html(elemet.jth_tempo);
      $("#no_faktur").html(elemet.no_faktur);
      $("#instansi").html(elemet.instansi);
    });
  }
  });

  return false;
}
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
          <div class="col-md-12">
          <div align="center">
            <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="btn btn-default" onclick="detail_versi(4)">Saat ini</button>
              <button type="button" class="btn btn-default" onclick="detail_versi(1)">1</button>
              <button type="button" class="btn btn-default" onclick="detail_versi(2)">2</button>
              <button type="button" class="btn btn-default" onclick="detail_versi(3)">3</button>
            </div>
          </div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Tanggal Perubahan</div>
          <div class="col-md-8">
            <div id="tanggal_perubahan"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Alasan Perubahan</div>
          <div class="col-md-8">
            <div id="alasan_perubahan"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Dirubah Oleh</div>
          <div class="col-md-8">
            <div id="dirubaholeh"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-8">
            <div id="nomor_transaksi"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Uraian</div>
          <div class="col-md-8">
            <div id="uraian"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Keterangan</div>
          <div class="col-md-8">
            <div id="keterangan"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Tanggal Transaksi</div>
          <div class="col-md-8">
            <div id="tgl_transaksi"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kategori Transaksi</div>
          <div class="col-md-8">
            <div id="kategori_transaksi"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Debit</div>
          <div class="col-md-8">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px"><div id="id_debit_akun"></div></div>
          <div class="col-md-8">
            <div id="jml_debit"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Kredit</div>
          <div class="col-md-8">
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px"><div id="id_akun_kredit"></div></div>
          <div class="col-md-8">
            <div id="jml_kredit"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Lampiran</div>
          <div class="col-md-8">
            <a><div id="lampiran"></div></a>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Syarat</div>
          <div class="col-md-8">
            <div id="syarat"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Jatuh Tempo</div>
          <div class="col-md-8">
            <div id="jth_tempo"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">No Faktur</div>
          <div class="col-md-8">
            <div id="no_faktur"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-4" style="padding: 5px">Instansi</div>
          <div class="col-md-8">
            <a href=""><div id="instansi"></div></a>
          </div>
        </div>
    </div>
    <div class="box-footer">
          <div class="box-footer">
            <div style="float:left">
              <button type="button" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus Transaksi</button>
            </div>
            <div style="float:right">
              <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i> Ubah</button>
              <button type="button" id="btn-close" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
            </div>
        </div>
    </div>
  </div>
</div>
</form>