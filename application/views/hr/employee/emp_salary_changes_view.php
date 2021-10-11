<script>
	$(document).ready(function(){
		
  		$("#effective_from").datepicker({
      			dateFormat: 'dd-MM-yy',
      			defaultDate: new Date(),
      			changeMonth: true,
      			changeYear: true,
      			yearRange: '-50' + ':' + '+1'
  		});

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
		$("#salary_div").hide();
		$("#allowance_div").hide();
		$("#epf_etf_paye_div").hide();
		$("#deduction_div").hide();
		$("#effective_from_div").hide();
		
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
						url: siteUrl + 'hr/employee/get_employee_salary_details',
						type: "POST",
						async: false,
						dataType: 'json',
						data: {emp_id:emp_id},
						success: function(data) {
							$("#salary_change_type_div").show();
							if(data.employee_salary == ""){
								$("#submit_type").val('insert');
								$("#salary_id").val('');
							}else{
								$("#submit_type").val('update');
								$("#salary_id").val(data.employee_salary.id);
							}
							
							$("#basic_salary").val(data.employee_salary.basic_salary);
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
			$("#salary_change_type_div").hide();
		}
	}
	
	function load_salary_change_type(update_type){
		var siteUrl = '<?php echo base_url(); ?>';
		var emp_id = $('#emp_id').val();
		
		if(emp_id != ''){
			if(update_type == 'salary_increment_decrement_update'){
				$("#allowance_div").hide();
				$("#epf_etf_paye_div").hide();
				$("#deduction_div").hide();
				$("#salary_div").show();
				$("#effective_from_div").show();
			}else if(update_type == 'allowance_update'){
				$("#salary_div").hide();
				$("#epf_etf_paye_div").hide();
				$("#deduction_div").hide();
				$("#allowance_div").show();
				$("#effective_from_div").show();
			}else if(update_type == 'epf_etf_paye_update'){
				$("#salary_div").hide();
				$("#allowance_div").hide();
				$("#deduction_div").hide();
				$("#epf_etf_paye_div").show();
				$("#effective_from_div").show();
			}else if(update_type == 'deduction_update'){
				$("#salary_div").hide();
				$("#allowance_div").hide();
				$("#epf_etf_paye_div").hide();
				$("#deduction_div").show();
				$("#effective_from_div").show();
			}else if(update_type == ''){
				$("#salary_div").hide();
				$("#allowance_div").hide();
				$("#epf_etf_paye_div").hide();
				$("#deduction_div").hide();
				$("#effective_from_div").hide();
			}
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
				url: siteUrl + 'hr/employee/define_employee_salary',
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
			<h3 class="title1">Employee Salary Changes</h3>	
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Salary Changes - Confirmation</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Employee Salary Changes</a>
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
						  <th>Change Type</th>
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
							  <td>
								<?php 
								if($row->change_type == "salary_increment_decrement_update"){
									$change_type = "Increment/Decrement";
									$edit_url = "edit_emp_increment_decrement";
								}else if($row->change_type == "allowance_update"){
									$change_type = "Allowance";
									$edit_url = "edit_emp_allowance";
								}else if($row->change_type == "epf_etf_paye_update"){
									$change_type = "EPF/ETF/Paye";
									$edit_url = "edit_emp_epf_etf_paye";
								}else if($row->change_type == "deduction_update"){
									$change_type = "Deduction";
									$edit_url = "edit_emp_deduction";
								}
								echo $change_type; ?>

							  </td>
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
								  <a href="javascript:call_edit('<?php echo $row->id;?>', '<?php echo $row->change_type;?>')" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
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
						<input type="hidden" id="salary_status" name="salary_status" value="Y">
						<div class="form-title">
						  <h4>Employee Salary Changes</h4>
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
									if($employee_list_row->status == "A" && $employee_list_row->salary_confirmation == "Y"){ ?>
										<option value="<?php echo $employee_list_row->id; ?>"><?php echo $employee_list_row->epf_no.' - '.$employee_list_row->surname; ?></option>
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

						<div id="salary_change_type_div" style="display: none;">
						  <div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <label for="salary_change_type" class="control-label">Select Salary Change Type</label>
								  <select class="form-control" id="salary_change_type" name="salary_change_type" onChange="load_salary_change_type(this.value);" required>
									<option value="">--Select Salary Change Type--</option>
									<option value="salary_increment_decrement_update">Increment/Decrement</option>
									<option value="allowance_update">Allowance Updates</option>
									<option value="epf_etf_paye_update">EPF/ETF/Paye</option>
									<option value="deduction_update">Deductions</option>
								  </select>
								  <span class="help-block with-errors" ></span>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="col-xs-12"><hr></div>
						</div>

						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">

							<div class="form-body" id="salary_div" style="display: none;">
							  <div class="form-group">
								<label for="salary_increment_decrement_type" class="control-label">Select Increment/Decrement Type</label>
								<select class="form-control" id="salary_increment_decrement_type" name="salary_increment_decrement_type" required>
								  <option value="">--Select Type--</option>
								  <option value="salary_increment_update">Increment</option>
								  <option value="salary_decrement_update">Decrement</option>
								</select>
								<span class="help-block with-errors" ></span>
							  </div>

							  <div class="form-group">
								<label for="basic_salary" class="control-label">Basic Salary</label>
								<input type="number" class="form-control" id="basic_salary" name="basic_salary" value="" placeholder="Basic Salary" readonly required>
							  </div>

							  <div class="form-group">
								<label for="salary_change_amount" class="control-label">Salary Increment/Decrement</label>
								<input type="number" class="form-control" id="salary_change_amount" name="salary_change_amount" value="" placeholder="Salary Increment" required>
							  </div>
							</div>

							<div id="allowance_div" style="display: none;">
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
							  <hr>
							</div>

							<div id="epf_etf_paye_div" style="display: none;">
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
							</div>

							<div id="deduction_div" style="display: none;">
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

							<div class="form-body" id="effective_from_div" style="display:none">
							  <div class="form-group">
								<label for="effective_from" class="control-label">Change Valid From</label>
								<input type="text" class="form-control" id="effective_from" name="effective_from" value="" placeholder="DD/MM/YYYY" required readonly />
								<span class="add-on"><i class="icon-calendar"></i></span>
							  </div>
							</div>

						  </div>
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

<script>
	
	function call_edit(id, type){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/employee/edit_emp_salary_changes/"+type+"/"+id );
	}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	function call_confirm(id, emp_id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({      
			url: siteUrl + 'hr/employee/employee_salary_confirm',
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
