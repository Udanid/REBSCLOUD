<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		get_no_pay_list_by_year_month();

	});
</script>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				url: siteUrl + 'hr/emp_payroll/submit_no_pay_leave_list',
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
	function call_reject(id){
		document.deletekeyform.deletekey.value = id;
		$('#complexConfirm').click();
	}
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
			<h3 class="title1">Employee No Pay Leave List</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee No Pay Leave List</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Submit Monthly No Pay Leave List</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>No</th>
						  <th>Year</th>
						  <th>Month</th>
						  <th>Generated Date</th>
						  <th>Status</th>
						  <th></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  $count = 1;
						  foreach($datalist as $row){ ?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td><?php echo $row->year; ?></td>
							  <td>
								<?php
								$date = $row->year."-".$row->month;
								$month= date("F", strtotime($date));
								echo $month;
								?>
							  </td>
							  <td><?php echo $row->generated_date; ?></td>
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
							  <td align="right">
								<div id="checherflag">
								  <a href="javascript:call_view('<?php echo $row->id;?>')"><i class="fa fa-external-link nav_icon icon_green"></i></a>
								  <?php
								  if($row->status == "P"){ ?>

										<a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
									  <a href="javascript:call_confirm('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
										<a href="javascript:call_reject('<?php echo $row->id;?>')"><i class="fa fa-times nav_icon icon_blue"></i></a>

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
						<div class="form-title">
						  <h4>Submit Monthly No Pay Leave List</h4>
						</div>

						<div class="col-md-8">
						  <div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
								  <label for="year" class="control-label" >Year</label>
								  <input type="number" class="form-control" id="year" name="year" value="<?php echo date('Y'); ?>" placeholder="Year" onchange="get_no_pay_list_by_year_month()">
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
								  <label for="month" class="control-label">Month</label>
								  <select class="form-control" id="month" name="month" onchange="get_no_pay_list_by_year_month()">
									<option value="01">January</option>
									<option value="02">February</option>
									<option value="03">March</option>
									<option value="04">April</option>
									<option value="05">May</option>
									<option value="06">June</option>
									<option value="07">July</option>
									<option value="08">August</option>
									<option value="09">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								  </select>
								</div>
							  </div>
							</div>
						  </div>
						</div>

						<?php
						foreach($employee_list as $employee){
							if($employee->status == 'A' && $employee->salary_confirmation == 'Y'){ ?>
								<div class="col-md-12">
								  <div class="form-body">
									<div class="form-group">
								      <div class="col-md-6">
									    <label class="control-label" >Employee</label>
									    <input type="text" class="form-control" id="employee_<?php echo $employee->id ?>" name="employee_<?php echo $employee->id; ?>" value="<?php echo $employee->epf_no.' - '.$employee->initial.' '.$employee->surname; ?>" placeholder="Employee" readonly>
									  </div>
									  <div class="col-md-3">
										<label class="control-label">No Pay Leave Count</label>
										<input type="text" class="form-control" id="no_pay_count_<?php echo $employee->id; ?>" name="no_pay_count_<?php echo $employee->id; ?>" value="" placeholder="No Pay Leave Count" readonly>
									  </div>
									  <div class="col-md-3">
										<label class="control-label">Edit No Pay Leave Count</label>
										<input type="number" step="0.01" class="form-control" id="edit_no_pay_count_<?php echo $employee->id; ?>" name="edit_no_pay_count_<?php echo $employee->id; ?>" value="" placeholder="Edit No Pay Leave Count">
									  </div>
									</div>
								  </div>
								</div>
							<?php
							}
						}
						?>

						<div class="col-md-4">
						  <div class="col-md-12 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Submit</button>
								</div>
							  </div>
							</div>
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
<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
<form name="deletekeyform">
	<input name="deletekey" id="deletekey" value="0" type="hidden">
</form>

<script>


	function get_no_pay_list_by_year_month(){
		var year = $('#year').val();
		var month = $('#month').val();
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/emp_payroll/get_no_pay_list_by_year_month',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {year:year, month:month},
			success: function(data) {
				var i;
				for(i = 0; i < data.length; i++){
					$("#no_pay_count_"+data[i]['emp_id']).val(data[i]['no_pay_count']);
				}
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}



	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/emp_payroll/emp_no_pay_list_list/"+id );
	}

	function call_view(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/emp_payroll/emp_no_pay_list_confirmed/"+id );
	}
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_confirm(id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/emp_payroll/employee_no_pay_leave_confirm',
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

	$("#complexConfirm").confirm({
			title:"Decline confirmation",
				text: "Are You sure you want to decline this ?" ,
		headerClass:"modal-header",
				confirm: function(button) {
					button.fadeOut(2000).fadeIn(2000);
						window.location="<?php echo base_url();?>hr/emp_payroll/decline_monthly_nopay_list/"+document.deletekeyform.deletekey.value;
				},
				cancel: function(button) {
					button.fadeOut(2000).fadeIn(2000);
				},
				confirmButton: "Yes I am",
				cancelButton: "No"
	});

</script>
