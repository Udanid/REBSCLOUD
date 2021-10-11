<?php

class Calendar_model extends CI_Model {

     function __construct() {
        parent::__construct();
    }

    function get_calendar_cat(){
    	$this->db->select('*');
		$query = $this->db->get('wip_calendar_cat'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
    }
	function get_calendar_events(){
    	$this->db->select('wip_calendar_events.*');
		$this->db->join('wip_calendar_staff','wip_calendar_staff.event_id=wip_calendar_events.event_id');
		$this->db->where('wip_calendar_staff.staff_id',$this->session->userdata('userid'));
		$this->db->where('wip_calendar_staff.status','ACCEPT');
		$this->db->where('wip_calendar_events.is_deleted','0');
		$query = $this->db->get('wip_calendar_events'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
    }
	function get_event_data($id)
	{
		$this->db->select('wip_calendar_events.*');
		$this->db->join('wip_calendar_staff','wip_calendar_staff.event_id=wip_calendar_events.event_id');
		$this->db->where('wip_calendar_events.event_id',$id);
		$query = $this->db->get('wip_calendar_events'); 
		
		if ($query->num_rows() > 0){
			return $query->row(); 
		}		
		else
		return false;
	}
 function get_participants($eventid,$status)
 {
	 $this->db->select('hr_empmastr.id,hr_empmastr.initial,hr_empmastr.surname,wip_calendar_staff.status');
		$this->db->join('hr_empmastr','hr_empmastr.id=wip_calendar_staff.staff_id');
		$this->db->where('wip_calendar_staff.event_id',$eventid);
		if($status !='ALL')
		$this->db->where('wip_calendar_staff.status',$status);
		$query = $this->db->get('wip_calendar_staff'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
 }
 function add_event()
 {
	 $mode="";
	 if($this->input->post('SMS'))
	 $mode='SMS,';
	 if($this->input->post('email'))
	 $mode=$mode.'email';
	 
	 $time = "";
	 if($this->input->post('not_time_SMS'))
	 $time = $this->input->post('not_time_SMS').',';
	 if($this->input->post('not_time_email'))
	 $time = $time.$this->input->post('not_time_email');
	 
	 if($this->input->post('allday') == 'on'){
		$all_day = 'true'; 
	 }else{
	 	$all_day = 'false'; 
	 }
	 
	 $details = str_replace(array("\n"), '<br>', $this->input->post('details'));
	 $details = str_replace(array("\r"), '', $details);
	 $details = preg_replace("/(<br>\s*)+/", "<br />", $details);
	 
	 $arr=array( 
			'title' => $this->input->post('title'),
			'end_date' => $this->input->post('end_date_time'),
			'start_date' => $this->input->post('start_date_time'),
			'location' => $this->input->post('location'),
			'details' => $details,
			'not_time' => $time,
			'not_mode' => $mode,
			'cat_id' => $this->input->post('cat_id'),
			'allday' => $all_day,
			'create_by' => $this->session->userdata('userid'),
				'create_date'=>date('Y-m-d')
		);

		$this->db->trans_start();
		$this->db->insert('wip_calendar_events', $arr);
		$event_id=$this->db->insert_id();
		$this->db->trans_complete();
		
		$arr=array( 
					'staff_id' =>$this->session->userdata('userid'),
					'event_id' => $event_id,
					'status' => 'ACCEPT',
							
				);

				$this->db->trans_start();
				$this->db->insert('wip_calendar_staff', $arr);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
		$emparr=explode(',',$this->input->post('emplist'));
		for($i=0; $i<count($emparr); $i++)
		{ 
			if($emparr[$i]!="")
			{
				$arr=array( 
					'staff_id' =>$emparr[$i],
					'event_id' => $event_id,
							
				);

				$this->db->trans_start();
				$this->db->insert('wip_calendar_staff', $arr);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
				$arr2=array( 
					'user_id' =>$emparr[$i],
					'event_id' => $event_id,
					'msg' => 'New event schedule',
					'link'=> 'wip/calendar/accept/'.$event_id,
							
				);

				$this->db->trans_start();
				$this->db->insert('wip_calendar_notification', $arr2);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
				
				
			}
			
			
		}
					
 }
function add_category()
{
		$arr=array( 
			'cat_name' =>$this->input->post('cat_name'),
			'cat_color' => $this->input->post('cat_color'),
					
		);

		$this->db->trans_start();
		$this->db->insert('wip_calendar_cat', $arr);
		$notification_id=$this->db->insert_id();
		$this->db->trans_complete();
}
function get_calandar_notification($id)
	{
		$this->db->select('wip_calendar_events.*,wip_calendar_notification.msg,wip_calendar_notification.link');
		$this->db->join('wip_calendar_events','wip_calendar_events.event_id=wip_calendar_notification.event_id');
		$this->db->where('wip_calendar_notification.user_id',$id);
		$query = $this->db->get('wip_calendar_notification'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
	}
 
 function update_status_event_data($event_id,$status)
 {
	 $arr=array( 
					'status' => $status,
							
				);

				$this->db->trans_start();
				$this->db->where('staff_id',$this->session->userdata('userid'));
				$this->db->where('event_id',$event_id);
				$this->db->update('wip_calendar_staff', $arr);
				
				$this->db->where('user_id',$this->session->userdata('userid'));
				$this->db->where('event_id',$event_id);
				$this->db->where('msg','New event schedule');
				$this->db->delete('wip_calendar_notification');
 }
 
 function update_status_event_data_update($event_id,$status)
 {
	 $arr=array( 
					'status' => $status,
							
				);

				$this->db->trans_start();
				$this->db->where('staff_id',$this->session->userdata('userid'));
				$this->db->where('event_id',$event_id);
				$this->db->update('wip_calendar_staff', $arr);
				
				$this->db->where('user_id',$this->session->userdata('userid'));
				$this->db->where('event_id',$event_id);
				$this->db->where('msg','Event schedule updated');
				$this->db->delete('wip_calendar_notification');
 }
  
 function check_employee_availability($id,$time){
    	$this->db->select('wip_calendar_events.*');
		$this->db->join('wip_calendar_staff','wip_calendar_staff.event_id=wip_calendar_events.event_id');
			$this->db->where('wip_calendar_staff.staff_id',$id);
	
		$this->db->where('wip_calendar_events.start_date <=',$time);
		$this->db->where('wip_calendar_events.end_date >',$time);
		$this->db->where('wip_calendar_staff.status !=','REJECT');
		$query = $this->db->get('wip_calendar_events'); 
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return true; 
		}		
		else
		return false;
    }
	
	function delete_event($id){
		
		$this->db->select('create_by');
		$this->db->where('wip_calendar_events.event_id',$id);
		$query = $this->db->get('wip_calendar_events'); 
		$creator = $query->row()->create_by;
		$data = array(
			'is_deleted' => 1,
		);
		$this->db->where('event_id',$id);
		$this->db->update('wip_calendar_events',$data);
		if($this->db->affected_rows() > 0){
			
			$this->db->where('event_id',$id);
			$this->db->delete('wip_calendar_notification');	
			
			$this->db->select('staff_id');
			$this->db->where('wip_calendar_staff.event_id',$id);
			$query = $this->db->get('wip_calendar_staff');
			foreach($query->result() as $data){
				//check whether the creator and send cancellation notification
				if($data->staff_id != $creator){
					$arr2=array( 
						'user_id' =>$data->staff_id,
						'event_id' => $id,
						'msg' => 'Event schedule cancelled',
						'link'=> 'wip/calendar/accept_cancel/'.$id,
								
					);
	
					$this->db->trans_start();
					$this->db->insert('wip_calendar_notification', $arr2);
					$notification_id=$this->db->insert_id();
					$this->db->trans_complete();
				}
			}
			
			$this->db->where('event_id',$id);
			$this->db->delete('wip_calendar_staff');
			
			return true;
		}else{
			return false;	
		}
	}
	
	function accept_cancel($event_id){
		$this->db->where('user_id',$this->session->userdata('userid'));
		$this->db->where('event_id',$event_id);
		$this->db->where('msg','Event schedule cancelled');
		$this->db->delete('wip_calendar_notification');
	}
	
	function get_notification_types($event_id){
		$this->db->select('not_mode,not_time');
		$this->db->where('wip_calendar_events.event_id',$event_id);
		$query = $this->db->get('wip_calendar_events');
		if($query->num_rows() > 0){
			if($query->row()->not_mode != ''){
				return $query->row();
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	function get_event_staff($event_id){
		$this->db->select('staff_id,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('wip_calendar_events','wip_calendar_events.create_by = wip_calendar_staff.staff_id','LEFT');
		$this->db->join('hr_empmastr','hr_empmastr.id = wip_calendar_staff.staff_id');
		$this->db->where('wip_calendar_staff.event_id',$event_id);
		$this->db->where('wip_calendar_events.create_by',NULL);
		$query = $this->db->get('wip_calendar_staff');
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function update_event($event_id){
		$mode="";
		 if($this->input->post('SMS'))
		 $mode='SMS,';
		 if($this->input->post('email'))
		 $mode=$mode.'email';
		 
		 $time = "";
		 if($this->input->post('not_time_SMS'))
		 $time = $this->input->post('not_time_SMS').',';
		 if($this->input->post('not_time_email'))
		 $time = $time.$this->input->post('not_time_email');
		 
		 if($this->input->post('allday') == 'on'){
			$all_day = 'true'; 
		 }else{
			$all_day = 'false'; 
		 }
		 
		 $details = str_replace(array("\n"), '<br>', $this->input->post('details'));
		 $details = str_replace(array("\r"), '', $details);
		 $details = preg_replace("/(<br>\s*)+/", "<br />", $details);
		 
		 $arr=array( 
			'title' => $this->input->post('title'),
			'end_date' => $this->input->post('end_date_time'),
			'start_date' => $this->input->post('start_date_time'),
			'location' => $this->input->post('location'),
			'details' => $details,
			'not_time' => $time,
			'not_mode' => $mode,
			'cat_id' => $this->input->post('cat_id'),
			'allday' => $all_day,
			//'updated_by' => $this->session->userdata('userid'),
				//'create_date'=>date('Y-m-d')
		);

		$this->db->trans_start();
		$this->db->where('wip_calendar_events.event_id',$event_id);
		$this->db->update('wip_calendar_events', $arr);
		$this->db->trans_complete();
		
		/*Get old emp list to array*/
		$this->db->select('staff_id');
		$this->db->where('event_id',$event_id);
		$query = $this->db->get('wip_calendar_staff');
		$staff_list = array();
		foreach($query->result() as $data){
			array_push($staff_list,$data->staff_id);
		}
		
		/*Remove all staff*/
		$this->db->where('event_id',$event_id);
		$this->db->delete('wip_calendar_staff');
		
		/*Remove all notifications*/
		$this->db->where('event_id',$event_id);
		$this->db->delete('wip_calendar_notification');
		
		$arr=array( 
					'staff_id' =>$this->session->userdata('userid'),
					'event_id' => $event_id,
					'status' => 'ACCEPT',
							
				);

				$this->db->trans_start();
				$this->db->insert('wip_calendar_staff', $arr);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
		$emparr=explode(',',$this->input->post('emplist'));
		for($i=0; $i<count($emparr); $i++)
		{ 
			if($emparr[$i]!="")
			{
				$arr=array( 
					'staff_id' =>$emparr[$i],
					'event_id' => $event_id,
				);

				$this->db->trans_start();
				$this->db->insert('wip_calendar_staff', $arr);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
				
				/*If employee was in the event we send an update, else a new notification*/
				if (in_array($emparr[$i], $staff_list))
  				{
					
					$arr2=array( 
						'user_id' =>$emparr[$i],
						'event_id' => $event_id,
						'msg' => 'Event schedule updated',
						'link'=> 'wip/calendar/accept_update/'.$event_id,
								
					);
				}else{
					$arr2=array( 
						'user_id' =>$emparr[$i],
						'event_id' => $event_id,
						'msg' => 'New event schedule',
						'link'=> 'wip/calendar/accept/'.$event_id,
								
					);
				}
				$this->db->trans_start();
				$this->db->insert('wip_calendar_notification', $arr2);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
				
				
			}
			
			
		}
	}
 
}
