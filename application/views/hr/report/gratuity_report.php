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
			<h3 class="title1">Employee Gratuity Report Summery</h3>
			<div class="widget-shadow">
			  <ul id="myTabs" class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active">
				  <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="false">Gratuity Report</a>
				</li>
			  </ul>
			  <div id="myTabContent" class="tab-content scrollbar1" style="padding:5px;">
				<div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab" >
				  <div class="row">
						<table class="table table-bordered">
							<tr class="success">
								<th>No</th>
								<th>Employee Name</th>
								<th>Basic Salary</th>
								<th>Join Date</th>
								<th>Gratuity %</th>
								<th>Gratuity Value</th>
								<th>Resignation Date</th>
								<th>Paid Gratuity</th>
								<th>Paid Vaucher</th>
							</tr>
							<? if($gratuity){
								$i=1;
								foreach ($gratuity as $key => $value) {
									?>
									<tr>
										<td><?=$i?></td>
										<td><?=$value->initial." ".$value->surname?></td>
										<td align="right"><?=number_format($value->basic_salary,2)?></td>
										<td><?=$value->joining_date?></td>
										<td><?=$value->gratuity?></td>
										<td align="right"><?=number_format($value->total_gratuity,2)?></td>
										<td><?=$value->resignation_date?></td>
										<td align="right"><?=number_format($value->paid_gratuity,2)?></td>
										<td><?=$value->voucher_id?></td>
									</tr>
							<?
							$i++;
						}

							}?>
						</table>

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
			var siteUrl = '<?php echo base_url(); ?>';
			var dats = $(this).serializeArray();
			$.ajax({
				url: siteUrl + 'hr/HrReport/view_expense_summery',
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
