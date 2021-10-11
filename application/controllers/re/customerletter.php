<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customerletter extends CI_Controller {

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
		$this->load->model("common_model");
		$this->load->model("message_model");
		$this->load->model("eploan_model");
		$this->load->model("project_model");
		$this->load->model("reservation_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('re/customerletter/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->message_model->get_letter_types();
		$data['cusdata']=$inventory=$this->customer_model->get_all_customer_summery();
		$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['datalist1']=$this->message_model->get_letters_all($this->session->userdata('branchid'));
		
				$courseSelectList="";
					$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customerletter/search';
				$data['tag']='Search Customer letter';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$inventory;
				$siteurl='re/customer/showall';
				$tablename='cm_customerms';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('re/customerletter/leter_data',$data);
		
		
		
	}
	public function letter_list()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customerletter/');
			return;
		}
		$data['type_id']=$this->uri->segment(4);
		$data['type_name']=get_letter_type($this->uri->segment(4));
	//	if($this->uri->segment(4)=='04')
		//$thislist=$this->message_model->generate_first_remind();
	//	if($this->uri->segment(4)=='05')
	//	$thislist=$this->message_model->generate_second_remind();
	//	if($this->uri->segment(4)=='06')
	//	$thislist=$this->message_model->generate_third_remind();
	//	if($this->uri->segment(4)=='07')
		//$thislist=$this->message_model->generate_termination_letter();
	//	if($this->uri->segment(4)=='08')
	//	$thislist=$this->message_model->generate_resale_letter();
		$data['datalist']=$this->message_model->get_letters_by_type($this->uri->segment(4),$this->session->userdata('branchid'));
		$this->load->view('re/customerletter/letter_list',$data);
		
	}
	public function printed_letter_list()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customerletter/');
			return;
		}
		$data['type_id']=$this->uri->segment(4);
		$data['type_name']=get_letter_type($this->uri->segment(4));
		$data['datalist']=$this->message_model->get_letters_printed_lettets($this->uri->segment(4),$this->uri->segment(5));
		$this->load->view('re/customerletter/printed_letter_list',$data);
		
	}
	public function letter_print()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customerletter/');
			return;
		}
		$data['type_id']=$this->uri->segment(5);
		$data['type_name']=get_letter_type($this->uri->segment(5));
		$data['letter_data']=$letter_data=$this->message_model->get_letter_byid($this->uri->segment(4));
		$data['customer_data']=$this->message_model->get_customer_bycode($letter_data->cus_code);
		$data['res_data']=$this->reservation_model->get_all_reservation_details_bycode($letter_data->res_code);
		if($letter_data->loan_code)
		{
		 $data['details']=$loan_data=$this->eploan_model->get_eploan_data($letter_data->loan_code);
		  $data['rshceduls']=false;
		  $data['rebate']=false;
			  $data['currentins']=$this->eploan_model->get_current_instalment($letter_data->loan_code);
		 	}
		
		$this->load->view('re/customerletter/customerletter_'.$this->uri->segment(5),$data);
		
	}
	public function update_printstatus($id)
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customerletter/');
			return;
		}
		$data['datalist']=$this->message_model->update_print_status($this->uri->segment(4));
		redirect('re/customerletter/');
		
	}
	
	public function add()
	{
		if ( ! check_access('add_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
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
		
		$this->common_model->add_notification('cm_customerms','customers','re/customer',$id);
		$this->session->set_flashdata('msg', 'Land customer Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/customer/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			return;
		}
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('cm_customerms',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'cm_customerms');
		$this->session->set_userdata($session);
		$this->load->view('re/customer/edit',$data);
		
	}
	
	function editdata()
	{
		if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			
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
		
		$this->common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('cus_code').' customer Details successfully Updated');
		redirect("re/customer/showall");
		
	}
	public function edit_loan()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			return;
		}
		$data['details']=$this->customer_model->get_customer_bycode($this->uri->segment(4));
		$data['bankdata']=$this->customer_model->get_customer_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->common_model->getbanklist();
		$this->common_model->add_activeflag('cm_customerms',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'cm_customerms');
		$this->session->set_userdata($session);
		$this->load->view('re/reservation/loan_customer',$data);
		
	}
	function editdata_loan()
	{
		if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			
			return;
		}
		$file_name="";
				
		$id=$this->customer_model->edit_loan($file_name);
		
		
		$this->session->set_flashdata('msg', 'customer Details Successfully Updated ');
		
		$this->common_model->delete_activflag('cm_customerms',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('cus_code').' customer Details successfully Updated');
		redirect("re/reservation/eploans");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			return;
		}
		$id=$this->customer_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'customer Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  customer id successfully Confirmed');
		redirect("re/customer/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/showall');
			return;
		}
		$id=$this->customer_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('cm_customerms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'customer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' customer id successfully Deleted');
		redirect("re/customer/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */