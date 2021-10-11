<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashier extends CI_Controller {

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
		$this->load->model("banktrn_model");
		
		
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

	function monthly_rental()
{
	if ( ! check_access('add_loanpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}
			if($this->session->userdata('usertype')=='Sales_officer')
			{
					  $data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
			}
			else
			{
				$data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
					
			}
			$data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='re/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				 foreach($inventory as $c)
      			 {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->loan_code.'">'.$c->loan_code . '- ' .$c->id_number .'- ' .$c->last_name .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				
				$data['followlist']=$this->eploan_model->get_followups();
	
			$this->load->view('accounts/cashier/monthly_rental',$data);
}
function get_rentalpaydata()
{
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);
	if($loan_data->loan_type!='EPB')
	$this->load->view('accounts/cashier/rentaldata',$data);
	else
	{
		$data['paylist']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
		$this->load->view('accounts/cashier/rentaldata_epb',$data);
	}
	
}

function pay_rental()
{
	if ( ! check_access('add_loanpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->input->post('loan_code'));
	if($loan_data->loan_type!='EPB')
	$entry=$this->eploan_model->rental_payment();
	else
	$entry=$this->eploan_model->rental_payment_epb();
	if($entry)
	{
		$this->session->set_flashdata('msg', $this->input->post('loan_code').'Instalment successfully Inserted');
		$this->logger->write_message("success", $this->input->post('loan_code').'  Loan successfully Confirmed');
	}
	else
		{
			$this->session->set_flashdata('error', 'Error Addin Instalment ');
		}
	redirect("accounts/income/add/".$entry);
}
public function showall_reservation()
	{
		$data=NULL;
		if ( ! check_access('add_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/');
			return;
		}
		$data['searchdata']=$inventory=$this->reservation_model->get_all_reservation_summery($this->session->userdata('branchid'));
				$courseSelectList="";
				 $count=0;
				foreach($inventory as $c)
      			  {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->res_code.'">'.$c->res_code .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='re/customer/search';
				$data['tag']='Search customer';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
				$data['datalist']=$this->reservation_model->get_all_reservation_details($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$siteurl='re/reservaation/showall';
				$tablename='re_resevation';
				$statusfield='res_status';
				$status='COMPLETE';
				$this->pagination_status($page_count,$siteurl,$tablename,$statusfield,$status);
				$this->load->view('accounts/cashier/reservation_list',$data);
		
		
		
	}
	function get_advancedata()
	{			$res_code=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['saledata']=$this->reservation_model->get_advance_data($res_code);
				$this->load->view('accounts/cashier/advance_data',$data);
	}
	function add_advance()
	{
		if ( ! check_access('add_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/showall_reservation');
			
			return;
		}
	
		$id=$this->reservation_model->add_advance();
		
		
		$this->session->set_flashdata('msg', 'Advance payment successfully Inserted ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		//redirect("re/reservation/showall/");
		redirect("accounts/income/add/".$id);
	}
	function delete_advance()
	{
		if ( ! check_access('delete_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}
		$id=$this->reservation_model->delete_advance($this->uri->segment(4));
				$this->session->set_flashdata('msg', 'advance payment Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance payment  successfully Deleted');
		redirect("re/reservation/showall");
	}
	//reservation charges module
	public function reservation_charges()
	{
		$data=NULL;
		if ( ! check_access('add_charge_payments'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/');
			return;
		}
		$data['searchdata']=$inventory=$this->reservation_model->get_charge_list($this->session->userdata('branchid'));
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
				$this->load->view('accounts/cashier/reservation_charges',$data);
		
		
		
	}
	function get_chargedata()
	{			$res_code=$this->uri->segment(5);
				$data['charge_type']=$this->uri->segment(4);
				$data['resdata']=$resdata=$this->reservation_model->get_all_reservation_details_bycode($res_code);
				$data['charge_data']=$this->reservation_model->get_charge_data($res_code);
				$data['charge_payment']=$this->reservation_model->get_charge_payments($res_code);
				
				$this->load->view('accounts/cashier/charge_data',$data);
	}
	function add_charges()
	{
			if ( ! check_access('add_charge_payments'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/showall_reservation');
			
			return;
		}
	
		$id=$this->reservation_model->add_charge_payments();
		
		
		$this->session->set_flashdata('msg', 'Advance payment successfully Inserted ');
		
		$this->logger->write_message("success", $this->input->post('res_code').' Advance payment successfully Inserted');
		//redirect("re/reservation/showall/");
		redirect("accounts/income/add/".$id);
	}
	function delete_charge()
	{
		if ( ! check_access('delete_advance'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/cashier/reservation_charges');
			return;
		}
		$id=$this->reservation_model->delete_charge_payment($this->uri->segment(4));
				$this->session->set_flashdata('msg', 'advance payment Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Advance payment  successfully Deleted');
		redirect("accounts/cashier/reservation_charges");
	}
	function banktransfers()
	{
		if ( ! check_access('view_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
			
			$data['searchdata']=$inventory=$this->branch_model->get_all_branches_summery();
				$courseSelectList="";
				 $count=0;
		$data['searchlist']=NULL;
				$data['searchpath']='re/customer/search';
				$data['searchpath']='re/eploan/search';
				 $data['ac_incomes']=$this->banktrn_model->get_bank_trnlist($this->session->userdata('branchid'));
				$data['searchlist']=$courseSelectList;
				$data['banks']=$this->ledger_model->get_all_ac_ledgers_tomake_payment();
				
				
			$this->load->view('accounts/banktrn/banktrn_main',$data);
	}
	
	function search_banktrn()
	{
	if ( ! check_access('add_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
		 $data['ac_incomes']=$this->banktrn_model->search_bank_trnlist($this->uri->segment(4));
		 $this->load->view('accounts/banktrn/banktrn_search',$data);
	}
	function search_branch_income()
	{
	if ( ! check_access('add_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
		$data['ac_incomes']='';
		$data['ac_incomes']=$this->banktrn_model->get_pending_trnlist($this->uri->segment(4));
		 //$this->load->view('accounts/banktrn/banktrn_search',$data);
	//	 
		 $this->load->view('accounts/banktrn/search_branch_income',$data);
	}
	function transfer_list()
	{
		
		if ( ! check_access('add_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
		$rowmatcount=$this->input->post('rawmatcount');
		$total_val=$this->input->post('total_val');
		$trndate=$this->input->post('trndate');
		$branch_code=$this->input->post('branch_code');
		$bankname=$this->ledger_model->get_name($this->input->post('banks'));
		$crledger=get_account_set('Advanced Payment');
			$crlist[0]['ledgerid']=$crledger['Dr_account'];
			$crlist[0]['amount']=$crtot=$total_val;
			$drlist[0]['ledgerid']=$this->input->post('banks');
			$drlist[0]['amount']=$drtot=$total_val;
			$narration = ' Cash Deposite - Bank transfer';
			$entry=fundtransfer_entry($crlist,$drlist,$crtot,$drtot,$trndate,$narration);
		for($i=1; $i<=$rowmatcount; $i++)//get selected voucher list
        {
            if($this->input->post('isselect'.$i)=="Yes")
            {	//$counter++;
                $pay_id=$this->input->post('pay_id'.$i);
                $trn_amount=$this->input->post('trnamount_val'.$i);
				$prvtransferd=$this->input->post('transferd'.$i);
				$fullamount=$this->input->post('fullamount'.$i);
				$newtransfer=round($prvtransferd+ $trn_amount,2);
				$newbalance=round($fullamount-$newtransfer,2);
				if($newbalance==0)
				{
					$status='COMPLETE';
				}
				else $status='PROCESSING';
				$this->banktrn_model->add_transfer($branch_code,$pay_id,$bankname,$trn_amount,$entry,$trndate);
				$this->banktrn_model->update_incometable($pay_id,$newtransfer,$newbalance,$status);
               
            }
        }
				$this->session->set_flashdata('msg', 'Cash Successfully Transferd');
		$this->logger->write_message("success", ' Cash Successfully Transferd');
		redirect("accounts/cashier/banktransfers");
	}
	function search_entry()
	{
		if ( ! check_access('add_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
		$data['entry_id']=$this->uri->segment(4);
		 $data['ac_incomes']=$this->banktrn_model->search_entry($this->uri->segment(4));
		 $this->load->view('accounts/banktrn/search_entry',$data);
	}
	function print_entry()
	{
		if ( ! check_access('add_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
		$data['entry_id']=$this->uri->segment(4);
		 $data['ac_incomes']=$this->banktrn_model->search_entry($this->uri->segment(4));
		 $this->load->view('accounts/banktrn/print_entry',$data);
	}
	function delete_entry()
	{
		if ( ! check_access('add_banktrn'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/home/');
			return;
		}
		$data['entry_id']=$this->uri->segment(4);
		 $data['ac_incomes']=$this->banktrn_model->delete_transfer($this->uri->segment(4));
		 redirect("accounts/cashier/banktransfers");
	}

	/*Ticket No:2943 Added By Madushan 2021.06.21*/
	function search_branch_income_receiptno()
	{
	if ( ! check_access('add_banktrn'))
	 {
		 $this->session->set_flashdata('error', 'Permission Denied');
		 redirect('accounts/home/');
		 return;
	 }
	 $id =  $this->uri->segment(4);
	 $receiptno = $this->uri->segment(5);
	 $data['ac_incomes']='';
	 $data['ac_incomes']=$this->banktrn_model->get_pending_trnlist_by_receiptno($id,$receiptno);
		//$this->load->view('accounts/banktrn/banktrn_search',$data);
	//
		$this->load->view('accounts/banktrn/search_branch_income',$data);
	}
	/*End of Ticket No:2943*/
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */