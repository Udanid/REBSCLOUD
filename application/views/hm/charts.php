  
                       <canvas id="canvas<?=$currentproject?>" width="300"></canvas>
                          	<script type="text/javascript">
     						    var color = Chart.helpers.color;
    							    var barChartData = {
    							        labels: <?=$js_label[$currentproject]?>,
    							        datasets: [{
    							            label: 'Estimate',
    							            backgroundColor:color(window.chartColors.blue).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.blue,
          							      borderWidth: 1,
         								       data:<?=$js_estimate[$currentproject]?>
       									     }, {
      								          label: 'New Budget',
        								        backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
         									       borderColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
          									      borderWidth: 1,
           									     data: <?=$js_budget[$currentproject]?>
          									  }, {
      								          label: 'Actual',
        								        backgroundColor:<?=$js_colors[$currentproject]?>,
         									       borderColor: <?=$js_colors[$currentproject]?>,
          									      borderWidth: 1,
           									     data: <?=$js_actual[$currentproject]?>
          									  }]
			

       								 };

       				    var ctx = document.getElementById("canvas<?=$currentproject?>").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
			

       

      
    </script>