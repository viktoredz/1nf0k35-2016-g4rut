<section class="content">
<form action="<?php echo base_url()?>inventory/bhp_distribusi/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
	        <div class="box-header">
	          <h3 class="box-title">{title_form}</h3>
		    </div>
	      	<div class="box-footer">
		      <div class="col-md-8">
		      	<?php //if($unlock==1){ ?>
			 	<button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>inventory/bhp_distribusi/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Dokumen Distribusi Baru</button>
				<?php //} ?>		 	
			 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
	          <button type="button" id="btn-export" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Export</button>
		     </div>
		      <div class="col-md-4">
		     	<div class="row">
			     	<div class="col-md-4" style="padding-top:5px;"><label> Puskesmas </label> </div>
			     	<div class="col-md-8">
			     		<select name="code_cl_phc" id="puskesmas" class="form-control">
							<?php foreach ($datapuskesmas as $row ) { ;?>
								<option value="<?php echo $row->code; ?>" onchange="" ><?php echo $row->value; ?></option>
							<?php	} ;?>
				     	</select>
				     </div>	
		     	</div>
			  </div>
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
	    $("#menu_bahan_habis_pakai").addClass("active");
	    $("#menu_inventory_bhp_distribusi").addClass("active");
	});
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_inv_inventaris_habispakai_distribusi', type: 'string'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'tgl_distribusi', type: 'date'},
			{ name: 'jenis_bhp', type: 'string'},
			{ name: 'nomor_dokumen', type: 'string'},
			{ name: 'bln_periode', type: 'string' },
			{ name: 'penerima_nama', type: 'string'},
			{ name: 'jumlah', type: 'string'},
			{ name: 'penerima_nip', type: 'string'},
			{ name: 'keterangan', type: 'string'},
			{ name: 'detail', type: 'number'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('inventory/bhp_distribusi/json'); ?>",
		cache: false,
			updateRow: function (rowID, rowData, commit) {
             
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
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100', '200'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: true,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'View', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.detail==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_inv_inventaris_habispakai_distribusi+"\",\""+dataRecord.jenis_bhp+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lockdo.gif'></a></div>";
					}
                 }
                },
				{ text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_inv_inventaris_habispakai_distribusi+"\",\""+dataRecord.jenis_bhp+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
			    	if(dataRecord.delete==1){		
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_inv_inventaris_habispakai_distribusi+"\",\""+dataRecord.jumlah+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'Nomor Dokumen', align: 'center', editable:false ,datafield: 'nomor_dokumen', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{ text: 'Tgl. Distribusi',editable:false , align: 'center', cellsalign: 'center', datafield: 'tgl_distribusi', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', width: '11%' },
				{ text: 'Periode', editable:false ,align: 'center', cellsalign: 'center', datafield: 'bln_periode', columntype: 'textbox', filtertype: 'textbox', width: '12%' },
				{ text: 'Jenis Barang', editable:false ,align: 'center', cellsalign: 'left', datafield: 'jenis_bhp', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{ text: 'Jumlah', editable:false ,align: 'center', cellsalign: 'right', datafield: 'jumlah', columntype: 'textbox', filtertype: 'none', width: '10%' },
				{ text: 'Nama Penerima', align: 'center', editable:false ,datafield: 'penerima_nama', columntype: 'textbox', filtertype: 'textbox', width: '25%' }
            ]
		});

	function detail(id,jenis){
		var idjenis = '0';
		if (jenis.toLowerCase()=="obat") {
			idjenis = '8';
		}else{
			idjenis = '0';
		}
		document.location.href="<?php echo base_url().'inventory/bhp_distribusi/detail';?>/" + id+'/'+idjenis  ;
	}

	function edit(id,jenis){
		var idjenis = '0';
		if (jenis.toLowerCase()=="obat") {
			idjenis = '8';
		}else{
			idjenis = '0';
		}
		document.location.href="<?php echo base_url().'inventory/bhp_distribusi/edit';?>/" + id+'/'+idjenis ;
	}

	function view(id){
		document.location.href="<?php echo base_url().'inventory/bhp_distribusi/view';?>/" + id;
	}

	function del(id,jumlah){
		if(jumlah>0){
			alert('Maaf, Data ini tidak bisa dihapus karena sudah ada data distribusi sebanyak '+ jumlah +' unit \n Jika ingin menghapus data ini silahkan hapus pengadaan barang didalamnya');
		}else{
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'inventory/bhp_distribusi/dodel' ?>/"+id,  function(){
				alert('data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
		}
	}

	$("#btn-export").click(function(){
		
		var post = "";
		var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
		for(i=0; i < filter.length; i++){
			var fltr 	= filter[i];
			var value	= fltr.filter.getfilters()[0].value;
			var condition	= fltr.filter.getfilters()[0].condition;
			var filteroperation	= fltr.filter.getfilters()[0].operation;
			var filterdatafield	= fltr.filtercolumn;
			if(filterdatafield=="tgl_permohonan"){
				var d = new Date(value);
				var day = d.getDate();
				var month = d.getMonth();
				var year = d.getYear();
				value = year+'-'+month+'-'+day;
				
			}
			post = post+'&filtervalue'+i+'='+value;
			post = post+'&filtercondition'+i+'='+condition;
			post = post+'&filteroperation'+i+'='+filteroperation;
			post = post+'&filterdatafield'+i+'='+filterdatafield;
			post = post+'&'+filterdatafield+'operator=and';
		}
		post = post+'&filterscount='+i;
		
		var sortdatafield = $("#jqxgrid").jqxGrid('getsortcolumn');
		if(sortdatafield != "" && sortdatafield != null){
			post = post + '&sortdatafield='+sortdatafield;
		}
		if(sortdatafield != null){
			var sortorder = $("#jqxgrid").jqxGrid('getsortinformation').sortdirection.ascending ? "asc" : ($("#jqxgrid").jqxGrid('getsortinformation').sortdirection.descending ? "desc" : "");
			post = post+'&sortorder='+sortorder;
			
		}
		post = post+'&puskes='+$("#puskesmas option:selected").text();
		
		$.post("<?php echo base_url()?>inventory/bhp_distribusi/distribusi_export_umum",post,function(response){
			//alert(response);
			window.location.href=response;
		});
	});
</script>