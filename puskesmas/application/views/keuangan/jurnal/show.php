<script>
  $(function() {
    $('#jqxTabs').jqxTabs({ width: '100%', height: '1300'});

     var loadPage = function (url, tabIndex) {
        $.get(url, function (data) {
            $('#content' + tabIndex).html(data);
        });
    }

    loadPage('<?php echo base_url()?>keuangan/jurnal/tab/1', 1);
    $('#jqxTabs').on('selected', function (event) {
        var pageIndex = event.args.item + 1;
        loadPage('<?php echo base_url()?>keuangan/jurnal/tab/'+pageIndex , pageIndex);
    });

    $("#menu_ekeuangan").addClass("active");
    $("#menu_keuangan_jurnal").addClass("active");
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
                      <i class="glyphicon glyphicon-th-list" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Jurnal Umum</div>
              </div>

            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="glyphicon glyphicon-list-alt" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Jurnal Penyesuaian </div>
              </div>
            </li>

            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="glyphicon glyphicon-book" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Jurnal Penutup</div>
              </div>
            </li>
            <li style="margin-left: 15px;">
              <div style="height: 20px; margin-top: 5px;">
                  <div style="float: left;">
                      <i class="glyphicon glyphicon-trash" style="font-size: 18px"></i>
                  </div>
                  <div style="margin-left: 8px; vertical-align: middle; text-align: center; float: left;">
                      Jurnal Hapus</div>
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

