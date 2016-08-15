<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header pull-left">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-footer pull-right">
         <button type="button" class="btn btn-primary" id="jqxgrid_jurnal_umum_refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button> 
         <button type="button" class="btn btn-success" onclick='add()'><i class='glyphicon glyphicon-floppy-save'></i> &nbsp; Export</button> 
        </div>
        <div class="row">
        <div class="box-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-3">
                    <label> Filter Transaksi</label>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="">
                      
                    </select>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id=""> 
                  
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-3">
                    <label> Periode</label>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="periodetahun" name="periodetahun">
                      <?php for($i=date("Y"); $i>=date("Y")-5; $i--){
                        $select = ($i==date('Y') ? 'selected' : '');
                      ?>
                        <option value="<?php echo $i?>" <?php echo $select?>><?php echo $i?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id="periodebulan" name="periodebulan"> 
                      <?php foreach ($bulan as $key => $value) { 
                        $select = ($key==date('n') ? 'selected' : '');
                      ?>  
                        <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
             <div class="row">
                <div class="col-md-6">
                  <label>Tambah Transaksi</label>
                  <select class="form-control" id="">
                    
                  </select>
                </div>
                <div class="col-md-6">
                  <label>Tambah Transaksi</label>
                  <select class="form-control" id=""> 
                
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="div-grid">
            <div id="jqxgrid_jurnal_umum"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</section>

<div id="popup_kategori_transaksi" style="display:none">
  <div id="popup_title">{title_form}</div>
  <div id="popup_kategori_transaksi_content">&nbsp;</div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    // prepare the data
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id_mst_transaksi', type: 'number' },
            { name: 'nama', type: 'string' },
            { name: 'untuk_jurnal', type: 'string' },
            { name: 'deskripsi', type: 'string' },
            { name: 'jumlah_transaksi', type: 'string' },
            { name: 'bisa_diubah', type: 'string' },
            { name: 'id_mst_kategori_transaksi', type: 'string' },
            { name: 'id_mst_transaksi_item', type: 'string' },
            { name: 'id_mst_akun', type: 'string' },
            { name: 'id_mst_transaksi', type: 'string' },
            { name: 'type', type: 'string' },
            { name: 'group', type: 'string' },
            { name: 'auto_fill', type: 'string' },
            { name: 'id_mst_transaksi_item_from', type: 'string' },
            { name: 'value', type: 'string' },
            { name: 'child', type: 'array' },
            { name: 'urutan', type: 'string' },
            { name: 'opsional', type: 'string' },  
        ],
        hierarchy:
        {
            root: 'child'
        },
        id: 'id_mst_transaksi',
        url: "<?php echo site_url('keuangan/jurnal/json_jurnal_umum'); ?>",
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // create Tree Grid
    $("#jqxgrid_jurnal_umum").jqxTreeGrid(
    {
        width: 850,
        source: dataAdapter,
        sortable: true,
        columns: [
          { text: 'Action', dataField: 'id_mst_transaksi', width: 120 },
          { text: 'Tanggal', dataField: 'nama', width: 120 },
          { text: 'Transaksi', dataField: 'untuk_jurnal', width: 120 },
          { text: 'Kode AKun', dataField: 'id_mst_transaksi_item', cellsFormat: 'd', width: 120 },
          { text: 'Debet', dataField: 'id_mst_akun', cellsFormat: 'd', width: 120 },
          { text: 'Kredit', dataField: 'Kredit', width: 120 },
          { text: 'Status', dataField: 'status', width: 120 },
        ]
    });
});
    </script>