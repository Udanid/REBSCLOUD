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
		
		$this->load->model("hm_project_model");
	    $this->load->model("hm_projectpayment_model");
		$this->load->model('paymentvoucher_model');
		$this->load->model('supplier_model');
		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("lotdata_model");
		$this->load->model("reservation_model");
		$this->load->model("reservationdiscount_model");
		$this->load->model("eploan_model");
		$this->load->model("customer_model");
		$this->load->model("additional_development_model");
		
		
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
		redirect('hm/projectpayments/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_projectpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/');
			return;
		}
				$data['searchpath']='hm/lotdata/search';
				$data['tag']='Search project';
				$page_count = (int)$this->uri->segment(4);
				if ( !$page_count)
				$page_count = 0;
				$pagination_counter =RAW_COUNT;
				$siteurl = 'hm/projectpayments/showall';
				$this->pagination($page_count,$siteurl,'hm_prjacpaymentdata');
				//echo $this->hm_projectpayment_model->check_paymentledger_set();
				
					$data['prjlist']=$this->hm_projectpayment_model->get_all_payto_projectlist($this->session->userdata('branchid'));
				
				$data['datalist']=$this->hm_projectpayment_model->get_get_paymentlist($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$data['suplist']=$this->supplier_model->get_all_supplier_summery();
				$data['advlist']=$this->cashadvance_model->get_Paid_advancedata();
				$data['invoice']=$this->invoice_model->get_not_paid_invoices_project();
				$this->load->view('hm/projectpayment/payment_list',$data);
	}
	
	
	function get_tasklist()
	{
		$data=NULL;
		
		$data['tasklist']=$this->hm_projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$this->load->view('hm/projectpayment/tasklist', $data);
	}
	function loadd_daterange()
	{
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4));
		$this->load->view('hm/projectpayment/date_range', $data);
	}
	function search()
	{
		if ( ! check_access('view_project'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/feasibility/showall/'.$encode_id);
			return;
		}	
		$data['planlist']=$planlist=$this->hm_lotdata_model->get_project_blockplans($this->uri->segment(4))	;
		$lotlist=NULL;
		if($planlist)
		foreach($planlist as $plnraw)
		{
		$lotlist[$plnraw->plan_sq]=$this->hm_lotdata_model->get_project_lots($this->uri->segment(4),$plnraw->plan_sq)	;
		}
		$data['lotlist']=$lotlist;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['estimateprice']=$this->hm_lotdata_model->get_feasibility_price($this->uri->segment(4))	;
		$this->load->view('hm/lotdata/search',$data);	
	}
	
	function add()
	{
		if ( ! check_access('add_projectpayment'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/lotdata/showall/');
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
	 	$voucherid=$this->paymentvoucher_model->getmaincode('voucherid','PV','ac_payvoucherdata',$this->input->post('drown_date'));
		$data=$this->hm_projectpayment_model->add_project_payment($taskdata[0],$subtaskdata[0],$date,$amount,$payeename,$payeecode,$prj_id);
		if($data)
		{
			$this->common_model->add_notification('hm_prjacpaymentdata','Project Payments','hm/projectpayments',$data);
			$this->session->set_flashdata('msg', 'Project Payment  Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
			redirect("hm/projectpayments/showall");
		}
		else
		{
		//$this->common_model->add_notification('hm_prjacpaymentdata','Project Payments','hm/projectpayments',$data);
			$this->session->set_flashdata('error', 'Error Inserting Project Payment');
		//	$this->logger->write_message("error", $this->input->post('task_name').'  successfully Inserted');
			redirect("hm/projectpayments/showall");
		}
		
	 	//echo $voucherid;
	}
	public function confirm()
	{
		if ( ! check_access('confirm_projectpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/introducer/showall');
			return;
		}
		$id=$this->hm_projectpayment_model->confirm($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_prjacpaymentdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Project Payment successfully Confirmed');
		redirect("hm/projectpayments/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_projectpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/introducer/showall');
			return;
		}
		$id=$this->hm_projectpayment_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_prjacpaymentdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Project Payment successfully Deleted');
		redirect("hm/projectpayments/showall");
		
	}
	function  get_budget()
	{
		$data['details']=$this->hm_projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$data['prjdata']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$this->load->view('hm/projectpayment/budget_data', $data);
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
			$this->hm_projectpayment_model->update_budget($prj_id,$task_id,$new_estimate,$new_budget);
			
		}
		$this->session->set_flashdata('msg', 'Project Budget successfully updated');
		$this->logger->write_message("success",$prj_id.' Project Budget successfully updated');
		redirect("hm/projectpayments/showall");
	}
	public function confirm_budget()
	{
		if ( ! check_access('confirm_budget'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/introducer/showall');
			return;
		}
		$id=$this->hm_project_model->confirm_budget($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_prjacpaymentdata',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Project Payment successfully Confirmed');
		redirect("hm/projectpayments/showall");
		
	}
	function get_fulldata()
	{
			$data['lotdetail']=$this->lotdata_model->get_project_lotdata_id($this->uri->segment(4));
		$data['current_rescode']=$current_rescode=$this->lotdata_model->get_max_resid($this->uri->segment(4));
		$data['loan_data']=NULL;
		$data['settle_data']=NULL;
		if($current_rescode)
		{
		$data['current_res']=$current_res=$this->reservation_model->get_all_reservation_details_bycode($current_rescode);
		$data['current_advances']=$current_advances=$this->reservation_model->get_advance_data($current_rescode);
		$data['cusdata']=$this->customer_model->get_customer_bycode($current_res->cus_code);
		$data['charge_payment']=$this->reservation_model->get_charge_payments($current_rescode);
			if($current_res->pay_type!='Outright')
			{
				$data['loan_data']=$current_advances=$this->reservation_model->get_eploan_data($current_rescode);
			}
			else
			{
				if($current_res->res_status=='SETTLED')
				{
					$data['settle_data']=$current_advances=$this->reservation_model->get_settlemnt_data_with_payment($current_rescode);
				}
			}
			$data['refunddata']=$this->reservation_model->get_customer_refund($current_rescode);

			//2019-12-19 Ticket 943 B.K.Dissanayake
			$data['resevationdiscount']=$this->reservationdiscount_model->get_reservationDiscount_by_lotid_prjid($current_rescode);

		}
		$data['res_his']=$res_his=$this->lotdata_model->get_reservation_historty($this->uri->segment(4));
		$resolelist=NULL;
		if($res_his)
		{
			foreach($res_his as $raw)
			{
				if($raw->pay_type=='Pending')
				{
					$resolelist[$raw->res_code]=$this->lotdata_model->get_resale_by_res_code($raw->res_code);

				}
				else
				$resolelist[$raw->res_code]=$this->lotdata_model->get_epresale_res_code($raw->res_code);

			}
		}
		$data['resolelist']=$resolelist;


		// Added by kalum Ticket 814 2019-10-28

			$data['paylistinq']=NULL;

			if($data['loan_data']){
				//if($current_advances->loan_type!='EPB'){
					$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($current_advances->loan_code);
				//}
			}

		// end Ticket 814

		// additonal development in lot inquart
		$data['development_data']=$this->additional_development_model->get_development_data_by_res_code($current_rescode);

		$this->load->view('hm/projectpayment/lot_details',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */