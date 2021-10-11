<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loanreport extends CI_Controller {

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
		$this->load->model("sales_model");
		$this->load->model("branch_model");
		$this->load->model("reservation_model");
		$this->load->model("eploan_model");
		$this->load->model("report_model");
		$this->load->model("loanreport_model");
		$this->load->model("summery_model");
		$this->load->model("customer_model");
		$this->load->model("redashboard_model");
		$this->load->model("projectpayment_model");
		$this->is_logged_in();

    }

	public function index()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('config/home');
			return;
		}
		redirect('re/project/showall');



	}
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
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
	
	//get stock report print to date end

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
					$this->load->view('re/loanreport/collection_main',$data);



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
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);

	//	echo 'sssss'.$this->uri->segment(6);
		//Down Payment Report Generation
	
			if($this->uri->segment(5)=='03')
			{
				$data['month']=$month='';
				$data['reName']=$reName="Bank Loan";
				$data['retype']='03';
				$data['enddate']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
				$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;
				if($prjlist){
					foreach($prjlist as $prjraw)
					{

						$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
						$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,"EPB");
						if($transferlist[$prjraw->prj_id]){

							foreach($transferlist[$prjraw->prj_id] as $raw)
							{
								$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
								$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							}
						}
						$reshedulelist[$prjraw->prj_id]=$this->report_model->get_eploan_data_reshedule($prjraw->prj_id,$fromdate,$enddate,"EPB");
					if($reshedulelist[$prjraw->prj_id]){

						foreach($reshedulelist[$prjraw->prj_id] as $raw1)
						{
							$relastpay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$todate,$raw1->reschdue_sqn);
							$rethispay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$fromdate,$raw1->reschdue_sqn);
						}
					}
					}
				}

						$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['rethispay']=$rethispay;
					$data['relastpay']=$relastpay;

						$this->load->view('re/loanreport/collection_pf_all',$data);

			}
		if($this->uri->segment(5)=='04')
		{
			$data['month']=$month='';
			$data['reName']=$reName="Personal Fund";
			$data['retype']='04';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;

			if($prjlist){
				foreach($prjlist as $prjraw)
				{

					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,"ZEP");
					if($transferlist[$prjraw->prj_id]){

						foreach($transferlist[$prjraw->prj_id] as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
					$reshedulelist[$prjraw->prj_id]=$this->report_model->get_eploan_data_reshedule($prjraw->prj_id,$fromdate,$enddate,"ZEP");
					if($reshedulelist[$prjraw->prj_id]){

						foreach($reshedulelist[$prjraw->prj_id] as $raw1)
						{
							$relastpay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$todate,$raw1->reschdue_sqn);
							$rethispay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$fromdate,$raw1->reschdue_sqn);
						}
					}
				}
			}

					$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['rethispay']=$rethispay;
					$data['relastpay']=$relastpay;
					$this->load->view('re/loanreport/collection_pf_all',$data);

		}
		if($this->uri->segment(5)=='05')
		{

			$data['month']=$month='';
			$data['reName']=$reName="NEP";
			$data['retype']='05';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$arrearspay=NULL;
			$lastpay=NULL;
			$lastshedule=NULL;
			$thishedule=NULL;
			$di=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{

					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
					$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,"NEP");
					if($transferlist[$prjraw->prj_id]){

						foreach($transferlist[$prjraw->prj_id] as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							$di[$raw->res_code]=$this->report_model->loan_paid_di($raw->loan_code,$fromdate,$todate);
							$lastshedule[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thishedule[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
				}
			}

						$data['dicollection']=$di;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['lastshedule']=$lastshedule;
					$data['thishedule']=$thishedule;

					$this->load->view('re/loanreport/collection_mep_all',$data);

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
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($this->session->userdata('branchid'));
		$data['prj_id']=$prj_id=$this->uri->segment(4);
		$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
		
		if($this->uri->segment(5)=='03')
		{
			$data['month']=$month='';
			$data['reName']=$reName="Bank Loan";
			$data['retype']='03';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;


					$details[$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
					$transferlist[$prj_id]=$this->report_model->get_eploan_data_other($prj_id,$enddate,"EPB");
					if($transferlist[$prj_id]){

						foreach($transferlist[$prj_id] as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
					$reshedulelist[$prj_id]=$this->report_model->get_eploan_data_reshedule($prj_id,$fromdate,$enddate,"EPB");
					if($reshedulelist[$prj_id]){

						foreach($reshedulelist[$prj_id] as $raw1)
						{
							$relastpay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$todate,$raw1->reschdue_sqn);
							$rethispay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$fromdate,$raw1->reschdue_sqn);
						}
					}

					$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['rethispay']=$rethispay;
					$data['relastpay']=$relastpay;
//echo  $data['retype'];
					$this->load->view('re/loanreport/collection_pf_prj',$data);

		}
		if($this->uri->segment(5)=='04')
		{
			$data['month']=$month='';
			$data['reName']=$reName="Personal Fund";
			$data['retype']='04';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;


					$details[$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
					$transferlist[$prj_id]=$this->report_model->get_eploan_data_other($prj_id,$enddate,"ZEP");
					if($transferlist[$prj_id]){

						foreach($transferlist[$prj_id] as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
					$reshedulelist[$prj_id]=$this->report_model->get_eploan_data_reshedule($prj_id,$fromdate,$enddate,"ZEP");
					if($reshedulelist[$prj_id]){

						foreach($reshedulelist[$prj_id] as $raw1)
						{
							$relastpay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$todate,$raw1->reschdue_sqn);
							$rethispay[$raw1->res_code]=$this->report_model->loan_paid_amounts_collection_re($raw1->loan_code,$fromdate,$raw1->reschdue_sqn);
						}
					}


					$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['rethispay']=$rethispay;
					$data['relastpay']=$relastpay;

					$this->load->view('re/loanreport/collection_pf_prj',$data);

		}
		if($this->uri->segment(5)=='05')
		{
			$data['month']=$month='';
			$data['reName']=$reName="NEP";
			$data['retype']='05';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$lastshedule=NULL;
			$thishedule=NULL;
$di=NULL;

					$details[$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
					$transferlist[$prj_id]=$this->report_model->get_eploan_data_other($prj_id,$enddate,"NEP");
					if($transferlist[$prj_id]){

						foreach($transferlist[$prj_id] as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							$lastshedule[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$todate,$raw->reschdue_sqn);
								$di[$raw->res_code]=$this->report_model->loan_paid_di($raw->loan_code,$fromdate,$todate);
							$thishedule[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}

$data['dicollection']=$di;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['lastshedule']=$lastshedule;
					$data['thishedule']=$thishedule;

					$this->load->view('re/loanreport/collection_mep_prj',$data);

		}

	}
	
	
	
	
	
	
	public function follow_upreport()
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
					$this->load->view('re/loanreport/followup_main',$data);



	}

	
	function get_followup_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		$data['fromdate']=$fromdate=date('Y-m-d');
		$data['todate']=$todate=date('Y-m-d');

	//	echo 'sssss'.$this->uri->segment(6);
		//Down Payment Report Generation
	
			if($this->uri->segment(5)=='03')
			{
				$data['month']=$month='';
				$data['reName']=$reName="Bank Loan";
				$data['retype']='03';
				$data['enddate']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
				$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;
				

					//	$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
						$transferlist=$this->loanreport_model->get_eploan_data_other($branchid,"EPB");
						if($transferlist){

							foreach($transferlist as $raw)
							{
								$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
								$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							}
						}
						
					
				

						$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['rethispay']=$rethispay;
					$data['relastpay']=$relastpay;

						$this->load->view('re/loanreport/followup_pf_all',$data);

			}
		if($this->uri->segment(5)=='04')
		{
			$data['month']=$month='';
			$data['reName']=$reName="Personal Fund";
			$data['retype']='04';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;

			

				//	$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
					$transferlist=$this->loanreport_model->get_eploan_data_other($branchid,"ZEP");
					if($transferlist){

						foreach($transferlist as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
					
					
				

					$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['rethispay']=$rethispay;
					$data['relastpay']=$relastpay;
					$this->load->view('re/loanreport/followup_pf_all',$data);

		}
		if($this->uri->segment(5)=='05')
		{

			$data['month']=$month='';
			$data['reName']=$reName="NEP";
			$data['retype']='05';
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$arrearspay=NULL;
			$lastpay=NULL;
			$lastshedule=NULL;
			$thishedule=NULL;
			$di=NULL;
			

					
					$transferlist=$this->loanreport_model->get_eploan_data($branchid,"NEP");
					if($transferlist){

						foreach($transferlist as $raw)
						{
							$lastpay[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							$di[$raw->res_code]=$this->report_model->loan_paid_di($raw->loan_code,$fromdate,$todate);
							$lastshedule[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thishedule[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
				

						$data['dicollection']=$di;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['thispay']=$thispay;
					$data['lastpay']=$lastpay;
					$data['lastshedule']=$lastshedule;
					$data['thishedule']=$thishedule;

					$this->load->view('re/loanreport/followup_mep_all',$data);

		}
	}
	
	
	function get_summery_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);

	//	echo 'sssss'.$this->uri->segment(6);
		//Down Payment Report Generation
	
				$data['month']=$month='';
				$data['reName']=$reName="Bank Loan";
				$data['retype']='03';
				$data['enddate']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
				$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$lastpay=NULL;
			$relastpay=NULL;
			$rethispay=NULL;
			
			
			
		
			$transferlist=NULL;
			$details=NULL;
			$thispay=NULL;
			$arrearspay=NULL;
			$lastpay=NULL;
			$lastshedule=NULL;
			$thishedule=NULL;
			$di=NULL;
			if($prjlist){
				foreach($prjlist as $prjraw)
				{

					$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
					
					$transferlist_EPB[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,"EPB");
						if($transferlist_EPB[$prjraw->prj_id]){

							foreach($transferlist_EPB[$prjraw->prj_id] as $raw)
							{
								$lastpay_EPB[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
								$thispay_EPB[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							}
						}
					
					$transferlist_ZEP[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,"ZEP");
					if($transferlist_ZEP[$prjraw->prj_id]){

						foreach($transferlist_ZEP[$prjraw->prj_id] as $raw)
						{
							$lastpay_ZEP[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay_ZEP[$raw->res_code]=$this->report_model->loan_paid_amounts_collection($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
					$transferlist_NEP[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,"NEP");
					if($transferlist_NEP[$prjraw->prj_id]){

						foreach($transferlist_NEP[$prjraw->prj_id] as $raw)
						{
							$lastpay_NEP[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thispay_NEP[$raw->res_code]=$this->report_model->loan_paid_amounts($raw->loan_code,$fromdate,$raw->reschdue_sqn);
							$di[$raw->res_code]=$this->report_model->loan_paid_di($raw->loan_code,$fromdate,$todate);
							$lastshedule_NEP[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$todate,$raw->reschdue_sqn);
							$thishedule_NEP[$raw->res_code]=$this->report_model->get_eploan_arrears_tot($raw->loan_code,$fromdate,$raw->reschdue_sqn);
						}
					}
				}
			}

								$data['details']=$details	;
							
					$data['transferlist_ZEP']=$transferlist_ZEP;
					$data['thispay_ZEP']=$thispay_ZEP;
					$data['lastpay_ZEP']=$lastpay_ZEP;
							
						$data['transferlist_EPB']=$transferlist_EPB;
					$data['thispay_EPB']=$thispay_EPB;
					$data['lastpay_EPB']=$lastpay_EPB;	
							
					$data['transferlist_NEP']=$transferlist_NEP;
				
					$data['thispay_NEP']=$thispay_NEP;
					$data['lastpay_NEP']=$lastpay_NEP;
					$data['lastshedule_NEP']=$lastshedule_NEP;
					$data['thishedule_NEP']=$thishedule_NEP;

					$this->load->view('re/loanreport/summery_all',$data);

		
	}
	
	
	public function delayint_report()
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
					$this->load->view('re/loanreport/delayint_main',$data);



	}

	function get_delayint_all()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);

	//	echo 'sssss'.$this->uri->segment(6);
		//Down Payment Report Generation
	
			if($this->uri->segment(5)=='03')
			{
					$data['reName']=$reName="Bank Loan";
					$type='EPB';
			}
			else if($this->uri->segment(5)=='04')
			{
				$data['reName']=$reName="Personal Fund";
					$type='ZEP';
			}
			else
			{$data['reName']=$reName="Normal Easy Payment";
					$type='NEP';
			}
				$data['month']=$month='';
				$data['retype']=$this->uri->segment(5);
				$data['enddate']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
				$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$paid=NULL;
			$waivoff=NULL;
			$repaid=NULL;
			$rewaivoff=NULL;
				if($prjlist){
					foreach($prjlist as $prjraw)
					{

						$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
						$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,$type);
						if($transferlist[$prjraw->prj_id]){

							foreach($transferlist[$prjraw->prj_id] as $raw)
							{
								$paid[$raw->res_code]=$this->report_model->loan_paid_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
								
								//if($paid[$raw->res_code])echo $raw->old_code.'-'.$paid[$raw->res_code]->totdi.'<br>';
								
								$waivoff[$raw->res_code]=$this->report_model->loan_waiveoff_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
							}
						}
						$reshedulelist[$prjraw->prj_id]=$this->report_model->get_eploan_data_reshedule($prjraw->prj_id,$fromdate,$enddate,$type);
						if($reshedulelist[$prjraw->prj_id]){

						foreach($reshedulelist[$prjraw->prj_id] as $raw1)
						{
							$repaid[$raw1->res_code]=$this->report_model->loan_paid_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
							$rewaivoff[$raw1->res_code]=$this->report_model->loan_waiveoff_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
						}
					}
					}
				}

						$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['paid']=$paid;
					$data['waivoff']=$waivoff;
					$data['repaid']=$repaid;
					$data['rewaivoff']=$rewaivoff;

						$this->load->view('re/loanreport/delayint_all',$data);

			
		

		
	}
	function get_delayint()
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
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
		
		if($this->uri->segment(5)=='03')
			{
					$data['reName']=$reName="Bank Loan";
					$type='EPB';
			}
			else if($this->uri->segment(5)=='04')
			{
				$data['reName']=$reName="Personal Fund";
					$type='ZEP';
			}
			else
			{$data['reName']=$reName="Normal Easy Payment";
					$type='NEP';
			}
			$data['month']=$month='';
			//$data['reName']=$reName="Bank Loan";
			$data['retype']=$this->uri->segment(5);
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$reshedulelist=NULL;
			$transferlist=NULL;
			$paid=NULL;
			$waivoff=NULL;
			$repaid=NULL;
			$rewaivoff=NULL;


					$details[$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
					$transferlist[$prj_id]=$this->report_model->get_eploan_data_other($prj_id,$enddate,$type);
					if($transferlist[$prj_id]){

						foreach($transferlist[$prj_id] as $raw)
						{
								$paid[$raw->res_code]=$this->report_model->loan_paid_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
								$waivoff[$raw->res_code]=$this->report_model->loan_waiveoff_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
						}
					}
					$reshedulelist[$prj_id]=$this->report_model->get_eploan_data_reshedule($prj_id,$fromdate,$enddate,$type);
					if($reshedulelist[$prj_id]){

						foreach($reshedulelist[$prj_id] as $raw1)
						{
							$repaid[$raw1->res_code]=$this->report_model->loan_paid_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
							$rewaivoff[$raw1->res_code]=$this->report_model->loan_waiveoff_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
					}
					}

					$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['paid']=$paid;
					$data['waivoff']=$waivoff;
					$data['repaid']=$rewaivoff;
					$data['rewaivoff']=$rewaivoff;
//echo  $data['retype'];
					$this->load->view('re/loanreport/delayint_prjl',$data);

		

	}
	
	function get_delayint_all_excel()
	{
		if ( ! check_access('view_report'))
		{

			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('re/report/profit_main/');
			return;
		}

		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery($branchid);
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);

	//	echo 'sssss'.$this->uri->segment(6);
		//Down Payment Report Generation
	
			if($this->uri->segment(5)=='03')
			{
					$data['reName']=$reName="Bank Loan";
					$type='EPB';
			}
			else if($this->uri->segment(5)=='04')
			{
				$data['reName']=$reName="Personal Fund";
					$type='ZEP';
			}
			else
			{$data['reName']=$reName="Normal Easy Payment";
					$type='NEP';
			}
				$data['month']=$month='';
				$data['retype']=$this->uri->segment(5);
				$data['enddate']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
				$reshedulelist=NULL;
			$transferlist=NULL;
			$details=NULL;
			$paid=NULL;
			$waivoff=NULL;
			$repaid=NULL;
			$rewaivoff=NULL;
				if($prjlist){
					foreach($prjlist as $prjraw)
					{

						$details[$prjraw->prj_id]=$this->project_model->get_project_bycode($prjraw->prj_id)	;
						$transferlist[$prjraw->prj_id]=$this->report_model->get_eploan_data_other($prjraw->prj_id,$enddate,$type);
						if($transferlist[$prjraw->prj_id]){

							foreach($transferlist[$prjraw->prj_id] as $raw)
							{
								$paid[$raw->res_code]=$this->report_model->loan_paid_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
								
								//if($paid[$raw->res_code])echo $raw->old_code.'-'.$paid[$raw->res_code]->totdi.'<br>';
								
								$waivoff[$raw->res_code]=$this->report_model->loan_waiveoff_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
							}
						}
						$reshedulelist[$prjraw->prj_id]=$this->report_model->get_eploan_data_reshedule($prjraw->prj_id,$fromdate,$enddate,$type);
						if($reshedulelist[$prjraw->prj_id]){

						foreach($reshedulelist[$prjraw->prj_id] as $raw1)
						{
							$repaid[$raw1->res_code]=$this->report_model->loan_paid_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
							$rewaivoff[$raw1->res_code]=$this->report_model->loan_waiveoff_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
						}
					}
					}
				}

						$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['paid']=$paid;
					$data['waivoff']=$waivoff;
					$data['repaid']=$repaid;
					$data['rewaivoff']=$rewaivoff;

						$this->load->view('re/loanreport/delayint_all_excel',$data);

			
		

		
	}
	
	
	function get_delayint_excel()
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
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		//echo $this->uri->segment(4);
		//Down Payment Report Generation
		$label=NULL;
		$sales=NULL;
		$dpcollect=NULL;
		
		if($this->uri->segment(5)=='03')
			{
					$data['reName']=$reName="Bank Loan";
					$type='EPB';
			}
			else if($this->uri->segment(5)=='04')
			{
				$data['reName']=$reName="Personal Fund";
					$type='ZEP';
			}
			else
			{$data['reName']=$reName="Normal Easy Payment";
					$type='NEP';
			}
			$data['month']=$month='';
			//$data['reName']=$reName="Bank Loan";
			$data['retype']=$this->uri->segment(5);
			$data['enddate']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;
			$reshedulelist=NULL;
			$transferlist=NULL;
			$paid=NULL;
			$waivoff=NULL;
			$repaid=NULL;
			$rewaivoff=NULL;


					$details[$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
					$transferlist[$prj_id]=$this->report_model->get_eploan_data_other($prj_id,$enddate,$type);
					if($transferlist[$prj_id]){

						foreach($transferlist[$prj_id] as $raw)
						{
								$paid[$raw->res_code]=$this->report_model->loan_paid_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
								$waivoff[$raw->res_code]=$this->report_model->loan_waiveoff_amounts_DI($raw->loan_code,$fromdate,$todate,$raw->reschdue_sqn);
						}
					}
					$reshedulelist[$prj_id]=$this->report_model->get_eploan_data_reshedule($prj_id,$fromdate,$enddate,$type);
					if($reshedulelist[$prj_id]){

						foreach($reshedulelist[$prj_id] as $raw1)
						{
							$repaid[$raw1->res_code]=$this->report_model->loan_paid_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
							$rewaivoff[$raw1->res_code]=$this->report_model->loan_waiveoff_amounts_DI_re($raw1->loan_code,$fromdate,$todate,$raw1->reschdue_sqn);
					}
					}

					$data['reshedulelist']=$reshedulelist;
					$data['transferlist']=$transferlist;
					$data['details']=$details	;
					$data['paid']=$paid;
					$data['waivoff']=$waivoff;
					$data['repaid']=$rewaivoff;
					$data['rewaivoff']=$rewaivoff;
//echo  $data['retype'];
					$this->load->view('re/loanreport/delayint_prjl_excel',$data);

		

	}
	
	
	
	
	}
	
	
	
	



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
