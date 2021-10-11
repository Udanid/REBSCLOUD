<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dplevels extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 function __construct() {
        parent::__construct();
		
		$this->load->model("dplevels_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('config/dplevels/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->dplevels_model->get_dplevels();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->dp_id.'">'.$c->dp_rate .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/dplevels/search';
				$data['tag']='Search Product Tasks ';
				
			
		$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('config/dplevels/dplevels_data',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['details']=$this->dplevels_model->get_dplevels_bycode($this->uri->segment(4));
		$this->load->view('config/dplevels/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/dplevels/showall');
			return;
		}
		$id=$this->dplevels_model->add();
		
		
		$this->session->set_flashdata('msg', 'Task Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("config/dplevels/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/dplevels/showall');
			return;
		}
		$data['details']=$this->dplevels_model->get_dplevels_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('cm_dplevels',$this->uri->segment(4),'dp_id');
		$session = array('activtable'=>'cm_dplevels');
		$this->session->set_userdata($session);
		$this->load->view('config/dplevels/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/dplevels/showall');
			
			return;
		}
		$id=$this->dplevels_model->edit();
		
		
		$this->session->set_flashdata('msg', 'Downpayment Ratio Successfully Updated ');
		
		$this->common_model->delete_activflag('cm_dplevels',$this->input->post('task_id'),'dp_id');
		$this->logger->write_message("success", $this->input->post('task_id').' Task successfully Updated');
		redirect("config/dplevels/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/dplevels/showall');
			return;
		}
		$id=$this->dplevels_model->confirm($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Task Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Task id successfully Confirmed');
		redirect("config/dplevels/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_dplevels'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/dplevels/showall');
			return;
		}
		$id=$this->dplevels_model->delete($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("config/dplevels/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */