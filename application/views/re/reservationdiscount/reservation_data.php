 <script type="text/javascript">
$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
   
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 
 

function padDigits(number, digits) {
    return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
}
function repay_cal(obj)
{
	obj=obj.replace(/\,/g,'');
	var newdiscount=parseFloat(obj)
	var sellingprice=parseFloat( document.getElementById("old_discountedprice").value)
	var paidamount=parseFloat( document.getElementById("paid_amount").value)
	var newdicountedprice=0
	var repaytotal=0;
	
		newdicountedprice=sellingprice-parseFloat(newdiscount);
		
	
	if(newdicountedprice < paidamount)
	{
		repaytotal=parseFloat(paidamount)-parseFloat(newdicountedprice);
	}
	document.getElementById("repay_amount").value=repaytotal;
	document.getElementById("new_discountedprice").value=newdicountedprice;
	document.getElementById("new_discount").value=newdiscount;
	document.getElementById("repay").value=repaytotal.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	document.getElementById("new_price").value=newdicountedprice.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}

 </script>
 

 <div class="form-title">
								<h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                </h4>
							</div>
       <input type="hidden" class="form-control"   id="sale_val"  value="<?=$lotdata->sale_val?>" name="sale_val"  readonly="readonly" required>
        <input type="hidden" class="form-control"   id="old_discount"  value="<?=$resdata->discount?>" name="old_discount"  readonly="readonly" required>
         <input type="hidden" class="form-control"  id="old_discountedprice"  value="<?=$resdata->discounted_price?>" name="old_discountedprice"  readonly="readonly" required>
          <input type="hidden" class="form-control"   id="new_discountedprice"  value="<?=$resdata->discounted_price?>" name="new_discountedprice"  readonly="readonly" required>
            <input type="hidden" class="form-control"   id="new_discount"  value="<?=$resdata->discount?>" name="new_discount"  readonly="readonly" required>
             <input type="hidden" class="form-control"   id="repay_amount"  value="0" name="repay_amount"  readonly="readonly" required>
             <input type="hidden" class="form-control"   id="paid_amount"  value="<?=$resdata->down_payment?>" name="paid_amount"  readonly="readonly" required>
			
							<div class="form-body  form-horizontal" >
                               <div class="form-group  "><label class="col-sm-3 control-label">Block Value</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="block_val"  value="<?=number_format($lotdata->sale_val,2) ?>" name="block_val"  readonly="readonly" required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Block Cost</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="block_cost"  name="block_cost"  data-error=""   readonly="readonly" value="<?=number_format($lotdata->costof_sale,2) ?>" required>
										</div></div>
                                    <div class="form-group  "><label class="col-sm-3 control-label">Current Selling Price</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="current_sell"  value="<?=number_format($resdata->seling_price,2) ?>" name="current_sell"  readonly="readonly" required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Current Discount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="cur_discount"  name="cur_discount"  data-error=""   readonly="readonly" value="<?=number_format($resdata->discount,2) ?>" required>
										</div></div>
                                          <div class="form-group  "><label class="col-sm-3 control-label">Current Discounted Price</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="current_val"  value="<?=number_format($resdata->discounted_price,2) ?>" name="current_val"  readonly="readonly" required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Paid Total</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="pay_tot"  name="pay_tot"  data-error=""   readonly="readonly" value="<?=number_format($resdata->down_payment,2) ?>" required>
										</div></div>
                                     <div class="form-group  ">
                                         <label class="col-sm-3 control-label" >New Discount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control number-separator" name="new_discount" id="new_discount"value=""  onblur="repay_cal(this.value)"  >
                                        
										</div>

                                         <label class="col-sm-3 control-label" >New Discounted Price</label>
										<div class="col-sm-3" id="subtaskdata"><input  type="text" class="form-control" name="new_price" id="new_price"   required   readonly="readonly" >
										</div>
                                       </div>                                        
									
                                     <div class="form-group ">
                                     	<label class="col-sm-3 control-label" > Comment</label>
										<div class="col-sm-3" id="subtaskdata">
											<textarea class="form-control" name="txtComment" id="txtComment" value="" ></textarea>
										</div>
									<label class="col-sm-3 control-label">Repay Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="repay"    name="repay"     data-error="" readonly="readonly"   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Discount Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate" autocomplete="off"  name="settldate"    data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                       <input type="hidden" class="form-control" id="instalments_val"  value=""name="instalments_val"    data-error=""  >
							
											</div>
                                        		</div>
                                               <div class="form-group"  style="float:right">
                                             
                                         <div class="col-sm-3 has-feedback" id="paymentdateid">  <h3>
												<button type="submit" class="btn btn-primary disabled" onClick="check_befor_submit()">Update</button></h3>
											</div>
                                             </div>
                                   
                                       
                                       
                                        <div class="clearfix"> </div>
								
							</div>
                            