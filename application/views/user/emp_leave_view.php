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
			}else if($user_leave_record->leave_type == "cassual"){
				$cassual_leave_count = $cassual_leave_count + $user_leave_record->no_of_days;
			}else if($user_leave_record->leave_type == "sick"){
				$sick_leave_count = $sick_leave_count + $user_leave_record->no_of_days;
			}else if($user_leave_record->leave_type == "maternity"){
				$maternity_leave_count = $maternity_leave_count + $user_leave_record->no_of_days;
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_pay_days;
			}else if($user_leave_record->leave_type == "no_pay"){
				$no_pay_leave_count = $no_pay_leave_count + $user_leave_record->no_of_days;
			}
		}
	}
}

$remaining_annual_leave_count = $entitled_annual_leave - $annual_leave_count;
$remaining_cassual_leave_count = $entitled_cassual_leave - $cassual_leave_count;
$remaining_sick_leave_count = $entitled_sick_leave - $sick_leave_count;
$remaining_maternity_leave_count = $entitled_maternity_leave - $maternity_leave_count;
?>


<script>
	$(document).ready(function(){

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

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
		  <h3 class="title1">Leave List</h3>
		  <div class="widget-shadow">
		    <ul id="myTabs" class="nav nav-tabs" role="tablist">
			  <li role="presentation" class="active">
				<a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Leave List</a>
			  </li>
			  <li role="presentation" class="">
				<a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Entitled Leave</a>
			  </li>
			  <li role="presentation" class="">
				<a href="#remaining" role="tab" id="remaining-tab" data-toggle="tab" aria-controls="remaining" aria-expanded="true">Remaining Leave</a>
			  </li>
				<li role="presentation" class="">
				<a href="#system_leave" role="tab" id="system_leave-tab" data-toggle="tab" aria-controls="system_leave" aria-expanded="true">System Pending Leave</a>
			  </li>
			</ul>
			<div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
			  <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				<div class=" widget-shadow bs-example" data-example-id="contextual-table" >
				  <table class="table">
					<thead>
					  <tr>
						<th>No</th>
						<th>Leave Type</th>
						<th>Start From</th>
						<th>No Of Days</th>
						<th>Submitted</th>
						<th>Officer In Charge</th>
						<th>Status</th>
					  </tr>
					</thead>
					<tbody>
					  <?php
					  if($datalist){
						$c = 0;
						$count = 1;
						$ci =&get_instance();
						$ci->load->model('hr/employee_model');
						foreach($datalist as $row){ ?>
						  <tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							<td><?php echo $count; ?></td>
							<td>
							  <?php
							  if($row->leave_type == "annual"){
								$leave_type = "Annual";
							  }else if($row->leave_type == "cassual"){
								$leave_type = "Cassual";
							  }else if($row->leave_type == "sick"){
								$leave_type = "Sick";
							  }else if($row->leave_type == "maternity"){
								$leave_type = "Maternity";
							  }else if($row->leave_type == "no_pay"){
								$leave_type = "No Pay";
							  }
							  echo $leave_type;
							  ?>
							</td>
							<td><?php echo $row->start_date; ?></td>
							<td><?php echo $row->no_of_days; ?></td>
							<td><?php echo $row->created; ?></td>
							<td>
								<?php
								if($row->officer_in_charge){
									$oicDetails = $ci->employee_model->get_employee_details($row->officer_in_charge);
									echo $oicDetails['emp_no'].' - '.$oicDetails['initial'].' '.$oicDetails['surname'];
								}

								?>
							</td>
							<td>
							  <?php
							  if($row->approval == "P"){
								$status = "Pending";
							  }else if($row->approval == "A"){
								$status = "Approved";
							  }else if($row->approval == "D"){
								$status = "Disapproved";
							  }else if($row->approval == "W"){
									$status = "Pending(Officer In Charge)";
								}else{
									$status ="";
								}
							  echo $status; ?>
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
					<form data-toggle="validator" id="" name="" method="post">
					  <div class="form-title">
						<h4>Entitled Leave</h4>
					  </div>

					  <div class="col-xs-12"><hr></div>

					  <div class="col-md-6 validation-grids validation-grids-right">
						<div class="" data-example-id="basic-forms">
						  <div class="form-body">
							<div class="form-group has-feedback">
							  <label for="annual_leave" class="control-label" >Annual Leave</label>
							  <input type="text" class="form-control" id="annual_leave" name="annual_leave" value="<?php echo $entitled_annual_leave; ?>" placeholder="Annual Leaves" readonly>
							</div>

							<div class="form-group has-feedback">
							  <label for="sick_leave" class="control-label">Sick Leave</label>
							  <input type="text" class="form-control" id="sick_leave" name="sick_leave" value="<?php echo $entitled_sick_leave; ?>" placeholder="Sick Leaves" readonly>
							</div>
						  </div>
						</div>
					  </div>

					  <div class="col-md-6 validation-grids validation-grids-left">
						<div class="" data-example-id="basic-forms">
						  <div class="form-body">
							<div class="form-group">
							  <label for="cassual_leave" class="control-label">Casual Leave</label>
							  <input type="text" class="form-control" id="cassual_leave" name="cassual_leave" value="<?php echo $entitled_cassual_leave; ?>" placeholder="Casual Leaves" readonly>
							</div>
							<div class="form-group">
							  <label for="maternity_leave" class="control-label">Maternity Leave</label>
							  <input type="text" class="form-control" id="maternity_leave" name="maternity_leave" value="<?php echo $entitled_maternity_leave; ?>" placeholder="Maternity Leaves" readonly>
							</div>
						  </div>
						</div>
					  </div>

					  <div class="col-xs-12"><hr></div>
					</form>
				  </div>
				</p>
			  </div>

			  <div role="tabpanel" class="tab-pane fade " id="remaining" aria-labelledby="remaining-tab">
				<p>
				  <div class="row">
					<form data-toggle="validator" id="" name="" method="post">
					  <div class="form-title">
						<h4>Remaining Leave</h4>
					  </div>

					  <div class="col-xs-12"><hr></div>

					  <div class="col-md-6 validation-grids validation-grids-right">
						<div class="" data-example-id="basic-forms">
						  <div class="form-body">
							<div class="form-group has-feedback">
							  <label for="annual_leave" class="control-label" >Annual Leave</label>
							  <input type="text" class="form-control" id="annual_leave" name="annual_leave" value="<?php echo $remaining_annual_leave_count; ?>" placeholder="Annual Leaves" readonly>
							</div>

							<div class="form-group has-feedback">
							  <label for="sick_leave" class="control-label">Sick Leave</label>
							  <input type="text" class="form-control" id="sick_leave" name="sick_leave" value="<?php echo $remaining_sick_leave_count; ?>" placeholder="Sick Leaves" readonly>
							</div>

							<div class="form-group">
							  <label for="no_pay_leave" class="control-label">No Pay Leaves Taken</label>
							  <input type="text" class="form-control" id="no_pay_leave" name="no_pay_leave" value="<?php echo $no_pay_leave_count; ?>" placeholder="No Pay Leaves" readonly>
							</div>
						  </div>
						</div>
					  </div>

					  <div class="col-md-6 validation-grids validation-grids-left">
						<div class="" data-example-id="basic-forms">
						  <div class="form-body">
							<div class="form-group">
							  <label for="cassual_leave" class="control-label">Casual Leave</label>
							  <input type="text" class="form-control" id="cassual_leave" name="cassual_leave" value="<?php echo $remaining_cassual_leave_count; ?>" placeholder="Cassual Leaves" readonly>
							</div>

							<div class="form-group">
							  <label for="maternity_leave" class="control-label">Maternity Leave</label>
							  <input type="text" class="form-control" id="maternity_leave" name="maternity_leave" value="<?php echo $remaining_maternity_leave_count; ?>" placeholder="Maternity Leaves" readonly>
							</div>
						  </div>
						</div>
					  </div>

					  <div class="col-xs-12"><hr></div>
					</form>
				  </div>
				</p>
			  </div>
				<div role="tabpanel" class="tab-pane fade" id="system_leave" aria-labelledby="system_leave-tab" >
				<div class=" widget-shadow bs-example" data-example-id="contextual-table" >
				  <table class="table">
					<thead>
					  <tr>
						<th>No</th>
						<th>Leave date</th>
					  </tr>
					</thead>
					<tbody>
					  <?php
						$count=1;
					  if($system_pending_leave_records)
						foreach($system_pending_leave_records as $row){ ?>

							<td><?php echo $count; ?></td>
							<td><?php echo $row->start_date; ?></td>

						  </tr>
						  <?php
						  $count++;
						}?>
					</tbody>
				  </table>
				</div>
			  </div>

			</div>
		  </div>
		</div>
	  </div>
	</div>

    <div class="row calender widget-shadow"  style="display:none">
      <h4 class="title">Calender</h4>
      <div class="cal1"></div>
    </div>

  </div>
</div>
