<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Additional_development extends CI_Controller {

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
		
		$this->load->model("reservation_model");
		$this->load->model("common_model");
		$this->load->model("project_model");
		$this->load->model("salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("lotdata_model");
		$this->load->model("dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("eploan_model");
		$this->load->model("ledger_model");
		$this->load->model("additional_development_model");
		
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('add_loanpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home');
			return;
		}
		redirect('re/eploan/showall');
		
		
		
	}


public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_addtional_development'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
	$data['reslist']=$inventory=$this->additional_development_model->get_all_housing_reservation_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				
				$data['searchlist']=NULL;
				$data['searchpath']='';
				$data['tag']='Search customer';
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
				
				$tab='';
				if($this->uri->segment(4))
				{
					$tab='list';
						if($this->uri->segment(4)=='list')
						$tab='list';
						else
						$page_count = (int)$this->uri->segment(4);
				}
				
				$data['tab']=$tab;
					if ( !$page_count)
					$page_count = 0;
						$data['datalist']=$this->additional_development_model->get_additional_develpment_list($this->session->userdata('branchid'));
			
				$siteurl='re/additional_development/showall';
				$tablename='re_hm_addtionaldp';
				$statusfield='status';
				$status='COMPLETE';
				$this->pagination($page_count,$siteurl,$tablename);
				$this->load->view('re/additional_development/development_main',$data);
		
		
		
	}
	
	function add_development()
	{
		if ( ! check_access('add_addtional_development'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/additional_development/showall');
			
			return;
		}
	
		$id=$this->additional_development_model->add_development();
			$this->common_model->add_notification('re_hm_addtionaldp',' Housing Additional Divelopment','re/additional_development/showall/list',$id);
		
		$this->session->set_flashdata('msg', 'Additional Development successfully Inserted ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		//redirect("re/reservation/showall/");
		redirect("re/additional_development/showall/list");
}
function delete_development()
{
	if ( ! check_access('delete_addtional_development'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/additional_development/showall');
			
			return;
		}
	$entry=$this->additional_development_model->delete_development($this->uri->segment(4));
	
	
	if($entry)
	{
		$this->session->set_flashdata('msg', 'Additional Development successfully Deleted');
		$this->common_model->delete_notification('re_hm_addtionaldp',$this->uri->segment(4));


	}
	else
		{
			$this->session->set_flashdata('error', 'Error deleting Di Return ');
		}
		
			redirect("re/additional_development/showall/list");
}

function confirm_development()
{
	if ( ! check_access('delete_addtional_development'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/additional_development/showall');
			
			return;
		}
	$entry=$this->additional_development_model->confirm_development($this->uri->segment(4));
	
	
	if($entry)
	{
		$this->session->set_flashdata('msg', 'Additional Development successfully Confirmed');
		$this->common_model->delete_notification('re_hm_addtionaldp',$this->uri->segment(4));


	}
	else
		{
			$this->session->set_flashdata('error', 'Error deleting Additional Development ');
		}
		
			redirect("re/additional_development/showall/list");

}
function addtional_development_recipet()
{
	$data=NULL;
		if ( ! check_access('add_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/');
			return;
		}
		$data['searchdata']=$inventory=$this->additional_development_model->get_additional_develpment_On_payment($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				 if($inventory){
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$siteurl='re/reservaation/showall';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status='COMPLETE';
				$this->pagination_status($page_count,$siteurl,$tablename,$statusfield,$status);
				$this->load->view('re/additional_development/additional_payment',$data);
	
}
function get_development_Data()
	{			$res_code=$this->uri->segment(4);
				$data['res_code']=$res_code;
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['development_data']=$this->additional_development_model->get_development_data_by_res_code($res_code);
				$data['development_payment']=$this->additional_development_model->get_development_payment_by_res_code($res_code);
				
				$this->load->view('re/additional_development/payment_data',$data);
	}
	function add_payment()
	{
			if ( ! check_access('add_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/');
			
			return;
		}
	
		$id=$this->additional_development_model->add_development_payments();
		
		
		$this->session->set_flashdata('msg', 'Additional Development payment successfully Inserted ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		//redirect("re/reservation/showall/");
		redirect("accounts/income/add/".$id);
	}

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */