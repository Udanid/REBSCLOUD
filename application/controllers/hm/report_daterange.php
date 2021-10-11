	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_daterange extends CI_Controller {

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
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('user');
			return;
		}
		redirect('hm/project/showall');
		
		
		
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
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		$data['type']=$type=$this->uri->segment(5);
		

		//Down Payment Report Generation
		if($this->uri->segment(5)=='01' || $this->uri->segment(5)=='04')
		{
			
		$data['month']=$month=$this->uri->segment(6);
		
				//$enddate=date("Y-m-d");
				$data['reportdata']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
			
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
							$zepprevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
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
			$data['reportdata']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
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
				
				$data['settlepayment']=$settlepayment;
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
		
					$this->load->view('hm/report/collection_loan_all',$data);	
				
			}
				
			
			
			//print_r($lotlist);
				
		}
		if($this->uri->segment(5)=='03')
			{	
		//	echo 'sss';
			$data['month']=$month=$this->uri->segment(6);
			$data['reportdata']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
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
				
					$data['settlepayment']=$settlepayment;
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
		
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
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		$data['type']=$type=$this->uri->segment(5);
		

		//Down Payment Report Generation
		if($this->uri->segment(5)=='01' || $this->uri->segment(5)=='04')
		{
			
		$data['month']=$month=$this->uri->segment(6);
		
				//$enddate=date("Y-m-d");
				$data['reportdata']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
			
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
							$zepprevpayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_befoer_date($resraw->loan_code,$stdate);
							$zepthispayment[$resraw->loan_code]=$this->hm_report_model->loan_payment_month($resraw->loan_code,$stdate,$enddate);
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
			$data['reportdata']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
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
				
				$data['settlepayment']=$settlepayment;
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
		
					$this->load->view('hm/report/collection_loan_all',$data);	
				
			}
				
			
			
			//print_r($lotlist);
				
		}
		if($this->uri->segment(5)=='03')
			{	
		//	echo 'sss';
			$data['month']=$month=$this->uri->segment(6);
			$data['reportdata']=$enddate=$todate;
				$data['sartdate']=$stdate=$fromdate;
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
				
					$data['settlepayment']=$settlepayment;
					$data['reservation']=$reservation;
					$data['currentlist']=$currentlist;
					$data['inttots']=$inttots;
					$data['prevpayment']=$prevpayment;
					$data['thispayment']=$thispayment;
					$data['details']=$details	;
		
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
	
	  function get_posummery()
	 {
			
			$data['month']=$month=$this->uri->segment(5);
			$data['fromdate']=$fromdate=$this->uri->segment(5);
			$data['todate']=$todate=$this->uri->segment(6);
			$data['reportdata']=$enddate=$todate;
			$data['sartdate']=$stdate=$fromdate;


		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_officerlist($branchid);
		if($prjlist)
		{
			foreach($prjlist as $prjraw)
			{ $end=$todate;
				$start=$fromdate;
				$prjtarget=0;
				$prjblocktarget=0;
				$prjsalestarget=0;
				while($start<=$end)
				{
					$yeararr=explode('-',$start);
					$year=$yeararr[0];
					$month2=$yeararr[1];
					$mblock=0;$msales=0;$mtarget=0;
					$targetdata=$this->hm_report_model->get_month_target($prjraw->prj_id,$month2,$year,$prjraw->officer_code);
					if($targetdata)
					{$mblock=$targetdata->blocks;
						$msales=$targetdata->sales;
						$mtarget=$targetdata->target;
					}
					$prjtarget=$prjtarget+$mtarget;
					$prjblocktarget=$prjblocktarget+$mblock;
					$prjsalestarget=$prjsalestarget+$msales;
					$start=date('Y-m-d',strtotime('+1 months',strtotime($start)));

				}
					$target[$prjraw->prj_id]=$prjtarget;
					$block[$prjraw->prj_id]=$prjblocktarget;
					$sales[$prjraw->prj_id]=$prjsalestarget;
					$totblocks[$prjraw->prj_id]=$this->hm_report_model->get_tot_finalized_blocks($prjraw->prj_id,$stdate,$enddate);
					$totsales[$prjraw->prj_id]=$this->hm_report_model->get_tot_finalized_sales($prjraw->prj_id,$stdate,$enddate);
					$totadvance[$prjraw->prj_id]=$this->hm_report_model->get_month_advance($prjraw->prj_id,$stdate,$enddate);
					$totcapital[$prjraw->prj_id]=$this->hm_report_model->get_month_capital($prjraw->prj_id,$stdate,$enddate);

			}
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
	function get_profit_month_project()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		$data['month']="";
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		
		$stdate=$fromdate;
		$enddate=$todate;
		
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
	function get_profit_all()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['prj_id']=$prj_id=$this->uri->segment(5);
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		$data['month']=$month="";
		
//	echo $yeararr[0]."ssss".$this->session->userdata('fy_end');

		
		$stdate=$fromdate;
		$enddate=$todate;
	
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
				$start=$fromdate;
				$end=$todate;
				
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
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		$data['month']=$month="";
		$stdate=$fromdate;
		$enddate=$todate;
		
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
				
			$data['fromdate']=$fromdate=$this->uri->segment(5);
		$data['todate']=$todate=$this->uri->segment(6);
		$data['month']=$month="";
		
				$enddate=$todate;
				$data['reportdata']=$todate;
				$data['sartdate']=$stdate=$fromdate;
			
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
				
					
			$data['fromdate']=$fromdate=$this->uri->segment(5);
			$data['todate']=$todate=$this->uri->segment(6);
			$data['month']=$month="";
				
				$enddate=$todate;
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=$fromdate;
			
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
	
		$data['branchid']=$branchid=$this->uri->segment(6);
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
				
						
			$data['fromdate']=$fromdate=$this->uri->segment(4);
			$data['todate']=$todate=$this->uri->segment(5);
			$data['month']=$month="";
		
				$enddate=$todate;
				$data['reportdata']=$enddate;
				$data['sartdate']=$stdate=$fromdate;
		
			$reservation=NULL;
			$currentlist=NULL;
			$prevpayment=NULL;
			$thispayment=NULL;
			$details=NULL;
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
							
								 $currentlist[$resraw->id]=$this->hm_report_model->get_paymentlist_daterange($prj_id,$resraw->task_id,$stdate,$enddate);			}
					}
					$details[$prj_id]=$prjdetails=$this->hm_project_model->get_project_bycode($prj_id)	;
		
					
			}}
				
			//print_r($lotlist);
				$data['reservation']=$reservation;
				$data['currentlist']=$currentlist;
				$data['details']=$details;
		
			$this->load->view('hm/report/provition_unbudget.php',$data);	
		
	}
	function collection_details()
	{
		$data['branchid']=$branchid=$this->uri->segment(4);
		$data['type']=$type=$this->uri->segment(5);
		//$details[$prj_id]=$prjdetails=$this->project_model->get_project_bycode($prj_id)	;
		$data['fromdate']=$fromdate=$this->uri->segment(6);
		$data['todate']=$todate=$this->uri->segment(7);
		$data['prj_id']=$prj_id=$this->uri->segment(8);
		$data['dataset']=$this->hm_report_model->get_all_project_income_list($branchid,$prj_id,$fromdate,$todate);
		//echo $type;
		//$this->load->view('re/report/collection_full_data.php',$data);	
		if($type=='05')
		$this->load->view('hm/report/collection_full_data.php',$data);
		else if($type=='06')
		{
			$data['branchid']=$branchid=$this->uri->segment(4);
			$data['prj_id']=$prj_id=$this->uri->segment(8);
			$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery_prj($prj_id);
			$data['sartdate']=$fromdate=$stdate=$this->uri->segment(6);
			$data['todate']=$todate=$enddate=$this->uri->segment(7);
			$data['type']=$type=$this->uri->segment(5);
			$data['reportdata']=$todate;
			//echo $prj_id;
			
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
					$zepreservation[$prjraw->prj_id]=$this->hm_report_model->allloans_befor($prjraw->prj_id,$enddate);
					//print_r($zepreservation[$prjraw->prj_id]);
					if($zepreservation[$prjraw->prj_id])
					{
						foreach($zepreservation[$prjraw->prj_id] as $resraw)
						{
								//$inttots[$resraw->loan_code]=$this->eploan_model->get_int_total($resraw->loan_code);
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
				
					$this->load->view('hm/report/collection_allloans_all',$data);	
			}
			
		
			
			
		}	
		else
		$this->load->view('hm/report/collection_summery_data.php',$data);	
	}
	
	}
	
	

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */