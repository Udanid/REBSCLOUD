	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Summeryreport extends CI_Controller {

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
	public function showall()
	{
		$data=NULL;
		if ( ! check_access('view_project'))
		{
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/project/');
			return;
		}
	
		
			
		
		
	}
	
		/* Start Collection Report**********************************************************************************************
	************************************************************************************************************************/
public function summery_report()
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
					$this->load->view('hm/report/summery_main',$data);
		
		
		
	}
	
	
	function collection_summery()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['year']=$year=$this->uri->segment(4);
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$data['month']=$month=$this->uri->segment(6);
		$data['stdate']=$stdate=$year.'-'.$month.'-01';
		$data['enddate']=$enddate=$year.'-'.$month.'-31';
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					$advance[$prjraw->prj_id]=$this->hm_report_model->Summery_advance_sum_this_month($prjraw->prj_id,$stdate,$enddate);
					$zep[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_payment_month($prjraw->prj_id,$stdate,$enddate,'ZEP');
				$nep[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_payment_month($prjraw->prj_id,$stdate,$enddate,'NEP');
				$epb[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_payment_month($prjraw->prj_id,$stdate,$enddate,'EPB');
				$epb[$prjraw->prj_id]=0;
						$reservation[$prjraw->prj_id]=$this->hm_report_model->epbloans_befor($prjraw->prj_id,$enddate);
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
							$paidtots=$prevpayment[$resraw->loan_code]->sum_cap+$prevpayment[$resraw->loan_code]->sum_int;
							$thispyament=$thispayment[$resraw->loan_code]->sum_int+$thispayment[$resraw->loan_code]->sum_cap;
							$opbal=$resraw->loan_amount+$inttots[$resraw->loan_code]-($paidtots);
							if($thispyament>$opbal)
							$thispyament=$opbal;
							
							//$thispyament=$thispyament+$thispayment[$resraw->loan_code]->sum_di;
							if($thispyament>0){
							//	echo $thispyament.'<br>';
							$epb[$prjraw->prj_id]=$epb[$prjraw->prj_id]+$thispyament;
							}
							
						}
					}
				
				
				
				
				}
					$data['advance']=$advance;
					$data['zep']=$zep;
					$data['nep']=$nep;
					$data['epb']=$epb;
					
		
					$this->load->view('hm/report/summery_collection',$data);	
				
			}
			
			//print_r($lotlist);
				
		
	}
	function collection_summery_excel()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['year']=$year=$this->uri->segment(4);
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$data['month']=$month=$this->uri->segment(6);
		$data['stdate']=$stdate=$year.'-'.$month.'-01';
		$data['enddate']=$enddate=$year.'-'.$month.'-31';
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					$advance[$prjraw->prj_id]=$this->hm_report_model->Summery_advance_sum_this_month($prjraw->prj_id,$stdate,$enddate);
					$zep[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_payment_month($prjraw->prj_id,$stdate,$enddate,'ZEP');
				$nep[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_payment_month($prjraw->prj_id,$stdate,$enddate,'NEP');
				//$epb[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_payment_month($prjraw->prj_id,$stdate,$enddate,'EPB');
					$epb[$prjraw->prj_id]=0;
						$reservation[$prjraw->prj_id]=$this->hm_report_model->epbloans_befor($prjraw->prj_id,$enddate);
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
							$paidtots=$prevpayment[$resraw->loan_code]->sum_cap+$prevpayment[$resraw->loan_code]->sum_int;
							$thispyament=$thispayment[$resraw->loan_code]->sum_int+$thispayment[$resraw->loan_code]->sum_cap;
							$opbal=$resraw->loan_amount+$inttots[$resraw->loan_code]-($paidtots);
							if($thispyament>$opbal)
							$thispyament=$opbal;
							
							//$thispyament=$thispyament+$thispayment[$resraw->loan_code]->sum_di;
							if($thispyament>0){
							//	echo $thispyament.'<br>';
							$epb[$prjraw->prj_id]=$epb[$prjraw->prj_id]+$thispyament;
							}
							
						}
					}
				
				}
					$data['advance']=$advance;
					$data['zep']=$zep;
					$data['nep']=$nep;
					$data['epb']=$epb;
					
		
					$this->load->view('hm/report/summery_collection_excel',$data);	
				
			}
			
			//print_r($lotlist);
				
		
	}
	function balance_summery()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['year']=$year=$this->uri->segment(4);
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$data['month']=$month=$this->uri->segment(6);
		$data['stdate']=$stdate=$year.'-'.$month.'-01';
		$data['enddate']=$enddate=$year.'-'.$month.'-31';
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					$lots[$prjraw->prj_id]=$this->hm_report_model->summery_pending_stock($prjraw->prj_id);
					$soldlots[$prjraw->prj_id]=$this->hm_report_model->summery_reserved_stock($prjraw->prj_id,$enddate);
					$advancelist[$prjraw->prj_id]=$this->hm_report_model->Summery_reservation_balance_month($prjraw->prj_id,$stdate,$enddate);
					$zeplist[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_balance_month($prjraw->prj_id,$stdate,$enddate,'ZEP');					$eplist[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_balance_month($prjraw->prj_id,$stdate,$enddate,'NEP');
					$epblist[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_balance_month($prjraw->prj_id,$stdate,$enddate,'EPB');
				
				}
					$data['lots']=$lots;
					$data['soldlots']=$soldlots;
					$data['advancelist']=$advancelist;
					$data['zeplist']=$zeplist;
					$data['eplist']=$eplist;
					$data['epblist']=$epblist;
					
		
					$this->load->view('hm/report/summery_balance',$data);	
				
			}
			
			//print_r($lotlist);
				
		
	}
	function balance_summery_excel()
	{
		if ( ! check_access('view_report'))
		{
			
			$this->session->set_flashdata('error', 'Permission Denied');
			redirect('hm/report/profit_main/');
			return;
		}	
		$data['year']=$year=$this->uri->segment(4);
		$data['branchid']=$branchid=$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->hm_report_model->get_all_project_summery($branchid);
		$data['month']=$month=$this->uri->segment(6);
		$data['stdate']=$stdate=$year.'-'.$month.'-01';
		$data['enddate']=$enddate=$year.'-'.$month.'-31';
			if($prjlist)
			{
				foreach($prjlist as $prjraw)
				{
					$lots[$prjraw->prj_id]=$this->hm_report_model->summery_pending_stock($prjraw->prj_id);
					$soldlots[$prjraw->prj_id]=$this->hm_report_model->summery_reserved_stock($prjraw->prj_id,$enddate);
					$advancelist[$prjraw->prj_id]=$this->hm_report_model->Summery_reservation_balance_month($prjraw->prj_id,$stdate,$enddate);
					$zeplist[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_balance_month($prjraw->prj_id,$stdate,$enddate,'ZEP');					$eplist[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_balance_month($prjraw->prj_id,$stdate,$enddate,'NEP');
					$epblist[$prjraw->prj_id]=$this->hm_report_model->Summery_loan_balance_month($prjraw->prj_id,$stdate,$enddate,'EPB');
				
				}
					$data['lots']=$lots;
					$data['soldlots']=$soldlots;
					$data['advancelist']=$advancelist;
					$data['zeplist']=$zeplist;
					$data['eplist']=$eplist;
					$data['epblist']=$epblist;
					
		
					$this->load->view('hm/report/summery_balance_excel',$data);	
				
			}
			
			//print_r($lotlist);
				
		
	}
	}
	
	

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */