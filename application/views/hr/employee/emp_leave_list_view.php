<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
	function load_printscrean1()
{
			window.open( "<?=base_url()?>hr/employee/emp_leave_list_excel");

}
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
					<a href="javascript:load_printscrean1()" style="margin-left: 95%;" name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >

					<table class="table">
					  <thead>
						<tr>
						<tr>
						  <th>No</th>
						  <th>Employee</th>
						  <th>Leave Type</th>
						  <th>Start From</th>
						  <th>No Of Days</th>
						  <th>Reason</th>
							<th>Approved By</th>
						  <th>Status</th>
							<th>System Record</th>
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
						  foreach($datalist as $row){ ?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td>
								<?php
								$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
								echo $empDetails['epf_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'];
								?>
							  </td>
							  <td><?php echo $row->leave_type; ?></td>
							  <td><?php echo $row->start_date; ?></td>
							  <td><?php echo $row->no_of_days; ?></td>
							  <td><?php echo $row->reason; ?></td>
								<td><?php echo get_user_fullname($row->approval_by); ?></td>
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
								<td>
									<?
									if($row->sytem_record == "Y"){
										$status = "Yes";
									}else{
										$status ="No";
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

</script>
