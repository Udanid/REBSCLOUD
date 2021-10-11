<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salary_advance extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->is_logged_in();
		$this->load->model("hr/employee_model");
		$this->load->model("hr/common_hr_model");
		$this->load->model("hr/config_model");
    $this->load->model("hr/salary_advance_model");
    $this->load->library('form_validation');
    }

	function is_logged_in() {
		$is_logged_in = $this->session->userdata('username');
		if ((!isset($is_logged_in) || $is_logged_in == "")) {
			$this->session->sess_destroy();
			redirect('login');
		}
	}

  public function salary_advance_request(){
    $data['title'] = "Salary Advance Request";
    $data['searchpath']='';

    $this->load->view('includes/header_'.$this->session->userdata('usermodule'), $data);
  $this->load->view('includes/topbar_notsearch');
    $this->load->view('hr/salary_advance/salary_advance_request');
    $this->load->view('includes/footer');
	}

  public function salary_advance_submit(){
    $this->form_validation->set_rules('amount', 'Amount', 'required');

		if($this->form_validation->run()){
			$this->salary_advance_model->salary_advance_submit();
			$this->session->set_flashdata('msg',"Salary advance request submitted successfully");
			echo json_encode(['success'=>'Salary advance request submitted successfully']);
		}else{
			$errors = validation_errors();
            echo json_encode(['error'=>$errors]);
      	}
		die();
	}

  public function emp_salary_advance_list_data($month){
      $viewData['employee_list'] =$employee_list= $this->employee_model->get_employee_list();
      $request_data=Null;
			$basic_salary=Null;
			foreach ($employee_list as $employee) {
				if($employee->status == 'A' && $employee->salary_confirmation == 'Y'){
						$request_data[$employee->id]= $this->salary_advance_model->get_salary_advance_request($employee->id,$month);
						$basic_salary[$employee->id]=$this->salary_advance_model->check_basic_salary($employee->id);


				}

			}
			$viewData['salaries']=$basic_salary;

      $viewData['request_data']=$request_data;
      $this->load->view('hr/employee/emp_salary_advance_view_data',$viewData);
  }
}
