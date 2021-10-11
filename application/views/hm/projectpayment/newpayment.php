 <script type="text/javascript">

   $( function() {
    $( "#drown_date" ).datepicker({dateFormat: 'yy-mm-dd'});
	
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
	// var baduget
	  document.getElementById("tot_baduget_val").value=parseFloat(id.split(",")[2]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	 document.getElementById("pending_val").value=parseFloat(id.split(",")[1]).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");;
	// tot_baduget_val
	 
	 
						 $('#subtaskdata').delay(1).fadeIn(600);
    				//	    document.getElementById("subtaskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
			//		$( "#subtaskdata" ).load( "<?=base_url()?>common/get_subtask_list_payment/"+taskid+"/"+ prj_id	);
				
	 
	 
		
 }
	 
}

function loadcurrent_block(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 
						 $('#taskdata').delay(1).fadeIn(600);
    					    document.getElementById("taskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#taskdata" ).load( "<?=base_url()?>hm/projectpayments/get_tasklist/"+id );
				//	alert("<?=base_url()?>hm/projectpayments/get_fulldata/"+id)
					$( "#lotinfomation" ).load( "<?=base_url()?>hm/projectpayments/get_fulldata/"+id );
					
				
	 
	 
		
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
	//alert()
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
	var paid = val.split("-")[1];
	if(val.split("-")[1])
	paid = val.split("-")[1];
	else
	paid = 0;
	var total = val.split("-")[2];
	var tot=parseFloat(total)-parseFloat(paid);
	 document.getElementById("invoice_bal").value=tot.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	 document.getElementById("invoice_balv").value=tot
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
		adv_id=document.getElementById("adv_id").value;
		if(adv_id!=''){
		 document.getElementById("checkflagmessage").innerHTML='Settle amount cannot be exceed cash advance amount'; 
					 $('#flagchertbtn').click();
					 document.getElementById("amount").value='';
		}
	}
	
}
 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>hm/projectpayments/add" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->lot_id?>"><?=$row->project_name?> <?=$row->lot_number?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata" style="display:none">
                            <div class="form-title">
								<h4>Payment Details</h4>
							</div>
							<div class="form-body  form-horizontal" >
                              <div class="form-group"><label class=" control-label col-sm-3 " >Advance Number</label><div class="col-sm-3 "> <select name="adv_id" id="adv_id" class="form-control" onChange="load_advancebalance(this.value)"  > <option value="">Select Advance</option>
                           <? if($advlist){
							 foreach($advlist as $dataraw)
							 { if($dataraw->totpay<$dataraw->amount){
							 ?>
                        <option value="<?=$dataraw->adv_id?>-<?=$dataraw->totpay?>-<?=$dataraw->amount?>" > <?=$dataraw->adv_code?> - <?=$dataraw->initial?> <?=$dataraw->surname?></option>
                         <? }}}?>
                         </select></div> <label class=" control-label col-sm-3 " >Invoice</label> 
                         <div class="col-sm-3 "><select name="invoice_id" id="invoice_id" class="form-control" onChange="load_invoice_balance(this.value)"  >
                         <option value="">Select Invoice</option>
                          <? if($invoice){
							 foreach($invoice as $dataraw)
							 { if($dataraw->totpay<$dataraw->total){
							 ?>
                        <option value="<?=$dataraw->id?>-<?=$dataraw->totpay?>-<?=$dataraw->total?>" > <?=$dataraw->total?> - <?=$dataraw->first_name?> <?=$dataraw->last_name?></option>
                         <? }}}?>
                         </select>
                          </div></div>
                           <div class="form-group">
                          <label class=" control-label col-sm-3 " >Advance Balance Amount</label>
                             <div class="col-sm-3 "><input  type="text" class="form-control" id="advance_bal"    name="advance_bal"  value=""   data-error=""    readonly placeholder="Advance Balance Amount" ></div>
                         <label class=" control-label col-sm-3 " >Invoice Balance Amount</label><div class="col-sm-3 ">  <input  type="text" class="form-control" id="invoice_bal"    name="invoice_bal"  value=""   data-error=""  readonly placeholder="Invoice Balance Amount" >
                          <input  type="hidden"  id="invoice_balv"    name="invoice_balv"  value="0"  >
                          <input  type="hidden"  id="advance_balv"    name="advance_balv"  value="0"  ></div></div>
                            
                            
                                    <div class="form-group  "><label class="col-sm-3 control-label">Task Name</label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" ></label>
										<div class="col-sm-3" id="subtaskdata"><input type="hidden" class="form-control" id="blockout_count"  name="blockout_count"     data-error=""  required>
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
										<div class="col-sm-3 has-feedback"><input type="number"  step="0.01" class="form-control" id="amount"  value=""name="amount" OnChange="validate_amount()"    data-error=""  required="required" >
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
                                        
                                        </div> <label class="col-sm-3 control-label">Payment Description </label>
                                        <div class="col-sm-3 " >
                        				<textarea class="form-control" id="paymentdes" name="paymentdes" style="width: 100%;"></textarea>
                  						  </div></div>
                                            <div class="form-group ">
									<label class="col-sm-3 control-label">Perfoma Invoice Number</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="pf_invoice_number"    name="pf_invoice_number"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                      
									</div>
                                      
                                          
                                          
                                          <div class="form-group validation-grids " style="float:right">
												
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button>
											
											
										</div>
								
							</div>
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>
<div id="lotinfomation"></div>