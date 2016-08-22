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
            <button type="button" class="btn btn-primary" onclick='add_sts()'><i class='fa fa-plus-square'></i> &nbsp;Tambah STS</button> 
            <button type="button" class="btn btn-success" id="btn-refresh"><i class='fa fa-refresh'></i> &nbsp;Refresh</button>    
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

<div id="popup_keuangan_penyusutan" style="display:none">
  <div id="popup_title">Tambah STS Baru</div>
  <div id="popup_keuangan_penyusutan_content">&nbsp;</div>
</div>

<script type="text/javascript">

    $(function () { 
        $("#menu_ekeuangan").addClass("active");
        $("#menu_keuangan_penyusutan").addClass("active");

        $("select[name='bulan']").change(function(){
            $.post("<?php echo base_url().'keuangan/penyusutan/filter_bulan' ?>", 'bulan='+$(this).val(),  function(){
                $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
            });
        });

        $("select[name='tahun']").change(function(){
            $.post("<?php echo base_url().'keuangan/penyusutan/filter_tahun' ?>", 'tahun='+$(this).val(),  function(){
                $("#jqxgrid").jqxGrid('updatebounddata', 'cells');

            });
        });
    });





       var source = {
            datatype: "json",
            type    : "POST",
            datafields: [
            { name: 'id_inventaris', type: 'string'},
            { name: 'nama_inventaris', type: 'string'},
            { name: 'metode', type: 'string'},
            { name: 'nilai_awal', type: 'string'},
            { name: 'nilai_akhir',type: 'string'},   
            { name: 'edit', type: 'number'},
            { name: 'delete', type: 'number'},
            { name: 'view', type: 'number'},
        ],
        url: "<?php echo site_url('keuangan/penyusutan/json'); ?>",
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
                { text: 'Detail', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    if(dataRecord.view==1){
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif' onclick='detail(\""+dataRecord.id_sts+"\");'></a></div>";
                    }else{
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_view.gif'></a></div>";
                    }
                  }
                },
                { text: 'Edit', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    if(dataRecord.edit==1){
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_edit.gif' onclick='edit(\""+dataRecord.id_sts+"\");'></a></div>";
                    }else{
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
                    }
                 }
                },
                { text: 'Del', align: 'center', filtertype: 'none', sortable: false, width: '4%', cellsrenderer: function (row) {
                    var dataRecord = $("#jqxgrid").jqxGrid('getrowdata', row);
                    if(dataRecord.delete==1){
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_del.gif' onclick='del(\""+dataRecord.id_sts+"\");'></a></div>";
                    }else{
                        return "<div style='width:100%;padding-top:2px;text-align:center'><a href='javascript:void(0);'><a href='javascript:void(0);'><img border=0 src='<?php echo base_url(); ?>media/images/16_lock.gif'></a></div>";
                    }
                 }
                },
                { text: 'ID Inventaris', datafield: 'id_inventaris', columntype: 'textbox', filtertype: 'textbox',align: 'center', cellsalign: 'center', width: '8%',cellsalign: 'center'},
                { text: 'Nama Inventaris', datafield: 'nama_inventaris', columntype: 'textbox', filtertype: 'textbox',align: 'center', width: '25%'},
                { text: 'Nilai Awal', datafield: 'nilai_awal', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '15%',cellsalign: 'right' },
                { text: 'Nilai Sekarang', datafield: 'nilai_akhir', columntype: 'textbox', filtertype: 'textbox', align: 'center',  width: '15%',cellsalign: 'right' },
                { text: 'Metode Penyusutan', datafield: 'metode', columntype: 'textbox', filtertype: 'textbox', align: 'center', cellsalign: 'center', width: '25%' }
            ]
        });

    function detail(id){
        $("#popup_keuangan_penyusutan #popup_keuangan_penyusutan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'keuangan/penyusutan/add_sts' ?>/", function(data) {
          $("#popup_keuangan_penyusutan_content").html(data);
        });
        $("#popup_keuangan_penyusutan").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 300,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_penyusutan").jqxWindow('open');
    }

    function del(id){
        var confirms = confirm("Hapus Data ?");
        if(confirms == true){
            $.post("<?php echo base_url().'keuangan/penyusutan/delete_sts' ?>/" + id,  function(){
                alert('Data berhasil dihapus');

                $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
            });
        }
    }

    function add_sts(){
      $("#popup_keuangan_penyusutan #popup_keuangan_penyusutan_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
        $.get("<?php echo base_url().'keuangan/penyusutan/add_sts' ?>/", function(data) {
          $("#popup_keuangan_penyusutan_content").html(data);
        });
        $("#popup_keuangan_penyusutan").jqxWindow({
          theme: theme, resizable: false,
          width: 600,
          height: 300,
          isModal: true, autoOpen: false, modalOpacity: 0.2
        });
        $("#popup_keuangan_penyusutan").jqxWindow('open');
    }

</script>

