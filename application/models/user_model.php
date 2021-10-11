<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->library('encryption');
    }
	
	function all_users() { //get all stock
		$this->db->select('cm_userdata.USRNAME,cm_userdata.USRTYPE,cm_userdata.USRID');
		$this->db->order_by('cm_userdata.USRTYPE');
		$query = $this->db->get('cm_userdata'); 
		if ($query->num_rows >0) {
            return array('row' => $query->row(), 'result' => $query->result(),'num_rows' => $query->num_rows);
    	}else
			return false;
    }
	
	function get_user($userid){
		$this->db->select('cm_userdata.USRNAME,cm_userdata.USRTYPE,cm_userdata.USRID');
		$this->db->where('cm_userdata.USRID',$userid);
		$query = $this->db->get('cm_userdata'); 
		return $query->row(); 
	}
	
	function edit_user(){
		$new_password = $this->encryption->encode($this->input->post('Password'));
		$data=array( 
		'USRPW' => $new_password
		);
		$this->db->where('USRID',$this->input->post('userid'));
		$update= $this->db->update('cm_userdata', $data);
	}

}