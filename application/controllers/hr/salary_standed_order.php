<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_standed_order extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
		$this->load->model('paymentvoucher_model');
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}


/*system pending leave view start*/
function standed_order_forpayroll()
{
	if ( ! check_access('payroll_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['payroll']=$this->employee_model->emp_payroll_master_active();
	$this->load->view('includes/header_'.$this->session->userdata('usermodule'));
	$this->load->view('includes/topbar_notsearch');
	$this->load->view('hr/stand_orders/standed_orders_print',$viewData);
	$this->load->view('includes/footer');
}
	function print_stand_orders()
	{
		if ( ! check_access('print_standorders'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = (int)$this->uri->segment(4);
		$viewData['emp']=$emp=$this->uri->segment(5);
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['details'] = $this->employee_model->get_emp_payroll_master_details($id);
		$viewData['payroll_list'] = $this->employee_model->get_emp_payroll_list($id);
		$viewData['allowance_list'] = $this->common_hr_model->get_allowance_list();
		$viewData['deduction_list'] = $this->common_hr_model->get_deduction_list();
		$this->load->view('hr/employee/payslip_print_all',$viewData);
	}



}
