
<script>
	$(document).ready(function() {

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
			<form class="userRegForm form-horizontal" id="inputform" name="inputform" method="post">
			  <input type="hidden" id="emp_id" name="emp_id" value="<?php echo $userid; ?>" />

			  <div class="panel panel-default">
				<div class="panel-heading">Password Reset</div>
				<div class="panel-body">

				  <div class="form-group">
					<label for="current_password" class="control-label col-xs-2">Current Password</label>
					<div class="col-xs-5">
					  <input type="password" class="form-control" id="current_password" name="current_password" value="" placeholder="Current Password" required/>
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
				  <button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">Reset</button>
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

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({      
				url: siteUrl + 'login/submit_password_reset',
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {
	                if($.isEmptyObject(data.error)){
						window.location.replace(siteUrl+'login');
	                	//location.reload();
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
