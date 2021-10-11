<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dbcheck_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	
	
	function get_all_databases() { 
		$this->db->select('*');
		$query = $this->db->get('sy_table_data'); 
		if ($query->num_rows >0) {
            return $query->result();
    	}else
			return false;
    }
	
	function get_table_count($table){
		$this->db->select('*');
		$query = $this->db->get($table); 
		if ($query->num_rows >0) {
            return $query->num_rows();
    	}else
			return false;
	}
	
	function update_record_count($id,$current_count,$previous_count,$difference){
		$data = array( 
			'previous_size' => $previous_count,
			'current_size' => $current_count,
			'difference' => $difference
		);
		$this->db->where('id',$id);
		$update= $this->db->update('sy_table_data', $data);
	}

}