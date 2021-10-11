<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends CI_Controller {

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
		$this->load->model("summery_model");
		$this->load->model("branch_model");
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
		if ( ! check_access('view_branch'))
		{
			
			redirect('user');
			return;
		}
		redirect('user');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_branch'))
		{
			
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->branch_code.'">'.$c->shortcode.'-'.$c->branch_name.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/branch/search';
				$data['tag']='Search Branch';
				$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('config/branch/showall');
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
		$data['datalist']=$this->branch_model->get_all_branches_details($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('cm_branchms');
			//echo $pagination_counter;
		$this->pagination->initialize($config);
	$this->load->view('config/branch/branch_data',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_branch'))
		{
			
			redirect('user');
			return;
		}
		$data['details']=$this->branch_model->get_branchdata_bycode($this->uri->segment(4));
		$this->load->view('config/branch/search',$data);
		
	}
	
	function check_shortcode() {
    	$this->load->model('branch_model');

    	$data = $this->branch_model->check_shortcode($this->input->get('vendor_no'));
		if($data)
		{
			echo "This short code already taken";
		}

   	
	}
	public function add()
	{
		if ( ! check_access('add_branch'))
		{
			
			redirect('config/branch/showall');
			return;
		}
		$id=$this->branch_model->add();
		
		
		$this->session->set_flashdata('msg', 'Branch Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('branch_name').'Branch successfully Inserted');
		redirect("config/branch/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_branch'))
		{
			
			redirect('user');
			return;
		}
		$data['details']=$this->branch_model->get_branchdata_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('cm_branchms',$this->uri->segment(4),'branch_code');
		$session = array('activtable'=>'cm_branchms');
		$this->session->set_userdata($session);
		
		$this->load->view('config/branch/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_branch'))
		{
			
			redirect('config/branch/showall');
			return;
		}
		$id=$this->branch_model->edit();
		
		
		$this->session->set_flashdata('msg', 'Branch Successfully Updated ');
		$this->common_model->delete_activflag('cm_branchms',$this->input->post('branch_code'),'branch_code');
		$this->logger->write_message("success", $this->input->post('branch_code').'Branch successfully Updated');
		redirect("config/branch/showall");
		
	}
	
	function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
	
	function customerByID($id){
		$customer = $this->customer_model->customerByID($id);
	
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */