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

<script>
  $(function() {
    $("#menu_master_data").addClass("active");
    $("#menu_mst_keuangan_transaksi").addClass("active");
  });
</script>

<section class="content">
  <div class="row">
    <form action="<?php echo base_url()?>mst/keuangan_transaksi/transaksi_{action}/{id}" method="post" name="editform">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">{title_form}</h3>
        </div>
        <div class="box-footer">
          <button type="button" id="btn-kembali" class="btn btn-primary pull-right"><i class='fa  fa-arrow-circle-o-left'></i> &nbsp;Kembali</button>
          <button type="button" name="btn_transaksi_save" class="btn btn-warning"><i class='fa fa-save'></i> &nbsp; Simpan</button>
          <button type="reset" value="Reset" class="btn btn-success"><i class='fa fa-refresh'></i> &nbsp; Reset</button>
        </div>
        <div class="box-body">

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Nama Transaksi</div>
          <div class="col-md-8">
            <input type="text" class="form-control" name="transaksi_nama" placeholder="Pembayaran Biaya Jasa Pelayanan" value="<?php 
              if(set_value('nama')=="" && isset($nama)){
               echo $nama;
              }else{
               echo  set_value('nama');
              }
            ?>">
          </div>
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Deskripsi</div>
          <div class="col-md-8">
            <textarea class="form-control" name="transaksi_deskripsi" placeholder="Deskripsi Dari Kategori"><?php 
              if(set_value('deskripsi')=="" && isset($deskripsi)){
              echo $deskripsi;
              }else{
              echo  set_value('deskripsi');
              }
              ?>
            </textarea>
         </div>  
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Untuk Jurnal</div>
        <div class="col-md-8">
          <select name="transaksi_jurnal" type="text" class="form-control">
          <?php 
            if(set_value('transaksi_jurnal')=="" && isset($untuk_jurnal)){
              $transaksi_jurnal = $untuk_jurnal;
            }else{
              $transaksi_jurnal = set_value('transaksi_jurnal');
            }
          ?>
            <option value="semua" <?php if($transaksi_jurnal=="semua") echo "selected" ?>>Semua</option>
            <option value="jurnal_umum" <?php if($transaksi_jurnal=="jurnal_umum") echo "selected" ?>>Jurnal Umum</option>
            <option value="jurnal_penyesuaian" <?php if($transaksi_jurnal=="jurnal_penyesuaian") echo "selected" ?>>Jurnal Penyesuaian</option>
            <option value="jurnal_penutup" <?php if($transaksi_jurnal=="jurnal_penutup") echo "selected" ?>>Jurnal Penutup</option>
          </select>
        </div>
      </div>

      <div class="row" style="margin: 5px">
        <div class="col-md-4" style="padding: 5px">Kategori</div>
        <div class="col-md-8">
          <select  name="transaksi_kategori" type="text" class="form-control">
          <?php foreach($kategori as $k) { ?>
            <?php
              if(set_value('id_mst_kategori_transaksi')=="" && isset($id_mst_kategori_transaksi)){
              $id_mst_kategori_transaksi = $id_mst_kategori_transaksi;
              }else{
              $id_mst_kategori_transaksi = set_value('id_mst_kategori_transaksi');
              }
              $select = $k->id_mst_kategori_transaksi == $id_mst_kategori_transaksi ? 'selected' : '' ;
            ?>
            <option value="<?php echo $k->id_mst_kategori_transaksi ?>" <?php echo $select ?>><?php echo $k->nama ?></option>
          <?php } ?>
          </select>
        </div>
      </div>
      
      <br><br>
      <div class="col-md-12">
        <div class="pull-right"><label>Jurnal Transaksi</label> <a class="glyphicon glyphicon-plus" id="create_jurnal_transaksi" name="create_jurnal_transaksi"></a></div>
      </div>  

      <div id="jurnal_transaksi" class="col-md-12">
       <?php foreach($jurnal_transaksi as $jt) { ?>
        <div id="jt-<?php echo $jt->group ?>">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Jurnal Pasangan</h3>
              <div class="pull-right"><a id="delete-<?php echo $jt->group ?>" name="delete" onclick='deletejt("<?php echo $jt->group ?>")'  class="glyphicon glyphicon-trash"></a></div>
            </div>
            <div class="box-body">
              <div class="row">
                <div id="debit-<?php echo $jt->group ?>" class="col-sm-6">
                  <div class="row">
                    <div class="col-md-7" style="padding-top:5px;"><label> Debit</label> </div>
                    <div class="col-md-1">
                      <?php
                        if(count($kredit[$jt->group]) > "1"){?>
                            <a style="visibility: hidden" class="glyphicon glyphicon-plus" id="add_debit-<?php echo $jt->group?>" onclick='add_debit("<?php echo $jt->group?>")' name="add_debit-<?php echo $jt->group?>"></a>
                         <?php }else{  ?>
                            <a class="glyphicon glyphicon-plus" id="add_debit-<?php echo $jt->group?>" name="add_debit-<?php echo $jt->group?>" onclick='add_debit("<?php echo $jt->group?>")'></a>
                      <?php } ?>
                    </div> 
                  </div>
                <?php foreach($debit[$jt->group] as $row) { ?>
                  <div id="debt-<?php echo $row->id_mst_transaksi_item ?>" name="debt-<?php echo $row->group ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="row" style="margin: 5px">
                            <div class="col-md-8">
                              <input type="hidden" class="form-control" name="debit_id" id="debit_id" value="<?php echo $row->id_mst_transaksi_item ?>">
                            </div>
                          </div>
                          <div class="col-md-8" style="padding-top:5px;">
                           <select id="debit_akun-<?php echo $row->id_mst_transaksi_item ?>" name="debit_akun-<?php echo $row->group ?>" onchange="debit_akun(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" type="text" class="form-control">
                              <?php foreach($akun as $a) { ?>
                                <?php
                                  if(set_value('id_mst_akun')=="" && isset($row->id_mst_akun)){
                                    $id_mst_akun = $row->id_mst_akun;
                                  }else{
                                    $id_mst_akun = set_value('id_mst_akun');
                                  }
                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                ?>
                                <option value="<?php echo $a->id_mst_akun ?>" <?php echo $select ?>><?php echo $a->uraian ?></option>
                                <?php } ?>
                            </select>
                          </div>
                          <?php 
                          if(count($debit[$jt->group]) > "1"){?>
                            <script type="text/javascript">
                              $(function(){
                                $('[name="debit_value_nilai-<?php echo $row->group ?>"]').show();
                                $('[name="label_persen_debit-<?php echo $row->group ?>"]').show();
                                $('[name="delete_debit-<?php echo $row->group ?>"]').show();
                              })
                            </script>
                          <?php }else{ ?>
                            <script type="text/javascript">
                              $(function(){
                                $('[name="debit_value_nilai-<?php echo $row->group ?>"]').hide();
                                $('[name="label_persen_debit-<?php echo $row->group ?>"]').hide();
                                $('[name="delete_debit-<?php echo $row->group ?>"]').hide();
                              })
                            </script>
                          <?php } ?>
                          <div class="col-md-1">
                            <div class="parentDiv">
                              <a data-toggle="collapse" data-target="#debit<?php echo $row->id_mst_transaksi_item ?>" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <a id="delete_debit-<?php echo $row->id_mst_transaksi_item ?>" name="delete_debit-<?php echo $row->group ?>" onclick="delete_debit(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" class="glyphicon glyphicon-trash"></a>
                          </div> 
                      </div>
                    </div>
                  </div>
                  <div class="collapse" id="debit<?php echo $row->id_mst_transaksi_item ?>">
                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="debit_isi_otomatis-<?php echo $row->id_mst_transaksi_item ?>" name="debit_isi_otomatis-<?php echo $row->group ?>" onclick="debit_isi_otomatis(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>,this)" value="<?php echo (isset($row->auto_fill) && $row->auto_fill!='0') ? $row->auto_fill : '0';?>" 
                            <?php 
                              if(!empty($row->auto_fill)){
                               echo "checked";
                              }
                            ?>>
                          </div> 
                          <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                        </div>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-sm-1"></div>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                          <div class="col-md-7">
                            <select <?php echo ((!empty($row->auto_fill) && $row->auto_fill=='1') ? "" : 'disabled') ;?> name="debit_cmbx_nilai-<?php echo $row->group ?>" id="debit_cmbx_nilai-<?php echo $row->id_mst_transaksi_item ?>" type="text" class="form-control">
                                <?php
                              if(count($debit[$jt->group]) > "1"){
                                echo '<option value=""></option>';
                                 foreach($nilai_debit[$row->group] as $nd) { ?>
                                  <?php
                                    if(set_value('id_mst_akun')=="" && isset($row->id_mst_akun)){
                                      $id_mst_akun = $row->id_mst_akun;
                                    }else{
                                      $id_mst_akun = set_value('id_mst_akun');
                                    }
                                    //$select = $nd->id_mst_akun == $id_mst_akun ? 'style="display:none"' : '' ;
                                      if ($nd->id_mst_akun != $id_mst_akun) {?>
                                        <option value="<?php echo $nd->id_mst_akun ?>"><?php echo $nd->uraian ?></option>
                              <?php   }
                                    }
                              }else{
                                echo "<option value=".'"kredit##'.$row->group.'##'.$id.'"'.">All Kredit</option>";
                              } 
                              ?>
                            </select>
                          </div> 
                          <div class="col-md-2">
                            <input type="text" <?php echo ((!empty($row->auto_fill) && $row->auto_fill=='1') ? "" : 'disabled') ;?> class="form-control" id="debit_value_nilai-<?php echo $row->id_mst_transaksi_item ?>" name="debit_value_nilai-<?php echo $row->group ?>" onchange="debit_value_nilai(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" value="<?php echo $row->value ?>">
                          </div>
                          <div class="col-md-1" style="padding-top:5px;"><label name="label_persen_debit-<?php echo $row->group ?>">%</label> </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="debit_opsional-<?php echo $row->id_mst_transaksi_item ?>" name="debit_opsional-<?php echo $row->group ?>" value="<?php echo ((isset($row->opsional) && $row->opsional!='0') ? $row->opsional : '0')?>" <?php 
                              if(!empty($row->opsional)){ echo "checked";}
                            ?> onclick="select_opsional(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>,'debit')">
                          </div> 
                          <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>

              <div id="kredit-<?php echo $jt->group ?>" class="col-sm-6">
                <div class="row">
                  <div class="col-md-8" style="padding-top:5px;"><label>Kredit</label></div>
                  <div class="col-md-2">
                    <?php
                      // print_r(count($debit[$jt->group]));
                      if(count($debit[$jt->group]) > "1"){?>
                          <a style="visibility: hidden" class="glyphicon glyphicon-plus" onclick='add_kredit("<?php echo $jt->group?>")' id="add_kredit-<?php echo $jt->group?>" name="add_kredit-<?php echo $jt->group?>"></a>
                       <?php }else{  ?>
                          <a class="glyphicon glyphicon-plus"  id="add_kredit-<?php echo $jt->group?>" name="add_kredit-<?php echo $jt->group?>" onclick='add_kredit("<?php echo $jt->group?>")'></a>
                    <?php } ?>
                  </div> 
                </div>
              <?php foreach($kredit[$jt->group] as $row) { ?> 
                <div id="kredt-<?php echo $row->id_mst_transaksi_item ?>"   name="kredt-<?php echo $row->group ?>">
                  <div class="row" >
                    <div class="col-md-12">
                      <div class="row">
                        <!-- <div class="col-md-1" style="padding-top:5px;"><label><?php echo $row->urutan ?></label> </div> -->
                        <div class="row" style="margin: 5px">
                          <div class="col-md-8">
                            <input type="hidden" class="form-control" name="kredit_id" id="kredit_id" value="<?php echo $row->id_mst_transaksi_item ?>">
                          </div>
                        </div>

                        <div class="col-md-8" style="padding-top:5px;">
                          <select id="kredit_akun-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_akun-<?php echo $row->group ?>" onchange="kredit_akun(<?php echo $row->id_mst_transaksi_item.','.$row->group ?>)" type="text" class="form-control">
                            <?php foreach($akun as $a) { ?>
                              <?php
                                if(set_value('id_mst_akun')=="" && isset($row->id_mst_akun)){
                                  $id_mst_akuns = $row->id_mst_akun;
                                }else{
                                  $id_mst_akuns = set_value('id_mst_akun');
                                }
                                  $select = $a->id_mst_akun == $id_mst_akuns ? 'selected' : '' ;
                              ?>
                              <option value="<?php echo $a->id_mst_akun ?>" <?php echo $select ?>><?php echo $a->uraian ?></option>
                              <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-1">
                          <div class="parentDiv">
                            <a data-toggle="collapse" data-target="#kredit<?php echo $row->id_mst_transaksi_item ?>" class="toggle_sign glyphicon glyphicon-chevron-down"></a>
                          </div>
                        </div>
                        <?php if(count($kredit[$jt->group]) > "1"){?>
                            <script type="text/javascript">
                              $(function(){
                                $('[name="kredit_value_nilai-<?php echo $row->group ?>"]').show();
                                $('[name="label_persen_kredit-<?php echo $row->group ?>"]').show();
                                $('[name="delete_kredit-<?php echo $row->group ?>"]').show();
                              })
                            </script>
                          <?php }else{ ?>
                            <script type="text/javascript">
                              $(function(){
                                $('[name="kredit_value_nilai-<?php echo $row->group ?>"]').hide();
                                $('[name="label_persen_kredit-<?php echo $row->group ?>"]').hide();
                                $('[name="delete_kredit-<?php echo $row->group ?>"]').hide();
                              })
                            </script>
                          <?php } ?>
                        <div class="col-md-2">
                          <a id="delete_kredit-<?php echo $row->id_mst_transaksi_item ?>" name="delete_kredit-<?php echo $row->group ?>" onclick="delete_kredit(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" class="glyphicon glyphicon-trash"></a>
                        </div> 
                      </div>
                    </div>
                  </div>
                  <div class="collapse" id="kredit<?php echo $row->id_mst_transaksi_item ?>">
                    <div class="row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="kredit_isi_otomatis-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_isi_otomatis" value="<?php echo ((isset($row->auto_fill) && $row->auto_fill!='0') ? $row->auto_fill : '0')?>" <?php 
                              if(!empty($row->auto_fill)){ 
                                echo "checked";
                              }
                            ?> onclick="kr_isi_otomatis(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>,this)">
                          </div> 
                          <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>
                        </div>
                      </div>
                     </div>
                    <div class="row">
                  <div class="col-sm-1"></div>
                    <div class="col-sm-1"></div>
                      <div class="col-sm-10">
                        <div class="row">
                          <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>
                          <div class="col-md-7">
                            <select <?php echo ((!empty($row->auto_fill) && $row->auto_fill=='1') ? "" : 'disabled') ;?> id="kredit_cmbx_nilai-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_cmbx_nilai-<?php echo $row->group?>" type="text" class="form-control">
                              <?php 
                              if(count($kredit[$jt->group]) > "1"){
                                  echo '<option value=""></option>';
                                  foreach($nilai_kredit[$row->group] as $nd) { ?>
                                  <?php
                                    if(set_value('id_mst_akun')=="" && isset($row->id_mst_akun)){
                                      $id_mst_akuns = $row->id_mst_akun;
                                    }else{
                                      $id_mst_akuns = set_value('id_mst_akun');
                                    }
                                    // $select = $nd->id_mst_akun == $id_mst_akuns ? 'style="display:none"' : '' ;
                                    if ( $nd->id_mst_akun != $id_mst_akuns) {?>
                                      <option value="<?php echo $nd->id_mst_akun ?>" <?php echo $select ?>><?php echo $nd->uraian ?></option>
                              <?php      
                                    }
                                  } 
                              }else{
                                echo "<option value=".'"debit##'.$row->group.'##'.$id.'"'.">All Debit</option>";
                              }
                              ?>
                            </select>
                          </div> 
                          
                          <div class="col-md-2">
                            <input type="text" <?php echo ((!empty($row->auto_fill) && $row->auto_fill=='1') ? "" : 'disabled') ;?> class="form-control" id="kredit_value_nilai-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_value_nilai-<?php echo $row->group ?>" onchange="kredit_value_nilai(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>)" value="<?php echo $row->value ?>">
                          </div>
                          <div class="col-md-1" style="padding-top:5px;"><label name="label_persen_kredit-<?php echo $row->group ?>">%</label> </div>
                          
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-1"></div>
                      <div class="col-sm-7">
                        <div class="row">
                          <div class="col-md-1">
                            <input type="checkbox" id="kredit_opsional-<?php echo $row->id_mst_transaksi_item ?>" name="kredit_opsional-<?php echo $row->group ?>" value="<?php echo ((isset($row->opsional) && $row->opsional!='0') ? $row->opsional : '0')?>" <?php 
                              if(!empty($row->opsional)){
                               echo "checked";
                              }
                            ?>  onclick="select_opsional(<?php echo $row->id_mst_transaksi_item ?>,<?php echo $row->group ?>,'kredit')">
                          </div> 
                          <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <!-- <span id="percent-<?php echo $row->group ?>">0</span>% -->
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

  <label>Pengaturan Transaksi</label>

        <div class="row" style="margin: 5px">
          <div class="col-md-12">
            <?php
             $i=1; foreach($template as $t) { ?>
              <input type="checkbox" name="transaksi_template" id="template<?php echo $t->id_mst_setting_transaksi_template;?>" value="<?php echo $t->id_mst_setting_transaksi_template;?>"
            <?php 
            if(!empty($t->id_mst_transaksi)){ echo "checked";}
            ?>> 
              <?php echo $t->setting_judul ?>
              </br>
              <?php echo $t->seting_deskripsi ?>
              </br></br>
            <?php $i++; } ?> 
         </div>
        </div>
       </div>
      </div>
     </form>
    </div>
</section>


<script type="text/javascript">
function add_debit(group){
      var data = new FormData();
      $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
      $('#biodata_notice').show();
      data.append('group',      group);

      $.ajax({
       cache : false,
       contentType : false,
       processData : false,
       type: 'POST',
       url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_debit/{id}" ?>',
       data : data,
       success: function (response) {
        a = response.split("|");
          if(a[0]=="OK"){
            if(a[1]!=null){
              if(a[2]!=null){
                // alert(response);

        var form_debit = '<div id="debt-'+a[1]+'" name="debt-'+a[2]+'">\
                      <div class="row">\
                        <div class="col-md-12">\
                          <div class="row">\
                            <div class="row" style="margin: 5px">\
                              <div class="col-md-8">\
                                <input type="hidden" class="form-control" name="debit_id" id="debit_id">\
                              </div>\
                            </div>\
                            <div class="col-md-8" style="padding-top:5px;">\
                              <select id="debit_akun-'+a[1]+'" name="debit_akun-'+a[2]+'" onchange="debit_akun('+a[1]+','+group+')" class="form-control" type="text">\
                                <?php foreach($akun as $a) { ?>\
                                  <?php
                                    if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                      $id_mst_akun = $id_mst_akun;
                                    }else{
                                      $id_mst_akun = set_value('id_mst_akun');
                                    }
                                      $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                  ?>\
                                  <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
                                  </option>\
                                  <?php } ?>\
                              </select>\
                            </div>\
                            <div class="col-md-1">\
                              <div class="parentDiv">\
                                <a data-toggle="collapse" data-target="#debit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                </a>\
                              </div>\
                            </div>\
                            <div class="col-md-2">\
                              <a id="delete_debit-'+a[1]+'" name="delete_debit-'+a[2]+'" onclick="delete_debit('+a[1]+','+a[2]+')" class="glyphicon glyphicon-trash">\
                              </a>\
                            </div>\
                      </div>\
                    </div>\
                  </div>\
                  <div class="collapse" id="debit'+a[1]+'">\
                    <div class="row">\
                      <div class="col-md-7">\
                        <div class="row">\
                          <div class="col-md-1">\
                           <input type="checkbox" id="debit_isi_otomatis-'+a[1]+'" name="debit_isi_otomatis-'+a[2]+'" onclick="debit_isi_otomatis('+a[1]+','+a[2]+',this)" value="1" <?php 
                              if(set_value('auto_fill')=="" && isset($auto_fill)){
                                  $auto_fill = $auto_fill;
                              }else{
                                  $auto_fill = set_value('auto_fill');
                              }
                                  if($auto_fill == 1) echo "checked";
                            ?>>\
                          </div>\
                          <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label></div>\
                        </div>\
                      </div>\
                    </div>\
                    <div class="row">\
                    <div class="col-sm-1"></div>\
                      <div class="col-sm-10">\
                        <div class="row">\
                          <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
                          <div class="col-md-7">\
                            <select  name="debit_cmbx_nilai-'+a[2]+'" id="debit_cmbx_nilai-'+a[1]+'" type="text" class="form-control">\
                              <?php foreach($nilai_debit[$row->group] as $nd) : ?>\
                                  <?php
                                    if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                      $id_mst_akunsd = $id_mst_akun;
                                    }else{
                                      $id_mst_akunsd = set_value('id_mst_akun');
                                    }
                                    $select = $nd->id_mst_akun == $id_mst_akunsd ? 'style="display:none"' : '' ;
                                  ?>\
                                  <option value="<?php echo $nd->id_mst_akun ?>" <?php echo $select ?>><?php echo $nd->uraian ?></option>\
                              <?php endforeach ?>\
                            </select>\
                          </div>\
                          <div class="col-md-2">\
                            <input type="text" class="form-control" id="debit_value_nilai-'+a[1]+'" name="debit_value_nilai-'+group+'" onchange="debit_value_nilai('+a[1]+')" value="<?php 
                            if(set_value('value')=="" && isset($value)){
                              echo $value;
                            }else{
                              echo  set_value('value');
                            }
                            ?>">\
                        </div>\
                        <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>\
                           <p id="d_value_nilai"></p>\
                        </div>\
                      </div>\
                    </div>\
                      <div class="row">\
                        <div class="col-md-7">\
                          <div class="row">\
                            <div class="col-md-1">\
                              <input type="checkbox" id="debit_opsional-'+a[1]+'" name="debit_opsional" onclick="select_opsional('+a[1]+','+group+',\'debit\')" value="1" <?php 
                              if(set_value('auto_fill')=="" && isset($auto_fill)){
                                  $auto_fill = $auto_fill;
                              }else{
                                  $auto_fill = set_value('auto_fill');
                              }
                                  if($auto_fill == 1) echo "checked";
                            ?>>\
                            </div>\
                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label></div>\
                          </div>\
                        </div>\
                      </div>\
                    </div>';

            $('#debit-'+group).append(form_debit);
            countcreadeb = a[3];
            if (countcreadeb > 1) {
              $('[name="debit_value_nilai-'+group+'"]').show();
              $('[name="label_persen_debit-'+group+'"]').show();
              $('[name="add_kredit-'+group+'"]').hide();
              $('[name="delete_debit-'+group+'"]').show();
            }else{
              $('[name="label_persen_debit-'+group+'"]').hide();
              $('[name="debit_value_nilai-'+group+'"]').hide();
              $('[name="add_kredit-'+group+'"]').show();
              $('[name="delete_debit-'+group+'"]').hide();
            };
            changeselect(group,'debit');
              }else{
                  alert("Kosong");
                };

            }else{
              alert("Kosong");
            };

        }else{
            alert("Failed.");
        }
       }
    });
}
  $("[id='create_jurnal_transaksi']").click(function(){
        var data = new FormData();
        $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
        $('#biodata_notice').show();
              
        $.ajax({
            cache : false,
            contentType : false,
            processData : false,
            type : 'POST',
            url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_pasangan_add/{id}" ?>',
            data : data,
            success : function(response){
              a = response.split("|");
              if(a[0]=="OK"){
                if(a[1]!=null){       //id debit
                  if(a[2]!=null){     //id kredit
                    if(a[3]!=null){   // group
                      if(a[4]!=null){ // value
                        var counter_jurnal = a[5];
              var form_jurnal_transaksi ='<div id="jt-'+counter_jurnal+'">\
                                            <div class="box box-primary">\
                                              <div class="box-header">\
                                                <h3 class="box-title">Jurnal Pasangan </h3>\
                                                <div class="pull-right">\
                                                <a id="delete-'+counter_jurnal+'" name="delete" onclick="deletejt('+counter_jurnal+')" class="glyphicon glyphicon-trash"></a>\
                                                </div>\
                                              </div>\
                                              <div class="box-body">\
                                                <div class="row">\
                                                  <div id="debit-'+a[3]+'" class="col-sm-6">\
                                                    <div class="row">\
                                                      <div class="col-md-7" style="padding-top:5px;"><label> Debit </label> </div>\
                                                      <div class="col-md-1">\
                                                        <a class="glyphicon glyphicon-plus" id="add_debit-'+counter_jurnal+'" name="add_debit-'+counter_jurnal+'" onclick="add_debit('+counter_jurnal+')" ></a>\
                                                      </div>\
                                                    </div>\
                                                    <div id="debt-'+a[1]+'" name="debt-'+a[3]+'">\
                                                      <div class="row">\
                                                        <div class="col-md-12">\
                                                          <div class="row">\
                                                            <div class="row" style="margin: 5px">\
                                                              <div class="col-md-8">\
                                                                <input type="hidden" class="form-control" name="debit_id" id="debit_id">\
                                                              </div>\
                                                            </div>\
                                                            <div class="col-md-8" style="padding-top:5px;">\
                                                             <select id="debit_akun-'+a[1]+'" name="debit_akun-'+a[3]+'" onchange="debit_akun('+a[1]+','+a[3]+')" type="text" class="form-control">\
                                                                <?php foreach($akun as $a) { ?>\
                                                                  <?php
                                                                    if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                      $id_mst_akun = $id_mst_akun;
                                                                    }else{
                                                                      $id_mst_akun = set_value('id_mst_akun');
                                                                    }
                                                                      $select = $a->id_mst_akun == $id_mst_akun ? "selected" : "" ;?>\
                                                                  <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?></option>\
                                                                  <?php } ?>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-1">\
                                                              <div class="parentDiv">\
                                                                <a data-toggle="collapse" data-target="#debit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                                                </a>\
                                                              </div>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                              <a id="delete_debit-'+a[1]+'" name="delete_debit-'+a[3]+'" onclick="delete_debit('+a[1]+','+a[3]+')" class="glyphicon glyphicon-trash">\
                                                              </a>\
                                                            </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                    <div class="collapse" id="debit'+a[1]+'">\
                                                      <div class="row">\
                                                        <div class="col-md-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" id="debit_isi_otomatis-'+a[1]+'" onclick="debit_isi_otomatis('+a[1]+','+a[3]+','+'this'+')" name="debit_isi_otomatis-'+a[3]+'" value="1" <?php 
                                                                if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                                  $auto_fill = $auto_fill;
                                                                }else{
                                                                  $auto_fill = set_value('auto_fill');
                                                                }
                                                                if($auto_fill == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                      <div class="col-sm-1">\
                                                      </div>\
                                                        <div class="col-sm-10">\
                                                          <div class="row">\
                                                            <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label></div>\
                                                            <div class="col-md-7">\
                                                              <select disabled name="debit_cmbx_nilai-'+a[3]+'" id="debit_cmbx_nilai-'+a[1]+'" type="text" class="form-control">\
                                                                <option value="kredit##'+a[3]+'##{id}" echo "selected" ?> All Kredit</option>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                              <input type="text" disabled class="form-control" id="debit_value_nilai-'+a[1]+'" name="debit_value_nilai-'+a[3]+'" onchange="debit_value_nilai('+a[1]+','+a[3]+')" value="<?php echo $row->value ?>">\
                                                            </div>\
                                                            <div class="col-md-1" style="padding-top:5px;"><label name="label_persen_debit-'+a[3]+'">%</label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-md-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" id="debit_opsional-'+a[1]+'" name="debit_opsional" value="1" <?php 
                                                              if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                                  $auto_fill = $auto_fill;
                                                              }else{
                                                                  $auto_fill = set_value('auto_fill');
                                                              }
                                                                  if($auto_fill == 1) echo "checked";
                                                              ?> onclick="select_opsional('+a[1]+','+a[3]+',\'debit\')">\
                                                            </div>\
                                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                </div>\
                                                <div id="kredit-'+a[3]+'" class="col-sm-6">\
                                                  <div class="row">\
                                                    <div class="col-md-8" style="padding-top:5px;"><label>Kredit</label></div>\
                                                    <div class="col-md-2">\
                                                      <a class="glyphicon glyphicon-plus" id="add_kredit-'+counter_jurnal+'" name="add_kredit-'+counter_jurnal+'" onclick="add_kredit('+counter_jurnal+')">\
                                                      </a>\
                                                    </div>\
                                                  </div>\
                                                  <div id="kredt-'+a[2]+'" name="kredt-'+a[3]+'">\
                                                    <div class="row" >\
                                                      <div class="col-md-12">\
                                                        <div class="row">\
                                                          <div class="row" style="margin: 5px">\
                                                            <div class="col-md-8">\
                                                              <input type="hidden" class="form-control" name="kredit_id" id="kredit_id">\
                                                            </div>\
                                                          </div>\
                                                          <div class="col-md-8" style="padding-top:5px;">\
                                                            <select id="kredit_akun-'+a[2]+'" name="kredit_akun-'+a[3]+'" onchange="kredit_akun('+a[2]+','+a[3]+')" type="text" class="form-control">\
                                                              <?php foreach($akun as $a) : ?>\
                                                                <?php
                                                                  if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                                    $id_mst_akun = $id_mst_akun;
                                                                  }else{
                                                                    $id_mst_akun = set_value('id_mst_akun');
                                                                  }
                                                                    $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                                                ?>\
                                                                <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?></option>\
                                                                <?php endforeach ?>\
                                                            </select>\
                                                          </div>\
                                                          <div class="col-md-1">\
                                                            <div class="parentDiv">\
                                                              <a data-toggle="collapse" data-target="#kredit'+a[2]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                                              </a>\
                                                            </div>\
                                                          </div>\
                                                          <div class="col-md-2">\
                                                            <a id="delete_kredit-'+a[2]+'" name="delete_kredit-'+a[3]+'" onclick="delete_kredit('+a[2]+','+a[3]+')" class="glyphicon glyphicon-trash">\
                                                            </a>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                    <div class="collapse" id="kredit'+a[2]+'">\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" onclick="kr_isi_otomatis('+a[2]+','+a[3]+',this)" id="kredit_isi_otomatis-'+a[2]+'" name="kredit_isi_otomatis" value="1" <?php 
                                                                if(set_value('auto_fill')=="" && isset($auto_fill)){
                                                                  $auto_fill = $auto_fill;
                                                                }else{
                                                                  $auto_fill = set_value('auto_fill');
                                                                }
                                                                if($auto_fill == 1) echo "checked";
                                                              ?>>\
                                                            </div>\
                                                            <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-10">\
                                                          <div class="row">\
                                                            <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
                                                            <div class="col-md-7">\
                                                              <select disabled id="kredit_cmbx_nilai-'+a[2]+'" name="kredit_cmbx_nilai-'+a[3]+'" type="text" class="form-control">\
                                                               <option value="debit##'+a[3]+'##{id}" echo "selected" ?> All Debit</option>\
                                                              </select>\
                                                            </div>\
                                                            <div class="col-md-2">\
                                                              <input type="text" disabled class="form-control" id="kredit_value_nilai-'+a[2]+'" name="kredit_value_nilai-'+a[3]+'" onchange="kredit_value_nilai('+a[2]+','+a[3]+')" value="<?php echo $row->value ?>">\
                                                            </div>\
                                                            <div class="col-md-1" style="padding-top:5px;"><label name="label_persen_kredit-'+a[3]+'">%</label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                      <div class="row">\
                                                        <div class="col-sm-1">\
                                                        </div>\
                                                        <div class="col-sm-7">\
                                                          <div class="row">\
                                                            <div class="col-md-1">\
                                                              <input type="checkbox" id="kredit_opsional-'+a[2]+'" name="kredit_opsional" value="1" <?php 
                                                                if(set_value('opsional')=="" && isset($opsional)){
                                                                  $opsional = $opsional;
                                                                }else{
                                                                  $opsional = set_value('opsional');
                                                                }
                                                                  if($opsional == 1) echo "checked";
                                                              ?> onclick="select_opsional('+a[2]+','+a[3]+',\'kredit\')">\
                                                            </div>\
                                                            <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                                          </div>\
                                                        </div>\
                                                      </div>\
                                                    </div>\
                                                  </div>\
                                                </div>\
                                              </div>\
                                            </div>\
                                          </div>\
                                        </div>';

      $('#jurnal_transaksi').append(form_jurnal_transaksi);
      $('[name="label_persen_debit-'+a[3]+'"]').hide();
      $('[name="debit_value_nilai-'+a[3]+'"]').hide();
       $('[name="label_persen_kredit-'+a[3]+'"]').hide();
      $('[name="kredit_value_nilai-'+a[3]+'"]').hide();
      $('[name="delete_debit-'+a[3]+'"]').hide();
      $('[name="delete_kredit-'+a[3]+'"]').hide();

      $('#debit_id').val(a[1]);
      $('#kredit_id').val(a[2]);
      countdelpasjurnal = $("[name='delete']").length;
      if (countdelpasjurnal > 1) {
        $("[name='delete']").show();
      }else{
        $("[name='delete']").hide();
      }

                          }else{
                            alert("Kosong");
                          };

                      }else{
                        alert("Kosong");
                      };

                  }else{
                    alert("Kosong");
                  };

              }else{
                alert("Kosong");
              };

          }else{
            alert("Failed.");
          }
        }
    });
        return false;
    });


function deletejt(data) {
  if (confirm("Anda yakin Akan menghapus Data Ini?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete" ?>',
       data : 'group='+data,
       success: function (response) {
        if(response=="OK"){
            $("#jt-"+data).remove();
            countdelpasjurnal = $("[name='delete']").length;
            if (countdelpasjurnal > 1) {
              $("[name='delete']").show();
            }else{
              $("[name='delete']").hide();
            }
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}

function delete_debit(id,group) {
  if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_debit" ?>',
       data : 'id_mst_transaksi_item='+id,
       success: function (response) {
        // alert(response);
        res = response.split("|");
        if(res[0]=="OK"){
            $("#debt-"+id).remove();
            var countdelbit = res[1];
            if (countdelbit > 1) {
              $('[name="add_kredit-'+group+'"]').hide();
              $('[name="debit_value_nilai-'+group+'"]').show();
              $('[name="label_persen_debit-'+group+'"]').show();
              $('[name="delete_debit-'+group+'"]').show();
            }else{
              $('[name="add_kredit-'+group+'"]').show();
              $('[name="debit_value_nilai-'+group+'"]').hide();
              $('[name="label_persen_debit-'+group+'"]').hide();
              $('[name="delete_debit-'+group+'"]').hide();
            };
            changeselect(group,'debit');
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}
function add_kredit(group) {

  var data = new FormData();
    $('#biodata_notice-content').html('<div class="alert">Mohon tunggu, proses simpan data....</div>');
    $('#biodata_notice').show();
    data.append('group',            group);

  $.ajax({
     cache : false,
     contentType : false,
     processData : false,
     type: 'POST',
     url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_add_kredit/{id}" ?>',
     data : data,
     success: function (response) {
      a = response.split("|");
        if(a[0]=="OK"){
          if(a[1]!=null){
            if(a[2]!=null){

                var form_kredit = '<div id="kredt-'+a[1]+'" name="kredt-'+group+'" >\
                              <div class="row" >\
                                <div class="col-md-12">\
                                  <div class="row">\
                                   <div class="row" style="margin: 5px">\
                                      <div class="col-md-8">\
                                        <input type="hidden" class="form-control" name="kredit_id" id="kredit_id">\
                                      </div>\
                                    </div>\
                                    <div class="col-md-8" style="padding-top:5px;">\
                                      <select id="kredit_akun-'+a[1]+'" name="kredit_akun-'+group+'" onchange="kredit_akun('+a[1]+','+group+')" type="text" class="form-control">\
                                        <?php foreach($akun as $a) : ?>\
                                          <?php
                                            if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                              $id_mst_akun = $id_mst_akun;
                                            }else{
                                              $id_mst_akun = set_value('id_mst_akun');
                                            }
                                              $select = $a->id_mst_akun == $id_mst_akun ? 'selected' : '' ;
                                          ?>\
                                          <option value="<?php echo $a->id_mst_akun ?>"><?php echo $a->uraian ?>\
                                           </option>\
                                          <?php endforeach ?>\
                                      </select>\
                                    </div>\
                                    <div class="col-md-1">\
                                      <div class="parentDiv">\
                                        <a data-toggle="collapse" data-target="#kredit'+a[1]+'" class="toggle_sign glyphicon glyphicon-chevron-down">\
                                        </a>\
                                      </div>\
                                    </div>\
                                    <div class="col-md-2">\
                                      <a id="delete_kredit-'+a[1]+'" name="delete_kredit-'+group+'" onclick="delete_kredit('+a[1]+','+group+')" class="glyphicon glyphicon-trash">\
                                      </a>\
                                    </div>\
                                  </div>\
                                </div>\
                              </div>\
                              <div class="collapse" id="kredit'+a[1]+'">\
                                <div class="row">\
                                  <div class="col-sm-1">\
                                  </div>\
                                  <div class="col-sm-7">\
                                    <div class="row">\
                                      <div class="col-md-1">\
                                        <input type="checkbox" id="kredit_isi_otomatis-'+a[1]+'" name="kredit_isi_otomatis" onclick="kr_isi_otomatis('+a[1]+','+group+',this);" value="1" <?php 
                                          if(set_value('auto_fill')=="" && isset($auto_fill)){
                                            $auto_fill = $auto_fill;
                                          }else{
                                            $auto_fill = set_value('auto_fill');
                                          }
                                          if($auto_fill == 1) echo "checked";
                                        ?>>\
                                      </div>\
                                      <div class="col-md-6" style="padding-top:5px;"><label> Isi Otomatis </label> </div>\
                                    </div>\
                                  </div>\
                                </div>\
                                <div class="row">\
                                  <div class="col-sm-1">\
                                  </div>\
                                  <div class="col-sm-1">\
                                  </div>\
                                  <div class="col-sm-10">\
                                    <div class="row">\
                                      <div class="col-md-2" style="padding-top:5px;"><label> Nilai </label> </div>\
                                      <div class="col-md-7">\
                                        <select  name="kredit_cmbx_nilai-'+group+'" id="kredit_cmbx_nilai-'+a[1]+'" type="text" class="form-control">\
                                          <?php foreach($nilai_kredit[$row->group] as $nd) : ?>\
                                              <?php
                                                if(set_value('id_mst_akun')=="" && isset($id_mst_akun)){
                                                  $id_mst_akunsa = $id_mst_akun;
                                                }else{
                                                  $id_mst_akunsa = set_value('id_mst_akun');
                                                }
                                                $select = $nd->id_mst_akun == $id_mst_akunsa ? 'style="display:none"' : '' ;
                                              ?>\
                                              <option value="<?php echo $nd->id_mst_akun ?>" <?php echo $select ?>><?php echo $nd->uraian ?></option>\
                                          <?php endforeach ?>\
                                        </select>\
                                      </div>\
                                      <div class="col-md-2">\
                                          <input type="text" class="form-control" id="kredit_value_nilai-'+a[1]+'" name="kredit_value_nilai-'+group+'" onchange="kredit_value_nilai('+a[1]+')" value="<?php 
                                          if(set_value('value')=="" && isset($value)){
                                            echo $value;
                                          }else{
                                            echo  set_value('value');
                                          }
                                          ?>">\
                                      </div>\
                                      <div class="col-md-1" style="padding-top:5px;"><label>%</label> </div>\
                                    </div>\
                                  </div>\
                                </div>\
                                <div class="row">\
                                  <div class="col-sm-1">\
                                  </div>\
                                  <div class="col-sm-7">\
                                    <div class="row">\
                                      <div class="col-md-1">\
                                        <input type="checkbox" id="kredit_opsional-'+a[1]+'" name="kredit_opsional" onclick="select_opsional('+a[1]+','+group+',\'kredit\');" value="1" <?php 
                                          if(set_value('opsional')=="" && isset($opsional)){
                                          $opsional = $opsional;
                                            }else{
                                          $opsional = set_value('opsional');
                                            }
                                          if($opsional == 1) echo "checked";
                                        ?>>\
                                      </div>\
                                      <div class="col-md-3" style="padding-top:5px;"><label> Opsional </label> </div>\
                                    </div>\
                                  </div>\
                                </div>\
                              </div>\
                          </div>';
          
                          //alert(group);
            // alert('#kredit-'+group);
           $('#kredit-'+group).append(form_kredit);
           var countkre = a[3];
           if (countkre > 1) {
              $('[name="add_debit-'+group+'"]').hide();
              $("[name='kredit_value_nilai-"+group+"']").show();
              $('[name="label_persen_kredit-'+group+'"]').show();
              $('[name="delete_kredit-'+group+'"]').show();
            }else{
              $('[name="add_debit-'+group+'"]').show();
              $("[name='kredit_value_nilai-"+group+"']").hide();
              $('[name="label_persen_kredit-'+group+'"]').hide();
              $('[name="delete_kredit-'+group+'"]').hide();
            };
            changeselect(group,'kredit');
            }else{
                alert("Kosong");
              };

          }else{
            alert("Kosong");
          };

      }else{
          alert("Failed.");
      }
     }
  });
}
function delete_kredit(id,group) {
  if (confirm("Anda yakin Akan menghapus Data Ini ?")) {
      $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_delete_kredit" ?>',
       data : 'id_mst_transaksi_item='+id,
       success: function (response) {
        res = response.split('|');
        if(res[0]=="OK"){
            $("#kredt-"+id).remove();
            var countdelkre = res[1];//$("[name='kredit-"+group+"']").length;
            if (countdelkre > 1) {
              $('[name="add_debit-'+group+'"]').hide();
              $("[name='kredit_value_nilai-"+group+"']").show();
              $('[name="label_persen_kredit-'+group+'"]').show();
              $('[name="delete_kredit-'+group+'"]').show();
            }else{
              $('[name="add_debit-'+group+'"]').show();
              $("[name='kredit_value_nilai-"+group+"']").hide();
              $('[name="label_persen_kredit-'+group+'"]').hide();
              $('[name="delete_kredit-'+group+'"]').hide();
            };
            changeselect(group,'kredit');
        }else{
          alert("Failed.");
        };
       }
    });

  } else{

  };
}
function debit_akun(id,group) {

  var debit_akun_val    = $("#debit_akun-"+id+"").val();
  var debit_akun_select = $("#debit_akun-"+id+">option:selected").text();
    $.ajax({
       type: 'POST',
       url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
       data : 'id_mst_akun='+debit_akun_val+'&id_mst_transaksi_item='+id+'&id_mst_transaksi_item_from='+debit_akun_val+'&group='+group,
       success: function (response) {
        // alert(response);
        res = response.split('|');
        if(res[0]=="OK"){
          changeselect(group,'debit');
        }else if (response=="dataada") {
          alert('Maaf, data tersebut sudah dipilih pada jurnal pasangan yang sama');
        }else{
            alert("Failed.");
        }
       }
    });
}
function kredit_akun(id,group) {

  var kredit_akun_val    = $("#kredit_akun-"+id+"").val();
  var kredit_akun_select = $("#kredit_akun-"+id+">option:selected").text();

  $.ajax({
     type: 'POST',
     url : '<?php echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kredit/{id}" ?>',
     data : 'id_mst_akun='+kredit_akun_val+'&id_mst_transaksi_item='+id+'&group='+group,
     success: function (response) {
      if(response=="OK"){
        changeselect(group,'kredit');
      }else if(response=="dataada"){
        alert('Maaf, data tersebut sudah dipilih pada jurnal pasangan yang sama');
      }else{
          alert("Failed.");
      }
     }
  });
}
function debit_isi_otomatis(id,group,obj) {
    var data = new FormData();
        data.append('auto_fill'            ,$("[name='debit_isi_otomatis-"+group+"']:checked").val());
        data.append('id_mst_transaksi_item', id);
        data.append('value', $("#debit_isi_otomatis-"+id+"").val());

    $.ajax({
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
        url : '<?php  echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_debit/{id}" ?>',
        data : data,
        success : function(response){
          res = response.split('|');
          // alert(response);
          if(res[0]=="OK"){
            if (res[1]=='1') {
                $('#debit_cmbx_nilai-'+id+'').prop('disabled', false);
                $('#debit_cmbx_nilai-'+id+'').val('1');
                $('#debit_value_nilai-'+id+'').prop('disabled', false);
            }else{
                $('#debit_cmbx_nilai-'+id+'').prop('disabled', true);
                $('#debit_cmbx_nilai-'+id+'').val('0');
                $('#debit_value_nilai-'+id+'').prop('disabled', true);
            }
          }else{
              // $("#debit_isi_otomatis").prop("checked", false);
              alert("Maaf data gagal di update");
          }     
        }
    });
}

function changeselect(group,tipe) {
    $.ajax({
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
        dataType: "json",
        url : '<?php echo base_url()."mst/keuangan_transaksi/changeselect/{id}" ?>/'+group+'/'+tipe,
        success : function(response){
         $.each(response, function (key, value) {
            var options = [];
            $.each(value.child, function (i, data) {
                if (value.idakun!=data.id_mst_akun) {
                  options.push($('<option/>', 
                  {
                      value: data.id_mst_akun, text: data.uraian 
                  }));  
                }
            }); 
            if (tipe==='kredit') {
              $('#kredit_cmbx_nilai-'+key+'').html(options);
              if (value.auto_fill=='1') {
                $('#kredit_cmbx_nilai-'+key+'').prop('disabled', false);
                $('#kredit_value_nilai-'+key+'').prop('disabled', false);
              }else{
                $('#kredit_cmbx_nilai-'+key+'').prop('disabled', true);
                $('#kredit_value_nilai-'+key+'').prop('disabled', true);
              }
            }else{
              $('#debit_cmbx_nilai-'+key+'').html(options);
              if (value.auto_fill=='1') {
                $('#debit_cmbx_nilai-'+key+'').prop('disabled', false);
                $('#debit_value_nilai-'+key+'').prop('disabled', false);
              }else{
                $('#debit_cmbx_nilai-'+key+'').prop('disabled', true);
                $('#debit_value_nilai-'+key+'').prop('disabled', true);
              }
            }
        });      
        
      }
    });
}
function kr_isi_otomatis(id,group,obj){
    var data = new FormData();
        data.append('auto_fill'            ,$("[name='kredit_isi_otomatis-"+group+"']:checked").val());
        data.append('id_mst_transaksi_item', id);
        data.append('value', $("#kredit_isi_otomatis-"+id+"").val());

    $.ajax({
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
        url : '<?php  echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_kreditotomatis/{id}" ?>',
        data : data,
        success : function(response){
          res = response.split('|');
          // alert(response);
          if(res[0]=="OK"){
            if (res[1]=='1') {
                $('#kredit_cmbx_nilai-'+id+'').prop('disabled', false);
                $('#kredit_cmbx_nilai-'+id+'').val('1');
                $('#kredit_value_nilai-'+id+'').prop('disabled', false);
            }else{
                $('#kredit_cmbx_nilai-'+id+'').prop('disabled', true);
                $('#kredit_cmbx_nilai-'+id+'').val('0');
                $('#kredit_value_nilai-'+id+'').prop('disabled', true);
            }
          }else{
              // $("#debit_isi_otomatis").prop("checked", false);
              alert("Maaf data gagal di update");
          }     
        }
    });
}
function select_opsional(id,group,tipe){
    var data = new FormData();
        data.append('id' ,id);
        data.append('group', id);
        data.append('tipe',tipe);

    $.ajax({
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
        url : '<?php  echo base_url()."mst/keuangan_transaksi/jurnal_transaksi_edit_optional" ?>/'+id+'/'+group+'/'+tipe,
        data : data,
        success : function(response){
          res = response.split('|');
          // alert(response);
          if(res[0]=="OK"){
          }else{
              alert("Maaf data gagal di update");
          }     
        }
    });
}
$("[name='transaksi_template']").click(function(){
  var data = new FormData();
    data.append('template',     $(this).val());
    
    $.ajax({
        cache : false,
        contentType : false,
        processData : false,
        type : 'POST',
        url : '<?php echo base_url()."mst/keuangan_transaksi/transaksi_template_update/".$id?>',
        data : data,
        success : function(response){
          if(response=="OK"){
            $("#transaksi_template").prop("checked", true);
          }else{
            $("#transaksi_template").prop("checked", false);
          }
        }
    });
});
</script>

