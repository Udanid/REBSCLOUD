<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hr_config extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->model("hr/employee_model");
		$this->load->model("hr/common_hr_model");
		$this->load->model("hr/config_model");
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

	public function employment_type(){
		if ( ! check_access('employee_type'))
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
		$config['base_url'] = site_url('hr/hr_config/employment_type');
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
		$data['datalist'] = $this->config_model->get_all_employment_types($pagination_counter, $page_count);
		$config['total_rows'] = $this->db->count_all('hr_employment_types');
		$this->pagination->initialize($config);

      	$data1['title'] = "Employment Types";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/employment_type_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_employment_type(){
		if ( ! check_access('employee_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_employment_type();
		$this->session->set_flashdata('msg', 'Employment Type Successfully Added');
		redirect("hr/hr_config/employment_type");
	}

	public function edit_employment_type(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_employment_type_details($id);
		$this->load->view('hr/config/edit_employment_type_view', $data);
	}

	public function update_employment_type(){
		if ( ! check_access('employee_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_employment_type();
		$this->session->set_flashdata('msg', 'Employment Type Successfully Updated');
		redirect("hr/hr_config/employment_type");
	}

	public function delete_employment_type(){
		if ( ! check_access('employee_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_employment_type($id);
		$this->session->set_flashdata('msg', 'Employment Type Successfully Deleted');
		redirect("hr/hr_config/employment_type");
	}

	public function designation(){
		if ( ! check_access('view_designation'))
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
		$config['base_url'] = site_url('hr/hr_config/designation');
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
		$data['datalist'] = $this->config_model->get_all_designations($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_dsgntion');
		$this->pagination->initialize($config);

      	$data1['title'] = "Designations";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/designation_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_designation(){
		if ( ! check_access('add_designation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_designation();
		$this->session->set_flashdata('msg', 'Designation Successfully Added');
		redirect("hr/hr_config/designation");
	}

	public function edit_designation(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_designation_details($id);
		$this->load->view('hr/config/edit_designation_view', $data);
	}

	public function update_designation(){
		if ( ! check_access('edit_designation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_designation();
		$this->session->set_flashdata('msg', 'Designation Successfully Updated');
		redirect("hr/hr_config/designation");
	}

	public function delete_designation(){
		if ( ! check_access('delete_designation'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_designation($id);
		$this->session->set_flashdata('msg', 'Designation Successfully Deleted');
		redirect("hr/hr_config/designation");
	}

	public function division(){
		if ( ! check_access('view_division'))
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
		$config['base_url'] = site_url('hr/hr_config/division');
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
		$data['datalist'] = $this->config_model->get_all_divisions($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_division');
		$this->pagination->initialize($config);

      	$data1['title'] = "Divisions";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/division_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_division(){
		if ( ! check_access('view_division'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_division();
		$this->session->set_flashdata('msg', 'Division Successfully Added');
		redirect("hr/hr_config/division");
	}

	public function edit_division(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_division_details($id);
		$this->load->view('hr/config/edit_division_view', $data);
	}

	public function update_division(){
		if ( ! check_access('edit_division'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_division();

		$this->session->set_flashdata('msg', 'Division Successfully Updated');
		redirect("hr/hr_config/division");
	}

	public function delete_division(){
		if ( ! check_access('delete_division'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_division($id);
		$this->session->set_flashdata('msg', 'Division Successfully Deleted');
		redirect("hr/hr_config/division");
	}

	public function allowance(){
		if ( ! check_access('view_allowance'))
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
		$config['base_url'] = site_url('hr/hr_config/allowance');
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
		$data['datalist'] = $this->config_model->get_all_allowances($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_allowances');
		$this->pagination->initialize($config);

      	$data1['title'] = "Allowance";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/allowance_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_allowance(){
		if ( ! check_access('add_allowance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_allowance();
		$this->session->set_flashdata('msg', 'Allowance Successfully Added');
		redirect("hr/hr_config/allowance");
	}

	public function edit_allowance(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_allowance_details($id);
		$this->load->view('hr/config/edit_allowance_view', $data);
	}

	public function update_allowance(){
		if ( ! check_access('edit_allowance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_allowance();
		$this->session->set_flashdata('msg', 'Allowance Successfully Updated');
		redirect("hr/hr_config/allowance");
	}

	public function delete_allowance(){
		if ( ! check_access('delete_allowance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_allowance($id);
		$this->session->set_flashdata('msg', 'Allowance Successfully Deleted');
		redirect("hr/hr_config/allowance");
	}

	public function loan(){
		if ( ! check_access('emp_loan_config'))
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
		$config['base_url'] = site_url('hr/hr_config/loan');
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
		$data['datalist'] = $this->config_model->get_all_loans($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_loans');
		$this->pagination->initialize($config);

      	$data1['title'] = "Company Loan";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/loan_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_loan(){
		$this->config_model->add_loan();
		$this->session->set_flashdata('msg', 'Loan Successfully Added');
		redirect("hr/hr_config/loan");
	}

	public function edit_loan(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_loan_details($id);
		$this->load->view('hr/config/edit_loan_view', $data);
	}

	public function update_loan(){
		if ( ! check_access('emp_loan_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_loan();
		$this->session->set_flashdata('msg', 'Loan Successfully Updated');
		redirect("hr/hr_config/loan");
	}

	public function delete_loan(){
		if ( ! check_access('emp_loan_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_loan($id);
		$this->session->set_flashdata('msg', 'Loan Successfully Deleted');
		redirect("hr/hr_config/loan");
	}

	public function deduction(){
		if ( ! check_access('view_deduction'))
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
		$config['base_url'] = site_url('hr/hr_config/deduction');
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
		$data['datalist'] = $this->config_model->get_all_deductions($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_deductions');
		$this->pagination->initialize($config);

      	$data1['title'] = "Deduction";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/deduction_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_deduction(){
		if ( ! check_access('add_deduction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_deduction();
		$this->session->set_flashdata('msg', 'Deduction Successfully Added');
		redirect("hr/hr_config/deduction");
	}

	public function edit_deduction(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_deduction_details($id);
		$this->load->view('hr/config/edit_deduction_view', $data);
	}

	public function update_deduction(){
		if ( ! check_access('edit_deduction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_deduction();
		$this->session->set_flashdata('msg', 'Deduction Successfully Updated');
		redirect("hr/hr_config/deduction");
	}

	public function delete_deduction(){
		if ( ! check_access('delete_deduction'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_deduction($id);
		$this->session->set_flashdata('msg', 'Deduction Successfully Deleted');
		redirect("hr/hr_config/deduction");
	}

	public function epf_etf(){
		if ( ! check_access('epf_etf_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$data['datalist'] = $this->config_model->get_all_epf_etf();
      	$data1['title'] = "Deduction";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/epf_etf_view', $data);
      	$this->load->view('includes/footer');
	}

	public function edit_epf_etf(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_epf_etf_details($id);
		$this->load->view('hr/config/edit_epf_etf_view', $data);
	}

	public function update_epf_etf(){
		if ( ! check_access('epf_etf_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_epf_etf();
		$this->session->set_flashdata('msg', 'EPF/ETF Successfully Updated');
		redirect("hr/hr_config/epf_etf");
	}

	public function equipment_category(){
		if ( ! check_access('equipment_config'))
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
		$config['base_url'] = site_url('hr/hr_config/equipment_category');
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
		$data['datalist'] = $this->config_model->get_all_equipment_categories($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_equipment_categories');
		$this->pagination->initialize($config);

      	$data1['title'] = "Equipment Category";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/equipment_category_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_equipment_category(){
		if ( ! check_access('equipment_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_equipment_category();
		$this->session->set_flashdata('msg', 'Equipment Category Successfully Added');
		redirect("hr/hr_config/equipment_category");
	}

	public function edit_equipment_category(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_equipment_category_details($id);
		$this->load->view('hr/config/edit_equipment_category_view', $data);
	}

	public function update_equipment_category(){
		if ( ! check_access('equipment_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_equipment_category();
		$this->session->set_flashdata('msg', 'Equipment Category Successfully Updated');
		redirect("hr/hr_config/equipment_category");
	}

	public function delete_equipment_category(){
		if ( ! check_access('equipment_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_equipment_category($id);
		$this->session->set_flashdata('msg', 'Equipment Category Successfully Deleted');
		redirect("hr/hr_config/equipment_category");
	}

	public function paye(){
		if ( ! check_access('paye_config'))
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
		$config['base_url'] = site_url('hr/hr_config/paye');
		$config['uri_segment'] = 4;

		$pagination_counter = 10;
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
		$data['datalist'] = $this->config_model->get_all_paye($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_paye');
		$this->pagination->initialize($config);

      	$data1['title'] = "Paye";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/paye_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_paye(){
		if ( ! check_access('paye_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_paye();
		$this->session->set_flashdata('msg', 'Paye Category Successfully Added');
		redirect("hr/hr_config/paye");
	}

	public function edit_paye(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_paye_details($id);
		$this->load->view('hr/config/edit_paye_view', $data);
	}

	public function update_paye(){
		if ( ! check_access('paye_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_paye();
		$this->session->set_flashdata('msg', 'Paye Category Successfully Updated');
		redirect("hr/hr_config/paye");
	}

	public function delete_paye(){
		if ( ! check_access('paye_config'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_paye($id);
		$this->session->set_flashdata('msg', 'Paye Category Successfully Deleted');
		redirect("hr/hr_config/paye");
	}

	public function leave_category(){
		if ( ! check_access('leave_category_config_view'))
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
		$config['base_url'] = site_url('hr/hr_config/leave_category');
		$config['uri_segment'] = 4;

		$pagination_counter = 10;
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
		$data['datalist'] = $this->config_model->get_all_leave_categories($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_leave_categories');
		$this->pagination->initialize($config);

      	$data1['title'] = "Leave Category";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/leave_category_view', $data);
      	$this->load->view('includes/footer');
	}

	public function add_leave_category(){
		if ( ! check_access('leave_category_config_add'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_leave_category();
		$this->session->set_flashdata('msg', 'Leave Category Successfully Added');
		redirect("hr/hr_config/leave_category");
	}

	public function edit_leave_category(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_leave_category_details($id);
		$this->load->view('hr/config/edit_leave_category_view', $data);
	}

	public function update_leave_category(){
		if ( ! check_access('leave_category_config_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_leave_category();
		$this->session->set_flashdata('msg', 'Leave Category Successfully Updated');
		redirect("hr/hr_config/leave_category");
	}

	public function delete_leave_category(){
		if ( ! check_access('leave_category_config_delete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_leave_category($id);
		$this->session->set_flashdata('msg', 'Leave Category Successfully Deleted');
		redirect("hr/hr_config/leave_category");
	}

	public function fuel_allowance_rate(){

		$this->load->library('pagination');
		$page_count = (int)$this->uri->segment(4);

		if(!$page_count)
		$page_count = 0;

		/* Pagination configuration */
		$config['base_url'] = site_url('hr/hr_config/fuel_allowance_rate');
		$config['uri_segment'] = 4;

		$pagination_counter = 10;
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
		$viewData['datalist'] = $this->config_model->get_all_fuel_allowance_rates($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('hr_fuel_allowance_rates');
		$this->pagination->initialize($config);
		$viewData['ratelist'] = $this->config_model->get_fuel_allowance_rate_updates();
      	$data1['title'] = "Fuel Allowance Rate";
      	$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
		$this->load->view('includes/topbar_notsearch');
      	$this->load->view('hr/config/fuel_allowance_rate_view', $viewData);
      	$this->load->view('includes/footer');
	}

	public function add_fuel_allowance_rate(){
		if ( ! check_access('fuel_allowance_rate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->add_fuel_allowance_rate();
		$this->session->set_flashdata('msg', 'Fuel Allowance Rate Successfully Added');
		redirect("hr/hr_config/fuel_allowance_rate");
	}

	public function edit_fuel_allowance_rate(){

		$id = (int)$this->uri->segment(4);
		$data['details'] = $this->config_model->get_fuel_allowance_rate_details($id);
		$this->load->view('hr/config/edit_fuel_allowance_rate_view', $data);
	}

	public function update_fuel_allowance_rate(){
		if ( ! check_access('fuel_allowance_rate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->config_model->update_fuel_allowance_rate();
		$this->session->set_flashdata('msg', 'Fuel Allowance Rate Successfully Updated');
		redirect("hr/hr_config/fuel_allowance_rate");
	}

	public function delete_fuel_allowance_rate(){
		if ( ! check_access('fuel_allowance_rate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id = $this->uri->segment(4);
		$this->config_model->delete_fuel_allowance_rate($id);
		$this->session->set_flashdata('msg', 'Fuel Allowance Rate Successfully Deleted');
		redirect("hr/hr_config/fuel_allowance_rate");
	}

	function add_fuel_allowance_rate_period(){
		if ( ! check_access('fuel_allowance_rate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id=$this->config_model->add_fuel_allowance_rate_period();
		if($id){
			$this->session->set_flashdata('msg', 'Fuel Allowance Rate Successfully Updated');
			redirect("hr/hr_config/fuel_allowance_rate");
		}else{
			$this->session->set_flashdata('error', 'Something went wrong, Please try again..!');
			redirect("hr/hr_config/fuel_allowance_rate");
		}
	}
	//run hr year end
	//delete leave tables

	function year_end(){
		if ( ! check_access('hr_year_end'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$this->load->view('includes/header_'.$this->session->userdata('usermodule'));
		$this->load->view('includes/topbar_notsearch');
		$this->load->view('hr/config/year_end');
		$this->load->view('includes/footer');
	}

	function hr_year_end(){
		if ( ! check_access('hr_year_end'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('menu_call/showdata/hr');
			return;
		}
		$id=$this->config_model->hr_year_end();
		if($id){
			echo json_encode($id);
		}
	}

	/*updated by nadee 2020-07-30*/

		public function performance_category()
		{
			$data['categories']=$this->config_model->get_performance_category('');
			$this->load->view('hr/config/performance_category',$data);

		}

		function add_performance_category()
		{
			$add=$this->config_model->add_performance_category();
			if($add){
				$this->session->set_flashdata('msg', 'Successfully Added');
			}else {
				$this->session->set_flashdata('error', 'Something Went Wrong! Please Try Again .. ');
			}
			redirect("hr/hr_config/performance_category");
		}

		function edit_perfomance_category($id)
		{
			$id = (int)$this->uri->segment(4);
			$data['details'] = $this->config_model->get_performance_category($id);
			$this->load->view('hr/config/edit_perfomance_category', $data);
		}

		function update_perfomance_category()
		{
			$add=$this->config_model->update_performance_category();
			if($add){
				$this->session->set_flashdata('msg', 'Successfully Updated');
			}else {
				$this->session->set_flashdata('error', 'Something Went Wrong! Please Try Again .. ');
			}
			redirect("hr/hr_config/performance_category");
		}

		//update by nadee 2020-12-23
		function view_hr_ledgers()
		{
			$data['details'] = $this->config_model->get_hr_ledgers();
			$data1['title'] = "HR Config";
			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
	$this->load->view('includes/topbar_notsearch');

			$this->load->view('hr/config/hr_ledgers_all', $data);
			$this->load->view('includes/footer');
		}

		function update_ledger()
		{
			$add = $this->config_model->update_hr_ledgers();
			if($add){
				$this->session->set_flashdata('msg', 'Successfully Updated');
			}else {
				$this->session->set_flashdata('error', 'Something Went Wrong! Please Try Again .. ');
			}
			redirect("hr/hr_config/view_hr_ledgers");
		}

		//2908
		public function other_deduction(){
			if ( ! check_access('deduction_view'))
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
			$config['base_url'] = site_url('hr/hr_config/other_deduction');
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
			$data['datalist'] = $this->config_model->get_all_otherdeduct_fields($pagination_counter,$page_count);
			$config['total_rows'] = $this->db->count_all('hr_insentive');
			$this->pagination->initialize($config);

					$data1['title'] = "incentive_view";
					$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
			$this->load->view('includes/topbar_notsearch');
					$this->load->view('hr/config/otherdeduct_view',$data);
					$this->load->view('includes/footer');




					/*$data['datalist'] = $this->config_model->get_all_incentive_fields($pagination_counter,$page_count);

					print_r($data['datalist']);
					die();*/



		}
		public function add_other_deduction()
		{
			if ( ! check_access('deduction_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}
			$this->config_model->add_otherdeduct_field();
			$this->session->set_flashdata('msg', 'Other Deduction Field Successfully Added');
			redirect("hr/hr_config/other_deduction");
		}

		public function edit_other_deduction(){
			if ( ! check_access('deduction_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}



			$id = (int)$this->uri->segment(4);
			$data['details'] = $this->config_model->get_otherdeduct_details($id);



			$this->load->view('hr/config/edit_otherdeduct_view',$data);
		}


		public function update_other_deduction(){

			if ( ! check_access('deduction_view'))
			{
				$this->session->set_flashdata('error', 'Permission Denied');
				redirect('menu_call/showdata/hr');
				return;
			}

			$this->config_model->update_otherdeduct_details();

			$this->session->set_flashdata('msg', 'Incentive Successfully Updated');
			redirect("hr/hr_config/other_deduction");
		}

		/*start qualification field by dileep*/

public function qualification_field(){
	if ( ! check_access('qualification_field_view'))
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
	$config['base_url'] = site_url('hr/hr_config/qualification_field');
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
	$data['datalist'] = $this->config_model->get_all_qualification_fields($pagination_counter,$page_count);
	$config['total_rows'] = $this->db->count_all('hr_qualification_field');
	$this->pagination->initialize($config);

			$data1['title'] = "qualification_fields";
			$this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data1);
	$this->load->view('includes/topbar_notsearch');
			$this->load->view('hr/config/qualification_field_view', $data);
			$this->load->view('includes/footer');

}

public function add_qualification_field(){
	if ( ! check_access('qualification_field_view'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$this->config_model->add_qualification_field();
	$this->session->set_flashdata('msg', 'Qualification Field Successfully Added');
	redirect("hr/hr_config/qualification_field");
}

public function edit_qualification_field(){

	$id = (int)$this->uri->segment(4);
	$data['details'] = $this->config_model->get_qualification_field_details($id);
	$this->load->view('hr/config/edit_qualification_field_view', $data);
}

public function update_qualification_field(){
	if ( ! check_access('qualification_field_edit'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$this->config_model->update_qualification_field();

	$this->session->set_flashdata('msg', 'Qualification Field Successfully Updated');
	redirect("hr/hr_config/qualification_field");
}

public function delete_qualification_field(){
	if ( ! check_access('qualification_field_delete'))
	{
		$this->session->set_flashdata('error', 'Permission Denied');
		redirect('menu_call/showdata/hr');
		return;
	}
	$id = $this->uri->segment(4);
	$this->config_model->delete_qualification_field($id);
	$this->session->set_flashdata('msg', 'Qualification Field Successfully Deleted');
	redirect("hr/hr_config/qualification_field");
}

/*Qualification field end */





}
