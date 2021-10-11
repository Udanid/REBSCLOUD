<?
   $heading2='  Bank Loan Collection as at '.$reportdata;
    $monthname=date('F', mktime(0, 0, 0, intval(date('m')), 10));

 $b='';
$b=$b.'
                     
      <table  border="1"  width="100%">
	  <tr><td  align="center"  colspan="8"><h2>'.$heading2.'</h2></td></tr>
	  <tr bgcolor="#dad1cb"><th  rowspan="2">Project Name</th><th rowspan="2" >Lot Number</th><th rowspan="2" >Agreement Date</th>
      <th  rowspan="2"> Land Value </th> <th  rowspan="2"> Down Payment </th><th  rowspan="2"> Finance Value </th><th rowspan="2">Total Payments As at </th><th  colspan="2"> Total Payable as at '.$sartdate.'</th><th colspan="2"> Payments of '.$monthname.'</th><th colspan="1" >Balance to be Received as at <?=$reportdata?> </th>';
    
       $b=$b.' </tr>
        <tr><th>Interest Due </th><th>Balance</th><th>Interest</th><th>Capital</th><th>Balance</th>
        </tr>';
       
       
  
	
	
	$fprjrental=0;$fprjlandval=0;$fprjdownpay=0;
			$fprjloanval=0;$fprjint=0; $fprjagreed=0; 
			$fprjopbalint=0;
			$fprjopbalcap=0;
			$fprjopbaltot=0;
			$fprjpayint=0;
			$fprjpaycap=0;
			$fprjpaydi=0;
			$fprjpayrent=0;
			$fprjclbalint=0;
			$fprjclbalcap=0;
			$fprjclbaltot=0;
			//echo $prjraw->prj_id;
			$prjrental=0;$prjlandval=0;$prjdownpay=0;
			$prjloanval=0;$prjint=0; $prjagreed=0; 
			$prjopbalint=0;
			$prjopbalcap=0;
			$prjopbaltot=0;
			$prjpayint=0;
			$prjpaycap=0;
			$prjpaydi=0;
			$prjpayrent=0;
			$prjclbalint=0;
			$prjclbalcap=0;
			$prjclbaltot=0;
			if($reservation[$prj_id]){
		
     $b=$b.'   <tr bgcolor="#b2ebf9" style="font-weight:bold"><td colspan="17">'.$details[$prj_id]->project_name.'</td><td></td>';
        
       $b=$b.' </tr>';
         
			foreach($reservation[$prj_id] as $raw){
					
						
							
		$opbalcap=$raw->loan_amount-$prevpayment[$raw->loan_code]->sum_cap;
		$paidtots=$prevpayment[$raw->loan_code]->sum_cap+$prevpayment[$raw->loan_code]->sum_int;
		$opbalint=$inttots[$raw->loan_code]-$prevpayment[$raw->loan_code]->sum_int;
		$opbal=$raw->loan_amount+$inttots[$raw->loan_code]-($paidtots);
		$clbalcap=$opbalcap-$thispayment[$raw->loan_code]->sum_cap;
		$clbalint=$opbalint-$thispayment[$raw->loan_code]->sum_int;
		$clbal=$opbal-($thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap);
		
			$totpaidcap=$prevpayment[$raw->loan_code]->sum_cap+$thispayment[$raw->loan_code]->sum_cap;
		$thispaidcap=0;
		
		if($clbal<0)
		{ //echo 'exxcess';
			$thispaidcap=$thispayment[$raw->loan_code]->sum_cap+$clbal;
		}
		else
		$thispaidcap=$thispayment[$raw->loan_code]->sum_cap;
		if($clbal<0)
		$clbal=0;
		$thispyament=$thispayment[$raw->loan_code]->sum_int+$thispayment[$raw->loan_code]->sum_cap;
		$flag=false;
		$status=$raw->loan_status;
		if($status=='CONFIRMED')
		$flag=true;
		if($thispyament>0)
		$flag=true;
		if($flag){
						$prjlandval=$prjlandval+$raw->discounted_price;
					
						$prjdownpay=$prjdownpay+$raw->down_payment;
						$prjloanval=$prjloanval+$raw->loan_amount;
						$prjint=$prjint+$inttots[$raw->loan_code];
						$prjagreed=$prjagreed+$paidtots;
						$prjopbalint=$prjopbalint+$opbalint;
						$prjopbalcap=$prjopbalcap+$opbalcap;
						$prjopbaltot=$prjopbaltot+$opbal;
						$prjpayint=$prjpayint+$thispayment[$raw->loan_code]->sum_int;
						$prjpaycap=$prjpaycap+$thispaidcap;
						$prjpaydi=$prjpaydi+$thispayment[$raw->loan_code]->sum_di;
						
						$prjclbaltot=$prjclbaltot+$clbal;
						
						
				
       $b=$b.' <tr><td>'.$raw->loan_code.'</td>';
      $b=$b.' <td>'.$raw->lot_number.'</td>';
      $b=$b.' <td>'.$raw->start_date.'</td>';
         $b=$b.'<td align="right">'.number_format($raw->discounted_price,2).'</td>';
         $b=$b.'<td align="right">'.number_format($raw->down_payment,2).'</td>';
         $b=$b.' <td align="right">'.number_format($raw->loan_amount,2).'</td>';
            $b=$b.' <td align="right">'.number_format($paidtots,2).'</td>';
         $b=$b.'  <td align="right">'.number_format($inttots[$raw->loan_code],2).'</td>';
                 $b=$b.'     <td align="right">'.number_format($opbal,2).'</td>';
            $b=$b.'  <td align="right">'.number_format($thispayment[$raw->loan_code]->sum_int,2).'</td>';
                $b=$b.'<td align="right">'.number_format($thispaidcap,2).'</td>';
                            $b=$b.' <td align="right">'.number_format($clbal,2).'</td>';
             
           
       $b=$b.' </tr>';
       }}
        
      $b=$b.'   <tr bgcolor="#c3c4be" style="font-weight:bold"><td></td><td></td><td></td>';
       $b=$b.'  <td align="right">'.number_format($prjlandval,2).'</td>';
        $b=$b.' <td align="right">'.number_format($prjdownpay,2).'</td>';
         $b=$b.' <td align="right">'.number_format($prjloanval,2).'</td>';
         $b=$b.'  <td align="right">'.number_format($prjagreed,2).'</td>';
           $b=$b.' <td align="right">'.number_format($prjint,2).'</td>';
           $b=$b.'  <td align="right">'.number_format($prjopbaltot,2).'</td>';
            $b=$b.' <td align="right">'.number_format($prjpayint,2).'</td>';
             $b=$b.' <td align="right">'.number_format($prjpaycap,2).'</td>';
               $b=$b.'                    <td align="right">'.number_format($prjclbaltot,2).'</td>';
       $b=$b.' </tr>';
        
      
	 
					
						
	  }
     $b=$b.'   </table>';
	 ob_end_clean();
	   	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment;Filename=".$month."-EPB-Collection-Report.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	ob_end_clean();
	echo $b;