<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class emp_qualification extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->helper("hr/constants");
		$this->load->model("hr/common_hr_model");
    	$this->load->model("hr/employee_model");
		$this->load->model("user/user_model");
		$this->load->library('form_validation');
		$this->load->model('paymentvoucher_model');
		$this->load->model("hr/letter_model");
		$this->load->model("hr/config_model");
		$this->load->model("hr/salary_advance_model");
		$this->load->model("hr/qualification_model");
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}


	//ticket no:2969


	function qualification_report()
	{
		$data['title'] = "Employee Qualification Report";
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['branch_list'] = $this->common_hr_model->get_branch_list();

		
		$viewData['divisions'] = $this->common_hr_model->get_division_list();

	$viewData['designation']=$this->common_hr_model->get_designation_list();

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/qualification/qualification_view', $viewData);
			$this->load->view('includes/footer');

			/*$data['val']=$this->qualification_model->get_emp_detailes("196","0001","6","154");

			print_r($data['val']);
			die();*/



     

	}


	function search_qualification()
	{
			$employee = $this->input->post("employee");
			$branchname =$this->input->post("branchname");
		
			$divisionname = $this->input->post("divisionname");
			$desigination=$this->input->post("desigination");

			
			$viewData['employee_details'] = $this->qualification_model->get_emp_detailes($employee,$branchname,$divisionname,$desigination);


			$emp_qualification=$this->load->view('hr/qualification/qualification_view_search', $viewData,TRUE);

	echo json_encode(['success' => $emp_qualification]);
	die;


			

		
	}



	





	





			

		









		
	















}
