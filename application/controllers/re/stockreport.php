	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockreport extends CI_Controller {

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
			$this->load->model("stockreport_model");
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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
					$this->load->view('re/stockreport/stock_main',$data);



	}

	function get_stock()
	{

		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$data['type']=$type=$this->uri->segment(5);
		$data['todate']=$todate=$this->uri->segment(6);
		$data['branchid']=$branchid=$this->uri->segment(7);
		$data['prjlist']=$prjlist=$this->stockreport_model->get_all_project_summery($branchid,$prj_id,$todate);


		foreach($prjlist as $prjraw)
		{
			$lotdata[$prjraw->prj_id]=$this->stockreport_model->get_full_lot_list($prjraw->prj_id);
		}
		$data['lotdata']=$lotdata;
		//$this->load->view('re/stockreport/stock_report',$data);
		if($type=='03'){
			$this->load->view('re/stockreport/monthly_stock_report',$data);
		}else{
			$this->load->view('re/stockreport/stock_report',$data);//updated by nadee 2021-06-08
		}
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
						}
					}
					$zepreservation[$prjraw->prj_id]=$this->report_model->zepploans_befor($prjraw->prj_id,$enddate);
					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
							$zepprevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date_withoutreshed($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->report_model->loan_payment_month_withoutreshed($resraw->loan_code,$stdate,$enddate);
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

			$this->load->view('re/report/collection_dp_all',$data);
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
					$data['settlepayment']=$settlepayment;;

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
		$data['settlepayment']=$settlepayment;;
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
						}
					}
					$zepreservation[$prjraw->prj_id]=$this->report_model->zepploans_befor($prjraw->prj_id,$enddate);
					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
							$zepprevpayment[$resraw->loan_code]=$this->report_model->loan_payment_befoer_date_withoutreshed($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->report_model->loan_payment_month_withoutreshed($resraw->loan_code,$stdate,$enddate);
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

			$this->load->view('re/report/collection_dp_all',$data);
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
					$data['settlepayment']=$settlepayment;;

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
		$data['settlepayment']=$settlepayment;;
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
	function get_budget()
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





			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['details']=$details;

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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
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

		$this->load->view('re/report/arrears_data_date',$data);
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

		$this->load->view('re/report/arrears_data_date_excel',$data);
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

//added by nadee 2021-06-09
	 function get_stock_monthly()
	 {

		 if ( ! check_access('view_report'))
		 {

			 $this->session->set_flashdata('error', 'Permission Denied');
			 redirect('re/report/profit_main/');
			 return;
		 }

		 $data['prj_id']=$prj_id=$this->uri->segment(4);
		 $data['type']=$type=$this->uri->segment(5);
	 $data['month']=$month=$this->uri->segment(6);
	 $data['year']=$year=$this->uri->segment(8);
		 //$data['todate']=$todate=$this->uri->segment(6);
		 $data['branchid']=$branchid=$this->uri->segment(7);
		 $todate=date($year.'-'.$month.'-'.'05');//get date 05 because of February
	 $data['todate']=$todate=date('Y-m-t',strtotime($todate));
		 $data['prjlist']=$prjlist=$this->stockreport_model->get_all_project_summery($branchid,$prj_id,$todate);


		 foreach($prjlist as $prjraw)
		 {
			 $lotdata[$prjraw->prj_id]=$this->stockreport_model->get_full_lot_list($prjraw->prj_id);
		 }
		 $data['lotdata']=$lotdata;
		 if($type=='03'){
			 $this->load->view('re/stockreport/monthly_stock_report',$data);
		 }else{
			 $this->load->view('re/stockreport/stock_report',$data);
		 }

	 }



	}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
