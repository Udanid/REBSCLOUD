<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

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
		
		$this->load->model("customer_model");
		$this->load->model("hm_common_model");
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
		redirect('hm/customer/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->customer_model->get_all_customer_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->cus_code.'">'.$c->first_name .' '.$c->last_name .' '.$c->id_number .' - '.$c->mobile.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/edit';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->customer_model->get_all_customer_details($pagination_counter,$page_count);
				$siteurl='hm/customer/showall';
				$tablename='cm_customerms';
				$data['tab']='';
				
					if($page_count)
						$data['tab']='list';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/customer/customer_data',$data);
		
		
		
	}
	public function excel_cusdata()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->customer_model->get_all_customer_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->cus_code.'">'.$c->first_name .' '.$c->last_name .' '.$c->id_number .' - '.$c->mobile.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/customer/edit';
				$data['tag']='Search customer';
				$data['banklist']=$this->hm_common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->customer_model->get_all_customer_details_excel();
				$siteurl='hm/customer/showall';
				$tablename='cm_customerms';
				$data['tab']='';
				
					if($page_count)
						$data['tab']='list';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/customer/customer_excel',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/');
			return;
		}
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->hm_common_model->getbanklist();
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$this->load->view('hm/customer/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
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
		$id=$this->customer_model->add($file_name);
		
		$this->hm_common_model->add_notification('cm_customerms','customers','hm/customer',$id);
		$this->session->set_flashdata('msg', 'Land customer Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("hm/customer/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
			return;
		}
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->hm_common_model->getbanklist();
		$this->hm_common_model->add_activeflag('cm_customerms',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'cm_customerms');
		$this->session->set_userdata($session);
		$this->load->view('hm/customer/edit',$data);
		
	}
	
	function editdata()
	{
		if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
			
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
		$id=$this->customer_model->edit($file_name);
		
		
		$this->session->set_flashdata('msg', 'customer Details Successfully Updated ');
		
		$this->hm_common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('cus_code').' customer Details successfully Updated');
		redirect("hm/customer/showall");
		
	}
	public function edit_loan()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
			return;
		}
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->hm_common_model->getbanklist();
		$this->hm_common_model->add_activeflag('cm_customerms',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'cm_customerms');
		$this->session->set_userdata($session);
		$this->load->view('hm/reservation/loan_customer',$data);
		
	}
	function editdata_loan()
	{
		if ( ! check_access('edit_customer_loan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
			
			return;
		}
		$file_name="";
				
		$id=$this->customer_model->edit_loan($file_name);
		
		
		$this->session->set_flashdata('msg', 'customer Details Successfully Updated ');
		
		$this->hm_common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('cus_code').' customer Details successfully Updated');
		redirect("hm/reservation/eploans");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
			return;
		}
		$id=$this->customer_model->confirm($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'customer Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  customer id successfully Confirmed');
		redirect("hm/customer/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/customer/showall');
			return;
		}
		$id=$this->customer_model->delete($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'customer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' customer id successfully Deleted');
		redirect("hm/customer/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */