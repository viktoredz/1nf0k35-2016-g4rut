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
         <button type="button" class="btn btn-primary" id="jqxgrid_jurnal_umum_refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button> 
         <button type="button" class="btn btn-success" onclick='add()'><i class='glyphicon glyphicon-floppy-save'></i> &nbsp; Export</button> 
         <button type="button" class="btn btn-danger" id="btnexpandall"><i class='glyphicon glyphicon-save-file'></i> &nbsp; Expand All</button> 
         <button type="button" class="btn btn-warning" id="btncollapseall"><i class='glyphicon glyphicon-open-file'></i> &nbsp; Collapse All</button>
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
                    <select class="form-control" id="filekategori" name="filekategori">
                      <?php foreach ($filekategori as $key => $value) {?>
                        <option value="<?php echo $key;?>"><?php echo $value?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id="filetransaksi" name="filetransaksi"> 
                      <?php foreach ($filetransaksi as $key => $value) {?>
                        <option value="<?php echo $key;?>"><?php echo $value?></option>
                      <?php }?>
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
                <div class="col-md-4">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Tambah Transaksi
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <?php foreach ($tambahtransaksi as $key => $value) {?>
                        <li><a onclick='tambahtransaksi("<?php echo $key;?>")'><?php echo $value;?></a></li>
                      <?php }?>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Tambah Transaksi Otomatis
                    <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                      <?php foreach ($tambahtransaksiotomatis as $key => $value) {?>
                        <li><a onclick='tambahotomatis("<?php echo $key ?>")'><?php echo $value;?></a></li>
                      <?php }?>
                    </ul>
                  </div>
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
    $('#btnexpandall').click(function () {
        $("#jqxgrid_jurnal_umum").jqxTreeGrid('expandAll');
    });
    $('#btncollapseall').click(function () {
       $("#jqxgrid_jurnal_umum").jqxTreeGrid('collapseAll');
    });
    $("#jqxgrid_jurnal_umum_refresh").click(function(){
        $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
    });
    var source =
    {
        dataType: "json",
        dataFields: [
            { name: 'id_jurnal', type: 'number' },
            { name: 'tanggal', type: 'string' },
            { name: 'transaksi', type: 'string' },
            { name: 'status', type: 'string' },
            { name: 'kodeakun', type: 'string' },
            { name: 'debet', type: 'string' },
            { name: 'kredit', type: 'string' },
            { name: 'child', type: 'array' },
            { name: 'edit', type: 'string' },
        ],
        hierarchy:
        {
            root: 'child'
        },
        id: 'id_jurnal',
        url: "<?php echo site_url('keuangan/jurnal/json_jurnal_umum'); ?>",
    };
      var dataAdapter = new $.jqx.dataAdapter(source, {
          loadComplete: function () {
          }
      });
    // create Tree Grid
    $("#jqxgrid_jurnal_umum").jqxTreeGrid(
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
           $("#jqxgrid_jurnal_umum").jqxTreeGrid('expandAll');            
        },
        pagerButtonsCount: 8,
        toolbarHeight: 40,
        columns: [
          { text: 'Action', dataField: 'id_jurnal', width: '10%', cellsrenderer: function (row, dataField, cellText, rowData) {
              if(rowData.edit==1){
                return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail("+rowData.id_jurnal+");'>   <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail("+rowData.id_jurnal+");'></div>";
              }else{
                return "";
              }
            },
          },
          { text: 'Tanggal', dataField: 'tanggal', width: '15%' },
          { text: 'Transaksi', dataField: 'transaksi', width: '25%' },
          { text: 'Kode AKun', dataField: 'kodeakun', cellsFormat: 'd', width: '10%' },
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
  $("#popup_jurnal #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/edit_junal_umum/'; ?>"+id, function(data) {
    $("#popup_content").html(data);
  });
  $("#popup_jurnal").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal").jqxWindow('open');
}

function close_popup(){
  $("#popup_jurnal").jqxWindow('close');
  $("#jqxgrid_jurnal_umum").jqxGrid('updatebounddata');
}
function tambahotomatis(id){
  $("#popup_jurnal #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/transaksi_otomatis_jurum/'; ?>"+id, function(data) {
    $("#popup_content").html(data);
  });
  $("#popup_jurnal").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal").jqxWindow('open');
}
function tambahtransaksi(id){
  $("#popup_jurnal #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/pilih_tipe_transaksijurum/'; ?>"+id, function(data) {
    $("#popup_content").html(data);
  });
  $("#popup_jurnal").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal").jqxWindow('open');
}
</script>