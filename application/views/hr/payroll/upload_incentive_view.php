<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = new FormData(this);//$(this).serializeArray();
			$.ajax({
				url: siteUrl +'hr/insentive/add_incentives',
				type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				data: dats,
				success: function(data) {
					//successfulAttemptAction(data.success);
					//location.reload();
	                if($.isEmptyObject(data.error)){
	                	location.reload();
										//successfulAttemptAction(data.success)
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
			}if($this->session->flashdata('error') != ''){ ?>
				<div class="alert alert-danger  fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
			<?php
			} ?>
	   </div>

		  <div class="table">
			<h3 class="title1">Employee Incentive</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Incentive List</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Add Incentive</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>No</th>
							<th>Type</th>
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
								 <td><?php echo $row->allowance; ?></td>
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
								}
								 else if($row->status=="C"){
									$status = "Checked";
								}

								else if($row->status == "Y"){
									$status = "Confirmed";
								}else if($row->status == "N"){
									$status = "Declined";
								}
								echo $status; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
								  <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"></i></a>
								  <?php
								  if($row->status == "P"){ ?>
									  <a href="javascript:call_checked('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>

										<a href="javascript:call_reject('<?php echo $row->id;?>')"><i class="fa fa-times nav_icon icon_blue"></i></a>


								  <?php
								  }elseif($row->status == "C"){?>
									<!-- <a href="javascript:call_excel('<?php echo $row->id;?>')"><i class="fa fa-external-link nav_icon icon_green"></i></a> -->
									<a href="javascript:call_reject('<?php echo $row->id;?>')"><i class="fa fa-times nav_icon icon_blue"></i></a>

									<a href="javascript:call_conformed('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_green"></i></a>

							<?	}
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
					  	<form enctype="multipart/form-data" data-toggle="validator" method="post" id="inputform" name="inputform">
						<div class="form-title">
						  <h4>Add Incentive</h4>
						</div>


						<div class="col-md-4">
						  <div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
									<br>

								  <select name="incentive" id="incentive" class="form-control text-input selectbox" tabindex="4">
								<option value="">Select Incentive</option>
								<? foreach ($incentivelist as $row){?>
			                      <option value="<?=$row->id?>"><?=$row->allowance?></option>
			                    <? }?>
							</select>
								 <!--  <input type="number" onchange="apply_all_amount(this.value)" class="form-control" id="apply_all" name="apply_all" value="" placeholder="Amount - Apply All"> -->
								</div>
							  </div>
							</div>
						  </div>
						</div>


						<div class="col-md-8">
						  <div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
								  <label for="year" class="control-label" >Year</label>
								  <input type="number" class="form-control" id="year" name="year" value="<?php echo date('Y'); ?>" placeholder="Year">
								</div>
							  </div>
							</div>
						  </div>

						  <div class="col-md-6 validation-grids validation-grids-left">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
								  <label for="month" class="control-label">Month</label>
								  <select class="form-control" id="month" name="month">
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

						<div class="col-md-4">
						  <div class="col-md-6 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group has-feedback">
								 <!--  <input type="number" onchange="apply_all_amount(this.value)" class="form-control" id="apply_all" name="apply_all" value="" placeholder="Amount - Apply All"> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
				<div class="form-group">
				<label for="employee" class="control-label">Insentive Sheet (Allowed file format: CSV)</label>
			<div id="employee_load">
				<input type="file" name="file" id="file" class="input-large" required="required">
			</div>
			</div>
		</div>



						<?php
						foreach($employee_list as $employee){
							if($employee->status == 'A' && $employee->salary_confirmation == 'Y'){ ?>
								<div class="col-md-12">
								  <div class="form-body">
									<div class="form-group">
								      <div class="col-md-5">
									    <label class="control-label" >Employee</label>
									    <input type="text" class="form-control" id="employee_<?php echo $employee->id;?>" name="employee_<?php echo $employee->id; ?>" value="<?php echo $employee->emp_no.' - '.$employee->initial.' '.$employee->surname;?>" placeholder="Employee" readonly>


									      <input type="hidden" class="form-control" id="employee"name="emp" value="<?php echo $employee->id;?>" placeholder="Employee" readonly>

									  </div>
										<div class="col-md-2">
										<label class="control-label">Amount</label>
										<input type="text" class="form-control" id="amount_<?=$employee->id?>" name="amount_<?=$employee->id?>">
										</div>
										<div class="col-md-2">
									  </div>
									  <div class="col-md-3">

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
								  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">Submit</button>
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
	<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
	<form name="deletekeyform">
		<input name="deletekey" id="deletekey" value="0" type="hidden">
	</form>
  </div>
</div>

<script>

	/*function apply_all_amount(value){
		var salary_advance_amount_length = $(":input[id^=salary_phonebill_amount_]").val(value);
	}*/

	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/insentive/incentive_list/"+id );
	}

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_checked(id){

		//alert(id);
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/insentive/check_incentive',
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

	function call_conformed(id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'hr/insentive/incentive_confirm',
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

	function call_reject(id){
		document.deletekeyform.deletekey.value = id;
		$('#complexConfirm').click();
	}
	$("#complexConfirm").confirm({
			title:"Decline confirmation",
				text: "Are You sure you want to decline this ?" ,
		headerClass:"modal-header",
				confirm: function(button) {
					button.fadeOut(2000).fadeIn(2000);
						window.location="<?php echo base_url();?>hr/insentive/delete_incentive/"+document.deletekeyform.deletekey.value;
				},
				cancel: function(button) {
					button.fadeOut(2000).fadeIn(2000);
				},
				confirmButton: "Yes I am",
				cancelButton: "No"
	});
	function call_excel(id)
{
			window.open( "<?=base_url()?>hr/insentive/emp_phonebill_excel/"+id);

}
</script>
