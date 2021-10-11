
<script type="text/javascript">

function load_printscrean1(month,prjid)
{
			window.open( "<?=base_url()?>hm/report/get_stock_all_print/"+month);
	
}
function expoet_excel(month)
{
		
		
				window.open( "<?=base_url()?>hm/report/arreas_data_excel/"+month );
}

</script>
<style type="text/css">

</style>
 <?
 if($month!=''){
  $heading2=' EP Arreas Report as at '.$reportdata.' Installment wise';
 }
 else{
   $heading2=' PEP Arreas Report  as at'.$reportdata.' Installment wise';
 }
 for($i=-60; $i<=60; $i++){
	 $myque[$i]=NULL;
	 $quecounter[$i]=0;
 }
 $week1end=$start=date('Y-m-d',strtotime('+7 days',strtotime($sartdate)));
 $week2end=$start=date('Y-m-d',strtotime('+14 days',strtotime($sartdate)));
 $week3end=$start=date('Y-m-d',strtotime('+21 days',strtotime($sartdate)));
 $week4end=$start=date('Y-m-d',strtotime('+28 days',strtotime($sartdate)));
 $week5end=$reportdata;

$b='';
$b=$b.'
      <table width="100%" border="1">  <tr><td  align="center"  colspan="14"><h2>'.$heading2.'</h2></td></tr>
      
    
	 <tr  bgcolor="#98e5f3"><th  rowspan="2"> Project Name </th><th  rowspan="2">Loan Code</th><th  rowspan="2">LOT Number</th><th colspan="3">Opening Balances as at <?=$sartdate?> </th><th  rowspan="2" >Budget </th><th  rowspan="2">Actual</th><th  rowspan="2">Variance</th>
	 
      <th colspan="3"  bgcolor="#FF6666">Closing Balance as at <?=$reportdata?></th><th colspan="3">No of Arrears Instalments <?=$reportdata?></th>
	    <th  rowspan="2">Officer Feedback</th><th  rowspan="2">Customer Feedback</th></tr>
   
   <tr  bgcolor="#8caeb4" >  <th >Arrears Amount</th> <th>Instalment</th> <th>Total Recievables</th> <th >Arrears Amount</th> <th>Instalment</th> <th>Total Recievables</th><th>Opening</th><th>Closing</th><th>Variance</th></tr>';
       
     $fulltot=0;
       $arrtot=0;$renttot=0;$budget=0; $paytot=0; $nextbudgettot=0;$credittot=0;
      if($prjlist){foreach($prjlist  as $prraw){ 
	
	
			
			
			?>
        <?  if($transferlist[$prraw->prj_id]){
			 

			foreach($transferlist[$prraw->prj_id] as $raw){
				 
				//print_r($arrearspay[$raw->res_code]);
				$arrearsmonth=0;$thismonthpay=0;$arrinscount=0;
				if($arrearspay[$raw->res_code]){
				$arrearsmonth=$arrearspay[$raw->res_code]->arriastot-$startpayment[$raw->res_code];
				$arrinscount=$arrearspay[$raw->res_code]->instalmentcount;
				}
				if($credtipay[$raw->res_code])
				{
				$arrearsmonth=$arrearsmonth-$credtipay[$raw->res_code]->totpay;
				$arrinscount=$arrinscount-$credtipay[$raw->res_code]->instalmentcount;
				}
				if($thispay[$raw->res_code])
				{
					$thismonthpay=$thispay[$raw->res_code]->sum_cap+$thispay[$raw->res_code]->sum_int;
				}
				$thisbudget=$arrearsmonth+$raw->montly_rental;
				$variance=$thisbudget-$thismonthpay;
				$nextbudget=	$thisbudget-$thismonthpay+$raw->montly_rental;	
					$closins=round($variance/$raw->montly_rental,0);	
				$arrinscount=round(($arrearsmonth)/$raw->montly_rental,0);	
			
				$renttot=$renttot+$raw->montly_rental;	
				if($arrearsmonth>0)
				$arrtot=$arrtot+$arrearsmonth;
				else
				$credittot=$credittot+$arrearsmonth;
				$paytot=$paytot+$thismonthpay;
				  $cusfeedback='';
				  $officerfeedback='';
				  if($feedback[$raw->res_code])
				  { $officerfeedback=$feedback[$raw->res_code]->sales_feedback;
				    $cusfeedback=$feedback[$raw->res_code]->cus_feedback;
				  }
				 $myque[$arrinscount][$quecounter[$arrinscount]]=array('project_name'=>$details[$prraw->prj_id]->project_name,
				  'loan_code'=>$raw->loan_code,'lot_number'=>$raw->lot_number,'arrearsmonth'=>$arrearsmonth,
				  'montly_rental'=>$raw->montly_rental
				  ,'startrec'=>$arrearsmonth+$raw->montly_rental
				  ,'budget'=>$arrearsmonth+$raw->montly_rental
				  ,'actual'=>$thismonthpay
				  ,'variance'=>$variance
				  ,'arramount'=>$variance
				  ,'instalment'=>$raw->montly_rental
				  ,'nextbudget'=>$nextbudget
				  ,'opening'=>$arrinscount
				   ,'closing'=>$closins
				    ,'varinace'=>$closins-$arrinscount
					 ,'officerfeedback'=>$officerfeedback
					    ,'cusfeedback'=>$cusfeedback
				  );
				 // $quecounter.$arrinscount++;*/
				   $quecounter[$arrinscount]++;
			
		
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	
       for($i=60; $i>=-60;$i--){
		if( $myque[$i]){  $projectname=0;
		for($j=0;$j<$quecounter[$i]; $j++){
			if($projectname!=$myque[$i][$j]['project_name']){
			//	$b=$b.'  <tr class="active" style="font-weight:bold"><td>'.$myque[$i][$j]['project_name'].'</td><td colspan="27"></td></tr>';
				
				
				 }
			
		  
      
      $b=$b.' <tr ><td>'.$myque[$i][$j]['project_name'].'</td><td>'.$myque[$i][$j]['loan_code'].'</td><td>'.$myque[$i][$j]['lot_number'].'</td>';
              $b=$b.' <td align="right">'.number_format($myque[$i][$j]['arrearsmonth'],2).'</td>';
         $b=$b.' <td align="right">'.number_format($myque[$i][$j]['montly_rental'],2).'</td>';
            $b=$b.' <td align="right">'.number_format($myque[$i][$j]['startrec'],2).'</td>';
              $b=$b.' <td align="right">'.number_format($myque[$i][$j]['budget'],2).'</td>';
               $b=$b.' <td align="right">'.number_format($myque[$i][$j]['actual'],2).'</td>';
                $b=$b.' <td align="right">'.number_format($myque[$i][$j]['variance'],2).'</td>';
                $b=$b.' <td align="right">'.number_format($myque[$i][$j]['arramount'],2).'</td>';
                $b=$b.' <td align="right">'.number_format($myque[$i][$j]['instalment'],2).'</td>';
                $b=$b.' <td align="right">'.number_format($myque[$i][$j]['nextbudget'],2).'</td>';
                $b=$b.' <td align="right">'.$myque[$i][$j]['opening'].'</td>';
                $b=$b.' <td align="right">'.$myque[$i][$j]['closing'].'</td>';
                 $b=$b.' <td align="right">'.$myque[$i][$j]['varinace'].'</td>';
          $b=$b.' <td align="right">'.$myque[$i][$j]['officerfeedback'].'</td>';
                   $b=$b.' <td align="right">'.$myque[$i][$j]['cusfeedback'].'</td>';
           
            
             $b=$b.' </tr>';
     $projectname=$myque[$i][$j]['project_name']; }}}
           $b=$b.'</table>';
  
  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."-EP-Arrears-Report-Installment-wise.xls");
	echo $b;