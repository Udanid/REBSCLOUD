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
			<h3 class="title1">Flagged User List</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Flagged User List</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						<tr>
						  <th>No</th>
						  <th>Employee</th>
						  <th>Duty In</th>
						  <th>Duty Out</th>
						  <th>Status</th>
						  <th></th>
						</tr>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  $count = 1;
						  $ci =&get_instance();
						  $ci->load->model('hr/employee_model');
						  foreach($datalist as $row){
						  $attendance_details = $ci->employee_model->get_attendance_details($row->attendance_id);?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td>
								<?php
								$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
								echo $empDetails['epf_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'];
								?>
							  </td>
							  <td><?php echo $attendance_details['duty_in']; ?></td>
							  <td><?php echo $attendance_details['duty_out']; ?></td>
							  <td>
								<?php
								if($row->status == "F"){
									$status = "Flagged";
								}else if($row->status == "U"){
									$status = "Unflagged";
								}
								echo $status; ?>
							  </td>
							  <td align="right">
								<?php
								if($row->status == 'F'){ ?>
									<div id="checherflag">
									  <a href="javascript:call_unflag('<?php echo $row->id;?>')"><i class="fa fa-edit nav_icon icon_blue"> Unflag</i></a>
									</div>
								<?php
								} ?>

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

			  </div>
			</div>
		  </div>
	  </div>
	</div>

  </div>
</div>

<script>

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_unflag(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/emp_attendance/emp_duty_out_unflag/"+id );
	}


</script>
