 <h4>Edit Vat Data<span  style="float:right; color:#FFF" ><a href="javascript:close_edit_vat('<?=$details->id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>accounts/tax/edit_vatdata">
                    
						<div class="col-md-6 validation-grids " data-example-id="basic-forms"> 
							
							<div class="form-body">
                            <div class="form-group has-feedback">
                             <label>Year : <?=$details->year?> &nbsp;  Month : <?=$details->month?>  <?=$details->m_half?> half </label>
								  <input type="text" class="form-control" value="<?=$details->rate?>" name="rate" id="rate" placeholder="Document Name"  required>
                                  <input type="hidden" class="form-control" value="<?=$details->id?>" name="id" id="id" >
								
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