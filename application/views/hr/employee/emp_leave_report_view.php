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
			<h3 class="title1">Leave Report</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Leave Report</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class="row">
					<form data-toggle="validator" method="post" action="<?php echo base_url();?>hr/hr_config/update_designation">
						<div class="col-md-7">
						  <div class="col-md-6">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<label for="year" class="control-label" >Year</label>
								<input type="number" class="form-control" id="year" name="year" value="<?php echo date('Y') ?>" placeholder="Year">
							  </div>
							</div>
						  </div>
						  
						  <div class="col-md-6">
						    <div class="form-body">
							  <div class="form-group has-feedback">
								<label for="branch" class="control-label">Branch</label>
								<select class="form-control" id="branch" name="branch">
								  <option value="all">All</option>
								  <?php
								  foreach($branch_list as $branch){ ?>
								    <option value="<?php echo $branch->branch_code; ?>"><?php echo $branch->branch_name; ?></option>
								  <?php	  
								  }
								  ?>
								</select>
							  </div>
							</div>
						  </div>
						</div>

						<div class="col-md-5">
						  <div class="col-md-12 validation-grids validation-grids-right">
							<div class="" data-example-id="basic-forms">
							  <div class="form-body">
								<div class="form-group">
								  <button type="button" onClick="view_report()" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">View Leave Report</button>
								</div>
							  </div>
							</div>
						  </div>
						</div>
					</form>
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
	
	function view_report(){
		var year = $("#year").val(); 
		var branch = $("#branch").val(); 
		$('#popupform').delay(1).fadeIn(600);
		$('#popupform').load("<?php echo base_url();?>hr/employee/view_leave_report/"+year+"/"+branch);
	}
	
	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}
	
</script>
