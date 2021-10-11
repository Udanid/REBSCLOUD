<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_supplier_summery() { //get all stock
		$this->db->select('sup_code,first_name,last_name,id_number');
		$this->db->order_by('first_name');
		$query = $this->db->get('cm_supplierms'); 
		return $query->result(); 
    }
	function get_all_supplier_details($pagination_counter, $page_count) { //get all stock
		$this->db->select('*');
		$this->db->order_by('sup_code');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_supplierms'); 
		return $query->result(); 
    }
     /*Ticket No:2699 Added By Madushan 2021.04.22*/
    function get_search_supplier_details($sup_code) {
		$this->db->select('*');
		$this->db->order_by('sup_code');
		$this->db->where('sup_code',$sup_code);
		$query = $this->db->get('cm_supplierms'); 
		return $query->result(); 
    }
	function get_supplier_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('sup_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_supplierms'); 
		return $query->row(); 
    }
	
	function get_supplier_bankdata_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('sup_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('cm_supplierbank'); 
		return $query->result(); 
    }
	function add($filename)
	{
		//$tot=$bprice*$quontity; 
		$id=$this->getmaincode('sup_code','SUP','cm_supplierms');
		$data=array( 
		'sup_code'=>$id,
		'create_date' => date("Y-m-d"),
		'title' => $this->input->post('title'),
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'landphone' => $this->input->post('landphone'),
		'mobile' => $this->input->post('mobile'),
		'email' => $this->input->post('email'),
		'address3' => $this->input->post('address3'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'id_type' => $this->input->post('id_type'),
		'id_number' => $this->input->post('id_number'),
		'sup_tin' => $this->input->post('sup_tin'),
		
		'id_copy' => $filename,
		'create_by' => $this->session->userdata('username'),
		
		);
		$insert = $this->db->insert('cm_supplierms', $data);
		if($this->input->post('bank1')!=""  ){
		$data2=array( 
		'sup_code'=>$id,
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('cm_supplierbank', $data2);
		
		}
		if($this->input->post('bank2')!=""  ){
		$data2=array( 
		'sup_code'=>$id,
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('cm_supplierbank', $data2);
		
		}
		return $id;
		
	}
	function edit($filename)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		'title' => $this->input->post('title'),
		'first_name' => $this->input->post('first_name'),
		'last_name' => $this->input->post('last_name'),
		'landphone' => $this->input->post('landphone'),
		'mobile' => $this->input->post('mobile'),
		'email' => $this->input->post('email'),
		'address3' => $this->input->post('address3'),
		'address1' => $this->input->post('address1'),
		'address2' => $this->input->post('address2'),
		'id_type' => $this->input->post('id_type'),
		'id_number' => $this->input->post('id_number'),
		'id_copy' => $filename,
			'sup_tin' => $this->input->post('sup_tin'),
		
		);
		$this->db->where('sup_code', $this->input->post('sup_code'));
		$insert = $this->db->update('cm_supplierms', $data);
		$this->db->where('sup_code',$this->input->post('sup_code'));
		$insert = $this->db->delete('cm_supplierbank');
		if($this->input->post('bank1')!=""  ){
		$data2=array( 
		'sup_code'=>$this->input->post('sup_code'),
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('cm_supplierbank', $data2);
		
		}
		if($this->input->post('bank2')!=""  ){
		$data2=array( 
		'sup_code'=>$this->input->post('sup_code'),
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('cm_supplierbank', $data2);
		
		}
		return $insert;
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('sup_code', $id);
		$insert = $this->db->update('cm_supplierms', $data);
		return $insert;
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		$this->db->where('sup_code', $id);
		$insert = $this->db->delete('cm_supplierbank');
		$this->db->where('sup_code', $id);
		$insert = $this->db->delete('cm_supplierms');
		return $insert;
		
	}
 function getmaincode($idfield,$prifix,$table)
	{
	
 	$query = $this->db->query("SELECT MAX(".$idfield.") as id  FROM ".$table);
        
		$newid="";
	
        if ($query->num_rows > 0) {
             $data = $query->row();
			 $prjid=$data->id;
			 if($data->id==NULL)
			 {
			 $newid=$prifix.str_pad(1, 4, "0", STR_PAD_LEFT);
		

			 }
			 else{
			 $prjid=substr($prjid,3,4);
			 $id=intval($prjid);
			 $newid=$id+1;
			 $newid=$prifix.str_pad($newid, 4, "0", STR_PAD_LEFT);
			
			
			 }
        }
		else
		{
		
		$newid=str_pad(1, 4, "0", STR_PAD_LEFT);
		$newid=$prifix.$newid;
		}
	return $newid;
	
	}
}