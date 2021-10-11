<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Controller {
   function __construct() {
        parent::__construct();
		$this->load->model("common_model");
		$this->load->model("user/user_model");
		$this->load->model("hr/employee_model");
    }
	
    function index() {
		

    }
	
	
	//created by udani 03-10-2012
	function activeflag_cheker(){
		//$this->load->model("config_model");
		$tabls=$this->input->get('table');
		$id=$this->input->get('id');
		$fieldname=$this->input->get('fieldname');
		if($this->common_model->check_common_activeflag($tabls,$id,$fieldname))
		{
			$data=$this->common_model->get_current_flaguser($tabls,$id,$fieldname);
			if($data->userid!=$this->session->userdata('userid'))
			{
			echo "This record already open by ".$data->initial.' '.$data->surname;
			}
			//echo "This record already open ";
		}
		//echo "This record already open ";
	//	$data['divisionlist']=$this->config_model->get_division_byzone($zondata->ZONENAME);
		//$this->load->view('manage/common/divisions', $data);
	}
	function delete_activflag()
	{
		$tabls=$this->input->get('table');
		$id=$this->input->get('id');
		$fieldname=$this->input->get('fieldname');
		$data=$this->common_model->delete_activflag($tabls,$id,$fieldname);
		//$data=0;
		if($data)
		{
			echo "Active Flag Closed";
			
		}
		
	}
	function get_bank_branchlist(){
		//$this->load->model("config_model");
		$data['id']=$this->uri->segment(3);
		$data['counter']=$this->uri->segment(4);
		
		//echo $this->uri->segment(3); 
		$data['branclist']=$this->common_model->get_bankbranchlist($this->uri->segment(3));
		$this->load->view('common/bank_branchlist', $data);
	}
	function get_subtask_list(){
		//$this->load->model("config_model");
		$data['taskid']=$this->uri->segment(3);
		$data['projectid']=$this->uri->segment(4);
		
		//echo $this->uri->segment(3); 
		$data['tasklist']=$this->common_model->get_project_subtask($this->uri->segment(3),$this->uri->segment(4));
		$this->load->view('common/subtask_list', $data);
	}
	function checkForChanges(){
		$new_type =check_notification_counter();
		if($new_type)
		{
		//	echo $new_type;
			$b='';
			 if($new_type){foreach($new_type as $raw){
								
								$b=$b.'<li><a href="'.base_url().$raw->module.'">';
									
								  $b=$b.' <div class="notification_desc">';
									$b=$b.'<p>'.$raw->mycount.' Pending '.$raw->notification.' </p>
									
									</div>
								  <div class="clearfix"></div>	
								 </a></li>';
                                  }}
								  echo $b;
								  
		}
		else
		echo 0;
			//$new_type;
		
	}
	
	function onAlerts(){
	
		$user_name = $this->session->userdata('user_name');
		
				$this->session->set_userdata('alerts', 'on');
				
	}
	
	function offAlerts(){
	
		
				$this->session->set_userdata('alerts', 'off');
			
		
	}
	function get_subtask_list_payment(){
		//$this->load->model("config_model");
		$data['taskid']=$this->uri->segment(3);
		$data['projectid']=$this->uri->segment(4);
		
		//echo $this->uri->segment(3); 
		$data['tasklist']=$this->common_model->get_subtask_payment($this->uri->segment(3));
		$this->load->view('common/subtask_list_payment', $data);
	}
	
	function get_user_notification_alert(){

        $user_id = $this->session->userdata('userid');
		$msg = array();
	
		$user_notify = check_notification();
		if($user_notify)
			foreach($user_notify as $data){
				$new = array($data->mycount,$data->notification,$data->module,$data->record_key);
				array_push($msg,$new);
		}
	
		$leave_records = $this->user_model->get_team_employees_leave_records_for_notificaton($user_id);
		if($leave_records){
		  $new2 = array(count($leave_records),'Pending Leave Requests','leave/approve_leave');
				array_push($msg,$new2);
		}
	
		$oic_leave_records = $this->user_model->get_oic_records_for_notificaton($user_id);
		if($oic_leave_records){
		  $new3 = array(count($oic_leave_records),'Pending Leave Requests Officer In Charge','leave/officer_in_charge');
				array_push($msg,$new3);
		}
	
		$additional_fuel_request="";
		$additional_fuel_request = $this->employee_model->get_all_pending_employee_additional_fuel_allowance_list();
		if($additional_fuel_request){
		  	$new4 = array(count($additional_fuel_request),'Additional Fuel Requests','hr/employee/additional_fuel_request');
			array_push($msg,$new4);
		}
        echo json_encode($msg);
    }
}
?>