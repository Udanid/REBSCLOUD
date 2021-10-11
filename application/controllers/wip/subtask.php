<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subtask extends CI_Controller {

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
		$this->load->view('wip/sub_task/subtask_main');
	}

	function sub_task_accept(){
		$subtask_id=$this->uri->segment(4);

		$data=NULL;
		if ( ! check_access('accept_sub_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
		$get_sub_task_file_attachment=NULL;
					
		$data['details']=$details=$this->Tasknotification_model->get_subtasks_bycode_for_notification_view($subtask_id);

		$data['get_sub_task_file_attachment']=$get_sub_task_file_attachment = $this->Sub_task_model->get_task_file_attachment($subtask_id);
		
		$this->common_model->add_activeflag('wip_sub_task',$subtask_id,'subt_id');
		$session = array('activtable'=>'wip_sub_task');
		$this->session->set_userdata($session);
		$this->load->view('wip/sub_task/sub_task_accept',$data);
	}
	
	function reject($task_id,$subt_id,$reason){
		if ( ! check_access('accept_sub_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$reason =  base64_decode(urldecode($reason));
		
		$id=$this->Sub_task_model->subtask_reject_update($task_id,$subt_id,$reason);

		if($id==1){
			//insert log 
			$subtasklog=array( 
				'task_type' => 'Sub Task',
				'id' => $subt_id,
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Sub Task Rejected - '.$reason,
				);
			$this->Task_log_model->add_tasklog($subtasklog);
			//End insert log
		}
		
		$this->session->set_flashdata('msg', 'Sub Task Rejected');
		$this->logger->write_message("success", $task_id.' - '.$subt_id.'  Rejected');
		redirect("wip/task/showall");
		
	}

	function sub_task_accept_view_for_popup(){
		$subtask_id=$this->uri->segment(4);

		$data=NULL;
		if ( ! check_access('accept_sub_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
					
		$data['details']=$details=$this->Tasknotification_model->get_subtasks_bycode_for_notification_view($subtask_id);

		$data['get_sub_task_file_attachment']=$get_sub_task_file_attachment = $this->Sub_task_model->get_task_file_attachment($subtask_id);
		
		$this->common_model->add_activeflag('wip_sub_task',$subtask_id,'subt_id');
		$session = array('activtable'=>'wip_sub_task');
		$this->session->set_userdata($session);
		$this->load->view('wip/sub_task/subtask_accept_popup',$data);
	}

	function accept_notification(){
		if ( ! check_access('accept_sub_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Tasknotification_model->accept_sub_task_notification_update();

		if($id==1){
			//insert log 
			$subtasklog=array( 
				'task_type' => 'Sub Task',
				'id' => $this->input->post('subt_id', TRUE),
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Sub Task Accepted',
				);
			$this->Task_log_model->add_tasklog($subtasklog);
			//End insert log
		}
		
		$this->session->set_flashdata('msg', 'Accept Update Successfully Inserted');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		redirect("wip/task/showall");
	}

	function progess_view(){
		$data=NULL;
		if ( ! check_access('view_progress'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$details=NULL;
		$subtaskdetails=NULL;
		$attachments=NULL;
		$comments=NULL;

		 $sub_task_id=$this->uri->segment(4);
		
		$data['details']=$details=$this->Sub_task_model->get_task_bycode_for_prograss_update($sub_task_id);

		$data['attachments']=$attachments=$this->Sub_task_model->get_subtask_attachment($sub_task_id);

		$data['comments']=$comments=$this->Sub_task_model->get_subtask_comments($sub_task_id);
						
		$this->common_model->add_activeflag('wip_task',$this->uri->segment(4),'task_id');
		$session = array('activtable'=>'wip_task');
		$this->session->set_userdata($session);
		$this->load->view('wip/sub_task/prograss_update',$data);
	}


	function update_prograss(){
		if ( ! check_access('edit_progress'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect("wip/task/showall");
			return;
		}

		$subt_id= $this->input->post('subt_id', TRUE);
		
		$id=$this->Sub_task_model->update_sub_task_progress();
		
		$this->session->set_flashdata('msg', 'Progress Update Successfully');
		$this->logger->write_message("success", $this->input->post('subt_id').'  successfully Inserted');

		redirect("wip/task/showall");
	}

	function viewsubtasklist(){
		$data=NULL;

		$userid = $this->session->userdata('userid');

		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		$task_id = (int)$this->uri->segment(4);
		
		$data['subtaskdetalist']=$this->Sub_task_model->get_all_subtask_details($task_id,$userid);

		$this->load->view('wip/sub_task/subtask_main',$data);
	}

	function viewsubtask(){
		$data=NULL;
		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		 $sub_task_id=$this->uri->segment(4);
		
		$data['details']=$this->Sub_task_model->get_task_bycode_for_prograss_update($sub_task_id);
		$data['attachments']=$attachments=$this->Sub_task_model->get_subtask_attachment($sub_task_id);
		$data['comments']=$comments=$this->Sub_task_model->get_subtask_comments($sub_task_id);
						
		$this->common_model->add_activeflag('wip_task',$this->uri->segment(4),'task_id');
		$session = array('activtable'=>'wip_task');
		$this->load->view('wip/sub_task/subtask_view',$data);
	} 

	public function delete(){
		
		if ( ! check_access('task_delete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$subtask_id=$this->uri->segment(4);
		
		$id=$this->Sub_task_model->delete($subtask_id);

		if($id!=1){
	 		$this->session->set_flashdata('error', 'Can not delete,beacuse some prograss include');
			redirect('wip/task/showall');
			return;
	 	}else{
	 		//insert log 
			$subtasklog=array( 
				'task_type' => 'Sub Task',
				'id' => $subtask_id,
				'user_id' => $this->session->userdata('userid'),
				'log_action'=>'Sub Task Deleted',
				);
			$this->Task_log_model->add_tasklog($subtasklog);
			//End insert log

	 		$this->common_model->delete_notification('wip_task',$this->uri->segment(4));
			$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
			$this->logger->write_message("success", $subtask_id.' Task id successfully Deleted');
			redirect("wip/task/showall");
	 	}
	} 

	function view_subtask_extend(){
		$data=NULL;
		$subtaskextend=NULL;

		$userid = $this->session->userdata('userid');

		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		$subt_id = (int)$this->uri->segment(4);
		
		$data['subtaskextend']=$subtaskextend=$this->Sub_task_model->view_subtask_extend($subt_id);

		$this->load->view('wip/sub_task/sub_extend',$data);
	} 

	function extendadd(){

		if ( ! check_access('extend_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Sub_task_model->sub_task_extendadd();		
		
		$this->session->set_flashdata('msg', 'Request Successfully Sent');
		$this->logger->write_message("success", $this->input->post('subt_id').'  successfully Inserted');
		redirect("wip/task/showall");
	}

	function extend_task_accept_view(){
    	$data=NULL;
		$subtaskextend=NULL;

		$userid = $this->session->userdata('userid');

		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		$subt_id = (int)$this->uri->segment(4);
		
		$data['subtaskextend']=$subtaskextend=$this->Sub_task_model->extend_task_accept_view($subt_id);

		$this->load->view('wip/sub_task/sub_extend_view',$data);
    }

    function sub_task_extend_accept_or_request(){
    	if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}
		
		$id=$this->Sub_task_model->sub_task_extend_accept_or_request();	
		
		$this->session->set_flashdata('msg', 'Request Successfully Sent');
		$this->logger->write_message("success", $this->input->post('task_id').'  successfully Inserted');
		redirect("wip/task/showall");
    }

    function reject_extend(){
		$extend_id=$this->uri->segment(4);
		$subt_id=$this->uri->segment(5);

		$id=$this->Sub_task_model->reject_extend($extend_id,$subt_id);	
		
		$this->session->set_flashdata('msg', 'Request Reject Successfully Sent');
		$this->logger->write_message("success", $this->input->post('id').'  successfully Inserted');
		redirect("wip/task/showall");

	}

	function completed_subtask_notification_accept(){
		$noti_id=$this->uri->segment(4);

		$this->Sub_task_model->completed_subtask_notification_accept($noti_id);
		redirect("wip/task/showall");
	}

	function sub_task_accept_notification_comform(){
		$noti_id=$this->uri->segment(4);

		$this->Sub_task_model->sub_task_accept_notification_comform($noti_id);
		redirect("wip/task/showall");
	}

	function accept_prograss_notification(){
		$data=NULL;
		if ( ! check_access('view_task'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/task/showall');
			return;
		}

		$sub_task_id=$this->uri->segment(4);
		$noti_id=$this->uri->segment(5);

		$this->Sub_task_model->accept_prograss_notification($noti_id);
		
		$data['details']=$this->Sub_task_model->get_task_bycode_for_prograss_update($sub_task_id);
		$data['attachments']=$attachments=$this->Sub_task_model->get_subtask_attachment($sub_task_id);
		$data['comments']=$comments=$this->Sub_task_model->get_subtask_comments($sub_task_id);
						
		$this->common_model->add_activeflag('wip_task',$this->uri->segment(4),'task_id');
		$session = array('activtable'=>'wip_task');
		$this->load->view('wip/sub_task/subtask_view',$data);
	}

	function sub_task_accept_notification_comform_by_task_assigner(){
		$noti_id=$this->uri->segment(4);

		$id=$this->Tasknotification_model->sub_task_accept_notification_comform_by_task_assigner($noti_id);	

		redirect("wip/task/showall");
	}

	function sub_task_reject_notification_comform(){
		$noti_id=$this->uri->segment(4);

		$id=$this->Tasknotification_model->sub_task_reject_notification_comform_by_subtask_assigner($noti_id);	

		redirect("wip/task/showall");
	}

	// Added By Kalum 2020.02.03

	public function delete_sub_task_attachment(){
		$id=$this->uri->segment(4);
		$data=$this->Sub_task_model->delete_sub_task_attachment($id);
  		
  		echo json_encode($data);
	}

	// end

}
