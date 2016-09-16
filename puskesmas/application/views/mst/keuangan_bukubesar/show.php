
<div id="popup_bukubesar" style="display:none">
	<div id="popup_title">Data Barang</div>
	<div id="popup_content">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>mst/keuangan_bukubesar/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
	    </div>

	      <div class="box-footer">
		 	<button type="button" class="btn btn-primary" onclick="add()"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
		 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	     </div>
        <div class="box-body">
		    <div class="div-grid">
		        <div id="jqxgrid"></div>
			</div>
	    </div>
	  </div>
	</div>
  </div>
</form>
</section>

<script type="text/javascript">
	$(function () {	
		$("#menu_mst_keuangan_bukubesar").addClass("active");
		$("#menu_master_data").addClass("active");
	});
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_mst_bukubesar', type: 'string'},
			{ name: 'judul', type: 'string'},
			{ name: 'deskripsi', type: 'string'},
			{ name: 'pisahkan_berdasar', type: 'string'},
			{ name: 'aktif', type: 'string'},
			{ name: 'view', type: 'number'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('mst/keuangan_bukubesar/json'); ?>",
		cache: false,
		updaterow: function (rowid, rowdata, commit) {
			},
		filter: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'sort');
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
     
		$('#btn-refresh').click(function () {
			$("#jqxgrid").jqxGrid('clearfilters');
		});

		$("#jqxgrid").jqxGrid(
		{		
			width: '70%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'View', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.view==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='viewdata(\""+dataRecord.id_mst_bukubesar+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_mst_bukubesar+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.delete==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_mst_bukubesar+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Judul Buku Besar',align: 'center',  datafield: 'judul', columntype: 'textbox', filtertype: 'textbox', width: '56%' },
				{ text: 'Aktif',align: 'center',  datafield: 'aktif', columntype: 'textbox', filtertype: 'none', width: '20%', cellsrenderer: function (row) {
					    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
					    if(dataRecord.aktif==1){
							return "<div style='width:100%;padding-top:2px;text-align:center'><input type='checkbox' name='cekboxdata' onclick='pilihaktip(\""+dataRecord.id_mst_bukubesar+"\")' checked></div>";
						}else{
							return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><input type='checkbox' name='cekboxdata' onclick='pilihaktip(\""+dataRecord.id_mst_bukubesar+"\")'></div>";
						}
	                 }
                }

            ]
		});

	function edit(id){
		$("#popup_bukubesar #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url()?>mst/keuangan_bukubesar/edit/"+id , function(data) {
			$("#popup_content").html(data);
		});
		$("#popup_bukubesar").jqxWindow({
			theme: theme, resizable: false,
			width: 600,
			height: 700,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_bukubesar").jqxWindow('open');
	}
	function viewdata(id){
		$("#popup_bukubesar #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url()?>mst/keuangan_bukubesar/view/"+id , function(data) {
			$("#popup_content").html(data);
		});
		$("#popup_bukubesar").jqxWindow({
			theme: theme, resizable: false,
			width: 600,
			height: 700,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_bukubesar").jqxWindow('open');
	}
	function del(id){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'mst/keuangan_bukubesar/dodel' ?>/" + id,  function(){
				alert('data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
	function add(){
		$("#popup_bukubesar #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url()?>mst/keuangan_bukubesar/add" , function(data) {
			$("#popup_content").html(data);
		});
		$("#popup_bukubesar").jqxWindow({
			theme: theme, resizable: false,
			width: 600,
			height: 700,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_bukubesar").jqxWindow('open');
	}
	function pilihaktip(id){
		$.post("<?php echo base_url()?>mst/keuangan_bukubesar/updatedata",{'id':id}, function(data) {
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
	}
	function close_popup(){
		$("#popup_bukubesar").jqxWindow('close');
		$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
	}
</script>