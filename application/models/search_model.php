<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_branches_summery() { //get all stock
		$this->db->select('branch_code,branch_name,shortcode');
		if(! check_access('all_branch'))
		$this->db->where('branch_code',$this->session->userdata('branchid'));
		$this->db->order_by('branch_name');
		$query = $this->db->get('cm_branchms');
		return $query->result();
    }
	function get_all_project_summery($branchid) { //get all stock
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
				$this->db->where('branch_code',$this->session->userdata('branchid'));
				$this->db->order_by('project_name');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				//$this->db->where('re_projectms.price_status',CONFIRMKEY);
			//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
				$query = $this->db->get('re_projectms');
				return $query->result();
			}
		}

    function get_reservation_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate){
		$status = array('PROCESSING'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branch_code!='ALL')
		$this->db->where('re_resevation.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);

		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');

		return $query->result();

    }    function get_allsearch_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,
    cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.extend_perch');
	//	$this->db->select('re_resevation.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id','left');
		if($branch_code!='ALL')
		$this->db->where('re_resevation.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);

		//$this->db->where_in('re_resevation.res_status',$status);
		$this->db->order_by('re_resevation.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');
		//echo $this->db->last_query();
		return $query->result();

    }
	function get_resale_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_adresale.*,re_resevation.prj_id,re_resevation.lot_id,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_resevation','re_resevation.res_code=re_adresale.res_code');
		//$this->db->join('re_prjacincome','re_prjacincome.id=re_epresale.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_adresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_adresale.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_adresale.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_adresale.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_adresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_outright_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branch_code!='ALL')
		$this->db->where('re_resevation.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);

		$this->db->where_in('re_resevation.res_status',$status);
		$this->db->where('re_resevation.pay_type','Outright');
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');

		return $query->result();

    }
	function get_loan_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate,$loantype){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_eploan.loan_amount,re_eploan.loan_code,re_eploan.loan_type');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->join('re_eploan','re_eploan.res_code=re_resevation.res_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_resevation.res_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_resevation.res_date <=',$todate);
		if($loantype!='')
		$this->db->where('re_eploan.loan_type',$loantype);

		$this->db->where_in('re_resevation.res_status','COMPLETE');
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');

		return $query->result();

    }
	function get_reshedule_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_epreschedule.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.prj_id,re_resevation.lot_id,re_eploan.loan_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epreschedule.cus_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epreschedule.res_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('re_eploan','re_eploan.loan_code=re_epreschedule.loan_code');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_epreschedule.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_epreschedule.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_epreschedule');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_rebate_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_eprebate.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjacincome.pay_status,re_resevation.prj_id,re_resevation.lot_id,re_eploan.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_eprebate.res_code');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eprebate.loan_code');
		$this->db->join('re_prjacincome','re_prjacincome.id=re_eprebate.rct_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_eprebate.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_eprebate.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_eprebate');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	function get_loanresale_searchlist($branch_code,$prj_id,$cus_code,$lot_id,$fromdate,$todate)
	{
		$this->db->select('re_epresale.*,re_projectms.project_name,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_resevation.prj_id,re_resevation.lot_id,re_eploan.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_epresale.res_code');
		$this->db->join('re_eploan','re_eploan.loan_code=re_epresale.loan_code');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_epresale.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');

		if($branch_code!='ALL')
		$this->db->where('re_projectms.branch_code',$branch_code);
		if($prj_id!='')
		$this->db->where('re_resevation.prj_id',$prj_id);
		if($lot_id!='')
		$this->db->where('re_resevation.lot_id',$lot_id);
		if($cus_code!='')
		$this->db->where('re_resevation.cus_code',$cus_code);
		if($fromdate!='')
		$this->db->where('re_epresale.apply_date >=',$fromdate);
		if($todate!='')
		$this->db->where('re_epresale.apply_date <=',$todate);
		$this->db->order_by('re_projectms.branch_code,re_projectms.prj_id');

		$query = $this->db->get('re_epresale');
		if ($query->num_rows() > 0){

		return $query->result();
		}
		else
		return 0;
	}
	 function get_customer_reservation_list($cus_code){
		$status = array('SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid');
	//	$this->db->select('re_resevation.*,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id','left');
		$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
		$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id','left');

		$this->db->where('re_resevation.cus_code',$cus_code);
		$this->db->order_by('re_resevation.branch_code,re_projectms.prj_id');
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			return $query->result();
		}
		else
			return false;
		//echo $this->db->last_query();


    }



	function get_paid_capital_byrescode($rescode,$todate) { //get all stock
//	$resdata=$this->get_eploan_data($rescode);
		$this->db->select('SUM(cap_amount)as totpaidcap');
		$this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
		$this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');

		$this->db->where('re_resevation.res_code',$rescode);
		$this->db->where('re_eploanpayment.pay_date <=',$todate);
		$query = $this->db->get('re_eploanpayment');
		if ($query->num_rows() > 0){
		$data=$query->row();
		return $data->totpaidcap;
		}
		else
		return 0;
    }


    function remaining_interest_byrescode($rescode,$todate) { //get all stock
  //	$resdata=$this->get_eploan_data($rescode);
      $this->db->select('SUM(re_eploanpayment.int_amount) as totremaing_int');
      $this->db->join('re_eploan','re_eploan.loan_code=re_eploanpayment.loan_code');
      $this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
      $this->db->where('re_resevation.res_code',$rescode);
      $this->db->where('re_eploanpayment.pay_date <=',$todate);
      $this->db->where('re_eploan.loan_status !=','SETTLED');
      $query = $this->db->get('re_eploanpayment');

      $this->db->select('SUM(re_eploanshedule.int_amount) as totint');
      $this->db->join('re_eploan','re_eploan.loan_code=re_eploanshedule.loan_code');
      $this->db->join('re_resevation','re_resevation.res_code=re_eploan.res_code');
      $this->db->where('re_resevation.res_code',$rescode);
      $this->db->where('re_eploan.loan_status !=','SETTLED');
      $query2 = $this->db->get('re_eploanshedule');


      if ($query2->num_rows() > 0){
      $data=$query2->row();
      $tot_int=0;
      if ($query->num_rows() > 0){
        $tot_int=$query->row()->totremaing_int;
      }
      $bal=$data->totint-$tot_int;
      return $bal;
      }
      else
      return 0;
      }
}
