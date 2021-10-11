<?php

class Stamp_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_stamp_date_range($fromdate,$todate){
    	$this->db->select('re_prjacincome.amount as pay_amount,re_prjacincome.rct_no,re_prjacincome.entry_date,re_projectms.project_name,re_prjaclotdata.lot_number');
         $this->db->join('re_projectms','re_projectms.prj_id = re_prjacincome.pri_id');
       $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = re_prjacincome.lot_id','left');
        $this->db->where('amount >=',25000);
		 $this->db->where('income_type !=','Reservation Chargers');
		
        $this->db->where('re_prjacincome.entry_date >=',$fromdate);
        $this->db->where('re_prjacincome.entry_date <=',$todate);
    
        $query = $this->db->get('re_prjacincome');
        if ($query->num_rows >0) {
		//	echo $this->db->last_query();
           return $query->result(); 
        }
        else
        return false; 
    }
}
?>