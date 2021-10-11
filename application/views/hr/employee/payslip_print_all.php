<?php
$this->load->library('fpdf');
//require('fpdf.php');
$pdf = new FPDF();
//$this->pdf->Open();
//$pdf = new PDF();
//$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);
if($emp){
	if($payroll_list){
		$date = $details['year']."-".$details['month'];
		$month= date("F", strtotime($date));
		$c = 0;
		$count = 1;
		$ci =&get_instance();
		$ci->load->model('employee_model');
		$ci->load->model('common_hr_model');
		foreach($payroll_list as $row){
			if($emp==$row->emp_record_id){
			$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
			$allowance_amount = 0;
			$bra=0;
			$vehicle_rent=0;
			$medical_deduction = 0;
			$welfare_deduction = 0;
			$ta_allowance_amount=0;
			foreach($allowance_list as $allowance){
				$emp_payroll_allowance_details = $ci->employee_model->get_employee_payroll_allowance_list($row->payroll_master_id, $row->emp_record_id, $allowance->id);
				if(count($emp_payroll_allowance_details) > 0){
					if($allowance->allowance=="BRA"){
						$bra=$emp_payroll_allowance_details['amount'];
					}elseif($allowance->allowance=="Vehicle Rent"){
						$vehicle_rent=$emp_payroll_allowance_details['amount'];
					}elseif($allowance->allowance=="Travelling Allowance"){
						$ta_allowance_amount = $emp_payroll_allowance_details['amount'];
					}else{
						$allowance_amount = $emp_payroll_allowance_details['amount'];
					}
				}
			}


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
	$pdf->AddPage('L');
	$pdf->SetXY(16, 42);
	$pdf->Cell(160,0,$month." ".$details['year'],0,0,'C');

	$pdf->SetXY(10, 55);

	$pdf->Cell(40,5,'EPF No');
	$pdf->Cell(40,5,':   '.$empDetails['epf_no']);
	$pdf->Ln();

	$pdf->Cell(40,5,'Employee Name');
	$pdf->Cell(40,5,':   '.$empDetails['initial']." ".$empDetails['surname']);
	$pdf->Ln();

	$empDesignation = $ci->common_hr_model->get_designation($empDetails['designation']);
	$pdf->Cell(40,5,'Designation');
	$pdf->Cell(40,5,':   '.$empDesignation['designation']);
	$pdf->Ln();

	$pdf->SetXY(20, 75);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Cell(85,5,'Narration');
	$pdf->Cell(40,5,'Amount (Rs.)', 0, 0, 'C');
	$pdf->Ln();

	$pdf->SetFont('Arial', '', 12);
	$pdf->Cell(90,5,'Basic Salary');
	$pdf->Cell(40,5,number_format($row->basic_salary,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'No Pay');
	$pdf->Cell(40,5,'('.number_format($row->no_pay_deduction,0, '.', ',').')', 0, 0, 'R');
	$pdf->Line(110, 90, 250-110, 90);

	$pdf->Ln();

	$pdf->Cell(90,5,'Gross Remuneration');
	$remuneration=$row->basic_salary-$row->no_pay_deduction;
	$pdf->Cell(40,5,number_format($remuneration,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();
	$pdf->Ln();

	$pdf->Cell(90,5,'Vehicle Rent');
	$pdf->Cell(40,5,number_format($vehicle_rent,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'B.R.A');
	$pdf->Cell(40,5,number_format($bra,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'Allowances');
	$pdf->Cell(40,5,number_format($allowance_amount+$ta_allowance_amount,0, '.', ','), 0, 0, 'R');
	$pdf->Line(110, 114, 250-110, 114);
	$pdf->Ln();

	$pdf->Cell(90,5,'Gross Salary');
	$pdf->Cell(40,5,number_format($row->gross_salary-$row->no_pay_deduction,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Ln();

	$pdf->Cell(90,5,'EPF 8%');
	$pdf->Cell(40,5,'('.number_format($row->epf_emp,0, '.', ',').')', 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'Welfare');
	$pdf->Cell(40,5,'('.number_format($welfare_deduction,0, '.', ',').')', 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'Medical');
	$pdf->Cell(40,5,'('.number_format($medical_deduction,0, '.', ',').')', 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'PAYE');
	$pdf->Cell(40,5,'('.number_format($row->paye,0, '.', ',').')', 0, 0, 'R');
	$pdf->Line(110, 144, 250-110, 144);
	$pdf->Ln();

	$pdf->Cell(90,5,'Net Salary');
	$pdf->Cell(40,5,number_format($row->net_salary+$row->salary_advance_amount+$row->loan_total,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Ln();

	$pdf->Cell(90,5,'Staff Loan');
	$pdf->Cell(40,5,'('.number_format($row->loan_total,0, '.', ',').')', 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'Salary Advance');
	$pdf->Cell(40,5,'('.number_format($row->salary_advance_amount,0, '.', ',').')', 0, 0, 'R');
	$pdf->Line(110, 165, 250-110, 165);
	$pdf->Ln();

	$pdf->Cell(90,5,'Net Pay');
	$pdf->Cell(40,5,number_format($row->net_salary,0, '.', ','), 0, 0, 'R');
	$pdf->Line(110, 170, 250-110, 170);
	$pdf->Line(110, 169, 250-110, 169);
	$pdf->Ln();

	$pdf->SetXY(10, 174);
	$pdf->Cell(90,5,'EPF Total');
	$pdf->Cell(40,5,number_format($row->epf_emp + $row->epf_company,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'EPF 12%');
	$pdf->Cell(40,5,number_format($row->epf_company,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();

	$pdf->Cell(90,5,'ETF 3%');
	$pdf->Cell(40,5,number_format($row->etf_company,0, '.', ','), 0, 0, 'R');
	$pdf->Ln();
	$count=$count+1;
}}}
}else{
	if($payroll_list){
		$date = $details['year']."-".$details['month'];
		$month= date("F", strtotime($date));
		$c = 0;
		$count = 1;
		$ci =&get_instance();
		$ci->load->model('employee_model');
		$ci->load->model('common_hr_model');
		foreach($payroll_list as $row){
			$empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);
			$allowance_amount = 0;
			$bra=0;
			$vehicle_rent=0;
			$medical_deduction = 0;
			$welfare_deduction = 0;
			$ta_allowance_amount=0;
			foreach($allowance_list as $allowance){
				$emp_payroll_allowance_details = $ci->employee_model->get_employee_payroll_allowance_list($row->payroll_master_id, $row->emp_record_id, $allowance->id);
				if(count($emp_payroll_allowance_details) > 0){
					if($allowance->allowance=="BRA"){
						$bra=$emp_payroll_allowance_details['amount'];
					}elseif($allowance->allowance=="Vehicle Rent"){
						$vehicle_rent=$emp_payroll_allowance_details['amount'];
					}elseif($allowance->allowance=="Travelling Allowance"){
						$ta_allowance_amount = $emp_payroll_allowance_details['amount'];
					}else{
						$allowance_amount = $emp_payroll_allowance_details['amount'];
					}
				}
			}


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

			if($count % 2 == 0){
				$pdf->SetXY(221, 42);
				$pdf->Cell(0,0,$month." ".$details['year']);

				$pdf->SetXY(155, 55);
				$pdf->Cell(40,5,'EPF No');
				$pdf->Cell(40,5,':   '.$empDetails['epf_no']);
				$pdf->Ln();

				$pdf->SetXY(155, 60);
				$pdf->Cell(40,5,'Employee Name');
				$pdf->Cell(40,5,':   '.$empDetails['initial']." ".$empDetails['surname']);
				$pdf->Ln();

				$pdf->SetXY(155, 65);
				$empDesignation = $ci->common_hr_model->get_designation($empDetails['designation']);
				$pdf->Cell(40,5,'Designation');
				$pdf->Cell(40,5,':   '.$empDesignation['designation']);
				$pdf->Ln();

				$pdf->SetXY(165, 75);
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->Cell(85,5,'Narration');
				$pdf->Cell(40,5,'Amount (Rs.)', 0, 0, 'C');
				$pdf->Ln();

				$pdf->SetXY(155, 79);
				$pdf->SetFont('Arial', '', 12);
				$pdf->Cell(90,5,'Basic Salary');
				$pdf->Cell(40,5,number_format($row->basic_salary,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 84);
				$pdf->Cell(90,5,'No Pay');
				$pdf->Cell(40,5,'('.number_format($row->no_pay_deduction,0, '.', ',').')', 0, 0, 'R');
				$pdf->Line(285, 90, 250-0, 90);
				$pdf->Ln();

				$pdf->SetXY(155, 89);
				$pdf->Cell(90,5,'Gross Remuneration');
				$remuneration=$row->basic_salary-$row->no_pay_deduction;
				$pdf->Cell(40,5,number_format($remuneration,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();
				$pdf->Ln();

				$pdf->SetXY(155, 99);
				$pdf->Cell(90,5,'Vehicle Rent');
				$pdf->Cell(40,5,number_format($vehicle_rent,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 104);
				$pdf->Cell(90,5,'B.R.A');
				$pdf->Cell(40,5,number_format($bra,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 109);
				$pdf->Cell(90,5,'Allowances');
				$pdf->Cell(40,5,number_format($allowance_amount+$ta_allowance_amount,0, '.', ','), 0, 0, 'R');
				$pdf->Line(285, 114, 250-0, 114);
				$pdf->Ln();

				$pdf->SetXY(155, 114);
				$pdf->Cell(90,5,'Gross Salary');
				$pdf->Cell(40,5,number_format($row->gross_salary-$row->no_pay_deduction,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();


				$pdf->Ln();
				$pdf->SetXY(155, 124);
				$pdf->Cell(90,5,'EPF 8%');
				$pdf->Cell(40,5,'('.number_format($row->epf_emp,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 129);
				$pdf->Cell(90,5,'Welfare');
				$pdf->Cell(40,5,'('.number_format($welfare_deduction,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 134);
				$pdf->Cell(90,5,'Medical');
				$pdf->Cell(40,5,'('.number_format($medical_deduction,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 139);
				$pdf->Cell(90,5,'PAYE');
				$pdf->Cell(40,5,'('.number_format($row->paye,0, '.', ',').')', 0, 0, 'R');
				$pdf->Line(285, 144, 250-0, 144);
				$pdf->Ln();

				$pdf->SetXY(155, 144);
				$pdf->Cell(90,5,'Net Salary');
				$pdf->Cell(40,5,number_format($row->net_salary+$row->salary_advance_amount+$row->loan_total,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Ln();

				$pdf->SetXY(155, 154);
				$pdf->Cell(90,5,'Staff Loan');
				$pdf->Cell(40,5,'('.number_format($row->loan_total,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 159);
				$pdf->Cell(90,5,'Salary Advance');
				$pdf->Cell(40,5,'('.number_format($row->salary_advance_amount,0, '.', ',').')', 0, 0, 'R');
				$pdf->Line(285, 165, 250-0, 165);
				$pdf->Ln();

				$pdf->SetXY(155, 164);
				$pdf->Cell(90,5,'Net Pay');
				$pdf->Cell(40,5,number_format($row->net_salary,0, '.', ','), 0, 0, 'R');
				$pdf->Line(285, 170, 250-0, 170);
				$pdf->Line(285, 169, 250-0, 169);
				$pdf->Ln();

				$pdf->SetXY(155, 174);
				$pdf->Cell(90,5,'EPF Total');
				$pdf->Cell(40,5,number_format($row->epf_emp + $row->epf_company,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 179);
				$pdf->Cell(90,5,'EPF 12%');
				$pdf->Cell(40,5,number_format($row->epf_company,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->SetXY(155, 184);
				$pdf->Cell(90,5,'ETF 3%');
				$pdf->Cell(40,5,number_format($row->etf_company,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

			}else{

				$pdf->AddPage('L');
				$pdf->SetXY(16, 42);
				$pdf->Cell(160,0,$month." ".$details['year'],0,0,'C');

				$pdf->SetXY(10, 55);

				$pdf->Cell(40,5,'EPF No');
				$pdf->Cell(40,5,':   '.$empDetails['epf_no']);
				$pdf->Ln();

				$pdf->Cell(40,5,'Employee Name');
				$pdf->Cell(40,5,':   '.$empDetails['initial']." ".$empDetails['surname']);
				$pdf->Ln();

				$empDesignation = $ci->common_hr_model->get_designation($empDetails['designation']);
				$pdf->Cell(40,5,'Designation');
				$pdf->Cell(40,5,':   '.$empDesignation['designation']);
				$pdf->Ln();

				$pdf->SetXY(20, 75);
				$pdf->SetFont('Arial', 'B', 12);
				$pdf->Cell(85,5,'Narration');
				$pdf->Cell(40,5,'Amount (Rs.)', 0, 0, 'C');
				$pdf->Ln();

				$pdf->SetFont('Arial', '', 12);
				$pdf->Cell(90,5,'Basic Salary');
				$pdf->Cell(40,5,number_format($row->basic_salary,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'No Pay');
				$pdf->Cell(40,5,'('.number_format($row->no_pay_deduction,0, '.', ',').')', 0, 0, 'R');
				$pdf->Line(110, 90, 250-110, 90);

				$pdf->Ln();

				$pdf->Cell(90,5,'Gross Remuneration');
				$remuneration=$row->basic_salary-$row->no_pay_deduction;
				$pdf->Cell(40,5,number_format($remuneration,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();
				$pdf->Ln();


				$pdf->Cell(90,5,'Vehicle Rent');
				$pdf->Cell(40,5,number_format($vehicle_rent,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'B.R.A');
				$pdf->Cell(40,5,number_format($bra,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'Allowances');
				$pdf->Cell(40,5,number_format($allowance_amount+$ta_allowance_amount,0, '.', ','), 0, 0, 'R');
				$pdf->Line(110, 114, 250-110, 114);
				$pdf->Ln();

				$pdf->Cell(90,5,'Gross Salary');
				$pdf->Cell(40,5,number_format($row->gross_salary-$row->no_pay_deduction,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Ln();

				$pdf->Cell(90,5,'EPF 8%');
				$pdf->Cell(40,5,'('.number_format($row->epf_emp,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'Welfare');
				$pdf->Cell(40,5,'('.number_format($welfare_deduction,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'Medical');
				$pdf->Cell(40,5,'('.number_format($medical_deduction,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'PAYE');
				$pdf->Cell(40,5,'('.number_format($row->paye,0, '.', ',').')', 0, 0, 'R');
				$pdf->Line(110, 144, 250-110, 144);
				$pdf->Ln();

				$pdf->Cell(90,5,'Net Salary');
				$pdf->Cell(40,5,number_format($row->net_salary+$row->salary_advance_amount+$row->loan_total,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Ln();

				$pdf->Cell(90,5,'Staff Loan');
				$pdf->Cell(40,5,'('.number_format($row->loan_total,0, '.', ',').')', 0, 0, 'R');
				$pdf->Ln();


				$pdf->Cell(90,5,'Salary Advance');
				$pdf->Cell(40,5,'('.number_format($row->salary_advance_amount,0, '.', ',').')', 0, 0, 'R');
				$pdf->Line(110, 165, 250-110, 165);
				$pdf->Ln();

				$pdf->Cell(90,5,'Net Pay');
				$pdf->Cell(40,5,number_format($row->net_salary,0, '.', ','), 0, 0, 'R');
				$pdf->Line(110, 170, 250-110, 170);
				$pdf->Line(110, 169, 250-110, 169);
				$pdf->Ln();

				$pdf->SetXY(10, 174);
				$pdf->Cell(90,5,'EPF Total');
				$pdf->Cell(40,5,number_format($row->epf_emp + $row->epf_company,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'EPF 12%');
				$pdf->Cell(40,5,number_format($row->epf_company,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

				$pdf->Cell(90,5,'ETF 3%');
				$pdf->Cell(40,5,number_format($row->etf_company,0, '.', ','), 0, 0, 'R');
				$pdf->Ln();

			}


			$count=$count+1;
		}}}
$pdf->Output();
?>
