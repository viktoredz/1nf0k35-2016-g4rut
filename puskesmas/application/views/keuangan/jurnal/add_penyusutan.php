
<section class="content">
<div class="box-header">
  <h3 class="box-title">{title_form}</h3>
</div>
<div class="box-header">
  <div class="pull-right">
  	<select id="filterkib" class="form-control">
  		<option value="all">ALL KIB</option>
  		<option value="01">KIB A</option>
  		<option value="02">KIB B</option>
  		<option value="03">KIB C</option>
  		<option value="04">KIB D</option>
  	</select>
  </div>
  <div>
  	<button type="button" class="btn btn-success" id="btn-refreshaddpenyusuan"><i class='glyphicon glyphicon-refresh'></i> &nbsp; Refresh</button> 
  </div>
 </div>


<div class="box-body">
    <div class="div-grid">
        <div id="jqxgridinventaris"></div>
	</div>
</div>
<div class="box-header pull-right">
	<button type="button" class="btn btn-primary" onclick="dolist()"><i class="glyphicon glyphicon-plus"></i> Tambahkan</button>
	<button type="button" id="btn-close_inventaris" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
</div>
</section>
<script type="text/javascript">
$("#filterkib").change(function(){
	$.post("<?php echo base_url().'keuangan/jurnal/filterkib' ?>", 'kibdata='+$(this).val(),  function(){
          $("#jqxgridinventaris").jqxGrid('updatebounddata', 'cell');
    });
});
var source = {
	datatype: "json",
	type	: "POST",
	datafields: [
	{ name: 'id_inventaris_barang', type: 'string'},
	{ name: 'register', type: 'string'},
	{ name: 'id_mst_inv_barang', type: 'string'},
	{ name: 'nama_barang', type: 'string'},
	{ name: 'harga', type: 'string'},
	{ name: 'showid_inventaris_barang', type: 'string'},
	{ name: 'edit', type: 'string'},
],
url: "<?php echo base_url().'keuangan/jurnal/json_penyusutan/'.$id; ?>",		
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

$('#btn-refreshaddpenyusuan').click(function () {
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
		{ text: 'Pilih', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
		    var dataRecord = $("#jqxgridinventaris").jqxGrid('getrowdata', row);
			return "<div style='width:100%;padding-top:2px;text-align:center'><input type='checkbox' name='aset[]' value=\""+dataRecord.id_inventaris_barang+"\" ></div>";
         }
        },
		{ text: 'Id Inventaris', align: 'center', cellsalign: 'center' , sortable: false,editable:false , datafield: 'showid_inventaris_barang', columntype: 'textbox', filtertype: 'textbox', width: '30%' },
		{ text: 'Register', align: 'center', cellsalign: 'center' , sortable: false,editable:false , datafield: 'register', columntype: 'textbox', filtertype: 'textbox', width: '10%' },
		{ text: 'Nama', align: 'center', editable:true ,datafield: 'nama_barang', columntype: 'textbox', filtertype: 'textbox', width: '52%' },
    ]
});

$("#btn-close_inventaris").click(function(){
	$("#popup_inventaris").jqxWindow('close');
});


	
function dolist(){	
	var values = new Array();	
	var	data_barang = "";
	$.each($("input[name='aset[]']:checked"), function() {
	  values.push($(this).val());		
	});
	
	
	if(values.length > 0){
		for(i=0; i<values.length; i++){
			data_barang = data_barang+values[i]+"_tr_";
		}
		$.post("<?php echo base_url().'keuangan/jurnal/add_inventaris/'.$id.'/'.$id_mst_keu_transaksi; ?>",{'data_barang': data_barang},  function(data) {
			$("#popup_inventaris").jqxWindow('close');
			addinventaris(data);
		});
	}else{
		alert('Silahkan Pilih Barang Terlebih Dahulu');
	}	
}

</script>
