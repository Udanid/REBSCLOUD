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
		$this->load->model("employee_model");

		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_eploan'))
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
		if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}
		$courseSelectList="";
				 $count=0;

				$data['searchpath']='re/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
		 	if($this->session->userdata('usertype')=='Sales_officer')
			{
					 $data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
					 $data['datalist']=$this->eploan_model->get_all_reservation_eploan_officer($pagination_counter,$page_count,$this->session->userdata('userid'));
			}
			else
			{
				$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery_all($this->session->userdata('branchid'));
				$data['datalist']=$this->eploan_model->get_all_reservation_eploan_all($pagination_counter,$page_count,$this->session->userdata('branchid'));

			}

				 foreach($inventory as $c)
      			 {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->loan_code.'">'.$c->loan_code . '- ' .$c->id_number .'- ' .$c->last_name .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$siteurl='re/eploan/showall';
				$tablename='re_eploan';
				$this->pagination($page_count,$siteurl,$tablename);

				$this->load->view('re/eploan/loan_list',$data);



	}

	public function loan_inquarymain()
	{
		$data=NULL;
		if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}
		$courseSelectList="";
				 $count=0;

				$data['searchpath']='re/eploan/search';
				$data['tag']='Search eploan';
				$data['banklist']=$this->common_model->getbanklist();
				$pagination_counter =RAW_COUNT;
				$page_count = (int)$this->uri->segment(4);
					if ( !$page_count)
					$page_count = 0;
		 	if($this->session->userdata('usertype')=='Sales_officer')
			{
					 $data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
					 $data['datalist']=$this->eploan_model->get_all_reservation_eploan_officer($pagination_counter,$page_count,$this->session->userdata('userid'));
					 $data['prjlist']=$this->salesmen_model->get_all_projectlist_inquary($this->session->userdata('userid'));
			}
			else
			{
				$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery_all($this->session->userdata('branchid'));
				$data['datalist']=$this->eploan_model->get_all_reservation_eploan_all($pagination_counter,$page_count,$this->session->userdata('branchid'));
				$data['prjlist']=$this->salesmen_model->get_all_projectlist_inquary($this->session->userdata('userid'));
			}

				 foreach($inventory as $c)
      			 {
           			 $courseSelectList .= '<option id="select"'.$count.' value="'.$c->loan_code.'">'.$c->loan_code . '- ' .$c->id_number .'- ' .$c->last_name .'</option>';
           			 $count++;
       			 }
				$data['searchlist']=$courseSelectList;
				$siteurl='re/reservaation/showall';
				$tablename='re_eploan';
				$this->pagination($page_count,$siteurl,$tablename);

				$this->load->view('re/eploan/loan_inquarymain',$data);



	}
function monthly_rental()
{
	if ( ! check_access('view_eploan'))
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

			$this->load->view('re/eploan/monthly_rental',$data);
}

function get_rentalpaydata()
{
	$data['paydate']=$paydate=$this->uri->segment(5);
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),$paydate);
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);
	if($loan_data->loan_type!='EPB')
	$this->load->view('re/eploan/rentaldata',$data);
	else
	{
		$data['paylist']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
		$data['dipayment']=$this->eploan_model->get_thismonth_payment_di($this->uri->segment(4));
		$this->load->view('re/eploan/rentaldata_epb',$data);
	}

}

function pay_rental()
{
	if ( ! check_access('add_loanpayment'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
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
	redirect("re/eploan");
}
function get_loanfulldata()
{
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
	$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);
		$data['paylistinq_old']=$this->eploan_model->get_paid_list_inquary_oldloan($this->uri->segment(4));


	$this->load->view('re/eploan/loanfulldata',$data);
}
function excel_loaninquary()
{
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
	$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);

	$this->load->view('re/eploan/loanfulldata_excel',$data);
}
function get_loanfulldata_popup()
{
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
		$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);
		$data['paylistinq_old']=$this->eploan_model->get_paid_list_inquary_oldloan($this->uri->segment(4));


	$this->load->view('re/eploan/loanfulldata_popup',$data);
}
function print_loaninquary()
{
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['rshceduls']=false;
	$data['rebate']=false;
	if($loan_data->reschdue_sqn!='000')
	$data['rshceduls']=$this->eploan_model->get_reshedule_details($this->uri->segment(4));;
	if($loan_data->loan_status=='SETTLED')
	$data['rebate']=$this->eploan_model->get_rebate_by_loancode($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	if($loan_data->loan_type!='EPB')
	{
		$data['paylist_epb']=NULL;
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
		$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	else{
		$data['paylistinq']=NULL;
		$data['paylist']=NULL;
	$data['paylist_epb']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
	$data['paylistinq']=$this->eploan_model->get_paid_list_inquary($this->uri->segment(4));
	}
	$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);

	  $data['dataset']=$shedule=$this->eploan_model->get_repayment_shedeule_ledger_card($this->uri->segment(4),$loan_data->reschdue_sqn);
	  $dataarr=NULL;
	  if($shedule)
	  {
		  $fromdate=$loan_data->start_date;
		  $fromdate=date('Y-m-d',strtotime('-1 months',strtotime($fromdate)));
		  foreach($shedule as $raw)
		  {
			  $getdate=$raw->deu_date;
			  if($raw->instalment=='1')
			  {
				  $getdate=$loan_data->start_date;
			  }
			  //update by nadee ticket number 1224
			  //update by udani  ticket number1323
			  $nextinst=$raw->instalment+1;
			  $todate=$this->eploan_model->get_next_due_date($this->uri->segment(4),$nextinst);
			  if($todate=='')
			  $todate=date('Y-m-d',strtotime('+1 months',strtotime($raw->deu_date)));
			  $dataarr[$raw->instalment]=$this->eploan_model->get_paid_list_Period($this->uri->segment(4),$getdate,$todate);

		  }
	  }
	  $data['paydata']=$dataarr;

	$this->load->view('re/eploan/print_loaninquary',$data);
}
function get_paymenthistory()
{
	$data['details']=$loan_data=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
//	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
	if($loan_data->loan_type=='EPB')
	{
		$data['typedata']=$this->eploan_model->get_saletype_by_type($loan_data->loan_type);
		$data['paylist']=$this->eploan_model->get_paid_list_epb($this->uri->segment(4));
		$this->load->view('re/eploan/paymenthistory_epb',$data);
	}
	else
		$this->load->view('re/eploan/paymenthistory',$data);
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
					  $data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery_officer($this->session->userdata('userid'));
			}
			else
			{
				$data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));

			}
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
				 $data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));

				$data['followlist']=$this->eploan_model->get_followups();

			$this->load->view('re/eploan/follow_up',$data);
}
function get_followupdata()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),$this->uri->segment(5));
	//Madushan
	$data['banklist']=$this->common_model->getbanklist();
	$data['emp_list']=$this->employee_model->get_employee_list();
	$data['loanfollow']=$this->eploan_model->get_followups_by_loancode($this->uri->segment(4));

	$this->load->view('re/eploan/followups',$data);

}


function get_followupdata_popup()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('y-m-d'));
	$data['loanfollow']=$this->eploan_model->get_followups_by_loancode($this->uri->segment(4));
	$data['searchdate']=date('y-m-d');
	$this->load->view('re/eploan/followups_popup',$data);

}
function add_followups()
{

	if ( ! check_access('add_followup'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
	$entry=$this->eploan_model->add_followups();
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
	redirect("re/eploan/follow_up");

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
		$entry=$this->eploan_model->add_followups_popup($loancode,$date,$cus_feedback,$sales_feedback,$todate_arreas,$contact_media,$promissed_date,$promissed_amount);
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
	$entry=$this->eploan_model->delete_feedback($this->uri->segment(4));
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
	redirect("re/eploan/follow_up");

}
function search()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));

	$this->load->view('re/eploan/loan_schedule',$data);

}
function get_rental()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));

	$this->load->view('re/eploan/rental_data',$data);
}
	public function confirm_loan()
	{
		if ( ! check_access('confirm_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');
			return;
		}

		$id=$this->reservation_model->confirm_loan($this->uri->segment(4));

		$this->common_model->delete_notification('re_eploan',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).'  Loan successfully Confirmed');
		redirect("re/reservation/eploan");

	}

function repayment_schedule()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$this->load->view('re/reservation/loan_schedule',$data);
}
function reschedule()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}

				$data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));


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
				$data['searchlist']=$courseSelectList;
				$siteurl='re/reservaation/showall';
				$tablename='re_epreschedule';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->eploan_model->get_reschedule($pagination_counter,$page_count,$this->session->userdata('branchid'));$data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));

			$this->load->view('re/eploan/reschedule_main',$data);
}
function get_reschdata()
{
	$data['request_date']=$request_date=$this->uri->segment(5);
	//echo $request_date;
	$data['details']=$resdata=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	//$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),$request_date);
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
	$data['saletype']=$this->reservation_model->get_purchase_type();
				$data['loan_officer']=$this->salesmen_model->get_project_officerlist($resdata->prj_id);
				$data['typedata']=$this->eploan_model->get_saletype_by_type($resdata->loan_type);
	//Ticket No:3087 Added By Madushan 2021-07-12
	$fromdate = Date('Y-m').'-01';
	$todate = Date('Y-m').'-31';
	$data['last_payment_date'] = $this->eploan_model->get_last_payment_date_to_date_range($fromdate,$todate,$this->uri->segment(4));

	$this->load->view('re/eploan/reschedule_data',$data);
}
function add_reschedule()
	{
		if ( ! check_access('add_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}

		$id=$this->eploan_model->add_reschedule();

		$paytype=trim($this->input->post('pay_type'));
		$this->common_model->add_notification('re_epreschedule',' Loan Reschedule Request','re/eploan/reschedule',$this->input->post('loan_code'));
		$this->session->set_flashdata('msg', ' Loan Reschedule Request Sent ');

		$this->logger->write_message("success", $this->input->post('loan_code').' Loan Reschedule Request Sent');

		redirect("re/eploan/reschedule/");
	}
	function edit_reschedule()
	{
		$data['details']=$resdata=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	//$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
		$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
		$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
		$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
		$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
		$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
		$data['saletype']=$this->reservation_model->get_purchase_type();
		$data['loan_officer']=$this->salesmen_model->get_project_officerlist($resdata->prj_id);
		$data['reschdata']=$this->eploan_model->get_reschedule_data($this->uri->segment(5));
		$this->common_model->add_activeflag('re_epreschedule',$this->uri->segment(5),'rsch_code');

	$this->load->view('re/eploan/reschedule_editdata',$data);
	}
	function editdata_reschedule()
	{
		if ( ! check_access('edit_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedule');

			return;
		}
		$id=$this->eploan_model->edit_reschedule();


		$this->session->set_flashdata('msg', 'Reschedule Details  Successfully Updated ');

		$this->common_model->delete_activflag('re_epreschedule',$this->input->post('rsch_code'),'rsch_code');
		$this->logger->write_message("success", $this->input->post('rsch_code').' Reschedule Details  Updated');
		redirect("re/eploan/reschedule");

	}
	public function delete_reschedule()
	{
		if ( ! check_access('delete_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedulel');
			return;
		}
		$id=$this->eploan_model->delete_reschedule($this->uri->segment(4));

		$this->common_model->delete_notification('re_epreschedule',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Reshedule Successfully Deleted ');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reshedule id successfully Deleted');
		redirect("re/eploan/reschedule");

	}
	public function confirm_reshedule()
	{
		if ( ! check_access('confirm_reschedule'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedulel');
			return;
		}
		$id=$this->eploan_model->confirm_reshedule($this->uri->segment(4));
		$reschdata=$this->eploan_model->get_reschedule_data($this->uri->segment(4));
		$this->common_model->delete_notification('re_epreschedule',$reschdata->loan_code);
			create_letter($reschdata->branch_code,$reschdata->cus_code,$reschdata->res_code,$reschdata->loan_code,'','02',$msg,$reschdata->new_cap);
		$this->session->set_flashdata('msg', 'Loan Reshedule Successfully Confirmed ');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reshedule id successfully Confirmed');
		redirect("re/eploan/reschedule");

	}
function rebate()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}

				$data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));


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
				$data['searchlist']=$courseSelectList;
				$siteurl='re/eploan/rebate';
				$tablename='re_eprebate';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->eploan_model->get_rebate($pagination_counter,$page_count,$this->session->userdata('branchid'));
			$data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				$this->load->view('re/eploan/rebate_main',$data);
}
function get_rebatedata()
{
	$data['request_date']=$request_date=$this->uri->segment(5);

	$data['details']=$resdata=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	if($resdata->loan_type!='EPB')
	{
	//$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),$request_date);
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));

	$this->load->view('re/eploan/rebate_data',$data);
	}
	else
	{	
		//2021-08-05 Ticket 3250 Madushan
		$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
		$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
		$this->load->view('re/eploan/rebate_data_epb',$data);
	}
	//echo "You cant use this process for bank loans";
}
function add_rebate()
	{
		if ( ! check_access('add_rebate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/reservation/showall');

			return;
		}

		$id=$this->eploan_model->add_rebate();

		$paytype=trim($this->input->post('pay_type'));
		if(floatval($this->input->post('int_paidrate'))>90)
		$this->common_model->add_notification('re_eprebate',' Loan Settlement Request','re/eploan/rebate',$id);

		$this->session->set_flashdata('msg', ' Loan Settlement Request Sent ');
		$this->logger->write_message("success", $this->input->post('loan_code').' Loan Settlement Request Sent');

		redirect("re/eploan/rebate/");
	}
	function delete_rebate()
	{
		if ( ! check_access('delete_rebate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedulel');
			return;
		}
		$id=$this->eploan_model->delete_rebate($this->uri->segment(4));

		$this->common_model->delete_notification('re_eprebate',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Settlement Request Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Settlement Request successfully Deleted');
		redirect("re/eploan/rebate");
	}
	function confirm_rebate()
	{
		if ( ! check_access('confirm_rebate'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedulel');
			return;
		}
		$id=$this->eploan_model->confirm_rebate($this->uri->segment(4));

		$this->common_model->delete_notification('re_eprebate',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Settlement Request Confirmed');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Settlement Request successfully Confirmed');
		redirect("re/eploan/rebate");
	}
function get_resaledata()
{
	$data['request_date']=$request_date=$this->uri->segment(5);

	$data['details']=$resdata=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['resdetails']=$this->reservation_model->get_all_reservation_details_bycode($resdata->res_code);
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),$request_date);
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));

	$this->load->view('re/eploan/resale_data',$data);
}
function resale()
{
	if ( ! check_access('view_eploan'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/home/');
			return;
		}

				$data['loanlist']=$data['searchdata']=$inventory=$this->eploan_model->get_all_reservation_eploan_summery($this->session->userdata('branchid'));


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
				$data['searchlist']=$courseSelectList;
				$siteurl='re/eploan/resale';
				$tablename='re_epresale';
				$this->pagination($page_count,$siteurl,$tablename);
				$data['datalist']=$this->eploan_model->get_resale($pagination_counter,$page_count,$this->session->userdata('branchid'));
			$data['prjlist']=$this->salesmen_model->get_all_projectlist($this->session->userdata('userid'));
				$this->load->view('re/eploan/resale_main',$data);
}
function add_resale()
	{
		if ( ! check_access('add_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/showall');

			return;
		}
		///image upload added by nadee 2020-09-16//
		$file_name="";
				$config['upload_path'] = 'uploads/resale/documents/';
								$config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc';
								$config['max_size'] = '3500';

								$this->load->library('image_lib');
								$this->load->library('upload', $config);
						$this->upload->do_upload('documents');
							$error = $this->upload->display_errors();

							$image_data = $this->upload->data();
				$documents="";
							//$this->session->set_flashdata('error',  $error );
				if($error=="")
							$documents = $image_data['file_name'];
				else
				$this->session->set_flashdata('error',  $error );
		///image upload added by nadee 2020-09-16 end//

		$id=$this->eploan_model->add_resale($documents);

		$this->common_model->add_notification('re_epresale',' Loan Reprocess Request','re/eploan/resale',$id);

		$this->session->set_flashdata('msg', ' Loan Reprocess Request Sent ');
		$this->logger->write_message("success", $this->input->post('loan_code').' Loan Reprocess Request Sent');

		redirect("re/eploan/resale/");
	}
	function delete_resale()
	{
		if ( ! check_access('delete_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedulel');
			return;
		}
		$id=$this->eploan_model->delete_resale($this->uri->segment(4));

		$this->common_model->delete_notification('re_epresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Reprocess Request Deleted');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reprocess Request successfully Deleted');
		redirect("re/eploan/resale");
	}
	function edit_resale()
	{
		$data['details']=$resdata=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['resdetails']=$this->reservation_model->get_all_reservation_details_bycode($resdata->res_code);
	$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_arrias_instalments($this->uri->segment(4),date('Y-m-d'));
	$data['totint']=$this->eploan_model->get_int_total($this->uri->segment(4));
	$data['currentins']=$this->eploan_model->get_current_instalment($this->uri->segment(4));
	$data['paylist']=$this->eploan_model->get_paid_list($this->uri->segment(4));
		$data['relsaledata']=$this->eploan_model->get_resale_bycode($this->uri->segment(5));
		$this->common_model->add_activeflag('re_epresale',$this->uri->segment(5),'resale_code');

	$this->load->view('re/eploan/resale_editdata',$data);
	}
	function editdata_resale()
	{
		if ( ! check_access('edit_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedule');

			return;
		}
		$id=$this->eploan_model->edit_resale();


		$this->session->set_flashdata('msg', 'Reprocess Details  Successfully Updated ');

		$this->common_model->delete_activflag('re_epresale',$this->input->post('resale_code'),'resale_code');
		$this->logger->write_message("success", $this->input->post('resale_code').' Reprocess Details  Updated');
		redirect("re/eploan/resale");

	}
	function confirm_resale()
	{
		if ( ! check_access('confirm_resale'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/eploan/reschedulel');
			return;
		}
		$id=$this->eploan_model->confirm_resale($this->uri->segment(4));

		$this->common_model->delete_notification('re_epresale',$this->uri->segment(4));
		$this->session->set_flashdata('msg', 'Loan Reprocess Request Confirmed');
		$this->logger->write_message("success", $this->uri->segment(4).' Loan Reprocess Request successfully Confirmed');
		redirect("re/eploan/resale");
	}

	// aditional search deta for loan quaries
	function get_blocklist()
	{
		$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
		$this->load->view('re/eploan/blocklist',$data);

	}


	function get_lot_loan()
	{
		$data['loanlist']=$this->eploan_model->get_eploan_data_lot_id($this->uri->segment(4));
		$this->load->view('re/eploan/lot_loanlist',$data);

	}

	function get_lot_loan_inquiry()
	{
		$data['loanlist']=$this->eploan_model->get_eploan_data_lot_id($this->uri->segment(4));
		$this->load->view('re/eploan/lot_loanlist_inquiry',$data);

	}

	//Ticket No:3231 Added By Madushan 2021-08-03
	function get_lot_loan_resale()
	{
		$data['loanlist']=$this->eploan_model->get_eploan_data_lot_id($this->uri->segment(4));
		$this->load->view('re/eploan/lot_loanlist_resale',$data);

	}
	
	function get_project_loan()
	{	
		$data['loanlist']=$this->eploan_model->get_eploan_data_project($this->uri->segment(4));
		$this->load->view('re/eploan/lot_loanlist',$data);

	}

	//Madushan
	function get_project_loan_inquiry()
	{	
		$data['loanlist']=$this->eploan_model->get_eploan_data_project($this->uri->segment(4));
		$this->load->view('re/eploan/lot_loanlist_inquiry',$data);

	}

function print_repayment_schedule()
{
	$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	$data['dataset']=$this->eploan_model->get_repayment_shedeule($this->uri->segment(4));
	$this->load->view('re/eploan/print_loan_schedule',$data);
}
	function get_followup_print()
{

	$data['followlist']=$this->eploan_model->get_followups_by_loancode($this->uri->segment(4));

	$this->load->view('re/eploan/followups_print',$data);

}
function get_ledgercard()//ticket number 521
  {
  	  $loan_code = $this->eploan_model->get_loan_code($this->uri->segment(4));
  	  $data['res_code'] = $this->uri->segment(4);
  	  $dataarr=NULL;
  	  $data['first_payments'] = null;
  	  $data['details'] = null;
  	   $data['dataset'] = null;
  	  if($loan_code)
  	  {
  	  	 $data['details']=$resdata=$this->eploan_model->get_eploan_data($loan_code);
	  	 $data['dataset']=$shedule=$this->eploan_model->get_repayment_shedeule_ledger_card($loan_code,$resdata->reschdue_sqn);

	 /*Ticket No:2817 Added by Madushan 2021.05.12*/
	  $reshedule_first_due_date = $this->eploan_model->get_reshedule_first_due_date($loan_code,$resdata->reschdue_sqn);
		if($reshedule_first_due_date){
			$data['first_payments'] = $this->eploan_model->get_paidlist_before_first_instalment($loan_code,$resdata->reschdue_sqn,$reshedule_first_due_date);


		}

		/*Ticket No:3082 Added By Madushan 2021.07.13*/
		 $reshedule_last_due_date = $this->eploan_model->get_reshedule_last_due_date($loan_code,$resdata->reschdue_sqn);
		 if($reshedule_last_due_date){
			 $reshedule_last_due_date=date('Y-m-d',strtotime('+1 months',strtotime($reshedule_last_due_date)));
			 //updated by nadee ticket 3124
			$data['last_payments'] = $this->eploan_model->get_paidlist_after_last_instalment($loan_code,$resdata->reschdue_sqn,$reshedule_last_due_date);
		}
	  $dataarr=NULL;
	  if($shedule)
	  {
		  $fromdate=$resdata->start_date;
		  $fromdate=date('Y-m-d',strtotime('-1 months',strtotime($fromdate)));
		  foreach($shedule as $raw)
		  {
			  $getdate=$raw->deu_date;
			  //Ticket No:2843 Updated by Madushan 2021.05.17
			  //if($raw->instalment=='1')
			  //{
				 // $getdate=$resdata->start_date;
			  //}
			  //update by nadee ticket number 1224
			  //update by udani  ticket number1323
			  $nextinst=$raw->instalment+1;
			  $todate=$this->eploan_model->get_next_due_date($loan_code,$nextinst);
			  if($todate=='')
			  $todate=date('Y-m-d',strtotime('+1 months',strtotime($raw->deu_date)));
			  $dataarr[$raw->instalment]=$this->eploan_model->get_paid_list_Period($loan_code,$getdate,$todate);

		  }
	  }

	  //Ticket No:3388 Added By Madushan 2021.09.03
	  $data['rebate'] = $this->eploan_model->get_rebate_by_loancode($loan_code);

  	  }

	  /*Ticket No:2889 Added By Madushan 2021.06.15*/
	  $advanceData = NULL;
	  $data['advance_shedule']=$advance_shedule = $this->reservation_model->get_advance_shedule($this->uri->segment(4));
	  if($advance_shedule){
	  	foreach ($advance_shedule as $row) {
	  		if($row->installment_number == 1){
	  			$first_due_date = $row->due_date;
	  			break;
	  		}
	  	}

	  	$data['first_advance_payments'] = $this->eploan_model->get_advance_paidlist_before_first_instalment($this->uri->segment(4),$first_due_date);

		foreach ($advance_shedule as $row){
			 $getdate=$row->due_date;
			 $nextinst=$row->installment_number+1;
			 $todate=$this->eploan_model->get_next_advance_due_date($this->uri->segment(4),$nextinst);
			 if($todate)
			 	 $todate=date('Y-m-d',strtotime('+1 months',strtotime($getdate)));
			 $advanceData[$row->installment_number]=$this->eploan_model->get_advance_paid_list_Period($this->uri->segment(4),$getdate,$todate);

		}

	  }
	  /*End of Ticket No:2889*/

	  //exit;
	  $data['paydata']=$dataarr;
	  $data['advance_payment']=$advanceData;
	  $this->load->view('re/eploan/ledger_card',$data);
  }

  /*Ticket No:2889 Added By Madushan 2021.06.18*/
  function get_advanceblocklist()
  {
  	$data['lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(4));
	$this->load->view('re/eploan/advance_block_list',$data);
  }

  function get_followupdata_adavance()
  {
  	//$data['details']=$this->eploan_model->get_eploan_data($this->uri->segment(4));
	//$data['totset']=$this->eploan_model->get_paid_totals($this->uri->segment(4));
	$data['ariastot']=$this->eploan_model->get_advance_arrias_instalments($this->uri->segment(4),$this->uri->segment(5));
	$data['paidtot']=$this->eploan_model->get_advance_paid_amount($this->uri->segment(4),$this->uri->segment(5));
	$data['advancefollow']=$this->eploan_model->get_followups_by_lot_id($this->uri->segment(4));
	$data['lot_id'] = $this->uri->segment(4);
	$this->load->view('re/eploan/followups_advance',$data);
  }

  function add_followups_advance()
  {
  	if ( ! check_access('add_followup'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
	$entry=$this->eploan_model->add_followups_advance();
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
	redirect("re/eploan/follow_up");
  }

function get_advance_followup_print()
{

	$data['advancefollowlist']=$this->eploan_model->get_followups_by_lot_id($this->uri->segment(4));

	$this->load->view('re/eploan/followups_advance_print',$data);

}
  /*End Of Ticket No:2889*/

   /*Ticket No:2952 Added By Madushan 2021.06.23*/
  function rebate_print($rebate_code)
  {
  	$data['datalist'] = $datalist = $this->eploan_model->get_rebate_print($rebate_code);
  	if($datalist)
  		$data['loan_details']=$this->eploan_model->get_eploan_data($datalist->loan_code);
  	$this->load->view('re/eploan/rebate_print',$data);
  }
  /*End Of Ticket No:2952*/

//Ticket No:3067 Added By Madushan 2021-07-12
  function update_bank_details()
  {

	$loan_code=$this->input->post('loan_code');
	$bank = $this->input->post('bank1');
	$branch = $this->input->post('branch1');
	$contact_person = $this->input->post('contact_name');
	$epb_officer = $this->input->post('contact_officer');
	if($branch == '')
	{
		$insert_data = array(
			'epb_bank'=>$bank,
			'epb_contact'=>$contact_person,
			'epb_officer'=>$epb_officer,
	);
	}
	else
	{
		$insert_data = array(
			'epb_bank'=>$bank,
			'epb_branch'=>$branch,
			'epb_contact'=>$contact_person,
			'epb_officer'=>$epb_officer,
	);
	}

  	$this->eploan_model->update_bank_details($insert_data,$loan_code);
  	//echo 'OK';
  	//redirect("re/eploan/follow_up");
  }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
