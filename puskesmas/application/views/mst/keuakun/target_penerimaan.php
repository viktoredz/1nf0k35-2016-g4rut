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
            <div class="col-md-9 pull-left">
              <button id="doExpand_target" class="btn btn-warning " ><i class="icon fa fa-plus-square-o"></i> &nbsp;Expand</button>  
              <button id="doCollapse_target" class="btn btn-warning " ><i class="icon fa fa-minus-square-o"></i> &nbsp;Collapse</button> 
              <button id="doRefresh_target" class="btn btn-primary" ><i class='fa fa-refresh'></i> &nbsp; Refresh</button>
            </div>
            <div class="col-md-3 pull-right">
              <div class="row">
                <div class="col-md-4" style="padding-top:5px;"><label> Periode </label> </div>
                  <div class="col-md-8">
                    <select name="tahuntarget" id="tahuntarget" class="form-control">
                      <?php for ($i=date("Y");$i>=date("Y")-10;$i--) { ;?>
                      <?php $select = $i == date("Y") ? 'selected=selected' : '' ?>
                     <option value="<?php echo $i; ?>" <?php echo $select ?>><?php echo $i; ?></option>
                      <?php   } ;?>
                    </select>
                  </div> 
              </div>
            </div>
        </div>
      </div>
    </div>
    <div class="box-body">
      <div class="default">
        <div id="treeGrid_target_penerimaan"></div>
      </div>
      </div>
    </div>
  </div>
  </div>
</section>

<script type="text/javascript">
  $(document).ready(function () {
      $("#doExpand_target").click(function(){
          $("#treeGrid_target_penerimaan").jqxTreeGrid('expandAll');                    
      });
      
      $("#doCollapse_target").click(function(){
          $("#treeGrid_target_penerimaan").jqxTreeGrid('collapseAll');                    
      });

      $("#doRefresh_target").click(function(){
          $("#treeGrid_target_penerimaan").jqxTreeGrid('updateBoundData');
      });

    $("select[name='tahuntarget']").change(function(){
      $.post("<?php echo base_url().'mst/keuangan_akun/filter_tahuntarget' ?>", 'tahuntarget='+$(this).val(),  function(){
        $("#treeGrid_target_penerimaan").jqxTreeGrid('updateBoundData','filter');
        });
    });
      
      var newRowID = null;

            var sourcetarget = {
            dataType: "tab",
            dataFields: [
                { name: "id_mst_akun_target", type: "number" },
                { name: "id_mst_anggaran_parent_target", type: "number" },
                { name: "kode_target", type: "number" },
                { name: "uraian_target", type: "string" },
                { name: "saldso_normal_target", type: "string" },
                { name: "saldso_awal_target", type: "string" },
                { name: "id_akun_anggaran_target", type: "string" },
                { name: "jumlah_target", type: "string" },
                { name: "tipe_target", type: "string" },
                { name: "periode_target", type: "date" },
                { name: "code_cl_phc_target", type: "string" },
                { name: "statusdata", type: "string" }
            ],
                hierarchy:
                {
                     keyDataField: { name: 'id_mst_akun_target' },
                     parentDataField: { name: 'id_mst_anggaran_parent_target' }
                },
                id: 'id_mst_akun_target',

                url: '<?php echo base_url()?>mst/keuangan_akun/api_data_target',

                 addRow: function (rowID, rowData, position, parentID, commit) {        
                    commit(true);
                    newRowID = rowID;
                 },
                 updateRow: function (rowID, rowData, commit) {
                  commit(true);
                  if (rowData.statusdata=='anak') {
                    alert('Tidak Bisa');
                  }else{
                    $.post( '<?php echo base_url()?>mst/keuangan_akun/akun_anggraan_update', 
                      {
                        id_akun_anggaran:rowData.id_akun_anggaran_target,
                        jumlah:rowData.jumlah_target,
                        tipe:'target', 
                        periode:$("#tahuntarget").val(), 
                        id_mst_akun : rowData.id_mst_akun_target, 
                        code_cl_phc : "<?php echo $this->session->userdata('puskesmas');?>"
                      },
                      function( data ) {
                        if(data != 0){
                          alert(data);
                        }
                        $("#treeGrid_target_penerimaan").jqxTreeGrid('updateBoundData');
                        $("#treeGrid_target_penerimaan").jqxTreeGrid('expandAll'); 
                    });
                  }
                 }
             };
            var dataAdaptertarget = new $.jqx.dataAdapter(sourcetarget, {
                loadComplete: function () {
                    // data is loaded.
                }
            });

            $("#treeGrid_target_penerimaan").jqxTreeGrid({
                width: '100%',
                source: dataAdaptertarget, 
                pageable: false,
                editable: true,
                showToolbar: true,
                altRows: true,
                ready: function(){
                   $("#treeGrid_target_penerimaan").jqxTreeGrid('expandAll'); 
                },
                pagerButtonsCount: 8,
                toolbarHeight: 40,

               
              columns: [                             
                { text: 'Uraian',editable:false, datafield: 'uraian_target', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '37%' },
                { text: 'Kode Akun', editable:false,datafield: 'kode_target', columntype: 'textbox', filtertype: 'textbox',align: 'center', cellsalign:'center', width: '10%'},
                { text: 'Target Penerimaan', datafield: 'jumlah_target', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '53%', cellsalign: 'center' }
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

