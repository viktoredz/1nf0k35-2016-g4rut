<div id="popup_jurnal" style="display:none">
  <div id="popup_title">Data Jurnal</div>
  <div id="popup_content">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-footer pull-right">
         <button type="button" class="btn btn-danger" id="btnexpandall"><i class='icon fa fa-plus-square-o'></i> &nbsp; Expand All</button> 
         <button type="button" class="btn btn-warning" id="btncollapseall"><i class='icon fa fa-minus-square-o'></i> &nbsp; Collapse All</button>
         <button type="button" class="btn btn-primary" id="jqxgrid_jurnal_umum_refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button> 
         <button type="button" class="btn btn-success" onclick='export(1)'><i class='glyphicon glyphicon-floppy-disk'></i> &nbsp; Export</button> 
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
                    <select class="form-control" id="filekategoriumum" name="filekategoriumum">
                        <option value="all">Semua Kategori </option>
                      <?php foreach ($filekategori as $key) {?>
                        <option value="<?php echo $key['id_mst_kategori_transaksi'];?>"><?php echo $key['nama']?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="filetransaksiumum" name="filetransaksiumum"> 
                        <option value="all">Semua Status</option>
                      <?php 
                      foreach ($filetransaksi as $key => $value) {
                        if ($key!='dihapus') {                      ?>
                        <option value="<?php echo $key;?>"><?php echo ucfirst($value);?></option>
                      <?php } }?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-3" style="padding:5px">
                    <label> Periode</label>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id="periodebulanumum" name="periodebulanumum"> 
                      <?php foreach ($bulan as $key => $value) { 
                        $select = ($key==date('n') ? 'selected' : '');
                      ?>  
                        <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="periodetahunumum" name="periodetahunumum">
                      <?php for($i=date("Y"); $i>=date("Y")-5; $i--){
                        $select = ($i==date('Y') ? 'selected' : '');
                      ?>
                        <option value="<?php echo $i?>" <?php echo $select?>><?php echo $i?></option>
                      <?php }?>
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
                    <button class="btn btn-primary dropdown-toggle" id="add_jurnal_umum" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-plus"></i> Tambah Transaksi</button>
                    <!-- <ul class="dropdown-menu">
                      <?php /* foreach ($tambahtransaksi as $key => $value) {?>
                        <li><a onclick='tambahtransaksi("<?php echo $key;?>")'><?php echo $value;?></a></li>
                      <?php }*/?>
                    </ul> -->
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Transaksi Otomatis
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
            <div class="col-md-4">
              <div class="row">
                <div class="col-md-5" style="padding:5px;">
                  <div class="pull-right"><b>Puskesmas</b></div>
                </div>
                <div class="col-md-7">
                    <select class="form-control" id="filterpuskesmas" name="filterpuskesmas"> 
                    <?php foreach ($datapuskes as $datpus) { 
                      $select = ($datpus->code=='P'.$this->session->userdata('puskesmas') ? 'selected' : '');
                    ?>  
                      <option value="<?php echo $datpus->code;?>" <?php echo $select?>><?php echo $datpus->value;?></option>
                    <?php } ?>
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
            { name: 'id_transaksi', type: 'double' },
            { name: 'id_jurnal', type: 'number' },
            { name: 'tanggal', type: 'string' },
            { name: 'uraian', type: 'string' },
            { name: 'status', type: 'string' },
            { name: 'kodeakun', type: 'string' },
            { name: 'id_mst_akun', type: 'string' },
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
        url: "<?php echo site_url('keuangan/jurnal/json_jurnal_umum/jurnal_umum'); ?>",
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
        showSubAggregates: true,
        showAggregates: true,
        aggregatesHeight: 55,
        ready: function(){
           $("#jqxgrid_jurnal_umum").jqxTreeGrid('expandAll');            
        },
        pagerButtonsCount: 8,
        toolbarHeight: 40,
        columns: [
          { text: 'Action', dataField: 'id_jurnal', align:'center', width: '7%', cellsrenderer: function (row, dataField, cellText, rowData) {
              if(rowData.edit==1){
                return "<div style='width:100%;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+rowData.id_transaksi+"\");'> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+rowData.id_transaksi+"\");'></div>";
              }else{
                return "";
              }
            },
          },
          { text: 'Tanggal', align:'center', dataField: 'tanggal', width: '9%',cellsAlign: "center" },
          { text: 'Transaksi', align:'center', dataField: 'uraian', width: '34%' },
          { text: 'Kode AKun', align:'center', dataField: 'kodeakun', width: '10%',cellsAlign: "center" },
          { text: 'Debet', align:'center', dataField: 'debet', cellsFormat: 'd', width: '15%',cellsAlign: "right", 
                      aggregates: [{
                          'Total':
                            function (aggregatedValue, currentValue, column, record, aggregateLevel) {
                                    if (aggregatedValue=='') {
                                      aggregatedValue=0;
                                    }
                                    if (currentValue=='') {
                                      currentValue=0;
                                    }
                                    return aggregatedValue + currentValue;
                            }
                      }],
                      aggregatesRenderer: function (aggregatesText, column, element, aggregates, type) {
                        if (aggregates!=null) {
                          if (type == "aggregates") {
                              var renderString = "<div style='margin: 4px; float: right;  height: 100%;'>";
                          }
                          else {
                              var renderString = "<div style='float: right;  height: 100%;'>";
                          }
                          var totdeb = dataAdapter.formatNumber(aggregates.Total, "f2");
                          renderString += "<table><tr><td rowspan='2'><strong>Total: </strong></td><td align='right'>" + totdeb + "</td></table>";
                          return renderString;
                        }
                      }
          },

          { text: 'Kredit', align:'center', dataField: 'kredit', width: '15%', cellsFormat: 'd', width: '15%',cellsAlign: "right", 
                      aggregates: [{
                          'Total':
                            function (aggregatedValue, currentValue, column, record, aggregateLevel) {
                                    if (aggregatedValue=='') {
                                      aggregatedValue=0;
                                    }
                                    if (currentValue=='') {
                                      currentValue=0;
                                    }
                                    return aggregatedValue + currentValue;
                            }
                      }],
                      aggregatesRenderer: function (aggregatesText, column, element, aggregates, type) {
                        if (aggregates!=null) {
                          if (type == "aggregates") {
                              var renderString = "<div style='margin: 4px; float: right;  height: 100%;'>";
                          }
                          else {
                              var renderString = "<div style='float: right;  height: 100%;'>";
                          }
                          var totkre = dataAdapter.formatNumber(aggregates.Total, "f2");
                          renderString += "<table><tr><td rowspan='2'><strong>Total: </strong></td><td align='right'>" + totkre + "</td></table>";
                          return renderString;
                        }
                      }
          },
          { text: 'Status', align:'center', cellsalign:'center', dataField: 'status', width: '10%' },
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
function penyusutaninventaris(id){   
  $.get("<?php echo base_url().'keuangan/jurnal/penyusutan_inventaris/'; ?>"+id, function(data) {
    $("#content1").html(data);
  });
}
function close_popup(){
  $("#popup_jurnal").jqxWindow('close');
  $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
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

$("#filekategoriumum").change(function(){

  $.post("<?php echo base_url().'keuangan/jurnal/filterkategori' ?>", 'kategori='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
    });
});
$("#filetransaksiumum").change(function(){

  $.post("<?php echo base_url().'keuangan/jurnal/filtertransaksi' ?>", 'transaksi='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
    });
});
$("#periodetahunumum").change(function(){
    $.post("<?php echo base_url().'keuangan/jurnal/filtertahun' ?>", 'tahundata='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
    });
});
$("#periodebulanumum").change(function(){
  $.post("<?php echo base_url().'keuangan/jurnal/filterbulan' ?>", 'bulandata='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
    });
});
$("#filterpuskesmas").change(function(){
  $.post("<?php echo base_url().'keuangan/jurnal/filterpuskesmas' ?>", 'puskes='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');
    });
});
$("#add_jurnal_umum").click(function(){
  $("#popup_jurnal #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/pilih_tipe_transaksijurum/jurnal_umum'; ?>", function(data) {
    $("#popup_content").html(data);
  });
  $("#popup_jurnal").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal").jqxWindow('open');
});
</script>