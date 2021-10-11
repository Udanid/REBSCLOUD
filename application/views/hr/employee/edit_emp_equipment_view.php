<script>
	$(document).ready(function(){
		var loan_status = '<?php echo $details['status']; ?>';
		if(loan_status == 'A' || loan_status == 'O'){
			$('#edit_form').find('input, textarea, button, select').attr('disabled','disabled');
		}
		
  		$("#from_date").datepicker({
      		dateFormat: 'dd-MM-yy',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-30' + ':' + '+1'
  		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
	});
</script>

<script>
	function load_edit_employment_details(emp_id){
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
		
		$("form#edit_form").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				cache: false,
				url: siteUrl + 'hr/employee/employee_equipment_update',
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {
	                if($.isEmptyObject(data.error)){
	                	location.reload();
	                }else{
						edit_unsuccessfulAttemptAction(data.error);
						$('html, body').animate({scrollTop: '0px'}, 300);
						$('html, body').animate({
							scrollTop: ($('#edit_form').first().offset().top)
						},500);
	                }
				},
				error: function(e) {
					console.log(e.responseText);
				}
			});
		});
		
		function edit_unsuccessfulAttemptAction(errors){
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
		
	  	function edit_successfulAttemptAction(successMsg){
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


<h4>Loan Details<span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div class="table widget-shadow">
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <form data-toggle="validator" id="edit_form" name="edit_form" method="post">
      <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $details['emp_record_id']; ?>" />
      <input type="hidden" name="form_submit_type" id="form_submit_type" value="update" />
      <input type="hidden" name="record_id" id="record_id" value="<?php echo $details['id']; ?>" />
				
	  <div class="col-md-6 validation-grids validation-grids-right">
	    <div class="" data-example-id="basic-forms"> 
		  <div class="form-body">
            <div class="form-group" id="surname_div">
              <label for="surname" class="control-label">Name</label>
              <input type="text" class="form-control" id="surname" name="surname" value="" placeholder="Name" readonly>
            </div>
				  
            <div class="form-group" id="branch_div">
              <label for="branch" class="control-label">Branch</label>
              <input type="text" class="form-control" id="branch" name="branch" value="" placeholder="Branch" readonly>
            </div>
				  
            <div class="form-group" id="designation_div">
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
			  <label for="equipment_category" class="control-label">Select Equipment Category</label>
			  <select class="form-control" id="equipment_category" name="equipment_category" required>
			    <option value="">--Select Equipment Category--</option>
				<?php
				foreach($equipment_categories as $equipment_category){ ?>
					<option value="<?php echo $equipment_category->id; ?>" <?php if($equipment_category->id == $details['equipment_category']){ echo "selected"; } ?>><?php echo $equipment_category->equipment_category; ?></option>
				<?php
				} ?>
			  </select>
			  <span class="help-block with-errors" ></span>
			</div>
						  
			<div class="form-group">
			  <label for="brand" class="control-label">Brand</label>
			  <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $details['brand']; ?>" placeholder="Brand" required>
			  <span class="help-block with-errors" ></span>
			</div>
						  
			<div class="form-group">
			  <label for="value" class="control-label">Value</label>
			  <input type="number" class="form-control" id="value" name="value" value="<?php echo $details['value']; ?>" placeholder="Value" required>
			  <span class="help-block with-errors" ></span>
			</div>
							
			<div class="form-group">
			  <label for="from_date" class="control-label">From</label>
			  <input type="text" class="form-control" id="from_date" name="from_date" value="<?php echo $details['from_date']; ?>" placeholder="DD/MM/YYYY" readonly required/>
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
			  <label for="equipment_name" class="control-label">Equipment Name</label>
			  <input type="text" class="form-control" id="equipment_name" name="equipment_name" value="<?php echo $details['equipment_name']; ?>" placeholder="Equipment Name" required>
			  <span class="help-block with-errors" ></span>
			</div>
						  
			<div class="form-group">
			  <label for="serial_number" class="control-label">Serial Number</label>
			  <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo $details['serial_number']; ?>" placeholder="Serial Number" required>
			  <span class="help-block with-errors" ></span>
			</div>
						  
			<div class="form-group">
			  <label for="inventory_number" class="control-label">Inventory Number</label>
			  <input type="text" class="form-control" id="inventory_number" name="inventory_number" value="<?php echo $details['inventory_number']; ?>" placeholder="Inventory Number" required>
			  <span class="help-block with-errors" ></span>
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
</div>