<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <?php foreach ($datagrid as $keydata) { ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingThree<?php echo $keydata['id_instansi']?>">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree<?php echo $keydata['id_instansi']?>" aria-expanded="false" aria-controls="collapseThree<?php echo $keydata['id_instansi']?>">
          <?php echo ($keydata['nama_instansi']=='' ? 'Bukan Perusahaan' : ucwords(strtolower($keydata['nama_instansi']))) ?>
        </a>
      </h4>
    </div>
    <div id="collapseThree<?php echo $keydata['id_instansi']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree<?php echo $keydata['id_instansi']?>">
      <div class="panel-body">
        <!--grid-->
        <div class="box-body">
          <div class="pull-right" style="padding:0 0 10px 0 ">>
            <button type="button" class="btn btn-primary" id="bt_export<?php echo $keydata['id_instansi']?>" onclick=""><i class='glyphicon glyphicon-download-alt'></i> &nbsp; Export</button>
            <button type="button" class="btn btn-success" id="btn-refreshdata<?php echo $keydata['id_instansi']?>"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
          </div>
            <div class="div-grid">
                <div id="jqxgrid<?php echo $keydata['id_instansi']?>"></div>
          </div>
        </div>
        <!--end grid-->
      </div>
    </div>
  </div>
  <?php } ?>
</div>
<script type="text/javascript">
<?php foreach ($datagrid as $keydata) { ?>
     var source<?php echo $keydata['id_instansi']?> = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'no', type: 'number'},
      { name: 'code_cl_phc', type: 'string'},
      { name: 'id_jurnal', type: 'string'},
      { name: 'id_keu_transaksi_inventaris', type: 'string'},
      { name: 'id_instansi', type: 'string'},
      { name: 'tanggal', type: 'date'},
      { name: 'kode', type: 'string'},
      { name: 'status', type: 'string'},
      { name: 'keterangan', type: 'number'},
      { name: 'debet', type: 'number'},
      { name: 'kredit', type: 'number'},
      { name: 'saldo', type: 'number'},
      { name: 'edit', type: 'number'}
        ],
    url: "<?php echo base_url().'keuangan/bukubesar/json_tambah/'.$id_judul.'/'.$keydata['id_instansi']; ?>",
    cache: false,
    updateRow: function (rowID, rowData, commit) {
        },
    filter: function(){
      $("#jqxgrid<?php echo $keydata['id_instansi']?>").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgrid<?php echo $keydata['id_instansi']?>").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        source<?php echo $keydata['id_instansi']?>.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapter<?php echo $keydata['id_instansi']?> = new $.jqx.dataAdapter(source<?php echo $keydata['id_instansi']?>, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $("#btn-refreshdata<?php echo $keydata['id_instansi']?>").click(function () {
      var idjudul = $("#changemodeshow").val();
      $("#jqxgrid<?php echo $keydata['id_instansi']?>").jqxGrid('clearfilters');
    });

    $("#jqxgrid<?php echo $keydata['id_instansi']?>").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapter<?php echo $keydata['id_instansi']?>, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
                { text: 'No', align: 'center', cellsalign: 'center',  datafield: 'no',editable:false ,sortable: false, filtertype: 'none', width: '4%' },
        { text: 'Tanggal', align: 'center', cellsalign: 'center', editable:false , datafield: 'tanggal', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '9%' },
        { text: 'Kode Akun', editable:false ,datafield: 'kode',cellsalign: 'center', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
        { text: 'Keterangan', align: 'center', cellsalign: 'left', editable:false ,datafield: 'keterangan', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
        { text: 'Ref', align: 'center', cellsalign: 'center',width: '5%', editable:false,filtertype: 'none' , cellsrenderer: function (row) {
            var dataRecord = $("#jqxgrid<?php echo $keydata['id_instansi']?>").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_jurnal+"\",\""+dataRecord.id_instansi+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
              },
        { text: 'Debet', editable:false ,datafield: 'debet', cellsalign: 'right',columntype: 'textbox', filtertype: 'textbox', width: '15%' },
        { text: 'Kredit', editable:false ,datafield: 'kredit', cellsalign: 'right',columntype: 'textbox', filtertype: 'textbox', width: '15%' },
        { text: 'Saldo', editable:false ,datafield: 'saldo', cellsalign: 'right',columntype: 'textbox', filtertype: 'textbox', width: '15%' },
            ]
    });

  <?php } ?>
  </script>