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
		var leagal_fee_tot= document.getElementById("leagal_fee").value;
		var document_fee_tot= document.getElementById("document_fee").value;
		var other_charges_tot= document.getElementById("other_charges").value;
		var other_charge2_tot= document.getElementById("other_charge2").value;
		var stamp_duty_tot= document.getElementById("stamp_duty").value;
		var opinion_fee_tot= document.getElementById("opinion_fee").value;
		var document_charge_tot= document.getElementById("document_charge").value;
		var ep_document_charge_tot= document.getElementById("ep_document_charge").value;

	
	
	
	var stamp= document.getElementById("stamp_duty_val").value;
	
	
	var leagal_fee= document.getElementById("leagal_fee_val").value;
	var document_fee= document.getElementById("document_fee_val").value;
	var other_charges= document.getElementById("other_charges_val").value;
	var other_charge2= document.getElementById("other_charge2_val").value;
	var opinion_fee= document.getElementById("opinion_fee_val").value;
	var document_charge= document.getElementById("document_charge_val").value;
	var ep_document_charge= document.getElementById("ep_document_charge_val").value;
	


		stamp=stamp.replace(",", "");
	  leagal_fee=leagal_fee.replace(",", "");
	  document_fee=document_fee.replace(",", "");
	  other_charges=other_charges.replace(",", "");
	  other_charge2=other_charge2.replace(",", "");
	   opinion_fee=opinion_fee.replace(",", "");
	   document_charge=document_charge.replace(",", "");
	    ep_document_charge=ep_document_charge.replace(",", "");
	   var check=true;
	      if(parseFloat(leagal_fee_tot)<parseFloat(leagal_fee))
		  check=false;
		   if(parseFloat(stamp_duty_tot)<parseFloat(stamp))
		  check=false;
		   if(parseFloat(document_fee_tot)<parseFloat(document_fee))
		  check=false;
		   if(parseFloat(other_charges_tot)<parseFloat(other_charges))
		  check=false;
		   if(parseFloat(other_charge2_tot)<parseFloat(other_charge2))
		  check=false;
		   if(parseFloat(opinion_fee_tot)<parseFloat(opinion_fee))
		  check=false;
		   if(parseFloat(document_charge_tot)<parseFloat(document_charge))
		  check=false;
		   if(parseFloat(ep_document_charge_tot)<parseFloat(ep_document_charge))
		  check=false;
		  if( check)
		  {

				document.getElementById("stamp_duty").value=stamp;
				document.getElementById("document_fee").value=document_fee;
				document.getElementById("leagal_fee").value=leagal_fee;
				document.getElementById("other_charges").value=other_charges;
				document.getElementById("other_charge2").value=other_charge2;
				document.getElementById("opinion_fee").value=opinion_fee;
				document.getElementById("document_charge").value=document_charge;
				document.getElementById("ep_document_charge").value=ep_document_charge;
	
	
	  
	  var total=parseFloat(stamp)+parseFloat(leagal_fee)+parseFloat(document_fee)+parseFloat(other_charges)+parseFloat(other_charge2)+parseFloat(opinion_fee)+parseFloat(document_charge)+parseFloat(ep_document_charge);
	  
	 
	
	  
	 		 document.getElementById("pay_amount_val").value=parseFloat(total).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	  		  document.getElementById("pay_amount").value=parseFloat(total);
				if(parseFloat(total)<=0)
			 document.getElementById("pay_amount_val").value="";
		  }
		  else
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
								$document_charge=$charge_data->document_chargers;
								$ep_document_charge=$charge_data->ep_document_chargers;
								$leagal_fee=$charge_data->leagal_fee;
								$stamp_duty=$charge_data->stamp_duty;
								$other_charges=$charge_data->other_charges;
								$other_charge2=$charge_data->other_charge2;
								//$other_charges=$charge_data->other_charges;
								$opinion_fee=$charge_data->opinion_fee;
							} else{
								$status='Insert';
								$document_fee=0;
								$document_charge=0;
								$ep_document_charge=0;
								$stamp_duty=(get_rate('Stamp Fee')*$resdata->discounted_price/100)-1000;
								$leagal_fee=(get_rate('Legal Fee')*$resdata->discounted_price/100);
								$other_charges=0;
								$other_charge2=0;
								$opinion_fee=0;
							
                            }
							$paiddoc=0; $padilegal=0; $paidstamp=0; $paiddeed=0; $paid_other_charge2=0; $paid_other_charges=0;$paidplancopy=0;$paid_opinion_fee=0;$paid_document_charge=0; $ep_paid_document_charge=0;
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
								if($raw->chage_type=='opinion_fee')
								$paid_opinion_fee=$paid_opinion_fee+$raw->pay_amount ;
								if($raw->chage_type=='document_chargers')
									$paid_document_charge=$paid_document_charge+$raw->pay_amount ;
								if($raw->chage_type=='ep_document_chargers')
									$ep_paid_document_charge=$ep_paid_document_charge+$raw->pay_amount ;
								
							}
							}$totalpaybel=0;
							
							?>
                           
                          
                             
                                
                                <table class="table"><tr><th>Charge Type</th><th>Payable Amount</th><th>Paid Amount</th><th>Current payment</th></tr>
                      <tr><td>Stamp Duty </td>
                      <td><input type="text" class="form-control"   id="stamp_duty_tot"    value="<?=number_format($stamp_duty,2) ?>" name="stamp_duty_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="stamp_duty_paid"   name="stamp_duty_paid"  data-error=""    value="<?=number_format($paidstamp,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$stamp_duty-$paidstamp;
					   $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control number-separator" id="stamp_duty_val"   name="stamp_duty_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()">
                                    <input type="hidden" class="form-control"   id="stamp_duty"  value="<?=$balance?>" name="stamp_duty"required></td>
                       <td> </td>
                      </tr>     
                        <tr><td>Legal Fee </td>
                      <td><input type="text" class="form-control"   id="leagal_fee_tot"    value="<?=number_format($leagal_fee,2) ?>" name="leagal_fee_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="leagal_fee_paid"   name="leagal_fee_paid"  data-error=""    value="<?=number_format($padilegal,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$leagal_fee-$padilegal;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control number-separator" id="leagal_fee_val"   name="leagal_fee_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"> <input type="hidden" class="form-control"   id="leagal_fee"  value="<?=$balance?>" name="leagal_fee"required></td>
                       <td> </td>
                      </tr>      
                               <tr><td>Plan  Fee </td>
                      <td><input type="text" class="form-control"   id="other_charges_tot"    value="<?=number_format($other_charges,2) ?>" name="other_charges_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="other_charges_paid"   name="other_charges_paid"  data-error=""    value="<?=number_format($paid_other_charges,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$other_charges-$paid_other_charges;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control number-separator" id="other_charges_val"   name="other_charges_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"> <input type="hidden" class="form-control"   id="other_charges"  value="<?=$balance?>" name="other_charges" required></td>
                       <td> </td>
                      </tr>   
                         
                        <tr><td>P/R Fee </td>
                      <td><input type="text" class="form-control"   id="other_charge2_tot"    value="<?=number_format($other_charge2,2) ?>" name="other_charge2_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="other_charge2_paid"   name="other_charge2_paid"  data-error=""    value="<?=number_format($paid_other_charge2,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$other_charge2-$paid_other_charge2;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control number-separator" id="other_charge2_val"   name="other_charge2_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"><input type="hidden" class="form-control"   id="other_charge2"  value="<?=$balance?>" name="other_charge2" required></td>
                       <td> </td>
                      </tr>   
                      
                       <tr><td>Draft Checking Fee</td>
                      <td><input type="text" class="form-control"   id="document_fee_tot"    value="<?=number_format($document_fee,2) ?>" name="plancopy_fee_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="document_fee_paid"   name="document_fee_paid"  data-error=""    value="<?=number_format($paiddoc,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$document_fee-$paiddoc;
					     $totalpaybel=$totalpaybel+$balance;
									?>  <input type="hidden" class="form-control"   id="document_fee"  value="<?=$balance?>" name="document_fee" required><input type="text" class="form-control number-separator" id="document_fee_val"   name="document_fee_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"></td>
                       <td> </td>
                      </tr> 
                       <tr><td>Opinion Fee</td>
                      <td><input type="text" class="form-control"   id="opinion_fee_tot"    value="<?=number_format($opinion_fee,2) ?>" name="opinion_fee_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="opinion_fee_paid"   name="opinion_fee_paid"  data-error=""    value="<?=number_format($paid_opinion_fee,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$opinion_fee-$paid_opinion_fee;
					     $totalpaybel=$totalpaybel+$balance;
									?>  <input type="hidden" class="form-control"   id="opinion_fee"  value="<?=$balance?>" name="opinion_fee" required><input type="text" class="form-control number-separator" id="opinion_fee_val"   name="opinion_fee_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"></td>
                       <td> </td>
                      </tr> 
                          <tr><td>Document Chargers </td>
                      <td><input type="text" class="form-control"   id="document_chargers_tot"    value="<?=number_format($document_charge,2) ?>" name="document_chargers_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="document_charge_paid"   name="document_charge_paid"  data-error=""    value="<?=number_format($paid_document_charge,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$document_charge-$paid_document_charge;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control number-separator" id="document_charge_val"   name="document_charge_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"><input type="hidden" class="form-control"   id="document_charge"  value="<?=$balance?>" name="document_charge" required></td>
                       <td> </td>
                      </tr>

                        <tr><td>EP Document Chargers </td>
                      <td><input type="text" class="form-control"   id="ep_document_chargers_tot"    value="<?=number_format($ep_document_charge,2) ?>" name="ep_document_chargers_tot"   readonly="readonly"required></td>
                      <td><input type="text" class="form-control" id="ep_document_charge_paid"   name="ep_document_charge_paid"  data-error=""    value="<?=number_format($ep_paid_document_charge,2) ?>"  readonly="readonly"required></td>
                       <td><?  $balance=$ep_document_charge-$ep_paid_document_charge;
					     $totalpaybel=$totalpaybel+$balance;
									?><input type="text" class="form-control number-separator" id="ep_document_charge_val"   name="ep_document_charge_val"  data-error=""    value="<?=number_format($balance,2) ?>" <?  if($balance<=0){?>  readonly="readonly"<? }?>required onblur="load_realvalues()"><input type="hidden" class="form-control"   id="ep_document_charge"  value="<?=$balance?>" name="ep_document_charge" required></td>
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