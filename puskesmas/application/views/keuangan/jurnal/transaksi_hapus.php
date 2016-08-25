<div id="popup_jurnal" style="display:none">
  <div id="popup_title">Data Jurnal</div>
  <div id="popup_content">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header pull-left">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-footer pull-right"> 
         <button type="button" class="btn btn-danger" id="btnexpandall_hapus"><i class='glyphicon glyphicon-save-file'></i> &nbsp; Expand All</button> 
         <button type="button" class="btn btn-warning" id="btncollapseall_hapus"><i class='glyphicon glyphicon-open-file'></i> &nbsp; Collapse All</button>
        </div>
        <div class="row">
        <div class="box-body">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-8">
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-3">
                    <label> Periode</label>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="periodetahunhapus" name="periodetahun">
                      <?php for($i=date("Y"); $i>=date("Y")-5; $i--){
                        $select = ($i==date('Y') ? 'selected' : '');
                      ?>
                        <option value="<?php echo $i?>" <?php echo $select?>><?php echo $i?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id="periodebulanhapus" name="periodebulan"> 
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
          <div class="div-grid">
            <div id="jqxgrid_jurnal_hapus"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
</section>

<script type="text/javascript">
$(document).ready(function () {
    $('#btnexpandall_hapus').click(function () {
        $("#jqxgrid_jurnal_hapus").jqxTreeGrid('expandAll');
    });
    $('#btncollapseall_hapus').click(function () {
       $("#jqxgrid_jurnal_hapus").jqxTreeGrid('collapseAll');
    });
    $("#jqxgrid_jurnal_hapus_refresh").click(function(){
        $("#jqxgrid_jurnal_hapus").jqxTreeGrid('updateBoundData');
    });
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id_jurnal', type: 'number' },
            { name: 'tanggal', type: 'string' },
            { name: 'uraian', type: 'string' },
            { name: 'status', type: 'string' },
            { name: 'id_mst_akun', type: 'string' },
            { name: 'id_transaksi', type: 'string' },
            { name: 'debet', type: 'number' },
            { name: 'kredit', type: 'number' },
            { name: 'child', type: 'array' },
            { name: 'edit', type: 'string' },
        ],
        hierarchy:
        {
            root: 'child'
        },
        id: 'id_transaksi',
        url: "<?php echo site_url('keuangan/jurnal/json_jurnal_umum'); ?>",
    };
      var dataAdapter = new $.jqx.dataAdapter(source, {
          loadComplete: function () {
          }
      });
    // create Tree Grid
    $("#jqxgrid_jurnal_hapus").jqxTreeGrid(
    {
        width: '100%',
        source: dataAdapter,
        sortable: true,
        pageable: false,
        editable: false,
        columnsResize: true,
        showToolbar: true,
        altRows: true,
        ready: function(){
           $("#jqxgrid_jurnal_hapus").jqxTreeGrid('expandAll');            
        },
        pagerButtonsCount: 8,
        toolbarHeight: 40,
        columns: [
          { text: 'Action', dataField: 'id_jurnal', width: '10%', cellsrenderer: function (row, dataField, cellText, rowData) {
              if(rowData.edit==1){
                return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail("+rowData.id_jurnal+");'>   <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit("+rowData.id_jurnal+");'></div>";
              }else{
                return "";
              }
            },
          },
          { text: 'Tanggal', dataField: 'tanggal', width: '15%' },
          { text: 'Transaksi', dataField: 'uraian', width: '25%' },
          { text: 'Kode AKun', dataField: 'id_mst_akun', width: '10%' },
          { text: 'Debet', dataField: 'debet', cellsFormat: 'd', width: '15%',cellsAlign: "right" },
          { text: 'Kredit', dataField: 'kredit', width: '15%',cellsAlign: "right" },
          { text: 'Status', dataField: 'status', width: '10%' },
        ]
    });

});
function detail(id){   
  $("#popup_jurnal #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/detail_jurnal_umum/'; ?>"+id, function(data) {
    $("#popup_content").html(data);
  });
  $("#popup_jurnal").jqxWindow({
    theme: theme, resizable: false,
    width: 600,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal").jqxWindow('open');
}
function edit(id){   
  $.get("<?php echo base_url().'keuangan/jurnal/edit_junal_umum/'; ?>"+id, function(data) {
    $("#content1").html(data);
  });
}
$("#periodetahunhapus").change(function(){
    $.post("<?php echo base_url().'keuangan/jurnal/filtertahun' ?>", 'tahundata='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_hapus").jqxTreeGrid('updateBoundData');
    });
});
$("#periodebulanhapus").change(function(){
  $.post("<?php echo base_url().'keuangan/jurnal/filterbulan' ?>", 'bulandata='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_hapus").jqxTreeGrid('updateBoundData');
    });
});
</script>