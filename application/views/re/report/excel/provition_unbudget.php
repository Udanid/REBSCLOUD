
 <?
 if($month!=''){
  $heading2=' Payment Details of Unbudgeted Projects -  as at '.$reportdata;
 }
 else{
   $heading2=' Payment Details of Unbudgeted Projects - as at'.$reportdata;
 }
 
 $b='';
                     
  $b=$b.' 
         

                     
     <table border="1"  width="100%"><tr><td  align="center"  colspan="6"><h2>'.$heading2.'</h2></td></tr><tr bgcolor="#b2ebf9"><th > Project Name </th><th>Category</th><th >Expense</th>
      <th >Description</th><th >Payment Date </th><th>CHQ / Voucher No</th>';
       $fulltot=0;
      $b=$b.'  </tr>';
       if($prjlist){foreach($prjlist  as $prraw){ 
       
   $b=$b.'  <tr><td>'.$details[$prraw->prj_id]->project_name.'</td><td></td><td></td><td></td><td></td><td></td></tr>';
	
	
			$prjbujet=0;$prjexp=0;$prjbal=0; $prjpayment=0; $prjlastbal=0;
			
			?>
        <?  if($reservation[$prraw->prj_id]){
			foreach($reservation[$prraw->prj_id] as $raw){
						if($raw->new_budget>0){			
				?>
         <? if($currentlist[$raw->id]){foreach($currentlist[$raw->id] as $payraw){
		 $b=$b.'	<tr><td></td><td>'.$raw->task_name.'</td>';
           $b=$b.'    <td align="right">'.number_format($payraw->amount,2).'</td>';
         $b=$b.'  <td align="right">'.$raw->task_name.'-'.$payraw->subtask_name.'</td>';
            $b=$b.'<td align="right">'.$payraw->create_date.'</td>';
          $b=$b.'   <td align="right">'.$payraw->voucherid.'/'.$payraw->CHQNO.'</td>';

            
            $b=$b.' </tr>';
		 }}	
    
     
        
		$prjbujet=$prjbujet+$raw->new_budget;
		$prjexp=$prjexp+$raw->tot_payments;
		}}}
        
              $b=$b.'  <tr class="active" style="font-weight:bold">';
        $b=$b.'  <td align="right">Total Project Expense</td>';
         $b=$b.'  <td align="right"></td>';
          $b=$b.'  <td align="right">'.number_format($prjexp,2).'</td>';
         $b=$b.'   <td align="right"></td>';
          $b=$b.'  <td align="right"></td>';
          $b=$b.'  <td align="right"></td>';
           $b=$b.'  </tr>';
            
           
        
        
     
	  $fulltot=$fulltot+$prjexp;
	   }}
	  
	
     $b=$b.'  <tr class="active" style="font-weight:bold">';
       $b=$b.'   <td align="right">Total Expense</td>';
        $b=$b.'   <td align="right"></td>';
        $b=$b.'    <td align="right">'.number_format($fulltot,2).'</td>';
          $b=$b.'  <td align="right"></td>';
           $b=$b.' <td align="right"></td>';
           $b=$b.' <td align="right"></td>';
            $b=$b.' </tr>';
        $b=$b.'  </table>';
		ob_end_clean();
      header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."Provition_unbudget_Report.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	ob_end_clean();
	echo $b;