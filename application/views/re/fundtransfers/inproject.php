 <script type="text/javascript">
$( function() {
    $( "#trndate" ).datepicker({dateFormat: 'yy-mm-dd'});
	
  } );
 
 
  function zeroPad(num, places) {
  var zero = places - num.toString().length + 1;
  return Array(+(zero > 0 && zero)).join("0") + num;
}
 
 function check_this_totals()
 {  
 	var pendingamount=parseFloat(document.getElementById('available_amount').value);
   var payamoount=parseFloat(document.getElementById('amount').value);
   if(document.getElementById('task_id').value=="")
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select From Task'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
   if(document.getElementById('to_task_id').value=="")
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select To Subtask'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
   if(payamoount>pendingamount)
   {
	   alert(pendingamount)
	    document.getElementById("checkflagmessage").innerHTML='Transfer Amount exseed Available'; 
					 $('#flagchertbtn').click();
					 document.getElementById('amount').value="";
   }
	
	 
 }


function load_subtasklist(id)
{
	//alert('sss');
	 var prj_id= document.getElementById("prj_id").value;
//	 var inner_prjid=document.getElementById("interf_prj_id").value;	
	 if(id!=""){
	 taskid=id.split(",")[0];
	 avbamount=id.split(",")[1];
	 if(prj_id!="")
	 document.getElementById("available_amount").value=avbamount;
	// if(inner_prjid!="")
	//  document.getElementById("inner_available_amount").value=avbamount;
					
				
	 
	 
		
 }
	 
}

function loadcurrent_block(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata').delay(1).fadeIn(600);
	 
						 $('#taskdata').delay(1).fadeIn(600);
    					    document.getElementById("taskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#taskdata" ).load( "<?=base_url()?>re/projectpayments/get_tasklist/"+id );
					$( "#totask" ).load( "<?=base_url()?>re/fundtransfers/get_tasklist/"+id );
					
				
	 
	 
		
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

 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>re/fundtransfers/add_internal" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                         <input type="hidden" name="trn_type" id="trn_type" value="Internal">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_block(this.value)" id="prj_id" name="prj_id" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div><label class="col-sm-3 control-label">Transfer Date</label>
                          <div class="col-sm-3 "> <input type="text" class="form-control"   id="trndate"  value="<?=date('Y-m-d')?>" name="trndate"  required> </div>
                          </div><? }?></div>
                          <div id="plandata" style="display:none">
                            <div class="form-title">
								<h4>Plan Details (Perch) :</h4>
							</div>
							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label">From Task </label>
										<div class="col-sm-3 " id="taskdata"><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Available Amount</label>
										<div class="col-sm-3" id="avbamount"><input type="text" class="form-control" readonly="readonly" id="available_amount"  name="available_amount"     data-error=""  required>
										</div></div>
									 
                                     <div class="form-group ">
									<label class="col-sm-3 control-label">To Task</label>
										<div class="col-sm-3 has-feedback" id="totask"><input  type="text" class="form-control"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Transfer Amount</label>
										<div class="col-sm-3 has-feedback"><input type="number" step="0.01" class="form-control" id="amount"  value=""name="amount"    data-error=""  required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>
                                      
                                    <div class="form-group ">
									<label class="col-sm-3 control-label">Description  </label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="description"    name="description"     data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                          <div class="form-group validation-grids " style="float:right">
												
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_totals()">Update</button>
											
											
										</div>
								
							</div>
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>