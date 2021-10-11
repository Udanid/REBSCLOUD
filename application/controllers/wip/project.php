<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

	function __construct() {
        parent::__construct();
		$this->load->model("user/user_model");		
		$this->load->library('form_validation');
		$this->load->model("common_model");
		$this->is_logged_in();
		$this->load->model("wip/Project_model");
		

    }

    function showall(){

    	$data=NULL;
    	if ( ! check_access('view_project'))
    	{
    		$this->session->set_flashdata('error', 'Permission Denied');
    		redirect('wip/task/showall');
    		return;
    	}

    	$data['alldetails']=$alldetails=$this->Project_model->get_all_project_summery();

    	$courseSelectList="";
    	$count=0;
    	
    	if($alldetails){	
    		foreach($alldetails as $c){               
    			
    			$courseSelectList .= '<option id="select"'.$count.' value="'.$c->prj_id.'">'.$c->prj_name .' '.$c->prj_createby .' '.$c->prj_create_date .'</option>';
    			$count++;           
    		}
    	}
    	$data['alldetails']=$courseSelectList;
    	$data['searchpath']='re/project/edit';
    	$data['tag']='Search customer';
    	$pagination_counter =RAW_COUNT;
    	$page_count = (int)$this->uri->segment(4);
    	if (!$page_count)
    		$page_count = 0;
    	$data['datalist']=$this->Project_model->get_all_project_details($pagination_counter,$page_count);
    	$siteurl='wip/project/showall';
    	$tablename='wip_project';
    	$data['tab']='';
    	
    	if($page_count)
    		$data['tab']='list';
    	
    	$this->pagination($page_count,$siteurl,$tablename);

    	$data['projectsnames']=$this->Project_model->get_all_project_names();

    	$this->load->view('wip/project/project_main',$data);
    }

	function add(){
		
		if ( ! check_access('add_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/project/showall');
			return;
		}

	 	$checkproject=$this->Project_model->add();

	 	if($checkproject!=1){
	 		$this->session->set_flashdata('error', 'Project Name Already exists');
			redirect('wip/project/showall');
			return;
	 	}else{
	 		$this->session->set_flashdata('msg', 'Project Successfully Inserted');
			$this->logger->write_message("success", $this->input->post('project_name').'  successfully Inserted');
		
			redirect("wip/project/showall");
	 	}
	 		
	}

	function edit(){
		$data=NULL;
		if ( ! check_access('taskproject_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/project/showall');
			return;
		}
		$data['details']=$this->Project_model->get_project_bycode($this->uri->segment(4));
				
		$this->common_model->add_activeflag('wip_project',$this->uri->segment(4),'prj_id');
		$session = array('activtable'=>'wip_project');
		$this->session->set_userdata($session);
		$this->load->view('wip/project/edit',$data);
	}

	function editdata(){
		if ( ! check_access('taskproject_edit'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/project/showall');
			
			return;
		}
		
		$checkproject=$this->Project_model->edit();
				
		if($checkproject!=1){
	 		$this->session->set_flashdata('error', 'Project Name Already exists');
			redirect('wip/project/showall');
			return;
	 	}else{
	 		$this->session->set_flashdata('msg', 'Project Details Successfully Updated ');
		
			$this->common_model->delete_activflag('wip_project',$this->input->post('prj_id'),'prj_id');
			$this->logger->write_message("success", $this->input->post('prj_id').' Project Details successfully Updated');
		
			redirect("wip/project/showall");
	 	}
	}

	public function delete(){
		
		if ( ! check_access('delete_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('wip/project/showall');
			return;
		}
		
		$id=$this->Project_model->delete($this->uri->segment(4));


		if($id!=1){
	 		$this->session->set_flashdata('error', 'Can not delete,beacuse some prograss include');
			redirect('wip/project/showall');
			return;
	 	}else{

	 		$this->common_model->delete_notification('wip_project',$this->uri->segment(4));
			$this->session->set_flashdata('msg', 'Project Successfully Deleted ');
			$this->logger->write_message("success", $this->uri->segment(4).' Project id successfully Deleted');
			redirect("wip/project/showall");
	 	}
		
	}

}
