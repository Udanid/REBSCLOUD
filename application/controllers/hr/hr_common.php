<?php 
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hr_common extends CI_Controller {
	
	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->model("hr/common_hr_model");
		$this->load->model("hr/employee_model");
    }
	
	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}
	
	function get_bank_branchlist(){
		$data['id'] = $this->uri->segment(4);
		$data['counter'] = $this->uri->segment(5);
		
		$data['branch_list'] = $this->common_hr_model->get_bank_branch_list($this->uri->segment(4));
		$this->load->view('hr/bank_branchlist', $data);
	}
	
	function get_edit_bank_branchlist(){
		$data['id'] = $this->uri->segment(4);
		$employee_id = $this->uri->segment(5);
		$data['bank_details'] = $this->employee_model->get_bank_details($employee_id);
		
		$data['branch_list'] = $this->common_hr_model->get_bank_branch_list($this->uri->segment(4));
		$this->load->view('hr/edit_bank_branchlist', $data);
	}
	
	function get_confirm_bank_branchlist(){
		$data['id'] = $this->uri->segment(4);
		$employee_id = $this->uri->segment(5);
		$data['bank_details'] = $this->employee_model->get_bank_details($employee_id);
		
		$data['branch_list'] = $this->common_hr_model->get_bank_branch_list($this->uri->segment(4));
		$this->load->view('hr/confirm_bank_branchlist', $data);
	}
		
	
}

