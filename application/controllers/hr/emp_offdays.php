<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_offdays extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->model("hr/employee_model");
		$this->load->model("hr/common_hr_model");
		$this->load->model("hr/config_model");
    $this->load->model("hr/emp_off_day_model");
    $this->load->library('form_validation');
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

  public function off_day_request(){

    	$data['title'] = "Day Off Request";

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
		$config['base_url'] = site_url('hr/emp_offdays/off_day_request');
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
		$viewData['datalist'] = $this->emp_off_day_model->dayoff_request_details($pagination_counter, $page_count);
		$config['total_rows'] = $this->db->count_all('hr_emp_leave_offdays');
		$this->pagination->initialize($config);

    	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
    	$this->load->view('hr/offdays/emp_off_day_request', $viewData);
    	$this->load->view('includes/footer');
	}



  public function submit_day_off(){
		$this->form_validation->set_rules('emp_id', 'Employee', 'required');
		$this->form_validation->set_rules('from_date', 'From date', 'required');
		$this->form_validation->set_rules('to_date', 'To date', 'required');
		if($this->form_validation->run()){


			$update_status = $this->emp_off_day_model->submit_day_off();
			if(empty($update_status['upload_data_failed'])){
				$this->session->set_flashdata('msg',"Employee off day added successfully");
				echo json_encode(['success'=>'Employee off day added successfully']);
			}else{
				$errors = $update_status['upload_data_failed'];
				echo json_encode(['error'=>$errors]);
			}
		}else{
			$errors = validation_errors();
            echo json_encode(['error'=>$errors]);
      	}
		die();
	}

	function confirm_day_off(){
		$day_off_id = $_REQUEST['id'];
		$statues= $_REQUEST['statues'];
		$this->emp_off_day_model->confirm_cancel_day_off($day_off_id,$statues);
		$this->session->set_flashdata('msg',"Employee day off confirmed successfully");
		echo json_encode(['success'=>'Employee day off confirmed successfully']);
		die();
	}
	function leave_delete(){
		$id=$this->emp_off_day_model->leave_delete($this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Leave Record Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).'Leave Record Deleted');
		redirect("hr/employee/leave_list");
	}

	public function leave_search(){

		$emp_id=$this->uri->segment(4);
		$viewData['datalist'] = $this->emp_off_day_model->get_employee_leave_search($emp_id);

		$this->load->view('hr/employee/emp_leave_search_view', $viewData);

	}

}
