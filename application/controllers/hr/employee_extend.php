<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee_extend extends CI_Controller {

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
function system_pending_leave_list()
{
	if ( ! check_access('leave_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$data['title'] = "Employee Leave List";

$viewData['employee_list'] = $this->employee_model->get_employee_list();

$viewData['datalist'] = $this->employee_model->get_employee_pendingleave_list();

	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
$this->load->view('includes/topbar_notsearch');
	$this->load->view('hr/employee/emp_leave_list_view_sys', $viewData);
	$this->load->view('includes/footer');
}

function delete_pending_leave()
{
	if ( ! check_access('leave_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id=$this->employee_model->delete_pending_leave($this->uri->segment(4));

	$this->session->set_flashdata('msg', 'Pending Leave Canceled');
	$this->logger->write_message("success", $this->uri->segment(4).'Pending Leave Canceled');
	redirect("hr/employee_extend/system_pending_leave_list");
}

function emp_leave_list_excel_sys()
{
	if ( ! check_access('leave_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$data['title'] = "Employee System Pending Leave List";
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['datalist'] = $this->employee_model->get_employee_pendingleave_list();
	$this->load->view('hr/employee/emp_leave_report_excel_sys', $viewData);
}
/*system pending leave view start*/
}
