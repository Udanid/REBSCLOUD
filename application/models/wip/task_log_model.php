<?php

class Task_log_model extends CI_Model {

    function Entry_model()
    {
        parent::__construct();
    }


    function add_tasklog($data)
	{
		$this->db->trans_start();
		$this->db->insert('wip_task_log', $data);
		$insert=$this->db->insert_id();
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $insert;
		}
	} 

}
