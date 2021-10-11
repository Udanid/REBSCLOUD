
<script type="text/javascript">

function load_printscrean1(branch,type,month)
{
			window.open( "<?=base_url()?>hm/report_excel/get_collection/"+branch+'/'+type+'/'+month);
	
}
function load_printscrean2(branch,type,from,to)
{
			window.open( "<?=base_url()?>hm/report_excel/date_get_collection/"+branch+'/'+type+'/'+from+'/'+to);
	
}

function load_lotinquary(id,prj_id)
{
	 if(id!="")
	 {
		// var prj_id= document.getElementById("prj_id").value
	//	alert("<?=base_url()?>hm/lotdata/get_fulldata/"+id+"/"+prj_id)
	 	 $('#popupform').delay(1).fadeIn(600);
   		   $( "#popupform").load( "<?=base_url()?>hm/lotdata/get_fulldata_popup/"+id+"/"+prj_id );
	 }
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
}
</script>
 <?
 if($month!=''){
  $heading2=' Down Payment as at '.$reportdata;
 }
 else{
   $heading2=' Down Payment as at '.$reportdata;
 }
 
 ?>
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
         								       data:<?=$js_sales?>
       									     }, {
      								          label: 'DP Collections',
        								        backgroundColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
         									       borderColor:color(window.chartColors.purple).alpha(0.5).rgbString(),
          									      borderWidth: 1,
           									     data:<?=$js_dpcollect?>
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
         								       data:<?=$js_sales?>
       									     }, {
      								          label: 'Realized Profit',
        								        backgroundColor:color(window.chartColors.red).alpha(0.5).rgbString(),
         									       borderColor:color(window.chartColors.red).alpha(0.5).rgbString(),
          									      borderWidth: 1,
           									     data:<?=$js_dpcollect?>
          									  }]
			

       								 };
								   var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                   <?=$currentsale-$colelction?>,
                  <?=$colelction?>,
                   
                ],
                backgroundColor: [
                 color(window.chartColors.red).alpha(0.5).rgbString(),
                    color(window.chartColors.green).alpha(0.7).rgbString()
                ],
                label: 'Dataset 1'
            }],
            labels: [
                "Balance",
                "DP Collection"
               
            ]
        },
        options: {
            responsive: true
        }
    };
       				    var ctx = document.getElementById("canvas2").getContext("2d");
         				   new Chart(ctx,  config);
		//	new Chart(document.getElementById("canvas2").getContext("2d")).Pie(pieData);
							

       

      
    </script>
                        
						</div>
                        
					</div>
					
					<div class="clearfix"> </div>
							
				</div>
<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> 
        <? if(isset($fromdate) & isset($todate)){ ?>
       <a href="javascript:load_printscrean2('<?=$prj_id?>','<?=$type?>','<?=$fromdate?>','<?=$todate?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
       <? }else{?>
          <a href="javascript:load_printscrean1('<?=$prj_id?>','<?=$type?>','<?=$month?>')"><i class="fa fa-file-excel-o nav_icon"></i></a>
   
       <? }?>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"  >
                     
      <table class="table table-bordered"><tr class="success"><th >Project Name</th><th  >Lot Number</th>
      <th > Land Value </th><th width="50">Capital Payment as at <?=$sartdate?></th><th width="50" >Balance to be Received as at <?=$sartdate?> </th>
      <th >Payment</th><th >Balance</th><th >%</th>
        </tr>
        </tr>
       
       
    <? 
	
	
		//echo $prjraw->prj_id;
			$prjlandval=0;$prjprvcap=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
        <tr class="active"><td><?=$details[$prj_id]->project_name?></td><td></td><td></td><td></td>
        
        <td></td><td></td><td></td></tr>
        <?  if($type=='01'){  if($reservation[$prj_id]){
			//print_r($reservation[$prj_id]);
			foreach($reservation[$prj_id] as $raw){
				$flag=true; 
				if($raw->res_status=='REPROCESS')
				$flag=false;
				if($raw->loan_code)
				$flag=false;
				if($thispayment[$raw->res_code]>0)
				$flag=true;
				

			
					
					if($raw->discounted_price!=$prevpayment[$raw->res_code]){
							//	echo $raw->lot_number.'-'.$thispayment[$raw->res_code].',';
						if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$prevpayment[$raw->res_code];
						$prjbal=$prjbal+($raw->discounted_price-$prevpayment[$raw->res_code]);
						$prjpayment=$prjpayment+$thispayment[$raw->res_code];
						$last_bal=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						if($raw->loan_code)
						$last_bal=0;
						if($raw->res_status=='REPROCESS')
							$last_bal=0;
						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$prevpayment[$raw->res_code]-$thispayment[$raw->res_code];
						
				?>
        <tr <? if($raw->loan_code) {?> class="yellow"<? }?>><td></td><td><a href="javascript:load_lotinquary('<?=$raw->lot_id?>','<?=$raw->prj_id?>')" ><?=$raw->lot_number?></a></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($prevpayment[$raw->res_code],2)?></td>
          <td align="right"><?=number_format($raw->discounted_price-$prevpayment[$raw->res_code],2)?></td>
           <td align="right"><?=number_format($thispayment[$raw->res_code],2)?></td>
            <td align="right"><?=number_format($last_bal,2)?></td>
            <td>
            
            
            <? $presentage=round(($raw->discounted_price-$balance)/$raw->discounted_price*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
            </td>
        </tr>
        <?  } }}} }?>
        <?  if($type=='04'){  if($zepreservation[$prj_id]){
			foreach($zepreservation[$prj_id] as $raw){
				//if($currentlist[$raw->res_code]){
					$zprvpayment=0;$zthispayment=0;
					if($zepprevpayment[$raw->loan_code])
					$zprvpayment=$zepprevpayment[$raw->loan_code]->sum_cap;
					if($zepthispayment[$raw->loan_code])
					$zthispayment=$zepthispayment[$raw->loan_code]->sum_cap;
					$fullpayment=$raw->down_payment+$zprvpayment;
						$flag=true; 
				if($raw->loan_status=='SETTLED')
				$flag=false;
				if($zthispayment>0)
				$flag=true;
					if($raw->discounted_price!=$fullpayment){
						if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
						$prjprvcap=$prjprvcap+$fullpayment;
						$prjbal=$prjbal+($raw->discounted_price-$fullpayment);
						$prjpayment=$prjpayment+$zthispayment;
						$last_bal=$raw->discounted_price-$fullpayment-$zthispayment;
						
						
						$prjlastbal=$prjlastbal+$last_bal;
						$balance=$raw->discounted_price-$fullpayment-$zthispayment;
						
				?>
        <tr  class="info"><td><a href="javascript:get_loan_detalis('<?=$raw->loan_code?>')"><?=$raw->loan_code?></a></td><td><?=$raw->lot_number?></td>
        <td align="right"><?=number_format($raw->discounted_price,2)?></td>
         <td align="right"><?=number_format($fullpayment,2)?></td>
          <td align="right"><?=number_format($raw->discounted_price-$fullpayment,2)?></td>
           <td align="right"><?=number_format($zthispayment,2)?></td>
            <td align="right"><?=number_format($last_bal,2)?></td>
            <td>
            
            
            <? $presentage=round(($raw->discounted_price-$balance)/$raw->discounted_price*100,2);
						     if($presentage>=60) $class='green'; else if($presentage<60 && $presentage>=50)  $class='blue'; else if($presentage<50 && $presentage>=25)  $class='yellow'; else $class='red';?>
                              
		
                         <div class="task-info">
									<span class="task-desc"></span><span class="percentage"><?=number_format($presentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$presentage?>%;"></div>
									</div>
            </td>
        </tr>
        <? } }}} }?>
         <tr class="active" style="font-weight:bold"><td></td><td></td>
        <td align="right"><?=number_format($prjlandval,2)?></td>
         <td align="right"><?=number_format($prjprvcap,2)?></td>
          <td align="right"><?=number_format($prjbal,2)?></td>
          <td align="right"><?=number_format($prjpayment,2)?></td>
          <td align="right"><?=number_format($prjlastbal,2)?></td>
          <td></td>
        </tr>
        
      <?
	 
	  
	  ?>
      
         </table></div>
    </div> 
    
</div>