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


  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<div class="row">
		  <!--block which displays the outcome message-->

		  <div class="col-xs-12 form-container">

				<p>	  <? if($this->session->flashdata('msg')){?>
               <div class="alert alert-success" role="alert">
						<?=$this->session->flashdata('msg')?>
				</div><? }?>
                <? if($this->session->flashdata('error')){?>
               <div class="alert alert-danger" role="alert">
						<?=$this->session->flashdata('error')?>
				</div><? }?>

			<form enctype="multipart/form-data" class="userRegForm form-horizontal" id="inputform" name="inputform" action="<?=base_url()?>hr/employee/submission" method="post">
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
						<option value="N">Not Required</option>
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
					<div class="form-group">
						<label for="emp_mobile" class="control-label col-xs-2">Phone Charges</label>
						<div class="col-xs-5">
						  <input type="number" step="0.01" class="form-control" id="emp_phone_charges" name="emp_phone_charges" value="" placeholder="0.00">
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
<script src="<?=base_url()?>media/js/jquery.validate.min.js"></script>
<script  type="text/javascript">
	jQuery(document).ready(function() {

	//validate all fields
  	$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		$("#inputform").validate({
			rules: {
					title: {required: true},
				 initials:{required: true},
				 surname:{required: true},
				 inifull:{required: true},
				 nic:{required: true},
				 dobDatepicker:{required: true},
				 immediate_manager_1:{required: true},
				 user_privilege:{required: true},
				 emp_joining_date:{required: true},

	},
        messages: {
            title: "Required",
						initials:"Required",
						surname:"Required",
						inifull:"Required",
						nic:"Required",
						dobDatepicker:"Required",
						immediate_manager_1:"Required",
						user_privilege:"Required",
						emp_joining_date:"Required",

        }
});


	});
</script>
