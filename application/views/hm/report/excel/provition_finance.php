
<?

$b='';
$b=$b.'
      <table  border="1"  width="100%">
     <tr  bgcolor="#dad1cb" style="font-weight:bold"><td colspan="7"  align="center">'.$details->project_name.'</td></tr>
       <tr><th >Serial No</th><th > Month </th><th>Cash Outflow</th><th >Cash inflow</th><th >NET CF</th> <th >Interest</th> <th >Interest Cost</th>
      
        
        </tr>';
       
       
    
	$srat=explode('-',$sartdate);
			$year=$srat[0];
			$month=$srat[1];
			$startDate=$year.'-'.$month.'-01';
			$totinti=0;
			$cumulativeout=0;
			$cumulativein=0;
			for($i=1; $i<=24; $i++)
			{
				if($startDate<date('Y-m-d')){
				$startDate=$startDate;
				$datearr=explode('-',$startDate);
				//print_r()
				$year=$datearr[0];
				$month=$datearr[1];
				$enddate=$year.'-'.$month.'-31';
				$monthName = date('F', mktime(0, 0, 0, intval($month), 10));
				$cumulativeout=$cumulativeout+$expence[$i];
				$cumulativein=$cumulativein+$dpcollect[$i];
				$netflow=$cumulativein-$cumulativeout;
				$intcost=0;
				if($netflow<0)
				{
					$intcost=$netflow*(-1)*1.5/100;
				}
				else $intcost=$netflow*1.5/100;
				$totinti=$totinti+$intcost;
				
                
			  $b=$b.' 	 <tr><td>'.$i.'</td>';
                $b=$b.'    <td>'.$monthName."-".$year.'</td>';
         $b=$b.'  <td align="right">'.number_format($cumulativeout,2).'</td>';
         $b=$b.'  <td align="right">'.number_format($cumulativein,2).'</td>';
         $b=$b.'  <td align="right"> '.number_format($netflow,2).'</td>';
          $b=$b.'  <td align="right"> 1.5</td>';
           $b=$b.'    <td align="right">'.number_format($intcost,2).'</td>';
		   $b=$b.' </tr>';
				
				
				$startDate=date('Y-m-d',strtotime('+1 months',strtotime($startDate)));
			}
			}
	
		//echo $prjraw->prj_id;
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			
  
       $b=$b.'    <tr class="active" style="font-weight:bold"><td colspan="6">Total</td>';
         $b=$b.'  <td align="right">'.number_format($totinti,2).'</td>';
         $b=$b.' </tr>
       
       
      
         </table>';
		 
		  	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Finance_cost.xls");
	echo $b;