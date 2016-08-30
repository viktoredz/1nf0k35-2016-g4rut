<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
           <h3 class="box-title">{title_form}</h3> 
      </div>
    <div class="box-body">
      <div class="row">
        <div class="col-md-12 pull-left">
            <div class="col-md-6 pull-left">
              <button id="doExpand_anggaran" class="btn btn-warning " ><i class="icon fa fa-plus-square-o"></i> &nbsp;Expand</button>  
              <button id="doCollapse_anggaran" class="btn btn-warning " ><i class="icon fa fa-minus-square-o"></i> &nbsp;Collapse</button> 
              <button id="doRefresh_anggaran" class="btn btn-primary" ><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
            </div>
            <div class="col-md-6 pull-right">
              <div class="row">
                <div class="col-md-5">
                  <div class="row">
                    <div class="col-md-4" style="padding-top:5px;"><label> Periode </label> </div>
                    <div class="col-md-8">
                      <select name="tahunanggaran" id="tahunanggaran" class="form-control">
                        <?php for ($i=date("Y");$i>=date("Y")-10;$i--) { ;?>
                        <?php $select = $i == date("Y") ? 'selected=selected' : '' ?>
                       <option value="<?php echo $i; ?>" <?php echo $select ?>><?php echo $i; ?></option>
                        <?php   } ;?>
                      </select>
                    </div> 
                  </div>
                </div>
                <div class="col-md-7">
                  <div class="row">
                    <div class="col-md-4" style="padding-top:5px;"><label> Puskesmas </label> </div>
                    <div class="col-md-8">
                      <select name="filterpuskesmas" id="filterpuskesmas" class="form-control">
                        <?php foreach ($datapuskesmas as $datapuskes){ ?>
                        <?php $select = $datapuskes->code == 'P'.$this->session->userdata('puskesmas') ? 'selected=selected' : '' ?>
                       <option value="<?php echo $datapuskes->code; ?>" <?php echo $select ?>><?php echo $datapuskes->value; ?></option>
                        <?php   } ;?>
                      </select>
                    </div> 
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="default">
        <div id="treeGrid_anggaran_akun"></div>
      </div>
      </div>
    </div>
  </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function () {
     $("#doExpand_anggaran").click(function(){
          $("#treeGrid_anggaran_akun").jqxTreeGrid('expandAll');                    
      });
      
      $("#doCollapse_anggaran").click(function(){
          $("#treeGrid_anggaran_akun").jqxTreeGrid('collapseAll');                    
      });

      $("#doRefresh_anggaran").click(function(){
          $("#treeGrid_anggaran_akun").jqxTreeGrid('updateBoundData');
      });
    $("select[name='tahunanggaran']").change(function(){
      $.post("<?php echo base_url().'mst/keuangan_akun/filter_tahunanggaran' ?>", 'tahunanggaran='+$(this).val(),  function(){
        $("#treeGrid_anggaran_akun").jqxTreeGrid('updateBoundData','filter');
        });
    });
    $("#filterpuskesmas").change(function(){
      $.post("<?php echo base_url().'mst/keuangan_akun/filter_puskesmas' ?>", 'filterpus='+$(this).val(),  function(){
        $("#treeGrid_anggaran_akun").jqxTreeGrid('updateBoundData','filter');
        });
    });
    
      
      var newRowID = null;

           var sourceanggran = {
            dataType: "tab",
            dataFields: [
                { name: "id_mst_akun", type: "number" },
                { name: "id_mst_anggaran_parent", type: "number" },
                { name: "kode", type: "number" },
                { name: "uraian", type: "string" },
                { name: "saldso_normal", type: "string" },
                { name: "saldso_awal", type: "string" },
                { name: "id_akun_anggaran", type: "string" },
                { name: "jumlah", type: "string" },
                { name: "tipe", type: "string" },
                { name: "periode", type: "date" },
                { name: "code_cl_phc", type: "string" }
            ],
                hierarchy:
                {
                     keyDataField: { name: 'id_mst_akun' },
                     parentDataField: { name: 'id_mst_anggaran_parent' }
                },
                id: 'id_mst_akun',

                url: '<?php echo base_url()?>mst/keuangan_akun/api_data_anggaran',

                 addRow: function (rowID, rowData, position, parentID, commit) {        
                    commit(true);
                    newRowID = rowID;
                 },
                 updateRow: function (rowID, rowData, commit) {
                  commit(true);
                  // alert(rowData.uraian+' '+rowData.kode+' '+rowData.jumlah+' '+rowData.id_akun_anggaran);
                       
                  $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_anggraan_update', 
                    {
                      id_akun_anggaran:rowData.id_akun_anggaran,
                      jumlah:rowData.jumlah,
                      tipe:'anggaran', 
                      periode:$("#tahunanggaran").val(), 
                      id_mst_akun : rowData.id_mst_akun, 
                      code_cl_phc : "<?php echo $this->session->userdata('puskesmas');?>"
                    },
                    function( data ) {
                      if(data != 0){
                        alert(data);
                      }
                      $("#treeGrid_anggaran_akun").jqxTreeGrid('updateBoundData');
                      $("#treeGrid_anggaran_akun").jqxTreeGrid('expandAll'); 
                  });
                 }
             };
            var dataAdapter = new $.jqx.dataAdapter(sourceanggran, {
                loadComplete: function () {
                    // data is loaded.
                }
            });

            $("#treeGrid_anggaran_akun").jqxTreeGrid({
                width: '100%',
                source: dataAdapter, 
                pageable: false,
                editable: true,
                showToolbar: true,
                altRows: true,
                ready: function(){
                   $("#treeGrid_anggaran_akun").jqxTreeGrid('expandAll');            
                },
                pagerButtonsCount: 8,
                toolbarHeight: 40,

                renderToolbar: function(toolBar){
                    var toTheme = function (className) {
                        if (theme == "") return className;
                        return className + " " + className + "-" + theme;
                    }

                    var rowKey = null;
                    $("#treeGrid_anggaran_akun").on('rowSelect', function (event) {
                        var args = event.args;
                        rowKey = args.key;
                    });
                    $("#treeGrid_anggaran_akun").on('rowUnselect', function (event) {
                    });
                    $("#treeGrid_anggaran_akun").on('rowEndEdit', function (event) {
                    });
                    $("#treeGrid_anggaran_akun").on('rowBeginEdit', function (event) {
                    });

                },
               
              columns: [                             
                { text: 'Uraian ',editable:false, datafield: 'uraian', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '37%' },
                { text: 'Kode Akun', editable:false,datafield: 'kode', columntype: 'textbox', filtertype: 'textbox',align: 'center', cellsalign:'center', width: '10%'},
                { text: 'Anggaran', datafield: 'jumlah', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '53%', cellsalign: 'center' }
              ]
            });
        });

    function detail(id){
        $("#popup_keuangan_akun_detail #popup_keuangan_akun_detail_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
          $.get("<?php echo base_url().'mst/keuangan_akun/induk_detail' ?>/"+ id, function(data) {
            $("#popup_keuangan_akun_detail_content").html(data);
          });
          $("#popup_keuangan_akun_detail").jqxWindow({
            theme: theme, resizable: false,
            width: 600,
            height: 450,
            isModal: true, autoOpen: false, modalOpacity: 0.2
          });
          $("#popup_keuangan_akun_detail").jqxWindow('open');
      }
    
    function add_induk(){
      $("#popup_keuangan_akun #popup_keuangan_akun_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'mst/keuangan_akun/induk_add' ?>/", function(data) {
          $("#popup_keuangan_akun_content").html(data);
        });
        $("#popup_keuangan_akun").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 280,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_akun").jqxWindow('open');
    }

</script>

