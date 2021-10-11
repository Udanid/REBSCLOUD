<script>
	$(document).ready(function(){
			//when succes close button pressed
				$(document).on('click','#close-btn', function(){
					location.reload();
				});

			$("#from_date").datepicker({
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
						yearRange: '-50' + ':' + '+1'
				});

			$('#from_date').change(function(){
				var from_date = $("#from_date").val();

				$('#to_date').datepicker('setDate', null);
				$("#to_date").datepicker("destroy");

				$("#to_date").datepicker({
					dateFormat: 'yy-mm-dd',
					setDate: from_date,
					minDate: from_date,
					changeMonth: true,
					changeYear: true,
				});
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
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				cache: false,
				url: siteUrl + 'hr/emp_offdays/submit_day_off',
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
			<h3 class="title1">Employee Day Off</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Confirm Employee Day Off</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add Employee Day Off</a>
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
						  <th>Start Date</th>
							<th>End Date</th>
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
									<?=$row->start_date?>
							  </td>

							  <td>
									<?=$row->end_date?></td>
								<td><?php
								echo $row->statues; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
									<?php if($row->statues=="Pending"){?>
								  <a href="javascript:call_delete('<?php echo $row->id;?>')" title="cancel"><i class="fa fa-times nav_icon icon_red"></i></a>

										<a href="javascript:call_confirm('<?php echo $row->id;?>')" title="Approve"><i class="fa fa-check nav_icon icon_green"></i></a>

									<?php }?>

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
						  <h4>Add Employee Day Off</h4>
						</div>
						<div class="col-md-6 validation-grids validation-grids-right">
						  <div class="" data-example-id="basic-forms">
							<div class="form-body">
							  <div class="form-group" id="emp_id_div">
								<label for="emp_id" class="control-label">Select Employee</label>
								<select class="form-control" id="emp_id" name="emp_id"  required>
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

						<div class="col-md-12">
						<div class="col-md-6">
					      <div class="form-group">
						    <label for="from_date" class="control-label" >From</label>
							<input type="text" class="form-control" id="from_date" name="from_date" value="" placeholder="DD/MM/YYYY" required readonly />
						  </div>
						</div>

						<div class="col-md-6">
						  <div class="form-group">
							<label for="to_date" class="control-label" >To</label>
							<input type="text" class="form-control" id="to_date" name="to_date" value="" placeholder="DD/MM/YYYY" required readonly />
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

	function call_confirm(id){
		var statues="Approved";
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/emp_offdays/confirm_day_off',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {id:id,statues:statues},
			success: function(data) {
	        	location.reload();
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}
	function call_delete(id){
		var statues="Cancel";
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/emp_offdays/confirm_day_off',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {id:id,statues:statues},
			success: function(data) {
						location.reload();
			},
			error: function(e) {
				console.log(e.responseText);
			}
		});
	}


</script>
