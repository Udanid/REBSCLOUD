<script>
		$(document).ready(function () {

		//Date of birth picker
		$("#dobDatepicker").datepicker({
				minDate: new Date(1900, 1 - 1, 1), maxDate: '-18Y',
				dateFormat: 'dd-MM-yy',
				defaultDate: new Date(1970, 1 - 1, 1),
				changeMonth: true,
				changeYear: true,
				yearRange: '-110:-18'
		});

		//datepicker for work experience and higher education
		$('body').on('focus', ".qualificationDatepicker, .weDatepicker", function () {

				$(this).datepicker({
						dateFormat: 'dd-MM-yy',
						changeMonth: true,
						changeYear: true,
						yearRange: '-50' + ':' + new Date().getFullYear()
				});
		});

		$("#emp_joining_date").datepicker({
				dateFormat: 'dd-MM-yy',
				changeMonth: true,
				changeYear: true,
				yearRange: '-50' + ':' + '+1'
		});

		$("#fuel_allowance_status").change(function () {
				var fuel_allowance_status = $('#fuel_allowance_status').val();
				if (fuel_allowance_status == "Y") {
						$("#vehicle_type_div").show();
						$("#initial_meter_reading_div").show();
						$("#fuel_allowance_maximum_limit_div").show();
				} else if (fuel_allowance_status == "N") {
						$("#vehicle_type_div").hide();
						$("#initial_meter_reading_div").hide();
						$("#fuel_allowance_maximum_limit_div").hide();
				}
		});

		//when succes close button pressed
		$(document).on('click', '#close-btn', function () {
				location.reload();
		});

});
</script>
<!--strart edit by dileep -->
<script type="text/javascript">
$(document).ready(function() {

		$("#higher_education_field_id").chosen({
			allow_single_deselect : true,
			search_contains: true,
			no_results_text: "Oops, nothing found!",
			placeholder_text_single: "Select an Option"

	});


		$.ajaxSetup ({
// Disable caching of AJAX responses
cache: false
},500);


});
</script>
<!-- end edit by dileep -->

<script>
function loadbranchlist(itemcode) {
		var code = itemcode.split("-")[0];
		if (code != '') {
				$("#bank_branch_load").load("<?php echo base_url();?>hr/hr_common/get_edit_bank_branchlist/" + itemcode + "/<?php echo $employee_details['id'];?>");
		}
}

// $(document).ready(function() {
// 	var bank_itemcode = document.getElementById("bank_code").value;
// 	loadbranchlist(bank_itemcode);
// });
</script>

<div id="page-wrapper">
<div class="main-page">

		<div class="modal-content">
				<div class="modal-body">
						<div class="row">
								<!--block which displays the outcome message-->
								<div id="messageBoard">
										<?php
										if ($this->session->flashdata('msg') != '') { ?>
												<div class="alert alert-success  fade in">
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
														</button>
														<?php echo $this->session->flashdata('msg'); ?>
												</div>
												<?php
										} ?>
										<?php
										if ($this->session->flashdata('error') != '') { ?>
												<div class="alert alert-danger  fade in">
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<span aria-hidden="true">&times;</span>
														</button>
														<?php echo $this->session->flashdata('error'); ?>
												</div>
												<?php
										} ?>
								</div>

								<div class="col-xs-12 form-container">
										<form enctype="multipart/form-data" class="userRegForm form-horizontal" id="inputform_1"
										name="inputform" method="post" action="<?= base_url() ?>hr/employee/update_edudatasubmit">
										<input type="hidden" name="employeeMasterID" id="employeeMasterID"
										value="<?php echo $employee_details['id']; ?>"/>

										<h3 class="title1">Education Details
												of <?php echo $employee_details['initial']; ?> <?php echo $employee_details['surname']; ?></h3>
												<div class="form-group">
														<div class="col-xs-10" style="float: right;">
																<a href="<?php echo base_url(); ?>hr/employee/employee_list">
																		<button type="button" class="btn btn-danger btn-lg "
																		data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request"
																		style="float: right;">Back
																</button>
														</a>
												</div>
										</div>


										<div class="panel panel-default">
												<div class="panel-heading">Qualifications</div>
												<div class="panel-body">

														<!--O/L header-->
														<div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
															 <span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
																 GCE Ordinary Level (O/L) <!--Padding is optional-->
														 </span>
												 </div>

												 <div class="alert alert-info">
														<strong>Notice - </strong> It is NOT mandatory to add all the O/L subjects,
														however incomplete paires (i.e empty subjects or grades) or providing only the
														school name without O/L results will be invalidated.
												</div>
												<? $school = '';
												if ($ol_details) {
														$school = $ol_details['school'];
														$path = $ol_details['document'];

														// print_r($path);
												}
												?>
												<!--*********O/L FIELDS**********-->
												<div class="form-group ol_input_fields_wrap">
														<div class="emp_rows col-xs-12">
																<div class="col-xs-4">
																		<button type="button" class="add_ol_subject_button btn btn-success">(+)
																				Add O/L Subject
																		</button>

																</div>
																<div class="col-xs-4">
																		<input type="text" class="form-control" name="olschoolname"
																		value="<?php echo $school ?>" placeholder="School name">
																</div>
																<div class="col-xs-4">
																		<div><?php if(!empty($path)){?>
																		<a href=<?=$path ?>>View Previous File</a><?php
																} ?></div>
																		<label for="oldocument">Upload Certificate</label>
																		<input type="file" id="oldocument" class="form-control" name="oldocument">
																</div>
														</div>

														<?php
														$ol_counter = 0;

														if (isset($ol_results)) {
																foreach ($ol_results as $ol_result_row) { ?>
																		<div class="emp_rows col-xs-12">
																				<div class="col-xs-4">
																						<input type="text" class="form-control"
																						id="ordinary_level[<?php echo $ol_counter; ?>][subject]"
																						name="ordinary_level[<?php echo $ol_counter; ?>][subject]"
																						value="<?php echo $ol_result_row['subject']; ?>"
																						placeholder="O/L Subject">
																				</div>
																				<div class="col-xs-4">
																						<input type="text" class="form-control"
																						id="ordinary_level[<?php echo $ol_counter; ?>][grade]"
																						name="ordinary_level[<?php echo $ol_counter; ?>][grade]"
																						value="<?php echo $ol_result_row['grade']; ?>"
																						placeholder="Grade">
																				</div>
																		</div>
																		<?php
																		$ol_counter++;
																}
														} else {
																$ol_counter = 1;
																?>
																<div class="emp_rows col-xs-12">
																		<div class="col-xs-4">
																				<input type="text" class="form-control"
																				name="ordinary_level[0][subject]"
																				id="ordinary_level[0][subject]" value=""
																				placeholder="O/L Subject">
																		</div>
																		<div class="col-xs-4">
																				<input type="text" class="form-control"
																				name="ordinary_level[0][grade]" id="ordinary_level[0][grade]"
																				value="" placeholder="Grade">
																		</div>
																</div>
																<?php
														} ?>
												</div>
												<input type="hidden" id="ol_input_fields_count" name="ol_input_fields_count"
												value="<?= $ol_counter ?>">
												<!--*********A/L FIELDS**********-->
												<div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
													 <span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
														 GCE Advanced Level (A/L) <!--Padding is optional-->
												 </span>
										 </div>
										 <? $school = '';
										 if ($al_details) {
												$school = $al_details['school'];
												$path = $al_details['document'];
										}
										?>
										<div class="alert alert-info">
												<strong>Notice -</strong> It is NOT mandatory to add all the A/L subjects,
												however incomplete paires (i.e empty subjects or grades) or providing only the
												school name without A/L results will be invalidated.
										</div>

										<div class="form-group al_input_fields_wrap">
												<div class="emp_rows col-xs-12">
														<div class="col-xs-4">
																<button type="button" class="add_al_subject_button btn btn-success">(+)
																		Add A/L Subject
																</button>
														</div>
														<div class="col-xs-4">
																<input type="text" class="form-control" value="<?php echo $school; ?>"
																placeholder="School name" name="alschoolname">
														</div>

														<div class="col-xs-4">
																<div><?php if(!empty($path)){?>
																		<a href=<?=$path ?>>View Previous File</a><?php
																} ?></div>
												<label for="aldocument">Upload Certificate</label>
										<input type="file" id="aldocument" class="form-control" name="aldocument">
									</div>
												</div>

												<?php
												$al_counter = 0;
												if (isset($al_results)) {
														foreach ($al_results as $al_result_row) { ?>
																<div class="emp_rows col-xs-12">
																		<div class="col-xs-4">
																				<input type="text" class="form-control"
																				name="advance_level[<?php echo $al_counter; ?>][subject]"
																				value="<?php echo $al_result_row['subject']; ?>"
																				placeholder="A/L Subject">
																		</div>
																		<div class="col-xs-4">
																				<input type="text" class="form-control"
																				name="advance_level[<?php echo $al_counter; ?>][grade]"
																				value="<?php echo $al_result_row['grade']; ?>"
																				placeholder="Grade">
																		</div>

																</div>
																<?php
																$al_counter++;
														}
												} else {
														$al_counter = 1;
														?>
														<div class="emp_rows col-xs-12">
																<div class="col-xs-4">
																		<input type="text" class="form-control"
																		name="advance_level[0][subject]" value=""
																		placeholder="A/L Subject">
																</div>
																<div class="col-xs-4">
																		<input type="text" class="form-control"
																		name="advance_level[0][grade]" value="" placeholder="Grade">
																</div>
														</div>
														<?php
												} ?>
										</div>
										<input type="hidden" id="al_input_fields_count" name="al_input_fields_count"
										value="<?= $al_counter ?>">
										<!--******** HIGHER EDUCATION FIELDS **********-->
										<div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
											 <span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
												 Higher Education <!--Padding is optional-->
										 </span>
								 </div>

								 <div class="alert alert-info">
										<strong>Notice - </strong> All the required fields (Qualification name,
										Institute name, Grade, and From and To dates) of each Higeher Education must be
										filled, otherwise your form will be invalidated.
								</div>

								<div class="form-group hq_input_fields_wrap">
										<div class="emp_rows col-xs-12">
												<div class="col-xs-12">
														<button type="button" class="add_hq_button btn btn-success">(+) Add
																Qualification
														</button>
												</div>
										</div>

										<?php
										$hq_counter = 0;
										if (isset($higher_education_details)) {
												foreach ($higher_education_details as $higher_education_details_row) { ?>
														<div class="emp_rows col-xs-12">

																<!-- start edit by dileep -->
																<div class="emp_rows col-xs-12">
																		<div class="col-xs-8">


																		 <select class="form-control" id="higher_education[<?php echo $hq_counter; ?>][name]" name="higher_education[<?php echo $hq_counter; ?>][name]">
																			 <option>Select Qualification</option>
																			 <?php
																			 foreach($higher_education_data as $data){
																					if ($data->id==$higher_education_details_row['name']){
																						?><option  selected value=<?php echo $data->id; ?>><?php echo $data->education_qualification_name; ?></option><?php
																				}else{
																						?><option   value=<?php echo $data->id; ?>><?php echo $data->education_qualification_name; ?></option><?php
																				}



																		} ?>
																</select>
														</div>

														<div class="col-xs-4">
																<div><?php if(!empty($higher_education_document[$hq_counter])){?>
																		<a href=<?=$higher_education_document[$hq_counter] ?>>View Previous File</a><?php
																} ?></div>
																<label for="hqdocument">Upload Certificate</label>
																<input type="file" id="hqdocument" class="form-control" name="hqdocument[<?php echo $hq_counter; ?>]"  >
														</div>

												</div>


												<div class="emp_rows col-xs-12">
														<div class="col-xs-8">


														 <select class="form-control" id="higher_education_field_id" name="higher_education[<?php echo $hq_counter; ?>][field]">
															 <option>Select Qualification Field</option>
															 <?php
															 foreach($qualification_field_data as $data){
																	if ($data->id==$higher_education_details_row['field']){
																		?><option  selected value=<?php echo $data->id; ?>><?php echo $data->qualification_field_name; ?></option><?php
																}else{
																		?><option   value=<?php echo $data->id; ?>><?php echo $data->qualification_field_name; ?></option><?php
																}



														} ?>
												</select>
										</div>

										<div class="col-xs-4">
										 <div><?php if(!empty($higher_education_transcript[$hq_counter])){?>
												<a href=<?=$higher_education_transcript[$hq_counter] ?>>View Previous File</a><?php
										} ?></div>
										<label for="hqtranscript">Upload Trancript</label>
										<input type="file" id="hqtranscript" class="form-control" name="hqtranscript[<?php echo $hq_counter; ?>]" >

								</div>
						</div>
						<!-- end edit by dileep -->
						<div class="emp_rows col-xs-12">
								<div class="col-xs-4">
										<input type="text" class="form-control"
										name="higher_education[<?php echo $hq_counter; ?>][institute]"
										value="<?php echo $higher_education_details_row['institute']; ?>"
										placeholder="Institute name"/>
								</div>
								<div class="col-xs-4">
										<input type="text" class="form-control"
										name="higher_education[<?php echo $hq_counter; ?>][grade]"
										value="<?php echo $higher_education_details_row['grade']; ?>"
										placeholder="Grade/Result"/>
								</div>
						</div>
						<div class="emp_rows col-xs-12">
								<!-- Ticket 2879 edit by dileep -->
								<div class="col-xs-4">
										<input type="text"
										class="form-control"
										name="higher_education[<?php echo $hq_counter; ?>][from]"
										value="<?php echo $higher_education_details_row['from']; ?>"
										placeholder="Year"/>
								</div>
								<!-- <div class="col-xs-4">
										<input type="text" readonly
										class="form-control qualificationDatepicker"
										name="higher_education[<?php echo $hq_counter; ?>][to]"
										value="<?php echo $higher_education_details_row['to']; ?>"
										placeholder="To"/>
								</div> -->

								 <!-- Ticket 2879 end -->
						</div>
						<div class="emp_rows col-xs-12">
								<div class="col-xs-8">
										<textarea style="resize:none" class="form-control" rows="5"
										name="higher_education[<?php echo $hq_counter; ?>][additionalInfo]"
										placeholder="Additional Info"><?php echo $higher_education_details_row['additionalInfo']; ?></textarea>
								</div>
						</div>
						<div class="emp_rows col-xs-12">
								<hr/>
						</div>
				</div>
				<?php
				$hq_counter++;
		}
} else {
		$hq_counter = 1;
		?>
		<div class="emp_rows col-xs-12">
				<!-- start edit by dileep -->

						<div class="col-xs-8">

						<select class="form-control" id="higher_education[0][name]" name="higher_education[0][name]">
							 <option>Select Qualification</option>
							 <?php
							 foreach($higher_education_data as $data){
									if ($data->id==$higher_education_details_row['name']){
										?><option  selected value=<?php echo $data->id; ?>><?php echo $data->education_qualification_name; ?></option><?php
								}else{
										?><option   value=<?php echo $data->id; ?>><?php echo $data->education_qualification_name; ?></option><?php
								}



						} ?>
				</select>
				</div>

				<div class="col-xs-4">
						<label for="hqdocument">Upload Certificate</label>
						<input type="file" id="hqdocument" class="form-control" name="hqdocument[]">
				</div>

</div>

<div class="emp_rows col-xs-12">
		<div class="col-xs-8">


		 <select class="form-control" id="higher_education_field_id" name="higher_education[0][field]">
			 <option>Select Qualification Field</option>


			 <?php
			 foreach($qualification_field_data as $data){
					if ($data->id==$higher_education_details_row['field']){
						?><option  selected value=<?php echo $data->id; ?>><?php echo $data->qualification_field_name; ?></option><?php
				}else{
						?><option   value=<?php echo $data->id; ?>><?php echo $data->qualification_field_name; ?></option><?php
				}



		} ?>
</select>
</div>
<div class="col-xs-4">
<label for="hqtranscript">Upload Transcript</label>
<input type="file" id="hqtranscript" class="form-control" name="hqtranscript[]">
</div>
</div>

<!-- end edit by dileep -->
<div class="emp_rows col-xs-12">
<div class="col-xs-4">
		<input type="text" class="form-control"
		name="higher_education[0][institute]" value=""
		placeholder="Institute name"/>
</div>
<div class="col-xs-4">
		<input type="text" class="form-control"
		name="higher_education[0][grade]" value=""
		placeholder="Grade/Result"/>
</div>
</div>
<div class="emp_rows col-xs-12">
<!-- Ticket 2879 edit by dileep -->
<div class="col-xs-4">
		<input type="text"
		class="form-control"
		name="higher_education[0][from]" value=""
		placeholder="Year"/>
</div>
<!-- <div class="col-xs-4">
		<input type="text" readonly
		class="form-control qualificationDatepicker"
		name="higher_education[0][to]" value=""
		placeholder="To"/>
</div> -->
<!-- Ticket 2879 end -->
</div>
<div class="emp_rows col-xs-12">
<div class="col-xs-8">
		<textarea style="resize:none" class="form-control" rows="5"
		name="higher_education[0][additionalInfo]"
		placeholder="Additional Info"></textarea>
</div>
</div>
<div class="emp_rows col-xs-12">
<hr/>
</div>
</div>
<?php
} ?>
<input type="hidden" id="hq_input_fields_count" name="hq_input_fields_count"
value="<?= $hq_counter ?>">
</div>

<!--******** WORK EXPERIENCE FIELDS **********-->
<div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
<span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
 Work Experience<!--Padding is optional-->
</span>
</div>
<div class="form-group xp_input_fields_wrap">
<div class="emp_rows col-xs-12">
		<div class="col-xs-12">
				<button type="button" class="add_xp_button btn btn-success"
				id="add_xp_button">(+) Add Experience
		</button>
</div>
</div>

<div class="emp_rows col-xs-12">
<?php
$work_exp_counter = 0;
if (isset($work_experience_details)) {
		foreach ($work_experience_details as $work_experience_details_row) { ?>
				<div class="emp_rows col-xs-12">
						<div class="col-xs-8">
								<input type="text" class="form-control"
								name="work_experience[<?php echo $work_exp_counter; ?>][job]"
								value="<?php echo $work_experience_details_row['job']; ?>"
								placeholder="Job Title"/>
						</div>
				</div>
				<div class="emp_rows col-xs-12">
						<div class="col-xs-8">
								<input type="text" class="form-control"
								name="work_experience[<?php echo $work_exp_counter; ?>][company]"
								value="<?php echo $work_experience_details_row['company']; ?>"
								placeholder="Company"/>
						</div>
				</div>
				<div class="emp_rows col-xs-12">
						<div class="col-xs-8">
								<input type="text" class="form-control"
								name="work_experience[<?php echo $work_exp_counter; ?>][location]"
								value="<?php echo $work_experience_details_row['location']; ?>"
								placeholder="Location"/>
						</div>
				</div>
				<div class="emp_rows col-xs-12">
						<div class="col-xs-4">
								<input type="text"
								class="form-control"
								name="work_experience[<?php echo $work_exp_counter; ?>][from]"
								value="<?php echo $work_experience_details_row['from']; ?>"
								placeholder="From"/>
						</div>
						<div class="col-xs-4">
								<input type="text"
								class="form-control"
								name="work_experience[<?php echo $work_exp_counter; ?>][to]"
								value="<?php echo $work_experience_details_row['to']; ?>"
								placeholder="To"/>
						</div>
				</div>
				<div class="emp_rows col-xs-12">
						<div class="col-xs-8">
								<textarea style="resize:none" class="form-control" rows="5"
								name="work_experience[<?php echo $work_exp_counter; ?>][additionalInfo]"
								placeholder="Additional Info"><?php echo $work_experience_details_row['additionalInfo']; ?></textarea>
						</div>
				</div>
				<div class="emp_rows col-xs-12">
						<hr/>
				</div>
				<?php
				$work_exp_counter++;
		}
} else {
		$work_exp_counter = 1;
		?>
		<div class="emp_rows col-xs-12">
				<div class="col-xs-8">
						<input type="text" class="form-control"
						name="work_experience[0][job]" value=""
						placeholder="Job Title"/>
				</div>
		</div>
		<div class="emp_rows col-xs-12">
				<div class="col-xs-8">
						<input type="text" class="form-control"
						name="work_experience[0][company]" value=""
						placeholder="Company"/>
				</div>
		</div>
		<div class="emp_rows col-xs-12">
				<div class="col-xs-8">
						<input type="text" class="form-control"
						name="work_experience[0][location]" value=""
						placeholder="Location"/>
				</div>
		</div>
		<div class="emp_rows col-xs-12">
				<div class="col-xs-4">
						<input type="text" class="form-control"
						name="work_experience[0][from]" value=""
						placeholder="From"/>
				</div>
				<div class="col-xs-4">
						<input type="text" class="form-control"
						name="work_experience[0][to]" value="" placeholder="To"/>
				</div>
		</div>
		<div class="emp_rows col-xs-12">
				<div class="col-xs-8">
						<textarea style="resize:none" class="form-control" rows="5"
						name="work_experience[0][additionalInfo]"
						placeholder="Additional Info"></textarea>
				</div>
		</div>
		<div class="emp_rows col-xs-12">
				<hr/>
		</div>
		<?php
} ?>
<input type="hidden" id="xp_input_fields_count" name="xp_input_fields_count"
value="<?= $work_exp_counter ?>">
</div>
</div>

</div>
</div>

<div class="form-group">
<div class="col-xs-10">
		<button type="submit" class="btn btn-primary btn-lg " id="formsubmitbtn"
		data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">
		Update Employee
</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>

</div>
</div>
<script src="<?= base_url() ?>media/js/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {

		/** ADD DYNAMIC FIELDS FOR O/L **/
		var ol_max_subjects = 10; //maximum input boxes allowed
		var ol_wrapper = $(".ol_input_fields_wrap"); //Fields wrapper
		var ol_add_button = $(".add_ol_subject_button"); //Add button ID

		var olCount = <?php echo $ol_counter; ?>; //initlal text box count
		$(ol_add_button).click(function (e) { //on add input button click
				e.preventDefault();
				if (olCount < ol_max_subjects) {
						olCount++;
						$(ol_wrapper).append('<div class="emp_rows col-xs-12">\
							 <div class="col-xs-4">\
							 <input type="text" class="form-control" name="ordinary_level[' + olCount + '][subject]" id="ordinary_level[' + olCount + '][subject]" placeholder="O/L Subject" />\
							 </div>\
							 <div class="col-xs-4">\
							 <input type="text" class="form-control" name="ordinary_level[' + olCount + '][grade]" id="ordinary_level[' + olCount + '][grade]" placeholder="O/L Grade" />\
							 </div>\
							 <div class="col-xs-4">\
							 <a href="#" class="remove_field btn btn-danger">Remove</a>\
							 </div>\
				</div>'); //add input box
						$("#ol_input_fields_count").val(olCount);
				}
				$('input[name*="ordinary_level"]').each(function () {
						$(this).rules('add', {
								required: true,  // example rule
								// another rule, etc.
								messages: {
										required: "Required input"
								}

						});
				});
		});

		$(ol_wrapper).on("click", ".remove_field", function (e) { //user click on remove text
				e.preventDefault();
				$(this).parent('div').parent('div').remove();
				olCount--;
				$("#ol_input_fields_count").val(olCount);
		})


		/** ADD DYNAMIC FIELDS FOR A/L **/
		var al_max_subjects = 5; //maximum input boxes allowed
		var al_wrapper = $(".al_input_fields_wrap"); //Fields wrapper
		var al_add_button = $(".add_al_subject_button"); //Add button ID
		var alCount = <?php echo $al_counter; ?>; //initlal text box count

		$(al_add_button).click(function (e) { //on add input button click
				e.preventDefault();
				if (alCount < al_max_subjects) {
						alCount++; //text box increment
						$(al_wrapper).append('<div class="emp_rows col-xs-12">\
							 <div class="col-xs-4">\
							 <input type="text" class="form-control" name="advance_level[' + alCount + '][subject]" placeholder="A/L Subject" />\
							 </div>\
							 <div class="col-xs-4">\
							 <input type="text" class="form-control" name="advance_level[' + alCount + '][grade]" placeholder="A/L Grade" />\
							 </div>\
							 <div class="col-xs-4">\
							 <a href="#" class="remove_field btn btn-danger">Remove</a>\
							 </div>\
				</div>'); //add input box
						$("#al_input_fields_count").val(alCount);
				}
				$('input[name*="advance_level"]').each(function () {
						$(this).rules('add', {
								required: true,  // example rule
								// another rule, etc.
								messages: {
										required: "Required input"
								}

						});
				});
		});

		$(al_wrapper).on("click", ".remove_field", function (e) { //user click on remove text
				e.preventDefault();
				$(this).parent('div').parent('div').remove();
				alCount--;
				$("#al_input_fields_count").val(alCount);
		})


		/** ADD DYNAMIC FIELDS FOR EDUCATION QUALIFICATIONS **/
		var hq_max_subjects = 15; //maximum input boxes allowed
		var hq_wrapper = $(".hq_input_fields_wrap"); //Fields wrapper
		var hq_add_button = $(".add_hq_button"); //Add button ID
		var hqCount = <?php echo $hq_counter; ?>; //initlal text box count

		$(hq_add_button).click(function (e) { //on add input button click
				e.preventDefault();
				if (hqCount < hq_max_subjects) {
						hqCount++;
						$(hq_wrapper).append('<div class="emp_rows col-xs-12">\
								<div class="emp_rows col-xs-12">\
								<div class="col-xs-8">\
								<select class="form-control" id="higher_education[' + hqCount + '][name]" name="higher_education[' + hqCount + '][name]">\
								<option>Select Qualification</option>\
								<?php
								foreach($higher_education_data as $data){ ?>
										<option value=<?php echo $data->id; ?>><?php echo $data->education_qualification_name; ?></option>\
										<?php
								} ?>
								</select>\
								</div>\
								<div class="col-xs-4">\
								<label for="hqdocument">Upload Certificate</label>\
								<input type="file" id="hqdocument[]" class="form-control" name="hqdocument[]">\
								</div>\
								</div>\
								<div class="emp_rows col-xs-12">\
								<div class="col-xs-8">\
								<select class="form-control" id="higher_education[' + hqCount + '][field]" name="higher_education[' + hqCount + '][field]">\
								<option>Select Qualification Field</option>\
								<?php
								foreach($qualification_field_data as $data){ ?>
										<option value=<?php echo $data->id; ?>><?php echo $data->qualification_field_name; ?></option>\
										<?php
								} ?>
								</select>\
								</div>\
								<div class="col-xs-4">\
								<label for="hqtranscript">Upload Documents</label>\
								<input type="file" id="hqtranscript[]" class="form-control" name="hqtranscript[]">\
								</div>\
								</div>\
								<div class="emp_rows col-xs-12">\
								<div class="col-xs-4">\
								<input type="text" class="form-control" name="higher_education[' + hqCount + '][institute]" placeholder="Institute name" />\
								</div>\
								<div class="col-xs-4">\
								<input type="text" class="form-control" name="higher_education[' + hqCount + '][grade]" placeholder="Grade" />\
								</div>\
								</div>\
								<div class="emp_rows col-xs-12">\
								<div class="col-xs-4">\
								<input type="text" class="form-control" name="higher_education[' + hqCount + '][from]" placeholder="Year" />\
								</div>\
								</div>\
								<div class="emp_rows col-xs-12">\
								<div class="col-xs-8">\
								<textarea style="resize:none" class="form-control" rows="5" name="higher_education[' + hqCount + '][additionalInfo]" placeholder="Additional Info"></textarea>\
								</div>\
								</div>\
								<div class="emp_rows col-xs-12">\
								<div class="col-xs-4">\
								<a href="#" class="remove_field btn btn-danger">Remove</a>\
								</div>\
								</div>\
		</div>'); //add input box
						$("#hq_input_fields_count").val(hqCount);
				}
				$('input[name*="higher_education"]').each(function () {
						$(this).rules('add', {
								required: true,  // example rule
								// another rule, etc.
								messages: {
										required: "Required input"
								}

						});
				});
		});

		$(hq_wrapper).on("click", ".remove_field", function (e) { //user click on remove text
				e.preventDefault();
				$(this).parent('div').parent('div').parent('div').remove();
				hqCount--;
				$("#hq_input_fields_count").val(hqCount);
		})


		/** ADD DYNAMIC FIELDS FOR WORK EXPERIENCE **/
		var xp_max = 15; //maximum input boxes allowed
		var xp_wrapper = $(".xp_input_fields_wrap"); //Fields wrapper
		var xp_add_button = $(".add_xp_button"); //Add button ID

		var xpCount = <?php echo $work_exp_counter; ?> //initlal text box count

				$(xp_add_button).click(function (e) { //on add input button click
						e.preventDefault();
						if (xpCount < xp_max) {
								xpCount++; //text box increment
								$(xp_wrapper).append('<div class="emp_rows col-xs-12">\
									 <div class="emp_rows col-xs-12">\
									 <div class="col-xs-8">\
									 <input type="text" class="form-control" name="work_experience[' + xpCount + '][job]" placeholder="Job Title" />\
									 </div>\
									 </div>\
									 <div class="emp_rows col-xs-12">\
									 <div class="col-xs-8">\
									 <input type="text" class="form-control" name="work_experience[' + xpCount + '][company]" placeholder="Company" />\
									 </div>\
									 </div>\
									 <div class="emp_rows col-xs-12">\
									 <div class="col-xs-8">\
									 <input type="text" class="form-control" name="work_experience[' + xpCount + '][location]" placeholder="Location" />\
									 </div>\
									 </div>\
									 <div class="emp_rows col-xs-12">\
									 <div class="col-xs-4">\
									 <input type="text" class="form-control" name="work_experience[' + xpCount + '][from]" placeholder="From" />\
									 </div>\
									 <div class="col-xs-4">\
									 <input type="text" class="form-control" name="work_experience[' + xpCount + '][to]" placeholder="To" />\
									 </div>\
									 </div>\
									 <div class="emp_rows col-xs-12">\
									 <div class="col-xs-8">\
									 <textarea style="resize:none" class="form-control" rows="5" name="work_experience[' + xpCount + '][additionalInfo]" placeholder="Additional Info"></textarea>\
									 </div>\
									 </div>\
									 <div class="emp_rows col-xs-12">\
									 <div class="col-xs-4">\
									 <a href="#" class="remove_field btn btn-danger">Remove</a>\
									 </div>\
									 </div>\
				</div>'); //add input box
								$("#xp_input_fields_count").val(xpCount);
						}
						$('input[name*="work_experience"]').each(function () {
								$(this).rules('add', {
										required: true,  // example rule
										// another rule, etc.
										messages: {
												required: "Required input"
										}

								});
						});
				});

		$(xp_wrapper).on("click", ".remove_field", function (e) { //user click on remove text
				e.preventDefault();
				$(this).parent('div').parent('div').parent('div').remove();
				xpCount--;
				$("#xp_input_fields_count").val(xpCount);
		})

});
</script>

<!-- <script>

jQuery(document).ready(function () {

//validate all fields
$.validator.setDefaults({ignore: ":hidden:not(.chosen-select)"});


$("#inputform_1").validate({
				submitHandler: function (form) { // <- you missed the 'form' argument
						form.submit(); // <- you can use the 'form' argument here
						/* you don't need the timer here,
						so if you remove it, then there is
						no point in having the 'submitHandler' at all,
						as 'form.submit()' is already the default.
						Just remove the 'submitHandler' entirely. */
				}

		});
$('input[name=olschoolname]').each(function () {
$(this).rules("add", "required");
});

$('input[name*="ordinary_level"]').each(function () {
$(this).rules('add', {
						required: true,  // example rule
						// another rule, etc.
						messages: {
								required: "Required input"
						}

				});
});


});

</script> -->
