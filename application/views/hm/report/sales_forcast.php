
<script type="text/javascript">

function load_printscrean1(branch,month,year)
{
			window.open( "<?=base_url()?>hm/report_excel/get_forcast_report/"+branch+"/"+month+"/"+year );
	
}

</script>
<style type="text/css">

</style>
 <?
 if($month!=''){
  $heading2=' Sales Forcast Report -  as at '.$reportdata;
 }
 else{
   $heading2=' Sales Forcast Report - as at'.$reportdata;
 }
 
 $week1end=$start=date('Y-m-d',strtotime('+7 days',strtotime($sartdate)));
 $week2end=$start=date('Y-m-d',strtotime('+14 days',strtotime($sartdate)));
 $week3end=$start=date('Y-m-d',strtotime('+21 days',strtotime($sartdate)));
 $week4end=$start=date('Y-m-d',strtotime('+28 days',strtotime($sartdate)));
 $week5end=$reportdata;
 ?>

<div class="row">
	<div class="widget-shadow" data-example-id="basic-forms">
   <div class="form-title">
		<h4><?=$heading2?> 
       <span style="float:right"> <a href="javascript:load_printscrean1('<?=$branchid?>','<?=$month?>','<?=$year?>')"> <i class="fa fa-file-excel-o nav_icon"></i></a>
</span></h4>
	</div>
     <div class="table-responsive bs-example widget-shadow"   style="max-height:400px; overflow:scroll" >
                
      <table class="table table-bordered">
      
     <tr   class="active"><th  rowspan="2"> Project Name </th><th  rowspan="2">LOT Number</th><th colspan="2"> Sale 	</th><th  rowspan="2" >Tot Payment </th><th  rowspan="2">Amount to Received</th>
      <th  rowspan="2">Payment Plan</th><th colspan="3">30% or 60%  Completion Details 	</th>  <th  rowspan="2">Interest Free Period End Date</th><th  rowspan="2">Exceed from Int free</th>
      <th  rowspan="2">Payment Due Date</th>
     <th colspan="3">1st Week</th> <th colspan="3">2nd Week</th> <th colspan="3">3rd Week</th> <th colspan="3" >4th Week</th><th colspan="3">5th Week</th></tr>
      <tr class="success" ><th >sales Date</th>
      <th >Sales Price</th> <th >To be Paid</th><th >Paid On</th><th >late Days</th>
    
      <th>Budget</th> <th>Actual</th><th>Variance</th>
      <th>Budget</th> <th>Actual</th><th>Variance</th>
      <th>Budget</th> <th>Actual</th><th>Variance</th>
      <th>Budget</th> <th>Actual</th><th>Variance</th>
      <th>Budget</th> <th>Actual</th><th>Variance</th>
      <th>Paid Total</th><th>Unpaid Total</th></tr>
       
       <? $fulltot=0;?>
       
       <? if($prjlist){foreach($prjlist  as $prraw){ ?> 
    <tr class="active" style="font-weight:bold"><td><?=$details[$prraw->prj_id]->project_name?></td><td colspan="27"></td></tr>
	
	<?
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
        <?  if($transferlist[$prraw->prj_id]){
			foreach($transferlist[$prraw->prj_id] as $raw){
				$type=$raw->pay_type;
				if($raw->loan_type)
				$type=$raw->loan_type;
				if($type!='NEP' &  $raw->loan_status!='SETTLED'){
						
				$intfeemonth=$details[$prraw->prj_id]->int_freetime;
				$week1=0;$week2=0;$week3=0;$week4=0;$week5=0;$paydate30="";$currentpay=0;
				$fweek1=0;$fweek2=0;$fweek3=0;$fweek4=0;$fweek5=0;
				
				$topaydate=date('Y-m-d',strtotime('+1 months',strtotime($raw->res_date)));
				$intfreedate=date('Y-m-d',strtotime('+'.intval($intfeemonth).' months',strtotime($raw->res_date)));
				$totpaid=$paidcap[$raw->res_code]+$paidadvance[$raw->res_code];
				$paiddate="";
				$balance=$raw->discounted_price-$totpaid;
				if($adpaylist[$raw->res_code])
				{
					foreach($adpaylist[$raw->res_code] as $adraw){
						if($adraw->pay_date>=$sartdate && $adraw->pay_date<$week1end)
						{
							$week1=$week1+$adraw->pay_amount;
							$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week1end && $adraw->pay_date<$week2end)
						{
							$week2=$week2+$adraw->pay_amount;
							//$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week2end && $adraw->pay_date<$week3end)
						{
							$week3=$week3+$adraw->pay_amount;
							//$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week3end && $adraw->pay_date<$week4end)
						{
							$week4=$week4+$adraw->pay_amount;
							//$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week4end && $adraw->pay_date<$week5end)
						{
							$week5=$week5+$adraw->pay_amount;
							
						}
						$currentpay=$currentpay+$adraw->pay_amount;
						
						if($paiddate=="")
						{
							$presentage=($currentpay/$raw->discounted_price)*100;
							if($presentage>30)
							$paiddate=$adraw->pay_date;
						}
						
						
					}
				}
				if($rentpaylist[$raw->res_code])
				{
					foreach($rentpaylist[$raw->res_code] as $adraw){
						if($adraw->pay_date>=$sartdate && $adraw->pay_date<$week1end)
						{
							$week1=$week1+$adraw->cap_amount;
							$currentpay=$currentpay+$adraw->cap_amount;
						}
						if($adraw->pay_date>=$week1end && $adraw->pay_date<$week2end)
						{
							$week2=$week2+$adraw->cap_amount;
							//$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week2end && $adraw->pay_date<$week3end)
						{
							$week3=$week3+$adraw->cap_amount;
							//$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week3end && $adraw->pay_date<$week4end)
						{
							$week4=$week4+$adraw->cap_amount;
							//$currentpay=$currentpay+$adraw->pay_amount;
						}
						if($adraw->pay_date>=$week4end && $adraw->pay_date<$week5end)
						{
							$week5=$week5+$adraw->cap_amount;
							
						}
						$currentpay=$currentpay+$adraw->cap_amount;
						
						if($paiddate=="")
						{
							$presentage=($currentpay/$raw->discounted_price)*100;
							if($presentage>30)
							$paiddate=$adraw->pay_date;
						}
						
						
					}
				}
				if($paiddate!="")
				$acdate=$paiddate;
				else $acdate=date('Y-m-d');
				$date1=date_create($acdate);
					
				$date2=date_create($topaydate);
				//echo $raw->res_code.'-'.$raw->res_date.'--'.$acdate.'topau';
			
				$date3=date_create($intfreedate);
				$diff=date_diff($date1,$date2);
				$difdates=$diff->format("%a ");
				$diff=date_diff($date1,$date3);
				$difdatesintf=$diff->format("%a ");
				if($forcast[$raw->res_code])
				{
				$fweek1=$forcast[$raw->res_code]->week1;
				$fweek2=$forcast[$raw->res_code]->week2;
				$fweek3=$forcast[$raw->res_code]->week3;
				$fweek4=$forcast[$raw->res_code]->week4;
				$fweek5=$forcast[$raw->res_code]->week5;
				
				}
				$wpaidtot=$week1+$week2+$week3+$week4+$week5;
				$wunpaidtot=($fweek1+$fweek2+$fweek3+$fweek4+$fweek5)-$wpaidtot;
				
			
						if($wpaidtot>0){		
				?>
      	<tr><td></td><td><?=$raw->lot_number?></td>
              <td align="right"><?=$raw->res_date?></td>
          <td align="right"><?=number_format($raw->discounted_price,2)?></td>
           <td align="right"><?=number_format($totpaid,2)?></td>
            <td align="right"><?=number_format($balance,2)?></td>
              <td align="right"><?=$raw->pay_type?></td>
               <td align="right"><?=$topaydate?></td>
                <td align="right"><?=$paiddate?></td>
                <td align="right"><?=$difdates?></td>
                <td align="right"><?=$intfreedate?></td>
                 <td align="right"><?=$difdatesintf?></td>
                   <td align="right"></td>
                    <td align="right"><?=number_format($fweek1,2)?></td>
                      <td align="right"><?=number_format($week1,2)?></td>
                         <td align="right"><?=number_format($fweek1-$week1,2)?></td>
                           <td align="right"><?=number_format($fweek2,2)?></td>
                      <td align="right"><?=number_format($week2,2)?></td>
                         <td align="right"><?=number_format($fweek2-$week2,2)?></td>
                           <td align="right"><?=number_format($fweek3,2)?></td>
                      <td align="right"><?=number_format($week3,2)?></td>
                         <td align="right"><?=number_format($fweek3-$week3,2)?></td>
                           <td align="right"><?=number_format($fweek4,2)?></td>
                      <td align="right"><?=number_format($week4,2)?></td>
                         <td align="right"><?=number_format($fweek4-$week4,2)?></td>
                           <td align="right"><?=number_format($fweek5,2)?></td>
                      <td align="right"><?=number_format($week5,2)?></td>
                         <td align="right"><?=number_format($fweek5-$week5,2)?></td>
                          <td align="right"><?=number_format($wpaidtot,2)?></td>
                           <td align="right"><?=number_format($wunpaidtot,2)?></td>

            
            </tr>
		<? 	?>
    
     
        <? 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
						}}}}?>
        
               
            
           
        
        
      <?
	  $fulltot=$fulltot+$prjexp;
	   }}
	  
	  ?>
      <tr class="active" style="font-weight:bold">
         <td align="right">Total Expense</td>
          <td align="right"></td>
           <td align="right"><?=number_format($fulltot,2)?></td>
           <td align="right"></td>
           <td align="right"></td>
           <td align="right"></td>
            </tr>
         </table></div>
    </div> 
    
</div>