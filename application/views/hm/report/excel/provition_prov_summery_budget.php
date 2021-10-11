

 <?
  $heading2='Provision Summary  - Budget ';

 $b='';
                     
  $b=$b.'
                 
      <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><th>Project</th>';
     foreach($tasklist as $raw){
		    if($raw->task_code=='007' || $raw->task_code=='008'|| $raw->task_code=='009'|| $raw->task_code=='010'|| $raw->task_code=='011'|| $raw->task_code=='012' || $raw->task_code=='013' || $raw->task_code=='014' || $raw->task_code=='015'  ){
				$groupname='Development Works';
			}
			else if ( $raw->task_code=='016')
			{
              $b=$b.' <th  > '.$groupname.'</th>';
             }
			else{
	      $b=$b.'<th  > '.$raw->task_name.'</th>';
	     } }
     
       
       $b=$b.'<th>Total</th>
            </tr>
';       
       
    $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
			if($details[$prjraw->prj_id]->dp_cmp_status!='COMPLETE'){
			$dptotp=0; $prjtot=0;
			//$prjbudget=project_expence($prjraw->prj_id);
		
           $b=$b.'   <tr><td>'.$details[$prjraw->prj_id]->project_name.'</td>';
             
                foreach($tasklist as $raw){
				
								 $prjtot= $prjtot+$reservation[$prjraw->prj_id][$raw->task_id];
		    if($raw->task_code=='007' || $raw->task_code=='008'|| $raw->task_code=='009'|| $raw->task_code=='010'|| $raw->task_code=='011'|| $raw->task_code=='012' || $raw->task_code=='013' || $raw->task_code=='014' || $raw->task_code=='015'  ){
				$groupname='Development Works';
				$dptotp=$dptotp+$reservation[$prjraw->prj_id][$raw->task_id];
				 //$prjtot= $prjtot+
			}
			else if ( $raw->task_code=='016')
			{$dptotp=$dptotp+$reservation[$prjraw->prj_id][$raw->task_id];
				
               $b=$b.'<td  align="right" >'.number_format($dptotp,2).'</th>';
             }
			else{
	      $b=$b.'<td   align="right"  >'.number_format($reservation[$prjraw->prj_id][$raw->task_id],2).'</th>';
	     }
				
			 }
         $b=$b.'     <td style="font-weight:bold"  align="right" >'.number_format($prjtot,2).'</td>';
       $b=$b.'</tr>';
            
             }
			
		
			
		}
	
		
		
		
	}
	
			
       
       $b=$b.'
         </table>';
    header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Provition_Summery_Report_budget.xls");
	echo $b;