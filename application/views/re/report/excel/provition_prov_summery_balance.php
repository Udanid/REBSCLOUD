

 <?
  $heading2='Provision Summary  Report - Balance ';

 $b='';
                     
  $b=$b.'
                 
      <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><th>Project</th>';      
	   foreach($tasklist as $raw){
		  
	     $b=$b.'<th  >'.$raw->task_name.'</th>';
	      }
     
       
      $b=$b.'<th>Total</th>
            </tr>';
       
       
     $totfinance=0;
	$totbudget=0;
	$totactual=0;
	$totbalance=0;
	
	if($prjlist){
		foreach($prjlist as $prjraw){
		//	$totfinance=$totfinance+$prjbudget;
			if($details[$prjraw->prj_id]->dp_cmp_status!='COMPLETE'){
			$dptotp=0; $prjtot=0;
	
    $b=$b.'         <td>'.$details[$prjraw->prj_id]->project_name.'</td>';
             
                foreach($tasklist as $raw){
					$balance=$reservation[$prjraw->prj_id][$raw->task_id]-$prevpayment[$prjraw->prj_id][$raw->task_id];
					 $prjtot= $prjtot+$balance;
		   
	     $b=$b.'<td   align="right"  >'.number_format($balance,2).'</th>';
	      }
             $b=$b.'<td style="font-weight:bold"  align="right" >'.number_format($prjtot,2).'</td>';
      $b=$b.'</tr>';
            
         }
			
	
		}
		
		?>
       
        
        <?
	}
	
			
  
      
      
       
       
      
        $b=$b.' </table>';
		
	ob_end_clean();	
		header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Provition_Summery_Report_balance.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	ob_end_clean();
	echo $b;