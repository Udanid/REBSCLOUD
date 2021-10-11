                  <?
				  if($details->loan_type!='EPB'){
				  
				   $delaintot=0;$thisdelayint=0;
				  $delayrentaltot=0; $arieasins=0;$arreascap=0;$arreasint=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));
					$arreascap=$arreascap+$raw->cap_amount-$raw->paid_cap;
					   $arreasint=$arreasint+$raw->int_amount-$raw->paid_int ;
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date1 >	 $date2)
					$dates=0-($dates);
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=($thisdelayint+floatval($details->montly_rental))*floatval($details->delay_interest)/(100);
						$thisdelayint=$thisdelayint+$dalay_int;
						$currentdi=round($dalay_int,2)-$raw->balance_di;
						 if($currentdi<0)
					  $currentdi=0;
					   $delaintot=$delaintot+$currentdi;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					
					}
						
				  }}}else {?>
					  
				  <?
 $futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=date('Y-m-d');
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
					  $date1=date_create($loanstart_date);
					  $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;
					$inttot=0;
					$dates=$diff->format("%m ");
					$thismonthint=0;
					$dates=get_month_count($loanstart_date,$current_date);
					if($dates>=1)
					{
					for($i=1; $i<=$dates; $i++)
					{
						
						$thismonthint=0;
						$prvdate=$futureDate;
						$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						
						if($i>$details->period)
						$thismonthint=round(($current_cap*$typedata->default_int)/(12*100),2);
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$balance=$current_cap+$thismonthint - $this_payment;
						$arrayintlist[$i]['date']=$prvdate;
						$arrayintlist[$i]['int']=$thismonthint;
						$arrayintlist[$i]['payment']=$this_payment;
						$arrayintlist[$i]['balance']=$balance;
						?>
                        <?
						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
						
					}
					
					}
					else
					{
						$prvdate=$current_date;
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$current_cap=$current_cap-$this_payment;
					}
					$lastint=0; 
					if($end_date < $current_date)
					{
						//echo $current_date;
					 $date1=date_create($futureDate);
					 $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
				
					$dates=$diff->format("%a ");
					$lastint=round(($current_cap*$dates*$typedata->default_int)/(12*100*360),2);
					}
					$uptodateint=$thismonthint+$lastint;
					$inttot=$inttot+$lastint;
					$last_bal=$current_cap+$lastint;
					$totint=$inttot;
					$totalout=$last_bal;
					 $delaintot=$inttot*$typedata->delay_int/100;
					 $arieasins=0;
 $delayrentaltot=$totint-$totset->totpaidint;
 ?>  
					  
				<?  }
                $b='';
$b=$b.' <h3> </h3>
                        <table class="table "   border="1"> 
                       <tr  bgcolor="#caf5f7"><th colspan="6"><h2>Loan Details</h2></th></tr>
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> '.$details->first_name .' &nbsp; '.$details->last_name.'</td><th  align="right">NIC Number</th><td>'.$details->id_number .'</td> 
                        
                          <th scope="row">Loan Status</th><td>'.$details->loan_status .'</td>
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td>'.$details->unique_code .'-'.$details->reschdue_sqn .' &nbsp; </td><th  align="right">Article Value</th><td>'.number_format($details->discounted_price,2).'</td> <th  align="right">Contract Date</th><td>'.$details->start_date.'</td>
                         </tr> 
                            <tr class="table-bordered"> 
                        <th scope="row">Monthly Rental</th><td align="right">'.number_format($details->montly_rental,2).' &nbsp; </td><th  >Period</th><td align="right">'.$details->period .'</td> <th  >Interest</th><td align="right">'.$details->interest.'</td>
                         </tr> 
                          <tr class="table-bordered"> 
                        <th scope="row">Capital</th><td  align="right">'.number_format($details->loan_amount,2) .' &nbsp; </td><th  >Total Interest</th><td align="right">'.number_format($totint,2).'</td> <th  >Agreed value</th><td align="right">'.number_format($totint+$details->loan_amount,2) .'</td>
                         </tr>';
                         
                       
					  // print_r($totset);
					   $paidcap=$totset->totpaidcap;
                       if($rebate)
					   {
						   if($totset->totpaidcap>0)
						   $paidcap=$rebate->balance_capital+$totset->totpaidcap;
						   else
						   $paidcap=$rebate->balance_capital;
					   }
					  
                           
                         $b=$b.'  <tr class="table-bordered"> 
                        <th scope="row">Paid Capital</th><td  align="right">'.number_format($paidcap,2) .' &nbsp; </td><th  >Paid Interest</th><td align="right">'.number_format($totset->totpaidint,2) .'</td> <th  >Paid Total</th><td align="right">'.number_format($totset->totpaidint+$totset->totpaidcap,2).'</td>
                         </tr> 
                          <tr class="table-bordered info"> 
                        <th scope="row">Balance Capital</th><td  align="right"> '.number_format($details->loan_amount-$paidcap,2) .' &nbsp; </td><th  >Balance Interest</th><td align="right">'.number_format($totint-$totset->totpaidint,2).'</td> <th  >Balance Total</th><td align="right">'.number_format(($totint+$details->loan_amount)-($totset->totpaidint+$totset->totpaidcap),2).'</td>
                         </tr> ';
                        
                         if($rebate){
                            $b=$b.'<tr class="table-bordered"> 
                        <th scope="row">Settlement Method</th><td  align="right"> Early Settlment </td><th  >Int Release Rate</th><td align="right">'.number_format($rebate->int_paidrate,2) .'</td> <th  >Paid Int on Settlement</th><td align="right">'.number_format($rebate->int_paidamount,2).'</td>
                         </tr>'; 
                        }
						$paidpreentage=($totset->totpaidcap/$details->loan_amount)*100;
							$creditcap=0; $creditint=0; $thisinsalment=NULL;
							$delay=0; $ontime=0; if($paylist){foreach($paylist as $row)
				  {
					  $thisinsalment[$row->ins_id]['ins_cap']=$row->ins_cap;
					  $thisinsalment[$row->ins_id]['ins_int']=$row->ins_int;
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create($row->pay_date);
					  $date3=date_create( date("Y-m-d"));

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a");
					if($date3<$date1)
					{
						$creditcap=$creditcap+$row->cap_amount;
						$creditint=$creditint+$row->int_amount; 
					}
					if($date1< $date2)
					$delay_date=intval($dates)-intval($details->grase_period);
					else
					
					$delay_date=0;
						
					
					if($delay_date >0)
					{
							$delay++;
					
					}
					else
					{
						$ontime++;
					}
					}}
					
							$totpay=$ontime+$delay;
							if($totpay>0)
							$payeve=($ontime/$totpay)*100;
							else $payeve=0;
			$b=$b.'<tr  bgcolor="#f8b0b0"> 
                        <th scope="row">Arrears Rental</th><td>'.number_format($arreascap+$arreasint,2).' &nbsp; </td><th  align="right">Delay Interest</th><td>'.number_format(get_loan_date_di($details->loan_code,date('Y-m-d')),2).'</td> <th  align="right">Arrears Istalments</th><td>'.$arieasins.'</td>
                         </tr> 
                           <tr bgcolor="#b0f8c1"> 
                   <th  >Credit Capital</th><td align="right">'.number_format($creditcap,2).'</td>    <th >Credit Interest</th><td align="right">'.number_format($creditint,2).'</td>  <th scope="row">Credit Balance</th><td align="right"> '.number_format($creditcap+$creditint,2).' &nbsp; </td>
                         </tr> 
                          <tr class="table-bordered danger"> 
                        <th scope="row">Delay Interest  Payments</th><td  align="right">'.number_format($totset->totpaiddi,2).' &nbsp; </td><td colspan="4"></td>
                         </tr> 
                            
                          </tbody></table>';  
                             if($rshceduls){
                            
                            
                             $b=$b.'	<h4>
                                  </h4>
                     		   <table class="table table-bordered"  border="1">   <tr  bgcolor="#caf5f7"><th colspan="8"><h2>Loan Reschedule History</h2></th></tr>
							   
							   <tr  bgcolor="#cfd0d0"><th>Reshedule Date</th><th>Loan Capital</th><th>Paid Capital</th><th>Paid Interest</th><th>Credit Interest</th><th> Initial Rate</th><th>Instalments</th><th>Reshceduled Capital </th></tr>';
                               foreach($rshceduls as $row){
                               
							    $b=$b.'<tr><td>'.$row->resch_date.'</td><td>'.number_format($row->loan_stcap,2).'</td><td>'.number_format($row->loan_paidcap,2).'</td>
                <td>'.number_format($row->loan_paidint ,2) .'</td>
                <td>'.number_format($row->loan_paidcrint ,2).'</td>
                <td>'.number_format($row->loan_previntrate ,2).'</td>
                <td>'.$row->loan_previnstalments.'</td>
                <td>'.number_format($row->new_cap,2).'</td>
                </tr>';
							   
							     }
                               
  $b=$b.' </table>';
                     }
                          
                          $b=$b.'	<h4>
                                     </h4>
                     
 <table class="table table-bordered"  border="1">   <tr><th colspan="10"  bgcolor="#caf5f7"><h2>Payment History</h2></th></tr><tr bgcolor="#cfd0d0"><th>id</th><th>Delay Interest</th><th> Paid Capital</th><th> Paid Interest</th><th> Total Pay Amount</th><th>Balance Capital</th><th> Balance Interest</th><th>Payment Date</th><th>Receipt No </th><th>Receipt Date </th></tr>';
                         $delaintot=0;$inslist=""; $paycap=0; $payint=0;$counter=0;
				  $delayrentaltot=0; $arieasins=0; if($paylistinq){foreach($paylistinq as $row)
				  {$counter++;
					  
					 
						 $delaintot= $delaintot+$row->tot_di;
					// $delaintot= $delaintot+$dalay_int;
					
					   $paycap= $paycap+$row->tot_cap;
					    $payint= $payint+$row->tot_int;
						 $balcap= $details->loan_amount-$paycap;
					  	$balint=$totint-$payint;
					 $totpayment=$row->tot_cap+$row->tot_di+$row->tot_int;
				
               $b=$b.' <tr ><td>'.$counter.'</td>';
               $b=$b.' <td>'.number_format($row->tot_di ,2) .'</td>';
               $b=$b.' <td>'.number_format( $row->tot_cap ,2) .'</td>';
              $b=$b.'  <td>'.number_format($row->tot_int,2) .'</td>';
              $b=$b.'   <td>'.number_format($totpayment,2) .'</td>';
              $b=$b.'   <td>'.number_format($balcap ,2) .'</td>';
		 $b=$b.'     <td>'.number_format($balint ,2) .'</td>';
              $b=$b.'  <td>'.$row->income_date.'</td>';
             $b=$b.'   <td>'.$row->RCT.'</td>';
             $b=$b.'   <td>'.$row->rct_date.'</td>';
                
             $b=$b.'   </tr>';
                
				}}
				$b=$b.'</table>';
                                 
                      
				  
                 
					 
				   if($rebate)
					   {
                       $b=$b.'  <table class="table table-bordered"   border="1">
					   <tr  bgcolor="#caf5f7"><th colspan="8"><h2>Settlement Data</h2></th></tr>
					   <tr   bgcolor="#cfd0d0"><th>Instalment</th><th>Rental</th><th>Due Date</th><th>Delay Interest</th><th> Paid Capital</th><th> Paid Interest</th><th>Balance Capital</th><th> Balance Interest</th><th>Payment Date</th><th>Receipt No </th><th>Additional Discount</th></tr>';
                     $b=$b.'  <tr>';
                     $b=$b.'  <td>Early Settlment</td><td>-</td><td>-</td><td>-</td><td>'.number_format(($rebate->balance_capital - $rebate->new_discount) ,2).'</td>';
                     $b=$b.'  <td>'.number_format($rebate->int_paidamount ,2).'</td>';
                     $b=$b.'  <td>-</td>';
                     $b=$b.'  <td>-</td>';
                     $b=$b.'  <td>'.$rebate->apply_date.'</td>';
                      $b=$b.'  <td>'.$rebate->rct_no.'</td>';
                       $b=$b.'  <td>'.number_format($rebate->new_discount,2).'</td>';
                     $b=$b.'  </tr>';
                       }
                 
                    
                        
                            
                         $b=$b.' </tbody></table> '; 
                               
                        if($details->loan_type=='EPB'){
                        	 $b=$b.' 	<h4></h4>
								<table class="table table-bordered"  border="1">
								 <tr  bgcolor="#caf5f7"><th colspan="8"><h2>Rental Computation</h2></th></tr>
								<tr  bgcolor="#cfd0d0"><th>Instalment Date</th><th>Loan Capital</th><th>This Month Int</th><th>This Month Payment</th><th>Closing bal</th></tr>';

  $futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=date('Y-m-d');
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
					  $date1=date_create($loanstart_date);
					  $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;
					$inttot=0;
					$dates=$diff->format("%m ");
					$thismonthint=0;
					$dates=$dates+1;
					$dates=get_month_count($loanstart_date,$current_date);
for($i=1; $i<=$dates; $i++)
					{
						
						$thismonthint=0;
						$prvdate=$futureDate;
						$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));
						
						if($i>$details->period)
						$thismonthint=round(($current_cap*$typedata->default_int)/(12*100),2);
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						$balance=$current_cap+$thismonthint - $this_payment;
						$arrayintlist[$i]['date']=$prvdate;
						$arrayintlist[$i]['int']=$thismonthint;
						$arrayintlist[$i]['payment']=$this_payment;
						$arrayintlist[$i]['balance']=$balance;
						 $b=$b.'<tr>';
                   $b=$b.  '<td>'.$prvdate.'</td>';
                    $b=$b.  '<td>'.$current_cap.'</td>';
                     $b=$b.  '<td>'.$thismonthint.'</td>';
                     $b=$b.   ' <td>'.$this_payment.'</td>';
                      $b=$b.   ' <td>'.$balance.'</td>';
                    $b=$b.' </tr>';
                      
						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
						
					}

 $b=$b.'</table>';
						   }
						   ob_end_clean();
						  header("Content-type: application/vnd.ms-excel");
							header("Content-Disposition: attachment;Filename=Loan_details.xls");
						  header("Pragma: no-cache");
						  header("Expires: 0");
						  ob_end_clean();
						    
	echo $b;
                   
                