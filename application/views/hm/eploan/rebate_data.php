 <script type="text/javascript">

$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
   

function calculete_int()
{
	//alert('ssss')
	var balance_int=parseFloat(document.getElementById("balance_int").value);
	
	var n=parseFloat(document.getElementById("int_paidrate").value);
	
	var paid_int=balance_int*(100-n)/100;
	var arrint=parseFloat(document.getElementById("arrears_int").value);
	var currentint=parseFloat(document.getElementById("this_creditint").value);
	paid_int=parseFloat(paid_int)+parseFloat(arrint)+parseFloat(currentint);
	
		var total=paid_int+parseFloat(document.getElementById("balance_capital").value)+parseFloat(document.getElementById("delay_int").value)-parseFloat(document.getElementById("credit_tot").value)
	document.getElementById("payble_int").value=paid_int.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("int_paidamount").value=paid_int;
	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	
}
function adjust_creditint()
{
	var current_creditint=document.getElementById("this_creditint").value;
	var payableint=document.getElementById("int_paidamount").value;
	//credit_tot
	if(current_creditint>=0)
	{
		var balance_int=parseFloat(document.getElementById("balance_int").value);
	
	var n=parseFloat(document.getElementById("int_paidrate").value);
	
	var paid_int=balance_int*(100-n)/100;
	var arrint=parseFloat(document.getElementById("arrears_int").value);
	paid_int=parseFloat(paid_int)+arrint;
			var totint=parseFloat(current_creditint)+parseFloat(paid_int);
		var total=totint+parseFloat(document.getElementById("balance_capital").value)+parseFloat(document.getElementById("delay_int").value)-parseFloat(document.getElementById("credit_tot").value)
	
		document.getElementById("int_paidamount").value=totint;
		document.getElementById("payble_int").value=totint.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
}
function adjust_delayint()
{
		var delayint=document.getElementById("di_amount").value;
		var current_creditint=document.getElementById("this_creditint").value;
	var payableint=document.getElementById("int_paidamount").value;
	var balance_int=parseFloat(document.getElementById("balance_int").value);
	document.getElementById("delay_int").value=parseFloat(delayint);
	var n=parseFloat(document.getElementById("int_paidrate").value);
	
	var paid_int=balance_int*(100-n)/100;
	var arrint=parseFloat(document.getElementById("arrears_int").value);
	paid_int=parseFloat(paid_int)+arrint;
	var totint=parseFloat(current_creditint)+parseFloat(paid_int);
	var total=totint+parseFloat(document.getElementById("balance_capital").value)+parseFloat(document.getElementById("delay_int").value)-parseFloat(document.getElementById("credit_tot").value)
	document.getElementById("payble_int").value=totint.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	document.getElementById("int_paidamount").value=totint;
	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
}

 </script>
 
						
                    
							
 <div class="form-title">
								<h4>Loan Details</h4>
                                <span style="float:right; margin-top:-15px;">  <a href="javascript:get_loan_detalis('<?=$details->loan_code?>')"><span class="label label-success">Loan Inquiry</span></a></span>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <?
				  if($details->loan_type!='EPB'){
				  
				   $delaintot=0;$thisdelayint=0;$arreascap=0; $arreasint=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));
					  $arreascap=$arreascap+$raw->cap_amount-$raw->paid_cap;
					   $arreasint=$arreasint+$raw->int_amount-$raw->paid_int ;
					   $paidtotals=$raw->paid_cap;+$raw->paid_int;
						
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date1 >	 $date2)
					$dates=0-($dates);
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=($thisdelayint+floatval($details->montly_rental-$raw->tot_payment))*floatval($details->delay_interest)/(100);
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
                        <table class="table " > 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td> 
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->unique_code ?> &nbsp; </td><th  align="right">Article Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                            <tr class="table-bordered"> 
                        <th scope="row">Monthly Rental</th><td align="right"> <?=number_format($details->montly_rental,2)  ?> &nbsp; </td><th  >Period</th><td align="right"> <?=$details->period ?></td> <th  >Interest</th><td align="right"><?=$details->interest ?></td>
                         </tr> 
                          <tr class="table-bordered"> 
                        <th scope="row">Capital</th><td  align="right"> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  >Total Interest</th><td align="right"><?=number_format($totint,2) ?></td> <th  >Agreed value</th><td align="right"><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr>
                       
                           
                           <tr class="table-bordered"> 
                        <th scope="row">Paid Capital</th><td  align="right"> <?=number_format($totset->totpaidcap,2)  ?> &nbsp; </td><th  >Paid Interest</th><td align="right"><?=number_format($totset->totpaidint,2) ?></td> <th  >Paid Total</th><td align="right"><?=number_format($totset->totpaidint+$totset->totpaidcap,2)  ?></td>
                         </tr> 
                           <tr class="table-bordered info"> 
                        <th scope="row">Balance Capital</th><td  align="right"> <?=number_format($details->loan_amount-$totset->totpaidcap,2)  ?> &nbsp; </td><th  >Balance Interest</th><td align="right"><?=number_format($totint-$totset->totpaidint,2) ?></td> <th  >Balance Total</th><td align="right"><?=number_format(($totint+$details->loan_amount)-($totset->totpaidint+$totset->totpaidcap),2)  ?></td>
                         </tr> 
                        
                            <? 
							$paidpreentage=($totset->totpaidcap/$details->loan_amount)*100;
							$creditcap=0; $creditint=0;
							$delay=0; $ontime=0; if($paylist){foreach($paylist as $row)
				  {
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create($row->pay_date);
					  $date3=date_create( date("Y-m-d"));

					$diff=date_diff($date1,$date2);
					  $futureDate=date('Y-m-d',strtotime('+1 months',strtotime(date("Y-m-d"))));
					$dates=$diff->format("%a ");
					if($date3<$date1 & $row->deu_date > $futureDate)
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
					$delaintot=hm_get_loan_date_di($details->loan_code,date('Y-m-d'));
							$totpay=$ontime+$delay;
							if($totpay>0)
							$payeve=($ontime/$totpay)*100;
							else $payeve=0;
							?>
                            <? if($paidpreentage>=60) $class='green'; else if($paidpreentage<60 && $paidpreentage>=50)  $class='green'; else if($paidpreentage<50 && $paidpreentage>=25)  $class='green'; else $class='green';?>

                        
                            <tr class="warning"> 
                        <th scope="row">Arrears Capital</th><td> <?=number_format($arreascap,2)  ?> &nbsp; </td><th  align="right">Arrears Interest</th><td><?=number_format($arreasint,2) ?></td> <th  align="right">Arrears Instalments</th><td><?=number_format($arreascap+$arreasint,2)?></td>
                         </tr> 
                              <tr class="success"> 
                       <th >Credit Capital</th><td  align="right"><?=number_format($creditcap,2) ?></td>    <th  >Credit Interest</th><td  align="right"><?=number_format($creditint,2) ?></td>  <th scope="row">Credit Balance</th><td  align="right"> <?=number_format($creditcap+$creditint,2)  ?> &nbsp; </td>
                      </tr> 
                       <tr class="table-bordered danger"> 
                        <th scope="row">Delay Interest  Payments</th><td  align="right"> <?=number_format($totset->totpaiddi,2)  ?> &nbsp; </td><td>Delay Interest</td><td colspan="1"><?=number_format($delaintot,2) ?></td><td></td><td></td>
                         </tr> 
                      
                            
                          </tbody></table>  
                                            </div>  
                   	
							</div>  
                         
                           <?   
		//				   echo $creditint;
						$nextinstalment=hm_get_next_instalmant($details->loan_code,date("Y-m-d"));
						   $thismonthint=0;
						   if($nextinstalment)
						   {
							   $thismonthint=$nextinstalment->int_amount-$nextinstalment->paid_int;
						   }
							if($creditcap<0)
						   $balanc=$details->loan_amount-$totset->totpaidcap - ((-1)*$creditcap); 
						   else
						   $balanc=$details->loan_amount-$totset->totpaidcap;
						   $balanceit=$totint-$totset->totpaidint + $creditint -$arreasint ;
						   $type=$details->loan_type;
						   $payableint=($balanceit*10/100)+$arreasint+$thismonthint;;
						     $credittotal= $creditint;
						   $totamount=$payableint+$delaintot+ $balanc- $credittotal;
					   
						   ?>
                            	<div class="form-body  form-horizontal" >
                               <? if($totset->totpaidcap) $totpaidcap=$totset->totpaidcap ; else $totpaidcap=0.00;
							   if($totset->totpaidint) $totpaidint=$totset->totpaidint ; else $totpaidint=0.00; ?>
                             <input type="hidden" name="balance_capital" id="balance_capital" value="<?=$balanc?>"  >
                              <input type="hidden" name="balance_int" id="balance_int"value="<?=$balanceit?>"  >
                               <input type="hidden"  name="delay_int" id="delay_int"value="<?=$delaintot?>" >
                                 <input type="hidden"  name="credit_cap" id="credit_cap"value="<?=$creditcap?>" >
                                   <input type="hidden"  name="credit_int" id="credit_int"value="<?=$creditint?>" >
                                     <input type="hidden"  name="credit_tot" id="credit_tot"value="<?=$credittotal?>" >
                                   <input type="hidden"  name="int_paidamount" id="int_paidamount"value="<?=$payableint?>" >
                                    <input type="hidden"  name="arrears_int" id="arrears_int"value="<?=$arreasint?>" >
                           		<div class="form-group">
                     					<label class="col-sm-3 control-label">Balance Capital</label>
										<div class="col-sm-3"><input type="text" class="form-control" name="capital" id="capital"value="<?=number_format($balanc,2)?>"  required readonly="readonly">
                                      </div>
                                         <label class="col-sm-3 control-label" >Balance  Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="interest" id="interest"value="<?=number_format($balanceit,2)?>"  required readonly="readonly">
										</div>
                                       </div>
                                           <div id="loandetails1" > 
									 <div class="form-group">
                                        <label class="col-sm-3 control-label">Credit Interest</label> 
										<div class="col-sm-3"><input  type="text" class="form-control" name="credit_payment" id="credit_payment"  value="<?=number_format($credittotal,2)?>"      required readonly="readonly"  >
                                       </div>
                                      <label class="col-sm-3 control-label" >Delay Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="text" class="form-control" name="di_amount" id="di_amount"    onchange="adjust_delayint()"   required value="<?=number_format($delaintot,2) ?>"  >
										</div>
                                     
                                   
                                        
                                      </div>
                                             <!--     <div class="form-group"><label class="col-sm-3 control-label">Sales Officer</label>
			    									<div class="col-sm-3"><select name="collection_officer" id="collection_officer" class="form-control" placeholder="Sales Officer" >
                                    <option value="">Collection officer</option>
                                     < ? foreach ($loan_officer as $raw){?>
                    <option value="< ?=$raw->user_id?>" >< ?=$raw->initial?> &nbsp; < ?=$raw->surname?></option>
                    < ? }?>
        
                                    </select>
  		</div>
                                      </div>-->
                                     <div class="form-group ">
                                       <label class="col-sm-3 control-label">Int Release Percentage</label>
										<div class="col-sm-3"><input  type="number" class="form-control" name="int_paidrate" id="int_paidrate" onchange="calculete_int()"     required value="90"  >
                                       </div>
									<label class="col-sm-3 control-label">Payable Interest Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="payble_int"    name="payble_int"  value="<?=number_format($payableint,2) ?>"    data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                      
                                     		</div>
                                            <div class="form-group ">
                                              <label class="col-sm-3 control-label">This Month  Interest </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="number" step="0.01" class="form-control" id="this_creditint"    name="this_creditint"  onchange="adjust_creditint()"  value="<?=$thismonthint;?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
								       <label class="col-sm-3 control-label">Total Amount Payable </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="total"    name="total"   value="<?=number_format($totamount,2) ?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                            <div class="form-group ">
                                            
								       <label class="col-sm-3 control-label">Settlement Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                        		
                                               <div class="form-group" style="float:right; margin-right:10px;">
                                           <h3> 
                                         		<button type="submit" class="btn btn-primary disabled" >Settle</button></h3>
											</div>
                                             
                                    
                                       <br /><br /><br />
                        
                       
                    </div> 
                    