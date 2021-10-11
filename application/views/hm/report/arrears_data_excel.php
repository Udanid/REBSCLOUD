
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
  $heading2=' EP Arreas Report as at '.$reportdata;
 }
 else{
   $heading2=' PEP Arreas Report  as at'.$reportdata;
 }
 
 $week1end=$start=date('Y-m-d',strtotime('+7 days',strtotime($sartdate)));
 $week2end=$start=date('Y-m-d',strtotime('+14 days',strtotime($sartdate)));
 $week3end=$start=date('Y-m-d',strtotime('+21 days',strtotime($sartdate)));
 $week4end=$start=date('Y-m-d',strtotime('+28 days',strtotime($sartdate)));
 $week5end=$reportdata;

$b='';
$b=$b.'
      <table width="100%" border="1">  <tr><td  align="center"  colspan="14"><h2>'.$heading2.'</h2></td></tr>
      
    
	 <tr  bgcolor="#98e5f3"><th  rowspan="2"> Project Name </th><th  rowspan="2">LOT Number</th><th colspan="3">Opening Balances as at <?=$sartdate?> </th><th  rowspan="2" >Budget </th><th  rowspan="2">Actual</th><th  rowspan="2">Variance</th>
      <th colspan="3"  bgcolor="#FF6666">Closing Balance as at <?=$reportdata?></th><th colspan="3">No of Arrears Instalments <?=$reportdata?></th></tr>
   
   <tr  bgcolor="#8caeb4" >  <th >Arrears Amount</th> <th>Instalment</th> <th>Total Recievables</th> <th >Arrears Amount</th> <th>Instalment</th> <th>Total Recievables</th><th>Opening</th><th>Closing</th><th>Variance</th></tr>';
       
     $fulltot=0;
       $arrtot=0;$renttot=0;$budget=0; $paytot=0; $nextbudgettot=0;$credittot=0;
      if($prjlist){foreach($prjlist  as $prraw){ 
	
	
			
			
			?>
        <?  if($transferlist[$prraw->prj_id]){
			  $b=$b.' <tr bgcolor="#CCCCCC"style="font-weight:bold"><td>'.$details[$prraw->prj_id]->project_name.'</td><td colspan="10"></td></tr>';

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
				
				if($closins >= 3)
				  	$b=$b.'<tr bgcolor="#FF6666">'; 
				else
       			 $b=$b.'<tr>';
       $b=$b.' <td>'.$raw->loan_code.'</td><td>'.$raw->lot_number.'</td>';
          //  echo $b;
			$varint=$closins-$arrinscount;
           $b=$b.' <td align="right" >'.number_format($arrearsmonth,2).'</td>';
             $b=$b.'<td align="right">'.number_format($raw->montly_rental,2).'</td>';
             $b=$b.' <td align="right">'.number_format($arrearsmonth+$raw->montly_rental,2).'</td>';
               $b=$b.' <td align="right">'.number_format($arrearsmonth+$raw->montly_rental,2).'</td>';
                $b=$b.' <td align="right">'.number_format($thismonthpay,2).'</td>';
                $b=$b.'  <td align="right">'.number_format($variance,2).'</td>';
                 $b=$b.' <td align="right">'.number_format($variance,2).'</td>';
                $b=$b.' <td align="right">'.number_format($raw->montly_rental,2).'</td>';
                 $b=$b.' <td align="right">'.number_format($nextbudget,2).'</td>';
                 $b=$b.' <td align="right">'.$arrinscount.'</td>';

                 $b=$b.' <td align="right">'.$closins.'</td>';
                  $b=$b.' <td align="right">'.$varint.'</td>';
           
            
             $b=$b.' </tr>';
		
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   }}
	  
	
       $b=$b.' <tr class="active" style="font-weight:bold">';
          $b=$b.' <td align="right" colspan="2">Total</td>';
            $b=$b.'<td align="right">'.number_format($arrtot,2).'</td>';
            $b=$b.' <td align="right">'.number_format($renttot,2).'</td>';
              $b=$b.'<td align="right">'.number_format($arrtot+$renttot-$credittot,2).'</td>';
              $b=$b.'  <td align="right">'.number_format($arrtot+$renttot,2).'</td>';
                 $b=$b.'<td align="right">'.number_format($paytot,2).'</td>';
                 $b=$b.' <td align="right">'.number_format($arrtot+$renttot-$paytot,2).'</td>';
                 $b=$b.' <td align="right">'.number_format($arrtot+$renttot-$paytot,2).'</td>';
                  $b=$b.'<td align="right">'.number_format($renttot,2).'</td>';
                  $b=$b.'<td align="right">'.number_format($arrtot+$renttot+$renttot-$paytot-$credittot,2).'</td>';
                  $b=$b.'<td align="right"></td>';
                  $b=$b.'<td align="right"></td>';
                  $b=$b.' <td align="right">1</td>';
             $b=$b.' </tr>';
           $b=$b.'</table>';
  
  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."-EP-Arrears-Report.xls");
	echo $b;