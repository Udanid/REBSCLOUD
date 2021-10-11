<!--For webcam capture-->
<style type="text/css">
    #results { padding:10px; border:1px solid #CCC; background:#fff; }
</style>
<!--//for webcam capture-->
<script>
	document.getElementById('confirm-but').disabled = true;
 	$( "#dob" ).datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
        });
	$( "#id_doi" ).datepicker({
            dateFormat : 'yy-mm-dd',
            changeMonth : true,
            changeYear : true,
            yearRange: '-100y:c+nn',
            maxDate: '-1d'
        });
	$("#title").chosen({
		 allow_single_deselect : true
		});
		$("#gender").chosen({
		 allow_single_deselect : true
		});
		$("#civilstatus").chosen({
		 allow_single_deselect : true
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

		$("#citizenship").chosen({
		 allow_single_deselect : true
		});
		$("#civil_status").chosen({
		 allow_single_deselect : true
		});
		$("#raddress_ownership").chosen({
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
					if(field=='customer_photo'){
						$('#customer_photo_webcam').hide().fadeIn('slow');
					}
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
                        <div class="row">
						     <div class="col-md-6 validation-grids widget-shadow" data-example-id="basic-forms">
							<div class="form-title">
								<h5>Personal Information :</h5>
							</div>
							<div class="form-body editform">
								<div class="form-inline">
									<div class="form-group">


                                    <input type="hidden" name="cus_code" id="cus_code" value="<?=$details->cus_code?>">
                                    <input type="hidden" name="custtype" id="custtype" value="<?=$details->cus_type?>">

                                    <label >Title</label>
                                    <select name="title" style="width:100%;" id="title" class="form-control" placeholder="Title" required>
                                    <option value="">Title</option>
                                    <option value="Mr" <? if($details->title=='Mr'){?> selected="selected"<? }?>>Mr</option>
                                    <option value="Mrs" <? if($details->title=='Mrs'){?> selected="selected"<? }?>>Mrs</option>
                                    <option value="Miss" <? if($details->title=='Miss'){?> selected="selected"<? }?>>Miss</option>
                                    <option value="Ms"  <? if($details->title=='Ms'){?> selected="selected"<? }?>>Ms</option>
                                    <option value="Dr"  <? if($details->title=='Dr'){?> selected="selected"<? }?>>Dr</option>
                                     <option value="Rev"  <? if($details->title=='Rev'){?> selected="selected"<? }?>>Rev</option>

                                    </select>

									</div>
                                    <div class="form-group has-feedback"><label >Name with Initials</label>
										<input type="text" class="form-control" style="width:100%;" name="first_name" autocomplete="off" id="first_name"  value="<?=$details->first_name?>" placeholder="Name with Initials" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
									</div>
                              </div>
									<div class="form-group has-feedback"><label >Last Name</label>
										<input type="text" class="form-control"name="last_name" id="last_name" autocomplete="off" value="<?=$details->last_name?>" placeholder="Last Name" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback"><label >Full Name According to Identification Document</label>
										<input type="text" class="form-control"name="full_name" id="full_name" autocomplete="off" value="<?=$details->full_name?>" placeholder="Full Name According to Identification Document" data-error=""  required>
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback"><label >Other Names (Maiden Name)</label>
										<input type="text" class="form-control"name="other_names" id="other_names" autocomplete="off" value="<?=$details->other_names?>" placeholder="Other Names (Maiden Name)" data-error="">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group has-feedback"><label >Name in Sinhala Unicode</label>
										<input type="text" class="form-control"name="unicode_name" id="unicode_name" autocomplete="off" value="<?=$details->unicode_name?>" placeholder="Name in Sinhala Unicode" data-error="">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors"></span>
									</div>
                                    <div class="form-group">
                                    	<label >Are You a Citizen of Sri Lanka?</label>
                                        <select name="citizenship" id="citizenship" class="form-control" placeholder="Citizenship">
                                        	<option value="">Select..</option>
                                            <option value="no" <? if ($details->citizenship=='no'){?> selected="selected"<? }?>>No</option>
                                            <option value="descent" <? if ($details->citizenship=='descent'){?> selected="selected"<? }?>>Yes/by Descent</option>
                                            <option value="registration" <? if ($details->citizenship=='registration'){?> selected="selected"<? }?>>Yes/by Registration</option>
                                        </select>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <label >Date of Birth</label>
                                            <input type="text" class="form-control" style="width:100%;" name="dob" id="dob" value="<?=$details->dob?>" autocomplete="off" placeholder="Date of Birth"  >
                                        </div>
                                        <div class="form-group">
                                        	<label >Place of Birth</label>
                                            <input type="text" class="form-control" style="width:100%;" name="pob" id="pob" value="<?=$details->pob?>" autocomplete="off" placeholder="Place of Birth">
                                        </div>
                                     </div>

                                     <div class="form-inline">
                                        <div class="form-group">
                                            <label >Gender</label>
                                            <select name="gender" style="width:100%;"  id="gender" class="form-control" placeholder="Gender" required>
                                                <option value="Male" <? if($details->gender=='Male'){?> selected="selected"<? }?>>Male</option>
                                                <option value="Female" <? if($details->gender=='Female'){?> selected="selected"<? }?>>Female</option>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                        	<label >Marital Status</label>
                                            <select name="civil_status" id="civil_status" style="width:100%;" onChange="showSpouse();" class="form-control" placeholder="Marital Status" required>
                                                <option value="single" <? if($details->civil_status=='single'){?> selected="selected"<? }?>>Single</option>
                                                <option value="married" <? if($details->civil_status=='married'){?> selected="selected"<? }?>>Married</option>
                                            </select>
                                        </div>

                                    </div>
                                    <!--starts spouse block-->
                                    <div id="spouse" <? if($details->civil_status == 'single' ){?> style="display:none;" <? }?>>
                                        <br>
                                        <br>
                                        <h5><strong>Family Information</strong></h5>
                                        <br>
                                        <div class="form-group has-feedback">
                                        	<label >Name of the Spouse</label>
                                            <input type="text" class="form-control" name="spouse_name" id="spouse_name" value="<?=$details->spouse_name?>" autocomplete="off" placeholder="Name of the Spouse" data-error="">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                        <div class="form-group">
                                        	<label >Employer of the Spouse</label>
                                            <input type="text" class="form-control" name="spouse_employer" id="spouse_employer" value="<?=$details->spouse_employer?>" autocomplete="off" placeholder="Employer of the Spouse">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors"></span>
                                        </div>
                                        <div class="form-inline">


                                            <div class="form-group">
                                            	<label >Designation</label>
                                                <input type="text" class="form-control" style="width:100%;" name="spouse_designation" id="spouse_designation" value="<?=$details->spouse_designation?>" autocomplete="off" placeholder="Designation">
                                            </div>
                                            <div class="form-group">
                                            	<label >Income</label>
                                                <input type="number" class="form-control" style="width:100%;" name="spouse_income" id="spouse_income" value="<?=$details->spouse_income?>" autocomplete="off" placeholder="Income">
                                            </div>
                                            <div class="form-group">
                                            	<label >Dependents</label>
                                                <input type="number" class="form-control" style="width:100%;" name="dependent" id="dependent" value="<?=$details->dependent?>" autocomplete="off" placeholder="Number of Dependents">
                                            </div>


                                        </div>
                                    </div>
                                    <!--ends spouse block-->
                                    <!-- <div class="form-group" id="customer_photo_webcam" <? if($details->customer_photo){?> style="display:none;" <? }?>>
                                        <br><br>
                                        <div class="row" style="margin-top:5px;">
                                            <div class="col-sm-6">
                                                    <h5><strong>Customer Photo (Webcam)</strong></h5>
                                                    <div id="my_camera"></div>
                                                    <input type=button value="Take Snapshot" class="btn btn-info" onClick="take_snapshot()">
                                                    <input type="hidden" name="webcamimage" id="webcamimage" class="image-tag">
                                            </div>
                                            <div class="col-sm-6">
                                                    <div class="col-md-6">
                                                        <br><br>
                                                        <span id="results_span"><a id="results_anchor" href="#"><div id="results">Captured image will appear here...</div></a></span>
                                                    </div>
                                                    <div class="col-md-12 text-center">
                                                        <br/>
                                                        <button class="btn btn-success" id="confirm-but">Confirm</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <br><br>
                                        <div class="row" style="margin-top:5px;">
                                            <div class="col-sm-6">
                                                    <h5><strong>Customer Photo (Manual Upload)</strong></h5>
                                                    <div id="ccustomer_photo" <? if($details->customer_photo){?> style="display:none;" <? }?>>
                                                        <span id="addfile3" class="btn btn-success fileinput-button" style="width:25%;">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                            <span></span>
                                                            <!-- The file input field used as target for the file upload widget -->
                                                            <input id="fileupload3" type="file" name="files">
                                                            <input type="hidden" name="customer_photo" id="customer_photo" value="<?=$details->customer_photo?>">
                                                            <div id="upfiles3" class="upfiles3"></div>
                                                        </span>

                                                        <!-- The global progress bar -->
                                                        <div id="progress3" class="progress">
                                                            <div class="progress-bar progress-bar-success"></div>
                                                        </div>
                                                        <!-- The container for the uploaded files -->
                                                        <div id="files3" class="files" style="width:25%;"></div>
                                                        <!-- The container for the uploaded files -->
                                                    </div>
                                                    <br />
                                                    <span id="oldfiles3">
                                                    <? if ($details->customer_photo){?>
                                                    	<span id="oldfiles3img">
                                                        	<a class="photo" href="<?=base_url()?>uploads/customer_ids/<?=$details->customer_photo?>"><img style="border:1px solid #CCC;" src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->customer_photo?>" /></a>&nbsp;&nbsp;&nbsp;
                                                        </span>
                                                        <a href="#" onclick="deleteDoc('<?=$details->customer_photo?>','customer_photo','oldfiles3','<?=$details->cus_code?>');"><i class="fa fa-times" style="color:red;"></i></a>
                                                    <? }else{?>
                                            			<span id="oldfiles3img"></span>
                                            		<? }?>
                                                    </span>
                                            </div>
                                            <div class="col-sm-6">
                                                    <h5><strong>Signature</strong></h5>
                                                    <div id="csignature" <? if($details->signature){?> style="display:none;" <? }?>>
                                                        <span id="addfile4" class="btn btn-success fileinput-button" style="width:25%;">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                            <span></span>
                                                            <!-- The file input field used as target for the file upload widget -->
                                                            <input id="fileupload4" type="file" name="files">
                                                            <input type="hidden" name="signature" id="signature" value="<?=$details->signature?>">
                                                            <div id="upfiles4" class="upfiles4"></div>
                                                        </span>

                                                        <!-- The global progress bar -->
                                                        <div id="progress4" class="progress">
                                                            <div class="progress-bar progress-bar-success"></div>
                                                        </div>
                                                        <!-- The container for the uploaded files -->
                                                        <div id="files4" class="files" style="width:25%;"></div>
                                                    </div>
                                                    <br />
                                                    <span id="oldfiles4">
                                                    <? if ($details->signature){?>
                                                    	<span id="oldfiles4img">
                                                        	<a href="<?=base_url()?>uploads/customer_ids/<?=$details->signature?>"><img style="border:1px solid #CCC;" src="<?=base_url()?>uploads/customer_ids/thumbnail/<?=$details->signature?>" /></a>&nbsp;&nbsp;&nbsp;
                                                        </span>
                                                        <a href="#" onclick="deleteDoc('<?=$details->signature?>','signature','oldfiles4','<?=$details->cus_code?>');"><i class="fa fa-times" style="color:red;"></i></a>
                                                    <? }else{?>
                                            			<span id="oldfiles4img"></span>
                                            		<? }?>
                                                    </span>
                                            </div>
                                        </div>
                                    </div>
                                    <br /><br />
                                    <div class="form-group">
                                    	<h5><strong>Identification Document Type</strong></h5>

										<div class="radio">
											<label>
											  <input type="radio" name="id_type" id="id_type[]" value="NIC" onClick="check_is_exsit();"   <? if($details->id_type=='NIC'){?> checked="checked"<? }?> required>
											  NIC
											</label>
										</div>
										<div class="radio">
											<label>
											<input type="radio"  name="id_type" id="id_type[]" value="Passport" onClick="check_is_exsit();"  <? if($details->id_type=='Passport'){?> checked="checked"<? }?> required>
											Passport
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
									<div class="form-group">
                                    	<h5><strong>Upload NIC Front/Passport
                                         <!-- <i style="color:#CC3300;">(required)</i> ticket 3123 -->
                                       </strong></h5>
                                        <div id="cid_copy_front" <? if($details->id_copy_front){?> style="display:none;"<? }?>>
                                            <span id="addfile" class="btn btn-success fileinput-button" style="width:25%; ">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Add file</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload" type="file" name="files">
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

                                        <div id="files" class="files" style="width:25%;">

                                        </div>

                                       <br /><br />
                                        <span id="documentback">
                                            <h5><strong>Upload NIC Back</strong></h5>
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
                            	<div class="form-title">
                                    <h5>Employment Information :</h5>
                                </div>
                                <div class="form-body">
                                      <div class="form-group has-feedback"><label >Occupation/Profession</label>
                                          <input type="text" class="form-control" id="occupation" name="occupation" autocomplete="off" value="<?=$details->occupation?>"  placeholder="Occupation/Profession" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Name of the Employer</label>
                                          <input type="text" class="form-control" id="employer" name="employer" autocomplete="off" value="<?=$details->employer?>"  placeholder="Name of the Employer" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Address of the Employer</label>
                                            <textarea class="form-control" id="employer_address" name="employer_address" autocomplete="off" placeholder="Address of the Employer" ><?=$details->employer_address?></textarea>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                            <span class="help-block with-errors" ></span>
                                        </div>
                                      <div class="form-group has-feedback"><label >Employer Phone</label>
                                          <input type="text" class="form-control" id="employer_phone" name="employer_phone"  autocomplete="off" value="<?=$details->employer_phone?>" placeholder="Employer Phone" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Monthly Income</label>
                                          <input type="number" class="form-control" id="monthly_income" name="monthly_income"  autocomplete="off" value="<?=$details->monthly_income?>" placeholder="Monthly Income" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback">
                                      		<label >Principal Source of Income</label>
                                          <input type="text" class="form-control" id="income_source" name="income_source"  autocomplete="off" value="<?=$details->income_source?>" placeholder="Principal Source of Income" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Monthly Expenses</label>
                                          <input type="number" class="form-control" id="monthly_expence" name="monthly_expence"  autocomplete="off" value="<?=$details->monthly_expence?>" placeholder="Monthly Expenses" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Savings</label>
                                          <input type="number" class="form-control" id="savings" name="savings"  autocomplete="off" value="<?=$details->savings?>" placeholder="Savings" data-error="">
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Movable Properties</label>
                                          <textarea class="form-control" id="moveable_property" name="moveable_property" placeholder="Movable Properties" data-error=""><?=$details->moveable_property?></textarea>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>
                                      <div class="form-group has-feedback"><label >Immovable Properties</label>
                                      		<textarea class="form-control" id="imovable_property" name="imovable_property" placeholder="Immovable Properties" data-error=""><?=$details->imovable_property?></textarea>
                                          <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                          <span class="help-block with-errors" ></span>
                                      </div>

                                </div>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
							<div class="widget-shadow" data-example-id="basic-forms">
								<div class="form-title">
									<h5>Contact Information :</h5>
								</div>
								<div class="form-body">


                                    <h4 class="h4red">Residential Address</h4>
                                    <div class="form-group has-feedback"><label >Address Line 1</label>
                                        <input type="text" class="form-control" id="raddress1" name="raddress1"  autocomplete="off" value="<?=$details->raddress1?>" placeholder="Address Line 1" data-error=""  required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                     <div class="form-group has-feedback"><label >Address Line 2</label>
                                        <input type="text" class="form-control" id="raddress2" name="raddress2" autocomplete="off"  value="<?=$details->raddress2?>" placeholder="Address Line 2" data-error="" required="required">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback"><label >City</label>
                                        <input type="text" class="form-control" name="raddress3" id="raddress3" autocomplete="off" value="<?=$details->raddress3?>" placeholder="City" required="required">

                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" name="rpostal_code" id="rpostal_code" autocomplete="off" value="<?=$details->rpostal_code?>" placeholder="Postal Code" data-error="">

                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback"><label >How Long Resident at Above Address?</label>
                                        <input type="text" class="form-control" id="raddress_duration" name="raddress_duration" autocomplete="off"  value="<?=$details->raddress_duration?>" placeholder="How Long Resident at Above Address?" data-error="" >
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group">
                                    	<label >Ownership of the Residency</label>
                                        <select name="raddress_ownership" id="raddress_ownership" class="form-control" placeholder="Ownership of the Residency">
                                        	<option value="">Select</option>
                                            <option value="owner" <? if ($details->raddress_ownership=='owner'){?> selected="selected"<? }?>>Owner</option>
                                            <option value="tenant" <? if ($details->raddress_ownership=='tenant'){?> selected="selected"<? }?>>Tenant</option>
                                            <option value="boarder" <? if ($details->raddress_ownership=='boarder'){?> selected="selected"<? }?>>Boarder</option>
                                        </select>
                                    </div>
                                   	<br>
                                    <h4 class="h4red">Postal Address </h4><span id="sameas"><p><input type="checkbox" name="same" id="same" onClick="copyAbove();">  Same as Above</p></span>
                                    <div class="form-group has-feedback"><label >Address Line 1</label>
                                        <input type="text" class="form-control" id="address1" name="address1" autocomplete="off"  value="<?=$details->address1?>" placeholder="Address Line 1" data-error=""  required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                     <div class="form-group has-feedback"><label >Address Line 2</label>
                                        <input type="text" class="form-control" id="address2" name="address2" autocomplete="off"  value="<?=$details->address2?>" placeholder="Address Line 2" data-error="" required="required">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <span class="help-block with-errors" ></span>
                                    </div>
                                    <div class="form-group has-feedback"><label >City</label>
                                        <input type="text" class="form-control" name="address3" id="address3" autocomplete="off" value="<?=$details->address3?>" placeholder="City" required="required">

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
                                    <div class="form-group has-feedback"><label >Work Phone</label>
										<input type="text" class="form-control" id="workphone" name="workphone" autocomplete="off"  value="<?=$details->workphone?>"  placeholder="Work Phone" data-error="Invalid number">
										<span class="glyphicon form-control-feedback" aria-hidden="true"></span>
										<span class="help-block with-errors" ></span>
									</div>
                                    <div class="form-group has-feedback"><label >Mobile Number</label>
										<input type="text" class="form-control" id="mobile" name="mobile" autocomplete="off" value="<?=$details->mobile?>"  placeholder="Mobile Number" data-error="Invalid number">
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
									<div class="form-group"><label >Bank Name</label>
                                    <select name="bank1" id="bank1" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'1')" >
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>" <? if($myarra[1]['bank']==$raw->BANKCODE){?> selected="selected"<? }?>><?=$raw->BANKNAME?></option>
                    <? }?>

                                    </select>
										</div>&nbsp;<div class="form-group" id="branch-1"><label >Branch</label>
										 <select name="branch1" id="branch1" class="form-control" placeholder="Bank" >
                                    <option value="<?=$myarra[1]['branch']?>"><?=$myarra[1]['branch']?></option>


                                    </select>
									</div>
                                    <div class="form-group has-feedback"><label >Account Number</label>
										<input type="text" class="form-control"name="acc1" id="acc1" value="<?=$myarra[1]['acc']?>"  autocomplete="off" placeholder="Account Number" data-error="" >

									</div>
                                    </div>
                                     <br>

                                    	<div class="form-inline">
									<div class="form-group"><label >Bank Name</label>
                                    <select name="bank2" id="bank2" class="form-control" placeholder="Bank" onChange="loadbranchlist(this.value,'2')">
                                    <option value="">Bank</option>
                                     <? foreach ($banklist as $raw){?>
                    <option value="<?=$raw->BANKCODE?>"  <? if($myarra[2]['bank']==$raw->BANKCODE){?> selected="selected"<? }?> ><?=$raw->BANKNAME?></option>
                    <? }?>

                                    </select>
										</div>&nbsp;<div class="form-group"  id="branch-2"><label >Branch</label>
										 <select name="branch2" id="branch2" class="form-control" placeholder="Bank" >
                                    <option value="<?=$myarra[2]['branch']?>"><?=$myarra[2]['branch']?></option>


                                    </select>
									</div>
                                    <div class="form-group has-feedback" ><label >Account NUmber</label>
										<input type="text" class="form-control"name="acc2" id="acc2" value="<?=$myarra[2]['acc']?>" autocomplete="off"   placeholder="Account Number" data-error=""  >
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

	$('#fileupload3').fileupload({
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
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files3');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files3');
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
        $('#progress3 .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile3").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
				$("#customer_photo").val(file.name);
				//$("#webcamimage").val('');

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
		//end file upload 3
	$('#fileupload4').fileupload({
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
                $('<p/>').html('<a href="#" class="text-danger delete" data-type="' + file.deleteType + '" data-url="' + file.deleteUrl + '" title="Delete">Delete</a>').appendTo('#files4');
            });
        }
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files4');
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
        $('#progress4 .progress-bar').css(
            'width',
            progress + '%'
        );
		$("#addfile4").hide();

    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);

                $(data.context.children()[index])
                    .wrap(link);
				$("#signature").val(file.name);

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
	  $('#files3').on('click', 'a.delete', function (e) {
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
		 $("#addfile3").show();
		 $("#files3").html('');
		 $('#progress3 .progress-bar').css(
            'width',
            0 + '%'
        );
	  });
	  $('#files4').on('click', 'a.delete', function (e) {
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
		 $("#addfile4").show();
		 $("#files4").html('');
		 $('#progress4 .progress-bar').css(
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
document.getElementById('files3').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};
document.getElementById('files4').onclick = function (event) {
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
document.getElementById('oldfiles3img').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};

document.getElementById('oldfiles4img').onclick = function (event) {
    event = event || window.event;
    var target = event.target || event.srcElement,
        link = target.src ? target.parentNode : target,
        options = {index: link, event: event},
        links = this.getElementsByTagName('a');
    blueimp.Gallery(links, options);
};


});
</script>
<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    /*Webcam.set({
        width: 300,
        height: 300,
		dest_width: 480,
    	dest_height: 480,
		//dest_width: 600,
    	//dest_height: 600,
        image_format: 'jpeg',
        jpeg_quality: 100
    });

    Webcam.attach( '#my_camera' ); */

   function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img width="75" src="'+data_uri+'"/>';
			document.getElementById('confirm-but').disabled = false;
			$('#confirm-but').html('Confirm');
        } );
    }

</script>
 <script>
 	$('#confirm-but').on("click", function(e){
		e.preventDefault();
		//processWebcam();
	});

	//webcam form action
	function processWebcam(){
		  //event.preventDefault();
		  document.getElementById('confirm-but').disabled = true;
		  $('#confirm-but').html('Please Wait');
		  var webcam_image = document.getElementById("webcamimage").value;
		  //alert(webcam_image);
		  $.ajax({
			  cache: false,
			  type: 'POST',
			  url: '<?php echo base_url().'cm/customer/webcam_image';?>',
			  data: {webcam_image:webcam_image},
			  success: function(data) {
				  if (data) {
					  $('#confirm-but').html('Uploaded');
					  //document.getElementById("webcamimage").value = data;
					  document.getElementById("customer_photo").value = data;
					  var newURL = '<?php echo base_url()?>uploads/temp/' + data;
					  document.getElementById('results_anchor').href = newURL;
					  document.getElementById('results_span').onclick = function (event) {
						  event = event || window.event;
						  var target = event.target || event.srcElement,
							  link = target.src ? target.parentNode : target,
							  options = {index: link, event: event},
							  links = this.getElementsByTagName('a');
						  blueimp.Gallery(links, options);
					  };
				  }
				  else
				  {
					  alert('Unable to upload the image. Please use manual upload option!');
				  }
			  }
		  });
	}



</script>
