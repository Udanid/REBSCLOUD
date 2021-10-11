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
$date = $details['year']."-".$details['month'];
$month= date("F", strtotime($date));
?>
<h4>Payroll Details: <?php echo $month."/".$details['year']; ?><span style="float:right; color:#FFF" ><a href="javascript:close_edit('<?php echo $details['id']; ?>')"><i class="fa fa-times-circle"></i></a></span></h4>
<div name="print_div" id="print_div" class="table widget-shadow">
	<h4 style="background-color: transparent; color: black; text-align: center; display:none;" name="print_title" id="print_title"> <br>Payroll Details: <?php echo $month."/".$details['year']; ?></h4>
	<button onclick="sent_to_print()" name="print_icon" id="print_icon"><img src="<?php echo base_url(); ?>application/assets/images/icons/print.png" border="0" alt="Re Print Payment Entry"/></button>
	<a href="#"  name="generate_excel_icon" id="generate_excel_icon"><i class="fa fa-file-excel-o"></i></a>
	<div name="messageBoard" id="messageBoard"></div>
	<div class="row">
		<table class="table" style="border-collapse:collapse;" border="1">
			<thead>
				<tr bgcolor="LightGray" >
					<th rowspan="2">Employee Number</th>
					<th rowspan="2">Employee Name</th>
					<th rowspan="2">Designation</th>
					<th rowspan="2">Date Joined</th>
					<th rowspan="2">Basic Salary</th>
					<th colspan="<?php echo count($allowance_list); ?>" style="text-align: center">Allowances</th>
					<th rowspan="2">Gross Salary</th>
					<th rowspan="2">No Pay</th>
					<th colspan="<?php echo count($deduction_list)+2-5; ?>" style="text-align: center">Deductions</th>
					<th rowspan="2">Taxable Salary</th>
					<th rowspan="2">PAYE Deduction</th>
					<th rowspan="2">Loan</th>
					<th rowspan="2">Net Salary</th>
					<th rowspan="2">EPF 12%</th>
					<th rowspan="2">Total EPF 12%</th>
					<th rowspan="2">ETF 3%</th>
				</tr>
				<tr bgcolor="LightGray">
					<?php
					foreach($allowance_list as $allowance){
						$allowance
						?>
						<th><?php echo $allowance->allowance; ?></th>
						<?php
					}
					?>
					<th>EPF 8%</th>
					<th>Advance</th>
					<th>Medical</th>
					<th>Welfare</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if($payroll_list){
					$c = 0;
					$count = 1;
					$ci =&get_instance();
					$ci->load->model('employee_model');
					$ci->load->model('common_hr_model');
					foreach($payroll_list as $row){
						$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);  ?>
						<tr class="<?php echo ($c<0) ? 0 : ($c++ % 2 == 1) ? 'info' : ''; ?>">
							<td><?php echo $empDetails['epf_no']; ?></td>
							<td><?php echo $empDetails['initial']." ".$empDetails['surname']; ?></td>
							<td>
								<?php
								$empDesignation = $ci->common_hr_model->get_designation($empDetails['designation']);
								echo $empDesignation['designation'];
								?>
							</td>
							<td><?php echo $empDetails['joining_date']; ?></td>
							<td id="basic_salary" class="basic_salary text-right"><?php echo number_format($row->basic_salary,2, '.', ''); ?></td>
							<?php
							foreach($allowance_list as $allowance){
								$emp_payroll_allowance_details = $ci->employee_model->get_employee_payroll_allowance_list($row->payroll_master_id, $row->emp_record_id, $allowance->id);
								if(count($emp_payroll_allowance_details) > 0){
									$allowance_amount = $emp_payroll_allowance_details['amount'];
								}else{
									$allowance_amount = 0;
								} ?>
								<td id="" class="text-right"><?php echo number_format($allowance_amount,2, '.', ''); ?></td>
								<?php
							}
							?>
							<td id="gross_salary" class="gross_salary text-right"><?php echo number_format($row->gross_salary,2, '.', ''); ?></td>
							<td id="no_pay_deduction" class="no_pay_deduction text-right"><?php echo number_format($row->no_pay_deduction,2, '.', ''); ?></td>
							<td id="epf_emp" class="epf_emp text-right"><?php echo number_format($row->epf_emp,2, '.', ''); ?></td>
							<td id="salary_advance_amount" class="salary_advance_amount text-right"><?php echo number_format($row->salary_advance_amount,2, '.', ''); ?></td>
							<?php
							$medical_deduction = 0;
							$welfare_deduction = 0;

							foreach($deduction_list as $deduction){
								$emp_payroll_deduction_details = $ci->employee_model->get_employee_payroll_deduction_list($row->payroll_master_id, $row->emp_record_id, $deduction->id);

								if($deduction->id == 1 || $deduction->id == 2){
									if(count($emp_payroll_deduction_details) > 0){
										$medical_deduction = $emp_payroll_deduction_details['amount'];
									}
								}else if($deduction->id == 3 || $deduction->id == 4 || $deduction->id == 5 || $deduction->id == 6 || $deduction->id == 7){
									if(count($emp_payroll_deduction_details) > 0){
										$welfare_deduction = $emp_payroll_deduction_details['amount'];
									}
								}
							}
							?>
							<td class="medical text-right"><?php echo number_format($medical_deduction,2, '.', ''); ?></td>
							<td class="welfare text-right"><?php echo number_format($welfare_deduction,2, '.', ''); ?></td>
							<td class="tax_free text-right"><?php echo number_format($row->gross_salary-$row->no_pay_deduction - $row->tax_free_allowance_amount_total,2, '.', ''); ?></td>
							<td class="paye text-right"><?php echo number_format($row->paye,2, '.', ''); ?></td>
							<td class="loan text-right"><?php echo number_format($row->loan_total,2, '.', ''); ?></td>
							<td class="net_salary text-right"><?php echo number_format($row->net_salary,2, '.', ''); ?></td>
							<td class="epf_company text-right"><?php echo number_format($row->epf_company,2, '.', ''); ?></td>
							<td class="epfall text-right"><?php echo number_format($row->epf_emp + $row->epf_company,2, '.', ''); ?></td>
							<td class="etf_company text-right"><?php echo number_format($row->etf_company,2, '.', ''); ?></td>
						</tr>
						<?php
					}
				} ?>

				<tr bgcolor="LightGray">
					<th ></th>
					<th></th>
					<th ></th>
					<th ></th>
					<th  class="total-salary text-right"></th>
					<?php
					foreach($allowance_list as $allowance){
						$emp_payroll_allowance_details = $ci->employee_model->get_employee_payroll_allowance_list_sum($row->payroll_master_id, $allowance->id);
						if(count($emp_payroll_allowance_details) > 0){
							$allowance_amount = $emp_payroll_allowance_details['total'];
						}else{
							$allowance_amount = 0;
						}
						?>
						<th class="text-right"><?php echo number_format($allowance_amount,2, '.', ''); ?></th>
						<?php
					}
					?>
					<th class="total-gross_salary text-right"></th>
					<th class="total-no_pay_deductionsum text-right">No Pay</th>
					<th class="total-epf_empsum text-right">EPF 8%</th>
					<th class="total-salary_advance_amountsum text-right">Advance</th>
					<th class="total-medical text-right">Medical</th>
					<th class="total-welfare text-right">Welfare</th>
					<th class="total-tax_free text-right">Taxable Salary</th>
					<th class="total-paye text-right">PAYE Deduction</th>
					<th class="total-loan text-right">Loan</th>
					<th class="total-net_salary text-right">Net Salary</th>
					<th class="total-epf_company text-right">EPF 12%</th>
					<th class="total-epfall text-right">Total EPF 12%</th>
					<th class="total-etf_company text-right">ETF 3%</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>



<script>
$(document).ready(function () {
	var salsum = 0;
	var gross_salarysum=0;
	var no_pay_deductionsum=0;
	var epf_empsum=0;
	var salary_advance_amountsum=0;
	var medicalsum=0;
	var welfaresum=0;
	var tax_freesum=0;
	var payesum=0;
	var net_salarysum=0;
	var epf_companysum=0;
	var epfallsum=0;
	var etf_companysum=0;
	var loan=0;
	$('tr').each(function () {
		$(this).find('.basic_salary').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				salsum =salsum+ parseFloat(combat);
			}
		});
		$(this).find('.gross_salary').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				gross_salarysum =gross_salarysum+ parseFloat(combat);
			}
		});
		$(this).find('.no_pay_deduction').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				no_pay_deductionsum =no_pay_deductionsum+ parseFloat(combat);
			}
		});
		$(this).find('.epf_emp').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				epf_empsum =epf_empsum+ parseFloat(combat);
			}
		});
		$(this).find('.salary_advance_amount').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				salary_advance_amountsum =salary_advance_amountsum+ parseFloat(combat);
			}
		});
		$(this).find('.medical').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				medicalsum =medicalsum+ parseFloat(combat);
			}
		});
		$(this).find('.welfare').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				welfaresum =welfaresum+ parseFloat(combat);
			}
		});
		$(this).find('.tax_free').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				tax_freesum =tax_freesum+ parseFloat(combat);
			}
		});
		$(this).find('.paye').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				payesum =payesum+ parseFloat(combat);
			}
		});
		$(this).find('.net_salary').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				net_salarysum =net_salarysum+ parseFloat(combat);
			}
		});
		$(this).find('.epf_company').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				epf_companysum =epf_companysum+ parseFloat(combat);
			}
		});
		$(this).find('.epfall').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				epfallsum =epfallsum+ parseFloat(combat);
			}
		});
		$(this).find('.etf_company').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				etf_companysum =etf_companysum+ parseFloat(combat);
			}
		});
		$(this).find('.loan').each(function () {
			var combat = $(this).text();
			if (!isNaN(combat) && combat.length !== 0) {
				loan =loan+ parseFloat(combat);
			}
		});


	});
	$('.total-etf_company', this).html(etf_companysum.toFixed(2));
	$('.total-epfall', this).html(epfallsum.toFixed(2));
	$('.total-epf_company', this).html(epf_companysum.toFixed(2));
	$('.total-net_salary', this).html(net_salarysum.toFixed(2));
	$('.total-paye', this).html(payesum.toFixed(2));
	$('.total-tax_free', this).html(tax_freesum.toFixed(2));
	$('.total-medical', this).html(medicalsum.toFixed(2));
	$('.total-welfare', this).html(welfaresum.toFixed(2));
	$('.total-no_pay_deductionsum', this).html(no_pay_deductionsum.toFixed(2));
	$('.total-epf_empsum', this).html(epf_empsum.toFixed(2));
	$('.total-salary_advance_amountsum', this).html(salary_advance_amountsum.toFixed(2));
	$('.total-gross_salary', this).html(gross_salarysum.toFixed(2));
	$('.total-loan', this).html(loan.toFixed(2));
	$('.total-salary', this).html(salsum.toFixed(2));

});
function close_edit(id){
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
	this.download = "payroll.xls";
	$('#print_title').hide();
	$('#print_icon').show();
	$('#generate_excel_icon').show();
	$('body').html(restorepage);
});

</script>
