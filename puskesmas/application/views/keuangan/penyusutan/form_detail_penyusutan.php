<?php if(validation_errors()!=""){ ?>
<div class="alert alert-danger alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<form action="#" method="POST" name="frmPegawai">
  <div class="row" style="margin: 15px 5px 15px 5px">
    <div class="col-sm-6">
        <h4>{title_form}</h4> 
    </div>
    <div class="col-sm-6" style="text-align: right">
      <button type="button" name="btn_keuangan_detail_penyusutan" class="btn btn-warning"><i class='glyphicon glyphicon-list-alt'></i> &nbsp; Lebih Detail</button>
      <button type="button" name="btn_keuangan_penyusutan_close" id="btn_keuangan_penyusutan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Close</button>
    </div>
  </div>

<div class="row" style="margin: 5px">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Nomor
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($id_inventaris)) {
          	echo $id_inventaris;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Nama Inventaris
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($nama_inventaris)) {
          	echo $nama_inventaris;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Nilai Awal
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($nilai_awal)) {
          	echo $nilai_awal;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Nilai Saat Ini
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($nilai_akhir)) {
          	echo $nilai_akhir;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Akun inventaris
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($akun_inventarsi)) {
          	echo $akun_inventarsi;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Akun Biaya Penyusutan
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($biaya_penyusutan)) {
          	echo $biaya_penyusutan;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Metode Penyusutan
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($metode_penyusutan)) {
          	echo $metode_penyusutan;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Nilai Ekonomis
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($nilai_ekonomis)) {
          	echo $nilai_ekonomis;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Umur Sisa
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($nilai_sisa)) {
          	echo $nilai_sisa;
          }
          ?>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">
         Mulai Pemakaian
        </div>
        <div class="col-md-8">
          <?php 
          if (isset($mulai_pakai)) {
          	echo $mulai_pakai;
          }
          ?>
        </div>
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-12" style="padding: 5px">
         <h3>Riwayat Transaksi & Penyusutan</h3>
        </div>
      </div>
      <div class="row" style="margin: 5px">
        <div class="col-md-12" style="padding: 5px">
         <div id="jqxgreeddetail"></div>
        </div>
      </div>

      <br>
    </div>

  </div>
</div>
</form>

<script>


  $(function () { 
  	$("#btn_keuangan_penyusutan_close").click(function(){
  		closepopup();
  	});
  	function closepopup(){
            $("#popup_keuangan_penyusutan").jqxWindow('close');
        }
    $("[name='btn_keuangan_add_sts']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();

        data.append('id_sts',          $("[name='sts_id']").val());
        data.append('nomor',           $("[name='sts_nomor']").val());
        data.append('tgl',             $("[name='sts_tgl']").val());
        
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/sts/add_sts"   ?>',
            data : data ,
            success : function(response){
              a = response.split(" | ");
              if(a[0]=="OK"){
                alert("Data STS berhasil disimpan.");
                $("#jqxgreeddetail").jqxGrid('updatebounddata', 'cells');
                window.location.href="<?php echo base_url().'keuangan/sts/detail';?>/" + a[1];
              }else{
                $('#popup_keuangan_sts_content').html(response);
              }
            }
         });

        return false;
    });
  });



 var source = {
    datatype: "json",
    type    : "POST",
    datafields: [
    { name: 'id_inventaris', type: 'string'},
    { name: 'tanggal', type: 'date'},
    { name: 'metode', type: 'string'},
    { name: 'kredit', type: 'string'},
    { name: 'nilai_inventaris',type: 'string'},   
    { name: 'debit', type: 'number'},
    { name: 'view', type: 'number'},
],
	url: "<?php echo site_url('keuangan/penyusutan/json_detail'); ?>",
	cache: false,
	updaterow: function (rowid, rowdata, commit) {
	    },
	filter: function(){
	    $("#jqxgreeddetail").jqxGrid('updatebounddata', 'filter');
	},
	sort: function(){
	    $("#jqxgreeddetail").jqxGrid('updatebounddata', 'sort');
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
	    $("#jqxgreeddetail").jqxGrid('clearfilters');
	});

	$("#jqxgreeddetail").jqxGrid(
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
	            var dataRecord = $("#jqxgreeddetail").jqxGrid('getrowdata', row);
	            if(dataRecord.view==1){
	                return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_sts+"\");'></a></div>";
	            }else{
	                return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
	            }
	          }
	        },
	        { text: 'Tanggal', datafield: 'tanggal', columntype: 'date', filtertype: 'date', cellsformat: 'dd-MM-yyyy',align: 'center', cellsalign: 'center', width: '15%',cellsalign: 'center'},
	        { text: 'Debit', datafield: 'debit', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '25%',cellsalign: 'right'},
	        { text: 'Kredit', datafield: 'kredit', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '25%',cellsalign: 'right' },
	        { text: 'Nilai Inventaris', datafield: 'nilai_inventaris', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '30%',cellsalign: 'right' },
	    ]
	});
</script>
