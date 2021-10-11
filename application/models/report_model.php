<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    //uvini
	function get_all_project_summery($branchid,$prj_id = 'all') { //get all stock
		if($this->session->userdata('usertype')!='Project Officer'){
			if($branchid=='ALL' & check_access('all_branch')){
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
				if($prj_id != 'all')
					$this->db->where('re_projectms.prj_id',$prj_id);
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
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
				if($prj_id != 'all')
					$this->db->where('re_projectms.prj_id',$prj_id);
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
		$this->db->where('re_projectms.price_status',CONFIRMKEY);
		if($prj_id != 'all')
					$this->db->where('re_projectms.prj_id',$prj_id);
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
		function get_profittransfer_data_period($branch,$prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,cm_customerms.address1,cm_customerms.address2,cm_customerms.address3,re_projectms.project_name');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
			$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch!='ALL')
		$this->db->where('re_resevation.branch_code',$branch);
		if($prj_id!='ALL')
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date >=',$fromdate);
		$this->db->where('re_resevation.profit_date <=',$todate);
		$this->db->order_by('re_resevation.branch_code,re_resevation.prj_id');

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
	function lastmonth_reservation_count($id,$stdate,$enddate) { //get all stock
		$this->db->select('COUNT(res_code) as rescount');
		$this->db->where('prj_id',$id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('res_date >=',$stdate);
		$this->db->where('res_date <',$enddate);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return  $data->rescount;
		}
		else
		return 0;
    }
	function thismonth_reservation_lots($id,$stdate,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		$this->db->select('re_prjaclotdata.*,re_resevation.res_date');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
			//$this->db->where('re_resevation.res_date >=',$stdate);
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
		$this->db->select('re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.*,re_eploan.loan_code,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		//$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date <',$enddate);
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_eploan',"re_eploan.res_code=re_resevation.res_code",'left');
			$this->db->order_by('re_prjaclotdata.lot_number');
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
		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->where('re_saleadvance.res_code',$res_code);
		$this->db->where('re_prjacincome.entry_date <',$start_date);
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
		$this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
		$this->db->where('re_saleadvance.res_code',$res_code);
		$this->db->where('re_prjacincome.entry_date >=',$start_date);
		$this->db->where('re_prjacincome.entry_date <=',$enddate);
		$query = $this->db->get('re_saleadvance');
	//	echo $this->db->last_query();
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
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.res_date,re_resevation.discounted_price,re_resevation.down_payment,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,re_resevation.sales_person');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_eploan.loan_type ',"NEP");
		$this->db->where('re_eploan.start_date <',$enddate);
		//$this->db->where('re_eploan.loan_status','CONFIRMED');
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
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.res_date,re_resevation.down_payment,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,re_resevation.sales_person');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
	$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_eploan.loan_type ',"EPB");
		$this->db->where('re_eploan.start_date <',$enddate);
		//$this->db->where('re_eploan.loan_status','CONFIRMED');
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
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.down_payment,re_resevation.res_date,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,re_resevation.sales_person');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');

		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_eploan.loan_type ',"ZEP");
		$this->db->where('re_eploan.start_date <',$enddate);
	//	$this->db->where('re_eploan.loan_status','CONFIRMED');
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
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
		$this->db->where('re_prjacincome.entry_date <',$start_date);
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
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di,pay_amount');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
			$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('re_prjacincome.entry_date >=',$start_date);
		$this->db->where('re_prjacincome.entry_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}
	//Ticket No:3317 Updated By Madushan
	function loan_settlepayment_month($loan_code,$start_date,$enddate)
	{
		$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('balance_capital as sum_cap,int_paidamount as sum_int,delay_int as sum_di,new_discount as sum_add_discnt,credit_int as sum_credit_int');//Ticket No:2791 Updated By Madushan 2021.05.10
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id');
		$this->db->where('re_eprebate.loan_code',$loan_code);
		//$this->db->where('re_eprebate.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('re_prjacincome.entry_date >=',$start_date);
		$this->db->where('re_prjacincome.entry_date <=',$enddate);
		$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}//  provition Report

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
		$this->db->select('re_prjacpaymentdata.*,ac_payvoucherdata.status,ac_chqprint.CHQNO,cm_subtask.subtask_name,ac_entries.narration');
	//	if(! check_access('all_branch'))
		$this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('re_prjacpaymentdata.task_id',$task_id);
		$this->db->where('re_prjacpaymentdata.create_date <',$todate);
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid');
		$this->db->join('ac_entries',"ac_entries.id=ac_payvoucherdata.entryid",'left');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=re_prjacpaymentdata.subtask_id','left');

		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;

    }

    //Ticket No-2977 | Added By uvini
	function get_paymentlist_daterange($prj_id, $task_id,$fromdate,$todate) { //get all stock
		$this->db->select('re_prjacpaymentdata.*,ac_payvoucherdata.status,ac_chqprint.CHQNO,cm_subtask.subtask_name,ac_entries.narration');
	//	if(! check_access('all_branch'))
		$this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('re_prjacpaymentdata.task_id',$task_id);
		$this->db->where('re_prjacpaymentdata.create_date >=',$fromdate);
		$this->db->where('re_prjacpaymentdata.create_date <=',$todate);

		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=re_prjacpaymentdata.voucherid');
		$this->db->join('ac_entries',"ac_entries.id=ac_payvoucherdata.entryid",'left');
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
		//$this->db->where('re_projectms.status','PENDING');
		//$this->db->where('re_projectms.price_status','PENDING');
		$this->db->where('re_projectms.budgut_status','PENDING');//updated by nadee 2021-09-08
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
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
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
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');

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
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_unrealized.unrealized_sale,re_unrealized.unrealized_cost,re_prjaclotdata.costof_sale');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
					$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');

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
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
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
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_unrealized.unrealized_sale,re_unrealized.unrealized_cost,re_prjaclotdata.costof_sale');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
			$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
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
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
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
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_unrealized.unrealized_sale,re_unrealized.unrealized_cost,re_prjaclotdata.costof_sale');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
					$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
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
		$this->db->where('re_resevation.profit_status',"PENDING");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		//$this->db->where('re_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_Advance_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
						$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"PENDING");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		//$this->db->where('re_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_dpcomplete_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(re_resevation.discounted_price) as totsale,SUM(re_prjaclotdata.costof_sale) totcost, COUNT(re_prjaclotdata.lot_id) lotcount,SUM(re_unrealized.unrealized_sale) as unsale,SUM(re_unrealized.unrealized_cost) as uncost');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		//$this->db->where('re_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_dpcomplete_reservation_list($prj_id) { //get all stock
		$this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_unrealized.unrealized_sale,re_unrealized.unrealized_cost,re_prjaclotdata.costof_sale');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
						$this->db->where('re_resevation.prj_id',$prj_id);
							$this->db->join('re_unrealized','re_unrealized.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status',"PROCESSING");
		//$this->db->where('re_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
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
		//$this->db->where('re_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }

    /*Ticket No:2983,2984,2985 Updated By Madushan 2021.06.30*/
	function get_eploan_data($prj_id,$start_date,$loan_type = '') { //get all stock
	//echo $start_date;
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,cm_customerms.first_name,cm_customerms.last_name,
    cm_customerms.mobile,re_resevation.res_date,cm_banklist.BANKNAME,re_eploan.epb_branch AS BRANCHNAME,
    hr_empmastr.initial,hr_empmastr.surname,hr_empmastr.display_name,re_prjaclotdata.lot_type');
		$this->db->join('hr_empmastr','hr_empmastr.id=re_eploan.epb_officer','left');
		$this->db->join('cm_banklist','cm_banklist.BANKCODE=re_eploan.epb_bank','left');
		  //$this->db->join('cm_bnkbrnch','cm_bnkbrnch.BRANCHCODE=re_eploan.epb_branch','left');//ticket 3245
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($loan_type == 'NEP')
			$this->db->where('re_eploan.loan_type','NEP');
		if($loan_type == 'ZEP')
			$this->db->where('re_eploan.loan_type','ZEP');
		if($loan_type == 'EPB')
			$this->db->where('re_eploan.loan_type','EPB');
		else
			$this->db->where('re_eploan.loan_type !=','EPB');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status <>','REPROCESS');
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
		$this->db->select('SUM(re_eploanshedule.tot_payment) as totpay,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
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
		$this->db->select('re_prjacpaymentms.new_budget,re_prjacpaymentms.estimate_budget');

		$this->db->where('re_prjacpaymentms.prj_id',$id);
		$this->db->where('re_prjacpaymentms.task_id',$taskid);
		//$this->db->join('cm_tasktype','cm_tasktype.task_id=re_prjacpaymentms.task_id');
	//	$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('re_prjacpaymentms');
		 if ($query->num_rows >0) {
           $data= $query->row();
		   return $data->estimate_budget;
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


						$current_cap=$balance;
						$inttot=$inttot+$thismonthint;
						//echo $current_cap.',';

					}

					}
					return $inttot;

    }
	function loan_final_feedback($loan_code) { //get all stock
	//echo $start_date;
		$this->db->select('MAX(id),cus_feedback,sales_feedback,contact_media,follow_date');
			$this->db->where('loan_code',$loan_code);

		$query = $this->db->get('re_epfollowups');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_reservation_data_forsalsesforcast($prj_id) { //get all stock
		$this->db->select('re_resevation.*,re_prjaclotdata.lot_number,re_eploan.loan_type,re_eploan.loan_status');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code','left');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function Summery_advance_sum_this_month($prjid,$start_date,$enddate)
	{
		$this->db->select('SUM(re_saleadvance.pay_amount) as payment');
		$this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code','left');
		$this->db->where('re_resevation.prj_id',$prjid);
		$this->db->where('re_saleadvance.pay_date >=',$start_date);
		$this->db->where('re_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('re_saleadvance');
	//echo	$this->db->last_query();
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}
	function Summery_loan_payment_month($prjid,$start_date,$enddate,$type)
	{

		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code and re_eploan.reschdue_sqn=re_eploanpayment.reschdue_sqn','left');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code','left');
			$this->db->where('re_resevation.prj_id',$prjid);
			$this->db->where('re_eploan.loan_type',$type);
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
	function summery_pending_stock($id)
	{
		$this->db->select('SUM(sale_val) as totsale,SUM(costof_sale) as totcost ,COUNT(lot_id) as mycount');
		$this->db->where('prj_id',$id);
		$this->db->where('status','PENDING');
		$this->db->where('price_perch >','0');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_prjaclotdata');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
	//	echo $data->mycount.'-'.$id.'-'.$data->totcost.'<br>';
		return $data->totcost;
		}
		else
		return 0;
	}
	function summery_reserved_stock($id,$date)
	{
		$this->db->select('SUM(re_prjaclotdata.costof_sale) as totsale');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.res_date >',$date);
		$this->db->where('re_resevation.res_status !=','REPROCESS');
		$this->db->group_by('re_resevation.prj_id');
		$query = $this->db->get('re_resevation');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->totsale;
		}
		else
		return 0;
	}
	function Summery_reservation_balance_month($id,$stdate,$enddate)
	{

		$advancetot=0;
		$this->db->select('SUM(discounted_price) as totsale');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.res_date <',$enddate);
		$this->db->where('re_resevation.res_status','PROCESSING');
		$this->db->group_by('prj_id');
		$query = $this->db->get('re_resevation');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		$advancetot= $data->totsale;
		}
		else
		$advancetot = 0;

		$paymenttot=0;
		$this->db->select('SUM(re_saleadvance.pay_amount) as payment');
		$this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code','left');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.res_date <',$enddate);
		$this->db->where('re_resevation.res_status','PROCESSING');
		$this->db->where('re_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('re_saleadvance');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		$paymenttot= $data->payment;
		}
		else
		$paymenttot = 0;
		$balance= $advancetot-$paymenttot;
		return $balance;

	}
	function Summery_loan_balance_month($prjid,$start_date,$enddate,$type)
	{


		$advancetot=0;
		$this->db->select('SUM(re_eploan.loan_amount) as totsale');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code','left');
		$this->db->where('re_resevation.prj_id',$prjid);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('re_eploan.start_date <=',$enddate);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->group_by('re_resevation.prj_id');
		$query = $this->db->get('re_eploan');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		$advancetot= $data->totsale;
		}
		else
		$advancetot = 0;

		$paymenttot = 0;
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code and  re_eploan.reschdue_sqn=re_eploanpayment.reschdue_sqn','left');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code','left');
		$this->db->where('re_resevation.prj_id',$prjid);
		$this->db->where('re_eploan.loan_type',$type);
		$this->db->where('re_eploan.start_date <=',$enddate);
		$this->db->where('re_eploan.loan_status','CONFIRMED');
		$this->db->where('re_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			$data= $query->row();
		$paymenttot = $data->sum_cap;

		}
		else
		$paymenttot= 0;
		$balance= $advancetot-$paymenttot;
		return $balance;
	}
	function loan_payment_befoer_date_withoutreshed($loan_code,$start_date)
	{
		$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->join('re_prjacincome','re_eploanpayment.rct_id = re_prjacincome.id');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
		$this->db->where('re_prjacincome.entry_date <',$start_date);
		$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return $query->row();

		}
		else
		return 0;
	}
	function loan_payment_month_withoutreshed($loan_code,$start_date,$enddate)
	{
		$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		 $this->db->join('re_prjacincome','re_eploanpayment.rct_id = re_prjacincome.id');
		$this->db->where('re_eploanpayment.loan_code',$loan_code);
		$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('re_prjacincome.entry_date >=',$start_date);
		$this->db->where('re_prjacincome.entry_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}



	// new report functions on collection full summery
	function get_all_project_income_list($branchid,$projectid,$fromdate,$todate) {
		$this->db->select('re_prjacincome.*,SUM(re_eploanpayment.cap_amount) as sum_cap,SUM(re_eploanpayment.int_amount) as sum_int,SUM(re_eploanpayment.di_amount) as sum_di,re_saleadvance.pay_amount,re_saleadvance.di_amount  as advance_di,re_projectms.project_name,re_prjaclotdata.lot_number,re_eprebate.int_paidamount,re_eprebate.balance_capital,re_eploan.loan_type,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->join('re_projectms','re_projectms.prj_id=re_prjacincome.pri_id');

		//Ticket No:3357 Updated By Madushan 2021.08.30
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_prjacincome.cus_code','left');

		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_prjacincome.lot_id','left');/*Ticket No:2520 Updated By Madushan 2021.04.20*/
		$this->db->join('re_eploanpayment','re_eploanpayment.rct_id=re_prjacincome.id','left');
		$this->db->join('re_saleadvance','re_saleadvance.rct_id=re_prjacincome.id','left');
		$this->db->join('re_eprebate','re_eprebate.rct_id=re_prjacincome.id','left');
		$this->db->join('re_eploan','re_eploan.loan_code=re_prjacincome.temp_code','left');

		if($branchid!='ALL')
		$this->db->where('re_prjacincome.branch_code',$branchid);
		if($projectid!='ALL')
		$this->db->where('re_prjacincome.pri_id',$projectid);
		/*Ticket No:2520 Updated By Madushan 2021.04.20*/
		$this->db->where('re_prjacincome.entry_date >=',$fromdate);
		$this->db->where('re_prjacincome.entry_date <=',$todate);

		$this->db->group_by('re_prjacincome.id');
		/*Ticket No:2520 Updated By Madushan 2021.04.20*/
		$this->db->order_by('re_prjacincome.pri_id,re_prjacincome.entry_date');
		$query = $this->db->get('re_prjacincome');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		return $query->result();

		}
		else
		return false;
    }
	function get_first_advance($rescode)
	{
		$this->db->select('MIN(rct_id) as first_rct');
		$this->db->where('re_saleadvance.res_code',$rescode);
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		$data= $query->row();
		return  $data->first_rct;

		}
		else
		return 0;
	}

	// Milan request Colleciton report
	function get_eploan_data_other($prj_id,$start_date,$type) { //get all stock
	//echo $start_date;
		$this->db->select('re_eploan.*,re_prjaclotdata.sale_val,re_prjaclotdata.lot_number,cm_customerms.first_name,cm_customerms.last_name,,cm_customerms.address1,cm_customerms.address2,cm_customerms.address3,re_resevation.discounted_price,re_resevation.res_date,,re_resevation.res_date');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_eploan.cus_code');
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
	function get_last_payment_date($loan_code)
	{	$this->db->select('MAX(income_date) as lastdate');
		$this->db->where('re_prjacincome.temp_code',$loan_code);

		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return $data->lastdate;

		}
		else
		return 0;
	}
function uptodate_arrears($loancode,$deu_date)
	{
		$loandata=$this->get_loandata_loancode($loancode);
		$this->db->select('SUM(re_eploanshedule.paid_cap) as cap,SUM(re_eploanshedule.paid_int) as inttot,SUM(re_eploanshedule.tot_instalment) as arriastot,COUNT(re_eploanshedule.id) instalmentcount');
		$this->db->where('re_eploanshedule.loan_code',$loancode);
		$this->db->where('re_eploanshedule.reschdue_sqn',$loandata->reschdue_sqn);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
		$this->db->where('re_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

		if ($query->num_rows() > 0){


		$data= $query->row();
		$paidtot=0;
		$paiddata=$this->loan_paid_amounts($loancode,$deu_date,$loandata->reschdue_sqn);
		if($paiddata)
		$paidtot=$paiddata->totcap+$paiddata->totint;
		$arr= $data->arriastot-$paidtot;


		return $arr;
		}
		else
		return 0;

	}
	function get_all_project_summery_prj($prj_id) { //get all stock

				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				if($prj_id!="ALL")
				$this->db->where('prj_id',$prj_id);
				$this->db->order_by('project_name');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();

    }
	function allloans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('re_eploan.*');
		$this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.down_payment,re_resevation.res_date,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,re_resevation.sales_person');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');

		$this->db->where('re_resevation.prj_id',$id);
	//	$this->db->where('re_eploan.loan_type ',"ZEP");
		$this->db->where('re_resevation.res_date <',$enddate);
	//	$this->db->where('re_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('re_eploan');
			//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }

	// sales forcast model new addition  - Start


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
	//	$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date >=',$fromdate);
		$this->db->where('re_resevation.res_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->totblocks;
		}
		else
		return 0;
    }
	function get_month_target($prj_id,$month,$year,$salsment)
	{
		$this->db->select('*');
		$this->db->where('prj_id',$prj_id);
		//$this->db->where('officer_id',$salsment);
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
	function get_tot_sale_downpayment($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('SUM(down_payment) as tot');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date >=',$fromdate);
		$this->db->where('re_resevation.res_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->tot;
		}
		else
		return 0;
    }
	function get_tot_sale_reservationlist($prj_id,$fromdate,$todate) { //get all stock
	$this->db->select('re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_prjaclotdata.extend_perch,re_prjaclotdata.price_perch,re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
			$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.res_date >=',$fromdate);
		$this->db->where('re_resevation.res_date <=',$todate);

		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	//added by udani ticket number 2591
	function get_realized_sale_andcost_date($res_code,$date)
	{
		$this->db->select('SUM(re_unrealizeddata.trn_sale) as totsale,SUM(re_unrealizeddata.trn_cost) as totcost');
		$this->db->where('re_unrealizeddata.res_code',$res_code);
		$this->db->where('re_unrealizeddata.date <=',$date);

		$query = $this->db->get('re_unrealizeddata');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data;
		}
		else
		return false;
	}


	 //Ticket No:2537 Added By Madushan
    function get_all_block_details_list($branchid,$projectid,$date)
    {
    	$this->db->select('re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.lot_id,re_prjaclotdata.status,re_prjaclotdata.sale_val');
    	$this->db->from('re_prjaclotdata');
    	$this->db->join('re_projectms','re_projectms.prj_id = re_prjaclotdata.prj_id');
    	if($projectid!='ALL'){
    		$this->db->where('re_prjaclotdata.prj_id',$projectid);
    	}
    	// $this->db->join('re_resevation','re_resevation.lot_id = re_prjaclotdata.lot_id','left');
    	// $this->db->join('cm_customerms','cm_customerms.cus_code = re_resevation.cus_code','left');
    	$this->db->where('re_prjaclotdata.create_date <=',$date);
    	//$this->db->where('re_resevation.res_status <>','REPROCESS');
    	$query = $this->db->get();

    	if ($query->num_rows() > 0){
		return $query->result();

		}
		else
		return false;
    	// $query = $this->db->get()->result_array();
    	// foreach($query as $row)
    	// {
    	// 	echo $row['project_name'].' - '.$row['lot_number'].' - '.$row['status'].' - '.$row['full_name'].' - '.$row['res_code'].' - '.$row['sale_val'].' - '.$row['discounted_price'].'<br>';
    	// }

    }


    function get_reserved_block_details($lot_id)
    {
    	$this->db->select('cm_customerms.full_name,re_resevation.res_code,re_resevation.discounted_price,re_resevation.profit_date,re_resevation.down_payment');
    	$this->db->from('re_resevation');
    	$this->db->join('cm_customerms','cm_customerms.cus_code = re_resevation.cus_code');
    	$this->db->where('lot_id',$lot_id);
    	$this->db->where('res_status <>','REPROCESS');
    	return $this->db->get()->row();
    }

    //End of Ticket No:2537

    /*Ticket No:2520 Added By Madushan 2021.04.20*/
	function get_other_chargers($id)
	{
		$this->db->select('*');
		$this->db->from('re_chargepayments');
		$this->db->where('rct_id',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
		return $query->result_array();
		}
		else
		return false;

	}

	/*Ticket No:2983,2984,2985 Added By Madushan 2021.06.30*/
	function get_no_of_due_rentals($loan_code,$enddate)
	{
		$this->db->select('COUNT(deu_date) as no_of_due,SUM(tot_instalment) as tot_due');
		$this->db->where('loan_code',$loan_code);
		$this->db->where('deu_date <=',$enddate);
		$query = $this->db->get('re_eploanshedule');
		if($query->num_rows>0)
			return $query->row();
		else
			return 0;
	}

	function get_current_month_details($loan_code,$stdate,$enddate)
	{
		$this->db->select('*');
		$this->db->where('loan_code',$loan_code);
		$this->db->where('deu_date >=',$stdate);
		$this->db->where('deu_date <=',$enddate);
		$query = $this->db->get('re_eploanshedule');
		if($query->num_rows>0)
			return $query->row();
		else
			return 0;
	}

	function get_current_month_payment($loan_code,$stdate,$enddate)
	{
		$this->db->select('*');
		$this->db->where('loan_code',$loan_code);
		$this->db->where('pay_date >=',$stdate);
		$this->db->where('pay_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if($query->num_rows>0)
			return $query->row();
		else
			return 0;
	}

	function get_loan_last_payment_date($loan_code,$enddate)
	{
		$this->db->select('MAX(pay_date) as last_date,SUM(cap_amount) as paid_cap,SUM(int_amount) as paid_int');
		$this->db->where('loan_code',$loan_code);
		//$this->db->where('pay_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if($query->num_rows>0)
			return $query->row();
		else
			return 0;
	}
	/*End of Ticket No:2983,2984,2985*/

  //2021-06-29 ticket 2986 by nadee
    function get_advance_arrears_data($prj_id,$start_date)
    {
      $this->db->select('re_resevation.*,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,re_prjaclotdata.lot_number,
      re_prjaclotdata.sale_val,');
  		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
  		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
  		$this->db->where('re_resevation.prj_id',$prj_id);
      $this->db->where('re_resevation.profit_status',"PENDING");
       $this->db->where('re_resevation.res_status <>',"REPROCESS");

  		$query = $this->db->get('re_resevation');
  		if ($query->num_rows() > 0){
  		return $query->result();
  		}
  		else
  		return false;
    }

    function resevation_shedule_count($res_code)
    {
      $this->db->select('count(id) as counts');
  		$this->db->where('res_code',$res_code);

  		$query = $this->db->get('re_salesadvanceshedule');
  		if ($query->num_rows() > 0){
  		$data=$query->row_array();
      return $data['counts'];
  		}
  		else
  		return 0;
    }
    function resevation_shedule_data($res_code)
    {
      $this->db->select('*');
  		$this->db->where('res_code',$res_code);

  		$query = $this->db->get('re_salesadvanceshedule');
  		if ($query->num_rows() > 0){
      return $query->result();
  		}
  		else
  		return 0;
    }
    function get_month_advance_byrescode($id,$stdate,$enddate)
    {
      $this->db->select('SUM(re_saleadvance.pay_amount) as tot,max(rct_no) AS rct_no,max(entry_date) AS entry_date,max(income_date) AS income_date');
      //$this->db->select('re_saleadvance.*');

      $this->db->join('re_prjacincome','re_prjacincome.id=re_saleadvance.rct_id');
      $this->db->join('re_resevation','re_resevation.res_code=re_saleadvance.res_code');
      $this->db->where('re_resevation.res_code',$id);
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

    //2021-06-29 end ticket 2986 by nadee

    function loan_payment_month_receipts($loan_code,$startdate,$enddate)
    {
      $loandata=$this->get_loandata_loancode($loan_code);
      $this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di,re_prjacincome.rct_no,
re_prjacincome.entry_date,re_prjacincome.income_date');
      $this->db->join('re_prjacincome','re_eploanpayment.rct_id = re_prjacincome.id');
      $this->db->where('re_eploanpayment.loan_code',$loan_code);
    	$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
      $this->db->where('re_prjacincome.entry_date >=',$startdate);
      $this->db->where('re_prjacincome.entry_date <=',$enddate);
      $this->db->group_by('re_eploanpayment.rct_id');
      $query = $this->db->get('re_eploanpayment');
      if ($query->num_rows() > 0){
        //$data= $query->row();
      return  $query->result();

      }
      else
      return 0;
    }


    function zepploans_befor_collection($id,$stdate,$enddate) { //get all stock
    $lotarr=NULL;
    $counter=0;
      //$this->db->select('re_eploan.*');
      $this->db->select('re_eploan.*,re_prjaclotdata.lot_number,re_prjaclotdata.sale_val,re_resevation.discounted_price,re_resevation.down_payment,re_resevation.res_date,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,re_resevation.sales_person');
      $this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
      $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
      $this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
      $this->db->join('re_prjacincome','re_prjacincome.temp_code=re_eploan.loan_code');

      $this->db->where('re_resevation.prj_id',$id);
      $this->db->where('re_eploan.loan_type ',"ZEP");
      $this->db->where('re_eploan.start_date <',$enddate);
      $this->db->where('re_prjacincome.entry_date >=',$stdate);
      $this->db->where('re_prjacincome.entry_date <=',$enddate);
      $this->db->group_by('re_eploan.loan_code');
    //	$this->db->where('re_eploan.loan_status','CONFIRMED');
        $query = $this->db->get('re_eploan');
        //echo $this->db->last_query();
      if ($query->num_rows() > 0){
        return $query->result();

      }
      else
      return 0;
      }

      //2021-07-15 end ticket 3079 by nadee

      //Ticket No:3300 Added By Madushan 2021-08-16
       function get_all_reservations_by_project($prj_id){
      	$this->db->select('*');
      	$this->db->where('prj_id',$prj_id);
      	$query = $this->db->get('re_resevation');
      	if($query->num_rows>0)
      		return $query->result();
      	else
      		return false;
      }

      function get_all_project_summery_date($branchid,$prj_id = 'all',$date) { //get all stock
		if($this->session->userdata('usertype')!='Project Officer'){
			if($branchid=='ALL' & check_access('all_branch')){
				$this->db->select('re_projectms.*');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
				$this->db->where('re_projectms.create_date <=',$date);
				if($prj_id != 'all')
					$this->db->where('re_projectms.prj_id',$prj_id);
				$this->db->order_by('project_name');
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
			else
			{
				$this->db->select('re_projectms.*');
				$this->db->where('branch_code',$branchid);
				$this->db->order_by('project_name');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
				$this->db->where('re_projectms.create_date <=',$date);
				if($prj_id != 'all')
					$this->db->where('re_projectms.prj_id',$prj_id);
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
		}
		else
		{
			$this->db->select('re_projectms.*');
		$this->db->where('officer_code',$this->session->userdata('userid'));
		$this->db->order_by('project_name');
		$this->db->where('re_projectms.status',CONFIRMKEY);
		$this->db->where('re_projectms.price_status',CONFIRMKEY);
		$this->db->where('re_projectms.create_date <=',$date);
		if($prj_id != 'all')
					$this->db->where('re_projectms.prj_id',$prj_id);
	//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
		$query = $this->db->get('re_projectms');
		return $query->result();
		}
    }

    //Ticket No:3337 Added By Madushan 2021-08-25
    function get_all_sold_lots_befor_date($prj_id,$date)
    {
    	$this->db->select('re_prjaclotdata.*,re_resevation.discounted_price');
    	$this->db->join('re_resevation','re_resevation.lot_id = re_prjaclotdata.lot_id');
    	$this->db->where('re_prjaclotdata.prj_id',$prj_id);
    	$this->db->where('re_resevation.res_status <>','REPROCESS');
    	$this->db->where('re_resevation.res_date <=',$date);
    	$query = $this->db->get('re_prjaclotdata');
    	if($query->num_rows>0)
    		return $query->result();
    	else
    		return false;

    }

    function advance_sum_as_at_date($res_code,$start_date)
	{
		$this->db->select('SUM(pay_amount) as payment');
		$this->db->where('re_saleadvance.res_code',$res_code);
		$this->db->where('re_saleadvance.pay_date <=',$start_date);
		$query = $this->db->get('re_saleadvance');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}

	function loan_payment_as_at_date($res_code,$start_date)
	{
		$loandata=$this->get_loandata_byrescode($res_code);
		if($loandata)
		{
			$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
			$this->db->where('re_eploanpayment.loan_code',$loandata->loan_code);
			$this->db->where('re_eploanpayment.pay_date <=',$start_date);
			//	$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

			$query = $this->db->get('re_eploanpayment');
			if ($query->num_rows() > 0){
				//$data= $query->row();
			return $query->row();

			}
			else
			return 0;
		}
		else
		{
			return 0;
		}

	}

	//Ticket No:3337 Added By Madushan 2021-08-25
	function get_all_blocks_asAt_date($prj_id,$date)
	{
		$this->db->select('re_prjaclotdata.*,re_resevation.discounted_price');
		$this->db->join('re_resevation','re_resevation.lot_id = re_prjaclotdata.lot_id','left');
		$this->db->where('re_prjaclotdata.prj_id',$prj_id);
		$this->db->where('re_prjaclotdata.extend_perch >',0);
		$this->db->group_by('re_prjaclotdata.lot_id');
		$query = $this->db->get('re_prjaclotdata');
		if($query->num_rows>0)
			return $query->result();
		else
			return false;
	}


	function loan_settlepayment_as_at_date($res_code,$start_date)
	{
		$loandata=$this->get_loandata_byrescode($res_code);
		if($loandata)
		{
			//$loandata=$this->get_loandata_loancode($loan_code);
			$this->db->select('balance_capital as sum_cap,int_paidamount as sum_int,delay_int as sum_di');//Ticket No:2791 Updated By Madushan 2021.05.10
			$this->db->where('re_eprebate.loan_code',$loandata->loan_code);
				//$this->db->where('re_eprebate.reschdue_sqn',$loandata->reschdue_sqn);
			$this->db->where('re_eprebate.confirm_date <=',$start_date);
			$query = $this->db->get('re_eprebate');
			if ($query->num_rows() > 0){
				//$data= $query->row();
			return  $query->row();

			}
			else
			return 0;
		}
		else
			return 0;
	}

	//End of Ticket No:3300 Added By Madushan 2021-08-16

	//Ticket No:3317 Added By Madushan 2021-08-19
    function loan_settlements_month_receipts($loan_code,$startdate,$enddate)
    {
      $loandata=$this->get_loandata_loancode($loan_code);
      $this->db->select('SUM(balance_capital) as sum_cap,SUM(int_paidamount) as sum_int,SUM(delay_int) as sum_di,SUM(new_discount) as sum_add_discnt,SUM(credit_int) as sum_credit_int,re_prjacincome.rct_no,re_prjacincome.entry_date,re_prjacincome.income_date');
      $this->db->join('re_prjacincome','re_eprebate.rct_id = re_prjacincome.id');
      $this->db->where('re_eprebate.loan_code',$loan_code);
    	//$this->db->where('re_eprebate.reschdue_sqn',$loandata->reschdue_sqn);
      $this->db->where('re_prjacincome.entry_date >=',$startdate);
      $this->db->where('re_prjacincome.entry_date <=',$enddate);
      $this->db->group_by('re_eprebate.rct_id');
      $query = $this->db->get('re_eprebate');
      if ($query->num_rows() > 0){
        //$data= $query->row();
      return  $query->result();

      }
      else
      return 0;
    }
    //End of Ticket No:3317

    //Ticket No:3356 Added By Madushan 2021-08-30
    function down_payment_month_receipts($res_code,$startdate,$enddate)
    {
      $this->db->select('re_prjacincome.*');
      $this->db->where('re_prjacincome.temp_code',$res_code);
    //		$this->db->where('re_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
      $this->db->where('re_prjacincome.entry_date >=',$startdate);
      $this->db->where('re_prjacincome.entry_date <=',$enddate);
      $this->db->group_by('re_prjacincome.rct_no');
      $query = $this->db->get('re_prjacincome');
      if ($query->num_rows() > 0){
        //$data= $query->row();
      return  $query->result();

      }
      else
      return 0;
    }
function get_profittransfer_data_period_project_summery($prj_id,$fromdate,$todate) { //get all stock

$array=array(0,0);
		$this->db->select('re_resevation.*,SUM(re_unrealizeddata.trn_sale) as selstot,SUM(re_unrealizeddata.trn_cost) as costtot' );
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->join('re_unrealizeddata','re_unrealizeddata.res_code=re_resevation.res_code');
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_unrealizeddata.date >=',$fromdate);
		$this->db->where('re_unrealizeddata.date <=',$todate);
		$this->db->group_by('re_unrealizeddata.res_code');

		$query = $this->db->get('re_resevation');
		
		if ($query->num_rows() > 0){
		$dataset= $query->result();
			foreach($dataset as $raw)
			{
				if($raw->res_status=='REPROCESS')
				{
					if($raw->resale_date>$todate)
					{
						$array[0]=$array[0]+$raw->selstot;
						$array[1]=$array[1]+$raw->costtot;
					}
				}
				else
				{
					$array[0]=$array[0]+$raw->selstot;
						$array[1]=$array[1]+$raw->costtot;
				}
			}
			return $array;
		}
		else
		return $array;
    }
}
