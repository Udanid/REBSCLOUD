<script>
	$(document).ready(function(){

  		$("#internal_loan_start_date").datepicker({
      		dateFormat: 'dd-MM-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-50' + ':' + '+1'
  		});
  		$("#external_loan_start_date").datepicker({
      		dateFormat: 'dd-MM-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-50' + ':' + '+1'
  		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
	function call_delete(id)
	{

		document.deletekeyform.deletekey.value=id;
		$('#complexConfirm').click();
	}
</script>

<script>
	function load_employment_details(emp_id){
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
					var siteUrl = '<?php echo base_url(); ?>';
					$.ajax({
						url: siteUrl + 'hr/employee/get_employement_details',
						type: "POST",
						async: false,
						dataType: 'json',
						data: { branch:data.employee_details.branch, division:data.employee_details.division, designation:data.employee_details.designation, employment_type:data.employee_details.employment_type},
						success: function(data) {
							$("#branch").val(data.branch.branch_name);
							$("#division").val(data.division.division_name);
							$("#designation").val(data.designation.designation);
							$("#employment_type").val(data.employment_type.employment_type);
							$("#loan_type_div").show();
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
			$("#loan_type_div").hide();
		}
	}

	function load_loan_type(loan_type){
		var emp_id = $('#emp_id').val();

		if(loan_type != '' && emp_id != ''){
			if(loan_type == 'internal_loan'){
				$("#external_loan_div").hide();
				$("#internal_loan_div").show();
			}else if(loan_type == 'external_loan'){
				$("#internal_loan_div").hide();
				$("#external_loan_div").show();
			}else if(loan_type == ''){
				$("#internal_loan_div").hide();
				$("#external_loan_div").hide();
			}
		}
	}

	function calculate_monthly_deduction(instalments){
		var internal_loan_amount = $('#internal_loan_amount').val();
		var monthly_deduction_amount = internal_loan_amount/instalments;
		$("#internal_monthly_deduction_amount").val(monthly_deduction_amount);

	}

	function reset_monthly_deduction(){
		$("#internal_monthly_deduction_amount").val("");
		$("#internal_instalments").val("");
	}

	function loadbranchlist(itemcode){
		var code = itemcode.split("-")[0];
		if(code != ''){
			$("#bank_branch_load").load("<?php echo base_url();?>hr/hr_common/get_bank_branchlist/"+itemcode);
		}
	}

</script>
<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				url: siteUrl + 'hr/employee/employee_loan_update',
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
			<h3 class="title1">Loans</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Loans</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Loan</a>
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
						  <th>Loan Type</th>
						  <th>Monthly Deduction Amount</th>
						  <th>Instalments</th>
						  <th>Status</th>
						  <th>Active</th>
						  <th></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  $count = 1;
						  $ci =&get_instance();
						  $ci->load->model('employee_model');
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
								if($row->loan_type == "internal_loan"){
									$loan_type = "Internal Loan";
								}else if($row->loan_type == "external_loan"){
									$loan_type = "External Loan";
								}
								echo $loan_type; ?>
							  </td>
							  <td><?php echo $row->monthly_deduction_amount; ?></td>
							  <td><?php echo $row->instalments; ?></td>
							  <td>
								<?php
								if($row->status == "P"){
									$status = "Pending";
								}else if($row->status == "Y"){
									$status = "Confirmed";
								}else if($row->status == "N"){
									$status = "Declined";
								}
								echo $status; ?>
							  </td>
							  <td>
								<?php
								if($row->active_loan == "P"){
									$active_loan = "Pending";
								}else if($row->active_loan == "Y"){
									$active_loan = "Active";
								}else if($row->active_loan == "N"){
									$active_loan = "Past";
								}
								echo $active_loan; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
								  <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
									<a href="javascript:call_delete('<?php echo $row->id;?>')"><i class="fa fa-times nav_icon icon_red"></i></a>
								  <?php
								  if($row->status == "P"){ ?>
									  <a href="javascript:call_confirm('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
								  <?php
								  }
								  ?>
								</div>
							  </td>
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
						<input type="hidden" name="loan_form_submit_type" id="loan_form_submit_type" value="insert" />
						<div class="form-title">
						  <h4>Employee Loan</h4>
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
									if($employee_list_row->status == "A" && $employee_list_row->salary_confirmation == "Y"){ ?>
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
							  <div class="form-group" id="loan_type_div" style="display: none;">
								<label for="loan_type" class="control-label">Select Loan Type</label>
								<select class="form-control" id="loan_type" name="loan_type" onChange="load_loan_type(this.value);" required>
								  <option value="">--Select Loan Type--</option>
								  <option value="internal_loan">Internal Loan</option>
								  <option value="external_loan">External Loan</option>
								</select>
								<span class="help-block with-errors" ></span>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-xs-12"><hr></div>

						<div id="internal_loan_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="internal_loan_id" class="control-label">Select Loan</label>
								  <select class="form-control" id="internal_loan_id" name="internal_loan_id" required>
									<option value="">--Select Loan--</option>
									<?php
									foreach($internal_loans as $internal_loan_row){ ?>
										<option value="<?php echo $internal_loan_row->id; ?>"><?php echo $internal_loan_row->loan; ?></option>
									<?php
									} ?>
								  </select>
								  <span class="help-block with-errors" ></span>
								</div>

								<div class="form-group">
								  <label for="internal_instalments" class="control-label">Instalments</label>
								  <input type="number" onchange="calculate_monthly_deduction(this.value);" class="form-control" id="internal_instalments" name="internal_instalments" value="" placeholder="Instalments" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" required>
								  <span class="help-block with-errors" ></span>
								</div>

								<div class="form-group">
								  <label for="internal_loan_start_date" class="control-label">Start Date</label>
								  <input type="text" class="form-control" id="internal_loan_start_date" name="internal_loan_start_date" value="" placeholder="DD/MM/YYYY" readonly required/>
								  <span class="add-on"><i class="icon-calendar"></i></span>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="internal_loan_amount" class="control-label">Loan Amount</label>
								  <input type="number" onchange="reset_monthly_deduction();" class="form-control" id="internal_loan_amount" name="internal_loan_amount" value="" placeholder="Loan Amount" min="0" required>
								  <span class="help-block with-errors" ></span>
								</div>

								<div class="form-group">
								  <label for="internal_monthly_deduction_amount" class="control-label">Monthly Deduction Amount</label>
								  <input type="number" class="form-control" id="internal_monthly_deduction_amount" name="internal_monthly_deduction_amount" value="" placeholder="Monthly Deduction Amount" readonly required>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"><hr></div>
						</div>

						<div id="external_loan_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="external_monthly_deduction_amount" class="control-label">Monthly Deduction Amount</label>
								  <input type="number" class="form-control" id="external_monthly_deduction_amount" name="external_monthly_deduction_amount" value="" placeholder="Monthly Deduction Amount" min="0" required>
								  <span class="help-block with-errors" ></span>
								</div>

								<div class="form-group">
								  <label for="external_loan_start_date" class="control-label">Start Date</label>
								  <input type="text" class="form-control" id="external_loan_start_date" name="external_loan_start_date" value="" placeholder="DD/MM/YYYY" readonly required/>
								  <span class="add-on"><i class="icon-calendar"></i></span>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="external_instalments" class="control-label">Instalments</label>
								  <input type="number" class="form-control" id="external_instalments" name="external_instalments" value="" placeholder="Instalments" min="0" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 48 && event.charCode <= 57" required>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-xs-12"></div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="bank_code" class="control-label">Bank name</label>
								  <select class="form-control" id="bank_code" name="bank_code" onChange="loadbranchlist(this.value); document.getElementById('bank_name').value=this.options[this.selectedIndex].text;" required>
									<option value="">Bank</option>
									<?php
									foreach($bank_list as $bank_list_row){ ?>
										<option value=<?php echo $bank_list_row->BANKCODE; ?>><?php echo $bank_list_row->BANKNAME; ?></option>
										<?php
									} ?>
								  </select>
								  <span class="help-block with-errors" ></span>
								  <input type="hidden" name="bank_name" id="bank_name" value="" />
								</div>

								<div class="form-group">
								  <label for="account_no" class="control-label">Account No.</label>
								  <input type="text" class="form-control" id="account_no" name="account_no" value="" placeholder="Account #" required>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="branch_name" class="control-label">Branch</label>
								  <div id="bank_branch_load">
									<select name="bank_branch" id="bank_branch" class="form-control" placeholder="Bank" required>
									  <option value="">Branch</option>
									</select>
									<span class="help-block with-errors" ></span>
								  </div>
								</div>

								<div class="form-group">
								  <label for="account_type" class="control-label">Account type</label>
								  <input type="text" class="form-control" id="account_type" name="account_type" value="" placeholder="Account type">
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
</form>
<script>

$("#complexConfirm").confirm({
	title:"Delete confirmation",
	text: "Are You sure you want to delete this ?" ,
	headerClass:"modal-header",
	confirm: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		var code=1
		window.location="<?=base_url()?>hr/employee/emp_loan_delete/"+document.deletekeyform.deletekey.value;
	},
	cancel: function(button) {
		button.fadeOut(2000).fadeIn(2000);
		// alert("You aborted the operation.");
	},
	confirmButton: "Yes I am",
	cancelButton: "No"
});


	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/employee/edit_emp_loan/"+id );
	}

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_confirm(id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/employee/employee_loan_confirm',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {loan_id:id},
			success: function(data) {
	        	location.reload();
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}

</script>
