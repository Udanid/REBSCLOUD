<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Producttasks_model extends CI_Model {

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
		return $insert;
		
	}
	function update_task_code($main_id,$key)
	{
		 $data=array( 
		  
		'task_code'=>$key,
		
		  );
		
		$this->db->where('task_id',$main_id);
		$insert = $this->db->update('cm_tasktype', $data);
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity;
		if($id) 
		{
			 $dataset=$this->get_tasks_bycode($id);
			 if($dataset->status=='PENDING')
			 {
				 
				 	$advanceledgerid=get_next_ledgerid(65);// reaccount helper function
				 
					 $insert_data = array(
					'name' => $dataset->task_name.' - Advance',
					'id' => $advanceledgerid,
					'ref_id' => '',
					'group_id' => 65,
					'op_balance' => 0,
					'op_balance_dc' => 'D',
					'type' =>0,
					'reconciliation' => 0,
	
					);
					$this->db->insert('ac_ledgers', $insert_data);
					$insert_data2 = array(
					'name' =>  $dataset->task_name.' - Advance',
					'id' => substr($advanceledgerid, 3),
					'ref_id' => '',
					'group_id' => 65,
					'op_balance' => 0,
					'op_balance_dc' => 'D',
					'type' => 0,
					'reconciliation' => 0,
					'status' => CONFIRMKEY,);
					$this->db->insert('ac_config_ledgers', $insert_data2);
					
					$ledgerid=get_next_ledgerid(66);// reaccount helper function
				 
					 $insert_data = array(
					'name' => $dataset->task_name,
					'id' => $ledgerid,
					'ref_id' => '',
					'group_id' => 66,
					'op_balance' => 0,
					'op_balance_dc' => 'D',
					'type' =>0,
					'reconciliation' => 0,
	
					);
					$this->db->insert('ac_ledgers', $insert_data);
					$insert_data2 = array(
					'name' => $dataset->task_name,
					'id' => substr($ledgerid, 3),
					'ref_id' => '',
					'group_id' => 66,
					'op_balance' => 0,
					'op_balance_dc' => 'D',
					'type' => 0,
					'reconciliation' => 0,
					'status' => CONFIRMKEY,);
					$this->db->insert('ac_config_ledgers', $insert_data2);
				
				
				
				
				$data=array( 
				'ledger_id'=>substr($ledgerid, 3),
				'adv_ledgerid'=>substr($advanceledgerid, 3),
				
				'status' => CONFIRMKEY,
				);
				$this->db->where('task_id', $id);
				$insert = $this->db->update('cm_tasktype', $data);
				
				
				
				$this->db->select('*');
				$this->db->where('status',CONFIRMKEY);
				//$this->db->limit($pagination_counter, $page_count);
				$query = $this->db->get('re_projectms'); 
				if ($query->num_rows() > 0){
					$dataset= $query->result(); 
					foreach($dataset as $raw)
					{
								$data=array( 
						'prj_id'=>$raw->prj_id,
						'task_id' => $id,
						'estimate_budget' => 0,
						'new_budget' => 0,
						'tot_payments' => 0,
						
						
						);
						$insert = $this->db->insert('re_prjacpaymentms', $data);
						
					}
				}
			
			
				return $insert;
			 }
		}
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		if($id)
		{
		$this->db->where('task_id', $id);
		$insert = $this->db->delete('cm_tasktype');
		}
		return $id;
		
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
		if($id)
		{
		$this->db->where('subtask_id', $id);
		$insert = $this->db->delete('cm_subtask');
		}
		return $id;
		
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