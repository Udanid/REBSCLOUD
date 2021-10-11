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
function load_realvalues()
{
	// alert('sss');
	var stamp= document.getElementById("stamp_duty_val").value;
	
	document.getElementById("stamp_duty").value=stamp.replace(",", "");
	
	var leagal_fee= document.getElementById("leagal_fee_val").value;
		
	document.getElementById("leagal_fee").value=leagal_fee.replace(",", "");
	var document_fee= document.getElementById("document_fee_val").value;

	document.getElementById("document_fee").value=document_fee.replace(",", "");
		var other_charges= document.getElementById("other_charges_val").value;
	document.getElementById("other_charges").value=other_charges.replace(",", "");
		var other_charge2= document.getElementById("other_charge2_val").value;
	document.getElementById("other_charge2").value=other_charge2.replace(",", "");
		 stamp=stamp.replace(",", "");
	  leagal_fee=leagal_fee.replace(",", "");
	  document_fee=document_fee.replace(",", "");
	  other_charges=other_charges.replace(",", "");
	  other_charge2=other_charge2.replace(",", "");
	  
	  var total=parseFloat(stamp)+parseFloat(leagal_fee)+parseFloat(document_fee)+parseFloat(other_charges)+parseFloat(other_charge2);
	
	  
	  document.getElementById("pay_amount_val").value=parseFloat(total).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	    document.getElementById("pay_amount").value=parseFloat(total);
		if(parseFloat(total)<=0)
			 document.getElementById("pay_amount_val").value="";
		
			
}
 </script>
 
 
 <div class="form-title">
								<h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                </h4>
							</div>
							<div class="form-body  form-horizontal" >
                           <? if($charge_data){
								$status='Update';
								$document_fee=$charge_data->document_fee;
								$leagal_fee=$charge_data->leagal_fee;
								$stamp_duty=$charge_data->stamp_duty;
								$other_charges=$charge_data->other_charges;
								$other_charge2=$charge_data->other_charge2;
								//$other_charges=$charge_data->other_charges;
							} else{
								$status='Insert';
								$document_fee=0;
								$stamp_duty=(get_rate('Stamp Fee')*$resdata->discounted_price/100)-1000;
								$leagal_fee=(get_rate('Legal Fee')*$resdata->discounted_price/100);
								$other_charges=0;
								$other_charge2=0;
							
                            }
							$paiddoc=0; $padilegal=0; $paidstamp=0; $paiddeed=0; $paid_other_charge2=0; $paid_other_charges=0;$paidplancopy=0;
							if($charge_payment){
							foreach($charge_payment as $raw)
							{
								if($raw->chage_type=='leagal_fee')
								$padilegal=$padilegal+$raw->pay_amount ;
								if($raw->chage_type=='stamp_duty')
								$paidstamp=$paidstamp+$raw->pay_amount ;
								if($raw->chage_type=='document_fee')
								$paiddoc=$paiddoc+$raw->pay_amount ;
									if($raw->chage_type=='other_charges')
								$paid_other_charges=$paid_other_charges+$raw->pay_amount ;
									if($raw->chage_type=='other_charge2')
								$paid_other_charge2=$paid_other_charge2+$raw->pay_amount ;
								
							}
							}$totalpaybel=0;
							
							?> <table class="table"><tr><th>Charge Type</th><th>Payable Amount</th><th>Paid Amount</th><th>Current payment</th></tr>
                      <tr><td>Stamp Duty </td>
                      <td><input type="text" class="form-control"   id="stamp_duty_tot"    value="<?=number_format($stamp_duty,2) ?>" name="stamp_duty_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="stamp_duty_paid"   name="stamp_duty_paid"  data-error=""    value="<?=number_format($paidstamp,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$stamp_duty-$paidstamp;
					   $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control" id="stamp_duty_val"   name="stamp_duty_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()">
                                    <input type="hidden" class="form-control"   id="stamp_duty"  value="<?=$balance?>" name="stamp_duty"required></td>
                       <td> </td>
                      </tr>     
                        <tr><td>Leegal Fee </td>
                      <td><input type="text" class="form-control"   id="leagal_fee_tot"    value="<?=number_format($leagal_fee,2) ?>" name="leagal_fee_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="leagal_fee_paid"   name="leagal_fee_paid"  data-error=""    value="<?=number_format($padilegal,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$leagal_fee-$padilegal;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control" id="leagal_fee_val"   name="leagal_fee_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"> <input type="hidden" class="form-control"   id="leagal_fee"  value="<?=$balance?>" name="leagal_fee"required></td>
                       <td> </td>
                      </tr>      
                               <tr><td>Plan Coppy Fee </td>
                      <td><input type="text" class="form-control"   id="other_charges_tot"    value="<?=number_format($other_charges,2) ?>" name="other_charges_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="other_charges_paid"   name="other_charges_paid"  data-error=""    value="<?=number_format($paid_other_charges,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$other_charges-$paid_other_charges;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control" id="other_charges_val"   name="other_charges_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"> <input type="hidden" class="form-control"   id="other_charges"  value="<?=$balance?>" name="other_charges" required></td>
                       <td> </td>
                      </tr>   
                         
                        <tr><td>Plan Aproval </td>
                      <td><input type="text" class="form-control"   id="other_charge2_tot"    value="<?=number_format($other_charge2,2) ?>" name="other_charge2_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="other_charge2_paid"   name="other_charge2_paid"  data-error=""    value="<?=number_format($paid_other_charge2,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$other_charge2-$paid_other_charge2;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control" id="other_charge2_val"   name="other_charge2_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"><input type="hidden" class="form-control"   id="other_charge2"  value="<?=$balance?>" name="other_charge2" required></td>
                       <td> </td>
                      </tr>   
                      
                       <tr><td>Documentation Charge</td>
                      <td><input type="text" class="form-control"   id="document_fee_tot"    value="<?=number_format($document_fee,2) ?>" name="plancopy_fee_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="document_fee_paid"   name="document_fee_paid"  data-error=""    value="<?=number_format($paiddoc,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$document_fee-$paiddoc;
					     $totalpaybel=$totalpaybel+$balance;
									?>  <input type="hidden" class="form-control"   id="document_fee"  value="<?=$balance?>" name="document_fee" required><input type="text" class="form-control" id="document_fee_val"   name="document_fee_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"></td>
                       <td> </td>
                      </tr> 
                      <tr><td colspan="3">Total Payment </td><td><div class="has-feedback" ><input  type="text"    class="form-control" id="pay_amount_val"  min="1"   name="pay_amount_val" readonly="readonly"  value="<?=$totalpaybel?>"   data-error=""   required="required"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></td></tr>  
                            
                            </table>    <input type="hidden" class="form-control"  id="pay_amount"   value="<?=$totalpaybel?>" name="pay_amount"    data-error=""  >
                            
                                     <div class="form-group " style="float:right">
									 
										<div class="col-sm-3 has-feedback"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Make Payment</button>
											</div>
                                    
									</div>
                                    
                                   
                                         <br /><br /><br />
							</div>
                    <div class="form-title">
								<h4>Legal Charge Payment History</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th>Amount</th><th>Reciept No</th> <th>Status </th></tr> </thead>
                      <? if($charge_payment){$c=0;
                          foreach($charge_payment as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->chage_dis ?></td><td  align="right"> <?=number_format($row->pay_amount,2)?></td> 
                        <td><?=$row->rct_no?></td>
                        <td><?=$row->status?></td>
                        <td><div id="checherflag">
                          <? if($row->status=='PENDING'){?>
                              <a  href="javascript:call_delete_advance('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          
                    </div>  