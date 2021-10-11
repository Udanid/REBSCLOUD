 <script type="text/javascript">

$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
   
 
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

function check_refundtot()
{
	 var thisrefund=parseFloat(document.getElementById("repay_total").value);
	  var maxrefund=parseFloat(document.getElementById("repay_total_check").value);
	if(maxrefund<thisrefund)
	{
	document.getElementById("repay_total").value=0;
	}
}
function change_refund_tot()
{
	var amount=document.getElementById("non_refund").value;
	var payment=document.getElementById("down_payment_val").value;
	amount=amount.replace(/\,/g,'');
	document.getElementById("non_refund_val").value=amount;
	document.getElementById("non_refund").value=amount;
	total=parseFloat(payment)-parseFloat(amount);
	document.getElementById("repay_total_check").value=total;
	document.getElementById("repay_total").value=total;
	
	
}
function load_amount(value)
{
	var amount=0;
	if(value!="")
	 amount=value.split(",")[1];
	document.getElementById("amount").value=amount;
}

 </script>
 
 
 <div class="form-title">
 <? if($deed_data) {?>
 <div class="alert alert-danger" role="alert">
						Deed Already  Transferd
				</div>
 <? } else {?>
								<h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                </h4>
							</div>
                            <? if(get_pending_payments($resdata->res_code)){
								?>
                                  <div class="alert alert-danger" role="alert">
                                  Please reciept the all pending payments befor resale
                                  </div>
                                <?
								
							}else{?>
							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label">Article Value</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="min_down"  value=" <?=number_format($resdata->discounted_price,2) ?>" name="min_down"  readonly="readonly" required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Paid Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="down_payment"  name="down_payment"  data-error=""   readonly="readonly" value="<?=number_format($resdata->down_payment) ?>" required>
                                        <input type="hidden" class="form-control" id="down_payment_val"  name="down_payment_val"  data-error=""   readonly="readonly" value="<?=$resdata->down_payment?>" required>
										</div></div>
									 
                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Non Refundable Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="number" step="0.01" class="form-control" id="non_refund"  value="<?=$resdata->non_refund ?>"   name="non_refund" onchange="change_refund_tot()"     data-error=""   required="required" >
                                        <input  type="hidden" class="form-control" id="non_refund_val"  value="<?=$resdata->non_refund ?>"   name="non_refund_val"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Refund Amount</label>
										<div class="col-sm-3 has-feedback" ><input  type="number" min="0" class="form-control" id="repay_total"  value="<?=$resdata->down_payment-$resdata->non_refund ?>"   name="repay_total"  onblur="check_refundtot()"    data-error=""   required="required" >
                                        <input  type="hidden" class="form-control" id="repay_total_check"  value="<?=$resdata->down_payment-$resdata->non_refund ?>"   name="repay_total_check"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                     
										
									</div>
                                       <div class="form-group ">
								       <label class="col-sm-3 control-label">Request  Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate"   value="<?=date('Y-m-d')?>"  data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        
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
                                     		</div>
                                        		
                                               <div class="form-group" style="float:right; margin-right:10px;">
                                           <h3> 
                                         		<button type="submit" class="btn btn-primary disabled" >Settle</button></h3>
											</div>
                                   
                                          <div class="form-group validation-grids " style="float:right">
												
												
											
										</div>
								
							</div>
                            <? }?>
                    <div class="form-title">
								<h4>Advance Payment History</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" > 
                  
                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Payment Sequence </th><th>Amount</th> <th>Status </th></tr> </thead>
                      <? if($saledata){$c=0;
                          foreach($saledata as $row){?>
                      
                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>"> 
                        <th scope="row"><?=$row->pay_date?></th><td> <?=$row->pay_seq ?></td><td  align="right"> <?=number_format($row->pay_amount,2)?></td> 
                       
                        <td><?=$row->status?></td>
                        <td><div id="checherflag">
                          <? if($row->status=='PENDING'){?>
                              <a  href="javascript:call_delete_advance('<?=$row->id?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
                    <? }?>
                        </div></td>
                         </tr> 
                        
                                <? }} ?>
                          </tbody></table>  
                          <? }?>
                    </div>  