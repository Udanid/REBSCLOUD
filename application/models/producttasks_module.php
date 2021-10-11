<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Producttasks_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_tasks($pagination_counter=100, $page_count=0) { //get all stock
		$this->db->select('task_id,task_code,product_code,task_name,status');
		$this->db->order_by('product_code,task_code');
			$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_tasktype'); 
		return $query->result(); 
    }

	
	function get_tasks_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('task_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_tasktype'); 
		return $query->row(); 
    }
	
	
	function add()
	{
		$code=$this->getmaincode('task_code',$this->input->post('product_code'),'cm_tasktype');
		//$tot=$bprice*$quontity; 
		$data=array( 
		'task_code'=>$code,
		'product_code' => $this->input->post('product_code'),
		'task_name' => $this->input->post('task_name'),
		'create_by' => $this->session->userdata('username'),
		'create_date' => date("Y-m-d"),
		
		);
		$insert = $this->db->insert('cm_tasktype', $data);
		return $id;
		
	}
	function edit()
	{
		//$tot=$bprice*$quontity; 
		$thisdata=$this->get_tasks_bycode($this->input->post('task_id'));
		if($thisdata->status==CONFIRMKEY)
		{
		  $data=array( 
		  
		
			  'create_by' => $this->session->userdata('username'),
		  );
		}
		else
		{
			 $data=array( 
		  
		  'task_name' => $this->input->post('task_name'),
		  'create_by' => $this->session->userdata('username'),
		  );
		}
		$this->db->where('task_id', $this->input->post('task_id'));
		$insert = $this->db->update('cm_tasktype', $data);
		return $id;
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('task_id', $id);
		$insert = $this->db->update('cm_tasktype', $data);
		return $id;
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		
		$this->db->where('task_id', $id);
		$insert = $this->db->delete('cm_tasktype');
		return $id;
		
	}

 function getmaincode($idfield,$prifix,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table ."where product_code='".$prifix."'");
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=str_pad(1, 3, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 //$prjid=substr($prjid,3,4);
			 $id=intval($id);
			 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 3, "0", STR_PAD_LEFT);
		$newid=$newid;
		}
	return $newid;
	
	}
}