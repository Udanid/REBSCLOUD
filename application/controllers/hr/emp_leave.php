<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emp_leave extends CI_Controller {


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


		public function leave_list(){
			if ( ! check_access('leave_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$data['title'] = "Employee Leave List";

		$viewData['employee_list'] = $this->employee_model->get_employee_list();

		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(4);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('hr/emp_leave/leave_list');
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
		$viewData['datalist'] = $this->employee_model->get_employee_leave_list($pagination_counter, $page_count);
		$config['total_rows'] = $this->db->count_all('hr_emp_leave_records');
		$this->pagination->initialize($config);

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/leave/emp_leave_list_view', $viewData);
			$this->load->view('includes/footer');
		}
		function emp_leave_list_excel()
		{
			if ( ! check_access('leave_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$data['title'] = "Employee Leave List";
			$viewData['employee_list'] = $this->employee_model->get_employee_list();
			$viewData['datalist'] = $this->employee_model->get_employee_leave_list_all();
			$this->load->view('hr/leave/emp_leave_report_excel', $viewData);
		}

		public function leave_report(){
			if ( ! check_access('leave_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$data['title'] = "Employee Leave Report";
		$viewData['branch_list'] = $this->common_hr_model->get_branch_list();

			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
		$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/leave/emp_leave_report_view', $viewData);
			$this->load->view('includes/footer');
		}

		public function view_leave_report(){
		if ( ! check_access('leave_view'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$year = $this->uri->segment(4);
		$branch = $this->uri->segment(5);

		if($branch == "all"){
			$branch = $this->uri->segment(5);
		}else{
			$branch_details = $this->common_hr_model->get_branch_details($branch);
			$branch = $branch_details['branch_name'];
		}

		$viewData['year'] = $year;
		$viewData['branch'] = $branch;

		$viewData['employee_list'] = $this->employee_model->get_employee_list();
		$viewData['leave_categories'] = $this->common_hr_model->get_leave_category_list();

		$viewData['view_leave_report'] = $this->employee_model->get_leave_report($year, $branch);
		$this->load->view('hr/leave/emp_leave_report_filter_view', $viewData);
		}


}
