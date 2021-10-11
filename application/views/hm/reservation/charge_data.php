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




function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}
function load_realvalues()
{
	
	var stamp= document.getElementById("stamp_duty_val").value;
	document.getElementById("stamp_duty").value=stamp.replace(",", "");
	var leagal_fee= document.getElementById("leagal_fee_val").value;
	document.getElementById("leagal_fee").value=leagal_fee.replace(",", "");
	var document_fee= document.getElementById("document_fee_val").value;
	document.getElementById("document_fee").value=document_fee.replace(",", "");
	var other_charges= document.getElementById("other_charges_val").value;
	document.getElementById("other_charges").value=other_charges.replace(",", "");
	var other_charges2= document.getElementById("other_charges2_val").value;
	document.getElementById("other_charge2").value=other_charges2.replace(",", "");
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
								$other_charges2=$charge_data->other_charge2;
							} else{
								$status='Insert';
								$document_fee=0;
								$stamp_duty=(get_rate('Stamp Fee')*$resdata->discounted_price/100)-1000;
								$leagal_fee=(get_rate('Legal Fee')*$resdata->discounted_price/100);
								$other_charges=0;
								$other_charges2=0;
                            }
							$paiddoc=0; $padilegal=0; $paidstamp=0;$paidothercharge=0;$paidothercharge2=0;
							if($charge_payment){
							foreach($charge_payment as $raw)
							{
								if($raw->chage_type=='leagal_fee')
								$padilegal=$padilegal+$raw->pay_amount ;
								if($raw->chage_type=='stamp_duty')
								$paidstamp=$paidstamp+$raw->pay_amount ;
								if($raw->chage_type=='document_fee')
								$paiddoc=$paiddoc+$raw->pay_amount ;
								$paidothercharge=$paidothercharge+$raw->pay_amount ;
								if($raw->chage_type=='other_charges')
								$paidothercharge=$paidothercharge+$raw->pay_amount ;
								if($raw->chage_type=='other_charge2')
								$paidothercharge2=$paidothercharge2+$raw->pay_amount ;
							}
							}
							?><input type="hidden" class="form-control"   id="stamp_duty"  value="<?=$stamp_duty?>" name="stamp_duty"required>
                            <input type="hidden" class="form-control"   id="leagal_fee"  value="<?=$leagal_fee?>" name="leagal_fee"required>
                            <input type="hidden" class="form-control"   id="document_fee"  value="<?=$document_fee?>" name="document_fee" required>
                                <input type="hidden" class="form-control"   id="other_charges"  value="<?=$other_charges?>" name="other_charges" required>
                            <input type="hidden" class="form-control"   id="other_charge2"  value="<?=$other_charges2?>" name="other_charge2" required>
                         
                                    <div class="form-group  "><label class="col-sm-3 control-label">Stamp Fee</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="stamp_duty_val"  onblur="load_realvalues()"  value="<?=number_format($stamp_duty,2) ?>" name="stamp_duty_val" <? if($paidstamp>0){?>  readonly="readonly"<? }?> required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Deed Fees</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="leagal_fee_val" onblur="load_realvalues()"   name="leagal_fee_val"  data-error=""    value="<?=number_format($leagal_fee,2) ?>"  <? if($padilegal>0){?>  readonly="readonly"<? }?>required>
										</div></div>
									 
                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Document Fee</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text"  onblur="load_realvalues()" class="form-control" id="document_fee_val"    name="document_fee_val"  value="<?=number_format($document_fee,2) ?>"   <? if($paiddoc>0){?>  readonly="readonly"<? }?>  data-error=""   required="required" >
										</div>
                                        <label class="col-sm-3 control-label">Plan Copy Fees</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="other_charges_val"  onblur="load_realvalues()"  value="<?=number_format($other_charges,2) ?>" name="other_charges_val" <? if($paidothercharge>0){?>  readonly="readonly"<? }?> required>
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> </div>
                                        
                                          <div class="form-group ">
									  <label class="col-sm-3 control-label" >Plan Aproval Fees</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="other_charges2_val" onblur="load_realvalues()"   name="other_charges2_val"  data-error=""    value="<?=number_format($other_charges2,2) ?>"  <? if($paidothercharge2>0){?>  readonly="readonly"<? }?>required>
										
                                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> 
                                     
										<div class="col-sm-3 has-feedback"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()"><?=$status?></button>
											</div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>
                                      
                                   
                                          <div class="form-group validation-grids " style="float:right">
												
												
											
										</div>
								
							</div>
                    <div class="form-title">
								<h4>Reservation Charge Payment History</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Charge Type </th><th>Amount</th><th>Receipt No</th> <th>Status </th></tr> </thead>
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