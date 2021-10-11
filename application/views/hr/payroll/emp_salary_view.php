<script>
	$(document).ready(function(){

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

		$('#inputform :checkbox').change(function (){
			if($(this).is(':checked') && $(this).attr('name') == 'allowance[]'){
				$("#allowance_div_"+$(this).val()).show(1000);
				$("#allowance_"+$(this).val()).attr('required',true);
			}else if(!$(this).is(':checked') && $(this).attr('name') == 'allowance[]'){
				$("#allowance_div_"+$(this).val()).hide(1000);
				$("#allowance_"+$(this).val()).attr('required',false);
				//$("#allowance_"+$(this).val()).removeAttr('required');
			}
		});

	});
</script>

<script>

	function load_employment_details(emp_id){
		$('input:checkbox').removeAttr('checked');
		$('div[id^="allowance_div_"]').hide(500);
		document.getElementById("inputform").reset();
		$("#emp_id").val(emp_id);
		var siteUrl = '<?php echo base_url(); ?>';

		if(emp_id != ''){
			$.ajax({
				cache: false,
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
						cache: false,
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
						},
						error: function(e) {
							console.log(e.responseText);
						}
					});
					$.ajax({
						cache: false,
						url: siteUrl + 'hr/emp_payroll/get_employee_salary_details',
						type: "POST",
						async: false,
						dataType: 'json',
						data: {emp_id:emp_id},
						success: function(data) {
							if(data.employee_salary == ""){
								$("#submit_type").val('insert');
								$("#salary_id").val('');
							}else{
								$("#submit_type").val('update');
								$("#salary_id").val(data.employee_salary.id);
							}

							$("#basic_salary").val(data.employee_salary.basic_salary);
							$("#gratuity").val(data.employee_salary.gratuity);
							if(data.employee_salary.payee_tax == "Y"){
								$('input[name=paye]').attr('checked', true);
							}
							if(data.employee_salary.epf == "Y"){
								$('input[name=EPF]').attr('checked', true);
							}
							if(data.employee_salary.etf == "Y"){
								$('input[name=ETF]').attr('checked', true);
							}
							var i;
							for(i = 0; i < data.employee_allowances.length; i++){
						  	  //$('input[id=allowance_check_'+data.employee_allowances[i].allowance_id+']').attr("checked", true);
							  $("#allowance_check_"+data.employee_allowances[i].allowance_id).attr("checked", true);
								$("#allowance_div_"+data.employee_allowances[i].allowance_id).show(1000);
								$("#allowance_"+data.employee_allowances[i].allowance_id).val(data.employee_allowances[i].value);
								$("#allowance_"+data.employee_allowances[i].allowance_id).attr('required', true);
							}
							var j;
							for(j = 0; j < data.employee_deductions.length; j++){
						  	  $('input[id=deduction_check_'+data.employee_deductions[j].deduction_id+']').attr("checked", true);
							}
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
				cache: false,
				url: siteUrl + 'hr/emp_payroll/define_employee_salary',
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
			<h3 class="title1">Employee Salary</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Salary</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Define Employee Salary</a>
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
						  <th>Basic Salary</th>
						  <th>Status</th>
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
							  <td><?php echo $row->basic_salary; ?></td>
							  <td>
								<?php
								if($row->status == "Y"){
									$status = "Confirmed";
								}else if($row->status == "N"){
									$status = "Not Confirmed";
								}
								echo $status; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
								  <a href="javascript:call_edit('<?php echo $row->id;?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
								  <?php
								  if($row->status == "N"){ ?>
									  <a href="javascript:call_confirm('<?php echo $row->id;?>', '<?php echo $row->emp_record_id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>
										<a href="javascript:call_delete('<?php echo $row->id;?>', '<?php echo $row->emp_record_id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>

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
						<input type="hidden" id="submit_type" name="submit_type" value="">
						<input type="hidden" id="salary_id" name="salary_id" value="">
						<input type="hidden" id="salary_status" name="salary_status" value="N">
						<div class="form-title">
						  <h4>Employee Salary</h4>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group" id="emp_id_div">
								<label for="emp_id" class="control-label">Select Employee</label>
								<select class="form-control" id="emp_id" name="emp_id" onChange="load_employment_details(this.value);" required>
								  <option value="">--Select Employee--</option>
								  <?php
								  foreach($employee_list as $employee_list_row){
									if($employee_list_row->status == "A" && $employee_list_row->salary_confirmation == "N" && $pending_salary_list[$employee_list_row->id]==Null){ ?>
										<option value="<?php echo $employee_list_row->id; ?>"><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->initial.' '.$employee_list_row->surname; ?></option>
									<?php
									}
								  } ?>
								</select>
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

						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group">
								<label for="basic_salary" class="control-label">Basic Salary</label>
								<input type="number" class="form-control" id="basic_salary" name="basic_salary" value="" placeholder="Basic Salary" required>
							  </div>
								<div class="form-group">
							  <label for="gratuity" class="control-label">Gratuity %</label>
							  <input type="number" class="form-control" id="gratuity" name="gratuity" value="" placeholder="Gratuity %" required>
						    </div>
							</div>

							<hr>

							<div class="form-body">
								<label class="control-label" style="font-size: 120%;">Allowances</label>
							</div>

							<?php
							foreach($allowances as $allowance_row){ ?>
								<div class="form-body">
								  <div class="col-xs-6">
									<?php echo $allowance_row->allowance; ?>
								  </div>
								  <div class="col-xs-6">
									<input type="checkbox" id="allowance_check_<?php echo $allowance_row->id; ?>" name="allowance[]" value="<?php echo $allowance_row->id; ?>">
								  </div>
								  <div class="col-xs-12" id="allowance_div_<?php echo $allowance_row->id; ?>" style="display: none;">
									<input type="number" class="form-control" id="allowance_<?php echo $allowance_row->id; ?>" name="allowance_<?php echo $allowance_row->id; ?>" value="" placeholder="<?php echo $allowance_row->allowance; ?>" required>
									<span class="help-block with-errors" ><?php echo $allowance_row->allowance.' (in '.strtolower($allowance_row->amount_type).')'; ?></span>
								  </div>
								</div>
							<?php
							} ?>
						  </div>
						</div>

						<div class="col-md-6 validation-grids validation-grids-left">
						  <div class="" data-example-id="basic-forms">

							<div class="form-body">
							  <label class="control-label" style="font-size: 120%;">EPF/ETF</label>
							</div>
							<?php
							foreach($epf_etf as $epf_etf_row){ ?>
								<div class="form-body">
								  <div class="col-xs-6">
									<?php echo $epf_etf_row->type; ?>
								  </div>
								  <div class="col-xs-6">
									<input type="checkbox" name="<?php echo $epf_etf_row->type; ?>" value="<?php echo $epf_etf_row->type; ?>">
								  </div>
								</div>
							<?php
							}  ?>
							<hr>

							<div class="form-body">
							  <label class="control-label" style="font-size: 120%;">Paye Tax</label>
							</div>
							<div class="form-body">
							  <div class="col-xs-6">
								Paye Tax
							  </div>
							  <div class="col-xs-6">
								<input type="checkbox" name="paye" value="paye">
							  </div>
							</div>
							<hr>

							<div class="form-body">
							  <label class="control-label" style="font-size: 120%;">Deductions</label>
							</div>
							<?php
							foreach($deductions as $deduction_row){ ?>
								<div class="form-body">
								  <div class="col-xs-6">
									<?php echo $deduction_row->deduction; ?> <?php if($deduction_row->amount_type == "AMOUNT"){}else if($deduction_row->amount_type == "PRECENTAGE"){ echo "(%)";} ; ?>
								  </div>
								  <div class="col-xs-6">
									<input type="checkbox" id="deduction_check_<?php echo $deduction_row->id; ?>" name="deduction[]" value="<?php echo $deduction_row->id; ?>">
								  </div>
								</div>
							<?php
							}  ?>

						  </div>
						</div>

						<div class="col-xs-12"><hr></div>

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

<script>

	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/emp_payroll/edit_emp_salary/"+id );
	}

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_confirm(id, emp_id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/emp_payroll/employee_salary_confirm',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {salary_id:id, emp_id:emp_id},
			success: function(data) {
	        	location.reload();
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}
	function call_delete(id, emp_id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/emp_payroll/employee_salary_delete',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {salary_id:id, emp_id:emp_id},
			success: function(data) {
	        	location.reload();
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}

</script>
