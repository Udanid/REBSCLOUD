<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesmen extends CI_Controller {

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
		
		$this->load->model("hm_salesmen_model");
		$this->load->model("hm_common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home');
			return;
		}
		redirect('hm/salesmen/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/');
			return;
		}
		$data['searchdata']=$inventory=$this->hm_salesmen_model->get_all_salesmen_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->id.'">'.$c->initial .'-'.$c->surname .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='hm/salesmen/search';
				$data['tag']='Search salesmen';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->hm_salesmen_model->get_all_salesmen_details($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$data['prjlist']=$this->hm_salesmen_model->get_manager_projectlist();
				$data['saleslist']=$this->hm_salesmen_model->get_all_salesmen_list($this->session->userdata('branchid'));
				$siteurl='hm/salesmen/showall';
				$tablename='hm_salesman';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/salesmen/salesmen_data',$data);
		
		
		
	}
	
	function check_thisid(){
		//$this->load->model("config_model");
		$prj_id=$this->input->get('prj_id');
		$officerid=$this->input->get('officerid');
	//	$fieldname=$this->input->get('fieldname');
		if($this->hm_salesmen_model->check_already_excist($prj_id,$officerid))
		{
			
			echo "This Sales Officer already assign to to this Project";
			
		
		}
		//echo "This record already open ";
	//	$data['divisionlist']=$this->config_model->get_division_byzone($zondata->ZONENAME);
		//$this->load->view('manage/common/divisions', $data);
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/');
			return;
		}
		$data['details']=$this->hm_salesmen_model->get_salesmen_bycode($this->uri->segment(4));
		$this->load->view('hm/salesmen/search',$data);
		
	}
	
	
	public function add()
	{
		if ( ! check_access('add_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}		
		$this->hm_salesmen_model->add($this->uri->segment(4),$this->uri->segment(5));
		$this->logger->write_message("success", 'Sales Officer  successfully Inserted');
				$pagination_counter =RAW_COUNT;
					$page_count = 0;
				$data['datalist']=$this->hm_salesmen_model->get_all_salesmen_details($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='hm/salesmen/showall';
				$tablename='hm_salesman';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/salesmen/data_table',$data);
	
		
		
		
	}
	public function edit()
	{
			$data=NULL;
		if ( ! check_access('view_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}
		$data['details']=$this->hm_salesmen_model->get_salesmen_bycode($this->uri->segment(4));
		$data['bankdata']=$this->hm_salesmen_model->get_salesmen_bankdata_bycode($this->uri->segment(4));
		$data['banklist']=$this->hm_common_model->getbanklist();
		$this->hm_common_model->add_activeflag('hm_salesman',$this->uri->segment(4),'cus_code');
		$session = array('activtable'=>'hm_salesman');
		$this->session->set_userdata($session);
		$this->load->view('hm/salesmen/edit',$data);
		
	}
	function editdata()
	{
		if ( ! check_access('edit_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			
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
		$id=$this->hm_salesmen_model->edit($file_name);
		
		
		$this->session->set_flashdata('msg', 'salesmen Details Successfully Updated ');
		
		$this->hm_common_model->delete_activflag('hm_salesman',$this->input->post('cus_code'),'cus_code');
		$this->logger->write_message("success", $this->input->post('cus_code').' salesmen Details successfully Updated');
		redirect("hm/salesmen/showall");
		
	}
	
	public function confirm()
	{
		if ( ! check_access('confirm_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}
		$id=$this->hm_salesmen_model->confirm($this->uri->segment(4));
		
		$this->hm_common_model->delete_notification('hm_salesman',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'salesmen Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  salesmen id successfully Confirmed');
		redirect("hm/salesmen/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_salesmen'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/salesmen/showall');
			return;
		}
		$id=$this->hm_salesmen_model->delete($this->uri->segment(4));
		if($id)
		{
		$this->session->set_flashdata('msg', 'salesmen Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' salesmen id successfully Deleted');
		}
		else
			$this->session->set_flashdata('error', 'This Sales person already sold some blocks');
		redirect("hm/salesmen/showall");
		
	}
		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */