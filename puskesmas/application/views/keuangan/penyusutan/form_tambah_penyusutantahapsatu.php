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
      <button type="button" name="btn_keuangan_add_sts" class="btn btn-warning" onclick="addstepdua(2)"><i class='glyphicon glyphicon-arrow-right'></i> &nbsp; Selanjutnya</button>
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
                  <div id='pengadaan_tgl' name="pengadaan_tgl">
                  </div>
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
  });
 var sourcepilih = {
      datatype: "json",
      type    : "POST",
      datafields: [
      { name: 'nama_barang', type: 'string'},
      { name: 'id_mst_inv_barang', type: 'string'},
      { name: 'id_inventaris_barang', type: 'string'},
      { name: 'register',type: 'string'},   
      { name: 'id_cl_phc',type: 'string'}, 
      { name: 'harga',type: 'string'}, 
      { name: 'delete', type: 'number'},
      { name: 'view', type: 'number'},
  ],
  url: "<?php echo site_url('keuangan/penyusutan/json_detail'); ?>",
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
          { text: 'Pilih', align: 'center', filtertype: 'none', sortable: false, width: '8%', cellsrenderer: function (row) {
            var dataRecord = $("#jqxgridPilih").jqxGrid('getrowdata', row);
          return "<div style='width:100%;padding-top:2px;text-align:center'><input type='checkbox' name='idinv[]' value="+dataRecord.id_inventaris_barang+" ></div>";
                 }
                },
          { text: 'ID Inventaris', datafield: 'id_inventaris_barang', columntype: 'textbox', filtertype: 'none',align: 'center', cellsalign: 'center', width: '15%',cellsalign: 'center'},
          { text: 'Nama Inventaris', datafield: 'nama_barang', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '47%'},
          { text: 'Status', datafield: 'status', columntype: 'textbox', filtertype: 'none', align: 'center', cellsalign: 'center', width: '30%' }
      ]
  });
function addsteplanjut(id) {
  $.post("<?php echo base_url().'keuangan/penyusutan/add_inventaris'?>/",{'dataceklis':id},function(data) {
    $("#popup_keuangan_penyusutan_content").html(data);
  });
}
function addstepdua(id) { 
    var values = new Array(); 
    $.each($("input[name='idinv[]']:checked"), function() {
      values.push($(this).val());   
    });
    data_barang=$("#pengadaan_tgl").val()+'_tu_';
    if(values.length > 0){
      for(i=0; i<values.length; i++){
        data_barang = data_barang+values[i]+"_tr_";
      }
      addsteplanjut(data_barang);
    }else{
      alert('Silahkan Pilih Barang Terlebih Dahulu');
    }
}
</script>
