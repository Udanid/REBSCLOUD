<?php

class Sub_Task_model extends CI_Model {

    function Entry_model()
    {
        parent::__construct();
    }

    function add_subtask($data,$count)
	{
		$task_createby=$this->session->userdata('userid');  
    	$notification_createdate=date("Y-m-d"); 

		$this->db->trans_start();
		$this->db->insert('wip_sub_task', $data);
		$sub_id=$this->db->insert_id();
		$this->db->trans_complete();

		// file attachment
		$task_id=$data['task_id'];

		$IMG = isset($_FILES['sub_file'.$count]) ? $_FILES['sub_file'.$count] : array();
		$milliseconds = round(microtime(true));

		mkdir('uploads/task_attach_files/'.$task_id.'/'.$sub_id,0777,true);		
		
	    if (!empty($IMG)){
	        $uploads_dir = 'uploads/task_attach_files/'.$task_id.'/'.$sub_id.'/';
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
					  'sub_task_id' => $sub_id,
					  'file_name' => $name,
					  'file_path' => $file_path,						  				
				    );	

				    $this->db->trans_start();
					$this->db->insert('wip_sub_task_attachment', $fileupload);
					$id=$this->db->insert_id();
					$this->db->trans_complete();  
	            }
	        }

	    }else{
	       echo 'empty array';
	    }

		// end file attachment	

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $sub_id;
		}
	} 


	function add_edited_subtask($data,$task_id,$count)
	{
		$task_createby=$this->session->userdata('userid');  
    	$notification_createdate=date("Y-m-d"); 

		$this->db->trans_start();
		$this->db->insert('wip_sub_task', $data);
		$sub_id=$this->db->insert_id();
		$this->db->trans_complete();	

		// file attachment		

		$IMG = isset($_FILES['sub_file'.$count]) ? $_FILES['sub_file'.$count] : array();
		$milliseconds = round(microtime(true));

		mkdir('uploads/task_attach_files/'.$task_id.'/'.$sub_id,0777,true);		
		
	    if (!empty($IMG)){
	        $uploads_dir = 'uploads/task_attach_files/'.$task_id.'/'.$sub_id.'/';
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
					  'sub_task_id' => $sub_id,
					  'file_name' => $name,
					  'file_path' => $file_path,						  				
				    );	

				    $this->db->trans_start();
					$this->db->insert('wip_sub_task_attachment', $fileupload);
					$id=$this->db->insert_id();
					$this->db->trans_complete();  
	            }
	        }

	    }else{
	       echo 'empty array';
	    }

		// end file attachment			

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $sub_id;
		}
	} 
	
	function subtask_reject_update($task_id,$subt_id,$reason){
		$data=array( 
			'noti_status' => 'accepted',
		);

    	$this->db->where('task_id',$task_id);
		$this->db->where('sub_task_id',$subt_id);
		$this->db->update('wip_notification', $data);
		if ($this->db->affected_rows() > 0){
			$task_rejected_noti=array( 
				'task_id' => $task_id,
				'sub_task_id' => $subt_id,
				'created_date' => date("Y-m-d"),
				'noti_status' => 'pending',
				'noti_type' => 'Sub Task Rejected - '.$reason,
			);

		   	$this->db->trans_start();
			$this->db->insert('wip_notification', $task_rejected_noti);
			$notification_id=$this->db->insert_id();
			$this->db->trans_complete();
			
			$data=array( 
				'subt_assign' => 0,
				'subt_status' => 'rejected',
			);
	
			$this->db->where('task_id',$task_id);
			$this->db->where('subt_id',$subt_id);
			$this->db->update('wip_sub_task', $data);
		  return TRUE;
		}else{
		  return FALSE;
		}
	}

	function edit_subtask($data,$subt_id,$task_id,$count){

		$task_createby=$this->session->userdata('userid');  
    	$notification_createdate=date("Y-m-d"); 
    	

    	$this->db->where('subt_id',$subt_id);
		$insert = $this->db->update('wip_sub_task', $data);	

		// file attachment		

		$IMG = isset($_FILES['sub_file'.$count]) ? $_FILES['sub_file'.$count] : array();
		$milliseconds = round(microtime(true));

		mkdir('uploads/task_attach_files/'.$task_id.'/'.$subt_id,0777,true);		
		
	    if (!empty($IMG)){
	        $uploads_dir = 'uploads/task_attach_files/'.$task_id.'/'.$subt_id.'/';
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
					  'sub_task_id' => $subt_id,
					  'file_name' => $name,
					  'file_path' => $file_path,						  				
				    );	

				    $this->db->trans_start();
					$this->db->insert('wip_sub_task_attachment', $fileupload);
					$id=$this->db->insert_id();
					$this->db->trans_complete();  
	            }
	        }

	    }else{
	       echo 'empty array';
	    }

		// end file attachment	

		return $insert;
    }

	function get_subtasks_employee_bycode($code){
    	$this->db->select('wip_sub_task.*,hr_empmastr.initials_full');
    	$this->db->join('wip_sub_task','wip_sub_task.task_id=wip_task.task_id');
		$this->db->where('wip_task.task_id',$code);
		$this->db->join('hr_empmastr','hr_empmastr.id=wip_sub_task.subt_assign');
		$query = $this->db->get('wip_task'); 
		
		if ($query->num_rows() > 0){
			return $query->result();  
		}
		
		else
			return false;
    } 

     function get_task_bycode_for_prograss_update($sub_task_id){

     	$this->db->select('wip_project.prj_name,hr_empmastr.initials_full,wip_sub_task.*,wip_task.*');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
    	$this->db->join('hr_empmastr','hr_empmastr.id=wip_task.task_assign');
		$this->db->where('wip_sub_task.subt_id',$sub_task_id);
		$query = $this->db->get('wip_sub_task'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}	
		else
			return false;
    }

    function get_subtask_attachment($sub_task_id){
    	$this->db->select('*');
		$this->db->where('wip_sub_task_file.subt_id',$sub_task_id);
		$query = $this->db->get('wip_sub_task_file'); 
		
		if ($query->num_rows() > 0){
			return $query->result();  
		}	
		else
			return false;
    }

    function get_subtask_comments($sub_task_id){
    	$this->db->select('*');
		$this->db->where('wip_sub_task_comment.subt_id',$sub_task_id);
		$query = $this->db->get('wip_sub_task_comment'); 
		
		if ($query->num_rows() > 0){
			return $query->result();  
		}	
		else
			return false;
    }

    function get_all_subtask_details($taskid,$userid){

    	$this->db->select('wip_task.*,wip_sub_task.*,wip_project.prj_name');
    	$this->db->join('wip_sub_task','wip_sub_task.task_id=wip_task.task_id');
    	$this->db->join('wip_project','wip_project.prj_id=wip_task.prj_id');
    	$this->db->where('wip_sub_task.task_id',$taskid);
    	$this->db->where('wip_sub_task.hold_status','active');
		$this->db->order_by('wip_sub_task.subt_id','DESC');
		$query = $this->db->get('wip_task'); 

		$check=$query->result();
		
		if ($query->num_rows() > 0){
			return $query->result(); 
		}		
		else
			return false;
    }

    function update_sub_task_progress(){
    	$user=$this->session->userdata('userid');  
    	$updated_date=date("Y-m-d");
    	$subt_id= $this->input->post('subt_id', TRUE);
    	$task_id= $this->input->post('task_id', TRUE);
    	$subt_progress=$this->input->post('subt_progress', TRUE);
    	$task_assign=$this->input->post('task_assign', TRUE);

    		// file upload
 		
			$IMG = isset($_FILES['files']) ? $_FILES['files'] : array();
			$milliseconds = round(microtime(true));

		    if (!empty($IMG)) 
		    {
		        $uploads_dir = 'uploads/subtaskfile/';
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
						  'subt_id' => $subt_id,
						  'file_name' => $name,
						  'file_path' => $file_path,
						  'updated_date' => $updated_date,				
					    );	

					    $this->db->trans_start();
						$this->db->insert('wip_sub_task_file', $fileupload);
						$notification_id=$this->db->insert_id();
						$this->db->trans_complete();             

		            }
		        }
		          
		     }else{
		        echo 'empty array';
		     }

		// end file upload


		// sub task table update
		if($subt_progress==100){
			$data=array( 
			  'subt_progress' => $this->input->post('subt_progress', TRUE),			  
			  'updated_date' => $updated_date,				
			  'subt_status' => 'completed',
			);

				$this->db->select('id');
				$this->db->where('task_id',$task_id);
				$this->db->where('sub_task_id',$subt_id);
				$query = $this->db->get('wip_notification');

				$result=$query->row();

				if($result){
					$notificationdata=array( 
						'created_date' => $updated_date,
						'noti_status' => 'pending',
						'noti_type' => 'Sub Task Completed',
					);

					$this->db->where('id',$result->id);
					$this->db->update('wip_notification', $notificationdata);
				}else{
					$notificationdata=array( 
						'task_id' => $task_id,
						'sub_task_id' => $subt_id,
						'created_date' => $updated_date,
						'noti_status' => 'pending',
						'noti_type' => 'Sub Task Completed',
					);

					$this->db->trans_start();
					$this->db->insert('wip_notification', $notificationdata);
					$this->db->insert_id();
					$this->db->trans_complete();
				}

		}else{
			$data=array( 
				'subt_progress' => $this->input->post('subt_progress', TRUE),
				'updated_date' => $updated_date,
				'subt_status' => 'processing',
			);

			if($task_assign != $user){
				$notificationdata=array( 
					'task_id' => $task_id,
					'sub_task_id' => $subt_id,
					'created_date' => $updated_date,
					'noti_status' => 'pending',
					'noti_type' => 'Prograss Update',
				);
			
				$this->db->trans_start();
				$this->db->insert('wip_notification', $notificationdata);
				$this->db->insert_id();
				$this->db->trans_complete();
			}			
			
		}

		$this->db->where('subt_id',$subt_id);
		$insert = $this->db->update('wip_sub_task', $data);

		// end sub task table update

		// sub task comment table update

		if($insert){
			$sub_comment_data=array( 
				'comment' => $this->input->post('subt_comment', TRUE),
				'subt_id' => $subt_id,
				'updated_date' => $updated_date,
				'cmnt_progress' => $this->input->post('subt_progress', TRUE),

			);	

			$this->db->trans_start();
			$this->db->insert('wip_sub_task_comment', $sub_comment_data);
			$sub_comment=$this->db->insert_id();
			$this->db->trans_complete();		
		}

		// end sub task comment
    	
    		
		if($insert){
			
			$this->db->select('subt_progress,task_id,subt_duration');
			$statuses = array('processing', 'completed', 'expired');
			$this->db->where_in('subt_status',$statuses);
			$this->db->where('task_id',$task_id);
			$query = $this->db->get('wip_sub_task');
			$sub_result=$query->result();

			$sub_task_prograss_total=0;
			$days=0;
			$completion=0;
			$sub_progress = 0;
			foreach ($sub_result as $data) {
				//if($row->subt_duration=!0){
					//$total_sub_completed_days+=($row->subt_progress/100)*$row->subt_duration;
					//$total_days+=$row->subt_duration;
				//}
				$days = $days + $data->subt_duration;
				if($data->subt_progress != 0){
					$sub_progress = $data->subt_duration*($data->subt_progress/100);
					$completion = $completion +	$sub_progress;
				}
				
			}

			$sub_task_prograss_total = ($completion/$days)*100;
			
			//check pending subtasks
			$pending_stasks = false;
			$this->db->select('*');
			$this->db->where('task_id',$task_id);
			$this->db->where('subt_status','pending');
			$query = $this->db->get('wip_sub_task');
			if($query->num_rows() > 0){
				$pending_stasks = true;
			}

			if($sub_task_prograss_total==100 && $pending_stasks == false){					

				$data1=array( 
					'task_progress' => $sub_task_prograss_total,
					'task_status' => 'completed',				
				);

				// complete notification
				
				$this->db->select('id');
				$this->db->where('task_id',$task_id);
				$this->db->where('sub_task_id',0);
				$query = $this->db->get('wip_notification');

				$result=$query->row();

				if($result){
					$notificationdata=array( 
						'created_date' => $updated_date,
						'noti_status' => 'pending',
						'noti_type' => 'Task Completed',
					);

					$this->db->where('id',$result->id);
					$this->db->update('wip_notification', $notificationdata);
				}else{
					$notificationdata=array( 
						'task_id' => $task_id,
						'created_date' => $updated_date,
						'noti_status' => 'pending',
						'noti_type' => 'Task Completed',
					);

					$this->db->trans_start();
					$this->db->insert('wip_notification', $notificationdata);
					$this->db->insert_id();
					$this->db->trans_complete();
				}

				// end send notification
				
			}else{
				$data1=array( 
					'task_progress' => round($sub_task_prograss_total,2),				
				);
			}

				$this->db->where('task_id',$task_id);
				$prograss_update = $this->db->update('wip_task', $data1);
						   	 
		}

		return $insert;
    }

    function delete($subt_id){
		
		$data=array( 
			'subt_status' => 'deleted',
		);

		$this->db->select('*');
		$this->db->where('subt_id',$subt_id);
		$query = $this->db->get('wip_sub_task');

		if ($query->num_rows() > 0){
			$task_result=$query->row();

			if($task_result->subt_progress > 0){
				return false;			
			}else{
				$this->db->where('subt_id',$subt_id);
				$insert = $this->db->update('wip_sub_task', $data);
				return $insert;
			}
		}
	}

	function hold_date_update($todate)
	{
		$userid = $this->session->userdata('userid');

		$this->db->select('wip_sub_task.*,wip_task.task_id');
		$this->db->where('subt_hold_edate',$todate);
		$this->db->where('hold_status','Hold');		
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$query = $this->db->get('wip_sub_task'); 
		$result=$query->result();

		if($result){
			$data=array( 
				'subt_status' => 'processing',
			);

			foreach ($result as $raw){
				$this->db->where('subt_id', $raw->subt_id);
				$insert = $this->db->update('wip_sub_task', $data);

				$notificationdata=array( 
						'task_id' => $raw->task_id,
						'sub_task_id' => $raw->subt_id,
						'created_date' => $todate,
						'noti_status' => 'pending',
						'noti_type' => 'Sub Task Accept',
					);

				   	$this->db->trans_start();
					$this->db->insert('wip_notification', $notificationdata);
					$notification_id=$this->db->insert_id();
					$this->db->trans_complete();
			}
		}
						
		return $insert;
		
	}

	function view_subtask_extend($sub_task_id){
    	$this->db->select('*');
		$this->db->where('subt_id',$sub_task_id);
		$query = $this->db->get('wip_sub_task'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}	
		else
			return false;
    }

    function sub_task_extendadd(){
    	$notification_createdate=date("Y-m-d");
    	$subt_id=$this->input->post('subt_id', TRUE);
    	$subt_duration=$this->input->post('subt_duration', TRUE);
    	$request_duration=$this->input->post('sub_extend_days', TRUE);

    	$sub_extend_days= $subt_duration+$request_duration;

    	$this->db->select('*');
    	$this->db->where('task_or_sub_id',$subt_id);
		$this->db->where('status','accepted');
		$query = $this->db->get('wip_task_extend'); 
		
		$task_extend_result=$query->row();

		if($task_extend_result){
			$data=array( 
				'days' => $sub_extend_days,
				'reason' => $this->input->post('reason', TRUE),
				'status' => 'pending',
			);

			$this->db->where('id',$task_extend_result->id);
			$insert=$this->db->update('wip_task_extend', $data);

		}else{
			$data=array( 
				'task_or_sub_id' => $this->input->post('subt_id', TRUE),
				'task_type' => 'Sub Task Extend',
				'days' => $sub_extend_days,
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
			$this->db->where('sub_task_id',$subt_id);
			$this->db->where('noti_status','accepted');
			$this->db->where('noti_type','Sub Task Extend');
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
					'sub_task_id' => $this->input->post('subt_id', TRUE),
					'created_date' => $notification_createdate,
					'noti_status' => 'pending',
					'noti_type' => 'Sub Task Extend',
				);

		   		$this->db->trans_start();
				$this->db->insert('wip_notification', $notificationdata);
				$notification_id=$this->db->insert_id();
				$this->db->trans_complete();
			}			
		}

		return $insert;
    }

    function extend_task_accept_view($subt_id){
    	$this->db->select('wip_task_extend.*,wip_sub_task.*,wip_task.*');
    	$this->db->join('wip_sub_task','wip_sub_task.subt_id=wip_task_extend.task_or_sub_id');
    	$this->db->join('wip_task','wip_task.task_id=wip_sub_task.task_id');
		$this->db->where('subt_id',$subt_id);
		$this->db->where('status','pending');
		$query = $this->db->get('wip_task_extend'); 
		
		if ($query->num_rows() > 0){
			return $query->row();  
		}	
		else
			return false;
    }

    function sub_task_extend_accept_or_request(){
    	//$main_task_duration=$this->input->post('task_duration', TRUE);
		$sub_start_date = $this->input->post('sub_start_date', TRUE);
    	$requested_duration=$this->input->post('request_duration', TRUE);
    	$task_id=$this->input->post('task_id', TRUE);
    	$subt_id=$this->input->post('subt_id', TRUE);
    	$task_createby=$this->input->post('task_createby', TRUE);
    	$updated_date=date("Y-m-d");
    	$checkuser=$this->session->userdata('userid');
		
		$request_duration = sub_task_skip_holiday_count($sub_start_date,$requested_duration); //wip helper function
		$main_task_duration = $this->input->post('task_end_date', TRUE);
		
    	if($main_task_duration >= $request_duration){

    		$this->db->select('*');
    		$this->db->where('task_id',$task_id);
			$this->db->where('sub_task_id',$subt_id);
			$this->db->where('noti_status','pending');
			$this->db->where('noti_type','Sub Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$notificationdata=array( 
					'created_date' => $updated_date,
					'noti_status' => 'pending',
					'noti_type' => 'Sub Task Extend Accept',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);
			}

			$this->db->select('*');
    		$this->db->where('task_or_sub_id',$subt_id);
			$this->db->where('status','pending');
			$query = $this->db->get('wip_task_extend'); 
		
			$task_extend_result=$query->row();

			if($task_extend_result){
				$taskextend_data=array( 
					'status' => 'accepted',
				);

				$this->db->where('id',$task_extend_result->id);
				$this->db->update('wip_task_extend', $taskextend_data);
			}

			if($subt_id){
				
				//get sub task
				$this->db->select('*');
				$this->db->where('subt_id',$subt_id);
				$query = $this->db->get('wip_sub_task'); 
				$stask = $query->row();
				
				//$stask_new_enddate = date('Y-m-d', strtotime($stask->subt_sdate. ' + '.$request_duration.' days')); //calculate new end date
				
				$stask_new_enddate = $this->sub_task_skip_holiday_count($stask->subt_sdate,$requested_duration);
				
				$update_task_duration=array( 
					'subt_duration' => $requested_duration,
					'subt_edate' => $stask_new_enddate,
					'subt_status' => 'processing',
				);

				$this->db->where('subt_id',$subt_id);
				$update=$this->db->update('wip_sub_task', $update_task_duration);
			}

			return $update;
    	}else if($main_task_duration < $request_duration && $task_createby==$checkuser) {
    		$this->db->select('*');
    		$this->db->where('task_id',$task_id);
			$this->db->where('sub_task_id',$subt_id);
			$this->db->where('noti_status','pending');
			$this->db->where('noti_type','Sub Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$notificationdata=array( 
					'created_date' => $updated_date,
					'noti_status' => 'pending',
					'noti_type' => 'Sub Task Extend Accept',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);
			}

			$this->db->select('*');
    		$this->db->where('task_or_sub_id',$subt_id);
			$this->db->where('status','pending');
			$query = $this->db->get('wip_task_extend'); 
		
			$task_extend_result=$query->row();

			if($task_extend_result){
				$taskextend_data=array( 
					'status' => 'accepted',
				);

				$this->db->where('id',$task_extend_result->id);
				$this->db->update('wip_task_extend', $taskextend_data);
			}

			if($subt_id){
				$update_task_duration=array( 
					'subt_duration' => $requested_duration,
				);

				$this->db->where('subt_id',$subt_id);
				$update=$this->db->update('wip_sub_task', $update_task_duration);
			}

			if($task_id){
				$update_task_duration=array( 
					'task_duration' => $requested_duration,
				);

				$this->db->where('task_id',$task_id);
				$update=$this->db->update('wip_task', $update_task_duration);
			}

			return $update;
    	}else{
			
    		$this->db->select('*');
    		$this->db->where('task_or_sub_id',$subt_id);
			$this->db->where('status','pending');
			$query = $this->db->get('wip_task_extend'); 
		
			$task_extend_result=$query->row();

			if($task_extend_result){
				$taskextend_data=array( 
					'task_or_sub_id' => $task_id,
					'end_date' => $request_duration,
				);

				$this->db->where('id',$task_extend_result->id);
				$this->db->update('wip_task_extend', $taskextend_data);
			}   		

			// accept sub task request notification

			$this->db->select('*');
    		$this->db->where('task_id',$task_id);
			$this->db->where('sub_task_id',$subt_id);
			$this->db->where('noti_status','pending');
			$this->db->where('noti_type','Sub Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$notificationdata=array( 
					'created_date' => $updated_date,
					'noti_status' => 'accepted',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);
			}

			// end sub task notification

			// send notification

			$notificationdata=array( 
				'task_id' => $task_id,
				'sub_task_id' => $subt_id,
				'created_date' => $updated_date,
				'noti_status' => 'pending',
				'noti_type' => 'Task Extend',
			);

	   		$this->db->trans_start();
			$this->db->insert('wip_notification', $notificationdata);
			$notification_id=$this->db->insert_id();
			$this->db->trans_complete();

			// end notification

			return $update;
    	}	
	}

	function reject_extend($extend_id,$subt_id){
		$updated_date=date("Y-m-d");

		if($extend_id){
			$reject_update=array( 
				'status' => 'rejected',
			);

			$this->db->where('id',$extend_id);
			$this->db->update('wip_task_extend', $reject_update);


			$this->db->select('*');
			$this->db->where('sub_task_id',$subt_id);
			$this->db->where('noti_status','pending');
			$this->db->where('noti_type','Sub Task Extend');
			$query = $this->db->get('wip_notification'); 
		
			$notification_result=$query->row();

			if($notification_result){
				$notificationdata=array( 
					'created_date' => $updated_date,
					'noti_status' => 'pending',
					'noti_type' => 'Sub Task Extend Reject',
				);

				$this->db->where('id',$notification_result->id);
				$this->db->update('wip_notification', $notificationdata);
			}
		}
	}

	function completed_subtask_notification_accept($noti_id){

		$notificationdata=array( 
			'noti_status' => 'accepted',
		);

		$this->db->where('id',$noti_id);
		$insert=$this->db->update('wip_notification', $notificationdata);

		return $insert;
	}

	function sub_task_accept_notification_comform($noti_id){

		$notificationdata=array( 
			'noti_status' => 'accepted',
		);

		$this->db->where('id',$noti_id);
		$insert=$this->db->update('wip_notification', $notificationdata);

		return $insert;
	}

	function accept_prograss_notification($noti_id){
		$updated_date=date("Y-m-d");

		if($noti_id){
			$notificationdata=array( 
				'created_date' => $updated_date,
				'noti_status' => 'accepted',
			);

			$this->db->where('id',$noti_id);
			$this->db->update('wip_notification', $notificationdata);
		}
	}

	function sub_task_skip_holiday_count($start_date,$duration){
		
		$end_date = date('Y-m-d', strtotime($start_date. "+".$duration." days"));
		
		$this->db->select('COUNT(id) as holiday_count');
		$this->db->where('holiday_date >=',$start_date);
		$this->db->where('holiday_date <=',$end_date);
		$query = $this->db->get('ln_config_holiday'); 
		
		if ($query->num_rows() > 0){
			$count = $query->row()->holiday_count; 
			$total = $count+$duration;
			$new_end_date = date('Y-m-d', strtotime($start_date. "+".$total." days"));
			return  $new_end_date;
		}	
		else
			return $end_date;
	
	}
	
	function get_task_remaining_days($start_date,$end_date){
				
		$datetime1 = date_create($start_date); 
		$datetime2 = date_create($end_date); 
		  
		// calculates the difference between DateTime objects 
		$diff = date_diff($datetime1, $datetime2); 
		
		$remaining_days = $diff->format("%a");
		
		$this->db->select('COUNT(id) as holiday_count');
		$this->db->where('holiday_date >=',$start_date);
		$this->db->where('holiday_date <=',$end_date);
		$query = $this->db->get('ln_config_holiday'); 
		
		if ($query->num_rows() > 0){
			$count = $query->row()->holiday_count; 
			$remaining_days = $remaining_days - $count;
			
		}	
		
		return $remaining_days;
		
	}
	
	function expire_subtasks(){
		$count = 0;
		//get expired sub tasks
		$this->db->select('*');
		$this->db->where('subt_edate <=',date('Y-m-d'));
		$this->db->where('subt_progress <','100');
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			foreach($query->result() as $row){
				$data = array('subt_status' => 'expired',);
				$this->db->where('subt_id',$row->subt_id);
				$this->db->update('wip_sub_task',$data);
				$count ++;
			}
			return $count;
		}else{
			return false;	
		}	
	}
	
	function get_subtasks_by_taskid($task_id,$user_id){
		$this->db->select('*');
		$this->db->where('task_id',$task_id);
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;	
		}	
	}
	
	function is_user_have_subtasks($user_id,$task_id){
		$this->db->select('*');
		$this->db->where('task_id',$task_id);
		$this->db->where('subt_assign',$user_id);
		$this->db->where('subt_sdate <=',date('Y-m-d'));
		$query = $this->db->get('wip_sub_task');
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;	
		}
	}

	function get_task_file_attachment($sub_task_id){
		$this->db->select('*');
		$this->db->where('sub_task_id',$sub_task_id);
		$query = $this->db->get('wip_sub_task_attachment'); 

		if ($query->num_rows() > 0){
			return $query->result(); 
		}
		
		else
		return false;
	}

	// Added By Kalum 2020.02.03

	function delete_sub_task_attachment($id){
    	if($id){
    		$this->db->where('id', $id);
			$insert = $this->db->delete('wip_sub_task_attachment');
			return $insert;
    	}
    	else
		return false;							
	}

}