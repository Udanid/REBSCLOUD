<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends CI_Controller {

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
		
		$this->load->model("document_model");
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
		if ( ! check_access('view_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('config/documents/showall');
		
		
		
	}
	public function showall()
	{
		//$this->output->delete_cache();
		$data=NULL;
		if ( ! check_access('view_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['searchdata']=$inventory=$this->document_model->get_all_document();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->doctype_id.'">'.$c->document_name.'-'.$c->category.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/documents/search';
				$data['tag']='Search Document Types';
		$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('config/documents/showall');
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
		$data['datalist']=$this->document_model->get_all_document($pagination_counter,$page_count);
		$config['total_rows'] = $this->db->count_all('cm_doctypes');
			//echo $pagination_counter;
		$this->pagination->initialize($config);
	$this->load->view('config/documents/document_typedata',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['details']=$this->document_model->get_document_bycode($this->uri->segment(4));
		$this->load->view('config/documents/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/documents/showall');
			return;
		}
		$id=$this->document_model->add();
		
		$this->common_model->add_notification('cm_doctypes','Documents','config/documents',$id);
		$this->session->set_flashdata('msg', 'Document Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('document_name').'  successfully Inserted');
		redirect("config/documents/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/documents/showall');
			return;
		}
		$data['details']=$this->document_model->get_document_bycode($this->uri->segment(4));
		$this->common_model->add_activeflag('cm_doctypes',$this->uri->segment(4),'doctype_id');
		$session = array('activtable'=>'cm_doctypes');
		$this->session->set_userdata($session);
		$this->load->view('config/documents/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/documents/showall');
			
			return;
		}
		$id=$this->document_model->edit();
		
		
		$this->session->set_flashdata('msg', 'Document Successfully Updated ');
		
		$this->common_model->delete_activflag('cm_doctypes',$this->input->post('doctype_id'),'doctype_id');
		$this->logger->write_message("success", $this->input->post('doctype_id').'Document successfully Updated');
		redirect("config/documents/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/documents/showall');
			return;
		}
		$id=$this->document_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_doctypes',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Document Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  successfully Confirmed');
		redirect("config/documents/showall",'refresh');
		
	}
	public function delete()
	{
		if ( ! check_access('delete_documenttyps'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/documents/showall');
			return;
		}
		$id=$this->document_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_doctypes',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Document Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'  successfully Deleted');
		redirect("config/documents/showall",'refresh');
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */