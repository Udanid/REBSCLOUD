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
			<h3 class="title1">Leave Request List</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Leave List</a>
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
						  <th>Leave Type</th>
						  <th>Start From</th>
						  <th>No Of Days</th>
						  <th>Submitted</th>
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
						  $ci->load->model('hr/employee_model');
						  foreach($datalist as $row){
								if($row->approval == "W" && $row->officer_in_charge==$this->session->userdata('userid')){
								?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td>
								<?php
								$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
								echo $empDetails['emp_no'].' - '.$empDetails['initial'].' '.$empDetails['surname'];
								?>
							  </td>
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
							  <td align="right">
								<div id="checherflag">
								  <?php
								  if($row->approval == "P"){ ?>
									  <a href="javascript:call_confirm('<?php echo $row->id;?>', '<?php echo $row->emp_record_id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
									   <a href="javascript:call_reject('<?php echo $row->id;?>')"><i class="fa fa-times nav_icon icon_blue"></i></a>
								  <?php
								  }
								  ?>
									<?php
								 if($row->approval == "W"){ ?>
									 <a href="javascript:call_confirm('<?php echo $row->id;?>', '<?php echo $row->emp_record_id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
										<a href="javascript:call_reject('<?php echo $row->id;?>')"><i class="fa fa-times nav_icon icon_blue"></i></a>
								 <?php
								 }
								 ?>
								</div>
							  </td>
							</tr>
						  <?php
							$count++;
						}}
						} ?>
					  </tbody>
					</table>
					<div id="pagination-container"></div>
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

	<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
	<form name="deletekeyform">
	  <input name="deletekey" id="deletekey" value="0" type="hidden">
	</form>

  </div>
</div>

<script>

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

	function call_confirm(id, emp_id){
		var siteUrl = '<?php echo base_url(); ?>';
		$.ajax({
			url: siteUrl + 'leave/user_oic_confirm',
			type: "POST",
			async: false,
			dataType: 'json',
			data: {record_id:id, emp_id:emp_id},
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
            window.location="<?php echo base_url();?>leave/decline_user_leave/"+document.deletekeyform.deletekey.value;
        },
        cancel: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
        },
        confirmButton: "Yes I am",
        cancelButton: "No"
	});

	function call_reject(id){
		document.deletekeyform.deletekey.value = id;
		$('#complexConfirm').click();
	}

</script>
