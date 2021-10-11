 <script type="text/javascript">
 $( function() {
    $( "#trndate_ex" ).datepicker({dateFormat: 'yy-mm-dd',minDate: '<?=$this->session->userdata("current_start")?>',
			maxDate: '<?=$this->session->userdata("current_end")?>'});
	
  } );
function load_external(id)
{
	
	//alert(id)
 if(id!=""){
	 
	 
	
					 $('#plandata_ex').delay(1).fadeIn(600);
	 
							    document.getElementById("taskdata").innerHTML='<img src="<?=base_url()?>media/images/loading.gif"  class="loadinggif">'; 
					$( "#totask_ex" ).load( "<?=base_url()?>re/fundtransfers/get_tasklist/"+id );
					
				
	 
	 
		
 }
 else
 {
	 $('#lotinfomation').delay(1).fadeOut(600);
	 $('#plandata').delay(1).fadeOut(600);
 }
}



 </script>
 
 
 <form data-toggle="validator" method="post" action="<?=base_url()?>re/fundtransfers/add_external" enctype="multipart/form-data">
                        <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                        <input type="hidden" name="trn_type_ex" id="trn_type_ex" value="External">
 <div class="row">
<div class=" widget-shadow" data-example-id="basic-forms" style="min-height:400px;"> 

  
							<div class="form-body form-horizontal">
                            <? if($prjlist){?>
                          <div class="form-group"><label class="col-sm-3 control-label">Select Project</label>
                          <div class="col-sm-3 ">  <select class="form-control" placeholder="Qick Search.."   onchange="load_external(this.value)" id="prj_id_ex" name="prj_id_ex" >
                    <option value="">Search here..</option>
                    <?    foreach($prjlist as $row){?>
                    <option value="<?=$row->prj_id?>"><?=$row->project_name?></option>
                    <? }?>
             
					</select> </div><label class="col-sm-3 control-label">Transfer Date</label>
                          <div class="col-sm-3 "> <input type="text" class="form-control"   id="trndate_ex" readonly="readonly"  value="<?=date('Y-m-d')?>" name="trndate_ex"  required> </div>
                          </div><? }?></div>
                          <div id="plandata_ex" style="display:none">
                            <div class="form-title">
								<h4>Plan Details (Perch) :</h4>
							</div>
							<div class="form-body  form-horizontal" >
                                    <div class="form-group  "><label class="col-sm-3 control-label"> Task </label>
										<div class="col-sm-3 " id="totask_ex"><input type="text" class="form-control"   id="plan_no"  value="" name="plan_no"  required>
                                       </div>
                                        
                                        <label class="col-sm-3 control-label" >Transfer  Amount</label>
										<div class="col-sm-3" id="subtaskdata"><input type="number" step="0.01" class="form-control"  name="ex_amount" id="ex_amount"   data-error=""  required>
										</div></div>
									 
                                   
                                    <div class="form-group ">
									<label class="col-sm-3 control-label">Account Narration</label>
										<div class="col-sm-3 has-feedback" id="paymentdateid"><input  type="text" class="form-control" id="ex_dis"    name="ex_dis"     data-error=""   required="required" >
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