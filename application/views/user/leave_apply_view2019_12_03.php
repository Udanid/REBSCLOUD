<?php
$annual_leave_count = 0;
$cassual_leave_count = 0;
$sick_leave_count = 0;
$maternity_leave_count = 0;
$no_pay_leave_count = 0;

$entitled_annual_leave = $leave_category_details['annual_leave'];
$entitled_cassual_leave  = $leave_category_details['cassual_leave'];
$entitled_sick_leave = $leave_category_details['sick_leave'];
$entitled_maternity_leave = $leave_category_details['maternity_leave'];

if(count($active_user_leave_records)>0){
	foreach($active_user_leave_records as $user_leave_record){
		if($user_leave_record->approval == "A" && $user_leave_record->active_record == "Y"){
			if($user_leave_record->leave_type == "annual"){
				$annual_leave_count = $annual_leave_count + $user_leave_record->no_of_days;
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_pay_days;
			}else if($user_leave_record->leave_type == "cassual"){
				$cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_pay_days;
			}else if($user_leave_record->leave_type == "sick"){
				$sick_leave_count = $sick_leave_count + $user_leave_record->no_of_days;
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_pay_days;
			}else if($user_leave_record->leave_type == "maternity"){
				$maternity_leave_count = $maternity_leave_count + $user_leave_record->no_of_days;
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_pay_days;
			}else if($user_leave_record->leave_type == "no_pay"){
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_pay_days;
			}
		}
	}
}

$remaining_annual_leave_count = $entitled_annual_leave - $annual_leave_count;
$remaining_cassual_leave_count = $entitled_cassual_leave - $cassual_leave_count;
$remaining_sick_leave_count = $entitled_sick_leave - $sick_leave_count;
$remaining_maternity_leave_count = $entitled_maternity_leave - $maternity_leave_count;
$tot_remaining_leave = $remaining_annual_leave_count + $remaining_cassual_leave_count + $remaining_sick_leave_count;
?>


<script>
function view_report(){
	var year = "<?=date('Y');?>";
	var branch = "all";
	$('#popupform').delay(1).fadeIn(600);
	$('#popupform').load("<?php echo base_url();?>hr/employee/view_leave_report/"+year+"/"+branch);
}
	$(document).ready(function() {

		var leave_type = $("#leave_type").val();
		load_leave_div(leave_type);

  		$("#start_date").datepicker({
      		dateFormat: 'yy-mm-dd',
      		defaultDate: new Date(),
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-0:+1'
  		});

		$('#start_date').change(function(){
			var start_date = $("#start_date").val();

			$('#end_date').datepicker('setDate', null);
			$("#end_date").datepicker("destroy");

			$("#end_date").datepicker({
				dateFormat: 'yy-mm-dd',
				setDate: start_date,
				minDate: start_date,
				changeMonth: true,
				changeYear: true,
			});
		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>


<script>
	function load_leave_div(leave_type){
		var remaining_annual_leave_count = '<?php echo $remaining_annual_leave_count; ?>';
		var remaining_cassual_leave_count = '<?php echo $remaining_cassual_leave_count; ?>';
		var remaining_sick_leave_count = '<?php echo $remaining_sick_leave_count; ?>';
		var remaining_maternity_leave_count = '<?php echo $remaining_maternity_leave_count; ?>';
		var no_pay_leave_count = '<?php echo $no_pay_leave_count; ?>';

		if(leave_type == 'annual'){
			$("#no_of_days").attr("readonly", false);
			$("#no_of_days").attr("step", "1");
			$("#no_of_days").val("");
			$("#remaining_leave").val('Remaining annual leaves = '+remaining_annual_leave_count);
			$("#remaining_leave_count").val(remaining_annual_leave_count);
		}else if(leave_type == 'cassual'){
			$("#no_of_days").attr("readonly", false);
			$("#no_of_days").attr("step", "1");
			$("#no_of_days").val("");
			$("#remaining_leave").val('Remaining cassual leaves = '+remaining_cassual_leave_count);
			$("#remaining_leave_count").val(remaining_cassual_leave_count);
		}else if(leave_type == 'sick'){
			$("#no_of_days").attr("readonly", false);
			$("#no_of_days").attr("step", "1");
			$("#no_of_days").val("");
			$("#remaining_leave").val('Remaining sick leaves = '+remaining_sick_leave_count);
			$("#remaining_leave_count").val(remaining_sick_leave_count);
		}else if(leave_type == 'maternity'){
			$("#no_of_days").attr("readonly", false);
			$("#no_of_days").attr("step", "1");
			$("#no_of_days").val("");
			$("#remaining_leave").val('Remaining maternity leaves = '+remaining_maternity_leave_count);
			$("#remaining_leave_count").val(remaining_maternity_leave_count);
		}else if(leave_type == 'no_pay'){
			$("#no_of_days").attr("readonly", false);
			$("#no_of_days").attr("step", "1");
			$("#no_of_days").val("");
			$("#remaining_leave").val('No Pay leave count = '+no_pay_leave_count);
			$("#remaining_leave_count").val(no_pay_leave_count);
		}else if(leave_type == 'half_day'){
			$("#no_of_days").attr("readonly", "readonly");
			$("#no_of_days").attr("step", "0.25");
			$("#no_of_days").val(0.5);
			$("#remaining_leave").val('');
			$("#remaining_leave_count").val('');
		}else if(leave_type == 'short_leave'){
			$("#no_of_days").attr("readonly", "readonly");
			$("#no_of_days").attr("step", "0.25");
			$("#no_of_days").val(0.25);
			$("#remaining_leave").val('');
			$("#remaining_leave_count").val('');
		}
	}
</script>

<div id="page-wrapper">
  <div class="main-page">

	<div class="modal-content">
	  <div class="modal-body">
		<div class="row">
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

		  <div class="col-xs-12 form-container">
			<form class="userRegForm form-horizontal" id="inputform" name="inputform" method="post">

			  <input type="hidden" id="leave_category_id" name="leave_category_id" value="<?php echo $leave_category_details['id']; ?>" />

			  <div class="panel panel-default">
				<div class="panel-heading">Leave Details</div>
				<div class="panel-body">
					<? if($this->session->userdata('usertype')=="Directors"){?>
						<!--- special for commercial realty-->
					<div class="form-group">
					<label for="branch" class="control-label col-xs-2">Employee</label>
					<div class="col-xs-5">
						<select class="form-control" id="emp_id" name="emp_id" onChange="load_empleave_count(this.value);">
						<option value="">--Please Select--</option>
						<?php
							foreach ($get_employee as $key => $value) {?>
								<option value="<?=$value->id;?>"><?=$value->initial;?> <?=$value->surname;?></option>
						<?php	}
						?>

					  </select>
					</div>
				  </div>
					<?}else{?>
						<input type="hidden" id="emp_id" name="emp_id" value="<?php echo $user_details['id']; ?>" />
					<?}?>

				  <div class="form-group">
					<label for="leave_type" class="control-label col-xs-2">Leave Type</label>
					<div class="col-xs-5">
					  <select class="form-control" id="leave_type" name="leave_type" onChange="load_leave_div(this.value);">
						<option value="annual">Annual</option>
						<option value="cassual">Cassual</option>
						<option value="sick">Sick</option>
						<option value="half_day">Half Day</option>
						<option value="short_leave">Short Leave</option>
						<option value="no_pay">No Pay</option>
						<option value="maternity">Maternity Leave</option>
					  </select>

					</div>
					<?
					$spance="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					if($this->session->userdata('usertype')=="Directors"){?>
						<div class="col-xs-5">
							<button type="button" onClick="view_report()" class="btn btn-primary btn-sm " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">View Remaining Leave</button>

						</div>
					<? }else{?>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="remaining_leave" name="remaining_leave" value="" readonly />
					  <input type="hidden" class="form-control" id="remaining_leave_count" name="remaining_leave_count" value="" />
					</div>
					<? }?>
				  </div>

				  <div class="form-group">
					<label for="start_date" class="control-label col-xs-2">Start Date</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="start_date" name="start_date" value="" placeholder="YYYY-MM-DD" required readonly />
					  <span class="add-on"><i class="icon-calendar"></i></span>
					</div>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="tot_remaining_leave" name="tot_remaining_leave" value="Total Remaining = <?php echo $tot_remaining_leave; ?>" readonly />
					</div>
				  </div>

				  <div class="form-group">
					<label for="no_of_days" class="control-label col-xs-2">No Of Days</label>
					<div class="col-xs-5">
					  <input type="number" class="form-control" id="no_of_days" min="1" step="1" name="no_of_days" value="" placeholder="No Of Days" required/>
					</div>
				  </div>

				  <div class="form-group">
					<label for="end_date" class="control-label col-xs-2">End Date</label>
					<div class="col-xs-5">
					  <input type="text" class="form-control" id="end_date" name="end_date" value="" placeholder="YYYY-MM-DD" readonly />
					  <span class="add-on"><i class="icon-calendar"></i></span>
					</div>
				  </div>
					<div class="form-group">
					<label for="branch" class="control-label col-xs-2">Officer In Charge</label>
					<div class="col-xs-5">
						<select class="form-control" id="officer_in_charge" name="officer_in_charge" >
						<option value="">--Please Select--</option>
						<?php
							foreach ($get_employee as $key => $value) {?>
								<option value="<?=$value->id;?>"><?=$value->initial;?> <?=$value->surname;?></option>
						<?php	}
						?>

					  </select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="branch" class="control-label col-xs-2">Reason</label>
					<div class="col-xs-5">
					  <textarea class="form-control" id="reason" name="reason" placeholder="Reason"></textarea>
					</div>
				  </div>

				</div>
			  </div>

			  <div class="form-group">
				<div class="col-xs-10">
				  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Apply</button>
				</div>
			  </div>
			</form>
		  </div>
		</div>
	  </div>
	</div>

    <div class="row calender widget-shadow" style="display:none">
      <h4 class="title">Calender</h4>
      <div class="cal1"></div>
    </div>

  </div>
</div>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var leave_type = $("#leave_type").val();
			var no_of_days = $("#no_of_days").val();
			var remaining_leave_count = $("#remaining_leave_count").val();
			if(leave_type != "no_pay" && leave_type != "half_day" && leave_type != "short_leave"){
				if(Number(no_of_days) > Number(remaining_leave_count)){
					var error = "<br>You are exceeding your entiled leaves";
					unsuccessfulAttemptAction(error);
					return false;
				}
			}


			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				url: siteUrl + 'leave/leave_submit',
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {

	                if($.isEmptyObject(data.error)){
	                	window.location.replace(siteUrl+'leave/leave_list');
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

	});
</script>
