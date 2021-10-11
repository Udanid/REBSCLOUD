<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Introducer extends CI_Controller {

	/**
	 * Index Page for this controller.intorducer
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
		
		$this->load->model("introducer_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('re/introducer/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/');
			return;
		}
		$data['searchdata']=$inventory=$this->introducer_model->get_all_intorducer_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->intro_code.'">'.$c->first_name .'-'.$c->last_name .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/introducer/search';
				$data['tag']='Search Introducer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->introducer_model->get_all_intorducer_details($pagination_counter,$page_count);
				$siteurl='re/introducer/showall';
				$tablename='re_introducerms';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('re/introducer/introducer_data',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/');
			return;
		}
		$data['bankdata']=$this->introducer_model->get_introducer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$data['details']=$this->introducer_model->get_intorducer_bycode($this->uri->segment(4));
		$this->load->view('re/introducer/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}		$file_name="";
				$config['upload_path'] = 'uploads/intorducer/nic/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '300';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('idcopy');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
            	$file_name = $image_data['file_name'];
				else
				{
				
				$this->session->set_flashdata('error',  $error );
				}
		$id=$this->introducer_model->add($file_name);
		
		$this->common_model->add_notification('re_introducerms','Introducers','re/introducer',$id);
		$this->session->set_flashdata('msg', 'Land Introducer Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/introducer/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}
		$data['details']=$this->introducer_model->get_intorducer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->introducer_model->get_introducer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('re_introducerms',$this->uri->segment(4),'intro_code');
		$session = array('activtable'=>'re_introducerms');
		$this->session->set_userdata($session);
		$this->load->view('re/introducer/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			
			return;
		}
		$file_name="";
				$config['upload_path'] = 'uploads/intorducer/nic/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '300';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('idcopy');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
            	$file_name = $image_data['file_name'];
				else
				{
				$file_name=$this->input->post('id_copy');
				//$this->session->set_flashdata('error',  $error );
				}
		$id=$this->introducer_model->edit($file_name);
		
		
		$this->session->set_flashdata('msg', 'Introducer Details Successfully Updated ');
		
		$this->common_model->delete_activflag('re_introducerms',$this->input->post('intro_code'),'intro_code');
		$this->logger->write_message("success", $this->input->post('intro_code').' Introducer Details successfully Updated');
		redirect("re/introducer/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}
		$id=$this->introducer_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_introducerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Introducer Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Introducer id successfully Confirmed');
		redirect("re/introducer/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_introducer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}
		$id=$this->introducer_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_introducerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Introducer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Introducer id successfully Deleted');
		redirect("re/introducer/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */