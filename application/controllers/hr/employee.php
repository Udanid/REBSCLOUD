<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller {

	private $_vaildateOlResults = NULL;
	private $_vaildateAlResults = NULL;
	private $_validateHigherEducation = NULL;
	private $_validateWorkExperience = NULL;

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

		$this->load->model("hr/employee_new_model");
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

  	public function create(){
			if ( ! check_access('employee_create'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
    	$data['title'] = "Create Employee";
		$viewData['countryList'] = countryList(); //country list derived from constants helper
    	$viewData['title'] = title(); //title
    	$viewData['bloodGroup'] = bloodGroup(); //blood groups
    	$viewData['province'] = province(); //provinces
    	$viewData['maritalStatus'] = maritalStatus();

		$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
		$viewData['branches'] = $this->common_hr_model->get_branch_list();
		$viewData['divisions'] = $this->common_hr_model->get_division_list();
		$viewData['designations'] = $this->common_hr_model->get_designation_list();
		$viewData['bank_list'] = $this->common_hr_model->get_bank_list();
		$viewData['leave_category_list'] = $this->common_hr_model->get_leave_category_list();
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['fuel_allowance_vehicle_type_list'] = $this->common_hr_model->get_fuel_allowance_vehicle_type_list();
		$viewData['user_privilege_list'] = $this->common_hr_model->get_user_privilege_list();

    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('hr/employee/create_emp_view', $viewData);
    	$this->load->view('includes/footer');
  	}

  	public function submission(){
			if ( ! check_access('employee_create'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}

			$update_status = $this->employee_model->add_employee();
			if($update_status){
				$this->session->set_flashdata('msg',"Employee added successfully");

				redirect("hr/employee/add_emp_other_data/".$update_status);
			}else{
				$this->session->set_flashdata('error',"Something Went Wrong... Please Try Again");
				redirect("hr/employee/create");
			}

	}

	public function employee_list(){
		if ( ! check_access('employee_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(4);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('hr/employee/employee_list');
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
		$data['datalist'] = $this->employee_model->get_all_employee_details($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_empmastr');
		$this->pagination->initialize($config);

      	$data1['title'] = "Employee List";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/employee/list_emp_view', $data);
      	$this->load->view('includes/footer');
	}

	//delete employee from pending list
	public function delete_employee(){
		if ( ! check_access('employee_delete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$emp_id = $this->uri->segment(4);
		$employee_details = $this->employee_model->get_employee_details($emp_id);
		if($employee_details['status'] == "P"){
			$this->employee_model->delete_employee($emp_id);
			$this->session->set_flashdata('msg',"Employee deleted successfully");
			redirect(base_url('hr/employee/employee_list'));
		}else{
			redirect(base_url('hr/employee/employee_list'));
		}
	}

	public function edit(){
		if ( ! check_access('employee_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Edit Employee";
	$employee_id = (int)$this->uri->segment(4);
	$employee_details = $this->employee_model->get_employee_details($employee_id);
	//if($employee_details['status'] != "P"){
		//redirect(base_url('hr/employee/employee_list'));
	//}
	$viewData['employee_details'] = $employee_details;
	$viewData['emergnecy_contact_details'] = $this->employee_model->get_emergnecy_contact_details($employee_id);
	$viewData['bank_details'] = $this->employee_model->get_bank_details($employee_id);
	$viewData['insurance_details'] = $this->employee_model->get_insurance_details($employee_id);


	$viewData['countryList'] = countryList(); //country list derived from constants helper
		$viewData['title'] = title(); //title
		$viewData['bloodGroup'] = bloodGroup(); //blood groups
		$viewData['province'] = province(); //provinces
		$viewData['maritalStatus'] = maritalStatus();

	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['bank_list'] = $this->common_hr_model->get_bank_list();
	$viewData['leave_category_list'] = $this->common_hr_model->get_leave_category_list();
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['fuel_allowance_vehicle_type_list'] = $this->common_hr_model->get_fuel_allowance_vehicle_type_list();
	$viewData['user_privilege_list'] = $this->common_hr_model->get_user_privilege_list();

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/edit_emp_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function update_submit(){
		if ( ! check_access('employee_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$employeeMasterID = $this->input->post('employeeMasterID', TRUE);

		$update_status = $this->employee_model->update_employee_details();
		if($update_status){
			$this->session->set_flashdata('msg',"Employee details updated successfully");
		//	echo json_encode(['success'=>'Employee details updated successfully']);
		redirect('hr/employee/add_emp_other_data/'.$update_status);
		}else{
		$errors = validation_errors();
		$this->session->set_flashdata('error',$errors);
					redirect('hr/employee/employee_list');
			}

}

	public function add_emp_other_data($id)
	{
		if ( ! check_access('employee_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Edit Employee";
		$employee_id = $id;
		$employee_details = $this->employee_model->get_employee_details($employee_id);

		$viewData['employee_details'] = $employee_details;
		$viewData['emergnecy_contact_details'] = $this->employee_model->get_emergnecy_contact_details($employee_id);
		$viewData['bank_details'] = $this->employee_model->get_bank_details($employee_id);
		$viewData['insurance_details'] = $this->employee_model->get_insurance_details($employee_id);

		$viewData['countryList'] = countryList(); //country list derived from constants helper
    	$viewData['title'] = title(); //title
    	$viewData['bloodGroup'] = bloodGroup(); //blood groups
    	$viewData['province'] = province(); //provinces
    	$viewData['maritalStatus'] = maritalStatus();
			$viewData['bank_list'] = $this->common_hr_model->get_bank_list();


		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/edit_emp_otherdata', $viewData);
		$this->load->view('includes/footer');
	}

	public function update_otherdatasubmit()
	{
		$update_status = $this->employee_model->add_employee_otherdata();
		if($update_status){
			$this->session->set_flashdata('msg',"Employee update successfully");

			redirect("hr/employee/add_emp_edu_data/".$update_status);
		}else{
			$this->session->set_flashdata('error',"Something Went Wrong... Please Try Again");
			redirect("hr/employee/create");
		}
	}

	public function add_emp_edu_data($id)
	{
		if ( ! check_access('employee_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Edit Employee";
		$employee_id = $id;
		$employee_details = $this->employee_model->get_employee_details($employee_id);

		$viewData['employee_details'] = $employee_details;
				$ol_details = $this->employee_model->get_ol_results($employee_id);

				$viewData['ol_details'] = $ol_details;
			if($ol_details){
				$viewData['ol_results'] = unserialize($ol_details['result']);
				$viewData['ol_document']= $ol_details['document'];
			}


			$al_details = $this->employee_model->get_al_results($employee_id);
			$viewData['al_details'] = $al_details;
			if($al_details){
				$viewData['al_results'] = unserialize($al_details['result']);
				$viewData['al_document']= $al_details['document'];

			}

				$higher_education_details = $this->employee_model->get_higher_education($employee_id);
					if($higher_education_details){
						$viewData['higher_education_details'] = unserialize($higher_education_details['qualification_details']);
						$viewData['higher_education_transcript']= unserialize($higher_education_details['document']);
						$viewData['higher_education_document']= unserialize($higher_education_details['document1']);
					}

				$work_experience_details = $this->employee_model->get_work_experience($employee_id);
					if($work_experience_details)
				$viewData['work_experience_details']  = unserialize($work_experience_details['experience_details']);

				$viewData['higher_education_data'] = $this->employee_model->get_higher_education_details(); //edit by dileep
					$viewData['qualification_field_data'] = $this->employee_model->get_qualification_field_details(); //edit by dileep


				$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
				$this->load->view('includes/topbar_notsearch');
				$this->load->view('hr/employee/edit_emp_edudata', $viewData);
				$this->load->view('includes/footer');

	}

	public function update_edudatasubmit()
	{
		$emp_id=$this->input->post('employeeMasterID');
		$this->form_validation->set_rules('ordinary_level', 'O/L Results', 'callback_validateOlResults');
		$this->form_validation->set_rules('advance_level', 'A/L Results', 'callback_validateAlResults');
		$this->form_validation->set_rules('higher_education', 'Higher Education', 'callback_validateHigherEducation');
		$this->form_validation->set_rules('work_experience', 'work_experience', 'callback_validateWorkExperiernce');

if($this->form_validation->run()){
		$this->_vaildateOlResults = $this->input->post('ordinary_level');
		$this->_vaildateAlResults = $this->input->post('advance_level');
		$this->_validateHigherEducation = $this->input->post('higher_education');
		$this->_validateWorkExperiernce = $this->input->post('work_experience');
		$data_set = array();
		$data_set['ordinary_level'] = $this->_vaildateOlResults;
		$data_set['advance_level'] = $this->_vaildateAlResults;
		$data_set['higher_education'] = $this->_validateHigherEducation;
		$data_set['work_experience'] = $this->_validateWorkExperiernce;
		$update_status = $this->employee_model->update_edudatasubmit($data_set);
		if($update_status){
			$this->session->set_flashdata('msg',"Employee update successfully");

			redirect("hr/employee/add_emp_edu_data/".$emp_id);
		}
		}else{
			//$this->session->set_flashdata('error',"Something Went Wrong... Please Try Again");
			$errors = validation_errors();
			$this->session->set_flashdata('error',$errors);

			redirect("hr/employee/add_emp_edu_data/".$emp_id);
		}
	}
	public function employee_confirmation_list(){
		if ( ! check_access('employee_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/employee/employee_confirmation_list');
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
	$data['datalist'] = $this->employee_model->get_all_employee_details($pagination_counter,$page_count);
	$config['total_rows'] = $this->db->count_all('hr_empmastr');
	$this->pagination->initialize($config);

			$data1['title'] = "Employee List";
			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
	$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/employee/emp_confirmation_list_view', $data);
			$this->load->view('includes/footer');
	}

	public function confirm_user_data(){
		if ( ! check_access('employee_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Confirm Employee";
	$employee_id = (int)$this->uri->segment(4);

	$employee_details = $this->employee_model->get_employee_details($employee_id);
	$viewData['employee_details'] = $employee_details;
	$viewData['emergnecy_contact_details'] = $this->employee_model->get_emergnecy_contact_details($employee_id);
	$viewData['bank_details'] = $this->employee_model->get_bank_details($employee_id);
	$viewData['insurance_details'] = $this->employee_model->get_insurance_details($employee_id);

	$ol_details = $this->employee_model->get_ol_results($employee_id);
	$viewData['ol_details'] = $ol_details;
	if($ol_details)
	$viewData['ol_results'] = unserialize($ol_details['result']);

	$al_details = $this->employee_model->get_al_results($employee_id);
	$viewData['al_details'] = $al_details;
	if($al_details)
	$viewData['al_results'] = unserialize($al_details['result']);

	$higher_education_details = $this->employee_model->get_higher_education($employee_id);
	if($higher_education_details)
	$viewData['higher_education_details'] = unserialize($higher_education_details['qualification_details']);

	$work_experience_details = $this->employee_model->get_work_experience($employee_id);
	if($work_experience_details)
	$viewData['work_experience_details']  = unserialize($work_experience_details['experience_details']);

	$viewData['countryList'] = countryList(); //country list derived from constants helper
		$viewData['title'] = title(); //title
		$viewData['bloodGroup'] = bloodGroup(); //blood groups
		$viewData['province'] = province(); //provinces
		$viewData['maritalStatus'] = maritalStatus();

	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['bank_list'] = $this->common_hr_model->get_bank_list();
	$viewData['leave_category_list'] = $this->common_hr_model->get_leave_category_list();
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['fuel_allowance_vehicle_type_list'] = $this->common_hr_model->get_fuel_allowance_vehicle_type_list();
	$viewData['user_privilege_list'] = $this->common_hr_model->get_user_privilege_list();

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/confirm_emp_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function employee_confirm_submit(){
		if ( ! check_access('employee_confirm'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}

		$employee_id = $this->input->post('employeeMasterID', TRUE);


// 	//Ticket 1575 2020/07/27
//
// 		$viewData["emp_detail"]=$employee_details = $this->employee_model->get_employee_details($employee_id);
// 		$viewData['designation'] =$designation= $this->common_hr_model->get_designation($employee_details["designation"]);
// 		$viewData["immediate_manager"]= $immediate_manager = $this->employee_model->get_employee_details($employee_details["immediate_manager_1"]);
// 		$viewData["immediate_manager_designation"]=$immediate_manager_designation =  $this->common_hr_model->get_designation($immediate_manager["designation"]);
// 		$viewData['branch']=$branch = $this->common_hr_model->get_branch_details($employee_details["branch"]);
// 		$viewData['salary']=$salary = $this->employee_model->get_emp_salary_details_by_emp_id($employee_id);
// 		//$this->load->view('hr/employee/employeeletter/employee_contract',$viewData);
//
//
// 		if(!empty($employee_details['addr1'])){
// 			$addr1 =$employee_details['addr1'].',<br>';
// 		}
// 		if(!empty($employee_details['addr2'])){
// 			$addr2=$employee_details['addr2'].' , <br>';
// 		}
// 		if(!empty($employee_details['town'])){
// 				$town=$employee_details['town'].' , <br>';
// 		}
//
//
// 		// Get output html
// 		$html = '<div class="row"  >
// 					<div  style="padding-left:50px; font-size:15px; width:640px; ">
// 				    <div style="height: 1.00in;"></div>
// 				   '.date("F j, Y").'<br>
// 				   '.$employee_details['initial']." ".$employee_details['surname'].'<br>'.
// 				   	$addr1;
// 				   	$addr2;
// 				   	$town;
// 		$html.='<br>
// 		 <br>
// 		 <b>Subject: Appointment for post of '.$designation["designation"].'</b><br/><br/>
// 		 Dear '. $employee_details['initial']." ".$employee_details['surname'].',
// 		 <br/><br/>
// 		 We are pleased to offer you, the position of '.$designation['designation'] .' with Master Land and Construction (Pvt) Ltd on the following terms and conditions:
// 			<br/><br/>
// 			1.<b> Commencement of employment</b><br/>
// 			Your employment will be effective, as of '. $employee_details['joining_date'] .' .<br/><br/>
//
// 			2.<b> Job title</b><br/>
// 			Your job title will be Assistant Accountant and you will report to '. $immediate_manager['initial'].'. '.$immediate_manager['surname'] .', '. $immediate_manager_designation['designation'] .'.<br><br>';
// 		$html.='3. <b>Salary</b><br>
// Your salary and other benefits will be as set out in Schedule 1, hereto.<br><br>
//
// 4. <b>Place of posting</b><br>
// You will be posted at '. $branch["branch_name"] .'. You may however be required to work at any place of business which the Company has, or may later acquire.<br><br>
//
// 5. <b>Hours of Work</b><br>
// The normal working days are Monday through Saturday. You will be required to work for such hours as necessary for the proper discharge of your duties to the Company. The normal working hours are from 8.30 a.m to 5.30 p.m and you are expected to work not less than eight hours each week, and if necessary for additional hours depending on your responsibilities.<br><br>
//
// 6. <b>Leave/Holidays</b><br>
// 6.1 You are entitled to casual leave of 7 days and annual leaves of 14 days.<br>
// 6.2 You are entitled to 1 working days of paid sick leave.<br>
// 6.3 The Company shall notify a list of declared holidays in the beginning of each year.<br><br>
//
// 7. <b>Nature of duties</b><br>
// You will perform to the best of your ability all the duties as are inherent in your post and such additional duties as the company may call upon you to perform, from time to time. Your specific duties are set out in Schedule II hereto.<br><br>
//
// 8. <b>Company property</b><br>
// You will always maintain in good condition Company property, which may be entrusted to you for official use during the course of your employment and shall return all such property to the Company prior to relinquishment of your charge, failing which the cost of the same will be recovered from you by the Company.<br><br>
//
// 9. <b>Borrowing/accepting gifts</b><br>
// You will not borrow or accept any money, gift, reward or compensation for your personal gains from or otherwise place yourself under pecuniary obligation to any person/client with whom you may be having official dealings.<br><br>
//
// 10. <b>Termination</b><br>
// 10.1 Your appointment can be terminated by the Company, without any reason, by giving you not less than one months’ prior notice in writing or salary in lieu thereof. For the purpose of this clause, salary shall mean basic salary.<br>
// 10.2 You may terminate your employment with the Company, without any cause, by giving no less than one months’ prior notice or salary for unsaved period, left after adjustment of pending leaves, as on date.<br>
// 10.3 The Company reserves the right to terminate your employment summarily without any notice period or termination payment, if it has reasonable ground to believe you are guilty of misconduct or negligence, or have committed any fundamental breach of contract or caused any loss to the Company. <br>
// 10. 4 On the termination of your employment for whatever reason, you will return to the Company all property; documents and paper, both original and copies thereof, including any samples, literature, contracts, records, lists, drawings, blueprints, letters, notes, data and the like; and Confidential Information, in your possession or under your control relating to your employment or to clients’ business affairs. <br><br>
//
// 11. <b>Notices</b><br>
// Notices may be given by you to the Company at its registered office address. Notices may be given by the Company to you at the address intimated by you in the official records.<br><br>
//
// 12. <b>Applicability of Company Policy</b><br>
// The Company shall be entitled to make policy declarations from time to time pertaining to matters like leave entitlement, maternity leave, employees’ benefits, working hours, transfer policies, etc., and may alter the same from time to time at its sole discretion. All such policy decisions of the Company shall be binding on you and shall override this Agreement to that extent.<br><br>
//
// 13. <b>Governing Law/Jurisdiction</b><br>
// Your employment with the Company is subject to labour laws. All disputes shall be subject to the jurisdiction of Labour Department only.<br><br>
//
// 14. <b>Acceptance of our offer</b><br>
// Please confirm your acceptance of this Contract of Employment by signing and returning the duplicate copy.<br><br>
//
// We welcome you, and look forward to receiving your acceptance and to working with you.<br><br><br><br>
//
// Yours Sincerely,<br>
// <strong>Master Land and Construction (Pvt) Ltd</strong><br><br><br>
//
//
// .....................<br>
// R. D. Wickramanayake<br>
// Director<br>
// 06/02/2019<br><br><br>
//
// <br><br>
// I have read the terms and conditions of this appointment and confirm my acceptance of the same.<br><br>
//
// ....................<br><br>
// (Signature and Date)<br><br>';
//
//
//
// $html.='<h4>Schedule I - Compensation Details</h4><br>
// <b>Salary Structure</b><br>
//
// <table style="border: 1px solid black ; width: 100%">
//   <tr>
//     <td>Basic Salary<br></td>
//     <td>'. $salary["basic_salary"] .'</td>
//   </tr>
// </table>
// <br><br>
// <p>Note: You will receive salary, and all other benefits forming part of your remuneration package subject to, and after, deduction of tax at source in accordance with applicable law.</p>
//
// <h3>Schedule II - Employee Duties & Responsibilities</h3>
//
// <ul>
//   <li>Preparing financial documents such as invoices, bills, and accounts payable and receivable</li>
//   <li>Completing purchase orders</li>
//   <li>Completing purchase orders</li>
//   <li>Assisting with budgets</li>
//   <li>Completing bank reconciliations</li>
//   <li>Entering financial information into appropriate software programs</li>
//   <li>Managing company ledgers</li>
//   <li>Processing business expenses</li>
//   <li>Coordinating internal and external audits</li>
//   <li>Verifying balances in account books and rectifying discrepancies</li>
//   <li>Verifying bank deposits</li>
//   <li>Managing day-to-day transactions</li>
//   <li>Recording office expenditures and ensuring these expenses are within the set budget</li>
//   <li>Assisting the finance department and senior accounting staff members with various tasks, including preparing budgets, records, and statements</li>
//   <li>Posting daily receipts</li>
//   <li>Preparing annual budgets</li>
//   <li>Completing the year-end analysis</li>
//   <li>Reporting on debtors and creditors</li>
//   <li>Handling accruals and prepayments</li>
//   <li>Managing monthly budgeting tasks</li>
//   <li>Encoding accounting entries for data processing</li>
//   <li>Sorting financial documents and posting them to the proper accounts.</li>
//   <li>Reviewing computer reports for accuracy and meticulously tracing errors back to their source.</li>
//   <li>Resolving errors in financial reports and correcting faulty reporting methods.</li>
// </ul>
//
//   </div>
// </div>';
//
// 		//path to save the file
// 		$date = date("Y-m-d");
// 		$filename = $employee_details['emp_no'].'_'.$date.'_appoinment_letter.pdf';
//
// 		$pdfroot = "./pdfs/appoinment letter/".$filename;
// 		$fileroot = "pdfs/appoinment letter/".$filename;
//
//
// 		 // Load library
// 		$this->load->library('dompdf_gen');
// 		// Convert to PDF
// 		$this->dompdf->load_html($html);
// 		$this->dompdf->render();
// 		//$this->dompdf->stream("welcome.pdf");
// 		$pdf_string =   $this->dompdf->output();
//         file_put_contents($pdfroot, $pdf_string );
//
//         $data_letter['emp_id']=$employee_details['id'];
//         $data_letter['letter_type']=2;
//         $data_letter['date']=date("Y-m-d");
//         $data_letter['file']=$fileroot;
//         $this->letter_model->insert_letter($data_letter);
//
//
//
//  	//Ticket 1575 2020/07/27 end



		$employee_details = $this->employee_model->get_employee_details($employee_id);
	 	if($employee_details['status'] != "P" || $employee_details['user_privilege']=="" || $employee_details['branch']==""
	 || $employee_details['division']=="" || $employee_details['leave_category']=="" || $employee_details['employment_type']==""){
	 	$this->session->set_flashdata('error',"Please Complete Employee Basic Details First");
	 	$this->session->set_flashdata('error',"Please Complete Employee Basic Details First");
	 		redirect(base_url('hr/employee/employee_confirmation_list'));
	 	}
	 	$this->employee_model->confirm_employee();
	 	$this->session->set_flashdata('msg',"Employee confirmed successfully");
	 		redirect(base_url('hr/employee/employee_confirmation_list'));

	}

	public function edit_confirmed_employee(){
		if ( ! check_access('employee_confirmed_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Edit Confirmed Employee";
	$employee_id = (int)$this->uri->segment(4);
	$employee_details = $this->employee_model->get_employee_details($employee_id);
	if($employee_details['status'] != "A"){
		redirect(base_url('hr/employee/employee_list'));
	}
	$viewData['employee_details'] = $employee_details;


	$viewData['countryList'] = countryList(); //country list derived from constants helper
		$viewData['title'] = title(); //title
		$viewData['bloodGroup'] = bloodGroup(); //blood groups
		$viewData['province'] = province(); //provinces
		$viewData['maritalStatus'] = maritalStatus();

	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['bank_list'] = $this->common_hr_model->get_bank_list();
	$viewData['leave_category_list'] = $this->common_hr_model->get_leave_category_list();
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['fuel_allowance_vehicle_type_list'] = $this->common_hr_model->get_fuel_allowance_vehicle_type_list();
	$viewData['user_privilege_list'] = $this->common_hr_model->get_user_privilege_list();

	$viewData['get_user_data'] = $this->employee_model->get_user_data($employee_id);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/edit_confirmed_emp_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function employee_flag_unflag(){
	if ( ! check_access('employee_unflag'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$user_id = $_REQUEST['user_id'];
	$flag_status = $_REQUEST['flag_status'];
	if($flag_status == 'flag'){
		$flag_log = "flagged";
	}else if ($flag_status == 'unflag'){
		$flag_log = "unflagged";
	}
	$this->employee_model->employee_flag_unflag($user_id, $flag_status);
	$this->session->set_flashdata('msg',"Employee $flag_log successfully");
	echo json_encode(['success'=>'Employee '.$flag_log.' successfully']);
	die();
	}

	// public function confirmed_employee_update(){
	// if ( ! check_access('employee_confirmed_edit'))
	// {
	// 	$this->session->set_flashdata('error', 'Permission Denied');
	// 	redirect('menu_call/showdata/hr');
	// 	return;
	// }
	// $employeeMasterID = $this->input->post('employeeMasterID', TRUE);
	//
	// $employee_details = $this->employee_model->get_employee_details($employeeMasterID);
	// $employee_email = $employee_details['email'];
	// if($this->input->post('userEmail') != $employee_email){
	// 		$is_unique = '|is_unique[hr_empmastr.email]|is_unique[hr_empmastr.office_email]';
	// }else{
	// 		$is_unique =  '';
	// }
	//
	// $employee_office_email = $employee_details['office_email'];
	// if($this->input->post('office_email') != $employee_office_email){
	// 		$office_email_is_unique = '|is_unique[hr_empmastr.office_email]|is_unique[hr_empmastr.email]';
	// }else{
	// 		$office_email_is_unique =  '';
	// }
	//
	// $this->form_validation->set_rules('immediate_manager_1', 'Immediate Manager 1', 'required');
	// $this->form_validation->set_rules('user_privilege', 'User Privilege Level', 'required');
	// $this->form_validation->set_rules('userEmail', 'Personal Email', 'trim|xss_clean'.$is_unique);
	// $this->form_validation->set_rules('office_email', 'Office Email', 'trim|xss_clean'.$office_email_is_unique);
	// $this->form_validation->set_rules('ordinary_level', 'O/L Results', 'callback_validateOlResults');
	// $this->form_validation->set_rules('advance_level', 'A/L Results', 'callback_validateAlResults');
	// $this->form_validation->set_rules('higher_education', 'Higher Education', 'callback_validateHigherEducation');
	// $this->form_validation->set_rules('work_experience', 'work_experience', 'callback_validateWorkExperiernce');
	//
	// if($this->form_validation->run()){
	// 	$data_set = array();
	// 	$data_set['ordinary_level'] = $this->_vaildateOlResults;
	// 	$data_set['advance_level'] = $this->_vaildateAlResults;
	// 	$data_set['higher_education'] = $this->_validateHigherEducation;
	// 	$data_set['work_experience'] = $this->_validateWorkExperiernce;
	//
	// 	$update_status = $this->employee_model->update_confirmed_employee_details($data_set);
	// 	if(empty($update_status['upload_data_failed'])){
	// 		$this->session->set_flashdata('msg',"Employee details updated successfully");
	// 		echo json_encode(['success'=>'Employee details updated successfully']);
	// 	}else{
	// 		$errors = $update_status['upload_data_failed'];
	// 		echo json_encode(['error'=>$errors]);
	// 	}
	// }else{
	// 	$errors = validation_errors();
	// 				echo json_encode(['error'=>$errors]);
	// 		}
	// die();
	// }

	public function validateOlResults(){
		$this->_vaildateOlResults = $this->input->post('ordinary_level');
		$noResultsFound = true;

		//unset blank pairs first before any process
		foreach($this->_vaildateOlResults as $key=>$value){
		$subject_trim = trim($value['subject']);
		$grade_trim = trim($value['grade']);
				if(empty($subject_trim) && empty($grade_trim)){
					unset($this->_vaildateOlResults[$key]);//remove empty ol fields
				}
		}
		if(sizeof($this->_vaildateOlResults) > 0){
				$noResultsFound = false;
				$this->_vaildateOlResults = array_values($this->_vaildateOlResults); //reassgsin array keys starting from zero

				//filter O/L data
				for($i=0; $i<sizeof($this->_vaildateOlResults); $i++){
			$vaildateOlResults_subject_trim = trim($this->_vaildateOlResults[$i]['subject']);
			$vaildateOlResults_grade_trim = trim($this->_vaildateOlResults[$i]['grade']);
					if(empty($vaildateOlResults_subject_trim) || empty($vaildateOlResults_grade_trim)){
							$this->form_validation->set_message('validateOlResults', 'Incomplete O/L result pair(s) found. Please include both the subject and the grade for each pair.');
							return false;
					}
				}
		}
		return true;
	}

	public function validateAlResults(){
	$this->_vaildateAlResults = $this->input->post('advance_level');
		$noResultsFound = true;

		//unset blank pairs first before any process
		foreach($this->_vaildateAlResults as $key=>$value){
		$subject_trim = trim($value['subject']);
		$grade_trim = trim($value['grade']);
				if(empty($subject_trim) && empty($grade_trim)){
					unset($this->_vaildateAlResults[$key]);//remove empty ol fields
				}
		}

		if(sizeof($this->_vaildateAlResults) > 0){
		$noResultsFound = false;
				$this->_vaildateAlResults = array_values($this->_vaildateAlResults); //reassgsin array keys starting from zero

				//filter O/L data (remove empty elements - incase if user added blank lines)
				for ($i=0; $i<count($this->_vaildateAlResults); $i++){
			$vaildateAlResults_subject_trim = trim($this->_vaildateAlResults[$i]['subject']);
			$vaildateAlResults_grade_trim = trim($this->_vaildateAlResults[$i]['grade']);
					if(empty($vaildateAlResults_subject_trim) || empty($vaildateAlResults_grade_trim)){
							$this->form_validation->set_message('validateAlResults', 'Incomplete A/L result pair(s) found. Please include both the subject and the grade for each pair.');
				return false;
					}
				}
		}
	return true;
	}

	public function validateHigherEducation(){
		$this->_validateHigherEducation = $this->input->post('higher_education');
			// print_r($this->input->post('higher_education')) ;
			$noResultsFound = true;

			//unset fully blank sets first
			foreach($this->_validateHigherEducation as $key=>$value){
			$name_trim = trim($value['name']);
			$institute_trim = trim($value['institute']);
			//$grade_trim = trim($value['grade']);
			$from_trim = trim($value['from']);
		//	$to_trim = trim($value['to']); //Ticket 2879 edit by dileep
					if(empty($name_trim) && empty($institute_trim) && empty($from_trim)){
						unset($this->_validateHigherEducation[$key]);
					}
			}

			if(sizeof($this->_validateHigherEducation) > 0){
					$noResultsFound = false;
					$this->_validateHigherEducation = array_values($this->_validateHigherEducation); //reassgsin array keys starting from zero

					for($i=0; $i<sizeof($this->_validateHigherEducation); $i++){
				$vaildateHigherEducation_name_trim = trim($this->_validateHigherEducation[$i]['name']);
				$vaildateHigherEducation_institute_trim = trim($this->_validateHigherEducation[$i]['institute']);
				//$vaildateHigherEducation_grade_trim = trim($this->_validateHigherEducation[$i]['grade']);
				$vaildateHigherEducation_from_trim = trim($this->_validateHigherEducation[$i]['from']);
				//$vaildateHigherEducation_to_trim = trim($this->_validateHigherEducation[$i]['to']);
						//validate required fields
						if(empty($vaildateHigherEducation_name_trim) || empty($vaildateHigherEducation_institute_trim) || empty($vaildateHigherEducation_from_trim)){
								$this->form_validation->set_message('validateHigherEducation', 'Incomplete Higher Education sets found in the form. Please fill all the required fields (Qualification name, Institute name, Grade, and Year dates) of each.');
								return false;
						}

						//validate dates
				$fromDate_trim = trim($this->_validateHigherEducation[$i]['from']);
						$fromDate = strtotime($fromDate_trim);
				// $toDate_trim = trim($this->_validateHigherEducation[$i]['to']);
				// $toDate = strtotime($toDate_trim);
				//
				// 		$days_between = ($toDate - $fromDate) / 86400;
				// 		if($days_between < 0){
				// 				$this->form_validation->set_message('validateHigherEducation', 'Invalid From and To dates selected for one of the Higher Education qualifications.');
				// 	return false;
				// }
					}
			}
			return true;
	}

	public function validateWorkExperiernce(){
		$this->_validateWorkExperiernce = $this->input->post('work_experience');
		$noResultsFound = true;

		//unset fully blank sets first
		foreach($this->_validateWorkExperiernce as $key=>$value){
		$job_trim = trim($value['job']);
		$company_trim = trim($value['company']);
		$location_trim = trim($value['location']);
		$from_trim = trim($value['from']);
		$to_trim = trim($value['to']);
				if(empty($job_trim) && empty($company_trim) && empty($location_trim)) {
					unset($this->_validateWorkExperiernce[$key]);
				}
		}

		if(sizeof($this->_validateWorkExperiernce) > 0){
				$noResultsFound = false;
				$this->_validateWorkExperiernce = array_values($this->_validateWorkExperiernce); //reassgsin array keys starting from zero

				for($i=0; $i<count($this->_validateWorkExperiernce); $i++){
			$validateWorkExperiernce_job_trim = trim($this->_validateWorkExperiernce[$i]['job']);
			$validateWorkExperiernce_company_trim = trim($this->_validateWorkExperiernce[$i]['company']);
			$validateWorkExperiernce_location_trim = trim($this->_validateWorkExperiernce[$i]['location']);
			$validateWorkExperiernce_from_trim = trim($this->_validateWorkExperiernce[$i]['from']);
			$validateWorkExperiernce_to_trim = trim($this->_validateWorkExperiernce[$i]['to']);
					//validate required fields
					if( empty($validateWorkExperiernce_job_trim) || empty($validateWorkExperiernce_company_trim) || empty($validateWorkExperiernce_location_trim)) {
							$this->form_validation->set_message('validateWorkExperiernce', 'Incomplete work_experience sets found in the form. Please fill all the required fields (Qualification Job Titie,  Company, Location) of each.');
							return false;
					}

					//validate dates
			// $fromDate_trim = trim($this->_validateWorkExperiernce[$i]['from']);
			// 		$fromDate = strtotime($fromDate_trim);
			// $toDate_trim = trim($this->_validateWorkExperiernce[$i]['to']);
			// 		$toDate = strtotime($toDate_trim);
			//
			// 		$days_between = ($toDate - $fromDate) / 86400;
			// 		if($days_between < 0){
			// 				$this->form_validation->set_message('validateWorkExperiernce', 'Invalid start and from dates selected for one of the work_experience.');
			// 				return false;
			// 		}
				}
		}
		return true;
	}


	public function employee_leave_category_update(){
		if ( ! check_access('employee_transaction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
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
		if ( ! check_access('employee_transaction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
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
		$this->session->set_flashdata('msg',"Employement Type updated successfully");
		echo json_encode(['success'=>'Employement Type updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}

	public function employee_resignation_update(){
		if ( ! check_access('employee_transaction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$employeeMasterID = $this->input->post('emp_id', TRUE);
	$this->form_validation->set_rules('resignation_trans_date', 'Resignation Valid From', 'required');

	if($this->form_validation->run()){
		$this->employee_model->update_employee_resignation($employeeMasterID);
		$this->session->set_flashdata('msg',"Employee resignation updated successfully");
		echo json_encode(['success'=>'Employee resignation updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}

	public function employee_equipment(){
		if ( ! check_access('employee_equipment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['title'] = "Employee Equipment";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['employment_types'] = $this->common_hr_model->get_employment_type_list();
	$viewData['branches'] = $this->common_hr_model->get_branch_list();
	$viewData['divisions'] = $this->common_hr_model->get_division_list();
	$viewData['designations'] = $this->common_hr_model->get_designation_list();
	$viewData['equipment_categories'] = $this->common_hr_model->get_equipment_category_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/employee/employee_equipment');
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
	$viewData['datalist'] = $this->employee_model->get_all_emp_equipment($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_emp_equipment');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/emp_equipment_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function employee_equipment_update(){
		if ( ! check_access('employee_equipment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$employeeMasterID = $this->input->post('emp_id', TRUE);
	$this->form_validation->set_rules('emp_id', 'Select Employee', 'required');
	$this->form_validation->set_rules('equipment_category', 'Select Equipment Category', 'required');
	$this->form_validation->set_rules('equipment_name', 'Equipment Name', 'required');
	$this->form_validation->set_rules('from_date', 'From', 'required');

	if($this->form_validation->run()){
		$this->employee_model->update_employee_equipment($employeeMasterID);
		$this->session->set_flashdata('msg',"Employee equipment updated successfully");
		echo json_encode(['success'=>'Employee equipment updated successfully']);
	}else{
		$errors = validation_errors();
					echo json_encode(['error'=>$errors]);
			}
	die();
	}

	public function edit_emp_equipment(){
	if ( ! check_access('employee_equipment'))
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
	$viewData['equipment_categories'] = $this->common_hr_model->get_equipment_category_list();
	$viewData['details'] = $this->employee_model->get_emp_equipment_details($id);
	$this->load->view('hr/employee/edit_emp_equipment_view', $viewData);
	}
	public function print_emp_equipment(){
	if ( ! check_access('employee_equipment'))
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
	$viewData['equipment_categories'] = $this->common_hr_model->get_equipment_category_list();
	$viewData['details'] =$details= $this->employee_model->get_emp_equipment_details($id);
	$viewData['employee_details'] = $this->employee_model->get_employee_details($details['emp_record_id']);
	$this->load->view('hr/employee/print_emp_equipment_view', $viewData);
	}
	public function employee_equipment_confirm(){
		if ( ! check_access('employee_equipment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
	$record_id = $_REQUEST['record_id'];
	$this->employee_model->confirm_employee_equipment($record_id);
	//$this->print_equipment_issue_letter($record_id);// ticket 1575 2020-07-28
	$this->session->set_flashdata('msg',"Employee equipment confirmed successfully");
	echo json_encode(['success'=>'Employee equipment confirmed successfully']);
	die();
	}

	public function additional_fuel_request(){
	$session = array('usermodule'=>'hr');
	$this->session->set_userdata($session);

		$data['title'] = "Employee Leave List";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/employee/additional_fuel_request');
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
	$viewData['datalist'] = $this->employee_model->get_employee_additional_fuel_allowance_list($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_emp_fuel_allowance_additional');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/emp_additional_fuel_allowance_list_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function emp_additional_fuel_allowance(){
	$id = (int)$this->uri->segment(4);
	$viewData['details'] = $this->employee_model->get_fuel_allowance_additional_details($id);
	$this->load->view('hr/employee/emp_additional_fuel_allowance_view', $viewData);
	}

	public function confirm_additional_fuel_request(){
	$this->employee_model->confirm_additional_fuel_request();
	$this->session->set_flashdata('msg',"Additional Fuel Request confirmed successfully");
	redirect('hr/employee/additional_fuel_request');
	}

	public function decline_emp_additional_fuel_allowance(){
	$id = $this->uri->segment(4);
	$this->employee_model->decline_additional_fuel_request($id);
	$this->session->set_flashdata('msg',"Additional Fuel Request decline successfully");
	redirect('hr/employee/additional_fuel_request');
	}

	public function fuel_allowance_payment(){
	if ( ! check_access('fuel_payment'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
		$data['title'] = "Employee Fuel Allowance Payment";

	$viewData['employee_list'] = $this->employee_model->get_employee_list();

	$this->load->library('pagination');
	$page_count = (int)$this->uri->segment(4);

	if(!$page_count)
	$page_count = 0;

	/* Pagination configuration */
	$config['base_url'] = site_url('hr/employee/fuel_allowance_payment');
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
	$viewData['datalist'] = $this->employee_model->get_fuel_allowance_payment_master_list($pagination_counter, $page_count);
	$config['total_rows'] = $this->db->count_all('hr_fuel_allowance_payment_master');
	$this->pagination->initialize($config);

		$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
	$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/employee/emp_fuel_payment_view', $viewData);
		$this->load->view('includes/footer');
	}

	public function run_monthly_fuel_allowance_payment(){
		if ( ! check_access('fuel_payment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->form_validation->set_rules('from_date', 'From Date', 'required');
		$this->form_validation->set_rules('to_date', 'To Date', 'required');

		if($this->form_validation->run()){
			$from_date=$this->input->post('from_date', TRUE);
			$todate=$this->input->post('to_date', TRUE);
			$year = date('Y',strtotime($from_date));
			$month = date('m',strtotime($from_date));
			$to_year = date('Y',strtotime($todate));
			$to_month = date('Y',strtotime($todate));
			$to_day = date('d',strtotime($todate));
			$date = $year."-".$month;
			if(date("Y-m", strtotime($date)) > date("Y-m") || date("Y-m-d", strtotime($todate)) > date("Y-m-d")){
				$errors = "<br>System Does NOT allow to generate fuel allowance paysheets for future months";
							echo json_encode(['error'=>$errors]);
				die();
			}
			$check=$this->employee_model->check_emp_emp_fuel_allowance_payment_to_from();
			if($check){
				$errors = "<br>Please first cancel or confirm pending fuel allowance payments";
							echo json_encode(['error'=>$errors]);
				die();
			}
	//			$year_month_validation = $this->employee_model->check_emp_emp_fuel_allowance_payment_year_month($year, $month);
	//			if(count($year_month_validation)>0){
	//				$errors = "<br>System Does NOT allow to regenerate fuel allowance paysheets";
	//            	echo json_encode(['error'=>$errors]);
	//				die();
	//			}

			$monthly_fuel_allowance = $this->employee_model->run_monthly_fuel_allowance_payment();
			if($monthly_fuel_allowance){
				$this->session->set_flashdata('msg',"Fuel allowance payment updated successfully");
				echo json_encode(['success'=>'Fuel allowance payment updated successfully']);
			}else{
				$errors = "<br>Please select valid date range";
					echo json_encode(['error'=>$errors]);
					die();
			}
		}else{
			$errors = validation_errors();
						echo json_encode(['error'=>$errors]);
				}
		die();
	}

	public function emp_fuel_allowance_payment_list(){
	if ( ! check_access('fuel_payment'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = (int)$this->uri->segment(4);
	$viewData['employee_list'] = $this->employee_model->get_employee_list();
	$viewData['details'] = $this->employee_model->get_emp_fuel_allowance_payment_master_details($id);
	$viewData['fuel_allowance_payment_list'] = $this->employee_model->get_emp_fuel_allowance_payment_list($id);
	$this->load->view('hr/employee/emp_fuel_allowance_payment_list_view', $viewData);
	}

	public function employee_fuel_allowance_payment_confirm(){
	$record_id = $_REQUEST['record_id'];
	$this->employee_model->confirm_employee_fuel_allowance_payment($record_id);
	$this->session->set_flashdata('msg',"Fuel Allowance Payment confirmed successfully");
	echo json_encode(['success'=>'Fuel Allowance Payment confirmed successfully']);
	die();
	}

	public function decline_monthly_fuel_payment(){
	$id = $this->uri->segment(4);
	$this->employee_model->decline_monthly_fuel_payment($id);
	$this->session->set_flashdata('msg',"Fuel payment decline successfully");
	redirect('hr/employee/fuel_allowance_payment');
	}

	public function emp_fuel_allowance_report(){
	if ( ! check_access('fuel_payment'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$master_id = $this->uri->segment(4);
	$emp_id = $this->uri->segment(5);

	$emp_fuel_allowance_payment_master_details = $this->employee_model->get_emp_fuel_allowance_payment_master_details($master_id);

	$start_date = $emp_fuel_allowance_payment_master_details['start_date'];
	$end_date = $emp_fuel_allowance_payment_master_details['end_date'];

	$viewData['start_date'] = $start_date;
	$viewData['end_date'] = $end_date;

	$viewData['employee_details'] = $this->employee_model->get_employee_details($emp_id);

	$viewData['view_emp_fuel_allowance_report'] = $this->employee_model->get_emp_fuel_allowance_report($start_date, $end_date, $emp_id);
	$this->load->view('hr/employee/emp_fuel_allowance_report_view', $viewData);
	}



	function holidays(){
	if ( ! check_access('add_holiday'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$data['holidays']=$this->employee_model->get_holidays();

	$this->load->view('hr/employee/add_holiday',$data);
	}
	function holidays_add(){
	if ( ! check_access('add_holiday'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$holiday=$this->input->post('holiday_date');
	$data=array(
		'holiday_date' =>$holiday,
		'holiday_reason' => $this->input->post('reason'),
	);
	$id=$this->employee_model->holidays_add($data,$holiday);
	if($id){
		$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Holiday Added Successfully');
		$this->logger->write_message("success", $this->input->post('holiday_date').' Holiday Added Successfully');
		redirect("hr/employee/holidays");
	}else{
		$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Something Went Wrong, Please Add Again.');
		$this->logger->write_message("success",$this->input->post('holiday_date').' Something Went Wrong, Please Add Again');
		redirect("hr/employee/holidays");
	}

	}
	function holiday_delete(){
	if ( ! check_access('add_holiday'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id=$this->employee_model->holiday_delete($this->uri->segment(4));

	$this->session->set_flashdata('msg', 'Holiday Deleted');
	$this->logger->write_message("success", $this->uri->segment(4).'Holiday Deleted');
	redirect("hr/employee/holidays");
	}



	public function get_employee_details(){
	$emp_id = $_REQUEST['emp_id'];
	$data['employee_details'] = $this->employee_model->get_employee_details($emp_id);
	echo json_encode($data);
	die();
	}

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


// created by terance 2020-7-28 ticket no 1575
    function print_equipment_issue_letter($confirm_id){
    $id = $confirm_id;
        $equipdetails= $this->employee_model->get_emp_equipment_details($id);
   $empdetails = $this->employee_model->get_employee_details($equipdetails['emp_record_id']);
   $category = $this->employee_model->get_equipment_name($equipdetails['equipment_category']);

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
   <div style="height: 1.00in;"></div>'.$equipdetails['from_date'].'<br><br><br><br><br>
    Dear '.$title." ".$empdetails['surname'].',<br><br><br>
    <strong><u>Issuing '.$equipdetails['equipment_name'].'</u></strong><br><br>

    <p>With reference to the captioned, the Management has decided to provide you with '.$equipdetails['equipment_name'].' closed user group connection for the position that you have joined with us, hereby authorize ..................................... as per to act on our behalf in all manners relating to application for authorization for '.$category['equipment_category'].'.</p><br>

    <p>At the time of leaving the services of the Company, you will have to return this '.$category['equipment_category'].' to the undersigned of Company.</p><br><br><br>

    Sincerely,<br><br><br><br>

    <table width="100%">
                        <tr>
                           <td align="center">..........................................</td>
                           <td align="center">..........................................</td>
                        </tr>
                        <tr>
                           <td align="center">Received by</td>
                           <td align="center">Managing Director</td>
                        </tr>
                        <tr>
                           <td align="center">'.$empdetails['initial'].' '.$empdetails['surname'].'</td>
                           <td align="center">R.D.Wickramanayake</td>
                        </tr>
    </table>';





    $date = date('Y-m-d H-i-s');
         $filename = $empdetails['emp_no'].'_'.$date.'documentry_issue_letter_report.pdf';
         $pdfroot = "./pdfs/documentories_issue_letter/".$filename;
         $fileroot = "pdfs/documentories_issue_letter/".$filename;

         //insert letter data ..
   $data_letter['emp_id']=$empdetails['id'];
   $data_letter['letter_type']=1;
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

// end 1575




    function print_employee_data(){
		$employee_id = $this->uri->segment(4);
		$employee_details = $this->employee_model->get_employee_details($employee_id);
		$empdesignation = $this->common_hr_model->get_designation($employee_details['designation']);


		////////////////////////////////////////////////////////////////////////////////////////////////
		$oldata = "";
		$ol_details = $this->employee_model->get_ol_results($employee_id);
		$school=$ol_details['school'];

		if($ol_details){
			$ol_result = unserialize($ol_details['result']);
		}

		$subwithresult = "";
		$ol_counter = 0;
		if(isset($ol_result)){
			foreach($ol_result as $ol_result_row){
				$subwithresult = $subwithresult.','.$ol_result_row['subject'].'-'.$ol_result_row['grade'].'';
				$ol_counter++;
			}
		}

		$oldata = '<tr>
		<td>'.$school.'</td>
		<td></td>
		<td>'.$subwithresult.'</td>
		<td>O/L</td>

		</tr>';
		////////////////////////////////////////////////////////////////////////////////
		$aldata = "";
		$al_details = $this->employee_model->get_al_results($employee_id);
		$schoolal=$al_details['school'];
		if($al_details){
			$al_result = unserialize($al_details['result']);
		}
		$subwithresult_al = "";
		$al_counter = 0;
		if(isset($al_result)){
			foreach($al_result as $al_result_row){
				$subwithresult_al = $subwithresult_al.','.$al_result_row['subject'].'-'.$al_result_row['grade'].'';
				$al_counter++;
			}
		}

		$aldata = '<tr>
		<td>'.$schoolal.'</td>
		<td></td>
		<td>'.$subwithresult_al.'</td>
		<td>A/L</td>
		</tr>';

		//////////////////////////////////////////////////////////////////////////////////
		$higheredudata = "";
		$higher_education_details = $this->employee_model->get_higher_education($employee_id);
		if($higher_education_details){
			$higheredu = unserialize($higher_education_details['qualification_details']);
		}
		$subwithresult_he = "";
		$higheredu_counter = 0;
		$schoolhe="";
		$gradehe="";
		if(isset($higheredu)){
			foreach($higheredu as $higher_education_details_row){
				$subwithresult_he = $subwithresult_he.','.$higher_education_details_row['name'].'';
				$schoolhe = $higher_education_details_row['institute'].'';
				$gradehe =  $higher_education_details_row['grade'].'';
				$higheredu_counter++;
			}
		}

		$higheredudata = '<tr>
		<td>'.$schoolhe.'</td>
		<td></td>
		<td>'.$subwithresult_he.'</td>
		<td>'.$gradehe.'</td>
		</tr>';


		///////////////////////////////////////////////////////////////////////////////////
		$work_experience_details = $this->employee_model->get_work_experience($employee_id);
		if($work_experience_details){
			$work_experience_detail = unserialize($work_experience_details['experience_details']);
		}
		$htmltabledata = "";
		if(isset($work_experience_detail)){
			foreach($work_experience_detail as $work_experience_details_row){
				$htmltabledata = '<tr>
				<td>'.$work_experience_details_row['company'].'</td>
				<td>'.$work_experience_details_row['job'].'</td>
				<td>'.$work_experience_details_row['from'].'</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				</tr>';
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////
		// print_r($employee_details);
		// print_r($empdesignation);
		// print_r(json_encode($work_experience_details));

		$html = '<div class="row"  >
		<div  style="padding-left:50px; font-size:15px; width:640px; ">
		<div style="height: 1.00in;"></div>
		<p align="center">'.companyname.'.</p>
		<p align="center">'.addressline1.',</p>
		<p align="center"> '.addressline2.',</p>
		<p align="center">'.addressline3.',</p>
		<p align="center">'.addressline4.'.</p>
		<br><br>

		<p align="center"><strong><font size="15">Application for Employment</font></strong></p>
		<br>
		<div style="padding-left:50px;padding-right:10px;">
		<p>Position for which you are applying: '.$empdesignation['designation'].'</p>
		<p>Personal Information:</p>

		<table width="100%">
		<tr>
		<td>Name(Last)</td>
		<td>First</td>
		<td>Date</td>
		</tr>
		<tr>
		<td>'.$employee_details['surname'].'</td>
		<td>'.$employee_details['initial'].'</td>
		<td>'.$employee_details['joining_date'].'</td>
		</tr>
		<tr>
		<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
		<td>Address</td>
		<td>City</td>
		<td>Phone No</td>
		</tr>
		<tr>
		<td>'.$employee_details['addr1'].",".$employee_details['addr1'].'</td>
		<td>'.$employee_details['town'].'</td>
		<td>'.$employee_details['tel_mob'].'</td>
		</tr>
		<tr>
		<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
		<td>NIC</td>
		<td>Birth Date</td>
		<td></td>
		</tr>
		<tr>
		<td>'.$employee_details['nic_no'].'</td>
		<td>'.$employee_details['dob'].'</td>
		<td></td>
		</tr>
		</table>

		<p>Experiences:</p>

		<table width="100%" border="1">
		<tr>
		<td>Place of Employment</td>
		<td>Job Title</td>
		<td>Date</td>
		<td>Responsibilities</td>
		<td>Pay Rate</td>
		<td>Supervisors Name</td>
		<td>Supervisors Contact No</td>
		</tr>
		'.$htmltabledata.'
		</table>
		<br><br>

		<p>Education-Name and location of each institute attended:</p>

		<table width="100%" border="1">
		<tr>
		<td>Institute</td>
		<td>Year</td>
		<td>Subjects</td>
		<td>Graduated</td>
		</tr>
		'.$oldata.'
		'.$aldata.'
		'.$higheredudata.'
		</table>

		<br><br>
		<p>Expected Salary Scale: '.$employee_details['basic_salary'].'</p>
		<br>
		</div>

		<br><br><br>
		<table width="100%">
		<tr>
		<td align="center">..........................................</td>
		<td align="center">..........................................</td>
		</tr>
		<tr>
		<td align="center">Applicant Signature</td>
		<td align="center">Date</td>
		</tr>

		</table>';




		$date = date('Y-m-d H-i-s');
		$filename = $employee_details['emp_no'].'_'.$date.'Application_for_Employment.pdf';
		$pdfroot = "./pdfs/application_for_employment/".$filename;
		$fileroot = "/pdfs/application_for_employment/".$filename;

		//insert letter data ..
		// $data_letter['emp_id']=$employee_details['id'];
		// $data_letter['letter_type']=10;
		// $data_letter['date']=date("Y-m-d");
		// $data_letter['file']=$fileroot;
		//$this->letter_model->insert_letter($data_letter);

		// Load library
		$this->load->library('dompdf_gen');
		// Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		ob_end_clean();
		$this->dompdf->stream($filename.".pdf");
		//$pdf_string = $this->dompdf->output();
		//file_put_contents($pdfroot, $pdf_string );

	}

	public function employee_appraisal()
	{
		if ( ! check_access('view_employee_appraisal'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$viewData['category'] = $this->employee_model->get_performance_category();
		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['appraisal_data']=$appraisal_data=$this->employee_model->get_employee_appraisal_data();
		$apprasal_category_data=Null;
		if($appraisal_data){
		foreach ($appraisal_data as $key => $value) {
			$apprasal_category_data[$value->id]=$this->employee_model->get_employee_appraisal_categorydata($value->id);
		}
	}
		$viewData['apprasal_category_data']=$apprasal_category_data;
		$this->load->view('hr/employee/employee_appraisal',$viewData);
	}

	public function add_employee_appraisal()
	{

		if ( ! check_access('add_employee_appraisal'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id=$this->employee_model->add_employee_appraisal();
		if($id){
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Employee Appraisal Added Successfully');
			$this->logger->write_message("success", $this->input->post('holiday_date').' Employee Appraisal Added Successfully');

		}else{
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Something Went Wrong, Please Add Again.');
			$this->logger->write_message("success",$this->input->post('holiday_date').' Something Went Wrong, Please Add Again');

		}
		redirect("hr/employee/employee_appraisal");
	}

	function view_appraisal_marks($id)
	{
		$viewData['appraisal_data'] = $this->employee_model->get_employee_appraisal_categorydata($id);
		$viewData['appraisal_commentdata'] =$appraisal_data= $this->employee_model->get_employee_appraisal_data_byemp($id);
		$this->load->view('hr/employee/employee_appraisal_data',$viewData);
	}

	// function employee_print($id)
	// {
	// 	$viewData['appraisal_data']=$appraisal_data=$this->employee_model->get_employee_appraisal_data();
	// 	$viewData['emp_data'] =$empDetails=$this->employee_model->get_employee_details($id);
	// 	$this->load->view('user/leave_application_print', $viewData);
	// }

	function emp_appraisal_comment($id)
	{
		$viewData['appraisal_data'] =$appraisal_data= $this->employee_model->get_employee_appraisal_data_byemp($id);
		$viewData['emp_data'] =$employee_details= $this->employee_model->get_employee_details($appraisal_data->emp_no);

		$this->load->view('hr/employee/employee_appraisal_empcommet', $viewData);
	}
	function addemp_appraisal_comment()
	{
		$id=$this->employee_model->add_employee_appraisal_comment();
		if($id){
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Employee Appraisal Comment Added Successfully');
			$this->logger->write_message("success", $this->input->post('holiday_date').' Employee Appraisal Comment Added Successfully');

		}else{
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Something Went Wrong, Please Add Again.');
			$this->logger->write_message("success",$this->input->post('holiday_date').' Something Went Wrong, Please Add Again');

		}
		redirect("hr/employee/employee_appraisal");
	}
	function appraisal_delete($id)
	{
		$id=$this->employee_model->appraisal_statueschange($id,'Canceled');
		if($id){
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Employee Appraisal Deleted Successfully');
			$this->logger->write_message("success", $this->input->post('holiday_date').' Employee Appraisal Deleted Successfully');

		}else{
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Something Went Wrong, Please Add Again.');
			$this->logger->write_message("success",$this->input->post('holiday_date').' Something Went Wrong, Please Add Again');

		}
		redirect("hr/employee/employee_appraisal");
	}
	function appraisal_confirm($id)
	{
		$id=$this->employee_model->appraisal_statueschange($id,'Confirmed');
		if($id){
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Employee Appraisal Confirmed Successfully');
			$this->logger->write_message("success", $this->input->post('holiday_date').' Employee Appraisal Confirmed Successfully');

		}else{
			$this->session->set_flashdata('msg', $this->input->post('holiday_date').' Something Went Wrong, Please Add Again.');
			$this->logger->write_message("success",$this->input->post('holiday_date').' Something Went Wrong, Please Add Again');

		}
		redirect("hr/employee/employee_appraisal");
	}
	function employee_appraisal_print($id)
	{

		$viewData['appraisal_data'] =$appraisal_data= $this->employee_model->get_employee_appraisal_data_byemp($id);
		$viewData['emp_data'] =$employee_details= $this->employee_model->get_employee_details($appraisal_data->emp_no);
		$viewData['division'] = $this->common_hr_model->get_division_details($employee_details['division']);
		$viewData['designation'] = $this->common_hr_model->get_designation_details($employee_details['designation']);
		$viewData['appraisal_categorydata']=$this->employee_model->get_employee_appraisal_categorydata($appraisal_data->id);

		$this->load->view('hr/employee/employee_appraisal_print', $viewData);
	}
/*appraisal module end 2020-07-30 updated by nadee*/

	//added by eranga to update emp entries
	function update_employees(){
		if($this->employee_model->update_employees()){
			echo 'Success';
		}
	}

//updated by nadee
	function search()
	{
		if ( ! check_access('employee_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}


		$data['datalist'] = $this->employee_model->get_all_employee_details_search();


				$data1['title'] = "Employee List";
				$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
				$this->load->view('hr/employee/list_emp_view_search', $data);
				$this->load->view('includes/footer');
	}
}
