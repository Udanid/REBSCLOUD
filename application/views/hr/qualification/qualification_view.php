<script type="text/javascript">









	function load_employee_list(branchcode){
		if(branchcode != ''){
			$("#employee_load").load("<?php echo base_url();?>hr/emp_attendance/get_branch_employee_list/"+branchcode);
		}
	}

	$(document).ready(function() {
		var branch_code = document.getElementById("branchname").value;
		load_employee_list(branch_code);
	});

</script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#divisionname").chosen({
     		allow_single_deselect : true
    	});
	});

	$(document).ready(function() {
		$("#branchname").chosen({
     		allow_single_deselect : true
    	});
	});
$(document).ready(function() {
		$("#desigination").chosen({
     		allow_single_deselect : true
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
			<h3 class="title1">Employee Qualification Report</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Qualification Report</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class="row">
					<form data-toggle="validator" method="post" id="inputform" name="inputform">
					  <div class="col-md-12">
						<div class="col-md-3">
						  <div class="form-group">
							<label for="branchname" class="control-label">Branch</label>
							<select class="form-control" id="branchname" name="branchname" onChange="load_employee_list(this.value);">
							  <option value="all">All Branches</option>
							  <?php
							  foreach($branch_list as $branch){ ?>
							    <option value="<?=$branch->branch_code; ?>"><?php echo $branch->branch_name;?></option>
							  <?php
							  } ?>
							</select>
						  </div>
						</div>

					

							<div class="col-md-3">
					      <div class="form-group">
						    <label for="divisionname" class="control-label">Division</label>
							  <select class="form-control" id="divisionname" name="divisionname">
							    <option value="all">--Select Division--</option>
							      <option value="all">All</option>
							    <?foreach($divisions as $row){?>
							    	<option value="<?=$row->id;?>"><?=$row->division_name;?></option>
							    	<?}?>
							  </select>
						  </div>
						</div>

						<div class="col-md-3">
					      <div class="form-group">
						    <label for="employee" class="control-label">Employee</label>
							<div id="employee_load">
							  <select class="form-control" id="employee" name="employee">
							    <option value="">--Select Employee--</option>
							  </select>
							</div>
						  </div>
						</div>

						<div class="col-md-3">
					      <div class="form-group">
						    <label for="desigination" class="control-label">Desigination</label>
							<div id="employee_load">
							  <select class="form-control" id="desigination" name="desigination">
							    <option value="all">--Select Desigination--</option>
							      <option value="all">All</option>
							    <?foreach($designation as $row){?>
							    	<option value="<?=$row->id;?>"><?=$row->designation;?></option>
							    	<?}?>
							  </select>
							</div>
						  </div>
						</div>

					

					  </div>

					  <div class="col-md-12">
						<div class="col-md-6">
					      <div class="form-group">
						    
						  </div>
						</div>

						<div class="col-md-6">
						  <div class="form-group">
							
						  </div>
						</div>
					  </div>

					  <div class="col-md-12">
					    <div class="col-md-12 validation-grids validation-grids-right">
						  <div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request">View Report</button>
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







	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			$("#popupform").empty();
			var employee = $("#employee").val();
		
			var branchname = $("#branchname").val();
			var divisionname = $("#divisionname").val();
			
			var desigination=$("#desigination").val();

				//alert(desigination);

			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				url: siteUrl + 'hr/emp_qualification/search_qualification',
				type: "POST",
				async: false,
				dataType: 'json',
				data: dats,
				success: function(data) {

	                if($.isEmptyObject(data.error)){
						$('#popupform').delay(1).fadeIn(600);
						$('#popupform').load();
						$('#popupform').append(data.success);
	                	//window.location.replace(siteUrl+'hr/employee/attendance_report');
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
