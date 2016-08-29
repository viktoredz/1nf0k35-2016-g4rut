<div class="row" style="margin: 0">
  <div class="col-md-12">
    <div class="box-footer" style="background: #FAFAFA;text-align: right">
      <button type="button" class="btn btn-primary" id="btn-berhenti-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
      <button type="button" class="btn btn-warning" id="btn-berhenti-tambah"><i class='fa fa-plus-circle'></i> &nbsp; Tambah SK Berhenti</button>
       </div>
        <div class="box-body">
          <div class="div-grid">
              <div id="jqxgridBerhenti"></div>
          </div>
        </div>
      </div>
    </div>
</div>

<div id="popup_berhenti" style="display:none">
  <div id="popup_title_berhenti">SK Pemberhentian Pegawai</div>
  <div id="popup_berhenti_content">&nbsp;</div>
</div>
<script type="text/javascript">
     var sourcegaji = {
      datatype: "json",
      type  : "POST",
      datafields: [
     
      { name: 'id_pegawai', type: 'string'},
      { name: 'tmt', type: 'date'},
      { name: 'tmt2', type: 'string'},
      { name: 'jenis', type: 'date'},
      { name: 'kategori', type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('kepegawaian/drh_berhenti/json/{id}'); ?>",
    cache: false,
    updaterow: function (rowid, rowdata, commit) {
      },
    filter: function(){
      $("#jqxgridBerhenti").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridBerhenti").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        sourcegaji.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadaptergaji = new $.jqx.dataAdapter(sourcegaji, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $('#btn-gaji-refresh').click(function () {
      $("#jqxgridBerhenti").jqxGrid('clearfilters');
    });

    $("#jqxgridBerhenti").jqxGrid(
    {   
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadaptergaji, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },
      columns: [
        { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridBerhenti").jqxGrid('getrowdata', row);
            if(dataRecord.edit==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt2+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
          }
                 }
                },
        { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridBerhenti").jqxGrid('getrowdata', row);
            if(dataRecord.delete==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del (\""+dataRecord.id_pegawai+"\",\""+dataRecord.tmt2+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
          }
                 }
                },
        { text: 'TMT', datafield: 'tmt', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '25%' },
        { text: 'Kategori', datafield: 'kategori', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '34%' },
        { text: 'Jenis', datafield: 'jenis', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '33%' }
            ],
    });

  function detail(id,tmt){
    $("#popup_berhenti #popup_berhenti_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_berhenti/edit' ?>/"+id+"/"+tmt, function(data) {
        $("#popup_berhenti_content").html(data);
      });
      $("#popup_berhenti").jqxWindow({
        theme: theme, resizable: false,
        width: 600,
        height: 550,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_berhenti").jqxWindow('open');
  }
 
  function del(id,tmt){
       var confirms = confirm("Hapus Data ?");
    if(confirms == true){
      $.post("<?php echo base_url().'kepegawaian/drh_berhenti/delete' ?>/" + id +"/"+tmt,   function(){
        alert('Data berhasil dihapus');

        $("#jqxgridBerhenti").jqxGrid('updatebounddata', 'cells');
      });
    }
  }

  $(function () { 
    $("#btn-berhenti-tambah").click(function(){
      $("#popup_berhenti #popup_berhenti_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
      $.get("<?php echo base_url().'kepegawaian/drh_berhenti/add/'.$id;?>" , function(data) {
        $("#popup_berhenti_content").html(data);
      });
      $("#popup_berhenti").jqxWindow({
        theme: theme, resizable: false,
        width: 500,
        height: 420,
        isModal: true, autoOpen: false, modalOpacity: 0.2
      });
      $("#popup_berhenti").jqxWindow('open');
    });
  });

</script>
