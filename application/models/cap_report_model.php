<!-- Ticket No-2683 | Added By Uvini -->
<?php

class Cap_report_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_cost_date_range($fromdate,$todate){
    	$this->db->select('re_projectms.project_name,cm_customerms.full_name,re_prjaclotdata.lot_number,re_prjaclotdata.extend_perch,re_unrealized.full_cost');
    	$this->db->join('re_projectms','re_projectms.prj_id = re_resevation.prj_id','left');
    	$this->db->join('cm_customerms','cm_customerms.cus_code = re_resevation.cus_code','left');
    	$this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = re_resevation.lot_id','left');
    	$this->db->join('re_unrealized','re_unrealized.res_code = re_resevation.res_code','left');
		 $this->db->where('re_resevation.res_status !=','REPROCESS');
    	$this->db->where('re_unrealized.status','COMPLETE');
    	$this->db->where('re_unrealized.last_trndate >=',$fromdate);
    	$this->db->where('re_unrealized.last_trndate <=',$todate);
 
    	$query = $this->db->get('re_resevation');
		if ($query->num_rows >0) {
           return $query->result(); 
        }
		else
		return false; 
    }

    //Ticket No-2799|Added By Uvini
    function get_turn_over_date_range($fromdate,$todate){
        $this->db->select('cm_customerms.full_name,re_prjaclotdata.lot_number,re_prjaclotdata.extend_perch,re_resevation.discounted_price,re_resevation.res_code,re_unrealized.full_cost,re_eploan.loan_code,re_eploan.loan_type,re_resevation.down_payment,re_projectms.project_name');
        $this->db->join('re_eploan','re_eploan.res_code = re_resevation.res_code','left');
        $this->db->join('re_projectms','re_projectms.prj_id = re_resevation.prj_id','left');
        $this->db->join('cm_customerms','cm_customerms.cus_code = re_resevation.cus_code','left');
        $this->db->join('re_prjaclotdata','re_prjaclotdata.lot_id = re_resevation.lot_id','left');
        $this->db->join('re_unrealized','re_unrealized.res_code = re_resevation.res_code','left');
        $this->db->where('re_unrealized.status','COMPLETE');
		 $this->db->where('re_resevation.res_status !=','REPROCESS');
        $this->db->where('re_unrealized.last_trndate >=',$fromdate);
        $this->db->where('re_unrealized.last_trndate <=',$todate);
 
        $query = $this->db->get('re_resevation');
        if ($query->num_rows >0) {
           return $query->result(); 
        }
        else
        return false; 
    }
}
?>