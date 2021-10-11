

 <?
 if($month!=''){
  $heading2=' Budget Report as at '.$reportdata;
 }
 else{
   $heading2=' Budget Report as at '.$reportdata;
 }
 

 $b='';
$b=$b.'      <table border="1"  width="100%"><tr><td  align="center"  colspan="4"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><td colspan="4"  align="center">'.$details[$prj_id]->project_name.'</td></tr>
       <tr><th > Category </th><th>Total Budget</th><th >Expense</th>
      <th >Balance</th>
        
        </tr>
       ';
       

	
	
		//echo $prjraw->prj_id;
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			
          if($reservation[$prj_id]){
			foreach($reservation[$prj_id] as $raw){
						if($raw->new_budget>0){			
				
       $b=$b.' <tr><td>'.$raw->task_name.'</td>';
       $b=$b.' <td align="right">'.number_format($raw->new_budget,2).'</td>';
       $b=$b.' <td align="right">'.number_format($raw->tot_payments,2).'</td>';
       $b=$b.' <td align="right"> '.number_format($raw->new_budget-$raw->tot_payments,2).'</td></tr>';
        
       
        
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}
       $b=$b.'  <tr class="info" style="font-weight:bold">';
       $b=$b.'  <td align="right">Total</td>';
        $b=$b.'    <td align="right">'.number_format($prjbujet,2).'</td>';
        $b=$b.'  <td align="right">'.number_format($prjexp,2).'</td>';
        $b=$b.' <td align="right">'.number_format($prjbujet-$prjexp,2).'</td>';
            
           
            $b=$b.'       </tr>';
           
           
   
     $b=$b.'    </table>';
	   header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=budget_Report.xls");
	echo $b;