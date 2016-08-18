
<section class="content">
<div class="box-header">
  <h3 class="box-title">{title}</h3>
</div>

	
<div class="box-body">
    <div class="div-grid">
        <div id="jqxgridinventaris"></div>
	</div>
</div>
<div class="box-header pull-right">
	<button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-plus"></i> Tambahkan</button>
	<button type="button" id="btn-close_inventaris" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
</div>
</section>

<script type="text/javascript">
var source = {
	datatype: "json",
	type	: "POST",
	datafields: [
	{ name: 'id_inventaris', type: 'string'},
	{ name: 'nm_iventaris', type: 'string'},
],
url: "<?php echo site_url('keuangan/jurnal/json_penyusutan'); ?>",		
cache: false,
updateRow: function (rowID, rowData, commit) {
	 commit(true);	
 },
filter: function(){
	$("#jqxgridinventaris").jqxGrid('updatebounddata', 'filter');
},
sort: function(){
	$("#jqxgridinventaris").jqxGrid('updatebounddata', 'sort');
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
	$("#jqxgridinventaris").jqxGrid('clearfilters');
});

$("#jqxgridinventaris").jqxGrid(
{		
	width: '100%',
	selectionmode: 'singlerow',
	source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
	showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
	rendergridrows: function(obj)
	{
		return obj.data;
	},
	columns: [
		{ text: 'Pilih', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
		    var dataRecord = $("#jqxgridinventaris").jqxGrid('getrowdata', row);
			return "<div style='width:100%;padding-top:2px;text-align:center'><input type='checkbox' name='aset[]' value="+dataRecord.id_inventaris+"_td_"+dataRecord.nm_iventaris+" ></div>";
         }
        },
		{ text: 'Id Inventaris', align: 'center', cellsalign: 'center' , sortable: false,editable:false , datafield: 'id_inventaris', columntype: 'textbox', filtertype: 'textbox', width: '19%' },
		{ text: 'Nama', align: 'center', cellsalign: 'center',editable:true ,datafield: 'nm_iventaris', columntype: 'textbox', filtertype: 'textbox', width: '75%' },
    ]
});

$("#btn-close_inventaris").click(function(){
	$("#popup_inventaris").jqxWindow('close');
});

function add_barang(data_barang){
	$("#popup_barang #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
	$.get("<?php echo base_url().'keuangan/jurnal/pop_add'; ?>"+data_barang ,  function(data) {
		$("#popup_content").html(data);
	});
	$("#popup_barang").jqxWindow({
		theme: theme, resizable: false,
		width: 700,
		height: 600,
		isModal: true, autoOpen: false, modalOpacity: 0.2
	});
	$("#popup_barang").jqxWindow('open');
}
	
function doList(){				
	var values = new Array();	
	var	data_barang = "/";
	$.each($("input[name='aset[]']:checked"), function() {
	  values.push($(this).val());		
	});
	//alert(values);
	
	if(values.length > 0){
		for(i=0; i<values.length; i++){
			data_barang = data_barang+values[i]+"_tr_";
		}
		add_barang(data_barang);
	}else{
		alert('Silahkan Pilih Barang Terlebih Dahulu');
	}	
}

</script>
