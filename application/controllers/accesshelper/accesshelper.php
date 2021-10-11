<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accesshelper extends CI_Controller {

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
		
		$this->load->model("accesshelper_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_accesshelper'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('config/accesshelper/showall');
		
		
		
	}
	public function menumain()
	{
		$data=NULL;
		if ( ! check_access('view_accesshelper'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$data['datalist']=$inventory=$this->accesshelper_model->get_all_mainmenus();
				$courseSelectList="";
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accesshelper/accesshelper/menumain';
				$data['tag']='Search Product Tasks ';
				$data['activeprd']=$this->accesshelper_model->get_active_Modules();
				$data['activcount']=$this->accesshelper_model->get_all_mainmenus();
				$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('config/producttasks/showall');
			$config['uri_segment'] = 4;
		
	
	$this->load->view('accesshelper/controller_data',$data);
		
		
		
	}
	function add_mainmenu()
	{
		$menu_name=$this->input->get('menu_name');
		$module_code=$this->input->get('module_code');
		$menu_url=$this->input->get('menu_url');
		$color=$this->input->get('color');
		$icon=$this->input->get('icon');
		
		$this->accesshelper_model->add_mainmenu($menu_name,$module_code,$menu_url,$color,$icon);
		echo $status;
	}
	function update_order_key_main()
	{
		$main_id=$this->input->get('main_id');
		$key=$this->input->get('key');
		
		
		$this->accesshelper_model->update_order_key_main($main_id,$key);
		echo $this->db->last_query();
		//echo $key;
	}
	function update_order_key_sub()
	{
		$main_id=$this->input->get('main_id');
		$key=$this->input->get('key');
		
		
		$this->accesshelper_model->update_order_key_sub($main_id,$key);
		echo $this->db->last_query();
		//echo $key;
	}
	
	function mainmenulist()
	{
		$data['datalist']=$inventory=$this->accesshelper_model->get_all_mainmenus();
		$this->load->view('accesshelper/mainmenulist',$data);
	}
	public function delete_main_menu()
	{
		
		$id=$this->accesshelper_model->delete_main_menu($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Main Menu Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("accesshelper/accesshelper/menumain");
	}
	function delete_submenu()
	{
		$id=$this->accesshelper_model->delete_submenu($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', 'Sub Menu Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("accesshelper/accesshelper/menumain");
	}
	function add_submenu()
	{
		$sub_url=$this->input->get('sub_url');
		$sub_name=$this->input->get('sub_name');
		$main_id=$this->input->get('main_id');
		$this->accesshelper_model->add_submenu($sub_name,$main_id,$sub_url);
		echo $main_id;
	}
	public function sublist()
	{
		$data['datalist']=$inventory=$this->accesshelper_model->get_submenu($this->uri->segment(4));
		$this->load->view('accesshelper/sublist',$data);
		
	}
	public function loadsubtasklist_select()
	{
		$data['sublist']=$inventory=$this->accesshelper_model->get_submenu($this->uri->segment(4));
		$this->load->view('accesshelper/loadsubtasklist_select',$data);
		
	}
	function add_controller()
	{
		$cont_name=$this->input->get('cont_name');
		$main_id=$this->input->get('main_id');
		$sub_id=$this->input->get('sub_id');
		$this->accesshelper_model->add_controller($cont_name,$main_id,$sub_id);
		echo $status;
	}
	function load_controller()
	{
		$data['datalist']=$inventory=$this->accesshelper_model->load_controller($this->uri->segment(4));
		$this->load->view('accesshelper/controllerlistt',$data);
	}
	public function delete_controller()
	{
		
		$id=$this->accesshelper_model->delete_controller($this->uri->segment(4));
		
		
		$this->session->set_flashdata('msg', ' Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Task id successfully Deleted');
		redirect("accesshelper/accesshelper/menumain");
	}
	
	public function usercontroller()
	{
		$data=NULL;
		if ( ! check_access('view_accesshelper'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$data['datalist']=$inventory=$this->accesshelper_model->get_all_mainmenus();
		$data['usertypes']=$inventory=$this->accesshelper_model->get_active_usertypes();
		
				$courseSelectList="";
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accesshelper/accesshelper/menumain';
				$data['tag']='Search Product Tasks ';
				$data['activeprd']=$this->accesshelper_model->get_active_Modules();
				$data['activcount']=$this->accesshelper_model->get_all_mainmenus();
				$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('config/producttasks/showall');
			$config['uri_segment'] = 4;
		
	
	$this->load->view('accesshelper/user_data',$data);
		
		
		
	}
	function get_user_prvdata()
	{
		//echo 'ssss'. $this->uri->segment(4);
		
		$data['mainmenu']=$mainmenu=$this->accesshelper_model->get_module_main_menu($this->uri->segment(5));
		$data['user_type']=$user_type=$this->uri->segment(4);
		$user_type=str_replace('-',' ',$user_type);
		$data['user_type']=$user_type;
		$subactive=NULL;
		$subcontroller=NULL;
		
		if($mainmenu)
		{
			foreach($mainmenu as $raw)
			{
				$sublist[$raw->main_id]=false;
				$sublist[$raw->main_id]=$this->accesshelper_model->get_main_sub_menu($raw->main_id);
				
				$maincontroller[$raw->main_id]=$this->accesshelper_model->get_mainmenu_controllers($raw->main_id);
				$mainactive[$raw->main_id]=$this->accesshelper_model->get_main_active($raw->main_id,$user_type);
				if($sublist[$raw->main_id])
				{
					foreach($sublist[$raw->main_id] as $subraw)
					{
						$subcontroller[$subraw->sub_id]=$this->accesshelper_model->get_submenu_controllers($subraw->sub_id);
						$subactive[$subraw->sub_id]=$this->accesshelper_model->get_sub_active($subraw->sub_id,$user_type);
					}
				}
			}
			//print_r($sublist);
			$data['sublist']=$sublist;
			$data['maincontroller']=$maincontroller;
			$data['mainactive']=$mainactive;
			$data['subcontroller']=$subcontroller;
			$data['subactive']=$subactive;
		}
		
		$this->load->view('accesshelper/user_fulldata',$data);
	}
	function add_user_controller()
	{
		$menu_id=$this->input->get('menu_id');
		$userid=$this->input->get('userid');
		$type=$this->input->get('type');
		if($type=='mainmenu')
		{
			
		$this->accesshelper_model->add_user_controller_mainmenu($menu_id,$userid);
		
		}
		if($type=='submenu')
		{
		$this->accesshelper_model->add_user_controller_submenu($menu_id,$userid);
		}
		if($type=='controller')
		{
		$this->accesshelper_model->add_user_controller_cntrl($menu_id,$userid);
		}echo $userid;
		
	}
	function delete_user_controller()
	{
		$menu_id=$this->input->get('menu_id');
		$userid=$this->input->get('userid');
		$type=$this->input->get('type');
		if($type=='mainmenu')
		{
		$this->accesshelper_model->delete_user_controller_mainmenu($menu_id,$userid);
		}
		if($type=='submenu')
		{
		$this->accesshelper_model->delete_controller_submenu($menu_id,$userid);
		}
		if($type=='controller')
		{
		$this->accesshelper_model->delete_user_controller_cntrl($menu_id,$userid);
		}
		echo $userid;
	}
	
	function userlevels(){
		if(!$_POST){
			$data['userlevels'] = $this->accesshelper_model->getuserlevels();
			$this->load->view('accesshelper/user_levels',$data);
		}else{
			$user_level = $this->input->post('user_level');
			$module = $this->input->post('module');
			//check if exists
			if($this->accesshelper_model->check_user_level($user_level)){
				$this->session->set_flashdata('error', 'User Level Exists');
				redirect('accesshelper/accesshelper/userlevels');
			}else{
				if($this->accesshelper_model->create_user_level($user_level,$module)){
					$this->session->set_flashdata('msg', ' Successfully Created');
				}else{
					$this->session->set_flashdata('error', 'Unable to Create User Level');
				}
			}
			redirect('accesshelper/accesshelper/userlevels');
		}
	}
	
	function delete_user_level($id){
		if($this->accesshelper_model->delete_user_level($id)){
			$this->session->set_flashdata('msg', ' Successfully Deleted ');
		}else{
			$this->session->set_flashdata('error', 'Unable to Delete');	
		}
		redirect('accesshelper/accesshelper/userlevels');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */