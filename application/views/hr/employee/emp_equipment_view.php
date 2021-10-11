<script>
	$(document).ready(function(){
		
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
	function load_employment_details(emp_id){
		var siteUrl = '<?php echo base_url(); ?>';
		
		document.getElementById("inputform").reset();
		$("#emp_id").val(emp_id);
		
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
	
</script>
<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({      
				url: siteUrl + 'hr/employee/employee_equipment_update',
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
			<h3 class="title1">Employee Equipment</h3>	
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Equipment</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">New Employee Equipment</a>
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
						  <th>Equipment Category</th>
						  <th>Equipment</th>
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
								foreach($equipment_categories as $equipment_category){
									if($equipment_category->id == $row->equipment_category){
										echo $equipment_category->equipment_category;
									}
								}
								?>
							  </td>
							  <td><?php echo $row->equipment_name; ?></td>
							  <td>
								<?php 
								if($row->status == "P"){
									$status = "Pending";
								}else if($row->status == "A"){
									$status = "Active";
								}else if($row->status == "O"){
									$status = "Past";
								}
								echo $status; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
								  <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
								  <?php
								  if($row->status == "P"){ ?>
									  <a href="javascript:call_confirm('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
								  <?php  
								  }
								  ?>
                                    <a href="javascript:call_print('<?php echo $row->id;?>')"><i class="fa fa-print nav_icon icon_blue"></i></a>
								
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
						<input type="hidden" name="form_submit_type" id="form_submit_type" value="insert" />
						<div class="form-title">
						  <h4>Employee Equipment</h4>
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

						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group">
								<label for="equipment_category" class="control-label">Select Equipment Category</label>
								<select class="form-control" id="equipment_category" name="equipment_category" required>
								  <option value="">--Select Equipment Category--</option>
								  <?php
								  foreach($equipment_categories as $equipment_category){ ?>
									<option value="<?php echo $equipment_category->id; ?>"><?php echo $equipment_category->equipment_category; ?></option>
								  <?php
								  } ?>
								</select>
								<span class="help-block with-errors" ></span>
							  </div>

							  <div class="form-group">
								<label for="brand" class="control-label">Brand</label>
								<input type="text" class="form-control" id="brand" name="brand" value="" placeholder="Brand" required>
								<span class="help-block with-errors" ></span>
							  </div>

							  <div class="form-group">
								<label for="value" class="control-label">Value</label>
								<input type="number" class="form-control" id="value" name="value" value="" placeholder="Value" required>
								<span class="help-block with-errors" ></span>
							  </div>

							  <div class="form-group">
								<label for="from_date" class="control-label">From</label>
								<input type="text" class="form-control" id="from_date" name="from_date" value="" placeholder="DD/MM/YYYY" readonly required/>
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
								<input type="text" class="form-control" id="equipment_name" name="equipment_name" value="" placeholder="Equipment Name" required>
								<span class="help-block with-errors" ></span>
							  </div>

							  <div class="form-group">
								<label for="serial_number" class="control-label">Serial Number</label>
								<input type="text" class="form-control" id="serial_number" name="serial_number" value="" placeholder="Serial Number" required>
								<span class="help-block with-errors" ></span>
							  </div>

							  <div class="form-group">
								<label for="inventory_number" class="control-label">Inventory Number</label>
								<input type="text" class="form-control" id="inventory_number" name="inventory_number" value="" placeholder="Inventory Number" required>
								<span class="help-block with-errors" ></span>
							  </div>
							</div>
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
		$('#popupform').load("<?php echo base_url();?>hr/employee/edit_emp_equipment/"+id );
	}
	function call_print(id){
		 window.open( "<?=base_url()?>hr/employee/print_emp_equipment/"+id);
		}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	function call_confirm(id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({      
			url: siteUrl + 'hr/employee/employee_equipment_confirm',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {record_id:id},
			success: function(data) {
	        	location.reload();
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}
	
</script>
