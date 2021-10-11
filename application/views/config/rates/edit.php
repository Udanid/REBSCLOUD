 <h4>Edit Downpayment Ratio<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->rate_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/rates/editdata">
                    
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
                            <div class="form-group has-feedback">
                             <label><?=$details->name?></label>
								  <input type="text" class="form-control" value="<?=$details->rate?>" name="rate" id="rate" placeholder="Document Name"  required>
                                  <input type="hidden" class="form-control" value="<?=$details->rate_id?>" name="rate_id" id="rate_id" >
								
									    <span class="help-block with-errors" ></span>
									</div>
									
								 <div class="bottom">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
									
									
								
								
							</div>
						</div>
						
										
								
							
					</form></div>
                           </div>