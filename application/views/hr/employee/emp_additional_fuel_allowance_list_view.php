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
			<h3 class="title1">Additional Fuel Allowance Requests</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Additional Fuel Allowance Requests</a>
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
						  <th>Requested Amount</th>
						  <th>Date</th>
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
							  <td><?php echo $row->requested_amount; ?></td>
							  <td><?php echo $row->date; ?></td>
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
								  <?php
								  if($row->status == "P"){ ?>
									  <a href="javascript:call_edit('<?php echo $row->id;?>')"><i class="fa fa-check nav_icon icon_blue"></i></a>
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
	
	function call_edit(id){
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/employee/emp_additional_fuel_allowance/"+id );
	}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
	$("#complexConfirm").confirm({
    	title:"Decline confirmation",
        text: "Are You sure you want to decline this ?" ,
		headerClass:"modal-header",
        confirm: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
            window.location="<?php echo base_url();?>hr/employee/decline_emp_additional_fuel_allowance/"+document.deletekeyform.deletekey.value;
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
