
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
		 	<button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
          </div>
	    </div>

	    <div class="box-footer">
	    	<div class="row">
	    		<div class="col-md-6">
	    			<select class="form-control" id="changemodeshow" name="changemodeshow">
						<optgroup label="Buku Besar Tambahan">
						<?php foreach ($databukubesar as $key){ ?>
							<option value="tambahan_#<?php echo $key->id_mst_bukubesar; ?>"><?php echo $key->judul; ?></option>
						<?php } ?>
						</optgroup>
						<optgroup label="Buku Besar Umum">
							<?php foreach ($dataallakun as $keyakun){ ?>
							<option value="akun_#<?php echo $keyakun['id_mst_akun']; ?>"><?php echo $keyakun['nama_akun']; ?></option>
							<?php } ?>
						</optgroup>
					</select> 	
	    		</div>
	    		<div class="col-md-6">
	    			<div class="row">
	    				<div class="col-md-9">
			    			<div class="pull-right">
			    				<select class="form-control" id="periodebulanumum" name="periodebulanumum"> 
			                      <?php foreach ($bulan as $key => $value) { 
			                        $select = ($key==date('n') ? 'selected' : '');
			                      ?>  
			                        <option value="<?php echo $key?>" <?php echo $select?>><?php echo $value?></option>
			                      <?php } ?>
			                    </select>
			    			</div>
	    				</div>
	    				<div class="col-md-3">
	    					<select class="form-control" id="periodetahunumum" name="periodetahunumum">
		                      <?php for($i=date("Y"); $i>=date("Y")-5; $i--){
		                        $select = ($i==date('Y') ? 'selected' : '');
		                      ?>
		                        <option value="<?php echo $i?>" <?php echo $select?>><?php echo $i?></option>
		                      <?php }?>
		                    </select>	
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
        <div class="box-body">
		   <div class="row">
			  <div class="col-md-12">
			  	<div class="box" id="loading">
				    <div class="box-header">
				    	<h3 class="box-title" id="judulloading" align="center">Mohon tunggu, sedang proses...</h3>
				    </div>
			    </div>
			    <div class="box" id="hilangdata">
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



<script type="text/javascript">
$(function () {	
	
	$("#menu_ekeuangan").addClass("active");
	$("#menu_keuangan_bukubesar").addClass("active");

	$("#hilangdata").hide(); 
	$("#loading").hide(); 
});
$('#changemodeshow').change(function(){
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
