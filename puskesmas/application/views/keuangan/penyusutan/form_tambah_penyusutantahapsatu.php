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
      <h4>{form_title}</h4>
    </div>
    <div class="col-sm-6" style="text-align: right">
      <button type="button" name="btn_keuangan_add_sts" class="btn btn-warning"><i class='glyphicon glyphicon-arrow-right'></i> &nbsp; Selanjutnya</button>
      <button type="button" name="btn_keuangan_close" class="btn btn-primary"><i class='fa fa-close'></i> &nbsp; Batal</button>
    </div>
  </div>

  <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <div class="box box-primary">
            <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                  Pengadaan 
                </div>
                <div class="col-md-8">
                  <div id='tgl' name="pengadaan_tgl" value="<?=date("m/d/Y")?>" >
                  </div>
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-4" style="padding: 5px">
                 Kata
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" name="kata" placeholder="Filter Kata" >
                </div>
              </div>
              <div class="row" style="margin: 5px">
                <div class="col-md-12" style="padding: 5px">
                  <div id="jqxgridPilih"></div>
                </div>
              </div>
              <br>
            </div>
          </div>
  </div>
</form>

<script>

 function kodeSTS(){
      $.ajax({
      url: "<?php echo base_url().'keuangan/sts/kodeSts';?>",
      dataType: "json",
      success:function(data){ 
        $.each(data,function(index,elemet){
          var sts = elemet.kodests.split(".")
          $("#id_sts").val(sts[0]);
        });
      }
      });
      return false;
  }

  $(function () { 
    tabIndex = 1;
    kodeSTS();

    $("[name='pengadaan_tgl']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme, height:30});

    
   $("[name='btn_keuangan_close']").click(function(){
        $("#popup_keuangan_penyusutan").jqxWindow('close');
    });

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
                $("#popup_keuangan_penyusutan").jqxWindow('close');
                alert("Data STS berhasil disimpan.");
                $("#jqxgridPilih").jqxGrid('updatebounddata', 'cells');
                window.location.href="<?php echo base_url().'keuangan/sts/detail';?>/" + a[1];
              }else{
                $('#popup_keuangan_sts_content').html(response);
              }
            }
         });

        return false;
    });
  });
 var sourcepilih = {
      datatype: "json",
      type    : "POST",
      datafields: [
      { name: 'id_inventaris', type: 'string'},
      { name: 'nama_inventaris', type: 'string'},
      { name: 'metode', type: 'string'},
      { name: 'nilai_awal', type: 'string'},
      { name: 'nilai_akhir',type: 'string'},   
      { name: 'status',type: 'string'},
      { name: 'edit', type: 'number'},
      { name: 'id', type: 'number'},
      { name: 'delete', type: 'number'},
      { name: 'view', type: 'number'},
  ],
  url: "<?php echo site_url('keuangan/penyusutan/json'); ?>",
  cache: false,
  updaterow: function (rowid, rowdata, commit) {
      },
  filter: function(){
      $("#jqxgridPilih").jqxGrid('updatebounddata', 'filter');
  },
  sort: function(){
      $("#jqxgridPilih").jqxGrid('updatebounddata', 'sort');
  },
  root: 'Rows',
  pagesize: 10,
  beforeprocessing: function(data){       
      if (data != null){
          sourcepilih.totalrecords = data[0].TotalRows;                    
      }
  }
  };      
  var dataadapterpilih = new $.jqx.dataAdapter(sourcepilih, {
      loadError: function(xhr, status, error){
          alert(error);
      }
  });

  $('#btn-refresh').click(function () {
      $("#jqxgridPilih").jqxGrid('clearfilters');
  });

  $("#jqxgridPilih").jqxGrid(
  {       
      width: '100%',
      selectionmode: 'singlerow',
      source: dataadapterpilih, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
      showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true, editable: false,
      rendergridrows: function(obj)
      {
          return obj.data;    
      },
      columns: [
          { text: 'Pilih',filtertype: 'none', align:'center', datafield: 'id', columntype: 'checkbox', width: '8%' },
          { text: 'ID Inventaris', datafield: 'id_inventaris', columntype: 'textbox', filtertype: 'none',align: 'center', cellsalign: 'center', width: '15%',cellsalign: 'center'},
          { text: 'Nama Inventaris', datafield: 'nama_inventaris', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '47%'},
          { text: 'Status', datafield: 'status', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '30%' }
      ]
  });
</script>
