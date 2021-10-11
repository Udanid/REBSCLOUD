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
			<h3 class="title1">Employee List</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee List</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>Emp No</th>
						  <th>Name</th>
						  <th>Designation</th>
						  <th>Contact Number</th>
						  <th>System ID</th>
						  <th>Status</th>
						  <th></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  foreach($datalist as $row){
							$ci =&get_instance();
							$ci->load->model('hr/common_hr_model');
							$designation = $ci->common_hr_model->get_designation($row->designation);?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <th scope="row"><?php echo $row->epf_no; ?></th>
							  <td><?php echo $row->initial.' '.$row->surname; ?></td>
							  <td><?php echo $designation['designation']; ?></td>
							  <td><?php echo $row->tel_mob ; ?></td>
							  <td><?php echo $row->id ; ?></td>
							  <td>
								<?php
								if($row->status == "P"){
									$status = "Pending";
								}else if($row->status == "A"){
									$status = "Active";
								}else if($row->status == "D"){
									$status = "Deactive";
								}
								echo $status; ?>
							  </td>
							  <td align="right">
								<div id="checherflag">
								  <?php
								  if($row->status == "P"){ ?>
									<a href="<?php echo base_url();?>hr/employee/edit/<?php echo $row->id;?>" title="Edit"><i class="fa fa-edit nav_icon icon_blue"></i></a>
                  <a href="<?php echo base_url();?>hr/employee/add_emp_other_data/<?php echo $row->id;?>" title="Edit"><i class="fa fa-edit nav_icon icon_green"></i></a>
									<a  href="javascript:call_delete('<?php echo $row->id;?>')" title="Delete"><i class="fa fa-times nav_icon icon_red"></i></a>
								  <?php
								  }else if($row->status == "A"){ ?>
									<a href="<?php echo base_url();?>hr/employee/edit_confirmed_employee/<?php echo $row->id;?>" title="View"><i class="fa fa-file-text-o nav_icon icon_blue"></i></a>
								  <?php
								  }else{ ?>
									<a href="<?php echo base_url();?>hr/employee/confirm_user_data/<?php echo $row->id;?>" title="View"><i class="fa fa-file-text-o nav_icon icon_blue"></i></a>
								  <?php
								  } ?>
								</div>
							  </td>
							</tr>
						  <?php
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
	$("#complexConfirm").confirm({
    	title:"Delete confirmation",
        text: "Are You sure you want to delete this ?" ,
		headerClass:"modal-header",
        confirm: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
            window.location="<?php echo base_url();?>hr/employee/delete_employee/"+document.deletekeyform.deletekey.value;
        },
        cancel: function(button) {
        	button.fadeOut(2000).fadeIn(2000);
        },
        confirmButton: "Yes I am",
        cancelButton: "No"
	});
	function call_delete(id){
		document.deletekeyform.deletekey.value = id;
		$('#complexConfirm').click();
	}
</script>
