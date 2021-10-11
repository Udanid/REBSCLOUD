<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class roi_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_reservation_sale_cost($prj_id,$todate)
	{
		$this->db->select('SUM(re_resevation.discounted_price) as selstot,SUM(re_prjaclotdata.costof_sale) as costtot' );
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.profit_status',"TRANSFERD");
		$this->db->where('re_resevation.res_status !=',"REPROCESS");
		$this->db->where('re_resevation.profit_date <=',$todate);

		$query = $this->db->get('re_resevation');
		//echo $this->db->last_query();
		if ($query->num_rows() > 0){
			
		return $query->row();
		}
		else
		return false;
	}
	
	function interest_income($prj_id,$enddate)
	{
		$this->db->select('SUM(cap_amount) as sum_cap,SUM(int_amount) as sum_int,SUM(di_amount) as sum_di');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->where('re_resevation.prj_id',$prj_id);
		$this->db->where('re_eploanpayment.pay_date <=',$enddate);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
			$data= $query->row();
		return  $data->sum_int;

		}
		else
		return 0;
	}
	
	function interest_payment($loan_id,$enddate)
	{
		$this->db->select('SUM(int_amount) as sum_int');
			$this->db->where('ac_outside_loanspayment.pay_date <=',$enddate);
			$this->db->where('ac_outside_loanspayment.loan_id ',$loan_id);
		$query = $this->db->get('ac_outside_loanspayment');
		if ($query->num_rows() > 0){
			//$data= $query->row();
		$data= $query->row();
		return  $data->sum_int;
//echo $intpay.'<br>';
		}
		else
		return 0;
	}
	function get_external_loan_payment($id,$enddate)
	{
		$intpay=0;
		$this->db->select('loan_id');
		$this->db->where('prj_id',$id);
		$this->db->group_by('loan_id');
		$query = $this->db->get('ac_outside_loansprjs');
		if ($query->num_rows() > 0){
			$data= $query->result();
			foreach($data as $raw)
			{
			//	echo $raw->loan_id.'<br>';
				$intpay=$intpay+$this->interest_payment($raw->loan_id,$enddate);
				
			}
			return $intpay;
		}
		else
		return 0;
	}
	function budget_balance($prj_id,$enddate){
		$paytot=0;
		$budgettot=0;
		$fullpaytot=0;
		$this->db->select('SUM(re_prjacpaymentdata.amount) as tot');
		$this->db->where('re_prjacpaymentdata.prj_id',$prj_id);
		$this->db->where('re_prjacpaymentdata.create_date >',$enddate);
		$query = $this->db->get('re_prjacpaymentdata');
		if ($query->num_rows() > 0){
			$data= $query->row();
			$paytot= $data->tot;
		}
		$this->db->select('SUM(re_prjacpaymentms.new_budget ) as tot,SUM(re_prjacpaymentms.tot_payments ) as totpayment');
		$this->db->where('re_prjacpaymentms.prj_id ',$prj_id);
		$query = $this->db->get('re_prjacpaymentms');
		if ($query->num_rows() > 0){
			$data= $query->row();
			$budgettot= $data->tot;
			$fullpaytot=$data->totpayment;
		}
		//echo $budgettot.'-'.$fullpaytot-$paytot;
		$balance=$budgettot-($fullpaytot-$paytot);
		return $balance;
	}
	
	
  /*end  update by nadee 2020-02-12 ticket number 1054*/
}
