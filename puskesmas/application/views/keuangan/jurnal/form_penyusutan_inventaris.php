
<?php if(validation_errors()!=""){ ?>
<div class="alert alert-warning alert-dismissable">
  <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
  <h4>  <i class="icon fa fa-check"></i> Information!</h4>
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
<div class="box-body">
<form action="<?php echo base_url()?>keuangan/jurnal/$action" method="post">
  <div class="box box-primary">
    <div class="box-body">
      <div class="row pull-right">
        <div class="box-body">
          <button type="reset" id="btn-reset_penyusutan_jurum" class="btn btn-success"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
          <button type="button" id="btn-simpan_penyusutan_jurum" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-saved"></i> Simpan Perubahan</button>
          <button type="button" id="btn-delete_penyusutan_jurum" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
          <button type="button" id="btn-close_penyusutan_jurum" class="btn btn-warning"><i class="glyphicon glyphicon-remove"></i> Batal</button>
        </div>
      </div>
        <div class="box-body">
          <h3>{title_form}</h3>
          <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Jenis Transaksi</div>
          <div class="col-md-9">
            <select disabled="disabled" id="jenistransaksipenyesuaian" name="jenistransaksipenyesuaian"  class="form-control">
                <?php foreach ($filetransaksi as $datjentrans) { 
                  $select = $datjentrans->id_mst_transaksi==$id_mst_keu_transaksi ? 'selected' :'';
                ?>
                  <option value="<?php echo $datjentrans->id_mst_transaksi;?>" <?php echo $select;?>><?php echo $datjentrans->nama;?></option>
                <?php } ?>
              </select>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Kategori</div>
          <div class="col-md-9">
            <select disabled="disabled"  id="kategori_transaksipenyesuaian" name="kategori_transaksipenyesuaian"  class="form-control">
                <?php foreach ($filterkategori_transaksi as $key) { 
                  $select = $key->id_mst_kategori_transaksi==$id_kategori_transaksi ? 'selected' :'';
                ?>
                  <option value="<?php echo $key->id_mst_kategori_transaksi;?>" <?php echo $select;?>><?php echo $key->nama;?></option>
                <?php } ?>
              </select>
          </div>
        </div>
        <!-- <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Alasan Perubahan</div>
          <div class="col-md-9">
            <textarea id="alasan_perubahan" name="alasan_perubahan" class="form-control"><?php 
             /* if(set_value('alasan_perubahan')=="" && isset($alasan_perubahan)){
                echo $alasan_perubahan;
              }else{
                echo  set_value('nomor_balasan_perubahanukti_kas');
              }*/
              ?></textarea> 
          </div>
        </div> -->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Informasi Dasar</h3></div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3" style="padding: 5px">Nomor Transaksi</div>
          <div class="col-md-9">
            <input type="text" disabled="disabled" id="id_transaksipenyesuaian" name="id_transaksipenyesuaian" placeholder="Nomor Transaksi"  class="form-control" value="<?php 
              if(set_value('id_transaksipenyesuaian')=="" && isset($id_transaksi)){
                echo substr($id_transaksi, -10);
              }else{
                echo  set_value('id_transaksipenyesuaian');
              }
              ?>" />
          </div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-3">Tanggal Transaksi</div>
          <div class="col-md-9">
            <div type="text" id="tgl_transaksipenyesuaian" name="tgl_transaksipenyesuaian" value="<?php 
                        if(set_value('tgl_transaksipenyesuaian')=="" && isset($tanggal)){
                          echo $tanggal;
                        }else{
                          echo  set_value('tgl_transaksipenyesuaian');
                        }
                        ?>"></div>
          </div>
        </div>
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><h3>Daftar Transaksi</h3></div>
        </div>
        <!--
        ini create
        -->
        <div class="row" style="margin: 5px">
          <div class="col-md-12" style="padding: 5px"><button type="button" id="add_inventaris" onclick="add_datainventaris()" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Tambah Inventaris</button></div>
        </div><br>
        <div class="row" style="margin: 5px">
          <div class="col-md-12">
<!--show hide-->
    <div id="jurnaltrasaksidata_penyusutan">
      <?php foreach($getallinventaris as $keyinv) { ?>
            <div id="createtransaksiinventaris<?php echo $keyinv['id_transaksi_inventaris'];?>" name="createtransaksiinventaris">
              <div class="row" style="border-bottom:solid #3333ff;"> 
                 <div class="col-md-1" style="padding:5px"><i class="glyphicon glyphicon-trash" onclick='delete_jurnalpenyesuaian("<?php echo $keyinv['id_transaksi_inventaris'];?>")'></i></div>
                 <div class="col-md-10"><font size="4"><b><?php echo $keyinv['nama_barang'] ?></b></font></div>
                 <div class="col-md-1">
                      <b><i  id="showdown<?php echo $keyinv['id_transaksi_inventaris'];?>" name="showdown" class="glyphicon glyphicon-chevron-down" onclick='showdowndata("<?php echo $keyinv['id_transaksi_inventaris'];?>")'></i></b>
                    <b><i id="showup<?php echo $keyinv['id_transaksi_inventaris'];?>" name="showup" class="glyphicon glyphicon-chevron-up" onclick='showupdata("<?php echo $keyinv['id_transaksi_inventaris'];?>")'></i></b>
                 </div>

              </div>
              <div id="showhide<?php echo $keyinv['id_transaksi_inventaris'];?>" name="showhide">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-3">
                      Transaksi Penyusutan
                    </div>
                    <div class="col-md-2">
                      <div onchange='updatedatadetail("<?php echo $keyinv['id_transaksi_inventaris'];?>","tgl_periode_penyusutan_awal","periode_penyusutan_awal","keu_transaksi_inventaris")' id="tgl_periode_penyusutan_awal<?php echo $keyinv['id_transaksi_inventaris'];?>" name="tgl_periode_penyusutan_awal" value="<?php 
                        if(set_value('tgl_periode_penyusutan_awal')=="" && isset($keyinv['periode_penyusutan_awal'])){
                          echo $keyinv['periode_penyusutan_awal'];
                        }else{
                          echo  set_value('tgl_periode_penyusutan_awal');
                        }
                        ?>" ></div>&nbsp;&nbsp;
                    </div>
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-6">
                      <div onchange='updatedatadetail("<?php echo $keyinv['id_transaksi_inventaris'];?>","tgl_periode_penyusutan_akhir","periode_penyusutan_akhir","keu_transaksi_inventaris")' id="tgl_periode_penyusutan_akhir<?php echo $keyinv['id_transaksi_inventaris'];?>" name="tgl_periode_penyusutan_akhir" value="<?php 
                        if(set_value('tgl_periode_penyusutan_akhir')=="" && isset($keyinv['periode_penyusutan_akhir'])){
                          echo $keyinv['periode_penyusutan_akhir'];
                        }else{
                          echo  set_value('tgl_periode_penyusutan_akhir');
                        }
                        ?>" ></div>
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-3" style="padding: 5px">Uraian</div>
                    <div class="col-md-9">
                      <input type="text" onchange='updatedatadetail("<?php echo $keyinv['id_transaksi_inventaris'];?>","uraian","uraian","keu_transaksi_inventaris")' id="uraian<?php echo $keyinv['id_transaksi_inventaris'];?>" name="uraian" placeholder="Uraian"  class="form-control" value="<?php 
                        if(set_value('uraian')=="" && isset($keyinv['uraian'])){
                          echo $keyinv['uraian'];
                        }else{
                          echo  set_value('uraian');
                        }
                        ?>" />
                    </div>
                  </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Alat</div>
                    <div class="col-md-3">
                      Debit
                    </div>
                    <div class="col-md-3">
                      Kredit
                    </div>
                  </div>
              <div clas='box-body'>
              <?php foreach ($keyinv['childern'] as $keydetail) { ?>
                  <div class="row" id="detailinventaris<?php echo $keydetail['id_jurnal'];?>" name="detailinventaris">
                    <?php if ($keydetail['status']=='kredit') { ?>
                    <div class="col-md-6" style="padding: 5px">
                    <?php }else{?>
                      <div class="col-md-1" style="padding: 5px"> </div>
                      <div class="col-md-5" style="padding: 5px"> 
                    <?php } ?>
                      <select  onchange='updatedatadetailtransaksi("<?php echo $keydetail['id_jurnal'];?>","id_mst_akun","id_mst_akun","keu_jurnal")' id="id_mst_akun<?php echo $keydetail['id_jurnal'];?>" name="id_mst_akun" class="form-control">
                        <?php  foreach ($getdataakun as $dataakun) { 
                          $select = $dataakun->id_mst_akun == $keydetail['id_mst_akun'] ? 'selected' : '';
                        ?>
                          <option value="<?php echo $dataakun->id_mst_akun?>" <?php echo $select;?>><?php echo  $dataakun->uraian?></option>
                        <?php } ?>
                      </select>
                    </div>

                    <div class="col-md-3" >
                      <?php if ($keydetail['status']=='debet') { ?>
                      <input onchange='updatedatadetailtransaksi("<?php echo $keydetail['id_jurnal'];?>","jml_debit","debet","keu_jurnal")' type="text" id="jml_debit<?php echo $keydetail['id_jurnal'];?>" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('jml_debit')=="" && isset($keydetail['debet'])){
                          echo $keydetail['debet'];
                        }else{
                          echo  set_value('jml_debit');
                        }
                        ?>" />
                      <?php }?>
                    </div>
                    <div class="col-md-3">
                      <?php if ($keydetail['status']=='kredit') { ?>
                      <input onchange='updatedatadetailtransaksi("<?php echo $keydetail['id_jurnal'];?>","jml_kredit","kredit","keu_jurnal")'  type="text" id="jml_kredit<?php echo $keydetail['id_jurnal'];?>" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('jml_kredit')=="" && isset($keydetail['kredit'])){
                          echo $keydetail['kredit'];
                        }else{
                          echo  set_value('jml_kredit');
                        }
                        ?>" />
                      <?php }?>
                    </div>
                  </div>
              <?php } ?>
              </div>
                  <div class="row" style="margin: 5px">
                    <div class="col-md-6" style="padding: 5px">Total</div>
                    <div class="col-md-3">
                      <input type="text" disabled="disabled" id="totaljml_debit<?php echo $keyinv['id_transaksi_inventaris'];?>" name="totaljml_debit" placeholder="Jumlah Debit"  class="form-control" value="<?php 
                        if(set_value('totaljml_debit')=="" && isset($keyinv['totaldebet'])){
                          echo $keyinv['totaldebet'];
                        }else{
                          echo  set_value('totaljml_debit');
                        }
                        ?>" />
                    </div>
                    <div class="col-md-3">
                      <input type="text" disabled="disabled" id="totaljml_kredit<?php echo $keyinv['id_transaksi_inventaris'];?>" name="totaljml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="<?php 
                        if(set_value('totaljml_kredit')=="" && isset($keyinv['totalkredit'])){
                          echo $keyinv['totalkredit'];
                        }else{
                          echo  set_value('totaljml_kredit');
                        }
                        ?>" />
                    </div>
                  </div>


                </div>
              </div>
            </div>
        <?php } ?>   
    </div>  
<!--show hide-->
          </div>
        </div>
        <!--End create -->
        
      </div>
    </div>
  </div>
</form>        
</div>
<div id="popup_inventaris" style="display:none">
  <div id="popup_title_inventaris">Data Inventaris</div>
  <div id="popup_content_inventaris">&nbsp;</div>
</div>
<script type="text/javascript">
$(function(){
  <?php if (count($getallinventaris) > 0) { ?>
    $("[name='tgl_periode_penyusutan_awal']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
    $("[name='tgl_periode_penyusutan_akhir']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  <?php }?>
  $('#btn-close_penyusutan_jurum').click(function(){
      window.location.href="<?php echo base_url()?>keuangan/jurnal";
  });
  
  $("#tgl_transaksipenyesuaian").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  $("[name='showhide']").hide();
  $("[name='showdown']").hide();
  $("[name='showup']").show();
});

function showdowndata(id){
  $("#showdown"+id).hide();
  $("#showup"+id).show();
  $("#showhide"+id).hide("slow");
}
function showupdata(id){
  $("#showup"+id).hide();
  $("#showdown"+id).show();
  $("#showhide"+id).show("slow");
}
function add_datainventaris(){
  // var id=0;
  $("#popup_inventaris #popup_content_inventaris").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
  $.get("<?php echo base_url().'keuangan/jurnal/add_penyusutan_inventaris/'.$id; ?>", function(data) {
    $("#popup_content_inventaris").html(data);
  });
  $("#popup_inventaris").jqxWindow({
    theme: theme, resizable: false,
    width: 500,
    height: 800,
    isModal: true, autoOpen: false, modalOpacity: 0.2
  });
  $("#popup_inventaris").jqxWindow('open');
  // $.get("<?php echo base_url().'keuangan/jurnal/add_inventaris/' ?>",  function(data) {
  //     $("#popup_inventaris").jqxWindow('close');
  //     addinventaris(data);
  // });
}

function addinventaris(data){
  var obj = $.parseJSON(data);
  var form_create_data ='';
  var form_create_detail ='';
  $.each(obj, function(key,value) {
    form_create_data += '<div id="createtransaksiinventaris'+value.id_transaksi_inventaris+'" name="createtransaksiinventaris">\
              <div class="row" style="border-bottom:solid #3333ff;">\
                 <div class="col-md-1" style="padding:5px"><i class="glyphicon glyphicon-trash" onclick="delete_jurnalpenyesuaian(\''+value.id_transaksi_inventaris+'\')"></i></div>\
                 <div class="col-md-10"><font size="4"><b>'+value.nama_barang+'</b></font></div>\
                 <div class="col-md-1">\
                      <b><i  id="showdown'+value.id_transaksi_inventaris+'" name="showdown" class="glyphicon glyphicon-chevron-down" onclick="showdowndata(\''+value.id_transaksi_inventaris+'\')"></i></b>\
                    <b><i id="showup'+value.id_transaksi_inventaris+' name="showup" class="glyphicon glyphicon-chevron-up" onclick="showupdata(\''+value.id_transaksi_inventaris+'\')"></i></b>\
                 </div>\
              </div>\
              <div id="showhide'+value.id_transaksi_inventaris+'" name="showhide">\
                <div class="box-body">\
                  <div class="row">\
                    <div class="col-md-3">\
                      Transaksi Penyusutan\
                    </div>\
                    <div class="col-md-2">\
                      <div onchange="updatedatadetail(\''+value.id_transaksi_inventaris+'\',\'tgl_periode_penyusutan_awal\',\'periode_penyusutan_awal\',\'keu_transaksi_inventaris\')" id="tgl_periode_penyusutan_awal'+value.id_transaksi_inventaris+'" name="tgl_periode_penyusutan_awal"></div>&nbsp;&nbsp;\
                    </div>\
                    <div class="col-md-1">\
                    </div>\
                    <div class="col-md-6">\
                      <div onchange="updatedatadetail(\''+value.id_transaksi_inventaris+'\',\'tgl_periode_penyusutan_akhir\',\'periode_penyusutan_akhir\',\'keu_transaksi_inventaris\')" id="tgl_periode_penyusutan_akhir'+value.id_transaksi_inventaris+'" name="tgl_periode_penyusutan_akhir"></div>\
                    </div>\
                  </div>\
                  <div class="row" style="margin: 5px">\
                    <div class="col-md-3" style="padding: 5px">Uraian</div>\
                    <div class="col-md-9">\
                      <input type="text" onchange="updatedatadetail(\''+value.id_transaksi_inventaris+'\',\'uraian\',\'uraian\',\'keu_transaksi_inventaris\')" id="uraian'+value.id_transaksi_inventaris+'" name="uraian" placeholder="Uraian"  class="form-control" value="'+value.uraian+'" />\
                    </div>\
                  </div>\
                  <div class="row" style="margin: 5px">\
                    <div class="col-md-6" style="padding: 5px">Alat</div>\
                    <div class="col-md-3">\
                      Debit\
                    </div>\
                    <div class="col-md-3">\
                      Kredit\
                    </div>\
                  </div>\
                  <div clas="box-body">';

          $.each(value.childern, function(keychildern,valuechildern) {
                form_create_data +='<div class="row" id="detailinventaris'+valuechildern.id_jurnal+'" name="detailinventaris">';
                  if (valuechildern.status=='kredit') {
                  form_create_data+='<div class="col-md-6" style="padding: 5px">';
                  }else{
                  form_create_data+='<div class="col-md-1" style="padding: 5px"> </div>\
                      <div class="col-md-5" style="padding: 5px">';
                  }
                  form_create_data+='<select onchange="updatedatadetailtransaksi(\''+valuechildern.id_jurnal+'\',\'id_mst_akun\',\'id_mst_akun\',\'keu_jurnal\')" id="id_mst_akun'+valuechildern.id_jurnal+'" name="id_mst_akun" class="form-control">\
                      </select>\
                    </div>\
                    <div class="col-md-3" >';
                  if (valuechildern.status=='debet') {
                    form_create_data+='<input  onchange="updatedatadetailtransaksi(\''+valuechildern.id_jurnal+'\',\'jml_debit\',\'debet\',\'keu_jurnal\')" type="text" id="jml_debit'+valuechildern.id_jurnal+'" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="'+valuechildern.debet+'" />';
                  }
                  form_create_data+='</div>\
                        <div class="col-md-3">';

                  if (valuechildern.status=='kredit') {
                      form_create_data+='<input onchange="updatedatadetailtransaksi(\''+valuechildern.id_jurnal+'\',\'jml_kredit\',\'kredit\',\'keu_jurnal\')" type="text" id="jml_kredit'+valuechildern.id_jurnal+'" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="'+valuechildern.kredit+'" />';
                  }
                  form_create_data+='</div>\
                  </div>';
                  mengisiselectcreate(valuechildern.id_jurnal);
        });
    form_create_data +='</div>\
                    <div class="row" style="margin: 5px">\
                    <div class="col-md-6" style="padding: 5px">Total</div>\
                    <div class="col-md-3">\
                      <input disabled="disabled" type="text" id="totaljml_debit'+value.id_transaksi_inventaris+'" name="jml_debit" placeholder="Jumlah Debit"  class="form-control" value="'+value.totaldebet+'" />\
                    </div>\
                    <div class="col-md-3">\
                      <input disabled="disabled" type="text" id="totaljml_kredit'+value.id_transaksi_inventaris+'" name="jml_kredit" placeholder="Jumlah Kredit"  class="form-control" value="'+value.totalkredit+'" />\
                    </div>\
                  </div>\
                </div>\
              </div>\
            </div>';

  });
  $('#jurnaltrasaksidata_penyusutan').append(form_create_data);
  $("[name='showhide']").hide();
  $("[name='showdown']").hide();
  $("[name='showup']").show();
  $("[name='tgl_periode_penyusutan_awal']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
  $("[name='tgl_periode_penyusutan_akhir']").jqxDateTimeInput({ formatString: 'dd-MM-yyyy', theme: theme});
}
function mengisiselectcreate(key){
  $.get("<?php echo base_url()."keuangan/jurnal/getdataakun/" ?>",function(data){
      var objda = $.parseJSON(data);
      var options = [];
      $.each(objda, function(idx, obj) {
        options.push('<option value="'+obj.id_mst_akun+'">'+ obj.uraian +'</option>');
      });
      $('#id_mst_akun'+key+'').html(options);
  });
}
function delete_jurnalpenyesuaian(id_transaksi_inv) {
  if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."keuangan/jurnal/delete_penyusutan_transaksi/" ?>',
       data : 'id_transaksi_inv='+id_transaksi_inv,
       success: function (response) {
        if(response=='OK'){
            $("#createtransaksiinventaris"+id_transaksi_inv).remove();
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}
function updatedatadetail(idinv,namahtml,dataubah,namatable){
  values = $("#"+namahtml+idinv).val();
  $.post("<?php echo base_url().'keuangan/jurnal/ubahdata/'?>",{
            'id_transaksi':"<?php echo $id?>",
            'idinv':idinv,
            'dataubah':dataubah,
            'values':values,
            'table':namatable,
          },  function(data){
  });
}
function updatedatadetailtransaksi(idjurnal,namahtml,dataubah,namatable){
  values = $("#"+namahtml+idjurnal).val();
  $.post("<?php echo base_url().'keuangan/jurnal/ubahdatadetail/'?>",{
            'id_transaksi':"<?php echo $id?>",
            'idjurnal':idjurnal,
            'dataubah':dataubah,
            'values':values,
            'table':namatable,
          },  function(data){
            if (dataubah=='debet' || dataubah=='kredit') {
              updatetotal(idjurnal,namahtml,dataubah,namatable);
            }
  });
}
function updatetotal(idjurnal,namahtml,dataubah,namatable){
  values = $("#"+namahtml+idjurnal).val();
  $.post("<?php echo base_url().'keuangan/jurnal/gettotaldetail/'?>",{
            'id_transaksi':"<?php echo $id?>",
            'idjurnal':idjurnal,
            'dataubah':dataubah,
            'values':values,
            'table':namatable,
          },  function(data){
            res = data.split(' | ');
            if (res[0]=='OK') {
              if (dataubah=='debet') {
                $("#totaljml_debit"+res[2]).val(res[1]);
              }else{
                $("#totaljml_kredit"+res[2]).val(res[1]);
              }
            }
  });
}
$("#btn-simpan_penyusutan_jurum").click(function(){
  $.get("<?php echo base_url()."keuangan/jurnal/gettotaldebetkreditpenyesuaian/$id/" ?>",function(data){
    ob = data.split(' | ');
      if (ob[0]=='error') {
        alert('Maaf ! '+ ob[1] +' Silahkan perbaiki terlebih dahulu');
      }else{
        var data = new FormData();
        $('#notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#notice').show();
        data.append('id_transaksi', "<?php echo $id;?>");
        data.append('tanggal', $('#tgl_transaksipenyesuaian').val());

        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."keuangan/jurnal/edit_junal_penyesuaian/$id/" ?>',
            data : data,
            success : function(response){
              var res  = response.split("|");
              if(res[0]=="OK"){
                var obj = jQuery.parseJSON(res[1]);
                $("#error_mssg").addClass("alert alert-success alert-dismissable").show();
                $("#mssgerr").html('Data berhasil diubah');
              }
              else if(res[0]=="Error"){
                 var obj = jQuery.parseJSON(res[1]);
                  $("#error_mssg").addClass("alert alert-danger alert-dismissable").show();
                  $("#mssgerr").html(obj.err_msg);
              }
              else{
                  var obj = jQuery.parseJSON(res[1]);
                  $("#error_mssg").addClass("alert alert-warning alert-dismissable").show();
                  $("#mssgerr").html(obj.err_msg);
              }
          }
        });
        return false;
      }
 });
});
</script>