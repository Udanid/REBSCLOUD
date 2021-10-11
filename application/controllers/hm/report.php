	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

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
	    $this->load->model("hm_lotdata_model");
		$this->load->model("hm_salesmen_model");
		$this->load->model("branch_model");
		$this->load->model("hm_reservation_model");
		$this->load->model("hm_eploan_model");
		$this->load->model("hm_report_model");
		$this->load->model("summery_model");
		$this->load->model("customer_model");
		$this->load->model("hm_redashboard_model");
		$this->load->model("hm_projectpayment_model");
		$this->is_logged_in();
		
    }
	
	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_report'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/project/showall');
		
		
		
	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_report'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/');
			return;
		}
	
		
			
		
		
	}
	function get_branch_projectlist()
	{
		
		$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$this->load->view('hm/report/project_list',$data);
		
	}
	// Start Profit Report**************************************************************************************************************
	public function profit()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
			
		$data['searchpath']='hm/lotdata/search';
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/profit_main',$data);
		
		
		
	}
	public function profitshedule()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
			
		$data['searchpath']='hm/lotdata/search';
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/profitshedule_main',$data);
		
		
		
	}
	
	function get_profit()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['transferlist']=$transferlist=$this->hm_report_model->get_profittransfer_data($this->uri->segment(5))	;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		$data['month']=$month="";
		if($transferlist){
			
		//	print_r($planlist);
		foreach($transferlist as $raw)
		{
			$paidcap[$raw->res_code]=0;
			$paidadvance[$raw->res_code]=0;
			if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
			{
				
				$loandata=$this->hm_report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->hm_report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->hm_report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->hm_report_model->get_lotdata($raw->lot_id);
			}}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(5))	;
		$data['projecttots']=$this->hm_report_model->get_lot_summery($this->uri->segment(5))	;
		$data['selabalecount']=$this->hm_report_model->get_selabale_count($this->uri->segment(5))	;
		
		$this->load->view('hm/report/profit_summery',$data);	
	}
	function get_profit_print()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['transferlist']=$transferlist=$this->hm_report_model->get_profittransfer_data($this->uri->segment(4))	;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		if($transferlist){
			
		//	print_r($planlist);
		foreach($transferlist as $raw)
		{
			$paidcap[$raw->res_code]=0;
			$paidadvance[$raw->res_code]=0;
			if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
			{
				
				$loandata=$this->hm_report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->hm_report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->hm_report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->hm_report_model->get_lotdata($raw->lot_id);
			}}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['projecttots']=$this->hm_report_model->get_lot_summery($this->uri->segment(4))	;
		$data['selabalecount']=$this->hm_report_model->get_selabale_count($this->uri->segment(4))	;
		
		$this->load->view('hm/report/print_profit_summery',$data);	
	}
	
	function get_profit_month_project()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['month']=$month=$this->uri->segment(6);
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=date('Y');
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		$data['transferlist']=$transferlist=$this->hm_report_model->get_profittransfer_data_period($this->uri->segment(5),$stdate,$enddate)	;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		if($transferlist){
			
		//	print_r($planlist);
		foreach($transferlist as $raw)
		{
			$paidcap[$raw->res_code]=0;
			$paidadvance[$raw->res_code]=0;
			if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
			{
				
				$loandata=$this->hm_report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->hm_report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->hm_report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->hm_report_model->get_lotdata($raw->lot_id);
			}
		}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(5));
		$data['projecttots']=$this->hm_report_model->get_lot_summery($this->uri->segment(5));
		$data['selabalecount']=$this->hm_report_model->get_selabale_count($this->uri->segment(5))	;
		
		$this->load->view('hm/report/profit_summery',$data);	
	}
	
	function get_profit_month_project_print()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=date('Y');;
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		$data['transferlist']=$transferlist=$this->hm_report_model->get_profittransfer_data_period($this->uri->segment(4),$stdate,$enddate)	;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		if($transferlist){
			
		//	print_r($planlist);
		foreach($transferlist as $raw)
		{
			$paidcap[$raw->res_code]=0;
			$paidadvance[$raw->res_code]=0;
			if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
			{
				
				$loandata=$this->hm_report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->hm_report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->hm_report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->hm_report_model->get_lotdata($raw->lot_id);
			}}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->hm_project_model->get_project_bycode($this->uri->segment(4))	;
		$data['projecttots']=$this->hm_report_model->get_lot_summery($this->uri->segment(4))	;
		$data['selabalecount']=$this->hm_report_model->get_selabale_count($this->uri->segment(4))	;
		
		$this->load->view('hm/report/print_profit_summery',$data);	
	}
	function get_profit_all()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['month']=$month=$this->uri->segment(6);
		if($month!=""){
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=date('Y');;
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		}
	
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		$details=NULL;
		$projecttots=NULL;
		$selabalecount=NULL;
		$transferlist=NULL;
	    foreach($prjlist as $prjraw)
		{ 
		
			if($month!="")
			$transferlist[$prjraw->prj_id][$month]=$this->hm_report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;
			else 
			{
				$start=date($this->session->userdata('fy_start'));
				$end=date('Y-m-d');
				
				while($start<=$end)
				{
					//	echo $prjraw->prj_id;	
					$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$stdate=$year.'-'.$month2.'-01';
					$enddate=$year.'-'.$month2.'-31';
					$transferlist[$prjraw->prj_id][$month2]=$this->hm_report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;
					
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					
				}
			}
		
			$projecttots[$prjraw->prj_id]=$this->hm_report_model->get_lot_summery($prjraw->prj_id);
			$selabalecount[$prjraw->prj_id]=$this->hm_report_model->get_selabale_count($prjraw->prj_id);
			$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id);
			
			
		//	print_r($planlist);
			
		}
		//print_r($transferlist);
		$data['transferlist']=$transferlist;
		$data['details']=$details	;
		$data['projecttots']=$projecttots	;
		$data['selabalecount']=$selabalecount	;
		
		$this->load->view('hm/report/profit_summery_all',$data);	
	}
	
	function get_profits_all()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['month']=$month=$this->uri->segment(6);
		if($month!=""){
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=date('Y');;
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		}
	
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		$details=NULL;
		$projecttots=NULL;
		$selabalecount=NULL;
		$transferlist=NULL;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
	    foreach($prjlist as $prjraw)
		{ 
		
			$data['transferlist'][$prjraw->prj_id]=$transferlist=$this->hm_report_model->get_profittransfer_data_period($prjraw->prj_id,$stdate,$enddate)	;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		if($transferlist){
			
		//	print_r($planlist);
		foreach($transferlist as $raw)
		{
			$paidcap[$raw->res_code]=0;
			$paidadvance[$raw->res_code]=0;
			if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
			{
				
				$loandata=$this->hm_report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->hm_report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->hm_report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->hm_report_model->get_lotdata($raw->lot_id);
			}
		}
		//print_r($lotlist);
		$data['paidadvance'][$prjraw->prj_id]=$paidadvance;
		$data['lotdata'][$prjraw->prj_id]=$lotdata;
		$data['paidcap'][$prjraw->prj_id]=$paidcap;
		$data['details'][$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($this->uri->segment(5));
		$data['projecttots'][$prjraw->prj_id]=$this->hm_report_model->get_lot_summery($this->uri->segment(5));
		$data['selabalecount'][$prjraw->prj_id]=$this->hm_report_model->get_selabale_count($this->uri->segment(5))	;
			
			
		//	print_r($planlist);
			
		}
		//print_r($transferlist);
			
		$this->load->view('hm/report/profitshedule_summery',$data);	
	}
	
	function get_profit_all_print()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['month']=$month=$this->uri->segment(5);
		if($month!=""){
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=date('Y');;
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		}
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		$details=NULL;
		$projecttots=NULL;
		$selabalecount=NULL;
		$transferlist=NULL;
	    foreach($prjlist as $prjraw)
		{ 
		
			if($month!="")
			$transferlist[$prjraw->prj_id][$month]=$this->hm_report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;
			else 
			{
				$start=date($this->session->userdata('fy_start'));
				$end=date('Y-m-d');
				
				while($start<=$end)
				{
					//	echo $prjraw->prj_id;	
					$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$stdate=$year.'-'.$month2.'-01';
					$enddate=$year.'-'.$month2.'-31';
					$transferlist[$prjraw->prj_id][$month2]=$this->hm_report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;
					
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));
					
				}
			}
		
			$projecttots[$prjraw->prj_id]=$this->hm_report_model->get_lot_summery($prjraw->prj_id);
			$selabalecount[$prjraw->prj_id]=$this->hm_report_model->get_selabale_count($prjraw->prj_id);
			$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id);
			
			
		//	print_r($planlist);
			
		}
		//print_r($transferlist);
		$data['transferlist']=$transferlist;
		$data['details']=$details	;
		$data['projecttots']=$projecttots	;
		$data['selabalecount']=$selabalecount	;
		
		$this->load->view('hm/report/print_profit_summery_all',$data);	
	}
	
	/* Start Stock Report Report**********************************************************************************************
	************************************************************************************************************************/
public function stock()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['searchpath']='hm/lotdata/search';
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/stock_main',$data);
		
		
		
	}
	
	function get_stock()
	{
		
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$lotdata=NULL;
		$pendinglot=NULL;
		$lastmont=NULL;
		$details=NULL;
		
		$data['month']=$month=$this->uri->segment(5);
		$data['year']=$year=$this->uri->segment(6);
		if($month!=""){
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=$year;
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		$data['reportdata']=$enddate;
		$data['sartdate']=$stdate;
		}
		else
		{
			$enddate=date("Y-m-d");
			$data['reportdata']=$enddate;
			$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
		}
		
		$lastmonthstdate=date('Y-m-d',strtotime('-1 months',strtotime($stdate)));
		$lastmonthstenddate=date('Y-m-d',strtotime('-1 months',strtotime($enddate)));
			$pendinglot[$prj_id]=$this->hm_report_model->pending_lotdata_count($prj_id);
			$fulllot[$prj_id]=$this->hm_report_model->full_lotdata_count($prj_id);
			$lastmont[$prj_id]=$this->hm_report_model->lastmonth_reservation_count($prj_id,$stdate,$lastmonthstdate,$lastmonthstenddate);
			
			$lotdata[$prj_id]=$this->hm_report_model->pending_lotdata($prj_id);
			$reslots[$prj_id]=$this->hm_report_model->thismonth_reservation_lots($prj_id,$stdate,$enddate);
			$details[$prj_id]=$this->hm_project_model->get_project_bycode($prj_id)	;
	
		
			$data['reslots']=$reslots;
				$data['fulllot']=$fulllot;
		$data['pendinglot']=$pendinglot;
		$data['lotdata']=$lotdata;
		$data['lastmont']=$lastmont;
		$data['details']=$details	;
		
		
		//print_r($lotlist);
		
		
		$this->load->view('hm/report/stock_report_prj',$data);
	}
	function get_stock_all()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['branchid']=$branchid=$this->uri->segment(4);
	
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$lotdata=NULL;
		$pendinglot=NULL;
		$lastmont=NULL;
		$details=NULL;
		
		$data['month']=$month=$this->uri->segment(5);
			$data['year']=$year=$this->uri->segment(6);
		if($month!=""){
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=$year;
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		$data['reportdata']=$enddate;
		$data['sartdate']=$stdate;
		}
		else
		{
			$enddate=date("Y-m-d");
			$data['reportdata']=$enddate;
			$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
		}
		$lastmonthstdate=date('Y-m-d',strtotime('-1 months',strtotime($stdate)));
		$lastmonthstenddate=date('Y-m-d',strtotime('-1 months',strtotime($enddate)));
		if($prjlist){
		foreach($prjlist as $prjraw)
		{
			$pendinglot[$prjraw->prj_id]=$this->hm_report_model->pending_lotdata_count($prjraw->prj_id);
			$fulllot[$prjraw->prj_id]=$this->hm_report_model->full_lotdata_count($prjraw->prj_id);
			$lastmont[$prjraw->prj_id]=$this->hm_report_model->lastmonth_reservation_count($prjraw->prj_id,$lastmonthstdate,$lastmonthstenddate);
			
			$lotdata[$prjraw->prj_id]=$this->hm_report_model->pending_lotdata($prjraw->prj_id);
			$reslots[$prjraw->prj_id]=$this->hm_report_model->thismonth_reservation_lots($prjraw->prj_id,$stdate,$enddate);
			$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
		}
		
			$data['reslots']=$reslots;
				$data['fulllot']=$fulllot;
		$data['pendinglot']=$pendinglot;
		$data['lotdata']=$lotdata;
		$data['lastmont']=$lastmont;
		$data['details']=$details	;
		
		}
		//print_r($lotlist);
		
		
		$this->load->view('hm/report/stock_report',$data);	
	}
	function get_stock_all_print()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		$lotdata=NULL;
		$pendinglot=NULL;
		$lastmont=NULL;
		$details=NULL;
		
		$data['month']=$month=$this->uri->segment(4);
		if($month!=""){
		if($month=='01' ||$month=='02' || $month=='03')
		{ 
	
		$yeararr=explode('-',$this->session->userdata('fy_end'));
		}
		else
		{
			$yeararr=explode('-',$this->session->userdata('fy_start'));
		}
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		$year=date('Y');
		$stdate=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		$data['reportdata']=$enddate;
		$data['sartdate']=$stdate;
		}
		else
		{
			$enddate=date("Y-m-d");
			$data['reportdata']=$enddate;
			$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
		}
		$lastmonthstdate=date('Y-m-d',strtotime('-1 months',strtotime($stdate)));
		$lastmonthstenddate=date('Y-m-d',strtotime('-1 months',strtotime($enddate)));
	
		if($prjlist){
		foreach($prjlist as $prjraw)
		{
			$pendinglot[$prjraw->prj_id]=$this->hm_report_model->pending_lotdata_count($prjraw->prj_id);
			$fulllot[$prjraw->prj_id]=$this->hm_report_model->full_lotdata_count($prjraw->prj_id);
			$lastmont[$prjraw->prj_id]=$this->hm_report_model->lastmonth_reservation_count($prjraw->prj_id,$lastmonthstdate,$lastmonthstenddate);
			
			$lotdata[$prjraw->prj_id]=$this->hm_report_model->pending_lotdata($prjraw->prj_id);
			$reslots[$prjraw->prj_id]=$this->hm_report_model->thismonth_reservation_lots($prjraw->prj_id,$stdate,$enddate);
			$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
		}
		}
		//print_r($lotlist);
			$data['reslots']=$reslots;
				$data['fulllot']=$fulllot;
		$data['pendinglot']=$pendinglot;
		$data['lotdata']=$lotdata;
		$data['lastmont']=$lastmont;
		$data['details']=$details	;
		
		$this->load->view('hm/report/print_stock_report',$data);	
	}
		/* Start Collection Report**********************************************************************************************
	************************************************************************************************************************/
public function collection()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		$data['searchpath']='hm/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/collection_main',$data);
		
		
		
	}
	
	
	function get_collection_all()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$data['fromdate']=$branchid=$this->uri->segment(7);
		$data['todate']=$branchid=$this->uri->segment(8);
		$data['type']=$type=$this->uri->segment(5);
		
		//echo 'sssss'.$this->uri->segment(5);
		//Down Payment Report Generation
		if($this->uri->segment(5)=='01' || $this->uri->segment(5)=='04')
		{
			
		
			$data['month']=$month=$this->uri->segment(6);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date("Y");;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$zepprevpayment=NULL;
			$details=NULL;
			$zepthispayment=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->hm_report_model->reservation_lots_befor($prjraw->prj_id,$enddate,$stdate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->res_code]=true;
							$prevpayment[$resraw->res_code]=0;
							if($resraw->pay_type=='NEP' || $resraw->pay_type=='ZEP'|| $resraw->pay_type=='EPB')
							$currentlist[$resraw->res_code]=$this->hm_report_model->check_loan_befordate($resraw->res_code,$stdate);
							$prevpayment[$resraw->res_code]=$this->hm_report_model->advance_sum_befoer_date($resraw->res_code,$stdate);
							$thispayment[$resraw->res_code]=$this->hm_report_model->advance_sum_this_month($resraw->res_code,$stdate,$enddate);
						}
					}
					$zepreservation[$prjraw->prj_id]=$this->hm_report_model->zepploans_befor($prjraw->prj_id,$enddate);
					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->hm_eploan_model->get_int_total($resraw->loan_code);
							$zepprevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date_withoutreshed($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month_withoutreshed($resraw->loan_code,$stdate,$enddate);
						}
					}
					
					$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
				
					$data['zepreservation']=$zepreservation;
					$data['zepprevpayment']=$zepprevpayment;
					$data['zepthispayment']=$zepthispayment;
				$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
			$data['prevpayment']=$prevpayment;
			$data['thispayment']=$thispayment;
		
			$data['details']=$details	;
		
			$this->load->view('hm/report/collection_dp_all',$data);	
			}
			//print_r($lotlist);
				
			
		}
		if($this->uri->segment(5)=='02')
		{
			$data['month']=$month=$this->uri->segment(6);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date("Y");;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$inttots=NULL;
			$details=NULL;
			$settlepayment=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->hm_report_model->eploans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->hm_eploan_model->get_int_total($resraw->loan_code);
							$prevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
								$settlepayment[$resraw->loan_code]=$this->hm_report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
						}
					}
					
					
					$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
				
				
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;;
		
					$this->load->view('hm/report/collection_loan_all',$data);	
				
			}
			
			//print_r($lotlist);
				
		}
		if($this->uri->segment(5)=='03')
		{
			$data['month']=$month=$this->uri->segment(6);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date("Y");;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$inttots=NULL;
			$details=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->hm_report_model->epbloans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->hm_report_model->caclulate_epb_interest($resraw->loan_code,$enddate);
							$prevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
							$settlepayment[$resraw->loan_code]=$this->hm_report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
						}
					}
					
					
					$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
				
				
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;;
		
					$this->load->view('hm/report/collection_loan_all',$data);	
				
			}
			
			//print_r($lotlist);
				
		}
		
	}
	function get_collection()
	{
			if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery_prj($prj_id);
		$data['fromdate']=$branchid=$this->uri->segment(7);
		$data['todate']=$branchid=$this->uri->segment(8);
		$data['type']=$type=$this->uri->segment(5);
		
		//echo 'sssss'.$this->uri->segment(5);
		//Down Payment Report Generation
		if($this->uri->segment(5)=='01' || $this->uri->segment(5)=='04')
		{
			
		
			$data['month']=$month=$this->uri->segment(6);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date("Y");;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$zepprevpayment=NULL;
			$details=NULL;
			$zepthispayment=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->hm_report_model->reservation_lots_befor($prjraw->prj_id,$enddate,$stdate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->res_code]=true;
							$prevpayment[$resraw->res_code]=0;
							if($resraw->pay_type=='NEP' || $resraw->pay_type=='ZEP'|| $resraw->pay_type=='EPB')
							$currentlist[$resraw->res_code]=$this->hm_report_model->check_loan_befordate($resraw->res_code,$stdate);
							$prevpayment[$resraw->res_code]=$this->hm_report_model->advance_sum_befoer_date($resraw->res_code,$stdate);
							$thispayment[$resraw->res_code]=$this->hm_report_model->advance_sum_this_month($resraw->res_code,$stdate,$enddate);
						}
					}
					$zepreservation[$prjraw->prj_id]=$this->hm_report_model->zepploans_befor($prjraw->prj_id,$enddate);
					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->hm_eploan_model->get_int_total($resraw->loan_code);
							$zepprevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date_withoutreshed($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month_withoutreshed($resraw->loan_code,$stdate,$enddate);
						}
					}
					
					$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
				
					$data['zepreservation']=$zepreservation;
					$data['zepprevpayment']=$zepprevpayment;
					$data['zepthispayment']=$zepthispayment;
				$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
			$data['prevpayment']=$prevpayment;
			$data['thispayment']=$thispayment;
		
			$data['details']=$details	;
		
			$this->load->view('hm/report/collection_dp_all',$data);	
			}
			//print_r($lotlist);
				
			
		}
		if($this->uri->segment(5)=='02')
		{
			$data['month']=$month=$this->uri->segment(6);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date("Y");;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$inttots=NULL;
			$details=NULL;
			$settlepayment=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->hm_report_model->eploans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->hm_eploan_model->get_int_total($resraw->loan_code);
							$prevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
								$settlepayment[$resraw->loan_code]=$this->hm_report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
						}
					}
					
					
					$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
				
				
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;;
		
					$this->load->view('hm/report/collection_loan_all',$data);	
				
			}
			
			//print_r($lotlist);
				
		}
		if($this->uri->segment(5)=='03')
		{
			$data['month']=$month=$this->uri->segment(6);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date("Y");;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$inttots=NULL;
			$details=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->hm_report_model->epbloans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->hm_report_model->caclulate_epb_interest($resraw->loan_code,$enddate);
							$prevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
							$settlepayment[$resraw->loan_code]=$this->hm_report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
						}
					}
					
					
					$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
				
				
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;;
		
					$this->load->view('hm/report/collection_loan_all',$data);	
				
			}
			
			//print_r($lotlist);
				
		}
		
	}
	// Start Provition Report**************************************************************************************************************
	public function provition()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		$data['searchpath']='hm/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/provition_main',$data);
		
		
		
	}
	function get_provition()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$details[$prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
			
			//details related to pichart data
			$start=$prjdetails->date_slscommence;
			$end=date('Y-m-d');
			$counter=0;
			$currentsale=0;
			$colelction=0;
				
			$data['month']=$month=$this->uri->segment(5);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date('Y');
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			//$details=NULL;
			
					$reservation[$prj_id]=$this->hm_report_model->get_project_paymeny_task($prj_id);
					if($reservation[$prj_id])
					{
						foreach($reservation[$prj_id] as $resraw)
						{
							
							 $currentlist[$resraw->id]=$this->hm_report_model->get_paymentlist($prj_id,$resraw->task_id,$enddate);
						}
					}
					
					
					
				
			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['currentlist']=$currentlist;
				$data['details']=$details;
		
			$this->load->view('hm/report/provition_prov.php',$data);	
		
	}
	function get_budget()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$details[$prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
			
			//details related to pichart data
			$start=$prjdetails->date_slscommence;
			$end=date('Y-m-d');
			$counter=0;
			$currentsale=0;
			$colelction=0;
				
			$data['month']=$month=$this->uri->segment(5);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date('Y');
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			//$details=NULL;
			
					$reservation[$prj_id]=$this->hm_report_model->get_project_paymeny_task($prj_id);
					
					
					
					
				
			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['details']=$details;
		
			$this->load->view('hm/report/provition_budget.php',$data);	
		
	}
	function get_unbudget()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
	
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_Unbudgeted_project_summery($branchid);
		//$data['prj_id']=$prj_id=$this->uri->segment(4);
			//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
			
			//details related to pichart data
			$end=date('Y-m-d');
			$counter=0;
			$currentsale=0;
			$colelction=0;
				
			$data['month']=$month=$this->uri->segment(4);
			if($month!=""){
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=date('Y');
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$details=NULL;
			//$details=NULL;
			if($prjlist)
			{
			foreach($prjlist as $prjraw)
			{
				$prj_id= $prjraw->prj_id;
					$reservation[$prj_id]=$this->hm_report_model->get_project_paymeny_task($prj_id);
					if($reservation[$prj_id])
					{
						foreach($reservation[$prj_id] as $resraw)
						{
							
							 $currentlist[$resraw->id]=$this->hm_report_model->get_paymentlist_daterange($prj_id,$resraw->task_id,$stdate,$enddate);
						}
					}
					$details[$prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		
					
			}}
				
			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['currentlist']=$currentlist;
				$data['details']=$details;
		
			$this->load->view('hm/report/provition_unbudget.php',$data);	
		
	}
	// Start Sales Report**************************************************************************************************************
	public function sales()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['searchpath']='hm/lotdata/search';
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/sales_main',$data);
		
		
		
	}
	 function get_forcast_report()
	 {
			
			$data['month']=$month=$this->uri->segment(5);
			$data['year']=$year=$this->uri->segment(6);
			
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=$year;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
		
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->hm_report_model->get_reservation_data_forsalsesforcast($prjraw->prj_id);
				if($transferlist[$prjraw->prj_id]){
					 
					foreach($transferlist[$prjraw->prj_id] as $raw)
					{
						$paidcap[$raw->res_code]=0;
						$paidadvance[$raw->res_code]=0;
						$adpaylist[$raw->res_code]=0;
						$rentpaylist[$raw->res_code]=0;
						$forcast[$raw->res_code]=0;
						if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
						{
							
							$loandata=$this->hm_report_model->get_loandata_byrescode($raw->res_code);
							if($loandata)
							{
							$paidcap[$raw->res_code]=$this->hm_report_model->get_paid_capital($loandata->loan_code);
							$rentpaylist[$raw->res_code]=$this->hm_report_model->get_paylist_capital($loandata->loan_code);
							}
						}
						$paidadvance[$raw->res_code]=$this->hm_report_model->get_paid_advance($raw->res_code);
						$adpaylist[$raw->res_code]=$this->hm_report_model->get_paylist_advance($raw->res_code);
						
						$forcast[$raw->res_code]=$this->hm_report_model->get_month_forcast($prjraw->prj_id,$month,$year,$raw->res_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['transferlist']=$transferlist;
		$data['paidcap']=$paidcap;
		$data['paidadvance']=$paidadvance;
		$data['rentpaylist']=$rentpaylist;
		$data['adpaylist']=$adpaylist;
		$data['forcast']=$forcast;
		$data['details']=$details;
		}
		
		$this->load->view('hm/report/sales_forcast',$data);
		
	 }
	  function get_posummery()
	 {
			
			$data['month']=$month=$this->uri->segment(5);
			$data['year']=$year=$this->uri->segment(6);
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=$year;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
		
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_officerlist($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$target[$prjraw->prj_id]=$this->hm_report_model->get_month_target($prjraw->prj_id,$month,$year,$prjraw->officer_code);
					$totadvance[$prjraw->prj_id]=$this->hm_report_model->get_month_advance($prjraw->prj_id,$stdate,$enddate);
					$totcapital[$prjraw->prj_id]=$this->hm_report_model->get_month_capital($prjraw->prj_id,$stdate,$enddate);
				
			}
			$data['target']=$target;
		$data['totadvance']=$totadvance;
		$data['totcapital']=$totcapital;
		}
		
	
		$this->load->view('hm/report/sales_posummery',$data);
		
	 }
	
	public function branch_report()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		$data['searchpath']='hm/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/branchrpt_main',$data);
		
		
		
	}
	
	function get_branchrpt()
	{ 
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['details']=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		$data['stock']=$this->hm_report_model->lot_pending_total($prj_id)	;
		$data['stocklist']=$this->hm_report_model->lot_pending_list($prj_id)	;
		$data['settled']=$this->hm_report_model->get_settled_reservation_data($prj_id)	;
		$data['settledlist']=$this->hm_report_model->get_settled_reservation_list($prj_id)	;
		$data['initsettled']=$this->hm_report_model->get_init_settled($prj_id)	;
		$data['initsettledlist']=$this->hm_report_model->get_init_settled_list($prj_id)	;
		
		
		$data['nep']=$this->hm_report_model->get_NEP_reservation_data($prj_id)	;
		$data['neplist']=$this->hm_report_model->get_NEP_reservation_list($prj_id)	;
		
		
		
		
		$data['epb']=$this->hm_report_model->get_EPB_reservation_data($prj_id)	;
		$data['epblist']=$this->hm_report_model->get_EPB_reservation_list($prj_id)	;
		
		$data['zep']=$this->hm_report_model->get_ZEP_reservation_data($prj_id)	;
		$data['zeplist']=$this->hm_report_model->get_ZEP_reservation_list($prj_id)	;
		$data['zep_profit']=$this->hm_report_model->get_ZEP_reservation_data_profit($prj_id)	;
		$data['adv']=$this->hm_report_model->get_Advance_reservation_data($prj_id)	;
		$data['advlist']=$this->hm_report_model->get_Advance_reservation_list($prj_id)	;
		$data['adv_profit']=$this->hm_report_model->get_Advance_reservation_data_profit($prj_id)	;
		$data['all']=$this->hm_report_model->lot_all_total($prj_id)	;
		
		//  budget report Details
		
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		//$details[$prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
			
			//details related to pichart data
			$start=$prjdetails->date_slscommence;
			$end=date('Y-m-d');
			$counter=0;
			$currentsale=0;
			$colelction=0;
				
			
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			//$details=NULL;
			
			$reservation[$prj_id]=$this->hm_report_model->get_project_paymeny_task($prj_id);
			$data['reservation']=$reservation;
				//$data['details']=$details;
		
			
		$this->load->view('hm/report/branchrpt_data',$data);
	}
	
	public function arrears_report()
	{
		$data=NULL;
		$data['cashcount']="1000";//$this->summery_model->today_cash_sales_sum();
		$data['creditcount']="2000";//$this->summery_model->today_credit_sales_sum();
		$data['posum']="3000";//$this->summery_model->today_purchase_sum();
	//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		$data['searchpath']='hm/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('hm/report/arrears_main',$data);
		
		
		
	}
	function arrears_data()
	{
		$data['month']=$month=$this->uri->segment(4);
		$data['year']=$year=$this->uri->segment(6);
			
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=$year;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
			
			$arrearspay=NULL;
			$thispay=NULL;
			$credtipay=NULL;
			$transferlist=NULL;
			$feedback=NULL;
			$startpayment=NULL;
				$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->hm_report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){
					 
					foreach($transferlist[$prjraw->prj_id] as $raw)
					{
						
						
							$arrearspay[$raw->res_code]=$this->hm_report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->hm_report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							//	echo $raw->loan_code.'-'.$startpayment[$raw->res_code].'<br>';
							}
							$credtipay[$raw->res_code]=$this->hm_report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->hm_report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->hm_report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				//print_r($details[$prjraw->prj_id]) ;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}
		
		$this->load->view('hm/report/arrears_data',$data);
	}
	function arreas_data_excel()
	{
		$data['month']=$month=$this->uri->segment(4);
			$data['year']=$year=$this->uri->segment(6);
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=$year;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
			
			$arrearspay=NULL;
			$thispay=NULL;
			$credtipay=NULL;
			$transferlist=NULL;
					$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
	
		//$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->hm_report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){
					 
					foreach($transferlist[$prjraw->prj_id] as $raw)
					{
						
						
							$arrearspay[$raw->res_code]=$this->hm_report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->hm_report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->hm_report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->hm_report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->hm_report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}
		
		$this->load->view('hm/report/arrears_data_excel',$data);
	}
	function arreas_data_excel_ins()
	{
		$data['month']=$month=$this->uri->segment(4);
				$data['year']=$year=$this->uri->segment(6);
					if($month=='01' ||$month=='02' || $month=='03')
					{ 
			
						$yeararr=explode('-',$this->session->userdata('fy_end'));
					}
					else
					{
						$yeararr=explode('-',$this->session->userdata('fy_start'));
					}
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		
					$year=$year;
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
			
			$arrearspay=NULL;
			$thispay=NULL;
			$credtipay=NULL;
			$transferlist=NULL;
					$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
	
		//$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->hm_report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){
					 
					foreach($transferlist[$prjraw->prj_id] as $raw)
					{
						
						
							$arrearspay[$raw->res_code]=$this->hm_report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->hm_report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->hm_report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->hm_report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->hm_report_model->loan_final_feedback($raw->loan_code);
							
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
			}
				$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}
		
		$this->load->view('hm/report/arrears_data_excel_ins',$data);
	}
	function get_finance()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['details']=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$expence=NULL;
		$dpcollect=NULL;
			
			//details related to pichart data
			$start=$prjdetails->date_proposal;
			$srat=explode('-',$start);
			$year=$srat[0];
			$month=$srat[1];
			$startDate=$year.'-'.$month.'-01';
				
			
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$startDate;
				
			for($i=1; $i<=24; $i++)
			{
				
				$startDate=$startDate;
				$datearr=explode('-',$startDate);
				$year=$datearr[0];
				$month=$datearr[1];
				$enddate=$year.'-'.$month.'-31';
			//	echo $enddate;
				$expence[$i]=$this->hm_report_model->get_project_month_expence($prj_id,$startDate,$enddate);
				$dpcollect[$i]=$this->hm_report_model->get_project_month_income($prj_id,$startDate,$enddate);
				
				
				$startDate=date('Y-m-d',strtotime('+1 months',strtotime($startDate)));
			}
			
					
					
				
			//print_r($lotlist);
			$data['details']=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		
				$data['expence']=$expence;
				$data['dpcollect']=$dpcollect;
		
			$this->load->view('hm/report/provition_finance.php',$data);	
		
	}
	function get_finance_summery()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);	
	//	$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($this->session->userdata('branchid'));
			//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		//echo $branchid;
		$expence=NULL;
		$dpcollect=NULL;
		$details=NULL;	
			//details related to pichart data
			//$start=$prjdetails->date_proposal;
			
				
				if($prjlist)
				{
					foreach($prjlist as $prjraw)
					{
					//	$expence[$prjraw->prj_id]=$this->hm_report_model->get_project_all_expence($prjraw->prj_id);
						$dpcollect[$prjraw->prj_id]=$this->hm_report_model->get_project_all_income($prjraw->prj_id);
						$details[$prjraw->prj_id]=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
						$financecost[$prjraw->prj_id]=$this->hm_lotdata_model->get_finance_cost($prjraw->prj_id);
						
						$start=$details[$prjraw->prj_id]->date_proposal;
						$srat=explode('-',$start);
						$year=$srat[0];
						$month=$srat[1];
						$startDate=$year.'-'.$month.'-01';
				
			
						$enddate=date("Y-m-d");
						$data['reportdata']=$enddate;
						$data['sartdate']=$startDate;
					$startDate=$startDate;
				
						$totinti=0;
						$cumulativeout=0;
						$cumulativein=0;
						$prjid=$prjraw->prj_id;
					for($i=1; $i<=24; $i++)
					{
						if($startDate<date('Y-m-d')){
					
						$datearr=explode('-',$startDate);
						$year=$datearr[0];
						$month=$datearr[1];
						$enddate=$year.'-'.$month.'-31';
			//	echo $enddate;
						$expence[$i]=$this->hm_report_model->get_project_month_expence($prjid,$startDate,$enddate);
						$dpcollect[$i]=$this->hm_report_model->get_project_month_income($prjid,$startDate,$enddate);
				//$expence[$i]=0;
				//$dpcollect[$i]=0;
				
						$startDate=date('Y-m-d',strtotime('+1 months',strtotime($startDate)));
						$cumulativeout=$cumulativeout+$expence[$i];
						$cumulativein=$cumulativein+$dpcollect[$i];
						$netflow=$cumulativein-$cumulativeout;
						$intcost=0;
							if($netflow<0)
							{
								$intcost=$netflow*(-1)*1.5/100;
							}
							else $intcost=$netflow*1.5/100;
							$totinti=$totinti+$intcost;
						 }
					}
						
						$intcostfull[$prjraw->prj_id]=$totinti;
						
						
					}
				}
				
				$data['financecost']=$financecost;
				$data['intcostfull']=$intcostfull;
				$data['expence']=$expence;
				$data['dpcollect']=$dpcollect;
				$data['details']=$details;
				$data['expence']=$expence;
				$data['dpcollect']=$dpcollect;
		
			$this->load->view('hm/report/provition_finance_summery.php',$data);	
		
	}
	
	function get_provition_summery()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);		
		//$details[$prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
			
			
				$enddate=date("Y-m-d");
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
		
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			//$details=NULL;
			$tasklist=$this->hm_report_model->task_list();	
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					foreach($tasklist as $raw)
					{
						
						$reservation[$prjraw->prj_id][$raw->task_id]=$this->hm_report_model->get_project_budget_by_task($prjraw->prj_id,$raw->task_id);
							
						$prevpayment[$prjraw->prj_id][$raw->task_id]=$this->hm_report_model->get_project_payment_by_task($prjraw->prj_id,$raw->task_id);
					}
					$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
				}
					
			}
					
					
				
			//print_r($lotlist);
				$data['tasklist']=$tasklist;
					$data['prevpayment']=$prevpayment;
					$data['reservation']=$reservation;
				$data['details']=$details;
		
			$this->load->view('hm/report/provition_prov_summery.php',$data);	
		
	}
    
    
    
    function arrears_data_date()
	{
		$data['date']=$date=$this->uri->segment(4);
			
					
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		      $yeararr=explode('-',$date);
					$year=$yeararr[0];
					$stdate=$year.'-'.$yeararr[1].'-01';
					$enddate=$date;
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
			
			$arrearspay=NULL;
			$thispay=NULL;
			$credtipay=NULL;
			$transferlist=NULL;
				$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->hm_report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){
					 
					foreach($transferlist[$prjraw->prj_id] as $raw)
					{
						
						
							$arrearspay[$raw->res_code]=$this->hm_report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->hm_report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->hm_report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->hm_report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->hm_report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}
		
		$this->load->view('hm/report/arrears_data_date',$data);
	}
    function arreas_data_date_excel()
	{
		$data['date']=$date=$this->uri->segment(4);
			
					
		//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
		      $yeararr=explode('-',$date);
					$year=$yeararr[0];
					$stdate=$year.'-'.$yeararr[1].'-01';
					$enddate=$date;
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;
				
			
			$arrearspay=NULL;
			$thispay=NULL;
			$credtipay=NULL;
			$transferlist=NULL;
				$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->hm_report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){
					 
					foreach($transferlist[$prjraw->prj_id] as $raw)
					{
						
						
							$arrearspay[$raw->res_code]=$this->hm_report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->hm_report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->hm_report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->hm_report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->hm_report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}
		
		$this->load->view('hm/report/arrears_data_date_excel',$data);
	}

	 /*Ticket No:2734 Added by Madushan 2021.04.30*/
	function payment_report(){
		$data['lot_data'] = $this->hm_report_model->get_hm_lotdata();
		$this->load->view('hm/report/payment_report_main',$data);
	}

	function get_payment_report(){
		$lot_id = $this->uri->segment(4);
		$data['fromdate']=$fromdate = $this->uri->segment(5);
		$data['todate']=$todate = $this->uri->segment(6);
		$data['report_data'] = $this->hm_report_model->get_payment_report_data($lot_id,$fromdate,$todate);
		
		$this->load->view('hm/report/payment_report',$data);

	}

	 /*End of Ticket No:2734*/

	}
	
	

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */