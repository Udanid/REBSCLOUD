
<script src="<?=base_url()?>media/js/jquery.table2excel.min.js"></script>

<script type="text/javascript">

$(document).ready(function(){  
      $('#create_excel').click(function(){ 
	  		var date =  document.getElementById('rptdate').value;
           $(".table2excel").table2excel({
					exclude: ".noExl",
					name: "Collection Report " +date,
					filename: "Collection_" + date + ".xls",
					fileext: ".xls",
					exclude_img: true,
					exclude_links: true,
					exclude_inputs: true
				});
           
      });  
 });

function load_printscrean1(prjid,month)
{
			window.open( "<?=base_url()?>re/report/get_profit_all_print/"+prjid+"/"+month );
	
}
function load_printscrean2(branchid,prjid,month)
{
			window.open( "<?=base_url()?>re/report_excel/get_profit_all/"+branchid+"/"+prjid+"/"+month );
	
}
function load_printscrean3(branchid,prjid,fromdate,todate)
{
			window.open( "<?=base_url()?>re/report_excel/get_profit_all_daterange/"+branchid+"/"+prjid+"/"+fromdate+"/"+todate );
	
}
</script>
<style>
	.tableFixHead { overflow-y: auto; height: 600px; }
	table  { border-collapse: collapse; width: 100%; }
	th, td { padding: 8px 16px; }
	th     { background:#eee; }
</style>
 <?
 if($month!=''){
 $heading=date('F', mktime(0, 0, 0, intval($month), 10)). ' Month Profit Realization Summery';
  $heading2=date('F', mktime(0, 0, 0, intval($month), 10)). ' Month Profit Realization Details';
 }
 else{
 $heading='Profit Realization Summery of Current Finance Year';
 $heading2='';
 }
  $heading='Profit Realization Summery form '.$fromdate.' to '.$todate ;
  if($prjlist){$counter=0;
		foreach($prjlist as $prjraw){
        $lable[$counter]=$prjraw->project_name;
		$profit[$counter]=0;
		$sale[$counter]=0;
		if($month!=''){
   if($transferlist[$prjraw->prj_id][$month]){
			$sale[$counter]=$transferlist[$prjraw->prj_id][$month][0];
			$profit[$counter]=$transferlist[$prjraw->prj_id][$month][0]-$transferlist[$prjraw->prj_id][$month][1];
					}}
	else
		{
			if(isset($fromdate))
			$start=$fromdate;
			else
			$start=date($this->session->userdata('fy_start'));
			if(isset($todate))
			$end=$todate;
			else
				$end=date('Y-m-d');
				while($start<=$end)
				{ 
					$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$stdate=$year.'-'.$month2.'-01';
					$enddate=$year.'-'.$month2.'-31';
					$profit[$counter]=$profit[$counter]+$transferlist[$prjraw->prj_id][$month2][0]-$transferlist[$prjraw->prj_id][$month2][1];
					$sale[$counter]=$sale[$counter]+$transferlist[$prjraw->prj_id][$month2][0];
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					
				}
		}
		$fullsale[$counter]=$projecttots[$prjraw->prj_id]->totsale;
		$fullprofit[$counter]=$projecttots[$prjraw->prj_id]->totsale-$projecttots[$prjraw->prj_id]->totcost;
        $counter++;
		}
		
		$js_label=json_encode($lable);
				$js_sale=json_encode($sale);
				$js_profit=json_encode($profit);
				$js_fullsale=json_encode($fullsale);
				$js_fullprofit=json_encode($fullprofit);
		
		}
		
		
		?>
        <div class="form-title">
		<h4><?=$heading?> 
      </h4>
	</div>
 <div class="charts"  style="margin-top:-10px;">
                  
					<div class="col-md-12 charts chrt-page-grids">
					     <div id="chartset" class=" col-sm-6">	
                      
                       <canvas id="canvas1" width="300"></canvas>
                          	<script type="text/javascript">
     						    var color = Chart.helpers.color;
    							    var barChartData = {
    							        labels:<?=$js_label?>,
    							        datasets: [{
    							            label: 'Total Sales',
    							            backgroundColor:color(window.chartColors.blue).alpha(0.5).rgbString(),
     							           borderColor: window.chartColors.blue,
          							      borderWidth: 1,
         								       data:<?=$js_fullsale?>
       									     }, {
      								          label: 'Current Sales',
        								        backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
         									       borderColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
          									      borderWidth: 1,
           									     data: <?=$js_sale?>
          									  }]
			

       								 };

       				    var ctx = document.getElementById("canvas1").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
			

       

      
    </script>
                        
						</div>
                          <div id="chartset2" class=" col-sm-6">	
                      
                       <canvas id="canvas2" width="300"></canvas>
                          	<script type="text/javascript">
     						    var color = Chart.helpers.color;
    							    var barChartData = {
    							        labels:<?=$js_label?>,
    							        datasets: [{
    							            label: 'Estimate Profit',
    							            backgroundColor:color(window.chartColors.green).alpha(0.7).rgbString(),
     							           borderColor: window.chartColors.green,
          							      borderWidth: 1,
         								       data:<?=$js_fullprofit?>
       									     }, {
      								          label: 'Realized Profit',
        								        backgroundColor:color(window.chartColors.red).alpha(0.5).rgbString(),
         									       borderColor:color(window.chartColors.red).alpha(0.5).rgbString(),
          									      borderWidth: 1,
           									     data:<?=$js_profit?>
          									  }]
			

       								 };

       				    var ctx = document.getElementById("canvas2").getContext("2d");
         				   new Chart(ctx, {type: 'bar', data: barChartData});
			

       

      
    </script>
                        
						</div>
                        
					</div>
					
					<div class="clearfix"> </div>
							
				</div>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading?> 
       <span style="float:right">  <a href="#" id="create_excel" name="create_excel"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <input type="hidden" id="rptdate" value="<?=$todate?>">  
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
        <div class="tableFixHead">             
      <table class="table table-bordered table2excel">
      	<thead><tr class="success"><th>Project Name</th>
        <? $counter=0; if($month!=""){ $counter=1; $projectsale1[0]=0;
					$projectcost1[0]=0;?>
        <th colspan="2"><?=date('F', mktime(0, 0, 0, intval($month), 10));?></th>
        <? }else{
        	if(isset($fromdate))
			$start=$fromdate;
			else
			$start=date($this->session->userdata('fy_start'));
			if(isset($todate))
			$end=$todate;
			else
				$end=date('Y-m-d');
				
				
				while($start<=$end)
				{ 
				
				$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$projectsale1[$counter]=0;
					$projectcost1[$counter]=0;
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					$counter++;
				?>
                
                   <th colspan="1" ><?=date('F', mktime(0, 0, 0, $month2, 10));?> Sales</th>
                    <th colspan="1" ><?=date('F', mktime(0, 0, 0, $month2, 10));?> Profit</th>
                <?
				}?>
				  <th colspan="1" >Total Sales</th>
                  <th colspan="1" >Total Profit</th>
        <? }?>
       
        </tr>
       
        </thead>
        <tbody>
       
    <? 
	$projectsale=0;
	$projectprofit=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){?>
        
        <tr><td><?=$prjraw->project_name?></td>
         <? if($month!=""){
			 $sale=$transferlist[$prjraw->prj_id][$month][0]; 
					$cost=$sale-$transferlist[$prjraw->prj_id][$month][1]; 
				 $projectsale1[0]= $projectsale1[0]+$sale;
					  $projectcost1[0]= $projectcost1[0]+$cost;
			 ?>
        <td  align="right"><?=number_format($sale,2)?></td>
           <td align="right" ><?=number_format($cost,2);?></td>
        <? }else{
        if(isset($fromdate))
			$start=$fromdate;
			else
			$start=date($this->session->userdata('fy_start'));
			if(isset($todate))
			$end=$todate;
			else
				$end=date('Y-m-d');
				$counter=0;
				$rawsale=0;$rawcost=0;
				while($start<=$end)
				{ 
				$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					 $sale=$transferlist[$prjraw->prj_id][$month2][0];
					$cost=$sale-$transferlist[$prjraw->prj_id][$month2][1];
					 $projectsale1[$counter]= $projectsale1[$counter]+$sale;
					  $projectcost1[$counter]= $projectcost1[$counter]+$cost;
					$rawsale=$rawsale+$sale;
					$rawcost=$rawcost+$cost;
					$i=$counter;
					print_r($projectsale[$month2]);
					?>
                      <td align="right" ><?=$projectsale[$month2];?><?=number_format($sale,2)?></td>
           <td  align="right"><?=number_format($cost,2)?></td>
                    <?
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					$counter++;
				?>
                
                
                <?
				}
				?>
                 <td align="right" ><?=number_format($rawsale,2)?></td>
           <td  align="right"><?=number_format($rawcost,2)?></td>
                <?
         }?>
     </tr>
        
        
        <? }}?>
         <tr ><td ><strong>Total</strong></td>
        <? $totsale=0;$totprofit=0; for($i=0; $i<$counter; $i++){?>
        <td class="info" align="right"><?=number_format($projectsale1[ $i],2)?></th>
         <td class="info" align="right"><?=number_format($projectcost1[ $i],2)?></th>
        <? $totsale=$totsale+$projectsale1[ $i];
		$totprofit=$totprofit+$projectcost1[ $i];
		}?>
        <? if($counter>1){?>
         <td class="info" align="right"><?=number_format($totsale,2)?></th>
         <td class="info" align="right"><?=number_format($totprofit,2)?></th>
        </tr>
        <? }?>
        </tbody>
         </table>
         	</div>
         </div>
    </div> 
    
</div>
<script>
	var $th = $('.tableFixHead').find('thead th')
	$('.tableFixHead').on('scroll', function() {
	  $th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});
</script>