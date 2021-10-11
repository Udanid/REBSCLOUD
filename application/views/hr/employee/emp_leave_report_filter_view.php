<script>
	$(document).ready(function(){
  		//when succes close button pressed
  		$(document).on('click','#close-btn', function(){
    		location.reload();
  		});
		
	});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<h4>Leave Report: <?php echo "Year - ".$year.", Branch - ".ucfirst($branch); ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Leave Report: <?php echo "Year - ".$year.", Branch - ".ucfirst($branch); ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Re Print Payment Entry"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <table class="table" style="border-collapse:collapse;" border="1"> 
      <thead> 
        <tr bgcolor="LightGray" > 
          <th rowspan="2">Employee Number</th>
          <th rowspan="2">Employee Name</th>
          <th colspan="4" style="text-align: center">Leave Entitlment</th>
          <th colspan="4" style="text-align: center">Leave Taken</th>
          <th colspan="4" style="text-align: center">Leave Available</th>
        </tr>
        <tr bgcolor="LightGray">
		  	<th>Annual</th>
		    <th>Casual</th>
		    <th>Medical</th>
		    <th>No Pay</th>
		  	<th>Annual</th>
		    <th>Casual</th>
		    <th>Medical</th>
		    <th>No Pay</th>
		  	<th>Annual</th>
		    <th>Casual</th>
		    <th>Medical</th>
            <th>No Pay</th>
        </tr>
      </thead>
      <tbody>
        <?php
		  $c = 0;
		  $ci =&get_instance();
		  $ci->load->model('employee_model');
		  $ci->load->model('common_hr_model');
		  foreach($employee_list as $employee){
			  if($branch == "all"){
				  if($employee->status == "A"){
					$emp_leave_category = $ci->common_hr_model->get_leave_category_details($employee->leave_category);

					$annual_count = 0;
					$annual_no_pay_count = 0;
					$casual_count = 0;
					$casual_no_pay_count = 0;
					$sick_count = 0;
					$sick_no_pay_count = 0;
					$no_pay_count = 0;
					foreach($view_leave_report as $view_leave){
						if($view_leave->emp_record_id == $employee->id && $view_leave->approval == "A"){
							if($view_leave->leave_type == "annual"){
								$annual_count = $annual_count + $view_leave->no_of_days;
								$annual_no_pay_count = $annual_no_pay_count + $view_leave->no_pay_days;
							}
							if($view_leave->leave_type == "cassual"){
								$casual_count = $casual_count + $view_leave->no_of_days;
								$casual_no_pay_count = $casual_no_pay_count + $view_leave->no_pay_days;
							}
							if($view_leave->leave_type == "sick"){
								$sick_count = $sick_count + $view_leave->no_of_days;
								$sick_no_pay_count = $sick_no_pay_count + $view_leave->no_pay_days;
							}
							$no_pay_count = $no_pay_count + $view_leave->no_pay_days;
						}
					}  
					$remaining_annual = $emp_leave_category['annual_leave'] - $annual_count;
					$remaining_casual = $emp_leave_category['cassual_leave'] - $casual_count;
					$remaining_sick = $emp_leave_category['sick_leave'] - $sick_count;
				   ?>
					<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
					  <td><?php echo $employee->epf_no; ?></td>
					  <td><?php echo $employee->initial." ".$employee->surname; ?></td>
					  <td><?php echo $emp_leave_category['annual_leave']; ?></td>
					  <td><?php echo $emp_leave_category['cassual_leave']; ?></td>
					  <td><?php echo $emp_leave_category['sick_leave']; ?></td>
					  <td style="text-align: center;">-</td>

					  <td><?php echo $annual_count - $annual_no_pay_count; ?></td>
					  <td><?php echo $casual_count - $casual_no_pay_count; ?></td>
					  <td><?php echo $sick_count - $sick_no_pay_count; ?></td>
					  <td><?php echo $no_pay_count; ?></td>

					  <td><?php echo $remaining_annual; ?></td>
					  <td><?php echo $remaining_casual; ?></td>
					  <td><?php echo $remaining_sick; ?></td>
					  <td style="text-align: center;">-</td>
					</tr>
				  <?php  
				  }
			  }else{
				  if($employee->status == "A" && $employee->branch == $branch){
					$emp_leave_category = $ci->common_hr_model->get_leave_category_details($employee->leave_category);

					$annual_count = 0;
					$annual_no_pay_count = 0;
					$casual_count = 0;
					$casual_no_pay_count = 0;
					$sick_count = 0;
					$sick_no_pay_count = 0;
					$no_pay_count = 0;
					foreach($view_leave_report as $view_leave){
						if($view_leave->emp_record_id == $employee->id && $view_leave->approval == "A"){
							if($view_leave->leave_type == "annual"){
								$annual_count = $annual_count + $view_leave->no_of_days;
								$annual_no_pay_count = $annual_no_pay_count + $view_leave->no_pay_days;
							}
							if($view_leave->leave_type == "cassual"){
								$casual_count = $casual_count + $view_leave->no_of_days;
								$casual_no_pay_count = $casual_no_pay_count + $view_leave->no_pay_days;
							}
							if($view_leave->leave_type == "sick"){
								$sick_count = $sick_count + $view_leave->no_of_days;
								$sick_no_pay_count = $sick_no_pay_count + $view_leave->no_pay_days;
							}
							$no_pay_count = $no_pay_count + $view_leave->no_pay_days;
						}
					}  
					$remaining_annual = $emp_leave_category['annual_leave'] - $annual_count;
					$remaining_casual = $emp_leave_category['cassual_leave'] - $casual_count;
					$remaining_sick = $emp_leave_category['sick_leave'] - $sick_count;
				   ?>
					<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
					  <td><?php echo $employee->epf_no; ?></td>
					  <td><?php echo $employee->initial." ".$employee->surname; ?></td>
					  <td><?php echo $emp_leave_category['annual_leave']; ?></td>
					  <td><?php echo $emp_leave_category['cassual_leave']; ?></td>
					  <td><?php echo $emp_leave_category['sick_leave']; ?></td>
					  <td style="text-align: center;">-</td>

					  <td><?php echo $annual_count - $annual_no_pay_count; ?></td>
					  <td><?php echo $casual_count - $casual_no_pay_count; ?></td>
					  <td><?php echo $sick_count - $sick_no_pay_count; ?></td>
					  <td><?php echo $no_pay_count; ?></td>

					  <td><?php echo $remaining_annual; ?></td>
					  <td><?php echo $remaining_casual; ?></td>
					  <td><?php echo $remaining_sick; ?></td>
					  <td style="text-align: center;">-</td>
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
        this.download = "leave_report.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});
	
</script>
