<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-hover">
      <tr>
        <th>Jaminan Kesehatan</th>
        <th>Jumlah</th>
        <th>Persentase</th>
      </tr>

      <?php 
      $total =0;
      foreach ($showjkn as $rows) { 
        $total = $rows->total;
      ?>
      <tr>
        <td><?php echo $rows->jkn; ?></td>
        <td><?php echo $rows->jumlah;?></td>
        <td><?php echo number_format($rows->jumlah/$jumlahorang*100,2); echo " %";?></td>
      </tr>
      <?php } ?>
      <tr>
        <th>Total</th>
        <th><?php echo $jumlahorang; ?></th>
        <th><?php echo ($jumlahorang>0) ? $jumlahorang/$jumlahorang*100 : 0; echo " %";?></th>
      </tr>
      
    </table>
  </div>
  <div class="col-md-6">
    <div class="row" id="row1">
      <div class="chart">
        <canvas id="pieChart" height="240" width="511" style="width: 511px; height: 240px;"></canvas>
      </div>
    </div>
  </div>
</div>
<?php // print_r($bar);?>
<script>
  $(function () { 
    
    //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = [<?php 
            $i=0;
         foreach ($showjkn as $row) {
            if($i>0) echo ",";
            echo "
              {
              value: ";echo number_format($row->jumlah/$jumlahorang*100,2).",
              color: \"".$color[$i]."\",
              highlight: \"".$color[$i]."\",
              label: \"".$row->jkn."\"
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
  });
</script>