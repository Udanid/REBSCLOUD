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
<h4>Employee Expense Summery: <?php echo "From - ".$from_date.", To - ".$to_date; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit()"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow" style="background-color:transparent;">
  <h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Employee Expense Summery: <?php echo "From - ".$from_date.", To - ".$to_date; ?></h4>
  <button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Print"/></button>
  <a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>

  <div name="messageBoard" id="messageBoard"></div>
  <div class="row">
    <table class="table" style="border-collapse:collapse;" border="1">
      <thead>
      <tr bgcolor="LightGray">
        <th></th>
				<th>Employee Name</th>
				<th>Basic Salary</th>
				<th>Other Allowance</th>
				<th>Vehicle Rent</th>
				<th>Commission</th>
				<th>Fuel Expense</th>
				<th>EPF</th>
				<th>ETF</th>
				<th>Phone Bill</th>
				<th>Total</th>

			</tr>
			<? if($employee_list)
			{
				$i=0;
				foreach ($employee_list as $key => $raw) {
					$i=$i+1;
					?>
					<tr>
						<th><?=$i?></th>
						<th><?php echo $raw->epf_no.' - '.$raw->initial.' '.$raw->surname; ?></th>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['basic_salary_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['allowance_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['vehicle_rent_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['commition_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['fual_expence_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['epf_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['etf_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['phone_bill_emp'],2); ?></td>
						<td align="right"><?php echo number_format($employee_a[$raw->id]['emp_tot'],2); ?></td>
					</tr>
			<?	}
			}?>
			<tr bgcolor="LightGray">
				<th></th>
        <th>Total</th>
				<td align="right"><?=number_format($basic_salary_tot,2);?></td>
				<td align="right"><?=number_format($allowance_tot,2);?></td>
				<td align="right"><?=number_format($vehicle_rent_tot,2);?></td>
				<td align="right"><?=number_format($commition_tot,2);?></td>
				<td align="right"><?=number_format($fual_expence_tot,2);?></td>
				<td align="right"><?=number_format($epf_tot,2);?></td>
				<td align="right"><?=number_format($etf_tot,2);?></td>
				<td align="right"><?=number_format($phone_bill_tot,2);?></td>
				<td align="right"><?=number_format($basic_salary_tot+$allowance_tot+$vehicle_rent_tot+$commition_tot+$fual_expence_tot+$epf_tot+$etf_tot+$phone_bill_tot,2);?></td>

			</tr>



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
        this.download = "Employee_Expense.xls";
		$('#print_title').hide();
		$('#print_icon').show();
		$('#generate_excel_icon').show();
		$('body').html(restorepage);
	});

</script>
