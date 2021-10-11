<?php

$this->load->library('fpdf');

//require('fpdf.php');

//$this->pdf->Open();

$pdf = new FPDF();

//$pdf->AliasNbPages();

//$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);

function num2words($num, $c=1) {
    $ZERO = 'zero';
    //$num='100000.908';

    $MINUS = 'minus';
    $lowName = array(
        /* zero is shown as "" since it is never used in combined forms */
        /* 0 .. 19 */
        "", "One", "Two", "Three", "Four", "Five",
        "Six", "Seven", "Eight", "Nine", "Ten",
        "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen",
        "Sixteen", "Seventeen", "Eighteen", "Nineteen");

    $tys = array(
        /* 0, 10, 20, 30 ... 90 */
        "", "", "Twenty", "Thirty", "Forty", "Fifty",
        "Sixty", "Seventy", "Eighty", "Ninety");

    $groupName = array(
        /* We only need up to a quintillion, since a long is about 9 * 10 ^ 18 */
        /* American: unit, hundred, thousand, million, billion, trillion, quadrillion, quintillion */
        "", "Hundred", "Thousand", "Million", "Billion",
        "Trillion", "Quadrillion", "Quintillion");

    $divisor = array(
        /* How many of this group is needed to form one of the succeeding group. */
        /* American: unit, hundred, thousand, million, billion, trillion, quadrillion, quintillion */
        100, 10, 1000, 1000, 1000, 1000,1000,1000) ;
    $num = str_replace(",","",$num);

    $num = number_format($num,2,'.','');

    $cents = substr($num,strlen($num)-2,strlen($num)-1);
    $num = (int)$num;

    $s = "";
    if ( $num == 0 ) $s = $ZERO;
    $negative = ($num < 0 );
    if ( $negative ) $num = -$num;
    // Work least significant digit to most, right to left.
    // until high order part is all 0s.
    for ( $i=0; $num>0; $i++ ) {
        $remdr = (int)($num % $divisor[$i]);
        $num = $num / $divisor[$i];

        // check for 1100 .. 1999, 2100..2999, ... 5200..5999
        // but not 1000..1099,  2000..2099, ...
        // Special case written as fifty-nine hundred.
        // e.g. thousands digit is 1..5 and hundreds digit is 1..9
        // Only when no further higher order.
        if ( $i == 1 /* doing hundreds */ && 1 <= $num && $num <= 1	 ){
            if ( $remdr > 0 ){
                $remdr = ($num * 10);
                $num = 0;
            } // end if
        } // end if
        if ( $remdr == 0 ){
            continue;
        }
        $t = "";
        if ( $remdr < 20 ){
            $t = $lowName[$remdr];
        }
        else if ( $remdr < 100 ){
            $units = (int)$remdr % 10;
            $tens = (int)$remdr / 10;
            $t = $tys [$tens];
            if ( $units != 0 ){
                $t .= "-" . $lowName[$units];
            }
        }else {
            // echo "oooo".$remdr."****";
            $t = num2words($remdr , 1);
        }
        $s = $t." ".$groupName[$i]." ".$s;
        $num = (int)$num;
    } // end for
    $s = trim($s);
    if ( $negative ){
        $s = $MINUS . " " . $s;
    }
    //  if ($c == 1) $s .= " and $cents/100";
    //$s .= " Rupees";
    if ($c == 1) {
        if ($cents == 0) { $s .= " "; } else {
            if($cents<20)
            {$cents=(int)$cents;
                $centavos = $lowName[$cents];
                $diez_centavos ="";
            }
            else
            {
                $pence = (int)substr("$cents",1);
                $centavos = $lowName[$pence];
                $dimes = (int)substr("$cents",0,1);
                $diez_centavos = $tys[$dimes];
            }
            $s .= " and $diez_centavos $centavos Cents Only";
        }
    }
    return $s;
}

if($emp){

	if($payroll_list){

		$date = $details['year']."-".$details['month'];

		$month= date("F", strtotime($date));
    $date2="02-".$details['month']."-".$details['year'];//get this to get last day of month
    $last_day=date('t',strtotime($date2));

		$c = 0;

		$count = 1;

		$ci =&get_instance();

		$ci->load->model('hr/employee_model');

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

      $working_days=0;

			$earnings = array();
			// if($row->basic_salary){
			// 	$earning = array('Basic Salary' => $row->basic_salary);
			// 	//merge earning arrays
			// 	$earnings = array_merge($earnings,$earning );
			// }

			foreach($allowance_list as $allowance){

				$emp_payroll_allowance_details = $ci->employee_model->get_employee_payroll_allowance_list($row->payroll_master_id, $row->emp_record_id, $allowance->id);

				if(count($emp_payroll_allowance_details) > 0){

					$earning = array($allowance->allowance => $emp_payroll_allowance_details['amount']);
					//merge earning arrays
					$earnings = array_merge($earnings,$earning );

				}

			}

			//define deduction array
			$deductions = array();
			//add efp and paye tax
			$deduction_arrays = array('EPF 8%' => $row->epf_emp);
			//merge deduction arrays
			$deductions = array_merge($deductions,$deduction_arrays );
      $deduction_arrays = array('Leave' => $row->no_pay_deduction);
			//merge deduction arrays
			$deductions = array_merge($deductions,$deduction_arrays );
			// $deduction_arrays = array('PAYE' => $row->paye);
			// //merge deduction arrays
			// $deductions = array_merge($deductions,$deduction_arrays );
      $deduction_arrays = array('Mobile Bill & Data Package Exceed' => $row->phonebill_deduction);
      //merge deduction arrays
      $deductions = array_merge($deductions,$deduction_arrays );

      $deduction_arrays = array('Staff Loan' => $row->loan_total);
      //merge deduction arrays
      $deductions = array_merge($deductions,$deduction_arrays );

			foreach($deduction_list as $deduction){

				$emp_payroll_deduction_details = $ci->employee_model->get_employee_payroll_deduction_list($row->payroll_master_id, $row->emp_record_id, $deduction->id);

				if(count($emp_payroll_deduction_details) > 0){

					//$deduction_arrays = array($emp_payroll_deduction_details['deduction'] => $emp_payroll_deduction_details['amount']);
					$arr1 = explode(' ',trim($emp_payroll_deduction_details['deduction']));
					$deduction_arrays = array($arr1[0] => $emp_payroll_deduction_details['amount']);
					//merge deduction arrays
					$deductions = array_merge($deductions,$deduction_arrays );

				}

			}
      $deduction_arrays = array('Advance' => $row->salary_advance_amount);
      $deductions = array_merge($deductions,$deduction_arrays );
      $working_days=$last_day-$row->no_pay_count;

	$pdf->AddPage('');

	$image = base_url().'media/images/leave_application_head.jpg';
	$pdf->SetXY(10, 43);
	$pdf->Image($image,10,10,-150);
	$pdf->SetFont('Arial','B',12);
	$pdf->SetXY(10, 47);
	$heading = 'PAY SLIP FOR THE MONTH OF '.strtoupper($month);
	$pdf->Cell(130,0,$heading." ".$details['year'],0,0,'C');

	$pdf->SetXY(10, 55);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,7,'Employee Details',1,0,'L',0);
  $pdf->SetFont('Arial','',9);
  $pdf->SetXY(10, 62);
	$pdf->Cell(65,7,'Name:',1,0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,$empDetails['initial']." ".$empDetails['surname'],1,0,'L',0);
	$pdf->SetFont('Arial','',9);
  $pdf->SetXY(10, 69);
	$pdf->Cell(65,7,'Designation:',1,0,'L',0);
	$pdf->SetFont('Arial','',9);
  $empDesignation = $ci->common_hr_model->get_designation($empDetails['designation']);
  if(strlen($empDesignation['designation']) > 25){
		$pdf->Cell(65,7,substr($empDesignation['designation'], 0, strpos($empDesignation['designation'], ' ', 15)),1,0,'L',0); //this function is in custom helper
	}else{
		$pdf->Cell(65,7,$empDesignation['designation'],1,0,'L',0);
	}

	$pdf->SetXY(10, 76);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,'Department:',1,0,'L',0);
	$pdf->SetFont('Arial','',9);
	$division = $ci->common_hr_model->get_division_details($empDetails['division']);
	//echo $empDesignation['designation'];
	if(strlen($division['division_name']) > 25){
		$pdf->Cell(65,7,substr($division['division_name'], 0, strpos($division['division_name'], ' ', 15)),1,0,'L',0); //this function is in custom helper
	}else{
		$pdf->Cell(65,7,$division['division_name'],1,0,'L',0);
	}
  $pdf->SetXY(10, 83);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,'Employee Number:',1,0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,$empDetails['epf_no'],1,0,'L',0);

	$pdf->SetXY(10, 90);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,'No.Of Working days:',1,0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,$working_days,1,0,'L',0); //this function is in re_account helper

  $pdf->SetXY(10, 97);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,7,'Salary Details',1,0,'L',0);

  $pdf->SetXY(10,104);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,7,'Earnings',1,0,'L',0);

  $pdf->SetXY(10,111);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,7,'Salary Heads',1,0,'L',0);

  $pdf->SetXY(10,118);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(65,7,'Basic Salary:',1,0,'L',0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(65,7,number_format($row->basic_salary,2),1,0,'L',0);

  $pdf->SetXY(10,125);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(130,7,'Allowances:',1,0,'L',0);


  $pdf->SetXY(10, 132);

	$total_earnings = 0;
	$total_deductions = 0;
  $x_zero = 0;
	$y_zero = 132;

	//print earnings
	foreach($earnings as $key=>$value){
	//	if($value > 0){
			$pdf->SetX(10);
			$pdf->Cell(65,7,$key,1,0,'L',0);
			$pdf->Cell(65,7,number_format($value,2,'.',','),1,0,'R',0);
			$pdf->SetX(10);
			$pdf->Ln();
      $y_zero=$y_zero+7;
			$total_earnings = $total_earnings + $value;
	//	}
	}
  $pdf->SetFont('','B');
	$pdf->Cell(65,7,'Total Allownces',1,0,'L',0);
	$pdf->Cell(65,7,number_format($total_earnings,2,'.',','),1,0,'R',0);

  $pdf->Ln();
  $pdf->SetFont('','B');
	$pdf->Cell(65,7,'Gross Salary',1,0,'L',0);
  $gross_salary=$total_earnings+$row->basic_salary;
	$pdf->Cell(65,7,number_format($gross_salary,2,'.',','),1,0,'R',0);

  $pdf->Ln();
  $pdf->SetFont('','B');
	$pdf->Cell(130,7,'Deductions',1,0,'L',0);

  $pdf->Ln();
  $pdf->SetFont('','B');
	$pdf->Cell(65,7,'Salary Heads',1,0,'L',0);
  $gross_salary=$total_earnings+$row->basic_salary;
	$pdf->Cell(65,7,'Amount',1,0,'C',0);
  $pdf->Ln();

	//print deductions
	foreach($deductions as $key=>$value){
	//	if($value > 0){
			$pdf->Cell(65,7,$key,1,0,'L',0);
			$pdf->Cell(65,7,number_format($value,2,'.',','),1,0,'R',0);
			$pdf->Ln();
			$pdf->SetX(10);
			$total_deductions = $total_deductions + $value;
	//	}
	}

	$pdf->SetX(10);
	$pdf->SetFont('','B');
	$pdf->Cell(65,7,'Total Deductions',1,0,'L',0);
	$pdf->Cell(65,7,number_format($total_deductions,2,'.',','),1,0,'R',0);

$pdf->Ln();
  $pdf->SetX(10);
  $pdf->SetFont('','B');
  $pdf->Cell(65,7,'Net Salary',1,0,'L',0);
  $net_salary=$gross_salary-$total_deductions;
  $pdf->Cell(65,7,number_format($net_salary,2,'.',','),1,0,'R',0);

	$pdf->Ln();
  $pdf->Cell(130,7,'',1,0,'L',0);

	$pdf->Ln();
  $pdf->SetX(10);
	$pdf->SetFont('','B');
	$pdf->Cell(65,7,'Calculations:',1,0,'L',0);
	$pdf->Cell(65,7,'',1,0,'R',0);

  $pdf->Ln();
  $pdf->SetX(10);
  $pdf->SetFont('','B');
  $pdf->Cell(65,7,'Total for EPF,ETF',1,0,'L',0);
  $pdf->Cell(65,7,$row->epf_company+$row->etf_company,1,0,'R',0);


  $pdf->Ln();
	$pdf->Cell(65,7,'ETF (Company Contr. 12%)',1,0,'L',0);
	$pdf->Cell(65,7,number_format($row->etf_company,2,'.',','),1,0,'R',0);

  $pdf->Ln();
  $pdf->Cell(65,7,'EPF (Company Contr.3%)',1,0,'L',0);
	$pdf->Cell(65,7,number_format($row->epf_company,2,'.',','),1,0,'R',0);



	$pdf->Ln();
  $pdf->Ln();

	$pdf->SetX(10);
	$pdf->Cell(65,7,'Checked by:',1,0,'C',0);
	$pdf->Cell(65,7,'Authorised by:',1,0,'C',0);
  $pdf->Ln();
  $pdf->Cell(65,7,'..............................',1,0,'C',0);
	$pdf->Cell(65,7,'...............................',1,0,'C',0);

	$count=$count+1;

}}}

}else{

	if($payroll_list){

		$date = $details['year']."-".$details['month'];

		$month= date("F", strtotime($date));
    $date2="02-".$details['month']."-".$details['year'];//get this to get last day of month
    $last_day=date('t',strtotime($date2));

		$c = 0;

		$count = 1;

		$ci =&get_instance();

		$ci->load->model('hr/employee_model');

		$ci->load->model('common_hr_model');

		foreach($payroll_list as $row){

      $empDetails = $ci->employee_model->get_employee_details($row->emp_record_id);

      $allowance_amount = 0;

      $bra=0;

      $vehicle_rent=0;

      $medical_deduction = 0;

      $welfare_deduction = 0;

      $ta_allowance_amount=0;

      $working_days=0;

      $earnings = array();
      // if($row->basic_salary){
      // 	$earning = array('Basic Salary' => $row->basic_salary);
      // 	//merge earning arrays
      // 	$earnings = array_merge($earnings,$earning );
      // }

      foreach($allowance_list as $allowance){

        $emp_payroll_allowance_details = $ci->employee_model->get_employee_payroll_allowance_list($row->payroll_master_id, $row->emp_record_id, $allowance->id);

        if(count($emp_payroll_allowance_details) > 0){

          $earning = array($allowance->allowance => $emp_payroll_allowance_details['amount']);
          //merge earning arrays
          $earnings = array_merge($earnings,$earning );

        }

      }

      //define deduction array
      $deductions = array();
      //add efp and paye tax
      $deduction_arrays = array('EPF 8%' => $row->epf_emp);
      //merge deduction arrays
      $deductions = array_merge($deductions,$deduction_arrays );
      $deduction_arrays = array('Leave' => $row->no_pay_deduction);
      //merge deduction arrays
      $deductions = array_merge($deductions,$deduction_arrays );
      // $deduction_arrays = array('PAYE' => $row->paye);
      // //merge deduction arrays
      // $deductions = array_merge($deductions,$deduction_arrays );
      $deduction_arrays = array('Mobile Bill & Data Package Exceed' => $row->phonebill_deduction);
      //merge deduction arrays
      $deductions = array_merge($deductions,$deduction_arrays );

      $deduction_arrays = array('Staff Loan' => $row->loan_total);
      //merge deduction arrays
      $deductions = array_merge($deductions,$deduction_arrays );

      foreach($deduction_list as $deduction){

        $emp_payroll_deduction_details = $ci->employee_model->get_employee_payroll_deduction_list($row->payroll_master_id, $row->emp_record_id, $deduction->id);

        if(count($emp_payroll_deduction_details) > 0){

          //$deduction_arrays = array($emp_payroll_deduction_details['deduction'] => $emp_payroll_deduction_details['amount']);
          $arr1 = explode(' ',trim($emp_payroll_deduction_details['deduction']));
          $deduction_arrays = array($arr1[0] => $emp_payroll_deduction_details['amount']);
          //merge deduction arrays
          $deductions = array_merge($deductions,$deduction_arrays );

        }

      }
      $deduction_arrays = array('Advance' => $row->salary_advance_amount);
      $deductions = array_merge($deductions,$deduction_arrays );
      $working_days=$last_day-$row->no_pay_count;

    $pdf->AddPage('');

    $image = base_url().'media/images/leave_application_head.jpg';
    $pdf->SetXY(10, 43);
    $pdf->Image($image,10,10,-150);
    $pdf->SetFont('Arial','B',12);
    $pdf->SetXY(10, 47);
    $heading = 'PAY SLIP FOR THE MONTH OF '.strtoupper($month);
    $pdf->Cell(130,0,$heading." ".$details['year'],0,0,'C');

    $pdf->SetXY(10, 55);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(130,7,'Employee Details',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(10, 62);
    $pdf->Cell(65,7,'Name:',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,$empDetails['initial']." ".$empDetails['surname'],1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $pdf->SetXY(10, 69);
    $pdf->Cell(65,7,'Designation:',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $empDesignation = $ci->common_hr_model->get_designation($empDetails['designation']);
    if(strlen($empDesignation['designation']) > 25){
    $pdf->Cell(65,7,substr($empDesignation['designation'], 0, strpos($empDesignation['designation'], ' ', 15)),1,0,'L',0); //this function is in custom helper
    }else{
    $pdf->Cell(65,7,$empDesignation['designation'],1,0,'L',0);
    }

    $pdf->SetXY(10, 76);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,'Department:',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $division = $ci->common_hr_model->get_division_details($empDetails['division']);
    //echo $empDesignation['designation'];
    if(strlen($division['division_name']) > 25){
    $pdf->Cell(65,7,substr($division['division_name'], 0, strpos($division['division_name'], ' ', 15)),1,0,'L',0); //this function is in custom helper
    }else{
    $pdf->Cell(65,7,$division['division_name'],1,0,'L',0);
    }
    $pdf->SetXY(10, 83);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,'Employee Number:',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,$empDetails['epf_no'],1,0,'L',0);

    $pdf->SetXY(10, 90);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,'No.Of Working days:',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,$working_days,1,0,'L',0); //this function is in re_account helper

    $pdf->SetXY(10, 97);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(130,7,'Salary Details',1,0,'L',0);

    $pdf->SetXY(10,104);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(130,7,'Earnings',1,0,'L',0);

    $pdf->SetXY(10,111);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(130,7,'Salary Heads',1,0,'L',0);

    $pdf->SetXY(10,118);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(65,7,'Basic Salary:',1,0,'L',0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(65,7,number_format($row->basic_salary,2),1,0,'L',0);

    $pdf->SetXY(10,125);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(130,7,'Allowances:',1,0,'L',0);


    $pdf->SetXY(10, 132);

    $total_earnings = 0;
    $total_deductions = 0;
    $x_zero = 0;
    $y_zero = 132;

    //print earnings
    foreach($earnings as $key=>$value){
    //	if($value > 0){
      $pdf->SetX(10);
      $pdf->Cell(65,7,$key,1,0,'L',0);
      $pdf->Cell(65,7,number_format($value,2,'.',','),1,0,'R',0);
      $pdf->SetX(10);
      $pdf->Ln();
      $y_zero=$y_zero+7;
      $total_earnings = $total_earnings + $value;
    //	}
    }
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Total Allownces',1,0,'L',0);
    $pdf->Cell(65,7,number_format($total_earnings,2,'.',','),1,0,'R',0);

    $pdf->Ln();
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Gross Salary',1,0,'L',0);
    $gross_salary=$total_earnings+$row->basic_salary;
    $pdf->Cell(65,7,number_format($gross_salary,2,'.',','),1,0,'R',0);

    $pdf->Ln();
    $pdf->SetFont('','B');
    $pdf->Cell(130,7,'Deductions',1,0,'L',0);

    $pdf->Ln();
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Salary Heads',1,0,'L',0);
    $gross_salary=$total_earnings+$row->basic_salary;
    $pdf->Cell(65,7,'Amount',1,0,'C',0);
    $pdf->Ln();

    //print deductions
    foreach($deductions as $key=>$value){
    //	if($value > 0){
      $pdf->Cell(65,7,$key,1,0,'L',0);
      $pdf->Cell(65,7,number_format($value,2,'.',','),1,0,'R',0);
      $pdf->Ln();
      $pdf->SetX(10);
      $total_deductions = $total_deductions + $value;
    //	}
    }

    $pdf->SetX(10);
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Total Deductions',1,0,'L',0);
    $pdf->Cell(65,7,number_format($total_deductions,2,'.',','),1,0,'R',0);

    $pdf->Ln();
    $pdf->SetX(10);
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Net Salary',1,0,'L',0);
    $net_salary=$gross_salary-$total_deductions;
    $pdf->Cell(65,7,number_format($net_salary,2,'.',','),1,0,'R',0);

    $pdf->Ln();
    $pdf->Cell(130,7,'',1,0,'L',0);

    $pdf->Ln();
    $pdf->SetX(10);
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Calculations:',1,0,'L',0);
    $pdf->Cell(65,7,'',1,0,'R',0);

    $pdf->Ln();
    $pdf->SetX(10);
    $pdf->SetFont('','B');
    $pdf->Cell(65,7,'Total for EPF,ETF',1,0,'L',0);
    $pdf->Cell(65,7,$row->epf_company+$row->etf_company,1,0,'R',0);


    $pdf->Ln();
    $pdf->Cell(65,7,'ETF (Company Contr. 12%)',1,0,'L',0);
    $pdf->Cell(65,7,number_format($row->etf_company,2,'.',','),1,0,'R',0);

    $pdf->Ln();
    $pdf->Cell(65,7,'EPF (Company Contr.3%)',1,0,'L',0);
    $pdf->Cell(65,7,number_format($row->epf_company,2,'.',','),1,0,'R',0);



    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetX(10);
    $pdf->Cell(65,7,'Checked by:',1,0,'C',0);
    $pdf->Cell(65,7,'Authorised by:',1,0,'C',0);
    $pdf->Ln();
    $pdf->Cell(65,7,'..............................',1,0,'C',0);
    $pdf->Cell(65,7,'...............................',1,0,'C',0);

    $count=$count+1;
		}}}

$pdf->Output();
?>
