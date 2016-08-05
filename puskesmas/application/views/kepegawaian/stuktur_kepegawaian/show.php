<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<div id="popup_pegawai" style="display:none">
	<div id="popup_title">Data Login Pegawai</div>
	<div id="popup_content">&nbsp;</div>
</div>
<section class="content">
<form action="<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/dodel_multi" method="POST" name="">
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
		 	<button type="button" class="btn btn-warning" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
		 	<button type="button" class="btn btn-success" id="btn-export"><i class='fa fa-file-excel-o'></i> &nbsp; Export</button>
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
	    $("#menu_kepegawaian").addClass("active");
	    $("#menu_kepegawaian_stuktur_kepegawaian").addClass("active");
	});
	function close_popup(){
		$("#popup_pegawai").jqxWindow('close');
	}
		var sourcejabatan =
	      {
	          datatype: "json",
	          datafields: [
	              { name: 'tar_id_struktur_org' , type: 'string'},
	              { name: 'tar_nama_posisi' , type: 'string'}
	          ],
	          url: '<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/json_kode_jabatan',
	          async: true
	      };
		var kode_jabatan_source = new $.jqx.dataAdapter(sourcejabatan);
	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'no', type: 'number'},
			{ name: 'code_cl_phc', type: 'string'},
			{ name: 'nip_nit', type: 'string'},
			{ name: 'id_pegawai', type: 'string'},
			{ name: 'username', type: 'string'},
			{ name: 'nama', type: 'string'},
			{ name: 'id_mst_peg_golruang', type: 'string'},
			{ name: 'ruang', type: 'string'},
			{ name: 'tar_nama_posisi', type: 'string'},
			{ name: 'detail', type: 'number'},
        ],
		url: "<?php echo site_url('kepegawaian/stuktur_kepegawaian/json'); ?>",
		cache: false,
		updateRow: function (rowID, rowData, commit) {
            commit(true);

         
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
				
				{ text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.detail==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_pegawai+"\",\""+dataRecord.code_cl_phc+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				
				{ text: 'NIP', datafield: 'nip_nit', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center' , cellsalign: 'center', width: '13%'},
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center', width: '25%' },
				{ text: 'Username', datafield: 'username', columntype: 'textbox', editable:false, filtertype: 'textbox', align: 'center', width: '8%' },
				{ text: 'Golongan', align: 'center', cellsalign: 'center', editable:false ,datafield: 'id_mst_peg_golruang', columntype: 'textbox', filtertype: 'textbox', width: '7%' },
				{ text: 'Pangkat', align: 'center', cellsalign: 'center', editable:false ,datafield: 'ruang', columntype: 'textbox', filtertype: 'textbox', width: '15%' },
				{
	                text: '<b><i class="fa fa-pencil-square-o"></i> Jabatan </b>', align: 'center', datafield: 'tar_nama_posisi', width: '28%', columntype: 'dropdownlist',
	                createEditor: function (row, cellvalue, editor, cellText, width, height) {
                       editor.jqxDropDownList({autoDropDownHeight: true,source: kode_jabatan_source, displayMember: "tar_nama_posisi", valueMember: "tar_id_struktur_org"});

                   },
                   initEditor: function (row, cellvalue, editor, celltext, width, height) {
                       editor.jqxDropDownList('selectItem', cellvalue);
                   },
                   getEditorValue: function (row, cellvalue, editor) {
                       editor.val();
                       // /alert(parseInt(editor.val()));
                       	if(editor.val() % 1 === 0){
                       		var datagrid = $("#jqxgrid").jqxGrid('getrowdata', row);
	                       $.post( '<?php echo base_url()?>kepegawaian/stuktur_kepegawaian/updatestatus', {id_jabatan:editor.val(),code_cl_phc:datagrid.code_cl_phc,id_pegawai:datagrid.id_pegawai}, function( data ) {
					            if(data != 0){
					              //alert(data);            
					              $("#jqxgrid").jqxGrid('updatebounddata', 'cells');      
					            }else{
					             // alert("Data berhasil disimpan"); 
					              $("#jqxgrid").jqxGrid('updatebounddata', 'cells');                 
					            }
					        });
                       	}else{
	                       $("#jqxgrid").jqxGrid('updatebounddata', 'cells');                 
                   		}
                   },

                },
            ]
		});

	function detail(id_pegawai,code_cl_phc){
		$("#popup_pegawai #popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$.get("<?php echo base_url().'kepegawaian/stuktur_kepegawaian/add/'; ?>" + id_pegawai+'/'+code_cl_phc, function(data) {
			$("#popup_content").html(data);
		});
		$("#popup_pegawai").jqxWindow({
			theme: theme, resizable: false,
			width: 370,
			height: 370,
			isModal: true, autoOpen: false, modalOpacity: 0.2
		});
		$("#popup_pegawai").jqxWindow('open');
	}
	$("select[name='code_cl_phc']").change(function(){
		$.post("<?php echo base_url().'kepegawaian/stuktur_kepegawaian/filter' ?>", 'code_cl_phc='+$(this).val(),  function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    });
			
	$("#btn-export").click(function(){
		
		var post = "";
		var filter = $("#jqxgrid").jqxGrid('getfilterinformation');
		for(i=0; i < filter.length; i++){
			var fltr 	= filter[i];
			var value	= fltr.filter.getfilters()[0].value;
			var condition	= fltr.filter.getfilters()[0].condition;
			var filteroperation	= fltr.filter.getfilters()[0].operation;
			var filterdatafield	= fltr.filtercolumn;
			if(filterdatafield=="tgl"){
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
		
		$.post("<?php echo base_url()?>inventory/pengadaanbarang/pengadaan_export",post,function(response	){
			window.location.href=response;
		});
	});
</script>











