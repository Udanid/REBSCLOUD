<!DOCTYPE HTML>
<html>
<?php ob_start();
ini_set('display_errors', '0');
?>
<head>
<title><?=companyname?>-<?=solutionfull?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>media/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="<?=base_url()?>media/css/style.css" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<!-- font-awesome icons -->
<link href="<?=base_url()?>media/css/font-awesome.css" rel="stylesheet">
<!-- //font-awesome icons -->
 <!-- js-->
<script src="<?=base_url()?>media/js/jquery-1.11.1.min.js"></script>
<script src="<?=base_url()?>media/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
<!--//webfonts-->
<!--animate-->
<link href="<?=base_url()?>media/css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="<?=base_url()?>media/js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<!-- Metis Menu -->
<script src="<?=base_url()?>media/js/metisMenu.min.js"></script>
<script src="<?=base_url()?>media/js/custom.js"></script>
<link href="<?=base_url()?>media/css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

  <link href="<?php echo base_url();?>public/css/jquery-ui.min.css" rel='stylesheet' type='text/css'/>
<!--Calender-->
 <script src="<?php echo base_url();?>public/js/underscore-min.js"></script>
  <script src="<?php echo base_url();?>public/js/moment-2.2.1.js"></script>
  <script src="<?php echo base_url();?>public/js/jquery-ui.min.js"></script>
<!--End Calender-->

<script>
	$(document).ready(function(){
		var min_date = '<?php if(!empty($user_meter_reading_last_record['date'])){ echo $user_meter_reading_last_record['date']; } ?>';
  		$("#effective_date").datepicker({
      		dateFormat: 'yy-mm-dd',
      		changeMonth: true,
      		changeYear: true,
			minDate: min_date,
			maxDate: '-1',
      		yearRange: '-1' + ':' + '+1'
  		});

  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>

</head>
<body class="cbp-spmenu-push">
	<div class="main-content">

	  <div name="popupform" id="popupform" style="display:none"></div>

		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left" >
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<!--logo -->
				<div class="logo">
					<a href="index.html">
						<h1><?=solutionname?></h1>
						<span><?=solutionfull?> </span>
					</a>
				</div>

				<!--//logo-->
				<!--search-box-->

				<!--//end-search-box-->
				<div class="clearfix"> </div>
			</div><br>

			<div class="header-right">

			</div>
			<div class="clearfix"> </div>
		</div>
		<!-- //header-ends -->
		<!-- main content start-->
		<div id="page-wrapper2">
		  <div class="main-page login-page" style="margin-top:100px; margin-bottom:100px;" >
			<div class="widget-shadow">
			  <div class="login-body">
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
					<div class="alert alert-danger  fade in">
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					  </button>
					  <?php echo $this->session->flashdata('error'); ?>
					</div>
				  <?php
				  } ?>
				</div>

                <div class="row">
                  <?php
				  	if(count($user_meter_reading_last_record)>0){
						$start_reading = $user_meter_reading_last_record['end_reading'];
					}else{
						$start_reading = $employee_details['initial_meter_reading'];
					}

					$total_fuel_entitled = $employee_details['fuel_allowance_maximum_limit'] + $fuel_allowance_additional_total;
					$balance = $total_fuel_entitled - $amount_count_per_month;
				  ?>
                  <form data-toggle="validator" method="post" action="<?php echo base_url();?>user/meter_reading_submit">

                    <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $employee_details['id']; ?>" >
                    <input type="hidden" name="exceed_status" id="exceed_status" value="" >
                    <input type="hidden" name="exceeded_amount" id="exceeded_amount" value="" >
										<input type="hidden" name="vehicle_type" id="vehicle_type" value="<?php echo $employee_details['vehicle_type']; ?>" >
                    <input type="hidden" name="rate_per_km_todate" id="rate_per_km_todate" value="<?php echo $fuel_allowance_rate['rate_per_km']; ?>" >
                    <div class="form-title">
					  <h4>Meter Reading</h4>
					</div>

				  <div class="form-group">
				  <br>
					<div class="col-xs-10" style="float: right;">
					  <a href="javascript:call_edit('<?php echo $employee_details['id']; ?>')" class="btn btn-primary btn-md " id="load" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Processing Request" style="float: right;">Request Additional Fuel Allowance</a>
					</div>
				  </div>

					<div class="col-md-12">
				      <br><br>
				      <div class="form-group">
				        <div class="col-md-12">
					      <label>Effective Date</label>
						  <input type="text" class="form-control" id="effective_date" name="effective_date" value="" placeholder="YYYY-MM-DD" required/>
						  <span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					  </div>
					  <div class="form-group">
				        <div class="col-md-4">
						  <label>Start Reading</label>
						  <input type="number" class="form-control" name="start_reading" id="start_reading" placeholder="Start Reading" value="<?php echo $start_reading; ?>" readonly>
				        </div>
					    <div class="col-md-4">
						  <label>End Reading</label>
						  <input type="number" min="<?php echo $start_reading; ?>" class="form-control" name="end_reading" id="end_reading" placeholder="End Reading" onchange="km_difference(this.value)" required>
						</div>
						<div class="col-md-4">
						  <label>Total KMs</label>
						  <input type="number" class="form-control" name="difference" id="difference" placeholder="Total KMs" readonly>
						</div>
					  </div>
					</div>


					<div class="col-md-12">
				      <br>
					  <div class="form-group">
					    <div class="col-md-4">
						  <label>Private(KM)</label>
						  <input type="number" class="form-control" name="private" id="private" placeholder="Private" onchange="private_distance(this.value)" required>
						</div>
						<div class="col-md-4">
						  <label>Official(KM)</label>
						  <input type="number" class="form-control" name="official" id="official" placeholder="Official" onchange="official_distance(this.value)" required>
						</div>
				        <div class="col-md-4">
						  <label>Amount (Rs)</label>
						  <input type="number" class="form-control" name="amount" id="amount" placeholder="Amount" readonly>
				        </div>
					  </div>
					</div>

					<div class="col-md-12">
				  	  <br>
					  <div class="form-group">
					    <div class="col-md-4">
						  <label>Fuel Limit (Rs)</label>
						  <input type="number" class="form-control" name="max_limit" id="max_limit" placeholder="Fuel Limit" value="<?php echo $employee_details['fuel_allowance_maximum_limit']; ?>" readonly>
					    </div>
					    <div class="col-md-4">
						  <label>Additional Fuel Allowed (Rs)</label>
						  <input type="number" class="form-control" name="additional_fuel" id="additional_fuel" placeholder="Additional Fuel Allowed" value="<?php echo $fuel_allowance_additional_total; ?>" readonly>
					    </div>
					    <div class="col-md-4">
					      <label>Balance Amount (Rs)</label>
						  <input type="number" class="form-control" name="balance" id="balance" placeholder="Balance Amount" value="<?php echo $balance; ?>" readonly>
					    </div>
					  </div>
					</div>

					<div class="col-md-12" name="exceeded_amount_total_div" id="exceeded_amount_total_div" style="display: none;">
				      <br>
				      <div class="col-md-12">
					    <div class="form-group">
					      <label style="color: red;">Exceeded Amount Total (Rs)</label>
						  <input type="number" class="form-control" name="exceeded_amount_total" id="exceeded_amount_total" placeholder="Exceeded Amount" style="color: red; border-color: red;" readonly>
					    </div>
					  </div>
					</div>

					<div class="col-md-12">
				      <br><br>
					  <div class="form-group">
						<div class="col-md-4">
						  <label>Location</label>
						  <input type="text" class="form-control" name="location1" id="location1" placeholder="Location">
						</div>
						<div class="col-md-8">
						  <label>Description</label>
						  <input type="text" class="form-control" name="description1" id="description1" placeholder="Description">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-md-4">
						  <label>Location</label>
						  <input type="text" class="form-control" name="location2" id="location2" placeholder="Location">
						</div>
						<div class="col-md-8">
						  <label>Description</label>
						  <input type="text" class="form-control" name="description2" id="description2" placeholder="Description">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-md-4">
						  <label>Location</label>
						  <input type="text" class="form-control" name="location3" id="location3" placeholder="Location">
						</div>
						<div class="col-md-8">
						  <label>Description</label>
						  <input type="text" class="form-control" name="description3" id="description3" placeholder="Description">
						</div>
					  </div>
				      <div class="form-group">
						<div class="col-md-4">
						  <label>Location</label>
						  <input type="text" class="form-control" name="location4" id="location4" placeholder="Location">
						</div>
						<div class="col-md-8">
						  <label>Description</label>
						  <input type="text" class="form-control" name="description4" id="description4" placeholder="Description">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-md-4">
						  <label>Location</label>
						  <input type="text" class="form-control" name="location5" id="location5" placeholder="Location">
						</div>
						<div class="col-md-8">
						  <label>Description</label>
						  <input type="text" class="form-control" name="description5" id="description5" placeholder="Description">
						</div>
					  </div>
					</div>

					<div class="col-md-6 validation-grids validation-grids-right">
					  <div class="" data-example-id="basic-forms">
					    <div class="form-body">
						  <div class="bottom">
						    <div class="form-group">
							  <button type="submit" class="btn btn-primary">Submit</button>
							</div>
							<div class="clearfix"> </div>
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
		<!--footer-->
		<div class="footer"  style="background-color:#000; height:100px;" >
		   <p>&copy; 2016 ISM Syetem. All Rights Reserved </p>
		</div>
        <!--//footer-->
	</div>

	<script>
		$(document).ready(function(){
			$("#effective_date").change(function() {
				$('#private').val('');
				$('#official').val('');
				$('#end_reading').val('');
				var date=$("#effective_date").val();
				var vehicle_type=$("#vehicle_type").val();
				$.ajax({
					headers: {
						Accept: 'application/json'
					},
					type: 'post',
					url: '<?=base_url()?>user/get_fuel_allowance_rate_updates',
					data: {vehicle_type: vehicle_type,date:date},
					dataType: "json",
					success: function(result){
						if(result=='empty_data'){

							$("#rate_per_km_todate").val('');
							$("#rate_per_km_todate").val('<?php echo $fuel_allowance_rate['rate_per_km']; ?>');
						}else{
							//jQuery.each(result, function(index, item) {
								//alert(result.rate_per_km);
								$("#rate_per_km_todate").val('');
								$("#rate_per_km_todate").val(result.rate_per_km);
							//});
						}


					},error: function() {
						console.log();
					}
				});
				});
		});
		function call_edit(id){
			$('#popupform').delay(1).fadeIn(600);
			$('#popupform').load("<?php echo base_url();?>user/request_additional_fuel_allowance/"+id );
		}

		function close_edit(id){
			$('#popupform').delay(1).fadeOut(800);
		}

		function km_difference(val) {
			var start_reading = $('#start_reading').val();
			var difference = val - start_reading;
			$('#difference').val(difference);
			$('#private').val('');
			$('#official').val('');
			$('#amount').val('');
			$('#exceed_status').val('N');
			$('#exceeded_amount').val('');
			$('#exceeded_amount_total').val('');
			$('#exceeded_amount_total_div').hide();
			$('#private').attr({"max" : difference});
			$('#official').attr({"max" : difference});
		}

		function private_distance(val) {
			var	rate_per_km_todate=$("#rate_per_km_todate").val();
			var difference = $('#difference').val();
			var official = Number(difference) - Number(val);
			$('#official').val(official);

			var fuel_allowance_rate = rate_per_km_todate;
			var amount = Number(fuel_allowance_rate) * Number(difference);
			$('#amount').val(amount);

			var fuel_allowance_maximum_limit = '<?php echo $employee_details['fuel_allowance_maximum_limit']; ?>';
			var fuel_allowance_additional_total = '<?php echo $fuel_allowance_additional_total; ?>';
			var total_fuel_entitled = Number(fuel_allowance_maximum_limit) + Number(fuel_allowance_additional_total);

			var amount_count_per_month = '<?php echo $amount_count_per_month; ?>';
			var exceeded_amount_per_month = '<?php echo $exceeded_amount_per_month; ?>';
			var balance = Number(total_fuel_entitled) - Number(amount_count_per_month) - Number(amount);
			if((Number(amount_count_per_month) + Number(amount)) > Number(total_fuel_entitled)){
				$('#balance').val(0);
				var balance_val = -balance;
				$('#exceed_status').val('Y');
				$('#exceeded_amount').val(balance_val);
				var exceeded_amount_total = Number(exceeded_amount_per_month) + Number(balance_val);
				$('#exceeded_amount_total').val(exceeded_amount_total);
				$('#exceeded_amount_total_div').show();
			}else{
				$('#exceed_status').val('N');
				$('#exceeded_amount').val('');
				$('#exceeded_amount_total').val('');
				$('#balance').val(balance);
				$('#exceeded_amount_total_div').hide();
			}

		}

		function official_distance(val) {
			var	rate_per_km_todate=$("#rate_per_km_todate").val();

			var difference = $('#difference').val();
			var private = Number(difference) - Number(val);
			$('#private').val(private);

			var fuel_allowance_rate = rate_per_km_todate;
			var amount = Number(fuel_allowance_rate) * Number(difference);
			$('#amount').val(amount);

			var fuel_allowance_maximum_limit = '<?php echo $employee_details['fuel_allowance_maximum_limit']; ?>';
			var fuel_allowance_additional_total = '<?php echo $fuel_allowance_additional_total; ?>';
			var total_fuel_entitled = Number(fuel_allowance_maximum_limit) + Number(fuel_allowance_additional_total);

			var amount_count_per_month = '<?php echo $amount_count_per_month; ?>';
			var exceeded_amount_per_month = '<?php echo $exceeded_amount_per_month; ?>';
			var balance = Number(total_fuel_entitled) - Number(amount_count_per_month) - Number(amount);
			if((Number(amount_count_per_month) + Number(amount)) > Number(total_fuel_entitled)){
				$('#balance').val(0);
				var balance_val = -balance;
				$('#exceed_status').val('Y');
				$('#exceeded_amount').val(balance_val);
				var exceeded_amount_total = Number(exceeded_amount_per_month) + Number(balance_val);
				$('#exceeded_amount_total').val(exceeded_amount_total);
				$('#exceeded_amount_total_div').show();
			}else{
				$('#exceed_status').val('N');
				$('#exceeded_amount').val('');
				$('#exceeded_amount_total').val('');
				$('#balance').val(balance);
				$('#exceeded_amount_total_div').hide();
			}
		}

	</script>

	<!--scrolling js-->
	<script src="<?=base_url()?>media/js/jquery.nicescroll.js"></script>
	<script src="<?=base_url()?>media/js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="<?=base_url()?>media/js/bootstrap.js"> </script>
</body>
</html>
