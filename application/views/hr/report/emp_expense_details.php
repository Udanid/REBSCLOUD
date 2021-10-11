<script>
	$(document).ready(function(){

		$("#from_date").datepicker({
      		dateFormat: 'yy-mm-dd',
      		changeMonth: true,
      		changeYear: true,
      		yearRange: '-50' + ':' + '+1',
					orientation: 'bottom'

  		});

		$('#from_date').change(function(){
			var from_date = $("#from_date").val();

			$('#to_date').datepicker('setDate', null);
			$("#to_date").datepicker("destroy");

			$("#to_date").datepicker({
				dateFormat: 'yy-mm-dd',
				setDate: from_date,
				minDate: from_date,
				changeMonth: true,
				changeYear: true,
				orientation: 'bottom'

			});
		});

	});

	function load_employee_list(branchcode){
		if(branchcode != ''){
			$("#employee_load").load("<?php echo base_url();?>hr/employee/get_branch_employee_list/"+branchcode);
		}
	}

	$(document).ready(function() {
		var branch_code = document.getElementById("branch").value;
		load_employee_list(branch_code);
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
			<h3 class="title1">Employee Expense Details</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Employee Expense Details</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class="row">
					<form data-toggle="validator" method="post" id="inputform" name="inputform">
					  <div class="col-md-12">
						<div class="col-md-6">
						  <div class="form-group">
							<label for="branch" class="control-label">Branch</label>
							<select class="form-control" id="branch" name="branch" onChange="load_employee_list(this.value);">
							  <option value="all">All Branches</option>
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
						    <label for="employee" class="control-label">Employee</label>
							<div id="employee_load">
							  <select class="form-control" id="employee" name="employee">
							    <option value="">--Select Employee--</option>
							  </select>
							</div>
						  </div>
						</div>
					  </div>

					  <div class="col-md-12">
						<div class="col-md-6">
					      <div class="form-group">
						    <label for="from_date" class="control-label" >From</label>
							<input type="text" class="form-control" id="from_date" name="from_date" value="" placeholder="DD/MM/YYYY" required readonly />
						  </div>
						</div>

						<div class="col-md-6">
						  <div class="form-group">
							<label for="to_date" class="control-label" >To</label>
							<input type="text" class="form-control" id="to_date" name="to_date" value="" placeholder="DD/MM/YYYY" required readonly />
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

</script>

<script>
	$(document).ready(function(){
		$("form#inputform").submit(function(e){
			e.preventDefault();
			$("#popupform").empty();
			var from_date = $("#from_date").val();
			var to_date = $("#to_date").val();
			var branch = $("#branch").val();
			var employee = $("#employee").val();
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				url: siteUrl + 'hr/HrReport/view_expense_details',
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
