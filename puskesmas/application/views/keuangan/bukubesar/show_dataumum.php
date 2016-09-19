<div class="box-body">
	<div class="pull-right" style="padding:0 0 10px 0 ">
		<button type="button" class="btn btn-primary" id="bt_export{id_judul}" onclick=""><i class='glyphicon glyphicon-download-alt'></i> &nbsp; Export</button>
		<button type="button" class="btn btn-success" id="btn-refreshdata{id_judul}"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	</div>
    <div class="div-grid">
        <div id="jqxgrid{id_judul}"></div>
	</div>
</div>

<script type="text/javascript">

	   var source{id_judul} = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'no', type: 'number'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'id_jurnal', type: 'string'},
			{ name: 'id_keu_transaksi_inventaris', type: 'string'},
			{ name: 'id_transaksi', type: 'string'},
			{ name: 'tanggal', type: 'date'},
			{ name: 'kode', type: 'string'},
			{ name: 'status', type: 'string'},
			{ name: 'keterangan', type: 'number'},
			{ name: 'debet', type: 'number'},
			{ name: 'kredit', type: 'number'},
			{ name: 'saldo', type: 'number'},
			{ name: 'edit', type: 'number'}
        ],
		url: "<?php echo base_url().'keuangan/bukubesar/json_umum/'.$id_judul; ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
        },
		filter: function(){
			$("#jqxgrid{id_judul}").jqxGrid('updatebounddata', 'filter');
		},
		sort: function(){
			$("#jqxgrid{id_judul}").jqxGrid('updatebounddata', 'sort');
		},
		root: 'Rows',
        pagesize: 10,
        beforeprocessing: function(data){		
			if (data != null){
				source{id_judul}.totalrecords = data[0].TotalRows;					
			}
		}
		};		
		var dataadapter{id_judul} = new $.jqx.dataAdapter(source{id_judul}, {
			loadError: function(xhr, status, error){
				alert(error);
			}
		});
     
		$("#btn-refreshdata{id_judul}").click(function () {
			var idjudul = $("#changemodeshow").val();
			$("#jqxgrid{id_judul}").jqxGrid('clearfilters');
		});

		$("#jqxgrid{id_judul}").jqxGrid(
		{		
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter{id_judul}, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
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
				    var dataRecord = $("#jqxgrid{id_judul}").jqxGrid('getrowdata', row);
				    if(dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_jurnal+"\",\""+dataRecord.id_transaksi+"\");'></a></div>";
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


	function edit(id_jurnal,id_transaksi){
		document.location.href="<?php echo base_url().'keuangan/bukubesar/edit';?>/" + id_jurnal + "/" + id_transaksi;
	}
</script>