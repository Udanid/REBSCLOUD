<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fundtransfers extends CI_Controller {

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
		$this->load->model('hm_fundtransfers_model');
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_fundtransfers'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home');
			return;
		}
		redirect('hm/fundtransfers/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_fundtransfers'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
				$data['searchpath']='hm/fundtransfers/search';
				$data['tag']='Search project';
				$page_count = (int)$this->uri->segment(4);
				if ( !$page_count)
				$page_count = 0;
				$pagination_counter =RAW_COUNT;
				$siteurl = 'hm/fundtransfers/showall';
				$this->pagination($page_count,$siteurl,'hm_prjacbudgettrn');
				//echo $this->hm_projectpayment_model->check_paymentledger_set();
				
				$data['prjlist']=$this->hm_projectpayment_model->get_all_budget_confirm_projectlist($this->session->userdata('branchid'));
				
				$data['datalist']=$this->hm_fundtransfers_model->get_transfer_list($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$this->load->view('hm/fundtransfers/transfer_list',$data);
	}
	function get_tasklist()
	{
		$data=NULL;
		
		$data['tasklist']=$this->hm_fundtransfers_model->get_project_to_task($this->uri->segment(4));
		$this->load->view('hm/fundtransfers/totasklist', $data);
	}
	function loadd_daterange()
	{
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4));
		$this->load->view('hm/fundtransfers/date_range', $data);
	}
	function search()
	{
		if ( ! check_access('view_fundtransfers'))
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
	
	function add_internal()
	{
		if ( ! check_access('add_fundtransfers'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/lotdata/showall/');
			return;
		}	
		$fromtaks=explode(',',$this->input->post('task_id'));
		$totask=explode(',',$this->input->post('to_task_id'));
		$trn_type=$this->input->post('trn_type');
		$amount=$this->input->post('amount');
		$description=$this->input->post('description');
		$prj_id=$this->input->post('prj_id');
		$trndate=$this->input->post('trndate');
		$data=$this->hm_fundtransfers_model->add_fundtransfers_internal($totask[0],$fromtaks[0],$trn_type,$amount,$description,$prj_id,$prj_id,$trndate);
		if($data)
		{
			$this->common_model->add_notification('hm_prjacbudgettrn','Project Fund Transfers','hm/fundtransfers',$data);
			$this->session->set_flashdata('msg', 'Project fund Transfer  Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('task_name').' fund Transfer  successfully Inserted');
			redirect("hm/fundtransfers/showall");
		}
		else
		{
		//$this->common_model->add_notification('hm_prjacpaymentdata','Project Payments','hm/fundtransferss',$data);
			$this->session->set_flashdata('error', 'Error Inserting Project Payment');
		//	$this->logger->write_message("error", $this->input->post('task_name').'  successfully Inserted');
			redirect("hm/fundtransfers/showall");
		}
		
	 	//echo $voucherid;
	}
	function add_inner()
	{
		if ( ! check_access('add_fundtransfers'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/lotdata/showall/');
			return;
		}	
		$fromtaks=explode(',',$this->input->post('task_id'));
		$totask=explode(',',$this->input->post('to_task_id'));
		$trn_type=$this->input->post('trn_type');
		$amount=$this->input->post('inner_amount');
		$description=$this->input->post('inner_dis');
		$fromprj_id=$this->input->post('interf_prj_id');
		$toprj_id=$this->input->post('intert_prj_id');
		$data=$this->hm_fundtransfers_model->add_fundtransfers_internal($totask[0],$fromtaks[0],$trn_type,$amount,$description,$fromprj_id,$toprj_id);
		if($data)
		{
			$this->common_model->add_notification('hm_prjacbudgettrn','Project Fund Transfers','hm/fundtransfers',$data);
			$this->session->set_flashdata('msg', 'Project fund Transfer  Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('task_name').' fund Transfer  successfully Inserted');
			redirect("hm/fundtransfers/showall");
		}
		else
		{
		//$this->common_model->add_notification('hm_prjacpaymentdata','Project Payments','hm/fundtransferss',$data);
			$this->session->set_flashdata('error', 'Error Inserting Project Payment');
		//	$this->logger->write_message("error", $this->input->post('task_name').'  successfully Inserted');
			redirect("hm/fundtransfers/showall");
		}
	}
	function add_external()
	{
		if ( ! check_access('add_fundtransfers'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/lotdata/showall/');
			return;
		}	
		//$fromtaks=explode(',',$this->input->post('task_id'));
		$totask=explode(',',$this->input->post('to_task_id'));
		$trn_type=$this->input->post('trn_type_ex');
		$amount=$this->input->post('ex_amount');
		$description=$this->input->post('ex_dis');
		$toprj_id=$this->input->post('prj_id_ex');
		$trndate=$this->input->post('trndate_ex');
		$data=$this->hm_fundtransfers_model->add_fundtransfers_external($totask[0],$trn_type,$amount,$description,$toprj_id,$trndate);
		if($data)
		{
			$this->session->set_flashdata('msg', 'Project fund Transfer  Successfully Inserted ');
			$this->logger->write_message("success", ' fund Transfer  successfully Inserted');
			redirect("hm/fundtransfers/showall");
		}
		else
		{
		//$this->common_model->add_notification('hm_prjacpaymentdata','Project Payments','hm/fundtransferss',$data);
			$this->session->set_flashdata('error', 'Error Inserting Project Payment');
		//	$this->logger->write_message("error", $this->input->post('task_name').'  successfully Inserted');
			redirect("hm/fundtransfers/showall");
		}
	}
	public function confirm()
	{
		if ( ! check_access('confirm_fundtransfers'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/introducer/showall');
			return;
		}
		$id=$this->hm_fundtransfers_model->confirm($this->uri->segment(4));
		if($id){
		$this->common_model->delete_notification('hm_prjacbudgettrn',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Project Payment Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Project Payment successfully Confirmed');}
		else
		$this->session->set_flashdata('error', 'Fund Transfer Not confirmed ');
		
		redirect("hm/fundtransfers/showall");
		
	}
		public function delete()
	{
		if ( ! check_access('delete_fundtransfers'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/fundtransfers/showall');
			return;
		}
		$id=$this->hm_fundtransfers_model->delete($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_prjacbudgettrn',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Fund Transfer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Fund Transfer Successfully Deleted');
		redirect("hm/fundtransfers/showall");
		
	}
	 public function projectcompltion()
	{
		$data=NULL;
		if ( ! check_access('add_projectcomplete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
				$data['searchpath']='hm/fundtransfers/search';
				$data['tag']='Search project';
				$page_count = (int)$this->uri->segment(4);
				if ( !$page_count)
				$page_count = 0;
				$pagination_counter =RAW_COUNT;
				$siteurl = 'hm/fundtransfers/projectcompltion';
				$this->pagination($page_count,$siteurl,'hm_prjdvcomplete');
				//echo $this->hm_projectpayment_model->check_paymentledger_set();
				
				$data['prjlist']=$this->hm_projectpayment_model->get_all_budget_confirm_projectlist($this->session->userdata('branchid'));
				
				$data['datalist']=$this->hm_fundtransfers_model->get_complete_list($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$this->load->view('hm/fundtransfers/complet_list',$data);
	}
	function  get_complete_tasklist()
	{
		$data['details']=$this->hm_projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
		$data['prjdata']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$this->load->view('hm/fundtransfers/taskt_data', $data);
	}
	function add_completion()
	{
		if ( ! check_access('add_projectcomplete'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/fundtransfers/showall/');
			return;
		}	
		
		$trndate_ex=$this->input->post('trndate_ex');
		$prj_id_ex=$this->input->post('prj_id_ex');
		$dataset=$this->hm_projectpayment_model->get_project_paymeny_task($prj_id_ex);
		$prjdata=$this->hm_project_model->get_project_bycode($prj_id_ex)	;
		$total=0;
		if($dataset)
		{$i=0;$crtot=0;$drtot=0;
			foreach($dataset as $raw )
			{ $taskdata=$this->hm_fundtransfers_model->get_task_fulldata($raw->task_id);
				$balance=$raw->new_budget-$raw->tot_payments;
				
				$craccount='HEDPI52050000';
				if($balance>0)
				{
					$total=$total+$balance;
					$crlist[$i]['ledgerid']=$craccount;
					$crlist[$i]['amount']=$balance;
					$drlist[$i]['ledgerid']=$this->session->userdata('accshortcode').$taskdata->ledger_id;
					$drlist[$i]['amount']=$balance;
					$crtot=$crtot+$balance;
					$drtot=$drtot+$balance;
					$i++;
				}
				
				
				
			}
			$narration=$prjdata->project_name." Development completion entry";
			$delay_entry=hm_jurnal_entry($crlist,$drlist,$crtot,$drtot,$trndate_ex,$narration,$prj_id_ex,'');
			$taskdata=$this->hm_fundtransfers_model->project_complete_update($prj_id_ex,$trndate_ex,$total,$delay_entry);
			
		//	$this->common_model->add_notification('hm_prjacbudgettrn','Project Fund Transfers','hm/fundtransfers',$data);
			$this->session->set_flashdata('msg', 'Project Completion entry  Successfully Inserted ');
			$this->logger->write_message("success", $this->input->post('task_name').' fund Transfer  successfully Inserted');
			redirect("hm/fundtransfers/projectcompltion");
		}
		else
		{
			$taskdata=$this->hm_fundtransfers_model->project_complete_update($prj_id_ex,$trndate_ex,'0','0');
		//$this->common_model->add_notification('hm_prjacpaymentdata','Project Payments','hm/fundtransferss',$data);
			$this->session->set_flashdata('error', 'Project Coplete with zero transaction');
		//	$this->logger->write_message("error", $this->input->post('task_name').'  successfully Inserted');
			redirect("hm/fundtransfers/projectcompltion");
		}
	}
	public function delete_competion()
	{
		if ( ! check_access('add_projectcomplete'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/fundtransfers/showall');
			return;
		}
		$id=$this->hm_fundtransfers_model->delete_competion($this->uri->segment(4));
		
	
		$this->session->set_flashdata('msg', 'Fund Transfer Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).'Project Completion entry Successfully Deleted');
		redirect("hm/fundtransfers/projectcompltion");
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */