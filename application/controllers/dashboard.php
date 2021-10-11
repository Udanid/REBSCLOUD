<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {

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
		$this->load->model("branch_model");
		$this->load->model("reservation_model");
		$this->load->model("search_model");
		$this->load->model("customer_model");
		$this->load->model("dashboard_model");
		//$this->load->model("budget_model");
		$this->load->model("ledger_model");
		$this->load->model("project_model");
		$this->load->model("sales_model");
		
		$this->load->model("salesdashboard_model");
	
		$this->is_logged_in();

    }

	public function index()
	{
		



	}
	public function sbu_head()
	{
		$branch_id=$this->session->userdata('branchid');
		$month=date('m');
		$year=date('Y');
		$fromdate=$year.'-'.$month.'-01';
		$settindata=$this->common_model->get_finance_year();
		$fiyearstdate=$settindata->fy_start;
		$todate=date('Y-m-d');
		 $data['searchpath']='';
		
		 $data['branchdata']=$this->branch_model->get_branchdata_bycode($branch_id);
		 $data['mforcast']=$this->dashboard_model->sbu_get_month_forcast($branch_id,$month,$year);
		 $data['msales']=$this->dashboard_model->get_sbu_finalized_sales($branch_id,$fromdate,$todate);
		 $data['mcollection']=$this->dashboard_model->get_sbu_month_advance($branch_id,$fromdate,$todate);
		 $data['ysales']=$this->dashboard_model->get_sbu_finalized_sales($branch_id,$fiyearstdate,$fromdate);
		 $data['ycollection']=$this->dashboard_model->get_sbu_month_advance($branch_id,$fiyearstdate,$fromdate);
		//  $ycoll_target=0;$ysales_target=0;$yincome_target=0;
		 $data['ysales_target']=0;//$this->budget_model->getFigures_by_ID_branch(1,$branch_id,$year);
		 $data['ycoll_target']=0;//$this->budget_model->getFigures_by_ID_branch(69,$branch_id,$year);
		 $data['yincome_target']=0;//$this->budget_model->getFigures_by_ID_branch(70,$branch_id,$year);
		$this->load->view('dashboard/sbu_head',$data);
			

	}
	public function managing_director()
	{
		$branch_id='ALL';
		$month=date('m');
		$year=date('Y');
		$fromdate=$year.'-'.$month.'-01';
		$settindata=$this->common_model->get_finance_year();
		$fiyearstdate=$settindata->fy_start;
		$todate=date('Y-m-d');
		 $data['searchpath']='';
		
		 $data['branchdata']=$this->branch_model->get_branchdata_bycode($branch_id);
		 $data['mforcast']=$this->dashboard_model->sbu_get_month_forcast($branch_id,$month,$year);
		 $data['msales']=$this->dashboard_model->get_sbu_finalized_sales($branch_id,$fromdate,$todate);
		 $data['mcollection']=$this->dashboard_model->get_sbu_month_advance($branch_id,$fromdate,$todate);
		  $data['mepincomeforcast']=$this->dashboard_model->get_sbu_month_epincomeforcast($branch_id,$fromdate,$todate);
		  $data['mepincome']=$this->dashboard_model->get_sbu_month_epincome($branch_id,$fromdate,$todate);
		  $data['yepincome']=$this->dashboard_model->get_sbu_month_epincome($branch_id,$fiyearstdate,$fromdate);
		 $data['ysales']=$this->dashboard_model->get_sbu_finalized_sales($branch_id,$fiyearstdate,$fromdate);
		 $data['ycollection']=$this->dashboard_model->get_sbu_month_advance($branch_id,$fiyearstdate,$fromdate);
		//  $ycoll_target=0;$ysales_target=0;$yincome_target=0;
		 $data['yepincome_target']=0;//$this->budget_model->getFigures_by_ID_branch(3,$branch_id,$year);
		 $data['ysales_target']=0;//$this->budget_model->getFigures_by_ID_branch(1,$branch_id,$year);
		 $data['ycoll_target']=0;//$this->budget_model->getFigures_by_ID_branch(69,$branch_id,$year);
		 $data['yincome_target']=0;//$this->budget_model->getFigures_by_ID_branch(70,$branch_id,$year);
		 
		  $branch_id='ALL';
		 $data['mforcast_NEP']=$this->dashboard_model->sbu_get_loan_forcast($branch_id,$month,$year,'NEP');
		 $data['mforcast_EPB']=$this->dashboard_model->sbu_get_loan_forcast($branch_id,$month,$year,'EPB');
		 $data['mforcast_ZEP']=$this->dashboard_model->sbu_get_loan_forcast($branch_id,$month,$year,'ZEP');
		 
		 $data['mactual_NEP']=$this->dashboard_model->get_sbu_nep_full_payment($branch_id,$fromdate,$todate,'NEP');
		 $data['mactual_EPB']=$this->dashboard_model->get_sbu_otherloan_full_payment($branch_id,$fromdate,$todate,'EPB');
		 $data['mactual_ZEP']=$this->dashboard_model->get_sbu_otherloan_full_payment($branch_id,$fromdate,$todate,'ZEP');
		 
		  $data['yactual_NEP']=$this->dashboard_model->get_sbu_nep_full_payment($branch_id,$fiyearstdate,$todate,'NEP');
		 $data['yactual_EPB']=$this->dashboard_model->get_sbu_otherloan_full_payment($branch_id,$fiyearstdate,$todate,'EPB');
		 $data['yactual_ZEP']=$this->dashboard_model->get_sbu_otherloan_full_payment($branch_id,$fiyearstdate,$todate,'ZEP');
		  $data['count_NEP']=$this->dashboard_model->get_loan_count($branch_id,'NEP');
		 $data['count_EPB']=$this->dashboard_model->get_loan_count($branch_id,'EPB');
		 $data['count_ZEP']=$this->dashboard_model->get_loan_count($branch_id,'ZEP');
		 
		 //Items from P&L
		 $lgplArray = array();
		 $total_from_pl = 0;
		 $ledger_groups_pl = "64,63,65,71,70,69"; //all the account groups to get dr total
		 $lgplArray = explode(',',$ledger_groups_pl); //convert into an array
		 foreach ($lgplArray as $group){
			 $ledger_accounts = $this->ledger_model->get_ledgers_by_groupID($group); //get ledger ids by group
			 if($ledger_accounts)foreach($ledger_accounts as $ledgers){
				 $total_from_pl = $total_from_pl+$this->ledger_model->get_dr_total_period($ledgers->id,$fromdate,$todate); //get dr total of each ledger account
			 }
		 }
		 $data['profit_loss'] = $total_from_pl;
		 
		 //Items from Balance sheet
		 $lgbsArray = array();
		 $total_from_bs = 0;
		 $ledger_groups_bs = "84,47,102,74,46,78,79,80,81,82,83,108,58,56,59,103,57,54,109"; //all the account groups to get dr total
		 $lgbsArray = explode(',',$ledger_groups_bs); //convert into an array
		 foreach ($lgbsArray as $group){
			 $ledger_accounts = $this->ledger_model->get_ledgers_by_groupID($group); //get ledger ids by group
			 if($ledger_accounts)foreach($ledger_accounts as $ledgers){
				 $total_from_bs = $total_from_bs+$this->ledger_model->get_dr_total_period($ledgers->id,$fromdate,$todate); //get dr total of each ledger account
			 }
		 }
		 $data['balance_sheet'] = $total_from_bs;
		 
		 //Out side borrwings
		 $total_from_borrowings = 0;
		 $ledger_accounts = $this->ledger_model->get_ledgers_by_groupID(108); //get ledger ids by group
		 if($ledger_accounts)foreach($ledger_accounts as $ledgers){
			 $total_from_borrowings = $total_from_borrowings+$this->ledger_model->get_cr_total_period($ledgers->id,$fromdate,$todate); //get dr total of each ledger account
		 }
		 $data['out_side'] = $total_from_borrowings;
		 
		$this->load->view('dashboard/md_main',$data);
			

	}
	function get_blocklist()
	{
		$data['searchpanel_lotlist']=$this->lotdata_model->get_project_all_lots_byprjid($this->uri->segment(3));
		$this->load->view('advancesearch/blocklist',$data);
		
	}
	
	
	function dashboard_headofsales($date='')
	{
		//$date=date('Y-m-d');
		if(!$date)
		$data['date']=$date=date('Y-m-d');
		$data['month']=$month=date('m');
		
		$year=date('Y');
		$startdate=$year.'-'.$month.'-01';
		$data['enddate']=$enddate=$year.'-'.$month.'-31';
		
		 $data['branchlist']=$branchlist=$this->branch_model->get_all_branches_summery();
		 if($branchlist)
		 {
			 foreach($branchlist as $raw)
			 {
				$prjlist[$raw->branch_code]=$this->salesdashboard_model->get_all_project_summery($raw->branch_code);
				
				if($prjlist[$raw->branch_code])
				{
					$counter=0;$full_lot=NULL;$fullbal=NULL;
					foreach($prjlist[$raw->branch_code] as $raw2)
					{
						$details[$raw2->prj_id]=$prjdata=$this->project_model->get_project_bycode($raw2->prj_id)	;
						
						$lotcount[$raw2->prj_id]=$this->salesdashboard_model->get_lot_count($raw2->prj_id);
						$sales[$raw2->prj_id]=$this->salesdashboard_model->reservation_lots_befor($raw2->prj_id,$enddate);
						/*echo $details[$raw2->prj_id]->project_name.'<br>';
						print_r($sales[$raw2->prj_id]);
						echo '<br>';*/
						$label[$counter]=substr($details[$raw2->prj_id]->project_name,0,10);
						$totlots=0;$totsale=0;$soldlot=0;$soldval=0;
											if($lotcount[$raw2->prj_id])
											{
												 $totlots=$lotcount[$raw2->prj_id]->totlots;
												 $totsale=$lotcount[$raw2->prj_id]->selstot;
											}
											if($sales[$raw2->prj_id])
											{
												 $soldval=$sales[$raw2->prj_id]->selstot;
												 $soldlot=$sales[$raw2->prj_id]->totcount;
											}
						$full_lot[$counter]= $totlots;
						$fullbal[$counter]= $totlots-$soldlot;
											
						$counter++;
					}
					
					$js_label[$raw->branch_code]=json_encode($label);
					$js_tot[$raw->branch_code]=json_encode($full_lot);
					$js_bal[$raw->branch_code]=json_encode($fullbal);
				}
				$offierlist[$raw->branch_code]=$this->sales_model->get_sales_officerlist($raw->branch_code);
				if($offierlist[$raw->branch_code])
				{
					foreach($offierlist[$raw->branch_code] as $raw3)
					{
						$target[$raw3->id]=$this->sales_model->get_month_officer_target($month,$year,$raw3->id);
						$salesachev[$raw3->id]=$this->salesdashboard_model->reservation_lots_officer_monthtarget($raw3->id,$startdate,$enddate);
					}
				}
			 }
		 }
		 $data['js_label']=$js_label;
		 $data['js_tot']=$js_tot;
		 $data['js_bal']=$js_bal;
		 $data['prjlist']=$prjlist;
		  $data['offierlist']=$offierlist;
		    $data['target']=$target;
			  $data['salesachev']=$salesachev;
		  $data['details']=$details;
		   $data['sales']=$sales;
		    $data['lotcount']=$lotcount;
		 $this->load->view('dashboard/sales_main',$data);
		 
		
		
	}
}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
