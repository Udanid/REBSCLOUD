<script>
	$(document).ready(function(){

  		$("#transfer_date").datepicker({
      			dateFormat: 'dd-MM-yy',
      			defaultDate: new Date(),
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + '+1'
  		});

  		$("#promotion_date").datepicker({
      			dateFormat: 'dd-MM-yy',
      			defaultDate: new Date(),
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + '+1'
  		});

  		$("#leave_trans_date").datepicker({
      			dateFormat: 'dd-MM-yy',
      			defaultDate: new Date(),
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + '+1'
  		});

  		$("#employment_type_date").datepicker({
      			dateFormat: 'dd-MM-yy',
      			defaultDate: new Date(),
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + '+1'
  		});

  		$("#resignation_trans_date").datepicker({
      			dateFormat: 'yy-mm-dd',
      			defaultDate: new Date(),
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + '+1'
  		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

<script>
	function load_employment_details(emp_id){
		document.getElementById("inputform").reset();
		$("#emp_id").val(emp_id);
		$("#transfer_div").hide();
		$("#branch_transfer_div").hide(1000);
		$("#division_transfer_div").hide(1000);
		var siteUrl = '<?php echo base_url(); ?>';

		if(emp_id != ''){
			$.ajax({
				url: siteUrl + 'hr/employee/get_employee_details',
				type: "POST",
				async: false,
				dataType: 'json',
				data: {emp_id:emp_id},
				success: function(data) {
					$("#surname").val(data.employee_details.initial+' '+data.employee_details.surname);
					$("#nic_no").val(data.employee_details.nic_no);
					var branch_id = data.employee_details.branch;
					var division_id = data.employee_details.division;
					var designation_id = data.employee_details.designation;
					var employment_type_id = data.employee_details.employment_type;
					var leave_category_id = data.employee_details.leave_category;
					var duration = data.employee_details.duration;
					var siteUrl = '<?php echo base_url(); ?>';
					$.ajax({
						url: siteUrl + 'hr/employee/get_employement_details',
						type: "POST",
						async: false,
						dataType: 'json',
						data: { branch:branch_id, division:division_id, designation:designation_id, employment_type:employment_type_id, leave_category:leave_category_id},
						success: function(data) {
							$("#branch").val(data.branch.branch_name);
							$("#division").val(data.division.division_name);
							$("#designation").val(data.designation.designation);
							$("#employment_type").val(data.employment_type.employment_type);
							$("#transaction_type_div").show();


							$("#current_branch").val(data.branch.branch_name);
							$("#current_branch_val").val(branch_id);
							$("#new_branch").find('option').removeAttr("disabled");
							$("#new_branch option[value='"+branch_id+"']").attr("disabled","disabled");
							$("#current_division").val(data.division.division_name);
							$("#current_division_val").val(division_id);
							$("#new_division").find('option').removeAttr("disabled");
							$("#new_division option[value='"+division_id+"']").attr("disabled","disabled");

							$("#current_designation").val(data.designation.designation);
							$("#current_designation_val").val(designation_id);
							$("#new_designation").find('option').removeAttr("disabled");
							$("#new_designation option[value='"+designation_id+"']").attr("disabled","disabled");

							$("#current_leave_profile").val(data.leave_category.leave_category_name);
							$("#current_leave_profile_val").val(leave_category_id);
							$("#new_leave_profile").find('option').removeAttr("disabled");
							$("#new_leave_profile option[value='"+leave_category_id+"']").attr("disabled","disabled");

							$("#current_employement_type").val(data.employment_type.employment_type);
							$("#current_employement_type_val").val(employment_type_id);
							$("#new_employement_type").find('option').removeAttr("disabled");
							$("#new_employement_type option[value='"+employment_type_id+"']").attr("disabled","disabled");
							$("#current_duration").val(duration);
						},
						error: function(e) {
							console.log(e.responseText);
						}
					});
				},
				error: function(e) {
					console.log(e.responseText);
				}
			});
		}else{
			$("#surname").val('');
			$("#nic_no").val('');
			$("#branch").val('');
			$("#division").val('');
			$("#designation").val('');
			$("#employment_type").val('');
			$("#transaction_type_div").hide();
		}
	}

	function load_transaction_type(transaction_type){
		var siteUrl = '<?php echo base_url(); ?>';
		var emp_id = $('#emp_id').val();

		if(transaction_type != '' && emp_id != ''){
			if(transaction_type == 'transfer_transaction'){
				$("#promotion_div").hide();
				$("#leave_div").hide();
				$("#employment_type_transaction_div").hide();
				$("#resignation_div").hide();
				$("#transfer_div").show();
			}else if(transaction_type == 'promotion_transaction'){
				$("#transfer_div").hide();
				$("#leave_div").hide();
				$("#employment_type_transaction_div").hide();
				$("#resignation_div").hide();
				$("#promotion_div").show();
			}else if(transaction_type == 'leave_category_transaction'){
				$("#transfer_div").hide();
				$("#promotion_div").hide();
				$("#employment_type_transaction_div").hide();
				$("#resignation_div").hide();
				$("#leave_div").show();
			}else if(transaction_type == 'employment_type_transaction'){
				$("#transfer_div").hide();
				$("#promotion_div").hide();
				$("#leave_div").hide();
				$("#resignation_div").hide();
				$("#employment_type_transaction_div").show();
			}else if(transaction_type == 'resignation_transaction'){
				//alert(emp_id)
				$.ajax({
					url: siteUrl + 'hr/gratuity_compute/get_employement_details',
					type: "POST",
					async: false,
					dataType: 'json',
					data: { emp_id:emp_id},
					success: function(data) {
						if(data){
							var gra_val=parseFloat(data.total_gratuity).toFixed(2);
							//roundN(data.total_gratuity * 100) / 100).toFixed(2);//parseFloat().toFixed(2);

							$("#gratuity").val(gra_val);
							$("#gratuity_val").val(gra_val);
							$("#gratuity_legers").val(data.cr_account);
						}


					},
					error: function(e) {
						console.log(e.responseText);
					}
				});
				$("#transfer_div").hide();
				$("#promotion_div").hide();
				$("#leave_div").hide();
				$("#employment_type_transaction_div").hide();
				$("#resignation_div").show();
			}else if(transaction_type == ''){
				$("#transfer_div").hide();
				$("#promotion_div").hide();
				$("#leave_div").hide();
				$("#employment_type_transaction_div").hide();
				$("#resignation_div").hide();
			}
		}else if(transaction_type == ''){
				$("#transfer_div").hide();
				$("#promotion_div").hide();
				$("#leave_div").hide();
				$("#employment_type_transaction_div").hide();
			}
	}

	function load_transfer_type(transfer_type){
		if(transfer_type == 'division_only'){
			$("#division_transfer_div").show(1000);
			$("#transfer_date_div").show(1000);
			$("#branch_transfer_div").hide(1000);
		}else if(transfer_type == 'branch_and_division'){
			$("#branch_transfer_div").show(1000);
			$("#division_transfer_div").show(1000);
			$("#transfer_date_div").show(1000);
		}else if(transfer_type == 'branch_only'){
			$("#branch_transfer_div").show(1000);
			$("#transfer_date_div").show(1000);
			$("#division_transfer_div").hide(1000);
		}else if(transfer_type == ''){
			$("#branch_transfer_div").hide(1000);
			$("#division_transfer_div").hide(1000);
			$("#transfer_date_div").hide(1000);
		}
	}

	function load_employment_type_transaction(employment_type_transaction){
		if(employment_type_transaction == 'employement_type_only'){
			$("#employement_type_only_div").show(1000);
			$("#employment_type_date_div").show(1000);
			$("#employement_type_and_duration_div").hide(1000);
		}else if(employment_type_transaction == 'employement_type_and_duration'){
			$("#employement_type_and_duration_div").show(1000);
			$("#employement_type_only_div").show(1000);
			$("#employment_type_date_div").show(1000);
		}else if(employment_type_transaction == 'duration_only'){
			$("#employement_type_and_duration_div").show(1000);
			$("#employment_type_date_div").show(1000);
			$("#employement_type_only_div").hide(1000);
		}else if(employment_type_transaction == ''){
			$("#employement_type_and_duration_div").hide(1000);
			$("#employement_type_only_div").hide(1000);
			$("#employment_type_date_div").hide(1000);
		}
	}


	function load_promotion_type(type){
		var emp_id = document.getElementById("emp_id").value;
		if(type != ''){
			$("#designation_transaction_div").show(1000);
			$("#promotion_date_div").show(1000);
		}else if(type == ''){
			$("#designation_transaction_div").hide(1000);
			$("#promotion_date_div").hide(1000);
		}
	}
function calc_gratuity(val)
{

var siteUrl = '<?php echo base_url(); ?>';
var date_val=$('#resignation_trans_date').val();

var emp_id = $('#emp_id').val();
//let date_val = date_val.getFullYear() + "-" + (date_val.getMonth() + 1) + "-" + date_val.getDate()
	$.ajax({
		url: siteUrl + 'hr/gratuity_compute/calc_gratuity_fordate',
		type: "POST",
		async: false,
		dataType: 'json',
		data: { emp_id:emp_id,date_val:date_val},
		success: function(data) {
			//alert(data)
			//console.log(data);
			if(data){
				var gra_val=parseFloat(data.total_gratuity).toFixed(2);
				//roundN(data.total_gratuity * 100) / 100).toFixed(2);//parseFloat().toFixed(2);

				$("#gratuity").val(gra_val);
				//$("#gratuity_val").val(gra_val);
				$("#gratuity_legers").val(data.cr_account);
			}


		},
		error: function(e) {
			console.log(e.responseText);
		}
	});
}
</script>
<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();

			var transaction_type = $('#transaction_type').val();
			if(transaction_type == 'transfer_transaction'){
				var submit_url = siteUrl + 'hr/emp_payroll/employee_transfer_update';
			}else if(transaction_type == 'promotion_transaction'){
				var submit_url = siteUrl + 'hr/emp_payroll/employee_promotion_update';
			}else if(transaction_type == 'leave_category_transaction'){
				var submit_url = siteUrl + 'hr/emp_payroll/employee_leave_category_update';
			}else if(transaction_type == 'employment_type_transaction'){
				var submit_url = siteUrl + 'hr/emp_payroll/employee_employment_type_update';
			}else if(transaction_type == 'resignation_transaction'){
				var submit_url = siteUrl + 'hr/emp_payroll/employee_resignation_update';
			}
			$.ajax({
				url: submit_url,
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {
	                if($.isEmptyObject(data.error)){
						location.reload();
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

	  	function successfulAttemptAction(successMsg){
    		$('html, body').animate({scrollTop: '0px'}, 300);//scroll to the top
    		var messageBoardDIV = $('#messageBoard');
			messageBoardDIV.empty();

			//append error message to the "messageBoard" block
			$(messageBoardDIV).append('<div class="alert alert-success fade in">\
				<strong>Success!</strong>\
				<div class="row">'+successMsg+'</div>\
				<div class="row">\
					<button type="button" id="close-btn" class="btn btn-primary">Done</button>\
				</div>\
			</div>');
	  	}

	});
</script>

<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<!--block which displays the outcome message-->
		<div id="messageBoard">
			<?php
			if($this->session->flashdata('msg') != ''){ ?>
				<div class="alert alert-success  fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('msg'); ?>
				</div>
			<?php
			} ?>
	   </div>

		  <div class="table">
			<h3 class="title1">Employee Transaction</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Transaction</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Employee Transaction</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>No</th>
						  <th>Employee</th>
						  <th>Branch</th>
						  <th>Designation</th>
						  <th>Employment_type</th>
						  <th>Basic Salary</th>
						  <th>Created Date</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  $count = 1;
						  $ci =&get_instance();
						  $ci->load->model('employee_model');
						  $ci->load->model('common_hr_model');
						  foreach($datalist as $row){ ?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td>
								<?php
								$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
								echo $empDetails['epf_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'];
								?>
							  </td>
							  <td>
								<?php
								$branch_details = $ci->common_hr_model->get_branch_details($row->branch);
								echo $branch_details['branch_name'];
								?>
							  </td>
							  <td>
								<?php
								$designation_details = $ci->common_hr_model->get_designation_details($row->designation);
								echo $designation_details['designation'];
								?>
							  </td>
							  <td>
								<?php
								$employment_type_details = $ci->common_hr_model->get_employment_type_details($row->employment_type);
								echo $employment_type_details['employment_type'];
								?>
							  </td>
							  <td><?php echo $row->basic_salary; ?></td>
							  <td><?php echo $row->created; ?></td>
							</tr>
						  <?php
							$count++;
						  }
						} ?>
					  </tbody>
					</table>
					<div id="pagination-container"><?php echo $this->pagination->create_links(); ?></div>
				  </div>
				</div>

				<div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">
				  <p>
					<div class="row">
					  <form data-toggle="validator" id="inputform" name="inputform" method="post">
						<input type="hidden" name="transaction_form_submit_type" id="transaction_form_submit_type" value="insert" />
						<div class="form-title">
						  <h4>Employee Transaction</h4>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group has-feedback" id="emp_id_div">
								<label for="emp_id" class="control-label">Select Employee</label>
								<select class="form-control" id="emp_id" name="emp_id" onChange="load_employment_details(this.value);" required>
								  <option value="">--Select Employee--</option>
								  <?php
								  foreach($employee_list as $employee_list_row){
									if($employee_list_row->status == "A"){ ?>
										<option value="<?php echo $employee_list_row->id; ?>"><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->initial.' '.$employee_list_row->surname; ?></option>
									<?php
									}
								  } ?>
								</select>
								<span class="help-block with-errors" ></span>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-xs-12"><hr></div>

						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group has-feedback" id="surname_div">
								<label for="surname" class="control-label" >Name</label>
								<input type="text" class="form-control" id="surname" name="surname" value="" placeholder="Name" readonly>
							  </div>

							  <div class="form-group has-feedback" id="branch_div">
								<label for="branch" class="control-label">Branch</label>
								<input type="text" class="form-control" id="branch" name="branch" value="" placeholder="Branch" readonly>
							  </div>

							  <div class="form-group has-feedback" id="designation_div">
								<label for="designation" class="control-label">Designation</label>
								<input type="text" class="form-control" id="designation" name="designation" value="" placeholder="Designation" readonly>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-md-6 validation-grids validation-grids-left">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group" id="nic_no_div">
								<label for="nic_no" class="control-label">NIC</label>
								<input type="text" class="form-control" id="nic_no" name="nic_no" value="" placeholder="NIC" readonly>
							  </div>

							  <div class="form-group" id="division_div">
								<label for="division" class="control-label">Division</label>
								<input type="text" class="form-control" id="division" name="division" value="" placeholder="Division" readonly>
							  </div>

							  <div class="form-group" id="employment_type_div">
								<label for="employment_type" class="control-label">Employment Type</label>
								<input type="text" class="form-control" id="employment_type" name="employment_type" value="" placeholder="Employment Type" readonly>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-xs-12"><hr></div>

						<div class="col-md-6 validation-grids validation-grids-left">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group" id="transaction_type_div" style="display: none;">
								<label for="transaction_type" class="control-label">Select Transaction Type</label>
								<select class="form-control" id="transaction_type" name="transaction_type" onChange="load_transaction_type(this.value);" required>
								  <option value="">--Select Transaction Type--</option>
								  <option value="transfer_transaction">Transfer</option>
								  <option value="promotion_transaction">Promotion/ Demotion/ Designation Change</option>
								  <option value="leave_category_transaction">Leave Category Update</option>
								  <option value="employment_type_transaction">Employment Type/ Duration</option>
								  <option value="resignation_transaction">Resignation</option>
								</select>
								<span class="help-block with-errors" ></span>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-xs-12"><hr></div>

						<div id="transfer_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="transfer_type" class="control-label">Transfer Type</label>
								  <select class="form-control" id="transfer_type" name="transfer_type" onChange="load_transfer_type(this.value);">
									<option value="">Select Transfer Type</option>
									<option value="division_only">Division Transfer (Inter-branch)</option>
									<option value="branch_and_division">Branch & Division Transfer</option>
									<option value="branch_only">Branch Transfer (Branch only)</option>
								  </select>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>

						  <div id="branch_transfer_div" style="display:none">
							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="current_branch" class="control-label">Current Branch</label>
									<input type="text" class="form-control" id="current_branch" name="current_branch" value="" readonly/>
									<input type="hidden" id="current_branch_val" name="current_branch_val" value="" />
								  </div>
								</div>
							  </div>
							</div>

							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="new_branch" class="control-label">Transfer To - Branch</label>
									<select name="new_branch" id="new_branch" class="form-control" placeholder="New Branch">
									  <option value="">select a branch</option>
									  <?php
									  foreach($branches as $branches_row){ ?>
										<option value="<?php echo $branches_row->branch_code; ?>"><?php echo $branches_row->branch_name; ?></option>
									  <?php
									  } ?>
									</select>
								  </div>
								</div>
							  </div>
							</div>
						  </div>

						  <div id="division_transfer_div" style="display:none">
							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="current_division" class="control-label">Current Division</label>
									<input type="text" class="form-control" id="current_division" name="current_division" value="" readonly/>
									<input type="hidden" id="current_division_val" name="current_division_val" value="" />
								  </div>
								</div>
							  </div>
							</div>

							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="new_division" class="control-label">Transfer To - Division</label>
									<select name="new_division" id="new_division" class="form-control" placeholder="New Division">
									  <option value="">select a division</option>
									  <?php
									  foreach($divisions as $division_row){ ?>
										<option value="<?php echo $division_row->id; ?>"><?php echo $division_row->division_name; ?></option>
									  <?php
									  } ?>
									</select>
								  </div>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group" id="transfer_date_div" style="display:none">
								  <label for="transfer_date" class="control-label">Transfer Valid From</label>
								  <input type="text" class="form-control" id="transfer_date" name="transfer_date" value="" placeholder="DD/MM/YYYY" readonly />
								  <span class="add-on"><i class="icon-calendar"></i></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>
						</div>

						<div id="promotion_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="promotion_type" class="control-label">Promotion Type</label>
								  <select class="form-control" id="promotion_type" name="promotion_type" onChange="load_promotion_type(this.value);">
									<option value="">Select Update Type</option>
									<option value="Promotion">Promotion</option>
									<option value="Demotion">Demotion</option>
									<option value="Designation Change">Designation Change</option>
								  </select>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>

						  <div id="designation_transaction_div" style="display:none">
							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="current_designation" class="control-label">Current Designation</label>
									<input type="text" class="form-control" id="current_designation" name="current_designation" value="" readonly/>
									<input type="hidden" id="current_designation_val" name="current_designation_val" value="" />
								  </div>
								</div>
							  </div>
							</div>

							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="new_designation" class="control-label">New Designation</label>
									<select name="new_designation" id="new_designation" class="form-control" placeholder="New Branch">
									  <option value="">select designation</option>
									  <?php
									  foreach($designations as $designation_row){ ?>
										<option value="<?php echo $designation_row->id; ?>"><?php echo $designation_row->designation; ?></option>
									  <?php
									  } ?>
									</select>
								  </div>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group" id="promotion_date_div" style="display:none">
								  <label for="promotion_date" class="control-label">Changes Valid From</label>
								  <input type="text" class="form-control" id="promotion_date" name="promotion_date" value="" placeholder="DD/MM/YYYY" readonly />
								  <span class="add-on"><i class="icon-calendar"></i></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>
						</div>

						<div id="leave_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="current_leave_profile" class="control-label">Current Leave Category</label>
								  <input type="text" class="form-control" id="current_leave_profile" name="current_leave_profile" value="" readonly/>
								  <input type="hidden" id="current_leave_profile_val" name="current_leave_profile_val" value="" />
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="new_leave_profile" class="control-label">New Leave Category</label>
								  <select name="new_leave_profile" id="new_leave_profile" class="form-control" placeholder="New Leave Category">
									<option value="">select leave category</option>
									<?php
									foreach($leave_category_list as $leave_category_row){ ?>
										<option value="<?php echo $leave_category_row->id; ?>"><?php echo $leave_category_row->leave_category_name; ?></option>
									<?php
									} ?>
								  </select>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="leave_trans_date" class="control-label">Changes Valid From</label>
								  <input type="text" class="form-control" id="leave_trans_date" name="leave_trans_date" value="" placeholder="DD/MM/YYYY" readonly />
								  <span class="add-on"><i class="icon-calendar"></i></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>
						</div>

						<div id="employment_type_transaction_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="employment_type_transaction" class="control-label">Employement Type/ Duration</label>
								  <select class="form-control" id="employment_type_transaction" name="employment_type_transaction" onChange="load_employment_type_transaction(this.value);">
									<option value="">Select Type</option>
									<option value="employement_type_only">Employement Type</option>
									<option value="employement_type_and_duration">Employement Type & Duration</option>
									<option value="duration_only">Duration</option>
								  </select>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>

						  <div id="employement_type_only_div" style="display:none">
							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="current_employement_type" class="control-label">Current Employement Type</label>
									<input type="text" class="form-control" id="current_employement_type" name="current_employement_type" value="" readonly/>
									<input type="hidden" id="current_employement_type_val" name="current_employement_type_val" value="" />
								  </div>
								</div>
							  </div>
							</div>

							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="new_employement_type" class="control-label">New Employement Type</label>
									<select name="new_employement_type" id="new_employement_type" class="form-control" placeholder="New Branch">
									  <option value="">select employement type</option>
									  <?php
									  foreach($employment_types as $employment_row){ ?>
										<option value="<?php echo $employment_row->id; ?>"><?php echo $employment_row->employment_type; ?></option>
									  <?php
									  } ?>
									</select>
								  </div>
								</div>
							  </div>
							</div>
						  </div>

						  <div id="employement_type_and_duration_div" style="display:none">
							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="current_duration" class="control-label">Current Duration (months)</label>
									<input type="text" class="form-control" id="current_duration" name="current_duration" value="" readonly/>
								  </div>
								</div>
							  </div>
							</div>

							<div class="col-md-6 validation-grids validation-grids-left">
							  <div class="" data-example-id="basic-forms">
								<div class="form-body">
								  <div class="form-group">
									<label for="new_duration" class="control-label">New Duration (months)</label>
									<input type="number" class="form-control" id="new_duration" name="new_duration" value=""/>
								  </div>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group" id="employment_type_date_div" style="display:none">
								  <label for="employment_type_date" class="control-label">Valid From</label>
								  <input type="text" class="form-control" id="employment_type_date" name="employment_type_date" value="" placeholder="DD/MM/YYYY" readonly />
								  <span class="add-on"><i class="icon-calendar"></i></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>
						</div>

						<div id="resignation_div" style="display: none;">

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
								<div class="form-body">
							  <label class="control-label" style="font-size: 120%;">Calculated Gratuity Value</label>
								</div>
								<div class="form-body">
							  <input type="number" class="form-control" id="gratuity" name="gratuity" value="" placeholder="Gratuity %" readonly>
								<input type="hidden" class="form-control" id="gratuity_legers" name="gratuity_legers" value="" >

								</div>
								<div class="form-body">
							  <label class="control-label" style="font-size: 120%;">Gratuity Payment</label>
								</div>
								<div class="form-body">
							  <input type="number" class="form-control" id="gratuity_val" name="gratuity_val" value="" placeholder="" >
						    </div>
							  <div class="form-body">
								<div class="form-group">
								  <label for="resignation_trans_date" class="control-label">Resignation Valid From</label>
								  <input type="text" class="form-control" id="resignation_trans_date" name="resignation_trans_date" value="" placeholder="DD/MM/YYYY" onChange="calc_gratuity(this.value);" readonly />
								  <span class="add-on"><i class="icon-calendar"></i></span>
								</div>
								<div class="form-group">
								  <label for="resignation_trans_date" class="control-label">Reason</label>
								  <textarea type="text" class="form-control" id="resignation_reason" name="resignation_reason"></textarea>
								  <span class="add-on"><i class="icon-calendar"></i></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>
						</div>

						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Submit</button>
						  </div>
						</div>

					  </form>
					</div>
				  </p>
				</div>
			  </div>
			</div>
		  </div>
	  </div>
	</div>

  </div>
</div>
