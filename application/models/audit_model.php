<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class audit_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
function insert_oumit_transactions($entry_id,$res_code,$loan_code,$prj_id,$lot_id,$date,$reason)
{

		$data=array( 
		'entry_id'=>$entry_id,
		'res_code'=>$res_code,
		'loan_code' =>$loan_code,
		'prj_id' => $prj_id ,
		'lot_id' => $lot_id,
		'date' => $date,
		'reason' => $reason,
		
		);
		if(!$this->db->insert('cm_audit_omttrns', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
	
	
	
}

function insert_change_transactions($entry_id,$res_code,$loan_code,$prj_id,$lot_id,$date,$reason)
{

		$data=array( 
		'entry_id'=>$entry_id,
		'res_code'=>$res_code,
		'loan_code' =>$loan_code,
		'prj_id' => $prj_id ,
		'lot_id' => $lot_id,
		'date' => $date,
		'reason' => $reason,
		
		);
		if(!$this->db->insert('cm_audit_changetrns', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
	
	
	
}
function insert_delete_transactions($entry_id,$date)
{

		$data=array( 
		'entry_id'=>$entry_id,
	
		'date' => $date,
		
		);
		if(!$this->db->insert('cm_audit_deletetrns', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
	
	
	
}
function insert_settle_transactions($res_code,$prj_id,$lot_id,$date)
{

		$data=array( 
		
		'res_code'=>$res_code,
		
		'prj_id' => $prj_id ,
		'lot_id' => $lot_id,
		'date' => $date,
		
		
		);
		if(!$this->db->insert('cm_audit_settleblocks', $data))
		{
				$this->db->trans_rollback();
					$this->logger->write_message("error", "Error confirming Project");
			return false;
		}
	
	
	
	
	
}
	
}