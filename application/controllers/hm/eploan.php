<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Eploan extends CI_Controller {

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
		
		$this->load->model("hm_reservation_model");
		$this->load->model("common_model");
		$this->load->model("hm_project_model");
		$this->load->model("hm_salesmen_model");
		$this->load->model("customer_model");
		$this->load->model("hm_lotdata_model");
		$this->load->model("hm_dplevels_model");
		$this->load->model("branch_model");
		$this->load->model("reciept_model");
		$this->load->model("hm_eploan_model");
			
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home');
			return;
		}
		redirect('hm/eploan/showall');
		
		
		
	}

	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
		$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
		 	if($this->session->userdata('usertype')=='Sales_officer')
			{
					 $data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
					 $data['datalist']=$this->hm_eploan_model->get_all_reservation_eploan_officer($pagination_counter,$page_count,$this->session->userdata('userid'));
			}
			else
			{
				$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery_all($this->session->userdata('branchid'));
				$data['datalist']=$this->hm_eploan_model->get_all_reservation_eploan_all($pagination_counter,$page_count,$this->session->userdata('branchid'));
				
			}
				
				 foreach($inventory as $c)
      			 {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->loan_code.'">'.$c->loan_code . '- ' .$c->id_number .'- ' .$c->last_name .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$siteurl='hm/eploan/showall';
				$tablename='hm_eploan';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/eploan/loan_list',$data);
		
		
		
	}
	
	public function loan_inquarymain()
	{
		$data=NULL;
		if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
		$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
		 	if($this->session->userdata('usertype')=='Sales_officer')
			{
					 $data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
					 $data['datalist']=$this->hm_eploan_model->get_all_reservation_eploan_officer($pagination_counter,$page_count,$this->session->userdata('userid'));
					 $data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
			}
			else
			{
				$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery_all($this->session->userdata('branchid'));
				$data['datalist']=$this->hm_eploan_model->get_all_reservation_eploan_all($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
			}
				
				 foreach($inventory as $c)
      			 {               
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->loan_code.'">'.$c->loan_code . '- ' .$c->id_number .'- ' .$c->last_name .'</option>';
           			 $count++;           
       			 }
				$data['searchlist']=$courseSelectList;
				$siteurl='hm/reservaation/showall';
				$tablename='hm_eploan';
				$this->pagination($page_count,$siteurl,$tablename);
	
				$this->load->view('hm/eploan/loan_inquarymain',$data);
		
		
		
	}
function monthly_rental()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
			if($this->session->userdata('usertype')=='Sales_officer')
			{
					  $data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
			}
			else
			{
				$data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
					
			}
			$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
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
				
				$data['followlist']=$this->hm_eploan_model->get_followups();
	
			$this->load->view('hm/eploan/monthly_rental',$data);
}

function get_rentalpaydata()
{
	$data['paydate']=$paydate=$this->uri->segment(5);
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),$paydate);
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($loan_data->loan_type);
	if($loan_data->loan_type!='EPB')
	$this->load->view('hm/eploan/rentaldata',$data);
	else
	{
		$data['paylist']=$this->hm_eploan_model->get_paid_list_epb($this->uri->segment(4));
		$data['dipayment']=$this->hm_eploan_model->get_thismonth_payment_di($this->uri->segment(4));
		$this->load->view('hm/eploan/rentaldata_epb',$data);
	}
	
}

function pay_rental()
{
	if ( ! check_access('add_loanpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->input->post('loan_code'));
	if($loan_data->loan_type!='EPB')
	$entry=$this->hm_eploan_model->rental_payment();
	else
	$entry=$this->hm_eploan_model->rental_payment_epb();
	if($entry)
	{
		$this->session->set_flashdata('msg', $this->input->post('loan_code').'Instalment successfully Inserted');
		$this->logger->write_message("success", $this->input->post('loan_code').'  Loan successfully Confirmed');
	}
	else
		{
			$this->session->set_flashdata('error', 'Error Addin Instalment ');
		}
	redirect("hm/eploan");
}
function get_loanfulldata()
{
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->hm_eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->hm_eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
	$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->hm_eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($loan_data->loan_type);
		$data['paylistinq_old']=$this->hm_eploan_model->get_paid_list_inquary_oldloan($this->uri->segment(4));


	$this->load->view('hm/eploan/loanfulldata',$data);
}
function excel_loaninquary()
{
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->hm_eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->hm_eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
	$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->hm_eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($loan_data->loan_type);

	$this->load->view('hm/eploan/loanfulldata_excel',$data);
}
function get_loanfulldata_popup()
{
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->hm_eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->hm_eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
		$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->hm_eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($loan_data->loan_type);
		$data['paylistinq_old']=$this->hm_eploan_model->get_paid_list_inquary_oldloan($this->uri->segment(4));


	$this->load->view('hm/eploan/loanfulldata_popup',$data);
}
function print_loaninquary()
{
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->hm_eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->hm_eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
		$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->hm_eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->hm_eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($loan_data->loan_type);

	$this->load->view('hm/eploan/print_loaninquary',$data);
}
function get_paymenthistory()
{
	$data['details']=$loan_data=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
//	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
	if($loan_data->loan_type=='EPB')
	{
		$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($loan_data->loan_type);
		$data['paylist']=$this->hm_eploan_model->get_paid_list_epb($this->uri->segment(4));
		$this->load->view('hm/eploan/paymenthistory_epb',$data);
	}
	else
		$this->load->view('hm/eploan/paymenthistory',$data);
}
function follow_up()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
			if($this->session->userdata('usertype')=='Sales_officer')
			{
					  $data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
			}
			else
			{
				$data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
					
			}
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
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
				 $data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
	
				$data['followlist']=$this->hm_eploan_model->get_followups();
	
			$this->load->view('hm/eploan/follow_up',$data);
}
function get_followupdata()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),$this->uri->segment(5));
	$data['loanfollow']=$this->hm_eploan_model->get_followups_by_loancode($this->uri->segment(4));
	
	$this->load->view('hm/eploan/followups',$data);
	
}
function get_followupdata_popup()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('y-m-d'));
	$data['loanfollow']=$this->hm_eploan_model->get_followups_by_loancode($this->uri->segment(4));
	$data['searchdate']=date('y-m-d');
	$this->load->view('hm/eploan/followups_popup',$data);
	
}
function add_followups()
{
	
	if ( ! check_access('add_followup'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
	$entry=$this->hm_eploan_model->add_followups();
	if($entry)
	{
		$this->session->set_flashdata('msg', $this->input->post('loan_code_rec').'Followups successfully Inserted');
		$this->logger->write_message("success", $this->input->post('loan_code_rec').'  Followups successfully Inserted');
		
	}
	else
		{
			$this->session->set_flashdata('error', 'Error Addin followups ');
		}
		$this->session->set_flashdata('tab', 'followups');
	redirect("hm/eploan/follow_up");
	
}
function add_followups_popup(){
		//$this->load->model("config_model");
		
		$loancode=$this->input->get('loan_code');
		$date=$this->input->get('date');
		$cus_feedback=$this->input->get('cus_feedback');
		$sales_feedback=$this->input->get('sales_feedback');
		$todate_arreas=$this->input->get('todate_arreas');
		$contact_media=$this->input->get('contact_media');
		$promissed_date=$this->input->get('promissed_date');
		$promissed_amount=$this->input->get('promissed_amount');
	//	echo $loancode;
		$entry=$this->hm_eploan_model->add_followups_popup($loancode,$date,$cus_feedback,$sales_feedback,$todate_arreas,$contact_media,$promissed_date,$promissed_amount);
		echo 'Followups successfully Inserted'.$promissed_amount;
		/*if($entry)
		{
			
			echo "Record Successfully Inserted";
			
			//echo "This record already open ";
		}*/
		//echo "This record already open ";
	//	$data['divisionlist']=$this->config_model->get_division_byzone($zondata->ZONENAME);
		//$this->load->view('manage/common/divisions', $data);
	}
function delete_feedback()
{
	$entry=$this->hm_eploan_model->delete_feedback($this->uri->segment(4));
	if($entry)
	{
		$this->session->set_flashdata('msg', 'Followups successfully Deleted');
		$this->logger->write_message("success", ' Followups successfully Deleted');
		
	}
	else
		{
			$this->session->set_flashdata('error', 'Error deleting followups ');
		}
		$this->session->set_flashdata('tab', 'followups');
	redirect("hm/eploan/follow_up");
	
} 
function search()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	
	$this->load->view('hm/eploan/loan_schedule',$data);
	
}
function get_rental()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	
	$this->load->view('hm/eploan/rental_data',$data);
}
	public function confirm_loan()
	{
		if ( ! check_access('confirm_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			return;
		}
		
		$id=$this->hm_reservation_model->confirm_loan($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_eploan',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Loan successfully Confirmed');
		redirect("hm/reservation/eploan");
		
	}

function repayment_schedule()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$this->load->view('hm/reservation/loan_schedule',$data);
}
function reschedule()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
			
				$data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
					
			
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
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
				$data['searchlist']=$courseSelectList;
				$siteurl='hm/reservaation/showall';
				$tablename='hm_epreschedule';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->hm_eploan_model->get_reschedule($pagination_counter,$page_count,$this->session->userdata('branchid'));$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
	
			$this->load->view('hm/eploan/reschedule_main',$data);
}
function get_reschdata()
{
	$data['details']=$resdata=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	//$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
	$data['saletype']=$this->hm_reservation_model->get_purchase_type();
				$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
				$data['typedata']=$this->hm_eploan_model->get_saletype_by_type($resdata->loan_type);
			
	$this->load->view('hm/eploan/reschedule_data',$data);
}
function add_reschedule()
	{
		if ( ! check_access('add_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_eploan_model->add_reschedule();
		
		$paytype=trim($this->input->post('pay_type'));
		$this->common_model->add_notification('hm_epreschedule',' Loan Reschedule Request','hm/eploan/reschedule',$this->input->post('loan_code'));
		$this->session->set_flashdata('msg', ' Loan Reschedule Request Sent ');
		
		$this->logger->write_message("success", $this->input->post('loan_code').' Loan Reschedule Request Sent');
		
		redirect("hm/eploan/reschedule/");
	}
	function edit_reschedule()
	{
		$data['details']=$resdata=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	//$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
		$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
		$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
		$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
		$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
		$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
		$data['saletype']=$this->hm_reservation_model->get_purchase_type();
		$data['loan_officer']=$this->hm_salesmen_model->get_project_officerlist($resdata->prj_id);
		$data['reschdata']=$this->hm_eploan_model->get_reschedule_data($this->uri->segment(5));
		$this->common_model->add_activeflag('hm_epreschedule',$this->uri->segment(5),'rsch_code');
			
	$this->load->view('hm/eploan/reschedule_editdata',$data);
	}
	function editdata_reschedule()
	{
		if ( ! check_access('edit_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedule');
			
			return;
		}
		$id=$this->hm_eploan_model->edit_reschedule();
		
		
		$this->session->set_flashdata('msg', 'Reschedule Details  Successfully Updated ');
		
		$this->common_model->delete_activflag('hm_epreschedule',$this->input->post('rsch_code'),'rsch_code');
		$this->logger->write_message("success", $this->input->post('rsch_code').' Reschedule Details  Updated');
		redirect("hm/eploan/reschedule");
		
	}
	public function delete_reschedule()
	{
		if ( ! check_access('delete_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedulel');
			return;
		}
		$id=$this->hm_eploan_model->delete_reschedule($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_epreschedule',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Reshedule Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reshedule id successfully Deleted');
		redirect("hm/eploan/reschedule");
		
	}
	public function confirm_reshedule()
	{
		if ( ! check_access('confirm_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedulel');
			return;
		}
		$id=$this->hm_eploan_model->confirm_reshedule($this->uri->segment(4));
		$reschdata=$this->hm_eploan_model->get_reschedule_data($this->uri->segment(4));
		$this->common_model->delete_notification('hm_epreschedule',$reschdata->loan_code);
			create_letter($reschdata->branch_code,$reschdata->cus_code,$reschdata->res_code,$reschdata->loan_code,'','02',$msg,$reschdata->new_cap);
		$this->session->set_flashdata('msg', 'Loan Reshedule Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reshedule id successfully Confirmed');
		redirect("hm/eploan/reschedule");
		
	}
function rebate()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
			
				$data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
					
			
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
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
				$data['searchlist']=$courseSelectList;
				$siteurl='hm/eploan/rebate';
				$tablename='hm_eprebate';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->hm_eploan_model->get_rebate($pagination_counter,$page_count,$this->session->userdata('branchid'));
			$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				$this->load->view('hm/eploan/rebate_main',$data);
}
function get_rebatedata()
{
	$data['details']=$resdata=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	if($resdata->loan_type!='EPB')
	{
	//$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
			
	$this->load->view('hm/eploan/rebate_data',$data);
	}
	else
	echo "You cant use this process for bank loans";
}
function add_rebate()
	{
		if ( ! check_access('add_rebate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/reservation/showall');
			
			return;
		}
	
		$id=$this->hm_eploan_model->add_rebate();
		
		$paytype=trim($this->input->post('pay_type'));
		if(floatval($this->input->post('int_paidrate'))>90)
		$this->common_model->add_notification('hm_eprebate',' Loan Settlement Request','hm/eploan/rebate',$id);
		
		$this->session->set_flashdata('msg', ' Loan Settlement Request Sent ');
		$this->logger->write_message("success", $this->input->post('loan_code').' Loan Settlement Request Sent');
		
		redirect("hm/eploan/rebate/");
	}
	function delete_rebate()
	{
		if ( ! check_access('delete_rebate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedulel');
			return;
		}
		$id=$this->hm_eploan_model->delete_rebate($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_eprebate',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Settlement Request Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Settlement Request successfully Deleted');
		redirect("hm/eploan/rebate");
	}
	function confirm_rebate()
	{
		if ( ! check_access('confirm_rebate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedulel');
			return;
		}
		$id=$this->hm_eploan_model->confirm_rebate($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_eprebate',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Settlement Request Confirmed');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Settlement Request successfully Confirmed');
		redirect("hm/eploan/rebate");
	}
function get_resaledata()
{
	$data['details']=$resdata=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['resdetails']=$this->hm_reservation_model->get_all_reservation_details_bycode($resdata->res_code);
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
			
	$this->load->view('hm/eploan/resale_data',$data);
}
function resale()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/home/');
			return;
		}
			
				$data['loanlist']=$data['searchdata']=$inventory=$this->hm_eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));
					
			
				$courseSelectList="";
				 $count=0;
		
				$data['searchpath']='hm/eploan/search';
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
				$data['searchlist']=$courseSelectList;
				$siteurl='hm/eploan/resale';
				$tablename='hm_epresale';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->hm_eploan_model->get_resale($pagination_counter,$page_count,$this->session->userdata('branchid'));
			$data['prjlist']=$this->hm_salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				$this->load->view('hm/eploan/resale_main',$data);
}
function add_resale()
	{
		if ( ! check_access('add_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/showall');
			
			return;
		}
	
		$id=$this->hm_eploan_model->add_resale();
		
		$this->common_model->add_notification('hm_epresale',' Loan Reprocess Request','hm/eploan/resale',$id);
		
		$this->session->set_flashdata('msg', ' Loan Reprocess Request Sent ');
		$this->logger->write_message("success", $this->input->post('loan_code').' Loan Reprocess Request Sent');
		
		redirect("hm/eploan/resale/");
	}
	function delete_resale()
	{
		if ( ! check_access('delete_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedulel');
			return;
		}
		$id=$this->hm_eploan_model->delete_resale($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_epresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Reprocess Request Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reprocess Request successfully Deleted');
		redirect("hm/eploan/resale");
	}
	function edit_resale()
	{
		$data['details']=$resdata=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['resdetails']=$this->hm_reservation_model->get_all_reservation_details_bycode($resdata->res_code);
	$data['totset']=$this->hm_eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->hm_eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->hm_eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->hm_eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->hm_eploan_model->get_paid_list($this->uri->segment(4));
		$data['relsaledata']=$this->hm_eploan_model->get_resale_bycode($this->uri->segment(5));
		$this->common_model->add_activeflag('hm_epresale',$this->uri->segment(5),'resale_code');
			
	$this->load->view('hm/eploan/resale_editdata',$data);
	}
	function editdata_resale()
	{
		if ( ! check_access('edit_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedule');
			
			return;
		}
		$id=$this->hm_eploan_model->edit_resale();
		
		
		$this->session->set_flashdata('msg', 'Reprocess Details  Successfully Updated ');
		
		$this->common_model->delete_activflag('hm_epresale',$this->input->post('resale_code'),'resale_code');
		$this->logger->write_message("success", $this->input->post('resale_code').' Reprocess Details  Updated');
		redirect("hm/eploan/resale");
		
	}
	function confirm_resale()
	{
		if ( ! check_access('confirm_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/eploan/reschedulel');
			return;
		}
		$id=$this->hm_eploan_model->confirm_resale($this->uri->segment(4));
		
		$this->common_model->delete_notification('hm_epresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Reprocess Request Confirmed');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reprocess Request successfully Confirmed');
		redirect("hm/eploan/resale");
	}
	
	// aditional search deta for loan quaries
	function get_blocklist()
	{
		$data['lotlist']=$this->hm_lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('hm/eploan/blocklist',$data);
		
	}
	function get_lot_loan()
	{
		$data['loanlist']=$this->hm_eploan_model->get_eploan_data_lot_id($this->uri->segment(4));
		$this->load->view('hm/eploan/lot_loanlist',$data);
		
	}
	function get_project_loan()
	{
		$data['loanlist']=$this->hm_eploan_model->get_eploan_data_project($this->uri->segment(4));
		$this->load->view('hm/eploan/lot_loanlist',$data);
		
	}
	 
function print_repayment_schedule()
{
	$data['details']=$this->hm_eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->hm_eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$this->load->view('hm/eploan/print_loan_schedule',$data);
}
	function get_followup_print()
{
		
	$data['followlist']=$this->hm_eploan_model->get_followups_by_loancode($this->uri->segment(4));
	
	$this->load->view('hm/eploan/followups_print',$data);
	
}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */