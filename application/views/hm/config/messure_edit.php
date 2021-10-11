 <h4>Edit Services Type<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->mt_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_messuretype">

						<div class="col-md-6 validation-grids " data-example-id="basic-forms">

							<div class="form-body">
                            <div class="form-group has-feedback">
                             <label>Measurement Name</label>
								  <input type="text" name="messure_name" id="messure_name" class="form-control" value="<?=$details->mt_name?>" required>
                  <input type="hidden" class="form-control" value="<?=$details->mt_id?>" name="messure_id" id="messure_id" >

									    <span class="help-block with-errors" ></span>
									</div>

								 <div class="bottom">

											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Sumbit</button>
											</div>
											<div class="clearfix"> </div>
										</div>




							</div>
						</div>




					</form></div>
                           </div>
