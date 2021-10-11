<script>
function  calculate_salestimetotal()
{
	
		
	var mysalestot=0;
	//alert(document.getElementById('mysalestot').value);
	for(i=1; i<=24; i++)
	{
		mysalestot=parseFloat(mysalestot)+parseFloat(document.getElementById('salestime'+i).value);
	}
	
	document.getElementById('mysalestot').value=mysalestot;
	//var unselabletot=parseFloat(document.getElementById('road_ways').value)+parseFloat(document.getElementById('other_res').value)+parseFloat(document.getElementById('open_space').value)+parseFloat(document.getElementById('unselable_area').value);
	//	var seleble=parseFloat(document.getElementById('land_extend').value)-unselabletot;
		//alert(seleble);
	
	
}

</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/add_salestime" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                       <input type="hidden" name="prjperiod" id="prjperiod" value="<?=$details->period?>">
                      
                        <div class="row">
                        <div class="col-md-6 validation-grids ">

						  <div class="  widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>1st Year</h4>
							</div>
					              <div class="form-body">
								
                                   <table class="table table-bordered"> <thead>   
                                 
                                   <tr  > <th >Month</th> <th >Percentage</th></tr>
                                     </thead>
                                   <? $tot=0; for($i=1; $i<=12; $i++){
									    if($salestime[$i])
									 $val=$salestime[$i]->percentage;
									 else 
									 $val=0;
									 $tot=$tot+$val;?>
                                   <tr>
                                   <td><?=str_pad($i, 2, "0", STR_PAD_LEFT);?></td>
                                    <td>
                                    <div class="form-group has-feedback" > <input type="text"   style="width:50px; padding:3px;" class="form-control" id="salestime<?=$i?>" name="salestime<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$val?>" required="required" onblur="calculate_salestimetotal()"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                   <? }?>
                                  
                                 
                                  
                                 
                                
								 
								   
								   </table>
                                       
								  
                                 
									
						</div>
                            </div>
                        </div>
                                   <div class="col-md-6 validation-grids validation-grids-right">

						  <div class="  widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>2nd Year</h4>
							</div>
					              <div class="form-body">
								
                                   <table class="table table-bordered"> <thead>   
                                 
                                   <tr  > <th >Month</th> <th >Percentage</th></tr>
                                     </thead>
                                   <? for($i=13; $i<=24; $i++){
									    if($salestime[$i])
									 $val=$salestime[$i]->percentage;
									 else 
									 $val=0;
									 $tot=$tot+$val;?>
                                   <tr>
                                   <td><?=str_pad($i, 2, "0", STR_PAD_LEFT);?></td>
                                    <td>
                                    <div class="form-group has-feedback" > <input type="text"   style="width:50px; padding:3px;" class="form-control" id="salestime<?=$i?>" name="salestime<?=$i?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$val?>" required="required"  onblur="calculate_salestimetotal()"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                   <? }?>
                                  
                                 
                                    <tr>
                                   <td>Total</td>
                                    <td>
                                    <div class="form-group has-feedback" > <input type="number"  class="form-control" id="mysalestot" name="mysalestot"  value="<?=$tot?>"  max="100" min="100" required="required"><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td></tr>
                                 
                                
								 
								   
								   </table>
                                        <? if($details->status=='PENDING'){?>
								  
                                    <div class="bottom ">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled" >Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                                        <? }?>
									
						</div>
                            </div>
                        </div>
                        <div class="clearfix"> </div></div>
                      
                       
                        
					</form>