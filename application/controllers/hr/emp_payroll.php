<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_payroll extends CI_Controller {

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
		$this->load->model("hr/salary_advance_model");
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

/*employee salary function start*/
	public function employee_salary(){
		if ( ! check_access('employee_salary'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$this->check_salary_changes_effective_from_date();
	$this->check_loan_effective_from_date();

		$data['title'] = "Employee Salary";
		$pending_salary_list =Null;
		$viewData['employee_list'] =$employee_list= $this->employee_model->get_employee_list();
		foreach ($employee_list as $key => $value) {
			$pending_salary_list[$value->id]=$this->employee_model->get_emp_salary_details_by_emp_id($value->id);
		}
		$viewData['pending_salary_list']=$pending_salary_list;
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['allowances'] = $this->common_hr_model->get_allowance_list();
	$viewData['epf_etf'] = $this->common_hr_model->get_epf_etf_list();
	$viewData['deductions'] = $this->common_hr_model->get_deduction_list();
	$viewData['salary_list'] = $this->employee_model->get_employee_salary_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_salary');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_all_emp_salary($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_emp_salary');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_salary_view', $viewData);
		$this->load->view('includes/footer');
	}






	public function edit_emp_salary(){
	if ( ! check_access('employee_salary_edit'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['allowances'] = $this->common_hr_model->get_allowance_list();
	$viewData['epf_etf'] = $this->common_hr_model->get_epf_etf_list();
	$viewData['deductions'] = $this->common_hr_model->get_deduction_list();
	$viewData['details'] = $this->employee_model->get_emp_salary_details($id);

	$this->load->view('hr/payroll/edit_emp_salary_view', $viewData);
	}

	public function define_employee_salary(){
		if ( ! check_access('employee_salary_add'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$employeeMasterID = $this->input->post('emp_id', TRUE);
	$salary_status = $this->input->post('salary_status', TRUE);

	$this->form_validation->set_rules('basic_salary', 'Basic Salary', 'required');
	if($salary_status == "Y"){
		$this->form_validation->set_rules('effective_from', 'Change Valid From', 'required');
	}

	if($this->form_validation->run()){
		if($salary_status == "Y"){
			$this->employee_model->update_employee_salary($employeeMasterID);
		}else if($salary_status == "N"){
			$this->employee_model->define_employee_salary($employeeMasterID);
		}
		$this->session->set_flashdata('msg',"Employee salary updated successfully");
		echo json_encode(['success'=>'Employee salary updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}

	public function employee_salary_confirm(){
		if ( ! check_access('employee_salary_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$salary_id = $_REQUEST['salary_id'];
	$emp_id= $_REQUEST['emp_id'];
	$this->employee_model->confirm_employee_salary($salary_id, $emp_id);
	$this->session->set_flashdata('msg',"Employee salary confirmed successfully");
	echo json_encode(['success'=>'Employee salary confirmed successfully']);
	die();
	}
	public function employee_salary_delete(){
	if ( ! check_access('employee_salary_delete'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$salary_id = $_REQUEST['salary_id'];
	$emp_id= $_REQUEST['emp_id'];
	$this->employee_model->delete_employee_salary($salary_id, $emp_id);
	$this->session->set_flashdata('error',"Employee Pending Salary Deleted Successfully");
	echo json_encode(['success'=>'Employee salary confirmed successfully']);
	die();
	}
	/*employee salary function end*/

/*employee salary change function start*/
	public function employee_salary_changes(){
		if ( ! check_access('employee_salary_changes'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$this->check_salary_changes_effective_from_date();
	$this->check_loan_effective_from_date();
		$data['title'] = "Employee Salary Changes";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['allowances'] = $this->common_hr_model->get_allowance_list();
	$viewData['epf_etf'] = $this->common_hr_model->get_epf_etf_list();
	$viewData['deductions'] = $this->common_hr_model->get_deduction_list();
	$viewData['salary_list'] = $this->employee_model->get_employee_salary_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_salary_changes');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_all_emp_salary_changes($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_emp_salary_changes');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_salary_changes_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function edit_emp_salary_changes(){
	if ( ! check_access('employee_salary_changes'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$change_type = $this->uri->segment(4);
	$hr_emp_salary_changes_id = (int)$this->uri->segment(5);
	$emp_sal_change_details = $this->employee_model->get_emp_salary_changes_details($hr_emp_salary_changes_id);

	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['details'] = $this->employee_model->get_emp_salary_details_by_emp_id($emp_sal_change_details['emp_record_id']);
	$viewData['hr_emp_salary_changes_id'] = $hr_emp_salary_changes_id;

	if($change_type == "salary_increment_decrement_update"){
		$viewData['salary_changes'] = $this->employee_model->get_emp_increment_decrement_changes_details($emp_sal_change_details['relevant_id']);
		$this->load->view('hr/payroll/edit_emp_salary_changes_view', $viewData);
	}else if($change_type == "allowance_update"){
		$viewData['allowances'] = $this->common_hr_model->get_allowance_list();
		$viewData['allowance_changes'] = $this->employee_model->get_emp_allowance_changes_details($emp_sal_change_details['relevant_id']);
		$this->load->view('hr/payroll/edit_emp_allowances_changes_view', $viewData);
	}else if($change_type == "epf_etf_paye_update"){
		$viewData['epf_etf'] = $this->common_hr_model->get_epf_etf_list();
		$viewData['epf_etf_paye_changes'] = $this->employee_model->get_emp_epf_etf_paye_changes_details($emp_sal_change_details['relevant_id']);
		$this->load->view('hr/payroll/edit_emp_epf_etf_paye_changes_view', $viewData);
	}else if($change_type == "deduction_update"){
		$viewData['deductions'] = $this->common_hr_model->get_deduction_list();
		$viewData['deduction_changes'] = $this->employee_model->get_emp_eduction_changes_details($emp_sal_change_details['relevant_id']);
		$this->load->view('hr/payroll/edit_emp_deductions_change_view', $viewData);
	}
	}

	public function confirm_emp_increment_decrement(){
		if ( ! check_access('employee_salary_changes'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$salary_change_id = $this->input->post('salary_change_id', TRUE);
	$emp_id= $this->input->post('emp_id', TRUE);
	$this->employee_model->confirm_emp_increment_decrement($salary_change_id, $emp_id);
	$this->check_salary_changes_effective_from_date();
	$this->session->set_flashdata('msg',"Employee salary increment/decrement update confirmed successfully");
	echo json_encode(['success'=>'Employee salary increment/decrement update confirmed successfully']);
	die();
	}

	public function confirm_emp_allowances(){
		if ( ! check_access('employee_salary_changes'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$allowance_change_id = $this->input->post('allowance_change_id', TRUE);
	$emp_id= $this->input->post('emp_id', TRUE);
	$this->employee_model->confirm_emp_allowances($allowance_change_id, $emp_id);
	$this->check_salary_changes_effective_from_date();
	$this->session->set_flashdata('msg',"Employee allowance update confirmed successfully");
	echo json_encode(['success'=>'Employee allowance update confirmed successfully']);
	die();
	}

	public function confirm_emp_epf_etf_paye(){
		if ( ! check_access('employee_salary_changes'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$epf_etf_paye_change_id = $this->input->post('epf_etf_paye_change_id', TRUE);
	$emp_id= $this->input->post('emp_id', TRUE);
	$this->employee_model->confirm_emp_epf_etf_paye($epf_etf_paye_change_id, $emp_id);
	$this->check_salary_changes_effective_from_date();
	$this->session->set_flashdata('msg',"Employee EPF/ETF/Paye update confirmed successfully");
	echo json_encode(['success'=>'Employee EPF/ETF/Paye update confirmed successfully']);
	die();
	}

	public function confirm_emp_deductions(){
		if ( ! check_access('employee_salary_changes'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$deduction_change_id = $this->input->post('deduction_change_id', TRUE);
	$emp_id= $this->input->post('emp_id', TRUE);
	$this->employee_model->confirm_emp_deductions($deduction_change_id, $emp_id);
	$this->check_salary_changes_effective_from_date();
	$this->session->set_flashdata('msg',"Employee deduction update confirmed successfully");
	echo json_encode(['success'=>'Employee deduction update confirmed successfully']);
	die();
	}

	public function employee_loan(){
		if ( ! check_access('employee_loan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$this->check_loan_effective_from_date();

		$data['title'] = "Employee Loan";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['internal_loans'] = $this->common_hr_model->get_loan_list();
	$viewData['bank_list'] = $this->common_hr_model->get_bank_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_loan');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_all_emp_loan($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_emp_loans');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	    $this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_loan_view', $viewData);
		$this->load->view('includes/footer');
	}
	/*employee salary changes function end*/

	/*employee loan function start*/

	public function employee_loan_update(){
		if ( ! check_access('employee_loan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$employeeMasterID = $this->input->post('emp_id', TRUE);
	$loan_type = $this->input->post('loan_type', TRUE);
	$this->form_validation->set_rules('emp_id', 'Select Employee', 'required');
	if($loan_type == "internal_loan"){
		$this->form_validation->set_rules('internal_loan_id', 'Select Loan', 'required');
		$this->form_validation->set_rules('internal_loan_amount', 'Loan Amount', 'required');
		$this->form_validation->set_rules('internal_instalments', 'Instalments', 'required');
		$this->form_validation->set_rules('internal_loan_start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('internal_monthly_deduction_amount', 'Monthly Deduction Amount', 'required');
	}else if($loan_type == "external_loan"){
		$this->form_validation->set_rules('external_monthly_deduction_amount', 'Monthly Deduction Amount', 'required');
		$this->form_validation->set_rules('external_loan_start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('external_instalments', 'Instalments', 'required');
		$this->form_validation->set_rules('bank_code', 'Bank name', 'required');
		$this->form_validation->set_rules('bank_branch', 'Branch', 'required');
		$this->form_validation->set_rules('account_no', 'Account No.', 'required');
	}
	if($this->form_validation->run()){
		$this->employee_model->update_employee_loan($employeeMasterID);
		$this->session->set_flashdata('msg',"Employee loan updated successfully");
		echo json_encode(['success'=>'Employee loan updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}

	public function edit_emp_loan(){
	if ( ! check_access('employee_loan'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['internal_loans'] = $this->common_hr_model->get_loan_list();
	$viewData['bank_list'] = $this->common_hr_model->get_bank_list();
	$viewData['details'] = $this->employee_model->get_emp_loan_details($id);
	$this->load->view('hr/payroll/edit_emp_loan_view', $viewData);
	}

	public function employee_loan_confirm(){
		if ( ! check_access('employee_loan_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$loan_id = $_REQUEST['loan_id'];
	$this->employee_model->confirm_employee_loan($loan_id);
	$this->check_loan_effective_from_date();
	$this->session->set_flashdata('msg',"Employee loan confirmed successfully");
	echo json_encode(['success'=>'Employee loan confirmed successfully']);
	die();
	}
	/*employee loan function end*/

	/*emp loan delete start*/
	function emp_loan_delete(){
	if ( ! check_access('employee_loan_delete'))
	{
	$this->session->set_flashdata('error', 'Permission Denied');
	redirect('menu_call/showdata/hr');
	return;
	}
	$id=$this->employee_model->emp_loan_delete($this->uri->segment(4));

	$this->session->set_flashdata('msg', 'Loan Deactivated');
	$this->logger->write_message("success", $this->uri->segment(4).'Loan Deactivated');
	redirect("hr/emp_payroll/employee_loan");
	}
	/*emp loan delete end*/

/*employee tranfers start*/
	public function employee_transaction(){
		if ( ! check_access('employee_transaction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Employee Transaction";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['leave_category_list'] = $this->common_hr_model->get_leave_category_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_transaction');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_all_emp_transactions($pagination_counter, $page_count);

	$config['total_rows'] = $this->db->count_all('hr_emp_transaction');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	    $this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_transaction_view', $viewData);
		$this->load->view('includes/footer');
	}
	/*employee tranfers end*/

	public function get_employement_details(){

	$branch = $_REQUEST['branch'];
	$data['branch'] = $this->common_hr_model->get_branch_details($branch);
	$division = $_REQUEST['division'];
	$data['division'] = $this->common_hr_model->get_division_details($division);
	$designation = $_REQUEST['designation'];
	$data['designation'] = $this->common_hr_model->get_designation_details($designation);
	$employment_type = $_REQUEST['employment_type'];
	$data['employment_type'] = $this->common_hr_model->get_employment_type_details($employment_type);
	if(isset($_REQUEST['leave_category'])){
		$leave_category = $_REQUEST['leave_category'];
		$data['leave_category'] = $this->common_hr_model->get_leave_category_details($leave_category);
	}
	echo json_encode($data);
	die();
	}

	public function get_employee_salary_details(){
	$emp_id = $_REQUEST['emp_id'];
	$data['employee_salary'] = $this->employee_model->get_employee_salary_details($emp_id);
	$data['employee_allowances'] = $this->employee_model->get_employee_allowances_details($emp_id);
	$data['employee_deductions'] = $this->employee_model->get_employee_deductions_details($emp_id);
	echo json_encode($data);
	die();
	}

/*employee tranfers start*/
	public function employee_transfer_update(){
	$employeeMasterID = $this->input->post('emp_id', TRUE);
	$transfer_type = $this->input->post('transfer_type', TRUE);
    $confirm_manager_id = $this->input->post('confirm_manager_id',TRUE);

	if($transfer_type == "division_only"){
		$this->form_validation->set_rules('new_division', 'Transfer To - Division', 'required');
	}else if($transfer_type == "branch_and_division"){
		$this->form_validation->set_rules('new_branch', 'Transfer To - Branch', 'required');
		$this->form_validation->set_rules('new_division', 'Transfer To - Division', 'required');
	}else if($transfer_type == "branch_only"){
		$this->form_validation->set_rules('new_branch', 'Transfer To', 'required');
	}
	$this->form_validation->set_rules('transfer_date', 'Transfer Valid From', 'required');

	if($this->form_validation->run()){
    //    $check_transfer_confirm_manager = $this->employee_new_model->check_tranfer_confirm_manager($confirm_manager_id);

		$this->employee_model->update_employee_transfer($employeeMasterID);
		$this->session->set_flashdata('msg',"Employee transfer updated successfully");
		echo json_encode(['success'=>'Employee transfer updated successfully']);




	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();

	}

	public function get_employee_details(){
	$emp_id = $_REQUEST['emp_id'];
	$data['employee_details'] = $this->employee_model->get_employee_details($emp_id);
	echo json_encode($data);
	die();
	}

	public function employee_promotion_update(){
		if ( ! check_access('employee_transaction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$employeeMasterID = $this->input->post('emp_id', TRUE);
	$this->form_validation->set_rules('promotion_type', 'Promotion Type', 'required');
	$this->form_validation->set_rules('new_designation', 'New Designation', 'required');
	$this->form_validation->set_rules('promotion_date', 'Changes Valid From', 'required');

	if($this->form_validation->run()){
		$this->employee_model->update_employee_promotion($employeeMasterID);
		$this->session->set_flashdata('msg',"Employee designation updated successfully");
		echo json_encode(['success'=>'Employee designation updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}
	/*employee tranfers start*/

	/*payroll function start*/

	public function check_salary_changes_effective_from_date(){
	$this->employee_model->validate_employee_salary_effective_from_date();
	}

	public function check_loan_effective_from_date(){
	$this->employee_model->validate_employee_loan_effective_from_date();
	}

	public function employee_payroll(){
		if ( ! check_access('payroll_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$this->check_salary_changes_effective_from_date();
	$this->check_loan_effective_from_date();

		$data['title'] = "Employee Payroll";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_payroll');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_payroll_master_list($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_payroll_master');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_payroll_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function run_monthly_payroll(){
		if ( ! check_access('payroll_run'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$this->form_validation->set_rules('year', 'Year', 'required');
	$this->form_validation->set_rules('month', 'Month', 'required');

	if($this->form_validation->run()){
		$year = $this->input->post('year', TRUE);
		$month = $this->input->post('month', TRUE);
		$date = $year."-".$month;
		if(date("Y-m", strtotime($date)) > date("Y-m")){
			$errors = "<br>System Does NOT allow to generate paysheets for future months";
						echo json_encode(['error'=>$errors]);
			die();
		}
		$year_month_validation = $this->employee_model->check_emp_payroll_master_year_month($year, $month);
		if(count($year_month_validation)>0){
			$errors = "<br>System Does NOT allow to regenerate paysheets";
						echo json_encode(['error'=>$errors]);
			die();
		}

		$payroll_status = $this->employee_model->run_monthly_payroll();
		//echo $payroll_status["error_message"];
		$this->session->set_flashdata('msg',"Payroll updated successfully");
		echo json_encode(['success'=>'Payroll updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}



	public function decline_monthly_payroll(){
		if ( ! check_access('payroll_run'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$id = $this->uri->segment(4);
	$this->employee_model->decline_monthly_payroll($id);
	$this->session->set_flashdata('msg',"Payroll decline successfully");
	redirect('hr/emp_payroll/employee_payroll');
	}



	public function emp_payroll_list(){
	if ( ! check_access('payroll_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['details'] = $this->employee_model->get_emp_payroll_master_details($id);
	$viewData['payroll_list'] = $this->employee_model->get_emp_payroll_list($id);
	$viewData['allowance_list'] = $this->common_hr_model->get_allowance_list();
	$viewData['insentive_list'] = $this->common_hr_model->get_insentive();
	$viewData['deduction_list'] = $this->common_hr_model->get_deduction_list();
	$viewData['other_deduction_list'] = $this->common_hr_model->get_otherdeduction_list();

	$viewData['allowance_bra'] = $this->common_hr_model->get_allowance_bra(); //edit by dileep
	$this->load->view('hr/payroll/emp_payroll_list_view', $viewData);
	}

	public function employee_payroll_list_confirm(){
		if ( ! check_access('payroll_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$record_id = $_REQUEST['record_id'];
	$this->employee_model->confirm_employee_payroll_list($record_id);
	$this->session->set_flashdata('msg',"Payroll confirmed successfully");
	echo json_encode(['success'=>'Payroll confirmed successfully']);
	die();
	}
	/*payroll function end*/

	/*print pay slip*/
	function print_payslip(){
	if ( ! check_access('print_payslip'))
	{
	$this->session->set_flashdata('error', 'Permission Denied');
	redirect('menu_call/showdata/hr');
	return;
	}
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['payroll']=$this->employee_model->emp_payroll_master_active();
	$this->load->view('includes/header_'.$this->session->userdata('usermodule'));
	$this->load->view('includes/topbar_notsearch');
	$this->load->view('hr/payroll/payslip_print',$viewData);
	$this->load->view('includes/footer');
	}
	function print_payslip_all(){
	if ( ! check_access('print_payslip'))
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
	$this->load->view('hr/payroll/payslip_print_all',$viewData);
	}
	/*print payslip end*/

	/*no pay leave sheet*/
	public function employee_no_pay_leave_list(){
	if ( ! check_access('no_pay_leave_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
		$data['title'] = "Employee No Pay Leave List";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_no_pay_leave_list');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_no_pay_leave_master_list($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_no_pay_leave_master');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	    $this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_no_pay_leave_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function get_no_pay_list_by_year_month(){
		if ( ! check_access('no_pay_leave_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$year = $_REQUEST['year'];
	$month = $_REQUEST['month'];
	$emp_no_pay_list_by_year_month = $this->employee_model->get_no_pay_list_by_year_month($year, $month);
	echo json_encode($emp_no_pay_list_by_year_month);
	die();
	}

	public function submit_no_pay_leave_list(){
	if ( ! check_access('no_pay_leave_create'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$this->form_validation->set_rules('year', 'Year', 'required');
	$this->form_validation->set_rules('month', 'Month', 'required');

	if($this->form_validation->run()){
		$year = $this->input->post('year', TRUE);
		$month = $this->input->post('month', TRUE);
		$date = $year."-".$month;
		if(date("Y-m", strtotime($date)) > date("Y-m")){
			$errors = "<br>System Does NOT allow to generate no pay leave sheet for future months";
						echo json_encode(['error'=>$errors]);
			die();
		}
		$year_month_validation = $this->employee_model->check_emp_no_pay_leave_master_year_month($year, $month);
		if(count($year_month_validation)>0){
			$errors = "<br>System Does NOT allow to regenerate no pay leave sheet";
						echo json_encode(['error'=>$errors]);
			die();
		}

		$monthly_no_pay_count = $this->employee_model->submit_no_pay_leave_list();
		$this->session->set_flashdata('msg',"No pay leave sheet updated successfully");
		echo json_encode(['success'=>'No pay leave sheet updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}
	public function edit_no_pay_leave_list(){
		if ( ! check_access('no_pay_leave_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$monthly_no_pay_count = $this->employee_model->edit_no_pay_leave_list();
		if($monthly_no_pay_count){
			$this->session->set_flashdata('msg',"No pay leave sheet updated successfully");
			echo json_encode(['success'=>'No pay leave sheet updated successfully']);
		}else{
			echo json_encode(['error'=>$errors]);
				}
		die();
		}

	public function emp_no_pay_list_list(){
	if ( ! check_access('no_pay_leave_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['details'] = $this->employee_model->get_emp_no_pay_master_details($id);
	$viewData['no_pay_list'] = $this->employee_model->get_emp_no_pay_list($id);
	$this->load->view('hr/payroll/emp_no_pay_list_view', $viewData);
	}
	public function emp_no_pay_list_confirmed(){
	if ( ! check_access('no_pay_leave_confirm'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['details'] = $this->employee_model->get_emp_no_pay_master_details($id);
	$viewData['no_pay_list'] = $this->employee_model->get_emp_no_pay_list($id);
	$this->load->view('hr/payroll/emp_no_pay_list_confirmed', $viewData);
	}

	public function employee_no_pay_leave_confirm(){
		if ( ! check_access('no_pay_leave_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$record_id = $_REQUEST['record_id'];
	$this->employee_model->confirm_employee_no_pay_leave($record_id);
	$this->session->set_flashdata('msg',"No Pay Leave List confirmed successfully");
	echo json_encode(['success'=>'No Pay Leave List confirmed successfully']);
	die();
	}
	/*no pay leave sheet end*/

	/*salary advance sheet*/
	public function employee_salary_advance(){
	if ( ! check_access('salary_advance_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
		$data['title'] = "Employee Salary Advance";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_salary_advance');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_salary_advance_master_list($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_emp_salary_advance_master');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_salary_advance_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function submit_salary_advance_list(){
	if ( ! check_access('salary_advance_create'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$this->form_validation->set_rules('year', 'Year', 'required');
	$this->form_validation->set_rules('month', 'Month', 'required');

	if($this->form_validation->run()){
		$year = $this->input->post('year', TRUE);
		$month = $this->input->post('month', TRUE);
		$date = $year."-".$month;
		if(date("Y-m", strtotime($date)) > date("Y-m")){
			$errors = "<br>System Does NOT allow to generate salary advance sheet for future months";
						echo json_encode(['error'=>$errors]);
			die();
		}
		$year_month_validation = $this->employee_model->check_emp_salary_advance_master_year_month($year, $month);
		if(count($year_month_validation)>0){
			$errors = "<br>System Does NOT allow to regenerate salary advance sheet";
						echo json_encode(['error'=>$errors]);
			die();
		}

		$monthly_no_pay_count = $this->employee_model->submit_salary_advance_list();
		$this->session->set_flashdata('msg',"Salary advance sheet updated successfully");
		echo json_encode(['success'=>'Salary advance sheet updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}

	public function emp_salary_advance_list(){
	if ( ! check_access('salary_advance_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['details'] = $this->employee_model->get_emp_salary_advance_master_details($id);
	$viewData['salary_advance_list'] = $this->employee_model->get_emp_salary_advance_list($id);
	$this->load->view('hr/payroll/emp_salary_advance_list_view', $viewData);
	}

	public function employee_salary_advance_confirm(){
		if ( ! check_access('salary_advance_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$record_id = $_REQUEST['record_id'];
	$this->employee_model->confirm_employee_salary_advance($record_id);
	$this->session->set_flashdata('msg',"Salary Advance List confirmed successfully");
	echo json_encode(['success'=>'Salary Advance List confirmed successfully']);
	die();
	}

	public function emp_salary_advance_edit(){
	if ( ! check_access('salary_advance_edit'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$salary_advance_details = $this->employee_model->get_emp_salary_advance_details($id);
	$viewData['salary_advance_details'] = $salary_advance_details;
	$details = $this->employee_model->get_emp_salary_advance_master_details($salary_advance_details['salary_advance_master_id']);
	if($details['status'] == "Y"){
		$this->session->set_flashdata('msg', 'Confirmed Salary advance amount cannot be updated');
		redirect("hr/emp_payroll/employee_salary_advance");
	}
	$this->load->view('hr/payroll/emp_salary_advance_edit_view', $viewData);
	}

	public function update_emp_salary_advance_amount(){
	if ( ! check_access('salary_advance_edit'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$this->employee_model->update_emp_salary_advance_amount();
	$this->session->set_flashdata('msg', 'Salary advance amount successfully updated');
	redirect("hr/emp_payroll/employee_salary_advance");
	}
/*salary advance sheet end*/

	//2018-11-13
	/*add employee phone bill start*/
	public function employee_phonebill_list(){
	if ( ! check_access('emp_phonebill_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
		$data['title'] = "Employee Phone Bill Payment List";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/emp_payroll/employee_phonebill_list');
	$config['uri_segment'] = 4;

	$pagination_counter = RAW_COUNT;
	$config['num_links'] = 10;
	$config['per_page'] = $pagination_counter;
	$config['full_tag_open'] = '<ul id="pagination-flickr">';
	$config['full_close_open'] = '</ul>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active">';
	$config['cur_tag_close'] = '</li>';
	$config['next_link'] = 'Next &#187;';
	$config['next_tag_open'] = '<li class="next">';
	$config['next_tag_close'] = '</li>';
	$config['prev_link'] = '&#171; Previous';
	$config['prev_tag_open'] = '<li class="previous">';
	$config['prev_tag_close'] = '</li>';
	$config['first_link'] = 'First';
	$config['first_tag_open'] = '<li class="first">';
	$config['first_tag_close'] = '</li>';
	$config['last_link'] = 'Last';
	$config['last_tag_open'] = '<li class="last">';
	$config['last_tag_close'] = '</li>';
	$startcounter = ($page_count)*$pagination_counter;
	$viewData['datalist'] = $this->employee_model->get_phone_bill_master_list($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_phonebill_master');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/payroll/emp_phonebill_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function submit_phonebill_list(){
		if ( ! check_access('emp_phonebill_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->form_validation->set_rules('year', 'Year', 'required');
		$this->form_validation->set_rules('month', 'Month', 'required');

		if($this->form_validation->run()){
			$year = $this->input->post('year', TRUE);
			$month = $this->input->post('month', TRUE);
			$date = $year."-".$month;
			if(date("Y-m", strtotime($date)) > date("Y-m")){
				$errors = "<br>System Does NOT allow to generate salary advance sheet for future months";
							echo json_encode(['error'=>$errors]);
				die();
			}
			$year_month_validation = $this->employee_model->check_emp_phonebill_master_year_month($year, $month);
			if(count($year_month_validation)>0){
				$errors = "<br>System Does NOT allow to regenerate phone bill payment sheet";
							echo json_encode(['error'=>$errors]);
				die();
			}

			$monthly_no_pay_count = $this->employee_model->submit_phonebill_list();
			$this->session->set_flashdata('msg',"Employee Phone Bill Payment updated successfully");
			echo json_encode(['success'=>'Employee Phone Bill Payment updated successfully']);
		}else{
			$errors = validation_errors();
						echo json_encode(['error'=>$errors]);
				}
		die();
		}
		public function employee_phonebill_confirm(){
			if ( ! check_access('emp_phonebill_confirm'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
		$record_id = $_REQUEST['record_id'];
		$this->employee_model->confirm_phone_bill_payment($record_id);
		$this->session->set_flashdata('msg',"Employees Phone Bill Payment Confirmed Successfully");
		echo json_encode(['success'=>'Employees Phone Bill Payment Confirmed Successfully']);
		die();
	}
	public function decline_monthly_phonebill(){
		if ( ! check_access('emp_phonebill_delete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->employee_model->decline_monthly_phonebill($id);
		$this->session->set_flashdata('msg',"phone Bill Payment  decline successfully");
		redirect('hr/emp_payroll/employee_phonebill_list');
	}
	public function emp_phonebill_paymentlist(){
		if ( ! check_access('emp_phonebill_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = (int)$this->uri->segment(4);
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['details'] = $this->employee_model->get_emp_phonebill_master_details($id);
		$viewData['salary_advance_list'] = $this->employee_model->get_emp_phonebill_list($id);
		$this->load->view('hr/payroll/emp_phonebill_list_view', $viewData);
	}

	public function emp_phonebill_excel()
	{
		if ( ! check_access('emp_phonebill_delete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Employee Leave List";
		$id = (int)$this->uri->segment(4);
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['details'] = $this->employee_model->get_emp_phonebill_master_details($id);
		$viewData['phonebill_list'] = $this->employee_model->get_emp_phonebill_list($id);
		$this->load->view('hr/payroll/emp_phonebill_excel', $viewData);
	}
	/*add employee phone bill end*/

	public function decline_monthly_nopay_list(){
		if ( ! check_access('payroll_run'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$id = $this->uri->segment(4);
	$this->employee_model->decline_monthly_nopay_list($id);
	$this->session->set_flashdata('msg',"Nopay sheet decline successfully");
	redirect('hr/emp_payroll/employee_no_pay_leave_list');
	}

	public function decline_monthly_salary_advance(){
		if ( ! check_access('payroll_run'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$id = $this->uri->segment(4);
	$this->employee_model->decline_monthly_salary_advance($id);
	$this->session->set_flashdata('msg',"Salary Advance sheet decline successfully");
	redirect('hr/emp_payroll/employee_salary_advance');
	}



	//Ticket 1575 Bilani 2020-07-29
	public function employee_leave_category_update(){
		$employeeMasterID = $this->input->post('emp_id', TRUE);
		$this->form_validation->set_rules('new_leave_profile', 'New Leave Category', 'required');
		$this->form_validation->set_rules('leave_trans_date', 'Changes Valid From', 'required');

		if($this->form_validation->run()){
			$this->employee_model->update_employee_leave_category($employeeMasterID);
			$this->session->set_flashdata('msg',"Employee leave category updated successfully");
			echo json_encode(['success'=>'Employee leave category updated successfully']);
		}else{
			$errors = validation_errors();
            echo json_encode(['error'=>$errors]);
      	}
		die();
  	}

  	public function employee_employment_type_update(){
		$employeeMasterID = $this->input->post('emp_id', TRUE);
		$employment_type_transaction = $this->input->post('employment_type_transaction', TRUE);
		if($employment_type_transaction == "employement_type_only"){
			$this->form_validation->set_rules('new_employement_type', 'New Employement Type', 'required');
		}else if($employment_type_transaction == "employement_type_and_duration"){
			$this->form_validation->set_rules('new_employement_type', 'New Employement Type', 'required');
			$this->form_validation->set_rules('new_duration', 'New Duration (months)', 'required');
		}else if($employment_type_transaction == "duration_only"){
			$this->form_validation->set_rules('new_duration', 'New Duration (months)', 'required');
		}
		$this->form_validation->set_rules('employment_type_date', 'Valid From', 'required');

		if($this->form_validation->run()){
			$this->employee_model->update_employee_employment_type($employeeMasterID);

			//Ticket 1575 Bilani 2020-07-29
			 $employment_type_transaction = $this->input->post('employment_type_transaction', TRUE);
			 $current_employement_type = $this->input->post('current_employement_type_val', TRUE);
			$new_employement_type = $this->input->post('new_employement_type', TRUE);
			$employment_type_date=$this->input->post('employment_type_date', TRUE);
			$employee_details = $this->employee_model->get_employee_details($employeeMasterID);
			$basic_salary=$employee_details['basic_salary'];

			if(($employment_type_transaction == "employement_type_only") || ($employment_type_transaction == "employement_type_and_duration")){
				if(($current_employement_type!=$new_employement_type) && $new_employement_type!=3){
					$this->print_job_confirmation_letter($employeeMasterID,$employment_type_date,$basic_salary);
				}
			}
			//Ticket 1575 Bilani 2020-07-29 end

			$this->session->set_flashdata('msg',"Employement Type updated successfully");
			echo json_encode(['success'=>'Employement Type updated successfully']);

		}else{
			$errors = validation_errors();
            echo json_encode(['error'=>$errors]);
      	}
		die();

  	}

	  //UPDATE employee_resignation_update TO DELETE USER ACCOUNT WHEN RESIGN [ Updated By Andrei 2021 FEB 14 ]

  	public function employee_resignation_update(){
		$employeeMasterID = $this->input->post('emp_id', TRUE);
		$this->form_validation->set_rules('resignation_trans_date', 'Resignation Valid From', 'required');

		if($this->form_validation->run()){
			$resignation_confirm_manager = $this->input->post('resignation_trans_date', TRUE);


			$this->employee_model->update_employee_resignation($employeeMasterID);

			//Ticket 1575 Bilani 2020-07-29
			$resignation_trans_date = $this->input->post('resignation_trans_date', TRUE);
			$payment = $this->input->post('gratuity_val', TRUE);
			//$this->print_termination_letter($employeeMasterID,$resignation_trans_date,$payment);
			//Ticket 1575 Bilani 2020-07-29 - End

			$this->session->set_flashdata('msg',"Employee resignation updated successfully");
			echo json_encode(['success'=>'Employee resignation updated successfully']);
		}else{
			$errors = validation_errors();
            echo json_encode(['error'=>$errors]);
      	}
		die();

  	}

  	//Ticket 1575 Bilani 2020-07-29
  	public function print_job_confirmation_letter ($employee_id,$employment_type_date,$basic_salary){
    //$id = $confirm_id;
        $empdetails = $this->employee_model->get_employee_details($employee_id);
        //$salary=$this->salary_advance_model->check_basic_salary($employee_id);

   $title = "";
   if($empdetails['title']==0){
    $title = "Mr";
   }else if($empdetails['title']==1){
    $title = "Mrs";
   }else if($empdetails['title']==2){
    $title = "Ms";
   }else if($empdetails['title']==3){
    $title = "Miss";
   }else if($empdetails['title']==4){
    $title = "Dr.";
   }else if($empdetails['title']==5){
    $title = "Prof.";
   }else if($empdetails['title']==6){
    $title = "Rev";
   }else if($empdetails['title']==7){
    $title = "Father";
   }else if($empdetails['title']==8){
    $title = "Sister";
   }


   $html = '<div class="row"  >
<div  style="padding-left:50px; font-size:15px; width:640px; ">
   <div style="height: 1.00in;"></div>'.date("F j, Y").'<br><br><br><br><br>
    '.$title." ".$employee_details['initial']." ".$empdetails['surname'].',<br><br><br>
    <strong><u>Job Confirmation Letter </u></strong><br><br>

    <p>We are pleased with your performance with us since joining as part of '.companyname.' . We are happy to have you in our growing family of '.companyname.'. We take pleasure in informing you that your services has been Confirmed with effect from '.$employment_type_date.'. Also, your salary has been revised to '.$basic_salary.'. All the other terms and conditions remain unaltered. We look forward to your continued dedicated performance. Please intimate your acceptance by signing this letter in duplicate and return this letter to the Human Resources department.</p><br><br><br>

    Sincerely,<br><br><br>
    .................<br>
    Managing Director
   ';





    $date = date('Y-m-d H-i-s');
         $filename = $empdetails['emp_no'].'_'.$date.'job_confirmation_letter.pdf';
         $pdfroot = "./pdfs/job_confirmation_letter/".$filename;
         $fileroot = "pdfs/job_confirmation_letter/".$filename;

         //insert letter data ..
   $data_letter['emp_id']=$empdetails['id'];
   $data_letter['letter_type']=3;
   $data_letter['date']=date("Y-m-d");
   $data_letter['file']=$fileroot;
   $this->letter_model->insert_letter($data_letter);

        // Load library
        $this->load->library('dompdf_gen');
        // Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        //$this->dompdf->stream("welcome.pdf");
        $pdf_string =   $this->dompdf->output();
        file_put_contents($pdfroot, $pdf_string );
    }


    function print_termination_letter ($employee_id,$resignation_trans_date,$payment){
        $empdetails = $this->employee_model->get_employee_details($employee_id);

	   $title = "";
	   if($empdetails['title']==0){
	    $title = "Mr";
	   }else if($empdetails['title']==1){
	    $title = "Mrs";
	   }else if($empdetails['title']==2){
	    $title = "Ms";
	   }else if($empdetails['title']==3){
	    $title = "Miss";
	   }else if($empdetails['title']==4){
	    $title = "Dr.";
	   }else if($empdetails['title']==5){
	    $title = "Prof.";
	   }else if($empdetails['title']==6){
	    $title = "Rev";
	   }else if($empdetails['title']==7){
	    $title = "Father";
	   }else if($empdetails['title']==8){
	    $title = "Sister";
	   }


	   $html = '<div class="row"  >
	<div  style="padding-left:50px; font-size:15px; width:640px; ">
	   <div style="height: 1.00in;"></div>'.date("F j, Y").'<br><br>
	   '.$title." ".$empdetails['surname'].',<br><br><br>
	    <strong><u>Employee Termination Letter </u></strong><br><br>
	    '.$empdetails['initial']." ".$empdetails['surname'].'<br><br>

	    <p>This employment termination letter is to inform you that your employment with '.companyname.' will end as of '.$resignation_trans_date.'. This decision cannot be changed.</p><br>
	    <p>You will receive your final paycheck for this month and payment for remaining leave today. Once you have signed and returned the attached release of claims document, you will receive a Rs.'.$payment.' severance payment.</p><br>
	    <p>You are requested to return the company laptop, swipe card, and cell phone before the end of the day.</p><br>
	    <p>Also, keep in mind that you have signed a confidentiality agreement. Please review the attached copy.</p><br>
	    <p>If you have questions about policies you have signed, your compensation, benefits, or returning company property, please contact (contact name, typically someone from HR, with contact info)</p><br>
	    <br>
	    Yours, <br><br><br>
	    .....................<br>
	    ';





	    $date = date('Y-m-d H-i-s');
	         $filename = $empdetails['emp_no'].'_'.$date.'termination_letter.pdf';
	         $pdfroot = "./pdfs/termination_letter/".$filename;
	         $fileroot = "pdfs/termination_letter/".$filename;

	         //insert letter data ..
	   $data_letter['emp_id']=$empdetails['id'];
	   $data_letter['letter_type']=4;
	   $data_letter['date']=date("Y-m-d");
	   $data_letter['file']=$fileroot;
	   $this->letter_model->insert_letter($data_letter);

	        // Load library
	        $this->load->library('dompdf_gen');
	        // Convert to PDF
	        $this->dompdf->load_html($html);
	        $this->dompdf->render();
	        //$this->dompdf->stream("welcome.pdf");
	        $pdf_string =   $this->dompdf->output();
	        file_put_contents($pdfroot, $pdf_string );

	        return;
    }


	//Ticket 1575 Bilani 2020-07-29 - End
}
