<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Projectpayments extends CI_Controller {

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
		
		
		$this->load->model("common_model");
		
		$this->load->model("project_model");
	    $this->load->model("projectpayment_model");
		$this->load->model('paymentvoucher_model');
		$this->load->model('supplier_model');
		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("lotdata_model");
		
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_projectpayment'))
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
		if ( ! check_access('view_projectpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/');
			return;
		}
				$data['searchpath']='re/lotdata/search';
				$data['tag']='Search project';
				$page_count = (int)$this->uri->segment(4);
				if ( !$page_count)
				$page_count = 0;
				$pagination_counter =RAW_COUNT;
				$siteurl = 're/projectpayments/showall';
				$this->pagination($page_count,$siteurl,'re_prjacpaymentdata');
				//echo $this->projectpayment_model->check_paymentledger_set();
				if($this->projectpayment_model->check_paymentledger_set())
				{
					$this->session->set_flashdata('error', 'Payment Accounts not defined');
					$data['prjlist']=false;
				}
				else
				{
					$data['prjlist']=$this->projectpayment_model->get_all_payto_projectlist($this->session->userdata('branchid'));
				}
				$data['datalist']=$this->projectpayment_model->get_get_paymentlist($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$data['suplist']=$this->supplier_model->get_all_supplier_summery();
				$data['advlist']=$this->cashadvance_model->get_Paid_advancedata();
				$data['invoice']=$this->invoice_model->get_not_paid_invoices_project();
				$this->load->view('re/projectpayment/payment_list',$data);
	}
	
	function payment_search(){
		$data['searchpath']='re/lotdata/search';
		$data['tag']='Search project';
		/* Pagination setup */
		$this->load->library('pagination');
		
		$string = $this->input->post('searchstring');
		if($string!=''){
			$this->session->set_userdata('searchstring',$string);
		}
		/*Pagination config*/
		$config['base_url'] = site_url('re/projectpayments/payment_search');
		$config['uri_segment'] = 4;
		$config['total_rows'] = $this->projectpayment_model->count_search_paymentlist_all($this->session->userdata('branchid'),$this->session->userdata('searchstring'));
		
		$pagination_counter = $this->config->item('row_count');
		$config['num_links'] = 10;
		$config['per_page'] = 20;
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
		/*end pagination config*/
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data_list = $this->projectpayment_model->get_search_paymentlist($config['per_page'],$page,$this->session->userdata('branchid'),$this->session->userdata('searchstring'));
		if($data_list){
			$this->pagination->initialize($config);
			$data["links"] = $this->pagination->create_links();
			$data['datalist']=$data_list;
			$this->load->view('re/projectpayment/search_payment_list',$data);
		}else{
			$this->session->set_flashdata('error', 'No matching records found.');
			redirect('re/projectpayments/showall');
		}
	}
	function get_tasklist()
	{
		$data=NULL;
		
		$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$this->load->view('re/projectpayment/tasklist', $data);
	}
	function loadd_daterange()
	{
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4));
		$this->load->view('re/projectpayment/date_range', $data);
	}
	function search()
	{
		if ( ! check_access('view_project'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/feasibility/showall/'.$encode_id);
			return;
		}	
		$data['planlist']=$planlist=$this->lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->lotdata_model->get_project_lots($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('re/lotdata/search',$data);	
	}
	
	function add()
	{
		if ( ! check_access('add_projectpayment'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/lotdata/showall/');
			return;
		}	
		$taskdata=explode(',',$this->input->post('task_id'));
		$subtaskdata=explode(',',$this->input->post('subtask_id'));
		$payeenamelist=explode(',',$this->input->post('payee_name'));
		$date=$this->input->post('drown_date');
		$amount=$this->input->post('amount');
		$payeename=$payeenamelist[1];
		$payeecode=$payeenamelist[0];
		$prj_id=$this->input->post('prj_id');
	 
		$data=$this->projectpayment_model->add_project_payment($taskdata[0],$subtaskdata[0],$date,$amount,$payeename,$payeecode,$prj_id);
		if($data)
		{
			$this->common_model->add_notification('re_prjacpaymentdata','Project Payments','re/projectpayments',$data);
			$this->session->set_flashdata('msg', 'Project Payment  Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
			redirect("re/projectpayments/showall");
		}
		else
		{
		//$this->common_model->add_notification('re_prjacpaymentdata','Project Payments','re/projectpayments',$data);
			$this->session->set_flashdata('error', 'Error Inserting Project Payment');
		//	$this->logger->write_message("error", $this->input->post('task_name').'  successfully Inserted');
			redirect("re/projectpayments/showall");
		}
		
	 	//echo $voucherid;
	}
	public function confirm()
	{
		if ( ! check_access('confirm_projectpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}
		$id=$this->projectpayment_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_prjacpaymentdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Project Payment successfully Confirmed');
		redirect("re/projectpayments/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_projectpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}
		$id=$this->projectpayment_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('re_prjacpaymentdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Project Payment successfully Deleted');
		redirect("re/projectpayments/showall");
		
	}
	function  get_budget()
	{
		$data['details']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$data['prjdata']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$this->load->view('re/projectpayment/budget_data', $data);
	}
	function add_newbudget()
	{
		$counter=$this->input->post('counter');
		$prj_id=$this->input->post('prj_id_bdget');
		for($i=1; $i<$counter; $i++)
		{
			$transfers=floatval($this->input->post('new_budget'.$i))-floatval($this->input->post('estimate'.$i));
			$new_budget=$transfers+floatval($this->input->post('newbdg'.$i));
			$new_estimate=$this->input->post('newbdg'.$i);
			$task_id=$this->input->post('task_id'.$i);
			$this->projectpayment_model->update_budget($prj_id,$task_id,$new_estimate,$new_budget);
			
		}
		$this->session->set_flashdata('msg', 'Project Budget successfully updated');
		$this->logger->write_message("success",$prj_id.' Project Budget successfully updated');
		redirect("re/projectpayments/showall");
	}
	public function confirm_budget()
	{
		if ( ! check_access('confirm_budget'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/introducer/showall');
			return;
		}
		
		if($this->project_model->check_budget_confirmed($this->uri->segment(4))){
			$this->session->set_flashdata('error', 'Budget already confirmed.');
			redirect('re/projectpayments/showall');
		}
		
		$id=$this->project_model->confirm_budget($this->uri->segment(4));
		$this->lotdata_model->cost_adjustment($this->uri->segment(4));
		$this->common_model->delete_notification('re_prjacpaymentdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Project Payment successfully Confirmed');
		redirect("re/projectpayments/showall");
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */