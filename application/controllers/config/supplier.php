<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends CI_Controller {

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
		
		$this->load->model("supplier_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('config/supplier/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/');
			return;
		}
		$data['searchdata']=$inventory=$this->supplier_model->get_all_supplier_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->sup_code.'">'.$c->first_name .'-'.$c->last_name .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='config/supplier/search';
				$data['tag']='Search Supplier';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->supplier_model->get_all_supplier_details($pagination_counter,$page_count);
				$siteurl='config/supplier/showall';
				$tablename='cm_supplierms';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('config/supplier/supplier_data',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/');
			return;
		}
		$data['bankdata']=$this->supplier_model->get_supplier_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$data['details']=$this->supplier_model->get_supplier_bycode($this->uri->segment(4));
		$this->load->view('config/supplier/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/showall');
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
		$id=$this->supplier_model->add($file_name);
		
		$this->common_model->add_notification('cm_supplierms','Suppliers','re/supplier',$id);
		$this->session->set_flashdata('msg', 'Land Supplier Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("config/supplier/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/showall');
			return;
		}
		$data['details']=$this->supplier_model->get_supplier_bycode($this->uri->segment(4));
		$data['bankdata']=$this->supplier_model->get_supplier_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('cm_supplierms',$this->uri->segment(4),'sup_code');
		$session = array('activtable'=>'cm_supplierms');
		$this->session->set_userdata($session);
		$this->load->view('config/supplier/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/showall');
			
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
		$id=$this->supplier_model->edit($file_name);
		
		
		$this->session->set_flashdata('msg', 'Supplier Details Successfully Updated ');
		
		$this->common_model->delete_activflag('cm_supplierms',$this->input->post('sup_code'),'sup_code');
		$this->logger->write_message("success", $this->input->post('sup_code').' Supplier Details successfully Updated');
		redirect("config/supplier/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/showall');
			return;
		}
		$id=$this->supplier_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Supplier Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Supplier id successfully Confirmed');
		redirect("config/supplier/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_supplier'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/supplier/showall');
			return;
		}
		$id=$this->supplier_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_supplierms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Supplier Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Supplier id successfully Deleted');
		redirect("config/supplier/showall");
		
	}

	/*Ticket No:2699 Added By Madushan 2021.04.22*/
	function search_supplier()
	{
		$sup_code = $this->uri->segment(4);
		$data['datalist']=$this->supplier_model->get_search_supplier_details($sup_code);
		$this->load->view('config/supplier/search_supplier',$data);
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */