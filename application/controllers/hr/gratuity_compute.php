<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gratuity_compute extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
		$this->load->model('paymentvoucher_model');
		$this->load->model('hr/gratuity_compute_model');

    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}


/*gratuity ledger config*/
//hr/Gratuity_compute/gratuity_legers
function gratuity_legers()
{
	if ( ! check_access('hr_ledger'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$viewData['gratuityleger'] = $this->gratuity_compute_model->get_gratuityleger();
	$this->load->view('includes/header_'.$this->session->userdata('usermodule'));
	$this->load->view('includes/topbar_notsearch');
	$this->load->view('hr/config/hr_ledgers',$viewData);
	$this->load->view('includes/footer');
}

function update_ledger()
{
	if ( ! check_access('hr_ledger'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$add_legers= $this->gratuity_compute_model->update_ledger();
	if($add_legers){
		$this->session->set_flashdata('msg', 'HR ledgers successfully updated');
		redirect('hr/Gratuity_compute/gratuity_legers');
	}else{
		$this->session->set_flashdata('error', 'Something went wrong');
		redirect('menu_call/showdata/hr');
		return;
	}
}
//http://localhost/firstteamnew/hr/Gratuity_compute/compute_gratuity/2014-09-01
//this is for cron
function compute_gratuity()
{
	$this->gratuity_compute_model->compute_gratuity(date('Y-m-d'));
}

public function get_employement_details(){

//call when employee resign in employee transfer view
$emp_id = $_REQUEST['emp_id'];
$data =$gratuity= $this->gratuity_compute_model->get_last_gratuity_data($emp_id);
//print_r($gratuity);
echo json_encode($data);
die();
}

public function calc_gratuity_fordate()
{
	//call when employee resign in employee transfer view
	$emp_id = $_REQUEST['emp_id'];
	$date = $_REQUEST['date_val'];
	//$date =date('Y-m-d',$date);
	$this_year=date('Y', strtotime($date));
	$employee=$this->gratuity_compute_model->get_alagible_employee_byemp($date,$emp_id);
	if($employee){
		$join_year=date('Y',strtotime($employee->joining_date));
		$year_diff=$this_year-$join_year;//get amount of service years
		$salary=$employee->basic_salary;//get employee basic salary
		$gratuity_rate=$employee->gratuity;//get employee gratuity
		$data['total_gratuity']=$gratuity_val=$salary*($gratuity_rate/100)*$year_diff;
		$gratuityleger=$this->gratuity_compute_model->get_gratuityleger();
		$data['cr_account']=$gratuityleger->cr_acc;


		//echo $employee->emp_no."  ".$salary." X ".($gratuity_rate/100)." * ".$year_diff." = ". $gratuity_val."<br>";
		echo json_encode($data);
		die();
	}else{
		$data['total_gratuity']='';
		$data['cr_account']='';
		echo json_encode($data);
		die();
	}



}

/*gratuity report employee vise*/
function report_emp_view()
{
	if ( ! check_access('gratuity_report'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$viewData['gratuity'] = $this->gratuity_compute_model->get_report_emp_view();
	$this->load->view('includes/header_'.$this->session->userdata('usermodule'));
	$this->load->view('includes/topbar_notsearch');
	$this->load->view('hr/report/gratuity_report',$viewData);
	$this->load->view('includes/footer');
}

//this is for cron
function update_employee_resignation_fordate()
{
		$this->gratuity_compute_model->update_employee_resignation_fordate(date('Y-m-d'));
		//$this->gratuity_compute_model->update_employee_resignation_fordate($date);
}

}
