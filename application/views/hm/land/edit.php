
 <script>
  $( function() {
    var availableTags = [
	  <?
	  foreach($landnames as $data){
		  echo '"'.$data->property_name.'",';
	  }
	  ?>
    ];
    $( ".property_name" ).autocomplete({
      source: availableTags
    });
  } );
  function loadlandadatalist(type)
  {
  	if(type=="client_property")
  	{
  		$( "#land_intro" ).hide();
  		$( "#land_data" ).hide();


  	}else{
  		$( "#land_intro" ).show();
  		$( "#land_data" ).show();


  	}
  }
  sampleFunction();
  function sampleFunction()
  {
    var type="<?=$details->owenership_type?>";
    loadlandadatalist(type)
  }
  </script>
 <h4>Land Introducer :  <?=$details->property_name?> - <?=$details->district ?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->land_code?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row" >
                       <form data-toggle="validator" method="post" action="<?=base_url()?>hm/land/editdata" enctype="multipart/form-data">
                       <input type="hidden" name="product_code" id="product_code" value="<?=$product_code?>">
                       <input type="hidden" name="branch_code" id="branch_code" value="<?=$this->session->userdata('branchid')?>">
                       <!-- 2018-11-18 dev nadee modification of construction system -->
                       <? if($details->land_code=="" || $details->land_code==Null){
                         $details->land_code="";
                       }?>
                       <? if($details->plan_copy=="" || $details->plan_copy==Null){
                         $details->plan_copy="";
                       }?>
                       <? if($details->deed_copy=="" || $details->deed_copy==Null){
                         $details->deed_copy="";
                       }?>
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
                  <div class="form-group">
                    <label class="control-label" for="inputSuccess1">&nbsp;&nbsp;&nbsp;&nbsp;Land Ownership&nbsp;&nbsp;&nbsp;&nbsp;</label>

                  <select name="property_ownership" id="property_ownership" class="form-control"  onChange="loadlandadatalist(this.value)" required>
                  <option value="Own_property" <? if($details->owenership_type=="Own_property"){echo "selected";}?>>Own Property</option>
                  <option value="client_property" <? if($details->owenership_type=="client_property"){echo "selected";}?>>Client Property</option>
                </select></div></div></br>
								<div class="form-inline" id="land_intro">

									<div class="form-group"><label >Introducer Name</label>
                                    <select name="intro_code" id="intro_code" class="form-control" placeholder="Introducer" required>
                                    <option value="">Land Introducer</option>
                                     <? foreach ($introduceerlist as $raw){?>
                    <option value="<?=$raw->intro_code?>" <? if($raw->intro_code==$details->intro_code){?> selected="selected"<? }?> ><?=$raw->first_name?> <?=$raw->last_name?></option>
                    <? }?>

                                    </select>
										</div>&nbsp;<div class="form-group"><label >Introduced Date</label>
										<input type="text" class="form-control" value="<?=$details->intro_date?>" name="intro_date" id="intro_date" placeholder="Introduced Date" required>
									</div></div>
                                     <div class="clearfix"> </div><br>

                                    	<div class="form-group has-feedback"><label >Property Name</label>
										<input type="text" class="form-control property_name" name="property_name"   value="<?=$details->property_name?>"id="property_name"   placeholder="Property Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback"><label >Remarks</label>
										<textarea class="form-control" id="remarks" name="remarks"  placeholder="Land Remarks" data-error="Invalid number"  required> <?=$details->remarks?></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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
										<input type="text" class="form-control" name="land_arc"  value="<?=round($details->extendperch/160,2)?>" id="land_arc" pattern="[0-9]+([\.][0-9]{0,2})?"   placeholder="Land Extend In Arc" data-error="Invalid number" required><span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                  <div id="land_data">
									<div class="form-group has-feedback" ><label >Perch Price</label>
                                   <input  type="text"  pattern="[0-9]+([\.][0-9]{0,2})?"   value="<?=$details->perch_price?>" class="form-control"  onBlur="calculate_tot(this.value)"  id="perch_price" name="perch_price"  placeholder="Perch Price"   required>
										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span></div>
                                          <div class="form-group has-feedback" >
										<label >Total Price</label>
										<input type="text" class="form-control"   value="<?=$details->perch_price*$details->extendperch?>" pattern="[0-9]+([\.][0-9]{0,2})?"  name="total_price" id="total_price"   placeholder="Total Price" data-error="" required>

										  <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
									</div></div>

									<div class="form-group has-feedback"><label >environment data</label>
										<textarea class="form-control" id="envirronment_data" name="envirronment_data"  placeholder="Environment Data" data-error="Invalid number"  required> <?=$details->envirronment_data?></textarea>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    </div>





						</div>
                        </div>
                        <div class="clearfix"> </div><br />
                         <div class="col-md-12 ">
                         	<div class="widget-shadow" data-example-id="basic-forms">

                             <div class="form-title">
								<h5>Owner List</h5>
                       		</div>
                            <? if($owners)$counter=1;
							{?>
							<table class="table">
                            <tr><th>Owner Name</th><th>Address</th><th>NIC</th>
                            <? foreach($owners as $raw){?>
                            <tr>
                            <td><input type="text" class="form-control" id="owner_name<?=$counter?>" name="owner_name<?=$counter?>"   value="<?=$raw->owner_name?>" placeholder=""   required></td>
                            <td><input type="text" class="form-control" id="address<?=$counter?>" name="address<?=$counter?>"   value="<?=$raw->address?>" placeholder=""   required></td>
                            <td><input type="text" class="form-control" id="nic<?=$counter?>" name="nic<?=$counter?>"   value="<?=$raw->nic?>" placeholder=""   required></td>

                            </tr>
                            <? $counter++; }?>
                            </table>

							<? }?>


                            </div></div>

                         <div class="clearfix"> </div><br />
                         <div class="col-md-12 ">
                         	<div class="widget-shadow" data-example-id="basic-forms">

                             <div class="form-title">
								<h5>Location Details</h5>
                       		</div>

							<table class="table">
                            <tr>
                            <td> <div class="form-group"><label >District</label>
										<select name="district" id="district" class="form-control"  data-error=""  required>
                                    <option value="">District</option>
                                     <? foreach ($district_list as $raw){?>
                    <option value="<?=$raw->name?>"  <? if($raw->name==$details->district){?> selected="selected"<? }?>> <?=$raw->name?></option>
                    <? }?>

                                    </select>

									</div></td>
                            <td><div class="form-group"><label >Provincial Council</label>

                                    <select name="procouncil" id="procouncil" class="form-control"   data-error="" required>
                                    <option value="">Provincial Council</option>
                                     <? foreach ($council_list as $raw){?>
                    <option value="<?=$raw->name?>"  <? if($raw->name==$details->procouncil){?> selected="selected"<? }?>> <?=$raw->name?></option>
                    <? }?>

                                    </select>


									 </div></td>
                            <td><div class="form-group has-feedback"><label >Town</label>
                           <select name="town" id="town" class="form-control"   data-error="" required>
                                    <option value="">Town</option>
                                     <? foreach ($town_list as $raw){?>
                    <option value="<?=$raw->town?>"  <? if($raw->town==$details->town){?> selected="selected"<? }?>> <?=$raw->town?> - <?=$raw->district?> District</option>
                    <? }?>

                                    </select></div></td>

                            </tr>

                        <tr>
                            <td> <div class="form-group has-feedback"><label >Address Line 1</label>
										<input type="text" class="form-control" id="address1"  value="<?=$details->address1?>" name="address1"  placeholder="Address Line 1" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                            <td> <div class="form-group has-feedback"><label >Address Line 2</label>
										<input type="text" class="form-control" id="address2"  value="<?=$details->address2?>" name="address2"  placeholder="Address Line 2" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div></td>
                            <td> <div class="form-group has-feedback"><label >City</label>
										<input type="text" class="form-control" name="address3"  value="<?=$details->address3?>" id="address3" placeholder="City" >

										<span class="help-block with-errors" ></span>
									</div></td>

                            </tr>
                            </table>




                            </div></div>
                        <br>

                        <div class="bottom ">

											<div class="form-group">
												<button type="submit" class="btn btn-primary ">Update</button>
											</div>
											<div class="clearfix"> </div>
										</div>
								</div>


					</form></div>





                                    <br /><br /><br /><br /></div>
