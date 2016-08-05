<script>
  $(function() {
    $('#jqxTabs').jqxTabs({ width: '100%', height: '1000'});

    $('#btn-return').click(function(){
        document.location.href="<?php echo base_url()?>kepegawaian/drh";
    });

     var loadPage = function (url, tabIndex) {
        $.get(url, function (data) {
            $('#content' + tabIndex).html(data);
        });
    }

    loadPage('<?php echo base_url()?>mst/keuangan_transaksi/tab/1', 1);
    $('#jqxTabs').on('selected', function (event) {
        var pageIndex = event.args.item + 1;
        loadPage('<?php echo base_url()?>mst/keuangan_transaksi/tab/'+pageIndex , pageIndex);
    });

    $("#menu_master_data").addClass("active");
    $("#menu_mst_keuangan_transaksi").addClass("active");
  });
</script>

<section class="content">
<div class="row">
  <div id='jqxWidget'>
    <div id='jqxTabs'>
        <ul>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Kategori Transaksi</div>
              </div>

            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Transaksi </div>
              </div>
            </li>

            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Transaksi Otomatis</div>
              </div>
            </li>

            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="icon fa fa-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                     Pengaturan Transaksi</div>
              </div>
            </li>
            
        </ul>
        <div id="content1" style="background: #FAFAFA"></div>
        <div id="content2" style="background: #FAFAFA"></div>
        <div id="content3" style="background: #FAFAFA"></div>
        <div id="content4" style="background: #FAFAFA"></div>

    </div>
  </div>
</div>
</section>

