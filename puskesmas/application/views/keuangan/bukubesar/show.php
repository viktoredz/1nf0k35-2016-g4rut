
<div id="popup_bukubesar" style="display:none">
	<div id="popup_title">Data Barang</div>
	<div id="popup_content">&nbsp;</div>
</div>
<form action="<?php echo base_url()?>keuangan/bukubesar/dodel_multi" method="POST" name="">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
          <div class="pull-right">
          	<button type="button" class="btn btn-primary" onclick=""><i class='glyphicon glyphicon-download-alt'></i> &nbsp; Export</button>
		 	<button type="button" class="btn btn-success" id="btn-refreshdata"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
          </div>
	    </div>

	    <div class="box-footer">
	    	<div class="row">
	    		<div class="col-md-7">
	    			<label>Pilih Buku Besar : </label>
	    			<select class="form-control" id="changemodeshow" name="changemodeshow">
						<option class="juduloption" value="judul">Tambah Buku Besar</option>
						<?php foreach ($databukubesar as $key){ ?>
							<option value="tambahan__<?php echo $key['id_mst_bukubesar']; ?>"><?php echo $key['judul']; ?></option>
						<?php } ?>
						
						<option class="juduloption" value="judul">Buku Besar Umum</option>
							<?php foreach ($dataallakun as $keyakun){ ?>
							<option value="akun__<?php echo $keyakun['id_mst_akun']; ?>"><?php echo $keyakun['nama_akun']; ?></option>
							<?php } ?>
					</select> 	
	    		</div>
	    		<div class="col-md-5">
	    			<div class="row">
	    				<div class="col-md-5">
			    			<div class="pull-right">
			    				<label>Periode : </label>
			    				<select class="form-control" id="periodebulanumum" name="periodebulanumum"> 
			                      <?php foreach ($bulan as $key => $value) { 
			                        $select = ($key==date('n') ? 'selected' : '');
			                      ?>  
			                        <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
			                      <?php } ?>
			                    </select>
			    			</div>
	    				</div>
	    				<div class="col-md-2" style="padding:25px 0 0 0">
	    					<select class="form-control" id="periodetahunumum" name="periodetahunumum">
		                      <?php for($i=date("Y"); $i>=date("Y")-5; $i--){
		                        $select = ($i==date('Y') ? 'selected' : '');
		                      ?>
		                        <option value="<?php echo $i?>" <?php echo $select?>><?php echo $i?></option>
		                      <?php }?>
		                    </select>	
	    				</div>
	    				<div class="col-md-4">
	    					<label>Puskesmas : </label>
	    					<select name="code_cl_phc" id="puskesmas" class="form-control">
								<?php foreach ($datapuskesmas as $row ) { ;?>
									<option value="<?php echo $row->code; ?>" onchange="" ><?php echo $row->value; ?></option>
								<?php	} ;?>
					     	</select>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
        <div class="box-body">
		   <div class="row">
			  <div class="col-md-12">
			  	<div class="box box-warning" id="loading">
				    <div class="box-header">
				    	<h3 class="box-title" id="judulloading" align="center">Mohon tunggu, sedang proses...</h3>
				    </div>
			    </div>
			    <div class="box box-success" id="hilangdata">
			      <div class="box-header with-border">
			        <h3 class="box-title" id="juduldata">Tunggu, sedang proses...</h3>
			        <br><br>
			        <div class="box-tools pull-right">
			          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			        </div>
			      </div><!-- /.box-header -->
			      <div class="box-body" id="isi" style="min-height: 200px">
			       <!-- <div class="row" id="rowchart">-->
			          <div id="tampilgridata">
			            <!--<canvas id="tampilchart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>-->
			          </div>
			          <div id="tampildata">
			          </div>
			        <!--</div>-->
			      </div><!-- /.box-body -->
			    </div><!-- /.box -->
			  </div><!-- /.col -->
			</div><!-- /.row -->
	    </div>
	  </div>
	</div>
  </div>
</form>

<style type="text/css">
.juduloption{
	font-weight:bold;
}
</style>

<script type="text/javascript">
$(function () {	
	
	$("#menu_ekeuangan").addClass("active");
	$("#menu_keuangan_bukubesar").addClass("active");

	$("#hilangdata").hide(); 
	$("#loading").hide(); 
});
$('#changemodeshow').change(function(){
	if ($(this).val()=='judul') {
		alert("Silahkan pilih jenis buku besar dari kategori "+$("#changemodeshow option:selected").text());
	}else{
		$("#hilangdata").hide();
		$("#loading").show();
		$("#tampildata").html('');
			var judul = $('[name=changemodeshow] :selected').text();
			var bulan = $("#periodebulanumum").val();
			var tahun  = $("#periodetahunumum").val();
			var id_judul = $("#changemodeshow").val();
			var rw = $("#rw").val();
	  		if ($("#changemodeshow").val()=="") {
	  			$("#hilangdata").hide();
	  			alert("Silahkan Pilih Laporan Terlebih Dahulu");
	  		}else{
	  		}
			$.ajax({
	        url : '<?php echo site_url('keuangan/bukubesar/pilihgrid/') ?>',
	        type : 'POST',
	        data : 'judul=' + judul+'&bulan=' + bulan+'&tahun=' + tahun+'&id_judul=' + id_judul,
	        success : function(data) {
	        	$("#loading").hide();
	        	$("#hilangdata").show(); 
	        	$('#juduldata').html($('[name=changemodeshow] :selected').text().replace(/-/g, ""));
	          	$('#tampilgridata').html(data);
	        }
	 	});

	  return false;
	}

});

$('#periodebulanumum').change(function(){
  var bulan = $(this).val();
  var idjuduldata =  $("#changemodeshow").val();
  $.ajax({
    url : '<?php echo site_url('keuangan/bukubesar/get_bulanfilter') ?>',
    type : 'POST',
    data : 'bulan=' + bulan,
    success : function(data) {
      $("#jqxgrid"+idjuduldata).jqxGrid('updateBoundData','cell');
    }
  });

  return false;
});
$('#periodetahunumum').change(function(){
  var idjuduldatas =  $("#changemodeshow").val();
  var tahun = $(this).val();
  $.ajax({
    url : '<?php echo site_url('keuangan/bukubesar/get_tahunfilter') ?>',
    type : 'POST',
    data : 'tahun=' + tahun,
    success : function(data) {
      $("#jqxgrid"+idjuduldatas).jqxGrid('updateBoundData','cell');
    }
  });

  return false;
});
$("#btn-export").click(function(){
		var judul = $('[name=laporan] :selected').text();
		var id_judul = $("#laporan").val();
		var kecamatanbar = $("#kecamatan").val();
		var kelurahanbar = $("#kelurahan").val();
		var rw = $("#rw").val();

	var post = "";
	post = post+'judul='+judul+'&kecamatan='+ kecamatanbar+'&kelurahan=' + kelurahanbar+'&rw=' + rw+'&id_judul=' + id_judul;
	
	$.post("<?php echo base_url()?>eform/export_data/pilih_export",post,function(response){
		//window.location.href=response;
		alert(response);
	});
});
</script>
