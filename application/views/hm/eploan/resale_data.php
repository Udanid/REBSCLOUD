 <script type="text/javascript">

$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
   

function change_capital(obj)
{
	//alert('ssss')
	obj=obj.replace(/\,/g,'');
	var maxcap =parseFloat(document.getElementById("repay_max").value)
	if(maxcap<obj)
	{
	document.getElementById("pay_refund").value=maxcap;
	document.getElementById("repay_capital").value=maxcap;
	}
	else
	{
		document.getElementById("repay_capital").value=obj;
	}
	var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);
	
	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
	
}
function change_int(obj)
{
	obj=obj.replace(/\,/g,'');
		var paidint=parseFloat(document.getElementById("paid_int").value)
	if(paidint<obj)
	{
	document.getElementById("repay_int").value=0;
	document.getElementById("intrefund").value=0;
	
	}
	else
	{
		document.getElementById("repay_int").value=obj;
		var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);
	
		document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
	
}

function get_loan_detalis(id)
{
	
		// var vendor_no = src.value;
//alert(id);
        
		
					$('#popupform').delay(1).fadeIn(600);
					
					$( "#popupform" ).load( "<?=base_url()?>hm/eploan/get_loanfulldata_popup/"+id );
			
}
function calculete_changevalues()
{
	var nonrefund=document.getElementById("nonrefund").value;
	 nonrefund=nonrefund.replace(/\,/g,'');
	var delayint=document.getElementById("payble_delayint").value;
	 delayint=delayint.replace(/\,/g,'');
	var nonrefund_org=document.getElementById("non_refundval").value;
	var delayint_org=document.getElementById("delay_int").value;
	var pay_refund=document.getElementById("pay_refund").value;
	 pay_refund=pay_refund.replace(/\,/g,'');
	 var newcap=parseFloat(pay_refund)+parseFloat(nonrefund_org)-parseFloat(nonrefund)+parseFloat(delayint_org)-parseFloat(delayint)
	document.getElementById("repay_capital").value=newcap;
	document.getElementById("non_refundval").value=nonrefund;
	document.getElementById("delay_int").value=delayint;
	document.getElementById("pay_refund").value=newcap.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);
	
		document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	
}
 </script>
 
						
                    
							
 <div class="form-title">
								<h4>Loan Details
                                 <span style="float:right; margin-top:-4px;">  <a href="javascript:get_loan_detalis('<?=$details->loan_code?>')"><span class="label label-success">Loan Inquiry</span></a></span>
                                </h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <? $delaintot=0;
				  $delayrentaltot=0; $arieasins=0;$arreascap=0; $arreasint=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));
					   $arreascap=$arreascap+$raw->cap_amount-$raw->paid_cap;
					   $arreasint=$arreasint+$raw->int_amount-$raw->paid_int ;
 					$paidtotals=$raw->paid_cap+$raw->paid_int;
					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					if($date1 >	 $date2)
					$dates=0-($dates);
					$delay_date=intval($dates)-intval($details->grase_period);
					//echo $details->grase_period
					if($delay_date >0)
					{
					$dalay_int=floatval($details->montly_rental-$paidtotals)*floatval($details->delay_interest)*$delay_date/(100*360);
					 $delaintot= $delaintot+$dalay_int;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					
					}
						
				  }}?>
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
                        
                            <? 
							$paidpreentage=($totset->totpaidcap/$details->loan_amount)*100;
							$creditcap=0; $creditint=0;
							$delay=0; $ontime=0; if($paylist){foreach($paylist as $row)
				  {
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create($row->pay_date);
					  $date3=date_create( date("Y-m-d"));
					  $futureDate=date('Y-m-d',strtotime('+1 months',strtotime(date("Y-m-d"))));

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					//echo $futureDate. '-'.$date1;
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
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>  
                         
                           <? 
						   $balanc=$details->loan_amount-$totset->totpaidcap;
						   $balanceit=$totint-($totset->totpaidint-$creditint);
						   $type=$details->loan_type;
						   $payableint=$balanceit*10/100;
						 $credittotal= $creditint;
						 $delaintot=hm_get_loan_date_di($details->loan_code,date('Y-m-d'));
					//	   echo $delaintot;
						   ?>
                            	<div class="form-body  form-horizontal" >
                               <? if($totset->totpaidcap) $totpaidcap=$totset->totpaidcap; else $totpaidcap=0.00;
							   if($totset->totpaidint) $totpaidint=$totset->totpaidint-$creditint; else $totpaidint=0.00; 
							   
							      $totamount=$resdetails->down_payment+$totpaidcap-$resdetails->non_refund-$delaintot+$creditint-$arreasint;?>
                                   <input type="hidden" name="down_payment" id="down_payment" value="<?=$resdetails->down_payment?>"  >
                             <input type="hidden" name="paid_capital" id="paid_capital" value="<?=$totpaidcap?>"  >
                              <input type="hidden" name="balance_int" id="balance_int"value="<?=$balanceit?>"  >
                                <input type="hidden" name="paid_int" id="paid_int"value="<?=$totpaidint?>"  >
                               <input type="hidden"  name="delay_int" id="delay_int"value="<?=$delaintot?>" >
                                <input type="hidden"  name="non_refundval" id="non_refundval"value="<?=$resdetails->non_refund?>" >
                                   <input type="hidden"  name="repay_capital" id="repay_capital"value="<?=$totamount?>" >
                                      <input type="hidden"  name="credit_cap" id="credit_cap"value="<?=$creditcap?>" >
                                   <input type="hidden"  name="credit_int" id="credit_int"value="<?=$creditint?>" >
                                     <input type="hidden"  name="credit_tot" id="credit_tot"value="<?=$credittotal?>" >
                                    <input type="hidden"  name="repay_max" id="repay_max"value="<?=$totamount?>" >
                                     <input type="hidden"  name="repay_int" id="repay_int"value="0.00" >
                                      <input type="hidden"  name="arrears_int" id="arrears_int"value="<?=$arreasint?>" >
                           		<div class="form-group">
                     					<label class="col-sm-3 control-label">Paid Capital</label>
										<div class="col-sm-3"><input type="text" class="form-control" name="capital" id="capital"value="<?=number_format($totpaidcap,2)?>"  required readonly="readonly">
                                      </div>
                                         <label class="col-sm-3 control-label" >Paid Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" name="interest" id="interest"value="<?=number_format($totpaidint,2)?>"  required readonly="readonly">
										</div>
                                       </div>
                                           <div id="loandetails1" > 
									 <div class="form-group">
                                      
                                      <label class="col-sm-3 control-label" >Down Payment</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="text" class="form-control" name="di_amount" id="di_amount"     required value="<?=number_format($resdetails->down_payment,2) ?>"   readonly="readonly">
										</div>
                                     
                                     <label class="col-sm-3 control-label">None Refundable Amount</label>
										<div class="col-sm-3"><input  type="text" class="form-control" name="nonrefund" id="nonrefund" onchange="calculete_changevalues()"      required value="<?=number_format($resdetails->non_refund,2)?>"  >
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
									<label class="col-sm-3 control-label">Delay Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="payble_delayint"    name="payble_delayint"  value="<?=number_format(get_loan_date_di($details->loan_code,date('Y-m-d')),2)?>"    data-error=""  onchange="calculete_changevalues()"      required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Credit Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="credittotal"    name="credittotal"  value="<?=number_format($credittotal,2) ?>"    data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                      
                                     		</div>
                                             <div class="form-group ">
                                               <label class="col-sm-3 control-label">Payment Refund </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="pay_refund" onchange="change_capital(this.value)"    name="total"   value="<?=number_format($totamount,2) ?>"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-sm-3 control-label">Interest Refund</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="intrefund"  onchange="change_int(this.value)"  <? if( check_access('refund Interest')){?> <? }else {?>  readonly="readonly"<? }?> name="intrefund"  value="0.00"    data-error="">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                      
                                     		</div>
                                            <div class="form-group ">
                                              <label class="col-sm-3 control-label">Total Refund </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="total"    name="total"   value="<?=number_format($totamount,2) ?>"    data-error="" required="required" readonly="readonly" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
								       <label class="col-sm-3 control-label">Request  Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate"   value="<?=date('Y-m-d')?>"  data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     		</div>
                                        		
                                               <div class="form-group" >
                                                 <label class="col-sm-3 control-label">Remark</label>
										<div class="col-sm-3 has-feedback"><select name="remark" id="remark"  class="form-control" required="required">
                                          <option  value="">Select Remark </option>
                                        <option  value="Customer Default">Customer Default </option>
                                         <option  value="Title Defect">Title Defect</option>
                                          <option  value="Plan Approval Pending"> Plan Approval Pending</option>
                                             <option  value="Utility Pending">Utility Pending</option>
                                             <option  value="Data Entry Error">Data Entry Error</option>
                                             <option  value="Misleading">Misleading</option>
                                          
                                        
                                        </select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                           <h3> 
                                         		<button type="submit" class="btn btn-primary disabled" >Settle</button></h3>
											</div>
                                             
                                    
                                       <br /><br /><br />
                        
                       
                    </div> 
                    