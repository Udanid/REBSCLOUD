<?
header('Content-Type: text/html; charset=utf-8');
?>
<script>
	$(document).ready(function() {

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
		$("#requests").chosen({
			allow_single_deselect : true
		});
		
		//validate all fields
		$.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" });
		
		//set validation options
		$("#inputform").validate({
			rules: {
				
				requests: {
							required: true
						 },
				new_password: "required",
				confirm_new_password: {
				  equalTo: "#new_password"
				}
				
			},
			messages: {
				
				requests: "Please select an Emaployee",
				confirm_new_password: {
				  equalTo: "Please enter the same value as new password"
				}
				
			}
			
		});
		
	});
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
			<?php 
			if($this->session->flashdata('error') != ''){ ?>
				<div class="alert alert-danger fade in">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
			<?php
			} ?>
		  </div>

		  <div class="col-xs-12 form-container">
			<form class="userRegForm form-horizontal" action="<?=base_url()?>login/reset_userpassword" id="inputform" name="inputform" method="post">
			  <div class="panel panel-default">
				<div class="panel-heading">User Password Reset</div>
				<div class="panel-body">

				  <div class="form-group">
                  		<label for="new_password" class="control-label col-xs-2">Employee</label>
                        <div class="col-xs-5">
                          <select class="sb-search-input input__field--madoka form-control chosen-select" id="requests" name="requests">
                              <option value="">Select..</option>
                              <? if ($requests){
                                 foreach ($requests as $raw){?>
                                 <option value="<?=$raw->id?>"><?=strtoupper($raw->initial) .' '.strtoupper($raw->surname)?></option>
                                 <? }}?>
                          </select> 
                        </div>
				  </div>
				  
				  <div class="form-group">
					<label for="new_password" class="control-label col-xs-2">New Password</label>
					<div class="col-xs-5">
					  <input type="password" class="form-control" id="new_password" name="new_password" value="" placeholder="New Password" required/>
					</div>
				  </div>
				  
				  <div class="form-group">
					<label for="confirm_new_password" class="control-label col-xs-2">Confirm New Password</label>
					<div class="col-xs-5">
					  <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" value="" placeholder="Confirm New Password" required/>
					</div>
				  </div>

				</div>
			  </div>

			  <div class="form-group">
				<div class="col-xs-10">
				  <button type="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Reset</button>
				</div>
			  </div>
			</form>
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
