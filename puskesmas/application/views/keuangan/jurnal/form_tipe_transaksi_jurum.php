
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
      { name: 'id_inv_hasbispakai_pembelian', type: 'string' },
      { name: 'id_mst_inv_barang_habispakai', type: 'number' },
      { name: 'uraian', type: 'string' },
      { name: 'jml', type: 'number' },
      { name: 'tgl_opname', type: 'string' },
      { name: 'batch', type: 'string' },
      { name: 'harga', type: 'string' },
      { name: 'jumlah', type: 'string' },
      { name: 'subtotal', type: 'string' },
      { name: 'harga', type: 'double' },
      { name: 'tgl_update', type: 'date' },
      { name: 'edit', type: 'number'},
      { name: 'delete', type: 'number'}
        ],
    url: "<?php echo site_url('inventory/bhp_distribusi/barang/'); ?>",
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
        { text: 'Kategori', editable: false,datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox', width: '50%'},
        { text: 'Transaksi',datafield: 'batch' ,align: 'center', editable: false, columntype: 'textbox', filtertype: 'textbox', width: '50%'},
           
      ]
    });
        
        
    $('#refreshdatabutton').click(function () {
      $("#jqxgridpilihtipe").jqxGrid('updatebounddata', 'cells');
    });


</script>

<div class="box-body">
  <div id="notice" class="alert alert-success alert-dismissable" <?php if ($notice==""){ echo 'style="display:none"';} ?> >
    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>
    <i class="icon fa fa-check"></i>
    Information!
    </h4>
    <div id="notice-content">{notice}</div>
  </div>
	<div class="row">
    <?php echo form_open(current_url(), 'id="form-ss-jurnal_umum"') ?>
    <div class="box-body">
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>{title}</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h4>Favorit</h4></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-6">
              <div class="alert alert-success" role="alert">
                ...
              </div>
          </div>
          <div class="col-md-6">
            <div class="alert alert-info" role="alert">
              ...
            </div>
          </div>
        </div>
    </div>
    <div class="box-body">
      <div id="jqxgridpilihtipe"></div>
    </div>
    <div class="box-footer pull-right">
          <button type="button" id="btn-close" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
    </div>
    </form>
  </div>
</div>
