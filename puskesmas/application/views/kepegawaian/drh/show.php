<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
	<?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
<form action="<?php echo base_url()?>kepegawaian/drh/dodel_multi" method="POST" name="">
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
			 	<button type="button" class="btn btn-primary" onclick="document.location.href='<?php echo base_url()?>kepegawaian/drh/add'"><i class='fa fa-plus-square-o'></i> &nbsp; Tambah</button>
			 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
			 </div>
		     <div class="col-md-4">
		     	<div class="row">
			     	<div class="col-md-4" style="padding-top:5px;"><label> Puskesmas </label> </div>
			     	<div class="col-md-8">
			     		<select name="code_cl_phc" id="code_cl_phc" class="form-control">
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
		$("#menu_kepegawaian_drh").addClass("active");
		$("#menu_kepegawaian").addClass("active");
	});

	function detail(id_pegawai){
      document.location.href="<?php echo base_url()?>kepegawaian/drh/detail/" + id_pegawai;
	}

	   var source = {
			datatype: "json",
			type	: "POST",
			datafields: [
			{ name: 'id_pegawai', type: 'string'},
			{ name: 'nip_lama', type: 'string'},
			{ name: 'nip_baru', type: 'string'},
			{ name: 'nik', type: 'string'},
			{ name: 'nip_nit', type: 'string'},
			{ name: 'nama', type: 'string'},
			{ name: 'jenis_kelamin', type: 'string'},
			{ name: 'tgl_lhr', type: 'date'},
			{ name: 'tmp_lahir', type: 'string'},
			{ name: 'kode_mst_agama', type: 'string'},
			{ name: 'kode_mst_nikah', type: 'string'},
			{ name: 'usia', type: 'string'},
			{ name: 'goldar', type: 'string'},
			{ name: 'edit', type: 'number'},
			{ name: 'delete', type: 'number'}
        ],
		url: "<?php echo site_url('kepegawaian/drh/json'); ?>",
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
			width: '100%',
			selectionmode: 'singlerow',
			source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
			showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
			rendergridrows: function(obj)
			{
				return obj.data;    
			},
			columns: [
				{ text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.edit==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='detail(\""+dataRecord.id_pegawai+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
					}
                 }
                },
				{ text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '5%', cellsrenderer: function (row) {
				    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
				    if(dataRecord.delete==1){
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_pegawai+"\");'></a></div>";
					}else{
						return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
					}
                 }
                },
				{ text: 'NIP', datafield: 'nip_nit', columntype: 'textbox', filtertype: 'textbox', align: 'center' , cellsalign: 'center', width: '20%'},
				{ text: 'Nama', datafield: 'nama', columntype: 'textbox', filtertype: 'textbox', align: 'center', width: '29%' },
				{ text: 'Jenis Kelamin', datafield: 'jenis_kelamin', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '10%' },
				{ text: 'Usia', datafield: 'usia', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '6%' },
				{ text: 'Tanggal Lahir', datafield: 'tgl_lhr', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy', align: 'center', cellsalign: 'center', width: '10%' },
				{ text: 'Tempat Lahir', datafield: 'tmp_lahir', columntype: 'textbox', filtertype: 'textbox', align: 'center', width: '15%' }
            ]
		});

	function edit(id){
		document.location.href="<?php echo base_url().'kepegawaian/drh/edit';?>/" + id;
	}

	function del(id){
		var confirms = confirm("Hapus Data ?");
		if(confirms == true){
			$.post("<?php echo base_url().'kepegawaian/drh/dodel' ?>/" + id,  function(){
				alert('data berhasil dihapus');

				$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
			});
		}
	}
	$("#code_cl_phc").change(function(){
		$.post("<?php echo base_url().'kepegawaian/drh/filter' ?>", 'code_cl_phc='+$(this).val(),  function(){
			$("#jqxgrid").jqxGrid('updatebounddata', 'cells');
		});
    });
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="<?php echo base_url()?>kepegawaian/drh/add" method="POST" name="">
		  <div class="row">
		    <!-- left column -->
		    <div class="col-md-12">
		      <!-- general form elements -->
		      <div class="box box-primary">
		        <div class="box-header">
		          <h3 class="box-title">{title_form}</h3>
		        </div><!-- /.box-header -->
		        <label>--Informasi Utama--</label>
		          <div class="box-body">
		            <div class="form-group">
		              <label>NIP / NIT</label>
		              <input type="text" class="form-control" name="nip_nit" placeholder="ID Penghargaan" value="<?php 
		                if(set_value('nip_nit')=="" && isset($nip_nit)){
		                  echo $nip_nit;
		                }else{
		                  echo  set_value('nip_nit');
		                }
		                ?>">
		            </div>
		            <div class="col-md-6">
			            <div class="form-group">
			              <label>NIP Lama</label>
			              <input type="text" class="form-control" name="nip_lama" placeholder="Nama Penghargaan" value="<?php 
			                if(set_value('nip_lama')=="" && isset($nip_lama)){
			                  echo $nip_lama;
			                }else{
			                  echo  set_value('nip_lama');
			                }
			                ?>">
			            </div>
		            </div>
		            <div class="col-md-6">
			            <div class="form-group">
			              <label>NIP Baru</label>
			              <input type="text" class="form-control" name="nip_baru" placeholder="Deskripsi" value="<?php 
			                if(set_value('nip_baru')=="" && isset($nip_baru)){
			                  echo $nip_baru;
			                }else{
			                  echo  set_value('nip_baru');
			                }
			                ?>">
			            </div>
		            </div>
		            <div class="col-md-6">
			            <div class="form-group">
			              <label>NRK</label>
			              <input type="text" class="form-control" name="nrk" placeholder="Deskripsi" value="<?php 
			                if(set_value('nrk')=="" && isset($nrk)){
			                  echo $nrk;
			                }else{
			                  echo  set_value('nrk');
			                }
			                ?>">
			            </div>
			        </div>
		            <div class="col-md-6">
			            <div class="form-group">
			              <label>Kartu Pegawai</label>
			              <input type="text" class="form-control" name="karpeg" placeholder="Deskripsi" value="<?php 
			                if(set_value('karpeg')=="" && isset($karpeg)){
			                  echo $karpeg;
			                }else{
			                  echo  set_value('karpeg');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Nit</label>
			              <input type="text" class="form-control" name="nit" placeholder="Deskripsi" value="<?php 
			                if(set_value('nit')=="" && isset($nit)){
			                  echo $nit;
			                }else{
			                  echo  set_value('nit');
			                }
			                ?>">
			            </div>
			        </div>
		            <div class="col-md-6">
			            <div class="form-group">
			              <label>Nit PLH</label>
			              <input type="text" class="form-control" name="nit_plh" placeholder="Deskripsi" value="<?php 
			                if(set_value('nit_plh')=="" && isset($nit_plh)){
			                  echo $nit_plh;
			                }else{
			                  echo  set_value('nit_plh');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Nama</label>
			              <input type="text" class="form-control" name="nama" placeholder="Deskripsi" value="<?php 
			                if(set_value('nama')=="" && isset($nama)){
			                  echo $nama;
			                }else{
			                  echo  set_value('nama');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Gelar</label>
			              <input type="text" class="form-control" name="gelar" placeholder="Deskripsi" value="<?php 
			                if(set_value('gelar')=="" && isset($gelar)){
			                  echo $gelar;
			                }else{
			                  echo  set_value('gelar');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Jenis Kelamin</label>
							<select type="text" class="form-control" name="tar_sex">
								<option value="L">Laki-laki</option>
								<option value="P">Perempuan</option>
							</select>			              
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Golongan Darah</label>
				              <select type="text" class="form-control" name="goldar">
				              	<option value="A">A</option>
				              	<option value="AB">AB</option>
				              	<option value="B">B</option>
				              	<option value="O">O</option>
				              </select>
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Tempat Lahir</label>
			              <input type="text" class="form-control" name="tgl_lhr" placeholder="Deskripsi" value="<?php 
			                if(set_value('tgl_lhr')=="" && isset($tgl_lhr)){
			                  echo $tgl_lhr;
			                }else{
			                  echo  set_value('tgl_lhr');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Tanggal Lahir</label>
			              <input type="date" class="form-control" name="tmp_lahir" placeholder="Deskripsi" value="<?php 
			                if(set_value('tmp_lahir')=="" && isset($tmp_lahir)){
			                  echo $tmp_lahir;
			                }else{
			                  echo  set_value('tmp_lahir');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Agama</label>
			              <input type="text" class="form-control" name="kode_mst_agama" placeholder="Deskripsi" value="<?php 
			                if(set_value('kode_mst_agama')=="" && isset($kode_mst_agama)){
			                  echo $kode_mst_agama;
			                }else{
			                  echo  set_value('kode_mst_agama');
			                }
			                ?>">
			            </div>
			        </div>
			        <div class="col-md-6">
			            <div class="form-group">
			              <label>Status Perkawinan</label>
			              <input type="text" class="form-control" name="kode_mst_nikah" placeholder="Deskripsi" value="<?php 
			                if(set_value('kode_mst_nikah')=="" && isset($kode_mst_nikah)){
			                  echo $kode_mst_nikah;
			                }else{
			                  echo  set_value('kode_mst_nikah');
			                }
			                ?>">
			            </div>
			        </div>
		        </div>
		        <br>
		        <label>--Keterangan Lainnya--</label>
		        <div class="box-body">
		            <div class="form-group">
		              <label>No NPWP</label>
		              <input type="text" class="form-control" name="tar_npwp" placeholder="Deskripsi" value="<?php 
		                if(set_value('tar_npwp')=="" && isset($tar_npwp)){
		                  echo $tar_npwp;
		                }else{
		                  echo  set_value('tar_npwp');
		                }
		                ?>">
		            </div>
		            <div class="form-group">
		              <label>Tanggal NPWP</label>
		              <input type="date" class="form-control" name="tar_npwp_tgl" placeholder="Deskripsi" value="<?php 
		                if(set_value('tar_npwp_tgl')=="" && isset($tar_npwp_tgl)){
		                  echo $tar_npwp_tgl;
		                }else{
		                  echo  set_value('tar_npwp_tgl');
		                }
		                ?>">
		            </div>
		            <div class="form-group">
		              <label>No KTP</label>
		              <input type="text" class="form-control" name="ktp" placeholder="Deskripsi" value="<?php 
		                if(set_value('ktp')=="" && isset($ktp)){
		                  echo $ktp;
		                }else{
		                  echo  set_value('ktp');
		                }
		                ?>">
		            </div>
		            <div class="form-group">
		              <label>Kode Puskesmas</label>
		              <input type="text" class="form-control" name="code_cl_phc" placeholder="Deskripsi" value="<?php 
		                if(set_value('code_cl_phc')=="" && isset($code_cl_phc)){
		                  echo $code_cl_phc;
		                }else{
		                  echo  set_value('code_cl_phc');
		                }
		                ?>">
		            </div>
		            <div class="form-group">
		              <label>Status Masuk</label>
		              <select type="text" class="form-control" name="status_masuk">
		              	<option value="pns">PNS</option>
		              	<option value="nonpns">Non PNS</option>
		              </select>
		            </div>
		        </div>
		            <div class="box-footer pull-right">
		            <button type="submit" class="btn btn-primary">Simpan</button>
		            <button type="reset" class="btn btn-warning">Ulang</button>
		            <button type="button" class="btn btn-success" onClick="document.location.href='<?php echo base_url()?>kepegawaian/drh'">Kembali</button>
		          </div>
		          </div><!-- /.box-body -->
		      </div><!-- /.box -->
		    </div><!-- /.box -->
		  </div><!-- /.box -->
		</form>
    </div>
  </div>
</div>