<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tax extends CI_Controller {

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
		
		$this->load->model("tax_model");
		$this->load->model("common_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		
		redirect('accounts/tax/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax');
			return;
		}
		$data['vatdata']=$inventory=$this->tax_model->get_vat_rates();
		$data['espdata']=$inventory=$this->tax_model->get_esp_rates();
				$courseSelectList="";
				 $count=0;
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='account/tax/showall';
				$data['tag']='Search Product Tasks ';
				
			
		$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('accounts/tax/config_rates',$data);
		
		
		
	}
	public function search()
	{
			$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax');
			return;
		}
		$data['details']=$this->rates_model->get_rates_bycode($this->uri->segment(4));
		$this->load->view('config/rates/search',$data);
		
	}
	
	
	public function add_vat()
	{
		if ( ! check_access('add_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax/showall');
			return;
		}
		$year=$this->input->post('year');
		$month=$this->input->post('month');
		$m_half=$this->input->post('m_half');
		$rate=$this->input->post('rate');
		if($month=='' || $m_half='')
		{
			$this->tax_model->delete_year_vat($year);
			for($i=1; $i<=12; $i++)
			{
				$month=str_pad($i, 2, "0", STR_PAD_LEFT);
				
					$m_half1=1;
				$startdate1=$year.'-'.$month.'-01';
				$enddate1=$year.'-'.$month.'-15';
				
					$m_half2=2;
				$startdate2=$year.'-'.$month.'-16';
				$enddate2=$year.'-'.$month.'-31';
				
				$id=$this->tax_model->add_vat($year,$month,$m_half1,$startdate1,$enddate1,$rate);
				$id=$this->tax_model->add_vat($year,$month,$m_half2,$startdate2,$enddate2,$rate);
				$this->session->set_flashdata('msg', 'Vat  Rate Successfully Inserted  for the year'.$year);
				
			}
		}
		else
		{
			if($m_half!="" && $month!=""){
				$val=$this->tax_model->is_inserted($year,$month,$m_half);
				if($val)
				{
					if($m_half==1)
						{
						$startdate=$year.'-'.$month.'-01';
						$enddate=$year.'-'.$month.'-15';
					}
					else
					{
						$startdate=$year.'-'.$month.'-16';
							$enddate=$year.'-'.$month.'-31';
					}	
					$id=$this->tax_model->add_vat($year,$month,$m_half,$startdate,$enddate,$rate);
					$this->session->set_flashdata('msg', 'Vat  Rate Successfully Inserted ');
					$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
					}
					else
					{
						$this->session->set_flashdata('error', 'Vat  Rate Already Inserted ');
						$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
					}
			}
			else
			{
						$this->session->set_flashdata('error', 'Please select month and month half ');
						
			}
		
		}
	
		redirect('accounts/tax/showall');
		
	}
	public function edit_vat()
	{
			$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$data['details']=$this->tax_model->get_vat_rates_bycode($this->uri->segment(4));
		//$this->common_model->add_activeflag('cm_rates',$this->uri->segment(4),'rate_id');
		//$session = array('activtable'=>'cm_rates');
		//$this->session->set_userdata($session);
		$this->load->view('accounts/tax/edit_vat',$data);
		
	}
	function edit_vatdata()
	{
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			
			return;
		}
		$id=$this->tax_model->edit_vat();
		//echo $this->input->post('rate_id');
		
		$this->session->set_flashdata('msg', 'Finance Rate Successfully Updated ');
		
		$this->logger->write_message("success", $this->input->post('rate_id').' Finance Rate successfully Updated');
		redirect('accounts/tax/showall');
		
	}
	
	
	public function add_esp()
	{
		if ( ! check_access('add_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax/showall');
			return;
		}
		$year=$this->input->post('year_sep');
		//echo $year;
		$quoter=$this->input->post('quoter');
		$rate=$this->input->post('rate');
		$val=$this->tax_model->is_inserted_esp($year,$quoter);
		if($val)
		{
			if($quoter==1)
			{
				$startdate=$year.'-04-01';
				$enddate=$year.'-06-30';
			}
			if($quoter==2)
			{
				$startdate=$year.'-07-01';
				$enddate=$year.'-09-31';
			}
			if($quoter==3)
			{
				$startdate=$year.'-10-01';
				$enddate=$year.'-12-31';
			}
			if($quoter==4)
			{
				$year2=$year+1;
				$startdate=$year2.'-01-01';
				$enddate=$year2.'-03-31';
			}
		$id=$this->tax_model->add_esp($year,$quoter,$startdate,$enddate,$rate);
		$this->session->set_flashdata('msg', 'ESP  Rate Successfully Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		}
		else
		{
			$this->session->set_flashdata('error', 'ESP  Rate Already Inserted ');
		$this->logger->write_message("success", $this->input->post('task_name').'  successfully Inserted');
		}
		
	
	redirect('accounts/tax/showall');
		
	}
	public function edit_esp()
	{
			$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$data['details']=$this->tax_model->get_esp_rates_bycode($this->uri->segment(4));
		//$this->common_model->add_activeflag('cm_rates',$this->uri->segment(4),'rate_id');
		//$session = array('activtable'=>'cm_rates');
		//$this->session->set_userdata($session);
		$this->load->view('accounts/tax/edit_esp',$data);
		
	}
	function edit_espdata()
	{
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			
			return;
		}
		$id=$this->tax_model->edit_esp();
		//echo $this->input->post('rate_id');
		
		$this->session->set_flashdata('msg', 'Finance Rate Successfully Updated ');
		
		$this->logger->write_message("success", $this->input->post('rate_id').' Finance Rate successfully Updated');
		redirect('accounts/tax/showall');
		
	}
	public function marketval()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax');
			return;
		}
		$data['prjlist']=$inventory=$this->tax_model->get_all_project_confirmed();
	
				$courseSelectList="";
				 $count=0;
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='account/tax/showall';
				$data['tag']='Search Product Tasks ';
				
			
		$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('accounts/tax/marketval_main',$data);
		
		
		
	}
	public function load_current_blocklist()
	{
			$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			return;
		}
		$data['details']=$this->tax_model->get_project_lots($this->uri->segment(4));
		//$this->common_model->add_activeflag('cm_rates',$this->uri->segment(4),'rate_id');
		//$session = array('activtable'=>'cm_rates');
		//$this->session->set_userdata($session);
		$this->load->view('accounts/tax/marketval_data',$data);
		
	}
	public function update_market()
	{
			$data=NULL;
		if ( ! check_access('edit_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/rates/showall');
			
			return;
		}
		$id=$this->tax_model->update_market();
		//echo $this->input->post('rate_id');
		
		$this->session->set_flashdata('msg', 'Market Value Successfully Updated ');
		
	//	$this->logger->write_message("success", ' Market Value  successfully Updated');
		redirect('accounts/tax/marketval');
		
	}
	public function eps_sum()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax');
			return;
		}
		$data['prjlist']=$inventory=$this->tax_model->get_all_project_confirmed();
	
				$courseSelectList="";
				 $count=0;
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='account/tax/showall';
				$data['tag']='Search Product Tasks ';
				
			
		$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('accounts/tax/epssum_main',$data);
		
		
		
	}
   function eps_sum_report()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['quoter']=$quoter=$this->uri->segment(5);
		
		$val=$this->tax_model->is_inserted_esp($year,$quoter);
		if($val)
		{
			$data['msg']= 'Please Define EPS Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			$data['prjlist']=$prjlist=$this->tax_model->get_all_project_confirmed();
			$data['epsdata']=$epsdata=$this->tax_model->get_esp_rates_bycode_year_quotare($year,$quoter);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['advanceresale']=$advancere=$this->tax_model->get_period_advance_resale($startdate,$enddate);
			$data['loanresale']=$loanre=$this->tax_model->get_period_loan_resale($startdate,$enddate);
			
			//echo $epsdata->enddate;
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					$advsettlelist[$prjraw->prj_id]=$this->tax_model->get_advance_settlelist($prjraw->prj_id,$startdate,$enddate);
					$loansettlset[$prjraw->prj_id]=$this->tax_model->get_ep_settle_list_new($prjraw->prj_id,$startdate,$enddate);
					
				}
				$data['advsettlelist']=$advsettlelist;
				$data['loansettlset']=$loansettlset;
			$this->load->view('accounts/tax/epssum_report',$data);
			}
			
			
		}
   }
   function eps_sum_report_excel()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['quoter']=$quoter=$this->uri->segment(5);
		
		$val=$this->tax_model->is_inserted_esp($year,$quoter);
		if($val)
		{
			$data['msg']= 'Please Define EPS Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			$data['prjlist']=$prjlist=$this->tax_model->get_all_project_confirmed();
			$data['epsdata']=$epsdata=$this->tax_model->get_esp_rates_bycode_year_quotare($year,$quoter);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['advanceresale']=$advancere=$this->tax_model->get_period_advance_resale($startdate,$enddate);
			$data['loanresale']=$loanre=$this->tax_model->get_period_loan_resale($startdate,$enddate);
			
			//echo $epsdata->enddate;
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					$advsettlelist[$prjraw->prj_id]=$this->tax_model->get_advance_settlelist($prjraw->prj_id,$startdate,$enddate);
					$loansettlset[$prjraw->prj_id]=$this->tax_model->get_ep_settle_list_new($prjraw->prj_id,$startdate,$enddate);
					
				}
				$data['advsettlelist']=$advsettlelist;
				$data['loansettlset']=$loansettlset;
			$this->load->view('accounts/tax/epssum_report_excel',$data);
			}
			
			
		}
   }
   public function vat_report()
	{
		$data=NULL;
		if ( ! check_access('view_rates'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('accounts/tax');
			return;
		}
		$data['prjlist']=$inventory=$this->tax_model->get_all_project_confirmed();
	
				$courseSelectList="";
				 $count=0;
				
				$data['searchlist']=$courseSelectList;
				$data['searchpath']='account/tax/showall';
				$data['tag']='Search Product Tasks ';
				
			
		$data['datalist']=$inventory;
		
			//echo $pagination_counter;
		
	$this->load->view('accounts/tax/vat_report',$data);
		
		
		
	}
function vat_schedule()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		$data['m_half']=$m_half=$this->uri->segment(6);
		
		$val=$this->tax_model->is_inserted($year,$month,$m_half);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata']=$epsdata=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_income_list($startdate,$enddate);
			$data['advanceresale']=$advancere=$this->tax_model->get_period_advance_resale($startdate,$enddate);
			$data['loanresale']=$loanre=$this->tax_model->get_period_loan_resale($startdate,$enddate);
			//echo $epsdata->enddate;
			if($reserv)
			{
				foreach($reserv as $prjraw)
				{$paytype=$prjraw->pay_type;
						$advpayementtot=$this->tax_model->advance_payment_period_date($prjraw->res_code,$startdate,$enddate);
						$loanpaytot=0;
					if($paytype=='NEP' || $paytype=='EPB' || $paytype=='ZEP')
					{
						$loanpaytot=$this->tax_model->loan_payment_befoer_date($prjraw->res_code,$startdate,$enddate);
						$loanpaytot=$loanpaytot+$this->tax_model->loan_settlepayment_month($prjraw->res_code,$startdate,$enddate);
					}
					$total[$prjraw->res_code]=$advpayementtot+$loanpaytot;
				}
				$data['total']=$total;
				
			$this->load->view('accounts/tax/vat_schedule',$data);
			}
			
			
		}
   }
   function vat_schedule_excel()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		$data['m_half']=$m_half=$this->uri->segment(6);
		
		$val=$this->tax_model->is_inserted($year,$month,$m_half);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata']=$epsdata=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_income_list($startdate,$enddate);
			$data['advanceresale']=$advancere=$this->tax_model->get_period_advance_resale($startdate,$enddate);
			$data['loanresale']=$loanre=$this->tax_model->get_period_loan_resale($startdate,$enddate);
			
			//echo $epsdata->enddate;
			if($reserv)
			{
				foreach($reserv as $prjraw)
				{$paytype=$prjraw->pay_type;
						$advpayementtot=$this->tax_model->advance_payment_period_date($prjraw->res_code,$startdate,$enddate);
						$loanpaytot=0;
					if($paytype=='NEP' || $paytype=='EPB' || $paytype=='ZEP')
					{
						$loanpaytot=$this->tax_model->loan_payment_befoer_date($prjraw->res_code,$startdate,$enddate);
						$loanpaytot=$loanpaytot+$this->tax_model->loan_settlepayment_month($prjraw->res_code,$startdate,$enddate);
					}
					$total[$prjraw->res_code]=$advpayementtot+$loanpaytot;
				}
				$data['total']=$total;
				
			$this->load->view('accounts/tax/vat_schedule_excel',$data);
			}
			
			
		}
   }
   function input_vatreport()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		$data['m_half']=$m_half=$this->uri->segment(6);
		
		$val=$this->tax_model->is_inserted($year,$month,$m_half);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata']=$epsdata=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate,$enddate);
			//echo $epsdata->enddate;
			
			$this->load->view('accounts/tax/input_vatreport',$data);
			
		}
   }
    function input_vatreport_excel()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		$data['m_half']=$m_half=$this->uri->segment(6);
		
		$val=$this->tax_model->is_inserted($year,$month,$m_half);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata']=$epsdata=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate,$enddate);
			//echo $epsdata->enddate;
			
			$this->load->view('accounts/tax/input_vatreport_excel',$data);
			
		}
   }
   function input_vatreport_csv()
   {
	   $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		$data['m_half']=$m_half=$this->uri->segment(6);
		
		$val=$this->tax_model->is_inserted($year,$month,$m_half);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata']=$epsdata=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate']=$startdate=$epsdata->startdate;
			$data['enddate']=$enddate=$epsdata->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate,$enddate);
			//echo $epsdata->enddate;
			
			$this->load->view('accounts/tax/input_vatreport_csv',$data);
			
		}
   }
   function vat_summery()
   {
	  	 $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
	    $m_half=1;
		$m_half2=2;
		 $val2=$this->tax_model->is_inserted($year,$month,$m_half);
		$val=$this->tax_model->is_inserted($year,$month,$m_half2);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else if($val2)
		{
			$data['msg']= 'Please Define VAT Rates for whole month Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata1']=$epsdata1=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate1']=$startdate1=$epsdata1->startdate;
			$data['enddate1']=$enddate1=$epsdata1->enddate;
			$data['epsdata2']=$epsdata2=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half2);
			$data['startdate2']=$startdate2=$epsdata2->startdate;
			$data['enddate2']=$enddate2=$epsdata2->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_income_list($startdate1,$enddate1);
			//echo $epsdata->enddate;
			$totvat_firsthalf=0;
			$tot_totrcv=0;$res_code="";$tot_totrcv_f='';
			if($reserv)
			{ 
				  $vat=$epsdata1->rate/100;
				foreach($reserv as $prjraw)
				{		$paytype=$prjraw->pay_type;
						$advpayementtot=$this->tax_model->advance_payment_period_date($prjraw->res_code,$startdate1,$enddate1);
						$loanpaytot=0;
					if($paytype=='NEP' || $paytype=='EPB' || $paytype=='ZEP')
					{
						$loanpaytot=$this->tax_model->loan_payment_befoer_date($prjraw->res_code,$startdate1,$enddate1);
						$loanpaytot=$loanpaytot+$this->tax_model->loan_settlepayment_month($prjraw->res_code,$startdate1,$enddate1);
					}
							$total[$prjraw->res_code]=$advpayementtot+$loanpaytot;
								 $market=0;$vatpayble=0;$taxable=0;$totrcv=0;$taxablerate=0; $vatrcv=0;
								  if($prjraw->market_val)
										 $market=$prjraw->market_val;
							 $taxable=$prjraw->discounted_price-$market;
									 if($taxable!=0)
									  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
									  $vatpayble=$taxable*$vat;
									  $totrcv=$total[$prjraw->res_code];
				//$espval=$raw->discounted_price*$esprate;
				if($total[$prjraw->res_code]>0){
					  if($res_code!=$prjraw->res_code) {
		   						$res_code=$prjraw->res_code;
									if($vatpayble>0)
									 $vatrcv= $totrcv*$taxablerate*$vat/100;
									 $totvat_firsthalf=$totvat_firsthalf+$vatrcv;
									 $tot_totrcv_f=$tot_totrcv_f+$totrcv;
									// echo $totrcv.'-'.$vatrcv.'<br>';
					  }
				}
					
					
				}
				
				
				//echo  $totvat_firsthalf;
			//$this->load->view('accounts/tax/vat_schedule_excel',$data);
			}
			
				$data['reserv']=$reserv=$this->tax_model->get_period_income_list($startdate2,$enddate2);
			//echo $epsdata->enddate;
			$totvat_secondhalf=0;
			$tot_totrcv=0;$res_code="";$tot_totrcv_s=0;
			if($reserv)
			{ 
				  $vat=$epsdata2->rate/100;
				foreach($reserv as $prjraw)
				{		$paytype=$prjraw->pay_type;
						$advpayementtot=$this->tax_model->advance_payment_period_date($prjraw->res_code,$startdate2,$enddate2);
						$loanpaytot=0;
					if($paytype=='NEP' || $paytype=='EPB' || $paytype=='ZEP')
					{
						$loanpaytot=$this->tax_model->loan_payment_befoer_date($prjraw->res_code,$startdate2,$enddate2);
						$loanpaytot=$loanpaytot+$this->tax_model->loan_settlepayment_month($prjraw->res_code,$startdate2,$enddate2);
					}
							$total[$prjraw->res_code]=$advpayementtot+$loanpaytot;
								 $market=0;$vatpayble=0;$taxable=0;$totrcv=0;$taxablerate=0; $vatrcv=0;
								  if($prjraw->market_val)
										 $market=$prjraw->market_val;
							 $taxable=$prjraw->discounted_price-$market;
									 if($taxable!=0)
									  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
									  $vatpayble=$taxable*$vat;
									  $totrcv=$total[$prjraw->res_code];
				//$espval=$raw->discounted_price*$esprate;
						if($total[$prjraw->res_code]>0){
						  if($res_code!=$prjraw->res_code) {
		   						$res_code=$prjraw->res_code;
									if($vatpayble>0)
									 $vatrcv= $totrcv*$taxablerate*$vat/100;
									 $totvat_secondhalf=$totvat_secondhalf+$vatrcv;
									 $tot_totrcv_s=$tot_totrcv_s+$totrcv;
									// echo $totrcv.'-'.$vatrcv.'<br>';
					  		}
						}
					
					
					}
				
				
				//echo  $totvat_firsthalf;
			
			}
				$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate1,$enddate1);
				$inputvat_fisthalf=0;
				 if($reserv)
				{
					foreach($reserv as $prjraw){
					 $inputvat_fisthalf=$inputvat_fisthalf+$prjraw->vat_amount;
					}
				}
				$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate2,$enddate2);
				$inputvat_secondhalf=0;
				 if($reserv)
				{
					foreach($reserv as $prjraw){
					 $inputvat_secondhalf=$inputvat_secondhalf+$prjraw->vat_amount;
					}
				}
				
					$data['inputvat_secondhalf']=$inputvat_secondhalf;
					$data['inputvat_fisthalf']=$inputvat_fisthalf;
					$data['totvat_firsthalf']=$totvat_firsthalf;
					$data['totvat_secondhalf']=$totvat_secondhalf;
					$data['tot_totrcv_f']=$tot_totrcv_f;
					$data['tot_totrcv_s']=$tot_totrcv_s;
					$this->load->view('accounts/tax/vat_summery',$data);
		}
   }
   function vat_summery_excel()
   {
	  	 $data['year']=$year=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
	    $m_half=1;
		$m_half2=2;
		 $val2=$this->tax_model->is_inserted($year,$month,$m_half);
		$val=$this->tax_model->is_inserted($year,$month,$m_half2);
		if($val)
		{
			$data['msg']= 'Please Define VAT Rates Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else if($val2)
		{
			$data['msg']= 'Please Define VAT Rates for whole month Before Generate the report';
			$this->load->view('accounts/tax/report_error',$data);
		}
		else
		{
			
			$data['epsdata1']=$epsdata1=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half);
			$data['startdate1']=$startdate1=$epsdata1->startdate;
			$data['enddate1']=$enddate1=$epsdata1->enddate;
			$data['epsdata2']=$epsdata2=$this->tax_model->get_vat_rates_bycode_year_month($year,$month,$m_half2);
			$data['startdate2']=$startdate2=$epsdata2->startdate;
			$data['enddate2']=$enddate2=$epsdata2->enddate;
			$data['reserv']=$reserv=$this->tax_model->get_period_income_list($startdate1,$enddate1);
			//echo $epsdata->enddate;
			$totvat_firsthalf=0;
			$tot_totrcv_f=0;
			$tot_totrcv=0;$res_code="";
			if($reserv)
			{ 
				  $vat=$epsdata1->rate/100;
				foreach($reserv as $prjraw)
				{		$paytype=$prjraw->pay_type;
						$advpayementtot=$this->tax_model->advance_payment_period_date($prjraw->res_code,$startdate1,$enddate1);
						$loanpaytot=0;
					if($paytype=='NEP' || $paytype=='EPB' || $paytype=='ZEP')
					{
						$loanpaytot=$this->tax_model->loan_payment_befoer_date($prjraw->res_code,$startdate1,$enddate1);
						$loanpaytot=$loanpaytot+$this->tax_model->loan_settlepayment_month($prjraw->res_code,$startdate1,$enddate1);
					}
							$total[$prjraw->res_code]=$advpayementtot+$loanpaytot;
								 $market=0;$vatpayble=0;$taxable=0;$totrcv=0;$taxablerate=0; $vatrcv=0;
								  if($prjraw->market_val)
										 $market=$prjraw->market_val;
							 $taxable=$prjraw->discounted_price-$market;
									 if($taxable!=0)
									  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
									  $vatpayble=$taxable*$vat;
									  $totrcv=$total[$prjraw->res_code];
				//$espval=$raw->discounted_price*$esprate;
				if($total[$prjraw->res_code]>0){
					  if($res_code!=$prjraw->res_code) {
		   						$res_code=$prjraw->res_code;
									if($vatpayble>0)
									 $vatrcv= $totrcv*$taxablerate*$vat/100;
									 $totvat_firsthalf=$totvat_firsthalf+$vatrcv;
									 $tot_totrcv_f=$tot_totrcv_f+$totrcv;
									// echo $totrcv.'-'.$vatrcv.'<br>';
					  }
				}
					
					
				}
				
				
				//echo  $totvat_firsthalf;
			//$this->load->view('accounts/tax/vat_schedule_excel',$data);
			}
			
				$data['reserv']=$reserv=$this->tax_model->get_period_income_list($startdate2,$enddate2);
			//echo $epsdata->enddate;
			$totvat_secondhalf=0;
			$tot_totrcv=0;$res_code="";
			$tot_totrcv_s=0;
			if($reserv)
			{ 
				  $vat=$epsdata2->rate/100;
				foreach($reserv as $prjraw)
				{		$paytype=$prjraw->pay_type;
						$advpayementtot=$this->tax_model->advance_payment_period_date($prjraw->res_code,$startdate2,$enddate2);
						$loanpaytot=0;
					if($paytype=='NEP' || $paytype=='EPB' || $paytype=='ZEP')
					{
						$loanpaytot=$this->tax_model->loan_payment_befoer_date($prjraw->res_code,$startdate2,$enddate2);
						$loanpaytot=$loanpaytot+$this->tax_model->loan_settlepayment_month($prjraw->res_code,$startdate2,$enddate2);
					}
							$total[$prjraw->res_code]=$advpayementtot+$loanpaytot;
								 $market=0;$vatpayble=0;$taxable=0;$totrcv=0;$taxablerate=0; $vatrcv=0;
								  if($prjraw->market_val)
										 $market=$prjraw->market_val;
							 $taxable=$prjraw->discounted_price-$market;
									 if($taxable!=0)
									  $taxablerate= ($taxable/$prjraw->discounted_price)*100;
									  $vatpayble=$taxable*$vat;
									  $totrcv=$total[$prjraw->res_code];
				//$espval=$raw->discounted_price*$esprate;
						if($total[$prjraw->res_code]>0){
						  if($res_code!=$prjraw->res_code) {
		   						$res_code=$prjraw->res_code;
									if($vatpayble>0)
									 $vatrcv= $totrcv*$taxablerate*$vat/100;
									 $totvat_secondhalf=$totvat_secondhalf+$vatrcv;
									 $tot_totrcv_s=$tot_totrcv_s+$totrcv;
									// echo $totrcv.'-'.$vatrcv.'<br>';
					  		}
						}
					
					
					}
				
				
				//echo  $totvat_firsthalf;
			
			}
				$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate1,$enddate1);
				$inputvat_fisthalf=0;
				 if($reserv)
				{
					foreach($reserv as $prjraw){
					 $inputvat_fisthalf=$inputvat_fisthalf+$prjraw->vat_amount;
					}
				}
				$data['reserv']=$reserv=$this->tax_model->get_period_invoice_list($startdate2,$enddate2);
				$inputvat_secondhalf=0;
				 if($reserv)
				{
					foreach($reserv as $prjraw){
					 $inputvat_secondhalf=$inputvat_secondhalf+$prjraw->vat_amount;
					}
				}
				
					$data['inputvat_secondhalf']=$inputvat_secondhalf;
					$data['inputvat_fisthalf']=$inputvat_fisthalf;
					$data['totvat_firsthalf']=$totvat_firsthalf;
					$data['totvat_secondhalf']=$totvat_secondhalf;
					
					$data['tot_totrcv_f']=$tot_totrcv_f;
					$data['tot_totrcv_s']=$tot_totrcv_s;
					$this->load->view('accounts/tax/vat_summery_excel',$data);
		}
   }
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */