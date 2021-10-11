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
						?><tr>
                    <td><?=$prvdate?></td>
                     <td><?=$current_cap?></td>
                      <td><?=$thismonthint?></td>
                        <td><?=$this_payment;?></td>
                         <td><?=$balance;?></td>
                    </tr>
                        <?
						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
						
					}?>

</table>
						   <? }?>
