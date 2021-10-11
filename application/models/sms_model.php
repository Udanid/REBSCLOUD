<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sms_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
	function record_sms($number,$message,$response){
		$data = array(
					'number' 	=> $number,
					'text'	=> $message,
					'status'	=> $response
				);
	    $this->db->insert('cm_outbox',$data);
    }
}