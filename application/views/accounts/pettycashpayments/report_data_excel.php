<?
$b='';
$b=$b.'

       
          <h4>Reimbursment Details - Direct Payments</h4>
         
          <table border="1"  width="100%">
      
   
   <tr bgcolor="#dad1cb"><th> PV No</th> <th> Date</th> <th>Payee</th> <th> Supplier Name</th>  <th>Description</th><th>Payment Added By</th> <th>Confirmed By</th><th>Paid Amount</th></tr> '
		?>       
            
            <? $fulltot=0; if($paymentlist){
			
			?>
            
            <? $directot=0;
			foreach($paymentlist as $raw){
				
				$fulltot=$fulltot+$raw->pay_amount;
							   $directot= $directot+$raw->pay_amount;;
				//print_r($arrearspay[$raw->res_code]);
				
				
           $b=$b.'<tr><td>'.$raw->serial_number.'</td>';     
      	$b=$b.'<td>'.$raw->paid_date.'</td>';
        $b=$b.'<td>'.$raw->initial.''.$raw->surname.'</td>';
             	$b=$b.'<td>'.$raw->sup_name.'</td>';
         $b=$b.' <td align="right">'.$raw->note.'</td>';
        $b=$b.' <td align="right">'.get_user_fullname_id($raw->paid_by).'</td>';
         $b=$b.'   <td align="right">'.get_user_fullname_id($raw->confirm_by).'</td>';
		   $b=$b.'    <td align="right">'.number_format($raw->pay_amount,2).'</td>';
              
           
            
           $b=$b.' </tr>';
			
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   
	   $b=$b.'  <tr class="active" style="font-weight:bold">';
	
     $b=$b.'    <td align="right" colspan="7">Direct Payment Total</td>';
     $b=$b.'     <td align="right">'.number_format($directot,2).'</td>';
            
      $b=$b.'           <td align="right"></td>
            </tr> </table>';
         
         
         
         
       
  
      $b=$b.'  <h4>IOU List</h4>    
           <table border="1"  width="100%">
      
   
   <tr bgcolor="#dad1cb">  <th >IOU No</th> <th >Cash Advance No</th> <th>Settlement Date</th> <th>Branch</th> <th >Employee Name</th> <th>Project</th> <th>Description </th><th>Actual Amount</th><th>Date Variance</th></tr>';
       
       $fulltota=0;?>
       
        <?  if($settledlist){
			
			foreach($settledlist as $raw){
				//print_r($arrearspay[$raw->res_code]);
				
				
              $b=$b.'<tr><td>'.$raw->serial_number.'</td>';       
      	$b=$b.'<td>'.$raw->adv_code.'</td>';
		 
        $b=$b.'<td>'.$raw->pay_date.'</td>';
            
         $b=$b.' <td align="right">'.get_branch_name($raw->branch).'</td>';
        $b=$b.' <td align="right">'.$raw->initial.''.$raw->surname.'</td>';
         $b=$b.'   <td align="right">'.$raw->project_name.'</td>';
          $b=$b.'    <td align="right">'.$raw->description.'</td>';
           $b=$b.'   <td align="right">'.number_format($raw->amount,2).'</td>';
            $b=$b.'   <td align="right"></td>';
              
           
            
           $b=$b.' </tr>';
			 $fulltota= $fulltota+$raw->amount;?>
    
     
        <? 
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        <?  if($pendiglist){
			
			?>
            
            <?
			foreach($pendiglist as $raw){
				//print_r($arrearspay[$raw->res_code]);
				 $date1=date_create($raw->promiss_date);
					  $date2=date_create($rptdate);
					  $diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
				
          $b=$b.'<tr><td>'.$raw->serial_number.'</td>';          
     $b=$b.' 	<td>'.$raw->adv_code.'</td>';
    $b=$b.'  <td>'.$raw->pay_date.'</td>';
            
     $b=$b.'     <td align="right">'.get_branch_name($raw->branch).'</td>';
     $b=$b.'    <td align="right">'.$raw->initial.' '.$raw->surname.'</td>';
      $b=$b.'      <td align="right">'.$raw->project_name.'</td>';
       $b=$b.'       <td align="right">'.$raw->description.'</td>';
        $b=$b.'      <td align="right">'.number_format($raw->amount,2).'</td>';
        $b=$b.'       <td align="right">'.$dates.'</td>';
              
           
            
         $b=$b.'   </tr>';
		 	 $fulltota= $fulltota+$raw->amount;
    
     
       
	//	$prjbujet=$prjbujet+$raw->new_budget;
	//	$prjexp=$prjexp+$raw->tot_payments;
		}}?>
        
               
            
           
        
        
      <?
	//  $fulltot=$fulltot+$prjexp;
	   
	  
	
    $b=$b.'  <tr class="active" style="font-weight:bold">';
     $b=$b.'    <td align="right" colspan="7">Total</td>';
     $b=$b.'     <td align="right">'.number_format($fulltota,2).'</td>';
            
   $b=$b.'              <td align="right"></td>';
    $b=$b.'        </tr>';
    $b=$b.'     </table>';
         
    $b=$b.'     <table border="1"  width="50%">';
    $b=$b.'     <tr><td>Direct Payment</td><td align="right">'.number_format($fulltot,2).'</td></tr>';
     $b=$b.'     <tr><td>Unsettled IOU</td><td align="right">'.number_format($fulltota+$fulltot,2).'</td></tr>';
     $b=$b.'       <tr><td>Cash In Hand and Bank</td><td align="right">'.number_format($ledgerbalance,2).'</td></tr></table>';
         
          	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=Cash_Advance-Report.xls");
	echo $b;