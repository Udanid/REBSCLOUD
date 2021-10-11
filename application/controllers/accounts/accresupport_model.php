<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class accresupport_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_incomes_by_entryid($entryid)
    {
        $options = array();
        $options[0] = "(Please Select)";
        $this->db->from('re_prjacincome')->where('entry_id',$entryid);
        $ledger_q = $this->db->get();
        if ($ledger_q->num_rows() > 0){
            return $ledger_q->row();
        }else
            return false;
    }
	function get_customer_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('cus_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_customerms'); 
		return $query->row(); 
    }
		function get_all_reservation_details_bycode($rescode) { //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->where('re_resevation.res_code',$rescode);
		$query = $this->db->get('re_resevation'); 
		return $query->row(); 
    }
	function get_eploan_data($rescode) { //get all stock
		$this->db->select('re_eploan.*,re_resevation.prj_id,re_resevation.pay_type,re_resevation.discounted_price,re_resevation.profit_status,cm_customerms.first_name,cm_customerms.last_name,cm_customerms.id_number,re_projectms.project_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->where('re_eploan.loan_code',$rescode);
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$query = $this->db->get('re_eploan'); 
		if ($query->num_rows() > 0){
		return $query->row(); 
		}
		else
		return false;
    }
	function get_branchdata_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('branch_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_branchms'); 
		return $query->row(); 
    }
	function get_recipt_loan_data($loan_code,$loan_type,$reshdue,$loan_amount,$rental,$date)
	{
		$balancecap=0;$balanceitn=0; $arrearsrent=0;
		if($loan_type=='NEP')
		{
			$this->db->select('SUM(re_eploanshedule.cap_amount) as totcap,SUM(re_eploanshedule.int_amount) as totint,SUM(re_eploanshedule.paid_cap) paidcap,SUM(re_eploanshedule.paid_int) AS paidint');
		$this->db->where('re_eploanshedule.loan_code',$loan_code);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reshdue);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
	//	$this->db->where('re_eploanshedule.deu_date <',$deu_date);
		$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

					if ($query->num_rows() > 0){
						$data= $query->row();
						$balancecap=$loan_amount-$data->paidcap;
						$balanceitn=$data->totint-$data->paidint;
					}
					$this->db->select('SUM(re_eploanshedule.cap_amount) as totcap,SUM(re_eploanshedule.int_amount) as totint,SUM(re_eploanshedule.paid_cap) paidcap,SUM(re_eploanshedule.paid_int) AS paidint');
		$this->db->where('re_eploanshedule.loan_code',$loan_code);
		$this->db->where('re_eploanshedule.reschdue_sqn',$reshdue);

	//	$this->db->where('re_eploanshedule.pay_status','PENDING');
	//	$this->db->join('re_eploanpayment','re_eploanpayment.ins_id=re_eploanshedule.id');
			//$this->db->where('re_eploanpayment.pay_date<',$deu_date);
			$this->db->where('re_eploanshedule.deu_date <=',$date);
		$this->db->group_by('re_eploanshedule.loan_code');
			$query = $this->db->get('re_eploanshedule');

					if ($query->num_rows() > 0){
						$data= $query->row();
						$balancecap1=$data->totcap-$data->paidcap;
						$balanceitn1=$data->totint-$data->paidint;
						$arrears=$balancecap1+$balanceitn1;
						$arrearsrent=$arrears;
					}
		
			
		}
		else
		{
			$this->db->select('SUM(re_eploanpayment.cap_amount) as mysum, SUM(re_eploanpayment.di_amount) as disum');
			$this->db->join('re_prjacincome','re_prjacincome.id=re_eploanpayment.rct_id','left');
			$this->db->where('re_eploanpayment.loan_code',$loan_code);
			$this->db->where('re_eploanpayment.reschdue_sqn',$reshdue);
			$this->db->group_by('re_eploanpayment.loan_code');
			$query = $this->db->get('re_eploanpayment'); 
				if ($query->num_rows() > 0){
	 
				$data= $query->row(); 
				$tot=$data->mysum;
				$balancecap=$loan_amount-$tot;
				}
				
		}
		$rentdata=array('bal_cap'=>$balancecap,'bal_int'=>$balanceitn,'arr_int'=>$arrearsrent);
		return $rentdata;
	}
	function get_advance_count($rescode) { //get all stock
		$this->db->select('COUNT(re_saleadvance.id) as mycount');
			$this->db->where('re_saleadvance.res_code',$rescode);
		$query = $this->db->get('re_saleadvance'); 
		if ($query->num_rows() > 0){
		$data= $query->row(); 
		return  $data->mycount;
		}
		else
		return 0;
    }
}