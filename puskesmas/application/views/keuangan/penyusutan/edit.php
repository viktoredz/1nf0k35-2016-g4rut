<?php if($this->session->flashdata('alert')!=""){ ?>
<div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
    <h4>    <i class="icon fa fa-check"></i> Information!</h4>
    <?php echo $this->session->flashdata('alert')?>
</div>
<?php } ?>
<section class="content">
<form action="<?php echo base_url()?>keuangan/penyusutan/dodel_multi" method="POST" name="">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
          <div class="pull-right">
            <button type="button" class="btn btn-danger" id="backdata"><i class="glyphicon glyphicon-arrow-left"></i> Back</button>
          </div>
        </div>
          <div class="box-footer">
            <button type="button" class="btn btn-success" id="btn-refresh-edit"><i class='fa fa-refresh'></i> &nbsp;Refresh</button>    
         </div>
      <div class="box-body">
            <div class="div-grid">
                <div id="jqxgridEdit"></div>
                <div style="font-size: 13px; margin-top: 20px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif;" id="eventLog"></div>
            </div>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- <div id="eventLog"></div> -->
</section>

<div id="popup_keuangan_penyusutan" style="display:none">
  <div id="popup_title">Data Inventaris Penyusutan</div>
  <div id="popup_keuangan_penyusutan_content">&nbsp;</div>
</div>

<script type="text/javascript">

    $(function () { 
        $("#menu_ekeuangan").addClass("active");
        $("#menu_keuangan_penyusutan").addClass("active");
    });
       var source = {
            datatype: "json",
            type    : "POST",
            datafields: [
            { name: 'nama_barang', type: 'string'},
            { name: 'id_mst_inv_barang', type: 'string'},
            { name: 'id_inventaris_barang', type: 'string'},
            { name: 'register',type: 'string'},   
            { name: 'id_inventaris',type: 'string'},   
            { name: 'id_cl_phc',type: 'string'}, 
            { name: 'harga',type: 'string'},
            { name: 'kodenamaakumulasi',type: 'string'},
            { name: 'kodenamaakun',type: 'string'},
            { name: 'id_mst_metode_penyusutan',type: 'string'},
            { name: 'namapenyusutan',type: 'string'},
            { name: 'nilai_ekonomis',type: 'string'},
            { name: 'nilai_sisa',type: 'number'}
        ],
        url: "<?php echo site_url('keuangan/penyusutan/json_edit'); ?>",
        cache: false,
        updaterow: function (rowid, rowdata, commit) {
            },
        filter: function(){
            $("#jqxgridEdit").jqxGrid('updatebounddata', 'filter');
        },
        sort: function(){
            $("#jqxgridEdit").jqxGrid('updatebounddata', 'sort');
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
     
        $('#btn-refresh-edit').click(function () {
            $("#jqxgridEdit").jqxGrid('clearfilters');
        });
       
        var akuninventaris =
        {
             datatype: "json",
            type    : "POST",
             datafields: [
                 { name: 'nama_akun', type: 'string' },
                 { name: 'id_mst_akun', type: 'number' }
             ],
             url: "<?php echo site_url('keuangan/penyusutan/arrayakuninventaris'); ?>",
        };
        var akuninventarisAdapter = new $.jqx.dataAdapter(akuninventaris, {
            autoBind: true
        });
        var penyusutan =
        {
             datatype: "json",
            type    : "POST",
             datafields: [
                 { name: 'nama', type: 'string' },
                 { name: 'id_mst_metode_penyusutan', type: 'string' }
             ],
             url: "<?php echo site_url('keuangan/penyusutan/arraymetodepenyusutan'); ?>",
        };
        var penyusutanAdapter = new $.jqx.dataAdapter(penyusutan, {
            autoBind: true
        });
        $("#jqxgridEdit").jqxGrid(
        {       
            width: '100%',
            selectionmode: 'singlerow',
            editable: true,
            source: dataadapter, theme: theme,columnsresize: true,showtoolbar: false, pagesizeoptions: ['10', '25', '50', '100'],
            showfilterrow: true, filterable: true, sortable: true, autoheight: true, pageable: true, virtualmode: true,
            rendergridrows: function(obj)
            {
                return obj.data;    
            },
            columns: [
                { text: 'ID Inventaris', datafield: 'id_inventaris_barang',editable:false, columntype: 'textbox', filtertype: 'none',align: 'center', cellsalign: 'center', width: '8%',cellsalign: 'center'},
                { text: 'Nama Inventaris', datafield: 'nama_barang', editable:false, columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '17%'},
                { text: '<i class="fa fa-pencil-square-o"></i> Akun Inventaris', datafield: 'kodenamaakun',  filtertype: 'textbox', align: 'center',  width: '15%', columntype: 'dropdownlist',
                    createEditor: function (row, cellvalue, editor, cellText, width, height) {
                       editor.jqxDropDownList({autoDropDownHeight: true,source: akuninventarisAdapter, displayMember: "nama_akun", valueMember: "id_mst_akun"});

                   },
                   initEditor: function (row, cellvalue, editor, celltext, width, height) {
                       editor.jqxDropDownList('selectItem', cellvalue);
                   },
                   getEditorValue: function (row, cellvalue, editor) {
                        if(editor.val() % 1 === 0){
                            var datagrid = $("#jqxgridEdit").jqxGrid('getrowdata', row);
                           $.post( '<?php echo base_url()?>keuangan/penyusutan/updatestatusakuninventaris', {'idakun':editor.val(),'tipe':'akuninventaris','idinventaris':datagrid.id_inventaris}, function( data ) {
                                if(data != 0){
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');      
                                }else{
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                                }
                            });
                        }else{
                           $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                        }
                   },

                },
                { text: '<i class="fa fa-pencil-square-o"></i> Akun Beban Penyusutan', datafield: 'kodenamaakumulasi', filtertype: 'textbox', align: 'center',  width: '15%', columntype: 'dropdownlist',
                    createEditor: function (row, cellvalue, editor, cellText, width, height) {
                       editor.jqxDropDownList({autoDropDownHeight: true,source: akuninventarisAdapter, displayMember: "nama_akun", valueMember: "id_mst_akun"});

                   },
                   initEditor: function (row, cellvalue, editor, celltext, width, height) {
                       editor.jqxDropDownList('selectItem', cellvalue);
                   },
                   getEditorValue: function (row, cellvalue, editor) {
                        if(editor.val() % 1 === 0){
                            var datagrid = $("#jqxgridEdit").jqxGrid('getrowdata', row);
                           $.post( '<?php echo base_url()?>keuangan/penyusutan/updatestatusakunakumulasi', {'idakunakumulasi':editor.val(),'idinventarisdata':datagrid.id_inventaris}, function( data ) {
                                if(data != 0){
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');      
                                }else{
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                                }
                            });
                        }else{
                           $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                        }
                   },

                },
                { text: '<i class="fa fa-pencil-square-o"></i> Metode Penyusutan', datafield: 'namapenyusutan', columntype: 'textbox', filtertype: 'textbox', align: 'center', width: '15%', columntype: 'dropdownlist',
                    createEditor: function (row, cellvalue, editor, cellText, width, height) {
                       editor.jqxDropDownList({autoDropDownHeight: true,source: penyusutanAdapter, displayMember: "nama", valueMember: "id_mst_metode_penyusutan"});

                   },
                   initEditor: function (row, cellvalue, editor, celltext, width, height) {
                       editor.jqxDropDownList('selectItem', cellvalue);
                   },
                   getEditorValue: function (row, cellvalue, editor) {
                        if(editor.val() % 1 === 0){
                            var datagrid = $("#jqxgridEdit").jqxGrid('getrowdata', row);
                           $.post( '<?php echo base_url()?>keuangan/penyusutan/updatestatuspenyusutan', {'idakunpenyusutan':editor.val(),'idinventarispenyusutan':datagrid.id_inventaris}, function( data ) {
                                if(data != 0){
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');      
                                }else{
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                                }
                            });
                        }else{
                           $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                        }
                   },

                },
                { text: '<i class="fa fa-pencil-square-o"></i> Nilai Ekonomis (Tahun)', datafield: 'nilai_ekonomis', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'right', width: '15%',
                  getEditorValue: function (row, cellvalue, editor) {
                        var datagrid = $("#jqxgridEdit").jqxGrid('getrowdata', row);
                        if (datagrid.id_mst_metode_penyusutan=='5') {
                          alert("Maaf Nilai Ekonomis tidak bisa di edit jika menggunakan Metode Tanpa Penyusutan");
                          $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');  
                        }else{
                          if(editor.val() % 1 === 0){
                             $.post( '<?php echo base_url()?>keuangan/penyusutan/updatenilaiekonomis', {'nilaiekonomis':editor.val(),'id_inventaris':datagrid.id_inventaris}, function( data ) {
                                  if(data != 0){
                                    $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');      
                                  }else{
                                    $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                                  }
                              });
                          }else{
                             $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                          }
                        }
                   },
                },
                { text: '<i class="fa fa-pencil-square-o"></i> Sisa', datafield: 'nilai_sisa', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'right', width: '15%',
                    getEditorValue: function (row, cellvalue, editor) {
                      var datagrid = $("#jqxgridEdit").jqxGrid('getrowdata', row);
                      if (datagrid.id_mst_metode_penyusutan=='5' || datagrid.id_mst_metode_penyusutan=='3' || datagrid.id_mst_metode_penyusutan=='6d') {
                          alert("Maaf Nilai Sisa tidak bisa di edit jika menggunakan Metode Tanpa Penyusutan,Manual dan Menurun");
                          $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');  
                      }else{
                        if(editor.val() % 1 === 0){
                           $.post( '<?php echo base_url()?>keuangan/penyusutan/updatenilaisisa', {'nilaisisa':editor.val(),'id_inventaris':datagrid.id_inventaris}, function( data ) {
                                if(data != 0){
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');      
                                }else{
                                  $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                                }
                            });
                        }else{
                           $("#jqxgridEdit").jqxGrid('updatebounddata', 'cells');                 
                        }
                      }
                   },
                },
            ]
        });
$("#backdata").click(function(){
  window.location = "<?php echo base_url().'keuangan/penyusutan' ?>";
});
</script>


   