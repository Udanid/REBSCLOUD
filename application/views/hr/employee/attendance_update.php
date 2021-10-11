<script>
$(document).ready(function(){
	//when succes close button pressed
	$(document).on('click','#close-btn', function(){
		location.reload();
	});

	$("#from_date").datepicker({
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		yearRange: '-50' + ':' + '+1'
	});


});
function call_confirm(id)
    {

      document.deletekeyform.deletekey.value=id;
      $('#complexConfirm').click();

    }
		function call_edit(id)
		    {

		      document.deletekeyform.deletekey.value=id;
		      $('#complexConfirm_confirm').click();

}

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
			<h3 class="title1">Employee Attendance Manual Update</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Attendance Update</a>
				</li>
				<li role="presentation" class="">
				  <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="true">Attendance Update List</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
			    <div role="tabpanel" class="tab-pane fade " id="profile" aria-labelledby="profile-tab">
				  <div class=" widget-shadow bs-example" data-example-id="contextual-table" >
					<table class="table">
					  <thead>
						<tr>
						  <th>No</th>
						  <th>Employee</th>
						  <th>Intime</th>
						  <th>Outtime</th>
							<th>Satues</th>
						</tr>
					  </thead>
					  <tbody>
							<?php
							$i=0;
							foreach ($temp_list as $key => $value) {
								$i=$i+1;
								?>
								<tr>
								<td><?=$i?></td>
							  <td><?=$user_data[$value->emp_record_id]->initial;?> <?=$user_data[$value->emp_record_id]->surname;?></td>
							  <td><?=$value->duty_in;?></td>
							  <td><?=$value->duty_out;?></td>
								<td align="right">
									<?php if($value->statues=='PENDING'){?>
                                <div id="checherflag">
                                  <a href="javascript:call_edit('<?php echo $value->id;?>')" title="Cancel"><i class="fa fa-times nav_icon icon_red"></i></a>
                                  <a href="javascript:call_confirm('<?php echo $value->id;?>')" title="Confirm"><i class="fa fa-check nav_icon icon_blue"></i></a>

                                </div>
											<?php }else{ echo $value->statues;}?>
                              </td>
							</tr>
						<?	}
							?>
					  </tbody>
					</table>
					<div id="pagination-container"></div>
				  </div>
				</div>

				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
				  <div class="row">
					<form enctype="multipart/form-data" data-toggle="validator" method="post" id="inputform" name="inputform">

					  <div class="col-md-12">
						<div class="col-md-6">
						  <div class="form-group">
							<label for="employee" class="control-label">Employee</label>
							<select class="form-control" id="employee" name="employee">
							  <?php
							  foreach($emp_list as $emp){ ?>
							    <option value="<?php echo $emp->id; ?>"><?php echo $emp->initial; ?> <?php echo $emp->surname; ?></option>
							  <?php
							  } ?>
							</select>
						  </div>
						</div>
						<div class="col-md-6">
					      <div class="form-group">
									<label for="from_date" class="control-label" >Date</label>
  							<input type="text" class="form-control" id="from_date" name="from_date" value="" placeholder="DD/MM/YYYY" required />

						  </div>
						</div>

						<div class="col-md-6">
					      <div class="form-group">
									<label for="intime" class="control-label" >In Time</label>
  							<input type="time" min="5:00" max="23:00" class="form-control" id="intime" name="intime" value="" placeholder="h/MM p" required step="2"/>

						  </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="outtime" class="control-label" >Out Time</label>
							<input type="time" min="5:00" max="23:00" class="form-control" id="outtime" name="outtime" value="" placeholder="h/MM p" required step="2"/>

						</div>
						</div>
					  </div>

					  <div class="col-md-12">
					    <div class="col-md-12 validation-grids validation-grids-right">
						  <div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Update</button>
						  </div>
						</div>
					  </div>
					</form>
				  </div>
				</div>
			  </div>
				<div class="col-md-4 modal-grids">
									<button type="button" style="display:none" class="btn btn-primary"  id="flagchertbtn"  data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button>
									<div class="modal fade bs-example-modal-sm"tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
										<div class="modal-dialog modal-sm">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
													<h4 class="modal-title" id="mySmallModalLabel"><i class="fa fa-info-circle nav_icon"></i> Alert</h4>
												</div>
												<div class="modal-body" id="checkflagmessage">
												</div>
											</div>
										</div>
									</div>
								</div>

								<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm" name="complexConfirm"  value="DELETE"></button>
								<button type="button" style="display:none" class="btn btn-delete" id="complexConfirm_confirm" name="complexConfirm_confirm"  value="DELETE"></button>
								<form name="deletekeyform">  <input name="deletekey" id="deletekey" value="0" type="hidden">
								</form>
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
				url: siteUrl + 'hr/employee/submit_attendance_manual',
			type: "POST",
				cache: false,
				contentType: false,
				processData: false,
				data: formData,
				success: function(data) {
					var data = JSON.parse(data);
	                if($.isEmptyObject(data.error)){
	                	window.location.replace(siteUrl+'hr/employee/attendance_update');
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
	$("#complexConfirm").confirm({
		title:"Record confirmation",
		text: "Are You sure you want to confirm this ?" ,
		headerClass:"modal-header confirmbox_green",
		confirm: function(button) {
			button.fadeOut(2000).fadeIn(2000);
			var code=1

			window.location="<?=base_url()?>hr/employee/attendence_confirm/"+document.deletekeyform.deletekey.value;
		},
		cancel: function(button) {
			button.fadeOut(2000).fadeIn(2000);
			// alert("You aborted the operation.");
		},
		confirmButton: "Yes I am",
		cancelButton: "No"

	});
	$("#complexConfirm_confirm").confirm({
		title:"Record confirmation",
		text: "Are You sure you want to cancel this ?" ,
		headerClass:"modal-header confirmbox_red",
		confirm: function(button) {
			button.fadeOut(2000).fadeIn(2000);
			var code=1

			window.location="<?=base_url()?>hr/employee/attendence_cancel/"+document.deletekeyform.deletekey.value;
		},
		cancel: function(button) {
			button.fadeOut(2000).fadeIn(2000);
			// alert("You aborted the operation.");
		},
		confirmButton: "Yes I am",
		cancelButton: "No"

	});
</script>
