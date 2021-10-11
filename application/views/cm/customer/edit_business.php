<script>
 	$( "#id_doi" ).datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
        });
	$("#bank1").chosen({
		 allow_single_deselect : true
		});
		$("#branch1").chosen({
		 allow_single_deselect : true
		});
		$("#bank2").chosen({
		 allow_single_deselect : true
		});
		$("#branch2").chosen({
		 allow_single_deselect : true
		});
function check_is_exsit(src)
{

	var number=src.value.length;
	val=$('input[name=id_type]:checked').val();
	//alert(val);
	//document.getElementById("id_type").value=val;
	if(val=='NIC')
	{

	 var pattern = /\d\d\d\d\d\d\d\d\d\V|X|Z|v|x|z/;
                var id=src.value;
				 var code="";

                if ((id.length == 0))
				{
                code='NIC Cannot be Blank';

				 //obj.focus();
				}
				else if (id.length == 10)
				{
       				//alert(' Please enter a valid NIC.\n');
					 if (id.match(pattern) == null)
						code='Invalid NIC';


				}
                else if (id.length == 12)
				{
       				//alert(' Please enter a valid NIC.\n');
					code="";

				}
				else
				{
					code='Invalid NIC';
				}



      			// document.getElementById("myerrorcode").innerHTML=code;

                if (code!="") {
				//	 alert(data);

					document.getElementById("id_number").focus();
					document.getElementById("id_number").setAttribute("placeholder", code);
					document.getElementById("id_number").setAttribute("error", code);
					src.value="";
					//document.getElementById("id_type").value=val;

					document.getElementById("short_description").focus();
                }


	}
}

function copyAbove(){
	var checkBox = document.getElementById("same");

	// If the checkbox is checked, copy from residential address
	if (checkBox.checked == true){
	  	address1 = document.getElementById("raddress1").value;
		address2 = document.getElementById("raddress2").value;
		address3 = document.getElementById("raddress3").value;
    rpostal_code = document.getElementById("rpostal_code").value;
		document.getElementById("address1").value = address1;
		document.getElementById("address2").value = address2;
		document.getElementById("address3").value = address3;
    document.getElementById("postal_code").value = rpostal_code;
	} else {
	  	document.getElementById("address1").value = '<?=$details->address1?>';
		document.getElementById("address2").value = '<?=$details->address2?>';
		document.getElementById("address3").value = '<?=$details->address3?>';
    document.getElementById("postal_code").value = '<?=$details->postal_code?>';
	}
}


function showSpouse(){
	var spouse = document.getElementById("spouse");
	var civilstatus = document.getElementById("civil_status").value;

	if (civilstatus=='single'){
		//spouse.style.display = "none";
		$('#spouse').fadeOut('slow');
		document.getElementById("spouse_name").value = '';
		document.getElementById("spouse_employer").value = '';
		document.getElementById("spouse_designation").value = '';
		document.getElementById("spouse_income").value = '';
		document.getElementById("dependent").value = '';
	}else if(civilstatus=='married'){
		//spouse.style.display = "block";
		$('#spouse').fadeIn('slow');
	}
}

function deleteImage(id,name,file){
	 //document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					 document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirmImage').click();
				}
            }
        });
}
function deleteImage2(id,name,file){
	 //document.deletekeyform.deletekey.value=id;
	$.ajax({
            cache: false,
            type: 'GET',
            url: '<?php echo base_url().'common/activeflag_cheker/';?>',
            data: {table: 'cm_customerms', id: id,fieldname:'cus_code' },
            success: function(data) {
                if (data) {
					// alert(data);
					 document.getElementById("checkflagmessage").innerHTML=data;
					 $('#flagchertbtn').click();

					//document.getElementById('mylistkkk').style.display='block';
                }
				else
				{
					$('#complexConfirmImage2').click();
				}
            }
        });
}
$('#editform').validator();

function deleteDoc(doc,field,divtoclear,cus_code){
	var result = confirm("Are you sure you want to delete?");
	if (result) {
		$.ajax({
			cache: false,
			type: 'POST',
			url: '<?php echo base_url().'cm/customer/deleteDoc';?>',
			data: {doc:doc,cus_code:cus_code,field:field },
			success: function(data) {
				if (data) {
					$('#c'+field).hide().fadeIn('slow');
					$('#'+divtoclear).fadeOut('slow');
				}else{
					alert('Cannot delete the image!');
				}
			}
		});
	}
}
 </script>
 <h4> <?=$details->first_name;?> - <?=$details->last_name;?><span  style="float:right; color:#FFF" ><a href="javascript:close_edit('<?=$details->cus_code;?>')"><i class="fa fa-times-circle "></i></a></span></h4>
<div class="table widget-shadow">
 <div class="row">
                     <form data-toggle="validator" name="editform" id="editform" method="post" action="<?=base_url()?>cm/customer/editdata" enctype="multipart/form-data">
                     	<input type="hidden" name="custtype" id="custtype" value="<?=$details->cus_type?>">
                     	<input type="hidden" name="cus_code" id="cus_code" value="<?=$details->cus_code?>">
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h5>Business Information :</h5>
							</div>
							<div class="form-body editform">
                                	<div class="form-group has-feedback">
                                    	  <label >Business Name</label>
                                          <input type="text" class="form-control" id="last_name" name="last_name" autocomplete="off" value="<?=$details->last_name?>" placeholder="Business Name" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	  <label >Type of Business</label>
                                          <input type="text" class="form-control" id="occupation" name="occupation" autocomplete="off" value="<?=$details->occupation?>" placeholder="Type of Business" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    		<label >Business Name in Sinhala Unicode</label>
                                            <input type="text" class="form-control" name="unicode_name" id="unicode_name" autocomplete="off" value="<?=$details->unicode_name?>"  placeholder="Business Name in Sinhala Unicode" data-error="">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                    <div class="form-group has-feedback">
                                    	<label >Tax Identification Number (TIN)</label>
                                        <input type="text" class="form-control" id="tin" name="tin"  autocomplete="off" value="<?=$details->tin?>" placeholder="Tax Identification Number (TIN)" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >VAT Registration Number</label>
                                        <input type="text" class="form-control" id="vat" name="vat"  autocomplete="off" value="<?=$details->vat?>" placeholder="VAT Registration Number" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >Monthly Income</label>
                                        <input type="text" class="form-control" id="monthly_income" name="monthly_income"  autocomplete="off" value="<?=$details->monthly_income?>" placeholder="Monthly Expenses" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >Principal Source of Income</label>
                                        <input type="text" class="form-control" id="income_source" name="income_source"  autocomplete="off" value="<?=$details->income_source?>" placeholder="Principal Source of Income" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >Monthly Expenses</label>
                                        <input type="text" class="form-control" id="monthly_expence" name="monthly_expence"  autocomplete="off" value="<?=$details->monthly_expence?>" placeholder="Monthly Expenses" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >Savings</label>
                                        <input type="text" class="form-control" id="savings" name="savings"  autocomplete="off" value="<?=$details->savings?>" placeholder="Savings" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >Movable Properties</label>
                                        <textarea class="form-control" id="moveable_property" name="moveable_property" placeholder="Movable Properties" data-error=""><?=$details->moveable_property?></textarea>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                    	<label >Immovable Properties</label>
                                        <textarea class="form-control" id="imovable_property" name="imovable_property" placeholder="Immovable Properties" data-error=""><?=$details->imovable_property?></textarea>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>

                                    <br />
                                    <div class="form-group">
                                    	<h5><strong>Identification Document Type</strong></h5>


										<div class="radio">
											<label>
											<input type="radio"  name="id_type" id="id_type[]" onClick="check_is_exsit();"  value="BRN" <? if($details->id_type=='BRN'){?> checked="checked"<? }?> required>
											Business Registration
											</label>
										</div>
									</div>
                                    <div class="form-inline">
                                        <div class="form-group has-feedback">
                                            <label >Document Number</label>
                                            <input type="text" class="form-control"name="id_number" id="id_number" style="width:100%;" autocomplete="off" value="<?=$details->id_number?>"  placeholder="Document Number" data-error="Please Enter Valid NIC Number" onChange="check_is_exsit()" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" id="myerrorcode"></span>
                                        </div>
                                        <div class="form-group has-feedback">
                                            <label >Date of Issue</label>
                                            <input type="text" class="form-control"name="id_doi" id="id_doi" style="width:100%;" autocomplete="off" value="<?=$details->id_doi?>"  placeholder="Date of Issue">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" id="myerrorcode"></span>
                                        </div>
                                    </div>
                                    <br />
									<div class="form-group">
                                    	<h5><strong>Upload BR Front <i style="color:#CC3300;">(required)</i></strong></h5>
                                        <div id="cid_copy_front" <? if($details->id_copy_front){?> style="display:none;"<? }?>>
                                            <span id="addfile" class="btn btn-success fileinput-button" style="width:25%; ">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Add file</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload" type="file" name="files" required="required">
                                                <input type="hidden" name="id_copy_front" id="id_copy_front" value="<?=$details->id_copy_front?>">
                                                <div id="upfiles" class="upfiles"></div>
                                            </span>

                                            <!-- The global progress bar -->
                                            <div id="progress" class="progress" >
                                                <div class="progress-bar progress-bar-success"></div>
                                            </div>
                                        </div>
                                        <!-- The container for the uploaded files -->
                                        <br />
                                        <span id="oldfiles">
                                        <? if ($details->id_copy_front){?>
                                        	<span id="oldfilesimg">
                                        		<a href="<?=base_url()?>uploads/customer_ids/<?=$details->id_copy_front?>"><img src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->id_copy_front?>" /></a>&nbsp;&nbsp;&nbsp;
                                            </span>

                                            <a href="#" onclick="deleteDoc('<?=$details->id_copy_front?>','id_copy_front','oldfiles','<?=$details->cus_code?>');"><i class="fa fa-times" style="color:red;"></i></a>
                                        <? }else{?>
                                            	<span id="oldfilesimg"></span>
                                            <? }?>
                                        </span>
                                        <br /><br />
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files" style="width:25%;">

                                        </div>

                                        <br /><br />
                                        <span id="documentback">
                                            <h5><strong>Upload BR Back</strong></h5>
                                            <div id="cid_copy_back" <? if($details->id_copy_back){?> style="display:none;" <? }?>>
                                                  <span id="addfile2" class="btn btn-success fileinput-button" style="width:25%;">
                                                      <i class="glyphicon glyphicon-plus"></i>
                                                      <span>Add file</span>
                                                      <!-- The file input field used as target for the file upload widget -->
                                                      <input id="fileupload2" type="file" name="files">
                                                      <input type="hidden" name="id_copy_back" id="id_copy_back" value="<?=$details->id_copy_back?>">
                                                      <div id="upfiles2" class="upfiles2"></div>
                                                  </span>

                                                  <!-- The global progress bar -->
                                                  <div id="progress2" class="progress">
                                                      <div class="progress-bar progress-bar-success"></div>
                                                  </div>
                                            </div>
                                            <br />
                                            <span id="oldfiles2">
                                            <? if ($details->id_copy_back){?>
                                            	<span id="oldfiles2img">
                                            		<a class="image" href="<?=base_url()?>uploads/customer_ids/<?=$details->id_copy_back?>"><img src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->id_copy_back?>" /></a>
                                                </span>
                                                &nbsp;&nbsp;&nbsp;

                                            <a href="#" onclick="deleteDoc('<?=$details->id_copy_back?>','id_copy_back','oldfiles2','<?=$details->cus_code?>');"><i class="fa fa-times" style="color:red;"></i></a>
                                            <? }else{?>
                                            	<span id="oldfiles2img"></span>
                                            <? }?>
                                            </span>
                                            <br /><br />
                                            <!-- The container for the uploaded files -->
                                            <div id="files2" class="files" style="width:25%;">

                                            </div>

                                    	</span>

									 </div>





							</div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h5>Contact Information :</h5>
								</div>
								<div class="form-body">



                                    <h4 class="h4red">Postal Address </h4>
                                    <div class="form-group has-feedback"><label >Address Line 1</label>
                                        <input type="text" class="form-control" id="address1" name="address1" autocomplete="off"  value="<?=$details->address1?>" placeholder="Address Line 1" data-error=""  required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                     <div class="form-group has-feedback"><label >Address Line 2</label>
                                        <input type="text" class="form-control" id="address2" name="address2" autocomplete="off"  value="<?=$details->address2?>" placeholder="Address Line 2" data-error="">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback"><label >City</label>
                                        <input type="text" class="form-control" name="address3" id="address3" autocomplete="off" value="<?=$details->address3?>" placeholder="City" >

                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                  											<input type="text" class="form-control" name="postal_code" id="postal_code" autocomplete="off" value="<?=$details->postal_code?>" placeholder="Postal Code" data-error="">

                  											<span class="help-block with-errors" ></span>
                  									</div>
                                    <div class="form-group has-feedback"><label >Grama Sewa Ward</label>
                                        <input type="text" class="form-control" name="gsword" id="gsword" autocomplete="off" value="<?=$details->gsword?>" placeholder="Grama Sewa Ward" >

                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <br>
                                    <h4 class="h4red">Overseas/Other Address </h4><br>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" id="otheraddress1" name="otheraddress1"  autocomplete="off" value="<?=$details->otheraddress1?>" placeholder="Address Line 1" data-error="" >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback">
										<input type="text" class="form-control" id="otheraddress2" name="otheraddress2"  autocomplete="off" value="<?=$details->otheraddress2?>" placeholder="Address Line 2" data-error="">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
										<input type="text" class="form-control" name="otheraddress3" id="otheraddress3" autocomplete="off" value="<?=$details->otheraddress3?>" placeholder="City">
										<span class="glyphicon form-control-feedback" aria-hidden="true"
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback">
                                        <select name="otheraddress4" id="otheraddress4" class="form-control" placeholder="Country">
                                            <option value="" ></option>
                                            <?
                                            $countries = get_countries(); //this function is in customer helper
											foreach($countries as $data){
												echo '<option ';
												if($details->otheraddress4 == $data){
													echo 'selected="selected" ';
												}
												echo 'value="'.$data.'">'.$data.'</option>';
											}
											?>
                                        </select>
										<span class="glyphicon form-control-feedback" aria-hidden="true"
										<span class="help-block with-errors" ></span>
									</div>
                  <div class="form-group has-feedback">
											<input type="text" class="form-control" name="otherpostal_code" id="otherpostal_code" autocomplete="off" placeholder="Postal Code" value="<?=$details->otherpostal_code?>" data-error="">

											<span class="help-block with-errors" ></span>
									</div>
                                    <br>
                                    <h4 class="h4red">Other Details</h4>
									<div class="form-group has-feedback"><label >Land Phone</label>
										<input type="text" class="form-control" id="landphone" name="landphone" autocomplete="off" value="<?=$details->landphone?>" pattern="[0-9]{10}" placeholder="Land Phone" data-error="Invalid number"  >
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>

                                    <div class="form-group has-feedback"><label >Mobile Number</label>
										<input type="text" class="form-control" id="mobile" name="mobile" autocomplete="off" value="<?=$details->mobile?>"  placeholder="Mobile Number" data-error="Invalid number" required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback"><label >Fax Number</label>
										<input type="text" class="form-control" id="fax" name="fax" pattern="[0-9]{10}" value="<?=$details->fax?>" autocomplete="off" placeholder="Fax Number" data-error="Invalid number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                     <div class="form-group has-feedback"><label >Email</label>
										<input type="email" class="form-control" id="email" name="email"  value="<?=$details->email?>" autocomplete="off" placeholder="Email" data-error="That email address is invalid"  >
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
										<input type="text" class="form-control"name="acc1" id="acc1" value="<?=$myarra[1]['acc']?>" autocomplete="off"  placeholder="Account Number" data-error="" >

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
										<input type="text" class="form-control"name="acc2" id="acc2" value="<?=$myarra[2]['acc']?>"  autocomplete="off"  placeholder="Account Number" data-error=""  >

									</div>
                                    </div>
                                   <br>


									<div class="bottom validation-grids">

											<div class="form-group">
												<button type="submit" class="btn btn-primary disabled">Submit</button>
											</div>
											<div class="clearfix"> </div>
										</div>


							</div>
						</div>




					</form></div>

                    <div class="col-md-4 modal-grids">
						<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
						<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
										<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
									</div>
									<div class="modal-body" id="checkflagmessage">
									</div>
								</div>
							</div>
						</div>
					</div>
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirmImage" name="complexConfirmImage"  value="DELETE"></button>
                    <button type="button" style="display:none" class="btn btn-delete" id="complexConfirmImage2" name="complexConfirmImage2"  value="DELETE"></button>
<br /><br /><br /><br /></div>

<script>
$("#complexConfirmImage").confirm({
	title:"Delete confirmation",
	text: "Are you sure you want to delete this image?" ,
	headerClass:"modal-header",
	confirm: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		var code=1
		var image = document.editform.id_copy_front.value;
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'cm/customer/deleteImage/';?>',
            data: {image:image },
            success: function(data) {
                if (data) {
					alert('File has been deleted successfully');
					$('#files').html('');
					$('#deletefile').fadeOut('slow');
					$('#progress').fadeIn('slow');
					$('#addfile').fadeIn('slow');


                } else{
					alert('File not found');
					$('#files').html('');
					$('#deletefile').fadeOut('slow');
					$('#progress').fadeIn('slow');
					$('#addfile').fadeIn('slow');
				}
            }
        });
		//window.location="cm/customer/deleteImage/"+document.editform.id_copy_front.value;
	},
	cancel: function(button) {
		button.fadeOut(2000).fadeIn(2000);
	   // alert("You aborted the operation.");
	},
	confirmButton: "Yes I am",
	cancelButton: "No"
});

$("#complexConfirmImage2").confirm({
	title:"Delete confirmation",
	text: "Are you sure you want to delete this image?" ,
	headerClass:"modal-header",
	confirm: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		var code=1
		var image = document.editform.id_copy_back.value;
		$.ajax({
            cache: false,
            type: 'POST',
            url: '<?php echo base_url().'cm/customer/deleteImage/';?>',
            data: {image:image },
            success: function(data) {
                if (data) {
					alert('File has been deleted successfully');
					$('#files2').html('');
					$('#deletefile2').fadeOut('slow');
					$('#progress2').fadeIn('slow');
					$('#addfile2').fadeIn('slow');


                } else{
					alert('File not found');
					$('#files2').html('');
					$('#deletefile2').fadeOut('slow');
					$('#progress2').fadeIn('slow');
					$('#addfile2').fadeIn('slow');
				}
            }
        });
		//window.location="cm/customer/deleteImage/"+document.editform.id_copy_front.value;
	},
	cancel: function(button) {
		button.fadeOut(2000).fadeIn(2000);
	   // alert("You aborted the operation.");
	},
	confirmButton: "Yes I am",
	cancelButton: "No"
});
</script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?=base_url()?>media/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=base_url()?>media/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?=base_url()?>media/js/jquery.fileupload-validate.js"></script>
<script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : '<?=base_url()?>uploads/temp/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Processing...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });

    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                //.text('Upload')
				.hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
				$("#id_copy_front").val(file.name);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

	$('#fileupload2').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
		//maxNumberOfFiles: 5,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true,
		done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files2');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files2');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .hide()
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress2 .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile2").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
				$("#id_copy_back").val(file.name);

            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');


		//remove file when click delete
	  $('#files').on('click', 'a.delete', function (e) {
		  e.preventDefault();

		  var $link = $(this);

		  var req = $.ajax({
			dataType: 'json',
			url: $link.data('url'),
			type: 'DELETE'
		  });

		  req.success(function () {
			$link.closet('p').remove();
		  });
		 $("#addfile").show();
		 $("#files").html('');
		 $('#progress .progress-bar').css(
            'width',
            0 + '%'
        );
	  });

	  $('#files2').on('click', 'a.delete', function (e) {
		  e.preventDefault();

		  var $link = $(this);

		  var req = $.ajax({
			dataType: 'json',
			url: $link.data('url'),
			type: 'DELETE'
		  });

		  req.success(function () {
			$link.closet('p').remove();
		  });
		 $("#addfile2").show();
		 $("#files2").html('');
		 $('#progress2 .progress-bar').css(
            'width',
            0 + '%'
        );
	  });

document.getElementById('files2').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('files').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('oldfilesimg').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('oldfiles2img').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

});
</script>
