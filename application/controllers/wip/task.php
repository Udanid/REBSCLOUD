<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model("user/user_model");		
		$this->load->library('form_validation');
		$this->load->model("common_model");
		$this->is_logged_in();
		$this->load->model("wip/Project_model");
		$this->load->model("wip/Task_model");
		$this->load->model("wip/Sub_task_model");
		$this->load->model('wip/Tasknotification_model');
		$this->load->model('wip/Task_log_model');
    }

	function showall(){

		$data=NULL;
		$alldetails=NULL;

		$userid = $this->session->userdata('userid');		

		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$data['searchdata']=$searchdata=$this->Project_model->get_all_project_names();

		$courseSelectList="";
		$count=0;

		if($searchdata){			
			foreach($searchdata as $c){               
       			 
       		$courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->prj_name.'</option>';
       			 $count++;           
   			}
   		}
			$data['searchdata']=$courseSelectList;
			//$data['searchpath']='wip/task/edit';
			//$data['tag']='Search customer';
			$pagination_counter =RAW_COUNT;
			$page_count = (int)$this->uri->segment(4);
			if ( !$page_count){
				$page_count = 0;
			}
			$data['datalist']=$this->Task_model->get_all_processing_task_details($pagination_counter,$page_count,$userid);
			$siteurl='wip/task/showall';
			$tablename='wip_task';
			$data['tab']='';
			
			if($page_count){
				$data['tab']='list';
			}
		
			$this->pagination($page_count,$siteurl,$tablename);

			$data['allproject']=$this->Project_model->get_all_project_names();
			$data['allemployees']=$this->Task_model->get_all_employees();
			$data['holidays']=$this->Task_model->get_all_holidays();

			$this->load->view('wip/task/task_main',$data);
	}

	function add(){
		
		if ( ! check_access('add_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

	 	$task_createby=$this->session->userdata('userid');
    	$task_createdate=date("Y-m-d");
    	$data['task_accepted_status']=0;

    	$data['task_name'] = $this->input->post('task_mame', TRUE);
    	$data['prj_id'] = $this->input->post('prj_id', TRUE);
    	$data['task_assign'] = $task_assign = $this->input->post('task_assign', TRUE);
    	$data['task_description	'] = $this->input->post('task_description', TRUE);
    	$data['task_duration']=$this->input->post('task_duration', TRUE);
    	$data['task_createdate']=$task_createdate;
    	$data['task_sdate']= $task_start_date = $this->input->post('task_start_date', TRUE);
    	$data['task_createby']=$task_createby;
    	$data['task_status']="pending";
    	$data['task_edate']=$this->input->post('showenddate', TRUE);

    	if($task_assign == $task_createby && $task_start_date == $task_createdate){
    		$data['task_accepted_status']=1;
    		$data['task_status']="processing";
    	}

    	$task_id=$this->Task_model->add($data);

    	if($task_id!=false){
    		//insert log 
	    	$tasklog=array( 
				'task_type' => 'Task',
				'id' => $task_id,
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Task Created',
			);
	    	$this->Task_log_model->add_tasklog($tasklog);
	    	//End insert log

	    	$numofrow=$this->input->post('numofrows', TRUE);
	    	for($i=1; $i<=$numofrow; $i++)
			{
				if(isset($_POST['subtask'][$i]))
				{
					$subdata['subt_hold_sdate']=NULL;
					$subdata['subt_hold_edate']=NULL;
					$subdata['subt_accepted_status']=0;
					$subdata['hold_status']='active';
					$subdata['subt_sdate']=NULL;
				    $subdata['subt_edate']=NULL;
					$subdata['task_id']=$task_id;				
					$subdata['task_id']=$task_id;				
			    	$subdata['subt_name']=$_POST['subtask'][$i]['name'];
			    	$subdata['subt_createdate']=$task_createdate;
			    	$subdata['subt_assign']=$subtask_assign=$_POST['subtask'][$i]['assign'];
			    	$subdata['subt_createby']=$task_createby;
			    	$subdata['subt_status']='pending';
			    	$subdata['subt_duration']=$_POST['subtask'][$i]['durarion'];
			    	$subdata['sub_description']=$_POST['subtask'][$i]['sub_description'];

			    	if(isset($_POST['subtask'][$i]['hold']) ){
			    		$subdata['hold_status']=$_POST['subtask'][$i]['hold'];
			    		$subdata['subt_hold_sdate']=$task_createdate;
			    		$subdata['subt_hold_edate']=$_POST['subtask'][$i]['holdenddate'];
			    	}else{
			    		if($subtask_assign==$task_createby && $task_start_date == $task_createdate && $data['task_accepted_status']==1){
			    			$subdata['subt_accepted_status']=1;
			    			$subdata['subt_status']="processing";

			    			//$subt_edate=date('Y-m-d', strtotime("+".$subdata['subt_duration']." days"));

			    			$subt_edate = $this->Sub_task_model->sub_task_skip_holiday_count($task_createdate,$subdata['subt_duration']);

			    			/*if($holiday_count){
			    				$total_duration=$subdata['subt_duration']+$holiday_count;
			    				$subt_edate=date('Y-m-d', strtotime("+".$total_duration." days"));
			    			}*/			    			

				    		$subdata['subt_sdate']=$task_createdate;
				    		$subdata['subt_edate']=$subt_edate;	
			    		}
			    		
			    	}
			    	
					$subtaskid=$this->Sub_task_model->add_subtask($subdata,$i);

					if($subtaskid!=false){

						//new notification
						if($task_assign == $task_createby && $task_start_date == $task_createdate && $subtask_assign!=$task_createby){
							$sub_notification=array( 
								'task_id' => $task_id,
								'sub_task_id' => $subtaskid,
								'created_date' => $task_createdate,
								'noti_status' => 'pending',
								'noti_type' => 'Sub Task Accept',
							);
							$this->Tasknotification_model->add_sub_task_notification_bycreater($sub_notification);
						}
						//end notification
						
						//insert log 
				    	$subtasklog=array( 
										'task_type' => 'Sub Task',
										'id' => $subtaskid,
										'user_id' => $this->session->userdata('userid'),
										'log_action'=>'Sub Task Created',
									);
				    	$this->Task_log_model->add_tasklog($subtasklog);
				    	//End insert log
					}
				}
			}
    	}
	 	$this->session->set_flashdata('msg', 'Task Successfully Inserted');
		$this->logger->write_message("success", $this->input->post('task_mame').'  successfully Inserted');
		
		redirect("wip/task/showall");
	}

	function edit(){
		$data=NULL;
		if ( ! check_access('edit_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
		$get_task_file_attachment=NULL;
		
		$data['details']=$details=$this->Task_model->get_task_bycode($this->uri->segment(4));
		
		$data['subtaskdetails']=$subtaskdetails=$this->Task_model->get_subtasks_bycode($this->uri->segment(4));

		$data['get_task_file_attachment']=$get_task_file_attachment = $this->Task_model->get_task_file_attachment($this->uri->segment(4));

		$data['allproject']=$this->Project_model->get_all_project_names();
		$data['allemployees']=$this->Task_model->get_all_employees();		
				
		$this->common_model->add_activeflag('wip_task',$this->uri->segment(4),'task_id');
		$session = array('activtable'=>'wip_task');
		$this->session->set_userdata($session);
		$this->load->view('wip/task/edit',$data);
	}

	
	function addedit(){
		if ( ! check_access('edit_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

	 	$task_createby=$this->session->userdata('userid');
    	$task_updatedate=date("Y-m-d");
    	$task_id = $this->input->post('task_id', TRUE);

    	$data['task_name'] = $this->input->post('task_mame', TRUE);
    	$data['prj_id'] = $this->input->post('prj_id', TRUE);
    	$data['task_assign'] = $this->input->post('task_assign', TRUE);
    	$data['task_description	'] = $this->input->post('task_description', TRUE);
    	$data['task_duration']=$this->input->post('task_duration', TRUE);
    	$data['task_updatedate']=$task_updatedate;
    	$data['task_edate']=$this->input->post('showenddate', TRUE);
    	$data['task_sdate']=$task_start_date=$this->input->post('task_start_date', TRUE);

     	$this->Task_model->insert_edit_data($data);

  	 	$numofrow=$this->input->post('nuberofrowsedit', TRUE);
     	for($i=0; $i<=$numofrow; $i++)
		{
			
			if(isset($_POST['subtaskedit'][$i]))
			{
				$subdata['subt_name']=NULL;
				$subdata['subt_assign']=NULL;
				$subdata['subt_duration']=NULL;
				$subdata['subt_id']=NULL;
				$subdata['hold_status']='active';
				$subdata['task_id']=$task_id;			
		    	$subdata['subt_name']=$_POST['subtaskedit'][$i]['name'];
		    	$subdata['subt_assign']=$subt_assign=$_POST['subtaskedit'][$i]['assign'];
		    	$subdata['subt_duration']=$_POST['subtaskedit'][$i]['durarion'];
		    	$subdata['sub_description']=$_POST['subtaskedit'][$i]['sub_description'];
		    	if(isset($_POST['subtaskedit'][$i]['hold']) ){
		    		$subdata['hold_status']=$_POST['subtaskedit'][$i]['hold'];
		    		$subdata['subt_hold_sdate']=$task_updatedate;
		    		if($_POST['subtaskedit'][$i]['holdenddate'] !=''){
		    			$subdata['subt_hold_edate']=$_POST['subtaskedit'][$i]['holdenddate'];
		    		}
		    		else{
		    			$subdata['subt_hold_edate']=NULL;
		    		}
		    	}

		    	if($_POST['subtaskedit'][$i]['subid'] !=NULL){
		    		$subt_id=$_POST['subtaskedit'][$i]['subid'];
		    		$subdata['subt_id']=$_POST['subtaskedit'][$i]['subid'];	
					
					if($_POST['subtaskedit'][$i]['subt_status'] == 'rejected'){
						$subdata['subt_status']="pending";
					}
					
					$this->Sub_task_model->edit_subtask($subdata,$subt_id,$task_id,$i);	
		    	}
		    	else{
		    		$subdata['subt_createby']=$task_createby;
		    		$subdata['subt_createdate']=$task_updatedate;
		    		$subdata['subt_status']='pending';
		    		if($subt_assign == $task_createby && $task_start_date<=$task_updatedate){
		    			$subdata['subt_accepted_status']=1;
			    		$subdata['subt_status']="processing";

			    		//$subt_edate=date('Y-m-d', strtotime("+".$subdata['subt_duration']." days"));

						$subt_edate = $this->Sub_task_model->sub_task_skip_holiday_count($task_updatedate,$subdata['subt_duration']);

						/*if($holiday_count){
							$total_duration=$subdata['subt_duration']+$holiday_count;
							$subt_edate=date('Y-m-d', strtotime("+".$total_duration." days"));
						}*/			    			

						$subdata['subt_sdate']=$task_updatedate;
						$subdata['subt_edate']=$subt_edate;

		    		}else{
		    			$subdata['subt_sdate']=$task_updatedate;
				    	$subdata['subt_edate']=NULL;
		    		}
		    		$subt_id=$this->Sub_task_model->add_edited_subtask($subdata,$task_id,$i);
		    		if($subt_id!=false){
		    			//new notification
						if($subt_assign != $task_createby){
							$sub_notification=array( 
								'task_id' => $task_id,
								'sub_task_id' => $subt_id,
								'created_date' => $task_updatedate,
								'noti_status' => 'pending',
								'noti_type' => 'Sub Task Accept',
							);
							$this->Tasknotification_model->add_sub_task_notification_bycreater($sub_notification);
						}
						//end notification
						//insert log 
				    	$subtasklog=array( 
										'task_type' => 'Sub Task',
										'id' => $subt_id,
										'user_id' => $this->session->userdata('userid'),
										'log_action'=>'Sub Task Created',
									);
				    	$this->Task_log_model->add_tasklog($subtasklog);
				    	//End insert log
					}
		    	}		    	
										
			}

		}		

	 	$this->session->set_flashdata('msg', 'Task Update Successfully Inserted');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		
		redirect("wip/task/showall");
	}


	function view(){
		$data=NULL;
		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
		
		$data['taskdetails']=$details=$this->Task_model->get_task_employe_bycode($this->uri->segment(4));
		
		$data['subtaskdetails']=$this->Sub_task_model->get_subtasks_employee_bycode($this->uri->segment(4));

		$data['projectdetails']=$this->Project_model->get_project_bycode($details->prj_id);	
				
		$this->load->view('wip/task/view',$data);
	}

	public function delete(){
		
		if ( ! check_access('task_delete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$task_id=$this->uri->segment(4);
		
		$id=$this->Task_model->delete($task_id);

		if($id!=1){
	 		$this->session->set_flashdata('error', 'Can not delete,beacuse some prograss include');
			redirect('wip/task/showall');
			return;
	 	}else{
	 		//insert log 
		    $subtasklog=array( 
					'task_type' => 'Task',
					'id' => $task_id,
					'user_id' => $this->session->userdata('userid'),
					'log_action'=>'Task Deleted',
				);
		    $this->Task_log_model->add_tasklog($subtasklog);
		    //End insert log

	 		$this->common_model->delete_notification('wip_task',$this->uri->segment(4));
			$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
			$this->logger->write_message("success", $task_id.' Task id successfully Deleted');
			redirect("wip/task/showall");
	 	}		
	}

	function task_accept_view(){
		
		$task_id=$this->uri->segment(4);

		$data=NULL;
		if ( ! check_access('accept_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
		
		$data['details']=$details=$this->Tasknotification_model->get_task_bycode_for_notification($task_id);
		
		$data['subtaskdetails']=$subtaskdetails=$this->Tasknotification_model->get_subtasks_bycode_for_notification($task_id);	

		$data['get_task_file_attachment']=$get_task_file_attachment = $this->Tasknotification_model->get_task_file_attachment($task_id);					
		
		$this->common_model->add_activeflag('wip_task',$task_id,'task_id');
		$session = array('activtable'=>'wip_task');
		$this->session->set_userdata($session);
		$this->load->view('wip/task/notification_taskaccept',$data);
	}

	function task_accept_view_for_popup(){
		
		$task_id=$this->uri->segment(4);

		$data=NULL;
		if ( ! check_access('accept_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
		
		$data['details']=$details=$this->Tasknotification_model->get_task_bycode_for_notification($task_id);

		$data['subtaskdetails']=$subtaskdetails=$this->Tasknotification_model->get_subtasks_bycode_for_notification($task_id);

		$data['get_task_file_attachment']=$get_task_file_attachment = $this->Tasknotification_model->get_task_file_attachment($task_id);						
		
		$this->common_model->add_activeflag('wip_task',$task_id,'task_id');
		$session = array('activtable'=>'wip_task');
		$this->session->set_userdata($session);
		$this->load->view('wip/task/task_accept',$data);
	}

	function accept_notification(){
		if ( ! check_access('accept_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Tasknotification_model->accept_notification_update();

		if($id==1){
			//insert log 
			$subtasklog=array( 
				'task_type' => 'Task',
				'id' => $this->input->post('task_id', TRUE),
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Task Accepted',
				);
			$this->Task_log_model->add_tasklog($subtasklog);
			//End insert log
		}
		
		$this->session->set_flashdata('msg', 'Task Accepted successfully');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		redirect("wip/task/showall");
	}

	function task_accept_add(){
		
		if ( ! check_access('accept_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Task_model->task_accept__update();

		if($id==1){
			//insert log 
			$subtasklog=array( 
				'task_type' => 'Task',
				'id' => $this->input->post('task_id', TRUE),
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Task Accepted',
				);
			$this->Task_log_model->add_tasklog($subtasklog);
			//End insert log
		}
		
		$this->session->set_flashdata('msg', 'Task Accepted successfully');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		redirect("wip/task/showall");
	}
	
	function reject($task_id,$reason){
		if ( ! check_access('accept_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$reason =  base64_decode(urldecode($reason));
		
		$id=$this->Task_model->task_reject_update($task_id,$reason);
		if($id){
			//insert log 
			$tasklog=array( 
				'task_type' => 'Task',
				'id' => $task_id,
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Task Rejected - '.$reason,
				);
			$this->Task_log_model->add_tasklog($tasklog);
			//End insert log
		}
		
		$this->session->set_flashdata('msg', 'Task Rejected.');
		$this->logger->write_message("success", $task_id.' rejected');
		redirect("wip/task/showall");
	}

	function completed_task_notification_accept(){
		$noti_id=$this->uri->segment(4);

		$this->Task_model->completed_task_notification_accept($noti_id);
		redirect("wip/task/showall");


	}

	function extend_main_task_accept_view(){
		$data=NULL;
		$taskextend=NULL;

		$userid = $this->session->userdata('userid');

		if ( ! check_access('extend_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		$task_id = (int)$this->uri->segment(4);
		
		$data['taskextend']=$taskextend=$this->Task_model->extend_main_task_accept_view($task_id);

		$this->load->view('wip/task/task_extend_view',$data);
	}

	function task_extend_accept(){
		if ( ! check_access('extend_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Task_model->task_extend_accept();	
		
		$this->session->set_flashdata('msg', 'Request Successfully Accepted');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		redirect("wip/task/showall");
	}

	function get_all_holidays(){

		$data=NULL;
		
		$data=$this->Task_model->get_all_holidays();

		echo json_encode($data);

	}

	function reject_extend(){
		$extend_id=$this->uri->segment(4);
		$task_id=$this->uri->segment(5);

		$id=$this->Task_model->reject_extend($extend_id,$task_id);	
		
		$this->session->set_flashdata('msg', 'Request Reject Successfully Send');
		$this->logger->write_message("success", $this->input->post('id').'  successfully Inserted');
		redirect("wip/task/showall");

	}

	function task_accept_notification_comform_by_task_creator(){
		$noti_id=$this->uri->segment(4);

		$id=$this->Tasknotification_model->task_accept_notification_comform_by_task_creator($noti_id);	

		redirect("wip/task/showall");
	}

	function getTaskbyProjectID(){
		$data=NULL;
		$data['taskdetails']=$this->Task_model->get_task_project_bycode($this->uri->segment(4));
		$this->load->view('wip/task/task_search_data',$data);
	}
	
	function view_task_extend(){
		$data=NULL;
		$taskextend=NULL;

		$userid = $this->session->userdata('userid');

		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		$task_id = (int)$this->uri->segment(4);
		
		$data['taskextend']=$taskextend=$this->Task_model->get_task_bycode($task_id);

		$this->load->view('wip/task/task_extend',$data);
	}
	
	function extendadd(){

		if ( ! check_access('extend_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Task_model->task_extendadd();		
		
		$this->session->set_flashdata('msg', 'Request Successfully Send');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		redirect("wip/task/showall");
	}
	
	function expire_tasks_subtasks(){
		$num_tasks = $this->Task_model->expire_tasks();	
		$num_stasks = $this->Sub_task_model->expire_subtasks();
		echo $num_tasks + $num_stasks;
	}
	
	function clear_messages($user_id = ''){
		$this->Tasknotification_model->clear_messages($user_id);
		$this->session->set_flashdata('msg', 'Messages have been Cleared');
		redirect("wip/task/showall");
	}

	// Added By Kalum 2020.02.03

	public function delete_task_attachment(){
		$id=$this->uri->segment(4);
		$data=$this->Task_model->delete_task_attachment($id);
  		
  		echo json_encode($data);
	}

	// end	
}
