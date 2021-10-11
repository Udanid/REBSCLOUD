 <script type="text/javascript">

function loadcurrent_interftask(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata_inter').delay(1).fadeIn(600);
	 
						 $('#inner_taskdata').delay(1).fadeIn(600);
    					    document.getElementById("inner_taskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#inner_taskdata" ).load( "<?=base_url()?>re/projectpayments/get_tasklist/"+id );
					//$( "#totask" ).load( "<?=base_url()?>re/fundtransfers/get_tasklist/"+id );
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}
function loadcurrent_interttask(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 if(document.getElementById('interf_prj_id').value==id)
   {
	     document.getElementById("checkflagmessage").innerHTML='Please Select Deferent Project'; 
		 
					 $('#flagchertbtn').click();
					  document.getElementById('amount').value="";
   }
   else
 	$( "#inner_totask" ).load( "<?=base_url()?>re/fundtransfers/get_tasklist/"+id );
					
				
	 
	 
		
 }
 
}

 function inner_check_this_totals()
 {  
 	var pendingamount=parseFloat(document.getElementById('inner_available_amount').value);
   var payamoount=parseFloat(document.getElementById('inner_amount').value);
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

 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>re/fundtransfers/add_inner" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                        <input type="hidden" name="trn_type" id="trn_type" value="Inter Project">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  <div class="form-title">
								<h4>Inter Project Fund Transfers</h4>
							</div>
							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">From Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_interftask(this.value)" id="interf_prj_id" name="interf_prj_id" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div><label class="col-sm-3 control-label">To Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="loadcurrent_interttask(this.value)" id="intert_prj_id" name="intert_prj_id" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div>
                          </div><? }?></div>
                          <div id="plandata_inter" style="display:none">
                            
							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label">From Task Name</label>
										<div class="col-sm-3 " id="inner_taskdata"><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >To Task</label>
										<div class="col-sm-3" id="inner_totask"><input type="text" class="form-control" id="blockout_count"  name="blockout_count" onblur="loadlotlist()"    data-error=""  required>
										</div></div>
									 
                                     <div class="form-group ">
									<label class="col-sm-3 control-label">Available Amount</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="inner_available_amount"    name="inner_available_amount"  readonly="readonly"    data-error=""   required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label">Transfer Amount</label>
										<div class="col-sm-3 has-feedback"><input type="number" step="0.01" class="form-control" id="inner_amount"  value=""name="inner_amount"    data-error=""  required="required" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <input type="hidden" class="form-control" id="pendingamount"  value=""name="pendingamount"    data-error=""  >
									</div>
                                      
                                    <div class="form-group ">
									<label class="col-sm-3 control-label">Description</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="inner_dis"    name="inner_dis"     data-error=""   >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                          <div class="form-group validation-grids " style="float:right">
												
												<button type="submit" class="btn btn-primary disabled" onclick="inner_check_this_totals()">Update</button>
											
											
										</div>
								
							</div>
                            
                            
                            
                            </div>
                            
                          
</div>
</div>
</form>