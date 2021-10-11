 <h4>Land Introducer :  <?=$details->property_name?> - <?=$details->district ?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->land_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                       <form data-toggle="validator" method="post" action="<?=base_url()?>re/land/editdata" enctype="multipart/form-data">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                       <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                        <input type="hidden" name="land_code" id="land_code" value="<?=$details->land_code?>">
                          <input type="hidden" name="plan" id="plan" value="<?=$details->plan_copy?>">
                            <input type="hidden" name="deed" id="deed" value="<?=$details->deed_copy?>">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h5 style="background-color:none;">Basic Information :</h5>
							</div>
							<div class="form-body">
								<div class="form-inline">
									<div class="form-group"><label >Introducer Name</label>
                                    <select name="intro_code" id="intro_code" class="form-control" placeholder="Introducer" required>
                                    <option value="">Land Introducer</option>
                                     <? foreach ($introduceerlist as $raw){?>
                    <option value="<?=$raw->intro_code?>" <? if($raw->intro_code==$details->intro_code){?> selected="selected"<? }?> ><?=$raw->first_name?> <?=$raw->last_name?></option>
                    <? }?>

                                    </select>
                                  </div>&nbsp;</div>
                                                   <div class="clearfix"> </div><br>
                              <div class="form-inline">
                                <div class="form-group"><label >2nd Introducer Name</label>
                                                  <select name="intro_code2" id="intro_code2" class="form-control" placeholder="Introducer">
                                                  <option value="">Second Land Introducer</option>
                                                   <? foreach ($introduceerlist as $raw){?>
                                  <option value="<?=$raw->intro_code?>" <? if($raw->intro_code==$details->intro_code2){?> selected="selected"<? }?> ><?=$raw->first_name?> <?=$raw->last_name?></option>
                                  <? }?>

                                                  </select>
										</div>&nbsp;<div class="form-group"><label >Introduced Date</label>
										<input type="text" class="form-control" value="<?=$details->intro_date?>" name="intro_date" id="intro_date" placeholder="Introduced Date" required>
									</div></div>
                                     <div class="clearfix"> </div><br>
									<div class="form-group has-feedback"><label >Owner Name</label>
										<input type="text" class="form-control"name="owner_name"  value="<?=$details->owner_name?>" id="owner_name"   placeholder="Land Owner Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    	<div class="form-group has-feedback"><label >Property Name</label>
										<input type="text" class="form-control"name="property_name"   value="<?=$details->property_name?>"id="property_name"   placeholder="Property Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback"><label >Remarks</label>
										<textarea class="form-control" id="remarks" name="remarks"  placeholder="Land Remarks" data-error="Invalid number"  required> <?=$details->remarks?></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>

                                    </div>
                                   <div class="form-title">
								<h5>Location Details :</h5>
							</div>
							<div class="form-body">
                                    <div class="form-group"><label >District</label>
										<select name="district" id="district" class="form-control"  data-error=""  required>
                                    <option value="">District</option>
                                     <? foreach ($district_list as $raw){?>
                    <option value="<?=$raw->name?>"  <? if($raw->name==$details->district){?> selected="selected"<? }?>> <?=$raw->name?></option>
                    <? }?>

                                    </select>

									</div>
									<div class="form-group"><label >Provincial Council</label>

                                    <select name="procouncil" id="procouncil" class="form-control"   data-error="" required>
                                    <option value="">Provincial Council</option>
                                     <? foreach ($council_list as $raw){?>
                    <option value="<?=$raw->name?>"  <? if($raw->name==$details->procouncil){?> selected="selected"<? }?>> <?=$raw->name?></option>
                    <? }?>

                                    </select>


									 </div>

                                      <div class="form-group has-feedback"><label >Address Line 1</label>
										<input type="text" class="form-control" id="address1"  value="<?=$details->address1?>" name="address1"  placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback"><label >Address Line 2</label>
										<input type="text" class="form-control" id="address2"  value="<?=$details->address2?>" name="address2"  placeholder="Address Line 2" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback"><label >City</label>
										<input type="text" class="form-control" name="address3"  value="<?=$details->address3?>" id="address3" placeholder="City" >

										<span class="help-block with-errors" ></span>
									</div>

							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h5>Land Details :</h5>
								</div>
								<div class="form-body">

									<div class="form-group has-feedback" ><label >Land Exptend Per Perch</label>
                                   <input type="text" class="form-control" id="extendperch"  value="<?=$details->extendperch?>" name="extendperch" pattern="[0-9]+([\.][0-9]{0,2})?" placeholder="Land Estend In purch"   onBlur="calculate_arc(this.value)"  required>
										</div>
                                        <div class="form-group has-feedback" >
										<label >Land Exptend Arc</label>
										<input type="text" class="form-control" name="land_arc"  value="<?=$details->extendperch/160?>" id="land_arc" pattern="[0-9]+([\.][0-9]{0,2})?"   placeholder="Land Extend In Arc" data-error="Invalid number" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>

									<div class="form-group has-feedback" ><label >Perch Price</label>
                                   <input  type="text"  pattern="[0-9]+([\.][0-9]{0,2})?"   value="<?=$details->perch_price?>" class="form-control"  onBlur="calculate_tot(this.value)"  id="perch_price" name="perch_price"  placeholder="Perch Price"   required>
										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
                                          <div class="form-group has-feedback" >
										<label >Total Price</label>
										<input type="text" class="form-control"   value="<?=$details->perch_price*$details->extendperch?>" pattern="[0-9]+([\.][0-9]{0,2})?"  name="total_price" id="total_price"   placeholder="Total Price" data-error="" required>

										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									</div>

									<div class="form-group has-feedback"><label >environment data</label>
										<textarea class="form-control" id="envirronment_data" name="envirronment_data"  placeholder="Environment Data" data-error="Invalid number"  required> <?=$details->envirronment_data?></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    </div>
                                   <div class="form-title">
								<h5>Document Details :</h5>
							</div>
							<div class="form-body">


									<div class="form-group has-feedback" ><label >Plan No.</label>
                                   <input type="text" class="form-control" id="plan_no" name="plan_no"  value="<?=$details->plan_no?>"  placeholder="Plan Number"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										</div>
                                        <div class="form-group has-feedback" >
										<label >Deed No.</label>
										<input type="text" class="form-control" name="deed_no" id="deed_no"  value="<?=$details->deed_no?>"   placeholder="Deed Number" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div>

									<div class="form-group has-feedback" ><label >Drown By</label>
                                   <input type="text" class="form-control" id="drawn_by" name="drawn_by"   value="<?=$details->drawn_by?>" placeholder="Drown By"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
										<div class="form-group has-feedback" >
										<label >Drown Date</label>
										<input type="text" class="form-control" name="drawn_date" id="drawn_date"  value="<?=$details->drawn_date?>"   placeholder="Drawn Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div>
									<div class="form-group has-feedback" ><label >Attest By</label>
                                   <input type="text" class="form-control" id="attest_by" name="attest_by"   value="<?=$details->attest_by?>" placeholder="Attest By"   required><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
											<div class="form-group has-feedback" >
										<label >Attest Date</label>
										<input type="text" class="form-control" name="attest_date" id="attest_date"    value="<?=$details->attest_date?>" placeholder="Attest Date" data-error="" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div>

									<div class="form-group has-feedback" ><label>Plan Copy</label>
                                   <input type="file" class="form-control" id="plan_copy" name="plan_copy"  placeholder="Attest By"   ><span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
										<div class="form-group has-feedback" >
										<label>Deed Copy</label>
										<input type="file" class="form-control" name="deed_copy" id="deed_copy"   placeholder="Attest Date" data-error="" ><span class="glyphicon form-control-feedback" aria-hidden="true"></span>

									</div>



								<div class="bottom ">

											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								</div>
							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>




					</form></div>





                                    <br /><br /><br /><br /></div>
