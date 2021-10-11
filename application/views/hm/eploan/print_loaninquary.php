<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<style type="text/css">
body{width:70%;
font-size:90%;
}
.row{
	font-size:80%;
}
.table{
	font-size:100%;
}
</style>
<script type="text/javascript">

function print_function()
{
	window.print() ;
	window.close();
}
</script>
<body onLoad="print_function()">
<div class="form-title">
								<h4>Loan Details</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <?
				  if($details->loan_type!='EPB'){
				  
				   $delaintot=0;$thisdelayint=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));

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
					$dates=$dates+1;
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
					  
				<?  }?>
                 <h3> </h3>
                        <table class="table " > 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td> 
                        
                          <th scope="row">Loan Status</th><td> <?=$details->loan_status ?> </td>
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?>-<?=$details->reschdue_sqn ?> &nbsp; </td><th  align="right">Artical Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                            <tr class="table-bordered"> 
                        <th scope="row">Monthly Rental</th><td align="right"> <?=number_format($details->montly_rental,2)  ?> &nbsp; </td><th  >Period</th><td align="right"> <?=$details->period ?></td> <th  >Interest</th><td align="right"><?=$details->interest ?></td>
                         </tr> 
                          <tr class="table-bordered"> 
                        <th scope="row">Capital</th><td  align="right"> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  >Total Interest</th><td align="right"><?=number_format($totint,2) ?></td> <th  >Agreed value</th><td align="right"><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr>
                         
                       <?
					  // print_r($totset);
					   $paidcap=$totset->totpaidcap;
                       if($rebate)
					   {
						   if($totset->totpaidcap>0)
						   $paidcap=$rebate->balance_capital+$totset->totpaidcap;
						   else
						   $paidcap=$rebate->balance_capital;
					   }
					   ?>
                           
                           <tr class="table-bordered"> 
                        <th scope="row">Paid Capital</th><td  align="right"> <?=number_format($paidcap,2)  ?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($totset->totpaidint,2) ?></td> <th  >Paid Total</th><td align="right"><?=number_format($totset->totpaidint+$totset->totpaidcap,2)  ?></td>
                         </tr> 
                          <tr class="table-bordered info"> 
                        <th scope="row">Balance Capital</th><td  align="right"> <?=number_format($details->loan_amount-$paidcap,2)  ?> &nbsp; </td><th  >Balance Interest</th><td align="right"><?=number_format($totint-$totset->totpaidint,2) ?></td> <th  >Balance Total</th><td align="right"><?=number_format(($totint+$details->loan_amount)-($totset->totpaidint+$totset->totpaidcap),2)  ?></td>
                         </tr> 
                        
                         <?  if($rebate){?>
                            <tr class="table-bordered"> 
                        <th scope="row">Settlement Method</th><td  align="right"> Early Settlment </td><th  >Int Release Rate</th><td align="right"><?=number_format($rebate->int_paidrate,2) ?></td> <th  >Paid Int on Settlement</th><td align="right"><?=number_format($rebate->int_paidamount,2)  ?></td>
                         </tr> 
                       <? }?>
                            <? 
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
							?>
                            <? if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='green'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='green'; else $class='green';?>
<tr><th>Paid percentage </th><td> <div class="task-info">
									<span class="task-desc">Paid percentage</span><span class="percentage"><?=number_format($paidpreentage,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$paidpreentage?>%;"></div>
									</div></td><td></td>
                                      <? if($payeve>=60) $class='green'; else if($payeve<60 && $payeve>=50)  $class='blue'; else if($payeve<50 && $payeve>=25)  $class='yellow'; else $class='red';?>
                                    <th>Payment Evaluation </th><td> <div class="task-info">
									<span class="task-desc">Ontime Payments</span><span class="percentage"><?=number_format($payeve,2)?>%</span>
 									   <div class="clearfix"></div>	
									</div>
									<div class="progress progress-striped active">
										 <div class="bar <?=$class?>" style="width:<?=$payeve?>%;"></div>
									</div></td>
                                    
                                    
                                    </tr>
                          <tr class="warning"> 
                        <th scope="row">Arrias Rental</th><td> <?=number_format($delayrentaltot,2)  ?> &nbsp; </td><th  align="right">Delay Interest</th><td><?=number_format($delaintot,2) ?></td> <th  align="right">Arreas Istalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                           <tr class="success"> 
                   <th  >Credit Capital</th><td align="right"><?=number_format($creditcap,2) ?></td>    <th >Credit Interest</th><td align="right"><?=number_format($creditint,2) ?></td>  <th scope="row">Credit Balance</th><td align="right"> <?=number_format($creditcap+$creditint,2)  ?> &nbsp; </td>
                         </tr> 
                          <tr class="table-bordered danger"> 
                        <th scope="row">Delay Interest  Payments</th><td  align="right"> <?=number_format($totset->totpaiddi,2)  ?> &nbsp; </td><td colspan="4"></td>
                         </tr> 
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>  
                            <? if($rshceduls){?>
                            
                            
                             <div class="form-title">
								<h4>Loan Reschedule History
                                  </h4>
                     		</div>
                            	<div class="form-body  form-horizontal" >
                               <table class="table table-bordered"><tr><th>Reshedule Date</th><th>Loan Capital</th><th>Paid Capital</th><th>Paid Interest</th><th> Initial Rate</th><th>Instalments</th><th>Reshceduled Capital </th></tr>
                               <?  foreach($rshceduls as $row){?>
                               
							    <tr><td><?=$row->resch_date?></td><td><?=number_format($row->loan_stcap,2) ?></td><td><?=number_format($row->loan_paidcap,2) ?></td>
                <td><?=number_format($row->loan_paidint ,2) ?></td>
                <td><?=number_format($row->loan_previntrate ,2) ?></td>
                <td><?=$row->loan_previnstalments?></td>
                <td><?=number_format($row->new_cap,2)?></td>
                </tr>
							   
							   <?  }?>
                               
   </table>
   </div>
                            <? }?>
                          
                             <div class="form-title">
								<h4>Payment History
                                     </h4>
            
							</div>
                            	<div class="form-body  form-horizontal" >
                             

                                   <table class="table table-bordered"><tr><th>Instalment</th><th>Rental</th><th>Due Date</th><th>Delay Interest</th><th> Paid Capital</th><th> Paid Interest</th><th>Balance Capital</th><th> Balance Interest</th><th>Payment Date</th><th>Receipt No </th></tr>
                         <? $delaintot=0;$inslist=""; $paycap=0; $payint=0;
				  $delayrentaltot=0; $arieasins=0; if($paylist){foreach($paylist as $row)
				  {
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create($row->pay_date);

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date1< $date2)
					$delay_date=intval($dates)-intval($details->grase_period);
					else
					$delay_date=0;
					$dalay_int=0;
					$class="";
					
					if($delay_date >0)
					{
						$class='danger';
					
					}
						 $delayrentaltot= $delayrentaltot+$details->montly_rental;
					 $delaintot= $delaintot+$dalay_int;
					
					   $paycap= $paycap+$row->cap_amount;
					    $payint= $payint+$row->int_amount;
						 $thisinsalment[$row->ins_id]['ins_cap']= $details->loan_amount-$paycap;
					  $thisinsalment[$row->ins_id]['ins_int']=$totint-$payint;
					 
				?>
                <tr class="<?=$class?>"><td><?=$row->instalment?></td><td><?=number_format($row->tot_instalment,2) ?></td>
                <td><?=$row->deu_date?></td>
                <td><?=number_format($row->di_amount ,2) ?></td>
                <td><?=number_format($row->cap_amount ,2) ?></td>
                <td><?=number_format($row->int_amount ,2) ?></td>
                 <td><?=number_format($thisinsalment[$row->ins_id]['ins_cap'] ,2) ?></td>
                  <td><?=number_format($thisinsalment[$row->ins_id]['ins_int'] ,2) ?></td>
                <td><?=$row->pay_date?></td>
                <td><?=$row->RCT?></td>
                
                </tr>
                <?
				  }}
				  
				   if($rebate)
					   {?>
                       <tr>
                       <td>Early Settlment</td><td>-</td><td>-</td><td>-</td><td><?=number_format($rebate->balance_capital ,2) ?></td>
                       <td><?=number_format($rebate->int_paidamount ,2) ?></td>
                       <td><?=$rebate->apply_date?></td>
                        <td><?=$rebate->rct_no?></td>
                       </tr>
                       <? }?>
                 
                    
                        
                            
                          </tbody></table>  
                         </div> <div class="form-body  form-horizontal" >
                             
                         <?  if($details->loan_type=='EPB'){?>
                          <div class="form-title">
								<h4>Rental Computation</h4>
							</div>
                         	<table class="table table-bordered"><tr><th>Instalment Date</th><th>Loan Capital</th><th>This Month Int</th><th>This Month Payment</th><th>Closing bal</th></tr>
<?
 $futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=date('Y-m-d');
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
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
                   
    </div>                