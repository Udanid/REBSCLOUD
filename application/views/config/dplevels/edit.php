 <h4>Edit Downpayment Ratio<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->dp_id 	?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/dplevels/editdata">
                    
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
                            <div class="form-group has-feedback">
                             <label>Downpayment Presentage</label>
								  <input type="text" class="form-control" value="<?=$details->dp_rate?>%" name="dp_rate" id="dp_rate" readonly="readonly" placeholder="Document Name"  required>
								
									    <span class="help-block with-errors" ></span>
									</div>
									
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms"> 
								
								<div class="form-body">
									
									<div class="form-group has-feedback">
                                    <label>Project Ratio</label>
                                    <input type="hidden" name="dp_id"	value="<?=$details->dp_id?>"	 id="doctype_id" />
                                   <input type="text" class="form-control" value="<?=$details->dp_ratio?>" name="dp_ratio" id="dp_ratio" placeholder="Document Name"  required>
										
										<span class="help-block with-errors" ></span>
									</div>
                                  
                                  </div>
                                  </div>
                                  </div>
                                  <div  class="form-body">
                                  
                                    <div class="form-inline"> 
									<div class="form-group has-feedback" >
                                    <table class="table table-bordered"><thead><tr><th colspan="8" align="center">Interest Rates </th></tr>
                        <tr> <th>12</th><th>24</th><th>36</th><th>48</th><th>60</th><th>72</th><th>84</th><th>96</th></tr> </thead></thead>
                                 <tr><td>  <input type="text" class="form-control " value="<?=$details->months12?>" style="width:50px; padding:3px;"   id="months12" name="months12" pattern="[0-9]+([\.][0-9]{0,2})?"    required>
                                    </td><td><input type="text" class="form-control " style="width:50px; padding:3px;" value="<?=$details->months24?>"  id="months24" name="months24" pattern="[0-9]+([\.][0-9]{0,2})?"  required>
                                    </td><td> <input type="text" class="form-control" style="width:50px; padding:3px;"   value="<?=$details->months36?>" id="months36" name="months36" pattern="[0-9]+([\.][0-9]{0,2})?"   required>
                                    </td><td>  <input type="text" class="form-control" style="width:50px; padding:3px;"  value="<?=$details->months48?>" id="months48" name="months48" pattern="[0-9]+([\.][0-9]{0,2})?"   required>
                                     </td><td>  <input type="text" class="form-control"  style="width:50px; padding:3px;" value="<?=$details->months60?>"id="months60" name="months60" pattern="[0-9]+([\.][0-9]{0,2})?"   required />
                                       </td><td> <input type="text" class="form-control"  style="width:50px; padding:3px;" value="<?=$details->months72?>" id="months72" name="months72" pattern="[0-9]+([\.][0-9]{0,2})?"    required />
                                       </td><td>  <input type="text" class="form-control" style="width:50px; padding:3px;"  
                                       value="<?=$details->months84?>" id="months84" name="months84" pattern="[0-9]+([\.][0-9]{0,2})?"     required />
                                       </td><td>   <input type="text" class="form-control" style="width:50px; padding:3px;" value="<?=$details->months96?>"  id="months96" name="months96" pattern="[0-9]+([\.][0-9]{0,2})?"     required /></td></tr></table>
										
										
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></div>
                                    <div class="bottom">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
                                  
                                  </div>
										
								
								</div>
							</div>
						</div>
					</form></div>
                           </div>