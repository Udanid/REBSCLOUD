<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ledgerbalance_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	
	
	function get_real_estete_income($fromdate,$todate,$type) { //get all stock
		$this->db->select('SUM(amount) as paidtot');
		$this->db->where('income_type',$type);
		$this->db->where('enry_date >=',$fromdate);
		$this->db->where('enry_date <=',$todate);
		$query = $this->db->get('re_prjacincome');
		if ($query->num_rows() > 0){
		$data= $query->row();
		return $data->paidtot;
		}
		else
		return 0;
    }
}
