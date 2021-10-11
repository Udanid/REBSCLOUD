<script>
	$(document).ready(function() {
  		var base_url = "<?php echo $this->config->item('base_url'); ?>"; //base URL of CI

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

  		/** ADD DYNAMIC FIELDS FOR O/L **/
  		var ol_max_subjects = 10; //maximum input boxes allowed
  		var ol_wrapper = $(".ol_input_fields_wrap"); //Fields wrapper
  		var ol_add_button = $(".add_ol_subject_button"); //Add button ID

  		var olCount = 1; //initlal text box count
  		$(ol_add_button).click(function(e){ //on add input button click
    		e.preventDefault();
    		if(olCount < ol_max_subjects){
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
				olCount++; //text box increment
    		}
  		});

		$(ol_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').remove(); olCount--;
  		})

  		/** ADD DYNAMIC FIELDS FOR A/L **/
  		var al_max_subjects = 5; //maximum input boxes allowed
  		var al_wrapper = $(".al_input_fields_wrap"); //Fields wrapper
  		var al_add_button = $(".add_al_subject_button"); //Add button ID
  		var alCount = 1; //initlal text box count

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
    		}
  		});

  		$(al_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').remove(); alCount--;
  		})

  		/** ADD DYNAMIC FIELDS FOR EDUCATION QUALIFICATIONS **/
  		var hq_max_subjects = 15; //maximum input boxes allowed
		var hq_wrapper = $(".hq_input_fields_wrap"); //Fields wrapper
  		var hq_add_button = $(".add_hq_button"); //Add button ID
  		var hqCount = 1; //initlal text box count

  		$(hq_add_button).click(function(e){ //on add input button click
    		e.preventDefault();
    		if(hqCount < hq_max_subjects){

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
				hqCount++; //increment
    		}
 	 	});

  		$(hq_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').parent('div').remove(); hqCount--;
  		})

  		/** ADD DYNAMIC FIELDS FOR WORK EXPERIENCE **/
  		var xp_max = 15; //maximum input boxes allowed
  		var xp_wrapper = $(".xp_input_fields_wrap"); //Fields wrapper
  		var xp_add_button = $(".add_xp_button"); //Add button ID
  		var xpCount = 1; //initlal text box count

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
    		}
  		});

  		$(xp_wrapper).on("click",".remove_field", function(e){ //user click on remove text
    		e.preventDefault();
    		$(this).parent('div').parent('div').parent('div').remove(); xpCount--;
  		})

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
			$("#bank_branch_load").load("<?php echo base_url();?>hr/hr_common/get_bank_branchlist/"+itemcode);
		}
	}
	$(document).ready(function() {
		var bank_itemcode = document.getElementById("bank_code").value;
		loadbranchlist(bank_itemcode);
	});
</script>
<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<div class="row">
		  <!--block which displays the outcome message-->
		  <div id="messageBoard"></div>

		  <div class="col-xs-12 form-container">
			<form enctype="multipart/form-data" class="userRegForm form-horizontal" id="inputform" name="inputform" method="post">
			  <div class="panel panel-default">
				<div class="panel-heading">Employee Personal Details</div>
				<div class="panel-body">

				  <div class="form-group">
					<label for="title" class="control-label col-xs-2">Title</label>
					<div class="col-xs-5">
					  <select class="form-control" id="title" name="title">
						<?php
						foreach($title as $key=>$value){ ?>
							<option value=<?php echo $key; ?>><?php echo $value; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="initials" class="control-label col-xs-2">Initials</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="initials" name="initials" value="" placeholder="Initials (no dots or space)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="surname" class="control-label col-xs-2">Surname</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="surname" name="surname" value="" placeholder="Surname">
					</div>
				  </div>

				  <div class="form-group">
					<label for="inifull" class="control-label col-xs-2">Initials in Full</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="inifull" name="inifull" value="" placeholder="Intials in Full">
					</div>
				  </div>

				  <div class="form-group">
					<label for="nationality" class="control-label col-xs-2">Nationality</label>
					<div class="col-xs-5">
					  <select class="form-control" id="nationality" name="nationality">
						<?php
						foreach($countryList as $key=>$value){
						  //select Sri Lanka as the currently selected country
						  if(strcmp($value['num_code'], "144") == 0){ ?>
							 <option value=<? echo $key; ?> selected="selected"><?php echo $value['nationality']; ?></option>
						  <?php
						  }else{ ?>
							<option value=<?php echo $key; ?>><?php echo $value['nationality']; ?></option>
						  <?php
						  }
						} ?>
					  </select>
					</div>
				  </div>

				  <!--marital status-->
				  <div class="form-group">
					<label for="martialStatus" class="control-label col-xs-2">Marital Status</label>
					<div class="col-xs-5">
					  <select class="form-control" id="martialStatus" name="martialStatus">
						<?php
						foreach($maritalStatus as $key=>$value){ ?>
							<option value=<?php echo $key; ?>><?php echo $value; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="religion" class="control-label col-xs-2">Religion</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="religion" name="religion" value="" placeholder="Religion">
					</div>
				  </div>

				  <div class="form-group">
					<label for="race" class="control-label col-xs-2">Race</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="race" name="race" value="" placeholder="Race">
					</div>
				  </div>

				  <div class="form-group">
					<label for="nic" class="control-label col-xs-2">NIC No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="nic" name="nic" value="" placeholder="NIC #">
					</div>
				  </div>

				  <div class="form-group">
					<label for="passport_no" class="control-label col-xs-2">Passport No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="passport_no" name="passport_no" value="" placeholder="Passport # (optional)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="driving_lic" class="control-label col-xs-2">Driving Licence</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="driving_lic" name="driving_lic" value="" placeholder="Driving Licence (optional)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="blood_group" class="control-label col-xs-2">Blood Group</label>
					<div class="col-xs-5">
					  <select class="form-control" id="blood_group" name="blood_group">
						<?php
						foreach($bloodGroup as $key=>$value){ ?>
							<option value=<?php echo $key; ?>><?php echo $value; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="dobDatepicker" class="control-label col-xs-2">Date of Birth</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="dobDatepicker" name="employeeDoB" value="" placeholder="DD/MM/YYYY" readonly />
					  <span class="add-on"><i class="icon-calendar"></i></span>
					</div>
				  </div>

				  <div class="form-group">
					<label for="profile_pic" class="control-label col-xs-2">Profile Picture</label>
					<div class="col-xs-5">
					  <input type="file" id="profile_pic" name="profile_pic">
					  <p class="help-block">JPG & PNG formats are allowed. Maximum file size allowed is 200KB.</p>
					</div>
				  </div>

				</div>
			  </div>

			  <!--Employement details-->
			  <div class="panel panel-default">
				<div class="panel-heading">Employment Details</div>
				<div class="panel-body">

				  <div class="form-group">
					<label for="employment_type" class="control-label col-xs-2">Employment Type</label>
					<div class="col-xs-5">
					  <select class="form-control" id="employment_type" name="employment_type">
						<?php
						foreach($employment_types as $employment_type_row){ ?>
							<option value=<?php echo $employment_type_row->id; ?>><?php echo $employment_type_row->employment_type; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>
					<div class="form-group">
					<label for="employment_working_days" class="control-label col-xs-2">Employment Working Days Per Week</label>
					<div class="col-xs-5">
					  <select class="form-control" id="employment_working_days" name="employment_working_days">
					  <option value="5" >5 Days</option>
					  <option value="7" >7 Days</option>

					  </select>
					</div>
					</div>

				  <div class="form-group">
					<label for="emp_joining_date" class="control-label col-xs-2">Joining Date</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="emp_joining_date" name="emp_joining_date" value="" placeholder="DD/MM/YYYY" readonly />
					  <span class="add-on"><i class="icon-calendar"></i></span>
					</div>
				  </div>

				  <div class="form-group">
					<label for="duration" class="control-label col-xs-2">Employment/Probation Duration (Months)</label>
					<div class="col-xs-5">
					  <input type="number" class="form-control" id="duration" name="duration" value="" placeholder="Duration (Months)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="epf_no" class="control-label col-xs-2">EPF No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="epf_no" name="epf_no" value="" placeholder="EPF #">
					</div>
				  </div>

				  <div class="form-group">
					<label for="designation" class="control-label col-xs-2">Designation</label>
					<div class="col-xs-5">
					  <select class="form-control" id="designation" name="designation">
						<?php
						foreach($designations as $designation_row){ ?>
							<option value=<?php echo $designation_row->id; ?>><?php echo $designation_row->designation; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="branch" class="control-label col-xs-2">Branch</label>
					<div class="col-xs-5">
					  <select class="form-control" id="branch" name="branch">
						<?php
						foreach($branches as $branch_row){ ?>
							<option value=<?php echo $branch_row->branch_code; ?>><?php echo $branch_row->branch_name; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="division" class="control-label col-xs-2">Division</label>
					<div class="col-xs-5">
					  <select class="form-control" id="division" name="division">
						<?php
						foreach($divisions as $division_row){ ?>
							<option value=<?php echo $division_row->id; ?>><?php echo $division_row->division_name; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="leave_category" class="control-label col-xs-2">Leave Category</label>
					<div class="col-xs-5">
					  <select class="form-control" id="leave_category" name="leave_category">
						<?php
						foreach($leave_category_list as $leave_category_row){ ?>
							<option value=<?php echo $leave_category_row->id; ?>><?php echo $leave_category_row->leave_category_name; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="maternity_leave" class="control-label col-xs-2">Maternity Leave</label>
					<div class="col-xs-5">
					  <select class="form-control" id="maternity_leave" name="maternity_leave">
						<option value="Y">Entitled</option>
						<option value="N" selected>Not Entitled</option>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="immediate_manager_1" class="control-label col-xs-2">Immediate Manager 1</label>
					<div class="col-xs-5">
					  <select class="form-control" id="immediate_manager_1" name="immediate_manager_1">
					    <option value="">--select immediate manager--</option>
						<?php
						foreach($employee_list as $employee_list_row){ ?>
							<option value=<?php echo $employee_list_row->id; ?>><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->initial.' '.$employee_list_row->surname; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="immediate_manager_2" class="control-label col-xs-2">Immediate Manager 2</label>
					<div class="col-xs-5">
					  <select class="form-control" id="immediate_manager_2" name="immediate_manager_2">
					    <option value="">--select immediate manager--</option>
						<?php
						foreach($employee_list as $employee_list_row){ ?>
							<option value=<?php echo $employee_list_row->id; ?>><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->initial.' '.$employee_list_row->surname; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="attendance_type" class="control-label col-xs-2">Attendance Type</label>
					<div class="col-xs-5">
					  <select class="form-control" id="attendance_type" name="attendance_type">
						<option value="S">System Login</option>
						<option value="F">Finger Print</option>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="fuel_allowance_status" class="control-label col-xs-2">Fuel Allowance</label>
					<div class="col-xs-5">
					  <select class="form-control" id="fuel_allowance_status" name="fuel_allowance_status">
						<option value="Y">Entitled</option>
						<option value="N" selected>Not Entitled</option>
					  </select>
					</div>
				  </div>

				  <div class="form-group" name="vehicle_type_div" id="vehicle_type_div" style="display: none;">
					<label for="vehicle_type" class="control-label col-xs-2">Vehicle Type</label>
					<div class="col-xs-5">
					  <select class="form-control" id="vehicle_type" name="vehicle_type">
						<?php
						foreach($fuel_allowance_vehicle_type_list as $vehicle_type_row){ ?>
							<option value=<?php echo $vehicle_type_row->id; ?>><?php echo $vehicle_type_row->vehicle_type; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>

				  <div class="form-group" name="initial_meter_reading_div" id="initial_meter_reading_div" style="display: none;">
					<label for="initial_meter_reading" class="control-label col-xs-2">Initial Meter Reading</label>
					<div class="col-xs-5">
					  <input type="number" class="form-control" id="initial_meter_reading" name="initial_meter_reading" value="" placeholder="Initial Meter Reading">
					</div>
				  </div>

				  <div class="form-group" name="fuel_allowance_maximum_limit_div" id="fuel_allowance_maximum_limit_div" style="display: none;">
					<label for="fuel_allowance_maximum_limit" class="control-label col-xs-2">Fuel Allowance Maximum Limit (Rs)</label>
					<div class="col-xs-5">
					  <input type="number" class="form-control" id="fuel_allowance_maximum_limit" name="fuel_allowance_maximum_limit" value="" placeholder="Fuel Allowance Maximum Limit">
					</div>
				  </div>

				  <div class="form-group">
					<label for="user_privilege" class="control-label col-xs-2">User Privilege Level</label>
					<div class="col-xs-5">
					  <select class="form-control" id="user_privilege" name="user_privilege">
					    <option value="">--Select User Privilege Level--</option>
						<?php
						foreach($user_privilege_list as $user_privilege_row){
						  if($user_privilege_row->usertype != "admin" && $user_privilege_row->usertype != "re_manager"){ ?>
							<option value=<?php echo $user_privilege_row->usertype_id; ?>><?php echo $user_privilege_row->usertype; ?></option>
						  <?php
						  }
						} ?>
					  </select>
					</div>
				  </div>

				</div>
			  </div>

			  <!--Contact information-->
			  <div class="panel panel-default">
				<div class="panel-heading">Contact information</div>
				<div class="panel-body">

				  <!--telephone #-->
				  <div class="form-group">
					<label for="emp_mobile" class="control-label col-xs-2">Personal Contact No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="emp_mobile" name="emp_mobile" value="" placeholder="Mobile #">
					</div>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="emp_tel" name="emp_tel" value="" placeholder="Telephone # (optional)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="userEmail" class="control-label col-xs-2">Personal Email</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="userEmail" name="userEmail" value="" placeholder="Email">
					</div>
				  </div>

				  <div class="form-group">
					<label for="emp_office_mobile" class="control-label col-xs-2">Office Contact No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="emp_office_mobile" name="emp_office_mobile" value="" placeholder="Mobile #">
					</div>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="emp_office_tel" name="emp_office_tel" value="" placeholder="Telephone # (optional)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="office_email" class="control-label col-xs-2">Office Email</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="office_email" name="office_email" value="" placeholder="Email">
					</div>
				  </div>

				  <!--Address-->
				  <div class="form-group">
					<label for="address1" class="control-label col-xs-2">Address</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="address1" name="address1" value="" placeholder="Address line 1 #">
					</div>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="address2" name="address2" value=""  placeholder="Address line 2 (optional)">
					</div>
				  </div>

				  <!--town-->
				  <div class="form-group">
					<label for="town" class="control-label col-xs-2">Town</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="town" name="town" value="" placeholder="Town">
					</div>
				  </div>

				  <!--Province-->
				  <div class="form-group">
					<label for="province" class="control-label col-xs-2">Province</label>
					<div class="col-xs-5">
					  <select class="form-control" id="province" name="province">
						<?php
						foreach($province as $key=>$value){ ?>
							<option value=<?php echo $key; ?>><?php echo $value; ?></option>
						<?php
						} ?>
					  </select>
					</div>
				  </div>
				</div>
			  </div>

			  <!--Emergency conatact persons-->
			  <div class="panel panel-default">
				<div class="panel-heading">Emergency Contact</div>
				<div class="panel-body">

				  <div class="form-group">
					<label for="name_emg_person" class="control-label col-xs-2">Contact person</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="name_emg_person" name="name_emg_person" value="" placeholder="Contact Person Name">
					</div>
				  </div>

				  <div class="form-group">
					<label for="relationship_emg" class="control-label col-xs-2">Relationship</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="relationship_emg" name="relationship_emg" value="" placeholder="Relationship Ex:wife">
					</div>
				  </div>

				  <div class="form-group">
					<label for="contact_mob_emg" class="control-label col-xs-2">Contact No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="contact_mob_emg" name="contact_mob_emg" value="" placeholder="Mobile #">
					</div>

					<div class="col-xs-5">
					  <input type="text" class="form-control" id="contact_tel_emg" name="contact_tel_emg" value="" placeholder="Telephone #">
					</div>
				  </div>

				  <div class="form-group">
					<label for="addr1_emg" class="control-label col-xs-2">Address</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="addr1_emg" name="addr1_emg" value="" placeholder="Address line 1">
					</div>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="addr2_emg" name="addr2_emg" value="" placeholder="Address line 2 (optional)">
					</div>
				  </div>

				  <div class="form-group">
					<label for="town_emg" class="control-label col-xs-2">Town</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="town_emg" name="town_emg" value="" placeholder="Town">
					</div>
				  </div>

				</div>
			  </div>

			  <!--Banking information-->
			  <div class="panel panel-default">
				<div class="panel-heading">Banking information</div>
				<div class="panel-body">
				  <div class="form-group">
					<label for="bank_given_name" class="control-label col-xs-2">Given name</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="bank_given_name" name="bank_given_name" value="" placeholder="Name with initials">
					</div>
				  </div>

				  <div class="form-group">
					<label for="bank_code" class="control-label col-xs-2">Bank name</label>
					<div class="col-xs-5">
					  <select class="form-control" id="bank_code" name="bank_code" onChange="loadbranchlist(this.value); document.getElementById('bank_name').value=this.options[this.selectedIndex].text;">
					    <option value="">Bank</option>
						<?php
						foreach($bank_list as $bank_list_row){ ?>
							<option value=<?php echo $bank_list_row->BANKCODE; ?>><?php echo $bank_list_row->BANKNAME; ?></option>
						<?php
						} ?>
					  </select>
					</div>
					<input type="hidden" name="bank_name" id="bank_name" value="" />
				  </div>

				  <div class="form-group">
					<label for="branch_name" class="control-label col-xs-2">Branch</label>
					<div class="col-xs-5" id="bank_branch_load">
					  <select name="bank_branch" id="bank_branch" class="form-control" placeholder="Bank" >
						<option value="">Branch</option>
					  </select>
					</div>
				  </div>

				  <div class="form-group">
					<label for="account_no" class="control-label col-xs-2">Account No.</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="account_no" name="account_no" value="" placeholder="Account #">
					</div>
				  </div>

				  <div class="form-group">
					<label for="account_type" class="control-label col-xs-2">Account type</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="account_type" name="account_type" value="" placeholder="Account type">
					</div>
				  </div>

				</div>
			  </div>

			  <!--Insurance information-->
			  <div class="panel panel-default">
				<div class="panel-heading">Insurance</div>
				<div class="panel-body">
				  <div class="form-group">
					<label for="insCompany" class="control-label col-xs-2">Company Name</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="insCompany" name="insCompany" value="" placeholder="Name of insurance company">
					</div>
				  </div>

				  <div class="form-group">
					<label for="insScheme" class="control-label col-xs-2">Scheme Name</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="insScheme" name="insScheme" value="" placeholder="Insurance scheme">
					</div>
				  </div>

				  <div class="form-group">
					<label for="policynumber" class="control-label col-xs-2">Insurance Policy Number</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="policynumber" name="policynumber" value="" placeholder="Insurance policy">
					</div>
				  </div>
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

				  <!--*********O/L FIELDS**********-->
				  <div class="form-group ol_input_fields_wrap">
					<div class="emp_rows col-xs-12">
					  <div class="col-xs-4">
						<button class="add_ol_subject_button btn btn-success">(+) Add O/L Subject</button>
					  </div>
					  <div class="col-xs-4">
						<input type="text" class="form-control" name="olschoolname" placeholder="School name">
					  </div>
					</div>

					<div class="emp_rows col-xs-12">
					  <div class="col-xs-4">
						<input type="text" class="form-control" id="ordinary_level" name="ordinary_level[0][subject]" placeholder="O/L Subject">
					  </div>
					  <div class="col-xs-4">
						<input type="text" class="form-control" name="ordinary_level[0][grade]" placeholder="Grade">
					  </div>
					</div>
				  </div>

				  <!--*********A/L FIELDS**********-->
				  <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
					<span style="font-size: 16px; background-color: #F3F5F6; padding: 0 10px;">
					  GCE Advanced Level (A/L) <!--Padding is optional-->
					</span>
				  </div>

				  <div class="alert alert-info">
					<strong>Notice -</strong> It is NOT mandatory to add all the A/L subjects, however incomplete paires (i.e empty subjects or grades) or providing only the school name without A/L results will be invalidated.
				  </div>

				  <div class="form-group al_input_fields_wrap">
					<div class="emp_rows col-xs-12">
					  <div class="col-xs-4">
						<button class="add_al_subject_button btn btn-success">(+) Add A/L Subject</button>
					  </div>
					  <div class="col-xs-4">
						<input type="text" class="form-control" placeholder="School name" name="alschoolname">
					  </div>
					</div>

					<div class="emp_rows col-xs-12">
					  <div class="col-xs-4">
						<input type="text" class="form-control" placeholder="A/L Subject" name="advance_level[0][subject]">
					  </div>
					  <div class="col-xs-4">
						<input type="text" class="form-control" placeholder="Grade" name="advance_level[0][grade]">
					  </div>
					</div>
				  </div>

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
						<button class="add_hq_button btn btn-success">(+) Add Qualification</button>
					  </div>
					</div>

					<div class="emp_rows col-xs-12">
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-8">
						  <input type="text" class="form-control" name="higher_education[0][name]" placeholder="Qualification / certification name" />
						</div>
					  </div>
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-4">
						  <input type="text" class="form-control" name="higher_education[0][institute]" placeholder="Institute name" />
						</div>
						<div class="col-xs-4">
						  <input type="text" class="form-control" name="higher_education[0][grade]" placeholder="Grade" />
						</div>
					  </div>
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-4">
						  <input type="text" readonly class="form-control qualificationDatepicker" name="higher_education[0][from]" placeholder="From" />
						</div>
						<div class="col-xs-4">
						  <input type="text" readonly class="form-control qualificationDatepicker" name="higher_education[0][to]" placeholder="To" />
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
						<button class="add_xp_button btn btn-success">(+) Add Experience</button>
					  </div>
					</div>

					<div class="emp_rows col-xs-12">
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-8">
						  <input type="text" class="form-control" name="work_experience[0][job]" placeholder="Job Title" />
						</div>
					  </div>
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-8">
						  <input type="text" class="form-control" name="work_experience[0][company]" placeholder="Company" />
						</div>
					  </div>
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-8">
						  <input type="text" class="form-control" name="work_experience[0][location]" placeholder="Location" />
						</div>
					  </div>
					  <div class="emp_rows col-xs-12">
						<div class="col-xs-4">
						  <input type="text" readonly class="form-control weDatepicker" name="work_experience[0][from]" placeholder="From" />
						</div>
						<div class="col-xs-4">
						  <input type="text" readonly class="form-control weDatepicker" name="work_experience[0][to]" placeholder="To" />
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
					</div>
				  </div>

				</div>
			  </div>

			  <div class="form-group">
				<div class="col-xs-10">
				  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Add Employee</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>

  </div>
</div>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			//var dats = $(this).serializeArray();
			var formData = new FormData(this);
			$.ajax({
				url: siteUrl + 'hr/employee/submission',
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

	});
</script>
