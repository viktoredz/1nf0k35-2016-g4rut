
<!-- Info boxes -->
<div class="row">
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-ambulance"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pus Kecamatan</span>
        <span class="info-box-number" style="font-size:14px;"><?php echo $j_puskesmas ;?><br>Puskesmas</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-blue"><i class="glyphicon glyphicon-user"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Jumlah Pegawai</span>
        <span class="info-box-number" style="font-size:14px;"><?php foreach ($j_pegawai as $row) { 
        echo $row->total;  
        }?><br>Orang</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix visible-sm-block"></div>

  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-education"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Jumlah PNS</span>
        <span class="info-box-number" style="font-size:14px;"><?php foreach ($j_pegawaipns as $row) { 
        echo $row->pns;  
        }?><br>Orang</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
  <div class="col-md-3 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-heart"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Jumlah Non PNS</span>
        <span class="info-box-number" style="font-size:14px;">
        <?php foreach ($j_pegawainonpns as $row) { 
        echo $row->nonpns;  
        }?>
        <br>Orang</span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</div><!-- /.row -->

<div class="row">
  <div class="col-md-7">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Jumlah Pegawai Berdasarkan Pendidikan</h3>
          <br>
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
        <div class="row" id="row_dim">
          <div class="chart">
            <canvas id="barChart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>
          </div>
        </div>
        <div class="row">
        <?php $i=0; foreach ($jmlpendidikanlulus as $key) {?>
          <div class="col-md-2">
              <div class="bux<?php echo $i?>"></div> &nbsp; <label><?php echo (isset($key->deskripsi) ? $key->deskripsi :'Lainnya') ;?></label>
          </div>
        <?php $i++;} ?>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
  <div class="col-md-5">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Jumlah Laki-laki & Perempuan</h3>  
        <div class="box-tools pull-right">
          <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
        </div>
      </div><!-- /.box-header -->
        <div class="box-body">
        <div class="row" id="row1">
          <div class="chart">
            <canvas id="pieChart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>
          </div>
          <div class="row"> 
          <div class="col-md-3">
              
          </div>
          <?php $i=1; foreach ($jenisklamin as $row) {  ?>
          <div class="col-md-4">
              <div class="buxlk<?php echo $i?>"></div> &nbsp; <label><?php echo (isset($row->kelamin)&& $row->kelamin =='P' ? 'Perempuan' : 'Laki-laki' );?></label>
          </div>
          <?php  $i++; } ?>
        </div>
        </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div><!-- /.col -->
</div><!-- /.row -->
<style type="text/css">
    .buxlk1{
      width: 10px;
      padding: 10px; 
      margin-right: 40%;
      background-color: #f56954;
      margin: 0;
      float: left;
    }
    .buxlk2{
      width: 10px;
      padding: 10px;
      background-color: #00a65a;
      margin: 0;
      float: left;
    }
</style>

<script>
  $(function () { 
    $("#menu_ekepegawaian").addClass("active");
    $("#menu_kepegawaian_dashboard").addClass("active");


      var areaChartData = {
        labels: [<?php 
        $i=0;
       // print_r($bar);  
        foreach ($bar as $row ) { 
          if($i>0) echo ",";
            echo "\"".str_replace(array("KEC. ","KEL. "),"", $row['puskesmas'])."\"";
          $i++;
        } ?>],
        datasets: [
        <?php $i=0; foreach ($jmlpendidikanlulus as $key) {?>
          {
            label: "<?php echo (isset($key->deskripsi) ? $key->deskripsi :'Lainnya') ?>",
            fillColor: "<?php echo $color[$i];?>",
            strokeColor: "<?php echo $color[$i];?>",
            pointColor: "<?php echo $color[$i];?>",
            pointStrokeColor: "<?php echo $color[$i];?>",
            pointHighlightFill: "<?php echo $color[$i];?>",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: [<?php echo (isset($key->total) ? $key->total :'0') ?>]
          },
        <?php $i++; }?>
        ]
      };

      var areaChartOptions = {
        showScale: true,
        scaleShowGridLines: false,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        bezierCurve: true,
        bezierCurveTension: 0.3,
        pointDot: false,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        maintainAspectRatio: false,
        responsive: true
      };


      

      


        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [<?php 
            $i=0;
            foreach ($jenisklamin as $row) { 
              if(isset($row->jmlklmin)) $x = ($row->jmlklmin);
              else                          $x = 0;
              if($i>0) echo ",";
              echo "
              {
              value: ".$x.",
              color: \"".$color[$i]."\",
              highlight: \"".$color[$i]."\",
              label: \"".$row->kelamin."\"
              }";
              $i++;
            }
            ?>
        ];
        var pieOptions = {
          segmentShowStroke: true,
          segmentStrokeColor: "#fff",
          segmentStrokeWidth: 2,
          percentageInnerCutout: 40, // This is 0 for Pie charts
          animationSteps: 100,
          animationEasing: "easeOutBounce",
          animateRotate: true,
          animateScale: false,
          responsive: true,
          maintainAspectRatio: false,
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        pieChart.Doughnut(PieData, pieOptions);


      



        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = areaChartData;
        var barChartOptions = {
          scaleBeginAtZero: true,
          scaleShowGridLines: true,
          scaleGridLineColor: "rgba(0,0,0,.05)",
          scaleGridLineWidth: 1,
          scaleShowHorizontalLines: true,
          scaleShowVerticalLines: true,
          barShowStroke: true,
          barStrokeWidth: 2,
          barValueSpacing: 5,
          barDatasetSpacing: 1,
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
          responsive: true,
          maintainAspectRatio: false
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);




      
      });
    </script>
    <style type="text/css">
<?php $i=0; foreach ($jmlpendidikanlulus as $key) {?>
      .bux<?php echo $i;?>{
        width: 10px;
        padding: 10px; 
        margin-right: 40%;
        background-color: <?php echo $color[$i];?>;
        margin: 0;
        float: left;
      }
<?php $i++;  } ?>
    </style>

    <script>
  
</script>
  