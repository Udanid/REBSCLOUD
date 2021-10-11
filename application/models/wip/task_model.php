<?php

class Task_model extends CI_Model {

    function Entry_model()
    {
        parent::__construct();
    }  

    function get_all_employees(){
    	$this->db->select('id,initial,surname,initials_full');
		$this->db->order_by('initial','DESC');
		$this->db->order_by('surname','DESC');
		$query = $this->db->get('hr_empmastr'); 
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
    }


   function add($data){
    	
    	$task_createby=$this->session->userdata('userid');  
    	$notification_createdate=date("Y-m-d"); 
    	$assignempoyee=$this->input->post('task_assign', TRUE);
    	$task_start_date = $this->input->post('task_start_date', TRUE);

		if($task_createby){

			// task insert

    		$this->db->trans_start();
			$this->db->insert('wip_task', $data);
			$task_id=$this->db->insert_id();
			$this->db->trans_complete();

			// end tast insert

			// file attachment

			$IMG = isset($_FILES['files']) ? $_FILES['files'] : array();
			$milliseconds = round(microtime(true));			
			
			mkdir('uploads/task_attach_files/'.$task_id,0777,true);

		    if (!empty($IMG)){
		        $uploads_dir = 'uploads/task_attach_files/'.$task_id.'/';
		        $value_insert = '';
		        foreach ($IMG["error"] as $key => $error)
		        {
		            if ($error == UPLOAD_ERR_OK)
		            {
		              $tmp_name = $IMG["tmp_name"][$key];
		              $name = $milliseconds.$IMG["name"][$key];
		              move_uploaded_file($tmp_name, "$uploads_dir".$name);

		              $file_path= $tmp_name = $uploads_dir.$name;  

		                $fileupload=array( 
						  'task_id' => $task_id,
						  'file_name' => $name,
						  'file_path' => $file_path,						  				
					    );	

					    $this->db->trans_start();
						$this->db->insert('wip_task_attachment', $fileupload);
						$id=$this->db->insert_id();
						$this->db->trans_complete();  
		            }
		        }

		    }else{
		       echo 'empty array';
		    }

		     // end file attachment

			// insert notification for empolyee

			if($task_id){
				if($assignempoyee != $task_createby || $task_start_date!=$notification_createdate){
					$notificationdata=array( 
						'task_id' => $task_id,
						'created_date' => $notification_createdate,
						'noti_status' => 'pending',
						'noti_type' => 'Task Accept',
					);

					$this->db->trans_start();
					$this->db->insert('wip_notification', $notificationdata);
					$notification_id=$this->db->insert_id();
					$this->db->trans_complete();
				}
			}

			// end notification

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}else{
				$this->db->trans_commit();
				return $task_id;
			}
		}
	}

	function get_all_task_summery(){
    	$this->db->select('task_id,prj_id,task_name,task_duration');
		$this->db->order_by('task_id','DESC');
		$query = $this->db->get('wip_task'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
    }

    function get_task_employe_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('task_id',$code);
		$this->db->join('hr_empmastr','hr_empmastr.id=wip_task.task_assign');
		$query = $this->db->get('wip_task'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}
		else
			return false;
    }

    function get_all_task_details($pagination_counter,$page_count,$userid){

    	$this->db->select('wip_task.task_id,wip_project.prj_name,wip_task.task_name,wip_task.task_duration,wip_task.task_progress,wip_task.task_status,wip_task.task_accepted_status,wip_task.task_assign,wip_task.task_createby,wip_sub_task.subt_assign,wip_sub_task.subt_id,wip_sub_task.subt_status,wip_sub_task.subt_name,wip_sub_task.subt_progress,wip_sub_task.subt_createby,wip_sub_task.subt_duration,wip_sub_task.subt_accepted_status,wip_task.task_sdate');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
    	$this->db->join('wip_sub_task','wip_sub_task.task_id=wip_task.task_id','left');
    	$this->db->where('wip_task.task_status !=','deleted'); 	
		$this->db->order_by('wip_task.task_id','DESC');
		$this->db->limit($pagination_counter,$page_count);
		$query = $this->db->get('wip_task'); 

		$check=$query->result();
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
		return false;
    } 

    function get_task_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('task_id',$code);
		$query = $this->db->get('wip_task'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}
		
		else
		return false;
    }

    function get_subtasks_bycode($code){
    	$this->db->select('wip_sub_task.*');
    	$this->db->join('wip_sub_task','wip_sub_task.task_id=wip_task.task_id');
		$this->db->where('wip_task.task_id',$code);
		$query = $this->db->get('wip_task'); 
		
		if ($query->num_rows() > 0){
			return $query->result();  
		}
		
		else
		return false;
    }

    function insert_edit_data($data){

    	$task_id = $this->input->post('task_id', TRUE);		
		$task_createby=$this->session->userdata('userid'); 
		$ctrate_date=date("Y-m-d");

		// file attachment

		$IMG = isset($_FILES['files']) ? $_FILES['files'] : array();
		$milliseconds = round(microtime(true));			
		
		//mkdir('uploads/task_attach_files/'.$task_id,0777,true);

	    if (!empty($IMG)){
	        $uploads_dir = 'uploads/task_attach_files/'.$task_id.'/';
	        $value_insert = '';
	        foreach ($IMG["error"] as $key => $error)
	        {
	            if ($error == UPLOAD_ERR_OK)
	            {
	              $tmp_name = $IMG["tmp_name"][$key];
	              $name = $milliseconds.$IMG["name"][$key];
	              move_uploaded_file($tmp_name, "$uploads_dir".$name);

	              $file_path= $tmp_name = $uploads_dir.$name;  

	                $fileupload=array( 
					  'task_id' => $task_id,
					  'file_name' => $name,
					  'file_path' => $file_path,						  				
				    );	

				    $this->db->trans_start();
					$this->db->insert('wip_task_attachment', $fileupload);
					$id=$this->db->insert_id();
					$this->db->trans_complete();  
	            }
	        }

	    }else{
	       echo 'empty array';
	    }

	     // end file attachment

// change assign user send new notification

		$previous_task_assigneer= $this->input->post('previous_task_assign', TRUE);
		$new_task_assigneer = $this->input->post('task_assign', TRUE);

		if($previous_task_assigneer!=$new_task_assigneer){				
			$data['task_status']='pending';
			$data['task_accepted_status']=0;

			$this->db->select('id');
			$this->db->where('task_id',$task_id);
			$this->db->where('sub_task_id',0);
			$query = $this->db->get('wip_notification');

			$result=$query->row();

			if($result){
				$notificationdata=array( 
					'created_date' => $ctrate_date,
					'noti_status' => 'pending',
				);

				$this->db->where('id',$result->id);
				$this->db->update('wip_notification', $notificationdata);
			}
    	} 

// end send nofification

    	$this->db->where('task_id',$task_id);
		$insert = $this->db->update('wip_task', $data);
    			
		return $insert;
    }

    function delete($task_id){
		
		$data=array( 
			'task_status' => 'deleted',
		);

		$this->db->select('*');
		$this->db->where('task_id',$task_id);
		$query = $this->db->get('wip_task');

		if ($query->num_rows() > 0){
			$task_result=$query->row();

			if($task_result->task_progress>0){
				return false;
			
			}else{
				$this->db->where('task_id',$task_id);
				$insert = $this->db->update('wip_task', $data);

				$this->db->select('*');
				$this->db->where('task_id',$task_id);
				$query = $this->db->get('wip_sub_task');

				$result=$query->result();

				if($result){
					$data1=array( 
					  'subt_status' => 'deleted',
					);

				    foreach ($result as $raw){
					   $this->db->where('subt_id', $raw->subt_id);
					   $sub_task_insert = $this->db->update('wip_sub_task',$data1);
				    }
				}

				$this->db->select('*');
				$this->db->where('task_id',$task_id);
				$query = $this->db->get('wip_notification');
				$notification_result=$query->result();

				if($notification_result){
					foreach ($notification_result as $raw){
					   $this->db->where('id', $raw->id);
					   $this->db->delete('wip_notification');
				    }
				}

				return $insert;
			} 
		}
	}
	
	function task_reject_update($task_id,$reason){
		
		$data=array( 
			'noti_status' => 'accepted',
		);

    	$this->db->where('task_id',$task_id);
		$this->db->update('wip_notification', $data);
		if ($this->db->affected_rows() > 0){
			$task_rejected_noti=array( 
				'task_id' => $task_id,
				'sub_task_id' => 0,
				'created_date' => date("Y-m-d"),
				'noti_status' => 'pending',
				'noti_type' => 'Task Rejected - '.$reason,
			);

		   	$this->db->trans_start();
			$this->db->insert('wip_notification', $task_rejected_noti);
			$notification_id=$this->db->insert_id();
			$this->db->trans_complete();
			
			$data=array( 
				'task_assign' => 0,
				'task_status' => 'rejected',
			);
	
			$this->db->where('task_id',$task_id);
			$this->db->update('wip_task', $data);
		  return TRUE;
		}else{
		  return FALSE;
		}
	}

	function task_accept__update(){
    	$task_id = $this->input->post('task_id', TRUE);
    	$task_createby=$this->session->userdata('userid');  
    	$notification_acceptdate=date("Y-m-d");

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
			    	$accep_data=array( 
						'task_id' => $task_id,
						'sub_task_id' => $raw->subt_id,
						'created_date' => $notification_acceptdate,
						'noti_status' => 'pending',
						'noti_type' => 'Sub Task Accept',
					);

				   	$this->db->trans_start();
					$this->db->insert('wip_notification', $accep_data);
					$notification_id=$this->db->insert_id();
					$this->db->trans_complete(); 

					$this->db->where('subt_id',$raw->subt_id);
					$this->db->update('wip_sub_task', $update_strat_date);

				}
			}					
		}

		return $updatetask_notification;
    }

function completed_task_notification_accept($noti_id){

		$notificationdata=array( 
			'noti_status' => 'accepted',
		);

		$this->db->where('id',$noti_id);
		$insert=$this->db->update('wip_notification', $notificationdata);

		return $insert;
	}

	function extend_main_task_accept_view($task_id){
		$this->db->select('wip_task_extend.*,wip_task.*');
    	$this->db->join('wip_task','wip_task.task_id=wip_task_extend.task_or_sub_id');
		$this->db->where('task_id',$task_id);
		$this->db->where('status','pending');
		$this->db->order_by('id','DESC');
		$query = $this->db->get('wip_task_extend'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}	
		else
			return false;
	}

	function task_extend_accept(){
		$main_task_duration=$this->input->post('task_duration', TRUE);
    	$request_duration=$this->input->post('request_duration', TRUE);
		$new_end_date = $this->input->post('task_end_date', TRUE);
    	$task_id=$this->input->post('task_id', TRUE);
    	$updated_date=date("Y-m-d");
    	$subt_id=0;

    	if($task_id){
			
			//get task
			$task = $this->get_task_bycode($task_id);
			//$task_new_enddate = date('Y-m-d', strtotime($task->task_sdate. ' + '.$request_duration.' days')); //calculate new end date
			
			//get total days
			$total_days = get_task_remaining_days($task->task_sdate,$new_end_date); //wip helper funtion
			
			//skip holidays if present
			$task_new_enddate = $this->Sub_task_model->sub_task_skip_holiday_count($task->task_sdate,$total_days);
			
    		$main_task_update=array( 
				'task_duration' => $total_days,
				'task_status' => 'processing',
				'task_edate' => $task_new_enddate,
			);

			$this->db->where('task_id',$task_id);
			$this->db->update('wip_task', $main_task_update);


			$this->db->select('*');
    		$this->db->where('task_or_sub_id',$task_id);
			$this->db->where('status','pending');
			$query = $this->db->get('wip_task_extend'); 
		
			$task_extend_result=$query->row();

			if($task_extend_result){
				$update_extend=array( 
					'status' => 'accepted',
				);

				$this->db->where('id',$task_extend_result->id);
				$this->db->update('wip_task_extend', $update_extend);
			}

			$this->db->select('*');
    		$this->db->where('task_id',$task_id);
			$this->db->where('noti_status','pending');
			$this->db->where('noti_type','Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$subt_id=$notification_result->sub_task_id;

				$notificationdata=array( 
					'created_date' => $updated_date,
					'noti_status' => 'pending',
					'noti_type' => 'Task Extend Accept',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);
			}

			if($subt_id){
				
				//get sub task
				$this->db->select('*');
				$this->db->where('subt_id',$subt_id);
				$query = $this->db->get('wip_sub_task'); 
				$stask = $query->row();
				//$stask_new_enddate = date('Y-m-d', strtotime($stask->subt_sdate. ' + '.$request_duration.' days')); //calculate new end date
				
				$stask_new_enddate = $this->Sub_task_model->sub_task_skip_holiday_count($stask->subt_sdate,$request_duration);
			
				$data=array( 
					'updated_date' => $updated_date,
					'subt_duration' => $request_duration,
					'subt_edate' => $stask_new_enddate,
					'subt_status' => 'processing',
				);

				$this->db->where('subt_id',$subt_id);
				$insert = $this->db->update('wip_sub_task', $data);
			}						
    	}

    	return $insert;    	
	}

	function get_all_holidays(){
		$this->db->select('*');
		$query = $this->db->get('ln_config_holiday'); 
		
		if ($query->num_rows() > 0){
			return $query->result();  
		}	
		else
			return false;
	}

	function reject_extend($extend_id,$task_id){
		$updated_date=date("Y-m-d");

		if($extend_id){
			$reject_update=array( 
				'status' => 'rejected',
			);

			$this->db->where('id',$extend_id);
			$this->db->update('wip_task_extend', $reject_update);


			$this->db->select('*');
			$this->db->where('task_id',$task_id);
			$this->db->where('noti_status','pending');
			$this->db->where('noti_type','Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$notificationdata=array( 
					'created_date' => $updated_date,
					'noti_status' => 'pending',
					'noti_type' => 'Task Extend Reject',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);
			}
		}
	}

	function get_all_processing_task_details($pagination_counter,$page_count,$userid){

    	$this->db->select('wip_task.*,wip_project.*');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
    	$this->db->where('wip_task.task_status !=','deleted');
    	$this->db->where('wip_task.task_status !=','completed');	
		$this->db->order_by('wip_task.task_id','DESC');
		//$this->db->group_by('wip_task.task_id','DESC');
		$this->db->limit($pagination_counter,$page_count);
		$query = $this->db->get('wip_task'); 

		$check=$query->result();
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else{
			return false;	
		}
    }

    function get_task_project_bycode($pro_id){
    	$this->db->select('wip_project.*,wip_task.*');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
    	$this->db->where('wip_project.prj_id',$pro_id);
    	$this->db->where('wip_task.task_status !=','deleted');
    	$this->db->order_by('wip_task.task_id','DESC');
    	$query = $this->db->get('wip_task');
    	if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else{
			return false;	
		}
    }
	
	function get_task_progress($task_id){
		$total_progress = 0;
		$sub_progress = 0;
		$statuses = array('processing', 'completed', 'expired','pending');
		$this->db->select('subt_progress,subt_duration');	
		$this->db->where('task_id',$task_id);
		$this->db->where_in('subt_status',$statuses);
		$query = $this->db->get('wip_sub_task');
    	if ($query->num_rows() > 0){
			$days = 0;
			$completion = 0;
			foreach($query->result() as $data){
				$days = $days + $data->subt_duration;
				if($data->subt_progress != 0){
					$sub_progress = $data->subt_duration*($data->subt_progress/100);
					$completion = $completion +	$sub_progress;
				}
			} 
			$total_progress = ($completion / $days) * 100;
			return round($total_progress, 2);
		}		
		else{
			return false;	
		}
	}
	
	function task_extendadd(){
		$notification_createdate=date("Y-m-d");
    	$task_id=$this->input->post('task_id', TRUE);
    	$task_duration=$this->input->post('task_duration', TRUE);
    	$request_duration=$this->input->post('extend_days', TRUE);

    	$task_extend_days= $task_duration+$request_duration;

    	$this->db->select('*');
    	$this->db->where('task_id',$task_id);
		$this->db->where('status','accepted');
		$query = $this->db->get('wip_task_extend'); 
		
		$task_extend_result=$query->row();

		if($task_extend_result){
			$data=array( 
				'days' => $task_extend_days,
				'reason' => $this->input->post('reason', TRUE),
				'status' => 'pending',
			);

			$this->db->where('id',$task_extend_result->id);
			$insert=$this->db->update('wip_task_extend', $data);

		}else{
			$data=array( 
				'task_or_sub_id' => $this->input->post('task_id', TRUE),
				'task_type' => 'Task Extend',
				'days' => $task_extend_days,
				'reason' => $this->input->post('reason', TRUE),
				'status' => 'pending',
			);

			$this->db->trans_start();
			$this->db->insert('wip_task_extend', $data);
			$insert=$this->db->insert_id();
			$this->db->trans_complete();
		}		

		if($insert){

			$this->db->select('*');
			$this->db->where('task_id',$task_id);
			$this->db->where('noti_status','accepted');
			$this->db->where('noti_type','Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$notificationdata=array( 
					'created_date' => $notification_createdate,
					'noti_status' => 'pending',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);

			}else{
				$notificationdata=array( 
					'task_id' => $this->input->post('task_id', TRUE),
					//'sub_task_id' => $this->input->post('subt_id', TRUE),
					'created_date' => $notification_createdate,
					'noti_status' => 'pending',
					'noti_type' => 'Task Extend',
				);

		   		$this->db->trans_start();
				$this->db->insert('wip_notification', $notificationdata);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
			}			
		}

		return $insert;	
	}
	
	function is_project_owner($checkuser,$prj_id){
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('prj_createby',$checkuser);
		$query = $this->db->get('wip_project');
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}
	
	function expire_tasks(){
		$count = 0;
		//get expired tasks
		$this->db->select('*');
		$this->db->where('task_edate <=',date('Y-m-d'));
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data = array('task_status' => 'expired',);
				$this->db->where('task_id',$row->task_id);
				$this->db->update('wip_task',$data);
				$count ++;
			}
			return $count;
		}else{
			return false;	
		}	
	}
	
	function get_pending_tasks($user_id){
		$count = '';
		//get task count
		$this->db->select('*');
		$this->db->where('task_status','pending');
		$this->db->where('task_createby',$user_id);
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$count ++;
			}
		}
		//get sub task count
		$this->db->select('*');
		$this->db->where('subt_status','pending');
		$this->db->where('subt_createby',$user_id);
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$count ++;
			}
		}
		
		if($count != ''){
			return $count;
		}else{
			return false;
		}
	}
	
	function get_pending_task_aaprovals($user_id){
		$count = '';
		//get task count
		$this->db->select('*');
		$this->db->where('task_status','pending');
		$this->db->where('task_assign',$user_id);
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$count ++;
			}
		}
		//get sub task count
		$this->db->select('*');
		$this->db->where('subt_status','pending');
		$this->db->where('subt_assign',$user_id);
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$count ++;
			}
		}
		if($count != ''){
			return $count;
		}else{
			return false;
		}
	}
	
	function get_project_task_completion($user_id,$project_id,$type = 'completed'){
		//first we will get user tasks
		$task_ids = array();
		$subt_ids = array();
		$completed = 0;
		$incomplete = 0;
		$completion = 0;
		//get task count
		$this->db->select('*');
		$this->db->where('task_assign',$user_id);
		$this->db->where('prj_id',$project_id);
		$this->db->where('task_status !=','deleted');
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				array_push($task_ids,$row->task_id);
				if($row->task_status == $type){
					$completed++;
				}else{
					$incomplete++;
				}
				
				//get sub task count
				$this->db->select('*');
				$this->db->where('subt_assign',$user_id);
				$this->db->where('task_id',$row->task_id);
				$this->db->where('subt_status !=','deleted');
				$query = $this->db->get('wip_sub_task');
				if ($query->num_rows() > 0){
					foreach($query->result() as $row){
						array_push($subt_ids,$row->subt_id);
						if($row->subt_status == $type){
							$completed++;
						}else{
							$incomplete++;
						}
					}
				}
			}
		}
		
		//some users doesn't have tasks, so we take all tasks and find sub task completion
		$this->db->select('*');
		$this->db->where('prj_id',$project_id);
		if($task_ids){
			$this->db->where_not_in('task_id',$task_ids);
		}
		$this->db->where('task_status !=','deleted');
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				
				//get sub task count
				$this->db->select('*');
				$this->db->where('subt_assign',$user_id);
				$this->db->where('task_id',$row->task_id);
				if($subt_ids){
					$this->db->where_not_in('subt_id',$subt_ids);
				}
				$this->db->where('subt_status !=','deleted');
				$query = $this->db->get('wip_sub_task');
				if ($query->num_rows() > 0){
					foreach($query->result() as $row){
						if($row->subt_status == $type){
							$completed++;
						}else{
							$incomplete++;
						}
					}
				}
			}
		}
		
		$total = $completed + $incomplete;
		if($total != 0){
			$completion = ($completed / $total) * 100;
			return round($completion,2);
		}else{
			return false;
		}
	}
	
	function get_task_status_percentage($user_id,$type){
		$completed = 0;
		$incomplete = 0;
		$completion = 0;
		//get task count
		$this->db->select('*');
		$this->db->where('task_assign',$user_id);
		$this->db->where('task_status !=','deleted');
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				if($row->task_status == $type){
					$completed++;
				}else{
					$incomplete++;
				}
			}
		}
		//get sub task count
		$this->db->select('*');
		$this->db->where('subt_assign',$user_id);
		$this->db->where('subt_status !=','deleted');
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				if($row->subt_status == $type){
					$completed++;
				}else{
					$incomplete++;
				}
			}
		}
		
		$total = $completed + $incomplete;
		if($total != 0){
			$completion = ($completed / $total) * 100;
			return round($completion,2);
		}else{
			return false;
		}
		
	}
	
	function get_expired_tasks($user_id){
		$count = '';
		//get task count
		$this->db->select('*');
		$this->db->where('task_status','expired');
		$this->db->where('task_assign',$user_id);
		$query = $this->db->get('wip_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$count ++;
			}
		}
		//get sub task count
		$this->db->select('*');
		$this->db->where('subt_status','expired');
		$this->db->where('subt_assign',$user_id);
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$count ++;
			}
		}
		if($count != ''){
			return $count;
		}else{
			return false;
		}	
	}

	// Added by Kalum 2020.02.03

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

	function delete_task_attachment($id){
    	if($id){
    		$this->db->where('id', $id);
			$insert = $this->db->delete('wip_task_attachment');
			return $insert;
    	}
    	else
		return false;							
	}

	// end
}
