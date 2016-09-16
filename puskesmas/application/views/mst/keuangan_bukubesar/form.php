<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h4>	<i class="icon fa fa-check"></i> Information!</h4>
  <?php echo validation_errors()?>
</div>
<?php } ?>

<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert alert-success alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
  <?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>


<section class="content">
<form id="form-ss"  method="POST" name="form-ss">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div><!-- /.box-header -->

          <div class="box-footer pull-right">
            <?php if ($action!='view') { ?>
            <button type="submit" class="btn btn-primary" id="simpanbukubesar">Simpan</button>
            <button type="reset" class="btn btn-warning">Ulang</button>
            <?php } ?>
            <button type="button" class="btn btn-success" id="close_popup">Tutup</button>
          </div><br/><br/>
          <div class="box-body">
            <div class="form-group">
              <label>Judul Buku Besar</label>
              <input type="text" class="form-control" name="judul" placeholder="Judul Buku Besar" value="<?php 
                if(set_value('judul')=="" && isset($judul)){
                  echo $judul;
                }else{
                  echo  set_value('judul');
                }
                ?>">
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi" value="<?php 
                if(set_value('deskripsi')=="" && isset($deskripsi)){
                  echo $deskripsi;
                }else{
                  echo  set_value('deskripsi');
                }
                ?>">
            </div>
            <?php if ($action=='edit' || $action=='view') { ?>
            <div class="form-group">
              <label>Akun yang terlibat</label>
              <div class="row">
                <div class="col-md-11">
                  <select  name="pilihakun" id="pilihakun" class="form-control">
                    <?php foreach($datanilaiakun as $datnil) : ?>
                      <?php $select = $datnil['id_mst_akun'] == set_value('pilihakun') ? 'selected' : '' ?>
                      <option value="<?php echo $datnil['id_mst_akun'] ?>" <?php echo $select ?>><?php echo $datnil['nama_akun']; ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-md-1" style="padding:5px">
                  <?php if ($action!='view') { ?><a onclick="tambahkanakun()"><i class="glyphicon glyphicon-plus"></i></a><?php }?>
                </div>
              </div>
            </div>
            <div class="form-group">
            <div class="row">
              <div class="col-md-1"></div>
              <div class="col-md-10">
                <ul class="list-group">
                  <?php foreach ($dataallakun as $datakun) { ?>
                    <li class="list-group-item" id="dataakun<?php echo $datakun['id_mst_buku_besar'].'_'.$datakun['id_mst_akun'];?>"><?php echo $datakun['uraian']; ?>  <?php if ($action!='view') { ?><a onclick='deleteakun("<?php echo $datakun['id_mst_buku_besar'] ?>","<?php echo $datakun['id_mst_akun'] ?>")'><i class="glyphicon glyphicon-trash pull-right"></i></a><?php } ?></li>
                  <?php }?>
                  <div id="isiakundata"></div>
                </ul>
              </div>
              <div class="col-md-1"></div>
            </div>
          </div>
            
            <?php } ?>
            <div class="form-group">
              <label>Pisahkan berdasarkan</label>
              <select  name="pisahkan_berdasar" id="pisahkan_berdasar" class="form-control">
                <?php foreach($datapisah as $datpis => $valuedatpis) : 
                  if (isset($pisahkan_berdasar)) {
                    $pisahkan_berdasar =$pisahkan_berdasar;
                  }else{
                    $pisahkan_berdasar =set_value('pisahkan_berdasar');
                  }
                ?>
                  <?php $select = $datpis == $pisahkan_berdasar ? 'selected' : '' ?>
                  <option value="<?php echo $datpis ?>" <?php echo $select ?>><?php echo ucfirst($valuedatpis) ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="form-group">
              <input type="checkbox" id="aktif" name="aktif" <?php 
                if(set_value('aktif')=="" && isset($aktif) && $aktif==1){
                  echo "checked='checked'";
                }else{
                  if ($action=='edit' && isset($aktif) && $aktif==1) {
                    echo "checked='checked'";
                  }else{
                    echo  "";
                  }
                }
                ?>"> <label>Aktip</label>
            </div>
          </div>
          </div><!-- /.box-body -->
      </div><!-- /.box -->
  	</div><!-- /.box -->
  </div><!-- /.box -->
</form>
</section>

<script>
	$(function () {	
    $("#menu_master_data").addClass("active");
    $("#menu_mst_agama").addClass("active");
    $("#close_popup").click(function(){
        close_popup();
    });
	});
function tambahkanakun() {
  var data = new FormData();
    pilihakun = $("#pilihakun").val();
    data.append('id_mst_akun', pilihakun);
    data.append('id_mst_buku_besar', "<?php echo $kode;?>");

    $.ajax({
     cache : false,
     contentType : false,
     processData : false,
     type: 'POST',
     url : '<?php echo base_url()."mst/keuangan_bukubesar/add_akundata/" ?>',
     data : data,
     success: function (response) {
      a = response.split("|");
        if(a[0]=="OK"){
              var form_kredit = '<li class="list-group-item" id="dataakun'+a[1]+'_'+a[2]+'">'+a[3]+' <a onclick="deleteakun(\''+a[1]+'\',\''+a[2]+'\')"><i class="glyphicon glyphicon-trash pull-right"></i></a></li>';

              $('#isiakundata').append(form_kredit);
          
        }else if(a[0]=="duplicate"){
            alert("Akun pernah ditambahkan");
        }else{
            alert("Failed.");
        }
     }
  });
}



$('#form-ss').submit(function(){
    var data = new FormData();
    $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
    $('#notice').show();
    data.append('judul',              $('input[name="judul"]').val());
    data.append('deskripsi',          $('input[name="deskripsi"]').val());
    data.append('pisahkan_berdasar',  $('#pisahkan_berdasar').val());
    if($('#aktif').is(':checked')){
        data.append('aktif',  1);
    }
    $.ajax({
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
        url : "<?php echo base_url()?>mst/keuangan_bukubesar/{action}/{kode}",
        data : data,
        success : function(response){
          var res  = response.split("|");
          if(res[0]=="OK"){
              $('#notice').hide();
              $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
              $('#notice').show();

              $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
              close_popup();
          }
          else if(res[0]=="Error"){
              $('#notice').hide();
              $('#notice-content').html('<div class="alert">'+res[1]+'</div>');
              $('#notice').show();
          }
          else{
              $('#popup_content').html(response);
          }
      }
    });

    return false;
});
function deleteakun(id_buku,id_akun) {
  if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."mst/keuangan_bukubesar/delete_dataakun/" ?>',
       data : 'id_buku='+id_buku+'&id_akun='+id_akun,
       success: function (response) {
        res = response.split("|");
        if(res[0]=="OK"){  
          $("#dataakun"+id_buku+'_'+id_akun).remove();
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}
</script>
