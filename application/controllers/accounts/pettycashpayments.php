<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pettycashpayments extends CI_Controller {

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
		$this->load->model("pettycashpayments_model");
		$this->load->model("settlement_model");
		$this->load->model("supplier_model");
		



		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		$data=NULL;

		redirect('accounts/pettycashpayments/showall');



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

	$this->load->view('accounts/pettycashpayments/cashbook_config',$data);



	}




	public function payment()
	{


		$data=NULL;
		
		$data['list']=$list=$this->uri->segment(4);
		
		
		
		
		
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
		$pay_type='CSH';
			$data['booklist']=$inventory=$this->cashadvance_model->get_all_books($pay_type);
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
        $data['emplist']=$emplist=$this->cashadvance_model->get_employee_details();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']='';
				$data['searchpath']='accounts/cashadvance/cashbook_config';

					$data['advlist']=$this->pettycashpayments_model->get_Paid_advancedata($this->session->userdata('branchid'));
                     $data['settlelist']=$dataset=$this->pettycashpayments_model->get_payment_list($pagination_counter,$page);

				$data['ledgerlist']=$this->cashadvance_model->get_active_ledgerlist();
				$data['invoice']=$this->invoice_model->get_not_paid_invoices_project();

				$data['approvlist']=$this->common_model->get_privilage_officer_list('approve_directpayments');
				 $data['check_list']=$this->common_model->get_privilage_officer_list('check_directpayments');

				$data['tag']='Search Document Types';
				
					
					$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				
				$siteurl='accounts/pettycashpayments/payment';
				$tablename='ac_cashpayment_ontime';
				$this->pagination($page_count,$siteurl,$tablename);

		$this->load->view('accounts/pettycashpayments/payment_main',$data);

	}
	function get_officder_advancelist()
	{
		$data['officerid']=$officerid=$this->uri->segment(4);
		$data['advancelist']=$this->pettycashpayments_model->get_officers_cash_advancedata($officerid);
		$this->load->view('accounts/pettycashpayments/advance_list',$data);
	}
	function add_project_raw()
	{
		$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['counter']=$counter=$this->uri->segment(5);
		$data['tag']=$tag=$this->uri->segment(4);
		$this->load->view('accounts/pettycashpayments/payment_projectraw',$data);

	}
	function get_tasklist()
	{
		$data=NULL;

		$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(6));
		$data['counter']=$counter=$this->uri->segment(5);
		$data['tag']=$tag=$this->uri->segment(4);
		$this->load->view('accounts/pettycashpayments/tasklist', $data);
	}
	function get_subtask_list_payment()
	{
			$data['counter']=$counter=$this->uri->segment(7);
		$data['tag']=$tag=$this->uri->segment(6);
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['task_id']=$task_id=$this->uri->segment(4);
		$data['tasklist']=$this->common_model->get_project_subtask($task_id,$prj_id);
		$this->load->view('accounts/pettycashpayments/subtask_list', $data);
	}
	function add_external_raw()
	{
		$data['ledgerlist']=$this->cashadvance_model->get_active_ledgerlist();
		$data['counter']=$counter=$this->uri->segment(5);
		$data['tag']=$tag=$this->uri->segment(4);
		$this->load->view('accounts/pettycashpayments/payment_externalraw',$data);

	}

	public function add_payment()
	{
		if ( ! check_access('add_directpayments'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$id=$this->pettycashpayments_model->add_payments();


		$settledata=$this->pettycashpayments_model->get_onetimepayment_data($id);
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
			$settledata=$this->pettycashpayments_model->get_onetimepayment_data($id);
			$aprofficer=$settledata->check_officerid;

				$this->common_model->add_notification_officer('ac_cashadvance','Direct Cash Payments to  Check','accounts/cashadvance/advancelist/book',$id,$aprofficer);

		$this->session->set_flashdata('msg', 'Cash Advance   Settement Successfully Inserted ');
		$this->logger->write_message("success", 'Cash Advance  successfully Inserted');
		redirect("accounts/pettycashpayments/payment");

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
	public function delete_payment()
	{

		$id=$this->pettycashpayments_model->delete_payment($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashpayment_ontime',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Pettycash payment  Successfully Deleted ');
		$this->logger->write_message("success", 'Cash Advance payment  successfully Deleted');
			redirect("accounts/pettycashpayments/payment/book");

	}
	public function get_paymentdata($id)
	{

		//echo $id;
			$data['settledata']=$settledata=$this->pettycashpayments_model->get_onetimepayment_data($id);

			$data['list']=$this->pettycashpayments_model->get_payment_list_ontime($id);
			$data['attachments']=$this->settlement_model->get_settelment_file($settledata->file_folder);
			$this->load->view('accounts/pettycashpayments/payment_view',$data);

	}
		public function print_paymentdata($id)
	{

		//echo $id;
			$data['settledata']=$settledata=$this->pettycashpayments_model->get_onetimepayment_data($id);

			$data['list']=$this->pettycashpayments_model->get_payment_list_ontime($settledata->id);//updated by nadee 2021-06-08

			$this->load->view('accounts/pettycashpayments/payment_print',$data);

	}
	public function check_payment()
	{
		if ( ! check_access('check_directpayments'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->pettycashpayments_model->check_payment($this->uri->segment(4));
				$this->common_model->delete_notification('ac_cashpayment_ontime',$this->uri->segment(4));


		$settledata=$this->pettycashpayments_model->get_onetimepayment_data($this->uri->segment(4));
			$aprofficer=$settledata->confirm_officerid;

				$this->common_model->add_notification_officer('ac_cashadvance','Direct Cash Payments to  Confirm','accounts/cashadvance/advancelist/book',$this->uri->segment(4),$aprofficer);
		$this->session->set_flashdata('msg', 'Petty cash payment  Successfully Checked ');
		$this->logger->write_message("success", 'Cash Advance payment  successfully Confirmed');
			redirect("accounts/pettycashpayments/payment/book");;

	}
	public function confirm_payment()
	{
		if ( ! check_access('confirm_directpayments'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->pettycashpayments_model->confirm_payment($this->uri->segment(4));
				$this->common_model->delete_notification('ac_cashpayment_ontime',$this->uri->segment(4));

				$settledata=$this->pettycashpayments_model->get_onetimepayment_data($this->uri->segment(4));
			$aprofficer=$settledata->apprved_officerid;

				$this->common_model->add_notification_officer('ac_cashadvance','Direct Cash Payments to  Approve','accounts/cashadvance/advancelist/book',$this->uri->segment(4),$aprofficer);

		$this->session->set_flashdata('msg', 'Petty cash payment  Successfully Confirmed ');
		$this->logger->write_message("success", 'Cash Advance payment  successfully Confirmed');
			redirect("accounts/pettycashpayments/payment/book");;

	}
	public function approve_payment()
	{
		if ( ! check_access('approve_directpayments'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}

		$id=$this->pettycashpayments_model->approve_payment($this->uri->segment(4));
				$this->common_model->delete_notification('ac_cashpayment_ontime',$this->uri->segment(4));

		$this->session->set_flashdata('msg', 'Petty cash payment  Successfully Approved ');
		$this->logger->write_message("success", 'Cash Advance payment  successfully Confirmed');
			redirect("accounts/pettycashpayments/payment/book");;

	}
	function reimbursement_report()
	{

		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
					$data['searchlist']='';
				$data['searchpath']='accounts/pettycashpayments/cashbook_config';
		$data['datalist']=$inventory=$this->cashadvance_model->get_all_books('CSH');
		$data['reimlist']=$this->pettycashpayments_model->get_reimbersment_list();

				$data['tag']='Search Document Types';

		$this->load->view('accounts/pettycashpayments/report_main',$data);
	}
	function report_data()
	{
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->get_settlement_data_bybook($bookid,$rptdate);
		$data['pendiglist']=$this->pettycashpayments_model->get_pending_data_bybook($bookid,$rptdate);
		$data['paymentlist']=$this->pettycashpayments_model->get_payment_list_confirmed($bookid,$rptdate);
		$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);

		$this->load->view('accounts/pettycashpayments/report_data',$data);
	}
		function report_data_excel()
	{
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$data['settledlist']=$this->cashadvance_model->get_settlement_data_bybook($bookid,$rptdate);
		$data['paymentlist']=$this->pettycashpayments_model->get_payment_list_confirmed($bookid,$rptdate);


		$data['pendiglist']=$this->pettycashpayments_model->get_pending_data_bybook($bookid,$rptdate);
		$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);

		$this->load->view('accounts/pettycashpayments/report_data_excel',$data);
	}
	function apply_reimbersment()
	{
		if ( ! check_access('apply_reimbursement'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		$data['bookid']=$bookid=$this->uri->segment(5);
		$data['rptdate']=$rptdate=$this->uri->segment(4);
		$data['amount']=$amount=$this->uri->segment(6);
		//$data['bookdata']=$bookdata=$details=$this->cashadvance_model->get_cashbook_data($bookid);
		$id=$this->pettycashpayments_model->apply_reimbersment($bookid,$rptdate,$amount);
	//	$data['pendiglist']=$this->cashadvance_model->get_pending_data_bybook($bookid,$rptdate);
	//	$data['ledgerbalance']=$ledgerbalance=$this->Ledger_model->get_ledger_balance($bookdata->ledger_id);
$this->session->set_flashdata('msg', 'Cash Advance Reimbersment successfully Updated ');
		//$this->logger->write_message("success", 'Cash Advance Settlement  successfully Deleted');
			//redirect("accounts/cashadvance/settlement");
			$this->common_model->add_notification('ac_cashreimbursement','Petty Cash Reimbersment','accounts/pettycashpayments/reimbursement_report/book',$id);
			redirect("accounts/pettycashpayments/reimbursement_report");
	}
	public function delete_reimbersment()
	{

		$id=$this->pettycashpayments_model->delete_reimbersment($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashsettelment_ontime',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Pettycash Reimbursement  Successfully Deleted ');
		$this->logger->write_message("success", 'Cash Advance payment  successfully Deleted');
		$this->common_model->delete_notification('ac_cashreimbursement',$this->uri->segment(4));
			redirect("accounts/pettycashpayments/reimbursement_report");

	}
	public function confirm_reimbersment()
	{

		$id=$this->pettycashpayments_model->confirm_reimbersment($this->uri->segment(4));
			$this->common_model->delete_notification('ac_cashsettelment_ontime',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Pettycash Reimbursement  Successfully Deleted ');
		$this->logger->write_message("success", 'Cash Advance payment  successfully Deleted');
		$this->common_model->delete_notification('ac_cashreimbursement',$this->uri->segment(4));
			redirect("accounts/pettycashpayments/reimbursement_report");

	}
	public function get_reimbersment_data($id)
	{
		$data['rptdata']=$this->pettycashpayments_model->get_reimbersment_data($id);
		$data['settledlist']=$this->pettycashpayments_model->get_cashadvance_reimbersment($id);
		$data['paymentlist']=$this->pettycashpayments_model->get_payment_reimbersment($id);

		$this->load->view('accounts/pettycashpayments/reimbursement_view',$data);

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
