<?php

class Tasknotification_model extends CI_Model {

    function Entry_model()
    {
        parent::__construct();
    }

    function get_all_notification_count($user_id){

    	$current_date=date("Y-m-d");
    	$result1=0;
    	$result2=0;
    	$result3=0;
    	$result4=0;
    	$result5=0;$result6=0;$result7=0;$result8=0;$result9=0;$result10=0;
    	$result=0;

    	// task notification count

    	$this->db->select('COUNT(wip_notification.id) as mycount1');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id','left');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->where('wip_task.task_sdate <=',$current_date);
		$this->db->where('wip_notification.noti_type','Task Accept');
		$query1 = $this->db->get('wip_notification');

		// sub task accept notification

		$this->db->select('COUNT(wip_notification.id) as mycount2');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Accept');
		$this->db->where('wip_sub_task.hold_status','active');
		$query2 = $this->db->get('wip_notification');

		// sub task extend count

		$this->db->select('COUNT(wip_notification.id) as mycount3');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Extend');
		$this->db->where('wip_sub_task.hold_status','active');
		$query3 = $this->db->get('wip_notification'); 

		// task extend count

		$this->db->select('COUNT(wip_notification.id) as mycount4');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_task.task_createby',$user_id);
		$this->db->where('wip_notification.noti_type','Task Extend');
		$query4 = $this->db->get('wip_notification');

		// completed task notification

		$this->db->select('COUNT(wip_notification.id) as mycount5');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Completed');
		$query5 = $this->db->get('wip_notification');

		// task extend approver notification count
		$this->db->select('COUNT(wip_notification.id) as mycount6');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Task Extend Accept');
		$query6 = $this->db->get('wip_notification');

		// sub task extend approver notification count
		$this->db->select('COUNT(wip_notification.id) as mycount7');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Extend Accept');
		$query7 = $this->db->get('wip_notification');

		// sub task prograss update notification count
		$this->db->select('COUNT(wip_notification.id) as mycount8');
		$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Prograss Update');
		$query8 = $this->db->get('wip_notification');

		
		// task accepted notification

		$this->db->select('COUNT(wip_notification.id) as mycount9');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_createby',$user_id);
		$this->db->where('wip_notification.noti_type','Task Accepted');
		$query9 = $this->db->get('wip_notification');

		// sub task accepted notification

		$this->db->select('COUNT(wip_notification.id) as mycount10');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_createby',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Accepted');
		$query10 = $this->db->get('wip_notification');

		// sub task extend reject notification count
		$this->db->select('COUNT(wip_notification.id) as mycount11');
		$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Extend Reject');
		$query11 = $this->db->get('wip_notification');

		// main task extend reject notification

		$this->db->select('COUNT(wip_notification.id) as mycount12');
		$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Task Extend Reject');
		$query12 = $this->db->get('wip_notification');
		
		//Task rejected count
		$this->db->select('COUNT(wip_notification.id) as mycount13');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_createby',$user_id);
		$this->db->like('wip_notification.noti_type','Task Rejected');
		$query13 = $this->db->get('wip_notification');
		
		// sub task reject notification

		$this->db->select('COUNT(wip_notification.id) as mycount14');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_createby',$user_id);
		$this->db->like('wip_notification.noti_type','Sub Task Rejected');
		$this->db->where('wip_sub_task.hold_status','active');
		$query14 = $this->db->get('wip_notification');

		if ($query1->num_rows() > 0 || $query2->num_rows() > 0 || $query3->num_rows() > 0 || $query4->num_rows() > 0 || $query5->num_rows() > 0 || $query6->num_rows() > 0 || $query7->num_rows() > 0 || $query6->num_rows() > 0 || $query8->num_rows() > 0 || $query4->num_rows() > 0 || $query10->num_rows() > 0 || $query11->num_rows() > 0 || $query12->num_rows() > 0 || $query13->num_rows() > 0 || $query14->num_rows() > 0){
			 
			$result1=$query1->row();
			$result2=$query2->row();
			$result3=$query3->row();
			$result4=$query4->row();
			$result5=$query5->row();
			$result6=$query6->row();
			$result7=$query7->row();
			$result8=$query8->row();
			$result9=$query9->row();
			$result10=$query10->row();
			$result11=$query11->row();
			$result12=$query12->row();
			$result13=$query13->row();
			$result14=$query14->row();
			$result= $result1->mycount1+$result2->mycount2+$result3->mycount3+$result4->mycount4+$result5->mycount5+$result6->mycount6+$result7->mycount7+$result8->mycount8+$result9->mycount9+$result10->mycount10+$result11->mycount11+$result12->mycount12+$result13->mycount13+$result14->mycount14;

			return $result;

		}
		
		else
		return false;
    }


    function get_task_notification_count($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('COUNT(wip_notification.id) as mycount');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type !=','Task Completed');
		$this->db->where('wip_task.task_sdate <=',$current_date);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->where('wip_notification.sub_task_id',0);
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    // pending task accept for task assigner

    function get_task_notification($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('wip_task.task_id,wip_task.task_name,wip_task.task_updatedate,wip_project.prj_name');   	
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Task Accept');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_sdate <=',$current_date);
		$this->db->where('wip_task.task_assign',$user_id);
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    // task accepted notification send to task created by

    function accepted_task_notification_view_task_createor($user_id){
    	$this->db->select('wip_notification.id,wip_task.task_id,wip_task.task_name,wip_task.task_updatedate,wip_project.prj_name');   	
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_createby',$user_id);
		$this->db->where('wip_notification.noti_type','Task Accepted');
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }
	
	// task rejected notification send to task created by
	
	function rejected_task_notification_view_task_createor($user_id){
    	$this->db->select('wip_notification.id,wip_task.task_id,wip_task.task_name,wip_task.task_updatedate,wip_project.prj_name,wip_notification.noti_type');   	
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_createby',$user_id);
		$this->db->like('wip_notification.noti_type','Task Rejected','both');
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_sub_task_accepted_notification__task_assigner($user_id){
    	$this->db->select('wip_notification.id,wip_task.task_name,wip_sub_task.subt_name');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_createby',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Accepted');
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }
	
	function get_sub_task_rejected_notification__task_assigner($user_id){
    	$this->db->select('wip_notification.id,wip_project.prj_name,wip_task.task_name,wip_sub_task.subt_name,wip_notification.noti_type');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_createby',$user_id);
		$this->db->like('wip_notification.noti_type','Sub Task Rejected');
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }


    function get_complted_task_notification_count($user_id){
    	$this->db->select('COUNT(wip_notification.id) as mycount');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Task Completed');
		$this->db->where('wip_task.task_assign',$user_id);
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_task_completed_notification($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('wip_notification.id,wip_task.task_id,wip_task.task_name,wip_task.task_updatedate');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Task Completed');
		$this->db->where('wip_notification.sub_task_id',0);
		$this->db->where('wip_task.task_assign',$user_id);
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }


    function get_sub_task_completed_notification($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('wip_notification.id,wip_task.task_name,wip_sub_task.subt_name');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Sub Task Completed');
		$this->db->where('wip_task.task_assign',$user_id);
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    // sub task extention reject notification

    function get_sub_task_extention_reject_notification($user_id){

    	$this->db->select('wip_notification.id,wip_task.task_name,wip_sub_task.subt_name,wip_sub_task.subt_id');
      	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Sub Task Extend Reject');
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
	}

	// main task extention reject notification

    function get_main_task_extention_reject_notification($user_id){

    	$this->db->select('wip_notification.id,wip_task.task_name,wip_sub_task.subt_name,wip_sub_task.subt_id');
      	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_notification.noti_type','Task Extend Reject');
		$query = $this->db->get('wip_notification');

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
	}

    function get_sub_task_prograss_update_notification($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('wip_notification.id,wip_task.task_name,wip_sub_task.subt_name,wip_sub_task.subt_id');
      $this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Prograss Update');
		$this->db->where('wip_task.task_assign',$user_id);
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_sub_task_notification_count($user_id){
    	$this->db->select('COUNT(wip_notification.id) as mycount');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Sub Task Accept');
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_sub_task.hold_status','active');
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_sub_task_notification($user_id){
    	$this->db->select('wip_sub_task.subt_id,wip_sub_task.subt_name,wip_task.task_name,wip_task.task_id');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Sub Task Accept');
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_sub_task.hold_status','active');
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_task_extend_notification($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('wip_sub_task.subt_id,wip_sub_task.subt_name,wip_task.task_name');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Sub Task Extend');
		//$this->db->where('wip_sub_task.subt_createby',$user_id);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->where('wip_sub_task.hold_status','active');
		$query = $this->db->get('wip_notification');  

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_main_task_extend_notification($user_id){

    	$current_date=date("Y-m-d");

    	$this->db->select('wip_task.task_id,wip_task.task_name,wip_notification.id,wip_project.prj_name');
    	$this->db->join('wip_task','wip_task.task_id=wip_notification.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.sub_task_id !=',0);
		$this->db->where('wip_task.task_createby',$user_id);
		$this->db->where('wip_notification.noti_type','Task Extend');
		$query = $this->db->get('wip_notification');  

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_task_bycode_for_notification($task_id) { //get all stock
		$this->db->select('wip_task.*,wip_project.prj_name,hr_empmastr.initials_full,hr_empmastr.initial,hr_empmastr.surname');
		$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
		$this->db->join('hr_empmastr','hr_empmastr.id=wip_task.task_createby');
		$this->db->where('wip_task.task_id',$task_id);
		$query = $this->db->get('wip_task'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}
		
		else
		return false;
    } 

    function get_sub_task_extend_accept_notification($user_id){
    	$this->db->select('wip_notification.id,wip_sub_task.subt_id,wip_sub_task.subt_name,wip_task.task_name');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->order_by('wip_notification.id','DESC');
		$this->db->where('wip_notification.noti_status','pending');
		$this->db->where('wip_notification.noti_type','Sub Task Extend Accept');
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where('wip_sub_task.hold_status','active');
		$query = $this->db->get('wip_notification'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }


	function get_main_task_extend_accept_notification($user_id){
	    	$this->db->select('wip_notification.id,wip_sub_task.subt_id,wip_sub_task.subt_name,wip_task.task_name');
	    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_notification.sub_task_id');
	    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
			$this->db->order_by('wip_notification.id','DESC');
			$this->db->where('wip_notification.noti_status','pending');
			$this->db->where('wip_notification.noti_type','Task Extend Accept');
			$this->db->where('wip_sub_task.subt_assign',$user_id);
			$this->db->where('wip_sub_task.hold_status','active');
			$query = $this->db->get('wip_notification'); 

			if ($query->num_rows() > 0){
				return $query->result(); 
			}
			
			else
			return false;
	    }

    function get_subtasks_bycode_for_notification($task_id){
    	$this->db->select('wip_sub_task.*,hr_empmastr.initials_full');
    	$this->db->join('wip_sub_task','wip_sub_task.task_id=wip_task.task_id');
    	$this->db->join('hr_empmastr','hr_empmastr.id=wip_sub_task.subt_assign');
		$this->db->where('wip_task.task_id',$task_id);
		$query = $this->db->get('wip_task'); 
		
		if ($query->num_rows() > 0){
			return $query->result();  
		}
		
		else
		return false;
    }

    function accept_notification_update(){
    	$task_id = $this->input->post('task_id', TRUE);
    	$task_createby=$this->session->userdata('userid');  
    	$notification_acceptdate=date("Y-m-d");
    	$subt_duration = $this->input->post('subt_duration', TRUE);

    	$data=array( 
			'task_accepted_status' => 1,
			'accepted_date' => $notification_acceptdate,
			'task_status' => 'processing',
		);

    	$this->db->where('task_id',$task_id);
		$updatetask_notification = $this->db->update('wip_task', $data);

		if($updatetask_notification){
			$data=array( 
			'noti_status' => 'accepted',
		);

    		$this->db->where('task_id',$task_id);
			$update_notification = $this->db->update('wip_notification', $data);

			$task_accepted_noti=array( 
				'task_id' => $task_id,
				'sub_task_id' => 0,
				'created_date' => $notification_acceptdate,
				'noti_status' => 'pending',
				'noti_type' => 'Task Accepted',
			);

		   	$this->db->trans_start();
			$this->db->insert('wip_notification', $task_accepted_noti);
			$notification_id=$this->db->insert_id();
			$this->db->trans_complete();
		}

		if($updatetask_notification){

			$this->db->select('subt_id');
			$this->db->where('task_id',$task_id);
			$this->db->where('subt_accepted_status',0);
			$this->db->order_by('task_id','DESC');
			$query = $this->db->get('wip_sub_task');
			$result=$query->result();
				
			if($result){

				

				$update_strat_date=array(
					'subt_sdate' => $notification_acceptdate,
				);

			    foreach ($result as $raw){
			    	$notificationdata=array( 
						'task_id' => $task_id,
						'sub_task_id' => $raw->subt_id,
						'created_date' => $notification_acceptdate,
						'noti_status' => 'pending',
						'noti_type' => 'Sub Task Accept',
					);

				   	$this->db->trans_start();
					$this->db->insert('wip_notification', $notificationdata);
					$notification_id=$this->db->insert_id();
					$this->db->trans_complete(); 

					$this->db->where('subt_id',$raw->subt_id);
					$this->db->update('wip_sub_task', $update_strat_date);

				}
			}					
		}

		return $updatetask_notification;
    }   

    function get_subtasks_bycode_for_notification_view($subtask_id){

    	$this->db->select('wip_sub_task.*,hr_empmastr.initials_full,wip_task.task_name,wip_project.prj_name,wip_task.task_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
    	$this->db->join('hr_empmastr','hr_empmastr.id=wip_sub_task.subt_assign');
		$this->db->where('wip_sub_task.subt_id',$subtask_id);
		$query = $this->db->get('wip_sub_task'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}
		
		else
		return false;
    }   


     function accept_sub_task_notification_update(){
    	$subt_id = $this->input->post('subt_id', TRUE);
    	$task_id = $this->input->post('task_id', TRUE);
    	$task_createby=$this->session->userdata('userid');  
    	$sub_task_accept_date=date("Y-m-d");
    	$subt_duration = $this->input->post('subt_duration', TRUE);


    	//$subt_edate=date('Y-m-d', strtotime("+".$subt_duration." days"));

		//$holiday_count=	$this->Sub_task_model->sub_task_skip_holiday_count($sub_task_accept_date,$subt_edate);
		
		$subt_edate = $this->Sub_task_model->sub_task_skip_holiday_count($sub_task_accept_date,$subt_duration);

		/*if($holiday_count){
			$total_duration=$subt_duration+$holiday_count;
			$subt_edate=date('Y-m-d', strtotime("+".$total_duration." days"));
		}*/			    			

		$subdata['subt_sdate']=$sub_task_accept_date;
		$subdata['subt_edate']=$subt_edate;
		
		//we check whether the sub task duration exced task end date
		$task = $this->Task_model->get_task_bycode($task_id);
		if($subt_edate > $task->task_edate){
			$subdata['subt_edate'] = $task->task_edate;
			$subt_edate = $task->task_edate;
			
			//get new duration
			$end_date = strtotime($task->task_edate);
			$start_date = strtotime($sub_task_accept_date);
			$datediff = $end_date - $start_date;
			$datediff = round($datediff / (60 * 60 * 24));

			$data=array( 
				'subt_accepted_status' => 1,
				'subt_sdate' => $sub_task_accept_date,
				'subt_edate' => $subt_edate,
				'subt_duration' => $datediff,
				'subt_status' => 'processing',
			);
		}else{
			$data=array( 
				'subt_accepted_status' => 1,
				'subt_sdate' => $sub_task_accept_date,
				'subt_edate' => $subt_edate,
				'subt_status' => 'processing',
			);
		}

    	$this->db->where('subt_id',$subt_id);
		$updatesub_task_notification = $this->db->update('wip_sub_task', $data);

		if($updatesub_task_notification){
			$data=array( 
				'noti_status' => 'accepted',
			);

    		$this->db->where('sub_task_id',$subt_id);
			$update_notification = $this->db->update('wip_notification', $data);


			$notificationdata=array( 
				'task_id' => $task_id,
				'sub_task_id' => $subt_id,
				'created_date' => $sub_task_accept_date,
				'noti_status' => 'pending',
				'noti_type' => 'Sub Task Accepted',
			);
			
			$this->db->trans_start();
			$this->db->insert('wip_notification', $notificationdata);
			$notification_id=$this->db->insert_id();
			$this->db->trans_complete();
		}

		return $updatesub_task_notification;
    }  

    function add_sub_task_notification_bycreater($sub_notification){
		$this->db->trans_start();
		$this->db->insert('wip_notification', $sub_notification);
		$notification_id=$this->db->insert_id();
		$this->db->trans_complete(); 	
    }

    function task_accept_notification_comform_by_task_creator($noti_id){
    	$sub_task_accept_date=date("Y-m-d");

    	if($noti_id){
			$data=array( 
			'noti_status' => 'accepted',
		);

    	$this->db->where('id',$noti_id);
		$update_notification = $this->db->update('wip_notification', $data);
			
		}
    }

    function sub_task_accept_notification_comform_by_task_assigner($noti_id){
    	$sub_task_accept_date=date("Y-m-d");

    	if($noti_id){
			$data=array( 
			'noti_status' => 'accepted',
		);

    	$this->db->where('id',$noti_id);
		$update_notification = $this->db->update('wip_notification', $data);
			
		}
    }

    function sub_task_reject_notification_comform_by_subtask_assigner($noti_id){
    	$sub_task_accept_date=date("Y-m-d");

    	if($noti_id){
			$data=array( 
			'noti_status' => 'accepted',
		);

    	$this->db->where('id',$noti_id);
		$update_notification = $this->db->update('wip_notification', $data);
			
		}
    }
	
	function clear_messages($user_id){
		
		
		$data = array(
			'noti_status' => 'accepted',
		);
				
		//remove task messages
		
		$statuses = array('Sub Task Accepted', 'Prograss Update','Task Accepted');
		$this->db->set($data);
		$this->db->where('wip_task.task_assign',$user_id);
		$this->db->or_where('wip_task.task_createby',$user_id);
		$this->db->where_in('wip_notification.noti_type', $statuses);
		$this->db->update('wip_notification JOIN wip_task ON wip_notification.task_id = wip_task.task_id');
				
		$statuses = array('Sub Task Extend Accept', 'Sub Task Extend Reject','Task Extend Accept','Task Extend Reject');
		$this->db->set($data);
		$this->db->where('wip_sub_task.subt_assign',$user_id);
		$this->db->where_in('wip_notification.noti_type', $statuses);
		$this->db->update('wip_notification JOIN wip_sub_task ON wip_notification.sub_task_id = wip_sub_task.subt_id');
				
	}

	function get_task_file_attachment($task_id){
		$this->db->select('*');
		$this->db->where('task_id',$task_id);
		$query = $this->db->get('wip_task_attachment'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
	}
}