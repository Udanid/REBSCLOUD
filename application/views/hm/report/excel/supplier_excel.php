
 <?
 if($month!=''){
  $heading2=' Provition Report as at '.$reportdata;
 }
 else{
   $heading2=' Provition Report as at '.$reportdata;
 }
 
 $b='';
                     
  $b=$b.' 
                     
    <table border="1"  width="100%"><tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><td colspan="7"  align="center">'.$details[$prj_id]->project_name.'</td></tr>
       <tr ><th colspan="2">Budget</th><th colspan="4">Actual</th><th>%</th></tr>
      <tr><th > Category </th><th width="50">Total Budget</th><th width="50" >Expense</th>
      <th >Description</th><th >Payment Date </th><th>CHQ / Voucher No</th><th >%</th>
       
        </tr>';
   	//echo $prjraw->prj_id;
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			
         if($reservation[$prj_id]){
			foreach($reservation[$prj_id] as $raw){
						if($raw->new_budget>0){			
				
       $b=$b.'  <tr><td>'.$raw->task_name.'</td>';
       $b=$b.'  <td align="right">'.number_format($raw->new_budget,2).'</td><td></td><td></td><td></td><td></td></tr>';
         if($currentlist[$raw->id]){foreach($currentlist[$raw->id] as $payraw){
			$b=$b.' <tr><td></td><td></td>';
            $b=$b.'   <td align="right">'.number_format($payraw->amount,2).'</td>';
         $b=$b.'  <td align="right">'.$payraw->name.'-'.$payraw->subtask_name.'</td>';
          $b=$b.'  <td align="right">'.$payraw->create_date.'</td>';
          $b=$b.'   <td align="right">'.$payraw->voucherid.'/'.$payraw->CHQNO.'</td>';

            
          $b=$b.'   </tr>';
		}}	
      $b=$b.'   <tr class="active" style="font-weight:bold">';
       $b=$b.'   <td align="right">Total Expense</td>';
        $b=$b.'   <td align="right"></td>';
         $b=$b.'   <td align="right">'.number_format($raw->tot_payments,2).'</td>';
        $b=$b.'    <td align="right"></td>';
          $b=$b.'  <td align="right"></td>';
         $b=$b.'   <td align="right"></td>';
         
       $b=$b.'  </tr>';
       $b=$b.'   <tr class="active" style="font-weight:bold">';
      $b=$b.'    <td align="right">Available Budget</td>';
      $b=$b.'     <td align="right">'.number_format($raw->new_budget-$raw->tot_payments,2).'</td>';
       $b=$b.'     <td align="right"></td>';
       $b=$b.'     <td align="right"></td>';
       $b=$b.'     <td align="right"></td>';
       $b=$b.'     <td align="right"></td>';
           
           
       $b=$b.'     </tr>';
        
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}
        $b=$b.'  <tr class="info" style="font-weight:bold">';
        $b=$b.'  <td align="right">Total Project Expens</td>';
          $b=$b.'   <td align="right"></td>';
         $b=$b.'  <td align="right">'.number_format($prjexp,2).'</td>';
        
         $b=$b.'   <td align="right"></td>';
         $b=$b.'   <td align="right"></td>';
         $b=$b.'   <td align="right"></td>';
           
           
       
         $b=$b.'   </tr>';
           
          $b=$b.'   <tr class="info" style="font-weight:bold">';
       $b=$b.'   <td align="right">Available Project Budget</td>';
           
         $b=$b.'  <td align="right">'.number_format($prjbujet-$prjexp,2).'</td>';
      $b=$b.'    <td align="right"></td>';
        $b=$b.'    <td align="right"></td>';
         $b=$b.'   <td align="right"></td>';
         $b=$b.'   <td align="right"></td></tr>';
           
        $b=$b.'   <tr class="info" style="font-weight:bold">';
       $b=$b.'   <td align="right">Total Budgeted Amount</td>';
           
      $b=$b.'     <td align="right">'.number_format($prjbujet,2).'</td>';
      $b=$b.'    <td align="right"></td>';
        $b=$b.'    <td align="right"></td>';
        $b=$b.'    <td align="right"></td>';
        $b=$b.'    <td align="right"></td>';
           
         $b=$b.'   </tr>';
        
    
     $b=$b.'     </table>';
	 
	     $b=$b.' </table>';
		  header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Provition_Report.xls");
	echo $b;