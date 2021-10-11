 <h4>Branch Details of <?=$details->branch_name?> Branch<span  style="float:right; color:#FFF" ><a href="javascript:closepo()"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                    <form data-toggle="validator" method="post" action="<?=base_url()?>config/branch/add">
						<div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5  style="color:#000">Basic Information :</h5>
							</div>
							<div class="form-body">
								
									<div class="form-group">
										<input type="text" class="form-control" value="<?=$details->branch_name?>" name="branch_name" id="branch_name" placeholder="Branch Name" required>
									</div>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" value="<?=$details->shortcode?>"name="shortcode" id="shortcode" maxlength="3"   pattern="[A-Za-z]{3}" placeholder="Short Code" data-error="" onChange="check_is_exsit(this)" required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode">Branch Short code contains maximum 3 letters</span>
									</div>
									<div class="form-group"><textarea name="short_description" maxlength="150"   id="short_description"  class="form-control" placeholder="Short Description About the branch" required><?=$details->short_description?></textarea>
									   <span class="help-block">Maximum of 150 characters</span>
									</div>
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms"> 
								<div class="form-title">
									<h5 style="color:#000">Contact Information :</h5>
								</div>
								<div class="form-body">
									
									<div class="form-group has-feedback">
										<input type="text" class="form-control" value="<?=$details->location_map?>" name="location_map" id="location_map" placeholder="Location Map" >
										
										<span class="help-block with-errors" >Google Map share link Shoud be goes here</span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" value="<?=$details->address1?>" id="address1" name="address1"  placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="text" class="form-control" value="<?=$details->address2?>" id="address2" name="address2"  placeholder="Address Line 2" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
									<div class="form-group has-feedback">
										<input type="text" class="form-control" value="<?=$details->Contact_number?>" id="Contact_number" name="Contact_number" pattern="[0-9]{10}" placeholder="Contact Number" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"  value="<?=$details->fax?>"id="fax" name="fax" pattern="[0-9]{10}" placeholder="Fax Number" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="email" class="form-control" value="<?=$details->email?>" id="email" name="email" placeholder="Email" data-error="That email address is invalid"  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
									
								
								</div>
							</div>
						</div>
					</form></div>



				            
                                    
                                    <br /><br /><br /><br /></div>