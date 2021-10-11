<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});

	});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
$to_date_cal = strtotime($to_date);
$from_date_cal= strtotime($from_date);
$datediff = $to_date_cal - $from_date_cal;
$datediff = round($datediff / (60 * 60 * 24));
?>
<h4>Offdays Report: <?php echo "From - ".$from_date.", To - ".$to_date.", Branch - ".ucfirst($branch); ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow" style="background-color:transparent;">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Attendance Report: <?php echo "From - ".$from_date." To - ".$to_date.", Branch - ".ucfirst($branch); ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Print"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <table class="table" style="border-collapse:collapse;" border="1">
      <thead
        <colgroup>
          <col span="2">
          <?php
		  $ci =&get_instance();
		  $ci->load->model('employee_model');
			$ci->load->model('hrreport_model');
		  $date_display = $from_date;
			$check_holiday=Null;
		  while ($date_display <= $to_date){
		    $check_attendance = $ci->employee_model->check_attendance_for_date($date_display);
				$check_holiday = $ci->employee_model->check_holidays($date_display);
			if(count($check_attendance)>0){ ?>
				<col>
			<?php
			}else if(date('D', strtotime($date_display)) == 'Sun'){ ?>
				<col style="background-color:lightgoldenrodyellow">
			<?php
			}else if($check_holiday==true){ ?>
				<col style="background-color:lightgoldenrodyellow">
			<?php
		}else{ ?>
			    <col>
			<?php
			}?>

		    <?php
			$date_display = date('Y-m-d', strtotime($date_display . ' +1 day'));
		  } ?>
        </colgroup>
        <tr bgcolor="LightGray" >
          <th rowspan="2">Employee Number</th>
          <th rowspan="2">Employees Name</th>
          <th colspan="<?php echo $datediff+1; ?>" style="text-align: center"></th>
        </tr>
        <tr bgcolor="LightGray">
					<?php
		  $date_display = $from_date;
		  while ($date_display <= $to_date){
				?>
				<th>
				<?php echo date('d-M', strtotime($date_display)); ?></th>
		    <?php
			$date_display = date('Y-m-d', strtotime($date_display . ' +1 day'));
		  } ?>
        </tr>
      </thead>

<tbody>
        <?php
		  $c = 0;
		  $ci =&get_instance();
		  $ci->load->model('employee_model');
		  foreach($employee_list as $employee){
			  if($branch == "all"){
				  if($employee->status == "A" && $employee_id == "all"){
				   ?>
					<tr>
					  <td><?php echo $employee->epf_no; ?></td>
					  <td><?php echo $employee->initial." ".$employee->surname; ?></td>
					  <?php
					  $date_display = $from_date;
					  while ($date_display <= $to_date){

						//$emp_leave_status = $ci->employee_model->get_emp_leave_status($date_display,$employee->id);
						//$emp_attendance = $ci->employee_model->get_emp_attendance_report($date_display,$employee->id);
						//$check_holiday = $ci->employee_model->check_holidays($date_display);
						$emp_attendance = $ci->hrreport_model->get_emp_offdays_report($date_display,$employee->id);
						if(count($emp_attendance)>0){ ?>
								<td style="text-align: center; background-color:lightcoral;"> Off Day</td>
							<?php
							}else{ ?>
							<td style="text-align: center;  "></td>
						<?php
						}

						$date_display = date('Y-m-d', strtotime($date_display . ' +1 day'));
					  } ?>
					</tr>
				  <?php
				  }else if($employee->status == "A" && $employee->id == $employee_id){
				   ?>
					<tr>
					  <td><?php echo $employee->epf_no; ?></td>
					  <td><?php echo $employee->initial." ".$employee->surname; ?></td>
					  <?php
					  $date_display = $from_date;
					  while ($date_display <= $to_date){
							$emp_attendance = $ci->hrreport_model->get_emp_offdays_report($date_display,$employee->id);
							if(count($emp_attendance)>0){ ?>
									<td style="text-align: center; background-color:lightcoral;"> Off Day</td>
								<?php
								}else{ ?>
								<td style="text-align: center;  "></td>
							<?php
							}

							$date_display = date('Y-m-d', strtotime($date_display . ' +1 day'));
					  } ?>
					</tr>
				  <?php
				  }
			  }else{
				  if($employee->status == "A" && $employee->branch == $branch && $employee_id == "all"){
				   ?>
					<tr>
					  <td><?php echo $employee->epf_no; ?></td>
					  <td><?php echo $employee->initial." ".$employee->surname; ?></td>
					  <?php
					  $date_display = $from_date;
					  while ($date_display <= $to_date){
							$emp_attendance = $ci->hrreport_model->get_emp_offdays_report($date_display,$employee->id);
							if(count($emp_attendance)>0){ ?>
									<td style="text-align: center; background-color:lightcoral;"> Off Day</td>
								<?php
								}else{ ?>
								<td style="text-align: center;  "></td>
							<?php 
							}

							$date_display = date('Y-m-d', strtotime($date_display . ' +1 day'));
					  } ?>
					</tr>
				  <?php
				  }else if($employee->status == "A" && $employee->branch == $branch && $employee->id == $employee_id){
				   ?>
					<tr>
					  <td><?php echo $employee->epf_no; ?></td>
					  <td><?php echo $employee->initial." ".$employee->surname; ?></td>
					  <?php
					  $date_display = $from_date;
					  while ($date_display <= $to_date){
							$emp_attendance = $ci->hrreport_model->get_emp_offdays_report($date_display,$employee->id);
							if(count($emp_attendance)>0){ ?>
									<td style="text-align: center; background-color:lightcoral;"> Off Day</td>
								<?php
								}else{ ?>
								<td style="text-align: center;  "></td>
							<?php
							}

							$date_display = date('Y-m-d', strtotime($date_display . ' +1 day'));
					  } ?>
					</tr>
				  <?php
				  }
			  }

		  }
		?>
      </tbody>

    </table>
  </div>
</div>



<script>

	function close_edit(){
		$('#popupform').delay(1).fadeOut(800);
	}

	function sent_to_print(){
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').hide();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		$('body').empty().html(printcontent);
		window.print();
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	}

	$("#generate_excel_icon").click(function (e) {
		var restorepage = $('body').html();
		$('#print_title').show();
		$('#print_icon').empty();
		$('#generate_excel_icon').hide();
		var printcontent = $('#print_div').clone();
		var contents = $('body').empty().html(printcontent);
		//window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html()));
		var result = 'data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=print_div]').html());
        this.href = result;
        this.download = "attendance_report.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});

</script>
