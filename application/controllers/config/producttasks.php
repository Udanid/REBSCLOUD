<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producttasks extends CI_Controller {

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
		
		$this->load->model("producttasks_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	function is_logged_in() {
		if($this->session->userdata('activtable')!=NULL)
		{
			$this->common_model->delete_curent_tabactivflag($this->session->userdata('activtable'));
		}
        $is_logged_in = $this->session->userdata('username');
		$is_usertype = $this->session->userdata('usertype');
        if ((!isset($is_logged_in) || $is_logged_in == "")) {
            $this->session->set_flashdata('return_url', current_url());
			$this->common_model->release_user_activeflag($this->session->userdata('userid'));
            redirect('login/index');
        }
		else if($is_usertype=="user")
		{
			$this->session->set_flashdata('return_url', current_url());
			  redirect('login/index');
		}
		else
		{
			$this->session->set_flashdata('return_url', current_url());
		}
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
		redirect('config/producttasks/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->producttasks_model->get_all_tasks();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->task_id.'">'.$c->product_code.'-'.$c->task_code.'-'.$c->task_name.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/producttasks/search';
				$data['tag']='Search Product Tasks ';
				$data['activeprd']=$this->producttasks_model->get_active_products();
				$data['activcount']=$this->producttasks_model->get_active_count();
				$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('config/producttasks/showall');
			$config['uri_segment'] = 4;
		
		$pagination_counter =RAW_COUNT;//$this->config->item('row_count');
		$config['num_links'] = 10;
		$config['per_page'] = $pagination_counter;
		$config['full_tag_open'] = '<ul id="pagination-flickr">';
		$config['full_close_open'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_link'] = 'Next &#187;';
		$config['next_tag_open'] = '<li class="next">';
		$config['next_tag_close'] = '</li>';
		$config['prev_link'] = '&#171; Previous';
		$config['prev_tag_open'] = '<li class="previous">';
		$config['prev_tag_close'] = '</li>';
		$config['first_link'] = 'First';
		$config['first_tag_open'] = '<li class="first">';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = 'Last';
		$config['last_tag_open'] = '<li class="last">';
		$config['last_tag_close'] = '</li>';
		$startcounter=($page_count)*$pagination_counter;
		$data['datalist']=$this->producttasks_model->get_all_tasks($pagination_counter,$page_count);
		$data['fulllist']=$this->producttasks_model->get_tasks_product_code('LNS');
		$config['total_rows'] = $this->db->count_all('cm_tasktype');
			//echo $pagination_counter;
		$this->pagination->initialize($config);
	$this->load->view('config/producttasks/producttasks_data',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['details']=$this->producttasks_model->get_tasks_bycode($this->uri->segment(4));
		$data['datalist']=$this->producttasks_model->get_subtask_bytask($this->uri->segment(4));
		$this->load->view('config/producttasks/subtask_list',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$id=$this->producttasks_model->add();
		
		
		$this->session->set_flashdata('msg', 'Task Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("config/producttasks/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$data['details']=$this->producttasks_model->get_tasks_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('cm_tasktype',$this->uri->segment(4),'task_id');
		$session = array('activtable'=>'cm_tasktype');
		$this->session->set_userdata($session);
		$this->load->view('config/producttasks/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			
			return;
		}
		$id=$this->producttasks_model->edit();
		
		
		$this->session->set_flashdata('msg', 'Document Successfully Updated ');
		
		$this->common_model->delete_activflag('cm_tasktype',$this->input->post('task_id'),'task_id');
		$this->logger->write_message("success", $this->input->post('task_id').' Task successfully Updated');
		redirect("config/producttasks/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$id=$this->producttasks_model->confirm($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Task Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Task id successfully Confirmed');
		redirect("config/producttasks/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$id=$this->producttasks_model->delete($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Task Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("config/producttasks/showall");
		
	}
		public function add_subtask()
	{
		if ( ! check_access('add_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$id=$this->producttasks_model->add_subtask();
		
		
		$this->session->set_flashdata('msg', 'Subtask Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('subtask_name').'  successfully Inserted');
		redirect("config/producttasks/showall");
		
	}
	public function subtask_list()
	{
			$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			//redirect('user');
			return;
		}
		$data['activeprd']=$this->producttasks_model->get_active_products();
				$data['activcount']=$this->producttasks_model->get_active_count();
		$data['details']=$this->producttasks_model->get_tasks_bycode($this->uri->segment(4));
		$data['datalist']=$this->producttasks_model->get_subtask_bytask($this->uri->segment(4));
		$this->load->view('config/producttasks/subtask_list',$data);
		
	}
	public function subtask_editlist()
	{
			$data=NULL;
		if ( ! check_access('view_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			//redirect('user');
			return;
		}
		$data['details']=$this->producttasks_model->get_tasks_bycode($this->uri->segment(4));
		$data['datalist']=$this->producttasks_model->get_subtask_bytask($this->uri->segment(4));
		$this->load->view('config/producttasks/subtask_editlist',$data);
		
	}
	public function confirm_subtask()
	{
		if ( ! check_access('confirm_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$id=$this->producttasks_model->confirm_subtask($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Sub Task Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Task id successfully Confirmed');
		redirect("config/producttasks/showall");
		
	}
		public function delete_subtask()
	{
		if ( ! check_access('delete_producttask'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/producttasks/showall');
			return;
		}
		$id=$this->producttasks_model->delete_subtask($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Sub Task Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("config/producttasks/showall");
		
	}
	function update_order_key_main()
	{
		$main_id=$this->input->get('main_id');
		$key=$this->input->get('key');
		
		
		$this->producttasks_model->update_task_code($main_id,$key);
		echo 'uodated';
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */