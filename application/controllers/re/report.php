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

		$this->load->model("project_model");
	    $this->load->model("lotdata_model");
		$this->load->model("salesmen_model");
		$this->load->model("branch_model");
		$this->load->model("reservation_model");
		$this->load->model("eploan_model");
		$this->load->model("report_model");
		$this->load->model("sales_model");
		$this->load->model("summery_model");
		$this->load->model("customer_model");
		$this->load->model("redashboard_model");
		$this->load->model("projectpayment_model");
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
		redirect('re/project/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_report'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/project/');
			return;
		}





	}
	function get_branch_projectlist()
	{

		$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		$this->load->view('re/report/project_list',$data);

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

		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
					$this->load->view('re/report/profit_main',$data);



	}
		public function profit_sum()
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

		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
					$this->load->view('re/report/profit_main_semmery',$data);



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

		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/report/profitshedule_main',$data);



	}

	function get_profit()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['transferlist']=$transferlist=$this->report_model->get_profittransfer_data($this->uri->segment(5))	;
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

				$loandata=$this->report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->report_model->get_lotdata($raw->lot_id);
			}}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(5))	;
		$data['projecttots']=$this->report_model->get_lot_summery($this->uri->segment(5))	;
		$data['selabalecount']=$this->report_model->get_selabale_count($this->uri->segment(5))	;

		$this->load->view('re/report/profit_summery',$data);
	}
	function get_profit_print()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['transferlist']=$transferlist=$this->report_model->get_profittransfer_data($this->uri->segment(4))	;
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

				$loandata=$this->report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->report_model->get_lotdata($raw->lot_id);
			}}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['projecttots']=$this->report_model->get_lot_summery($this->uri->segment(4))	;
		$data['selabalecount']=$this->report_model->get_selabale_count($this->uri->segment(4))	;

		$this->load->view('re/report/print_profit_summery',$data);
	}

	function get_profit_month_project()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
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
		$data['transferlist']=$transferlist=$this->report_model->get_profittransfer_data_period($this->uri->segment(4),$this->uri->segment(5),$stdate,$enddate)	;
		$lotdata=NULL;
		$resdata=NULL;
		$paidcap=NULL;
		$paidadvance=NULL;
		$data['todate']=$enddate;
		if($transferlist){

		//	print_r($planlist);
		foreach($transferlist as $raw)
		{
			$paidcap[$raw->res_code]=0;
			$paidadvance[$raw->res_code]=0;
			if($raw->pay_type=='NEP' || $raw->pay_type=='ZEP'|| $raw->pay_type=='EPB')
			{

				$loandata=$this->report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->report_model->get_lotdata($raw->lot_id);
			}
		}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(5));
		$data['projecttots']=$this->report_model->get_lot_summery($this->uri->segment(5));
		$data['selabalecount']=$this->report_model->get_selabale_count($this->uri->segment(5))	;

		$this->load->view('re/report/profit_summery',$data);
	}

	function get_profit_month_project_print()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
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
		$data['transferlist']=$transferlist=$this->report_model->get_profittransfer_data_period($this->uri->segment(4),$stdate,$enddate)	;
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

				$loandata=$this->report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->report_model->get_lotdata($raw->lot_id);
			}}
		//print_r($lotlist);
		$data['paidadvance']=$paidadvance;
		$data['lotdata']=$lotdata;
		$data['paidcap']=$paidcap;
		$data['details']=$this->project_model->get_project_bycode($this->uri->segment(4))	;
		$data['projecttots']=$this->report_model->get_lot_summery($this->uri->segment(4))	;
		$data['selabalecount']=$this->report_model->get_selabale_count($this->uri->segment(4))	;

		$this->load->view('re/report/print_profit_summery',$data);
	}
	function get_profit_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
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
			$transferlist[$prjraw->prj_id][$month]=$this->report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;
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
					$transferlist[$prjraw->prj_id][$month2]=$this->report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;

					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));

				}
			}

			$projecttots[$prjraw->prj_id]=$this->report_model->get_lot_summery($prjraw->prj_id);
			$selabalecount[$prjraw->prj_id]=$this->report_model->get_selabale_count($prjraw->prj_id);
			$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id);


		//	print_r($planlist);

		}
		//print_r($transferlist);
		$data['transferlist']=$transferlist;
		$data['details']=$details	;
		$data['projecttots']=$projecttots	;
		$data['selabalecount']=$selabalecount	;

		$this->load->view('re/report/profit_summery_all',$data);
	}

	function get_profits_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
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

			$data['transferlist'][$prjraw->prj_id]=$transferlist=$this->report_model->get_profittransfer_data_period($branchid,$prjraw->prj_id,$stdate,$enddate)	;
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

				$loandata=$this->report_model->get_loandata_byrescode($raw->res_code);
				if($loandata)
				{
				$paidcap[$raw->res_code]=$this->report_model->get_paid_capital($loandata->loan_code);
				}
			}
			$paidadvance[$raw->res_code]=$this->report_model->get_paid_advance($raw->res_code);
			$lotdata[$raw->res_code]=$this->report_model->get_lotdata($raw->lot_id);
			}
		}
		//print_r($lotlist);
		$data['paidadvance'][$prjraw->prj_id]=$paidadvance;
		$data['lotdata'][$prjraw->prj_id]=$lotdata;
		$data['paidcap'][$prjraw->prj_id]=$paidcap;
		$data['details'][$prjraw->prj_id]=$this->project_model->get_project_bycode($this->uri->segment(5));
		$data['projecttots'][$prjraw->prj_id]=$this->report_model->get_lot_summery($this->uri->segment(5));
		$data['selabalecount'][$prjraw->prj_id]=$this->report_model->get_selabale_count($this->uri->segment(5))	;


		//	print_r($planlist);

		}
		//print_r($transferlist);

		$this->load->view('re/report/profitshedule_summery',$data);
	}

	function get_profit_all_print()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
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
			$transferlist[$prjraw->prj_id][$month]=$this->report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;
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
					$transferlist[$prjraw->prj_id][$month2]=$this->report_model->get_profittransfer_data_period_sum($prjraw->prj_id,$stdate,$enddate)	;

					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));

				}
			}

			$projecttots[$prjraw->prj_id]=$this->report_model->get_lot_summery($prjraw->prj_id);
			$selabalecount[$prjraw->prj_id]=$this->report_model->get_selabale_count($prjraw->prj_id);
			$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id);


		//	print_r($planlist);

		}
		//print_r($transferlist);
		$data['transferlist']=$transferlist;
		$data['details']=$details	;
		$data['projecttots']=$projecttots	;
		$data['selabalecount']=$selabalecount	;

		$this->load->view('re/report/print_profit_summery_all',$data);
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
		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/report/stock_main',$data);



	}

	function get_stock()
	{

		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
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
			$pendinglot[$prj_id]=$this->report_model->pending_lotdata_count($prj_id);
			$fulllot[$prj_id]=$this->report_model->full_lotdata_count($prj_id);
			$lastmont[$prj_id]=$this->report_model->lastmonth_reservation_count($prj_id,$stdate,$lastmonthstdate,$lastmonthstenddate);

			$lotdata[$prj_id]=$this->report_model->pending_lotdata($prj_id);
			$reslots[$prj_id]=$this->report_model->thismonth_reservation_lots($prj_id,$stdate,$enddate);
			$details[$prj_id]=$this->project_model->get_project_bycode($prj_id)	;


			$data['reslots']=$reslots;
				$data['fulllot']=$fulllot;
		$data['pendinglot']=$pendinglot;
		$data['lotdata']=$lotdata;
		$data['lastmont']=$lastmont;
		$data['details']=$details	;


		//print_r($lotlist);


		$this->load->view('re/report/stock_report_prj',$data);
	}
	function get_stock_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['branchid']=$branchid=$this->uri->segment(4);

		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
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
			$pendinglot[$prjraw->prj_id]=$this->report_model->pending_lotdata_count($prjraw->prj_id);
			$fulllot[$prjraw->prj_id]=$this->report_model->full_lotdata_count($prjraw->prj_id);
			$lastmont[$prjraw->prj_id]=$this->report_model->lastmonth_reservation_count($prjraw->prj_id,$lastmonthstdate,$lastmonthstenddate);

			$lotdata[$prjraw->prj_id]=$this->report_model->pending_lotdata($prjraw->prj_id);
			$reslots[$prjraw->prj_id]=$this->report_model->thismonth_reservation_lots($prjraw->prj_id,$stdate,$enddate);
			$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
		}

			$data['reslots']=$reslots;
				$data['fulllot']=$fulllot;
		$data['pendinglot']=$pendinglot;
		$data['lotdata']=$lotdata;
		$data['lastmont']=$lastmont;
		$data['details']=$details	;

		}
		//print_r($lotlist);


		$this->load->view('re/report/stock_report',$data);
	}
	function get_stock_all_print()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
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
			$pendinglot[$prjraw->prj_id]=$this->report_model->pending_lotdata_count($prjraw->prj_id);
			$fulllot[$prjraw->prj_id]=$this->report_model->full_lotdata_count($prjraw->prj_id);
			$lastmont[$prjraw->prj_id]=$this->report_model->lastmonth_reservation_count($prjraw->prj_id,$lastmonthstdate,$lastmonthstenddate);

			$lotdata[$prjraw->prj_id]=$this->report_model->pending_lotdata($prjraw->prj_id);
			$reslots[$prjraw->prj_id]=$this->report_model->thismonth_reservation_lots($prjraw->prj_id,$stdate,$enddate);
			$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
		}
		}
		//print_r($lotlist);
			$data['reslots']=$reslots;
				$data['fulllot']=$fulllot;
		$data['pendinglot']=$pendinglot;
		$data['lotdata']=$lotdata;
		$data['lastmont']=$lastmont;
		$data['details']=$details	;

		$this->load->view('re/report/print_stock_report',$data);
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
		$data['searchpath']='re/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/report/collection_main',$data);



	}


	function get_collection_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
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
						$data['reportdata']=$data['todate']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$data['todate']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$zepprevpayment=NULL;
			$details=NULL;
			$zepthispayment=NULL;
			$zepthisreceipts=NULL;
			$month_shedule=NULL;
			$settlepayment=NULL;
			$zepsettlereceipts=NULL;
			$dpthisreceipts=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->report_model->reservation_lots_befor($prjraw->prj_id,$enddate,$stdate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->res_code]=true;
							$prevpayment[$resraw->res_code]=0;
							if($resraw->pay_type=='NEP' || $resraw->pay_type=='ZEP'|| $resraw->pay_type=='EPB')
							$currentlist[$resraw->res_code]=$this->report_model->check_loan_befordate($resraw->res_code,$stdate);
							$prevpayment[$resraw->res_code]=$this->report_model->advance_sum_befoer_date($resraw->res_code,$stdate);
							$thispayment[$resraw->res_code]=$this->report_model->advance_sum_this_month($resraw->res_code,$stdate,$enddate);
							$dpthisreceipts[$resraw->res_code]=$this->report_model->down_payment_month_receipts($resraw->res_code,$stdate,$enddate);
						}
					}
					//$zepreservation[$prjraw->prj_id]=$this->report_model->zepploans_befor($prjraw->prj_id,$enddate);
					$zepreservation[$prjraw->prj_id]=$this->report_model->zepploans_befor_collection($prjraw->prj_id,$stdate,$enddate);

					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
							$zepprevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date_withoutreshed($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->report_model->loan_payment_month_withoutreshed($resraw->loan_code,$stdate,$enddate);
							//2021-07-15 end ticket 3079 by nadee
							$zepthisreceipts[$resraw->loan_code]=$this->report_model->loan_payment_month_receipts($resraw->loan_code,$stdate,$enddate);
							$month_shedule[$resraw->loan_code]=$this->report_model->get_current_month_details($resraw->loan_code,$stdate,$enddate);

							//Ticket No:3317 Added By Madushan 2021-08-19
							$settlepayment[$resraw->loan_code]=$this->report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
							$zepsettlereceipts[$resraw->loan_code]=$this->report_model->loan_settlements_month_receipts($resraw->loan_code,$stdate,$enddate);

						}
					}

					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}

					$data['zepreservation']=$zepreservation;
					$data['zepprevpayment']=$zepprevpayment;
					$data['zepthispayment']=$zepthispayment;
				$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
			$data['prevpayment']=$prevpayment;
			$data['thispayment']=$thispayment;

			$data['details']=$details	;

			//$this->load->view('re/report/collection_dp_all',$data);
			$data['month_shedule']=$month_shedule;
			$data['zepthisreceipts']=$zepthisreceipts;
			$data['settlepayment']=$settlepayment;
			$data['zepsettlereceipts']=$zepsettlereceipts;
			$data['dpthisreceipts']=$dpthisreceipts;

			//$this->load->view('re/report/collection_dp_all',$data);
			if($this->uri->segment(5)=='04'){
				$this->load->view('re/report/collection_zep_all',$data);
			}else{
				$this->load->view('re/report/collection_dp_all',$data);
			}
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
			$epthisreceipts=NULL;
			$epsettlereceipts=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->report_model->eploans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
							$prevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
								$settlepayment[$resraw->loan_code]=$this->report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
							$epsettlereceipts[$resraw->loan_code]=$this->report_model->loan_settlements_month_receipts($resraw->loan_code,$stdate,$enddate);
							$epthisreceipts[$resraw->loan_code]=$this->report_model->loan_payment_month_receipts($resraw->loan_code,$stdate,$enddate);
						}
						
					}


					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}


					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details;
					$data['settlepayment']=$settlepayment;
					$data['epthisreceipts']=$epthisreceipts;
					$data['epsettlereceipts']=$epsettlereceipts;


					$this->load->view('re/report/collection_ep_all',$data);

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
			$epbsettlereceipts=NULL;
			$epbthisreceipts=NULL;
			$settlepayment=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->report_model->epbloans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->report_model->caclulate_epb_interest($resraw->loan_code,$enddate);
							$prevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
							$settlepayment[$resraw->loan_code]=$this->report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
							$epbsettlereceipts[$resraw->loan_code]=$this->report_model->loan_settlements_month_receipts($resraw->loan_code,$stdate,$enddate);
							$epbthisreceipts[$resraw->loan_code]=$this->report_model->loan_payment_month_receipts($resraw->loan_code,$stdate,$enddate);
						}
					}


					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}


					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;
					$data['epbsettlereceipts']=$epbsettlereceipts;
					$data['epbthisreceipts']=$epbthisreceipts;
					$this->load->view('re/report/collection_loan_all',$data);

			}

			//print_r($lotlist);

		}

	}
	function get_collection()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery_prj($prj_id);
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
						$data['reportdata']=$data['todate']=$enddate;
					$data['sartdate']=$stdate;
					}
			else
			{
				$enddate=date("Y-m-d");
				$data['reportdata']=$data['todate']=$enddate;
				$data['sartdate']=$stdate=date('Y').'-'.date('m').'-01';
			}
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$zepprevpayment=NULL;
			$details=NULL;
			$zepthispayment=NULL;
			$zepthisreceipts=NULL;
			$month_shedule=NULL;
			$settlepayment=NULL;
			$zepsettlereceipts=NULL;
			$dpthisreceipts=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->report_model->reservation_lots_befor($prjraw->prj_id,$enddate,$stdate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->res_code]=true;
							$prevpayment[$resraw->res_code]=0;
							if($resraw->pay_type=='NEP' || $resraw->pay_type=='ZEP'|| $resraw->pay_type=='EPB')
							$currentlist[$resraw->res_code]=$this->report_model->check_loan_befordate($resraw->res_code,$stdate);
							$prevpayment[$resraw->res_code]=$this->report_model->advance_sum_befoer_date($resraw->res_code,$stdate);
							$thispayment[$resraw->res_code]=$this->report_model->advance_sum_this_month($resraw->res_code,$stdate,$enddate);
							$dpthisreceipts[$resraw->res_code]=$this->report_model->down_payment_month_receipts($resraw->res_code,$stdate,$enddate);
						}
					}
				//	$zepreservation[$prjraw->prj_id]=$this->report_model->zepploans_befor($prjraw->prj_id,$enddate);
				$zepreservation[$prjraw->prj_id]=$this->report_model->zepploans_befor_collection($prjraw->prj_id,$stdate,$enddate);

					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
							$zepprevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date_withoutreshed($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->report_model->loan_payment_month_withoutreshed($resraw->loan_code,$stdate,$enddate);
							//2021-07-15 end ticket 3079 by nadee
							$zepthisreceipts[$resraw->loan_code]=$this->report_model->loan_payment_month_receipts($resraw->loan_code,$stdate,$enddate);
							$month_shedule[$resraw->loan_code]=$this->report_model->get_current_month_details($resraw->loan_code,$stdate,$enddate);
							//Ticket No:3317 Added By Madushan 2021-08-19
							$settlepayment[$resraw->loan_code]=$this->report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
							$zepsettlereceipts[$resraw->loan_code]=$this->report_model->loan_settlements_month_receipts($resraw->loan_code,$stdate,$enddate);

						}
					}

					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}

					$data['zepreservation']=$zepreservation;
					$data['zepprevpayment']=$zepprevpayment;
					$data['zepthispayment']=$zepthispayment;
				$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
			$data['prevpayment']=$prevpayment;
			$data['thispayment']=$thispayment;

			$data['details']=$details	;

			//$this->load->view('re/report/collection_dp_all',$data);
			$data['month_shedule']=$month_shedule;
			$data['zepthisreceipts']=$zepthisreceipts;
			$data['settlepayment']=$settlepayment;
			$data['zepsettlereceipts']=$zepsettlereceipts;
			$data['dpthisreceipts'] = $dpthisreceipts;

			//$this->load->view('re/report/collection_dp_all',$data);
			if($this->uri->segment(5)=='04'){
				$this->load->view('re/report/collection_zep_all',$data);
			}else{
				$this->load->view('re/report/collection_dp_all',$data);
			}
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
			$epsettlereceipts=NULL;
			$epthisreceipts=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->report_model->eploans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
							$prevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
								$settlepayment[$resraw->loan_code]=$this->report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
							$epsettlereceipts[$resraw->loan_code]=$this->report_model->loan_settlements_month_receipts($resraw->loan_code,$stdate,$enddate);
							$epthisreceipts[$resraw->loan_code]=$this->report_model->loan_payment_month_receipts($resraw->loan_code,$stdate,$enddate);
						}
					}


					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}


					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;
					$data['epsettlereceipts']=$epsettlereceipts;
					$data['epthisreceipts']=$epthisreceipts;


					$this->load->view('re/report/collection_ep_prj',$data);

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
			$epbsettlereceipts=NULL;
			$epbthisreceipts=NULL;
			$settlepayment=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{
					$reservation[$prjraw->prj_id]=$this->report_model->epbloans_befor($prjraw->prj_id,$enddate);
					if($reservation[$prjraw->prj_id])
					{
						foreach($reservation[$prjraw->prj_id] as $resraw)
						{
							$currentlist[$resraw->loan_code]=true;
							$prevpayment[$resraw->loan_code]=0;
							$inttots[$resraw->loan_code]=$this->report_model->caclulate_epb_interest($resraw->loan_code,$enddate);
							$prevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$thispayment[$resraw->loan_code]=$this->report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
							$settlepayment[$resraw->loan_code]=$this->report_model->loan_settlepayment_month($resraw->loan_code,$stdate,$enddate);
							$epbsettlereceipts[$resraw->loan_code]=$this->report_model->loan_settlements_month_receipts($resraw->loan_code,$stdate,$enddate);
							$epbthisreceipts[$resraw->loan_code]=$this->report_model->loan_payment_month_receipts($resraw->loan_code,$stdate,$enddate);
						}
						
					}


					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}


					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
					$data['settlepayment']=$settlepayment;
					$data['epbsettlereceipts']=$epbsettlereceipts;
					$data['epbthisreceipts']=$epbthisreceipts;
					$this->load->view('re/report/collection_loan_all',$data);

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
		$data['searchpath']='re/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/report/provition_main',$data);



	}
	function get_provition()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
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

					$reservation[$prj_id]=$this->report_model->get_project_paymeny_task($prj_id);
					if($reservation[$prj_id])
					{
						foreach($reservation[$prj_id] as $resraw)
						{

							 $currentlist[$resraw->id]=$this->report_model->get_paymentlist($prj_id,$resraw->task_id,$enddate);
						}
					}




			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['currentlist']=$currentlist;
				$data['details']=$details;

			$this->load->view('re/report/provition_prov.php',$data);

	}

	//Ticket No:3378 Updated By Madushan 2021-09-02
	function get_budget()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery_prj($prj_id);
		
		//$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		// $label=NULL;
		// $sales=NULL;
		// $dpcollect=NULL;

			//details related to pichart data
			// $start=$prjdetails->date_slscommence;
			// $end=date('Y-m-d');
			// $counter=0;
			// $currentsale=0;
			// $colelction=0;

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
			echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

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
			// $currentlist=NULL;
			// $prevpayment=NULL;
			// $thispayment=NULL;
			//$details=NULL;

					
			if($prjlist){
				foreach($prjlist as $row){
					$reservation[$row->prj_id]=$this->report_model->get_project_paymeny_task($row->prj_id);
					
				}
			}
					

			//print_r($lotlist);
				$data['reservation']=$reservation;
				// $data['details']=$details;

			$this->load->view('re/report/provition_budget.php',$data);

	}

	function get_unbudget()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		$data['prjlist']=$prjlist=$this->report_model->get_all_Unbudgeted_project_summery($branchid);
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
					$reservation[$prj_id]=$this->report_model->get_project_paymeny_task($prj_id);
					if($reservation[$prj_id])
					{
						foreach($reservation[$prj_id] as $resraw)
						{

							 $currentlist[$resraw->id]=$this->report_model->get_paymentlist_daterange($prj_id,$resraw->task_id,$stdate,$enddate);
						}
					}
					$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;


			}}

			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['currentlist']=$currentlist;
				$data['details']=$details;

			$this->load->view('re/report/provition_unbudget.php',$data);

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
		$data['searchpath']='re/lotdata/search';
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/report/sales_main',$data);



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
		$data['searchpath']='re/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					$this->load->view('re/report/branchrpt_main',$data);



	}

	function get_branchrpt()
	{
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['details']=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
		$data['stock']=$this->report_model->lot_pending_total($prj_id)	;
		$data['stocklist']=$this->report_model->lot_pending_list($prj_id)	;
		//print_r($data['stock']);
		$data['settled']=$this->report_model->get_settled_reservation_data($prj_id)	;
		$data['settledlist']=$this->report_model->get_settled_reservation_list($prj_id)	;
		$data['initsettled']=$this->report_model->get_init_settled($prj_id)	;
		$data['initsettledlist']=$this->report_model->get_init_settled_list($prj_id)	;


		$data['nep']=$this->report_model->get_NEP_reservation_data($prj_id)	;
		$data['neplist']=$this->report_model->get_NEP_reservation_list($prj_id)	;




		$data['epb']=$this->report_model->get_EPB_reservation_data($prj_id)	;
		$data['epblist']=$this->report_model->get_EPB_reservation_list($prj_id)	;

		$data['zep']=$this->report_model->get_ZEP_reservation_data($prj_id)	;
		$data['zeplist']=$this->report_model->get_ZEP_reservation_list($prj_id)	;
		$data['zep_profit']=$this->report_model->get_ZEP_reservation_data_profit($prj_id)	;
		$data['dpcomplete']=$this->report_model->get_dpcomplete_reservation_data($prj_id)	;
		$data['dpcompletelist']=$this->report_model->get_dpcomplete_reservation_list($prj_id)	;
		$data['adv']=$this->report_model->get_Advance_reservation_data($prj_id)	;
		$data['advlist']=$this->report_model->get_Advance_reservation_list($prj_id)	;
		$data['adv_profit']=$this->report_model->get_Advance_reservation_data_profit($prj_id)	;
		$data['all']=$this->report_model->lot_all_total($prj_id)	;

		//  budget report Details

		$data['prj_id']=$prj_id=$this->uri->segment(4);
		//$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
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

			$reservation[$prj_id]=$this->report_model->get_project_paymeny_task($prj_id);
			$data['reservation']=$reservation;
				//$data['details']=$details;


		$this->load->view('re/report/branchrpt_data',$data);
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
		$data['searchpath']='re/lotdata/search';
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
		 //Ticket No-3055|Added By Uvini
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
					$this->load->view('re/report/arrears_main',$data);



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
			$feedback = NULL;
			$startpayment = NULL;
				$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){

					foreach($transferlist[$prjraw->prj_id] as $raw)
					{


							$arrearspay[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							//	echo $raw->loan_code.'-'.$startpayment[$raw->res_code].'<br>';
							}
							$credtipay[$raw->res_code]=$this->report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}

		$this->load->view('re/report/arrears_data',$data);
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);

		//$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){

					foreach($transferlist[$prjraw->prj_id] as $raw)
					{


							$arrearspay[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}

		$this->load->view('re/report/arrears_data_excel',$data);
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);

		//$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){

					foreach($transferlist[$prjraw->prj_id] as $raw)
					{


							$arrearspay[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->report_model->loan_final_feedback($raw->loan_code);

					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
			}
				$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}

		$this->load->view('re/report/arrears_data_excel_ins',$data);
	}
	function get_finance()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['details']=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
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
				$expence[$i]=$this->report_model->get_project_month_expence($prj_id,$startDate,$enddate);
				$dpcollect[$i]=$this->report_model->get_project_month_income($prj_id,$startDate,$enddate);


				$startDate=date('Y-m-d',strtotime('+1 months',strtotime($startDate)));
			}




			//print_r($lotlist);
			$data['details']=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;

				$data['expence']=$expence;
				$data['dpcollect']=$dpcollect;

			$this->load->view('re/report/provition_finance.php',$data);

	}
	function get_finance_summery()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
	//	$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
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
					//	$expence[$prjraw->prj_id]=$this->report_model->get_project_all_expence($prjraw->prj_id);
						$dpcollect[$prjraw->prj_id]=$this->report_model->get_project_all_income($prjraw->prj_id);
						$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
						$financecost[$prjraw->prj_id]=$this->lotdata_model->get_finance_cost($prjraw->prj_id);

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
						$expence[$i]=$this->report_model->get_project_month_expence($prjid,$startDate,$enddate);
						$dpcollect[$i]=$this->report_model->get_project_month_income($prjid,$startDate,$enddate);
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

			$this->load->view('re/report/provition_finance_summery.php',$data);

	}

	function get_provition_summery()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		//$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
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
			$tasklist=$this->report_model->task_list();
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					foreach($tasklist as $raw)
					{

						$reservation[$prjraw->prj_id][$raw->task_id]=$this->report_model->get_project_budget_by_task($prjraw->prj_id,$raw->task_id);

						$prevpayment[$prjraw->prj_id][$raw->task_id]=$this->report_model->get_project_payment_by_task($prjraw->prj_id,$raw->task_id);
					}
					$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
				}

			}



			//print_r($lotlist);
				$data['tasklist']=$tasklist;
					$data['prevpayment']=$prevpayment;
					$data['reservation']=$reservation;
				$data['details']=$details;

			$this->load->view('re/report/provition_prov_summery.php',$data);

	}



    function arrears_data_date()
	{
		$data['date']=$date=$this->uri->segment(4);
		$type=$this->uri->segment(6);
		//Ticket No-3055|Added By Uvini
		$prj_id=$this->uri->segment(7);
		$loan_type = '';

		/*Ticket No:2983,2984,2985 Added By Madushan 2021.06.30*/
		if($type == '01')
			$loan_type = 'NEP';
		if($type == '02')
			$loan_type = 'EPB';
		if($type == '03')
			$loan_type = 'ZEP';


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
			$due_rentals = NULL;
			$current_month_details = NULL;
			$last_payment_date = NULL;
			$current_month_payment_date = NULL;
				$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid,$prj_id);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data($prjraw->prj_id,$stdate,$loan_type);
				if($transferlist[$prjraw->prj_id]){

					foreach($transferlist[$prjraw->prj_id] as $raw)
					{


							$arrearspay[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->report_model->loan_final_feedback($raw->loan_code);

							/*Ticket No:2983,2984,2985 Added By Madushan 2021.06.30*/
							$due_rentals[$raw->loan_code]=$this->report_model->get_no_of_due_rentals($raw->loan_code,$enddate);
							$current_month_details[$raw->loan_code]=$this->report_model->get_current_month_details($raw->loan_code,$stdate,$enddate);
							$last_payment_date[$raw->loan_code]=$this->report_model->get_loan_last_payment_date($raw->loan_code,$enddate);
							$current_month_payment_date[$raw->loan_code] = $this->report_model->get_current_month_payment($raw->loan_code,$stdate,$enddate);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;

		/*Ticket No:2983,2984,2985 Added By Madushan 2021.06.30*/
		$data['due_rentals']=$due_rentals;
		$data['current_month_details']=$current_month_details;
		$data['last_payment_date']=$last_payment_date;
		$data['current_month_payment_date']=$current_month_payment_date;
		}


		/*Ticket No:2983,2984,2985 Added By Madushan 2021.06.30*/
		if($type == '01')
			$this->load->view('re/report/ep_arrears_report',$data);
		if($type == '02')
			$this->load->view('re/report/epb_arrears_report',$data);
		if($type == '03')
			 $this->load->view('re/report/zep_arreas_report',$data);
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data($prjraw->prj_id,$stdate);
				if($transferlist[$prjraw->prj_id]){

					foreach($transferlist[$prjraw->prj_id] as $raw)
					{


							$arrearspay[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$loanpayment=$this->report_model->loan_payment_befoer_date($raw->loan_code,$stdate);
							$startpayment[$raw->res_code]=0;
							if($loanpayment)
							{
								$startpayment[$raw->res_code]=$loanpayment->sum_cap+$loanpayment->sum_int;
							}
							$credtipay[$raw->res_code]=$this->report_model->get_eploan_credit_tot($raw->loan_code,$stdate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_payment_month($raw->loan_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->report_model->loan_final_feedback($raw->loan_code);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['feedback']=$feedback;
			$data['startpayment']=$startpayment;
			$data['transferlist']=$transferlist;
			$data['details']=$details;
		$data['arrearspay']=$arrearspay;
		$data['credtipay']=$credtipay;
		$data['thispay']=$thispay;
		}



	}


	// sales forcast report n



	  function get_posummery()
	 {

			$data['month']=$month=$this->uri->segment(5);


					$data['year']=$year=$this->uri->segment(6);
					$stdate=$year.'-'.$month.'-01';
					$enddate=$year.'-'.$month.'-31';
						$data['reportdata']=$enddate;
					$data['sartdate']=$stdate;


		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_officerlist($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
				$mblock=0;$msales=0;$mtarget=0;$issettarget=false;
				$targetdata=$this->report_model->get_month_target($prjraw->prj_id,$month,$year,$prjraw->officer_code);
					if($targetdata)
					{	$mblock=$targetdata->blocks;
						$msales=$targetdata->sales;
						$mtarget=$targetdata->target;
						$issettarget=true;
					}
					$settarget[$prjraw->prj_id]=$issettarget;
					$target[$prjraw->prj_id]=$mtarget;
					$block[$prjraw->prj_id]=$mblock;
					$sales[$prjraw->prj_id]=$msales;
					$totblocks[$prjraw->prj_id]=$this->report_model->get_tot_finalized_blocks($prjraw->prj_id,$stdate,$enddate);
					$totsales[$prjraw->prj_id]=$this->report_model->get_tot_finalized_sales($prjraw->prj_id,$stdate,$enddate);
					$totadvance[$prjraw->prj_id]=$this->report_model->get_month_advance($prjraw->prj_id,$stdate,$enddate);
					$totdownpayment[$prjraw->prj_id]=$this->report_model->get_tot_sale_downpayment($prjraw->prj_id,$stdate,$enddate);
					$reserlist[$prjraw->prj_id]=$this->report_model->get_tot_sale_reservationlist($prjraw->prj_id,$stdate,$enddate);
					$totcapital[$prjraw->prj_id]=$this->report_model->get_month_capital($prjraw->prj_id,$stdate,$enddate);

			}
			$data['totdownpayment']=$totdownpayment;
			$data['reserlist']=$reserlist;
			$data['settarget']=$settarget;
			$data['target']=$target;
			$data['block']=$block;
			$data['sales']=$sales;
			$data['totadvance']=$totadvance;
			$data['totcapital']=$totcapital;
			$data['totblocks']=$totblocks;
			$data['totsales']=$totsales;
		}


		$this->load->view('re/report/sales_posummery',$data);

	 }

	 function get_forcast_report()
	 {

			$data['month']=$month=$this->uri->segment(5);
				$data['type']=$type=$this->uri->segment(6);

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

		$data['year']=$year=$this->uri->segment(7);
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_officerlist($branchid);
		$date=$year.'-'.$month.'-01';
		$enddate=$year.'-'.$month.'-31';
		$thismonthpay=NULL;
		$monthtarget=NULL;
		$paidtots=NULL;
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,$type);
				if($transferlist[$prjraw->prj_id]){

					foreach($transferlist[$prjraw->prj_id] as $raw)
					{

						$thismonthpay[$raw->res_code]=0;
						$paidtots[$raw->res_code]=0;
						$forcast[$raw->res_code]=0;

							$thismonthpay[$raw->loan_code]=$this->report_model->loan_paid_amounts_current_month($raw->loan_code,$date,$enddate,$raw->reschdue_sqn);
						 $paidtots[$raw->loan_code]=$this->report_model->loan_paid_amounts_befordate($raw->loan_code,$date,$raw->reschdue_sqn);

						$monthtarget[$raw->loan_code]=$this->sales_model->get_month_forcast($prjraw->prj_id,$month,$year,$raw->loan_code);
						 $arrears[$raw->loan_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$date,$raw->reschdue_sqn);
					}
				}
				$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
			}
			$data['arrears']=$arrears;
			$data['transferlist']=$transferlist;
		$data['paidtots']=$paidtots;
		$data['thismonthpay']=$thismonthpay;
		$data['monthtarget']=$monthtarget;
		$data['details']=$details;

		}

		$this->load->view('re/report/sales_forcast',$data);

	 }

	 //Ticket No-2902 | Added By Uvini
	 function budget_comparison_report(){
	 	$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
	 	$this->load->view('re/report/budget_comparison_report_main',$data);
	 }

	 //2021-06-29 ticket 2986 by nadee
	 public function arrears_report_advance()
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
		 $data['searchpath']='re/lotdata/search';
			$data['branchlist']=$this->branch_model->get_all_branches_summery();
		 $data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
					 $this->load->view('re/report/advance_arrears_main',$data);



	 }
	 function arrears_data_advance()
	 {
		 $data['date']=$date=$this->uri->segment(4);
		 //Ticket No-3055|Added By Uvini
		 $prj_id=$this->uri->segment(6);


			//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');
						$yeararr=explode('-',$date);
						$year=$yeararr[0];
						$stdate=$year.'-'.$yeararr[1].'-01';
						$enddate=$date;
							$data['reportdata']=$enddate;
						$data['sartdate']=$stdate;


				$arrearspay=NULL;
				$thispay=NULL;
				$shedule_count=NULL;
			$shedule_data=NULL;
				$transferlist=NULL;
			$feedback=Null;
			$startpayment=NULL;
					$data['branchid']=$branchid=$this->uri->segment(5);
			$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid,$prj_id);
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
						$transferlist[$prjraw->prj_id]=$this->report_model->get_advance_arrears_data($prjraw->prj_id,$stdate);
					$details[$prjraw->prj_id]=$prjdetails=$this->project_model->get_project_bycode($prjraw->prj_id)	;
					if($transferlist[$prjraw->prj_id])
					{
						foreach ($transferlist[$prjraw->prj_id] as $key => $raw) {
							$thispay[$raw->res_code]=$this->report_model->get_month_advance_byrescode($raw->res_code,$stdate,$enddate);
							$feedback[$raw->res_code]=$this->report_model->loan_final_feedback($raw->res_code);
							$shedule_count[$raw->res_code]=$this->report_model->resevation_shedule_count($raw->res_code);
							if($shedule_count[$raw->res_code]>0){
								$shedule_data[$raw->res_code]=$this->report_model->resevation_shedule_data($raw->res_code);
							}
						}
					}

				}
				$data['feedback']=$feedback;
				$data['startpayment']=$startpayment;
				$data['transferlist']=$transferlist;
				$data['details']=$details;
			$data['arrearspay']=$arrearspay;
			$data['shedule_count']=$shedule_count;
		$data['shedule_data']=$shedule_data;
			$data['thispay']=$thispay;
			}


		 $this->load->view('re/report/advance_arrears_data',$data);
	 }
	 //2021-06-29 end ticket 2986 by nadee

	 //Ticket No:3300 Added By Madushan 2021-08-16
	 function stock_sales_collection_report()
	 {	
	 	$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
	 	$this->load->view('re/report/stc_sal_col_main',$data);
	 }

	 function stock_sales_collection_report_data()
	 {	
	 	$data['date']=$date = $this->uri->segment(4);
	 	$prj_id = $this->uri->segment(5);
	 	$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery_date('ALL',$prj_id,$date);
	 	if($prjlist)
	 	{ 
	 		$all_blocks = null;
	 		$all_reservations = null;
	 		$sold_lots = null;
	 		$dp_collection = null;
	 		$loan_payment = null;
	 		$settlepayment = null;
	 		$prj_budget = null;
	 		foreach($prjlist as $row)
	 		{
	 			$all_blocks[$row->prj_id] = $this->report_model->get_all_blocks_asAt_date($row->prj_id,$date);
	 			$sold_lots[$row->prj_id] = $this->report_model->get_all_sold_lots_befor_date($row->prj_id,$date);
	 			$all_reservations[$row->prj_id]=$allreservations = $this->report_model->get_all_reservations_by_project($row->prj_id);
	 			$prj_budget[$row->prj_id]=$this->report_model->get_project_paymeny_task($row->prj_id);
	 			if($allreservations){
	 				foreach($allreservations as $res)
	 				{
	 					$dp_collection[$res->res_code] = $this->report_model->advance_sum_as_at_date($res->res_code,$date);
	 					if($res->pay_type == 'NEP' || $res->pay_type == 'ZEP' || $res->pay_type == 'EPB')
	 					{
	 						$loan_payment[$res->res_code] = $this->report_model->loan_payment_as_at_date($res->res_code,$date);
	 						$settlepayment[$res->res_code] = $this->report_model->loan_settlepayment_as_at_date($res->res_code,$date);
	 					}

	 				}
	 			}
	 		}


	 	}
	 	
	 	$data['all_blocks'] = $all_blocks;
	 	$data['sold_lots'] = $sold_lots;
	 	$data['all_reservations'] = $all_reservations;
	 	$data['dp_collection'] = $dp_collection;
	 	$data['loan_payment'] = $loan_payment;
	 	$data['settlepayment'] = $settlepayment;
	 	$data['prj_budget'] = $prj_budget;

	 	$this->load->view('re/report/stc_sal_col_data',$data);
	 }

	 //End of Ticket No:3300 2021-08-16



	}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
