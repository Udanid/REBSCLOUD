<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_report_model extends CI_Model {
function __construct() {
        parent::__construct();
    }
	function get_all_project_summery($branchid) { //get all stock
		if($this->session->userdata('usertype')!='Project Officer'){
			if($branchid=='ALL' & check_access('all_branch')){
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('hm_projectms.status',CONFIRMKEY);
				$this->db->where('hm_projectms.price_status',CONFIRMKEY);
				$this->db->order_by('project_name');
			//	$this->db->where('hm_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('hm_projectms');
				return $query->result();
			}
			else
			{
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('branch_code',$branchid);
				$this->db->order_by('project_name');
				$this->db->where('hm_projectms.status',CONFIRMKEY);
				$this->db->where('hm_projectms.price_status',CONFIRMKEY);
			//	$this->db->where('hm_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('hm_projectms');
				return $query->result();
			}
		}
		else
		{
			$this->db->select('prj_id,project_code,project_name,branch_code,town');
		$this->db->where('officer_code',$this->session->userdata('userid'));
		$this->db->order_by('project_name');
		$this->db->where('hm_projectms.status',CONFIRMKEY);
		$this->db->where('hm_projectms.price_status',CONFIRMKEY);
	//	$this->db->where('hm_projectms.budgut_status',CONFIRMKEY);
		$query = $this->db->get('hm_projectms');
		return $query->result();
		}
    }
	function get_loandata_byrescode($id)
	{
		$this->db->select('*');
		$this->db->where('res_code',$id);
		$query = $this->db->get('hm_eploan');
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
		$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
	}
	function get_resevation($id) { //get all stock
		$this->db->select('*');
		$this->db->where('res_code',$id);
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_lotdata($id) { //get all stock
		$this->db->select('*');
		$this->db->where('lot_id',$id);
		$query = $this->db->get('hm_prjaclotdata');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_paid_capital($id)
	{$loandata=$this->get_loandata_loancode($id);
		$this->db->select('SUM(hm_eploanpayment.cap_amount) as tot');
			$this->db->join('hm_prjacincome','hm_prjacincome.id=hm_eploanpayment.rct_id');
		$this->db->where('hm_eploanpayment.loan_code',$id);
		$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('hm_prjacincome.pay_status','PAID');
		$this->db->group_by('loan_code');
		$query = $this->db->get('hm_eploanpayment');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->tot;
		}
		else
		return false;
	}
	function get_paid_advance($id)
	{
		$this->db->select('SUM(hm_saleadvance.pay_amount) as tot');
			$this->db->join('hm_prjacincome','hm_prjacincome.id=hm_saleadvance.rct_id');
		$this->db->where('hm_saleadvance.res_code',$id);
	$this->db->where('hm_prjacincome.pay_status','PAID');
		$this->db->group_by('hm_saleadvance.res_code');
		$query = $this->db->get('hm_saleadvance');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$query = $this->db->get('hm_prjaclotdata');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data;
		}
		else
		return false;
	}
	function get_profittransfer_data($prj_id) { //get all stock
		$this->db->select('hm_resevation.*');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");

		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
		function get_profittransfer_data_period($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('hm_resevation.*');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.profit_date >=',$fromdate);
		$this->db->where('hm_resevation.profit_date <=',$todate);

		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_profittransfer_data_period_sum($prj_id,$fromdate,$todate) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as selstot,SUM(hm_prjaclotdata.costof_sale) as costtot' );
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.profit_date >=',$fromdate);
		$this->db->where('hm_resevation.profit_date <=',$todate);

		$query = $this->db->get('hm_resevation');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('res_date >=',$stdate);
		$this->db->where('res_date <',$enddate);
		$query = $this->db->get('hm_resevation');
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
		$this->db->select('hm_prjaclotdata.*,hm_resevation.res_date');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");
			//$this->db->where('hm_resevation.res_date >=',$stdate);
			$this->db->where('hm_resevation.res_date >',$enddate);
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function reservation_lots_befor($id,$enddate,$stdate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		$this->db->select('hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val,hm_resevation.*,hm_eploan.loan_code,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		//$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_date <',$enddate);
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->join('hm_eploan',"hm_eploan.res_code=hm_resevation.res_code",'left');
			$this->db->order_by('hm_prjaclotdata.lot_number');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function check_loan_befordate($res_code,$start_date)
	{
		$this->db->select('loan_code');
		$this->db->where('hm_eploan.res_code',$res_code);
			$this->db->where('hm_eploan.start_date <',$start_date);
		$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
			return false;

		}
		else
		return true;
	}
	function advance_sum_befoer_date($res_code,$start_date)
	{
		$this->db->select('SUM(pay_amount) as payment');
		$this->db->where('hm_saleadvance.res_code',$res_code);
		$this->db->where('hm_saleadvance.pay_date <',$start_date);
		$query = $this->db->get('hm_saleadvance');
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
		$this->db->where('hm_saleadvance.res_code',$res_code);
		$this->db->where('hm_saleadvance.pay_date >=',$start_date);
		$this->db->where('hm_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('hm_saleadvance');
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
		$this->db->select('SUM(hm_saleadvance.pay_amount) as payment');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_saleadvance.res_code');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_saleadvance.pay_date >=',$start_date);
		$this->db->where('hm_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('hm_saleadvance');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->payment;

		}
		else
		return 0;
	}
	function project_sales_month($prj_id,$start_date,$enddate)
	{
		$this->db->select('SUM(hm_resevation.discounted_price) as payment');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_date >=',$start_date);
		$this->db->where('hm_resevation.res_date <=',$enddate);
		$query = $this->db->get('hm_resevation');
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
		//$this->db->select('hm_eploan.*');
		$this->db->select('hm_eploan.*,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val,hm_resevation.res_date,hm_resevation.discounted_price,hm_resevation.down_payment,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,hm_resevation.sales_person');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
	$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_eploan.loan_type ',"NEP");
		$this->db->where('hm_eploan.start_date <',$enddate);
		//$this->db->where('hm_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function epbloans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('hm_eploan.*');
		$this->db->select('hm_eploan.*,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val,hm_resevation.discounted_price,hm_resevation.res_date,hm_resevation.down_payment,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,hm_resevation.sales_person');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
	$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_eploan.loan_type ',"EPB");
		$this->db->where('hm_eploan.start_date <',$enddate);
		//$this->db->where('hm_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }
	function zepploans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('hm_eploan.*');
		$this->db->select('hm_eploan.*,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val,hm_resevation.discounted_price,hm_resevation.down_payment,hm_resevation.res_date,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,hm_resevation.sales_person');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');

		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_eploan.loan_type ',"ZEP");
		$this->db->where('hm_eploan.start_date <',$enddate);
	//	$this->db->where('hm_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('hm_eploan');
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
		$this->db->where('hm_eploanpayment.loan_code',$loan_code);
		$this->db->where('hm_eploanpayment.pay_date <',$start_date);
			$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

		$query = $this->db->get('hm_eploanpayment');
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
		$this->db->where('hm_eploanpayment.loan_code',$loan_code);
			$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('hm_eploanpayment.pay_date >=',$start_date);
		$this->db->where('hm_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('hm_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}
	function loan_settlepayment_month($loan_code,$start_date,$enddate)
	{
		//$loandata=$this->get_loandata_loancode($loan_code);
		$this->db->select('balance_capital as sum_cap,balance_int as sum_int');
		$this->db->where('hm_eprebate.loan_code',$loan_code);
			//$this->db->where('hm_eprebate.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('hm_eprebate.confirm_date >=',$start_date);
		$this->db->where('hm_eprebate.confirm_date <=',$enddate);
		$query = $this->db->get('hm_eprebate');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}//  provition Reports

	function get_project_paymeny_task($id)
	{
		$this->db->select('hm_prjacpaymentms.*,cm_tasktype.task_name');

		$this->db->where('hm_prjacpaymentms.prj_id',$id);
		$this->db->join('cm_tasktype','cm_tasktype.task_id=hm_prjacpaymentms.task_id');
		$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('hm_prjacpaymentms');
		 if ($query->num_rows >0) {
            return $query->result();
        }
		else
		return false;
	}
	function get_paymentlist($prj_id, $task_id,$todate) { //get all stock
		$this->db->select('hm_prjacpaymentdata.*,ac_payvoucherdata.status,ac_chqprint.CHQNO,cm_subtask.subtask_name');
	//	if(! check_access('all_branch'))
		$this->db->where('hm_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('hm_prjacpaymentdata.task_id',$task_id);
		$this->db->where('hm_prjacpaymentdata.create_date <',$todate);
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=hm_prjacpaymentdata.voucherid');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=hm_prjacpaymentdata.subtask_id','left');

		$query = $this->db->get('hm_prjacpaymentdata');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
		return false;

    }
	function get_paymentlist_daterange($prj_id, $task_id,$fromdate,$todate) { //get all stock
		$this->db->select('hm_prjacpaymentdata.*,ac_payvoucherdata.status,ac_chqprint.CHQNO,cm_subtask.subtask_name');
	//	if(! check_access('all_branch'))
		$this->db->where('hm_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('hm_prjacpaymentdata.task_id',$task_id);
		$this->db->where('hm_prjacpaymentdata.create_date >=',$fromdate);
		$this->db->where('hm_prjacpaymentdata.create_date <=',$todate);
		$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid=hm_prjacpaymentdata.voucherid');
		$this->db->join('ac_chqprint',"ac_chqprint.PAYREFNO=ac_payvoucherdata.entryid and ac_payvoucherdata.status='PAID'",'left');
		$this->db->join('cm_subtask','cm_subtask.subtask_id=hm_prjacpaymentdata.subtask_id','left');

		$query = $this->db->get('hm_prjacpaymentdata');
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
		$this->db->where('hm_projectms.status','PENDING');
		$this->db->where('hm_projectms.price_status','PENDING');
	//	$this->db->where('hm_projectms.budgut_status',CONFIRMKEY);
		$query = $this->db->get('hm_projectms');
		return $query->result();
    }
	function get_reservation_data($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,hm_prjaclotdata.lot_number');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");

		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_paylist_capital($id)
	{$loandata=$this->get_loandata_loancode($id);

		$this->db->select('hm_eploanpayment.*');
			$this->db->join('hm_prjacincome','hm_prjacincome.id=hm_eploanpayment.rct_id');
		$this->db->where('hm_eploanpayment.loan_code',$id);
		$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
			$this->db->where('hm_prjacincome.pay_status','PAID');
		$query = $this->db->get('hm_eploanpayment');
		if ($query->num_rows() > 0){
		//$data= $query->result();
		return$query->result();
		}
		else
		return false;
	}
	function get_paylist_advance($id)
	{
		$this->db->select('hm_saleadvance.*');
		$this->db->join('hm_prjacincome','hm_prjacincome.id=hm_saleadvance.rct_id');
		$this->db->where('hm_saleadvance.res_code',$id);
		$this->db->where('hm_prjacincome.pay_status','PAID');
		$query = $this->db->get('hm_saleadvance');
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
		$query = $this->db->get('hm_salesforcast');
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
			$this->db->select('hm_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
			$this->db->where('hm_projectms.status',CONFIRMKEY);
			$this->db->where('hm_projectms.price_status',CONFIRMKEY);
			$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code');
			$this->db->order_by('hm_projectms.branch_code,hm_projectms.officer_code');
			$query = $this->db->get('hm_projectms');
			return $query->result();
			}
			else
			{
				$this->db->select('hm_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
				$this->db->where('branch_code',$branchid);
				$this->db->where('hm_projectms.status',CONFIRMKEY);
				$this->db->where('hm_projectms.price_status',CONFIRMKEY);
				$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code');
				$this->db->order_by('hm_projectms.officer_code');
				$query = $this->db->get('hm_projectms');
				return $query->result();
			}
		}
		else
		{
			$this->db->select('hm_projectms.*,hr_empmastr.initial,hr_empmastr.surname');
		if(! check_access('all_branch'))
		$this->db->where('officer_code',$this->session->userdata('userid'));
		$this->db->where('hm_projectms.status',CONFIRMKEY);
		$this->db->where('hm_projectms.price_status',CONFIRMKEY);
		$this->db->join('hr_empmastr','hr_empmastr.id=hm_projectms.officer_code');
		$this->db->order_by('hm_projectms.officer_code');
		$query = $this->db->get('hm_projectms');
		}
	}
	function get_month_target($prj_id,$month,$year,$salsment)
	{
		$this->db->select('target');
		$this->db->where('prj_id',$prj_id);
		$this->db->where('officer_id',$salsment);
		$this->db->where('month',$month);
		$this->db->where('year',$year);
		$query = $this->db->get('hm_salestarget');
		 if ($query->num_rows >0) {
			 $data=$query->row();
            return $data->target;
        }
		else
		return 0;
	}
	function get_month_advance($id,$stdate,$enddate)
	{
		$this->db->select('SUM(hm_saleadvance.pay_amount) as tot');
		//$this->db->select('hm_saleadvance.*');

		$this->db->join('hm_prjacincome','hm_prjacincome.id=hm_saleadvance.rct_id');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_saleadvance.res_code');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_prjacincome.pay_status','PAID');
		$this->db->where('hm_saleadvance.pay_date >=',$stdate);
			$this->db->where('hm_saleadvance.pay_date <=',$enddate);
			//$this->db->group_by('hm_resevation.prj_id');
		$query = $this->db->get('hm_saleadvance');
		if ($query->num_rows() > 0){
	//	$data= $query->row();
		return $query->row();
		}
		else
		return false;
	}
	function get_month_capital($id,$stdate,$enddate)
	{$status = array('ZEP', 'EPB');
		$this->db->select('SUM(hm_eploanpayment.cap_amount) as captot,SUM(hm_eploanpayment.int_amount) as inttot');
			$this->db->join('hm_prjacincome','hm_prjacincome.id=hm_eploanpayment.rct_id');
				$this->db->join('hm_eploan','hm_eploan.loan_code=hm_eploanpayment.loan_code');
				$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->where('hm_resevation.prj_id',$id);
			$this->db->whehm_in('hm_eploan.loan_type',$status);
			$this->db->where('hm_eploanpayment.pay_date >=',$stdate);
			$this->db->where('hm_eploanpayment.pay_date <=',$enddate);
		$this->db->where('hm_prjacincome.pay_status','PAID');
	//	$this->db->group_by('hm_eploan.loan_code');
		$query = $this->db->get('hm_eploanpayment');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$query = $this->db->get('hm_prjaclotdata');
		if ($query->num_rows() > 0){

		return  $query->row();
		}
		else
		return 0;
    }
	function get_settled_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"SETTLED");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_settled_reservation_list($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
		$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"SETTLED");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_init_settled($prj_id) { //get all stock
		//$this->db->group_by('prj_id');
		$query = $this->db->query('SELECT SUM(hm_prjaclotdata.sale_val) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount FROM hm_prjaclotdata WHERE Status="SOLD" AND prj_id="'.$prj_id.'" AND lot_id NOT IN (SELECT  lot_id FROM hm_resevation )');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_init_settled_list($prj_id) { //get all stock
		//$this->db->group_by('prj_id');
		$query = $this->db->query('SELECT * FROM hm_prjaclotdata WHERE Status="SOLD" AND prj_id="'.$prj_id.'" AND lot_id NOT IN (SELECT  lot_id FROM hm_resevation )');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_NEP_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');

		$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"NEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
		function get_NEP_reservation_list($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');

		$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"NEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function get_EPB_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"EPB");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
		function get_EPB_reservation_list($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
						$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"EPB");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_ZEP_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"ZEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_ZEP_reservation_list($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
						$this->db->where('hm_resevation.prj_id',$prj_id);
	//	$this->db->where('hm_resevation.res_status !=',"REPROCESS");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"ZEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_ZEP_reservation_data_profit($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status',"COMPLETE");
		$this->db->where('hm_resevation.pay_type ',"ZEP");
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_Advance_reservation_data($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		//$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status',"PROCESSING");
		//$this->db->where('hm_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_Advance_reservation_list($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,cm_customerms.first_name,cm_customerms.last_name,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
				$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');
						$this->db->where('hm_resevation.prj_id',$prj_id);
		//$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status',"PROCESSING");
		//$this->db->where('hm_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_Advance_reservation_data_profit($prj_id) { //get all stock
		$this->db->select('SUM(hm_resevation.discounted_price) as totsale,SUM(hm_prjaclotdata.costof_sale) totcost, COUNT(hm_prjaclotdata.lot_id) lotcount');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.profit_status',"TRANSFERD");
		$this->db->where('hm_resevation.res_status',"PROCESSING");
		//$this->db->where('hm_resevation.pay_type',"Pending");//commit by nadee ticket number 1175
		//$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_eploan_data($prj_id,$start_date) { //get all stock
	//echo $start_date;
		$this->db->select('hm_eploan.*,hm_prjaclotdata.lot_number');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_eploan.loan_type !=','EPB');
		$this->db->where('hm_eploan.start_date <= ',$start_date);

		$this->db->where('hm_eploan.loan_status',"CONFIRMED");

		$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	function get_eploan_arrears_tot($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(hm_eploanshedule.tot_payment) as totpay,SUM(hm_eploanshedule.tot_instalment) as arriastot,COUNT(hm_eploanshedule.id) instalmentcount');
		$this->db->where('hm_eploanshedule.loan_code',$loancode);
		$this->db->where('hm_eploanshedule.reschdue_sqn',$reschdue_sqn);

	//	$this->db->where('hm_eploanshedule.pay_status','PENDING');
	//	$this->db->join('hm_eploanpayment','hm_eploanpayment.ins_id=hm_eploanshedule.id');
			//$this->db->where('hm_eploanpayment.pay_date<',$deu_date);
		$this->db->where('hm_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('hm_eploanshedule.loan_code');
			$query = $this->db->get('hm_eploanshedule');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}

	function get_eploan_credit_tot($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(hm_eploanshedule.tot_payment) as totpay,SUM(hm_eploanshedule.tot_instalment) as arriastot,COUNT(hm_eploanshedule.id) instalmentcount');
		$this->db->where('loan_code',$loancode);
			$this->db->where('hm_eploanshedule.reschdue_sqn',$reschdue_sqn);
		$this->db->where('deu_date >=',$deu_date);
			$this->db->where('tot_payment >',0.00);
			$this->db->group_by('loan_code');
		$query = $this->db->get('hm_eploanshedule');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}
	function get_project_month_income($loancode,$start_date,$end_date)
	{
		$this->db->select('SUM(hm_prjacincome.amount) as totpay');
		$this->db->where('pri_id',$loancode);
		$this->db->where('income_date >=',$start_date);
		$this->db->where('income_date <=',$end_date);

			$this->db->group_by('pri_id');
		$query = $this->db->get('hm_prjacincome');

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
		$query = $this->db->get('hm_prjacpaymentdata');

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
		$this->db->select('SUM(hm_prjacincome.amount) as totpay');
		$this->db->where('pri_id',$loancode);

			$this->db->group_by('pri_id');
		$query = $this->db->get('hm_prjacincome');

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
		$query = $this->db->get('hm_prjacpaymentdata');

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
		$this->db->select('hm_prjacpaymentms.new_budget,hm_prjacpaymentms.estimate_budget');

		$this->db->where('hm_prjacpaymentms.prj_id',$id);
		$this->db->where('hm_prjacpaymentms.task_id',$taskid);
		//$this->db->join('cm_tasktype','cm_tasktype.task_id=hm_prjacpaymentms.task_id');
	//	$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('hm_prjacpaymentms');
		 if ($query->num_rows >0) {
           $data= $query->row();
		   return $data->estimate_budget;
        }
		else
		return 0;
	}
	function get_project_payment_by_task($id,$taskid)
	{
		$this->db->select('hm_prjacpaymentms.tot_payments ');

		$this->db->where('hm_prjacpaymentms.prj_id',$id);
		$this->db->where('hm_prjacpaymentms.task_id',$taskid);
		//$this->db->join('cm_tasktype','cm_tasktype.task_id=hm_prjacpaymentms.task_id');
	//	$this->db->order_by('cm_tasktype.task_id');

		$query = $this->db->get('hm_prjacpaymentms');
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

		$query = $this->db->get('hm_epfollowups');
		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return false;
    }
	function get_reservation_data_forsalsesforcast($prj_id) { //get all stock
		$this->db->select('hm_resevation.*,hm_prjaclotdata.lot_number,hm_eploan.loan_type,hm_eploan.loan_status');
			$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
			$this->db->join('hm_eploan','hm_eploan.res_code=hm_resevation.res_code','left');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_resevation.res_status !=',"REPROCESS");

		$query = $this->db->get('hm_resevation');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function Summery_advance_sum_this_month($prjid,$start_date,$enddate)
	{
		$this->db->select('SUM(hm_saleadvance.pay_amount) as payment');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_saleadvance.res_code','left');
		$this->db->where('hm_resevation.prj_id',$prjid);
		$this->db->where('hm_saleadvance.pay_date >=',$start_date);
		$this->db->where('hm_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('hm_saleadvance');
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
		$this->db->join('hm_eploan','hm_eploan.loan_code=hm_eploanpayment.loan_code and hm_eploan.reschdue_sqn=hm_eploanpayment.reschdue_sqn','left');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code','left');
			$this->db->where('hm_resevation.prj_id',$prjid);
			$this->db->where('hm_eploan.loan_type',$type);
		$this->db->where('hm_eploanpayment.pay_date >=',$start_date);
		$this->db->where('hm_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('hm_eploanpayment');
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
		$query = $this->db->get('hm_prjaclotdata');
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
		$this->db->select('SUM(hm_prjaclotdata.costof_sale) as totsale');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_resevation.res_date >',$date);
		$this->db->where('hm_resevation.res_status !=','REPROCESS');
		$this->db->group_by('hm_resevation.prj_id');
		$query = $this->db->get('hm_resevation');
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
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_resevation.res_date <',$enddate);
		$this->db->where('hm_resevation.res_status','PROCESSING');
		$this->db->group_by('prj_id');
		$query = $this->db->get('hm_resevation');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		$advancetot= $data->totsale;
		}
		else
		$advancetot = 0;

		$paymenttot=0;
		$this->db->select('SUM(hm_saleadvance.pay_amount) as payment');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_saleadvance.res_code','left');
		$this->db->where('hm_resevation.prj_id',$id);
		$this->db->where('hm_resevation.res_date <',$enddate);
		$this->db->where('hm_resevation.res_status','PROCESSING');
		$this->db->where('hm_saleadvance.pay_date <=',$enddate);
		$query = $this->db->get('hm_saleadvance');
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
		$this->db->select('SUM(hm_eploan.loan_amount) as totsale');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code','left');
		$this->db->where('hm_resevation.prj_id',$prjid);
		$this->db->where('hm_eploan.loan_type',$type);
		$this->db->where('hm_eploan.start_date <=',$enddate);
		$this->db->where('hm_eploan.loan_status','CONFIRMED');
		$this->db->group_by('hm_resevation.prj_id');
		$query = $this->db->get('hm_eploan');
	//	echo $this->db->last_query();
		if ($query->num_rows() > 0){
		$data= $query->row();
		$advancetot= $data->totsale;
		}
		else
		$advancetot = 0;

		$paymenttot = 0;
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->join('hm_eploan','hm_eploan.loan_code=hm_eploanpayment.loan_code and  hm_eploan.reschdue_sqn=hm_eploanpayment.reschdue_sqn','left');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code','left');
		$this->db->where('hm_resevation.prj_id',$prjid);
		$this->db->where('hm_eploan.loan_type',$type);
		$this->db->where('hm_eploan.start_date <=',$enddate);
		$this->db->where('hm_eploan.loan_status','CONFIRMED');
		$this->db->where('hm_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('hm_eploanpayment');
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
		$this->db->where('hm_eploanpayment.loan_code',$loan_code);
		$this->db->where('hm_eploanpayment.pay_date <',$start_date);
		//	$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

		$query = $this->db->get('hm_eploanpayment');
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
		$this->db->where('hm_eploanpayment.loan_code',$loan_code);
	//		$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);
		$this->db->where('hm_eploanpayment.pay_date >=',$start_date);
		$this->db->where('hm_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('hm_eploanpayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		return  $query->row();

		}
		else
		return 0;
	}



	// new report functions on collection full summery
	function get_all_project_income_list($branchid,$projectid,$fromdate,$todate) {
		$this->db->select('hm_prjacincome.*,SUM(hm_eploanpayment.cap_amount) as sum_cap,SUM(hm_eploanpayment.int_amount) as sum_int,SUM(hm_eploanpayment.di_amount) as sum_di,hm_saleadvance.pay_amount,hm_saleadvance.di_amount  as advance_di,hm_projectms.project_name,hm_prjaclotdata.lot_number,hm_eprebate.int_paidamount,hm_eprebate.balance_capital,hm_eploan.loan_type');
		$this->db->join('hm_projectms','hm_projectms.prj_id=hm_prjacincome.pri_id');

		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_prjacincome.lot_id');
		$this->db->join('hm_eploanpayment','hm_eploanpayment.rct_id=hm_prjacincome.id','left');
		$this->db->join('hm_saleadvance','hm_saleadvance.rct_id=hm_prjacincome.id','left');
		$this->db->join('hm_eprebate','hm_eprebate.rct_id=hm_prjacincome.id','left');
		$this->db->join('hm_eploan','hm_eploan.loan_code=hm_prjacincome.temp_code','left');

		if($branchid!='ALL')
		$this->db->where('hm_prjacincome.branch_code',$branchid);
		if($projectid!='ALL')
		$this->db->where('hm_prjacincome.pri_id',$projectid);
		$this->db->where('hm_prjacincome.income_date >=',$fromdate);
		$this->db->where('hm_prjacincome.income_date <=',$todate);

		$this->db->group_by('hm_prjacincome.id');
		$this->db->order_by('hm_prjacincome.pri_id,hm_prjacincome.income_date');
		$query = $this->db->get('hm_prjacincome');
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
		$this->db->where('hm_saleadvance.res_code',$rescode);
		$query = $this->db->get('hm_saleadvance');
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
		$this->db->select('hm_eploan.*,hm_prjaclotdata.sale_val,hm_prjaclotdata.lot_number,cm_customerms.first_name,cm_customerms.last_name,,cm_customerms.address1,cm_customerms.address2,cm_customerms.address3,hm_resevation.discounted_price,hm_resevation.res_date,,hm_resevation.res_date');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_eploan.cus_code');
		$this->db->where('hm_resevation.prj_id',$prj_id);
		$this->db->where('hm_eploan.loan_type',$type);
		$this->db->where('hm_eploan.start_date <=',$start_date);

			//$this->db->where('hm_eploan.loan_status',"CONFIRMED");

		$query = $this->db->get('hm_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function loan_paid_amounts($loancode,$deu_date,$reschdue_sqn)
	{
		$this->db->select('SUM(hm_eploanpayment.cap_amount ) as totcap,SUM(hm_eploanpayment.int_amount) as totint,SUM(hm_eploanpayment.di_amount) as totdi');
		$this->db->where('loan_code',$loancode);
		$this->db->where('reschdue_sqn',$reschdue_sqn);
		$this->db->where('pay_date <=',$deu_date);
			$this->db->group_by('loan_code');
		$query = $this->db->get('hm_eploanpayment');

		if ($query->num_rows() > 0){
		return $query->row();
		}
		else
		return 0;

	}

	function loan_paid_di($loan_code,$start_date,$enddate)
	{$loandata=$this->get_loandata_loancode($loan_code);



		$this->db->select('SUM(di_amount) as sum_di');
		$this->db->where('hm_eploanpayment.loan_code',$loan_code);
		$this->db->where('hm_eploanpayment.pay_date >=',$start_date);
			$this->db->where('hm_eploanpayment.pay_date <',$enddate);
				$this->db->where('hm_eploanpayment.reschdue_sqn',$loandata->reschdue_sqn);

		$query = $this->db->get('hm_eploanpayment');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return $data->sum_di;

		}
		else
		return 0;
	}
	function get_last_payment_date($loan_code)
	{	$this->db->select('MAX(income_date) as lastdate');
		$this->db->where('hm_prjacincome.temp_code',$loan_code);

		$query = $this->db->get('hm_prjacincome');
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
		$this->db->select('SUM(hm_eploanshedule.paid_cap) as cap,SUM(hm_eploanshedule.paid_int) as inttot,SUM(hm_eploanshedule.tot_instalment) as arriastot,COUNT(hm_eploanshedule.id) instalmentcount');
		$this->db->where('hm_eploanshedule.loan_code',$loancode);
		$this->db->where('hm_eploanshedule.reschdue_sqn',$loandata->reschdue_sqn);

	//	$this->db->where('hm_eploanshedule.pay_status','PENDING');
	//	$this->db->join('hm_eploanpayment','hm_eploanpayment.ins_id=hm_eploanshedule.id');
			//$this->db->where('hm_eploanpayment.pay_date<',$deu_date);
		$this->db->where('hm_eploanshedule.deu_date <',$deu_date);
		//$this->db->group_by('hm_eploanshedule.loan_code');
			$query = $this->db->get('hm_eploanshedule');

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
				$this->db->where('hm_projectms.status',CONFIRMKEY);
				$this->db->where('hm_projectms.price_status',CONFIRMKEY);
			//	$this->db->where('hm_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('hm_projectms');
				return $query->result();

    }
	function allloans_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		//$this->db->select('hm_eploan.*');
		$this->db->select('hm_eploan.*,hm_prjaclotdata.lot_number,hm_prjaclotdata.sale_val,hm_resevation.discounted_price,hm_resevation.down_payment,hm_resevation.res_date,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.mobile,cm_customerms.id_number,hm_resevation.sales_person');
		$this->db->join('hm_resevation','hm_resevation.res_code=hm_eploan.res_code');
		$this->db->join('hm_prjaclotdata','hm_prjaclotdata.lot_id=hm_resevation.lot_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=hm_resevation.cus_code');

		$this->db->where('hm_resevation.prj_id',$id);
	//	$this->db->where('hm_eploan.loan_type ',"ZEP");
		$this->db->where('hm_resevation.res_date <',$enddate);
	//	$this->db->where('hm_eploan.loan_status','CONFIRMED');
			$query = $this->db->get('hm_eploan');
			//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return 0;
    }

     /*Ticket No:2734 Added by Madushan 2021.04.30*/
    function get_hm_lotdata(){
    	$this->db->select('re_prjaclotdata.lot_number,re_prjaclotdata.lot_id,re_projectms.project_name');
    	$this->db->join('re_projectms','re_projectms.prj_id = re_prjaclotdata.prj_id');
    	$this->db->where('re_prjaclotdata.lot_type','H');
    	$query = $this->db->get('re_prjaclotdata');
    	if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return false;
    }

     function get_payment_report_data($lot_id,$fromdate,$todate){
    	$this->db->select('re_hmacpaymentdata.create_date,ac_payvoucherdata.voucher_ncode,ac_payvoucherdata.paymentdes,ac_chqprint.CHQNO,re_hmacpaymentdata.name,re_prjaclotdata.lot_number,re_projectms.project_name,re_hmacpaymentdata.amount');

    	$this->db->join('ac_payvoucherdata','ac_payvoucherdata.voucherid = re_hmacpaymentdata.voucherid');
    	$this->db->join('ac_chqprint','ac_chqprint.PAYREFNO = ac_payvoucherdata.entryid','left');
    	$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = re_hmacpaymentdata.lot_id');
    	$this->db->join('re_projectms','re_projectms.prj_id = re_prjaclotdata.prj_id');
    	$this->db->where('re_hmacpaymentdata.create_date >=',$fromdate);
    	$this->db->where('re_hmacpaymentdata.create_date <=',$todate);
    	if($lot_id != "all")
    		$this->db->where('re_hmacpaymentdata.lot_id',$lot_id);
    	$query = $this->db->get('re_hmacpaymentdata');
    	if ($query->num_rows() > 0){
			return $query->result();

		}
		else
		return false;
    
		}

		 /*End of Ticket No:2734*/

}
