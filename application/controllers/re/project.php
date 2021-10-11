<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller {

	/**
	 * Index Page for this controller.land
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
		
		$this->load->model("land_model");
		$this->load->model("common_model");
		$this->load->model("introducer_model");
		$this->load->model("project_model");
		$this->load->model("document_model");
		$this->load->model("branch_model");
		$this->load->model("producttasks_model");
		$this->load->model("feasibility_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('re/project/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/');
			return;
		}
		$data['searchdata']=$inventory=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$this->encryption->encode($c->prj_id).'">'.$c->project_name.'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/feasibility/showall';
				$data['tag']='Search project';
				$data['product_code']='LNS';
				$data['officerlist']=$this->project_model->get_project_officer_list($this->session->userdata('branchid'));
				 $data['branchlist']=$this->branch_model->get_all_branches_summery();
				$data['land_list']=$this->land_model->get_all_unused_land_summery();
				
				
				$this->load->library('pagination');
			
		$page_count = (int)$this->uri->segment(4);;

		//$page_count = $this->input->xss_clean($page_count);
		if ( !$page_count)
			$page_count = 0;

		/* Pagination configuration */
		
			$config['base_url'] = site_url('re/project/showall');
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
		$data['datalist']=$this->project_model->get_all_project_details($pagination_counter,$page_count,$this->session->userdata('branchid'));
		$config['total_rows'] = $this->db->count_all('re_projectms');
			//echo $pagination_counter;
		$this->pagination->initialize($config);
		$data['tab']='';
			if($page_count)
						$data['tab']='list';
		//$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('re/project/project_data',$data);
		
		
		
	}
	function landinformation()
	{
			$data=NULL;
		if ( ! check_access('add_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/land/showall');
			return;
		}
		$data['details']=$this->land_model->get_land_bycode($this->uri->segment(4));
		$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$data['doctypes']=$this->document_model->get_document_bycategory('Projects');
		$this->common_model->add_activeflag('re_landms',$this->uri->segment(4),'land_code');
		$session = array('activtable'=>'re_landms');
		$this->session->set_userdata($session);
		$this->load->view('re/project/landinformation',$data);
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/');
			return;
		}
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4));
		$data['product_code']='LNS';
				$data['district_list']=$this->common_model->distict_list();
				$data['council_list']=$this->common_model->council_list();
				$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$this->load->view('re/project/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}
			$uoloaderro="";	
$id=$this->project_model->add();
	//$id=2;
		$file_name="";
				$config['upload_path'] = 'uploads/project/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '300';
             
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
					$this->project_model->add_documents($id,$docraw->doctype_id,$filename);
				}
				else
				$uoloaderro=$uoloaderro.$docraw->document_name.'Not Uploaded<br>';
			}
		$tasklist=$this->producttasks_model->get_tasks_product_code('LNS');
			foreach($tasklist as $taskraw)
			{
				$this->feasibility_model->update_prjpayment($id,$taskraw->task_id,0.00);
			}
		
		$this->session->set_flashdata('msg', 'project project Successfully Inserted ');
		$this->session->set_flashdata('error', $uoloaderro);
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		redirect("re/project/showall");
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4));
		$data['product_code']='LNS';
				$data['district_list']=$this->common_model->distict_list();
				$data['council_list']=$this->common_model->council_list();
				$data['introduceerlist']=$this->introducer_model->get_all_intorducer_summery();
		$this->common_model->add_activeflag('re_projectms',$this->uri->segment(4),'prj_id');
		$session = array('activtable'=>'re_projectms');
		$this->session->set_userdata($session);
		$this->load->view('re/project/edit',$data);
		
	}
	function comments()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4));
		$data['comments']=$this->project_model->get_project_comments($this->uri->segment(4));
		
		$this->load->view('re/project/comments',$data);
		
	}
	function commetnadd()
	{
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}
		$id=$this->project_model->commetnadd();
		redirect('re/project/showall');
	}
	function editdata()
	{
		if ( ! check_access('edit_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			
			return;
		}
		$file_name="";
				$file_name="";
				$config['upload_path'] = 'uploads/project/documents/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size'] = '300';
             
                $this->load->library('image_lib');
                $this->load->library('upload', $config);
         		$this->upload->do_upload('plan_copy');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
				$plan_copy="";$deed_copy ="";
            	//$this->session->set_flashdata('error',  $error );
				if($error=="")
            	$plan_copy = $image_data['file_name'];
				else
				$plan_copy=$this->input->post('plan');
				
				$this->upload->do_upload('deed_copy');
            	$error = $this->upload->display_errors();
				
            	$image_data = $this->upload->data();
				if($error=="")
            	$deed_copy = $image_data['file_name'];
				else
				$deed_copy=$this->input->post('deed');
				
			$id=$this->project_model->edit($plan_copy,$deed_copy);
		
		
		$this->session->set_flashdata('msg', 'project Details Successfully Updated ');
		
		$this->common_model->delete_activflag('re_projectms',$this->input->post('prj_id'),'prj_id');
		$this->logger->write_message("success", $this->input->post('prj_id').' project Details successfully Updated');
		redirect("re/project/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}
		$id=$this->project_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_projectms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'project Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  project id successfully Confirmed');
		redirect("re/project/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/showall');
			return;
		}
		$id=$this->project_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_projectms',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'project Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' project id successfully Deleted');
		redirect("re/project/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */