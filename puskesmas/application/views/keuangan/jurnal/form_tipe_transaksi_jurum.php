<script type="text/javascript">
  $(function(){
   
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
                    $("#jqxgridpilihtipe").jqxGrid('updatebounddata', 'cells');
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
var source = {
      datatype: "json",
      type  : "POST",
      datafields: [
      { name: 'id_mst_transaksi', type: 'string' },
      { name: 'nama', type: 'string' },
      { name: 'namakategori', type: 'string' },
      { name: 'untuk_jurnal', type: 'string' },
      { name: 'deskripsi', type: 'string' },
      { name: 'detail', type: 'number' },
        ],
    url: "<?php echo site_url('keuangan/jurnal/json_transaksi/'); ?>",
    cache: false,
    updateRow: function (rowID, rowData, commit) {
            commit(true);
    },
    filter: function(){
      $("#jqxgridpilihtipe").jqxGrid('updatebounddata', 'filter');
    },
    sort: function(){
      $("#jqxgridpilihtipe").jqxGrid('updatebounddata', 'sort');
    },
    root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){   
      if (data != null){
        source.totalrecords = data[0].TotalRows;          
      }
    }
    };    
    var dataadapter = new $.jqx.dataAdapter(source, {
      loadError: function(xhr, status, error){
        alert(error);
      }
    });
     
    $("#jqxgridpilihtipe").jqxGrid(
    { 
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
      rendergridrows: function(obj)
      {
        return obj.data;    
      },

      columns: [
        { text: 'Add', align: 'center', filtertype: 'none', sortable: false, width: '10%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridpilihtipe").jqxGrid('getrowdata', row);
            if(dataRecord.detail==1){
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_add.gif' onclick='pilihjurnal(\""+dataRecord.id_mst_transaksi+"\");'></a></div>";
          }else{
            return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lockdo.gif'></a></div>";
          }
                 }
        },
        { text: 'Kategori', editable: false,datafield: 'namakategori', columntype: 'textbox', filtertype: 'textbox', width: '45%'},
        { text: 'Transaksi',datafield: 'nama' ,align: 'center', editable: false, columntype: 'textbox', filtertype: 'textbox', width: '45%'},
           
      ]
    });
        
        
    $('#refreshdatabutton').click(function () {
      $("#jqxgridpilihtipe").jqxGrid('updatebounddata', 'cells');
    });
    function pilihjurnal(id){
      if(confirm("Anda yakin akan membuat jurnal ini?")){
        close_popup();
        $.get("<?php echo base_url().'keuangan/jurnal/add_junal_umum/'; ?>"+id, function(data) {
          $("#content1").html(data);
        });
      }
    }
</script>

<div class="box-body">
    <div class="box-body" style="margin: 0px"><h4>{title}</h4></div>
    <div class="box-body">
      <div id="jqxgridpilihtipe"></div>
    </div>
    <div class="box-footer pull-right">
        <button type="button" id="btn-close" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
    </div>
</div>
