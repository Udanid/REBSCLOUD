 <h4>Edit Services<span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->service_id?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>hm/hm_config/update_services">

						<div class="col-md-6 validation-grids " data-example-id="basic-forms">

							<div class="form-body">
                            <div class="form-group has-feedback">
                              <label>Service Name</label>
            									<div class="form-group">
                                <input type="text" name="service_name" id="service_name" class="form-control" value="<?=$details->service_name?>" required>
                                <input type="hidden" name="service_id" id="service_id" class="form-control" value="<?=$details->service_id?>" required>
            									</div>
            									<label>Pay Type</label>
            									<div class="form-group">
                                <input type="text" name="pay_type" id="pay_type" class="form-control" value="<?=$details->pay_type?>" required>
            									</div>
            									<label>Pay Rate</label>
            									<div class="form-group">
                                <input type="number" name="pay_rate" step="0.01" id="pay_rate" class="form-control" value="<?=$details->pay_rate?>" required>
            									</div>

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
