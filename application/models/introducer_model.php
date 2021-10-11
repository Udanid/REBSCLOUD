<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Introducer_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	function get_all_intorducer_summery() { //get all stock
		$this->db->select('intro_code,first_name,last_name');
		$this->db->order_by('first_name');
		$query = $this->db->get('re_introducerms'); 
		return $query->result(); 
    }
	function get_all_intorducer_details($pagination_counter, $page_count) { //get all stock
		$this->db->select('*');
		$this->db->order_by('intro_code');
		$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_introducerms'); 
		return $query->result(); 
    }
	function get_intorducer_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('intro_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_introducerms'); 
		return $query->row(); 
    }
	
	function get_introducer_bankdata_bycode($code) { //get all stock
		$this->db->select('*');
		$this->db->where('intro_code',$code);
		//$this->db->limit($pagination_counter, $page_count);
		$query = $this->db->get('re_introcuderbank'); 
		return $query->result(); 
    }
	function add($filename)
	{
		//$tot=$bprice*$quontity; 
		$id=$this->getmaincode('intro_code','INR','re_introducerms');
		$data=array( 
		'intro_code'=>$id,
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
		'id_copy' => $filename,
		'create_by' => $this->session->userdata('username'),
		
		);
		$insert = $this->db->insert('re_introducerms', $data);
		if($this->input->post('bank1')!=""  ){
		$data2=array( 
		'intro_code'=>$id,
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('re_introcuderbank', $data2);
		
		}
		if($this->input->post('bank2')!=""  ){
		$data2=array( 
		'intro_code'=>$id,
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('re_introcuderbank', $data2);
		
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
		
		);
		$this->db->where('intro_code', $this->input->post('intro_code'));
		$insert = $this->db->update('re_introducerms', $data);
		$this->db->where('intro_code',$this->input->post('intro_code'));
		$insert = $this->db->delete('re_introcuderbank');
		if($this->input->post('bank1')!=""  ){
		$data2=array( 
		'intro_code'=>$this->input->post('intro_code'),
		'bank_code' => $this->input->post('bank1'),
		'branch_code' => $this->input->post('branch1'),
		'acc_number' => $this->input->post('acc1'),
		);
		$insert = $this->db->insert('re_introcuderbank', $data2);
		
		}
		if($this->input->post('bank2')!=""  ){
		$data2=array( 
		'intro_code'=>$this->input->post('intro_code'),
		'bank_code' => $this->input->post('bank2'),
		'branch_code' => $this->input->post('branch2'),
		'acc_number' => $this->input->post('acc2'),
		);
		$insert = $this->db->insert('re_introcuderbank', $data2);
		
		}
		return $insert;
		
	}
	function confirm($id)
	{
		//$tot=$bprice*$quontity; 
		$data=array( 
		
		
		'status' => CONFIRMKEY,
		);
		$this->db->where('intro_code', $id);
		$insert = $this->db->update('re_introducerms', $data);
		return $insert;
		
	}
	function delete($id)
	{
		//$tot=$bprice*$quontity; 
		if($id)
		{
			$this->db->where('intro_code', $id);
			$insert = $this->db->delete('re_introcuderbank');
			$this->db->where('intro_code', $id);
			$insert = $this->db->delete('re_introducerms');
			return $insert;
		}
		
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