<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Add_shedule_model extends CI_Model {
	 function __construct() {
        parent::__construct();
    }

    function get_all_reservations()
	{
		$this->db->select('*');
		$this->db->where('dp_cmpldate <>','');
		$query = $this->db->get('re_resevation');
		if($query->num_rows>0)
			return $query->result();
		else
			return false;
	}

	function add_shedule($dataArray)
	{
		$this->db->insert('re_salesadvanceshedule',$dataArray);
	}
	  function get_all_reservations_status()
	{
		$status = array( 'COMPLETE','SETTLED'); //get all stock
		$this->db->select('re_resevation.*,re_projectms.project_name,cm_customerms.id_number,cm_customerms.first_name,cm_customerms.last_name,re_prjaclotdata.lot_number,re_prjaclotdata.plan_sqid,re_prjaclotdata.status');
		$this->db->join('re_projectms','re_projectms.prj_id=re_resevation.prj_id');
			$this->db->join('cm_customerms','cm_customerms.cus_code=re_resevation.cus_code');
				$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id=re_resevation.lot_id');

		if(! check_access('all_branch'))
		$this->db->where('re_resevation.branch_code',$branchid);
		$this->db->where_in('re_resevation.res_status',$status);
		$query = $this->db->get('re_resevation');
		return $query->result();
	}
}