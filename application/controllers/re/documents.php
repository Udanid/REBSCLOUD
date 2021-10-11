<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documents extends CI_Controller {

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
		$this->load->model("document_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_documents'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home');
			return;
		}
		redirect('re/documents/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_documents'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/customer/');
			return;
		}
		$data['searchdata']=$inventory=$this->customer_model->get_all_customer_summery();
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->cus_code.'">'.$c->first_name .'-'.$c->last_name .'</option>';
           			 $count++;           
       			 }
				 $data['prjlist']=$this->document_model->get_project_list();
				 $data['landlist']=$this->document_model->get_land_list();
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				
				$this->load->view('re/documents/document_data',$data);
		
		
		
	}
	public function land_docs()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			//redirect('re/documents/');
			return;
		}
		$data['details']=$this->document_model->get_land_documents($this->uri->segment(4));
		$this->load->view('re/documents/land_docs',$data);
		
	}		
		
   public function update_landdoc()
   {
	   if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/documents/');
			return;
		}
		$landcode=$this->input->post('land_code');
		$doclist=$this->document_model->get_land_documents($landcode);
		$file_name="";
				$config['upload_path'] = 'uploads/land/documents/';
                $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
                $config['max_size'] = '3500';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
		foreach($doclist as $raw)
		{
			
			$id=$raw->id;
			$plan_copy=$raw->plan_copy;
			$deed_copy=$raw->deed_copy;
			$plan_no=$this->input->post('plan_no'.$id);
			$deed_no=$this->input->post('deed_no'.$id);
			$drawn_by=$this->input->post('drawn_by'.$id);
			$drawn_date=$this->input->post('drawn_date'.$id);
			$attest_by=$this->input->post('attest_by'.$id);
			$attest_date=$this->input->post('attest_date'.$id);
			$this->upload->do_upload('plan_copy'.$id);
            $error = $this->upload->display_errors();
			$image_data = $this->upload->data();
			if($error=="")
            	$plan_copy = $image_data['file_name'];
			$this->upload->do_upload('deed_copy'.$id);
            $error = $this->upload->display_errors();
			$image_data = $this->upload->data();
			if($error=="")
            	$deed_copy = $image_data['file_name'];
			$this->document_model->update_land_documents($id,$plan_no,$deed_no,$drawn_by,$drawn_date,$attest_by,$attest_date,$plan_copy,$deed_copy);
			
		}
		$this->session->set_flashdata('msg', $landcode.' Land Documents Successfully Updated ');
		$this->logger->write_message("success", $landcode .'  Land Documents Successfully Updated');
		redirect("re/documents/showall");
   }
	public function project_docs()
	{
			$data=NULL;
		if ( ! check_access('view_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			//redirect('re/documents/');
			return;
		}
		$prj_id=$this->uri->segment(4);
		$data['typelist']=$doctypes=$this->document_model->get_document_bycategory('Projects');
		$doclist=NULL;
		foreach($doctypes as $raw)
		{
			$prjdoc=$this->document_model->get_project_documents($prj_id,$raw->doctype_id);
			if($prjdoc)
			$doclist[$raw->doctype_id]=$prjdoc->document;
			else
			$doclist[$raw->doctype_id]="";
			
		}
		$data['doclist']=$doclist;
		$this->load->view('re/documents/project_docs',$data);
		
	}
	public function update_projectdocs()
   {
	   if ( ! check_access('edit_customer'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/documents/');
			return;
		}
		$id=$this->input->post('prj_id');
		$file_name="";
				$config['upload_path'] = 'uploads/project/';
                 $config['allowed_types'] = 'gif|jpg|png|pdf|docx';
                $config['max_size'] = '3500';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
		$doctypes=$this->document_model->get_document_bycategory('Projects');	
			
			foreach($doctypes as $docraw)
			{ 
			
				$this->upload->do_upload('document'.$docraw->doctype_id);
            	$error = $this->upload->display_errors();
				//echo $error;
				if($error==""){
					$image_data = $this->upload->data();
					$filename=$image_data['file_name'];
					$this->document_model->delete_project_documents($id,$docraw->doctype_id,$filename);
					$this->document_model->add_project_documents($id,$docraw->doctype_id,$filename);
				}
				else
				$uoloaderro=$uoloaderro.$docraw->document_name.'Not Uploaded<br>';
			}
			$this->session->set_flashdata('error', $uoloaderro);
		$this->session->set_flashdata('msg', $id.' Project Documents Successfully Updated ');
		$this->logger->write_message("success", $id .'  Project Documents Successfully Updated');
		redirect("re/documents/showall");
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