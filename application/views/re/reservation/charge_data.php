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
	//Ticket No:2739 Added By Madushan 2021.05.03 Get already paid values
	var paid_stamp= document.getElementById("paid_stamp_duty").value;
	var paid_leagal_fee= document.getElementById("paid_leagal_fee").value;
	var paid_document_fee= document.getElementById("paid_document_fee").value;
	var paid_other_charges= document.getElementById("paid_other_charges").value;
	var paid_other_charges2= document.getElementById("paid_other_charge2").value;
	var paid_opinion_fee= document.getElementById("paid_opinion_fee").value;
	var paid_document_charge= document.getElementById("paid_document_charge").value;
	var paid_ep_document_charge= document.getElementById("paid_ep_document_chargers").value;

	//Ticket No:2739 Added By Madushan 2021.05.03 Get previous values
	var stamp_duty_old= document.getElementById("stamp_duty_old").value;
	var leagal_fee_old= document.getElementById("leagal_fee_old").value;
	var document_fee_old= document.getElementById("document_fee_old").value;
	var other_charges_old= document.getElementById("other_charges_old").value;
	var other_charge2_old= document.getElementById("other_charge2_old").value;
	var opinion_fee_old= document.getElementById("opinion_fee_old").value;
	var document_charge_old= document.getElementById("document_charge_old").value;
	var ep_document_chargers_old= document.getElementById("ep_document_chargers_old").value;
	
	//Get new values
	var stamp= document.getElementById("stamp_duty_val").value;
	var leagal_fee= document.getElementById("leagal_fee_val").value;
	var document_fee= document.getElementById("document_fee_val").value;
	var other_charges= document.getElementById("other_charges_val").value;
	var other_charges2= document.getElementById("other_charges2_val").value;
	var opinion_fee= document.getElementById("opinion_fee_val").value;
	var document_charge= document.getElementById("document_chargers_val").value;
	var ep_document_charge= document.getElementById("ep_document_val").value;
	

	//Ticket No:2739 Added By Madushan 2021.05.03 Check if the new value lower than paid value
	if(parseFloat(paid_stamp) > parseFloat(stamp.replace(",", "")))
	{
		alert('Value must be greater than '+paid_stamp);
		document.getElementById("stamp_duty_val").value=stamp_duty_old;
		var stamp= document.getElementById("stamp_duty_val").value;

	}

	
	if(parseFloat(paid_leagal_fee) > parseFloat(leagal_fee.replace(",", "")))
	{
		alert('Value must be greater than '+paid_leagal_fee);
		document.getElementById("leagal_fee_val").value=leagal_fee_old;
		var leagal_fee= document.getElementById("leagal_fee_val").value;

	}
	

	if(parseFloat(paid_document_fee) > parseFloat(document_fee.replace(",", "")))
	{
		alert('Value must be greater than '+paid_document_fee);
		document.getElementById("document_fee_val").value=document_fee_old;
		var document_fee= document.getElementById("document_fee_val").value;

	}

	if(parseFloat(paid_other_charges) > parseFloat(other_charges.replace(",", "")))
	{
		alert('Value must be greater than '+paid_other_charges);
		document.getElementById("other_charges_val").value=other_charges_old;
		var other_charges= document.getElementById("other_charges_val").value;

	}

	if(parseFloat(paid_other_charges2) > parseFloat(other_charges2.replace(",", "")))
	{
		alert('Value must be greater than '+paid_other_charges2);
		document.getElementById("other_charges2_val").value=other_charge2_old;
		var other_charges2= document.getElementById("other_charges2_val").value;

	}

	if(parseFloat(paid_opinion_fee) > parseFloat(opinion_fee.replace(",", "")))
	{
		alert('Value must be greater than '+paid_opinion_fee);
		document.getElementById("opinion_fee_val").value=opinion_fee_old;
		var opinion_fee= document.getElementById("opinion_fee_val").value;

	}

	if(parseFloat(paid_document_charge) > parseFloat(document_charge.replace(",", "")))
	{
		alert('Value must be greater than '+paid_document_charge);
		document.getElementById("document_chargers_val").value=document_charge_old;
		var document_charge= document.getElementById("document_chargers_val").value;

	}

	if(parseFloat(paid_ep_document_charge) > parseFloat(ep_document_charge.replace(",", "")))
	{
		alert('Value must be greater than '+paid_ep_document_charge);
		document.getElementById("ep_document_val").value=ep_document_chargers_old;
		var ep_document_charge= document.getElementById("ep_document_val").value;

	}

	//Set Values to post
	document.getElementById("stamp_duty").value=stamp.replace(",", "");
	document.getElementById("leagal_fee").value=leagal_fee.replace(",", "");
	document.getElementById("document_fee").value=document_fee.replace(",", "");
	document.getElementById("other_charges").value=other_charges.replace(",", "");
	document.getElementById("other_charge2").value=other_charges2.replace(",", "");
	document.getElementById("opinion_fee").value=opinion_fee.replace(",", "");
	document.getElementById("document_charge").value=document_charge.replace(",", "");
	document.getElementById("ep_document_chargers").value=ep_document_charge.replace(",", "");
	
	
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
								$document_charge=$charge_data->document_chargers;
								$ep_document_charge=$charge_data->ep_document_chargers;
								$leagal_fee=$charge_data->leagal_fee;
								$stamp_duty=$charge_data->stamp_duty;
								$other_charges=$charge_data->other_charges;
								$other_charges2=$charge_data->other_charge2;
								$opinion_fee=$charge_data->opinion_fee;
							} else{
								$status='Insert';
								$document_fee=0;
								$document_charge=0;
								$ep_document_charge=0;
								$stamp_duty=(get_rate('Stamp Fee')*$resdata->discounted_price/100)-1000;
								$leagal_fee=(get_rate('Legal Fee')*$resdata->discounted_price/100);
								$other_charges=0;
								$other_charges2=1000;
								$opinion_fee=0;
                            }
							$paiddoc=0; $padilegal=0; $paidstamp=0;$paidothercharge=0;$paidothercharge2=0;$paid_opinion_fee=0; $paiddocchargers=0; $paidepdocchargers=0;
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
								$paidothercharge=$paidothercharge+$raw->pay_amount ;
								if($raw->chage_type=='other_charge2')
								$paidothercharge2=$paidothercharge2+$raw->pay_amount ;
								if($raw->chage_type=='opinion_fee')
								$paid_opinion_fee=$paid_opinion_fee+$raw->pay_amount ;
								if($raw->chage_type=='document_chargers')
								$paiddocchargers=$paiddocchargers+$raw->pay_amount ;
								if($raw->chage_type=='ep_document_chargers')
								$paidepdocchargers=$paidepdocchargers+$raw->pay_amount ;
							}
							}
							?><input type="hidden" class="form-control"   id="stamp_duty"  value="<?=$stamp_duty?>" name="stamp_duty"required>
                            <input type="hidden" class="form-control"   id="leagal_fee"  value="<?=$leagal_fee?>" name="leagal_fee"required>
                            <input type="hidden" class="form-control"   id="document_fee"  value="<?=$document_fee?>" name="document_fee" required>
                                <input type="hidden" class="form-control"   id="other_charges"  value="<?=$other_charges?>" name="other_charges" required>
                            <input type="hidden" class="form-control"   id="other_charge2"  value="<?=$other_charges2?>" name="other_charge2" required>
                            <input type="hidden" class="form-control"   id="opinion_fee"  value="<?=$opinion_fee?>" name="opinion_fee" required>
                             <input type="hidden" class="form-control"   id="document_charge"  value="<?=$document_charge?>" name="document_charge" required>
                             <input type="hidden" class="form-control"   id="ep_document_chargers"  value="<?=$ep_document_charge?>" name="ep_document_chargers" required>



                              <!--Ticket No:2739 Added By Madushan 2021.05.03 Paid Amounts-->
							<input type="hidden" class="form-control"   id="paid_stamp_duty"  value="<?=$paidstamp?>" name="paid_stamp_duty"required>
                            <input type="hidden" class="form-control"   id="paid_leagal_fee"  value="<?=$padilegal?>" name="paid_leagal_fee"required>
                            <input type="hidden" class="form-control"   id="paid_document_fee"  value="<?=$paiddoc?>" name="paid_document_fee" required>
                             <input type="hidden" class="form-control"   id="paid_other_charges"  value="<?=$paidothercharge?>" name="paid_other_charges" required>
                            <input type="hidden" class="form-control"   id="paid_other_charge2"  value="<?=$paidothercharge2?>" name="paid_other_charge2" required>
                            <input type="hidden" class="form-control"   id="paid_opinion_fee"  value="<?=$paid_opinion_fee?>" name="paid_opinion_fee" required>
                             <input type="hidden" class="form-control"   id="paid_document_charge"  value="<?=$paiddocchargers?>" name="paid_document_charge" required>
                             <input type="hidden" class="form-control"   id="paid_ep_document_chargers"  value="<?=$paidepdocchargers?>" name="paid_ep_document_chargers" required>


                             <!--Ticket No:2739 Added By Madushan 2021.05.03 Previous Amounts-->
							<input type="hidden" class="form-control"   id="stamp_duty_old"  value="<?=$stamp_duty?>" name="stamp_duty_old"required>
                            <input type="hidden" class="form-control"   id="leagal_fee_old"  value="<?=$leagal_fee?>" name="leagal_fee_old"required>
                            <input type="hidden" class="form-control"   id="document_fee_old"  value="<?=$document_fee?>" name="document_fee_old" required>
                                <input type="hidden" class="form-control"   id="other_charges_old"  value="<?=$other_charges?>" name="other_charges_old" required>
                            <input type="hidden" class="form-control"   id="other_charge2_old"  value="<?=$other_charges2?>" name="other_charge2_old" required>
                            <input type="hidden" class="form-control"   id="opinion_fee_old"  value="<?=$opinion_fee?>" name="opinion_fee_old" required>
                             <input type="hidden" class="form-control"   id="document_charge_old"  value="<?=$document_charge?>" name="document_charge_old" required>
                             <input type="hidden" class="form-control"   id="ep_document_chargers_old"  value="<?=$ep_document_charge?>" name="ep_document_chargers_old" required>

                            
                             
                            
                           
                                    <div class="form-group  "><label class="col-sm-3 control-label">Stamp Fee</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control number-separator"   id="stamp_duty_val"  onblur="load_realvalues()"  value="<?=number_format($stamp_duty,2) ?>" name="stamp_duty_val" required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Legal Fees</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control number-separator" id="leagal_fee_val" onblur="load_realvalues()"   name="leagal_fee_val"  data-error=""    value="<?=number_format($leagal_fee,2) ?>" required>
										</div></div>
									 
                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Draft Checking Fee</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text"  onblur="load_realvalues()" class="form-control number-separator" id="document_fee_val"    name="document_fee_val"  value="<?=number_format($document_fee,2) ?>" data-error=""   required="required" >
										</div>
                                        <label class="col-sm-3 control-label">Plan Copy Fees</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control number-separator"   id="other_charges_val"  onblur="load_realvalues()"  value="<?=number_format($other_charges,2) ?>" name="other_charges_val" required>
                                       <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> </div>
                                        
                                          <div class="form-group ">
									  <label class="col-sm-3 control-label" >PR Fees</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control number-separator" id="other_charges2_val" onblur="load_realvalues()"   name="other_charges2_val"  data-error=""    value="<?=number_format($other_charges2,2) ?>" required>
										
                                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> 
                                          <label class="col-sm-3 control-label" >Opinion Fee</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control number-separator" id="opinion_fee_val" onblur="load_realvalues()"   name="opinion_fee_val"  data-error=""    value="<?=number_format($opinion_fee,2) ?>" required>
										
                                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> 
                                        </div>

                                           <div class="form-group ">
									 	<label class="col-sm-3 control-label">Document Charges</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control number-separator"   id="document_chargers_val"  onblur="load_realvalues()"  value="<?=number_format($document_charge,2) ?>" name="document_chargers_val" required>

                                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
										 
                                          	<label class="col-sm-3 control-label">EP Document Charges</label>
										<div class="col-sm-3 has-feedback" id="taskdata"><input  type="text"  onblur="load_realvalues()" class="form-control number-separator" id="ep_document_val"    name="ep_document_val"  value="<?=number_format($ep_document_charge,2) ?>" data-error=""   required="required" >

										
                                               <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div> 
                                        </div>

                                      <div class="form-group " style="float:right">
										<div class="col-sm-3 has-feedback"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()"><?=$status?></button>
											</div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>
                                      <br /><br /><br />
                                   
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