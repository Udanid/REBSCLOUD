 <h4>Land Introducer :  <?=$details->first_name?> - <?=$details->last_name?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->intro_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                     <form data-toggle="validator" method="post" action="<?=base_url()?>hm/introducer/editdata" enctype="multipart/form-data">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h5>Basic Information :</h5>
							</div>
							<div class="form-body">
								<div class="form-inline"> 
									<div class="form-group">
                                    
                                    <input type="hidden" name="id_type" id="id_type" value="<?=$details->id_type?>">
                                    <input type="hidden" name="intro_code" id="intro_code" value="<?=$details->intro_code?>">
                                    <input type="hidden" name="id_copy" id="id_copy" value="<?=$details->id_copy?>">
                                    <select name="title" id="title" class="form-control" placeholder="Title" required>
                                    <option value="">Title</option>
                                    <option value="Mr" <? if($details->title=='Mr'){?> selected="selected"<? }?>>Mr</option>
                                    <option value="Ms"  <? if($details->title=='Ms'){?> selected="selected"<? }?>>Ms</option>
                                    <option value="Dr"  <? if($details->title=='Dr'){?> selected="selected"<? }?>>Dr</option>
                                     <option value="Rev"  <? if($details->title=='Rev'){?> selected="selected"<? }?>>Rev</option>
        
                                    </select>
                                    
										</div>&nbsp;<div class="form-group"><label >First Name</label>
										<input type="text" class="form-control" name="first_name" id="first_name"  value="<?=$details->first_name?>" placeholder="First Name Or Initials" required>
									</div></div>
                                     <div class="clearfix"> </div><br>
									<div class="form-group has-feedback"><label >Last Name</label>
										<input type="text" class="form-control"name="last_name" id="last_name"    value="<?=$details->last_name?>" placeholder="Last Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group">
										<div class="radio">
											<label>
											  <input type="radio" name="idtype" value="NIC"   <? if($details->id_type=='NIC'){?> checked="checked"<? }?>required>
											  NIC
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio"  name="idtype" value="Passport"  <? if($details->id_type=='Passport'){?> checked="checked"<? }?> required>
											Passport
											</label>
										</div>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control"name="id_number" id="id_number"   value="<?=$details->id_number?>"  placeholder="NIC Passport Number"  	 data-error="Please Enter Valid NIC Number" onChange="check_is_exsit(this)" required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" id="myerrorcode"></span>
									</div>
									<div class="form-group"><h5>Upload NIC/Passport Copy</h5><br><input type="file" name="idcopy"  id="idcopy" placeholder="Last Name"class="form-control">
									 </div>
								
									
									
								
								
							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms"> 
								<div class="form-title">
									<h5>Contact Information :</h5>
								</div>
								<div class="form-body">
									
									
                                    <div class="form-group has-feedback"><label >Address Line 1</label>
										<input type="text" class="form-control" id="address1" name="address1"   value="<?=$details->address1?>" placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback"><label >Address Line 2</label>
										<input type="text" class="form-control" id="address2" name="address2"   value="<?=$details->address2?>" placeholder="Address Line 2" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback"><label >City</label>
										<input type="text" class="form-control" name="address3" id="address3"  value="<?=$details->address3?>" placeholder="City" >
										
										<span class="help-block with-errors" ></span>
									</div>
									<div class="form-group has-feedback"><label >Land Line</label>
										<input type="text" class="form-control" id="landphone" name="landphone"  value="<?=$details->landphone?>" pattern="[0-9]{10}" placeholder="Contact Number" data-error="Invalid number"  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback"><label >Mobile</label>
										<input type="text" class="form-control" id="mobile" name="mobile"  value="<?=$details->mobile?>" pattern="[0-9]{10}" placeholder="Mobile Number" data-error="Invalid number"  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback"><label >Email</label>
										<input type="email" class="form-control" id="email" name="email"  value="<?=$details->email?>" placeholder="Email" data-error="That email address is invalid"  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
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
								
									
									
								
								
							</div>
						</div>
                        
                        
                        
                        
					</form></div>



				            
                                    
                                    <br /><br /><br /><br /></div>