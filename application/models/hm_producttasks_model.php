<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hm_producttasks_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_active_products()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
			$this->db->where('Status', 'Active');
		$query = $this->db->get('cm_prdtype'); 
		return $query->result(); 
	}
	function get_active_count()
	{
		$this->db->select('*');
		//$this->db->order_by('product_code,task_code');
		$this->db->where('Status', 'Active');
		$query = $this->db->get('cm_prdtype'); 
		return $query->num_rows();
	}
	function get_all_tasks($pagination_counter=100, $page_count=0) { //get all stock
		$this->db->select('task_id,task_code,product_code,task_name,status');
		$this->db->order_by('product_code,task_code');
			$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_tasktype'); 
		return $query->result(); 
    }

	
	function get_tasks_product_code($product_code) { //get all stock
		$this->db->select('*');
		$this->db->where('product_code',$product_code);
		$this->db->where('entry_flag','M');
		$this->db->where('status',CONFIRMKEY);
		$this->db->order_by('product_code,task_code');
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_tasktype'); 
		if ($query->num_rows() > 0){
		return $query->result(); 
		}
		else
		return false;
		
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
		$code=$this->getmaincode('task_code',$this->input->post('product_code'),'cm_tasktype','product_code');
		//$tot=$bprice*$quontity; 
		$data=array( 
		'task_code'=>$code,
		'product_code' => $this->input->post('product_code'),
		'task_name' => $this->input->post('task_name'),
		'ledger_id' => $this->input->post('ledger_id'),
		'adv_ledgerid' => $this->input->post('adv_ledgerid'),
		'create_by' => $this->session->userdata('username'),
		'create_date' => date("Y-m-d"),
		
		);
		$insert = $this->db->insert('cm_tasktype', $data);
		return $insert;
		
	}
	function edit()
	{
		//$tot=$bprice*$quontity; 
		$thisdata=$this->get_tasks_bycode($this->input->post('task_id'));
		if($thisdata->status==CONFIRMKEY)
		{
		  $data=array( 
		  
		
			  'create_by' => $this->session->userdata('username'),
			    'ledger_id' => $this->input->post('ledger_id'),
		  'adv_ledgerid' => $this->input->post('adv_ledgerid'),
		  );
		}
		else
		{
			 $data=array( 
		  
		  'task_name' => $this->input->post('task_name'),
		  'ledger_id' => $this->input->post('ledger_id'),
		  'adv_ledgerid' => $this->input->post('adv_ledgerid'),
		  'create_by' => $this->session->userdata('username'),
		  );
		}
		$this->db->where('task_id', $this->input->post('task_id'));
		$insert = $this->db->update('cm_tasktype', $data);
		return $insert;
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('task_id', $id);
		$insert = $this->db->update('cm_tasktype', $data);
		return $insert;
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		
		$this->db->where('task_id', $id);
		$insert = $this->db->delete('cm_tasktype');
		return $insert;
		
	}

	function get_subtask_bytask($code) { //get all stock
		$this->db->select('*');
		$this->db->where('task_id',$code);
		//$this->db->where('status',CONFIRMKEY);
	
		$query = $this->db->get('cm_subtask'); 
		return $query->result(); 
    }
	function get_confirmed_subtask_bytask($code) { //get all stock
		$this->db->select('*');
		$this->db->where('task_id',$code);
		$this->db->where('status',CONFIRMKEY);
	
		$query = $this->db->get('cm_subtask'); 
		return $query->result(); 
    }
	
	function get__subtask_byid($code) { //get all stock
		$this->db->select('*');
		$this->db->where('subtask_id',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_subtask'); 
		return $query->row(); 
    }
	
	function add_subtask()
	{
		$code=$this->getmaincode('subtask_code',$this->input->post('task_id'),'cm_subtask','task_id');
		//$tot=$bprice*$quontity; 
		$data=array( 
		'subtask_code'=>$code,
		'task_id' => $this->input->post('task_id'),
		'subtask_name' => $this->input->post('subtask_name'),
		'create_by' => $this->session->userdata('username'),
		'create_date' => date("Y-m-d"),
		
		);
		$insert = $this->db->insert('cm_subtask', $data);
		return $insert;
		
	}
	
	function confirm_subtask($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('subtask_id', $id);
		$insert = $this->db->update('cm_subtask', $data);
		return $insert;
		
	}
	function delete_subtask($id)
	{
		//$tot=$bprice*$quontity; 
		
		$this->db->where('subtask_id', $id);
		$insert = $this->db->delete('cm_subtask');
		return $insert;
		
	}
	function edit_subtask()
	{
		
			 $data=array( 
		  
		  'subtask_name' => $this->input->post('subtask_name'),
		  'create_by' => $this->session->userdata('username'),
		  );
		
		$this->db->where('subtask_id', $this->input->post('subtask_id'));
		$insert = $this->db->update('cm_subtask', $data);
		return $insert;
		
	}

 function getmaincode($idfield,$prifix,$table,$fildname)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table ."  where ".$fildname."='".$prifix."'");
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			  $id=intval($data->id);
			 if($data->id==NULL)
			 {
				 $newid=$id+1;
			 $newid=str_pad($newid, 3, "0", STR_PAD_LEFT);
		

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