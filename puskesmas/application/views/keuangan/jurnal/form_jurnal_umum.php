
<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<div class="box-body">
<form action="<?php echo base_url()?>keuangan/jurnal/$action" method="post">
  <div class="box box-primary">
    <div class="box-body">
      <div class="row pull-right">
        <div class="box-body">
          <button type="reset" id="btn-reset_jurum" class="btn btn-success">Reset</button>
          <button type="button" id="btn-simpan_jurum" class="btn btn-primary">Simpan</button>
          <button type="button" id="btn-draf_jurum" class="btn btn-info">Simpan Sebagai Draf</button>
          <button type="button" id="btn-delete_jurum" class="btn btn-danger">Hapus</button>
          <button type="button" id="btn-close_jurum" class="btn btn-warning">Batal</button>
        </div>
      </div>
        <div class="box-body">
          <h3>{sub_title}</h3>
          <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jenis Transaksi</div>
          <div class="col-md-9">
            <input type="text" id="jenis_transaksi" name="jenis_transaksi" placeholder="Jenis Transaksi"  class="form-control" value="<?php 
              if(set_value('jenis_transaksi')=="" && isset($jenis_transaksi)){
                echo $jenis_transaksi;
              }else{
                echo  set_value('jenis_transaksi');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kategori</div>
          <div class="col-md-9">
            <input type="text" id="kategori" name="kategori" placeholder="Kategori"  class="form-control" value="<?php 
              if(set_value('kategori')=="" && isset($kategori)){
                echo $jenis_transaksi;
              }else{
                echo  set_value('kategori');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Alasan Perubahan</div>
          <div class="col-md-9">
            <textarea id="alasan_perubahan" name="alasan_perubahan" class="form-control"><?php 
              if(set_value('alasan_perubahan')=="" && isset($alasan_perubahan)){
                echo $alasan_perubahan;
              }else{
                echo  set_value('nomor_balasan_perubahanukti_kas');
              }
              ?></textarea> 
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Dasar</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-9">
            <input type="text" id="nomor_transaksi" name="nomor_transaksi" placeholder="Nomor Transaksi"  class="form-control" value="<?php 
              if(set_value('nomor_transaksi')=="" && isset($nomor_transaksi)){
                echo $nomor_transaksi;
              }else{
                echo  set_value('nomor_transaksi');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Tanggal Transaksi</div>
          <div class="col-md-9">
            <!-- <div type="text" id="tgl_transaksi" name="tgl_transaksi" /></div> -->
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Uraian</div>
          <div class="col-md-9">
            <input type="text" id="uraian_transaksi" name="uraian_transaksi" placeholder="Uraian"  class="form-control" value="<?php 
              if(set_value('uraian_transaksi')=="" && isset($uraian_transaksi)){
                echo $uraian_transaksi;
              }else{
                echo  set_value('uraian_transaksi');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Jurnal Transaksi</h3></div>
        </div>
        <!--
        ini create
        -->
        <div id="jurnal_transaksi" class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-5">
                  <div class="box-header">
                    <h3 class="box-title">Nama Akun</h3>
                  </div>
                </div>
                <div class="col-md-3">
                  Debit
                </div>
                <div class="col-md-3">
                  Kredit
                </div>
              </div>
            </div>
            <?php //foreach($jurnal_transaksi as $jt) { ?>
            <div id="jt-<?php // echo $jt->group ?>">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-1">
                    <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi" name="create_jurnal_transaksi"></a>
                  </div>
                  <div class="col-md-5">
                    <div class="box-header">
                      <select id="namaakun">
                        <option></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="debit_akun" name="debit_akun" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit_akun')=="" && isset($debit_akun)){
                          echo $debit_akun;
                        }else{
                          echo  set_value('debit_akun');
                        }
                        ?>" />
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="debit_akun" name="debit_akun" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit_akun')=="" && isset($debit_akun)){
                          echo $debit_akun;
                        }else{
                          echo  set_value('debit_akun');
                        }
                        ?>" />
                  </div>
                </div>
              </div>
            <div id="detail-<?php  ?>">
              <div class="box-body">
                <div class="row">
                  <div class="col-md-1">
                    <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi" name="create_jurnal_transaksi"></a>
                  </div>
                  <div class="col-md-5">
                    <div class="box-header">
                      <select id="namaakun">
                        <option></option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="debit_akun" name="debit_akun" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit_akun')=="" && isset($debit_akun)){
                          echo $debit_akun;
                        }else{
                          echo  set_value('debit_akun');
                        }
                        ?>" />
                  </div>
                  <div class="col-md-3">
                    <input type="text" id="debit_akun" name="debit_akun" placeholder="Debit Akun"  class="form-control" value="<?php 
                        if(set_value('debit_akun')=="" && isset($debit_akun)){
                          echo $debit_akun;
                        }else{
                          echo  set_value('debit_akun');
                        }
                        ?>" />
                  </div>
                </div>
              </div>
            </div>
            </div>
            <?php //} ?>
          </div>
        </div>
        <!--End create -->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Tambahan</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Syarat Pembayaran</div>
          <div class="col-md-9">
            <select type="text" id="syarat_pem" name="syarat_pem" class="form-control">
              <option></option>
            </select>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jatuh Tempo</div>
          <div class="col-md-9">
            <!-- <div type="text" id="tgl_transaksi" name="tgl_transaksi" placeholder="Tanggal Transaksi" /></div> -->
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Faktur</div>
          <div class="col-md-9">
            <input type="text" id="no_faktur" name="no_faktur" placeholder="Nomor Faktur"  class="form-control" value="<?php 
              if(set_value('no_faktur')=="" && isset($no_faktur)){
                echo $no_faktur;
              }else{
                echo  set_value('no_faktur');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Bukti Kas</div>
          <div class="col-md-9">
            <input type="text" id="nomor_bukti_kas" name="nomor_bukti_kas" placeholder="Nomor Bukti Kas"  class="form-control" value="<?php 
              if(set_value('nomor_bukti_kas')=="" && isset($uraian_transaksi)){
                echo $nomor_bukti_kas;
              }else{
                echo  set_value('nomor_bukti_kas');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Instansi</div>
          <div class="col-md-9">
            <input type="text" id="instansi" name="instansi" placeholder="Instansi"  class="form-control" value="<?php 
              if(set_value('instansi')=="" && isset($instansi)){
                echo $instansi;
              }else{
                echo  set_value('instansi');
              }
              ?>" />
          </div>
        </div>
         <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Lampiran</div>
          <div class="col-md-9">
            <input type="file" id="lampiran" name="lampiran" value="Upload" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Keterangan</div>
          <div class="col-md-9">
            <textarea id="keterangan" name="keterangan" class="form-control"><?php 
              if(set_value('nomor_bukti_kas')=="" && isset($uraian_transaksi)){
                echo $nomor_bukti_kas;
              }else{
                echo  set_value('nomor_bukti_kas');
              }
              ?></textarea> 
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Data Pendukung</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kode Kegiatan</div>
          <div class="col-md-9">
            <input type="text" id="kode_kegiatan" name="kode_kegiatan" placeholder="Kode Kegiatan"  class="form-control" value="<?php 
              if(set_value('kode_kegiatan')=="" && isset($kode_kegiatan)){
                echo $kode_kegiatan;
              }else{
                echo  set_value('kode_kegiatan');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Sub Kegiatan</div>
          <div class="col-md-9">
            <input type="text" id="subkegiatan" name="subkegiatan" placeholder="Sub Kegiatan"  class="form-control" value="<?php 
              if(set_value('subkegiatan')=="" && isset($subkegiatan)){
                echo $subkegiatan;
              }else{
                echo  set_value('subkegiatan');
              }
              ?>" />
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jenis Belaja</div>
          <div class="col-md-9">
            <input type="text" id="jns_belanja" name="jns_belanja" placeholder="Jenis Belanja"  class="form-control" value="<?php 
              if(set_value('jns_belanja')=="" && isset($jns_belanja)){
                echo $jns_belanja;
              }else{
                echo  set_value('jns_belanja');
              }
              ?>" />
          </div>
        </div>

      </div>
    </div>
  </div>
</form>        
</div>
<script type="text/javascript">
$(function(){
  $('#btn-close_jurum').click(function(){
      window.location.href="<?php echo base_url()?>keuangan/jurnal";
  });

 
  // $("#tgl_transaksi").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
});

</script>
