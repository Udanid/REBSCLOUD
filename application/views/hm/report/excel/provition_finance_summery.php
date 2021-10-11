

 <?
  $heading2='Finance Cost Summary  Report';

$b='';
$b=$b.'
      <table  border="1"  width="100%">
     <tr bgcolor="#dad1cb" style="font-weight:bold"><td colspan="7"  align="center"></td></tr>
       <tr><th rowspan="2" >Project</th><th rowspan="2" > Total Project Cost </th><th rowspan="2" >Collection as % cost Cover</th><th colspan="3" >Finance Cost</th>
             </tr>
             <tr><th>Budgeted</th><th>Actual</th><th>Balance/Excess</th></tr>';
       
       
     $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	$totfinance2=0;
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
			$prjbudget=project_expence($prjraw->prj_id);
			$presentage=0;
			if($prjbudget>0)
			$presentage=($dpcollect[$prjraw->prj_id]/$prjbudget)*100;
			if($presentage<100){
				$totfinance=$totfinance+$prjbudget;
				$totfinance2=$totfinance2+$financecost[$prjraw->prj_id];
				$totbudget=$totbudget+$prjbudget;
				$totactual=$totactual+$intcostfull[$prjraw->prj_id];
				$finance=$financecost[$prjraw->prj_id];
			
            $b=$b.' <td>'.$details[$prjraw->prj_id]->project_name.'</td>';
       $b=$b.' <td align="right">'.number_format($prjbudget,2).'</td>';
       $b=$b.' <td align="right">'.number_format($presentage,2).' %</td>';
       $b=$b.' <td align="right"> '.number_format($finance,2).'</td>';
       $b=$b.'  <td align="right"> '.number_format($intcostfull[$prjraw->prj_id],2).'</td>';
        $b=$b.'    <td align="right">'.number_format($finance-$intcostfull[$prjraw->prj_id],2).'</td><tr>';
             }
			
		}
		
		
		
        $b=$b.'  <tr class="active" style="font-weight:bold"><td >Total</td>';
       $b=$b.' <td align="right">'.number_format($totfinance,2).'</td>';
       $b=$b.'   <td align="right"></td></td>';
        $b=$b.'   <td align="right">'.number_format($totfinance2,2).'</td>';
          $b=$b.'  <td align="right">'.number_format($totactual,2).'</td>';
           $b=$b.'  <td align="right">'.number_format($totfinance2-$totactual,2).'</td></tr>';
        
        
	}
	
			
  
      
      
       
       
      
       $b=$b.'  </table>';
	    	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Finance_Cost_Summary_Report.xls");
	echo $b;