<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leave extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->model("user/user_model");
		$this->load->model("hr/common_hr_model");
		$this->load->library('form_validation');
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	function apply(){
    	$data['title'] = "Leave Apply";
		$data['searchpath']='';

		$userid = $this->session->userdata('userid');
		$user_details = $this->user_model->get_employee_details($userid);

		$viewData['user_details'] = $user_details;

		$viewData['leave_category_details'] = $this->common_hr_model->get_leave_category_details($user_details['leave_category']);

		$viewData['active_user_leave_records'] = $this->user_model->get_user_active_leave_records($user_details['id']);
		$viewData['get_employee'] = $this->common_hr_model->get_employee_list();
    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('user/leave_apply_view', $viewData);
    	$this->load->view('includes/footer');
	}

  	public function leave_submit(){

		$this->form_validation->set_rules('leave_type', 'SLeave Type', 'required');
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('end_date', 'End Date', 'required');
		$this->form_validation->set_rules('no_of_days', 'No Of Days', 'required');
		$this->form_validation->set_rules('officer_in_charge', 'Officer in charge', 'required');



		if($this->form_validation->run()){
			$check_pending_system_leave=$this->user_model->check_pending_system_leave();
			$check_pending_leave=$this->user_model->check_pending_leave();
			if($check_pending_system_leave=="allow_leave_apply" && $check_pending_leave=="allow_leave_apply"){
				$this->user_model->leave_submit();

				$this->session->set_flashdata('msg',"Leave request submitted successfully");
				echo json_encode(['success'=>'Leave request submitted successfully']);
			}elseif($check_pending_leave=="have_pending_leave"){
				$this->session->set_flashdata('error',"You already applied leave for this day");
				echo json_encode(['error'=>"You already applied leave for this day"]);
			}else{

				$this->session->set_flashdata('error',"You have pending leave dates to apply leave or You alreay applied leave for this day");
				echo json_encode(['error'=>"You have pending leave dates to apply leave"]);
			}

		}else{
			$errors = validation_errors();
            echo json_encode(['error'=>$errors]);
      	}
		die();
  	}

  	public function leave_list(){
		$userid = $this->session->userdata('userid');
		$user_details = $this->user_model->get_employee_details($userid);

		$viewData['leave_category_details'] = $this->common_hr_model->get_leave_category_details($user_details['leave_category']);

		$viewData['active_user_leave_records'] = $this->user_model->get_user_active_leave_records($userid);
		$viewData['system_pending_leave_records']=$this->user_model->get_system_pending_leave_records($userid);


    	$data['title'] = "Employee Equipment";
		$data['searchpath']='';

		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(4);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('leave/leave_list');
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
		$data['datalist'] = $this->user_model->get_all_emp_leave_records($pagination_counter, $page_count, $userid);
		$query = $this->db->where('emp_record_id', $userid)->get('hr_emp_leave_records');
		$total_rows = $query->num_rows();
		$config['total_rows'] = $total_rows;
		$this->pagination->initialize($config);

    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('user/emp_leave_view', $viewData);
    	$this->load->view('includes/footer');
  	}

  	public function approve_leave(){

		$session = array('usermodule'=>'hr');
		$this->session->set_userdata($session);

    	$data['title'] = "Employee Leave Approval List";
		$data['searchpath']='';

		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(3);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('leave/approve_leave');
		$config['uri_segment'] = 3;

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

		$userid = $this->session->userdata('userid');

		$team_employees_details = $this->user_model->check_immediate_manager($userid);

		$j = 0;
		$employee_list = array();
		foreach($team_employees_details as $team_employee){
			$employee_list['employee_id'][$j] = $team_employee->id;
			$j++;
		}
		if(count($employee_list)>0){
			$team_employees_leave_records = $this->user_model->get_team_employees_leave_records($employee_list);
			$viewData['team_employees_leave_records'] = $team_employees_leave_records;
			$viewData['datalist'] = $this->user_model->get_all_get_team_employees_leave_records($pagination_counter, $page_count, $employee_list);
		}else{
			$team_employees_leave_records = array();
			$viewData['datalist'] = "";
		}

		$config['total_rows'] = count($team_employees_leave_records);
		$this->pagination->initialize($config);

    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('user/leave_approval_view', $viewData);
    	$this->load->view('includes/footer');
  	}

  	public function user_leave_confirm(){
		$record_id = $_REQUEST['record_id'];
		$this->user_model->user_leave_confirm($record_id);
		$this->session->set_flashdata('msg',"Leave approved successfully");
		echo json_encode(['success'=>'Leave approved successfully']);
		die();
  	}

  	public function decline_user_leave(){
		$id = $this->uri->segment(3);
		$this->user_model->decline_user_leave($id);
		$this->session->set_flashdata('msg',"Leave request decline successfully");
		redirect('leave/approve_leave');
  	}

  	public function duty_in(){
		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');

		$user_details = $this->user_model->get_employee_details($userid);
		if($user_details['status'] == 'D' || $user_details['attendance_type'] == 'F'){
			redirect(base_url()."user");
		}

		$attendance_details = $this->user_model->get_attendance_details($userid);
		if(!count($attendance_details)>0){
			$this->user_model->mark_employee_duty_in($userid, $username);
			$this->session->set_flashdata('msg',"Duty In");
		}else{
			$this->session->set_flashdata('msg',"Already you marked Duty In for the day.");
		}
		//redirect(base_url()."user");
  	}

  	public function duty_out(){
		$userid = $this->session->userdata('userid');

		$user_details = $this->user_model->get_employee_details($userid);
		if($user_details['status'] == 'D' || $user_details['attendance_type'] == 'F'){
			redirect(base_url()."login");
		}
		$attendance_details = $this->user_model->get_attendance_details($userid);

		$duty_out = $attendance_details['duty_out'];
		if(count($attendance_details)>0 && empty($duty_out)){
			$this->user_model->mark_employee_duty_out($attendance_details['id'],'','');
			$this->session->set_flashdata('msg',"Duty Off");
		}else{
			$this->session->set_flashdata('msg',"Already you marked Duty Off for today.");
		}
		redirect(base_url()."login");
  	}

  	public function go_out(){
		$username = $this->session->userdata('username');
		$userid = $this->session->userdata('userid');

		$user_details = $this->user_model->get_employee_details($userid);
		if($user_details['status'] == 'D' || $user_details['attendance_type'] == 'F'){
			redirect(base_url()."login");
		}

		$go_in_out_attendance_details = $this->user_model->get_go_in_out_attendance_details($userid);
		$go_in = $go_in_out_attendance_details['go_in'];
		if(!count($go_in_out_attendance_details)>0 || !empty($go_in)){
			$this->user_model->mark_employee_go_out($userid, $username);
			$this->session->set_flashdata('msg',"Go Out");
		}else{
			$this->session->set_flashdata('msg',"Already you marked Go Out.");
		}
		redirect(base_url()."login");
  	}

  	public function go_in(){
		$userid = $this->session->userdata('userid');

		$user_details = $this->user_model->get_employee_details($userid);
		if($user_details['status'] == 'D' || $user_details['attendance_type'] == 'F'){
			redirect(base_url()."user");
		}

		$go_in_out_attendance_details = $this->user_model->get_go_in_out_attendance_details($userid);
		$go_in = $go_in_out_attendance_details['go_in'];
		if(count($go_in_out_attendance_details)>0 && empty($go_in)){
			$id = $go_in_out_attendance_details['id'];
			$this->user_model->mark_employee_go_in($id);
			$this->session->set_flashdata('msg',"Go In");
		}else{
			$this->session->set_flashdata('msg',"Already you marked Go In.");
		}
		redirect(base_url()."user");
  	}
		// add by nadee
		function officer_in_charge()
		{
			$session = array('usermodule'=>'hr');
			$this->session->set_userdata($session);

	    	$data['title'] = "Employee Leave Approval List";
			$data['searchpath']='';
			$userid = $this->session->userdata('userid');

			$team_employees_details = $this->user_model->check_officer_in_charge($userid);

			$j = 0;
			$employee_list = array();
			foreach($team_employees_details as $team_employee){
				$employee_list['employee_id'][$j] = $team_employee->emp_record_id;
				$j++;
			}
			if(count($employee_list)>0){
				$team_employees_leave_records = $this->user_model->get_team_employees_leave_records($employee_list);
				$viewData['team_employees_leave_records'] = $team_employees_leave_records;
				$viewData['datalist'] = $this->user_model->get_all_team_employees_leave_records($employee_list);
			}else{
				$team_employees_leave_records = array();
				$viewData['datalist'] = "";
			}

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('user/office_in_charge', $viewData);
    	$this->load->view('includes/footer');
		}
		function user_oic_confirm()
		{
			$record_id = $_REQUEST['record_id'];
			$this->user_model->user_oic_confirm($record_id);
			$this->session->set_flashdata('msg',"Leave approved successfully");
			echo json_encode(['success'=>'Leave approved successfully']);
			die();
		}

}
