 <h4> <?=$details->first_name?> - <?=$details->last_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->cus_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                     <form data-toggle="validator" method="post" action="<?=base_url()?>hm/customer/editdata_loan" enctype="multipart/form-data">
                        <div class="row ">
						     <div class="col-md-6   validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5>Basic Information :</h5>
							</div>
							<div class="form-body form-horizontal">
									<div class="form-group">
                                    <div class="col-md-4">
                                    <input type="hidden" name="id_type" id="id_type" value="<?=$details->id_type?>">
                                    <input type="hidden" name="cus_code" id="cus_code" value="<?=$details->cus_code?>">
                                    <input type="hidden" name="id_copy" id="id_copy" value="<?=$details->id_copy?>">
                                    <select name="title" id="title" class="form-control" placeholder="Title" required>
                                    <option value="">Title</option>
                                    <option value="Mr" <? if($details->title=='Mr'){?> selected="selected"<? }?>>Mr</option>
                                    <option value="Ms"  <? if($details->title=='Ms'){?> selected="selected"<? }?>>Ms</option>
                                    <option value="Dr"  <? if($details->title=='Dr'){?> selected="selected"<? }?>>Dr</option>
                                     <option value="Rev"  <? if($details->title=='Rev'){?> selected="selected"<? }?>>Rev</option>
        
                                    </select></div>
                                     <div class="col-md-8">
										<input type="text" class="form-control" name="last_name" id="last_name"  value="<?=$details->last_name?>" placeholder="First Name Or Initials" required readonly="readonly">
									</div></div>
                                     <div class="clearfix"> </div><br>
									<div class="form-group has-feedback"><label class="col-md-4" >Other Names</label>
										 <div class="col-md-8"><input type="text" class="form-control"name="first_name" id="first_name"    value="<?=$details->first_name?>" placeholder="Last Name" data-error=""  required readonly="readonly">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span></div>
									</div>
                                    <div class="form-group">
                                    <label class="col-md-4" >NIC /Passwort</label>
                                       <div class="col-md-8">	<input type="text" class="form-control"name="id_number" id="id_number"   value="<?=$details->id_number?>"  placeholder="NIC Passport Number"  	 data-error="Please Enter Valid NIC Number" onChange="check_is_exsit(this)" required readonly="readonly">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
                                       </div>
									</div>
                                    <div class="form-group ">
									 <label class="col-md-4" >Profession</label>
                                       <div class="col-md-8">	<input type="text" class="form-control"name="profession" id="profession"   value="<?=$details->profession?>"  placeholder="Profession"  	 data-error="Please Enter Valid NIC Number" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
                                       </div></div>
                                        <div class="form-group ">
									 <label class="col-md-4" >Occupation</label>
                                       <div class="col-md-8">	<input type="text" class="form-control"name="occupation" id="occupation"   value="<?=$details->occupation?>"  placeholder="Occupation"  	 data-error="Please Enter Valid NIC Number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
                                       </div></div>
                                    <div class="form-group ">
									 <label class="col-md-4" >Civil Status</label>
                                       <div class="col-md-8">	<input type="text" class="form-control"name="civil_status" id="civil_status"   value="<?=$details->civil_status?>"  placeholder="Civil Status"  	 data-error="Please Enter Valid NIC Number" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
                                       </div></div>
                                        <div class="form-group ">
									 <label class="col-md-4" >Spouce Name </label>
                                       <div class="col-md-8">	<input type="text" class="form-control"name="spause_name" id="spause_name"   value="<?=$details->spause_name?>"  placeholder="Spouce Name"  	 data-error="Please Enter Valid NIC Number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
                                       </div>
									</div>
                                    <div class="form-group">
									 <label class="col-md-4" >Dependent </label>
                                       <div class="col-md-8">	<input type="text" class="form-control"name="dependent" id="dependent"   value="<?=$details->dependent?>"  placeholder="Dependent"  	 data-error="Please Enter Valid NIC Number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
                                       </div>
									</div>
								
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right ">
							<div class="widget-shadow " data-example-id="basic-forms"> 
								<div class="form-title">
									<h5>Contact Information :</h5>
								</div>
								<div class="form-body form-horizontal">
									
									
                                    <div class="form-group has-feedback"><label class="col-md-4" > Permenent Address </label>
										<div class="col-md-6"><textarea type="text" class="form-control" id="permenant_address" name="permenant_address"   value="" placeholder="Address Line 1" data-error=""  required><?=$details->permenant_address?></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                
									<div class="form-group has-feedback"><label class="col-md-4" >Land Line</label>
										<div class="col-md-6"><input type="text" class="form-control" id="landphone" name="landphone"  value=""  placeholder="Contact Number" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                    <div class="form-group has-feedback"><label class="col-md-4" >Mobile</label>
										<div class="col-md-6"><input type="text" class="form-control" id="mobile" name="mobile"  value="<?=$details->mobile?>"  placeholder="Mobile Number" data-error="Invalid number"  readonly="readonly" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                     <div class="form-group has-feedback"><label class="col-md-4" >Email</label>
										<div class="col-md-6"><input type="email" class="form-control" id="email" name="email"  value="<?=$details->email?>" placeholder="Email" data-error="That email address is invalid"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
											<div class="form-group has-feedback"><label class="col-md-4" > Business Address </label>
										<div class="col-md-6"><textarea type="text" class="form-control" id="business_add" name="business_add"   value="" placeholder="Business Address " data-error=""  required><?=$details->business_add?></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                     <div class="form-group has-feedback"><label class="col-md-4" >Business Telephone</label>
										<div class="col-md-6"><input type="text" class="form-control" id="bussiness_tell" name="bussiness_tell"  value="<?=$details->bussiness_tell?>" placeholder="Business Telephone" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
								
								</div>
							</div>
						</div>
                        </div>
                        <div class="clearfix"> </div>
                        <br>
                        <? $counter=1;
						$myarra=NULL;
						$myarra[1]['bank']="";
						$myarra[1]['branch']="";
						$myarra[1]['acc']="";
						$myarra[2]['bank']="";
						$myarra[2]['branch']="";
						$myarra[2]['acc']="";
                        foreach($bankdata as $raw)
						{
							$myarra[$counter]['bank']=$raw->bank_code;
							$myarra[$counter]['branch']=$raw->branch_code;
							$myarra[$counter]['acc']=$raw->acc_number;
							$counter++;
						}
						
						?>
                          <div class="widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5>Finance Information</h5>
							</div>
							<div class="form-body form-horizontal">
								 <div class="form-group has-feedback"><label class="col-md-2" >Monthly Income</label>
										<div class="col-md-4"><input type="text" class="form-control" id="monthly_incom" name="monthly_incom"  value="<?=$details->monthly_incom?>" placeholder="Monthly Income" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-md-2" >Monthly Expence</label>
										<div class="col-md-4"><input type="text" class="form-control" id="monthly_expence" name="monthly_expence"  value="<?=$details->monthly_expence?>"  placeholder="Monthly Expence" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                             	
                                 <div class="form-group has-feedback"><label class="col-md-2" >Spouce Income</label>
										<div class="col-md-4"><input type="text" class="form-control" id="spause_income" name="spause_income"  value="<?=$details->spause_income?>"  placeholder="Monthly Income" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-md-2" >Savings</label>
										<div class="col-md-4"><input type="text" class="form-control" id="savings" name="savings"  value="<?=$details->savings?>"  placeholder="Savings" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                    <div class="form-group has-feedback"><label class="col-md-2" >Movable Property</label>
										<div class="col-md-4"><input type="text" class="form-control" id="moveable_property" name="moveable_property"  value="<?=$details->moveable_property?>"  placeholder="Movable Property" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-md-2" >Imovable Property</label>
										<div class="col-md-4"><input type="text" class="form-control" id="imovable_property" name="imovable_property"  value="<?=$details->imovable_property?>"  placeholder="Imovable Property" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                     <div class="form-group has-feedback"><label class="col-md-2" >Tax Details</label>
										<div class="col-md-4"><input type="text" class="form-control" id="tax_details" name="tax_details"  value="<?=$details->tax_details?>"  placeholder="Tax Details" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									<label class="col-md-2" >Additional security</label>
										<div class="col-md-4"><input type="text" class="form-control" id="additional_facility" name="additional_facility"  value="<?=$details->additional_facility?>"  placeholder="Additional security" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									</div>
                                    <div class="form-group has-feedback"><label class="col-md-2" >Purpose of  Facility</label>
										<div class="col-md-4"><input type="text" class="form-control" id="popose_facility" name="popose_facility"  value="<?=$details->popose_facility?>" placeholder="Tax Details" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span></div>
									
									</div>
                             	 
                                  
								
									
									
								
								
							</div>
						</div>
                         <div class="widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5>Bank Account Details</h5>
							</div>
							<div class="form-body">
								<div class="form-inline"> 
									<div class="form-group">
                                    <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>" <? if($myarra[1]['bank']==$raw->BANKCODE){?> selected="selected"<? }?>><?=$raw->BANKNAME?></option>
                    <? }?>
        
                                    </select>
										</div>&nbsp;<div class="form-group" id="branch-1">
										 <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
                                    <option value="<?=$myarra[1]['branch']?>"><?=$myarra[1]['branch']?></option>
                                    
        
                                    </select>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"name="acc1" id="acc1" value="<?=$myarra[1]['acc']?>"   placeholder="Account Number" data-error="" >
										
									</div>
                                    </div>
                                     <br>
								
                                    	<div class="form-inline"> 
									<div class="form-group">
                                    <select name="bank2" id="bank2" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'2')">
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>"  <? if($myarra[2]['bank']==$raw->BANKCODE){?> selected="selected"<? }?> ><?=$raw->BANKNAME?></option>
                    <? }?>
        
                                    </select>
										</div>&nbsp;<div class="form-group"  id="branch-2">
										 <select name="branch2" id="branch2" class="form-control" placeholder="Bank" >
                                    <option value="<?=$myarra[2]['branch']?>"><?=$myarra[2]['branch']?></option>
                                    
        
                                    </select>
									</div>
                                    <div class="form-group has-feedback" >
										<input type="text" class="form-control"name="acc2" id="acc2" value="<?=$myarra[2]['acc']?>"    placeholder="Account Number" data-error=""  >
										
									</div>
                                    </div>
                                   <br>
								
									
									<div class="bottom validation-grids">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Sumbit</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								
								
							</div>
						</div>
                        
                        
                        
                        
					</form>
</div></div>


				            
                                    
                                    <br /><br /><br /><br />