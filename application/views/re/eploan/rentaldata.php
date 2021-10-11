 <script type="text/javascript">

   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 
 function check_this_totals()
 {  
 	var pendingamount=parseFloat(document.getElementById('pendingamount').value);
   var payamoount=parseFloat(document.getElementById('amount').value);
   if(document.getElementById('task_id').value=="")
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select Task'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
  
   if(payamoount>pendingamount)
   {
	    document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Budget Allocation'; 
					 $('#flagchertbtn').click();
					 document.getElementById('amount').value="";
   }
	
	 
 }


function load_subtasklist(id)
{
	 var prj_id= document.getElementById("prj_id").value;
	 if(id!=""){
	 taskid=id.split(",")[0];
	 
	 document.getElementById("pendingamount").value=id.split(",")[1];
	 
						 $('#subtaskdata').delay(1).fadeIn(600);
    					    document.getElementById("subtaskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#subtaskdata" ).load( "<?=base_url()?>common/get_subtask_list/"+taskid+"/"+ prj_id	);
				
	 
	 
		
 }
	 
}


function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}
function calculatetot()
{	var list=document.getElementById('inslist').value;
//alert(list);
	var res2 = list.split(",");
	
	var tot=0;
	var paytot=0;
	
	//var rawmatcount=document.myform.rawmatcount.value;
	
		for(i=0; i< res2.length-1; i++)
	{
		
		totobj=document.getElementById('isselect'+res2[i]);
		
		amount=document.getElementById('raw_val'+res2[i]).value;
		
		if(totobj.checked)
		{
			//alert(totobj);
			tot=parseFloat(tot)+parseFloat(amount);
			
		}
		
	}
   
	if(tot!=0)
	{
	document.getElementById('payment_full').value=parseFloat(tot).toFixed(2);
	}
	else
	{
		document.getElementById('payment').value=0;;

	}
}
function check_value()
{
	var amount=document.getElementById("payment").value;
	var balance=document.getElementById("balance_val").value;
	amount=amount.replace(/\,/g,'');
	document.getElementById("payment").value=amount;
	/*if(parseFloat(amount)>parseFloat(balance))
	{
	  document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Balance Amount'; 
					 $('#flagchertbtn').click();
					 document.getElementById("payment").value="";
	}*/
	if(parseFloat(amount)==0)
	{
		document.getElementById("checkflagmessage").innerHTML='Pay Amount Couldnt Be Zero'; 
					 $('#flagchertbtn').click();
					 document.getElementById("payment").value="";
	}
}

 </script>
 
							<div class="form-body  form-horizontal" >
                              <? $retruncharge=get_pending_return_charge($details->cus_code);
							
							if($retruncharge>0){?>
                             <div class="form-group"><label class="col-sm-3 control-label">Cheque Retrun Charge</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="chqcharge"    name="chqcharge"  value="<?=$retruncharge?>" readonly   data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                        <? }?>
                                   <table class="table"><tr><th>Instalment</th><th>Rental</th><th>Due Date</th><th>Delay Interest</th><th></th><th>Paid Total</th><th>Credit Balance</th><th  style="color:#F30"></th><th>Payment</th></tr>
                         <? $delaintot=0;$inslist="";$tot=0;$thisdelayint=0;$dalay_int=0;
				  $delayrentaltot=0; $arieasins=0; 
				  if($ariastot){
					foreach($ariastot as $row)
				   {
						  $instalment_lastpaydate=get_last_payment_date_current_instalment($row->id);
						   if( $instalment_lastpaydate){
							  $grace=0;
						
								if( $instalment_lastpaydate > $row->deu_date){
									$date1=date_create($instalment_lastpaydate); 
								}else{
									$date1=date_create($row->deu_date);
									 $grace=intval($details->grase_period);
								}						
							$date2=date_create($paydate);
	
							$diff=date_diff($date1,$date2);
							$dates=$diff->format("%a ");
							$delay_date=intval($dates)-$grace;
						  }
											 
						  else
						  {
							  $date1=date_create($row->deu_date);
							  $date2=date_create($paydate);
	
							$diff=date_diff($date1,$date2);
							$dates=$diff->format("%a ");
							$delay_date=intval($dates)-intval($details->grase_period);
						  }
						  $payrental=$row->paid_cap+$row->paid_int;
							if($delay_date >0)
							{
								if($typedata->grace_period_effectto_di=='YES')
								$dates=$dates;
								else
								$dates=$delay_date;
								
								
								$dalay_int=(floatval($row->tot_instalment-$payrental))*floatval($typedata->delay_int)*$dates/(100*30);
							
							
								 $arieasins++;
						
							}
						
							$inslist=$row->id.','.$inslist;
							$delayrentaltot= $delayrentaltot+$row->tot_instalment;
						 	$currentdi=round($dalay_int,2);
							 if($currentdi<0)
						 	 $currentdi=0;
					  		 $delaintot=$delaintot+$currentdi;
							 $thispayment=($row->tot_instalment)-$payrental+$currentdi;
							$tot=$tot+$thispayment;
					// echo $row->tot_payment;
				?>
                            <tr><td><?=$row->instalment?></td><td><?=number_format($row->tot_instalment,2) ?></td><td><?=$row->deu_date?></td><td align="right"><?=number_format($currentdi,2) ?></td><td></td><td><?=number_format($row->tot_payment,2) ?></td><td><input  class="form-control" type="text" readonly name="raw_valtot<?=$row->id?>" id="raw_valtot<?=$row->id?>"  value="<?=number_format($thispayment,2) ?>" />
                            <input  class="form-control" type="hidden" readonly name="raw_val<?=$row->id?>" id="raw_val<?=$row->id?>"  value="<?=$dalay_int+$row->tot_instalment?>" />
                             <input  class="form-control" type="hidden" readonly name="raw_delayint<?=$row->id?>" id="raw_delayint<?=$row->id?>"  value="<?=round($currentdi,2)?>" />
                             <input  class="form-control" type="hidden" readonly name="raw_int<?=$row->id?>" id="raw_int<?=$row->id?>"  value="<?=$row->int_amount?>" />
                                <input  class="form-control" type="hidden" readonly name="raw_intalment<?=$row->id?>" id="raw_intalment<?=$row->id?>"  value="<?=$row->instalment?>" /></td>
                            <td></td>
                                 
                            </tr>
                <?
				  	}}else
					{ if($currentins){
						  $payrental=$currentins->paid_cap+$currentins->paid_int;
					   $thispayment=($currentins->tot_instalment)- $payrental;
					  ?>
                  
                           <tr><td><?=$currentins->instalment?></td><td><?=number_format($currentins->tot_instalment,2) ?></td><td><?=$currentins->deu_date?></td><td>0.00</td><td>0.00</td><td><?=number_format($currentins->tot_payment,2)?></td><td><input  class="form-control" type="text" readonly name="raw_valtot<?=$currentins->id?>" id="raw_valtot<?=$currentins->id?>"  value="<?=number_format( $thispayment,2) ?>" />
                        <input  class="form-control" type="hidden" readonly name="raw_val<?=$currentins->id?>" id="raw_val<?=$currentins->id?>"  value="<?=$thispayment?>" /></td>
                        <input  class="form-control" type="hidden" readonly name="raw_delayint<?=$currentins->id?>" id="raw_delayint<?=$currentins->id?>"  value="0" />
                        <input  class="form-control" type="hidden" readonly name="raw_int<?=$currentins->id?>" id="raw_int<?=$currentins->id?>"  value="<?=$currentins->int_amount?>" />
                        <input  class="form-control" type="hidden" readonly name="raw_intalment<?=$currentins->id?>" id="raw_intalment<?=$currentins->id?>"  value="<?=$currentins->instalment?>" /></td>
        
                        <td></td>
                        </tr>
				 	 <? 	$inslist=$currentins->id.','.$inslist; $tot=$tot+$thispayment;
					  }}
                 	 ?>
                 
                     <tr><th>Total Payment</th><td></td><td></td><td align="right"><?=number_format($delaintot,2)?></td><td></td><td></td>
                     <td><input  class="form-control" type="text" readonly name="payment_full" id="payment_full"  value="<?=number_format($tot,2)?>"  required="required"/></td><td></td><td>
                     <div class="form-group has-feedback"><input  class="form-control number-separator disallowminus" type="text"   name="payment" id="payment"  value=""  required="required" onchange="check_value()"/>
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></td></tr>
             
                        
                            
                          </tbody>
                          <tr><td colspan="3" style="color:#F30"></td>
                          <td  valign="bottom" style=" margin-top:30px;"></td>
                          </tr>
                          </table> 
                          
                          
                          <div class="form-group has-feedback">
                          
                           <label class="col-sm-3 control-label">Total DI</label>
                                    <div class="col-sm-3 has-feedback" >
                                      <input type="text" readonly="readonly" name="total_di_amount" id="total_di_amount" value="<?=number_format($delaintot,2)?>" class="form-control">
                                    </div>
                                      <label class="col-sm-3 control-label"  style="color:#F30">DI Waive Off</label>
                                    <div class="col-sm-3 has-feedback" >
                                      <input type="number" value="0"  <? if( !check_access('waive_off DI')) { ?> readonly="readonly" <? } ?>step="0.01" max="<?=$delaintot?>" min="0" name="wave_off_total" id="wave_off_total" class="form-control"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                    </div>
                          </div> 
                         <input type="hidden" value="<?=$inslist?>" name="inslist" id="inslist" />
                         <?
                         $balance=($details->loan_amount+$totint+$delaintot)-($totset->totpaidcap+$totset->totpaidint);
						 ?>
                          <input type="hidden" value="<?=$balance?>" name="balance_val" id="balance_val"  />
                         
                                   <input  class="form-control" type="hidden" step="0.01" name="totdelayint" id="totdelayint"  value="<?=round($delaintot,2)?>"   required="required"/>
                                   
                         <div class="bottom ">
											
											<div class="form-group validation-grids" style="float:right">
												<button type="submit" class="btn btn-primary disabled" >Make Payment</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                       
                    </div> 
                    
							
 <div class="form-title">
								<h4>Loan Details</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <? $delaintot=0;$tot=0;
				 // print_r($ariastot);
				  $thisdelayint=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create($paydate);

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=($tot+floatval($details->montly_rental))*floatval($details->delay_interest)/(100);
					$thisdelayint=$thisdelayint+$dalay_int;
					  $currentdi=round($dalay_int,2)-$raw->balance_di;
					 if($currentdi<0)
					  $currentdi=0;
					   $delaintot=$delaintot+$currentdi;
					// echo $row->balance_di;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					 $tot=$details->montly_rental+$dalay_int+$tot;
					}
						
				  }}?>
                        <table class="table"> 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td> 
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?> &nbsp; </td><th  align="right">Article Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Amount</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Period</th><td><?=$details->period ?></td> <th  align="right">Interest</th><td><?=$details->interest ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Capital</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Total Interest </th><td><?=number_format($totint,2) ?></td> <th  align="right">Agreed value</th><td><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Monthly Rental</th><td> <?=number_format($details->montly_rental,2)  ?> &nbsp; </td><th  align="right"></th><td></td> <th  align="right"></th><td></td>
                         </tr> 
                          <tr class="warning"> 
                        <th scope="row">Arrears Rental</th><td> <?=number_format($delayrentaltot,2)  ?> &nbsp; </td><th  align="right">Delay Interest</th><td><?=number_format(get_loan_date_di($details->loan_code,date('Y-m-d')),2)?></td> <th  align="right">Arrears Instalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                        
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>
                    