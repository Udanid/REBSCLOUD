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
			<h3 class="title1">Upload Employee Attendance</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Attendance Upload List</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Upload Employee Attendance</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
			    <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>No</th>
						  <th>Branch</th>
						  <th>From</th>
						  <th>To</th>
						  <th>Uploaded Date</th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if($datalist){
						  $c = 0;
						  $count = 1;
						  $ci =&get_instance();
						  $ci->load->model('common_hr_model');
						  foreach($datalist as $row){ ?>
							<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							  <td><?php echo $count; ?></td>
							  <td>
								<?php
								$branch_details = $ci->common_hr_model->get_branch_details($row->branch);
								echo $branch_details['branch_name'];
								?>
							  </td>
							  <td>
								<?php
								echo $row->from_date;
								?>
							  </td>
							  <td>
								<?php
								echo $row->to_date;
								?>
							  </td>
							  <td><?php echo $row->created; ?></td>
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
				  <div class="row">
					<form enctype="multipart/form-data" data-toggle="validator" method="post" id="inputform1"  action="<?=base_url()?>hr/emp_attendance/submit_attendance_sheet"name="inputform">

					  <div class="col-md-12">
						<div class="col-md-6">
						  <div class="form-group">
							<label for="branch" class="control-label">Branch</label>
							<select class="form-control" id="branch" name="branch" onChange="load_employee_list(this.value);">
							  <?php
							  foreach($branch_list as $branch){ ?>
							    <option value="<?php echo $branch->branch_code; ?>"><?php echo $branch->branch_name; ?></option>
							  <?php
							  } ?>
							</select>
						  </div>
						</div>
						<div class="col-md-6">
					      <div class="form-group">
						    <label for="employee" class="control-label">Attendance Sheet (Allowed file format: CSV)</label>
							<div id="employee_load">
							  <input type="file" name="file" id="file" class="input-large" required="required">
							</div>
						  </div>
						</div>
					  </div>

					  <div class="col-md-12">
					    <div class="col-md-12 validation-grids validation-grids-right">
						  <div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Upload</button>
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

	function close_edit(id){
		$('#popupform').delay(1).fadeOut(800);
	}

</script>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			$("#popupform").empty();

			var siteUrl = '<?php echo base_url(); ?>';
			var formData = new FormData(this);
			$.ajax({
				url: siteUrl + 'hr/emp_attendance/submit_attendance_sheet',
			type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				success: function(data) {
					var data = JSON.parse(data);
	                if($.isEmptyObject(data.error)){
	                	window.location.replace(siteUrl+'hr/emp_attendance/upload_attendance');
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
