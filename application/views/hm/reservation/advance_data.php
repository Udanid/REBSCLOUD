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
					$( "#plandata" ).load( "<?=base_url()?>hm/reservation/get_advancedata/"+id );






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
function check_value()
{
	var amount=document.getElementById("pay_amount").value;
	var balance=document.getElementById("balance_val").value;

	amount=amount.replace(/\,/g,'');
	document.getElementById("pay_amount").value=amount;
	/*if(parseFloat(amount)>parseFloat(balance))
	{
	  document.getElementById("checkflagmessage").innerHTML='Pay Amount exseed Balance Amount';
					 $('#flagchertbtn').click();
					 document.getElementById("pay_amount").value="";
	}*/
	if(parseFloat(amount)==0)
	{
		document.getElementById("checkflagmessage").innerHTML='Pay Amount Couldnt Be Zero';
					 $('#flagchertbtn').click();
					 document.getElementById("pay_amount").value="";
	}
}
 </script>


 <div class="form-title">
								<h4>Customer Name : &nbsp;  <?=$resdata->first_name ?> <?=$resdata->last_name ?>
                                &nbsp;  &nbsp; Project Name :&nbsp;<?=$resdata->project_name?> &nbsp;&nbsp;  Land Details :  <?=$resdata->lot_number ?>-<?=$resdata->plan_sqid ?>
                                </h4>
							</div>
							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label">Minimum Down Payment</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="min_down"  value="<?=number_format($resdata->min_down,2) ?>" name="min_down"  readonly="readonly" required>
                                       </div>

                                        <label class="col-sm-3 control-label" >Paid Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="down_payment"  name="down_payment"  data-error=""   readonly="readonly" value="<?=number_format($resdata->down_payment) ?>" required>
										</div></div>
                                         <div class="form-group ">
                                         <? $diamount=hm_get_advance_date_di($resdata->res_code,date('Y-m-d'))?>
                                       <label class="col-sm-3 control-label" >Delay Interest</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="balance"  name="balance"  data-error=""   readonly="readonly" value="<?=number_format($diamount,2) ?>" required>
                                        <input type="hidden" class="form-control" id="di_val"  name="di_val"  data-error=""   readonly="readonly" value="<?=$diamount?>" required>
										</div>
									<label class="col-sm-3 control-label">DI waive off amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid">
                      <? $user1=$this->session->userdata('usertype');
                      $today=date_create(date('Y-m-d'));
                      $dp_date=date_create($resdata->dp_fulcmpdate);
                        $diff=date_diff($dp_date,$today);
                        $diff=$diff->format("%R%a");
                   if( check_access('waive_off DI')){?>
                      <input  type="number" step="0.01" min="0"  class="form-control" id="di_vaivamount"    name="di_vaivamount"  max="<?=$diamount?>"   value='0' data-error=""   required="required"  onblur="check_value()" >
                         <? }else{?>
                        <input  type="number" step="0.01" min="0"  class="form-control" id="di_vaivamount" readonly   name="di_vaivamount"  max="<?=$diamount?>"   value='0' data-error=""   required="required"  onblur="check_value()" >
                        <? }?>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>

                                     <div class="form-group ">
                                       <label class="col-sm-3 control-label" >Balance Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="balance"  name="balance"  data-error=""   readonly="readonly" value="<?=number_format($resdata->discounted_price-$resdata->down_payment,2) ?>" required>
                                        <input type="hidden" class="form-control" id="balance_val"  name="balance_val"  data-error=""   readonly="readonly" value="<?=$resdata->discounted_price-$resdata->down_payment?>" required>
										</div>
									<label class="col-sm-3 control-label">Current Payment</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="number" step="0.01" min="1"  class="form-control" id="pay_amount"    name="pay_amount"     data-error=""   required="required"  onblur="check_value()" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                     <? $retruncharge=get_pending_return_charge($resdata->cus_code);

							if($retruncharge>0){?>
                             <div class="form-group"><label class="col-sm-3 control-label">Cheque Retrun Charge</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="chqcharge"    name="chqcharge"  value="<?=$retruncharge?>" readonly="readonly"   data-error="" required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                        <? }?>
										<div class="col-sm-3 has-feedback" style="float:right"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button>
											</div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>


                                          <div class="form-group validation-grids " style="float:right">



										</div>

							</div>
                    <div class="form-title">
								<h4>Advance Payment History</h4>
							</div>
 <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

                        <table class="table"> <thead> <tr> <th>Payment Date</th><th>Payment Sequence </th><th style="text-align:right;">Advance Payment</th><th style="text-align:right;">DI Payment</th><th style="text-align:right;">Amount</th><th style="text-align:center;">Receipt No</th> <th>Status </th><th></th></tr> </thead>
                      <? if($saledata){$c=0;
                          foreach($saledata as $row){?>

                        <tbody> <tr class="<? echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
                        <th scope="row"><?=$row->pay_date?></th>
                        <td> <?=$row->pay_seq ?></td>
                        <td  align="right"> <?=number_format($row->pay_amount,2)?></td>
                        <td  align="right"> <?=number_format($row->di_amount,2)?></td>
                        <td  align="right"> <?=number_format($row->di_amount+$row->pay_amount,2)?></td>
                        <td align="center"><?=$row->rct_no?></td>
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
