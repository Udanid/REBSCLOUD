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

function loadcurrent_block(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 			    document.getElementById("plandata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#plandata" ).load( "<?=base_url()?>re/reservation/get_advancedata/"+id );
				
					
				
	 
	 
		
 }
 else
 {
	 $('#plandata').delay(1).fadeOut(600);
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
 </script>
 
							<div class="form-body  form-horizontal" >
                                   <table class="table"><tr><th>Instalment</th><th>Rental</th><th>Due Date</th><th>Delay Interest</th><th>Credit Balance</th><th>Total</th><td></td><th>Payment</th></tr>
                         <? $delaintot=0;$inslist="";$tot=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $row)
				  {
					  
					  $date1=date_create($row->deu_date);
					  $date2=date_create(date("Y-m-d"));

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					$delay_date=intval($dates)-intval($details->grase_period);
					$dalay_int=0;
					if($delay_date >0)
					{
						$dalay_int=floatval($details->montly_rental)*floatval($details->delay_interest)*$delay_date/(100*360);
						
					 	
					  $arieasins++;
					
					}
					$inslist=$row->id.','.$inslist;
					 $delayrentaltot= $delayrentaltot+$details->montly_rental;
					 $delaintot= $delaintot+$dalay_int;
					 $tot=$details->montly_rental+$dalay_int+$tot;
					 $thispayment=($details->montly_rental+$dalay_int+$row->balance_di)-$row->tot_payment;
					// echo $row->tot_payment;
				?>
                <tr><td><?=$row->instalment?></td><td><?=number_format($row->tot_instalment,2) ?></td><td><?=$row->deu_date?></td><td><?=number_format($dalay_int,2) ?></td><td><input  class="form-control" type="text" readonly="readonly" name="raw_valtot<?=$row->id?>" id="raw_valtot<?=$row->id?>"  value="<?=number_format($thispayment,2) ?>" />
                <input  class="form-control" type="hidden" readonly="readonly" name="raw_val<?=$row->id?>" id="raw_val<?=$row->id?>"  value="<?=$dalay_int+$row->tot_instalment?>" />
                 <input  class="form-control" type="hidden" readonly="readonly" name="raw_delayint<?=$row->id?>" id="raw_delayint<?=$row->id?>"  value="<?=$dalay_int?>" />
                 <input  class="form-control" type="hidden" readonly="readonly" name="raw_int<?=$row->id?>" id="raw_int<?=$row->id?>"  value="<?=$row->int_amount?>" />
                    <input  class="form-control" type="hidden" readonly="readonly" name="raw_intalment<?=$row->id?>" id="raw_intalment<?=$row->id?>"  value="<?=$row->instalment?>" /></td>
                <td><input type="checkbox"  value="YES" name="isselect<?=$row->id?>"  id="isselect<?=$row->id?>"  onclick="calculatetot()"></td>
                     
                </tr>
                <?
				  }}else{ if($currentins){
					   $thispayment=($currentins->tot_instalment+$currentins->balance_di)-$currentins->tot_payment;
					  ?>
                  
                   <tr><td><?=$currentins->instalment?></td><td><?=number_format($currentins->tot_instalment,2) ?></td><td><?=$currentins->deu_date?></td><td>0.00</td><td><?=number_format($currentins->tot_payment,2)?></td><td><input  class="form-control" type="text" readonly="readonly" name="raw_valtot<?=$currentins->id?>" id="raw_valtot<?=$currentins->id?>"  value="<?=number_format( $thispayment,2) ?>" />
                <input  class="form-control" type="hidden" readonly="readonly" name="raw_val<?=$currentins->id?>" id="raw_val<?=$currentins->id?>"  value="<?=$thispayment?>" /></td>
                <input  class="form-control" type="hidden" readonly="readonly" name="raw_delayint<?=$currentins->id?>" id="raw_delayint<?=$currentins->id?>"  value="0" />
                 <input  class="form-control" type="hidden" readonly="readonly" name="raw_int<?=$currentins->id?>" id="raw_int<?=$currentins->id?>"  value="<?=$currentins->int_amount?>" />
                    <input  class="form-control" type="hidden" readonly="readonly" name="raw_intalment<?=$currentins->id?>" id="raw_intalment<?=$currentins->id?>"  value="<?=$currentins->instalment?>" /></td>

                <td><input type="checkbox"  value="YES" name="isselect<?=$currentins->id?>"  id="isselect<?=$currentins->id?>"  onclick="calculatetot()"></td>
                </tr>
				  <? 	$inslist=$currentins->id.','.$inslist; $tot=$tot+$thispayment;
				  }}
                  ?>
                 
                     <tr><th>Total payment</th><td></td><td></td><td></td><td></td>
                     <td><input  class="form-control" type="text" readonly="readonly" name="payment_full" id="payment_full"  value="<?=number_format($tot,2)?>"  required="required"/></td><td></td><td>
                     <div class="form-group has-feedback"><input  class="form-control" type="text"  name="payment" id="payment"  value=""  required="required"/>
                     <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></td></tr>
             
                        
                            
                          </tbody></table>  
                         <input type="hidden" value="<?=$inslist?>" name="inslist" id="inslist" />
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
                  
                  <? $delaintot=0;
				  $delayrentaltot=0; $arieasins=0; if($ariastot){foreach($ariastot as $raw)
				  {
					  
					  $date1=date_create($raw->deu_date);
					  $date2=date_create(date("Y-m-d"));

					$diff=date_diff($date1,$date2);
					$dates=$diff->format("%a ");
					$delay_date=intval($dates)-intval($details->grase_period);
					if($delay_date >0)
					{
					$dalay_int=floatval($details->montly_rental)*floatval($details->delay_interest)*$delay_date/(100*360);
					 $delaintot= $delaintot+$dalay_int;
					  $delayrentaltot= $delayrentaltot+$details->montly_rental;
					  $arieasins++;
					
					}
						
				  }}?>
                        <table class="table"> 
                       
                        <tbody> <tr> 
                        <th scope="row">Customer Name</th><td> <?=$details->first_name ?> &nbsp; <?=$details->last_name ?></td><th  align="right">Nic Number</th><td><?=$details->id_number ?></td> 
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Number</th><td> <?=$details->loan_code ?> &nbsp; </td><th  align="right">Artical Value</th><td><?=number_format($details->discounted_price,2) ?></td> <th  align="right">Contract Date</th><td><?=$details->start_date ?></td>
                         </tr> 
                          <tr> 
                        <th scope="row">Loan Amount</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Period</th><td><?=$details->period ?></td> <th  align="right">Interest</th><td><?=$details->interest ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Capital</th><td> <?=number_format($details->loan_amount,2)  ?> &nbsp; </td><th  align="right">Total Interest</th><td><?=number_format($totint,2) ?></td> <th  align="right">Agreed value</th><td><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr> 
                           <tr> 
                        <th scope="row">Monthly Rental</th><td> <?=number_format($details->montly_rental,2)  ?> &nbsp; </td><th  align="right">Total Interest</th><td><?=number_format($totint,2) ?></td> <th  align="right">Agreed value</th><td><?=number_format($totint+$details->loan_amount,2)  ?></td>
                         </tr> 
                          <tr class="warning"> 
                        <th scope="row">Arrias Rental</th><td> <?=number_format($delayrentaltot,2)  ?> &nbsp; </td><th  align="right">Delay Interest</th><td><?=number_format($delaintot,2) ?></td> <th  align="right">Arreas Istalments</th><td><?=$arieasins  ?></td>
                         </tr> 
                        
                            
                          </tbody></table>  
                          
                    </div>  
                   	
							</div>
                    