<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function sbu_get_month_forcast($branchid,$month,$year)
	{
		$this->db->select('SUM(re_salestarget.target) as coll_target,SUM(re_salestarget.sales) as sales_target,SUM(re_salestarget.income) as income_target');
		$this->db->join('re_projectms','re_projectms.prj_id=re_salestarget.prj_id');
		if($branchid!='ALL')
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_salestarget.month',$month);
		$this->db->where('re_salestarget.year',$year);
		$query = $this->db->get('re_salestarget'); 
		 if ($query->num_rows >0) {
			// $data=$query->row();
            return $query->row();
        }
		else
		return 0; 
	}
	
	function get_sbu_finalized_sales($branchid,$fromdate,$todate) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as selstot,SUM(re_prjaclotdata.costof_sale) as costtot' );
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branchid!='ALL')
	 	$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $query->row();
		}
		else
		return 0;
    }
	
	function get_sbu_month_advance($branchid,$stdate,$enddate)
	{
		$this->db->select('SUM(re_saleadvance.pay_amount) as tot');
		//$this->db->select('re_saleadvance.*');

		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code');
		if($branchid!='ALL')
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->where('re_saleadvance.pay_date >=',$stdate);
			$this->db->where('re_saleadvance.pay_date <=',$enddate);
			//$this->db->group_by('re_resevation.prj_id');
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
	//	$data= $query->row();
		return $query->row();
		}
		else
		return false;
	}
	function get_sbu_month_capital($branchid,$stdate,$enddate)
	{$status = array('ZEP', 'EPB');
		$this->db->select('SUM(re_eploanpayment.cap_amount) as captot,SUM(re_eploanpayment.int_amount) as inttot');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
				$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
				$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
				if($branchid!='ALL')
		$this->db->where('re_resevation.branch_code',$branchid);
			$this->db->where_in('re_eploan.loan_type',$status);
			$this->db->where('re_eploanpayment.pay_date >=',$stdate);
			$this->db->where('re_eploanpayment.pay_date <=',$enddate);
		$this->db->where('re_prjacincome.pay_status','PAID');
	//	$this->db->group_by('re_eploan.loan_code');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		//$data= $query->row();
		return  $query->row();
		}
		else
		return false;
	}
	function get_sbu_month_epincome($branchid,$stdate,$enddate)
	{$status = array('ZEP', 'EPB');
		$this->db->select('SUM(re_eploanpayment.cap_amount) as captot,SUM(re_eploanpayment.int_amount) as inttot');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
				$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
				$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
				if($branchid!='ALL')
		$this->db->where('re_resevation.branch_code',$branchid);
		//	$this->db->where_in('re_eploan.loan_type',$status);
			$this->db->where('re_eploanpayment.pay_date >=',$stdate);
			$this->db->where('re_eploanpayment.pay_date <=',$enddate);
	//	$this->db->where('re_prjacincome.pay_status','PAID');
			$this->db->where('re_eploanpayment.int_entry !=','NULL');
	//	$this->db->group_by('re_eploan.loan_code');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		//$data= $query->row();
		return  $query->row();
		}
		else
		return false;
	}
	function get_sbu_month_epincomeforcast($branchid,$stdate,$enddate)
	{$status = array('ZEP', 'EPB');
		$this->db->select('SUM(re_eploanshedule.int_amount) as inttot,SUM(re_eploanshedule.paid_int) as paidint');
			
				$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
				$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
				if($branchid!='ALL')
		$this->db->where('re_resevation.branch_code',$branchid);
		//	$this->db->where_in('re_eploan.loan_type',$status);
			$this->db->where('re_eploanshedule.deu_date >=',$stdate);
			$this->db->where('re_eploanshedule.deu_date <=',$enddate);
	
		
	//	$this->db->group_by('re_eploan.loan_code');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		//$data= $query->row();
		return  $query->row();
		}
		else
		return false;
	}
	function get_loan_count($branchid,$type)
	{
		$this->db->select('COUNT(re_eploan.loan_code) as captot');
					if($branchid!='ALL')
		$this->db->where('re_eploan.branch_code',$branchid);
			$this->db->where_in('re_eploan.loan_type',$type);
				$this->db->where_in('re_eploan.loan_status','CONFIRMED');
			
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $data->captot;
		}
		else
		return 0;
	}
	function get_sbu_otherloan_full_payment($branchid,$stdate_date,$end_date,$type)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
		$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
			if($branchid!='ALL')
		$this->db->where('re_eploan.branch_code',$branchid);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('ac_entries.date >=',$stdate_date);
		$this->db->where('ac_entries.date <=',$end_date);
		//$this->db->group_by('re_eploanpayment.loan_code');
			//$this->db->group_by('re_prjacincome.temp_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		//echo $this->db->last_query();
		return $query->row();
		}
		else
		return 0;

	}
	function get_sbu_nep_full_payment($branchid,$stdate_date,$end_date,$type)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
		$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
			if($branchid!='ALL')
		$this->db->where('re_eploan.branch_code',$branchid);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('ac_entries.date >=',$stdate_date);
		$this->db->where('ac_entries.date <=',$end_date);
	//	$this->db->group_by('re_eploanpayment.loan_code');
			//$this->db->group_by('re_prjacincome.temp_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		//echo $this->db->last_query();
		return $query->row();
		}
		else
		return 0;

	}
	function get_rebait_full_payment($branchid,$stdate_date,$end_date,$type)
	{
		$this->db->select('SUM(re_eprebate.balance_capital ) as totcap,SUM(re_eprebate.int_paidamount) as totint');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eprebate.loan_code');
		$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
			if($branchid!='ALL')
		$this->db->where('re_eploan.branch_code',$branchid);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('re_eprebate.apply_date <=',$end_date);
		$this->db->where('re_eprebate.apply_date >=',$stdate_date);
		//$this->db->group_by('re_eploanpayment.loan_code');
			//$this->db->group_by('re_prjacincome.temp_code');
		$query = $this->db->get('re_eprebate');

		if ($query->num_rows() > 0){
		//echo $this->db->last_query();
		return $query->row();
		}
		else
		return 0;

	}
	
	function sbu_get_loan_forcast($branchid,$month,$year,$type)
	{
		$this->db->select('SUM(re_salesforcast.collection) as coll_target');
		$this->db->join('re_eploan','re_eploan.loan_code=re_salesforcast.res_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_salesforcast.prj_id');
		if($branchid!='ALL')
		$this->db->where('re_projectms.branch_code',$branchid);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('re_salesforcast.month',$month);
		$this->db->where('re_salesforcast.year',$year);
		$query = $this->db->get('re_salesforcast'); 
		 if ($query->num_rows >0) {
			// $data=$query->row();
            return $query->row();
        }
		else
		return 0; 
	}
	
	//////////// dashboard model start ************************************************************************************
	//*********************************************************************************************************************
	//********************************************************************************************************************
	
	function get_all_project_summery($branchid) { //get all stock
		if($this->session->userdata('usertype')!='Project Officer'){
			if($branchid=='ALL' & check_access('all_branch')){
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('re_projectms.status',CONFIRMKEY);
			//	$this->db->where('re_projectms.price_status',CONFIRMKEY);
				$this->db->order_by('project_name');
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
			else
			{
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('branch_code',$branchid);
				$this->db->order_by('project_name');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				//$this->db->where('re_projectms.price_status',CONFIRMKEY);
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
		}
		else
		{
			$this->db->select('prj_id,project_code,project_name,branch_code,town');
		$this->db->where('officer_code',$this->session->userdata('userid'));
		$this->db->order_by('project_name');
		$this->db->where('re_projectms.status',CONFIRMKEY);
		//$this->db->where('re_projectms.price_status',CONFIRMKEY);
	//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
		$query = $this->db->get('re_projectms');
		return $query->result();
		}
    }
	function get_loandata_byrescode($id)
	{
		$this->db->select('*');
		$this->db->where('res_code',$id);
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}
	function get_loandata_loancode($id)
	{
		$this->db->select('*');
		$this->db->where('loan_code',$id);
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}
	function get_resevation($id) { //get all stock
		$this->db->select('*');
		$this->db->where('res_code',$id);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_lotdata($id) { //get all stock
		$this->db->select('*');
		$this->db->where('lot_id',$id);
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_paid_capital($id)
	{$loandata=$this->get_loandata_loancode($id);
		$this->db->select('SUM(re_eploanpayment.cap_amount) as tot');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
		$this->db->where('re_eploanpayment.loan_code',$id);
		$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->tot;
		}
		else
		return false;
	}
	function get_paid_advance($id)
	{
		$this->db->select('SUM(re_saleadvance.pay_amount) as tot');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->where('re_saleadvance.res_code',$id);
	$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->group_by('re_saleadvance.res_code');
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->tot;
		}
		else
		return false;
	}
	function get_selabale_count($id)
	{
		$this->db->select('COUNT(lot_id) as tot');
		$this->db->where('prj_id',$id);
		$this->db->where('price_perch !=',0);
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->tot;
		}
		else
		return false;
	}
	function get_lot_summery($id)
	{
		$this->db->select('SUM(sale_val) as totsale,SUM(costof_sale) as totcost');
		$this->db->where('prj_id',$id);
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data;
		}
		else
		return false;
	}
	function get_profittransfer_data($prj_id) { //get all stock
		$this->db->select('re_resevation.*');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
		function get_profittransfer_data_period($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('re_resevation.*');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_profittransfer_data_period_sum($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as selstot,SUM(re_prjaclotdata.costof_sale) as costtot' );
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function pending_lotdata($id) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$id);
		$this->db->where('status','PENDING');
		$this->db->where('price_perch >','0');
		$this->db->order_by('lot_id');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function pending_lotdata_count($id) { //get all stock
		$this->db->select('COUNT(lot_id) as pendingcount');
		$this->db->where('prj_id',$id);
		$this->db->where('status','PENDING');
		$this->db->where('price_perch >','0');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $data->pendingcount;
		}
		else
		return 0;
    }
	function full_lotdata_count($id) { //get all stock
		$this->db->select('COUNT(lot_id) as pendingcount');
		$this->db->where('prj_id',$id);
		$this->db->where('price_perch >','0');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $data->pendingcount;
		}
		else
		return 0;
    }
	function lastmonth_reservation_count($id,$date) { //get all stock
		$this->db->select('COUNT(res_code) as rescount');
		$this->db->where('prj_id',$id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('res_date <',$date);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $data->rescount;
		}
		else
		return 0;
    }
	function thismonth_reservation_lots($id,$stdate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		$this->db->select('re_prjaclotdata.*,re_resevation.res_date');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
			$this->db->where('re_resevation.res_date >',$stdate);
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }

    function reservation_lots_todate($id,$enddate) { //get all stock
    $lotarr=NULL;
    $counter=0;
      $this->db->select('re_prjaclotdata.*,re_resevation.res_date');
      $this->db->where('re_resevation.prj_id',$id);
      $this->db->where('re_resevation.res_status !=',"REPROCESS");
        $this->db->where('re_resevation.res_date >',$enddate);
      $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
      $query = $this->db->get('re_resevation');
      if ($query->num_rows() > 0){
        return $query->result();

      }
      else
      return 0;
      }

	function reservation_lots_befor($id,$enddate,$stdate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		$this->db->select('re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.*,re_eploan.loan_code');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date <',$enddate);
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan',"re_eploan.res_code=re_resevation.res_code AND re_eploan.start_date >= '".$stdate."' and  re_eploan.start_date <= '".$enddate."'",'left');
			$this->db->order_by('re_prjaclotdata.lot_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function check_loan_befordate($res_code,$start_date)
	{
		$this->db->select('loan_code');
		$this->db->where('re_eploan.res_code',$res_code);
			$this->db->where('re_eploan.start_date <',$start_date);
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
			return false;

		}
		else
		return true;
	}
	function advance_sum_befoer_date($res_code,$start_date)
	{
		$this->db->select('SUM(pay_amount) as payment');
		$this->db->where('re_saleadvance.res_code',$res_code);
		$this->db->where('re_saleadvance.pay_date <',$start_date);
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}
	function advance_sum_this_month($res_code,$start_date,$enddate)
	{
		$this->db->select('SUM(pay_amount) as payment');
		$this->db->where('re_saleadvance.res_code',$res_code);
		$this->db->where('re_saleadvance.pay_date >=',$start_date);
		$this->db->where('re_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}
	function project_dpcollection_month($prj_id,$start_date,$enddate)
	{
		$this->db->select('SUM(re_saleadvance.pay_amount) as payment');
		$this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_saleadvance.pay_date >=',$start_date);
		$this->db->where('re_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}
	function project_sales_month($prj_id,$start_date,$enddate)
	{
		$this->db->select('SUM(re_resevation.discounted_price) as payment');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date >=',$start_date);
		$this->db->where('re_resevation.res_date <=',$enddate);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}
	function eploans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('re_eploan.*');
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.down_payment');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_eploan.loan_type ',"NEP");
		$this->db->where('re_eploan.start_date <',$enddate);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function epbloans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('re_eploan.*');
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.down_payment');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_eploan.loan_type ',"EPB");
		$this->db->where('re_eploan.start_date <',$enddate);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function zepploans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('re_eploan.*');
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.down_payment');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_eploan.loan_type ',"ZEP");
		$this->db->where('re_eploan.start_date <',$enddate);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('re_eploan');
			//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function loan_payment_befoer_date($loan_code,$start_date)
	{
		$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
		$this->db->where('re_eploanpayment.pay_date <',$start_date);
			$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return $query->row();

		}
		else
		return 0;
	}
	function loan_payment_month($loan_code,$start_date,$enddate)
	{
		$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
			$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('re_eploanpayment.pay_date >=',$start_date);
		$this->db->where('re_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}
	//  provition Reports

	function get_project_paymeny_task($id)
	{
		$this->db->select('re_prjacpaymentms.*,cm_tasktype.task_name');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
		$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}
	function get_paymentlist($prj_id, $task_id,$todate) { //get all stock
		$this->db->select('re_prjacpaymentdata.*,ac_payvoucherdata.status,ac_chqprint.CHQNO,cm_subtask.subtask_name');
	//	if(! check_access('all_branch'))
		$this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('re_prjacpaymentdata.task_id',$task_id);
		$this->db->where('re_prjacpaymentdata.create_date <',$todate);
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;

    }
	function get_paymentlist_daterange($prj_id, $task_id,$fromdate,$todate) { //get all stock
		$this->db->select('re_prjacpaymentdata.*,ac_payvoucherdata.status,ac_chqprint.CHQNO,cm_subtask.subtask_name');
	//	if(! check_access('all_branch'))
		$this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('re_prjacpaymentdata.task_id',$task_id);
		$this->db->where('re_prjacpaymentdata.create_date >=',$fromdate);
		$this->db->where('re_prjacpaymentdata.create_date <=',$todate);
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;

    }
	function get_all_Unbudgeted_project_summery($branchid) { //get all stock
		$this->db->select('prj_id,project_code,project_name,branch_code,town');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$branchid);
		$this->db->order_by('prj_id');
		$this->db->where('re_projectms.status','PENDING');
		$this->db->where('re_projectms.price_status','PENDING');
	//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
		$query = $this->db->get('re_projectms');
		return $query->result();
    }
	function get_reservation_data($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_prjaclotdata.lot_number');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_paylist_capital($id)
	{$loandata=$this->get_loandata_loancode($id);

		$this->db->select('re_eploanpayment.*');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
		$this->db->where('re_eploanpayment.loan_code',$id);
		$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
			$this->db->where('re_prjacincome.pay_status','PAID');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		//$data= $query->result();
		return$query->result();
		}
		else
		return false;
	}
	function get_paylist_advance($id)
	{
		$this->db->select('re_saleadvance.*');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->where('re_saleadvance.res_code',$id);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
	//	$data= $query->row();
		return $query->result();
		}
		else
		return false;
	}
	function get_month_forcast($prj_id,$month,$year,$rescode)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('res_code',$rescode);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('re_salesforcast');
		 if ($query->num_rows >0) {
			// $data=$query->row();
            return $query->row();
        }
		else
		return false;
	}
	function get_officerlist($branchid)
	{
		if($this->session->userdata('usertype')!='Project Officer'){

			if($branchid=='ALL' & check_access('all_branch')){
			$this->db->select('re_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
			$this->db->where('re_projectms.status',CONFIRMKEY);
			$this->db->where('re_projectms.price_status',CONFIRMKEY);
			$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code');
			$this->db->order_by('re_projectms.branch_code,re_projectms.officer_code');
			$query = $this->db->get('re_projectms');
			return $query->result();
			}
			else
			{
				$this->db->select('re_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
				$this->db->where('branch_code',$branchid);
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
				$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code');
				$this->db->order_by('re_projectms.officer_code');
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
		}
		else
		{
			$this->db->select('re_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
		if(! check_access('all_branch'))
		$this->db->where('officer_code',$this->session->userdata('userid'));
		$this->db->where('re_projectms.status',CONFIRMKEY);
		$this->db->where('re_projectms.price_status',CONFIRMKEY);
		$this->db->join('hr_empmastr','hr_empmastr.id=re_projectms.officer_code');
		$this->db->order_by('re_projectms.officer_code');
		$query = $this->db->get('re_projectms');
		}
	}
	function get_month_target($prj_id,$month,$year,$salsment)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('officer_id',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('re_salestarget');
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $query->row();
        }
		else
		return false;
	}
	function get_month_advance($id,$stdate,$enddate)
	{
		$this->db->select('SUM(re_saleadvance.pay_amount) as tot');
		//$this->db->select('re_saleadvance.*');

		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_prjacincome.pay_status','PAID');
		$this->db->where('re_saleadvance.pay_date >=',$stdate);
			$this->db->where('re_saleadvance.pay_date <=',$enddate);
			//$this->db->group_by('re_resevation.prj_id');
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
	//	$data= $query->row();
		return $query->row();
		}
		else
		return false;
	}
	function get_month_capital($id,$stdate,$enddate)
	{$status = array('ZEP', 'EPB');
		$this->db->select('SUM(re_eploanpayment.cap_amount) as captot,SUM(re_eploanpayment.int_amount) as inttot');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
				$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
				$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->where('re_resevation.prj_id',$id);
			$this->db->where_in('re_eploan.loan_type',$status);
			$this->db->where('re_eploanpayment.pay_date >=',$stdate);
			$this->db->where('re_eploanpayment.pay_date <=',$enddate);
		$this->db->where('re_prjacincome.pay_status','PAID');
	//	$this->db->group_by('re_eploan.loan_code');
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		//$data= $query->row();
		return  $query->row();
		}
		else
		return false;
	}
	 function lot_pending_total($id) { //get all stock
		$this->db->select('SUM(sale_val) as totsale,SUM(costof_sale) totcost, COUNT(lot_id) lotcount');
		$this->db->where('prj_id',$id);
		$this->db->where('price_perch >','0');
		$this->db->where('status ','PENDING');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){

		return  $query->row();
		}
		else
		return 0;
    }
	function lot_pending_list($id) { //get all stock
		$this->db->select('*');
		$this->db->where('prj_id',$id);
		$this->db->where('price_perch >','0');
		$this->db->where('status ','PENDING');
	//	$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){

		return  $query->result();
		}
		else
		return 0;
    }
	function lot_all_total($id) { //get all stock
		$this->db->select('SUM(sale_val) as totsale,SUM(costof_sale) totcost, COUNT(lot_id) lotcount');
		$this->db->where('prj_id',$id);
		$this->db->where('price_perch >','0');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){

		return  $query->row();
		}
		else
		return 0;
    }
	function get_settled_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"SETTLED");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_settled_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_customerms.first_name,re_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"SETTLED");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_init_settled($prj_id) { //get all stock
		//$this->db->group_by('prj_id');
		$query = $this->db->query('SELECT SUM(re_prjaclotdata.sale_val) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount FROM re_prjaclotdata WHERE Status="SOLD" AND prj_id="'.$prj_id.'" AND lot_id NOT IN (SELECT  lot_id FROM re_resevation )');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_init_settled_list($prj_id) { //get all stock
		//$this->db->group_by('prj_id');
		$query = $this->db->query('SELECT * FROM re_prjaclotdata WHERE Status="SOLD" AND prj_id="'.$prj_id.'" AND lot_id NOT IN (SELECT  lot_id FROM re_resevation )');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_NEP_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"NEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
		function get_NEP_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_customerms.first_name,re_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');

		$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"NEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function get_EPB_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"EPB");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
		function get_EPB_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_customerms.first_name,re_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');
						$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"EPB");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_ZEP_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"ZEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_ZEP_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_customerms.first_name,re_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');
						$this->db->where('re_resevation.prj_id',$prj_id);
	//	$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"ZEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_ZEP_reservation_data_profit($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"COMPLETE");
		$this->db->where('re_resevation.pay_type ',"ZEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_Advance_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
		//$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		$this->db->where('re_resevation.pay_type',"Pending");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_Advance_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_customerms.first_name,re_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');
						$this->db->where('re_resevation.prj_id',$prj_id);
		//$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		$this->db->where('re_resevation.pay_type',"Pending");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_Advance_reservation_data_profit($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		$this->db->where('re_resevation.pay_type',"Pending");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_eploan_data($prj_id,$start_date) { //get all stock
	//echo $start_date;
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_customerms.first_name,re_customerms.last_name');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_customerms','re_customerms.cus_code=re_eploan.cus_code');

		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_eploan.loan_type','NEP');
		$this->db->where('re_eploan.start_date <= ',$start_date);

		$this->db->where('re_eploan.loan_status',"CONFIRMED");

		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_eploan_arrears_tot($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount,SUM(delay_int) AS delay_int');
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reschdue_sqn);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
		$this->db->where('re_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}

	function get_eploan_credit_tot($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('loan_code',$loancode);
			$this->db->where('re_eploanshedule.reschdue_sqn',$reschdue_sqn);
		$this->db->where('deu_date >=',$deu_date);
			$this->db->where('tot_payment >',0.00);
			$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
	function get_project_month_income($loancode,$start_date,$end_date)
	{
		$this->db->select('SUM(re_prjacincome.amount) as totpay');
		$this->db->where('pri_id',$loancode);
		$this->db->where('income_date >=',$start_date);
		$this->db->where('income_date <=',$end_date);

			$this->db->group_by('pri_id');
		$query = $this->db->get('re_prjacincome');

		if ($query->num_rows() > 0){
		$data=$query->row();
			return $data->totpay;
		}
		else
		return 0;

	}
	function get_project_month_expence($loancode,$start_date,$end_date)
	{
		$this->db->select('SUM(amount) as totpay');
		//$this->db->select('*');
		$this->db->where('prj_id',$loancode);
		$this->db->where('create_date >=',$start_date);
		$this->db->where('create_date <=',$end_date);

		//	$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjacpaymentdata');

		if ($query->num_rows() > 0){

		$data=$query->row();
		return $data->totpay;
		//return 1;
		}
		else
		return 0;

	}
	function get_project_all_income($loancode)
	{
		$this->db->select('SUM(re_prjacincome.amount) as totpay');
		$this->db->where('pri_id',$loancode);

			$this->db->group_by('pri_id');
		$query = $this->db->get('re_prjacincome');

		if ($query->num_rows() > 0){
		$data=$query->row();
			return $data->totpay;
		}
		else
		return 0;

	}
	function get_project_all_expence($loancode)
	{
		$this->db->select('SUM(amount) as totpay');
		//$this->db->select('*');
		$this->db->where('prj_id',$loancode);

		//	$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjacpaymentdata');

		if ($query->num_rows() > 0){

		$data=$query->row();
		return $data->totpay;
		//return 1;
		}
		else
		return 0;

	}
	function get_project_budget_by_task($id,$taskid)
	{
		$this->db->select('re_prjacpaymentms.new_budget');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
		//$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
	//	$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
           $data= $query->row();
		   return $data->new_budget;
        }
		else
		return 0;
	}
	function get_project_payment_by_task($id,$taskid)
	{
		$this->db->select('re_prjacpaymentms.tot_payments ');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
		//$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
	//	$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
           $data= $query->row();
		   return $data->tot_payments ;
        }
		else
		return 0;
	}
	function task_list()
	{
		$this->db->select('cm_tasktype.*');
		$this->db->order_by('cm_tasktype.task_code');
		$query = $this->db->get('cm_tasktype');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}
	function caclulate_epb_interest($rescode,$paydate) { //get all stock

	$details=$this->eploan_model->get_eploan_data($rescode);
	//echo $rescode;
		$futureDate=$loanstart_date=$details->start_date;
 $arrayintlist=NULL;
 $current_date=$paydate;
 $end_date=date('Y-m-d',strtotime('+'.intval($details->period).' months',strtotime($futureDate)));

					  $date1=date_create($loanstart_date);
					  $date2=date_create($current_date);

					$diff=date_diff($date1,$date2);
					$current_cap=$details->loan_amount;

					$inttot=0;
					$dates=$diff->format("%m ");
					$thismonthint=0;
					$dates=get_month_count($loanstart_date,$current_date);

					if($dates>=1)
					{
						//echo  $current_cap;
				//		 echo $rescode.'-'.$current_cap.'===<br>';
					for($i=1; $i<=$dates; $i++)
					{

						$thismonthint=0;
						$prvdate=$futureDate;
						$futureDate=date('Y-m-d',strtotime('+1 months',strtotime($futureDate)));

						if($i>$details->period)
						$thismonthint=round(($current_cap*$details->interest)/(12*100),2);
						$this_payment= get_thismonth_payment($details->loan_code,$prvdate,$futureDate);
						//  echo $rescode.'-'.$current_cap.'==='. $thismonthint.'<br>';
					//	echo $futureDate;
						$balance=$current_cap+$thismonthint - $this_payment;
						$arrayintlist[$i]['date']=$futureDate;
						$arrayintlist[$i]['int']=$thismonthint;
						$arrayintlist[$i]['payment']=$this_payment;
						$arrayintlist[$i]['balance']=$balance;
						?>
                        <?

						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
						//echo $current_cap.',';

					}

					}
					return $inttot;

    }
	function get_need_topay($loancode,$deu_date,$reswq)
	{
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('loan_code',$loancode);
		$this->db->where('reschdue_sqn',$reswq);
		//$this->db->where('pay_status','PENDING');
		$this->db->where('deu_date <=',$deu_date);
		$this->db->group_by('loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
	function get_eploan_data_other($prj_id,$start_date,$type) { //get all stock
	//echo $start_date;
		$this->db->select('re_eploan.*,re_prjaclotdata.sale_val,re_prjaclotdata.lot_number,re_customerms.first_name,re_customerms.last_name,,re_customerms.address1,re_customerms.address2,re_customerms.address3,re_resevation.discounted_price');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_customerms','re_customerms.cus_code=re_eploan.cus_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('re_eploan.start_date <=',$start_date);

			//$this->db->where('re_eploan.loan_status',"CONFIRMED");

		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_reservation_data_out($prj_id,$start_date,$type) { //get all stock
	//echo $start_date;
		$this->db->select('re_resevation.*,re_prjaclotdata.lot_number');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
			$this->db->where('re_resevation.res_status','PROCESSING');
		//$this->db->where('re_eploan.start_date <= ',$start_date);

	//	$this->db->where('re_resevation.loan_status',"CONFIRMED");

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function loan_paid_amounts_advance($loancode,$deu_date)
	{
		$this->db->select('SUM(re_saleadvance.pay_amount ) as totcap');
		$this->db->where('res_code',$loancode);

		$this->db->where('pay_date <=',$deu_date);
			$this->db->group_by('res_code');
		$query = $this->db->get('re_saleadvance');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
	function loan_paid_amounts($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->where('loan_code',$loancode);
		$this->db->where('reschdue_sqn',$reschdue_sqn);
		$this->db->where('pay_date <=',$deu_date);
			$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}

function get_tot_finalized_blocks($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('COUNT(res_code) as totblocks');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->totblocks;
		}
		else
		return 0;
    }
	function get_tot_finalized_sales($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('SUM(discounted_price) as totblocks');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->totblocks;
		}
		else
		return 0;
    }
	function get_all_supplier_summery() { //get all stock
		$this->db->select('sup_code,first_name,last_name,id_number');
		$this->db->order_by('first_name');
		$query = $this->db->get('cm_supplierms'); 
		return $query->result(); 
    }
	function get_supppayment_searchlist($branch_code,$prj_id,$sup_code,$fromdate,$todate){
			$this->db->select('re_prjacpaymentdata.*,ac_payvoucherdata.status,ac_payvoucherdata.paymentdate,ac_payvoucherdata.voucher_ncode,ac_chqprint.CHQNO,cm_subtask.subtask_name,cm_tasktype.task_name,re_projectms.project_name,re_projectms.branch_code');
	//	if(! check_access('all_branch'))
				$this->db->join('re_projectms','re_projectms.prj_id=re_prjacpaymentdata.prj_id');
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');
		$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentdata.task_id','left');
		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		if($sup_code!='')
		$this->db->where('ac_payvoucherdata.payeecode',$sup_code);
		if($fromdate!='')
		$this->db->where('re_prjacpaymentdata.create_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_prjacpaymentdata.create_date <=',$todate);
			
			$this->db->order_by('re_projectms.branch_code,re_prjacpaymentdata.prj_id');
		$query = $this->db->get('re_prjacpaymentdata'); 
		
		return $query->result(); 
		
    }
	function get_supplier_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('sup_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_supplierms'); 
		return $query->row(); 
    }
	
function loan_paid_amounts_collection($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
		$this->db->where('re_eploanpayment.loan_code',$loancode);
		$this->db->where('re_eploanpayment.reschdue_sqn',$reschdue_sqn);
		$this->db->where('ac_entries.date <=',$deu_date);
			$this->db->group_by('re_eploanpayment.loan_code');
			//$this->db->group_by('re_prjacincome.temp_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		//echo $this->db->last_query();
		return $query->row();
		}
		else
		return 0;

	}
	function loan_paid_amounts_collection_re($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
		$this->db->where('re_eploanpayment.loan_code',$loancode);
		$this->db->where('re_eploanpayment.reschdue_sqn !=',$reschdue_sqn);
		$this->db->where('re_eploanpayment.ins_id',NULL);
		$this->db->where('ac_entries.date <=',$deu_date);
			$this->db->group_by('re_eploanpayment.loan_code');
			//$this->db->group_by('re_prjacincome.temp_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		//echo $this->db->last_query();
		return $query->row();
		}
		else
		return 0;

	}
	
	function get_eploan_data_reshedule($prj_id,$start_date,$end_date,$type) { //get all stock
	//echo $start_date;
		$this->db->select('re_eploan.*,re_prjaclotdata.sale_val,re_prjaclotdata.lot_number,re_customerms.first_name,re_customerms.last_name,,re_customerms.address1,re_customerms.address2,re_customerms.address3');
		$this->db->join('re_eploan','re_eploan.loan_code=re_epreschedule.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epreschedule.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_customerms','re_customerms.cus_code=re_epreschedule.cus_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_epreschedule.prev_type',$type);
		$this->db->where('re_epreschedule.confirm_date >',$start_date);
		$this->db->where('re_epreschedule.confirm_date <=',$end_date);

		$this->db->where('re_epreschedule.status',"CONFIRMED");

		$query = $this->db->get('re_epreschedule');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
 	function notfinalized_lots_todate($id,$enddate) { //get all stock
    $lotarr=NULL;
    $counter=0;
      $this->db->select('re_prjaclotdata.*,re_resevation.res_date,re_resevation.discounted_price');
      $this->db->where('re_resevation.prj_id',$id);
      $this->db->where('re_resevation.res_status',"PROCESSING");
	//   $this->db->or_where('re_resevation.profit_date >',$enddate);
	  
        $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
      $query = $this->db->get('re_resevation');
	//  echo $this->db->last_query();
      if ($query->num_rows() > 0){
        return $query->result();

      }
      else
      return 0;
      }
	  function get_eploan_tot($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanshedule.cap_amount) as totcap,SUM(re_eploanshedule.int_amount) as totint,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reschdue_sqn);
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
	 function get_eploan_last_date($loancode,$reschdue_sqn)
	{
		$this->db->select('MAX(deu_date) as lastdate');
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reschdue_sqn);
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->lastdate;
		}
		else
		return 0;

	}
	function get_eploan_first_date($loancode,$reschdue_sqn)
	{
		$this->db->select('MIN(deu_date) as lastdate');
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reschdue_sqn);
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->lastdate;
		}
		else
		return 0;

	}
	function loan_paid_amounts_current_month($loancode,$stdate_date,$end_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->join('re_prjacincome',"re_eploanpayment.rct_id=re_prjacincome.id");
		$this->db->join('ac_entries',"ac_entries.id=re_prjacincome.entry_id",'left');
		$this->db->where('re_eploanpayment.loan_code',$loancode);
		$this->db->where('re_eploanpayment.reschdue_sqn',$reschdue_sqn);
		$this->db->where('ac_entries.date <=',$end_date);
		$this->db->where('ac_entries.date >=',$stdate_date);
			$this->db->group_by('re_eploanpayment.loan_code');
			//$this->db->group_by('re_prjacincome.temp_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		//echo $this->db->last_query();
		return $query->row();
		}
		else
		return 0;

	}
	function loan_paid_amounts_befordate($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(re_eploanpayment.cap_amount ) as totcap,SUM(re_eploanpayment.int_amount) as totint,SUM(re_eploanpayment.di_amount) as totdi');
		$this->db->where('loan_code',$loancode);
		$this->db->where('reschdue_sqn',$reschdue_sqn);
		$this->db->where('pay_date <',$deu_date);
			$this->db->group_by('loan_code');
		$query = $this->db->get('re_eploanpayment');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
function get_finalized_detials($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('re_resevation.*,re_eploan.loan_amount,re_eploan.old_code ,re_eploan.interest,re_eploan.period,re_eploan.montly_rental, re_prjaclotdata.extend_perch,re_prjaclotdata.sale_val, re_prjaclotdata.lot_number,re_customerms.first_name,re_customerms.last_name,re_customerms.address1,re_customerms.address2,re_customerms.address3,re_customerms.mobile,re_projectms.project_name');
	
		$this->db->join('re_eploan',"re_eploan.res_code=re_resevation.res_code",'left');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_customerms','re_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function loan_paid_di($loan_code,$start_date,$enddate)
	{$loandata=$this->get_loandata_loancode($loan_code);
		
		
	
		$this->db->select('SUM(di_amount) as sum_di');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
		$this->db->where('re_eploanpayment.pay_date >=',$start_date);
			$this->db->where('re_eploanpayment.pay_date <',$enddate);
				$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return $data->sum_di;

		}
		else
		return 0;
	}
	
}
