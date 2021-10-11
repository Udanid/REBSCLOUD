<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Loanreport_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
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

	function get_eploan_data($branchid,$start_date) { //get all stock
	//echo $start_date;
		$this->db->select('MIN(re_eploanshedule.deu_date) as deu_date ,re_eploan.*,re_prjaclotdata.lot_number,re_projectms.project_name,re_customerms.mobile,re_customerms.first_name,re_customerms.last_name,re_resevation.discounted_price,re_resevation.down_payment');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code and re_eploan.reschdue_sqn=re_eploanshedule.reschdue_sqn ');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
			$this->db->join('re_customerms','re_customerms.cus_code=re_eploan.cus_code');
$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			if($branchid!='ALL')
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_eploanshedule.pay_status ','PENDING');
		$this->db->where('re_eploan.loan_type','NEP');
		$this->db->where('re_eploan.loan_status',"CONFIRMED");
		$this->db->group_by('re_eploanshedule.loan_code');
		$this->db->order_by('re_eploanshedule.deu_date');
		$query = $this->db->get('re_eploanshedule');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }

	function get_eploan_data_other($branchid,$type) { //get all stock
	//echo $start_date;
		$this->db->select('re_eploan.*,re_prjaclotdata.sale_val,re_prjaclotdata.lot_number,re_customerms.first_name,
		re_customerms.last_name,re_projectms.project_name,re_customerms.mobile,re_customerms.address1,re_customerms.address2,re_customerms.address3,re_resevation.discounted_price');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_customerms','re_customerms.cus_code=re_eploan.cus_code');
			if($branchid!='ALL')
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where('re_eploan.loan_type',$type);
		
		$this->db->where('re_eploan.loan_status',"CONFIRMED");
		$this->db->order_by('re_eploan.start_date');
		$query = $this->db->get('re_eploan');
		if ($query->num_rows() > 0){
		return $query->result();
		}
		else
		return false;
    }
	
}
