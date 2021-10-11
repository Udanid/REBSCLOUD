<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model("user/user_model");		
		$this->load->library('form_validation');
		$this->load->model("common_model");
		$this->load->model("wip/calendar_model");
		$this->load->model("hr/employee_model");
		$this->is_logged_in();
    }

    function index(){
		if ( ! check_access('view_calendar'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('home');
			return;
		}
		
		$data['category']=$this->calendar_model->get_calendar_cat();
		$data['employees']=$this->employee_model->get_employee_list();
		$data['eventslist']=$eventslist=$this->calendar_model->get_calendar_events();
		$participent=NUll;
		if($eventslist)foreach($eventslist as $raw)
		{
			$list=$this->calendar_model->get_participants($raw->event_id,'ACCEPT');
			$arr=NULL;
			if($list)foreach($list as $raw1)
			{
				$arr[]=$raw1->initial.' '.$raw1->surname;
			}
			$participent[$raw->event_id]=json_encode($arr);
		}
		$data['participent']=$participent;
		//print_r($data['eventslist']);
      	$this->load->view('wip/calendar/index',$data);
    }
 	function add_event()
	{
		if ( ! check_access('add_calendar_event'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/calendar/index');
			return;
		}
		$data['category']=$this->calendar_model->add_event();
		$this->session->set_flashdata('msg', 'Successfully Inserted the Event');
		$this->logger->write_message("success", $this->input->post('title').'  successfully Inserted');
		redirect('wip/calendar');
	}
	function add_category()
	{
		if ( ! check_access('add_calendar'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/calendar/index');
			return;
		}
		$data['category']=$this->calendar_model->add_category();
		$this->session->set_flashdata('msg', 'Successfully Inserted the Category');
		$this->logger->write_message("success", $this->input->post('cat_name').'  successfully Inserted');
		redirect('wip/calendar');
	}
	function accept($id)
	{
		$data['details']=$this->calendar_model->get_event_data($id);
			$data['list']=$list=$this->calendar_model->get_participants($id,'ALL');
	
		$this->load->view('wip/calendar/accept',$data);
		//redirect('wip/calendar');
	}
	
	function accept_update($id){
		$data['details']=$this->calendar_model->get_event_data($id);
		$data['list']=$list=$this->calendar_model->get_participants($id,'ALL');
		$this->load->view('wip/calendar/accept_update',$data);
	}
	
	function accept_meeting_update($id)
	{
		$data['details']=$this->calendar_model->update_status_event_data_update($id,'ACCEPT');
		redirect('wip/calendar');
	}
	
	function accept_cancel($event_id){
		$this->calendar_model->accept_cancel($event_id);
		redirect('wip/calendar');
	}
	
	function accept_meeting($id)
	{
		$data['details']=$this->calendar_model->update_status_event_data($id,'ACCEPT');
		redirect('wip/calendar');
	}
	function reject_meeting($id)
	{
		$data['details']=$this->calendar_model->update_status_event_data($id,'REJECT');
			
		redirect('wip/calendar');
	
	}
	function checktime()
	{
		//echo 'hello';
		$id=$this->input->get('id');
		$time=$this->input->get('sartdatetime');
		$result=$this->calendar_model->check_employee_availability($id,$time);
		if($result)
		{
			echo "has another event";
		}
		//echo "Has another meeting";
	}
	
	function delete_event($id){
		if ( ! check_access('delete_calendar_event'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/calendar/index');
			return;
		}
		
		$data = $this->calendar_model->delete_event($id);
		
		if($data){
			$this->session->set_flashdata('msg', 'Successfully Deleted the Event');
			$this->logger->write_message("success", 'Event '.$id.' successfully Deleted');
		}else{
			$this->session->set_flashdata('error', 'Failed to Deleted the Event');
		}
		redirect('wip/calendar/index');
	}
	
	function get_notification_types(){
		$event_id = $this->input->post('schedule_id');
		$data = $this->calendar_model->get_notification_types($event_id);
		if($data){
			$not_types =  explode (",", $data->not_mode);
			$not_times =  explode (",", $data->not_time);
			$result = array();
			foreach($not_types as $key=>$val){ // Loop though one array
				$val2 = $not_times[$key]; // Get the values from the other array
				$result[$key] = $val.','.$val2; // combine them
			}
			echo json_encode($result);
		}
	}
	
	function get_event_staff(){
		$event_id = $this->input->post('schedule_id');
		$data = $this->calendar_model->get_event_staff($event_id);
		if($data){
			echo json_encode($data);
		}
	}
	
	function update_event($event_id){
		if ( ! check_access('update_calendar_event'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/calendar/index');
			return;
		}
		$data = $this->calendar_model->update_event($event_id);
		$this->session->set_flashdata('msg', 'Successfully Updated the Event');
		$this->logger->write_message("success", $this->input->post('title').'  successfully Updated');
		redirect('wip/calendar');
	}
}
