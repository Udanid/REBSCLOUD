<script>
	$(document).ready(function(){
		var salary_status = '<?php echo $allowance_changes['record_status']; ?>';
		if(salary_status == 'Y'){
			$('#edit_sal_inputform').find('input, textarea, button, select').attr('disabled','disabled');
		}

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
		$('#edit_sal_inputform :checkbox').change(function (){
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
	
	function load_edit_employment_details(emp_id){
		$('div[id^="allowance_div_"]').hide(500);
		document.getElementById("edit_sal_inputform").reset();
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
					$("#employee").val(data.employee_details.epf_no+' - '+data.employee_details.initial+' '+data.employee_details.surname);
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
							$("#salary_id").val(data.employee_salary.id);
							
							var i;
							for(i = 0; i < data.employee_allowances.length; i++){
								$("#allowance_check_"+data.employee_allowances[i].allowance_id).attr("checked", true);
								$("#allowance_div_"+data.employee_allowances[i].allowance_id).show(1000);
								$("#allowance_"+data.employee_allowances[i].allowance_id).val(data.employee_allowances[i].value);
								$("#allowance_"+data.employee_allowances[i].allowance_id).attr('required', true);
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
		
		var emp_record_id = '<?php echo $details['emp_record_id']; ?>';
		load_edit_employment_details(emp_record_id);
		
		$("form#edit_sal_inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				cache: false,
				url: siteUrl + 'hr/employee/confirm_emp_allowances',
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

<h4>Salary Details<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <form data-toggle="validator" id="edit_sal_inputform" name="edit_sal_inputform" method="post">
      <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $details['emp_record_id']; ?>" />
	  <input type="hidden" id="salary_id" name="salary_id" value="">
	  <input type="hidden" id="allowance_change_id" name="allowance_change_id" value="<?php echo $allowance_changes['id']; ?>">
	  <input type="hidden" id="hr_emp_salary_changes_id" name="hr_emp_salary_changes_id" value="<?php echo $hr_emp_salary_changes_id; ?>">
	  <input type="hidden" id="salary_status" name="salary_status" value="<?php echo $details['status']; ?>">
			    
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms">
		  <div class="form-body">
		    <div class="form-group has-feedback" id="employee_div">
			  <label for="employee" class="control-label" >Employee</label>
			  <input type="text" class="form-control" id="employee" name="employee" value="" placeholder="Employee" readonly>
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
		    <label class="control-label" style="font-size: 120%;">Allowances - Current state</label>
		  </div>
						
		  <?php
		  foreach($allowances as $allowance_row){ 
			if($allowance_changes['allowance_id'] == $allowance_row->id){ ?>
				<div class="form-body">
				  <div class="col-xs-6">
					<?php echo $allowance_row->allowance; ?>
				  </div>
				  <div class="col-xs-6">
					<input type="checkbox" id="allowance_check_<?php echo $allowance_row->id; ?>" name="allowance[]" value="<?php echo $allowance_row->id; ?>" disabled >
				  </div>

				  <div class="col-xs-12" id="allowance_div_<?php echo $allowance_row->id; ?>" style="display: none;">
					<input type="number" class="form-control" id="allowance_<?php echo $allowance_row->id; ?>" name="allowance_<?php echo $allowance_row->id; ?>" value="" placeholder="<?php echo $allowance_row->allowance; ?>" readonly>
					<span class="help-block with-errors" ><?php echo $allowance_row->allowance.' (in '.strtolower($allowance_row->amount_type).')'; ?></span>
				  </div>
				</div>
			<?php
			}?>
			<br>
		  <?php	
		  } ?>
		</div>
	  </div>
					
	  <div class="col-md-6 validation-grids validation-grids-left">
	    <div class="" data-example-id="basic-forms">	
	      
		  <div class="form-body">
		    <label class="control-label" style="font-size: 120%;">Allowance - Changes</label>
		  </div>
						
		  <?php
		  foreach($allowances as $allowance_row){ 
			if($allowance_changes['allowance_id'] == $allowance_row->id){ ?>
				<div class="form-body">
				  <div class="col-xs-6">
					<?php echo $allowance_row->allowance; ?>
				  </div>
				  <div class="col-xs-6">
					<div><input type="checkbox" name="changed_allowance" value="<?php echo $allowance_row->id; ?>" <?php if($allowance_changes['status'] == "Y"){ echo "checked"; } ?> disabled ></div>
				  </div>

				  <div class="col-xs-12"  <?php if($allowance_changes['status'] == "N"){ echo 'style="display: none;"'; } ?> >
					<input type="number" class="form-control" value="<?php echo $allowance_changes['value']; ?>" placeholder="<?php echo $allowance_row->allowance; ?>" readonly>
					<span class="help-block with-errors" ><?php echo $allowance_row->allowance.' (in '.strtolower($allowance_row->amount_type).')'; ?></span>
				  </div>
				</div>
			<?php
			}?>
			<br>
		  <?php	
		  } ?>
		</div>
	  </div>
						
	  <div class="col-xs-12"><hr></div>
								
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="form-group">
		  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Confirm</button>
		</div> 
	  </div>
    </form>
  </div>
</div>



<script>
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
</script>
