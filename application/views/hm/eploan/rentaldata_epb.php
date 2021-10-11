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
  <?
  $futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=$paydate;
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
					  $date1=date_create($loanstart_date);
					  $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;
					$inttot=0;
					$dates=$diff->format("%m ");
					$thismonthint=0;
					$paid_cap=0;
					$paid_di=0;
					$paid_int=0;
					$dates=$dates+1;
					if($totset)
					{
						$paid_cap=$totset->totpaidcap;
						$paid_int=$totset->totpaidint;
						$paid_di=$totset->totpaiddi;
					}
				//	echo $paid_cap;
			//	print_r($paylist);
					//echo $futureDate;
					$lastint=0; 
					/*if($end_date < $current_date)
					{
						//echo $current_date;
					 $date1=date_create($futureDate);
					 $date2=date_create($current_date);
					echo $futureDate;
					$diff=date_diff($date1,$date2);
				
					$datesnew=$diff->format("%a ");
					$lastint=round(($current_cap*$typedata->default_int)/(12*100),2);
					}*/
						$last_bal=$current_cap-$paid_cap;

 ?>
								
			      
				
             <? $totalout=$last_bal;
			  $current_date=$paydate;
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));
 
					  $date1=date_create($end_date);
					  $date2=date_create($current_date);
					  $delay_int=0;
				
				if($end_date<$current_date)
				{		 
				 
				  $diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;
					$inttot=0;
					$dates=$diff->format("%a ");
			// echo  $dates;	
					 $full_di=$delay_int=($dates*$details->loan_amount*$details->interest)/(30*12*100);
				}
			 $delay_int=round($delay_int-$paid_di,2);
			 if( $delay_int<=0)
			 $delay_int=0;
			 $uptodateint=0;
			// echo totset
			 ?>
			 </table>
                               <div class="form-body form-horizontal">
                          
                          <div class="form-group"><label class="col-sm-3 control-label">Total Outstanding</label>
                          <div class="col-sm-3 ">  <input  class="form-control" type="text" readonly="readonly" name="payment_full" id="payment_full"  value="<?=number_format($last_bal,2)?>"  required="required"/></div>
                          <input  class="form-control" type="hidden" readonly="readonly" name="totl_out" id="totl_out"  value="<?=$totalout?>"  required="required"/>
                          <label class="col-sm-3 control-label">Delay Interest</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  class="form-control" type="text"  name="delay_int" id="delay_int"  value="<?=number_format($delay_int,2)?>"  readonly="readonly"/>
                                        <input  class="form-control" type="hidden"  name="delay_int_val" id="delay_int_val"  value="<?=$delay_int?>"  readonly="readonly"/>
                                          <input  class="form-control" type="hidden"  name="int_val" id="int_val"  value="<?=$uptodateint?>"  readonly="readonly"/>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                      
                       
                        
											
											<div class="form-group">
                                             <label class="col-sm-3 control-label">Current Payment</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  class="form-control" type="number" step="0.01" name="payment" id="payment"  value=""   required="required" onchange="check_value()"/>
                              			<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
                                         <? $retruncharge=get_pending_return_charge($details->cus_code);
							
							if($retruncharge>0){?>
                             <div class="form-group"><label class="col-sm-3 control-label">Cheque Retrun Charge</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="chqcharge"    name="chqcharge"  value="<?=$retruncharge?>" readonly="readonly"   data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                        <? }?></div>
                                        <? $currentloanbalance=$delay_int+$last_bal?>
                        <input type="hidden" value="<?=$currentloanbalance?>" name="balance_val" id="balance_val"  />
                          <div class="form-group "<?  if( check_access('waive_off DI')) {?> style="display:block" <? } else{ ?>  style="display:none" <? }?> >
                         <label class="col-sm-3 control-label" style="color:#F30">Wave Off DI</label>
                         <div class="col-sm-3" > <input  class="form-control" type="checkbox" value="Yes" name="divaveoff" id="divaveoff"  style=" margin-top:05px;"/></div></div>
                                           	<div class="col-sm-3 has-feedback" id="paymentdateid" style="float:right"> 
												<button type="submit" class="btn btn-primary disabled" >Make Payment</button>
											</div>
										</div>
										</div>
                       
                    </div> 
                    
							
 <div class="form-title">
								<h4>Loan Details</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                  <? $delaintot=0;
				  $delayrentaltot=0; $arieasins=0; ?>
                        <table class="table"> 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">NIC Number</th><td><?=$details->id_number ?></td> 
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?> &nbsp; </td><th  align="right">Artical Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Amount</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Period</th><td><?=$details->period ?></td> <th  align="right">Interest</th><td><?=$details->interest ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Capital</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Total Interest</th><td><?=number_format($inttot,2) ?></td> <th  align="right">Agreed value</th><td><?=number_format($inttot+$details->loan_amount,2)  ?></td>
                         </tr> 
                         
                          <tr class="warning"> 
                        <th scope="row">Paid Di</th><td> <?=number_format($paid_di,2) ?> </td><th  align="right">Delay Interest</th><td><?=number_format($delay_int,2) ?></td> <th  align="right">Arreas Istalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                        
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>
                    