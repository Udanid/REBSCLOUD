<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settlments extends CI_Controller {

	/**
	 * Index Page for this controller.
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
		
		$this->load->model("cashadvance_model");
		$this->load->model("invoice_model");
		$this->load->model("common_model");
		$this->load->model("Ledger_model");
		$this->load->model("branch_model");
		$this->load->model("project_model");
		$this->load->model("projectpayment_model");
		$this->load->model("settlement_model");
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		$data=NULL;
		
		redirect('accounts/cashadvance/showall');
		
		
		
	}
	public function showall()
	{
		//$this->output->delete_cache();
		if ( ! check_access('view_cashebook_type'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data=NULL;
		
		$data['list']=$list=$this->uri->segment(4);
		$data['searchdata']=$inventory=$this->cashadvance_model->get_allbook_types();
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();
		$data['ledgerlist']=$inventory=$this->cashadvance_model->get_all_ledgers();
			$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/cashadvance/cashbook_config';
				$data['tag']='Search Document Types';
		
	$this->load->view('accounts/cashadvance/cashbook_config',$data);
		
		
		
	}

	
	
	
	public function settlement()
	{
		
		
		$data=NULL;
		
			$data=NULL;
		$pagination_counter =RAW_COUNT;
		
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data['list']=$list=$this->uri->segment(4);
		if ($page != 0){
			$data['list']='book';
		}
		
		if ($_POST)
        {
				$data['list']='book';
		}
		
		$data['mylist']=$mylist='test';
			$data['pay_type']=$pay_type='CSH';
			  $data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books($pay_type);
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']='';
				$data['searchpath']='accounts/cashadvance/cashbook_config';
    		
					$data['advlist']=$this->settlement_model->get_Paid_advancedata($this->session->userdata('branchid'));
                     $data['settlelist']=$dataset=$this->settlement_model->get_settlement_list($pagination_counter,$page);
				
				$data['ledgerlist']=$this->cashadvance_model->get_active_ledgerlist();
				$data['invoice']=$this->invoice_model->get_not_paid_invoices_project();
				//echo 
				$config["total_rows"]=count($dataset);
				
				$data['tag']='Search Document Types';
					$data['tag']='Search Document Types';
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				
				$siteurl='accounts/settlments/settlement';
				$tablename='ac_cashsettelment_ontime';
				$this->pagination($page_count,$siteurl,$tablename);
		
		$this->load->view('accounts/settlements/settlement_main',$data);
		
	}
	function add_project_raw()
	{
		$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['counter']=$counter=$this->uri->segment(5);
		$data['tag']=$tag=$this->uri->segment(4);
		$this->load->view('accounts/settlements/settlement_projectraw',$data);
		
	}
	function get_tasklist()
	{
		$data=NULL;
		
		$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(6));
		$data['counter']=$counter=$this->uri->segment(5);
		$data['tag']=$tag=$this->uri->segment(4);
		$this->load->view('accounts/settlements/tasklist', $data);
	}
	function get_subtask_list_payment()
	{
			$data['counter']=$counter=$this->uri->segment(7);
		$data['tag']=$tag=$this->uri->segment(6);
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['task_id']=$task_id=$this->uri->segment(4);
		$data['tasklist']=$this->common_model->get_project_subtask($task_id,$prj_id);
		$this->load->view('accounts/settlements/subtask_list', $data);
	}
	function add_external_raw()
	{
		$data['ledgerlist']=$this->cashadvance_model->get_active_ledgerlist();
		$data['counter']=$counter=$this->uri->segment(5);
		$data['tag']=$tag=$this->uri->segment(4);
		$this->load->view('accounts/settlements/settlement_externalraw',$data);
		
	}
	
	public function add_settlment()
	{
		if ( ! check_access('add_pettycash_settlements'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->settlement_model->add_settlment();
		$settledata=$this->settlement_model->get_settlement_data($id);
		$insert_id=$settledata->file_folder;
		if ($this->input->post('file_array')){
				$files = explode(',', $this->input->post('file_array')); //create an array from files
				//create folders
				if (!file_exists('uploads/pettycash/'.$insert_id)) {
					mkdir('uploads/pettycash/'.$insert_id, 0777, true);
				}
				if (!file_exists('uploads/pettycash/'.$insert_id.'/thumbnail')) {
					mkdir('uploads/pettycash/'.$insert_id.'/thumbnail', 0777, true);
				}
				//move files
				foreach($files as $raw){
					if (file_exists('uploads/pettycash/temp_images/'.$raw)) {
						$image_info = explode(".", $raw);
						$image_type = end($image_info);
						$new_name = $this->generateRandomName().'.'.$image_type;
						rename('uploads/pettycash/temp_images/'.$raw, 'uploads/pettycash/'.$insert_id.'/'.$new_name);
						//add_watermark('media/property_images/'.$type.'/'.$insert_id.'/'.$new_name,'media/property_images/'.$type.'/'.$insert_id.'/watermarked_'.$new_name);
						//now add it in to web_images table
						$this->settlement_model->add_settelment_file($insert_id,$new_name);
					}
					if (file_exists('uploads/pettycash/temp_images/thumbnail/'.$raw)) {
						rename('uploads/pettycash/temp_images/thumbnail/'.$raw, 'uploads/pettycash/'.$insert_id.'/thumbnail/'.$new_name);
					}
				}
			}
	//	echo $id;
	
	
		$advancedata=$this->cashadvance_model->get_cashadvancedata($settledata->adv_id);
		$aprofficer=$advancedata->check_officerid;
		$this->common_model->add_notification_officer('ac_cashsettelment_ontime','IOU Settlement to  Check','accounts/settlments/settlement/book',$id,$aprofficer);
		
		$this->session->set_flashdata('msg', 'Cash Advance   Settement Successfully Inserted ');
		$this->logger->write_message("success", 'Cash Advance  successfully Inserted');
		redirect("accounts/settlments/settlement");
		
	}
	function generateRandomName($length = 15) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function delete_settlement()
	{
		
		$id=$this->settlement_model->delete_settlment($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashsettelment_ontime',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Pettycash Settlement  Successfully Deleted ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Deleted');
			redirect("accounts/settlments/settlement");
		
	}
	public function get_settementdata($id)
	{
		
		//echo $id;
			$data['settledata']=$dataset=$this->settlement_model->get_settlement_data($id);
			
			$data['list']=$settledata=$this->settlement_model->get_settlement_list_ontime($id);
			
			$data['attachments']=$this->settlement_model->get_settelment_file($dataset->file_folder);
			
			$this->load->view('accounts/settlements/settlement_view',$data);
		
	}
		public function print_settementdata($id)
	{
		
		//echo $id;
			$data['settledata']=$this->settlement_model->get_settlement_data($id);
			
			$data['list']=$settledata=$this->settlement_model->get_settlement_list_ontime($id);
			
			$this->load->view('accounts/settlements/settlement_print',$data);
		
	}
	public function check_settlement()
	{
		if ( ! check_access('check_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		
		
		
		$id=$this->settlement_model->check_settlement($this->uri->segment(4));
		
		$this->common_model->delete_notification('ac_cashsettelment_ontime',$this->uri->segment(4));
		
		$settledata=$this->settlement_model->get_settlement_data($this->uri->segment(4));
		$advancedata=$this->cashadvance_model->get_cashadvancedata($settledata->adv_id);
		$aprofficer=$advancedata->confirm_officerid;
	
				$this->common_model->add_notification_officer('ac_cashsettelment_ontime','IOU Settlement to  Confirm','accounts/settlments/settlement/book',$this->uri->segment(4),$aprofficer);
			
			$this->session->set_flashdata('msg', 'IOU  Successfully Checked ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Confirmed');
			redirect("accounts/settlments/settlement");
		
	}
	public function confirm_settlement()
	{
		
		
		if ( ! check_access('confirm_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		
		
		$id=$this->settlement_model->confirm_settlement($this->uri->segment(4));
		$this->common_model->delete_notification('ac_cashsettelment_ontime',$this->uri->segment(4));
	
		
		$settledata=$this->settlement_model->get_settlement_data($this->uri->segment(4));
		$advancedata=$this->cashadvance_model->get_cashadvancedata($settledata->adv_id);
		$aprofficer=$advancedata->apprved_officerid;
		$this->common_model->add_notification_officer('ac_cashsettelment_ontime','IOU Settlement to  Approve','accounts/settlments/settlement/book',$this->uri->segment(4),$aprofficer);
		
		
		$this->session->set_flashdata('msg', 'Petty cash Settlement  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Confirmed');
			redirect("accounts/settlments/settlement");;
		
	}
	public function approve_settlement()
	{
		
		
		if ( ! check_access('approve_cashadvance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		
		
		$id=$this->settlement_model->approve_settlement($this->uri->segment(4));
		$this->common_model->delete_notification('ac_cashsettelment_ontime',$this->uri->segment(4));
	
		
		
		
		
		$this->session->set_flashdata('msg', 'Petty cash Settlement  Successfully Approved ');
		$this->logger->write_message("success", 'Cash Advance Settlement  successfully Confirmed');
			redirect("accounts/settlments/settlement");;
		
	}
	
	function test($id)
	{
	$id=$this->cashadvance_model->delete_cashadvance_onpayment($this->uri->segment(4));
	}
	function cash_advance_report()
	{
		
		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
					$data['searchlist']='';
				$data['searchpath']='accounts/cashadvance/cashbook_config';
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books();
				
				$data['tag']='Search Document Types';
		
		$this->load->view('accounts/cashadvance/report_main',$data);
	}
	function report_data()
	{
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->get_settlement_data_bybook($bookid,$rptdate);
		$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
		$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);

		$this->load->view('accounts/cashadvance/report_data',$data);
	}
		function report_data_excel()
	{
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->get_settlement_data_bybook($bookid,$rptdate);
		$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
		$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);

		$this->load->view('accounts/cashadvance/report_data_excel',$data);
	}
	function confirm_report()
	{
		if ( ! check_access('confirm_advance_report_data'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		//$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->confirm_settlement_data_bybook($bookid,$rptdate);
	//	$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
	//	$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);
$this->session->set_flashdata('msg', 'Cash Advance Reimbersment successfully Updated ');
		//$this->logger->write_message("success", 'Cash Advance Settlement  successfully Deleted');
			//redirect("accounts/cashadvance/settlement");
			redirect("accounts/cashadvance/cash_advance_report");
	}
	function check_officer_unsettled_advance(){
		
		$officer_id = $this->input->post('officer_id');
		$data=$this->cashadvance_model->check_officer_unsettled_advance($officer_id);
		if($data)
		echo 'This officer has unsettled cash advances';
	}
	
	
	public function report()
{
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	$this->load->view('accounts/cashadvance/settlement_report_main',$data);
}
function full_report()
{
	$reportnames=$this->input->post('reportnames');
	$fromdate=$this->input->post('fromdate');
	$todate=$this->input->post('todate');
	$officer_id=$this->input->post('officer_id');
	$amount=$this->input->post('amount');

	if($reportnames=='01') //Ticket No-2800 | Added By Uvini
	$this->cashadvance_data($fromdate,$todate,$officer_id,$amount);
	// else if($reportnames=='02')
	// $this->unsettlement_report_data($fromdate,$todate,$officer_id,$amount);
	else if($reportnames=='03')
	$this->unsettlement_report_data_timeexceed($officer_id);
	else
	$this->settlement_report();

}
function settlement_report_data($fromdate,$todate,$officer_id,$amount)
{

	//$data['fromdate']=$fromdate=$this->uri->segment(4);
//	$data['todate']=$todate=$this->uri->segment(5);
//	$data['officer_id']=$officer_id=$this->uri->segment(4);
	$data['settledlist']=$settledlist=$this->cashadvance_model->get_settlement_data($fromdate,$todate,$officer_id,$amount);
	$ledger_data=Null;
	//print_r($settledlist);
	$task_data=Null;
	if($settledlist){
		foreach ($settledlist as $key => $value) {
			$ledger_data[$value->adv_id]=null;
			if($value->payvoucher_id)
			{
				$ledger_data[$value->adv_id]=$this->cashadvance_model->get_ledgerdata_byvoucher($value->voucher_id);

			}
			$task_data[$value->adv_id]=$this->cashadvance_model->get_project_paymeny_advanceid($value->adv_id);
		}
	}

	$data['fromdate']=$fromdate;
	$data['todate']=$todate;
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	$data['task_data']=$task_data;
	$data['ledger_data']=$ledger_data;
	//print_r($ledger_data);
	$this->load->view('accounts/cashadvance/settlement_report_data',$data);

}//ticket end 1322
//ticketnumber 1520 updated by nadee
function unsettlement_report_data($fromdate,$todate,$officer_id,$amount)
{
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
//	$data['todate']=$todate=$this->uri->segment(5);
//	$data['officer_id']=$officer_id=$this->uri->segment(4);
	$data['settledlist']=$settledlist=$this->cashadvance_model->get_unsettlement_data($fromdate,$todate,$officer_id,$amount);
//print_r($settledlist);
	//print_r($ledger_data);
	$settled_data=Null;
	if($settledlist)
	{
		foreach ($settledlist as $key => $raw) {
			$bal=$raw->amount-$raw->settled_amount-$raw->refund_amount;
	
			$unsettled_data[$raw->adv_id]=$this->cashadvance_model->get_settlement_details($raw->adv_id);
	
		}
	}
	$data['fromdate']=$fromdate;
	$data['todate']=$todate;
	$data['unsettled_data']=$unsettled_data;
	$this->load->view('accounts/cashadvance/unsettlement_report_data',$data);

}
function unsettlement_report_data_timeexceed($officer_id)
{
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
//	$data['todate']=$todate=$this->uri->segment(5);
//	$data['officer_id']=$officer_id=$this->uri->segment(4);
	$data['settledlist']=$settledlist=$this->cashadvance_model->get_unsettlement_data_time_exceed($officer_id);
//print_r($settledlist);
	//print_r($ledger_data);
	$unsettled_data=Null;
	if($settledlist)
	{
		foreach ($settledlist as $key => $raw) {
			$bal=$raw->amount-$raw->settled_amount-$raw->refund_amount;
	
			$unsettled_data[$raw->adv_id]=$this->cashadvance_model->get_settlement_details($raw->adv_id);
	
		}
	}
	$data['fromdate']='';
	$data['todate']='';
	$data['unsettled_data']=$unsettled_data;
	$this->load->view('accounts/cashadvance/unsettlement_report_data',$data);

}

function print_checklist()
{
	
		
		$data['details']=$this->cashadvance_model->get_checked_cashadvancelist();
		
		
			$this->load->view('accounts/cashadvance/print_checkadvancelist',$data);
		
	
}

//Ticket No-2800 | Added By Uvini
function cashadvance_data($fromdate,$todate,$officer_id,$amount)
{
	$data['settledlist']=$settledlist=$this->cashadvance_model->cashadvance_data($fromdate,$todate,$officer_id,$amount);
	$ledger_data=Null;
	//print_r($settledlist);
	$task_data=Null;
	if($settledlist){
		foreach ($settledlist as $key => $value) {
			$ledger_data[$value->adv_id]=null;
			if($value->payvoucher_id)
			{
				$ledger_data[$value->adv_id]=$this->cashadvance_model->get_ledgerdata_byvoucher($value->voucher_id);

			}
			$task_data[$value->adv_id]=$this->cashadvance_model->get_project_paymeny_advanceid($value->adv_id);
		}
	}

	$unsettled_data=Null;
	if($settledlist)
	{
		foreach ($settledlist as $key => $raw) {
			$bal=$raw->amount-$raw->settled_amount-$raw->refund_amount;
	
			$unsettled_data[$raw->adv_id]=$this->cashadvance_model->get_settlement_details($raw->adv_id);
	
		}
	}

	$data['fromdate']=$fromdate;
	$data['todate']=$todate;
	$data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
	$data['task_data']=$task_data;
	$data['ledger_data']=$ledger_data;
	$data['unsettled_data']=$unsettled_data;
	//print_r($ledger_data);
	$this->load->view('accounts/cashadvance/settlement_report',$data);
}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */