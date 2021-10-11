<script type="text/javascript">
function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 $( function() {
    $( "#drown_date" ).datepicker({dateFormat: 'yy-mm-dd' ,minDate: '<?=$this->session->userdata("current_start")?>',
			maxDate: '<?=$this->session->userdata("current_end")?>'});

  } );
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
	 	document.getElementById("tot_baduget_val").value=parseFloat(id.split(",")[2]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	 	document.getElementById("pending_val").value=parseFloat(id.split(",")[1]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
		$('#subtaskdata').delay(1).fadeIn(600);
    	document.getElementById("subtaskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		$( "#subtaskdata" ).load( "<?=base_url()?>common/get_subtask_list_payment/"+taskid+"/"+ prj_id	);
 	}
}

function loadcurrent_block(id)
{
	if(id!=""){
		$('#plandata').delay(1).fadeIn(600);
	 	$('#taskdata').delay(1).fadeIn(600);
    	document.getElementById("taskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">';
		$( "#taskdata" ).load( "<?=base_url()?>re/projectpayments/get_tasklist/"+id );
		$( "#paymentdateid" ).load( "<?=base_url()?>re/projectpayments/loadd_daterange/"+id );
		$.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'accounts/invoice/get_invoices_by_projectid/';?>',
			data: { id: id },
			success: function(data) {
				if (data) {
					$( "#invoice_id" ).append(data);
					$('#invoice_id').trigger("chosen:updated");
				}
			}
		});
 	}
 	else
 	{
	 	$('#lotinfomation').delay(1).fadeOut(600);
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

function load_advancebalance(val)
{
	if(val!='')
	{
	var paid = val.split("-")[1];
	if(val.split("-")[1])
	paid = val.split("-")[1];
	else
	paid = 0;
	var total = val.split("-")[2];
	var tot=parseFloat(total)-parseFloat(paid);
	 document.getElementById("advance_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 document.getElementById("advance_balv").value=tot
	}
	else
	{
		 document.getElementById("advance_bal").value=0.00;
		  document.getElementById("advance_balv").value=0;
	}
}
function load_invoice_balance(val)
{
	//alert()
	if(val!='')
	{
		var id = val.split("-")[0];
		var paid = val.split("-")[1];
		if(val.split("-")[1])
		paid = val.split("-")[1];
		else
		paid = 0;
		var total = val.split("-")[2];
		var retention = parseFloat(val.split("-")[3]);
		$.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'accounts/invoice/get_retention_total_by_id/';?>',
			data: { id: id },
			success: function(data) {
				if (data) {
					retention = retention - data;
					//retention_paid = data;
				}
				if(retention > 0){
					$('#retention').css('display','block');
				}
				var tot=parseFloat(total)-parseFloat(paid) - retention;
				 document.getElementById("invoice_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				 document.getElementById("invoice_balv").value=tot
				 document.getElementById("invoice_retention").value=retention.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				 document.getElementById("retention_balv").value=retention;
			}
		});

	}
	else
	{
		 document.getElementById("invoice_bal").value=0.00;
		  document.getElementById("invoice_balv").value=0;
	}
}
function validate_amount()
{

	var mypayment=document.getElementById("amount").value
	mypayment=mypayment.replace(/\,/g,'');
	var invoicebal=document.getElementById("invoice_balv").value;
	var advancebal=document.getElementById("advance_balv").value;

	if(parseFloat(mypayment) > parseFloat(invoicebal))
	{

		invoiceid=document.getElementById("invoice_id").value;
		if(invoiceid!='')
		{
		 document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed invoice amount';
					 $('#flagchertbtn').click();
					 document.getElementById("amount").value='';
		}
	}
	if(parseFloat(mypayment) > parseFloat(advancebal))
	{
		adv_id=document.getElementById("adv_id1").value;
		if(adv_id!=''){
		 document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed cash advance amount';
					 $('#flagchertbtn').click();
					 document.getElementById("amount").value='';
		}
	}

}

function addRetention(val){
	var retention = $('#retention_balv').val();
	var inv_balance = $('#invoice_balv').val();
	var new_balance = 0;
	if ($('#add_retention').is(":checked"))
	{
		new_balance = parseFloat(inv_balance) + parseFloat(retention);
		$('#invoice_bal').val(new_balance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"))
		$('#invoice_balv').val(new_balance);
	}else{
		inv_balance = parseFloat(inv_balance) - parseFloat(retention);
		$('#invoice_bal').val(inv_balance.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"))
		$('#invoice_balv').val(inv_balance);
	}
}
 </script>


 <form data-toggle="validator" method="post" action="<?=base_url()?>re/projectpayments/add" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:450px;">


							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value=""></option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>

					</select> </div>
                          </div><? }?></div>
                          <div id="plandata" style="display:none">
                            <div class="form-title">
								<h4>Payment Details</h4>
							</div>
							<div class="form-body  form-horizontal" >
                              <div class="form-group"><label class=" control-label col-sm-3 " >Advance Number</label><div class="col-sm-3 "> <select name="adv_id1" id="adv_id1" class="form-control" onChange="load_advancebalance(this.value)"  > <option value=""></option>
                           <? if($advlist){
							 foreach($advlist as $dataraw)
							 { if($dataraw->totpay<$dataraw->amount){
							 ?>
                        <option value="<?=$dataraw->adv_id?>-<?=$dataraw->totpay?>-<?=$dataraw->amount?>" > <?=$dataraw->adv_code?> - <?=$dataraw->initial?> <?=$dataraw->surname?></option>
                         <? }}}?>
                         </select></div> <label class=" control-label col-sm-3 " >Invoice</label>
                         <div class="col-sm-3 "><select name="invoice_id" id="invoice_id" class="form-control" onChange="load_invoice_balance(this.value)"  >
                         <option value=""></option>
                         </select>
                          </div></div>
                           <div class="form-group">
                          <label class=" control-label col-sm-3 " >Advance Balance Amount</label>
                             <div class="col-sm-3 "><input  type="text" class="form-control" id="advance_bal"    name="advance_bal"  value=""   data-error=""    readonly placeholder="Advance Balance Amount" ></div>
                         <label class=" control-label col-sm-3 " >Invoice Balance Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="invoice_bal"    name="invoice_bal"  value=""   data-error=""  readonly placeholder="Invoice Balance Amount" >
                          <input  type="hidden"  id="invoice_balv"    name="invoice_balv"  value="0"  >
                          <input  type="hidden"  id="advance_balv"    name="advance_balv"  value="0"  >
                          <input  type="hidden"  id="retention_balv"    name="retention_balv"  value="0"  ></div>
                         	</div>


                                    <div class="form-group  "><label class="col-sm-3 control-label">Task Name</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>

                                        <label class="col-sm-3 control-label" >Sub Task Name</label>
										<div class="col-sm-3" id="subtaskdata"><input type="text" class="form-control" id="blockout_count"  name="blockout_count"     data-error=""  required>
										</div></div>
                                          <div class="form-group  "><label class="col-sm-3 control-label">Total Budget</label>
										<div class="col-sm-3 " ><input type="text" class="form-control"   id="tot_baduget_val"  name="tot_baduget_val"   value="0" readonly  >
                                       </div>

                                        <label class="col-sm-3 control-label" >Available Amount</label>
										<div class="col-sm-3" ><input type="text" class="form-control" id="pending_val"  name="pending_val"     data-error="" value="0"   readonly="readonly">
										</div></div>

                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Payment Date</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="drown_date"    name="drown_date"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Amount</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control number-separator" id="amount"  value=""name="amount" OnChange="validate_amount()"    data-error=""  required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>

                                    <div class="form-group ">
										<label class="col-sm-3 control-label">Payee Name</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid">
                                            <select  class="form-control" id="payee_name"    name="payee_name"     data-error=""   required="required" >
                                            <? if($suplist){
                                                foreach($suplist as $raw){?>
                                            <option value="<?=$raw->sup_code?>,<?=$raw->first_name?> <?=$raw->last_name?>"><?=$raw->first_name?> <?=$raw->last_name?> - <?=$raw->id_number?></option>
                                            <? }}?>
                                            </select>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                        <span id="retention" style="display:none;">
                                            <label class=" control-label col-sm-3 " >Invoice Retention Amount</label>
                                            <div class="col-sm-3"><input  type="text" class="form-control" id="invoice_retention"  name="invoice_retention" value="0" data-error="" readonly placeholder="Invoice Retention Amount" ><br />Include Retention&nbsp;&nbsp;&nbsp;<input type="checkbox" id="add_retention" onclick="addRetention(this.value)" /></div>
                                        </span>
                                        <!-- updated by nadee ticket 2916 -->
                                        <label class="col-sm-3 control-label">Narration</label>
<div class="col-sm-3 has-feedback"><textarea class="form-control" id="description"  value=""name="description"></textarea>
<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
<span class="help-block with-errors" ></span></div>
                                    </div>
                                    <div class="form-group validation-grids " style="float:right">
                                    	<div class="col-sm-3"></div>
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3"></div>
										<div class="col-sm-3"><button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button></div>
									</div>

							</div>

                        </div>

          </div>

</div>
</form>
