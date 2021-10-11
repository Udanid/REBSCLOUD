<script>
 function check_this_market()
 {
	// 
	 
		var myeptot=parseFloat(document.getElementById('eppercentage12').value)+parseFloat(document.getElementById('eppercentage24').value)+parseFloat(document.getElementById('eppercentage36').value)+parseFloat(document.getElementById('eppercentage48').value)+parseFloat(document.getElementById('eppercentage60').value)+parseFloat(document.getElementById('eppercentage72').value)+parseFloat(document.getElementById('eppercentage84').value)+parseFloat(document.getElementById('eppercentage96').value);
	//	alert(myeptot);
		if(myeptot!=100)
	document.getElementById('totalep').value="";
	else 
	 document.getElementById('totalep').value=myeptot;
	var mydptot=parseFloat(document.getElementById('percentage1').value)+parseFloat(document.getElementById('percentage2').value)+parseFloat(document.getElementById('percentage3').value)+parseFloat(document.getElementById('percentage4').value);
	
	if(mydptot!=parseFloat(document.getElementById('epsales').value))
	{
		//alert(parseFloat(document.getElementById('epsales').value));
	document.getElementById('totaldp').value="";
	}
	else
	document.getElementById('totaldp').value=mydptot;
 }

</script>
 <? $this->load->view("includes/flashmessage");?>
<form data-toggle="validator"  method="post" action="<?=base_url()?>re/feasibility/add_marketdata" enctype="multipart/form-data">
                       <input type="hidden" name="prj_id" id="prj_id" value="<?=$prj_id?>">
                      
                        <div class="row">
						  <div class="  widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Marketing Data</h4>
							</div>
					              <div class="form-body"> 
                                      <div class="form-group form-horizontal" style="float:left"><label class="col-md-3 control-label">Outright sales (%)</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control"   id="outright"  value="<?=$details->outright?>" name="outright" pattern="[0-9]+([\.][0-9]{0,2})?"    required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label" >Easy payment Sales (%)</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="epsales" onBlur="calculate_tot(this.value)"   value="<?=$details->epsales?>" name="epsales"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                        <br /><br />
								</div>
                                </div></div>
                                 <div class="row">
	
    
    					     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
                                <div class="form-title">
								<h4>Expected EP sales Distribution (%)  :</h4>
							</div>
                                   <table class="table"> <thead> <tr> <th >id</th> <th >Down Payment</th>  <th >Percentage</th></tr> </thead>
                                   <? $count=1; if($dplist){
									  foreach($dplist as $raw) {
										  if($dpdata[$raw->dp_id])
										  $value=$dpdata[$raw->dp_id]->percentage;
										  else
										  $value=0;
									   ?>
                                  <tr> <td><?=$raw->dp_id?></td>
                                   <td> <?=$raw->dp_rate?></td>
                                    <td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="percentage<?=$raw->dp_id?>"  id="percentage<?=$raw->dp_id?>" value="<?=$value?>" max="100"   pattern="[0-9]+([\.][0-9]{0,2})?" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    </tr>
                                   <?  $count++; }
								
								   
								    } ?><tr> <td></td>
                                   <td>Total</td>
                                    <td> <div class="form-group has-feedback" ><input type="text"   class="form-control" name="totaldp"  id="totaldp"   pattern="[0-9]+([\.][0-9]{0,2})?"  required="required" data-error="Total must euql to easy payment sales value "> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    </tr></table>
                                       
								  <div class="form-title">
								<h4>Financing Data - Borrowung Rates(%)</h4>
								</div>
					              <div class="form-body"> 
                                      <div class="form-group form-horizontal" style="float:left"><label class="col-sm-3 control-label">Land Bank</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control"   id="land_bank"  value="<?=$details->land_bank ?>" name="land_bank" pattern="[0-9]+([\.][0-9]{0,2})?"    required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label" >Other</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="other_rate" onBlur="calculate_tot(this.value)"   value="<?=$details->other_rate?>" name="other_rate"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                         <div class="form-group form-horizontal" style="float:left"><label class="col-sm-3 control-label">Branch_rate</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control"   id="branch_rate"  value="<?=$details->branch_rate  ?>" name="branch_rate" pattern="[0-9]+([\.][0-9]{0,2})?"    required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
                                        <label class="col-sm-3 control-label" >Sales Tax</label>
										<div class="col-sm-3 has-feedback"><input type="text" class="form-control" id="sales_tax" onBlur="calculate_tot(this.value)"   value="<?=$details->sales_tax?>" name="sales_tax"   pattern="[0-9]+([\.][0-9]{0,2})?"  data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div></div>
                                        <br /><br />
								</div>
                                  
						</div>
                        
                        <div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms"> 
								<div class="form-title">
									<h4>Ep Contract Period</h4>
								</div>
								
								 <table class="table"> <thead> <tr> <th >Period</th><th  >Percentage</th></tr> </thead>
                                   <? $count=1; if($epchart){
									  foreach($epchart as $raw) {
										
									   ?>
                                  <tr> <td><?=$raw->timerange?></td>
                                    <td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage<?=$raw->timerange?>"id="eppercentage<?=$raw->timerange?>"  pattern="[0-9]+([\.][0-9]{0,2})?" value="<?=$raw->percentage?>" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     <td> </td></tr>
                                   <?  $count++; }
								
								   
								    } else {?>
                                    
                                     <tr><td>12</td><td><div class="form-group has-feedback" > <input type="number" step='0.01'  class="form-control" name="eppercentage12"id="eppercentage12"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>24</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage24" id="eppercentage24" pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>36</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage36" id="eppercentage36" pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>48</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage48"  id="eppercentage48" pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>60</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage60"  id="eppercentage60" pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>72</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage72"  id="eppercentage72" pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>84</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage84" id="eppercentage84"  pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                     <tr><td>96</td><td> <div class="form-group has-feedback" ><input type="number" step='0.01'  class="form-control" name="eppercentage96"  id="eppercentage96" pattern="[0-9]+([\.][0-9]{0,2})?" value="0" max="100" min="0"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                     </tr>
                                    <? }?><tr> 
                                   <td>Total</td>
                                    <td> <div class="form-group has-feedback" ><input type="text"    class="form-control" name="totalep" id="totalep"  max="100"  pattern="[0-9]+([\.][0-9]{0,2})?" min="100" data-error="Total Ep rates Must euql to 100" required="required"> <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                                    </tr></table>
								
                                          <div class="bottom ">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled" onclick="check_this_market()">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
									
									</div>
                            
                        </div>
                        <div class="clearfix"> </div></div>
                      
                       
                        
					</form>