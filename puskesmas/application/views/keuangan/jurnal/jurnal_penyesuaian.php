<div id="popup_jurnal_penyesuaian" style="display:none">
  <div id="popup_title">Data Jurnal</div>
  <div id="popup_content_penyesuaian">&nbsp;</div>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-footer pull-right">
         <button type="button" class="btn btn-danger" id="btnexpandall_penyesuaian"><i class='icon fa fa-plus-square-o'></i> &nbsp; Expand All</button> 
         <button type="button" class="btn btn-warning" id="btncollapseall_penyesuaian"><i class='icon fa fa-minus-square-o'></i> &nbsp; Collapse All</button>
         <button type="button" class="btn btn-primary" id="jqxgrid_jurnal_penyesuaian_refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button> 
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
                    <select class="form-control" id="filekategoriumum_penyesuaian" name="filekategoriumum_penyesuaian">
                        <option value="all">Semua Kategori </option>
                      <?php foreach ($filekategori as $key) {?>
                        <option value="<?php echo $key['id_mst_kategori_transaksi'];?>"><?php echo $key['nama']?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="filetransaksiumum_penyesuaian" name="filetransaksiumum_penyesuaian"> 
                        <option value="all">Semua Status</option>
                      <?php foreach ($filetransaksi as $key => $value) {?>
                        <option value="<?php echo $key;?>"><?php echo ucfirst($value);?></option>
                      <?php }?>
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
                    <select class="form-control" id="periodebulanumum_penyesuaian" name="periodebulanumum_penyesuaian"> 
                      <?php foreach ($bulan as $key => $value) { 
                        $select = ($key==date('n') ? 'selected' : '');
                      ?>  
                        <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="periodetahunumum_penyesuaian" name="periodetahunumum_penyesuaian">
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
                    <button class="btn btn-primary dropdown-toggle" id="add_jurnal_umum_penyesuaian" type="button" data-toggle="dropdown"><i class="glyphicon glyphicon-plus"></i> Tambah Transaksi</button>
                    <!-- <ul class="dropdown-menu">
                      <?php /* foreach ($tambahtransaksi as $key => $value) {?>
                        <li><a onclick='tambahtransaksi("<?php echo $key;?>")'><?php echo $value;?></a></li>
                      <?php }*/?>
                    </ul> -->
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="add_jurnal_umum_penyesuaian_otomatis"><i class="glyphicon glyphicon-plus-sign"></i> Tambah Transaksi Otomatis
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
                    <select class="form-control" id="filterpuskesmas_penyesuaian" name="filterpuskesmas_penyesuaian"> 
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
            <div id="jqxgrid_jurnal_penyesuaian"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
$(document).ready(function () {
    hidebukututuppenyesuaian();
    $('#btnexpandall_penyesuaian').click(function () {
        $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('expandAll');
    });
    $('#btncollapseall_penyesuaian').click(function () {
       $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('collapseAll');
    });
    $("#jqxgrid_jurnal_penyesuaian_refresh").click(function(){
        $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');
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
        url: "<?php echo site_url('keuangan/jurnal/json_jurnal_umum/jurnal_penyesuaian'); ?>",
    };
      var dataAdapter = new $.jqx.dataAdapter(source, {
          loadComplete: function () {
          }
      });
    // create Tree Grid
    $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid(
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
           $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('expandAll');            
        },
        pagerButtonsCount: 8,
        toolbarHeight: 40,
        columns: [
          { text: 'Action', dataField: 'id_jurnal', align:'center', width: '7%', cellsrenderer: function (row, dataField, cellText, rowData) {
              if(rowData.edit==1){
                return "<div style='width:100%;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detailpenyesuaian(\""+rowData.id_transaksi+"\");'> <a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='editpenyesuaian(\""+rowData.id_transaksi+"\");'></div>";
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
function detailpenyesuaian(id){   
  $("#popup_jurnal_penyesuaian #popup_content_penyesuaian").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/detail_jurnal_umum/'; ?>"+id+'/jurnal_penyesuaian', function(data) {
    $("#popup_content_penyesuaian").html(data);
  });
  $("#popup_jurnal_penyesuaian").jqxWindow({
    theme: theme, resizable: false,
    width: 600,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal_penyesuaian").jqxWindow('open');
}
function editpenyesuaian(id){   
  $.get("<?php echo base_url().'keuangan/jurnal/edit_junal_penyesuaian/'; ?>"+id, function(data) {
    $("#content2").html(data);
  });
}
function penyusutaninventaris(id){   
  $.get("<?php echo base_url().'keuangan/jurnal/penyusutan_inventaris/'; ?>"+id, function(data) {
    $("#content2").html(data);
  });
}
function close_popup(tipe){
  if (tipe=='jurnal_umum') {
    $("#popup_jurnal").jqxWindow('close');
    $("#jqxgrid_jurnal_umum").jqxTreeGrid('updateBoundData');  
  }else if (tipe=='jurnal_penyesuaian') {
    $("#popup_jurnal_penyesuaian").jqxWindow('close');
    $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');  
  }else if (tipe=='jurnal_penutup') {
    $("#popup_jurnal_penutup").jqxWindow('close');
    $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');  
  }else if (tipe=='jurnal_hapus') {
    $("#popup_jurnal_hapuss").jqxWindow('close');
    $("#jqxgrid_jurnal_hapus").jqxTreeGrid('updateBoundData');  
  }
  
}
function tambahotomatis(id){
  $("#popup_jurnal_penyesuaian #popup_content_penyesuaian").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/transaksi_otomatis_jurum/'; ?>"+id, function(data) {
    $("#popup_content_penyesuaian").html(data);
  });
  $("#popup_jurnal_penyesuaian").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal_penyesuaian").jqxWindow('open');
}

$("#filekategoriumum_penyesuaian").change(function(){

  $.post("<?php echo base_url().'keuangan/jurnal/filterkategori' ?>", 'kategori='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');
    });
});
$("#filetransaksiumum_penyesuaian").change(function(){

  $.post("<?php echo base_url().'keuangan/jurnal/filtertransaksi' ?>", 'transaksi='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');
    });
});
$("#periodetahunumum_penyesuaian").change(function(){
    $.post("<?php echo base_url().'keuangan/jurnal/filtertahun' ?>", 'tahundata='+$(this).val(),  function(data){
          hidebukututuppenyesuaian(data);
          $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');
    });
});
$("#periodebulanumum_penyesuaian").change(function(){
  $.post("<?php echo base_url().'keuangan/jurnal/filterbulan' ?>", 'bulandata='+$(this).val(),  function(data){
          hidebukututuppenyesuaian(data);
          $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');
    });
});
$("#filterpuskesmas_penyesuaian").change(function(){
  $.post("<?php echo base_url().'keuangan/jurnal/filterpuskesmas_penyesuaian' ?>", 'puskes='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_penyesuaian").jqxTreeGrid('updateBoundData');
    });
});
$("#add_jurnal_umum_penyesuaian").click(function(){
  $("#popup_jurnal_penyesuaian #popup_content_penyesuaian").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/pilih_tipe_transaksijurum/jurnal_penyesuaian'; ?>", function(data) {
    $("#popup_content_penyesuaian").html(data);
  });
  $("#popup_jurnal_penyesuaian").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal_penyesuaian").jqxWindow('open');
});
function hidebukututuppenyesuaian(databaru){
  blnbuku = $("#periodebulanumum_penyesuaian").val();
  thnbuku = $("#periodetahunumum_penyesuaian").val();
  if (databaru=='undefined' || databaru==null) {
    tgldatabejalan = "<?php echo $tgldatabejalan ?>".split("-");
  }else{
    tgldatabejalan = databaru.split("-");
  }
  blnberjalan = parseInt(tgldatabejalan[1]);
  thnberjalan = tgldatabejalan[0];
  if (blnbuku==blnberjalan && thnbuku==thnberjalan) {
    $("#add_jurnal_umum_penyesuaian").show();
    $("#add_jurnal_umum_penyesuaian_otomatis").show();
  }else{
    $("#add_jurnal_umum_penyesuaian").hide();
    $("#add_jurnal_umum_penyesuaian_otomatis").hide();
  }
}
</script>