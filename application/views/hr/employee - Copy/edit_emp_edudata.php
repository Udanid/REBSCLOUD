<script>
	$(document).ready(function() {

  		//Date of birth picker
  		$("#dobDatepicker").datepicker({
    		minDate: new Date(1900,1-1,1), maxDate: '-18Y',
    		dateFormat: 'dd-MM-yy',
    		defaultDate: new Date(1970,1-1,1),
    		changeMonth: true,
    		changeYear: true,
    		yearRange: '-110:-18'
  		});

  		//datepicker for work experience and higher education
  		$('body').on('focus',".qualificationDatepicker, .weDatepicker", function(){
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

		$("#fuel_allowance_status").change(function(){
			var fuel_allowance_status = $('#fuel_allowance_status').val();
			if(fuel_allowance_status == "Y"){
				$("#vehicle_type_div").show();
				$("#initial_meter_reading_div").show();
				$("#fuel_allowance_maximum_limit_div").show();
			}else if(fuel_allowance_status == "N"){
				$("#vehicle_type_div").hide();
				$("#initial_meter_reading_div").hide();
				$("#fuel_allowance_maximum_limit_div").hide();
			}
		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

<script>
	function loadbranchlist(itemcode){
		var code = itemcode.split("-")[0];
		if(code != ''){
			$("#bank_branch_load").load("<?php echo base_url();?>hr/hr_common/get_edit_bank_branchlist/"+itemcode+"/<?php echo $employee_details['id'];?>");
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
		  <div id="messageBoard"></div>

		  <div class="col-xs-12 form-container">
			<form enctype="multipart/form-data" class="userRegForm form-horizontal" id="inputform" name="inputform" method="post" action="<?=base_url()?>hr/employee/update_edudatasubmit">
			  <input type="hidden" name="employeeMasterID" id="employeeMasterID" value="<?php echo $employee_details['id']; ?>" />
				<div class="form-group">
					<div class="col-xs-10" style="float: right;">
						<a href="<?php echo base_url();?>hr/employee/employee_list"><button type="button" class="btn btn-danger btn-lg " data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request" style="float: right;">Skip</button></a>
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
					<strong>Notice - </strong> It is NOT mandatory to add all the O/L subjects, however incomplete paires (i.e empty subjects or grades) or providing only the school name without O/L results will be invalidated.
				  </div>
<? $school='';
if($ol_details)
{
	$school=$ol_details['school'];
}
?>
				  <!--*********O/L FIELDS**********-->
				  <div class="form-group ol_input_fields_wrap">
					<div class="emp_rows col-xs-12">
					  <div class="col-xs-4">
						<button type="button" class="add_ol_subject_button btn btn-success">(+) Add O/L Subject</button>

					  </div>
					  <div class="col-xs-4">
						<input type="text" class="form-control" name="olschoolname" value="<?php echo $school ?>" placeholder="School name">
					  </div>
					</div>

					<?php
					$ol_counter = 0;

					if(isset($ol_results)){
						foreach($ol_results as $ol_result_row){ ?>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-4">
								<input type="text" class="form-control" name="ordinary_level[<?php echo $ol_counter; ?>][subject]" value="<?php echo $ol_result_row['subject']; ?>" placeholder="O/L Subject">
							  </div>
							  <div class="col-xs-4">
								<input type="text" class="form-control" name="ordinary_level[<?php echo $ol_counter; ?>][grade]" value="<?php echo $ol_result_row['grade']; ?>" placeholder="Grade">
							  </div>
							</div>
							<?php
							$ol_counter++;
						}
					}else{ ?>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-4">
							<input type="text" class="form-control" name="ordinary_level[0][subject]" id="ordinary_level[0][subject]" value="" placeholder="O/L Subject">
						  </div>
						  <div class="col-xs-4">
							<input type="text" class="form-control" name="ordinary_level[0][grade]" value="" placeholder="Grade">
						  </div>
						</div>
					<?php
					} ?>
				  </div>
					<input type="hidden" id="ol_input_fields_count" name="ol_input_fields_count" value="<?=$ol_counter?>">
				  <!--*********A/L FIELDS**********-->
				  <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
					<span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
					  GCE Advanced Level (A/L) <!--Padding is optional-->
					</span>
				  </div>
<? $school='';
if($al_details)
{
	$school=$al_details['school'];
}
?>
				  <div class="alert alert-info">
					<strong>Notice -</strong> It is NOT mandatory to add all the A/L subjects, however incomplete paires (i.e empty subjects or grades) or providing only the school name without A/L results will be invalidated.
				  </div>

				  <div class="form-group al_input_fields_wrap">
					<div class="emp_rows col-xs-12">
					  <div class="col-xs-4">
						<button type="button" class="add_al_subject_button btn btn-success">(+) Add A/L Subject</button>
					  </div>
					  <div class="col-xs-4">
						<input type="text" class="form-control" value="<?php echo $school; ?>" placeholder="School name" name="alschoolname">
					  </div>
					</div>

					<?php
					$al_counter = 0;
					if(isset($al_results) ){
						foreach($al_results as $al_result_row){ ?>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-4">
								<input type="text" class="form-control" name="advance_level[<?php echo $al_counter; ?>][subject]" value="<?php echo $al_result_row['subject']; ?>" placeholder="A/L Subject">
							  </div>
							  <div class="col-xs-4">
								<input type="text" class="form-control" name="advance_level[<?php echo $al_counter; ?>][grade]" value="<?php echo $al_result_row['grade']; ?>" placeholder="Grade">
							  </div>
							</div>
							<?php
							$al_counter++;
						}
					}else{ ?>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-4">
							<input type="text" class="form-control" name="advance_level[0][subject]" value="" placeholder="A/L Subject">
						  </div>
						  <div class="col-xs-4">
							<input type="text" class="form-control" name="advance_level[0][grade]" value="" placeholder="Grade">
						  </div>
						</div>
					<?php
					} ?>
				  </div>
					<input type="hidden" id="al_input_fields_count" name="al_input_fields_count" value="<?=$al_counter?>">
				  <!--******** HIGHER EDUCATION FIELDS **********-->
				  <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
					<span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
					  Higher Education <!--Padding is optional-->
					</span>
				  </div>

				  <div class="alert alert-info">
					<strong>Notice - </strong> All the required fields (Qualification name, Institute name, Grade, and From and To dates) of each Higeher Education must be filled, otherwise your form will be invalidated.
				  </div>

				  <div class="form-group hq_input_fields_wrap">
					<div class="emp_rows col-xs-12">
					  <div class="col-xs-12">
						<button type="button" class="add_hq_button btn btn-success">(+) Add Qualification</button>
					  </div>
					</div>

				   <?php
					$hq_counter = 0;
					if(isset($higher_education_details)){
						foreach($higher_education_details as $higher_education_details_row){ ?>
							<div class="emp_rows col-xs-12">
							  <div class="emp_rows col-xs-12">
								<div class="col-xs-8">
								  <input type="text" class="form-control" name="higher_education[<?php echo $hq_counter; ?>][name]" value="<?php echo $higher_education_details_row['name']; ?>" placeholder="Qualification / certification name" />
								</div>
							  </div>
							  <div class="emp_rows col-xs-12">
								<div class="col-xs-4">
								  <input type="text" class="form-control" name="higher_education[<?php echo $hq_counter; ?>][institute]" value="<?php echo $higher_education_details_row['institute']; ?>" placeholder="Institute name" />
								</div>
								<div class="col-xs-4">
								  <input type="text" class="form-control" name="higher_education[<?php echo $hq_counter; ?>][grade]" value="<?php echo $higher_education_details_row['grade']; ?>" placeholder="Grade/Result" />
								</div>
							  </div>
							  <div class="emp_rows col-xs-12">
								<div class="col-xs-4">
								  <input type="text" readonly class="form-control qualificationDatepicker" name="higher_education[<?php echo $hq_counter; ?>][from]" value="<?php echo $higher_education_details_row['from']; ?>" placeholder="From" />
								</div>
								<div class="col-xs-4">
								  <input type="text" readonly class="form-control qualificationDatepicker" name="higher_education[<?php echo $hq_counter; ?>][to]" value="<?php echo $higher_education_details_row['to']; ?>" placeholder="To" />
								</div>
							  </div>
							  <div class="emp_rows col-xs-12">
								<div class="col-xs-8">
								  <textarea style="resize:none" class="form-control" rows="5" name="higher_education[<?php echo $hq_counter; ?>][additionalInfo]" placeholder="Additional Info"><?php echo $higher_education_details_row['additionalInfo']; ?></textarea>
								</div>
							  </div>
							  <div class="emp_rows col-xs-12">
								<hr/>
							  </div>
							</div>
							<?php
							$hq_counter++;
						}
					}else{ ?>
						<div class="emp_rows col-xs-12">
						  <div class="emp_rows col-xs-12">
							<div class="col-xs-8">
							  <input type="text" class="form-control" name="higher_education[0][name]" value="" placeholder="Qualification / certification name" />
							</div>
						  </div>
						  <div class="emp_rows col-xs-12">
							<div class="col-xs-4">
							  <input type="text" class="form-control" name="higher_education[0][institute]" value="" placeholder="Institute name" />
							</div>
							<div class="col-xs-4">
							  <input type="text" class="form-control" name="higher_education[0][grade]" value="" placeholder="Grade/Result" />
							</div>
						  </div>
						  <div class="emp_rows col-xs-12">
							<div class="col-xs-4">
							  <input type="text" readonly class="form-control qualificationDatepicker" name="higher_education[0][from]" value="" placeholder="From" />
							</div>
							<div class="col-xs-4">
							  <input type="text" readonly class="form-control qualificationDatepicker" name="higher_education[0][to]" value="" placeholder="To" />
							</div>
						  </div>
						  <div class="emp_rows col-xs-12">
							<div class="col-xs-8">
							  <textarea style="resize:none" class="form-control" rows="5" name="higher_education[0][additionalInfo]" placeholder="Additional Info"></textarea>
							</div>
						  </div>
						  <div class="emp_rows col-xs-12">
							<hr/>
						  </div>
						</div>
					<?php
					} ?>
					<input type="hidden" id="hq_input_fields_count" name="hq_input_fields_count" value="<?=$hq_counter?>">
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
						<button type="button" class="add_xp_button btn btn-success" id="add_xp_button">(+) Add Experience</button>
					  </div>
					</div>

					<div class="emp_rows col-xs-12">
					  <?php
					  $work_exp_counter = 0;
					  if(isset($work_experience_details)){
						foreach($work_experience_details as $work_experience_details_row){ ?>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-8">
								<input type="text" class="form-control" name="work_experience[<?php echo $work_exp_counter; ?>][job]" value="<?php echo $work_experience_details_row['job']; ?>" placeholder="Job Title" />
							  </div>
							</div>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-8">
								<input type="text" class="form-control" name="work_experience[<?php echo $work_exp_counter; ?>][company]" value="<?php echo $work_experience_details_row['company']; ?>" placeholder="Company" />
							  </div>
							</div>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-8">
								<input type="text" class="form-control" name="work_experience[<?php echo $work_exp_counter; ?>][location]" value="<?php echo $work_experience_details_row['location']; ?>" placeholder="Location" />
							  </div>
							</div>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-4">
								<input type="text" readonly class="form-control weDatepicker" name="work_experience[<?php echo $work_exp_counter; ?>][from]" value="<?php echo $work_experience_details_row['from']; ?>" placeholder="From" />
							  </div>
							  <div class="col-xs-4">
								<input type="text" readonly class="form-control weDatepicker" name="work_experience[<?php echo $work_exp_counter; ?>][to]" value="<?php echo $work_experience_details_row['to']; ?>" placeholder="To" />
							  </div>
							</div>
							<div class="emp_rows col-xs-12">
							  <div class="col-xs-8">
								<textarea style="resize:none" class="form-control" rows="5" name="work_experience[<?php echo $work_exp_counter; ?>][additionalInfo]" placeholder="Additional Info"><?php echo $work_experience_details_row['additionalInfo']; ?></textarea>
							  </div>
							</div>
							<div class="emp_rows col-xs-12">
							  <hr/>
							</div>
							<?php
							$work_exp_counter++;
						}
					  }else{ ?>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-8">
							<input type="text" class="form-control" name="work_experience[0][job]" value="" placeholder="Job Title" />
						  </div>
						</div>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-8">
							<input type="text" class="form-control" name="work_experience[0][company]" value="" placeholder="Company" />
						  </div>
						</div>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-8">
							<input type="text" class="form-control" name="work_experience[0][location]" value="" placeholder="Location" />
						  </div>
						</div>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-4">
							<input type="text" readonly class="form-control weDatepicker" name="work_experience[0][from]" value="" placeholder="From" />
						  </div>
						  <div class="col-xs-4">
							<input type="text" readonly class="form-control weDatepicker" name="work_experience[0][to]" value="" placeholder="To" />
						  </div>
						</div>
						<div class="emp_rows col-xs-12">
						  <div class="col-xs-8">
							<textarea style="resize:none" class="form-control" rows="5" name="work_experience[0][additionalInfo]" placeholder="Additional Info"></textarea>
						  </div>
						</div>
						<div class="emp_rows col-xs-12">
						  <hr/>
						</div>
					  <?php
					  } ?>
						<input type="hidden" id="xp_input_fields_count" name="xp_input_fields_count" value="<?=$work_exp_counter?>">
					</div>
				  </div>

				</div>
			  </div>

			  <div class="form-group">
				<div class="col-xs-10">
				  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Update Employee</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>

  </div>
</div>
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function() {

		/** ADD DYNAMIC FIELDS FOR O/L **/
  		var ol_max_subjects = 10; //maximum input boxes allowed
  		var ol_wrapper = $(".ol_input_fields_wrap"); //Fields wrapper
  		var ol_add_button = $(".add_ol_subject_button"); //Add button ID

  		var olCount = <?php echo $ol_counter; ?>; //initlal text box count
  		$(ol_add_button).click(function(e){ //on add input button click
    		e.preventDefault();
    		if(olCount < ol_max_subjects){
				olCount++;
      			$(ol_wrapper).append('<div class="emp_rows col-xs-12">\
      			<div class="col-xs-4">\
      			<input type="text" class="form-control" name="ordinary_level['+olCount+'][subject]" placeholder="O/L Subject" />\
      			</div>\
      			<div class="col-xs-4">\
      			<input type="text" class="form-control" name="ordinary_level['+olCount+'][grade]" placeholder="O/L Grade" />\
      			</div>\
      			<div class="col-xs-4">\
      			<a href="#" class="remove_field btn btn-danger">Remove</a>\
      			</div>\
      			</div>'); //add input box
						$("#ol_input_fields_count").val(olCount);
    		}
  		});

		$(ol_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').remove(); olCount--;
				$("#ol_input_fields_count").val(olCount);
  		})


		/** ADD DYNAMIC FIELDS FOR A/L **/
  		var al_max_subjects = 5; //maximum input boxes allowed
  		var al_wrapper = $(".al_input_fields_wrap"); //Fields wrapper
  		var al_add_button = $(".add_al_subject_button"); //Add button ID
  		var alCount = <?php echo $al_counter; ?>; //initlal text box count

  		$(al_add_button).click(function(e){ //on add input button click
    		e.preventDefault();
    		if(alCount < al_max_subjects){
				alCount++; //text box increment
				$(al_wrapper).append('<div class="emp_rows col-xs-12">\
      			<div class="col-xs-4">\
      			<input type="text" class="form-control" name="advance_level['+alCount+'][subject]" placeholder="A/L Subject" />\
      			</div>\
      			<div class="col-xs-4">\
      			<input type="text" class="form-control" name="advance_level['+alCount+'][grade]" placeholder="A/L Grade" />\
      			</div>\
      			<div class="col-xs-4">\
      			<a href="#" class="remove_field btn btn-danger">Remove</a>\
      			</div>\
      			</div>'); //add input box
						$("#al_input_fields_count").val(alCount);
    		}
  		});

  		$(al_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').remove(); alCount--;
				$("#al_input_fields_count").val(alCount);
  		})


  		/** ADD DYNAMIC FIELDS FOR EDUCATION QUALIFICATIONS **/
  		var hq_max_subjects = 15; //maximum input boxes allowed
		var hq_wrapper = $(".hq_input_fields_wrap"); //Fields wrapper
  		var hq_add_button = $(".add_hq_button"); //Add button ID
  		var hqCount = <?php echo $hq_counter; ?>; //initlal text box count

  		$(hq_add_button).click(function(e){ //on add input button click
    		e.preventDefault();
    		if(hqCount < hq_max_subjects){
				hqCount++;
				$(hq_wrapper).append('<div class="emp_rows col-xs-12">\
				<div class="emp_rows col-xs-12">\
				<div class="col-xs-8">\
				<input type="text" class="form-control" name="higher_education['+hqCount+'][name]" placeholder="Qualification / certification name" />\
				</div>\
				</div>\
				<div class="emp_rows col-xs-12">\
				<div class="col-xs-4">\
				<input type="text" class="form-control" name="higher_education['+hqCount+'][institute]" placeholder="Institute name" />\
				</div>\
				<div class="col-xs-4">\
				<input type="text" class="form-control" name="higher_education['+hqCount+'][grade]" placeholder="Grade" />\
				</div>\
				</div>\
				<div class="emp_rows col-xs-12">\
				<div class="col-xs-4">\
				<input type="text" class="form-control qualificationDatepicker" readonly name="higher_education['+hqCount+'][from]" placeholder="From" />\
				</div>\
				<div class="col-xs-4">\
				<input type="text" class="form-control qualificationDatepicker" readonly name="higher_education['+hqCount+'][to]" placeholder="To" />\
				</div>\
				</div>\
				<div class="emp_rows col-xs-12">\
				<div class="col-xs-8">\
				<textarea style="resize:none" class="form-control" rows="5" name="higher_education['+hqCount+'][additionalInfo]" placeholder="Additional Info"></textarea>\
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
 	 	});

  		$(hq_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').parent('div').remove(); hqCount--;
				$("#hq_input_fields_count").val(hqCount);
  		})


  		/** ADD DYNAMIC FIELDS FOR WORK EXPERIENCE **/
  		var xp_max = 15; //maximum input boxes allowed
  		var xp_wrapper = $(".xp_input_fields_wrap"); //Fields wrapper
  		var xp_add_button = $(".add_xp_button"); //Add button ID

  		var xpCount = <?php echo $work_exp_counter; ?> //initlal text box count

  		$(xp_add_button).click(function(e){ //on add input button click
			e.preventDefault();
    		if(xpCount < xp_max){
      			xpCount++; //text box increment
      			$(xp_wrapper).append('<div class="emp_rows col-xs-12">\
      			<div class="emp_rows col-xs-12">\
      			<div class="col-xs-8">\
      			<input type="text" class="form-control" name="work_experience['+xpCount+'][job]" placeholder="Job Title" />\
      			</div>\
      			</div>\
      			<div class="emp_rows col-xs-12">\
      			<div class="col-xs-8">\
      			<input type="text" class="form-control" name="work_experience['+xpCount+'][company]" placeholder="Company" />\
      			</div>\
      			</div>\
      			<div class="emp_rows col-xs-12">\
      			<div class="col-xs-8">\
      			<input type="text" class="form-control" name="work_experience['+xpCount+'][location]" placeholder="Location" />\
      			</div>\
      			</div>\
      			<div class="emp_rows col-xs-12">\
      			<div class="col-xs-4">\
      			<input type="text" class="form-control weDatepicker" readonly name="work_experience['+xpCount+'][from]" placeholder="From" />\
				</div>\
      			<div class="col-xs-4">\
      			<input type="text" class="form-control weDatepicker" readonly name="work_experience['+xpCount+'][to]" placeholder="To" />\
      			</div>\
      			</div>\
      			<div class="emp_rows col-xs-12">\
				<div class="col-xs-8">\
      			<textarea style="resize:none" class="form-control" rows="5" name="work_experience['+xpCount+'][additionalInfo]" placeholder="Additional Info"></textarea>\
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
  		});

  		$(xp_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').parent('div').remove(); xpCount--;
				$("#xp_input_fields_count").val(xpCount);
  		})

	});
</script>

<script>
	$(document).ready(function(){

	/*	$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			//var dats = $(this).serializeArray();
			var formData = new FormData(this);
			$.ajax({
				url: siteUrl + 'hr/employee/update_submit',
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				success: function(data) {
					var data = JSON.parse(data);
	                if($.isEmptyObject(data.error)){
	                	window.location.replace(siteUrl+'hr/employee/employee_list');
	                }else{
						unsuccessfulAttemptAction(data.error);
	                }
				},
				error: function(e) {
					console.log(e.responseText);
				}
			});
		});

  		function unsuccessfulAttemptAction(errors){
    		$('html, body').animate({scrollTop: '0px'}, 300);//scroll to the top
    		var messageBoardDIV = $('#messageBoard');
    		//empty child elements if exist
			messageBoardDIV.empty();

    		//append error message to the "messageBoard" block
    		$(messageBoardDIV).append('<div class="alert alert-danger  fade in">\
            	<button type="button" class="close" data-dismiss="alert" aria-label="Close">\
            		<span aria-hidden="true">&times;</span>\
                </button>\
                <strong>Please correct the following error(s)!</strong>\
                '+errors+'\
            </div>');
  		}
*/
	});
</script>
<script>
jQuery(document).ready(function() {

//validate all fields
	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
	$("#inputform").validate({
		rules: {
			 // olschoolname: {required:function(element){
				//  return $("#ol_input_fields_count").val()>0;
			 // }},
			 olschoolname: {required:true},
			 'ordinary_level[0][grade]':{ordinary_level:[]},
			 'advance_level[0][grade]':{advance_level:[]},
			 'higher_education[0][grade]':{higher_education:[]},
			 'work_experience[0][grade]':{work_experience:[]},

		 },
			messages: {
					olschoolname:"Required",

			},
});
$.validator.addMethod('ordinary_level', function() {
	var count=$("#ol_input_fields_count").val();
	var newnum=0;
	for (var i = 0; i < count; i++) {

		var field_1 = $('input[name="ordinary_level['+i+'][grade]"]').val();
    var field_2 = $('input[name="ordinary_level['+i+'][subject]"]').val();

		if(field_1 && field_2){
			newnum=newnum+1;
		}
		//return ;
	}
	if(newnum==count){
		return true;
	}


}, "There is/are incomplete paires");

$.validator.addMethod('advance_level', function() {
	var count=$("#al_input_fields_count").val();
	var newnum=0;
	for (var i = 0; i < count; i++) {

		var field_1 = $('input[name="advance_level['+i+'][grade]"]').val();
    var field_2 = $('input[name="advance_level['+i+'][subject]"]').val();

		if(field_1 && field_2){
			newnum=newnum+1;
		}
		//return ;
	}
	if(newnum==count){
		return true;
	}


}, "There is/are incomplete paires");

$.validator.addMethod('higher_education', function() {
	var count=$("#hq_input_fields_count").val();
	var newnum=0;
	for (var i = 0; i < count; i++) {

		var field_1 = $('input[name="higher_education['+i+'][name]"]').val();
    var field_2 = $('input[name="higher_education['+i+'][institute]"]').val();
		var field_3 = $('input[name="higher_education['+i+'][grade]"]').val();
    var field_4 = $('input[name="higher_education['+i+'][from]"]').val();
		var field_5 = $('input[name="higher_education['+i+'][to]"]').val();

		if(field_1 && field_2 && field_3 && field_4 && field_5){
			newnum=newnum+1;
		}
		//return ;
	}
	if(newnum==count){
		return true;
	}


}, "There is/are incomplete paires");

$.validator.addMethod('work_experience', function() {
	var count=$("#xp_input_fields_count").val();
	var newnum=0;
	for (var i = 0; i < count; i++) {

		var field_1 = $('input[name="work_experience['+i+'][job]"]').val();
    var field_2 = $('input[name="work_experience['+i+'][company]"]').val();

		if(field_1 && field_2){
			newnum=newnum+1;
		}
		//return ;
	}
	if(newnum==count){
		return true;
	}


}, "There is/are incomplete paires");


});
</script>
