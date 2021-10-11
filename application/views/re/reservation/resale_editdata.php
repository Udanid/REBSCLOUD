 <h4>Loan Reschedule Details<span style="float:right"><a href="javascript:close_edit('<?=$relsaledata->resale_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
 <script type="text/javascript">
$( function() {
    $( "#settldate" ).datepicker({dateFormat: 'yy-mm-dd'});

  } );


function change_capital(obj)
{
	//alert('ssss')
	document.getElementById("repay_capital").value=obj;

	var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);

	document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");


}
function change_int(obj)
{
	//alert('ssss')
	if(parseFloat(document.getElementById("paid_int").value) >obj)
	{
		document.getElementById("repay_int").value=obj;

		var total=parseFloat(document.getElementById("repay_capital").value)+parseFloat(document.getElementById("repay_int").value);

		document.getElementById("total").value=total.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
	else
	{
		  document.getElementById("checkflagmessage").innerHTML='Refund interest value couldn be greater than the paid interest';
					 $('#flagchertbtn').click();
		document.getElementById("intrefund").value=0.00;
	}

}


 </script>

						<form data-toggle="validator" method="post" action="<?=base_url()?>re/reservation/editdata_resale" enctype="multipart/form-data">
                        <input type="hidden" name="resale_code" id="resale_code" value="<?=$relsaledata->resale_code?>">
                        <input type="hidden" name="res_code" id="res_code" value="<?=$relsaledata->res_code?>">




 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
         <div class="form-title">
								<h5>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                              </h5>
							</div>

							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label">Article Value</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="min_down"  value=" <?=number_format($resdata->discounted_price,2) ?>" name="min_down"  readonly="readonly" required>
                                       </div>

                                        <label class="col-sm-3 control-label" >Paid Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="down_payment"  name="down_payment"  data-error=""   readonly="readonly" value="<?=number_format($resdata->down_payment,2) ?>" required>
										</div></div>

                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Non Refundable Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="non_refund"  value="<?=number_format($relsaledata->down_payment-$relsaledata->repay_total,2) ?>"   name="non_refund"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Refund Amount</label>
										<div class="col-sm-3 has-feedback" ><input  type="text" class="form-control" id="repay_total"  value="<?=number_format($relsaledata->repay_total,2) ?>"   name="repay_total"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>


									</div>
                                       <div class="form-group ">
								       <label class="col-sm-3 control-label">Request  Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="settldate"    name="settldate"   value="<?=$relsaledata->apply_date?>"  data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                         <label class="col-sm-3 control-label">Remark</label>
										<div class="col-sm-3 has-feedback"><select name="remark" id="remark"  class="form-control" required="required">
                                          <option  value="">Select Remark </option>
                                        <option  value="Customer Default" <? if($relsaledata->remark=='Customer Default'){?> selected="selected" <? }?>>Customer Default </option>
                                         <option  value="Title Defect" <? if($relsaledata->remark=='Title Defect'){?> selected="selected" <? }?>>Title Defect</option>
                                          <option  value="Plan Approval Pending"<? if($relsaledata->remark=='Plan Approval Pending'){?> selected="selected" <? }?>> Plan Approval Pending</option>
                                             <option  value="Utility Pending" <? if($relsaledata->remark=='Utility Pending'){?> selected="selected" <? }?>>Utility Pending</option>
                                             <option  value="Data Entry Error" <? if($relsaledata->remark=='Data Entry Error'){?> selected="selected" <? }?>>Data Entry Error</option>
                                             <option  value="Misleading" <? if($relsaledata->remark=='Misleading'){?> selected="selected" <? }?>>Misleading</option>


                                        </select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                    <div class="form-group ">
                      <label class="col-sm-3 control-label">Documents</label>
                      <div class="col-sm-3 has-feedback" >
                        <a href="<?=base_url()?>uploads/resale/documents/<?=$relsaledata->documents?>" target="_blank">&nbsp;&nbsp;&nbsp;<?=$relsaledata->documents?>&nbsp;&nbsp;&nbsp;<i class="fa fa-download nav_icon icon_red"></i></a>
                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span class="help-block with-errors" ></span></div>

                                     		

                                               <div class="col-sm-3 has-feedback" >
                                           <? if($relsaledata->repay_total=='PENDING'){?>
                                         		<button type="submit" class="btn btn-primary disabled" >Update</button><? }?>
											</div></div>



							</div>


 </div>
</form>
