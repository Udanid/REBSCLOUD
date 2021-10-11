	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ledgerbalance_report extends CI_Controller {

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
		$this->load->model("ledgerbalance_report_model");
		
		
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
		$this->ledgerbalance_report_model->update_settlement();
	//	$this->ledgerbalance_report_model->update_leagal_fee();
		$data=NULL;
		//	create_branchaccluntlist();
		$lebal=NULL;
		$estimate=NULL;
		$actual=NULL;
		$color=NULL;
		$counter=0;
		 $data['branchlist']=$this->branch_model->get_all_branches_summery();
			
		$data['searchpath']='re/lotdata/search';
		$data['to_date']=$todate=date('Y-m-d');//$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
		$data['task_list']=$task_list=$this->ledgerbalance_report_model->task_list();
		$data['task_list_hm']=$task_list_hm=$this->ledgerbalance_report_model->task_list_hm();
		$data['flag']=$this->ledgerbalance_report_model->migration_entry_check();
		//print_r($prjlist);
		if($prjlist)
		{
			foreach($prjlist as $raw)
			{
				$prj_id=$raw->prj_id;
		//		$this->ledgerbalance_report_model->update_project_price($prj_id);
				$totsale=0;$unsale=0;$uncost=0;$totcost=0;
				$hm_totsale=0;$hm_unsale=0;$hm_uncost=0;$hm_totcost=0;
				$stock_balance=$this->ledgerbalance_report_model->get_available_stock($todate,$prj_id);
				$advance_stock=$this->ledgerbalance_report_model->get_advance_stock($todate,$prj_id);
				$dwonpayment_stock=$this->ledgerbalance_report_model->get_dpcomplete_reservation_data($todate,$prj_id);
				$NEP_stock=$this->ledgerbalance_report_model->get_NEP_reservation_data($todate,$prj_id);
				$EPB_stock=$this->ledgerbalance_report_model->get_EPB_reservation_data($todate,$prj_id);
				$ZEP_stock=$this->ledgerbalance_report_model->get_ZEP_reservation_data($todate,$prj_id);
				$settled_stock=$this->ledgerbalance_report_model->get_settled_stock($todate,$prj_id);
				if($stock_balance)
				{
					$data_set['Available to Sale Stock'][$prj_id]=$stock_balance->totcost;
					$data_set['Construction Stock - Houses'][$prj_id]=$stock_balance->hm_totcost;
				}
				if($advance_stock){
					$data_set['Advanced Stock'][$prj_id]=$advance_stock->totcost;
					$data_set['Advance Received from Customers for Lands'][$prj_id]=$advance_stock->totsale;
				}
				 if($dwonpayment_stock){
				   $totcost= $totcost+$dwonpayment_stock->totcost;
				    $totsale=$totsale+$dwonpayment_stock->totsale;
					$unsale=$unsale+$dwonpayment_stock->unsale;
					$uncost=$uncost+$dwonpayment_stock->uncost;
					 $hm_totcost= $hm_totcost+$dwonpayment_stock->hm_totcost;
				    $hm_totsale=$hm_totsale+$dwonpayment_stock->hm_totsale;
					$hm_unsale=$hm_unsale+$dwonpayment_stock->hm_unsale;
					$hm_uncost=$hm_uncost+$dwonpayment_stock->hm_uncost;
					
					$data_set['Trade Debtor'][$prj_id]=$dwonpayment_stock->totsale+$dwonpayment_stock->hm_totsale-$dwonpayment_stock->totpaid;
				 }
				 
				 if($NEP_stock){
		  
				   $totcost= $totcost+$NEP_stock->totcost;
					$totsale=$totsale+$NEP_stock->totsale;
					$unsale=$unsale+$NEP_stock->unsale;
					$uncost=$uncost+$NEP_stock->uncost;
					 $hm_totcost= $hm_totcost+$NEP_stock->hm_totcost;
				    $hm_totsale=$hm_totsale+$NEP_stock->hm_totsale;
					$hm_unsale=$hm_unsale+$NEP_stock->hm_unsale;
					$hm_uncost=$hm_uncost+$NEP_stock->hm_uncost;
					//echo $hm_unsale;
					$tot_due_data=loan_due_totals('NEP','2020-12-31',$prj_id);
				//echo $this->db->last_query();
					$tot_paid_data=loan_paid_totals('NEP','2020-12-31',$prj_id);
				
				//print_r($tot_paid_data);
					$tot_due=$tot_due_data->due_cap+$tot_due_data->due_int;
					$tot_paid=$tot_paid_data->paid_cap+$tot_paid_data->paid_int;
					$arrears=$tot_due-$tot_paid;
					$stock=$NEP_stock->totepstock-$tot_due_data->due_cap;
					
					$full_data=loan_due_totals('NEP','',$prj_id);
					if($full_data)
					{
						$tot_int=$full_data->due_int;
						$unrealized_int=$tot_int-$tot_due_data->due_int;
						$arrears_int=$tot_due_data->due_int-$tot_paid_data->paid_int;
						if($arrears_int>0)
						$suspense_int=$tot_int-$tot_due_data->due_int+$arrears_int;
						else
						$suspense_int=$tot_int-$tot_due_data->due_int;
						$int_income=$tot_int-$suspense_int;
		
					}
					$data_set['Trade Debtor EP'][$prj_id]=$arrears;
					$data_set['Trade Receivable EP'][$prj_id]=$stock;
					$data_set['Unrealized EP Interest Lands'][$prj_id]=$unrealized_int;
					$data_set['EP Interest In Suspense Lands'][$prj_id]=$suspense_int;
					$data_set['EP Interest Income Lands'][$prj_id]=$int_income;
					
				 }
				 if($ZEP_stock){
		
					   $totcost= $totcost+$ZEP_stock->totcost;
						$totsale=$totsale+$ZEP_stock->totsale;
						$unsale=$unsale+$ZEP_stock->unsale;
						$uncost=$uncost+$ZEP_stock->uncost;
						
						 $hm_totcost= $hm_totcost+$ZEP_stock->hm_totcost;
				 	   $hm_totsale=$hm_totsale+$ZEP_stock->hm_totsale;
						$hm_unsale=$hm_unsale+$ZEP_stock->hm_unsale;
						$hm_uncost=$hm_uncost+$ZEP_stock->hm_uncost;
						
						$tot_due_data=loan_due_totals('ZEP','2020-12-31',$prj_id);
					//echo $this->db->last_query();
						$tot_paid_data=loan_paid_totals('ZEP','2020-12-31',$prj_id);
					
					//print_r($tot_paid_data);
						$tot_due=$tot_due_data->due_cap+$tot_due_data->due_int;
						$tot_paid=$tot_paid_data->paid_cap+$tot_paid_data->paid_int;
						$arrears=$tot_due-$tot_paid;
						$stock=$ZEP_stock->totepstock-$tot_due_data->due_cap;
						$data_set['Trade Debtor ZEP'][$prj_id]=$arrears;
						$data_set['Trade Receivable ZEP'][$prj_id]=$stock;
				 }
				 if($EPB_stock){
		  
				  	$totcost= $totcost+$EPB_stock->totcost;
					$totsale=$totsale+$EPB_stock->totsale;
					$unsale=$unsale+$EPB_stock->unsale;
					$uncost=$uncost+$EPB_stock->uncost;
					
					 $hm_totcost= $hm_totcost+$EPB_stock->hm_totcost;
				 	   $hm_totsale=$hm_totsale+$EPB_stock->hm_totsale;
						$hm_unsale=$hm_unsale+$EPB_stock->hm_unsale;
						$hm_uncost=$hm_uncost+$EPB_stock->hm_uncost;
				
					$tot_paid_data=loan_paid_totals('EPB','2020-12-31',$prj_id);
				
			
					$tot_paid=$tot_paid_data->paid_cap+$tot_paid_data->paid_int;
					$arrears=$tot_due-$tot_paid;
					$stock=$EPB_stock->totepstock-$tot_paid;
					$data_set['Trade Debtor EPB'][$prj_id]=$stock;
				 }
		   		 if($settled_stock)
				{
						  $settled_cost=$settled_stock->totcost;
						  $settled_sale=$settled_stock->totsale;
						  $hm_settled_cost=$settled_stock->hm_totcost;
						  $hm_settled_sale=$settled_stock->hm_totsale;
				}
				$data_set['Unrealized Sale Land'][$prj_id]=$unsale;
				$data_set['Unrealized Cost Lands'][$prj_id]=$uncost;
				
				$data_set['Unrealized Sale House'][$prj_id]=$hm_unsale;
				$data_set['Unrealized Cost House'][$prj_id]=$hm_uncost;
				
				
				$data_set['Land Sale Income'][$prj_id]=$totsale+$settled_sale-$unsale;
				$data_set['Cost of Lands'][$prj_id]=$totcost+$settled_cost-$uncost;
				$data_set['House Sale Income'][$prj_id]=$hm_totsale+$hm_settled_sale-$hm_unsale;
				$data_set['Cost of House'][$prj_id]=$hm_totcost+$hm_settled_cost-$hm_uncost;
				
				//	 echo $data_set['Land Sale Income'][$prj_id].'-'.$unsale.'<br>';
				
			
				$data_set['details'][$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
				
				$chargpeyments=$this->ledgerbalance_report_model->get_charge_payment($todate,$prj_id);
				$data_set['Legal Fee'][$prj_id]=0;
					$data_set['P/R Fee'][$prj_id]=0;
					$data_set['Plan Fee'][$prj_id]=0;
					$data_set['Stamp Duty'][$prj_id]=0;
					$data_set['Draft Checking Fee'][$prj_id]=0;
				if($chargpeyments)
				{
					
					
					foreach($chargpeyments as $raw2)
					{
						if($raw2->chage_dis=='Legal Fee')
						{
							$data_set['Legal Fee'][$prj_id]=$raw2->charge_payment;
						}
						if($raw2->chage_dis=='P/R Fee')
						{
							$data_set['P/R Fee'][$prj_id]=$raw2->charge_payment;
						}
						if($raw2->chage_dis=='Plan Fee')
						{
							$data_set['Plan Fee'][$prj_id]=$raw2->charge_payment;
						}
						if($raw2->chage_dis=='Stamp Duty')
						{
							$data_set['Stamp Duty'][$prj_id]=$raw2->charge_payment;
						}
						if($raw2->chage_dis=='Draft Checking Fee')
						{
							$data_set['Draft Checking Fee'][$prj_id]=$raw2->charge_payment;
						}
						
					}
				}
				$expence=0;
				if($task_list)
				{
					$budget_tot=0;
					foreach($task_list as $raw3)
					{
						$taskdata=$this->ledgerbalance_report_model->get_task_balance($todate,$prj_id,$raw3->task_id);
						$balance=0;
						if($taskdata)
						{
							$budget_tot=$budget_tot+$taskdata->new_budget;
							$expence=$expence+$taskdata->tot_payments;
							$balance=$taskdata->new_budget-$taskdata->tot_payments;
						
						}
						$data_set[$raw3->task_name][$prj_id]=$balance;
					}
					
					
				}
				
				if($task_list_hm)
				{
					foreach($task_list_hm as $raw4)
					{
						$taskdata=$this->ledgerbalance_report_model->get_task_balance_hm($todate,$prj_id,$raw4->task_id);
						$balance=0;
						if($taskdata)
						{
							$expence=$expence+$taskdata->payment;
							$balance=$taskdata->estimate-$taskdata->payment;
						
						}
						$data_set[$raw4->task_name][$prj_id]=$balance;
					}
				}
				$data_set['Income'][$prj_id]=$this->ledgerbalance_report_model->get_total_income($todate,$prj_id);
				//echo $this->ledgerbalance_report_model->get_total_income($todate,$prj_id);
				
				$data_set['Expence'][$prj_id]=$expence;
				
			}
		}
		
		//print_r($data_set);
		$data['data_set']=$data_set;
		$this->load->view('re/ledgerbalance_report/report_main',$data);
		
		
		
		
	}
	
	function get_report()
	{
		
		$prj_id=$this->uri->segment(4);
		
		
		$this->load->view('re/ledgerbalance_report/report_data',$data);
		
	}
	// Start Profit Report**************************************************************************************************************
	public function update_migration_entry()
	{
		$data['to_date']=$todate=date('Y-m-d');//$this->uri->segment(5);
		$data['prjlist']=$prjlist=$this->report_model->get_all_project_summery('ALL');
		$data['task_list']=$task_list=$this->ledgerbalance_report_model->task_list();
		$data['task_list_hm']=$task_list_hm=$this->ledgerbalance_report_model->task_list_hm();
	
		if($prjlist)
		{
			foreach($prjlist as $raw)
			{	$crlist=NULL;$drlist=NULL;$crtot=0;$drtot=0;$crcount=0;$drcount=0;
				$prj_id=$raw->prj_id;
				$totsale=0;$unsale=0;$uncost=0;$totcost=0;
				$hm_totsale=0;$hm_unsale=0;$hm_uncost=0;$hm_totcost=0;
				$stock_balance=$this->ledgerbalance_report_model->get_available_stock($todate,$prj_id);
				$advance_stock=$this->ledgerbalance_report_model->get_advance_stock($todate,$prj_id);
				$dwonpayment_stock=$this->ledgerbalance_report_model->get_dpcomplete_reservation_data($todate,$prj_id);
				$NEP_stock=$this->ledgerbalance_report_model->get_NEP_reservation_data($todate,$prj_id);
				$EPB_stock=$this->ledgerbalance_report_model->get_EPB_reservation_data($todate,$prj_id);
				$ZEP_stock=$this->ledgerbalance_report_model->get_ZEP_reservation_data($todate,$prj_id);
				$settled_stock=$this->ledgerbalance_report_model->get_settled_stock($todate,$prj_id);
				if($stock_balance)
				{
					$data_set['Available to Sale Stock'][$prj_id]=$stock_balance->totcost;
					$data_set['Construction Stock - Houses'][$prj_id]=$stock_balance->hm_totcost;
					$drlist[$drcount]['ledgerid']='HEDBA15000100';
					$val=0;
					if($stock_balance->totcost)
					$val=$stock_balance->totcost;
					$drlist[$drcount]['amount']=$val;
					$drtot=$drtot+$val;
					$drcount=$drcount+1;
					$drlist[$drcount]['ledgerid']='HEDBA15000102';
					$val=0;
					if($stock_balance->hm_totcost)
					$val=$stock_balance->hm_totcost;
					$drlist[$drcount]['amount']=$val;
					$drtot=$drtot+$val;
					$drcount=$drcount+1;
					
				}
				if($advance_stock){
					$data_set['Advanced Stock'][$prj_id]=$advance_stock->totcost;
					$data_set['Advance Received from Customers for Lands'][$prj_id]=$advance_stock->totsale;
					if($advance_stock->totcost)
					{
					$drlist[$drcount]['ledgerid']='HEDBA15000101';
					$drlist[$drcount]['amount']=$advance_stock->totcost;
					$drtot=$drtot+$advance_stock->totcost;
					$drcount=$drcount+1;
					}
					
					if($advance_stock->totsale)
					{
						$crlist[$crcount]['ledgerid']='HEDBL31000900';
						$crlist[$crcount]['amount']=$advance_stock->totsale;
						$crtot=$crtot+$advance_stock->totsale;
						$crcount=$crcount+1;
					}
					
				}
				 if($dwonpayment_stock){
				   $totcost= $totcost+$dwonpayment_stock->totcost;
				    $totsale=$totsale+$dwonpayment_stock->totsale;
					$unsale=$unsale+$dwonpayment_stock->unsale;
					$uncost=$uncost+$dwonpayment_stock->uncost;
					 $hm_totcost= $hm_totcost+$dwonpayment_stock->hm_totcost;
				    $hm_totsale=$hm_totsale+$dwonpayment_stock->hm_totsale;
					$hm_unsale=$hm_unsale+$dwonpayment_stock->hm_unsale;
					$hm_uncost=$hm_uncost+$dwonpayment_stock->hm_uncost;
					
					$data_set['Trade Debtor'][$prj_id]=$value=$dwonpayment_stock->totsale+$dwonpayment_stock->hm_totsale-$dwonpayment_stock->totpaid;
					if($value)
					{
					$drlist[$drcount]['ledgerid']='HEDBA15000304';
					$drlist[$drcount]['amount']=$value;
					$drtot=$drtot+$value;
					$drcount=$drcount+1;
					}
				 }
				 
				 if($NEP_stock){
		  
				   $totcost= $totcost+$NEP_stock->totcost;
					$totsale=$totsale+$NEP_stock->totsale;
					$unsale=$unsale+$NEP_stock->unsale;
					$uncost=$uncost+$NEP_stock->uncost;
					 $hm_totcost= $hm_totcost+$NEP_stock->hm_totcost;
				    $hm_totsale=$hm_totsale+$NEP_stock->hm_totsale;
					$hm_unsale=$hm_unsale+$NEP_stock->hm_unsale;
					$hm_uncost=$hm_uncost+$NEP_stock->hm_uncost;
					//echo $hm_unsale;
					$tot_due_data=loan_due_totals('NEP','2020-12-31',$prj_id);
				//echo $this->db->last_query();
					$tot_paid_data=loan_paid_totals('NEP','2020-12-31',$prj_id);
				
				//print_r($tot_paid_data);
					$tot_due=$tot_due_data->due_cap+$tot_due_data->due_int;
					$tot_paid=$tot_paid_data->paid_cap+$tot_paid_data->paid_int;
					$arrears=$tot_due-$tot_paid;
					$stock=$NEP_stock->totepstock-$tot_due_data->due_cap;
					
					$full_data=loan_due_totals('NEP','',$prj_id);
					if($full_data)
					{
						$tot_int=$full_data->due_int;
						$unrealized_int=$tot_int-$tot_due_data->due_int;
						$suspense_int=$tot_int-($tot_int-$unrealized_int)+($tot_due_data->due_int-$tot_paid_data->paid_int);
						$int_income=$tot_int-$suspense_int;
		
					}
					$data_set['Trade Debtor EP'][$prj_id]=$arrears;
					$data_set['Trade Receivable EP'][$prj_id]=$stock;
					$data_set['Unrealized EP Interest Lands'][$prj_id]=$unrealized_int;
					$data_set['EP Interest In Suspense Lands'][$prj_id]=$suspense_int;
					$data_set['EP Interest Income Lands'][$prj_id]=$int_income;
					
					$drlist[$drcount]['ledgerid']='HEDBA15000300';
					$drlist[$drcount]['amount']=$arrears;
					$drtot=$drtot+$arrears;
					$drcount=$drcount+1;
					
					$drlist[$drcount]['ledgerid']='HEDBA15000200';
					$drlist[$drcount]['amount']=$stock;
					$drtot=$drtot+$stock;
					$drcount=$drcount+1;
					
					$drlist[$drcount]['ledgerid']='HEDBA14000300';
					$drlist[$drcount]['amount']=$unrealized_int;
					$drtot=$drtot+$unrealized_int;
					$drcount=$drcount+1;
					
					$crlist[$crcount]['ledgerid']='HEDBA14000400';
					$crlist[$crcount]['amount']=$suspense_int;
					$crtot=$crtot+$suspense_int;
					$crcount=$crcount+1;
					
					$crlist[$crcount]['ledgerid']='HEDPI52030000';
					$crlist[$crcount]['amount']=$int_income;
					$crtot=$crtot+$int_income;
					$crcount=$crcount+1;
				 }
				 if($ZEP_stock){
		
					   $totcost= $totcost+$ZEP_stock->totcost;
						$totsale=$totsale+$ZEP_stock->totsale;
						$unsale=$unsale+$ZEP_stock->unsale;
						$uncost=$uncost+$ZEP_stock->uncost;
						
						 $hm_totcost= $hm_totcost+$ZEP_stock->hm_totcost;
				 	   $hm_totsale=$hm_totsale+$ZEP_stock->hm_totsale;
						$hm_unsale=$hm_unsale+$ZEP_stock->hm_unsale;
						$hm_uncost=$hm_uncost+$ZEP_stock->hm_uncost;
						
						$tot_due_data=loan_due_totals('ZEP','2020-12-31',$prj_id);
					//echo $this->db->last_query();
						$tot_paid_data=loan_paid_totals('ZEP','2020-12-31',$prj_id);
					
					//print_r($tot_paid_data);
						$tot_due=$tot_due_data->due_cap+$tot_due_data->due_int;
						$tot_paid=$tot_paid_data->paid_cap+$tot_paid_data->paid_int;
						$arrears=$tot_due-$tot_paid;
						$stock=$ZEP_stock->totepstock-$tot_due_data->due_cap;
						$data_set['Trade Debtor ZEP'][$prj_id]=$arrears;
						$data_set['Trade Receivable ZEP'][$prj_id]=$stock;
						
						
						$drlist[$drcount]['ledgerid']='HEDBA15000301';
						$drlist[$drcount]['amount']=$arrears;
						$drtot=$drtot+$arrears;
						$drcount=$drcount+1;
						
						$drlist[$drcount]['ledgerid']='HEDBA15000201';
						$drlist[$drcount]['amount']=$stock;
						$drtot=$drtot+$stock;
						$drcount=$drcount+1;	
				 }
				 if($EPB_stock){
		  
				  	$totcost= $totcost+$EPB_stock->totcost;
					$totsale=$totsale+$EPB_stock->totsale;
					$unsale=$unsale+$EPB_stock->unsale;
					$uncost=$uncost+$EPB_stock->uncost;
					
					 $hm_totcost= $hm_totcost+$EPB_stock->hm_totcost;
				 	   $hm_totsale=$hm_totsale+$EPB_stock->hm_totsale;
						$hm_unsale=$hm_unsale+$EPB_stock->hm_unsale;
						$hm_uncost=$hm_uncost+$EPB_stock->hm_uncost;
				
					$tot_paid_data=loan_paid_totals('EPB','2020-12-31',$prj_id);
				
			
					$tot_paid=$tot_paid_data->paid_cap+$tot_paid_data->paid_int;
					$arrears=$tot_due-$tot_paid;
					$stock=$EPB_stock->totepstock-$tot_paid;
					$data_set['Trade Debtor EPB'][$prj_id]=$stock;
					
						$drlist[$drcount]['ledgerid']='HEDBA15000302';
						$drlist[$drcount]['amount']=$stock;
						$drtot=$drtot+$stock;
						$drcount=$drcount+1;	
					
				 }
		   		 if($settled_stock)
				{
						  $settled_cost=$settled_stock->totcost;
						 
						  $settled_sale=$settled_stock->totsale;
						  $hm_settled_cost=$settled_stock->hm_totcost;
						  $hm_settled_sale=$settled_stock->hm_totsale;
				}
				$data_set['Unrealized Sale Land'][$prj_id]=$unsale;
				$data_set['Unrealized Cost Lands'][$prj_id]=$uncost;
				
				$data_set['Unrealized Sale House'][$prj_id]=$hm_unsale;
				$data_set['Unrealized Cost House'][$prj_id]=$hm_uncost;
				
				
				$data_set['Land Sale Income'][$prj_id]=$income=$totsale+$settled_sale-$unsale;
				$data_set['Cost of Lands'][$prj_id]=$cost=$totcost+$settled_cost-$uncost;
				$data_set['House Sale Income'][$prj_id]=$income_hm=$hm_totsale+$hm_settled_sale-$hm_unsale;
				$data_set['Cost of House'][$prj_id]=$cost_hm=$hm_totcost+$hm_settled_cost-$hm_uncost;
				
				$drlist[$drcount]['ledgerid']='HEDBA14000200';
				$drlist[$drcount]['amount']=$uncost;
				$drtot=$drtot+$uncost;
				$drcount=$drcount+1;
				
				$crlist[$crcount]['ledgerid']='HEDBA14000100';
				$crlist[$crcount]['amount']=$unsale;
				$crtot=$crtot+$unsale;
				$crcount=$crcount+1;
				
				$drlist[$drcount]['ledgerid']='HEDBA14000201';
				$drlist[$drcount]['amount']=$hm_uncost;
				$drtot=$drtot+$hm_uncost;
				$drcount=$drcount+1;
				
				$crlist[$crcount]['ledgerid']='HEDBA14000101';
				$crlist[$crcount]['amount']=$hm_unsale;
				$crtot=$crtot+$hm_unsale;
				$crcount=$crcount+1;
				
				
				
				$crlist[$crcount]['ledgerid']='HEDPI51010000';
				$crlist[$crcount]['amount']=$income;
				$crtot=$crtot+$income;
				$crcount=$crcount+1;
				
				$crlist[$crcount]['ledgerid']='HEDPI51010002';
				$crlist[$crcount]['amount']=$income_hm;
				$crtot=$crtot+$income_hm;
				$crcount=$crcount+1;
				
				$drlist[$drcount]['ledgerid']='HEDPE53000000';
				$drlist[$drcount]['amount']=$cost;
				$drtot=$drtot+$cost;
				$drcount=$drcount+1;
				
				$drlist[$drcount]['ledgerid']='HEDPE53000100';
				$drlist[$drcount]['amount']=$cost_hm;
				$drtot=$drtot+$cost_hm;
				$drcount=$drcount+1;
				
				
				$data_set['details'][$prj_id]=$this->project_model->get_project_bycode($prj_id)	;
				
				$chargpeyments=$this->ledgerbalance_report_model->get_charge_payment($todate,$prj_id);
				$data_set['Legal Fee'][$prj_id]=0;
					$data_set['P/R Fee'][$prj_id]=0;
					$data_set['Plan Fee'][$prj_id]=0;
					$data_set['Stamp Duty'][$prj_id]=0;
					$data_set['Draft Checking Fee'][$prj_id]=0;
				if($chargpeyments)
				{
					
					
					foreach($chargpeyments as $raw2)
					{
						if($raw2->chage_dis=='Legal Fee')
						{
							$data_set['Legal Fee'][$prj_id]=$raw2->charge_payment;
							$crlist[$crcount]['ledgerid']='HEDPI52040000';
							$crlist[$crcount]['amount']=$raw2->charge_payment;
							$crtot=$crtot+$raw2->charge_payment;
							$crcount=$crcount+1;
						}
						if($raw2->chage_dis=='P/R Fee')
						{
							$data_set['P/R Fee'][$prj_id]=$raw2->charge_payment;
							$crlist[$crcount]['ledgerid']='HEDPI52050000';
							$crlist[$crcount]['amount']=$raw2->charge_payment;
							$crtot=$crtot+$raw2->charge_payment;
							$crcount=$crcount+1;
						}
						if($raw2->chage_dis=='Plan Fee')
						{
							$data_set['Plan Fee'][$prj_id]=$raw2->charge_payment;
							$crlist[$crcount]['ledgerid']='HEDPI52070000';
							$crlist[$crcount]['amount']=$raw2->charge_payment;
							$crtot=$crtot+$raw2->charge_payment;
							$crcount=$crcount+1;
						}
						if($raw2->chage_dis=='Stamp Duty')
						{
							$data_set['Stamp Duty'][$prj_id]=$raw2->charge_payment;
							
							$crlist[$crcount]['ledgerid']='HEDBL31000902';
							$crlist[$crcount]['amount']=$raw2->charge_payment;
							$crtot=$crtot+$raw2->charge_payment;
							$crcount=$crcount+1;
						}
						if($raw2->chage_dis=='Draft Checking Fee')
						{
							$data_set['Draft Checking Fee'][$prj_id]=$raw2->charge_payment;
							$crlist[$crcount]['ledgerid']='HEDPI52090000';
							$crlist[$crcount]['amount']=$raw2->charge_payment;
							$crtot=$crtot+$raw2->charge_payment;
							$crcount=$crcount+1;
						}
						
					}
				}
				
				
				$expence=0;
				if($task_list)
				{
					foreach($task_list as $raw3)
					{
						$taskdata=$this->ledgerbalance_report_model->get_task_balance($todate,$prj_id,$raw3->task_id);
						$balance=0;
						if($taskdata)
						{
							$expence=$expence+$taskdata->tot_payments;
							$balance=$taskdata->new_budget-$taskdata->tot_payments;
						
						}
						$data_set[$raw3->task_name][$prj_id]=$balance;
						
							$crlist[$crcount]['ledgerid']='HED'.$raw3->ledger_id;
							$crlist[$crcount]['amount']=$balance;
							$crtot=$crtot+$balance;
							$crcount=$crcount+1;
					}
				}
				$hm_balance_tot=0;
				if($task_list_hm)
				{
					foreach($task_list_hm as $raw4)
					{
						$taskdata=$this->ledgerbalance_report_model->get_task_balance_hm($todate,$prj_id,$raw4->task_id);
						$balance=0;
						if($taskdata)
						{
							$expence=$expence+$taskdata->payment;
							$balance=$taskdata->estimate-$taskdata->payment;
						
						}
						$hm_balance_tot=$hm_balance_tot+$balance;
						$data_set[$raw4->task_name][$prj_id]=$balance;
					}
				}
				$crlist[$crcount]['ledgerid']='HEDBL33000100';
				$crlist[$crcount]['amount']=$hm_balance_tot;
				$crtot=$crtot+$hm_balance_tot;
				//$crcount=$crcount+1;
				$data_set['Income'][$prj_id]=$income=$this->ledgerbalance_report_model->get_total_income($todate,$prj_id);
				//echo $this->ledgerbalance_report_model->get_total_income($todate,$prj_id);
				$cash_balance=$income-$expence;
				$data_set['Expence'][$prj_id]=$expence;
			
				
				$drlist[$drcount]['ledgerid']='HEDBA15002100';
				$drlist[$drcount]['amount']=$cash_balance;
				$drtot=$drtot+$cash_balance;
				//$drcount=$drcount+1;
				$narration = 'Migration Entry '.$raw->project_name;
				$delay_entry=jurnal_entry($crlist,$drlist,$crtot,$drtot,'2020-12-31',$narration,$prj_id,'','');
				
				
			}
		}
		
		
		$data['data_set']=$data_set;
		
		
		redirect('re/ledgerbalance_report');
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */