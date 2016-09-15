<div id="popup_jurnal_penutup" style="display:none">
  <div id="popup_title_penutup">Data Jurnal</div>
  <div id="popup_content_penutup">&nbsp;</div>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-footer pull-right">
         <button type="button" class="btn btn-danger" id="btnexpandall_penutup"><i class='icon fa fa-plus-square-o'></i> &nbsp; Expand All</button> 
         <button type="button" class="btn btn-warning" id="btncollapseall_penutup"><i class='icon fa fa-minus-square-o'></i> &nbsp; Collapse All</button>
         <button type="button" class="btn btn-primary" id="jqxgrid_refresh_penutup"><i class='fa fa-refresh'></i> &nbsp; Refresh</button> 
         <button type="button" class="btn btn-success" onclick='export(1)'><i class='glyphicon glyphicon-floppy-disk'></i> &nbsp; Export</button> 
         <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" id="btn_jurnal_penutup"><i class='glyphicon glyphicon-folder-close'></i> &nbsp; Penutup</button> 
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
                    <select class="form-control" id="filekategori_penutup" name="filekategori_penutup">
                        <option value="all">Semua Kategori </option>
                      <?php foreach ($filekategori as $key) {?>
                        <option value="<?php echo $key['id_mst_kategori_transaksi'];?>"><?php echo $key['nama']?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="col-md-5">
                    <div class="row">
                      <div class="col-md-4" style="padding:5px;">
                        <div class="pull-right"><b>Puskesmas</b></div>
                      </div>
                      <div class="col-md-8">
                          <select class="form-control" id="filterpuskesmas_penutup" name="filterpuskesmas_penutup"> 
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
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-3" style="padding:5px">
                    <label> Periode</label>
                  </div>
                  <div class="col-md-5">
                    <select class="form-control" id="periodebulanumum_penutup" name="periodebulanumum_penutup"> 
                      <?php foreach ($bulan as $key => $value) { 
                        $select = ($key==date('n') ? 'selected' : '');
                      ?>  
                        <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <select class="form-control" id="periodetahunumum_penutup" name="periodetahunumum_penutup">
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
            </div>
            <div class="col-md-4">
              
            </div>
          </div>
        </div>
        <div class="box-body">
          <div class="div-grid">
            <div id="jqxgrid_jurnal_penutup"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Tutup Buku</b></h4>
      </div>
      <div class="modal-body">
        <?php $tglpisah = explode("-", $tgldatabejalan); ?>
        <p><b>Konfirmasi tutup buku periode <?php echo $tglpisah[2].' '.namabulan($tglpisah[1]).' - '.lastdate($tglpisah[1],$tglpisah[0]).' '.namabulan($tglpisah[1]).' '.$tglpisah[0]; ?></b></p>
        <p>Sebelum tutup buku, pastikan transaksi periode ini dan transaksi untuk tutup buku sudah dimasukan. Jurnal yang sudah ditutup tidak bisa dirubah lagi.</p>
        <p><b>Yakin akan menutup buku periode ini ?</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="tutupbukujurnal()" data-dismiss="modal">Penutup</button>
      </div>
    </div>
    
  </div>
</div>
<?php
function lastdate($bulan, $tahun){
  $tanggal =  date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date($bulan).'/01/'.date($tahun).' 00:00:00'))));
  $tgl = explode("-", $tanggal);
  return $tgl[2];
}
function namabulan($bulan)
{
Switch ($bulan){
    case 1 : $bulan="Januari";
        Break;
    case 2 : $bulan="Februari";
        Break;
    case 3 : $bulan="Maret";
        Break;
    case 4 : $bulan="April";
        Break;
    case 5 : $bulan="Mei";
        Break;
    case 6 : $bulan="Juni";
        Break;
    case 7 : $bulan="Juli";
        Break;
    case 8 : $bulan="Agustus";
        Break;
    case 9 : $bulan="September";
        Break;
    case 10 : $bulan="Oktober";
        Break;
    case 11 : $bulan="November";
        Break;
    case 12 : $bulan="Desember";
        Break;
    }
return $bulan;
}
?>
<script type="text/javascript">
$(document).ready(function () {
    hidebukututup();
    $('#btnexpandall_penutup').click(function () {
        $("#jqxgrid_jurnal_penutup").jqxTreeGrid('expandAll');
    });
    $('#btncollapseall_penutup').click(function () {
       $("#jqxgrid_jurnal_penutup").jqxTreeGrid('collapseAll');
    });
    $("#jqxgrid_refresh_penutup").click(function(){
        $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');
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
        url: "<?php echo site_url('keuangan/jurnal/json_jurnal_penutup'); ?>",
    };
      var dataAdapter = new $.jqx.dataAdapter(source, {
          loadComplete: function () {
          }
      });
    // create Tree Grid
    $("#jqxgrid_jurnal_penutup").jqxTreeGrid(
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
           $("#jqxgrid_jurnal_penutup").jqxTreeGrid('expandAll');            
        },
        pagerButtonsCount: 8,
        toolbarHeight: 40,
        columns: [
          { text: 'Action', dataField: 'id_jurnal', align:'center', width: '7%', cellsrenderer: function (row, dataField, cellText, rowData) {
              if(rowData.edit==1){
                return "<div style='width:100%;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail_penutup(\""+rowData.id_transaksi+"\");'></a></div>";
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
function detail_penutup(id){   
  $("#popup_jurnal_penutup #popup_content_penutup").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/detail_jurnal_umum/'; ?>"+id+'/jurnal_penutup', function(data) {
    $("#popup_content_penutup").html(data);
  });
  $("#popup_jurnal_penutup").jqxWindow({
    theme: theme, resizable: false,
    width: 600,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_jurnal_penutup").jqxWindow('open');
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
$("#filekategori_penutup").change(function(){

  $.post("<?php echo base_url().'keuangan/jurnal/filterkategori' ?>", 'kategori='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');
    });
});
$("#periodetahunumum_penutup").change(function(){
    $.post("<?php echo base_url().'keuangan/jurnal/filtertahun' ?>", 'tahundata='+$(this).val(),  function(data){
          hidebukututup(data);
          $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');
    });
});
$("#periodebulanumum_penutup").change(function(){
  $.post("<?php echo base_url().'keuangan/jurnal/filterbulan' ?>", 'bulandata='+$(this).val(),  function(data){
          hidebukututup(data);
          $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');
    });
});
$("#filterpuskesmas_penutup").change(function(){
    $.post("<?php echo base_url().'keuangan/jurnal/filterpuskesmas_penutup' ?>", 'puskes='+$(this).val(),  function(){
          $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');
    });
});
function tutupbukujurnal(){
    $.post("<?php echo base_url().'keuangan/jurnal/jurnaltutupbuku' ?>",{'bulan' : $("#periodebulanumum_penutup").val(),'tahun' : $("#periodetahunumum_penutup").val()},  function(data){
          $("#jqxgrid_jurnal_penutup").jqxTreeGrid('updateBoundData');
          hidebukututup(data);
    });
}
function hidebukututup(databaru){
  blnbuku = $("#periodebulanumum_penutup").val();
  thnbuku = $("#periodetahunumum_penutup").val();
  if (databaru=='undefined' || databaru==null) {
    tgldatabejalan = "<?php echo $tgldatabejalan ?>".split("-");
  }else{
    tgldatabejalan = databaru.split("-");
  }
  blnberjalan = parseInt(tgldatabejalan[1]);
  thnberjalan = tgldatabejalan[0];
  if (blnbuku==blnberjalan && thnbuku==thnberjalan) {
    $("#btn_jurnal_penutup").show();
  }else{
    $("#btn_jurnal_penutup").hide();
  }
}
</script>
