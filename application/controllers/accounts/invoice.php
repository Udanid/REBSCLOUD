<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller {

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
		$this->load->model("supplier_model");
			$this->load->model("project_model");
		$this->load->model("projectpayment_model");
		
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		
		redirect('accounts/invoice/showall');
		
		
		
	}

	public function showall()
	{
		//$this->output->delete_cache();
		$data=NULL;
		
		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
		$data['datalist']=$inventory=$this->invoice_model->get_all_invoices();
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
		$data['ledgerlist']=$inventory=$this->invoice_model->get_all_legers();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
		$data['assetlist']=$inventory=$this->invoice_model->get_confiremed_assets();
				
				$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/invoice/invoice_main';
				
				
				$data['tag']='Search Document Types';
		
		$this->load->view('accounts/invoice/invoice_main',$data);
	} 
	
	
	public function get_tasklist()
	{
			$data['tasklist']=$this->projectpayment_model->get_project_paymeny_task($this->uri->segment(4));
	
		$this->load->view('accounts/cashadvance/task_list',$data);
	}
	public function add_invoice()
	{
		if ( ! check_access('add invoice'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
		$id=$this->invoice_model->add_invoice();
		
		$this->session->set_flashdata('msg', 'Invoice  Successfully Inserted ');
		$this->logger->write_message("success", 'Invoice  successfully Inserted');
		redirect("accounts/invoice/showall");
		
	}
	public function delete_invoice($id)
	{
		if ( ! check_access('delete invoice'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
		$id=$this->invoice_model->delete_invoice($this->uri->segment(4));
		
		$this->session->set_flashdata('msg', 'Invoice  Successfully Deleted ');
		$this->logger->write_message("success", 'Invoice  successfully Deleted');
		redirect("accounts/invoice/showall");
		
	}
	public function confirm_invoice()
	{
		if ( ! check_access('confirm invoice'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
		$id=$this->invoice_model->confirm_invoice($this->uri->segment(4));
		
		$this->session->set_flashdata('msg', 'Invoice  Successfully Confirmed ');
		$this->logger->write_message("success", 'Invoice  successfully Confirmed');
		redirect("accounts/invoice/showall");
		
	}
	
	public function add_payment()
	{
		
		if ( ! check_access('add invoice payments'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
		$data=NULL;
	
		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']='';
				$data['searchpath']='accounts/cashadvance/cashbook_config';
					$data['invoice']=$this->invoice_model->get_not_paid_invoices_confirmed();
				$data['datalist']=$this->invoice_model->payment_list();
				//Ticket No:3440 Added By Madushan 2021-09-14
				$data['suplist']=$this->supplier_model->get_all_supplier_summery();
				
				$data['tag']='Search Document Types';
				$this->load->view('accounts/invoice/add_payment',$data);
		
	}

	//Ticket No:3440 Added By Madushan 2021-09-14
	public function seach_invoice()
	{
		$sup_code = $this->uri->segment(4);
		$inv_no = $this->uri->segment(5);
		$data['datalist']=$this->invoice_model->search_payment_list($sup_code,$inv_no);
		$this->load->view('accounts/invoice/invoice_payment_search',$data);

	}
	//End of Ticket No:3440

	public function make_payment()
	{
		
		$id=$this->invoice_model->make_payment();
		
		$this->session->set_flashdata('msg', 'Invoice Payment  Successfully Inserted ');
		$this->logger->write_message("success", 'Invoice Payment  successfully Inserted');
		redirect("accounts/invoice/add_payment");
	}
	function delete_payment()
	{
		if ( ! check_access('delete invoice payments'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
		$id=$this->invoice_model->delete_payment($this->uri->segment(4));
		
		$this->session->set_flashdata('msg', 'Invoice Payment  Successfully Deleted ');
		$this->logger->write_message("success", 'Invoice Payment  successfully Deleted');
		redirect("accounts/invoice/add_payment");
	}
	function confirm_payment()
	{
		if ( ! check_access('confirm invoice payments'))
        {
            //$this->messages->add('Permission denied.', 'error');
            $this->session->set_flashdata('error', 'Permission Denied');
            redirect('user');
            return;
        }
		$id=$this->invoice_model->confirm_payment($this->uri->segment(4));
		
		$this->session->set_flashdata('msg', 'Invoice Payment  Successfully Deleted ');
		$this->logger->write_message("success", 'Invoice Payment  successfully Deleted');
		redirect("accounts/invoice/add_payment");
	}
	function reports()
	{
		$data=NULL;
		
		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
		$data['datalist']=$inventory=NULL;
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
				
				$courseSelectList="";
				 $count=0;
				 	$data['prjlist']=$this->project_model->get_all_project_summery($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/invoice/invoice_main';
				
				
				$data['tag']='Search Document Types';
		
		$this->load->view('accounts/invoice/invoice_report_main',$data);
	}
	function report_data()
	{
		$data=NULL;
		
		$data['list']=$list=$this->uri->segment(4);
		$data['mylist']=$mylist='test';
		$data['datalist']=$inventory=NULL;
		$data['branchlist']=$inventory=$this->branch_model->get_all_branches_summery();
		$data['suplist']=$this->supplier_model->get_all_supplier_summery();
				
				$courseSelectList="";
				 $count=0;
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='accounts/invoice/invoice_main';
				$data['tag']='Search Document Types';
			$type=$this->input->post('rpt_type');
			$sup_code=$this->input->post('sup_code');
			$fromdate=$this->input->post('fromdate');
			$todate=$this->input->post('todate');
			if($type=='01')
			{
					$data['datalist']=$this->invoice_model->get_oustanding_list($sup_code,$fromdate,$todate);
						$data['lastq'] =$this->db->last_query();
					$this->load->view('accounts/invoice/invoice_report_out',$data);
			}
			if($type=='02')
			{
					$data['datalist']=$this->invoice_model->get_payment_data($sup_code,$fromdate,$todate);
						$data['lastq'] =$this->db->last_query();
					$this->load->view('accounts/invoice/invoice_report_payment',$data);
			}
			
		
		
	}
	function supplier_outstanding_excel()
	{
		$query = $this->db->query($this->input->post('lastq')); 
		$data['datalist']=$query->result(); 
			$data['lastq'] =$this->db->last_query();
			$this->load->view('accounts/invoice/invoice_report_out_excel',$data);
	}
	
	function get_retention_total_by_id(){
		if($retention = $this->invoice_model->get_retention_total_by_id($this->input->post('id'))){
			echo $retention;
		}
	}
	
	function check_pending_payments_by_invoiceid(){
		if($this->invoice_model->check_pending_payments_by_invoiceid($this->input->post('id'))){
			echo 'Yes';
		}
	}
	
	function check_project_invoice(){
		if($this->invoice_model->check_project_invoice($this->input->post('id'))){
			echo 'Yes';
		}
	}
	
	function get_invoices_by_projectid(){
		if($inv_data = $this->invoice_model->get_invoices_by_projectid($this->input->post('id'))){
			foreach($inv_data as $dataraw){
				 echo '<option value="'.$dataraw->id.'-'.$dataraw->totpay.'-'.$dataraw->total.'-'.$dataraw->retention_amount.'" >'.$dataraw->inv_no.' - '.number_format($dataraw->total,2).' - '.$dataraw->first_name.' '.$dataraw->last_name.'</option>';
			}
		}
	}
	
	function printinterim($inv_id){
		if ( ! check_access('print interim'))
        {
            $this->session->set_flashdata('error', 'Permission denied.');
            redirect('user');
            return;
        }
		$data['invoice'] = $invoice = $this->invoice_model->get_invoice_by_id($inv_id);
		$data['project'] = $this->project_model->get_project_bycode($invoice->prj_id);
		$data['tot_confirmed_payments'] = $this->invoice_model->get_tot_confirmed_payments($inv_id);
		$data['tot_pending_payments'] = $this->invoice_model->get_tot_pending_payments($inv_id);
		$this->load->view('accounts/invoice/print_interim', $data);

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */