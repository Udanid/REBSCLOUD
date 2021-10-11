 <script src="<?=base_url()?>media/js/dist/Chart.bundle.js"></script>
    <script src="<?=base_url()?>media/js/utils.js"></script>
                       <canvas id="canvas"  width="300"><img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif"></canvas>
                          	<script type="text/javascript">
     						    var color = Chart.helpers.color;
    							    var barChartData = {
    							        labels: <?=$js_label?>,
    							        datasets: [{
    							            label: 'Estimate',
    							            backgroundColor:color(window.chartColors.blue).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.blue,
          							      borderWidth: 1,
         								       data:<?=$js_estimate?>
       									     },{
    							            label: 'New Budget',
    							            backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.purple,
          							      borderWidth: 1,
         								       data:<?=$js_budget?>
       									     }, {
      								          label: 'Actual',
        								        backgroundColor:<?=$js_colors?>,
         									       borderColor: <?=$js_colors?>,
          									      borderWidth: 1,
           									     data: <?=$js_actual?>
          									  }]
			

       								 };

       				    var ctx = document.getElementById("canvas").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
			

       

      
    </script>