<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
//started 2018-09-27
class HrReport extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
    $this->load->model('hr/hrreport_model');
    }

    function is_logged_in() {
  		$is_logged_in = $this->session->userdata('username');
  		if ((!isset($is_logged_in) || $is_logged_in == "")) {
  			$this->session->sess_destroy();
  			redirect('login');
  		}
  	}


  function emp_expense_summery()
  {
		$data['title'] = "Employee Expense Summery";
  $viewData['branch_list'] = $this->common_hr_model->get_branch_list();

    $this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
    $this->load->view('includes/topbar_notsearch');
    $this->load->view('hr/report/emp_expense_summery', $viewData);
    $this->load->view('includes/footer');
  }

	function view_expense_summery()
	{

		$viewData['employee_list'] =$employee_list= $this->employee_model->get_employee_list();
		$basic_salary_tot=0;//to get total of report
		$vehicle_rent_tot=0;
		$allowance_tot=0;
		$etf_tot=0;
		$epf_tot=0;
		$commition_tot=0;
		$phone_bill_tot=0;
		$fual_expence_tot=0;
		$emp_summery = array();
		$employee_a=array();
		$employee_id='';
		if($employee_list)
		{

			foreach ($employee_list as $key => $value) {
				$employee_id=$value->id;
				$viewData['from_date'] = $from_date=$this->input->post('from_date', TRUE);
				$viewData['to_date'] = $to_date=$this->input->post('to_date', TRUE);
				$frommonth = date("m",strtotime($this->input->post('from_date', TRUE)));
				$tomonth = date("m",strtotime($this->input->post('to_date', TRUE)));
				$fromyear = date("y",strtotime($this->input->post('from_date', TRUE)));
				$toyear = date("y",strtotime($this->input->post('to_date', TRUE)));
				$basic_salary_emp=0;//to get total of employee wise
				$vehicle_rent_emp=0;
				$allowance_emp=0;
				$etf_emp=0;
				$epf_emp=0;
				$commition_emp=0;
				$phone_bill_emp=0;
				$fual_expence_emp=0;

				while ($from_date <= $to_date) {
					$basic_salary_emp_sum=0;//to get total of period wise
					$vehicle_rent_emp_sum=0;
					$allowance_emp_sum=0;
					$etf_emp_sum=0;
					$epf_emp_sum=0;
					$commition_emp_sum=0;
					$phone_bill_emp_sum=0;
					$fual_expence_emp_sum=0;

				$emp_payroll=$this->hrreport_model->get_emp_payroll($employee_id,date("m",strtotime($from_date)),date("Y",strtotime($from_date)));
					if($emp_payroll){
						$emp_allowances=$this->hrreport_model->get_emp_allowances($employee_id,$emp_payroll->payroll_master_id);
						if($emp_allowances){
							foreach ($emp_allowances as $key => $value) {
								if($value->allowance=='Vehicle Rent'){// vaild only for winrose.
									$vehicle_rent_emp_sum=$value->amount;

								}else{
									$allowance_emp_sum=$allowance_emp+$value->amount;

								}
						}
					}
					$etf_emp_sum=$emp_payroll->etf_company;
					$epf_emp_sum=$emp_payroll->epf_company;
						$basic_salary_emp_sum=$emp_payroll->basic_salary;
					}
					$fuel_allowance_payment=$this->hrreport_model->get_emp_fuel_allowance_payment($employee_id,date("m",strtotime($from_date)),date("Y",strtotime($from_date)));
					if($fuel_allowance_payment)
					{
						foreach ($fuel_allowance_payment as $key => $value) {
							$fual_expence_emp_sum=$fual_expence_emp+$value->total_amount_payable;
						}
					}
					$vehicle_rent_emp=$vehicle_rent_emp+$vehicle_rent_emp_sum;
					$allowance_emp=$allowance_emp+$allowance_emp_sum;
					$etf_emp=$etf_emp+$etf_emp_sum;
					$epf_emp=$epf_emp+$epf_emp_sum;
					$basic_salary_emp=$basic_salary_emp+$basic_salary_emp_sum;
					$fual_expence_emp=$fual_expence_emp+$fual_expence_emp_sum;

					$from_date = date("Y-m-d", strtotime("+1 month", strtotime($from_date)));
	        $frommonth = date("m",strtotime($from_date));
	        $fromyear = date("Y",strtotime($from_date));

				}
				$employee_a[$employee_id]['vehicle_rent_emp']=$vehicle_rent_emp;
				$employee_a[$employee_id]['allowance_emp']=$allowance_emp;
				$employee_a[$employee_id]['etf_emp']=$etf_emp;
				$employee_a[$employee_id]['epf_emp']=$epf_emp;
				$employee_a[$employee_id]['basic_salary_emp']=$basic_salary_emp;
				$employee_a[$employee_id]['fual_expence_emp']=$fual_expence_emp;
				$employee_a[$employee_id]['phone_bill_emp']=$phone_bill_emp_sum;
				$employee_a[$employee_id]['commition_emp']=$commition_emp_sum;
				$employee_a[$employee_id]['emp_no']=$employee_id;
				$employee_a[$employee_id]['emp_tot']=$vehicle_rent_emp+$allowance_emp+$etf_emp+$epf_emp+$basic_salary_emp+$fual_expence_emp;
				//array_push($emp_summery,$employee_a);
				$basic_salary_tot=$basic_salary_tot+$basic_salary_emp;
				$vehicle_rent_tot=$vehicle_rent_tot+$vehicle_rent_emp;
				$allowance_tot=$allowance_tot+$allowance_emp;
				$etf_tot=$etf_tot+$etf_emp;
				$epf_tot=$epf_tot+$epf_emp;
				$commition_tot=$commition_tot+$commition_emp_sum;
				$phone_bill_tot=$phone_bill_tot+$phone_bill_emp_sum;
				$fual_expence_tot=$fual_expence_tot+$fual_expence_emp;
			}
			$viewData['basic_salary_tot']=$basic_salary_tot;
			$viewData['vehicle_rent_tot']=$vehicle_rent_tot;
			$viewData['allowance_tot']=$allowance_tot;
			$viewData['etf_tot']=$etf_tot;
			$viewData['epf_tot']=$epf_tot;
			$viewData['commition_tot']=$commition_tot;
			$viewData['phone_bill_tot']=$phone_bill_tot;
			$viewData['fual_expence_tot']=$fual_expence_tot;
		}
		//print_r($employee_a);
		$viewData['employee_a'] = $employee_a;
		$emp_attendance_report_filter_view = $this->load->view('hr/report/view_emp_expense_summery', $viewData, TRUE);
		echo json_encode(['success' => $emp_attendance_report_filter_view]);
		die;

	}

  function emp_expense_details()
  {
    $data['title'] = "Employee Expense Details";
  $viewData['employee_list'] = $this->employee_model->get_employee_list();
  $viewData['branch_list'] = $this->common_hr_model->get_branch_list();


    $this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
    $this->load->view('includes/topbar_notsearch');
    $this->load->view('hr/report/emp_expense_details', $viewData);
    $this->load->view('includes/footer');
  }

  function view_expense_details()
  {

		$viewData['from_date'] = $from_date=$this->input->post('from_date', TRUE);
		$viewData['to_date'] = $to_date=$this->input->post('to_date', TRUE);
    $viewData['employee_id'] =$employee_id= $this->input->post('employee', TRUE);
		if($employee_id=="all"){
			redirect('hr/HrReport/view_expense_summery');
		}
    $frommonth = date("m",strtotime($from_date));
    $tomonth = date("m",strtotime($to_date));
    $fromyear = date("y",strtotime($from_date));
    $toyear = date("y",strtotime($to_date));
    $monthName=array();
    $basic_salary=array();
    $allowance=array();
    $vehical_rent=array();
    $commition=array();
    $fual_expence=array();
    $etf=array();
    $epf=array();
    $phone_bill=array();
		$emp_sum=array();
      while ($from_date <= $to_date) {
        if($frommonth=='01')$month_name="Jan";
        if($frommonth=='02')$month_name="Feb";
        if($frommonth=='03')$month_name="Mar";
        if($frommonth=='04')$month_name="Apr";
        if($frommonth=='05')$month_name="May";
        if($frommonth=='06')$month_name="Jun";
        if($frommonth=='07')$month_name="Jul";
        if($frommonth=='08')$month_name="Aug";
        if($frommonth=='09')$month_name="Sep";
        if($frommonth=='10')$month_name="Oct";
        if($frommonth=='11')$month_name="Nov";
        if($frommonth=='12')$month_name="Des";
//$from_date2=$from_date;
				$basic_salary_emp=0;
				$vehicle_rent_emp=0;
				$allowance_emp=0;
				$etf_emp=0;
				$epf_emp=0;
				$commition_emp=0;
				$phone_bill_emp=0;
				$fual_expence_emp=0;

			$emp_payroll=$this->hrreport_model->get_emp_payroll($employee_id,date("m",strtotime($from_date)),date("Y",strtotime($from_date)));
				if($emp_payroll){
					$emp_allowances=$this->hrreport_model->get_emp_allowances($employee_id,$emp_payroll->payroll_master_id);
					if($emp_allowances){
						foreach ($emp_allowances as $key => $value) {
							if($value->allowance=='Vehicle Rent'){// vaild only for winrose.
								$vehicle_rent_emp=$value->amount;

							}else{
								$allowance_emp=$allowance_emp+$value->amount;

							}
					}
				}
				$etf_emp=$emp_payroll->etf_company;
				$epf_emp=$emp_payroll->epf_company;
					$basic_salary_emp=$emp_payroll->basic_salary;
				}
				$fuel_allowance_payment=$this->hrreport_model->get_emp_fuel_allowance_payment($employee_id,date("m",strtotime($from_date)),date("Y",strtotime($from_date)));
				if($fuel_allowance_payment)
				{
					foreach ($fuel_allowance_payment as $key => $value) {
						$fual_expence_emp=$fual_expence_emp+$value->total_amount_payable;
					}
				}


        array_push($monthName,$month_name.'-'.$fromyear);
        array_push($commition,$commition_emp);//will be calculate later 2018-09-28
        array_push($phone_bill,$phone_bill_emp);//will be calculate later 2018-09-28
				array_push($basic_salary,$basic_salary_emp);
				array_push($allowance,$allowance_emp);
        array_push($vehical_rent,$vehicle_rent_emp);
				array_push($etf,$etf_emp);
        array_push($epf,$epf_emp);
				array_push($fual_expence,$fual_expence_emp);
				array_push($emp_sum,$commition_emp+$phone_bill_emp+$basic_salary_emp+$allowance_emp+$vehicle_rent_emp+$etf_emp+$epf_emp+$fual_expence_emp);
        $from_date = date("Y-m-d", strtotime("+1 month", strtotime($from_date)));
        $frommonth = date("m",strtotime($from_date));
        $fromyear = date("Y",strtotime($from_date));

      }
//$emp_payroll=$this->hrreport_model->get_emp_payroll(25,'08',date("Y",strtotime('2018-06-01')));
    //print_r($emp_payroll);
		$viewData['emp_payroll'] =$emp_payroll=$this->hrreport_model->get_emp_payroll(25,08,2018);
    $viewData['employee_data'] =$this->employee_model->get_employee_details($employee_id);


    $viewData['monthName'] = $monthName;
    $viewData['basic_salary'] =$basic_salary;
    $viewData['allowance'] =$allowance;
    $viewData['vehical_rent'] =$vehical_rent;
    $viewData['commition'] =$commition;
    $viewData['fual_expence'] =$fual_expence;
    $viewData['etf'] =$etf;
    $viewData['epf'] =$epf;
    $viewData['phone_bill'] =$phone_bill;
		$viewData['emp_sum']=$emp_sum;

		$emp_attendance_report_filter_view = $this->load->view('hr/report/view_emp_expense_details', $viewData, TRUE);
		echo json_encode(['success' => $emp_attendance_report_filter_view]);
		die;
  }

  }
