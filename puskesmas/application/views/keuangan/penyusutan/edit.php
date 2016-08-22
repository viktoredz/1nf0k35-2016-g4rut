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
        </div>
          <div class="box-footer">
            <button type="button" class="btn btn-success" id="btn-refresh-edit"><i class='fa fa-refresh'></i> &nbsp;Refresh</button>    
         </div>
      <div class="box-body">
            <div class="div-grid">
                <div id="jqxgridEdit"></div>
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
            { name: 'id_inventaris', type: 'string'},
            { name: 'nama_inventaris', type: 'string'},
            { name: 'akun_inventaris', type: 'string'},
            { name: 'akun_beban', type: 'string'},
            { name: 'metode',type: 'string'},   
            { name: 'nilai_ekonomis', type: 'number'},
            { name: 'nilai_sisa', type: 'number'},
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
                 { name: 'label', type: 'string' },
                 { name: 'value', type: 'string' }
             ],
             url: "<?php echo site_url('keuangan/penyusutan/arrayakuninventaris'); ?>",
        };
        var akuninventarisAdapter = new $.jqx.dataAdapter(akuninventaris, {
            autoBind: true
        });
        var akunbeban =
        {
             datatype: "json",
            type    : "POST",
             datafields: [
                 { name: 'label', type: 'string' },
                 { name: 'value', type: 'string' }
             ],
             url: "<?php echo site_url('keuangan/penyusutan/arrayakunbeban'); ?>",
        };
        var akunbebanAdapter = new $.jqx.dataAdapter(akunbeban, {
            autoBind: true
        });
        var metodepenyusutan =
        {
             datatype: "json",
            type    : "POST",
             datafields: [
                 { name: 'label', type: 'string' },
                 { name: 'value', type: 'string' }
             ],
             url: "<?php echo site_url('keuangan/penyusutan/arraymetodepenyusutan'); ?>",
        };
        var metodepenyusutanAdapter = new $.jqx.dataAdapter(metodepenyusutan, {
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
                { text: 'ID Inventaris', datafield: 'id_inventaris',editable:false, columntype: 'textbox', filtertype: 'none',align: 'center', cellsalign: 'center', width: '8%',cellsalign: 'center'},
                { text: 'Nama Inventaris', datafield: 'nama_inventaris', editable:false, columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '17%'},
                { text: '<i class="fa fa-pencil-square-o"></i> Akun Inventaris', datafield: 'akun_inventaris',  filtertype: 'textbox', align: 'center',  width: '15%', columntype: 'dropdownlist',
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({ source: akuninventarisAdapter, displayMember: 'label', valueMember: 'value' });
                        }
                },
                { text: '<i class="fa fa-pencil-square-o"></i> Akun Beban Penyusutan', datafield: 'akun_beban', filtertype: 'textbox', align: 'center',  width: '15%', columntype: 'dropdownlist',
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({ source: akunbebanAdapter, displayMember: 'label', valueMember: 'value' });
                        }
                },
                { text: '<i class="fa fa-pencil-square-o"></i> Metode Penyusutan', datafield: 'metode', columntype: 'textbox', filtertype: 'textbox', align: 'center', width: '15%', columntype: 'dropdownlist',
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({ source: metodepenyusutanAdapter, displayMember: 'label', valueMember: 'value' });
                        } 
                },
                { text: '<i class="fa fa-pencil-square-o"></i> Nilai Ekonomis (Tahun)', datafield: 'nilai_ekonomis', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'right', width: '15%' },
                { text: '<i class="fa fa-pencil-square-o"></i> Sisa', datafield: 'nilai_sisa', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'right', width: '15%'
                },
            ]
        });
         $("#jqxgridEdit").on('cellselect', function (event) {
                var column = $("#jqxgridEdit").jqxGrid('getcolumn', event.args.datafield);
                var value = $("#jqxgridEdit").jqxGrid('getcellvalue', event.args.rowindex, column.datafield);
                var displayValue = $("#jqxgridEdit").jqxGrid('getcellvalue', event.args.rowindex, column.displayfield);
                $("#eventLog").html("<div>Selected Cell<br/>Row: " + event.args.rowindex + ", Column: " + column.text + ", Value: " + value + ", Label: " + displayValue + "</div>");
            });
        $("#jqxgridEdit").on('cellendedit', function (event) {
            var column = $("#jqxgridEdit").jqxGrid('getcolumn', event.args.datafield);
            if (column.displayfield != column.datafield) {
                $("#eventLog").html("<div>Cell Edited:<br/>Index: " + event.args.rowindex + ", Column: " + column.text + "<br/>Value: " + event.args.value.value + ", Label: " + event.args.value.label
                    + "<br/>Old Value: " + event.args.oldvalue.value + ", Old Label: " + event.args.oldvalue.label + "</div>"
                    );
            }
            else {
                $("#eventLog").html("<div>Cell Edited:<br/>Row: " + event.args.rowindex + ", Column: " + column.text + "<br/>Value: " + event.args.value
                    + "<br/>Old Value: " + event.args.oldvalue + "</div>"
                    );
            }
        });


</script>

