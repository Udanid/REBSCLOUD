<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Salesdashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function get_all_project_summery($branchid) { //get all stock
		if($this->session->userdata('usertype')!='Project Officer'){
			if($branchid=='ALL' & check_access('all_branch')){
				$this->db->select('prj_id,project_code,project_name,branch_code,town');
				$this->db->where('re_projectms.status',CONFIRMKEY);
				$this->db->where('re_projectms.price_status',CONFIRMKEY);
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
	//	$this->db->where('re_projectms.budgut_status',CONFIRMKEY);
		$query = $this->db->get('re_projectms');
		return $query->result();
		}
    }
	function get_lot_count($id) { //get all stock
		$this->db->select('count(lot_id) as totlots,SUM(sale_val) as selstot');
		$this->db->where('prj_id',$id);
		$query = $this->db->get('re_prjaclotdata');
		if ($query->num_rows() > 0){
		$data =$query->row();
		return $query->row();
		}
		else
		return false;;
    }
	function reservation_lots_befor($id,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		$this->db->select('SUM(re_resevation.discounted_price) as selstot,Count(re_resevation.res_code) as totcount');
		$this->db->where('re_resevation.prj_id',$id);
		$this->db->where('re_resevation.resale_date',NULL);
		$this->db->or_where('re_resevation.resale_date >',$enddate);
		$this->db->where('re_resevation.res_date <=',$enddate);
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			return $query->row();

		}
		else
		return false;
    }
	function reservation_lots_officer_monthtarget($id,$start_date,$enddate) { //get all stock
	$lotarr=NULL;
	$counter=0;
		$this->db->select('SUM(re_resevation.discounted_price) as selstot,Count(re_resevation.res_code) as totcount');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
		$this->db->where('re_projectms.officer_code',$id);
		$this->db->where('re_resevation.resale_date',NULL);
		$this->db->or_where('re_resevation.resale_date >',$enddate);
		$this->db->where('re_resevation.res_date >=',$start_date);
		$this->db->where('re_resevation.res_date <=',$enddate);
		
		$query = $this->db->get('re_resevation');
		if ($query->num_rows() > 0){
			return $query->row();

		}
		else
		return false;
    }
}
